<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>petmanagementproject</title>
    <link
        href="./bootstrap/css/bootstrap.min.css"rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body> 
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container">
            <!-- Logo / Brand -->
            <a class="navbar-brand fw-bold" href="index.php">
                <i class="bi bi-heart-fill"></i>
                PetCare
            </a>
            <!-- Mobile Toggle Button -->
            <button class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Navbar Links -->
            <div class="collapse navbar-collapse" id="navbarMenu">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">
                            Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pets/view_pets.php">
                            View Pets
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">
                            Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">
                            Register
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>