<?php 

	session_start();

	if(isset($_SESSION['login_user'])){

		header("location:home.php");
  	}

	include('db_connect.php');
	$log_in_error="";
	$email="";
	$password="";

	if(isset($_POST["submit"])){

		$email=mysqli_real_escape_string($conn,$_POST["email"]);
		$password=mysqli_real_escape_string($conn,$_POST["password"]);
		$sql="Select id from admin where admin_email='$email' and admin_password='$password'";
		$result = mysqli_query($conn, $sql);

		if (mysqli_num_rows($result)) {

			$_SESSION['login_user']=$email;
		    header('location:home.php');
		}
		else
			$log_in_error="Incorrect Email & Password";
	}
 ?>


<!DOCTYPE html> 
<html>
	<head> 
		<title>Log In</title> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
		<link href="css/bootstrap.min.css" rel="stylesheet"> 
		<link rel="stylesheet" href="css/index.css">
	</head> 


	<body> 

		<div class="container-fluid">

			<div class="row header">
				<div class="col-lg-8 col-lg-offset-2">
					<h2>Result Management System</h2>
				</div>
			</div>


			<div class="row">
				<div class="col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4 col-xs-12">
					<p style='color:red;'><?php echo $log_in_error ?></p>
				</div>
			</div>
			<form action="" method="post">
				<div class="row">
					<div class="col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4 col-xs-12">
						<input type="email" name="email" placeholder="Enter Email" required>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4 col-xs-12">
						<input type="password" name="password" placeholder="Enter Password" required>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4 col-xs-12">
						<input type="submit" name="submit" value="Log In">
					</div>
				</div>
			</form>

		</div>


		<script src="js/jquery-3.2.1.min.js"></script> 
	</body> 
</html>