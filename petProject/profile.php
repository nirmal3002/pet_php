<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}
include_once "db.php";
$conn = get_connection();
$user_id = $_SESSION["id"];
$message = "";
$message_type = "";
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
}
else {
    $conn->close();
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}
$stmt->close();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_password = $_POST["current_password"];
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];
    if ($current_password != $user["password"]) {
        $message = "Current password is incorrect!";
        $message_type = "danger";
    }
    else if (strlen($new_password) < 8) {
        $message = "New password must contain at least 8 characters!";
        $message_type = "danger";

    }
    else if ($new_password != $confirm_password) {
        $message = "New password and confirm password do not match!";
        $message_type = "danger";

    }
    else {
        $hashed_password = $new_password;
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $hashed_password, $user_id);
        if ($stmt->execute()) {
            $message = "Password changed successfully!";
            $message_type = "success";
            $user["password"] = $hashed_password;
        }
        else {
            $message = "Unable to change password!";
            $message_type = "danger";
        }
        $stmt->close();
    }
}
$conn->close();
include_once "navbar.php";
?>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <i class="bi bi-person-circle text-success"
                           style="font-size: 70px;"></i>
                        <h2 class="fw-bold mt-2">
                            My Profile
                        </h2>
                        <p class="text-muted">
                            View your account information.
                        </p>
                    </div>
                    <?php if ($message != "") { ?>
                        <div class="alert alert-<?php echo $message_type; ?>">
                            <?php echo htmlspecialchars($message); ?>
                        </div>
                    <?php } ?>
                    <!-- User Information -->
                    <h5 class="fw-bold text-success mb-3">
                        Account Information
                    </h5>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Name</label>
                        <input type="text"
                               class="form-control"
                               value="<?php echo htmlspecialchars($user["name"]); ?>"
                               readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Mobile</label>
                        <input type="text"
                               class="form-control"
                               value="<?php echo htmlspecialchars($user["mobile"]); ?>"
                               readonly>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Email</label>
                        <input type="email"
                               class="form-control"
                               value="<?php echo htmlspecialchars($user["email"]); ?>"
                               readonly>
                    </div>
                    <hr>
                    <!-- Change Password Form -->
                    <h5 class="fw-bold text-success mb-3">
                        Change Password
                    </h5>
                    <form method="POST" onsubmit="return validatePasswordChange();">
                        <div class="mb-3">
                            <label class="form-label">
                                Current Password
                            </label>
                            <input type="password"
                                   name="current_password"
                                   class="form-control"
                                   required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                New Password
                            </label>
                            <input type="password"
                                   name="new_password"
                                   id="new_password"
                                   class="form-control"
                                   minlength="8"
                                   required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                Confirm New Password
                            </label>
                            <input type="password"
                                   name="confirm_password"
                                   id="confirm_password"
                                   class="form-control"
                                   minlength="8"
                                   required>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit"
                                    class="btn btn-success">
                                <i class="bi bi-key"></i>
                                Change Password
                            </button>
                            <a href="dashboard.php"
                               class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i>
                                Back to Dashboard
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include_once "footer.php";
?>