<?php
// ---------------------------------------
// SLP - Reusable Error Display Page
// ---------------------------------------
// Call this page with:
// error.php?msg=Something+went+wrong
// Or send an array of errors via session
// ---------------------------------------

session_start();

// Single string message fallback
$message = $_GET['msg'] ?? 'An unexpected error occurred.';

// If multiple errors were passed
$errors = $_SESSION['validation_errors'] ?? [];
unset($_SESSION['validation_errors']); // Clear after showing
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Error - SLP</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap"
        rel="stylesheet" />

    <!-- Font Awesome -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer" />

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous" />

    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="../css/error.css" />

</head>

<body class="d-flex flex-column min-vh-100">

    <div class="error-page d-flex align-items-center justify-content-center">
        <div class="error-container text-center p-4">
            <h1 class="error-code mb-3">Error</h1>
            <p class="error-message"><?= htmlspecialchars($message) ?></p>
            <?php if (!empty($errors)): ?>
                <ul class="error-list text-center text-light">
                    <?php foreach ($errors as $err): ?>
                        <li><?= htmlspecialchars($err) ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <div class="text-center">
                <a href="javascript:history.back()" class="btn btn-glass px-4 py-2">
                    Go Back
                </a>
            </div>
        </div>
    </div>

    <footer class="mt-auto slp-gradient shadow p-2">
        <div class="container text-center">
            &copy;
            <?php echo date("Y"); ?>
            Shipping Logistics Platform. All rights reserved.
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js" integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y" crossorigin="anonymous"></script>
</body>

</html>