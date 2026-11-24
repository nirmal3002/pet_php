<?php
session_start();
include_once "db.php";
$conn = get_connection();
$sql = "SELECT * FROM pets ORDER BY id DESC";
$result = $conn->query($sql);
include_once "navbar.php";
?>
<div class="container my-5">
    <div class="text-center mb-4">
        <h2 class="fw-bold">
            <i class="bi bi-heart-fill text-success"></i>
            Our Pets
        </h2>
        <p class="text-muted">
            Explore all the pets registered in our system.
        </p>
    </div>
    <!-- Search Section -->
    <div class="row mb-4">
        <div class="col-md-6 mx-auto">
            <form action="search_result.php" method="GET">
                <div class="input-group">
                    <input type="text"
                           name="search"
                           class="form-control"
                           placeholder="Search by pet name or category..."
                           required>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-search"></i>
                        Search
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!-- Add Pet Button -->
    <?php if (isset($_SESSION["id"])) { ?>
        <div class="text-end mb-4">
            <a href="pet_add.php" class="btn btn-success">
                <i class="bi bi-plus-circle"></i>
                Add New Pet
            </a>
        </div>
    <?php } ?>
    <!-- Pet Cards -->
    <div class="row g-4">
        <?php if ($result->num_rows > 0) { ?>
            <?php while ($pet = $result->fetch_assoc()) { ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-sm h-100">
                        <!-- Pet Image -->
                        <?php if (!empty($pet["image"]) &&
                                  file_exists(__DIR__ . "/" . $pet["image"])) { ?>
                            <img src="<?php echo htmlspecialchars($pet["image"]); ?>"
                                class="card-img-top"
                                alt="<?php echo htmlspecialchars($pet["name"]); ?>">
                        <?php } else { ?>
                            <div class="bg-light d-flex align-items-center justify-content-center"
                                 style="height:220px;">
                                <i class="bi bi-image text-secondary"
                                   style="font-size:60px;"></i>
                            </div>
                        <?php } ?>
                        <!-- Pet Information -->
                        <div class="card-body">
                            <h4 class="card-title fw-bold">
                                <?php echo htmlspecialchars($pet["name"]); ?>
                            </h4>
                            <p class="text-muted mb-2">
                                <i class="bi bi-tag"></i>
                                <?php echo htmlspecialchars($pet["category"]); ?>
                            </p>
                            <p class="mb-2">
                                <strong>Breed:</strong>
                                <?php echo htmlspecialchars($pet["breed"] ?? "Not specified"); ?>
                            </p>
                            <p class="mb-2">
                                <strong>Age:</strong>
                                <?php
                                echo htmlspecialchars(
                                    $pet["age"] !== null ? $pet["age"] . " years" : "Not specified"
                                );
                                ?>
                            </p>
                            <p class="mb-3">
                                <strong>Status:</strong>
                                <?php if ($pet["status"] == "Available") { ?>
                                    <span class="badge bg-success">
                                        Available
                                    </span>
                                <?php } else { ?>
                                    <span class="badge bg-secondary">
                                        <?php echo htmlspecialchars($pet["status"]); ?>
                                    </span>
                                <?php } ?>
                            </p>
                            <!-- Action Buttons -->
                            <div class="d-flex flex-wrap gap-2">
                                <a href="pet_details.php?id=<?php echo $pet["id"]; ?>"
                                   class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-eye"></i>
                                    View Details
                                </a>
                                <?php if (isset($_SESSION["id"])) { ?>
                                    <a href="pet_update.php?id=<?php echo $pet["id"]; ?>"
                                       class="btn btn-outline-success btn-sm">
                                        <i class="bi bi-pencil"></i>
                                        Edit
                                    </a>
                                    <form action="pet_delete.php" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this pet?');">
                                        <input type="hidden"
                                            name="id"
                                            value="<?php echo $pet["id"]; ?>">
                                        <button type="submit" class="btn btn-outline-danger btn-sm">
                                            <i class="bi bi-trash"></i>
                                            Delete
                                        </button>
                                    </form>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } else { ?>
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="bi bi-info-circle"></i>
                    No pets found in the database.
                    <?php if (isset($_SESSION["id"])) { ?>
                        <br>
                        <a href="pet_add.php" class="btn btn-success mt-3">
                            Add Your First Pet
                        </a>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<?php if (isset($_GET["message"]) && $_GET["message"] == "deleted") { ?>
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle"></i>
        Pet deleted successfully!
        <button type="button"
                class="btn-close"
                data-bs-dismiss="alert"></button>
    </div>
<?php } ?>
<?php if (isset($_GET["message"]) && $_GET["message"] == "notfound") { ?>
    <div class="alert alert-warning alert-dismissible fade show">
        Pet record not found!
        <button type="button"
                class="btn-close"
                data-bs-dismiss="alert"></button>
    </div>
<?php } ?>
<?php
$conn->close();
include_once "footer.php";
?>