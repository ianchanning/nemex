<?php

namespace Controllers;

class ProjectsController extends AppController
{

	public function index() {
		$projects = $this->Projects->getProjectList();
        $this->set(compact('projects'));
	}

	public function readonly() {
		$get = array_keys($_GET);
		$projectName = $get[0];
		$sharekey = $get[1];

		$project = $this->Projects->openWithSharekey($projectName, $sharekey);
		if ( $project ) {
			$nodes = $this->Projects->getNodes();
	        $this->set(compact('nodes', 'project'));
		}
	}

	public function view() {
		$projectName = $_GET['name'];
		$project = $this->Projects->open($projectName);
		if ( !empty($project) ) {
			$nodes = $project->getNodes();
			$this->set(compact('nodes', 'project'));
		}
	}

	public function add() {
		/**
		 * ICC 2015-06-08 replace !! with (bool)
		 * @link http://stackoverflow.com/a/2127324/327074
		 */
		$this->response['created'] = (bool) $this->Projects->create($_POST['name']);
	}

	public function delete() {
		$project = $this->Projects->open($_POST['name']);
		if ( $project ) {
			$project->delete();
		}
	}

	public function download() {
		$project = $this->Projects->open($_GET['project']);
		if ( $project ) {
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
	}

	public function share() {
		$project = $this->Projects->open($_POST['project']);
		$key = $project->createSharekey();
		$this->response['sharekey'] = $key;
	}

	public function unshare() {
		$project = $this->Projects->open($_POST['project']);
		$project->removeSharekey();
	}

}