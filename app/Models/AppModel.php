<?php

namespace Models;

use Vanda\Model;

class AppModel extends Model
{
	/**
	 * Convert file path to app relative URL
	 * @param  string $path File path
	 * @return string       relative URL
	 */
	public function getPathUrl($path) {
		$relativePath = str_replace(NX_PATH, '', $path);
		return str_replace('\\', '/', $relativePath);
	}

}
