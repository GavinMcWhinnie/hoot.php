<!DOCTYPE html>
<html>
<head>
  <title>hoot.php</title>
  <style type="text/css">
		body { margin: 0; background: linear-gradient(45deg, #660000, #000066); background-size: 100px 100px; height: 100vh;}
		.login { background-color: white; position: relative; top: 40%; width: 300px; margin: auto; text-align: center; padding: 20px 10px; }
	</style>
</head>
<body>
	<?php
	session_start();

	if (isset($_SESSION['logged_on'])) {
		header('Location: hoot.php');
	}
	?>
	<div class='login'>
		<h2>Password:</h2>
		<form action='hoot.php' method='post'>
			<input type="password" name="password" placeholder="password">
			<input type="submit" name="submit" value="Login">
		</form>
	</div>
</body>
</html>