
<?php

session_start();

// Check whether the user is logged in
if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

include_once "db.php";

$message = "";
$message_type = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get form values
    $name = trim($_POST["name"]);
    $category = $_POST["category"];
    $breed = trim($_POST["breed"]);
    $age = $_POST["age"];
    $gender = $_POST["gender"];
    $color = trim($_POST["color"]);
    $description = trim($_POST["description"]);
    $status = $_POST["status"];

    // Image is optional
    $image = "";

    // Check whether an image was uploaded
    if (isset($_FILES["pet_image"]) &&
        $_FILES["pet_image"]["error"] != 4) {

        if ($_FILES["pet_image"]["error"] == 0) {

            $file_name = $_FILES["pet_image"]["name"];
            $file_size = $_FILES["pet_image"]["size"];
            $file_tmp = $_FILES["pet_image"]["tmp_name"];

            // Get file extension
            $extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            $allowed_extensions = ["jpg", "jpeg", "png", "webp"];

            if (!in_array($extension, $allowed_extensions)) {
                $message = "Only JPG, JPEG, PNG and WEBP images are allowed!";
                $message_type = "danger";
            }
            else if ($file_size > 2 * 1024 * 1024) {
                $message = "Image size must be less than 2 MB!";
                $message_type = "danger";
            }
            else {

                // Create a unique image name
                $new_file_name = time() . "_" . basename($file_name);

                $upload_path = "uploads/pets/" . $new_file_name;

                if (move_uploaded_file($file_tmp, $upload_path)) {
                    $image = $upload_path;
                }
                else {
                    $message = "Image upload failed!";
                    $message_type = "danger";
                }
            }
        }
        else {
            $message = "There was an error uploading the image!";
            $message_type = "danger";
        }
    }

    // Insert pet details if there is no upload error
    if ($message == "") {

        $conn = get_connection();

        $sql = "INSERT INTO pets
                (name, category, breed, age, gender, color,
                 description, image, status)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param(
            "sssisssss",
            $name,
            $category,
            $breed,
            $age,
            $gender,
            $color,
            $description,
            $image,
            $status
        );

        if ($stmt->execute()) {
            $message = "Pet added successfully!";
            $message_type = "success";
        }
        else {
            $message = "Unable to add pet!";
            $message_type = "danger";
        }

        $stmt->close();
        $conn->close();
    }
}

include_once "navbar.php";

?>

<div class="container my-5">

    <div class="row justify-content-center">

        <div class="col-md-8">

            <div class="card shadow p-4">

                <h2 class="text-center mb-4">
                    <i class="bi bi-plus-circle text-success"></i>
                    Add New Pet
                </h2>

                <?php if ($message != "") { ?>

                    <div class="alert alert-<?php echo $message_type; ?>">
                        <?php echo htmlspecialchars($message); ?>
                    </div>

                <?php } ?>

                <form method="post"
                      enctype="multipart/form-data"
                      onsubmit="return validatePet();">

                    <div class="mb-3">
                        <label class="form-label">Pet Name</label>

                        <input type="text"
                               name="name"
                               id="pet_name"
                               class="form-control"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Category</label>

                        <select name="category"
                                id="category"
                                class="form-select"
                                required>

                            <option value="">Select Category</option>
                            <option value="Dog">Dog</option>
                            <option value="Cat">Cat</option>
                            <option value="Bird">Bird</option>
                            <option value="Rabbit">Rabbit</option>
                            <option value="Other">Other</option>

                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Breed</label>

                        <input type="text"
                               name="breed"
                               class="form-control"
                               placeholder="Enter breed">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Age (in years)</label>

                        <input type="number"
                               name="age"
                               id="age"
                               class="form-control"
                               min="0"
                               max="100"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Gender</label>

                        <select name="gender"
                                class="form-select"
                                required>

                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>

                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Color</label>

                        <input type="text"
                               name="color"
                               class="form-control"
                               placeholder="Enter pet color">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>

                        <textarea name="description"
                                  class="form-control"
                                  rows="4"
                                  placeholder="Enter pet description"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pet Image</label>

                        <input type="file"
                               name="pet_image"
                               id="pet_image"
                               class="form-control"
                               accept=".jpg,.jpeg,.png,.webp">
                        <small class="text-muted">
                            JPG, JPEG, PNG or WEBP. Maximum 2 MB.
                        </small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>

                        <select name="status" class="form-select">

                            <option value="Available">Available</option>
                            <option value="Not Available">Not Available</option>

                        </select>
                    </div>

                    <div class="d-grid gap-2">

                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-save"></i>
                            Add Pet
                        </button>

                        <a href="dashboard.php" class="btn btn-secondary">
                            Back to Dashboard
                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

<?php
include_once "footer.php";
?>
