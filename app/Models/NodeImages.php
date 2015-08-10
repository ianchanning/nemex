<?php

namespace Models;

use Config\Config;
// require_once(NX_PATH.'lib/node.php');
// require_once(NX_PATH.'lib/image.php');

class NodeImages extends Nodes
{
	protected $extension = 'jpg';
	public $type = 'image';

	public $editable = false;


	public function open($path) {
		if (is_file($path)) {
			$node = new NodeImages('NodeImages');
			$node->setPath($path);
			return $node;
		} else {
			return null;
		}
	}

	public function createFromUpload($basePath, $uploadPath) {
		$image = new Images($uploadPath);
		if ( !$image->valid ) {
			return null;
		}

		$targetName = $this->getNewName($image->extension);
		$scaledTargetPath = $basePath.$targetName;
		$originalTargetPath = $scaledTargetPath;

		// Do we want to create a scaled down version of this image?
		if ( $image->width > Config::IMAGE_MAX_WIDTH ) {
			$scaledWidth = Config::IMAGE_MAX_WIDTH;
			$scaledHeight = ($scaledWidth/$image->width) * $image->height;
			$image->writeThumb(
				$scaledTargetPath, Config::IMAGE_JPEG_QUALITY,
				$scaledWidth, $scaledHeight,
				Config::IMAGE_SHARPEN
			);
			setFileMode($scaledTargetPath);

			// We created a scaled down version, so the original has to be moved
			// in a separate big/ folder
			$originalTargetPath = $basePath.Config::IMAGE_BIG_PATH.$targetName;
		}

		// If the image had an exif orientation, save the rotated version
		// and delete the original.
		if ( $image->exifRotated ) {
			$image->write($originalTargetPath, Config::IMAGE_JPEG_QUALITY);
			unlink($uploadPath);
		}
		// No EXIF orientation? Just move the original.
		else {
			move_uploaded_file($uploadPath, $originalTargetPath);
		}
		setFileMode($originalTargetPath);

		return $this->open($scaledTargetPath);
	}

	protected function getBigPathName() {
		return dirname($this->path).'/'.Config::IMAGE_BIG_PATH.basename($this->path);
	}

	public function getOriginalPath() {
		$bigPath = $this->getBigPathName();
		return file_exists($bigPath)
			? $bigPath
			: $this->path;
	}

	public function delete() {
		$bigPath = $this->getBigPathName();
		if ( file_exists($bigPath) ) {
			unlink($bigPath);
		}

		parent::delete();
	}
}