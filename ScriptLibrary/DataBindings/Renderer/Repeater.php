<?php

namespace DataBindings\Renderer;

use DataBindings\Data\Scope;

const REPEAT = 'Repeat';
const REPEAT_CHILD = 'RepeatChildren';
const REPEAT_ATTR = 'data-binding-repeat';
const REPEAT_ATTR_ID = 'data-binding-id';
const REPEAT_ATTR_CHILD = 'data-binding-repeat-children';
const REPEAT_ATTR_IDX = 'data-binding-repeat-index';
const REPEAT_ATTR_PAGE = 'data-binding-repeat-page';
const REPEAT_ATTR_SIZE = 'data-binding-repeat-size';

class Repeater
{
	private static $rid;

	private $id;
	private $element;
	private $data = array();
	private $type;
	private $expression;
	private $pageSize = -1;

	private $params;

	public function __construct($element) {
		$this->element = $element;

		$this->params = (object)array(
			'$selectedItem' => null,
			'$selectedIndex' => 0,
			'$currentPage' => 1,
			'$totalPages' => 1,
			'$totalItems' => 0
		);

		if ($element->hasAttribute(REPEAT_ATTR)) {
			$this->type = REPEAT;
			$this->expression = $element->getAttribute(REPEAT_ATTR);
			$element->removeAttribute(REPEAT_ATTR);
		} else {
			$this->type = REPEAT_CHILD;
			$this->expression = $element->getAttribute(REPEAT_ATTR_CHILD);
			$element->removeAttribute(REPEAT_ATTR_CHILD);
		}

		$this->id = $element->hasAttribute(REPEAT_ATTR_ID)
			? $element->getAttribute(REPEAT_ATTR_ID)
			: ($element->hasAttribute('id')
				? $element->getAttribute('id')
				: 'Region' + (++Repeater::$rid));

		$this->scope = Scope::closest($element);

		$this->{'setup' . $this->type}();

		$self = $this;
		$this->scope->watch($this->expression, function($value) use ($self) {
			$self->set($value);
		});
	}

	private function updateScopeProps() {
		$scope = $this->scope;

		do {
			$scope->add($this->id, $this->params);
		} while ($scope = $scope->parentScope);
	}

	public function set($data) {
		if (is_null($data)) {
			return;
		}

		if (is_numeric($data)) {
			$c = $data;
			$data = array();
			for ($i = 0; $i < $c; $i++) {
				$data[] = $i;
			}
		}

		if (!(is_array($data) || is_object($data))) return;

		$this->data = array();

		$i = 0;
		foreach ($data as $key => $value) {
			$d = is_object($value) ? clone $value : (object)array();
			$d->{'$key'} = $key;
			$d->{'$name'} = $key;
			$d->{'$value'} = $value;
			$d->{'$index'} = $i;
			$d->{'$number'} = $i + 1;
			$d->{'$oddeven'} = $i % 2;
			$d->{'$selected'} = false;

			$this->data[] = $d;

			$i++;
		}

		$totalItems = count($this->data);
		$this->params->{'$totalItems'} = $totalItems;

		if ($totalItems == 0) return;

		if ($this->element->hasAttribute(REPEAT_ATTR_IDX)) {
			$idx = $this->element->getAttribute(REPEAT_ATTR_IDX);
			
			if (strpos($idx, '{{') !== false) {
				$idx = $this->scope->parse($idx);
			}

			if (is_string($idx)) {
				switch ($idx) {
					case 'none'   : $idx = -1; break;
					case 'first'  : $idx = 0; break;
					case 'last'   : $idx = $totalItems - 1; break;
					case 'middle' : $idx = floor($totalItems / 2); break;
					case 'random' : $idx = rand(0, $totalItems - 1); break;
					default       : $idx = (int)$idx; break;
				}
			}

			if (!is_numeric($idx)) $idx = -1;

			if ($idx != -1) {
				$idx = $idx < 0 ? 0 : ($idx >= $totalItems ? $totalItems - 1 : $idx);
				$this->params->{'$selectedIndex'} = $idx;
			}		
		}

		if ($this->params->{'$selectedIndex'} != -1) {
				$this->data[$this->params->{'$selectedIndex'}]->{'$selected'} = true;
				$this->params->{'$selectedItem'} = $this->data[$this->params->{'$selectedIndex'}];
		}

		if ($this->element->hasAttribute(REPEAT_ATTR_SIZE)) {
			$size = $this->element->getAttribute(REPEAT_ATTR_SIZE);
			
			if (strpos($size, '{{') !== false) {
				$size = $this->scope->parse($size);
			}
			
			$this->pageSize = (int)$size;
			$this->params->{'$totalPages'} = ceil($totalItems / $this->pageSize);
		}

		if ($this->pageSize > 0 && $this->element->hasAttribute(REPEAT_ATTR_PAGE)) {
			$page = $this->element->getAttribute(REPEAT_ATTR_PAGE);
			$total = $this->params->{'$totalPages'};
			
			if (strpos($page, '{{') !== false) {
				$page = $this->scope->parse($page);
			}

			if (is_string($page)) {
				switch ($page) {
					case 'first'  : $page = 1; break;
					case 'last'   : $page = $total; break;
					case 'middle' : $page = ceil($total / 2); break;
					case 'random' : $page = rand(1, $total); break;
					default       : $page = (int)$page; break;
				}
			}

			if (!is_numeric($page)) $page = 1;

			$this->params->{'$currentPage'} = $page < 1 ? 1 : ($page > $total ? $total : $page);
		}

		$this->updateScopeProps();

		$this->render();
	}

	private function render() {
		$renderTime = -microtime(true);

		$this->{'clear' . $this->type}();

		$totalItems = $this->params->{'$totalItems'};

		if ($totalItems == 0) return;

		$start = 0;
		$end = $totalItems;

		if ($this->pageSize > 0) {
			$start = ($this->params->{'$currentPage'} - 1) * $this->pageSize;
			$end = min($start + $this->pageSize, $totalItems);
		}

		for ($i = $start; $i < $end; $i++) {
			$this->{'render' . $this->type}($i);
		}

		global $timings;
		$timings['Repeater '.$this->id] = $renderTime + microtime(true);
	}

	private function setupRepeat() {
		$doc = $this->element->ownerDocument;
		$this->startNode = $doc->createComment('START REPEAT');
		$this->endNode = $doc->createComment('END REPEAT');
		$this->template = $this->element->before($this->startNode)->after($this->endNode)->detach();
	}

	private function clearRepeat() {
		$node = $this->startNode->nextSibling;

		while ($node && $node != $this->endNode) {
			$next = $node->nextSibling;
			$node->detach();
			$node = $next;
		}
	}

	private function renderRepeat($i) {
		$element = $this->template->cloneNode(true)->insertBeforeNode($this->endNode);
		$this->scope->create($element)->set($this->data[$i]);
		Parser::parseElement($element);
	}

	private function setupRepeatChildren() {
		$this->template = array();
		foreach ($this->element->children(1) as $node) {
			$element = $node->detach();
			$this->template[] = $element;
		}
	}

	private function clearRepeatChildren() {
		$this->element->removeChildNodes();
	}

	private function renderRepeatChildren($i) {
		foreach ($this->template as $node) {
			$element = $node->cloneNode(true)->appendTo($this->element);
			$this->scope->create($element)->set($this->data[$i]);
			Parser::parseElement($element);
		}
	}
}
