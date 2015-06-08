<?php

namespace Controllers;

use Vanda\Controller;

class ProjectsController extends Controller
{
	public function __construct($session) {
		$this->session = $session;
	}

	public function add() {
		/**
		 * ICC 2015-06-08 replace !! with (bool)
		 * @link http://stackoverflow.com/a/2127324/327074
		 */
		$this->response['created'] = (bool) Projects::create($_POST['name']);
	}

	public function delete() {
		$project = Projects::open($_POST['name']);
		if( $project ) {
			$project->delete();
		}
	}

	public function download() {
		$project = Projects::open($_GET['project']);
		if( $project ) {
			$zipPath = $project->getPath().'project-all.temp.zip';
			$project->createZIP($zipPath);
			header("Content-type: application/zip"); 
			header("Content-Disposition: attachment; filename=".$project->getName().".zip");
			header("Content-length: " . filesize($zipPath));
			header("Pragma: no-cache"); 
			header("Expires: 0"); 
			readfile($zipPath);
			unlink($zipPath);
		}
		exit();
	}

	public function share() {
		$project = Projects::open($_POST['project']);
		$key = $project->createSharekey();
		$this->response['sharekey'] = $key;
	}

	public function unshare() {
		$project = Projects::open($_POST['project']);
		$project->removeSharekey();
	}
}