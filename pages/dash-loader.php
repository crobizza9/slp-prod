<?php
require_once '../includes/db_connect.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// If user role is admin then load admin.php. Otherwise load dashboard.php

if ($_SESSION['role'] == 'admin') {
    header("Location: admin.php");
    exit;
} else {
    header("Location: dashboard.php");
}
