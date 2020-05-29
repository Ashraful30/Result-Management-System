<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
</head>
<body>

	<form id="jsform" action="update.php" method="post">
		<input type="hidden" name="session" value=<?php echo $_SESSION['s']; ?> >
		<input type="hidden" name="year" value=<?php echo $_SESSION['y']; ?> >
		<input type="hidden" name="semester" value=<?php echo $_SESSION['sm']; ?> >
		<input type="hidden" name="submit1" value="submit">
	</form>
	
	<script type="text/javascript">
	  document.getElementById('jsform').submit();
	</script>
</body>
</html>