<?php

class PagesController extends Controller {
	function __construct($action) {
		parent::__construct($action);

		$this->title = 'Classrooms';
	}

	protected function home() {
		// TODO: refactor this part, but be carfull of the ajax
		$v = new View('view/pages/' . $this->_action . '.html');

		$this->title = 'Home';

		// Operations
		$data = array();
		$data['pseudo'] = 'Smiley32';

		// Display
		$v->replace($data); // replace if we want to
		echo $v->getContent();
	}
}

?>
