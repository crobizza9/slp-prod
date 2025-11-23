<?php
session_start();
require '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../pages/error.php?msg=Invalid+request+method");
    exit;
}

// Collect and sanitize input
$firstname        = trim($_POST['firstname'] ?? '');
$lastname         = trim($_POST['lastname'] ?? '');
$email            = trim($_POST['email'] ?? '');
$password         = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm-password'] ?? '';

$errors = [];

// =======================
// Server-side Validation
// =======================
if ($firstname === '' || $lastname === '' || $email === '' || $password === '' || $confirm_password === '') {
    $errors[] = 'All fields are required.';
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Invalid email format.';
}

if ($password !== $confirm_password) {
    $errors[] = 'Passwords do not match.';
}

if (strlen($password) < 8) {
    $errors[] = 'Password must be at least 8 characters long.';
}

if (!empty($errors)) {
    $_SESSION['validation_errors'] = $errors;
    header("Location: ../pages/error.php?msg=Please+fix+the+errors+below");
    exit;
}

$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->close();
    header("Location: ../pages/error.php?msg=An+account+with+this+email+already+exists");
    exit;
}
$stmt->close();

// =======================
// Insert new user
// =======================
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$role = 'standard';

$stmt = $conn->prepare("
    INSERT INTO users (firstname, lastname, email, password, role)
    VALUES (?, ?, ?, ?, ?)
");
$stmt->bind_param("sssss", $firstname, $lastname, $email, $hashed_password, $role);

if ($stmt->execute()) {


    header("Location: login.php?success=1");
    exit;
} else {
    $_SESSION['validation_errors'] = ["Database error: " . $stmt->error];
    header("Location: ../pages/error.php?msg=Something+went+wrong");
    exit;
}

$stmt->close();
$conn->close();
