<?php

require_once(NX_PATH.'lib/project.php');
require_once(NX_PATH.'lib/node-text.php');

class AjaxController {
	public $response = array();
	protected $session = null;

	public function __construct($session) {
		$this->session = $session;
	}

	public function logout() {
		$this->session->logout();
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

	public function downloadNode() {
		$project = Projects::open($_GET['project']);
		$node = $project->getNode($_GET['downloadNode']);

		if( $node ) {
			header('Content-type: application/octet-stream');
			header('Content-Disposition: attachment; filename='.$node->getName());

			readfile($node->getOriginalPath());
		}
		exit();
	}

	public function addNode() {
		$project = Projects::open($_POST['project']);
		if( $project ) {
			$node = NodeText::create($project->getPath(), $_POST['content']);
		}
	}

	public function deleteNode() {
		$project = Projects::open($_POST['project']);
		$node = $project->getNode($_POST['node']);
		$node->delete();
	}

	public function updateNode() {
		$project = Projects::open($_POST['project']);
		$node = $project->getNode($_POST['node']);
		if( $node instanceof NodeText ) {
			$node->edit($_POST['content']);
		}
	}

	public function upload() {
		$project = Projects::open($_POST['project']);
		foreach( $_FILES as $file ) {
			$node = NodeImage::createFromUpload($project->getPath(), $file['tmp_name']);
		}
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

