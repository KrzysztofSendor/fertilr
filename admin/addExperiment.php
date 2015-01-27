<!DOCTYPE html>
<?php
	session_start();
	require_once('../db.php');
?>
<html lang="pl">
<head>
	<title>fertil</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<link href="../css/bootstrap.min.css" rel="stylesheet">
	<script src="../js/jquery-2.1.3.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
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
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-md-offset-3 col-md-6 col-sm-12">
				<?php 
				if(!isset($_POST['step']) || $_POST['step'] == ''){
				?>					
					<form name="form-addStep0" action="addExperiment.php" method="post">
						<div class="form-group">
							<label for="nameInput">Nazwa</label>
							<input type="text" class="form-control" placeholder="Wprowadź nazwę" name="name">
						</div>
						<div class="form-group">
							<label for="poleInput">Pole</label>
							<select name="field" class="form-control">
							<?php
							$sql = mysql_query("SELECT Pola.id_pola, Pola.nazwa, Pola.rozmiar FROM Pola WHERE id_pola NOT IN (SELECT id_pola FROM Doswiadczenia WHERE ISNULL(data_zakonczenia))");
							while($row = mysql_fetch_row($sql)){
								echo"<option value='$row[0]'>$row[1] / $row[2] m&sup2;</option>";
							}
							?>
							</select>
						</div>
						<div class="form-group">
							<label for="areaNumber">Ile obszarów?</label>
							<input type="number" class="form-control" placeholder="Podaj ilosc obszarów" name="areaNumber">
						</div>
						<div class="form-group" style="margin-top:20px">
							<button type="submit" name="step" value="0" class="btn btn-danger">Anuluj</button>
							<button type="submit" name="step" value="1" class="btn btn-success">Dalej</button>
						</div>
					</form>
				<?php
				}
				if(isset($_POST['step']) && $_POST['step'] == '0') header("Location: experiments.php");
				if(isset($_POST['step']) && $_POST['step'] == '1'){ 
					if($_POST['name'] == '' || $_POST['field'] == '' || $_POST['areaNumber'] == ''){
						$_SESSION['tmp'] = 'noAddData';
						header("Location: experiments.php");
					}
					elseif(!is_numeric($_POST['areaNumber'])){
						$_SESSION['tmp'] = 'wrongDataType';
						header("Location: experiments.php");
					}
					else{
					
					
					$areaNumber = $_POST['areaNumber'];
				?>
				<form name="form-addStep1" action="addExperiment.php" method="post">
					<input type="text" name="name" hidden="true" value="<?php echo($_POST['name']); ?>">
					<input type="text" name="field" hidden="true" value="<?php echo($_POST['field']); ?>">
					<input type="number" name="areaNumber" hidden="true" value="<?php echo($areaNumber); ?>">
					
					<div class="form-group">
						<label for="fertiliserInput">Nawozy</label>
						<select class="form-control" multiple="multiple" name="fertilizers[]">
							<?php 
							$sql = mysql_query("SELECT id_nawozu, nazwa FROM Nawozy");
							while($row = mysql_fetch_row($sql)){
								echo"<option value='$row[0]'>$row[1]</option>";									
							}
							?>
						</select>
					</div>
					<div class="form-group">
						<label for="areaInput">Obszary</label>
						<?php
						for($i = 0; $i < $areaNumber; $i++){
							?>
							<div class="row" style="margin-top:10px">
								<div class="col-xs-1"><?php echo($i+1); ?></div>
								<div class="col-xs-6">
									<div class="input-group">
										<input type="number" class="form-control" placeholder="Wprowadź rozmiar" name="areaSize<?php echo($i); ?>">
										<span class="input-group-addon">m&sup2;</span>
									</div>
<!-- 									<input type="number" class="form-control" name="areaSize<?php echo($i); ?>" placeholder="Podaj rozmiar"> -->
								</div>
								<div class="col-xs-5">
									<select name="areaPlant<?php echo($i) ?>" class="form-control">
									<?php
									$sql = mysql_query("SELECT id_rosliny, nazwa FROM Rosliny");
									while($row = mysql_fetch_row($sql)){
										echo"<option value='$row[0]'>$row[1]</option>";
									}
									?>
									</select>
								</div>
							</div>
							<?php
						}
						?>
					</div>
					<div class="form-group" style="margin-top:20px">
						<button type="submit" name="step" value="0" class="btn btn-danger">Anuluj</button>
						<button type="submit" name="step" value="2" class="btn btn-success">Dalej</button>
					</div>
				</form>
				<?php
					}
				}
				if(isset($_POST['step']) && $_POST['step'] == '2'){
					if($_POST['fertilizers'] == '') {
						$_SESSION['tmp'] = 'noAddData';
						header("Location: experiments.php");
					}
					$areaNumber = $_POST['areaNumber'];
					$wrong = false;
					for($i = 0; $i < $areaNumber; $i++){
						if($_POST["areaSize$i"] == '') $wrong = true;
						if($_POST["areaPlant$i"] == '') $wrong = true;
					}
					if($wrong == true) {
						$_SESSION['tmp'] = 'noAddData';
						header("Location: experiments.php");
					}
					$wrong = false;
					for($i = 0; $i < $areaNumber; $i++){
						if(!is_numeric($_POST["areaSize$i"])) $wrong = true;
					}
					if($wrong == true) {
						$_SESSION['tmp'] = 'wrongDataType';
						header("Location: experiments.php");
					}
					$sum = 0;
					for($i = 0; $i < $areaNumber; $i++){
						$sum += $_POST["areaSize$i"];
					}
					$name = $_POST['name'];
					$id_field = $_POST['field'];
					$sql = "SELECT rozmiar FROM Pola WHERE id_pola = $id_field";
					$row = mysql_fetch_row(mysql_query($sql));
					
					if($sum > $row[0]){
						$_SESSION['tmp'] = 'toBig';
						header("Location: experiments.php");
					}
					else{
						$sql = "INSERT INTO Doswiadczenia (nazwa, id_pola) VALUES ('$name', $id_field)";
						mysql_query($sql);
						
						$sql = "SELECT id_doswiadczenia FROM Doswiadczenia WHERE id_pola = $id_field AND ISNULL(data_zakonczenia)";
						$row = mysql_fetch_row(mysql_query($sql));
						$id_experiment = $row[0];
						
						foreach ($_POST['fertilizers'] as $fertilizers){
							$sql = "INSERT INTO Doswiadczenia_Nawozy (id_doswiadczenia, id_nawozu) VALUES ($id_experiment, $fertilizers)";
							mysql_query($sql);	
						}
						
						for($i = 0; $i < $areaNumber; $i++){
							$areaSize = $_POST["areaSize$i"];
							$areaPlant = $_POST["areaPlant$i"];
							$sql = "INSERT INTO Obszary (rozmiar, id_doswiadczenia, id_rosliny) VALUES ('$areaSize', $id_experiment, $areaPlant)";
							mysql_query($sql);						
						}
						header("Location: experiments.php");
					}
				}
				?>		
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