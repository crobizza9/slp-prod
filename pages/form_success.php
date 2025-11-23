<?php
include 'session.php';
include '../includes/user-header.php';

$shipping_id = $_GET['id'] ?? null;
?>

<main class="container py-4">
    <div class="card shadow-sm border-success">
        <div class="card-body text-center">
            <h2 class="text-success mb-3">Shipping Request Submitted Successfully!</h2>
            <p>Your shipping request has been added to the system.</p>

            <div class="d-flex flex-wrap justify-content-center gap-3 mt-4">
                <a href="dashboard.php" class="btn btn-primary">Back to Dashboard</a>
                <?php if ($shipping_id): ?>
                    <a href="update_form.php?id=<?= $shipping_id ?>" class="btn slp-theme">Update Form</a>
                    <a href="view_form.php?id=<?= $shipping_id ?>" class="btn slp-theme">View Form</a>
                    <a href="print_form.php?id=<?= $shipping_id ?>" class="btn slp-theme" target="_blank">Print Form</a>
                    <a href="email_form.php?id=<?= $shipping_id ?>" class="btn slp-theme">Email Form</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<?php include '../includes/footer.php'; ?>