<?php
// ==========================================
// Circulation API: Issue & Return Transactions
// ICT 1108 - Skill Development Project I
// ==========================================

header('Content-Type: application/json');
require_once __DIR__ . '/../config/db.php';

$action = $_GET['action'] ?? '';

// 1. Issue Book to Student
if ($action === 'issue' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $reg_no = trim($_POST['reg_no'] ?? '');
    $accession_no = trim($_POST['accession_no'] ?? '');
    
    // Auto calculate 14-day return due date
    $due_date = date('Y-m-d', strtotime('+14 days'));

    // Find student user id
    $u_stmt = $pdo->prepare("SELECT id FROM users WHERE reg_no = ? AND status = 'Active'");
    $u_stmt->execute([$reg_no]);
    $user = $u_stmt->fetch();

    // Find book details and check availability
    $b_stmt = $pdo->prepare("SELECT id, available_copies FROM books WHERE isbn = ? OR id = ?");
    $b_stmt->execute([$accession_no, $accession_no]);
    $book = $b_stmt->fetch();

    if ($user && $book && $book['available_copies'] > 0) {
        // Insert active loan record
        $ins = $pdo->prepare("INSERT INTO borrow_records (user_id, book_id, accession_no, issue_date, due_date, status) VALUES (?, ?, ?, CURDATE(), ?, 'Active')");
        $ins->execute([$user['id'], $book['id'], $accession_no, $due_date]);

        // Decrement available copies count in catalog
        $upd = $pdo->prepare("UPDATE books SET available_copies = available_copies - 1 WHERE id = ?");
        $upd->execute([$book['id']]);

        echo json_encode([
            'success' => true, 
            'message' => 'Book issued successfully to student.', 
            'due_date' => $due_date
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Cannot issue book. Please check student standing or book availability.']);
    }
    exit();
}

// 2. Process Book Return
if ($action === 'return' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $record_id = intval($_POST['record_id'] ?? 0);

    // Find active loan record
    $stmt = $pdo->prepare("SELECT * FROM borrow_records WHERE id = ? AND status = 'Active'");
    $stmt->execute([$record_id]);
    $record = $stmt->fetch();

    if ($record) {
        // Calculate overdue fine (Rs. 10.00 per overdue day)
        $due_timestamp = strtotime($record['due_date']);
        $current_timestamp = time();
        $fine = 0.00;
        
        if ($current_timestamp > $due_timestamp) {
            $days_overdue = floor(($current_timestamp - $due_timestamp) / 86400);
            $fine = $days_overdue * 10.00;
        }

        // Mark record as Returned with return date and fine
        $upd = $pdo->prepare("UPDATE borrow_records SET return_date = CURDATE(), status = 'Returned', fine_amount = ? WHERE id = ?");
        $upd->execute([$fine, $record_id]);

        // Restore available book copy count
        $upd_book = $pdo->prepare("UPDATE books SET available_copies = available_copies + 1 WHERE id = ?");
        $upd_book->execute([$record['book_id']]);

        echo json_encode([
            'success' => true, 
            'message' => 'Book returned successfully.', 
            'fine_amount' => $fine
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Active borrowing record not found.']);
    }
    exit();
}

echo json_encode(['status' => 'online', 'service' => 'Circulation Service']);
?>