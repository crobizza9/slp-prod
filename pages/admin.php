<?php
include 'session.php';
include '../includes/header-loader.php';
include '../includes/get_admin_dash.php';
?>

<main class="dashboard admin">
    <div class="page-header d-flex justify-content-center align-items-center">
        <h1 class="">Admin Dashboard</h1>
    </div>

    <!-- Filter and Overview -->
    <div class="card mb-4">
        <h5 class="card-title">All Shipping Requests</h5>
        <form method="GET" class="d-flex align-items-center gap-2">
            <label for="status" class="form-label mb-0">Filter by Status:</label>
            <select name="status" id="status" class="form-select w-auto">
                <option value="">All</option>
                <option value="Pending" <?php if ($status_filter == 'Pending') echo 'selected'; ?>>Pending</option>
                <option value="In Transit" <?php if ($status_filter == 'In Transit') echo 'selected'; ?>>In Transit</option>
                <option value="Delivered" <?php if ($status_filter == 'Delivered') echo 'selected'; ?>>Delivered</option>
                <option value="Cancelled" <?php if ($status_filter == 'Cancelled') echo 'selected'; ?>>Cancelled</option>
            </select>
            <button type="submit" class="btn btn-primary btn-sm">Sort</button>
        </form>

        <div class="table-wrapper mt-3">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Destination</th>
                        <th>Requested Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $requests->fetch_assoc()): ?>
                        <tr>
                            <td>#SR-<?php echo $row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['firstname'] . ' ' . $row['lastname']); ?></td>
                            <td><?php echo htmlspecialchars($row['recipient_city'] . ', ' . $row['recipient_state']); ?></td>
                            <td><?php echo htmlspecialchars($row['requested_date']); ?></td>
                            <td><span class="badge bg-light text-dark border"><?php echo htmlspecialchars($row['status']); ?></span></td>
                            <td class="actions">
                                <a href="view_form.php?id=<?php echo $row['id']; ?>" class="btn btn-xs btn-primary">View</a>
                                <a href="delete_request.php?id=<?php echo $row['id']; ?>" class="btn btn-xs btn-danger" onclick="return confirm('Delete this request?');">Remove</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <?php if ($total_pages > 1): ?>
                <nav aria-label="Pagination" class="mt-3">
                    <ul class="pagination justify-content-center">

                        <!-- Previous -->
                        <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
                            <a class="page-link"
                                href="?page=<?php echo $page - 1; ?>&status=<?php echo urlencode($status_filter); ?>">
                                Previous
                            </a>
                        </li>

                        <!-- Page numbers -->
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                                <a class="page-link"
                                    href="?page=<?php echo $i; ?>&status=<?php echo urlencode($status_filter); ?>">
                                    <?php echo $i; ?>
                                </a>
                            </li>
                        <?php endfor; ?>

                        <!-- Next -->
                        <li class="page-item <?php if ($page >= $total_pages) echo 'disabled'; ?>">
                            <a class="page-link"
                                href="?page=<?php echo $page + 1; ?>&status=<?php echo urlencode($status_filter); ?>">
                                Next
                            </a>
                        </li>

                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </div>

    <!-- Account Maintenance -->
    <div class="card mt-4">
        <h5 class="card-title">Account Maintenance</h5>
        <table class="data-table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($u = $users->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($u['firstname'] . ' ' . $u['lastname']); ?></td>
                        <td><?php echo htmlspecialchars($u['email']); ?></td>
                        <td><?php echo htmlspecialchars($u['role']); ?></td>
                        <td class="actions">
                            <button
                                class="btn btn-primary btn-xs open-action-modal"
                                data-action="edit_user.php"
                                data-user-id="<?php echo $u['id']; ?>"
                                data-title="Update Role"
                                data-message="Change this user's role:"
                                data-mode="role">
                                Update Role
                            </button>

                            <!-- Reset Password -->
                            <button
                                class="btn btn-secondary btn-xs open-action-modal"
                                data-action="reset_password.php"
                                data-user-id="<?php echo $u['id']; ?>"
                                data-title="Reset Password"
                                data-message="Enter a new password for this user:"
                                data-mode="reset">
                                Reset Password
                            </button>

                            <!-- Delete User -->
                            <button
                                class="btn btn-danger btn-xs open-action-modal"
                                data-action="delete_user.php"
                                data-user-id="<?php echo $u['id']; ?>"
                                data-title="Delete User"
                                data-message="Are you sure you want to permanently delete this account? This cannot be undone."
                                data-mode="delete">
                                Delete
                            </button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <div class="modal fade" id="actionModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <form id="actionForm" method="POST">

                    <div class="modal-header">
                        <h5 class="modal-title" id="actionModalTitle"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <p id="actionModalMessage"></p>

                        <!-- USER ID -->
                        <input type="hidden" name="id" id="actionUserId">

                        <!-- ROLE SELECT (hidden unless mode=role) -->
                        <div id="roleField" class="d-none">
                            <label class="form-label">Select Role</label>
                            <select name="role" class="form-select">
                                <option value="admin">Admin</option>
                                <option value="standard">Standard</option>
                            </select>
                        </div>

                        <!-- PASSWORD FIELDS (hidden unless mode=reset) -->
                        <div id="passwordFields" class="d-none">

                            <label class="form-label mt-2">New Password</label>
                            <input type="password" name="new_password" class="form-control" minlength="8">

                            <label class="form-label mt-2">Confirm Password</label>
                            <input type="password" name="confirm_password" class="form-control" minlength="8">

                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn" id="actionSubmitBtn">Continue</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</main>
<script src="../js/admin.js"></script>
<?php include '../includes/footer.php'; ?>