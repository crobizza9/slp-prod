<?php

// Start session safely
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanitize and validate inputs
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "Please enter both email and password.";
        header("Location: login.php");
        exit;
    }

    // Prepare SQL query (prevent SQL injection)
    $stmt = $conn->prepare("SELECT id, firstname, lastname, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {

            // Regenerate session ID for security
            session_regenerate_id(true);

            // Store session data
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['firstname'] = $user['firstname'];
            $_SESSION['lastname'] = $user['lastname'];
            $_SESSION['fullname'] = $user['firstname'] . ' ' . $user['lastname'];
            $_SESSION['unique'] = hash('ripemd128', $_SERVER['REMOTE_ADDR'] .
                $_SERVER['HTTP_USER_AGENT']);
            $_SESSION['role'] = $user['role'];

            // Redirect to dashboard
            header("Location: dash-loader.php");
            exit;
        } else {
            $_SESSION['error'] = "Invalid password.";
            header("Location: login.php");
            exit;
        }
    } else {
        $_SESSION['error'] = "No account found with that email.";
        header("Location: login.php");
        exit;
    }

    $stmt->close();
    $conn->close();
} else {
    // If someone tries to access this page directly
    header("Location: login.php");
    exit;
}
