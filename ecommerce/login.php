<?php
require("connection.inc.php");
require("function.inc.php");
$loginError="";
if(isset($_POST["submit"])){
	$username=$_POST['email'];
	$password=$_POST['password'];
	$flag=true;
	$sql="SELECT * FROM `users`";
	$res=mysqli_query($conn,$sql);
	while($row=mysqli_fetch_assoc($res)){
		if($username==$row['email'] && $password==$row['password']){
			$_SESSION['ADMIN_LOGIN'] = 'yes';
			$_SESSION['ADMIN_Email'] = $username;
			redirect('admin_dashboard.php');
		}
		else{
			$loginError = '<div class="alert alert-danger" role="alert">
							 Login Failed! Incorrect username or password
							 </div>';
		}
	}
	
}

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Laravel Shop :: Administrative Panel</title>
		<!-- Google Font: Source Sans Pro -->
		<link rel="stylesheet" href="assets/https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
		<!-- Theme style -->
		<link rel="stylesheet" href="assets/css/adminlte.min.css">
		<link rel="stylesheet" href="assets/css/custom.css">
	</head>
	<body class="hold-transition login-page">
		<div class="login-box">
			<!-- /.login-logo -->
			<div class="card card-outline card-primary">
			  	<div class="card-header text-center">
					<a href="#" class="h3">Administrative Panel</a>
			  	</div>
			  	<div class="card-body">
					<p class="login-box-msg">Sign in to start your session</p>
					<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
				  		<div class="input-group mb-3">
							<input type="email" class="form-control" placeholder="Email" name="email">
							<div class="input-group-append">
					  			<div class="input-group-text">
									<span class="fas fa-envelope"></span>
					  			</div>
							</div>
				  		</div>
				  		<div class="input-group mb-3">
							<input type="password" class="form-control" placeholder="Password"name="password">
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
							<!-- /.col -->
							<div class="col-4">
					  			<button type="submit" class="btn btn-primary btn-block" name="submit">Login</button>
							</div>
							<!-- /.col -->
				  		</div>
					</form>
		  			<p class="mb-1 mt-3">
				  		<a href="forgot-password.html">I forgot my password</a>
					</p>					
			  	</div>
			  	<!-- /.card-body -->
			</div>
			<!-- /.card -->
		</div>
		<!-- ./wrapper -->
		<!-- jQuery -->
		<script src="assets/plugins/jquery/jquery.min.js"></script>
		<!-- Bootstrap 4 -->
		<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
		<!-- AdminLTE App -->
		<script src="assets/js/adminlte.min.js"></script>
		<!-- AdminLTE for demo purposes -->
		<script src="assets/js/demo.js"></script>
	</body>
</html>