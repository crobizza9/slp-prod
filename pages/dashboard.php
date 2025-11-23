<?php
include 'session.php';
include '../includes/header-loader.php';
include '../includes/get_dashboard.php';
?>

<main class="dashboard">
    <div class="page-header">
        <h1>Dashboard</h1>
    </div>

    <div class="grid-top">
        <div class="card">
            <h5 class="card-title text-primary mb-3">Shipping Requests</h5>
            <p>Create a new shipping request here.</p>




            <a href="shipping-request-form.php" class="btn btn-primary">New Request</a>
        </div>

        <div class="card">
            <h5 class="card-title text-success">Account Settings</h5>
            <p>Update your account details and password.</p>
            <a href="account.php" class="btn btn-success">Manage Account</a>
        </div>
    </div>

    <div class="card history">
        <h5 class="card-title text-info">Shipping History</h5>
        <p class="text-muted">Your recent and completed shipping requests.</p>
        <div class="row text-center">

            <div class="col status-filter" data-status="Pending">
                <strong>Pending</strong><br>
                <span class="text-decoration-underline text-info fs-5"><?php echo $status_counts["Pending"]; ?></span>
            </div>


            <div class="col status-filter" data-status="Shipped">
                <strong>Shipped</strong><br>
                <span class="text-decoration-underline text-info fs-5"><?php echo $status_counts["Shipped"]; ?></span>
            </div>
            <div class="col status-filter text-nowrap" data-status="In Transit">
                <strong>In Transit</strong><br>
                <span class="text-decoration-underline text-info fs-5"><?php echo $status_counts["In Transit"]; ?></span>
            </div>

            <div class="col status-filter" data-status="Delivered">
                <strong>Delivered</strong><br>
                <span class="text-decoration-underline text-success fs-5"><?php echo $status_counts["Delivered"]; ?></span>
            </div>

            <div class="col status-filter" data-status="Cancelled">
                <strong>Cancelled</strong><br>
                <span class="text-decoration-underline text-danger fs-5"><?php echo $status_counts["Cancelled"]; ?></span>
            </div>

        </div>
        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Request ID</th>
                        <th>Destination</th>
                        <th>Requested Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td>#SR-<?php echo htmlspecialchars($row['id']); ?></td>
                                <td><?php echo htmlspecialchars($row['recipient_city'] . ', ' . $row['recipient_state']); ?></td>
                                <td><?php echo htmlspecialchars($row['requested_date']); ?></td>
                                <td>
                                    <span class="badge bg-light text-dark border">
                                        <?php echo htmlspecialchars($row['status']); ?>
                                    </span>
                                </td>
                                <td class="actions">
                                    <a href="view_form.php?id=<?php echo $row['id']; ?>" class="btn btn-xs btn-primary">View</a>
                                    <a href="update_form.php?id=<?php echo $row['id']; ?>" class="btn btn-xs btn-secondary">Edit</a>
                                    <a href="delete_request.php?id=<?php echo $row['id']; ?>" class="btn btn-xs btn-danger" onclick="return confirm('Delete this request?');">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted">No shipping requests found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <?php if ($total_pages > 1): ?>
                <nav aria-label="Pagination" class="mt-3">
                    <ul class="pagination justify-content-center">

                        <!-- Previous -->
                        <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
                            <a class="page-link"
                                href="?page=<?php echo $page - 1; ?>">
                                Previous
                            </a>
                        </li>

                        <!-- Page Numbers -->
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                                <a class="page-link" href="?page=<?php echo $i; ?>">
                                    <?php echo $i; ?>
                                </a>
                            </li>
                        <?php endfor; ?>

                        <!-- Next -->
                        <li class="page-item <?php if ($page >= $total_pages) echo 'disabled'; ?>">
                            <a class="page-link"
                                href="?page=<?php echo $page + 1; ?>">
                                Next
                            </a>
                        </li>

                    </ul>
                </nav>
            <?php endif; ?>

        </div>

        <button id="showAll" class="btn btn-outline-primary btn-sm mt-3 d-none">
            Show All
        </button>
    </div>
</main>
<script src="../js/dashboard.js"></script>
<?php include '../includes/footer.php'; ?>