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
		$path = $basePath.$this->getNewName('md');
		file_put_contents($path, $content);
		setFileMode($path);

		return $this->open($path);
	}

	public function getContent() {
		return file_get_contents($this->path);
	}

	public function edit($content) {
		// Write the new file and delete the old
		$newPath = dirname($this->path).'/'.$this->getNewName($this->extension);

		if ( file_put_contents($newPath, $content) ) {
			setFileMode($newPath);
			$this->delete();
			$this->path = $newPath;
		}
	}
}
