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
				<div class="col-md-2 col-sm-2 text-right">
					<button type="submit" class="btn btn-danger" data-toggle="modal" data-target="#logoutModal">Wyloguj</button>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-md-offset-1 col-md-10 col-sm-12">
				<?php require_once('errors.php'); ?>
				<div class="row">
					<form name="EditElement" action="measurements.php" method="post">
						<div class="col-md-8 col-sm-12">				
							<div class="panel panel-default">
								<div class="panel-heading">Lista doświadczeń</div>
								<?php
								if(!isset($_GET['p']) || !is_numeric($_GET['p'])){
										$page = 0;
									} else {
										$page = (int)$_GET['p'];
									}
									$sql = mysql_query("SELECT id_doswiadczenia, nazwa, DATE(data_rozpoczecia), DATE(data_zakonczenia) FROM `Doswiadczenia` LIMIT $page, 10");
									$num = mysql_num_rows($sql);
									if($num>0){
								?>
								<table class="table table-hover">
									<tr>
										<th class="col-xs-1"></th>
										<th class="col-xs-1">id.</th>
										<th class="col-sm-4 col-xs-10">nazwa</th>
										<th class="hidden-xs col-sm-3">data rozp.</th>
										<th class="hidden-xs col-md-3">data zak.</th>											
									</tr>
									<?php
									for($i=0; $i<$num; $i++){
										$row = mysql_fetch_row($sql);
										?>
										<tr>
										<td><input type="radio" name="elementSelect" id="elementSelect<?php echo($i+1) ?>" value="<?php echo($row[0]) ?>"></td>
										<?php
										echo"<td>$row[0]</td>";	
										echo"<td>$row[1]</td>";
										echo"<td>$row[2]</td>";
										echo"<td class='hiddex-xs'>$row[3]</td>";
										if(isset($row[4])) echo"<td class='hiddex-xs'>$row[4]</td>";
										else echo"<td class='hiddex-xs'></td>";
										echo"</tr>";
									}
									?>
								</table>
								<?php
								}
								else {
									?>
									<div class="text-center" style="margin:20px">Brak danych do wyświetlenia</div>
									<?php
								}
								?>
							</div>
							<nav>
								<ul class="pager">
									<li class="previous <?php 
										if($page==0) echo(disabled);
										else echo(active);
									?>"><a href="measurements.php?p=<?php echo($page-10); ?>" aria-label="Previous"><span aria-hidden="true">&larr;</span> Poprzednie</a></li>
									<li class="next <?php
										if($page+10 > $num) echo(disabled);
										else echo(active);
									?>"><a href="measurements.php?p=<?php echo($page+10); ?>" aria-label="Next">Następne <span aria-hidden="true">&rarr;</span></a></li>
								</ul>
							</nav>
						</div>
						<div class="col-md-3 col-md-offset-1 col-sm-10 col-sm-offset-1">
							<div class="well">
								<button type="submit" class="btn btn-default btn-block" name="editType" value="details">Szczegóły</button>
				<!--
				<button type="button" class="btn btn-default btn-block" data-toggle="modal" data-target="#finishModal">Zakończ</button>
								<button type="submit" class="btn btn-default btn-block" name="editType" value="add">Dodaj</button>
								<button type="submit" class="btn btn-default btn-block" name="editType" value="edit">Edytuj</button>
								<button type="button" class="btn btn-default btn-block" data-toggle="modal" data-target="#deleteModal">Usuń</button> -->
								<button type="submit" class="btn btn-default btn-block" style="margin-top: 25px" name="editType" value="back">Wstecz</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	
	<?php
	if(isset($_POST['editType']) && $_POST['editType'] == 'back'){
		header("Location: ../admin.php");
	}
	
	elseif(isset($_POST['editType']) && $_POST['editType'] == 'details'){
		$_SESSION['tmp'] = 'details';
		$_SESSION['data'] = $_POST['elementSelect'];
		header("Location: measurements.php");
	}
		
	elseif(isset($_SESSION['tmp']) && $_SESSION['tmp'] == 'details'){
		$_SESSION['tmp'] = '';
		$id = $_SESSION['data'];
		$_SESSION['data'] = '';
		
		$row = mysql_fetch_row(mysql_query("SELECT Obszary.id_obszaru, Obszary.rozmiar, Pomiary.pomiar, Rosliny.nazwa, Pomiary.data_pomiaru, Uzytkownicy.imie, Uzytkownicy.nazwisko FROM Pomiary NATURAL JOIN Obszary NATURAL JOIN Uzytkownicy NATURAL JOIN Rosliny WHERE Obszary.id_doswiadczenia = $id AND Pomiary.id_uzytkownika = Uzytkownicy.id_uzytkownik ORDER BY Obszary.id_obszaru ASC;"));
	?>
	
	<script type="text/javascript">
		$(window).load(function(){
			$('#detailsModal').modal('show');
		});
	</script>
	
	<div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="detailsModal" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
					<div class="panel panel-default">
						<div class="panel-heading">Lista pomiarów</div>
						<table class="table table-condensed">
							<tr>
								<th class="col-xs-2">id obszaru</th>
								<th class="col-xs-2">rozmiar obszaru</th>
								<th class="col-xs-2">wartość pomiaru</th>
								<th class="col-xs-2">roślina</th>
								<th class="col-xs-2">data pomiaru</th>
								<th class="col-xs-2">wykonany przez</th>										
							</tr>
							<?php
								$sql = mysql_query("SELECT Obszary.id_obszaru, Obszary.rozmiar, Pomiary.pomiar, Rosliny.nazwa, Pomiary.data_pomiaru, Uzytkownicy.imie, Uzytkownicy.nazwisko FROM Pomiary NATURAL JOIN Obszary NATURAL JOIN Uzytkownicy NATURAL JOIN Rosliny WHERE Obszary.id_doswiadczenia = $id AND Pomiary.id_uzytkownika = Uzytkownicy.id_uzytkownik ORDER BY Obszary.id_obszaru ASC;");
								while($row = mysql_fetch_row($sql)){
									$temp = $i+1;
									echo"<td>$row[0]</td>";
									echo"<td>$row[1] m&sup2;</td>";
									echo"<td>$row[2]</td>";
									echo"<td>$row[3]</td>";
									echo"<td>$row[4]</td>";
									echo"<td>$row[5] $row[6]</td>";
									echo"</tr>";
								}
							?>
						</table>
					</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-success" data-dismiss="modal">Zamknij</button>
				</div>
			</div>
		</div>
	</div>
	
	<?php
	}
	?>
	
	<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModal" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-body">
					Na pewno chcesz wylogować?
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Nie</button>
					<button type="button" class="btn btn-success" onclick="location.href='../index.php?logout'">Tak</button>
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