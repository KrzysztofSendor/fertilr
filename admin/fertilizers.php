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
				<?php
				if(isset($_SESSION['tmp']) && $_SESSION['tmp'] == 'deleted'){
				$_SESSION['tmp'] = '';
				?>
				<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong>Sukcess!</strong> Usunięto nawóz.
				</div>
				<?php
				}
				elseif(isset($_SESSION['tmp']) && $_SESSION['tmp'] == 'ups'){
				$_SESSION['tmp'] = '';
				?>
				<div class="alert alert-warning alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong>Ups!</strong> Coś poszło nie tak.
				</div>
				<?php
				}
				elseif(isset($_SESSION['tmp']) && $_SESSION['tmp'] == 'noData'){
				$_SESSION['tmp'] = '';
				?>
				<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong>Uwaga!</strong> Żaden nawóz nie został wybrany.
				</div>
				<?php
				}
				elseif(isset($_SESSION['tmp']) && $_SESSION['tmp'] == 'added'){
					$_SESSION['tmp'] = '';
				?>
				<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong>Sukces!</strong> Dodano nawóz.
				</div>
				<?php
				}
				elseif(isset($_SESSION['tmp']) && $_SESSION['tmp'] == 'noAddData'){
					$_SESSION['tmp'] = '';
				?>
				<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong>Uwaga!</strong> Nie wprowadzono wymaganych danych. Nawóz nie został dodany.
				</div>
				<?php
				}
				elseif(isset($_SESSION['tmp']) && $_SESSION['tmp'] == 'edited'){
					$_SESSION['tmp'] = '';
				?>
				<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong>Sukces!</strong> Nazwa nawozu została zmieniona.
				</div>
				<?php
				}
				elseif(isset($_SESSION['tmp']) && $_SESSION['tmp'] == 'nameUsed'){
					$_SESSION['tmp'] = '';
				?>
				<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong>Uwaga!</strong> Nawóz o danej nazwie już istnieje. 
				</div>
				<?php
				}
				?>
				<div class="row">
					<form name="EditUser" action="editFertilizer.php" method="post">
						<div class="col-md-8 col-sm-12">				
							<div class="panel panel-default">
								<div class="panel-heading">Lista nawozów</div>
								<table class="table table-hover">
									<tr>
										<th class="col-sm-1"></th>
										<th class="col-sm-1">id.</th>
										<th>nazwa</th>
									</tr>
									<?php
									if(!isset($_GET['p']) || !is_numeric($_GET['p'])){
										$page = 0;
									} else {
										$page = (int)$_GET['p'];
									}
									$sql = mysql_query("SELECT id_nawozu, nazwa FROM `Nawozy` LIMIT $page, 10");
									$num = mysql_num_rows($sql);
									if($num>0){
										for($i=0; $i<$num; $i++){
											$row = mysql_fetch_row($sql);
											?>
												<td><input type="radio" name="FertilizerSelect" id="FertilizerSelect<?php echo($i+1) ?>" value="<?php echo($row[1]) ?>"></td>
											<?php
											echo"<td>$row[0]</td>";
											echo"<td>$row[1]</td>";
											echo"</tr>";
										}
									}
									?>
								</table>
							</div>
							<nav>
								<ul class="pager">
									<li class="previous <?php 
										if($page==0) echo(disabled);
										else echo(active);
									?>"><a href="fertilizers.php?p=<?php echo($page-10); ?>" aria-label="Previous"><span aria-hidden="true">&larr;</span> Poprzednie</a></li>
									<li class="next <?php
										if($page+10 > $num) echo(disabled);
										else echo(active);
									?>"><a href="fertilizers.php?p=<?php echo($page+10); ?>" aria-label="Next">Następne <span aria-hidden="true">&rarr;</span></a></li>
								</ul>
							</nav>
						</div>
						<div class="col-md-3 col-md-offset-1 col-sm-10 col-sm-offset-1">
							<div class="well">
								<button type="button" class="btn btn-default btn-block" data-toggle="modal" data-target="#addModal">Dodaj</button>
								<button type="submit" class="btn btn-default btn-block" name="editType" value="edit">Edytuj</button>
								<button type="button" class="btn btn-default btn-block" data-toggle="modal" data-target="#deleteModal">Usuń</button>
								<button type="submit" class="btn btn-default btn-block" style="margin-top: 25px" name="editType" value="back">Wstecz</button>
							</div>
						</div>
						<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteUserModal" aria-hidden="true">
							<div class="modal-dialog modal-sm">
								<div class="modal-content">
									<div class="modal-body">
										<div class="alert alert-danger" role="alert">
											<strong>Uwaga!</strong> Usunięcie nawozu może spowodować nieodwracalne błędy.
										</div>
										Na pewno chcesz usunąć wybrany nawóz?
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-danger" data-dismiss="modal">Nie</button>
										<button name="editType" value="delete" type="submit" class="btn btn-success">Tak</button>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModal" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<form name="add" action="editFertilizer.php" method="post">
				<div class="modal-content">
					<div class="modal-body">
						<div class="form-group">
							<label for="LoginInput">Nazwa</label>
							<input type="text" class="form-control" placeholder="Wprowadź nazwę" name="name">
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Anuluj</button>
						<button name="editType" value="add" type="submit" class="btn btn-success">Dodaj</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	
	<?php
	if(isset($_SESSION['tmp']) && $_SESSION['tmp'] == 'editCallback'){
		$_SESSION['tmp'] = '';
		$data = $_SESSION['data'];
		$_SESSION['data'] = '';
		$row = mysql_fetch_row(mysql_query("SELECT id_nawozu, nazwa FROM Nawozy WHERE nazwa='$data'"));
	?>
	
	<script type="text/javascript">
		$(window).load(function(){
			$('#editFertilizerModal').modal('show');
		});
	</script>
	
	<form name="formEdit" action="editFertilizer.php" method="post">
		<div class="modal fade" id="editFertilizerModal" tabindex="-1" role="dialog" aria-labelledby="editFertilizerModal" aria-hidden="true">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-body">
						<input hidden="true" type="text" name="oldName" value="<?php echo($data); ?>">
						<div class="form-group">
							<label for="Name">Nazwa</label>
							<input type="text" class="form-control" placeholder="Wprowadź nazwę" value="<?php echo($row[1]); ?>" name="name">
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Anuluj</button>
						<button name="editType" value="saveEdit" type="submit" class="btn btn-success">Zapisz</button>
					</div>
				</div>
			</div>
		</div>
	</form>
	
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
	} else {
		header("Location: index.php");
	}
	mysql_close();
	?>
</body>
</html>