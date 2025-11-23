<?php
session_start();
require_once '../includes/db_connect.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "You must be logged in to submit a shipping request.";
    header("Location: ../login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id            = $_SESSION['user_id'];
    $today_date         = trim($_POST['today_date'] ?? '');
    $requested_date     = trim($_POST['requested_date'] ?? '');
    $sender_name        = trim($_POST['sender_name'] ?? '');
    $sender_business    = trim($_POST['sender_business'] ?? '');
    $sender_address     = trim($_POST['sender_address'] ?? '');
    $sender_city        = trim($_POST['sender_city'] ?? '');
    $sender_state       = strtoupper(trim($_POST['sender_state'] ?? ''));
    $sender_zip         = trim($_POST['sender_zip'] ?? '');
    $sender_phone       = trim($_POST['sender_phone'] ?? '');
    $sender_email       = trim($_POST['sender_email'] ?? '');
    $recipient_name     = trim($_POST['recipient_name'] ?? '');
    $recipient_business = trim($_POST['recipient_business'] ?? '');
    $recipient_address  = trim($_POST['recipient_address'] ?? '');
    $recipient_city     = trim($_POST['recipient_city'] ?? '');
    $recipient_state    = strtoupper(trim($_POST['recipient_state'] ?? ''));
    $recipient_zip      = trim($_POST['recipient_zip'] ?? '');
    $recipient_phone    = trim($_POST['recipient_phone'] ?? '');
    $recipient_email    = trim($_POST['recipient_email'] ?? '');
    $carrier            = trim($_POST['carrier'] ?? '');
    $speed              = trim($_POST['speed'] ?? '');
    $insurance          = trim($_POST['insurance'] ?? 'no');
    $declared_value     = trim($_POST['declared_value'] ?? '');
    $signature          = trim($_POST['signature'] ?? 'no');
    $special_notes      = trim($_POST['special_instructions'] ?? '');
    $status             = 'Pending'; // Always set to Pending for new requests

    // These can be null
    $tracking             = isset($_POST['tracking_number']) && trim($_POST['tracking_number']) !== ''
        ? trim($_POST['tracking_number'])
        : null;
    $delivery_date        = isset($_POST['delivery_date']) && trim($_POST['delivery_date']) !== ''
        ? trim($_POST['delivery_date'])
        : null;

    // Validation - only required fields
    $required = [
        'today_date' => $today_date,
        'requested_date' => $requested_date,
        'sender_name' => $sender_name,
        'sender_address' => $sender_address,
        'sender_city' => $sender_city,
        'sender_state' => $sender_state,
        'sender_zip' => $sender_zip,
        'sender_phone' => $sender_phone,
        'sender_email' => $sender_email,
        'recipient_name' => $recipient_name,
        'recipient_address' => $recipient_address,
        'recipient_city' => $recipient_city,
        'recipient_state' => $recipient_state,
        'recipient_zip' => $recipient_zip,
        'recipient_phone' => $recipient_phone,
        'recipient_email' => $recipient_email,
        'carrier' => $carrier,
        'speed' => $speed
    ];

    $missing_fields = [];
    foreach ($required as $field_name => $value) {
        if ($value === '') {
            $missing_fields[] = $field_name;
        }
    }

    if (!empty($missing_fields)) {
        $_SESSION['error'] = "Please fill in all required fields: " . implode(', ', $missing_fields);
        header("Location: shipping-request-form.php");
        exit;
    }

    try {
        $stmt = $conn->prepare("
            INSERT INTO shipping_requests (
                user_id, today_date, requested_date,
                sender_name, sender_business, sender_address, sender_city, sender_state, sender_zip, sender_phone, sender_email,
                recipient_name, recipient_business, recipient_address, recipient_city, recipient_state, recipient_zip, recipient_phone, recipient_email,
                carrier, speed, insurance, declared_value, signature_required, special_instructions, status, tracking_number, delivery_date
            )
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            'isssssssssssssssssssssssssss',
            $user_id,
            $today_date,
            $requested_date,
            $sender_name,
            $sender_business,
            $sender_address,
            $sender_city,
            $sender_state,
            $sender_zip,
            $sender_phone,
            $sender_email,
            $recipient_name,
            $recipient_business,
            $recipient_address,
            $recipient_city,
            $recipient_state,
            $recipient_zip,
            $recipient_phone,
            $recipient_email,
            $carrier,
            $speed,
            $insurance,
            $declared_value,
            $signature,
            $special_notes,
            $status,
            $tracking,
            $delivery_date
        );

        if ($stmt->execute()) {
            $new_id = $stmt->insert_id;
            $_SESSION['success'] = "Shipping request submitted successfully.";
            header("Location: form_success.php?id=$new_id");
            exit;
        } else {
            $_SESSION['error'] = "Error submitting shipping request: " . $stmt->error;
            header("Location: shipping-request-form.php");
            exit;
        }
    } catch (mysqli_sql_exception $e) {
        $_SESSION['error'] = "Database error: " . $e->getMessage();
        header("Location: shipping-request-form.php");
        exit;
    }
} else {
    header("Location: shipping-request-form.php");
    exit;
}
