<?php
	session_start();
	require_once('../db.php');
	
	if($_SESSION['auth'] == TRUE && $_SESSION['admin'] == TRUE){
		if($_POST['editType'] == 'delete') {		
			if(!isset($_POST['UserSelect'])) {
				$_SESSION['tmp'] = 'noData';
			}
			else {
				$user = $_POST['UserSelect'];
				$sql = "DELETE FROM `Uzytkownicy` WHERE login='$user'";
				$_SESSION['tmp'] = 'deleted';
			}
		}
		elseif($_POST['editType'] == 'add') {
			if(($_POST['name'] == '') || ($_POST['surename'] == '') || ($_POST['login'] == '') || ($_POST['password']) == ''){
				$_SESSION['tmp'] = 'noAddData';
			}
			else {
				$imie = $_POST['name'];
				$nazwisko = $_POST['surename'];
				$login = $_POST['login'];
				$password = $_POST['password'];
				$password = md5($password);
				$admin = 0;
				if(isset($_POST['admin'])) $admin = 1;
				$sql = "INSERT INTO `Uzytkownicy` (login, haslo, imie, nazwisko, admin) VALUES ('$login','$password','$imie','$nazwisko',$admin)";
				$_SESSION['tmp'] = 'added';
			}
		}
		elseif($_POST['editType'] == 'edit') {
			if(!isset($_POST['UserSelect'])) {
				$_SESSION['tmp'] = 'noData';
			}
			else {
				$user = $_POST['UserSelect'];
				$_SESSION['data'] = $user;
				$_SESSION['tmp'] = 'editCallback';
				header("Location: users.php");
			}
		}
		elseif($_POST['editType'] == 'saveEdit'){
			if(($_POST['name'] == '') || ($_POST['surename'] == '') || ($_POST['login'] == '') || ($_POST['password']) == ''){
				$_SESSION['tmp'] = 'noAddData';
			}
			else {
				$oldLogin = $_POST['oldLogin'];
				$imie = $_POST['name'];
				$nazwisko = $_POST['surename'];
				$login = $_POST['login'];
				$password = $_POST['password'];
				$sql = mysql_fetch_array(mysql_query("SELECT haslo FROM Uzytkownicy WHERE login = '$oldLogin'"));
				if($password != $sql[0]) $password = md5($password);
				$admin = 0;
				if(isset($_POST['admin'])) $admin = 1;
				$sql = "UPDATE Uzytkownicy SET imie='$imie', nazwisko='$nazwisko', login='$login', haslo='$password', admin='$admin' WHERE login='$oldLogin'";
				$_SESSION['tmp'] = 'edited;';
			}
		}
		
		if(isset($sql))	mysql_query($sql);
		header("Location: users.php");
	}
	else{
		header("Location: ../index.php");
	}
		
		
	
?>