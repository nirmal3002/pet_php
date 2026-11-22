<?php
include_once "navbar.php";
?>

<!-- Hero Section -->
<div class="hero-section">

    <div class="container">
        <div class="row align-items-center">

            <div class="col-md-6 text-center text-md-start">

                <h1 class="display-4 fw-bold">
                    Every Pet Deserves
                    <span class="text-success">Love & Care</span>
                </h1>

                <p class="lead text-muted mt-3">
                    A simple and efficient platform to manage pet
                    information. Add, view, update and manage your
                    favourite pets in one place.
                </p>

                <div class="mt-4">

                    <a href="pet_display.php"
                       class="btn btn-success btn-lg me-2 mb-2">
                        <i class="bi bi-search"></i>
                        Explore Pets
                    </a>

                    <?php if (isset($_SESSION["id"])) { ?>

                        <a href="dashboard.php"
                           class="btn btn-outline-success btn-lg mb-2">
                            <i class="bi bi-speedometer2"></i>
                            Dashboard
                        </a>

                    <?php } else { ?>

                        <a href="register.php"
                           class="btn btn-outline-success btn-lg mb-2">
                            <i class="bi bi-person-plus"></i>
                            Get Started
                        </a>

                    <?php } ?>

                </div>

            </div>

            <div class="col-md-6 text-center mt-4 mt-md-0">

                <div class="hero-image">
                    <img src="https://images.unsplash.com/photo-1450778869180-41d0601e046e?w=700"
                         alt="Cute pets"
                         class="img-fluid rounded-4 shadow">
                </div>

            </div>

        </div>
    </div>

</div>


<!-- Features Section -->
<div class="container my-5">

    <div class="text-center mb-5">

        <span class="text-success fw-bold">OUR FEATURES</span>

        <h2 class="fw-bold mt-2">
            What Can You Do?
        </h2>

        <p class="text-muted">
            Everything you need to manage pet information.
        </p>

    </div>


    <div class="row g-4">

        <!-- Add Pet -->
        <div class="col-md-4">

            <div class="card feature-card shadow-sm p-4 text-center h-100">

                <div class="feature-icon">
                    <i class="bi bi-plus-circle"></i>
                </div>

                <h4 class="mt-3">Add New Pets</h4>

                <p class="text-muted">
                    Add new pet details including name, category,
                    breed, age, gender and image.
                </p>

                <?php if (isset($_SESSION["id"])) { ?>

                    <a href="pet_add.php"
                       class="btn btn-outline-success mt-auto">
                        Add Pet
                    </a>

                <?php } else { ?>

                    <a href="login.php"
                       class="btn btn-outline-success mt-auto">
                        Login to Add
                    </a>

                <?php } ?>

            </div>

        </div>


        <!-- View Pets -->
        <div class="col-md-4">

            <div class="card feature-card shadow-sm p-4 text-center h-100">

                <div class="feature-icon">
                    <i class="bi bi-card-list"></i>
                </div>

                <h4 class="mt-3">View Pets</h4>

                <p class="text-muted">
                    View all registered pets and explore their
                    information in one place.
                </p>

                <a href="pet_display.php"
                   class="btn btn-outline-success mt-auto">
                    View Pets
                </a>

            </div>

        </div>


        <!-- Manage Pets -->
        <div class="col-md-4">

            <div class="card feature-card shadow-sm p-4 text-center h-100">

                <div class="feature-icon">
                    <i class="bi bi-clipboard-check"></i>
                </div>

                <h4 class="mt-3">Manage Pets</h4>

                <p class="text-muted">
                    Update pet information, view individual
                    details and delete records.
                </p>

                <?php if (isset($_SESSION["id"])) { ?>

                    <a href="pet_display.php"
                       class="btn btn-outline-success mt-auto">
                        Manage Pets
                    </a>

                <?php } else { ?>

                    <a href="login.php"
                       class="btn btn-outline-success mt-auto">
                        Login to Manage
                    </a>

                <?php } ?>

            </div>

        </div>

    </div>

</div>


<!-- About Section -->
<div class="about-section py-5">

    <div class="container">

        <div class="row align-items-center">

            <div class="col-md-6 mb-4 mb-md-0">

                <img src="https://images.unsplash.com/photo-1548199973-03cce0bbc87b?w=700"
                     alt="Dogs playing together"
                     class="img-fluid rounded-4 shadow">

            </div>


            <div class="col-md-6">

                <span class="text-success fw-bold">
                    ABOUT OUR PROJECT
                </span>

                <h2 class="fw-bold mt-2">
                    Making Pet Management Easier
                </h2>

                <p class="text-muted mt-3">
                    Pet Management System is designed to make
                    storing and managing pet information easy.
                    Users can register, log in and manage pet
                    records through a simple interface.
                </p>

                <p class="text-muted">
                    From adding new pets to updating existing
                    information, this system helps keep all
                    pet records organized.
                </p>

                <a href="pet_display.php"
                   class="btn btn-success mt-2">
                    Explore Our Pets
                    <i class="bi bi-arrow-right"></i>
                </a>

            </div>

        </div>

    </div>

</div>


<!-- Call to Action -->
<div class="container my-5">

    <div class="cta-section text-center p-5 rounded-4">

        <h2 class="fw-bold">
            Ready to Manage Your Pets?
        </h2>

        <p class="mt-3">
            Join us and start managing pet information easily.
        </p>

        <?php if (isset($_SESSION["id"])) { ?>

            <a href="dashboard.php"
               class="btn btn-light btn-lg mt-2">
                Go to Dashboard
            </a>

        <?php } else { ?>

            <a href="register.php"
               class="btn btn-light btn-lg mt-2">
                Create Your Account
            </a>

            <a href="login.php"
               class="btn btn-outline-light btn-lg mt-2 ms-2">
                Login
            </a>

        <?php } ?>

    </div>

</div>


<?php
include_once "footer.php";
?>
