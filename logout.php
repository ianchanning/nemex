<?php
	if (session_id() === '') {
		session_start();
	}
    session_destroy();

    $hostname = $_SERVER['HTTP_HOST'];
    $path = dirname($_SERVER['PHP_SELF']);

    header('Location: http://'.$hostname.($path == DIRECTORY_SEPARATOR ? '' : $path).'/login.php');
