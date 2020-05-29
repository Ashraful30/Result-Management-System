<?php 

	session_start();

	if(!isset($_SESSION['login_user'])){
      header("location:index.php");
  	}
  	include('db_connect.php');
  	$nos=0;$mgs="";$err="";$repeat="";
  	if (isset($_POST['submit1'])) {

  		$nos=$_POST['nos'];
  		$session=$_POST['session'];
  	}

  	if (isset($_POST["submit"])) {

  		$nos=$_POST['nos'];
  		$session=$_POST['session'];
  		$count=1;
		for ($i=1; $i <=$nos ; $i++) { 
			$a=$count;
			$b=$a+1;

			$sql2="select id from student where id=$_POST[$a]";
			$res2=mysqli_query($conn,$sql2);
			$sql="insert into student(id,name,session) values('$_POST[$a]','$_POST[$b]','$session')";
			$res=mysqli_query($conn,$sql);
			if (mysqli_num_rows($res2)>0) {
				$repeat="Information already exist";
			}
			if ($res) {
				$mgs="Information of the student successfully added";
			}
			else{
				$err="Insertion of information is unsuccessful";
			}
			$count=$b+1;
		}
		if (!empty($repeat) && !empty($mgs)) {

			$mgs="Some information added successfully but some information already exist";
		}
		$nos=0;
	}

  ?>

<!DOCTYPE html> 
<html>
	<head> 

		<title>Add Student Information</title> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
		<link href="css/bootstrap.min.css" rel="stylesheet"> 
		<link rel="stylesheet" href="css/add.css">

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
					<li><a style="background-color: #4CAF50;color: white" href="add_new_student.php">Add Student</a></li>
					<li><a href="add_new_course.php">Add Course</a></li>
				</ul>
			</div>

			<div class="col-lg-8 col-lg-offset-2">
				
				<?php 

					if (isset($_SESSION['nos'])) {

						if (!empty($repeat) && empty($mgs)) {
							echo "<p id='success' style='color:blue'>".$repeat."<p>";
						}
						elseif (!empty($repeat) && !empty($mgs)) {
							echo "<p id='success' style='color:#F1BFC3;font-size: 25px'>".$mgs."<p>";
						}
						elseif (isset($mgs)) {
							echo "<p id='success'>".$mgs."<p>";
						}
						else{
							echo "<p id='success' style='color:red'>".$err."<p>";
						}
					}

					if ($nos==0) {
						echo '<form id="first_form" action="" method="post" >
						<table>
							<tr>
							<td id="ff">Session</td>
							<td style="border-bottom:1px solid #dedede"><select name="session" style="width: 213px" id="ft">
									<option value="2012-13">2012-13</option>
									<option value="2013-14">2013-14</option>
									<option value="2014-15">2014-15</option>
									<option value="2015-16">2015-16</option>
									<option value="2016-17">2016-17</option>
								</select></td>
							</tr>
							<tr>
							<td id="ff">No of Student</td>
							<td><input style="width: 213px" id="ft" type="text" title="Only number allowed >0" name="nos" placeholder="Enter No of Student" pattern="[1-9]+[0-9]*" maxlength="3" required></td>
							</tr>
							<tr>
								<td id="ff" colspan="2"><input id="submit1" type="submit" name="submit1" value="Submit"></td>
								
							</tr>

						</form>';
					}

				 ?>

			</div>

			<div class="col-lg-8 col-lg-offset-2">

			<form id="second_form" action="" method="post">
				
				<table>

						<?php 

							if($nos>0){

								echo "<p id='ins'>Enter ID(ROLL) & Name of the student </p>";

								echo '<tr>
									<th style="text-align: center;">ID</th>
									<th style="text-align: center;">Name</th>
								</tr>';
							}

							$count=1;
							for ($i=1; $i <=$nos; $i++) { 
								$id=$count;
								$name=$id+1;
								echo "<tr>
									<td><input type='text' title='Only number allowed >0' name=$id placeholder='ID' pattern='[0-9]+' maxlength='6' required></td>

									<td><input type='text' title='Only characters A-Z or a-z allowed' name=$name placeholder='Name' pattern='[A-Za-z ]+' maxlength='50' required></td>
									</tr>";
								$count=$name+1;
							}
							
						 ?>

				</table> 
				<?php 
					if ($nos>0) {

						echo '
							<input type="hidden" name="session" value='.$session.'>
							<input type="hidden" name="nos" value='.$nos.'>
							<input type="submit" name="submit" value="Submit"><br>';
					}
				 ?>
			</form>
			

			</div>
		</div>
		
		<script src="js/jquery-3.2.1.min.js"></script> 
	</body> 
</html>