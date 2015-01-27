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
				$sql = "DELETE FROM `Doswiadczenia` WHERE nazwa='$name'";
				$_SESSION['tmp'] = 'deleted';
			}
		}
		/*
elseif($_POST['editType'] == 'edit') {
			if(!isset($_POST['elementSelect'])) {
				$_SESSION['tmp'] = 'noData';
			}
			else {
				$name = $_POST['elementSelect'];
				$_SESSION['data'] = $name;
				$_SESSION['tmp'] = 'editCallback';
				header("Location: eperiments.php");
			}
		}
*/
		/*
elseif($_POST['editType'] == 'saveEdit'){
			if($_POST['name'] == ''){
				$_SESSION['tmp'] = 'noAddData';
			}
			else {
				$oldName = $_POST['oldName'];
				$name = $_POST['name'];
				if($name != $oldName) {
					$doubles = mysql_num_rows(mysql_query("SELECT name FROM Nawozy WHERE name = '$name'"));
				}
				if($doubles > 0) $_SESSION['tmp'] = 'nameUsed';
				else {
					$sql = "UPDATE Nawozy SET nazwa='$name' WHERE nazwa='$oldName'";
					$_SESSION['tmp'] = 'edited;';
				}
			}
		}
*/
		elseif($_POST['editType'] == 'details') {
			if(!isset($_POST['elementSelect'])){
				$_SESSION['tmp'] = 'noData';
			}
			else {
				$id = $_POST['elementSelect'];
				$_SESSION['data'] = $id;
				$_SESSION['tmp'] = 'detailsCallback';
				header("Location: experiments.php");
			}
		}
		elseif($_POST['editType'] == 'finish') {
			if(!isset($_POST['elementSelect'])){
				$_SESSION['tmp'] = 'noData';
			}
			else {
				$id = $_POST['elementSelect'];
/* 				$time_stamp = (new \DateTime())->format('Y-m-d H:i:s'); */
				$sql = "UPDATE Doswiadczenia SET data_zakonczenia = now() WHERE id_doswiadczenia = $id";
			}
		}
		if(isset($sql))	mysql_query($sql);
		if($_POST['editType'] == 'back') header("Location: ../admin.php");
		elseif($_POST['editType'] == 'add') header("Location: addExperiment.php");
		else header("Location: experiments.php");
	}
	else{
		header("Location: ../index.php");
	}
		
		
	
?>