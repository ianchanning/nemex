<?php

use Config\Config;
// shorthand escaped print function for use in templates
function p($string) {
	echo htmlspecialchars($string);
}

function setFileMode($path) {
	$oldUmask = umask(0);
	chmod($path, Config::FILE_CREATION_MODE);
	umask($oldUmask);
}

// glob returns 'false' for empty directories on some
// PHP versions; fix it to always return an empty array.
function saneGlob($path, $mode = null) {
	$files = glob($path, $mode);
	return empty($files) ? array() : $files;
}
