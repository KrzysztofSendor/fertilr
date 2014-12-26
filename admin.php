<!DOCTYPE html>
<?php
	session_start();
	require_once('db.php');
?>
<html>
<head>
	<title>fertil | admin</title>
	<meta charset="utf-8">
</head>
<body>
	<?php
		if($_SESSION['auth'] == TRUE && $_SESSION['admin'] == TRUE){
	?>
	SUKCES!<br>
	
	<a href="index.php?logout">Wyloguj się</a>
	
	
	
	
	
	
	<?php
		} else {
			header("Location: index.php");
		}
	?>
</body>
</html>