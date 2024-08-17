<?php
require("connection.inc.php");
require("function.inc.php");

$signupError = "";
$signupSuccess = "";

if (isset($_POST["submit"])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $address = $_POST['address'];
    $contact_info = $_POST['contact_info'];
    $role = 2; // Default role for regular users
    $status = 1; // Assuming 1 means active
    $photo = ''; // Placeholder for photo upload feature
    $activate_code = '';
    $reset_code = '';
    $created_on = date('Y-m-d');

    // Check if passwords match
    if ($password !== $confirm_password) {
        $signupError = '<div class="alert alert-danger" role="alert">
                            Passwords do not match!
                        </div>';
    } else {
        // Check if the email already exists
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $res = mysqli_query($conn, $sql);

        if (mysqli_num_rows($res) > 0) {
            $signupError = '<div class="alert alert-danger" role="alert">
                                Email is already registered!
                            </div>';
        } else {
            // Hash the password
            $hashed_password = $password; // Use md5 for simplicity, but consider a stronger hashing method like password_hash()

            // Insert new user into the database
            $sql = "INSERT INTO users (email, password, firstname, lastname, address, contact_info, role, status, photo, activate_code, reset_code, created_on)
                    VALUES ('$email', '$hashed_password', '$firstname', '$lastname', '$address', '$contact_info', '$role', '$status', '$photo', '$activate_code', '$reset_code', '$created_on')";

            if (mysqli_query($conn, $sql)) {
                $signupSuccess = '<div class="alert alert-success" role="alert">
                                    Registration successful! You can now <a href="login.php">login</a>.
                                  </div>';
            } else {
                $signupError = '<div class="alert alert-danger" role="alert">
                                    Something went wrong! Please try again.
                                </div>';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Shop :: Signup</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="assets/https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="assets/css/adminlte.min.css">
    <link rel="stylesheet" href="assets/css/custom.css">
</head>
<body class="hold-transition register-page">
<div class="register-box">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="#" class="h3">Register a New Membership</a>
        </div>
        <div class="card-body">
            <p class="login-box-msg">Fill in the details below to create your account</p>
            <?php echo $signupError; ?>
            <?php echo $signupSuccess; ?>
            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="First Name" name="firstname" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Last Name" name="lastname" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="email" class="form-control" placeholder="Email" name="email" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Password" name="password" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Confirm Password" name="confirm_password" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Address" name="address" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-home"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Contact Info" name="contact_info" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-phone"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <?php echo $signupError; ?>
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block" name="submit">Sign Up</button>
                    </div>
                </div>
            </form>
            <p class="mb-1 mt-3">
                <a href="login.php">Already have an account? Login here</a>
            </p>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="assets/js/adminlte.min.js"></script>
</body>
</html>
