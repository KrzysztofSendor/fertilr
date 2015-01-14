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
		if(isset($_SESSION['auth']) && $_SESSION['auth'] == TRUE && isset($_SESSION['admin']) && $_SESSION['admin'] == TRUE){
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
					<form name="EditUser" action="editUser.php" method="post">
						<div class="col-md-8 col-sm-12">				
							<div class="panel panel-default">
								<div class="panel-heading">Lista użytkowników</div>
								<?php
									if(!isset($_GET['p']) || !is_numeric($_GET['p'])){
										$page = 0;
									} else {
										$page = (int)$_GET['p'];
									}
									$sql = mysql_query("SELECT id_uzytkownik, login, imie, nazwisko, admin FROM `Uzytkownicy` LIMIT $page, 10");
									$num = mysql_num_rows($sql);
									if($num>0){
									?>
									<table class="table table-hover">
										<tr>
											<th class="col-sm-1"></th>
											<th class="col-sm-1">id.</th>
											<th class="hidden-xs col-sm-3">imię</th>
											<th class="hidden-xs col-sm-3">nazwisko</th>
											<th class="col-xs-9 col-sm-3">login</th>
											<th class="col-sm-1">admin</th>
										</tr>
										<?php
										for($i=0; $i<$num; $i++){
										$row = mysql_fetch_row($sql);
											?>
											<td><input type="radio" name="UserSelect" id="UserSelect<?php echo($i+1) ?>" value="<?php echo($row[1]) ?>"></td>
											<?php
											echo"<td>$row[0]</td>";
											echo"<td class='hidden-xs'>$row[2]</td>";
											echo"<td class='hidden-xs'>$row[3]</td>";
											echo"<td>$row[1]</td>";
											echo"<td class='text-center'>",($row[4] == 1 ? '&check;' : ''),"</td>";
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
									?>"><a href="users.php?p=<?php echo($page-10); ?>" aria-label="Previous"><span aria-hidden="true">&larr;</span> Poprzednie</a></li>
									<li class="next <?php
										if($page+10 > $num) echo(disabled);
										else echo(active);
									?>"><a href="users.php?p=<?php echo($page+10); ?>" aria-label="Next">Następne <span aria-hidden="true">&rarr;</span></a></li>
								</ul>
							</nav>
						</div>
						<div class="col-md-3 col-md-offset-1 col-sm-10 col-sm-offset-1">
							<div class="well">
								<button type="button" class="btn btn-default btn-block" data-toggle="modal" data-target="#addUserModal">Dodaj</button>
								<button type="submit" class="btn btn-default btn-block" name="editType" value="edit">Edytuj</button>
								<button type="button" class="btn btn-default btn-block" data-toggle="modal" data-target="#deleteUserModal">Usuń</button>
								<button type="submit" class="btn btn-default btn-block" style="margin-top: 25px" name="editType" value="back">Wstecz</button>
							</div>
						</div>
						<div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="deleteUserModal" aria-hidden="true">
							<div class="modal-dialog modal-sm">
								<div class="modal-content">
									<div class="modal-body">
										<div class="alert alert-danger" role="alert">
											<strong>Uwaga!</strong> Usunięcie użytkownika może spowodować nieodwracalne błędy.
										</div>
										Na pewno chcesz usunąć wybranego użytkownika?
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
	
	<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModal" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<form name="addUser" action="editUser.php" method="post">
				<div class="modal-content">
					<div class="modal-body">
						<div class="form-group">
							<label for="LoginInput">Login</label>
							<input type="text" class="form-control" placeholder="Wprowadź login" name="login">
						</div>
						<div class="form-group">
							<label for="PasswordInput">Hasło</label>
							<input type="password" class="form-control" placeholder="Wprowadź hasło" name="password">
						</div>
						<div class="form-group">
							<label for="ImieInput">Imię</label>
							<input type="text" class="form-control" placeholder="Wprowadź imię" name="name">
						</div>
						<div class="form-group">
							<label for="NazwiskoInput">Nazwisko</label>
							<input type="text" class="form-control" placeholder="Wprowadź nazwisko" name="surename">
						</div>
						<div class="form-group">
							<label for="AdminInput">Admin</label>
								<input type="checkbox" name="admin">
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
		$row = mysql_fetch_row(mysql_query("SELECT id_uzytkownik, login, haslo, imie, nazwisko, admin FROM `Uzytkownicy` WHERE login='$data'"));
	?>
	
	<script type="text/javascript">
		$(window).load(function(){
			$('#editUserModal').modal('show');
		});
	</script>
	
	<form name="formEdit" action="editUser.php" method="post">
		<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModal" aria-hidden="true">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-body">
						<input hidden="true" type="text" name="oldLogin" value="<?php echo($data); ?>">
						<div class="form-group">
							<label for="LoginInput">Login</label>
							<input type="text" class="form-control" placeholder="Wprowadź login" value="<?php echo($row[1]); ?>" name="login">
						</div>
						<div class="form-group">
							<label for="PasswordInput">Hasło</label>
							<input type="password" class="form-control" placeholder="Wprowadź hasło" value="<?php echo($row[2]); ?>" name="password">
						</div>
						<div class="form-group">
							<label for="LoginInput">Imię</label>
							<input type="text" class="form-control" placeholder="Wprowadź imię" value="<?php echo($row[3]); ?>" name="name">
						</div>
						<div class="form-group">
							<label for="LoginInput">Nazwisko</label>
							<input type="text" class="form-control" placeholder="Wprowadź nazwisko" value="<?php echo($row[4]); ?>" name="surename">
						</div>
						<div class="form-group">
							<label for="AdminInput">Admin</label>
							<input type="checkbox" name="admin" <?php if($row[5] == TRUE) echo('checked'); ?>>
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
	mysql_close();
	} else {
		header("Location: index.php");
	}
	?>
</body>
</html>