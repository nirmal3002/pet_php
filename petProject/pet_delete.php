<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}
// Accept only POST requests
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: pet_display.php");
    exit();
}
// Check pet ID
if (!isset($_POST["id"]) || !is_numeric($_POST["id"])) {
    header("Location: pet_display.php");
    exit();
}
$id = $_POST["id"];
include_once "db.php";
$conn = get_connection();
// First, get the pet image path
$sql = "SELECT image FROM pets WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $pet = $result->fetch_assoc();
    $image = $pet["image"];
    $stmt->close();
    // Delete pet record from database
    $sql = "DELETE FROM pets WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        // Delete uploaded image if it belongs to upload/pets
        if (!empty($image) &&
            strpos($image, "upload/pets/") === 0) {
            $image_path = __DIR__ . "/upload/pets/" . basename($image);
            if (is_file($image_path)) {
                unlink($image_path);
            }
        }
        $stmt->close();
        $conn->close();
        header("Location: pet_display.php?message=deleted");
        exit();
    }
    else {
        $stmt->close();
        $conn->close();
        die("Unable to delete pet record!");
    }
}
else {
    $stmt->close();
    $conn->close();
    header("Location: pet_display.php?message=notfound");
    exit();
}
?>