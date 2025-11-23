<?php
require_once '../includes/db_connect.php';

// Verify admin role
if ($_SESSION['role'] !== 'admin') {
    header("Location: dash-loader.php");
    exit;
}
$status_filter = $_GET['status'] ?? '';
// Pagination settings
$limit = 10; // max items per page
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
    $page = 1;
}
$offset = ($page - 1) * $limit;


// Get total row count for pagination
$count_sql = "SELECT COUNT(*) AS total FROM shipping_requests";
if ($status_filter) {
    $count_sql .= " WHERE status = ?";
}
$count_stmt = $conn->prepare($count_sql);

if ($status_filter) {
    $count_stmt->bind_param("s", $status_filter);
}

$count_stmt->execute();
$count_result = $count_stmt->get_result();
$total_rows = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $limit);

// Fetch all shipping requests

$sql = "SELECT s.id, u.firstname, u.lastname, s.recipient_city, s.recipient_state, s.status, s.requested_date
        FROM shipping_requests s
        LEFT JOIN users u ON s.user_id = u.id";
if ($status_filter) {
    $sql .= " WHERE s.status = ?";
}

$sql .= " ORDER BY s.requested_date DESC LIMIT ? OFFSET ?";

$stmt = $conn->prepare($sql);

// Handle bound parameters depending on filter
if ($status_filter) {
    $stmt->bind_param("sii", $status_filter, $limit, $offset);
} else {
    $stmt->bind_param("ii", $limit, $offset);
}

$stmt->execute();
$requests = $stmt->get_result();

// Fetch users for Account Maintenance
$users = $conn->query("SELECT id, firstname, lastname, email, role FROM users ORDER BY role, firstname");
