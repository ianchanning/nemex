<?php

use Config\Config;

/**
 * shorthand escaped print function for use in templates
 * @param  string $string unescaped HTML
 * @return string         escaped HTML
 */
function p($string) {
	echo htmlspecialchars($string);
}
