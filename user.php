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
		if($_SESSION['auth'] == TRUE && $_SESSION['admin'] == FALSE){
			$imie = mysql_fetch_array(mysql_query("SELECT imie FROM `Uzytkownicy` WHERE `login` = '".$_SESSION['user']."'"));
			$imie = $imie[0];
			$nazwisko = mysql_fetch_array(mysql_query("SELECT nazwisko FROM `Uzytkownicy` WHERE `login` = '".$_SESSION['user']."'"));
			$nazwisko = $nazwisko[0];
			$id_user = mysql_fetch_array(mysql_query("SELECT id_uzytkownik FROM `Uzytkownicy` WHERE `login` = '".$_SESSION['user']."'"));
			$id_user = $id_user[0];
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
			<div class="col-md-offset-3 col-md-6 col-sm-12">
				<?php
				if(isset($_SESSION['tmp']) && $_SESSION['tmp'] == 'noAddData'){
					$_SESSION['tmp'] = '';
				?>
				<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong>Uwaga!</strong> Nie podano wartości pomiaru. Pomiar nie zapisany. 
				</div>
				<?php
				}
				elseif(isset($_SESSION['tmp']) && $_SESSION['tmp'] == 'wrongDataType'){
					$_SESSION['tmp'] = '';
				?>
				<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong>Uwaga!</strong> Błędny typ wprowadzanych danych. 
				</div>
				<?php
				}elseif(isset($_SESSION['tmp']) && $_SESSION['tmp'] == 'added'){
					$_SESSION['tmp'] = '';
				?>
				<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong>Sukces!</strong> Pomiar został zapisany. 
				</div>
				<?php
				}
				if(!isset($_POST['step']) || $_POST['step'] == ''){
				?>					
					<form name="form-addStep0" action="user.php" method="post">
						<div class="form-group">
							<label for="expeerimentInput">Doświadczenie</label>
							<select name="experiment" class="form-control">
							<?php
							$sql = mysql_query("SELECT id_doswiadczenia, nazwa FROM Doswiadczenia WHERE ISNULL(data_zakonczenia)");
							while($row = mysql_fetch_row($sql)){
								echo"<option value='$row[0]'>$row[1]</option>";
							}
							?>
							</select>
						</div>
						<div class="form-group" style="margin-top:20px">
							<button type="submit" name="step" value="1" class="btn btn-success">Dalej</button>
						</div>
					</form>
				<?php
				}
				if(isset($_POST['step']) && $_POST['step'] == '0') header("Location: user.php");
				if(isset($_POST['step']) && $_POST['step'] == '1'){
				?>
				<form name="form-addStep1" action="user.php" method="post">
					<?php $experiment = $_POST['experiment']; ?>
					
					<div class="form-group">
						<label for="areaInput">Obszar</label>
						<select class="form-control" name="area">
							<?php 
							$sql = mysql_query("SELECT id_obszaru, rozmiar, nazwa FROM Obszary NATURAL JOIN Rosliny WHERE id_doswiadczenia=$experiment");
							while($row = mysql_fetch_row($sql)){
								echo"<option value='$row[0]'>$row[1] m&sup2; / $row[2]</option>";									
							}
							?>
						</select>
					</div>
					<div class="form-group">
						<label for="numberInput">Wartość pomiaru</label>
						<input class="form-control" type="number" name="number" placeholder="Wprowadź wartość pomiaru">
					</div>
					<div class="form-group" style="margin-top:20px">
						<button type="submit" name="step" value="0" class="btn btn-danger">Anuluj</button>
						<button type="submit" name="step" value="2" class="btn btn-success">Dalej</button>
					</div>
				</form>
				<?php
				}
				if(isset($_POST['step']) && $_POST['step'] == '2'){
					if($_POST['number'] == ''){
						$_SESSION['tmp'] = 'noAddData';
						header("Location: user.php");
					}
					elseif(!is_numeric($_POST['number'])){
						$_SESSION['tmp'] = 'wrongDataType';
						header("Location: user.php");
					}
					else{
						$area = $_POST['area'];
						$number = $_POST['number'];
						$sql = "INSERT INTO Pomiary (id_obszaru, id_uzytkownika, pomiar) VALUES ($area, $id_user ,$number)";
						mysql_query($sql);
						$_SESSION['tmp'] = 'added';
						$_POST['step'] = '0';
						header("Location: user.php");
					}
				}
				?>		
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
	mysql_close();
	} else {
		header("Location: index.php");
	}
	?>
</body>
</html>