<?php

class View {
	private $_content;
	private $_file;

	function __construct($path) {
		$this->_file = $path;

		$this->_content = file_get_contents($path);
	}

	function replace($data) {
		$this->_content = $this->replaceIf($data);
		$this->_content = $this->replaceVar($data);
	}

	function getContent() {
		return $this->_content;
	}

	function replaceIf($data) {
		return preg_replace_callback(
			'/{\?(.+?)\?}(.*?){\?\?}/ms'
			, function($m) use ($data) {
				if($data[$m[1]]) {
					return $m[2];
				} else {
					return '';
				}
			}, $this->_content
		);
	}

	function replaceVar($data) {
		return preg_replace_callback(
			'/{{([a-zA-Z]+)}}/'
			, function($m) use ($data) {
				return (string) $data[$m[1]];
			}, $this->_content
		);
	}
}

?>
