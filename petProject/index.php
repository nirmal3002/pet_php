<?php
include "navbar.php";
?>
<div class="container-fluid bg-success text-white py-5">
    <div class="container text-center py-5">
        <h1 class="display-4 fw-bold">
            Welcome to PetCare
        </h1>
        <p class="lead mt-3">
            Find Your Perfect Companion and Give a Pet
            a Loving Home.
        </p>
        <a href="pets/view_pets.php"
           class="btn btn-light btn-lg mt-3">

            <i class="bi bi-heart"></i>
            Explore Pets
        </a>
    </div>
</div>

<div class="container my-5">
    <div class="text-center mb-4">
        <h2 class="fw-bold">About PetCare</h2>
        <p class="text-muted">
            PetCare is a pet adoption management system
            that connects loving families with pets
            looking for a home.
        </p>
    </div>
    <div class="row text-center g-4">
        <div class="col-md-4">
            <div class="card shadow-sm p-4 h-100">
                <i class="bi bi-search fs-1 text-success"></i>
                <h4 class="mt-3">Find Pets</h4>
                <p>
                    Browse available pets and find
                    your perfect companion.
                </p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm p-4 h-100">
                <i class="bi bi-house-heart fs-1 text-success"></i>
                <h4 class="mt-3">Adopt Pets</h4>
                <p>
                    Submit adoption requests and
                    give animals a loving home.
                </p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm p-4 h-100">
                <i class="bi bi-shield-check fs-1 text-success"></i>
                <h4 class="mt-3">Safe Adoption</h4>
                <p>
                    Manage adoption applications
                    through a simple system.
                </p>
            </div>
        </div>
    </div>
</div>
<?php
include "footer.php";
?>
