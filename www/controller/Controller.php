<?php

class Controller {
	protected $_action;

	public $title = 'Default title';
	public $type = 'html';
	public $body = 'nothing yet..';

	function __construct($action) {
		$this->_action = $action;
	}

	public function call() {
		ob_start();
		$this->{ $this->_action }();
		$this->body = ob_get_contents();
		ob_end_clean();
	}
}

?>
