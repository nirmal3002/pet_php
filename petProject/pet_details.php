<?php
session_start();
include_once "db.php";
$conn = get_connection();
$pet = null;
$message = "";
// Get pet ID from URL
if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
    $id = $_GET["id"];
    // Retrieve selected pet
    $sql = "SELECT * FROM pets WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $pet = $result->fetch_assoc();
    }
    else {
        $message = "Pet record not found!";
    }
    $stmt->close();
}
else {
    $message = "Invalid pet ID!";
}
$conn->close();
include_once "navbar.php";
?>
<div class="container my-5">
    <?php if ($pet != null) { ?>
        <div class="row justify-content-center">
            <div class="col-md-9 col-lg-8">
                <div class="card shadow border-0">
                    <div class="row g-0">
                        <!-- Pet Image -->
                        <div class="col-md-5">
                            <?php if (!empty($pet["image"]) &&
                                      file_exists(__DIR__ . "/" . $pet["image"])) { ?>
                                <img src="<?php echo htmlspecialchars($pet["image"]); ?>"
                                     alt="<?php echo htmlspecialchars($pet["name"]); ?>"
                                     class="img-fluid rounded-start pet-details-image">
                            <?php } else { ?>
                                <div class="bg-light d-flex justify-content-center align-items-center pet-details-image">
                                    <i class="bi bi-image text-secondary"
                                       style="font-size: 70px;"></i>
                                </div>
                            <?php } ?>
                        </div>
                        <!-- Pet Details -->
                        <div class="col-md-7">
                            <div class="card-body p-4">
                                <h2 class="fw-bold text-success mb-3">
                                    <?php echo htmlspecialchars($pet["name"]); ?>
                                </h2>
                                <p>
                                    <strong>Category:</strong>
                                    <?php echo htmlspecialchars($pet["category"]); ?>
                                </p>
                                <p>
                                    <strong>Breed:</strong>
                                    <?php echo htmlspecialchars($pet["breed"] ?? "Not specified"); ?>
                                </p>
                                <p>
                                    <strong>Age:</strong>
                                    <?php
                                    echo htmlspecialchars(
                                        $pet["age"] !== null ? $pet["age"] . " years" : "Not specified"
                                    );
                                    ?>
                                </p>
                                <p>
                                    <strong>Gender:</strong>
                                    <?php echo htmlspecialchars($pet["gender"] ?? "Not specified"); ?>
                                </p>
                                <p>
                                    <strong>Color:</strong>
                                    <?php echo htmlspecialchars($pet["color"] ?? "Not specified"); ?>
                                </p>
                                <p>
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
                                <hr>
                                <h5 class="fw-bold">Description</h5>
                                <p class="text-muted">
                                    <?php
                                    echo nl2br(htmlspecialchars(
                                        $pet["description"] ?? "No description available."
                                    ));
                                    ?>
                                </p>
                                <p class="small text-muted">
                                    <strong>Added On:</strong>
                                    <?php echo htmlspecialchars($pet["created_at"]); ?>
                                </p>
                                <!-- Buttons -->
                                <div class="d-flex flex-wrap gap-2 mt-4">
                                    <a href="pet_display.php"
                                       class="btn btn-secondary">
                                        <i class="bi bi-arrow-left"></i>
                                        Back to Pets
                                    </a>
                                    <?php if (isset($_SESSION["id"])) { ?>
                                        <a href="pet_update.php?id=<?php echo $pet["id"]; ?>"
                                           class="btn btn-success">
                                            <i class="bi bi-pencil"></i>
                                            Edit Pet
                                        </a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <div class="alert alert-danger text-center">
            <i class="bi bi-exclamation-circle"></i>
            <?php echo htmlspecialchars($message); ?>
            <br>
            <a href="pet_display.php" class="btn btn-success mt-3">
                Back to Pets
            </a>
        </div>
    <?php } ?>
</div>
<?php
include_once "footer.php";
?>