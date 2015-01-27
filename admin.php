<!DOCTYPE html>
<?php
	session_start();
	require_once('db.php');
?>
<html lang="pl">
<head>
	<title>fertil</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<script src="js/jquery-2.1.3.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
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
				<div class="col-md-8 col-md-offset-1 col-sm-8 col-sm-offset-1">	
					<h1>fertilr</h1>
					<p>Witaj <?php echo($imie); echo(" "); echo($nazwisko) ?></p>
				</div>
				<div class="col-md-2 col-sm-2 text-right">
					<button type="submit" class="btn btn-danger" data-toggle="modal" data-target="#logoutModal">Wyloguj</button>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1">
				<div class="row">
					<div class="col-md-6 col-sm-12">
						<div class="well well-lg">
							 <button type="submit" class="btn btn-default btn-lg btn-block" onclick="location.href='admin/users.php'">Użytkownicy</button>
							 <button type="submit" class="btn btn-default btn-lg btn-block" onclick="location.href='admin/fertilizers.php'">Nawozy</button>
							 <button type="submit" class="btn btn-default btn-lg btn-block" onclick="location.href='admin/plants.php'">Rośliny</button>
							 <button type="submit" class="btn btn-default btn-lg btn-block" onclick="location.href='admin/fields.php'">Pola</button>
							 <button type="submit" class="btn btn-default btn-lg btn-block" onclick="location.href='admin/experiments.php'">Doświadczenia</button>
							 <button type="submit" class="btn btn-default btn-lg btn-block" onclick="location.href='admin/measurements.php'">Pomiary</button>
						</div>
					</div>
					<div class="col-md-6 col-sm-12">
						<h2>Statystyki</h2>
						<p>Tu pojawią się statystyki</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	
	<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModal" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-body">
					Na pewno chcesz wylogować?
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Nie</button>
					<button type="button" class="btn btn-success" onclick="location.href='index.php?logout'">Tak</button>
				</div>
			</div>
		</div>
	</div>
	
	<?php
		} else {
			header("Location: index.php");
		}
		mysql_close();
	?>
</body>
</html>