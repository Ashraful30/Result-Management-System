<?php 

	session_start();

	if(!isset($_SESSION['login_user'])){
      header("location:index.php");
  	}
  	include('db_connect.php');


    
    /*for first form handling*/


  	$flag=0;$err="";$count=0;$nos=0;$session_error="";$con_mgs="";$error=0;

  	if (isset($_POST['submit1'])) {
  		$session=$_POST['session'];
  		$year=$_POST['year'];
  		$semester=$_POST['semester'];
  		$id=0;
  		$sql="select id from student where session='$session' limit 1";
  		$res=mysqli_query($conn,$sql);

  		if (mysqli_num_rows($res)>0) {
  			
  			$row = mysqli_fetch_assoc($res);
  			$id=$row['id'];
  			$sql1="select marks from result where student_id='$id' and year='$year' and semester='$semester' limit 1";

	  		$res1=mysqli_query($conn,$sql1);

	  		if (mysqli_num_rows($res1)>0) {
	  			$err="Result already made";
	  			$flag=0;
	  		}
	  		else{
	  			$flag=1;
	  			$data=mysqli_fetch_assoc(mysqli_query($conn,"select count(id) as total from student where session='$session'"));
	  			$count=$data['total'];
	  		}
	  	}
	  	else{
	  		$session_error="Student's information isn't added yet of session ".$session." ";
	  		$flag=0;
	  	}
  	}



  	/*for second form handling*/




  	if (isset($_POST['submit'])) {
  		
  		$temp=0;
  		$y=$_SESSION['year'];
  		$s=$_SESSION['semester'];
  		for ($i=0; $i < $_SESSION['count'] ; $i++) { 

  			$id=$_SESSION['student_id'][$i];
  			
  			for ($j=0; $j < $_SESSION['nos']; $j++) { 

  				$marks=$_POST[$temp];
  				$cid=$_SESSION['course_id'][$j];
  				
  				$sql4="insert into result(student_id,course_id,marks,semester,year) values('$id','$cid','$marks','$s','$y')";

  				$res4=mysqli_query($conn,$sql4);

  				if ($res4) {
		  			$con_mgs="Result made successfully";
	  			}
	  			else{
	  				$con_mgs="Error in making result";
	  				$error=1;	
	  			}

  				$temp=$temp+1;

  			}
  		}
  	}



 ?>

<!DOCTYPE html> 
<html>
	<head> 

		<title>Make Result</title> 
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
					<li><a style="background-color: #4CAF50;color: white" href="make.php">Make Result</a></li>
					<li><a href="update.php">Update Result</a></li>
					<li><a href="display.php">Display Result</a></li>
					<li><a href="find.php">Find Result</a></li>
					<li><a href="add_new_student.php">Add Student</a></li>
					<li><a href="add_new_course.php">Add Course</a></li>
				</ul>
			</div>

			<div class="col-lg-8 col-lg-offset-2 row table-responsive">




			<!-- first form input -->



				<form  action="" method="post">
					<table align="center" class="table-bordered table1">
					
						<?php  

							if ($flag==0) {
								echo '<p id="se">'.$session_error.'</p>';
								echo '<p id="se" style="color:#F1BFC3">'.$err.'</p>';
								if($error){
									echo '<p id="se" style="color:red">'.$con_mgs.'</p>';
								}
								else{
									echo '<p id="se" style="color:#055B05">'.$con_mgs.'</p>';
								}
								echo "<p id='ins'>Enter Session,Year and Semester of the student to make result</p>";
								echo '
										<tr>
											<td id="ff">Enter Session</td>
											<td ><select name="session" style="width: 213px" id="ft" >
													<option value="2012-13">2012-13</option>
													<option value="2013-14">2013-14</option>
													<option value="2014-15">2014-15</option>
													<option value="2015-16">2015-16</option>
													<option value="2016-17">2016-17</option>
												</select></td>
										</tr>
										<tr>
											<td id="ff">Enter Year</td>
											<td><select name="year" style="width: 213px" id="ft" >
													<option value="1">1</option>
													<option value="2">2</option>
												</select></td>
										</tr>
										<tr>
											<td id="ff">Enter Semester</td>
											<td><select name="semester" style="width: 213px" id="ft" >
													<option value="1">1</option>
													<option value="2">2</option>
												</select></td>
										</tr>
										<tr>
											<td id="ff" colspan="2"><input type="submit" name="submit1" value="Submit"></td>
											
										</tr>';
							}
						?>
					</table>
				</form> 
			</div>
			<div class="col-lg-12 row table-responsive">




			<!-- second form input -->




				<form action="" method="post">
					<table id="table2" class="table-bordered table2">
						<?php 

							if($count>0){

								echo "<p id='ins'>Enter Grade of All Courses of Each Student</p>";

								$nos=0;
								$course=[];
								$student=[];
								$course_id=[];
								$sql2="select id,course_title from course where id in(select course_id from cys_relation where semester='$semester' and syear='$year')";

								$res2=mysqli_query($conn,$sql2);
								if(mysqli_num_rows($res2)>0){
									while($row1=mysqli_fetch_assoc($res2)){
										$course[$nos]=$row1['course_title'];
										$course_id[$nos]=$row1['id'];
										$nos=$nos+1;
									}
								}

								$sql3="select id from student where session='$session'";
								$res3=mysqli_query($conn,$sql3);
								if(mysqli_num_rows($res3)>0){
									$num=0;
									while($row2=mysqli_fetch_assoc($res3)){
										$student[$num]=$row2['id'];
										$num=$num+1;
									}
								}

								echo '<tr><th id="fs">ID</th>';
								for ($i=0; $i <$nos ; $i++) { 
									echo '<th id="fs">'.$course[$i].'</th>';
								}
								echo '</tr>';
								$name=0; 
								for ($i=0; $i <$count ; $i++) { 
									echo "<tr><td id='fs'>".$student[$i]."</td>";
									for ($j=0; $j <$nos ; $j++) {
										echo "<td><input id='ft' type='number' name=$name placeholder='Enter Marks' title='Only numeric value >=0 & <=100 allowed' min=0 max=100 required ></td>";
										$name=$name+1;
									}
									echo "</tr>";
								}
							
								echo '<tr><td style="border:none"><input id="ls" type="submit" name="submit" value="Submit"></td></tr>';

								$_SESSION['nos']=$nos;
								$_SESSION['count']=$count;
								$_SESSION['student_id']=$student;
								$_SESSION['course_id']=$course_id;
								$_SESSION['year']=$year;
								$_SESSION['semester']=$semester;
							}

						?>
					</table>
				</form>

			</div>

		</div

		<script src="js/jquery-3.2.1.min.js"></script> 
	</body> 
</html>