<?php
// includes/user-header.php
require_once __DIR__ . '/db_connect.php';


if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Fetch email + avatar for header display
    $stmt = $conn->prepare("SELECT firstname, profile_pic FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($firstname_db, $avatar_db);
    if ($stmt->fetch()) {
        $firstname = htmlspecialchars($firstname_db);
        $avatar = !empty($avatar_db) ? htmlspecialchars($avatar_db) : "default.png";
    }
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SLP - Shipping Logistics Platform</title>

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
    <link rel="stylesheet" href="/css/style.css" />
    <link rel="stylesheet" href="/css/dashboard.css" />
    <style>
        body,
        html {
            background: linear-gradient(to bottom, #1e1e2f, #64646d);
        }
    </style>


</head>

<body class="d-flex flex-column min-vh-100 bg-dark-subtle">

    <!-- Header Section -->
    <header>
        <nav class="navbar navbar-expand-md slp-theme shadow p-0">

            <div class="container-fluid">
                <a href="/index.php" class="nav-item">
                    <img src="/img/SLP.png" alt="SLP Logo" width="55" class="navbar-brand" /></a>

            </div>

            <!-- Right side: Profile dropdown -->
            <div class="dropdown ms-auto">
                <button
                    class="btn dropdown-toggle d-flex align-items-center"
                    type="button"
                    id="userDropdown"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                    style="background: none; border: none; color: white;">
                    <span class="me-2 fw-semibold"><?php echo htmlspecialchars($firstname); ?></span>
                    <img
                        src="../uploads/avatars/<?php echo htmlspecialchars($avatar); ?>"
                        alt="Profile Picture"
                        width="36"
                        height="36"
                        class="border border-secondary" />
                </button>

                <ul class="dropdown-menu dropdown-menu-end custom-dropdown" aria-labelledby="userDropdown">
                    <li><a class="dropdown-item" href="/pages/shipping-request-form.php">New Request</a></li>
                    <li><a class="dropdown-item" href="/pages/dash-loader.php">Dashboard</a></li>
                    <li><a class="dropdown-item" href="/pages/account.php">Account Settings</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item text-danger" href="/pages/logout.php">Logout</a></li>
                </ul>
            </div>

        </nav>
    </header>