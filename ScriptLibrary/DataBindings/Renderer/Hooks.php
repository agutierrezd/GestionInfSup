<?php

namespace DataBindings\Renderer;

use DataBindings\DOM\Document,
	DataBindings\DOM\Element,
	DataBindings\Data\Scope;

class Hooks
{
	public static $hooks = array();

	public static function exec($hook, &$state) {
		if (array_key_exists($hook, self::$hooks)) {
			$func = self::$hooks[$hook];
			$result = call_user_func_array($func, array_slice(func_get_args(), 2));

			if (is_array($result)) {
				$state = array_merge($state, $result);
			} else {
				return $result;
			}
		}
	}
}

Hooks::$hooks = array(
	'start' => function(Element $element) {
		if ($element->hasAttribute('data-binding-repeat')) {
			// repeater
			new Repeater($element);
			return false;
		}
	},

	'tag:script' => function(Element $element) {
		return false;
	},

	'tag:iframe' => function(Element $element) {
		return false;
	},

	'attr:data-binding-repeat-children' => function(Element $element, $attr) {
		new Repeater($element);
		return array('parseChildren' => false);
	},

	'attr:data-binding-scope' => function(Element $element, $attr) {
		$scope = Scope::closest($element)->create($element);
		$scope->parentScope->watch($attr->value, function($value) use ($scope) {
			$scope->set($value);
		});
	},

	'attr:data-binding-detail' => function(Element $element, $attr) {
		$scope = Scope::closest($element)->create($element);
		$scope->parentScope->watch($attr->value . '.$selectedItem', function($value) use ($scope) {
			$scope->set($value);
		});
	},

	'attr:data-binding-html' => function(Element $element, $attr) {
		Scope::closest($element)->watch($attr->value, function($value) use ($element) {
			$element->html($value);
		});

		$element->removeAttribute($attr->name);

		return array('parseChildren' => false);
	},

	'attr:data-binding-text' => function(Element $element, $attr) {
		Scope::closest($element)->watch($attr->value, function($value) use ($element) {
			$element->text($value);
		});

		$element->removeAttribute($attr->name);

		return array('parseChildren' => false);
	},

	'attr:data-binding-ignore' => function(Element $element, $attr) {
		return array('parseChildren' => false);
	},

	'attr:data-binding-show' => function(Element $element, $attr) {
		$placeholder = $element->ownerDocument->createComment('placeholder');
		$parent = $element->parentNode;
		$parent->insertBefore($placeholder, $element);

		Scope::closest($element)->watch($attr->value, function($value) use ($element, $parent, $placeholder) {
			if ($value) {
				$parent->insertBefore($element, $placeholder);
			} else {
				$element->detach();
			}
		});

		$element->removeAttribute($attr->name);
	},

	'attr:data-binding-hide' => function(Element $element, $attr) {
		$placeholder = $element->ownerDocument->createComment('placeholder');
		$parent = $element->parentNode;
		$parent->insertBefore($placeholder, $element);

		Scope::closest($element)->watch($attr->value, function($value) use ($element, $parent, $placeholder) {
			if ($value) {
				$element->detach();
			} else {
				$parent->insertBefore($element, $placeholder);
			}
		});

		$element->removeAttribute($attr->name);
	},

	'attr:data-binding-src' => function(Element $element, $attr) {
		$scope = Scope::closest($element);

		Parser::parseTemplate($attr->value, $scope, function($value) use ($element) {
			$element->setAttribute('src', $value);
		});
	},

	'attr:data-binding-style' => function(Element $element, $attr) {
		$scope = Scope::closest($element);

		Parser::parseTemplate($attr->value, $scope, function($value) use ($element) {
			$element->setAttribute('style', $value);
		});
	},

	'attr:data-binding-href' => function(Element $element, $attr) {
		$scope = Scope::closest($element);

		Parser::parseTemplate($attr->value, $scope, function($value) use ($element) {
			$element->setAttribute('href', $value);
		});
	}
);
