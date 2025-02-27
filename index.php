<?php

session_start();
include("controllers/controller_parent.php");

/**** Dispatcher ****/
$strAction 		= $_GET['action'] ?? 'home';
$strCtrl 		= $_GET['ctrl'] ?? 'advert';
$advId			= $_GET['id'] ?? null;

$strFileName	= "controllers/" . $strCtrl . "_controller.php";

$bool404		= false;
// Test si le fichier existe
if (file_exists($strFileName)) {
	include($strFileName);
	$strClassName	= ucfirst($strCtrl) . "Ctrl";
	// Test si le nom de la classe existe
	if (class_exists($strClassName)) {
		$objCtrl = new $strClassName();
		// Test si la méthode existe dans l'objet controller
		if (method_exists($objCtrl, $strAction)) {
			if ($advId != 0) {
				$objCtrl->$strAction($advId);
			} else {
				$objCtrl->$strAction();
			}
		} else {
			$bool404	= true;
		}
	} else {
		$bool404	= true;
	}
} else {
	$bool404	= true;
}

if ($bool404) {
	header('Location:index.php?action=show404&ctrl=error');
}
