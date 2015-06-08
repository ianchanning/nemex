<?php

namespace Models;

use Vanda\Model;

// require_once(NX_PATH.'lib/project.php');

class Nodes extends Model
{
	protected $path = null;
	protected $extension = 'txt';

	public $type = 'none';
	public $editable = true;

	protected function __construct($path) {
		$this->path = $path;
	}

	public function getName() {
		return basename($this->path);
	}

	public function getPath() {
		return $this->path;
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
		unlink($this->path);
	}
}
