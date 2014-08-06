<?php
/**
 * Central class to generate the view output
 */
class View {
	/**
	 * Create the output by combining content with the layout
	 * 
	 * @param string $content_for_layout content to be echoed in the $layout
	 * @param string $layout Layout template
	 */
	function render($content_for_layout, $layout) {
		require_once('views'.DIRECTORY_SEPARATOR.'layouts'.DIRECTORY_SEPARATOR.$layout.'.php');
	}
}
