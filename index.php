<!DOCTYPE html>
<?php
	session_start();
	require_once('db.php');
?>
<html lang="pl">
<head>
	<title>fertilr</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<link href="css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
	<div class="jumbotron">
		<div class="container">
			<div class="row">
				<div class="col-md-11 col-md-offset-1 col-sm-11 col-sm-offset-1">	
					<h1>fertilr</h1>
					<p>Proste narzędzie do przeprowadzania doświadczeń botanicznych</p>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-md-offset-4 col-sm-10 col-sm-offset-1">
				<?php
	if (!isset($_SESSION['auth'])) $_SESSION['auth'] = false;
	
	if (!isset($_POST['login']) && !isset($_POST['password']) && $_SESSION['auth'] == FALSE) {
	?>
				<div class="panel panel-default">
					<div class="panel-heading">Logowanie</div>
					<div class="panel-body">
						<form name="form-logowanie" action="index.php" method="post">
							<div class="form-group">
								<label for="LoginInput">Login</label>
								<input type="text" class="form-control" placeholder="Wprowadź login" name="login">
							</div>
							<div class="form-group">
								<label for="PasswordInput">Hasło</label>
								<input type="password" class="form-control" placeholder="Wprowadź hasło" name="password">
							</div>
							<button type="submit" class="btn btn-default" name="zaloguj">Zaloguj</button>
						</form>
					</div>
				</div>
				<?php
	} 
	elseif (isset($_POST['login']) && isset($_POST['password']) && $_SESSION['auth'] == FALSE) {
		if(!empty($_POST['login']) && !empty($_POST['password'])) {
			$login = mysql_real_escape_string($_POST['login']);
			$password = mysql_real_escape_string($_POST['password']);
			$password = md5($password);
			
			$sql = mysql_num_rows(mysql_query("SELECT login, haslo FROM `Uzytkownicy` WHERE `login` = '$login' AND `haslo` = '$password'"));
			
			if ($sql == 1) {
				$_SESSION['user'] = $login;
				$_SESSION['auth'] = TRUE;
				
				$sql = mysql_num_rows(mysql_query("SELECT login, haslo, admin FROM `Uzytkownicy` WHERE `login` = '$login' AND `haslo` = '$password' AND `admin` = 1"));
			
				if ($sql == 1){
					$_SESSION['admin'] = TRUE;
					header("Location: admin.php");
				} else {
					$_SESSION['admin'] = FALSE;
					header("Location: user.php");
				}
			} else {
			?>
				<div class="panel panel-default">
					<div class="panel-heading">Logowanie</div>
					<div class="panel-body">
						<div class="alert alert-danger" role="alert">Błędne dane logowania</div>
						<form action="index.php">
							<button type="submit" class="btn btn-default">Wróć do logowania</button>
						</form>
					</div>
				</div>
				<?php
			}
		} else {
		?>
			<div class="panel panel-default">
				<div class="panel-heading">Logowanie</div>
				<div class="panel-body">
					<div class="alert alert-danger" role="alert">Brak danych logowania</div>
					<form action="index.php">
						<button type="submit" class="btn btn-default">Wróć do logowania</button>
					</form>
				</div>
			</div>
			<?php
		}
	}
	elseif ($_SESSION['auth'] == TRUE && isset($_GET['logout'])){
		$_SESSION['user'] = FALSE;
		$_SESSION['auth'] = '';
		?>
		<div class="panel panel-default">
			<div class="panel-heading">Logowanie</div>
			<div class="panel-body">
				<div class="alert alert-success" role="alert">Wylogowano</div>
				<form action="index.php">
					<button type="submit" class="btn btn-default">Wróć do logowania</button>
				</form>
			</div>
		</div>
		<?php
	}
	
	elseif ($_SESSION['auth'] == TRUE && $_SESSION['admin'] == TRUE) header("Location: admin.php");
	elseif ($_SESSION['auth'] == TRUE && $_SESSION['admin'] == FALSE) header("Location: user.php");

	mysql_close();
	?>
			</div>
		</div>
	</div>
</body>
</html>