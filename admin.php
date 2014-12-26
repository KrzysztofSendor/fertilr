<!DOCTYPE html>
<?php
	session_start();
	require_once('db.php');
?>
<html lang="pl">
<head>
	<title>fertil | admin</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
	<?php
		if($_SESSION['auth'] == TRUE && $_SESSION['admin'] == TRUE){
			$imie = mysql_fetch_array(mysql_query("SELECT imie FROM `Uzytkownicy` WHERE `login` = '".$_SESSION['user']."'"));
			$imie = $imie[0];
			$nazwisko = mysql_fetch_array(mysql_query("SELECT nazwisko FROM `Uzytkownicy` WHERE `login` = '".$_SESSION['user']."'"));
			$nazwisko = $nazwisko[0];
	?>
	<div class="jumbotron">
		<div class="container">
			<div class="row">
				<div class="col-md-11 col-md-offset-1 col-sm-11 col-sm-offset-1">	
					<h1>fertilr</h1>
					<p>Witaj <?php echo($imie); echo(" "); echo($nazwisko) ?></p>
				</div>
			</div>
		</div>
	</div>
	
	<a href="index.php?logout">Wyloguj się</a>
	
	<?php
		} else {
			header("Location: index.php");
		}
		mysql_close();
	?>
</body>
</html>