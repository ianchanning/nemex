<?php

namespace Controllers;

use Vanda\Controller;

class NodesController extends Controller
{
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

}
