<?php
	session_start();
	require_once('../db.php');
	
	if($_SESSION['auth'] == TRUE && $_SESSION['admin'] == TRUE){
		if($_POST['editType'] == 'delete') {		
			if(!isset($_POST['UserSelect'])) {
				$_SESSION['tmp'] = 'noData';
/* 				header("Location: users.php"); */
			}
			else {
				$user = $_POST['UserSelect'];
				$sql = "DELETE FROM `Uzytkownicy` WHERE login='$user'";
				$_SESSION['tmp'] = 'deleted';
				mysql_query($sql);
			}
		}
		elseif($_POST['editType'] == 'add') {
			if(($_POST['name'] == '') || ($_POST['surename'] == '') || ($_POST['login'] == '') || ($_POST['password']) == ''){
				$_SESSION['tmp'] = 'noAddData';
			}
			else{
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
		mysql_query($sql);
		header("Location: users.php");
	}
	else{
		header("Location: ../index.php");
	}
		
		
	
?>