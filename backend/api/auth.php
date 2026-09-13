<?php
// ==========================================
// Authentication API Endpoint
// Handles member login, credential checks, and sessions
// ==========================================

header('Content-Type: application/json');
require_once __DIR__ . '/../config/db.php';

$action = $_GET['action'] ?? '';

// Check if request is POST for login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'login') {
    // Read input data from form or json
    $input = json_decode(file_get_contents('php://input'), true) ?? $_POST;
    $email = trim($input['email'] ?? '');
    $password = $input['password'] ?? '';

    // Validate inputs are not empty
    if (empty($email) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Please enter both email and password.']);
        exit();
    }

    // 1. Query user from database by email
    $stmt = $pdo->prepare("SELECT u.*, r.role_name FROM users u JOIN roles r ON u.role_id = r.id WHERE u.email = ? LIMIT 1");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // 2. Check if user exists and verify hashed password
    if ($user && password_verify($password, $user['password_hash'])) {
        
        // 3. Check if account is still pending admin approval
        if ($user['status'] === 'Pending') {
            echo json_encode(['success' => false, 'message' => 'Your student account is pending approval by the library administration.']);
            exit();
        }
        
        // 4. Check if account is active
        if ($user['status'] !== 'Active') {
            echo json_encode(['success' => false, 'message' => 'Your account is suspended. Please contact the library desk.']);
            exit();
        }

        // 5. Start user session upon successful login
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['full_name'];
        $_SESSION['role'] = $user['role_name'];

        echo json_encode([
            'success' => true,
            'message' => 'Login successful',
            'user' => [
                'id' => $user['id'],
                'name' => $user['full_name'],
                'role' => $user['role_name'],
                'reg_no' => $user['reg_no']
            ]
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid email or password.']);
    }
    exit();
}

echo json_encode(['status' => 'online', 'service' => 'Authentication Service']);
?>