<?php

namespace Models;

// require_once(NX_PATH.'lib/project.php');

class Nodes extends AppModel
{
	protected $path = null;
	protected $extension = 'txt';

	public $type = 'none';
	public $editable = true;

	public function __construct($name) {
        parent::__construct($name);

		$this->linkModel('Files');
	}

	public function getName() {
		return basename($this->path);
	}

	public function getPath() {
		return $this->path;
	}

	public function setPath($path) {
		return $this->path = $path;
	}

	public function getOriginalPath() {
		return $this->path;
	}

	public function getTimestamp() {
		return filemtime($this->path);
	}

	protected function getNewName($extension) {
		return time().'-'.substr(md5(uniqid(rand(), true)),0, 8).'.'.$extension;
	}

	public function delete() {
		$this->Files->delete($this->path);
	}
}
