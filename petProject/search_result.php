<?php
session_start();
include_once "db.php";
$conn = get_connection();
$search = "";
$result = null;
$message = "";
// Check whether search value is received
if (isset($_GET["search"])) {
    $search = trim($_GET["search"]);
    if ($search != "") {
        // Search pet by name or category
        $sql = "SELECT * FROM pets
                WHERE name LIKE ? OR category LIKE ?
                ORDER BY id DESC";
        $stmt = $conn->prepare($sql);
        $search_value = "%" . $search . "%";
        $stmt->bind_param("ss", $search_value, $search_value);
        $stmt->execute();
        $result = $stmt->get_result();
    }
    else {
        $message = "Please enter a pet name or category!";
    }
}
else {
    $message = "Please enter something to search!";
}
include_once "navbar.php";
?>
<div class="container my-5">
    <!-- Page Heading -->
    <div class="text-center mb-4">
        <h2 class="fw-bold">
            <i class="bi bi-search text-success"></i>
            Search Results
        </h2>
        <p class="text-muted">
            Find pets by name or category.
        </p>
    </div>
    <!-- Search Form -->
    <div class="row mb-4">
        <div class="col-md-6 mx-auto">
            <form action="search_result.php" method="GET">
                <div class="input-group">
                    <input type="text"
                           name="search"
                           class="form-control"
                           placeholder="Search pets..."
                           value="<?php echo htmlspecialchars($search); ?>"
                           required>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-search"></i>
                        Search
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!-- Search Message -->
    <?php if ($message != "") { ?>
        <div class="alert alert-warning text-center">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php } ?>
    <!-- Results -->
    <?php if ($result != null) { ?>
        <?php if ($result->num_rows > 0) { ?>
            <h5 class="mb-4">
                Search results for:
                <span class="text-success">
                    <?php echo htmlspecialchars($search); ?>
                </span>
                <span class="text-muted">
                    (<?php echo $result->num_rows; ?> pets found)
                </span>
            </h5>
            <div class="row g-4">
                <?php while ($pet = $result->fetch_assoc()) { ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card shadow-sm h-100">
                            <!-- Pet Image -->
                            <?php if (!empty($pet["image"]) &&
                                      file_exists(__DIR__ . "/" . $pet["image"])) { ?>
                                <img src="<?php echo htmlspecialchars($pet["image"]); ?>"
                                     class="card-img-top"
                                     alt="<?php echo htmlspecialchars($pet["name"]); ?>"
                                     style="height:220px; object-fit:contain; background-color:#fff;">
                            <?php } else { ?>
                                <div class="bg-light d-flex justify-content-center align-items-center"
                                     style="height:220px;">
                                    <i class="bi bi-image text-secondary"
                                       style="font-size:60px;"></i>
                                </div>
                            <?php } ?>
                            <!-- Pet Information -->
                            <div class="card-body">
                                <h4 class="card-title fw-bold text-success">
                                    <?php echo htmlspecialchars($pet["name"]); ?>
                                </h4>
                                <p class="mb-2">
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
                                        <form action="pet_delete.php"
                                              method="POST"
                                              onsubmit="return confirm('Are you sure you want to delete this pet?');">
                                            <input type="hidden"
                                                   name="id"
                                                   value="<?php echo $pet["id"]; ?>">
                                            <button type="submit"
                                                    class="btn btn-outline-danger btn-sm">
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
            </div>
        <?php } else { ?>
            <div class="alert alert-info text-center">
                <i class="bi bi-info-circle"></i>
                No pets found matching
                <strong><?php echo htmlspecialchars($search); ?></strong>.
            </div>
        <?php } ?>
    <?php } ?>
    <!-- Back Button -->
    <div class="text-center mt-5">
        <a href="pet_display.php" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i>
            Back to All Pets
        </a>
    </div>
</div>
<?php
if ($result != null) {
    $stmt->close();
}
$conn->close();
include_once "footer.php";
?>