<?php 

	session_start();

	if(!isset($_SESSION['login_user'])){
      header("location:index.php");
  	}
  	include('db_connect.php');
  	if (isset($_POST['marks'])) {
  		echo $_POST['marks'];
  	}

?>