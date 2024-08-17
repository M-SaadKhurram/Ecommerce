<?php
require("connection.inc.php");
require("function.inc.php");

$loginError = "";

if (isset($_POST["submit"])) {
    $username = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);

    // Retrieve user data
    $sql = "SELECT * FROM `users` WHERE `email` = '$username' AND `password` = '$password'";
    $res = $conn->query($sql);

    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $user_name = $row['firstname']; // Fetch the first name from the row
        $user_id = $row['id']; // Fetch the first name from the row
        
        
        // Check for admin login
        if ($row['role'] == 1) {
            $_SESSION['ADMIN_LOGIN'] = 'yes';
            $_SESSION['ADMIN_Email'] = $username;
            header('Location: admin_dashboard.php');
            exit();
        }
        // Check for user login
        elseif ($row['role'] == 2) {
            $_SESSION['USER_ID'] = $user_id;

            $_SESSION['USER_Name'] = $user_name;
            $_SESSION['USER_LOGIN'] = 'yes';
            $_SESSION['USER_Email'] = $username;
             header('Location: cart.php');
            exit();
        }
    } else {
        // If password verification fails
        $loginError = '<div class="alert alert-danger" role="alert">
                        Login Failed! Incorrect username or password.
                    </div>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="assets/css/adminlte.min.css">
    <link rel="stylesheet" href="assets/css/custom.css">
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="#" class="h3">Login Panel</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Sign in to continue</p>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <?php echo $loginError; ?>
                            </div>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block" name="submit">Login</button>
                        </div>
                    </div>
                </form>
                <p class="mb-1 mt-3">
                    <a href="Singup.php">Signup</a>
                </p>
            </div>
        </div>
    </div>
    <script src="assets/plugins/jquery/jquery.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/adminlte.min.js"></script>
</body>
</html>
