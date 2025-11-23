<?php
include 'session.php';
include '../includes/user-header.php';
include '../includes/get-account-data.php';
?>

<main class="container mb-5 mt-5">
    <div class="card slp-theme-light rounded border border-dark-subtle">
        <h2 class="p-4 mb-4 text-center">Account Settings</h2>

        <?php if ($success): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php elseif ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <div class="card-body">
            <form method="POST" action="" enctype="multipart/form-data" autocomplete="off" novalidate>

                <!-- Profile Picture -->
                <div class="text-center mb-4">
                    <div class="mb-2">
                        <img id="profilePreview"
                            src="<?= htmlspecialchars($profile_pic) ?>"
                            alt="Profile Picture"
                            class="border"
                            width="80" height="80"
                            style="object-fit: cover;">
                    </div>
                    <label class="form-label">Upload New Avatar</label>
                    <input type="file" name="profile_pic" id="profile_pic" class="form-control mt-1 mx-auto" accept="image/*">
                </div>

                <!-- Password -->
                <h5 class="m-3 text-center">Change Password</h5>
                <div class="mb-3">
                    <label for="password" class="form-label">New Password</label>
                    <input type="password" class="form-control" name="password" id="password">
                </div>
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirm New Password</label>
                    <input type="password" class="form-control" name="confirm_password" id="confirm_password">
                </div>
                <h5 class="m-3 text-center">Update Name and Email</h5>
                <!-- Account Info -->
                <div class="mb-3">
                    <label for="firstname" class="form-label">First Name</label>
                    <input type="text" class="form-control" name="firstname" id="firstname"
                        value="<?= htmlspecialchars($firstname) ?>">
                </div>
                <div class="mb-3">
                    <label for="lastname" class="form-label">Last Name</label>
                    <input type="text" class="form-control" name="lastname" id="lastname"
                        value="<?= htmlspecialchars($lastname) ?>">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" name="email" id="email"
                        value="<?= htmlspecialchars($email) ?>">
                </div>

                <div class="mt-4 text-center">
                    <button type="submit" class="btn btn-primary mb-4">Save Changes</button>
                    <div id="saveChanges" class="form-text">
                        Only the fields that were changed will be updated.<br>Fields left alone will not update!
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<script>
    document.getElementById('profile_pic').addEventListener('change', function(event) {
        const [file] = event.target.files;
        if (file) {
            document.getElementById('profilePreview').src = URL.createObjectURL(file);
        }
    });
</script>

<?php include '../includes/footer.php'; ?>