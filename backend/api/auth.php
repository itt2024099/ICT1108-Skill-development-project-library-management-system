<?php
/**
 * Authentication API Endpoint
 * Handles login validation, member registration verification, and session state
 */
header('Content-Type: application/json');
require_once __DIR__ . '/../config/db.php';

$pdo = Database::getInstance();
$action = $_GET['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true) ?? $_POST;

    if ($action === 'login') {
        $email = trim($input['email'] ?? '');
        $password = $input['password'] ?? '';

        if (empty($email) || empty($password)) {
            echo json_encode(['success' => false, 'message' => 'Please provide both email and password.']);
            exit();
        }

        $stmt = $pdo->prepare("SELECT u.*, r.role_name FROM users u JOIN roles r ON u.role_id = r.id WHERE u.email = ? LIMIT 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            if ($user['status'] === 'Pending') {
                echo json_encode(['success' => false, 'message' => 'Your student account is pending approval by the library administration.']);
                exit();
            }
            if ($user['status'] !== 'Active') {
                echo json_encode(['success' => false, 'message' => 'Your account is suspended. Please contact the librarian.']);
                exit();
            }

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
}

echo json_encode(['status' => 'online', 'service' => 'Authentication Service']);
?>
