<?php 

	session_start();

	if(!isset($_SESSION['login_user'])){
      header("location:index.php");
  	}
  	include('db_connect.php');
  	$nos=0;$mgs="";$err="";
  	if (isset($_POST['submit1'])) {
  		$nos=$_POST['nos'];
  		$_SESSION['nos']=$_POST['nos'];
  	}

  	if (isset($_POST["submit"])) {
  		
  		$count=1;
		for ($i=1; $i <=$_SESSION['nos'] ; $i++) { 
			$a=$count;
			$b=$a+1;
			$c=$a+2;
			$sql="insert into course(course_code,course_title,course_credit) values('$_POST[$a]','$_POST[$b]','$_POST[$c]')";
			$res=mysqli_query($conn,$sql);
			if ($res) {
				$mgs="Information of the courses successfully added";
			}
			else{
				$err="Insertion of information is unsuccessful";
			}
			$count=$c+1;
		}
	}

  ?>

<!DOCTYPE html> 
<html>
	<head> 

		<title>Add Course Information</title> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
		<link href="css/bootstrap.min.css" rel="stylesheet"> 
		<link rel="stylesheet" href="css/add_new_course.css">

	</head> 


	<body> 



		<div class="container-fluid">

			<div class="row header">
				<div class="col-lg-8 col-lg-offset-2">
					<h2>Result Management System</h2>
				</div>
				
			</div>
			<div class="navm">
				<ul>
					<li><a href="home.php">Home</a></li>
					<li><a href="make.php">Make Result</a></li>
					<li><a href="update.php">Update Result</a></li>
					<li><a href="display.php">Display Result</a></li>
					<li><a href="find.php">Find Result</a></li>
					<li><a href="add_new_student.php">Add Student</a></li>
					<li><a style="background-color: #4CAF50;color: white" href="add_new_course.php">Add Course</a></li>
				</ul>
			</div>

			<div class="col-lg-8 col-lg-offset-2">
				
				<?php 

					if (isset($_SESSION['nos'])) {
						if (isset($mgs)) {
							echo "<p id='success'>".$mgs."<p>";
						}
						else{
							echo "<p id='success' style='color:red'>".$err."<p>";
						}
					}

					if ($nos==0) {
						echo '<form id="first_form" action="" method="post" >
						<span id="p">Enter the number of courses you want to add  </span>
						<input  type="text" title="Only number allow >0" name="nos" placeholder="No of Course" pattern="[1-9]+[0-9]*" required>
						<input id="submit1" type="submit" name="submit1" value="Submit">
						</form>';
					}

				 ?>

			</div>

			<div class="col-lg-8 col-lg-offset-2">

			<form id="second_form" action="" method="post">
				
				<table>

						<?php 

							if($nos>0){

								echo "<p id='ins'>Enter Code, Title and Credit of the Courses </p>";

								echo '<tr>
									<th style="text-align: center;">Course Code</th>
									<th style="text-align: center;">Course Title</th>
									<th style="text-align: center;">Course Credit</th>
								</tr>';
							}

							$count=1;
							for ($i=1; $i <=$nos; $i++) { 
								$code=$count;
								$tittle=$code+1;
								$credit=$code+2;
								echo "<tr>
									<td><input type='text' title='Only A-z and a-z and number allow' placeholder='Code' name=$code pattern='[A-Za-z0-9]{0,10}' required></td>
									<td><input type='text' title='Only characters A-Z or a-z allow' placeholder='Title' name=$tittle pattern='[A-Za-z]{0,100}' required></td>
									<td><input type='text' title='Only fractional number 0-3 allow' placeholder='Credit' name=$credit pattern='[0-9.]{0,4}' required></td>
								</tr>";
								$count=$credit+1;
							}
							
						 ?>

				</table> 
				<?php 
					if ($nos>0) {

						echo '<input type="submit" name="submit" value="Submit"><br>';
					}
				 ?>
			</form>
			

			</div>
		</div>

		
		<script src="js/jquery-3.2.1.min.js"></script> 
	</body> 
</html>