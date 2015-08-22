<?php

namespace Controllers;

class ProjectsController extends AppController
{

	/**
     * Check if model action is authorised
     *
     * Override to allow readonly projects access
     * @param  string $modelName
     * @param  string $action
     * @return boolean           If the action is autorised
     */
    protected function auth($modelName, $action) {
		if ($modelName === 'Projects' && $action === 'readonly') {
			return true;
		} else {
			return parent::auth($modelName, $action);
		}
	}

	/**
	 * List all existing projects
	 */
	public function index() {
		$projects = $this->Projects->getProjectList();
        $this->set(compact('projects'));
	}

	/**
	 * View a shared project
	 */
    public function readonly() {
		$projectName = $_GET['name'];
		$sharekey = $_GET['key'];

		$project = $this->Projects->openWithSharekey($projectName, $sharekey);
		if ( !empty($project) ) {
			$nodes = $project->getNodes();
	        $this->set(compact('nodes', 'project'));
		} else {
			$this->redirect('pages','login');
		}
	}

	/**
	 * Open a private project to view
	 */
	public function view() {
		$projectName = $_GET['name'];
		$project = $this->Projects->open($projectName);
		if ( !empty($project) ) {
			$nodes = $project->getNodes();
			$this->set(compact('nodes', 'project'));
		}
	}

	/**
	 * Create a private empty project
	 */
	public function add() {
		$this->layout = '';
		/**
		 * ICC 2015-06-08 replace !! with (bool)
		 * @link http://stackoverflow.com/a/2127324/327074
		 */
		$this->response['created'] = (bool) $this->Projects->create($_POST['name']);
	}

	/**
	 * Delete a private project if it exists
	 */
	public function delete() {
		$this->layout = '';
		$project = $this->Projects->open($_POST['name']);
		if ( !empty($project) ) {
			$project->delete();
		}
	}

	/**
	 * Download a private project to a zip file
	 */
	public function download() {
		$this->layout = '';
		$project = $this->Projects->open($_GET['project']);
		if ( !empty($project) ) {
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

	/**
	 * Generate a link to share a project
	 */
	public function share() {
		$this->layout = '';
		$project = $this->Projects->open($_POST['project']);
		if ( !empty($project) ) {
			$key = $project->createSharekey();
			$this->response['sharekey'] = $key;
		}
	}

	/**
	 * Delete the key that allowed readonly access
	 */
	public function unshare() {
		$this->layout = '';
		$project = $this->Projects->open($_POST['project']);
		if ( !empty($project) ) {
			$project->removeSharekey();
		}
	}

}