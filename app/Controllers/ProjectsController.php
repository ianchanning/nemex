<?php

namespace Controllers;

use Vanda\Controller;

class ProjectsController extends Controller
{
	public function __construct($session) {
		$this->session = $session;
	}

	public function addProject() {
		$this->response['created'] = !!Projects::create($_POST['name']);
	}

	public function deleteProject() {
		$project = Projects::open($_POST['name']);
		if( $project ) {
			$project->delete();
		}
	}

	public function downloadProject() {
		$project = Projects::open($_GET['downloadProject']);
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

	public function shareProject() {
		$project = Projects::open($_POST['project']);
		$key = $project->createSharekey();
		$this->response['sharekey'] = $key;
	}

	public function unshareProject() {
		$project = Projects::open($_POST['project']);
		$project->removeSharekey();
	}
}