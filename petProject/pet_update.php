<?php
session_start();
// Check login
if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}
include_once "db.php";
$conn = get_connection();
$message = "";
$pet = null;
// Get pet ID
if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
    $id = $_GET["id"];
}
else {
    die("Invalid Pet ID!");
}
// Retrieve existing pet details
$sql = "SELECT * FROM pets WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $pet = $result->fetch_assoc();
}
else {
    die("Pet record not found!");
}
$stmt->close();
// Update pet information
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $category = $_POST["category"];
    $breed = trim($_POST["breed"]);
    $age = $_POST["age"];
    $gender = $_POST["gender"];
    $color = trim($_POST["color"]);
    $description = trim($_POST["description"]);
    $status = $_POST["status"];
    // Keep existing image
    $image = $pet["image"];
    // Check whether a new image is selected
    if (isset($_FILES["pet_image"]) &&
        $_FILES["pet_image"]["error"] != 4) {
        if ($_FILES["pet_image"]["error"] == 0) {
            $file_name = $_FILES["pet_image"]["name"];
            $file_size = $_FILES["pet_image"]["size"];
            $file_tmp = $_FILES["pet_image"]["tmp_name"];
            $extension = strtolower(
                pathinfo($file_name, PATHINFO_EXTENSION)
            );
            $allowed_extensions = ["jpg", "jpeg", "png", "webp"];
            if (!in_array($extension, $allowed_extensions)) {
                $message = "Only JPG, JPEG, PNG and WEBP images are allowed!";
            }
            else if ($file_size > 2 * 1024 * 1024) {
                $message = "Image size must be less than 2 MB!";
            }
            else {
                $upload_dir = __DIR__ . "/upload/pets/";
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                $new_file_name = time() . "_" . basename($file_name);
                $destination = $upload_dir . $new_file_name;
                if (move_uploaded_file($file_tmp, $destination)) {
                    $image = "upload/pets/" . $new_file_name;
                }
                else {
                    $message = "Image upload failed!";
                }
            }
        }
        else {
            $message = "There was an error uploading the image!";
        }
    }
    // Update database if there is no error
    if ($message == "") {
        $sql = "UPDATE pets SET
                name = ?,
                category = ?,
                breed = ?,
                age = ?,
                gender = ?,
                color = ?,
                description = ?,
                image = ?,
                status = ?
                WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "sssisssssi",
            $name,
            $category,
            $breed,
            $age,
            $gender,
            $color,
            $description,
            $image,
            $status,
            $id
        );
        if ($stmt->execute()) {
            // Delete previous image if a replacement was uploaded
            if ($image != $pet["image"] &&
                !empty($pet["image"]) &&
                file_exists(__DIR__ . "/" . $pet["image"])) {
                unlink(__DIR__ . "/" . $pet["image"]);
            }
            $stmt->close();
            $conn->close();
            header("Location: pet_details.php?id=" . $id);
            exit();
        }
        else {
            $message = "Unable to update pet information!";
        }
        $stmt->close();
    }
    // Keep entered values in the form if an error occurs
    $pet["name"] = $name;
    $pet["category"] = $category;
    $pet["breed"] = $breed;
    $pet["age"] = $age;
    $pet["gender"] = $gender;
    $pet["color"] = $color;
    $pet["description"] = $description;
    $pet["status"] = $status;
}

include_once "navbar.php";
?>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow p-4">
                <h2 class="text-center fw-bold mb-4">
                    <i class="bi bi-pencil-square text-success"></i>
                    Update Pet Information
                </h2>
                <?php if ($message != "") { ?>
                    <div class="alert alert-danger">
                        <?php echo htmlspecialchars($message); ?>
                    </div>
                <?php } ?>
                <form method="post"
                      enctype="multipart/form-data"
                      onsubmit="return validatePet();">
                    <!-- Pet Name -->
                    <div class="mb-3">
                        <label class="form-label">Pet Name</label>
                        <input type="text"
                               name="name"
                               id="pet_name"
                               class="form-control"
                               value="<?php echo htmlspecialchars($pet["name"]); ?>"
                               required>
                    </div>
                    <!-- Category -->
                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select name="category"
                                id="category"
                                class="form-select"
                                required>
                            <option value="">Select Category</option>
                            <option value="Dog" <?php if ($pet["category"] == "Dog") echo "selected"; ?>>
                                Dog
                            </option>
                            <option value="Cat" <?php if ($pet["category"] == "Cat") echo "selected"; ?>>
                                Cat
                            </option>
                            <option value="Bird" <?php if ($pet["category"] == "Bird") echo "selected"; ?>>
                                Bird
                            </option>
                            <option value="Rabbit" <?php if ($pet["category"] == "Rabbit") echo "selected"; ?>>
                                Rabbit
                            </option>
                            <option value="Other" <?php if ($pet["category"] == "Other") echo "selected"; ?>>
                                Other
                            </option>
                        </select>
                    </div>
                    <!-- Breed -->
                    <div class="mb-3">
                        <label class="form-label">Breed</label>
                        <input type="text"
                               name="breed"
                               class="form-control"
                               value="<?php echo htmlspecialchars($pet["breed"] ?? ""); ?>">
                    </div>
                    <!-- Age -->
                    <div class="mb-3">
                        <label class="form-label">Age (in years)</label>
                        <input type="number"
                               name="age"
                               id="age"
                               class="form-control"
                               min="0"
                               max="100"
                               value="<?php echo htmlspecialchars($pet["age"] ?? ""); ?>"
                               required>
                    </div>
                    <!-- Gender -->
                    <div class="mb-3">
                        <label class="form-label">Gender</label>
                        <select name="gender" class="form-select" required>
                            <option value="">Select Gender</option>
                            <option value="Male" <?php if ($pet["gender"] == "Male") echo "selected"; ?>>
                                Male
                            </option>
                            <option value="Female" <?php if ($pet["gender"] == "Female") echo "selected"; ?>>
                                Female
                            </option>
                        </select>
                    </div>
                    <!-- Color -->
                    <div class="mb-3">
                        <label class="form-label">Color</label>
                        <input type="text"
                               name="color"
                               class="form-control"
                               value="<?php echo htmlspecialchars($pet["color"] ?? ""); ?>">
                    </div>
                    <!-- Description -->
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description"
                                  class="form-control"
                                  rows="4"><?php echo htmlspecialchars($pet["description"] ?? ""); ?></textarea>
                    </div>
                    <!-- Existing Image -->
                    <div class="mb-3">
                        <label class="form-label">Current Pet Image</label>
                        <div>
                            <?php if (!empty($pet["image"]) &&
                                      file_exists(__DIR__ . "/" . $pet["image"])) { ?>
                                <img src="<?php echo htmlspecialchars($pet["image"]); ?>"
                                     alt="Current pet image"
                                     class="img-thumbnail"
                                     style="width:150px; height:130px; object-fit:contain;">
                            <?php } else { ?>
                                <p class="text-muted">No image available.</p>
                            <?php } ?>
                        </div>
                    </div>
                    <!-- New Image -->
                    <div class="mb-3">
                        <label class="form-label">Choose New Image</label>
                        <input type="file"
                               name="pet_image"
                               class="form-control"
                               accept=".jpg,.jpeg,.png,.webp">
                        <small class="text-muted">
                            Leave empty to keep the current image.
                            Maximum size: 2 MB.
                        </small>
                    </div>
                    <!-- Status -->
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="Available"
                                <?php if ($pet["status"] == "Available") echo "selected"; ?>>
                                Available
                            </option>
                            <option value="Not Available"
                                <?php if ($pet["status"] == "Not Available") echo "selected"; ?>>
                                Not Available
                            </option>
                        </select>
                    </div>
                    <!-- Buttons -->
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-save"></i>
                            Update Pet
                        </button>
                        <a href="pet_details.php?id=<?php echo $id; ?>"
                           class="btn btn-secondary">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
$conn->close();
include_once "footer.php";
?>