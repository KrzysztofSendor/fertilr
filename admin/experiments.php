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
					<form name="EditElement" action="editExperiment.php" method="post">
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
									?>"><a href="experiments.php?p=<?php echo($page-10); ?>" aria-label="Previous"><span aria-hidden="true">&larr;</span> Poprzednie</a></li>
									<li class="next <?php
										if($page+10 > $num) echo(disabled);
										else echo(active);
									?>"><a href="experiments.php?p=<?php echo($page+10); ?>" aria-label="Next">Następne <span aria-hidden="true">&rarr;</span></a></li>
								</ul>
							</nav>
						</div>
						<div class="col-md-3 col-md-offset-1 col-sm-10 col-sm-offset-1">
							<div class="well">
								<button type="submit" class="btn btn-default btn-block" name="editType" value="details">Szczegóły</button>
								<button type="button" class="btn btn-default btn-block" data-toggle="modal" data-target="#finishModal">Zakończ</button>
								<button type="submit" class="btn btn-default btn-block" name="editType" value="add">Dodaj</button>
<!-- 								<button type="submit" class="btn btn-default btn-block" name="editType" value="edit">Edytuj</button> -->
								<button type="button" class="btn btn-default btn-block" data-toggle="modal" data-target="#deleteModal">Usuń</button>
								<button type="submit" class="btn btn-default btn-block" style="margin-top: 25px" name="editType" value="back">Wstecz</button>
							</div>
						</div>
						<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteUserModal" aria-hidden="true">
							<div class="modal-dialog modal-sm">
								<div class="modal-content">
									<div class="modal-body">
										<div class="alert alert-danger" role="alert">
											<strong>Uwaga!</strong> Usunięcie doświadczenia może spowodować nieodwracalne błędy.
										</div>
										Na pewno chcesz usunąć wybrane doświadczenie?
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-danger" data-dismiss="modal">Nie</button>
										<button name="editType" value="delete" type="submit" class="btn btn-success">Tak</button>
									</div>
								</div>
							</div>
						</div>
						<div class="modal fade" id="finishModal" tabindex="-1" role="dialog" aria-labelledby="deleteUserModal" aria-hidden="true">
							<div class="modal-dialog modal-sm">
								<div class="modal-content">
									<div class="modal-body">
										Na pewno chcesz zakończyć wybrane doświadczenie?
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-danger" data-dismiss="modal">Nie</button>
										<button name="editType" value="finish" type="submit" class="btn btn-success">Tak</button>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	
	<?php
	if(isset($_SESSION['tmp']) && $_SESSION['tmp'] == 'detailsCallback'){
		$_SESSION['tmp'] = '';
		$id = $_SESSION['data'];
		$_SESSION['data'] = '';
		$row = mysql_fetch_row(mysql_query("SELECT Doswiadczenia.nazwa, data_rozpoczecia, data_zakonczenia, Pola.nazwa, rozmiar FROM Doswiadczenia JOIN Pola ON Doswiadczenia.id_pola = Pola.id_pola WHERE id_doswiadczenia='$id'"));
	?>
	
	<script type="text/javascript">
		$(window).load(function(){
			$('#detailsExperimentModal').modal('show');
		});
	</script>
	
	<div class="modal fade" id="detailsExperimentModal" tabindex="-1" role="dialog" aria-labelledby="detailsExperimentModal" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
					<dl class="dl-horizontal">
						<dt>Nazwa doświadczenia</dt>
						<dd><?php echo($row[0]); ?></dd>
						<dt>Data rozpoczęcia</dt>
						<dd><?php echo($row[1]) ?></dd>			
						<dt>Data zakończenia</dt>
						<dd><?php if(isset($row[2])) echo($row[2]); else echo("-"); ?></dd>
						<dt>Nazwa pola</dt>
						<dd><?php echo($row[3]); ?></dd>
						<dt>Rozmiar pola</dt>
						<dd><?php echo($row[4]); ?> m&sup2;</dd>
					</dl>
				</div>
					<div class="panel panel-default" style="margin-left: 50px; margin-right: 50px">
						<div class="panel-heading">Lista obszarów</div>
						<table class="table table-condensed">
							<tr>
								<th class="col-xs-1">#</th>
								<th class="col-xs-5">rozmiar</th>
								<th class="col-xs-6">roślina</th>											
							</tr>
							<?php
								$sql = mysql_query("SELECT rozmiar, nazwa FROM Obszary JOIN Rosliny ON Obszary.id_rosliny = Rosliny.id_rosliny WHERE id_doswiadczenia = $id");
								$i = 1;
								while($row = mysql_fetch_row($sql)){
									$temp = $i+1;
									echo"<td>$i</td>";
									echo"<td>$row[0] m&sup2;</td>";
									echo"<td>$row[1]</td>";
									echo"</tr>";
									$i++;
								}
							?>
						</table>
					</div>
					<div class="panel panel-default" style="margin-left: 50px; margin-right: 50px">
						<div class="panel-heading">Lista nawozów</div>
						<table class="table table-condensed">
							<tr>
								<th class="col-xs-1">#</th>
								<th class="col-xs-11">nawóz</th>											
							</tr>
							<?php
								$sql = mysql_query("SELECT Nawozy.nazwa FROM Nawozy NATURAL JOIN Doswiadczenia_Nawozy WHERE id_doswiadczenia = '$id'");
								$i = 1;
								while($row = mysql_fetch_row($sql)){
									echo"<td>$i</td>";
									echo"<td>$row[0]</td>";
									echo"</tr>";
									$i++;
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