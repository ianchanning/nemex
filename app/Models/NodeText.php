<?php

namespace Models;

class NodeText extends Nodes
{
	protected $extension = 'md';
	public $type = 'text';

	public function open($path) {
		return is_file($path)
			? new self($path)
			: null;
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

		if( file_put_contents($newPath, $content) ) {
			setFileMode($newPath);
			$this->delete();
			$this->path = $newPath;
		}
	}
}
