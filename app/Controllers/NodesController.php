<?php

namespace Controllers;

class NodesController extends AppController
{

    public function __construct($modelName = null) {
        parent::__construct($modelName);
        $this->loadModel('Projects');
        $this->loadModel('NodeTexts');
        $this->loadModel('NodeImages');
    }

    public function download() {
        $this->layout = '';
        $project = $this->Projects->open($_GET['project']);
        $node = $project->getNode($_GET['node']);

        if ( $node ) {
            header('Content-type: application/octet-stream');
            header('Content-Disposition: attachment; filename='.$node->getName());

            readfile($node->getOriginalPath());
        }
    }

    public function add() {
        $this->layout = '';
        $project = $this->Projects->open($_POST['project']);
        if ( $project ) {
            $node = $this->NodeTexts->create($project->getPath(), $_POST['content']);
        }
    }

    public function delete() {
        $this->layout = '';
        $project = $this->Projects->open($_POST['project']);
        $node = $project->getNode($_POST['node']);
        $node->delete();
    }

    public function update() {
        $this->layout = '';
        $project = $this->Projects->open($_POST['project']);
        $node = $project->getNode($_POST['node']);
        if ( $node instanceof \Models\Nodes ) {
            $node->edit($_POST['content']);
        }
    }

    public function upload() {
        $this->layout = '';
        $project = $this->Projects->open($_POST['project']);
        foreach( $_FILES as $file ) {
            $node = $this->NodeImages->createFromUpload($project->getPath(), $file['tmp_name']);
        }
    }

}
