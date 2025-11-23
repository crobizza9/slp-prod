<?php
session_start();

require_once '../includes/email_service.php';



// Shipping request fields
$sr = $_POST;

// Email the user typed
$recipientEmail = $_POST['final_recipient_email'] ?? '';

// Additional instructions
$extra = trim($_POST['extra_instructions'] ?? '');

// Safe field accessor
function safeField($array, $key, $default = '')
{
    return htmlspecialchars($array[$key] ?? $default);
}

// Build the email HTML body
ob_start();
?>

<style>
    .slp-container {
        width: 100%;
        max-width: 700px;
        margin: auto;
        font-family: Arial, Helvetica, sans-serif;
        color: #1e1e2f;
        background: #ffffff;
        padding: 20px;
        border-radius: 12px;
        border: 1px solid #dcdcdc;
    }

    .slp-header {
        background: #1e1e2f;
        color: white;
        padding: 16px;
        text-align: center;
        font-size: 22px;
        margin-bottom: 10px;
    }

    .slp-section-title {
        font-size: 18px;
        font-weight: bold;
        margin-top: 25px;
        margin-bottom: 10px;
        color: #1e1e2f;
    }

    .slp-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .slp-table td {
        padding: 8px 10px;
        border: 1px solid #cccccc;
    }

    .slp-subtext {
        margin-bottom: 20px;
        padding: 10px;
        background: #f6f7fb;
        border-radius: 6px;
    }
</style>

<div class="slp-container">

    <div class="slp-header">
        SLP Shipping Request
    </div>

    <div class="slp-subtext">
        <?= nl2br(htmlspecialchars($extra)) ?>
    </div>

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


<?php
$emailBody = ob_get_clean();

// Send using EmailService
$result = EmailService::sendShippingRequest(
    $recipientEmail,
    $sr['sender_email'],
    $sr['sender_name'],
    $emailBody
);

if ($result === true) {
    $_SESSION['success'] = "Shipping request email sent successfully!";
} else {
    $_SESSION['error'] = $result;
}

// Return to email form
header("Location: email_form.php?id=" . ($sr['id'] ?? ''));
exit;
