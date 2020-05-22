<?php

namespace DataBindings\Expression;

use \DataBindings\Data\RegExp;

require_once(BASE_PATH.'/DataBindings/Vendor/portable-utf8.php');

class Lexer
{
	private $exp;
	private $pos;
	private $char;
	
	private $ops = array(
		'(', ')', '[', ']', '.', ',', ':', '?',
		'+', '-', '*', '/', '%',
		'===', '!==', '==', '!=',
		'<', '>', '<=', '>=', 'in',
		'&&', '||', '!',
		'&', '|', '^', '~',
		'<<', '>>', '>>>'
	);

	private $esc = array(
		'n' => '\n',
		'f' => '\f',
		'r' => '\r',
		't' => '\t',
		'v' => '\v',
		'"' => '"',
		"'" => "'"
	);

	public function parse($expression) {
		$tokens = array();
		$this->exp = $expression;
		$this->pos = 0;
		$op = true;

		while ($this->pos < utf8_strlen($expression)) {
			$this->char = $this->read();

			if ($op && $this->detect_string()) {
				$tokens[] = new Token(Token::STRING, $this->read_string());
				$op = false;
			}
			elseif ($op && $this->detect_number()) {
				$tokens[] = new Token(Token::NUMBER, $this->read_number());
				$op = false;
			}
			elseif ($op && $this->detect_identifier()) {
				//$value = $this->readIdent();
				//$tokens[] = new Token($this->is($this->read(), '(') ? Token::METHOD : Token::IDENTIFIER, $value);
				$tokens[] = new Token(Token::IDENTIFIER, $this->read_identifier());
				$op = false;
			}
			elseif ($op && $this->detect_regexp()) {
				$tokens[] = new Token(Token::REGEXP, $this->read_regexp());
				$op = false;
			}
			elseif ($this->is_whitespace()) {
				// skip character
				$this->pos += 1;
			}
			else {
				if (in_array($this->read(3), $this->ops)) {
					$n = 3;
				}
				elseif (in_array($this->read(2), $this->ops)) {
					$n = 2;
				}
				elseif (in_array($this->char, $this->ops)) {
					$n = 1;
				}
				else {
					throw new Exception('Unexpected character '.$this->char.' at column '.$this->pos.' in expression {{'.$this->exp.'}}');
					//exit('Error: Unexpected token '.$this->char.' at column '.$this->pos.' in expression {{'.$expression.'}}');
				}

				$tokens[] = new Token(Token::OPERATOR, $this->consume($n));
				$op = true;
			}
		}

		return $tokens;
	}

	private function read($n = 1) {
		return utf8_substr($this->exp, $this->pos, $n);
	}

	private function peek($n = 1) {
		$pos = $this->pos + $n;
		return $pos < utf8_strlen($this->exp) ? utf8_substr($this->exp, $pos, 1) : false;
	}

	private function consume($n = 1) {
		$str = $this->read($n);
		$this->pos += $n;
		return $str;
	}

	private function detect_string() {
		return $this->is('\'"');
	}

	private function detect_number() {
		return $this->is('0123456789') ||
		      ($this->is('.') &&
		       $this->is('0123456789', $this->peek()));
	}

	private function detect_identifier() {
		return preg_match('/[a-zA-Z_$]/', $this->char);
	}

	private function detect_regexp() {
		return $this->is('/');
	}

	private function is($chars, $char = null) {
		if ($char == null) $char = $this->char;
		return utf8_strpos($chars, $char) !== false;
	}

	private function is_whitespace() {
		$char = $this->char;
		return $char == ' '  || $char == '\r' || $char == '\t' ||
		       $char == '\n' || $char == '\v' || $char == '\u00A0';
	}

	private function isExpOperator($ch) {
		return $ch == '-' || $ch == '+' || $this->is_digid($ch);
	}

	private function read_string() {
		$quote = $this->char;
		$value = '';

		// skip quote
		++$this->pos;

		while ($this->pos < utf8_strlen($this->exp)) {
			$char = $this->consume();

			if ($char == '\\') {
				// escape character
				$char = $this->consume();

				if ($char == 'u') {
					// Unicode char escape
					$value .= utf8_chr($this->consume(4));
				}
				elseif (array_key_exists($char, $this->esc)) {
					$value .= $this->esc[$char];
				}
				else {
					$value .= $char;
				}
			}
			elseif ($char == $quote) {
				// end of string
				return $value;
			}
			else {
				$value .= $char;
			}
		}

		throw new Exception('Unterminated string in expression {{'.$this->exp.'}}');
		//exit('Error: Unterminated string');
	}

	private function read_number() {
		preg_match('/^[0-9]*\\.?[0-9]+([eE][-+]?[0-9]+)?/', utf8_substr($this->exp, $this->pos, utf8_strlen($this->exp)), $match);
		return floatval($this->consume(utf8_strlen($match[0])));
	}

	private function read_identifier() {
		preg_match('/^[a-zA-Z0-9_$]+/', utf8_substr($this->exp, $this->pos, utf8_strlen($this->exp)), $match);
		return $this->consume(utf8_strlen($match[0]));
	}

	private function read_regexp() {
		$val = '';
		$mod = '';
		$esc = false;

		$this->pos += 1;

		while ($this->pos < utf8_strlen($this->exp)) {
			$ch = $this->read();

			if ($esc) {
				$esc = false;
			}
			elseif ($ch == '\\') {
				$esc = true;
			}
			elseif ($ch == '/') {
				$this->pos += 1;

				while (utf8_strpos('ign', $ch = $this->read()) !== false) {
					$mod .= $ch;
					$this->pos += 1;
				}

				//return $val . '%%%' . $mod;
				return new RegExp($val, $mod);
			}

			$val .= $ch;
			$this->pos += 1;
		}

		throw new Exception('Unterminated RegExp in expression {{'.$this->exp.'}}');
		//exit('Error: unterminated regexp');
	}
}

class Token
{
	const STRING = 'STRING';
	const NUMBER = 'NUMBER';
	const REGEXP = 'REGEXP';
	const OPERATOR = 'OPERATOR';
	const IDENTIFIER = 'IDENTIFIER';
	const METHOD = 'METHOD';

	public $type;
	public $value;

	public function __construct($type, $value) {
		$this->type = $type;
		$this->value = $value;
	}
}
