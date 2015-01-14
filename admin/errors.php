<?php
/* USERS */
if(isset($_SESSION['auth']) && $_SESSION['auth'] == TRUE && isset($_SESSION['admin']) && $_SESSION['admin'] == TRUE){
	if(isset($_SESSION['tmp']) && $_SESSION['tmp'] == 'deletedUser'){
	$_SESSION['tmp'] = '';
	?>
	<div class="alert alert-success alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<strong>Sukcess!</strong> Usunięto użytkownika.
	</div>
	<?php
	}
	elseif(isset($_SESSION['tmp']) && $_SESSION['tmp'] == 'noDataUser'){
	$_SESSION['tmp'] = '';
	?>
	<div class="alert alert-danger alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<strong>Uwaga!</strong> Nie wybrałeś użytkownika. Żaden użytkownik nie został usunięty. 
	</div>
	<?php
	}
	elseif(isset($_SESSION['tmp']) && $_SESSION['tmp'] == 'addedUser'){
		$_SESSION['tmp'] = '';
	?>
	<div class="alert alert-success alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<strong>Sukces!</strong> Dodano użytkownika.
	</div>
	<?php
	}
	elseif(isset($_SESSION['tmp']) && $_SESSION['tmp'] == 'noAddDataUser'){
		$_SESSION['tmp'] = '';
	?>
	<div class="alert alert-danger alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<strong>Uwaga!</strong> Nie wprowadzono wymaganych danych. Użytkownik nie został dodany.
	</div>
	<?php
	}
	elseif(isset($_SESSION['tmp']) && $_SESSION['tmp'] == 'editedUser'){
		$_SESSION['tmp'] = '';
	?>
	<div class="alert alert-success alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<strong>Sukces!</strong> Dane użytkownika zostały zmienione.
	</div>
	<?php
	}
	elseif(isset($_SESSION['tmp']) && $_SESSION['tmp'] == 'loginUsed'){
		$_SESSION['tmp'] = '';
	?>
	<div class="alert alert-danger alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<strong>Uwaga!</strong> Użytkownik o danym loginie już istnieje. 
	</div>
	<?php
	}	
/* 	OTHER */
	if(isset($_SESSION['tmp']) && $_SESSION['tmp'] == 'deleted'){
	$_SESSION['tmp'] = '';
	?>
	<div class="alert alert-success alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<strong>Sukcess!</strong> Usunięto element.
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
		<strong>Uwaga!</strong> Żaden element nie został wybrany.
	</div>
	<?php
	}
	elseif(isset($_SESSION['tmp']) && $_SESSION['tmp'] == 'added'){
		$_SESSION['tmp'] = '';
	?>
	<div class="alert alert-success alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<strong>Sukces!</strong> Dodano element.
	</div>
	<?php
	}
	elseif(isset($_SESSION['tmp']) && $_SESSION['tmp'] == 'noAddData'){
		$_SESSION['tmp'] = '';
	?>
	<div class="alert alert-danger alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<strong>Uwaga!</strong> Nie wprowadzono wymaganych danych. Element nie został dodany.
	</div>
	<?php
	}
	elseif(isset($_SESSION['tmp']) && $_SESSION['tmp'] == 'edited'){
		$_SESSION['tmp'] = '';
	?>
	<div class="alert alert-success alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<strong>Sukces!</strong> Edycja elementu został zapisana.
	</div>
	<?php
	}
	elseif(isset($_SESSION['tmp']) && $_SESSION['tmp'] == 'nameUsed'){
		$_SESSION['tmp'] = '';
	?>
	<div class="alert alert-danger alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<strong>Uwaga!</strong> Element o danej nazwie już istnieje. 
	</div>
	<?php
	}
} else {
	header("Location: ../index.php");
}
?>