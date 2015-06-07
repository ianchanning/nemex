<?php
	date_default_timezone_set('UTC');
	include('../auth.php');

	$path = '../projects/'.$_POST['project'].'/big/'.$_POST['itemId'];

	if (file_exists($path)) {
		header('Content-type: image/jpg');
		header('Content-Disposition: attachment; filename='.$_POST['itemId']);
		readfile($path);
	}
