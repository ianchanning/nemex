<?php
/**
 * Send messages between models and views
 */
class Controller {
	public $modelName = '';
	public $viewVars = array();
	public $layout = '';
/**
 * An array containing the class names of the models this controller uses.
 *
 * @var array Array of model objects.
 * @access public
 */
	public $modelNames = array();
	
	/**
	 * The controller view class
	 * @var object
	 * @access public
	 */
	public $view = null;
	
	public function __construct($model_name = null) {
		$this->modelName = $model_name;
		$this->loadModel($model_name);
		$this->layout = 'default';
		$this->view = new View();
	}
	
/**
 * add variables to the array that is accessed by the view 
 *
 * @param $vars array var_name => var
 * @access public
 */
	public function set($vars) {
		$this->viewVars = array_merge($this->viewVars, $vars);
	}
	
/**
 * Loads and instantiates models required by this controller.
 *
 * @param string $model_class Name of model class to load
 * @return mixed true when single model found and instance created error returned if models not found.
 * @access public
 */
	public function loadModel($model_class = null) {
		require_once('models'.DIRECTORY_SEPARATOR.model_to_view($model_class).'.php');
		
		$this->modelNames[] = $model_class;
		$this->{$model_class} = new $model_class($model_class);
	}
	
/**
 * extract the view variables and apply them to the view
 * 
 * @access public
 */
	public function renderView($view, $action) {
		extract($this->viewVars);
		
		ob_start();
		require_once('views'.DIRECTORY_SEPARATOR.$view.DIRECTORY_SEPARATOR.$action.'.php');
		$content_for_layout = ob_get_clean();
		
		$this->view->render($content_for_layout, $this->layout);
	}
}
