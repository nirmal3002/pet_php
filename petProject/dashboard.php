<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}
include_once "navbar.php";
?>
<div class="container my-5">
    <div class="card shadow">
        <div class="card-body text-center py-5">
            <i class="bi bi-person-circle text-success"
               style="font-size: 60px;"></i>
            <h2 class="mt-3">
                Welcome,
                <?php echo htmlspecialchars($_SESSION["name"]); ?>!
            </h2>
            <p class="text-muted">
                Welcome to your Pet Management Dashboard.
            </p>
            <p>
                Email:
                <?php echo htmlspecialchars($_SESSION["email"]); ?>
            </p>
            <hr>
            <div class="row g-3 mt-3">
                <div class="col-md-6">
                    <a href="pet_add.php"
                       class="btn btn-success w-100">
                        <i class="bi bi-plus-circle"></i>
                        Add New Pet
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="pet_display.php"
                       class="btn btn-primary w-100">
                        <i class="bi bi-list"></i>
                        View All Pets
                    </a>
                </div>
            </div>
            <a href="logout.php" class="btn btn-danger mt-4">
                <i class="bi bi-box-arrow-right"></i>
                Logout
            </a>
        </div>
    </div>
</div>
<?php
include_once "footer.php";
?>