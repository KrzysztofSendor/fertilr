<!DOCTYPE html>
<?php
	session_start();
	require_once('db.php');
?>
<html>
<head>
	<title>fertilr</title>
	<meta charset="utf-8">
</head>

<body>
	<?php
	if (!isset($_SESSION['auth'])) $_SESSION['auth'] = false;
	
	if (!isset($_POST['login']) && !isset($_POST['password']) && $_SESSION['auth'] == FALSE) {
	?>
	<form name="form-logowanie" action="index.php" method="post">
		Login:<br>
		<input type="text" name="login"><br>
		Hasło:<br>
		<input type="password" name="password"><br>
		<input type="submit" name="zaloguj" value="Zaloguj">
	</form>
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
/* 					echo '<meta http-equiv="refresh" content"1; URL=admin.php">'; */
					header("Location: admin.php");
				} else {
					$_SESSION['admin'] = FALSE;
/* 					echo '<meta http-equiv="refresh" content"1; URL=user.php">'; */
					header("Location: user.php");
				}
			} else {
				echo 'Błąd logowania';
				echo '<a href="index.php">Wróć do logowania</a>';
			}
		} else {
			echo 'Błąd logowania';
			echo '<a href="index.php">Wróć do logowania</a>';
		}
	}
	elseif ($_SESSION['auth'] == TRUE && isset($_GET['logout'])){
		$_SESSION['user'] = FALSE;
		$_SESSION['auth'] = '';
		echo 'Wylogowano<br><a href="index.php">Powrót do strony logowania</a>';
	}
	
	elseif ($_SESSION['auth'] == TRUE && $_SESSION['admin'] == TRUE) header("Location: admin.php");
	elseif ($_SESSION['auth'] == TRUE && $_SESSION['admin'] == FALSE) header("Location: user.php");

	
	
	?>
	
</body>
</html>