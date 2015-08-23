<?php

namespace Models;

use Config\Config;
// require_once(NX_PATH.'lib/node-image.php');
// require_once(NX_PATH.'lib/node-text.php');

class Projects extends AppModel
{
    protected $sharekey = null;

    /**
     * This is the path to the individual project
     * @var string
     */
    protected $path = null;

    protected $directory = null;

    public function __construct($name) {
        parent::__construct($name);

        $this->linkModel('NodeTexts');
        $this->linkModel('NodeImages');
        $this->linkModel('Files');

        $this->directory = __DIR__ . DIRECTORY_SEPARATOR . Config::PROJECTS_PATH;
    }

    public function create($name) {

        $this->Files->createProjectDirectory($this->directory, $name);
        return $this->open($name);
    }

    public function open($name) {
        $path = $this->Files->sanitizePath($this->directory, $name);
        if (is_dir($path)) {
            $project = new Projects('Projects');
            $project->setPath($path);
            return $project;
        } else {
            return null;
        }
    }

    public function setPath($path) {
        $this->path = $path;
    }

    public function getPath() {
        return $this->path;
    }

    public function openWithShareKey($name, $sharekey) {
        $project = $this->open($name);

        // Make sure the project is shared and the sharekey matches
        if ( $project && $project->isShared() && $project->getShareKey() == $sharekey ) {
            return $project;
        }
        return null;
    }

    public function getName() {
        return basename($this->getPath());
    }

    public function getTitleImage() {
        $images = $this->Files->getImages($this->getPath());
        if ( !empty($images) ) {
            rsort($images);
            return "url('".$this->getPathUrl($this->getPath().basename($images[0]))."')";
        } else {
            return 'none';
        }
    }

    public function delete() {
        foreach ( $this->getNodes() as $node ) {
            $node->delete();
        }
        $this->removeShareKey();
        $this->Files->deleteProjectDirectory($this->getPath());
    }

    public function isShared() {
        $key = $this->getShareKey();
        return !empty($key);
    }

    public function getShareKey() {
        // Load sharekey if we didn't have one already
        if ( empty($this->shareKey) ) {
            $this->setShareKey();
        }

        return $this->shareKey;
    }

    public function setShareKey($key = null) {
        if (is_null($key)) {
            $this->shareKey = $this->Files->getShareKey($this->getPath());
        } else {
            $this->shareKey = $key;
        }
    }

    public function removeShareKey() {
        $key = $this->getShareKey();
        if ( !empty($key) ) {
            $this->Files->deleteShareKey($this->getPath(), $key);
        }
        $this->shareKey = null;
    }

    /**
     * Create a new .sharekey file with a random name
     * @return string key
     */
    public function createShareKey() {
        // Remove old sharekey, if present
        $this->removeShareKey();

        $key = md5(rand().time());
        $this->Files->createShareKey($this->getPath(), $key);
        $this->setShareKey($key);
        return $key;
    }

    /**
     * Get either NodeImages or NodeTexts depending on file extension
     * @param  string $name Node file name
     * @return object       NodeImages or NodeTexts or null if invalid extension
     */
    public function getNode($name) {
        if ( $this->Files->isImage($name) ) {
            return $this->NodeImages->open($this->getPath().$name);
        }
        else if ( $this->Files->isText($name) ) {
            return $this->NodeTexts->open($this->getPath().$name);
        }
        return null;
    }

    /**
     * Get array of all nodes in this project
     * @return array Node objects
     */
    public function getNodes() {
        $nodes = array();
        foreach ( $this->getFiles() as $file ) {
            $nodes[] = $this->getNode(basename($file));
        }
        return $nodes;
    }

    /**
     * Get count of all recognised file types
     * @return integer count
     */
    public function getNodeCount() {
        return count($this->getFiles());
    }

    /**
     * Get array of all recognised file types
     * @return array reverse sorted filenames
     */
    protected function getFiles() {
        return $this->Files->getFiles($this->getPath());
    }

    /**
     * Zip up all the nodes under this project
     *
     * Requires ZipArchive PECL extension
     * @link http://php.net/manual/en/zip.installation.php
     * @param  string  $zipPath where to create the zip
     * @return boolean          true if successfully created
     */
    public function createZIP($zipPath) {
        /**
         * @todo Remove the Download link from the UI if the class doesn't exist
         */
        if (class_exists('ZipArchive')) {
            $zip = new \ZipArchive();
            if ( $zip->open($zipPath, \ZipArchive::CREATE) ) {
                foreach ( $this->getNodes() as $node ) {
                    $zip->addFile($node->getOriginalPath(), $node->getName());
                }

                $zip->close();
                return true;
            }
        }
        return false;
    }

    /**
     * Get all projects
     * @return array Project object array
     */
    public function getProjectList() {
        $projects = array();
        foreach ( $this->Files->getProjectDirectories($this->directory)  as $dir ) {
            $project = $this->open( basename($dir) );
            if ( !empty($project) ) { // Make sure the project could be opened
                $projects[] = $project;
            }
        }
        return $projects;
    }
}
