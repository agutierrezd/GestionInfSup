<?php

namespace DataBindings\DOM;

class Document extends \DOMDocument
{
	public function __construct() {
		parent::__construct();
		$this->encoding = 'UTF-8';
		$this->registerNodeClass('DOMElement', '\\DataBindings\\DOM\\Element');
	}

	public function loadHTML($html, $options = 0) {
		// hack to make sure document will be utf-8
		return @parent::loadHTML('<meta http-equiv="content-type" content="text/html; charset=utf-8">'.$html); // suppress warnings
	}

	public function loadHTMLFile($uri, $options = 0) {
		return @$this->loadHTML(file_get_contents($uri), $options);
	}

	public static function fromHTML($html, $options = 0) {
		$doc = new Document();
		$doc->loadHTML($html, $options);
		return $doc;
	}

	public static function fromHTMLFile($uri, $options = 0) {
		$doc = new Document();
		$doc->loadHTMLFile($uri, $options);
		return $doc;
	}
}
