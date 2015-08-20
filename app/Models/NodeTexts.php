<?php

namespace Models;

class NodeTexts extends Nodes
{
	protected $extension = 'md';
	public $type = 'text';

	public function open($path) {
		if (is_file($path)) {
			$node = new NodeTexts('NodeTexts');
			$node->setPath($path);
			return $node;
		} else {
			return null;
		}
	}

	public function create($basePath, $content) {
		$path = $basePath.$this->getNewName($this->extension);
		$this->Files->create($path, $content);

		return $this->open($path);
	}

	public function getContent() {
		return file_get_contents($this->path);
	}

	/**
	 * Write the new file and delete the old
	 * @param  string $content text contents
	 * @return boolean          successful edit
	 */
	public function edit($content) {
		//
		$newPath = dirname($this->path).DIRECTORY_SEPARATOR.$this->getNewName($this->extension);

		if ($this->Files->create($newPath, $content)) {
			$this->delete();
			$this->path = $newPath;
			return true;
		} else {
			return false;
		}
	}

}
