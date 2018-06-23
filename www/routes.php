<?php

class Route {
	private $_controller;
	private $_action;

	// TODO: load controllers from file
	private $_controllers = array('pages' => ['home', 'error']);

	private $_page;

	function __construct($controller, $action) {
		if(!array_key_exists($controller, $this->_controllers) || !in_array($action, $this->_controllers[$controller])) {
			$this->_controller = 'pages';
			$this->_action = 'error';
		} else {
			$this->_controller = $controller;
			$this->_action = $action;
		}
	}

	/**
	 * Call the right function in the right controller
	 */
	public function call() {
		require_once('controller/Controller.php');
		require_once('controller/' . ucfirst($this->_controller) . 'Controller.php');

		$className = ucfirst($this->_controller) . 'Controller';

		$this->_page = new $className($this->_action);

		// Call the function corresponding to the action
		$this->_page->call();
	}

	public function display() {
		if($this->_page->type == 'html') {

			$data = array();
			$data['title'] = $this->_page->title;
			$data['body'] = $this->_page->body;
			$data['bScript'] = true;
			$data['script'] = 'nimportequoi';

			$v = new View('view/layout.html');
			$v->replace($data);
			echo $v->getContent();
		} else {
			// for ajax
			header("Content-Type: text/plain");
			echo $this->_page->body;
		}
	}
}

?>
