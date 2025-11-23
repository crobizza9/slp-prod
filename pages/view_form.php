<?php
include 'session.php';
include '../includes/user-header.php';
include '../includes/db_connect.php';

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
?>

<main class="container py-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="mb-4">Shipping Request Details</h3>

            <?php if ($request): ?>
                <ul class="list-group">
                    <li class="list-group-item"><strong>Sender:</strong> <?= htmlspecialchars($request['sender_name'] ?? '') ?> (<?= htmlspecialchars($request['sender_business'] ?? '') ?>)</li>
                    <li class="list-group-item"><strong>From:</strong> <?= htmlspecialchars($request['sender_city'] ?? '') ?>, <?= htmlspecialchars($request['sender_state'] ?? '') ?> <?= htmlspecialchars($request['sender_zip'] ?? '') ?></li>
                    <li class="list-group-item"><strong>Recipient:</strong> <?= htmlspecialchars($request['recipient_name'] ?? '') ?> (<?= htmlspecialchars($request['recipient_business'] ?? '') ?>)</li>
                    <li class="list-group-item"><strong>To:</strong> <?= htmlspecialchars($request['recipient_city'] ?? '') ?>, <?= htmlspecialchars($request['recipient_state'] ?? '') ?> <?= htmlspecialchars($request['recipient_zip'] ?? '') ?></li>
                    <li class="list-group-item"><strong>Carrier:</strong> <?= htmlspecialchars($request['carrier'] ?? '') ?></li>
                    <li class="list-group-item"><strong>Speed:</strong> <?= htmlspecialchars($request['speed'] ?? '') ?></li>
                    <li class="list-group-item"><strong>Insurance:</strong> <?= htmlspecialchars($request['insurance'] ?? '') ?></li>
                    <li class="list-group-item"><strong>Declared Value:</strong> <?= htmlspecialchars($request['declared_value'] ?? '') ?></li>
                    <li class="list-group-item"><strong>Signature Required:</strong> <?= htmlspecialchars($request['signature_required'] ?? 'No') ?></li>
                    <li class="list-group-item"><strong>Status:</strong> <?= htmlspecialchars($request['status'] ?? 'Pending') ?></li>
                    <li class="list-group-item"><strong>Tracking Number:</strong> <?= htmlspecialchars($request['tracking_number'] ?? '') ?></li>
                    <li class="list-group-item"><strong>Delivery Date:</strong> <?= htmlspecialchars($request['delivery_date'] ?? '') ?></li>
                </ul>
                <div class="mt-4 text-center">
                    <a href="update_form.php?id=<?= $id ?>" class="btn slp-theme">Update</a>
                    <a href="print_form.php?id=<?= $id ?>" class="btn slp-theme">Print</a>
                    <a href="email_form.php?id=<?= $id ?>" class="btn slp-theme">Email</a>
                    <a href="dash-loader.php" class="btn slp-theme">Back</a>
                </div>
            <?php else: ?>
                <div class="alert alert-danger text-center mt-3">Form not found.</div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php include '../includes/footer.php'; ?>