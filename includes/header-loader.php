<?php
// header-loader.php
// Automatically include the correct header depending on login state

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    include __DIR__ . '/user-header.php';
} else {
    include __DIR__ . '/header.php';
}
