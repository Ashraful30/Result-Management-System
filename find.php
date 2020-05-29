<?php 

	session_start();

	if(!isset($_SESSION['login_user'])){
      header("location:index.php");
  	}
  	include('db_connect.php');


    
    /*for first form handling*/


  	$flag=0;$session_error="";$count=0;$nos=0;$noc=0;$error="";$session=0;$year=0;$semester=0;

  	if (isset($_POST['submit1'])) {
  		$session=$_POST['session'];
  		$year=$_POST['year'];
  		$semester=$_POST['semester'];
  		$roll=$_POST['roll'];
  		$sql="SELECT id,name from student where id='$roll' and  session='$session'";
  		$res=mysqli_query($conn,$sql);

  		if (mysqli_num_rows($res)>0) {
  			
  			$row = mysqli_fetch_assoc($res);
  			$id=$row['id'];
  			$first_student=$row['name'];
  			$sql1="SELECT marks from result where student_id='$id' and year='$year' and semester='$semester' limit 1";
	  		$res1=mysqli_query($conn,$sql1);

	  		if (mysqli_num_rows($res1)>0) {
	  			$flag=1;
	  		}
	  		else{
	  			$flag=0;
	  			$error="Sorry the result has not been published yet";
	  		}
	  	}
	  	else{
	  		$session_error="The Session or Roll doesn't exist";
	  		$flag=0;
	  	}
  	}
?>



<!DOCTYPE html> 
<html>
	<head> 

		<title>Find Result</title> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
		<link href="css/bootstrap.min.css" rel="stylesheet"> 
		<link rel="stylesheet" href="css/find.css">

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
					<li><a style="background-color: #4CAF50;color: white" href="find.php">Find Result</a></li>
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
								echo '<p id="se" style="color:#F1BFC3">'.$error.'</p>';

								echo "<p id='ins'>Enter Roll,Session,Year and Semester of the students to see result</p>";
								echo '
										<tr>
											<td id="ff">Enter Roll</td>
											<td><input style="width: 213px" id="ft" type="text" name="roll" placeholder="150130" title="Only number allowed >0" pattern="[0-9]+" maxlength="6" required ></td>
										</tr>
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
											<td colspan="2" id="ff"><input type="submit" name="submit1" value="Submit"></td>
											
										</tr>';
							}
						?>
					</table>
				</form> 
			</div>




			<!-- Displaying result -->




			<div class="col-lg-12 row">

					<table  class="table-bordered table 2">
						<?php 

							if ($flag==1) {

								echo "<p id='pust'>Pabna University of Science & Technology</p>";
								echo "<p id='dept_name'>Department Of Computer Science & Engineering</p>";
								echo '<p style="text-align:center;font-size:20px;color:white;margin-bottom:20px">Result of '.$year.' Year '.$semester.' Semester '.$session.' Session</p>';

								$course_title=[];
								$course_credit=[];
								$total_credit=0;

								$sql2="SELECT course_title,course_credit from course where id in(select course_id from cys_relation where semester='$semester' and syear='$year')";

								$res2=mysqli_query($conn,$sql2);
								$i=0;
								if(mysqli_num_rows($res2)>0){
									while($row1=mysqli_fetch_assoc($res2)){
										$course_title[$i]=$row1['course_title'];
										$course_credit[$i]=$row1['course_credit'];
										$total_credit+=$row1['course_credit'];
										$i=$i+1;
									}
								}
								$noc=$i;

								echo '<tr style="font-size: 15px;"><th>ID</th><th>Name</th>';
								for ($j=0; $j <$noc ; $j++) { 
									echo '<th>'.$course_title[$j].'</th>';
								}
								echo '<th>SGPA</th><th>Comments</th></tr>';


								$sql_res="SELECT result.student_id,course.id,course.course_title,result.marks from course inner join cys_relation on (course.id=cys_relation.course_id and cys_relation.semester=$semester and cys_relation.syear=$year) inner join result on course.id=result.course_id";

								$result=mysqli_query($conn,$sql_res);
								if(mysqli_num_rows($result)>0){

									echo '<tr><td>'.$id.'</td><td>'.$first_student.'</td>';
									$fail=0;
									$credit_counter=0;$obtain_credit=0;$tc=0;$k=1;
									while($row3=mysqli_fetch_assoc($result)){

										echo '<td>'.get_grade($row3["marks"]).'</td>';

										$obtain_credit +=($course_credit[$credit_counter]*make_gpa($row3["marks"]));
										if ($row3['marks']<40) {
											$fail=1;
										}
										
										$credit_counter++;

										if ($credit_counter%$noc==0) {
											
											if($fail==1){
												echo '<td>0</td><td>Not Promoted</td></tr>';
												$fail=0;
											}
											else{
												$cg=$obtain_credit / $total_credit;
												echo '<td>'.sprintf("%0.2f",$cg).'</td><td>Promoted</td></tr>';
											}
											break;
										}
									}
								}

							}
							function make_gpa($marks)
							{
				  				if ($marks>=80) {
				  					$gpa=4;
				  				}
				  				else if ($marks>=75 && $marks<=79) {
				  					$gpa=3.75;
				  				}
				  				else if ($marks>=70 && $marks<=74) {
				  					$gpa=3.50;
				  				}
				  				else if ($marks>=65 && $marks<=69) {
				  					$gpa=3.25;
				  				}
				  				else if ($marks>=60 && $marks<=64) {
				  					$gpa=3;
				  				}
				  				else if ($marks>=55 && $marks<=59) {
				  					$gpa=2.75;
				  				}
				  				else if ($marks>=50 && $marks<=54) {
				  					$gpa=2.50;
				  				}
				  				else if ($marks>=45 && $marks<=49) {
				  					$gpa=2.25;
				  				}
				  				else if ($marks>=40 && $marks<=44) {
				  					$gpa=2;
				  				}
				  				else{
				  					$gpa=0;
				  				}
				  				return $gpa;
							}
							function get_grade($marks){

								if ($marks>=80) {
				  					$grade="A+";
				  				}
				  				else if ($marks>=75 && $marks<=79) {
				  					$grade="A";
				  				}
				  				else if ($marks>=70 && $marks<=74) {
				  					$grade="A-";
				  				}
				  				else if ($marks>=65 && $marks<=69) {
				  					$grade="B+";
				  				}
				  				else if ($marks>=60 && $marks<=64) {
				  					$grade="B";
				  				}
				  				else if ($marks>=55 && $marks<=59) {
				  					$grade="B-";
				  				}
				  				else if ($marks>=50 && $marks<=54) {
				  					$grade="C+";
				  				}
				  				else if ($marks>=45 && $marks<=49) {
				  					$grade="C";
				  				}
				  				else if ($marks>=40 && $marks<=44) {
				  					$grade="D";
				  				}
				  				else{
				  					$grade="F";
				  				}
				  				return $grade;
							}
						?>
					</table>
					<?php 

						if ($flag==1) {

							echo '<a id="again" href="find.php">Find Again</a>';
						}

					 ?>
			</div>
		</div

		<script src="js/jquery-3.2.1.min.js"></script> 
	</body> 
</html>