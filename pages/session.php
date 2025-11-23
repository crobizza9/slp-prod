<?php
session_start();

// Set session timeout (in seconds)
$timeout_duration = 600; // 10 minutes

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Check if the session has been idle too long
if (
    isset($_SESSION['LAST_ACTIVITY']) &&
    (time() - $_SESSION['LAST_ACTIVITY']) > $timeout_duration
) {

    // Session expired — destroy it and redirect
    session_unset();
    session_destroy();
    header("Location: login.php?timeout=1");
    exit;
}

// Check if the user is the same via session id
if ($_SESSION['unique'] != hash('ripemd128', $_SERVER['REMOTE_ADDR'] .
    $_SERVER['HTTP_USER_AGENT'])) {
    session_unset();
    session_destroy();
    header("Location: login.php?timeout=1");
    exit;
}

// Update last activity timestamp
$_SESSION['LAST_ACTIVITY'] = time();
