<?php

namespace DataBindings\Data;

class Scope
{
	private static $global;
	private $data = array();
	private $watches = array();

	public $parentScope;
	public $childScopes = array();

	public function __construct(Scope $parentScope = null) {
		$this->parentScope = $parentScope;
	}

	public function __set($name, $value) {
		$this->add($name, $value);
	}

	public function __get($name) {
		return $this->get($name);
	}

	public function __isset($name) {
		return $this->exists($name);
	}

	public function __unset($name) {
		$this->remove($name);
	}

	public function set($data) {
		$data = (array)$data;
		if (!$this->compare($this->data, $data)) {
			$this->data = $data;
			$this->digest($data);
		}
	}

	public function add($name, $value) {
		if (!isset($this->data[$name]) || !$this->compare($this->data[$name], $value)) {
			$this->data[$name] = $value;
			$this->digest(array('name' => $name, 'value' => $value));
		}
	}

	public function get($name) {
		if (isset($this->data[$name])) {
			return $this->data[$name];
		}

		if ($this->parentScope) {
			return $this->parentScope->get($name);
		}

		return null;
	}

	public function exists($name) {
		if (isset($this->data[$name])) {
			return true;
		}

		if ($this->parentScope) {
			return $this->parentScope->exists($name);
		}

		return false;
	}

	public function remove($name) {
		unset($this->data[$name]);
	}

	public function &ref($name) {
		if (isset($this->data[$name])) {
			return $this->data[$name];
		}

		if ($this->parentScope) {
			return $this->parentScope->get($name);
		}

		return null;
	}

	public function parse($expression) {
		$parser = new \DataBindings\Expression\Parser();
		return $parser->parse($expression, $this);
	}

	public function getData() {
		return $this->data;
	}

	public function create(\DOMNode $node) {
		$scope = new Scope($this);
		$this->childScopes[] = $scope;
		$node->data('scope', $scope);
		return $scope;
	}

	// removed deep compare because of some infinite loop with some users
	public function compare($var1, $var2) {
		if (gettype($var1) != gettype($var2)) {
			return false;
		}

		if (is_array($var1)) {
			if (count($var1) != count($var2)) {
				return false;
			}

			foreach ($var1 as $key => $value) {
				if (!isset($var2[$key])) { // || !$this->compare($value, $var2[$key])) {
					return false;
				}
			}

			return true;
		}

		if (is_object($var1)) {
			foreach ($var1 as $key => $value) {
				if (!isset($var2->$key)) { // || !$this->compare($value, $var2->$key)) {
					return false;
				}
			}

			return true;
		}

		return $var1 === $var2;
	}

	public function digest($trigger) {
		foreach ($this->watches as $expression => $watch) {
			$value = $this->parse($expression);
			if (!$this->compare($value, $watch->value)) {
				$watch->value = is_object($value) ? clone $value : $value;
				foreach ($watch->callbacks as $callback) {
					$callback($value);
				}
			}
		}

		foreach ($this->childScopes as $scope) {
			$scope->digest('CHILD');
		}
	}

	public function watch($expression, $callback) {
		if (preg_match('/^\s*(\{\{)?@/', $expression)) return;

		$expression = preg_replace('/^\s*\{\{@?|\}\}\s*$/', '', $expression);

		$value = $this->parse($expression);

		if (!isset($this->watches[$expression])) {
			$this->watches[$expression] = (object)array(
				'callbacks' => array(),
				'value' => is_object($value) ? clone $value : $value
			);
		}

		$this->watches[$expression]->callbacks[] = $callback;

		$callback($value);
	}

	public static function globalScope() {
		if (!isset(self::$global)) {
			self::$global = new Scope();
		}

		return self::$global;
	}

	public static function closest(\DOMNode $node) {
		do {
			if ($node->nodeType == 1) {
				if ($node->data('scope')) {
					return $node->data('scope');
				}
			}
		} while ($node = $node->parentNode);

		return self::globalScope();
	}
}

?>