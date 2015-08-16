<?php

namespace Models;

use Config\Config;
// require_once(NX_PATH.'lib/node-image.php');
// require_once(NX_PATH.'lib/node-text.php');

class Projects extends AppModel
{
	protected $dirProtectIndex = '<?php header( "HTTP/1.1 403 forbidden" );';
	protected $fileGlob = '*.{md,jpg,jpeg,png,gif}';
	protected $titleImageGlob = '*.{jpg,jpeg,png,gif}';
	protected $sharekeyGlob = '*.sharekey';

	protected $sharekey = null;

	/**
	 * This is the path to the individual project
	 * @var string
	 */
	protected $path = null;

	public function __construct($name) {
        parent::__construct($name);

		$this->linkModel('NodeTexts');
		$this->linkModel('NodeImages');
	}

	public function create($name) {
		$path = $this->sanitizePath($name);
		// Create the project directory, the subdirectory for big images
		// and a dummy index.php to prevent dir listing
		mkdir($path);
		setFileMode($path);

		mkdir($path.Config::IMAGE_BIG_PATH);
		setFileMode($path.Config::IMAGE_BIG_PATH);

		file_put_contents($path.'index.php', $this->dirProtectIndex);
		setFileMode($path.'index.php');

		return $this->open($name);
	}

	public function open($name) {
		$path = $this->sanitizePath($name);
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

	public function openWithSharekey($name, $sharekey) {
		$project = $this->open($name);

		// Make sure the project is shared and the sharekey matches
		if ( $project && $project->isShared() && $project->getSharekey() == $sharekey ) {
			return $project;
		}
		return null;
	}

	protected function sanitizePath($name) {
		$name = iconv('UTF-8', 'ASCII//IGNORE', $name);
		$name = preg_replace('/\W+/', '-', $name);
		return __DIR__ . DIRECTORY_SEPARATOR . Config::PROJECTS_PATH.$name.DIRECTORY_SEPARATOR;
	}

	public function getName() {
		return basename($this->getPath());
	}

	public function getTitleImage() {
		$images = saneGlob($this->getPath().$this->titleImageGlob, GLOB_BRACE);
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
		unlink($this->getPath().'index.php');
		$this->removeSharekey();

		rmdir($this->getPath().Config::IMAGE_BIG_PATH);
		rmdir($this->getPath());
	}

	public function isShared() {
		$key = $this->getSharekey();
		return !empty($key);
	}

	public function getSharekey() {
		// Load sharekey if we didn't have one already
		if ( empty($this->sharekey) ) {
			$sharekeys = saneGlob($this->getPath().$this->sharekeyGlob, GLOB_BRACE);
			if ( !empty($sharekeys) && preg_match('/(\w{32})\.sharekey$/', $sharekeys[0], $match) ) {
				$this->sharekey = $match[1];
			}
		}

		return $this->sharekey;
	}

	public function removeSharekey() {
		$key = $this->getSharekey();
		if ( !empty($key) ) {
			unlink($this->getPath().$key.'.sharekey');
		}
		$this->sharekey = null;
	}

	public function createSharekey() {
		// Remove old sharekey, if present
		$this->removeSharekey();

		// Create a new .sharekey file with a random name
		$key = md5(rand().time());
		$keyfile = $this->getPath().$key.'.sharekey';
		file_put_contents($keyfile, time());
		setFileMode($keyfile);

		$this->sharekey = $key;
		return $this->sharekey;
	}

	public function getNode($name) {
		if ( preg_match('/\.(jpg|jpeg|png|gif)$/i', $name) ) {
			return $this->NodeImages->open($this->getPath().$name);
		}
		else if ( preg_match('/\.md$/i', $name) ) {
			return $this->NodeTexts->open($this->getPath().$name);
		}
		return null;
	}

	public function getNodes() {
		$nodes = array();
		foreach ( $this->getFiles() as $file ) {
			$nodes[] = $this->getNode(basename($file));
		}
		return $nodes;
	}

	public function getNodeCount() {
		return count($this->getFiles());
	}

	protected function getFiles() {
		$files = saneGlob($this->getPath().$this->fileGlob, GLOB_BRACE);
		rsort($files);
		return $files;
	}

	public function createZIP($zipPath) {
		$zip = new ZipArchive;
		if ( $zip->open($zipPath, ZipArchive::CREATE) ) {
			foreach ( $this->getNodes() as $node ) {
				$zip->addFile($node->getOriginalPath(), $node->getName());
			}

			$zip->close();
			return true;
		}
		return false;
	}

	public function getProjectList() {
		$projects = array();
		foreach ( saneGlob(__DIR__ . DIRECTORY_SEPARATOR . Config::PROJECTS_PATH.'*', GLOB_ONLYDIR) as $dir ) {
			$project = $this->open( basename($dir) );
			if ( !empty($project) ) { // Make sure the project could be opened
				$projects[] = $project;
			}
		}
		return $projects;
	}
}
