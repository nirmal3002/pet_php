<?php
session_start();
include("../db.php");

// Check login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user_id = $_SESSION['user_id'];
    $pet_id = intval($_POST['pet_id']);

    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $reason = trim($_POST['reason']);

    if (empty($phone) || empty($address) || empty($reason)) {
        die("Please fill all the fields.");
    }

    // Check pet availability
    $sql = "SELECT id FROM pets
            WHERE id = ? AND status = 'available'";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $pet_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 0) {
        die("This pet is not available.");
    }

    // Check duplicate request
    $sql = "SELECT id FROM adoption_requests
            WHERE user_id = ? AND pet_id = ?
            AND status IN ('pending', 'approved')";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $user_id, $pet_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        die("You have already submitted a request for this pet.");
    }

    // Insert adoption request
    $sql = "INSERT INTO adoption_requests
            (user_id, pet_id, phone, address, reason)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "iisss",
        $user_id,
        $pet_id,
        $phone,
        $address,
        $reason
    );

    if (mysqli_stmt_execute($stmt)) {

        echo "<script>
                alert('Adoption request submitted successfully!');
                window.location.href='../dashboard.php';
              </script>";

    } else {
        echo "Something went wrong. Please try again.";
    }

} else {
    header("Location: ../index.php");
    exit();
}
?>