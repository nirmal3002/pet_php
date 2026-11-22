<?php
$msg = "";
$error = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "db.php";
    $name = $_POST["name"];
    $mobile = $_POST["mobile"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    try {
        $conn = get_connection();
        // Check whether email already exists
        $sql = "SELECT id FROM users WHERE email = ?";
        $ps = $conn->prepare($sql);
        $ps->bind_param("s", $email);
        $ps->execute();
        $rs = $ps->get_result();
        if ($rs->num_rows > 0) {
            $msg = "Email already registered!";
            $error = true;
        } else {
            // Encrypt password before storing
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users(name, mobile, email, password)
                    VALUES(?,?,?,?)";
            $ps = $conn->prepare($sql);
            $ps->bind_param(
                "ssss",
                $name,
                $mobile,
                $email,
                $hashed_password
            );
            if ($ps->execute()) {
                $msg = "Registration Successful! Please Login.";
                $error = false;
            }
        }
        $conn->close();
    }
    catch (mysqli_sql_exception $se) {
        $msg = "Database Error: " . $se->getMessage();
        $error = true;
    }
}
include_once "navbar.php";
?>
<div class="container my-5">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h3 class="text-center">User Registration</h3>
                </div>
                <div class="card-body">
                    <?php if ($msg != "") { ?>
                        <div class="alert alert-<?php echo $error ? "danger" : "success"; ?>">
                            <?php echo htmlspecialchars($msg); ?>
                        </div>
                    <?php } ?>
                    <form action="register.php" method="post"
                          onsubmit="return validateRegistration()">
                        <label class="form-label">Full Name</label>
                        <input type="text"
                               name="name"
                               id="name"
                               class="form-control mb-3"
                               required>
                        <label class="form-label">Mobile Number</label>
                        <input type="text"
                               name="mobile"
                               id="mobile"
                               class="form-control mb-3"
                               maxlength="10"
                               required>
                        <label class="form-label">Email Address</label>
                        <input type="email"
                               name="email"
                               class="form-control mb-3"
                               required>
                        <label class="form-label">Password</label>
                        <input type="password"
                               name="password"
                               id="password"
                               class="form-control mb-3"
                               required>
                        <label class="form-label">Confirm Password</label>
                        <input type="password"
                               id="confirm_password"
                               class="form-control mb-3"
                               required>
                        <button type="submit" class="btn btn-success w-100">
                            Register
                        </button>
                    </form>
                    <p class="text-center mt-3">
                        Already have an account?
                        <a href="login.php">Login Here</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include_once "footer.php";
?>