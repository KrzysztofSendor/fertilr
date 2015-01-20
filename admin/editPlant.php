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
				$sql = "DELETE FROM `Rosliny` WHERE nazwa='$name'";
				$_SESSION['tmp'] = 'deleted';
			}
		}
		elseif($_POST['editType'] == 'add') {
			if($_POST['name'] == ''){
				$_SESSION['tmp'] = 'noAddData';
			}
			else {
				$name = $_POST['name'];
				$doubles = mysql_num_rows(mysql_query("SELECT nazwa FROM Rosliny WHERE nazwa = '$name'"));
				if($doubles > 0) $_SESSION['tmp'] = 'nameUsed';
				else {				
					$sql = "INSERT INTO Rosliny (nazwa) VALUES ('$name')";
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
				header("Location: plants.php");
			}
		}
		elseif($_POST['editType'] == 'saveEdit'){
			if($_POST['name'] == ''){
				$_SESSION['tmp'] = 'noAddData';
			}
			else {
				$oldName = $_POST['oldName'];
				$name = $_POST['name'];
				if($name != $oldName) {
					$doubles = mysql_num_rows(mysql_query("SELECT name FROM Rosliny WHERE name = '$name'"));
				}
				if($doubles > 0) $_SESSION['tmp'] = 'nameUsed';
				else {
					$sql = "UPDATE Rosliny SET nazwa='$name' WHERE nazwa='$oldName'";
					$_SESSION['tmp'] = 'edited;';
				}
			}
		}
		if(isset($sql))	mysql_query($sql);
		if($_POST['editType'] == 'back') header("Location: ../admin.php");
		else header("Location: plants.php");
	}
	else{
		header("Location: ../index.php");
	}
		
		
	
?>