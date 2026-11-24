<?php
session_start();
$msg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "db.php";
    $email = $_POST["email"];
    $password = $_POST["password"];
    try {
        $conn = get_connection();
        $sql = "SELECT * FROM users WHERE email = ?";
        $ps = $conn->prepare($sql);
        $ps->bind_param("s", $email);
        $ps->execute();
        $rs = $ps->get_result();
        if ($rs->num_rows == 1) {
            $user = $rs->fetch_assoc();
            // Check password
            if($password == $user["password"]) {
                $_SESSION["id"] = $user["id"];
                $_SESSION["name"] = $user["name"];
                $_SESSION["email"] = $user["email"];
                header("Location: dashboard.php");
                exit();
            } else {
                $msg = "Invalid Email or Password!";
            }
        } else {
            $msg = "Invalid Email or Password!";
        }
        $conn->close();
    }
    catch (mysqli_sql_exception $se) {
        $msg = "Database Error: " . $se->getMessage();
    }
}
include_once "navbar.php";
?>
<div class="container my-5">
    <div class="row">
        <div class="col-md-5 mx-auto">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h3 class="text-center">User Login</h3>
                </div>
                <div class="card-body">
                    <?php if ($msg != "") { ?>
                        <div class="alert alert-danger">
                            <?php echo htmlspecialchars($msg); ?>
                        </div>
                    <?php } ?>
                    <form action="login.php" method="post">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control mb-3">
                        <button type="submit" class="btn btn-success w-100">Login</button>
                    </form>
                    <p class="text-center mt-3">
                        Don't have an account?
                        <a href="register.php">Register Here</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include_once "footer.php";
?>