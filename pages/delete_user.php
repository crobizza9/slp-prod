<?php
session_start();
require_once '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: admin.php");
    exit;
}

$user_id = intval($_POST['id']);

// prevent deleting own account
if ($user_id == $_SESSION['user_id']) {
    $_SESSION['error'] = "You cannot delete your own account.";
    header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'admin.php'));
    exit;
}

$stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    $_SESSION['success'] = "User deleted successfully.";
} else {
    $_SESSION['error'] = "Failed to delete user.";
}

$stmt->close();
$conn->close();

header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'admin.php'));
exit;
