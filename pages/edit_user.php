<?php
session_start();
require_once '../includes/db_connect.php';

// Must be POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: admin.php");
    exit;
}

$user_id = intval($_POST['id']);
$new_role = $_POST['role'] ?? '';

$allowed_roles = ['standard', 'admin'];

if (!in_array($new_role, $allowed_roles)) {
    $_SESSION['error'] = "Invalid role.";
    // Go back to previous page
    header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'admin.php'));
    exit;
}

$stmt = $conn->prepare("UPDATE users SET role = ? WHERE id = ?");
$stmt->bind_param("si", $new_role, $user_id);

if ($stmt->execute()) {
    $_SESSION['success'] = "User role updated!";
} else {
    $_SESSION['error'] = "Failed to update role.";
}

$stmt->close();
$conn->close();

// Return to previous page or admin.php
header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'admin.php'));
exit;
