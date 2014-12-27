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
			<div class="col-md-offset-1 col-md-7 col-sm-12">
				<div class="panel panel-default">
					<div class="panel-heading">Lista użytkowników</div>
					<table class="table table-hover">
						<tr>
							<th>#</th>
							<th>imię</th>
							<th>nazwisko</th>
							<th>login</th>
						</tr>
						<?php
						if(!isset($_GET['p']) || !is_numeric($_GET['p'])){
							$page = 0;
						} else {
							$page = (int)$_GET['p'];
						}
						$sql = mysql_query("SELECT id_uzytkownik, login, imie, nazwisko, admin FROM `Uzytkownicy` LIMIT $page, 10");
						$num = mysql_num_rows($sql);
						if($num>0){
							for($i=0; $i<$num; $i++){
								$row = mysql_fetch_row($sql);
								echo"<tr
								
								>";
								echo"<td>$row[0]</td>";
								echo"<td>$row[2]</td>";
								echo"<td>$row[3]</td>";
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
						?>"><a href="users.php?p=<?php echo($page-10); ?>" aria-label="Previous"><span aria-hidden="true">&larr;</span> Poprzednie</a></li>
						<li class="next <?php
							if($page >= $num) echo(disabled);
							else echo(active);
						?>"><a href="users.php?p=<?php echo($page+10); ?>" aria-label="Next">Następne <span aria-hidden="true">&rarr;</span></a></li>
					</ul>
				</nav>
			</div>
			<div class="col-md-2 col-sm-10 col-sm-offset-1">
				<div class="well">
					Hi
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
					<button type="button" class="btn btn-success" onclick="location.href='../index.php?logout'">Tak</button>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="deleteUserModal" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-body">
					
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