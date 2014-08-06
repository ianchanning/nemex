<?php
/** 
 * Convert a view url to a Model name
 *
 * @param string $view The lower case URL view name, e.g. licence_types
 * @return string The converted name e.g. licence_types => licence types => Licence Types => LicenceTypes
 */
function view_to_model($view) {
	return str_replace(' ', '', ucwords(str_replace('_',' ', $view)));
}

/** 
 * Convert a Model name to a view url (http://www.php.net/manual/en/function.ucwords.php#92092). Used in controller->load_model
 *
 * @param string $model The proper case Model name, e.g. LicenceTypes
 * @return string The converted name e.g. LicenceTypes => licence_types
 */
function model_to_view($model) {
	// e.g. from LicenceTypes replace 'eT' with 'e_T'
	return strtolower(preg_replace('/([^A-Z])([A-Z])/', "$1_$2", $model)); 
}

/** 
 * Redirect to a new page, wrapper onto the PHP header function
 * 
 * @param string $view View to redirect to
 * @param string $action Action to redirect to
 * @return none Uses HTTP header 301 redirect
 */
function redirect($view, $action = null) {
	if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === 'off') {
		$protocol = 'http://';
	} else {
		$protocol = 'https://';
	}
	/**
	 * @var the root URL of the website
	 * @link http://stackoverflow.com/a/3429657/327074 Get base directory of current script
	 */
	$base_url = $protocol . $_SERVER['SERVER_NAME'] . dirname($_SERVER['PHP_SELF']);
	
	$url = $base_url."?v=$view";
	if (!is_null($action)) {
		$url .= "&a=$action";
	}
	exit(header("Location: $url"));
}
