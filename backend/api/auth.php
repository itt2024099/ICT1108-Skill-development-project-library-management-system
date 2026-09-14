<?php
// Authentication API Endpoint
// handles member login, credentals and session
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

    // 1. Querry user from databse by email
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

// Check if request is POST for registration
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'register') {
    $full_name = trim($_POST['full_name'] ?? '');
    $reg_no = trim($_POST['reg_no'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($full_name) || empty($reg_no) || empty($email) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Please fill all required fields.']);
        exit();
    }
    
    // handle id card front and back uploads
    $id_front_path = 'uploads/id_cards/default_front.jpg';
    $id_back_path = 'uploads/id_cards/default_back.jpg';
    
    if (!empty($_FILES['id_card_front']['name'])) {
        $front_name = time() . '_front_' . basename($_FILES['id_card_front']['name']);
        $target = __DIR__ . '/../../uploads/id_cards/' . $front_name;
        if (move_uploaded_file($_FILES['id_card_front']['tmp_name'], $target)) {
            $id_front_path = 'uploads/id_cards/' . $front_name;
        }
    }
    if (!empty($_FILES['id_card_back']['name'])) {
        $back_name = time() . '_back_' . basename($_FILES['id_card_back']['name']);
        $target = __DIR__ . '/../../uploads/id_cards/' . $back_name;
        if (move_uploaded_file($_FILES['id_card_back']['tmp_name'], $target)) {
            $id_back_path = 'uploads/id_cards/' . $back_name;
        }
    }
    
    $hash = password_hash($password, PASSWORD_BCRYPT);
    
    $stmt = $pdo->prepare("INSERT INTO users (role_id, reg_no, full_name, email, password_hash, id_card_front, id_card_back, status) VALUES (3, ?, ?, ?, ?, ?, ?, 'Pending')");
    try {
        $stmt->execute([$reg_no, $full_name, $email, $hash, $id_front_path, $id_back_path]);
        echo json_encode(['success' => true, 'message' => 'Registration submitted for library approval.']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Registration failed: ' . $e->getMessage()]);
    }
    exit();
}

// Check if request is POST for profile avatar update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'update_profile') {
    $user_id = intval($_POST['user_id'] ?? 0);
    $full_name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    
    $avatar_path = null;
    if (!empty($_FILES['profile_pic']['name'])) {
        $pic_name = time() . '_avatar_' . basename($_FILES['profile_pic']['name']);
        $target = __DIR__ . '/../../uploads/profiles/' . $pic_name;
        if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $target)) {
            $avatar_path = 'uploads/profiles/' . $pic_name;
        }
    }
    
    if ($avatar_path) {
        $stmt = $pdo->prepare("UPDATE users SET full_name = ?, email = ?, profile_pic = ? WHERE id = ?");
        $stmt->execute([$full_name, $email, $avatar_path, $user_id]);
    } else {
        $stmt = $pdo->prepare("UPDATE users SET full_name = ?, email = ? WHERE id = ?");
        $stmt->execute([$full_name, $email, $user_id]);
    }
    
    echo json_encode(['success' => true, 'message' => 'Profile details updated successfully.']);
    exit();
}

echo json_encode(['status' => 'online', 'service' => 'Authentication Service']);
?>