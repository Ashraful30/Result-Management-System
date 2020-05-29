<?php 

	session_start();

	if(!isset($_SESSION['login_user'])){
      header("location:index.php");
  	}
  	include('db_connect.php');


    
    /*for first form handling*/


  	$flag=0;$err="";$con_mgs="";$r=0;

  	if (isset($_GET)) {
  		$id=$_GET['id'];
  		$name=$_GET['name'];
  		$c_id=$_GET['cid'];
  		$marks=$_GET['marks'];
  		$course=$_GET['course'];
  		$_SESSION['id']=$c_id;
  		$flag=1;
  	}



  	if (isset($_POST['submit'])) {
  		
  		for ($i=0; $i < count($_SESSION['id']); $i++) { 
  			
  			$sql="UPDATE result set marks='".$_POST[$i]."' where id='".$_SESSION['id'][$i]."'";
  			$res=mysqli_query($conn,$sql);
  			if ($res) {
  				$con_mgs="Information updated successfully";
  			}
  			else{
  				$err="Failed to update";
  			}

  		}
  		$flag=0;
  		$r=1;
  	}



 ?>

<!DOCTYPE html> 
<html>
	<head> 

		<title>Update Result</title> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
		<link href="css/bootstrap.min.css" rel="stylesheet"> 
		<link rel="stylesheet" href="css/make.css">

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
					<li><a href="add_new_course.php">Add Course</a></li>
					<li><a style="background-color: #313131;color: #AAAAAA" href="edit.php">Edit</a></li>
				</ul>
			</div>

			<p id="se" style="color:#F1BFC3"><?php echo $err;  ?></p>;
			<p id="se" style="color:#055B05"><?php echo $con_mgs;  ?></p>;
			<?php  

				if ($r==1) {
					header( "refresh:1;url=helper.php" );
				}

			?>
			<div class="col-lg-12 row table-responsive">


				<form  action="" method="post">
					<table align="center" class="table-bordered table2">
					
						<?php  

							if ($flag==1) {
								
								echo '<tr><th id="fs">ID</th>';
								for ($i=0; $i <count($course) ; $i++) { 
									echo '<th id="fs">'.$course[$i].'</th>';
								}
								echo '</tr>';
								$name=0; 
								echo "<tr><td id='fs'>".$id."</td>";
								for ($j=0; $j <count($course) ; $j++) {
									echo "<td><input id='ft' type='input' name=$name value='".$marks[$j]."' title='Only numeric value >=0 & <=100 allowed' min=0 max=100 required ></td>";
									$name=$name+1;
								}
								echo "</tr>";

							
								echo '<tr><td style="border:none"><input id="ls" type="submit" name="submit" value="Update"></td></tr>';
							}
						?>
					</table>
				</form> 
			</div>
		</div>

		<script src="js/jquery-3.2.1.min.js"></script> 
	</body> 
</html>