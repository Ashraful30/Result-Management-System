<?php 
	
	session_start();

	if(isset($_POST["submit"])){
		unset($_SESSION['login_user']);
		session_destroy(); 
		header("location:index.php"); 
	}

 ?>

 <!DOCTYPE html>

 <html>
 	<head>
	 	<title>Result Management System</title>
	 	<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
		<link href="css/bootstrap.min.css" rel="stylesheet"> 
	 	<link rel="stylesheet" href="css/home.css">
 	</head>

 <body>


 	<div class="container-fluid">
			<div class="row header">

				<?php include('log_out.php'); ?>

				<!-- <form action="" method="post">
					<input type="submit" name='submit' value="Log out">
				</form> -->

				<div class="col-lg-8 col-lg-offset-2">
					<h2>Result Management System</h2>

				</div>

			</div>

			<div class="menu col-lg-6 col-lg-offset-3">
				<ul>
					<li><a href="make.php">Make Result</a></li>
					<li><a href="update.php">Update Result</a></li>
					<li><a href="display.php">Display Result</a></li>
					<li><a href="find.php">Find Result</a></li>
					<li><a href="add_new_student.php">Add Student Information</a></li>
					<li><a href="add_new_course.php">Add Course Information</a></li>
				</ul>
			</div>
	</div>


 	<script src="js/jquery-3.2.1.min.js"></script> 
 </body>
 </html>