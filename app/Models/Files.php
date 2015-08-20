<?php

namespace Models;

use Config\Config;

/**
 * Wrapper for glob/file interaction
 */
class Files extends AppModel
{

	/**
	 * @todo These extensions should be passed in by the calling model
	 */
	protected $imageExtensions 		= array('jpg', 'jpeg', 'png', 'gif');
	protected $textExtensions 		= array('md');
	protected $shareKeyExtension 	= 'sharekey';

	protected $dirProtectIndex 		= '<?php header( "HTTP/1.1 403 forbidden" );';
	protected $fileGlob 			= ''; // '*.{md,jpg,jpeg,png,gif}';
	protected $titleImageGlob 		= ''; // '*.{jpg,jpeg,png,gif}';
	protected $shareKeyGlob 		= ''; // '*.sharekey';


	public function __construct($name) {
        parent::__construct($name);

		$extensionGlob = '*.{%s}';
		$this->fileGlob 		= sprintf($extensionGlob, implode(',', array_unique(array_merge($this->textExtensions, $this->imageExtensions))));
		$this->titleImageGlob 	= sprintf($extensionGlob, implode(',', $this->imageExtensions));
		$this->shareKeyGlob 	= sprintf($extensionGlob, $this->shareKeyExtension);
	}

	/**
	 * Check if a file is a recognised image
	 * @param  string  $name file name
	 * @return boolean       If the file has a recognised image extension
	 */
	public function isImage($name) {
		return $this->hasExtension($name, $this->imageExtensions);
	}

	/**
	 * Check if a file is a recognised text
	 * @param  string  $name file name
	 * @return boolean       If the file has a recognised text extension
	 */
	public function isText($name) {
		return $this->hasExtension($name, $this->textExtensions);
	}

	/**
	 * Look for a 32 character filename with .sharekey extension
	 * @param  string $name   file name
	 * @param  array &$match preg_match match array
	 * @return boolean         found the key
	 */
	public function findShareKey($name, &$match) {
		return preg_match(sprintf('/(\w{32})\.%s$/', $this->shareKeyExtension), $name, $match);
	}

	public function getImages($path) {
		return $this->saneGlob($path.$this->titleImageGlob, GLOB_BRACE);
	}

	public function getShareKey($path) {
			$sharekeys = $this->saneGlob($path.$this->shareKeyGlob, GLOB_BRACE);
			if ( !empty($sharekeys) &&  $this->findShareKey($sharekeys[0], $match) ) {
				return $match[1];
			}
	}

	public function deleteShareKey($path, $key) {
		$this->delete($this->getKeyPath($path, $key));

	}

	public function createShareKey($path, $key) {
		$file = $this->getKeyPath($path, $key);
		$this->create($file, time());
	}

	public function create($path, $contents) {
		if (file_put_contents($path, $contents)) {
			$this->setFileMode($path);
			return true;
		} else {
			return false;
		}
	}

	protected function getKeyPath($dirPath, $key) {
		return $dirPath.$key.'.'.$this->shareKeyExtension;
	}

	public function delete($path) {
		unlink($path);
	}

	protected function deleteGlob($pattern, $mode = null) {
		array_map('unlink', $this->saneGlob($pattern, $mode));
	}

	/**
	 * Check a file against an extension
	 * @param  strin  $name       file name
	 * @param  array  $extensions file extensions
	 * @return boolean             if the file has one of the extensions
	 */
	private function hasExtension($name, $extensions) {
		$regex = sprintf('/\.(%s)$/i', implode('|', $extensions));
		return preg_match($regex, $name);
	}
	/**
	 * Give full permissions on a file
	 * @param string $path File path
	 */
	public function setFileMode($path) {
		$oldUmask = umask(0);
		chmod($path, Config::FILE_CREATION_MODE);
		umask($oldUmask);
	}

	/**
	 * Get an array of file names
	 *
	 * glob returns 'false' for empty directories on some
	 * PHP versions; fix it to always return an empty array.
	 *
	 * @param  string  $path Glob directory pattern
	 * @param  integer $mode Glob flag
	 * @return array         file names
	 */
	public function saneGlob($path, $mode = null) {
		$files = glob($path, $mode);
		return empty($files) ? array() : $files;
	}

	/**
	 * Create the project directory, the subdirectory for big images
	 * and a dummy index.php to prevent dir listing
	 * @param  string $projectName name of the project
	 */
	public function createProjectDirectory($path, $name) {
		$dir = $this->sanitizePath($path, $name);
		$this->createDirectory($dir);

		$imageDir = $path.Config::IMAGE_BIG_PATH;
		$this->createDirectory($imageDir);

		$this->create($path.'index.php', $this->dirProtectIndex);
	}

	public function createDirectory($path) {
		mkdir($path);
		$this->setFileMode($path);
	}

	public function deleteProjectDirectory($path) {
		$this->delete($path.'index.php');
		rmdir($path.Config::IMAGE_BIG_PATH);
		rmdir($path);
	}

	public function sanitizePath($path, $name) {
		$name = iconv('UTF-8', 'ASCII//IGNORE', $name);
		$name = preg_replace('/\W+/', '-', $name);
		return $path.$name.DIRECTORY_SEPARATOR;
	}

	public function getProjectDirectories($path) {
		return $this->saneGlob($path.'*', GLOB_ONLYDIR);
	}

	/**
	 * Get array of all recognised file types
	 * @return array reverse sorted filenames
	 */
	public function getFiles($path) {
		$files = $this->saneGlob($path.$this->fileGlob, GLOB_BRACE);
		rsort($files);
		return $files;
	}

}