<?php
session_start();
require_once "../includes/db_connect.php";

if (!isset($_GET['id'])) {
    die("Missing Request ID.");
}

$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM shipping_requests WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$sr = $result->fetch_assoc();

if (!$sr) {
    die("Shipping Request not found.");
}

// Helper for empty fields
function safeField($data, $field, $default = "")
{
    return isset($data[$field]) && $data[$field] !== ""
        ? htmlspecialchars($data[$field])
        : $default;
}

$extra = $sr['extra_instructions'] ?? "";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Print Shipping Request</title>
    <link rel="stylesheet" href="../css/print.css">
    <script>
        window.onload = () => {
            window.print();
        };
    </script>
</head>

<body>

    <div class="no-print">
        <a href="javascript:history.back()" class="btn">Back</a>
        <button onclick="window.print()" class="btn">Print</button>
    </div>

    <div class="slp-container">

        <div class="slp-header">SLP Shipping Request</div>

        <div class="slp-section-title">Dates</div>
        <table class="slp-table">
            <tr>
                <td><b>Today's Date:</b></td>
                <td><?= safeField($sr, 'today_date') ?></td>
            </tr>
            <tr>
                <td><b>Requested Ship Date:</b></td>
                <td><?= safeField($sr, 'requested_date') ?></td>
            </tr>
        </table>

        <div class="slp-section-title">Sender</div>
        <table class="slp-table">
            <tr>
                <td><b>Name:</b></td>
                <td><?= safeField($sr, 'sender_name') ?></td>
            </tr>
            <tr>
                <td><b>Business:</b></td>
                <td><?= safeField($sr, 'sender_business') ?></td>
            </tr>
            <tr>
                <td><b>Phone:</b></td>
                <td><?= safeField($sr, 'sender_phone') ?></td>
            </tr>
            <tr>
                <td><b>Email:</b></td>
                <td><?= safeField($sr, 'sender_email') ?></td>
            </tr>
            <tr>
                <td><b>Address:</b></td>
                <td><?= safeField($sr, 'sender_address') ?></td>
            </tr>
            <tr>
                <td><b>City:</b></td>
                <td><?= safeField($sr, 'sender_city') ?></td>
            </tr>
            <tr>
                <td><b>State:</b></td>
                <td><?= safeField($sr, 'sender_state') ?></td>
            </tr>
            <tr>
                <td><b>Zip:</b></td>
                <td><?= safeField($sr, 'sender_zip') ?></td>
            </tr>
        </table>

        <div class="slp-section-title">Recipient</div>
        <table class="slp-table">
            <tr>
                <td><b>Name:</b></td>
                <td><?= safeField($sr, 'recipient_name') ?></td>
            </tr>
            <tr>
                <td><b>Business:</b></td>
                <td><?= safeField($sr, 'recipient_business') ?></td>
            </tr>
            <tr>
                <td><b>Phone:</b></td>
                <td><?= safeField($sr, 'recipient_phone') ?></td>
            </tr>
            <tr>
                <td><b>Email:</b></td>
                <td><?= safeField($sr, 'recipient_email') ?></td>
            </tr>
            <tr>
                <td><b>Address:</b></td>
                <td><?= safeField($sr, 'recipient_address') ?></td>
            </tr>
            <tr>
                <td><b>City:</b></td>
                <td><?= safeField($sr, 'recipient_city') ?></td>
            </tr>
            <tr>
                <td><b>State:</b></td>
                <td><?= safeField($sr, 'recipient_state') ?></td>
            </tr>
            <tr>
                <td><b>Zip:</b></td>
                <td><?= safeField($sr, 'recipient_zip') ?></td>
            </tr>
        </table>

        <div class="slp-section-title">Shipping Info</div>
        <table class="slp-table">
            <tr>
                <td><b>Carrier:</b></td>
                <td><?= safeField($sr, 'carrier') ?></td>
            </tr>
            <tr>
                <td><b>Declared Value:</b></td>
                <td><?= safeField($sr, 'declared_value') ?></td>
            </tr>
            <tr>
                <td><b>Insurance:</b></td>
                <td><?= safeField($sr, 'insurance', 'No') ?></td>
            </tr>
            <tr>
                <td><b>Signature Required:</b></td>
                <td><?= safeField($sr, 'signature_required', 'No') ?></td>
            </tr>
            <tr>
                <td><b>Speed:</b></td>
                <td><?= safeField($sr, 'speed') ?></td>
            </tr>
        </table>

        <div class="slp-section-title">Special Instructions</div>
        <div class="slp-subtext">
            <?= nl2br(safeField($sr, 'special_instructions')) ?>
        </div>

    </div>

</body>

</html>