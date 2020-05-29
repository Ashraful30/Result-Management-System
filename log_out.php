<?php 
	

	if(isset($_POST["submit"])){
		unset($_SESSION['login_user']);
		session_destroy(); 
		header("location:index.php"); 
	}
?>

<style>
	input[type="submit"]{
		float: right;
		margin-top: 15px;
		margin-right: 15px;
		background-color: #323232;
		border: 0px;
		padding: 11px;
		color: white;
		font-size: 18px;
		font-family: tahoma;
	}

	input[type="submit"]:hover{
		background-color: #5F5F5F;
	}
</style>


<form action="" method="post">
	<input type="submit" name='submit' value="Log out">
</form>