<?php
// Start session early to ensure message handling works
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}



// Display session error messages, if any
if (isset($_SESSION['error'])) {
    echo '<div class="alert alert-danger text-center" role="alert">'
        . htmlspecialchars($_SESSION['error'])
        . '</div>';
    unset($_SESSION['error']);
}


if (isset($_SESSION['user_id'])) {
    header("Location: dash-loader.php");
    exit;
}
// Include header after session starts (so headers can still be sent)
include __DIR__ . '/../includes/header-loader.php';
?>
<main class="container-fluid slp-theme-light login d-flex flex-column justify-content-center align-items-center shadow mt-auto">
    <h2 class="text-accent mb-4">Login</h2>

    <form action="process_login.php" method="POST" class=" text-center d-flex flex-column justify-content-center align-items-center" autocomplete="off" novalidate>
        <div class="form-group mb-3">
            <label class="mb-3" for="email">Email</label>
            <input type="email" id="email" name="email" required class="form-control"
                placeholder="Enter your email">
        </div>

        <div class="form-group mb-3">
            <label class="mb-3" for="password">Password</label>
            <input type="password" id="password" name="password" required class="form-control"
                placeholder="Enter your password">
        </div>

        <button type="submit" class="btn btn-custom" name="login">Login</button>
    </form>

    <p class="mt-3">Don’t have an account?
        <a href="register.php" class="text-accent">Register Here</a>
    </p>
</main>


<?php include '../includes/footer.php'; ?>