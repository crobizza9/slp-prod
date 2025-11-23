<?php
include 'session.php';
include '../includes/db_connect.php';

// Redirect if no ID provided
if (!isset($_GET['id'])) {
    header("Location: dash-loader.php");
    exit;
}

$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM shipping_requests WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$request = $result->fetch_assoc();
$stmt->close();

if (!$request) {
    echo "<main class='container py-4'><div class='alert alert-danger text-center'>Form not found.</div></main>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $today_date           = trim($_POST['today_date'] ?? '');
    $requested_date       = trim($_POST['requested_date'] ?? '');
    $sender_name          = trim($_POST['sender_name'] ?? '');
    $sender_business      = trim($_POST['sender_business'] ?? '');
    $sender_address       = trim($_POST['sender_address'] ?? '');
    $sender_city          = trim($_POST['sender_city'] ?? '');
    $sender_state         = strtoupper(trim($_POST['sender_state'] ?? ''));
    $sender_zip           = trim($_POST['sender_zip'] ?? '');
    $sender_phone         = trim($_POST['sender_phone'] ?? '');
    $sender_email         = trim($_POST['sender_email'] ?? '');
    $recipient_name       = trim($_POST['recipient_name'] ?? '');
    $recipient_business   = trim($_POST['recipient_business'] ?? '');
    $recipient_address    = trim($_POST['recipient_address'] ?? '');
    $recipient_city       = trim($_POST['recipient_city'] ?? '');
    $recipient_state      = strtoupper(trim($_POST['recipient_state'] ?? ''));
    $recipient_zip        = trim($_POST['recipient_zip'] ?? '');
    $recipient_phone      = trim($_POST['recipient_phone'] ?? '');
    $recipient_email      = trim($_POST['recipient_email'] ?? '');
    $carrier              = trim($_POST['carrier'] ?? '');
    $speed                = trim($_POST['speed'] ?? '');
    $insurance            = trim($_POST['insurance'] ?? '');
    $declared_value       = trim($_POST['declared_value'] ?? '');
    $signature_required   = trim($_POST['signature_required'] ?? '');
    $special_instructions = trim($_POST['special_instructions'] ?? '');
    $status               = trim($_POST['status'] ?? '');


    $tracking             = isset($_POST['tracking']) && trim($_POST['tracking']) !== ''
        ? trim($_POST['tracking'])
        : null;
    $delivery_date        = isset($_POST['delivery_date']) && trim($_POST['delivery_date']) !== ''
        ? trim($_POST['delivery_date'])
        : null;

    $stmt = $conn->prepare("
        UPDATE shipping_requests SET
            today_date=?, requested_date=?,
            sender_name=?, sender_business=?, sender_address=?, sender_city=?, sender_state=?, sender_zip=?, sender_phone=?, sender_email=?,
            recipient_name=?, recipient_business=?, recipient_address=?, recipient_city=?, recipient_state=?, recipient_zip=?, recipient_phone=?, recipient_email=?,
            carrier=?, speed=?, insurance=?, declared_value=?, signature_required=?, special_instructions=?, status=?, tracking_number=?, delivery_date=?
        WHERE id=?
    ");

    $stmt->bind_param(
        "sssssssssssssssssssssssssssi",
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
        $signature_required,
        $special_instructions,
        $status,
        $tracking,
        $delivery_date,
        $id
    );

    if ($stmt->execute()) {
        header("Location: view_form.php?id=$id");
        exit;
    } else {
        $error = "Failed to update form. Please try again.";
    }
    $stmt->close();
}
include '../includes/user-header.php';
?>


<div class="container slp-theme-light rounded mt-5 mb-5">
    <h1 class="text-center p-3">Update Shipping Form</h1>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <!-- Dates -->
        <fieldset>
            <div class="row m-3 p-3 border border-dark rounded shadow">
                <legend class="text-center">Dates</legend>
                <div class="col">
                    <label for="today_date" class="form-label">Today's Date</label>
                    <input type="date" id="today_date" name="today_date" class="form-control"
                        value="<?= htmlspecialchars($request['today_date'] ?? '') ?>" required />
                </div>
                <div class="col">
                    <label for="requested_date" class="form-label">Requested Ship Date</label>
                    <input type="date" id="requested_date" name="requested_date" class="form-control"
                        value="<?= htmlspecialchars($request['requested_date'] ?? '') ?>" required />
                </div>
            </div>
        </fieldset>

        <!-- Sender -->
        <fieldset>
            <div class="row m-3 p-3 border border-dark rounded shadow">
                <legend class="text-center">Sender Information</legend>
                <div class="col">
                    <label for="sender_name" class="form-label">Name</label>
                    <input type="text" id="sender_name" name="sender_name" class="form-control mb-2"
                        value="<?= htmlspecialchars($request['sender_name'] ?? '') ?>" required />
                    <label for="sender_business" class="form-label">Business</label>
                    <input type="text" id="sender_business" name="sender_business" class="form-control mb-2"
                        value="<?= htmlspecialchars($request['sender_business'] ?? '') ?>" />
                    <label for="sender_phone" class="form-label">Phone Number</label>
                    <input type="tel" id="sender_phone" name="sender_phone" class="form-control mb-2"
                        value="<?= htmlspecialchars($request['sender_phone'] ?? '') ?>" required />
                    <label for="sender_email" class="form-label">Email</label>
                    <input type="email" id="sender_email" name="sender_email" class="form-control mb-2"
                        value="<?= htmlspecialchars($request['sender_email'] ?? '') ?>" required />
                </div>

                <div class="col">
                    <label for="sender_address" class="form-label">Address</label>
                    <input type="text" id="sender_address" name="sender_address" class="form-control mb-2"
                        value="<?= htmlspecialchars($request['sender_address'] ?? '') ?>" required />
                    <label for="sender_city" class="form-label">City</label>
                    <input type="text" id="sender_city" name="sender_city" class="form-control mb-2"
                        value="<?= htmlspecialchars($request['sender_city'] ?? '') ?>" required />
                    <label for="sender_state" class="form-label">State</label>
                    <input type="text" id="sender_state" name="sender_state" maxlength="2" class="form-control mb-2"
                        value="<?= htmlspecialchars($request['sender_state'] ?? '') ?>" required />
                    <label for="sender_zip" class="form-label">Zipcode</label>
                    <input type="text" id="sender_zip" name="sender_zip" class="form-control mb-2"
                        value="<?= htmlspecialchars($request['sender_zip'] ?? '') ?>" required />
                </div>
            </div>
        </fieldset>

        <!-- Recipient -->
        <fieldset>
            <div class="row m-3 p-3 border border-dark rounded shadow">
                <legend class="text-center">Recipient Information</legend>
                <div class="col">
                    <label for="recipient_name" class="form-label">Name</label>
                    <input type="text" id="recipient_name" name="recipient_name" class="form-control mb-2"
                        value="<?= htmlspecialchars($request['recipient_name'] ?? '') ?>" required />
                    <label for="recipient_business" class="form-label">Business</label>
                    <input type="text" id="recipient_business" name="recipient_business" class="form-control mb-2"
                        value="<?= htmlspecialchars($request['recipient_business'] ?? '') ?>" />
                    <label for="recipient_phone" class="form-label">Phone Number</label>
                    <input type="tel" id="recipient_phone" name="recipient_phone" class="form-control mb-2"
                        value="<?= htmlspecialchars($request['recipient_phone'] ?? '') ?>" required />
                    <label for="recipient_email" class="form-label">Email</label>
                    <input type="email" id="recipient_email" name="recipient_email" class="form-control mb-2"
                        value="<?= htmlspecialchars($request['recipient_email'] ?? '') ?>" required />
                </div>

                <div class="col">
                    <label for="recipient_address" class="form-label">Address</label>
                    <input type="text" id="recipient_address" name="recipient_address" class="form-control mb-2"
                        value="<?= htmlspecialchars($request['recipient_address'] ?? '') ?>" required />
                    <label for="recipient_city" class="form-label">City</label>
                    <input type="text" id="recipient_city" name="recipient_city" class="form-control mb-2"
                        value="<?= htmlspecialchars($request['recipient_city'] ?? '') ?>" required />
                    <label for="recipient_state" class="form-label">State</label>
                    <input type="text" id="recipient_state" name="recipient_state" maxlength="2" class="form-control mb-2"
                        value="<?= htmlspecialchars($request['recipient_state'] ?? '') ?>" required />
                    <label for="recipient_zip" class="form-label">Zipcode</label>
                    <input type="text" id="recipient_zip" name="recipient_zip" class="form-control mb-2"
                        value="<?= htmlspecialchars($request['recipient_zip'] ?? '') ?>" required />
                </div>
            </div>
        </fieldset>

        <!-- Shipping Method -->
        <fieldset>
            <div class="row gap-2 m-3 p-3 border border-dark rounded shadow">
                <legend class="text-center">Shipping Method</legend>

                <div class="col">
                    <label for="carrier" class="form-label">Carrier</label>
                    <select id="carrier" name="carrier" class="form-select" required>
                        <option value="fedex" <?= ($request['carrier'] === 'fedex') ? 'selected' : '' ?>>FedEx</option>
                        <option value="ups" <?= ($request['carrier'] === 'ups') ? 'selected' : '' ?>>UPS</option>
                        <option value="usps" <?= ($request['carrier'] === 'usps') ? 'selected' : '' ?>>USPS</option>
                        <option value="dhl" <?= ($request['carrier'] === 'dhl') ? 'selected' : '' ?>>DHL</option>
                        <option value="other" <?= ($request['carrier'] === 'other') ? 'selected' : '' ?>>Other</option>
                    </select>

                    <label for="declared_value" class="form-label mt-3">Declared Value (if insured)</label>
                    <input type="number" id="declared_value" name="declared_value" min="0" step="0.01"
                        value="<?= htmlspecialchars($request['declared_value'] ?? '') ?>" class="form-control mb-2" />
                    <label class="form-check-label">Insurance?</label>
                    <div class="d-flex flex-row gap-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="yes" name="insurance" id="insuranceYes"
                                <?= ($request['insurance'] === 'yes') ? 'checked' : '' ?> />
                            <label class="form-check-label" for="insuranceYes">Yes</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="no" name="insurance" id="insuranceNo"
                                <?= ($request['insurance'] === 'no') ? 'checked' : '' ?> />
                            <label class="form-check-label" for="insuranceNo">No</label>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <label class="form-check-label">Signature Required?</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="yes" name="signature_required" id="signatureYes"
                            <?= ($request['signature_required'] === 'yes') ? 'checked' : '' ?> />
                        <label class="form-check-label" for="signatureYes">Yes</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="no" name="signature_required" id="signatureNo"
                            <?= ($request['signature_required'] === 'no') ? 'checked' : '' ?> />
                        <label class="form-check-label" for="signatureNo">No</label>
                    </div>

                    <label class="mt-3">Shipping Speed</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="economy" name="speed" id="speedEconomy"
                            <?= ($request['speed'] === 'economy') ? 'checked' : '' ?> />
                        <label class="form-check-label" for="speedEconomy">Economy (3+ days)</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="priority" name="speed" id="speedPriority"
                            <?= ($request['speed'] === 'priority') ? 'checked' : '' ?> />
                        <label class="form-check-label" for="speedPriority">Priority (2–3 days)</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="overnight" name="speed" id="speedOvernight"
                            <?= ($request['speed'] === 'overnight') ? 'checked' : '' ?> />
                        <label class="form-check-label" for="speedOvernight">Overnight (1 day)</label>
                    </div>
                </div>
            </div>
        </fieldset>

        <!-- Special Instructions -->
        <fieldset>
            <div class="row m-3 p-3 border border-dark rounded shadow">
                <legend class="text-center mb-3">Special Instructions</legend>
                <textarea id="special_instructions" name="special_instructions" rows="5" class="form-control mb-3"
                    placeholder="Enter any additional delivery or packaging notes..."><?= htmlspecialchars($request['special_instructions'] ?? '') ?></textarea>
            </div>
        </fieldset>
        <fieldset>
            <div class="row m-3 p-3 border border-dark rounded shadow">
                <legend class="text-center mb-3">Status</legend>

                <div class="col">
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status" class="form-select mb-3" required>
                        <option value="Pending" <?= ($request['status'] == 'Pending' ? 'selected' : '') ?>>Pending</option>
                        <option value="Shipped" <?= ($request['status'] == 'Shipped' ? 'selected' : '') ?>>Shipped</option>
                        <option value="In Transit" <?= ($request['status'] == 'In Transit' ? 'selected' : '') ?>>In Transit</option>
                        <option value="Delivered" <?= ($request['status'] == 'Delivered' ? 'selected' : '') ?>>Delivered</option>
                        <option value="Cancelled" <?= ($request['status'] == 'Cancelled' ? 'selected' : '') ?>>Cancelled</option>
                    </select>
                </div>

                <div class="col">
                    <label for="tracking" class="form-label">Tracking Number</label>
                    <input
                        type="text"
                        name="tracking"
                        id="tracking"
                        class="form-control"
                        value="<?= htmlspecialchars($request['tracking_number'] ?? '') ?>">
                </div>

                <div class="col">
                    <label for="delivery_date" class="form-label">Expected Delivery Date</label>
                    <input
                        type="date"
                        name="delivery_date"
                        id="delivery_date"
                        class="form-control"
                        value="<?= htmlspecialchars($request['delivery_date'] ?? '') ?>">
                </div>
            </div>
        </fieldset>
        <div class="m-5 text-center">
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="view_form.php?id=<?= $id ?>" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
<script src="../js/form.js"></script>
<?php include '../includes/footer.php'; ?>