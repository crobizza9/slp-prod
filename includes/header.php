<?php
// includes/header.php
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



</head>

<body class="d-flex flex-column min-vh-100 bg-dark">

    <!-- Header Section -->
    <header>
        <nav class="navbar navbar-expand-md slp-theme shadow">
            <div class="container">
                <a href="/index.php" class="nav-item">
                    <img src="/img/SLP.png" alt="SLP Logo" width="55" class="navbar-brand" /></a>

            </div>
            <div class="navbar-collapse pe-2">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link text-light fw-medium" href="/pages/login.php">Login</a></li>
                    <li class="nav-item"><a class="nav-link text-light fw-medium" href="/pages/register.php">Sign up</a></li>
                </ul>
            </div>
        </nav>
    </header>