<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Pet Management System</title>

    <!-- Bootstrap CSS -->
    <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">

</head>

<body>

<!-- <nav class="navbar navbar-expand-lg navbar-dark bg-success">

    <div class="container">

        <a class="navbar-brand fw-bold" href="index.php">
            <i class="bi bi-heart-fill"></i> Pet Management
        </a>

        <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#menu">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse" id="menu">

            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a href="index.php" class="nav-link">Home</a>
                </li>

                <li class="nav-item">
                    <a href="pet_display.php" class="nav-link">View Pets</a>
                </li>

                <li class="nav-item">
                    <a href="pet_add.php" class="nav-link">Add Pet</a>
                </li>

                <li class="nav-item">
                    <a href="login.php" class="nav-link">Login</a>
                </li>

                <li class="nav-item">
                    <a href="register.php" class="nav-link">Register</a>
                </li>

            </ul>

        </div>

    </div>

</nav> -->

<nav class="navbar navbar-expand-lg navbar-dark bg-success">

    <div class="container">

        <a class="navbar-brand fw-bold" href="index.php">
            <i class="bi bi-heart-fill"></i>
            Pet Management
        </a>

        <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#menu">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse" id="menu">

            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a href="index.php" class="nav-link">Home</a>
                </li>

                <li class="nav-item">
                    <a href="pet_display.php" class="nav-link">View Pets</a>
                </li>

                <?php if (isset($_SESSION["id"])) { ?>

                    <li class="nav-item">
                        <a href="dashboard.php" class="nav-link">Dashboard</a>
                    </li>

                    <li class="nav-item">
                        <a href="logout.php" class="nav-link">Logout</a>
                    </li>

                <?php } else { ?>

                    <li class="nav-item">
                        <a href="login.php" class="nav-link">Login</a>
                    </li>

                    <li class="nav-item">
                        <a href="register.php" class="nav-link">Register</a>
                    </li>

                <?php } ?>

            </ul>

        </div>

    </div>

</nav>

