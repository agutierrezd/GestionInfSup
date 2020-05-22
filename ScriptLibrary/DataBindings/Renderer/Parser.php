<?php

namespace DataBindings\Renderer;

use DataBindings\DOM\Document,
	DataBindings\DOM\Element,
	DataBindings\Data\DataSet,
	DataBindings\Data\Scope;

class Parser
{
	public static function parseHTML($html, $options = 0) {
		return self::parse(Document::fromHTML($html, $options));
	}

	public static function parseHTMLFile($uri, $options = 0) {
		return self::parse(Document::fromHTMLFile($uri, $options));
	}

	public static function parse(Document $doc) {
		$globalScope = Scope::globalScope();

		$globalScope->add('$URL', array());
		$globalScope->add('$FORM', array());

		$url = &$globalScope->ref('$URL');

		foreach ($_GET as $key => $value) {
			$url[$key] = $value;
		}

		$form = &$globalScope->ref('$FORM');

		$formElements = array();
		$submittables = array('input', 'select', 'textarea');
		foreach ($submittables as $submittable) {
			$nodes = array();
			foreach ($doc->getElementsByTagName($submittable) as $node) {
				$nodes[] = $node;
			}
			$formElements = array_merge($formElements, array_filter($nodes, function($elm) {
				return $elm->hasAttribute('name') && !$elm->hasAttribute('disabled') && ($elm->hasAttribute('checked') || !preg_match('/^(?:checkbox|radio)$/i', $elm->getAttribute('type')));
			}));
		}

		foreach ($formElements as $elm) {
			$elm->name = $elm->getAttribute('name');

			switch (strtolower($elm->tagName)) {
				case 'textarea':
					$elm->value = $elm->textContent;
					break;

				case 'select':
					$options = $elm->getElementsByTagName('option');
					$one = !($elm->hasAttribute('multiple'));
					$values = $one ? NULL : array();

					foreach ($options as $option) {
						if ($option->hasAttribute('selected')) {
							$val = $option->hasAttribute('value') ? $option->getAttribute('value') : $option->textContent;
	
							if ($one) {
								$values = $val;
								break;
							}

							$values[] = $val;
						}

					}

					$elm->value = $values;
					break;
				
				default:
					$elm->value = $elm->hasAttribute('value') ? $elm->getAttribute('value') : '';
					break;
			}

			if ($elm->value) {
				if (isset($form[$elm->name])) {
					if (!is_array($form[$elm->name])) {
						$form[$elm->name] = array($form[$elm->name]);
					}
					$form[$elm->name][] = $elm->value;
				} else {
					$form[$elm->name] = $elm->value;
				}
			}
		}

		// parse script blocks
		$scripts = $doc->getElementsByTagName('script');

		$datasets = array();

		foreach ($scripts as $script) {
			if ($script->nodeValue) {
				preg_match_all('~/\* dmxDataSet name "([^"]*)" \*/\s*jQuery\.dmxDataSet\(\s*(.*?)\s*\);\s*/\* END dmxDataSet name "\1" \*/~us', $script->nodeValue, $matches);
				foreach ($matches[2] as $cfg) {
					$cfg = json_decode($cfg);
					if ($cfg === NULL) {
						// parse error
						$cfg = json_decode(str_replace("\\'", "'", $cfg));
					}
					if ($cfg !== NULL) {
						$ch = DataSet::create($cfg);
						if ($ch !== FALSE) {
							$datasets[$cfg->id] = $ch;
						}
					}
				}
			}
		}

		if ($datasets) {
			$asyncTime = -microtime(TRUE);

			$mh = curl_multi_init();

			foreach ($datasets as $ch) {
				curl_multi_add_handle($mh, $ch);
			}

			$active = NULL;

			do {
				curl_multi_exec($mh, $active);
				usleep(10000);
			} while ($active);

			$globalScope = Scope::globalScope();

			foreach ($datasets as $id => $ch) {
				$curlError = curl_error($ch);
				
				if ($curlError == '') {
					$result = curl_multi_getcontent($ch);
					$data = json_decode(preg_replace('/^\w+\(|\);?&/', '', $result));
					$globalScope->add($id, $data);
				}

				curl_multi_remove_handle($mh, $ch);
				curl_close($ch);
			}

			curl_multi_close($mh);

			global $timings;
			$timings['Async loading'] = $asyncTime + microtime(TRUE);
		}

		$parseTime = -microtime(TRUE);

		// parse document
		Parser::parseElement($doc->documentElement);

		global $timings;
		$timings['Rendering'] = $parseTime + microtime(TRUE);

		// return rendered html
		return $doc->saveHTML();
	}

	// nodeType 1
	public static function parseElement(Element $element) {
		$tag = strtolower($element->tagName);

		$state = array(
			'parseAttributes' => TRUE,
			'parseChildren'   => TRUE
		);

		if (Hooks::exec('start', $state, $element) === FALSE) return;
		if (Hooks::exec('tag:' . $tag, $state, $element) === FALSE) return;

		if ($state['parseAttributes']) {
			$i = $element->attributes->length;

			while ($i--) {
				$attr = $element->attributes->item($i);

				if (Hooks::exec('attr:' . $attr->name, $state, $element, $attr) !== FALSE) {
					Parser::parseAttr($attr);
				}
			}
		}

		if ($state['parseChildren'] && $element->hasChildNodes()) {
			foreach ($element->children() as $node) {
				switch ($node->nodeType) {
					case 1:
						Parser::parseElement($node);
						break;
					case 3:
					//case 8:
						Parser::parseNode($node);
						break;
				}
			}
		}
	}

	// nodeType 2
	public static function parseAttr(\DOMAttr $attr) {
		if (strpos($attr->value, '{{') !== FALSE) {
			$scope = Scope::closest($attr);

			Parser::parseTemplate($attr->value, $scope, function($value) use ($attr) {
				$attr->value = htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
			});
		}
	}

	// nodeType 3/8
	public static function parseNode(\DOMNode $node) {
		if (strpos($node->nodeValue, '{{') !== FALSE) {
			$scope = Scope::closest($node);

			Parser::parseTemplate($node->nodeValue, $scope, function($value) use ($node) {
				$node->nodeValue = $value;
			});
		}
	}

	public static function parseTemplate($template, $scope, $callback = null) {
		if (strpos($template, '{{') === FALSE) {
			if (!is_null($callback)) $callback($template);
			return $template;
		}

		return preg_replace_callback('/\{\{(.*?)\}\}/', function($matches) use ($template, $scope, $callback) {
			$expression = $matches[1];

			if ($expression[0] == '@') {
				return '{{' . utf8_substr($expression, 1) . '}}';
			}

			$value = $scope->parse($expression);

			if (!is_null($callback)) {
				$scope->watch($expression, function() use ($callback, $template, $scope) {
					$callback(Parser::parseTemplate($template, $scope));
				});
			}

			return Parser::jsString($value);
		}, $template);
	}

	public static function jsString($value) {
		if (is_object($value)) {
			return '[object]';
		}

		if (is_bool($value)) {
			return $value ? 'true' : 'false';
		}

		if (is_array($value)) {
			return implode(',', array_map(function($val) {
				return Parser::jsString($val);
			}, $value));
		}

		return is_null($value) ? '' : (string)$value;
	}
}
