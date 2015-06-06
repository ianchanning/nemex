<?php
    $hostname = $_SERVER['HTTP_HOST'];
    $path = dirname($_SERVER['PHP_SELF']);
    
    if (!isset($_SESSION['angemeldet']) || !$_SESSION['angemeldet']) {
    	header('Location: http://'.$hostname.($path == DIRECTORY_SEPARATOR ? '' : $path).'/login.php');  
    	exit;
    }


?>