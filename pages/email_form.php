<?php
include 'session.php';
include '../includes/db_connect.php';
include '../includes/user-header.php';

function safe($v)
{
    return htmlspecialchars($v ?? "");
}

// 1. Flow A (POST)
if (!empty($_POST)) {
    $sr = $_POST;
}
// 2. Flow B (GET id)
elseif (isset($_GET['id'])) {
    $sr_id = (int) $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM shipping_requests WHERE id = ?");
    $stmt->bind_param("i", $sr_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) die("Invalid Shipping Request ID.");
    $sr = $result->fetch_assoc();
}
// 3. No data
else {
    die("No shipping request data provided.");
}

// Build placeholder with sender email
$dynamicPlaceholder = "Hello! Please see the following shipping request. When completed, please email the tracking number to {$sr['sender_email']}.";
?>

<main class=" d-flex flex-column container mt-5 align-items-center justify-content-center">
    <div class="w-50 slp-theme-light border border-dark-subtle shadow-sm rounded mb-5">
        <h2 class="text-center p-4 mb-0">Email Shipping Request</h2>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success text-center">
                <?= safe($_SESSION['success']);
                unset($_SESSION['success']); ?>
            </div>
        <?php elseif (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger text-center">
                <?= safe($_SESSION['error']);
                unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <form class="p-4" action="process_email.php" method="POST">

            <!-- SENDER INFO -->
            <h5 class="mt-2 text-center">Sender Information</h5>
            <div class="mb-3">
                <label class="form-label">Sender Name</label>
                <input type="text" class="form-control"
                    value="<?= safe($sr['sender_name']) ?>" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Sender City/State</label>
                <input type="text" class="form-control"
                    value="<?= safe($sr['sender_city']) . ', ' . safe($sr['sender_state']) ?>" readonly>
            </div>

            <!-- RECIPIENT INFO -->
            <h5 class="mt-4 text-center">Recipient Information</h5>
            <div class="mb-3">
                <label class="form-label">Recipient Name</label>
                <input type="text" class="form-control"
                    value="<?= safe($sr['recipient_name']) ?>" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Recipient City/State</label>
                <input type="text" class="form-control"
                    value="<?= safe($sr['recipient_city']) . ', ' . safe($sr['recipient_state']) ?>" readonly>
            </div>

            <!-- EMAIL TO SEND TO -->
            <div class="mb-3">
                <label for="send_to_email" class="form-label text-center">Email To Send This Request To</label>
                <input type="email" id="send_to_email" name="send_to_email"
                    class="form-control" placeholder="example@domain.com" required>
            </div>

            <!-- ADDITIONAL INSTRUCTIONS -->
            <div class="mb-3">
                <label for="extra_instructions" class="form-label">Additional Instructions</label>
                <textarea name="extra_instructions" id="extra_instructions"
                    class="form-control" rows="4"><?= safe($dynamicPlaceholder) ?></textarea>
            </div>

            <!-- HIDDEN SHIPPING REQUEST DATA -->
            <?php foreach ($sr as $key => $value): ?>
                <input type="hidden" name="<?= safe($key) ?>" value="<?= safe($value) ?>">
            <?php endforeach; ?>

            <!-- Also send the selected email -->
            <input type="hidden" name="final_recipient_email" id="final_recipient_email">

            <div class="text-center">
                <button type="submit" class="btn btn-primary px-5"
                    onclick="document.getElementById('final_recipient_email').value = document.getElementById('send_to_email').value;">
                    Send Email
                </button>
                <a href="dash-loader.php" class="btn btn-secondary ms-2">Cancel</a>
            </div>

        </form>
    </div>
</main>

<?php include '../includes/footer.php'; ?>