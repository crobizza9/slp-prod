<?php
session_start();
require_once '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: admin.php");
    exit;
}

$user_id = intval($_POST['id']);
$new_pass = trim($_POST['new_password'] ?? '');
$confirm_pass = trim($_POST['confirm_password'] ?? '');

// Validation
if (strlen($new_pass) < 8) {
    $_SESSION['error'] = "Password must be at least 8 characters.";
    header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'admin.php'));
    exit;
}

if ($new_pass !== $confirm_pass) {
    $_SESSION['error'] = "Passwords do not match.";
    header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'admin.php'));
    exit;
}

$hashed = password_hash($new_pass, PASSWORD_DEFAULT);

$stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
$stmt->bind_param("si", $hashed, $user_id);

if ($stmt->execute()) {
    $_SESSION['success'] = "Password reset successfully.";
} else {
    $_SESSION['error'] = "Failed to reset password.";
}

$stmt->close();
$conn->close();

header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'admin.php'));
exit;
