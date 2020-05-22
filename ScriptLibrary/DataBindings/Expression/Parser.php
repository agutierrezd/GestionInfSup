<?php

namespace DataBindings\Expression;

require_once(BASE_PATH.'/DataBindings/Expression/Formatters.php');

use \DataBindings\Data\Scope,
	\DataBindings\Data\RegExp;

const OP_LEFT_PAREN = '(';
const OP_RIGHT_PAREN = ')';
const OP_LEFT_BRACKET = '[';
const OP_RIGHT_BRACKET = ']';
const OP_DOT = '.';
const OP_COMMA = ',';
const OP_COLON = ':';
const OP_HOOK = '?';
const OP_PLUS = '+';
const OP_MINUS = '-';
const OP_MUL = '*';
const OP_DIV = '/';
const OP_MOD = '%';
const OP_LOGICAL_AND = '&&';
const OP_LOGICAL_OR = '||';
const OP_LOGICAL_NOT = '!';
const OP_BITWISE_AND = '&';
const OP_BITWISE_OR = '|';
const OP_BITWISE_XOR = '^';
const OP_BITWISE_NOT = '~';
const OP_STRICT_EQ = '===';
const OP_EQ = '==';
const OP_STRICT_NE = '!==';
const OP_NE = '!=';
const OP_LSH = '<<';
const OP_LE = '<=';
const OP_LT = '<';
const OP_URSH = '>>>';
const OP_RSH = '>>';
const OP_GE = '>=';
const OP_GT = '>';
const OP_IN = 'in';

class Parser
{
	private $lexer;
	private $tokens;
	private $data;

	private $reserved = array();

	public function __construct() {
		$this->lexer = new Lexer();
		$this->reserved['PI'] = function() { return pi(); };
		$this->reserved['$this'] = function() { return '[$this]'; };
		$this->reserved['$global'] = function() { return '[$global]'; };
		$this->reserved['$parent'] = function() { return '[$parent]'; };
		$this->reserved['null'] = function() { return NULL; };
		$this->reserved['true'] = function() { return TRUE; };
		$this->reserved['false'] = function() { return FALSE; };
	}

	public function parse($expression, Scope $data) {
		// clean expression for {{ }} when they are still there
		$expression = preg_replace('/^\{\{|\}\}$/', '', $expression);

		$this->tokens = $this->lexer->parse($expression);
		$this->data = $data;

		$value = $this->expression();

		return $value();
	}

	private function read() {
		if (count($this->tokens) == 0) {
			throw new Exception('Unexpected end of expression.');
			//exit('Error: Unexpected end of expression');
		}

		return $this->tokens[0];
	}

	private function peek($value = NULL, $type = NULL) {
		if (count($this->tokens) > 0) {
			$token = $this->tokens[0];

			if (is_array($value)) {
				foreach ($value as $val) {
					if ($token->value === $val && (is_null($type) || $token->type === $type)) {
						return $token;
					}
				}
			}
			elseif ((is_null($value) || $token->value === $value) && (is_null($type) || $token->type === $type)) {
				return $token;
			}
		}

		return FALSE;
	}

	private function expect($e = NULL, $type = NULL) {
		$token = $this->peek($e, $type);

		if ($token !== FALSE) {
			array_shift($this->tokens);
			return $token;
		}

		return FALSE;
	}

	private function consume($e) {
		if ($this->expect($e) === FALSE) {
			throw new Exception('Unexpected token, expecting ('.$e.').');
			//exit('Error: Unexpected token, expecting '.$e);
		}
	}

	private function fn($exp) {
		return function() use ($exp) {
			return $exp;
		};
	}

	private function expression() {
		return $this->conditional();
	}

	private function conditional() {
		$left = $this->logicalOr();

		if ($token = $this->expect(OP_HOOK, Token::OPERATOR)) {
			$middle = $this->expression();

			if ($token = $this->expect(OP_COLON, Token::OPERATOR)) {
				return Operator::execute($token->value, $left, $middle, $this->expression());
			} else {
				throw new Exception('Unexpected token, Expecting (:).');
				//exit('Error: Parse error');
			}
		} else {
			return $left;
		}
	}

	private function logicalOr() {
		$left = $this->logicalAnd();

		while (true) {
			if ($token = $this->expect(OP_LOGICAL_OR, Token::OPERATOR)) {
				$left = Operator::execute($token->value, $left, $this->logicalAnd());
			}
			else {
				return $left;
			}
		}
	}

	private function logicalAnd() {
		$left = $this->bitwiseOr();

		if ($token = $this->expect(OP_LOGICAL_AND, Token::OPERATOR)) {
			$left = Operator::execute($token->value, $left, $this->logicalAnd());
		}

		return $left;
	}

	private function bitwiseOr() {
		$left = $this->bitwiseXor();

		if ($token = $this->expect(OP_BITWISE_OR, Token::OPERATOR)) {
			$left = Operator::execute($token->value, $left, $this->bitwiseXor());
		}

		return $left;
	}

	private function bitwiseXor() {
		$left = $this->bitwiseAnd();

		if ($token = $this->expect(OP_BITWISE_XOR, Token::OPERATOR)) {
			$left = Operator::execute($token->value, $left, $this->bitwiseAnd());
		}

		return $left;
	}

	private function bitwiseAnd() {
		$left = $this->equality();

		if ($token = $this->expect(OP_BITWISE_AND, Token::OPERATOR)) {
			$left = Operator::execute($token->value, $left, $this->equality());
		}

		return $left;
	}

	private function equality() {
		$left = $this->relational();

		if ($token = $this->expect(array(OP_EQ, OP_NE, OP_STRICT_EQ, OP_STRICT_NE), Token::OPERATOR)) {
			$left = Operator::execute($token->value, $left, $this->equality());
		}

		return $left;
	}

	private function relational() {
		$left = $this->bitwiseShift();

		if ($token = $this->expect(array(OP_LT, OP_LE, OP_GT, OP_GE, OP_IN), Token::OPERATOR)) {
			$left = Operator::execute($token->value, $left, $this->relational());
		}

		return $left;
	}

	private function bitwiseShift() {
		$left = $this->addictive();

		while ($token = $this->expect(array(OP_LSH, OP_RSH, OP_URSH), Token::OPERATOR)) {
			$left = Operator::execute($token->value, $left, $this->addictive());
		}

		return $left;
	}

	private function addictive() {
		$left = $this->multiplicative();

		while ($token = $this->expect(array(OP_PLUS, OP_MINUS), Token::OPERATOR)) {
			$left = Operator::execute($token->value, $left, $this->multiplicative());
		}

		return $left;
	}

	private function multiplicative() {
		$left = $this->unary();

		while ($token = $this->expect(array(OP_MUL, OP_DIV, OP_MOD), Token::OPERATOR)) {
			$left = Operator::execute($token->value, $left, $this->unary());
		}

		return $left;
	}

	private function unary() {
		if ($token = $this->expect(array(OP_PLUS, OP_MINUS), Token::OPERATOR)) {
			if ($token->value == OP_PLUS) {
				return $this->group();
			}

			return Operator::execute($token->value, $this->fn(0), $this->unary());
		}
		elseif ($token = $this->expect(OP_LOGICAL_NOT, Token::OPERATOR)) {
			return Operator::execute($token->value, $this->unary());
		}

		return $this->group();
	}

	private function group() {
		if ($this->expect(OP_LEFT_PAREN, Token::OPERATOR)) {
			$value = $this->expression();
			$this->consume(OP_RIGHT_PAREN, Token::OPERATOR);

			while ($next = $this->expect(array(OP_LEFT_BRACKET, OP_DOT), Token::OPERATOR)) {
				if ($next->value == OP_LEFT_BRACKET) {
					// index
					$value = $this->fn($this->objectIndex($value));
				}
				elseif ($next->value == OP_DOT) {
					// member
					$value = $this->fn($this->objectMember($value));
				}
				else {
					throw new Exception('Unexpected token ('.$next->value.').');
					//Exit('Error');
				}
			}

			return $value;
		}

		return $this->primary();
	}

	private function primary() {
		$token = $this->expect();

		if ($token === false) {
			throw new Exception('Unexpected end of tokens.');
			//exit('Error: Unexpected end of tokens');
		}

		$value = $this->fn($token->value);

		switch ($token->type) {
			case Token::IDENTIFIER:
				if (array_key_exists($token->value, $this->reserved)) {
					$value = $this->reserved[$token->value];
					break;
				}

				if ($this->data->exists($token->value)) {
					$value = $this->fn($this->data->get($token->value));
					break;
				}

				$value = $this->fn(null);
				break;

			case Token::OPERATOR:
				if ($token->value == OP_LEFT_BRACKET) {
					$value = $this->fn($this->objectIndex($this->fn($this->data->getData())));
					break;
				}
				elseif ($token->value == OP_DOT) {
					$value = $this->peek() ? $this->fn($this->objectMember($this->fn($this->data->getData()))) : $this->fn($this->data->getData());
					break;
				}

				throw new Exception('Unexpected operator token ('.$token->value.').');
				//exit('Error: Unexpected operator token "'.$token->value.'"!');
		}

		while ($next = $this->expect(array(OP_LEFT_BRACKET, OP_DOT), Token::OPERATOR)) {
			if ($next->value == OP_LEFT_BRACKET) {
				// index
				$value = $this->fn($this->objectIndex($value));
			}
			elseif ($next->value == OP_DOT) {
				// member
				$value = $this->fn($this->objectMember($value));
			}
			else {
				throw new Exception('Unexpected token ('.$next->value.').');
				//Exit('Error');
			}
		}

		return $value;
	}

	private function objectIndex($value) {
		$index = $this->expression();
		$index = $index();

		$this->consume(OP_RIGHT_BRACKET);

		$data = $value();

		return $this->getProperty($data, $index);
	}
	
	private function objectMember($value) {
		$token = $this->expect(NULL, Token::IDENTIFIER);

		if (!$token) {
			throw new Exception('Unexpected token ('.$this->peek().').');
			//exit('Error: Invalid token!');
		}

		$data = $value();

		if ($this->expect(OP_LEFT_PAREN, Token::OPERATOR)) {
			$args = array($data);

			if ($this->peek()->value !== OP_RIGHT_PAREN) {
				do {
					$arg = $this->expression();
					$args[] = $arg();
				} while ($this->expect(OP_COMMA, Token::OPERATOR));
			}

			$this->consume(OP_RIGHT_PAREN);

			if (is_callable('DataBindings\Expression\Filter_'.$token->value)) {
				return call_user_func_array('DataBindings\Expression\Filter_'.$token->value, $args);
			} else {
				return null;
			}
		}

		return $this->getProperty($data, $token->value);
	}

	private function getProperty($object, $prop) {
		switch (gettype($object)) {
			case 'string':
				return $prop === 'length' ? utf8_strlen($object) : null;

			case 'array':
				return $prop === 'length' ? count($object) : (isset($object[$prop]) ? $object[$prop] : null);

			case 'object':
				return isset($object->$prop) ? $object->$prop : null;

			default:
				return null;
		}
	}
}

class Operator
{
	public static function execute($op, $a, $b = null, $c = null) {
		switch ($op) {
			case OP_COLON:
				return function() use ($a, $b, $c) {
					return $a() ? $b() : $c();
				};

			case OP_LOGICAL_OR:
				return function() use ($a, $b) {
					return $a() || $b();
				};

			case OP_LOGICAL_AND:
				return function() use ($a, $b) {
					return $a() && $b();
				};

			case OP_BITWISE_OR:
				return function() use ($a, $b) {
					return $a() | $b();
				};

			case OP_BITWISE_XOR:
				return function() use ($a, $b) {
					return $a() ^ $b();
				};

			case OP_BITWISE_AND:
				return function() use ($a, $b) {
					return $a() & $b();
				};

			case OP_EQ:
				return function() use ($a, $b) {
					return $a() == $b();
				};

			case OP_NE:
				return function() use ($a, $b) {
					return $a() != $b();
				};

			case OP_STRICT_EQ:
				return function() use ($a, $b) {
					return $a() === $b();
				};

			case OP_STRICT_NE:
				return function() use ($a, $b) {
					return $a() !== $b();
				};

			case OP_LT:
				return function() use ($a, $b) {
					return $a() < $b;
				};

			case OP_LE:
				return function() use ($a, $b) {
					return $a() <= $b;
				};

			case OP_GT:
				return function() use ($a, $b) {
					return $a() > $b();
				};

			case OP_GE:
				return function() use ($a, $b) {
					return $a() >= $b();
				};

			case OP_IN:
				return function() use ($a, $b) {
					// TODO: simulate the in operation from javascript
					// return $a() in $b();
					$aa = $a();
					$bb = $b();

					if (is_array($bb)) {
						return array_key_exists($aa, $bb);
					}

					if (is_object($bb)) {
						return property_exists($bb, $aa);
					}

					return false;
				};

			case OP_LSH:
				return function() use ($a, $b) {
					return $a() << $b();
				};

			case OP_RSH:
				return function() use ($a, $b) {
					return $a() >> $b();
				};

			case OP_URSH:
				return function() use ($a, $b) {
					return $a() >> $b();
				};

			case OP_PLUS:
				return function() use ($a, $b) {
					$aa = $a();
					$bb = $b();

					if (is_string($aa) || is_string($bb)) {
						return $aa . $bb;
					}

					return $aa + $bb;
				};

			case OP_MINUS:
				return function() use ($a, $b) {
					return $a() - $b();
				};

			case OP_MUL:
				return function() use ($a, $b) {
					return $a() * $b();
				};

			case OP_DIV:
				return function() use ($a, $b) {
					return $a() / $b();
				};

			case OP_MOD:
				return function() use ($a, $b) {
					return $a() % $b();
				};

			case OP_LOGICAL_NOT:
				return function() use ($a) {
					return !$a();
				};

			case OP_BITWISE_NOT:
				return function() use ($a) {
					return ~$a();
				};
		}
	}
}
