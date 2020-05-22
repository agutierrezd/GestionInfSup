<?php

namespace DataBindings\DOM;

class Element extends \DOMElement
{
	private $data = array();

	public function data($key) {
		if (func_num_args() == 2) {
			$this->data[$key] = func_get_arg(1);
			return;
		}

		return isset($this->data[$key]) ? $this->data[$key] : null;
	}

	public function children($nodeType = 0) {
		$children = array();
		foreach ($this->childNodes as $node) {
			if ($nodeType == 0 || $node->nodeType == $nodeType) {
				$children[] = $node;
			}
		}
		return $children;
	}

	public function detach() {
		if (isset($this->parentNode)) {
			$this->parentNode->removeChild($this);
		}

		return $this;
	}

	public function before($node) {
		if (isset($this->parentNode)) {
			$this->parentNode->insertBefore($node, $this);
		}

		return $this;
	}

	public function after($node) {
		if (isset($this->parentNode)) {
			$this->parentNode->insertBefore($node, $this->nextSibling);
		}

		return $this;
	}

	public function appendTo($node) {
		$node->appendChild($this);
		return $this;
	}

	public function insertBeforeNode($node) {
		if (isset($node->parentNode)) {
			$node->parentNode->insertBefore($this, $node);
		}

		return $this;
	}

	public function removeChildNodes() {
		while (isset($this->firstChild)) {
			$this->removeChild($this->firstChild);
		}

		return $this;
	}

	public function html($html = null) {
		if (is_null($html)) {
			$html = '';

			foreach ($this->childNodes as $node) {
				$html .= $this->ownerDocument->saveHTML($node);
			}

			return $html;
		}

		$this->removeChildNodes();

		$doc = new \DOMDocument();
		$doc->loadHTML($html);

		$body = $doc->getElementsByTagName('body')->item(0);

		if (!preg_match('/^\s*</', $html)) {
			$body = $body->firstChild;
		}

		foreach ($body->childNodes as $node) {
			$node = $this->ownerDocument->importNode($node, true);
			$this->appendChild($node);
		}
	}

	public function text($text = null) {
		if (is_null($text)) {
			return $this->textContent;
		}

		$this->removeChildNodes()->appendChild(new \DOMText($text));
	}
}
