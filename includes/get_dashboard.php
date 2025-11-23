<?php
require_once '../includes/db_connect.php';

// Fetch user’s shipping requests
$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header("Location: login.php");
    exit;
}

// Count each status for this user
$status_counts = [
    "Pending" => 0,
    "In Transit" => 0,
    "Shipped" => 0,
    "Delivered" => 0,
    "Cancelled" => 0
];

$count_sql = "SELECT status, COUNT(*) AS total
              FROM shipping_requests
              WHERE user_id = ?
              GROUP BY status";

$count_stmt = $conn->prepare($count_sql);
$count_stmt->bind_param("i", $user_id);
$count_stmt->execute();
$count_result = $count_stmt->get_result();

while ($row = $count_result->fetch_assoc()) {
    $status_counts[$row['status']] = $row['total'];
}



// Pagination settings
$limit = 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
    $page = 1;
}
$offset = ($page - 1) * $limit;

// Count total requests for this user
$count_sql = "SELECT COUNT(*) AS total FROM shipping_requests WHERE user_id = ?";
$count_stmt = $conn->prepare($count_sql);
$count_stmt->bind_param("i", $user_id);
$count_stmt->execute();
$count_result = $count_stmt->get_result();
$total_rows = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $limit);


$filter_status = $_GET['status'] ?? '';

if ($filter_status && $filter_status !== 'all') {
    $query = $conn->prepare("
        SELECT id, recipient_city, recipient_state, requested_date, status
        FROM shipping_requests
        WHERE user_id = ? AND status = ?
        ORDER BY requested_date DESC
    ");
    $query->bind_param("is", $user_id, $filter_status);
} else {
    $query = $conn->prepare("
        SELECT id, recipient_city, recipient_state, requested_date, status
        FROM shipping_requests
        WHERE user_id = ?
        ORDER BY requested_date DESC
    ");
    $query->bind_param("i", $user_id);
}

$query->execute();
$result = $query->get_result();
