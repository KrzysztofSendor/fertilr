<?php
	session_start();
	require_once('../db.php');
	
	if($_SESSION['auth'] == TRUE && $_SESSION['admin'] == TRUE){
		if($_POST['editType'] == 'delete') {		
			if(!isset($_POST['elementSelect'])) {
				$_SESSION['tmp'] = 'noData';
			}
			else {
				$name = $_POST['elementSelect'];
				$sql = "DELETE FROM `Pola` WHERE nazwa='$name'";
				$_SESSION['tmp'] = 'deleted';
			}
		}
		elseif($_POST['editType'] == 'add') {
			if($_POST['name'] == '' || $_POST['size'] == ''){
				$_SESSION['tmp'] = 'noAddData';
				}
			else {
				$name = $_POST['name'];
				$size = $_POST['size'];
				$doubles = mysql_num_rows(mysql_query("SELECT nazwa FROM Pola WHERE nazwa = '$name'"));
				if($doubles > 0) $_SESSION['tmp'] = 'nameUsed';
				if(!is_numeric($size) || $size < 0) $_SESSION['tmp'] = 'wrongDataType';
				else {				
					$sql = "INSERT INTO Pola (nazwa, rozmiar) VALUES ('$name',$size)";
					$_SESSION['tmp'] = 'added';
				}
			}
		}
		elseif($_POST['editType'] == 'edit') {
			if(!isset($_POST['elementSelect'])) {
				$_SESSION['tmp'] = 'noData';
			}
			else {
				$name = $_POST['elementSelect'];
				$_SESSION['data'] = $name;
				$_SESSION['tmp'] = 'editCallback';
				header("Location: fields.php");
			}
		}
		elseif($_POST['editType'] == 'saveEdit'){
			if($_POST['name'] == '' || $_POST['size'] == '') $_SESSION['tmp'] = 'noAddData';
			else {
				$oldName = $_POST['oldName'];
				$name = $_POST['name'];
				$size = $_POST['size'];
				if($name != $oldName) {
					$doubles = mysql_num_rows(mysql_query("SELECT name FROM Pola WHERE name = '$name'"));
				}
				if($doubles > 0) $_SESSION['tmp'] = 'nameUsed';
				else {
					$sql = "UPDATE Pola SET nazwa='$name', romziar='$size' WHERE nazwa='$oldName'";
					$_SESSION['tmp'] = 'edited;';
				}
			}
		}
		if(isset($sql))	mysql_query($sql);
		if($_POST['editType'] == 'back') header("Location: ../admin.php");
		else header("Location: fields.php");
	}
	else{
		header("Location: ../index.php");
	}
		
		
	
?>