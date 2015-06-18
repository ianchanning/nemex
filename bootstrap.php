<?php

date_default_timezone_set('UTC');

/**
 * Autoload the app classes
 *
 * This means:
 *     `use \Models\Pages` will load `app\Models\Pages.php`
 *     `use \Controllers\PagesController` will load `app\Controllers\PagesController.php`
 *
 * @link http://php.net/manual/en/function.spl-autoload.php#92767
 */
set_include_path(get_include_path() . PATH_SEPARATOR . 'app/');
spl_autoload_register();

require_once __DIR__ . '/vendor/autoload.php';

/**
 * @todo This shouldn't just be a hard coded require
 */
require_once __DIR__ . '/vendor/ianchanning/vandaphp-core/src/bootstrap.php';

session_start();

/**
 * Nemex index.php code
 */
define( 'NX_PATH', realpath('./').'/' );

use \Config\config;
use \Models\Sessions;
use utils_vanda;
use \Models\Projects;

header( 'Content-type: text/html; Charset=UTF-8' );
$session = new Session('nemex', NX_PATH, CONFIG::USER, CONFIG::PASSWORD);

// Attempting to login?
if( !empty($_POST['username']) && !empty($_POST['password']) ) {
	if( $session->login($_POST['username'], $_POST['password']) ) {
		header('location: ./');
		exit();
	}
}

// Not authed for this nemex? Maybe we have a sharekey for the project?
// If not, just show the login form
if( !$session->isAuthed() ) {
	if( count($_GET) == 2 ) {
		$get = array_keys($_GET);
		$projectName = $get[0];
		$sharekey = $get[1];

		$project = new Project();
		$project->openWithSharekey($projectName, $sharekey);
		if( $project ) {
			$nodes = $project->getNodes();
			include 'Views/projects/project-readonly.html.php';
			exit();
		}
	}

	include 'Views/pages/login.html.php';
}

// Show project or project list
else {
	if( !empty($_GET) ) {
		$projectName = key($_GET);
		$project = new Project();
		$project->open($projectName);
		if( $project ) {
			$nodes = $project->getNodes();
			include 'Views/projects/project.html.php';
		}
		else {
			header( "HTTP/1.1 404 Not Found" );
			echo 'No Such Project: '.htmlspecialchars($projectName);
		}
	}
	else {
		$project = new Project();
		/**
		 * @todo This should be static and used to be in the original nemex
		 * @var array of projects
		 */
		$projects = $project->getProjectList();
		include 'Views/projects/project-list.html.php';
	}
}
