<?php
session_start();
include("../db.php");

// Check admin access
if (!isset($_SESSION['user_id']) ||
    !isset($_SESSION['role']) ||
    $_SESSION['role'] != 'admin') {

    header("Location: ../login.php");
    exit();
}
    
// Fetch adoption requests
$sql = "SELECT
        adoption_requests.*,
        users.name AS user_name,
        pets.name AS pet_name

        FROM adoption_requests

        JOIN users
        ON adoption_requests.user_id = users.id

        JOIN pets
        ON adoption_requests.pet_id = pets.id

        ORDER BY adoption_requests.request_date DESC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Adoption Requests - PetCare</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

<?php include("../navbar.php"); ?>

<div class="container">

    <h2>Adoption Requests</h2>

    <table border="1" cellpadding="10">

        <tr>
            <th>Applicant Name</th>
            <th>Pet Name</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Reason</th>
            <th>Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>

        <tr>

            <td>
                <?php echo htmlspecialchars($row['user_name']); ?>
            </td>

            <td>
                <?php echo htmlspecialchars($row['pet_name']); ?>
            </td>

            <td>
                <?php echo htmlspecialchars($row['phone']); ?>
            </td>

            <td>
                <?php echo htmlspecialchars($row['address']); ?>
            </td>

            <td>
                <?php echo htmlspecialchars($row['reason']); ?>
            </td>

            <td>
                <?php echo $row['request_date']; ?>
            </td>

            <td>
                <?php echo ucfirst($row['status']); ?>
            </td>

            <td>

                <?php if ($row['status'] == 'pending') { ?>

                    <form action="update_status.php" method="POST">

                        <input type="hidden" name="request_id"
                               value="<?php echo $row['id']; ?>">

                        <button type="submit"
                                name="status"
                                value="approved">
                            Approve
                        </button>

                        <button type="submit"
                                name="status"
                                value="rejected">
                            Reject
                        </button>

                    </form>

                <?php } else { ?>

                    Completed

                <?php } ?>

            </td>

        </tr>

        <?php } ?>

    </table>

</div>

<?php include("../footer.php"); ?>

</body>
</html>