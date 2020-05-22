<?php

namespace DataBindings\Data;

require_once(BASE_PATH.'/DataBindings/Vendor/portable-utf8.php');

class String
{
	private $value = '';

	public function __construct($value = '') {
		$this->value = (string)$value;
	}

	public function __get($name) {
		if ($name == 'length') {
			return utf8_strlen($this->value);
		}
	}

	public function __toString() {
		return (string)$this->value;
	}

	public function charAt($index) {
		$value = utf8_split($this->value);
		return isset($value[$index]) ? $value[$index] : '';
	}

	public function charCodeAt($index) {
		$char = $this->charAt($index);

		if ($char) {
			return utf8_ord($char);
		}

		return NAN;
	}

	public function concat() {
		$args = func_get_args();
		$value = $this->value;

		foreach ($args as $arg) {
			$value .= $arg;
		}

		return new String($value);
	}

	public static function fromCharCode() {
		$args = func_get_args();
		$value = '';

		foreach ($args as $arg) {
			$value .= utf8_chr($arg);
		}

		return new String($value);
	}

	public function indexOf($searchValue, $start = 0) {
		$pos = utf8_strpos($this->value, $searchValue, $start);
		return $pos !== FALSE ? $pos : -1;
	}

	public function lastIndexOf($searchValue, $start = 0) {
		$pos = utf8_strrpos($this->value, $searchValue, $start);
		return $pos !== FALSE ? $pos : -1;
	}

	public function replace($searchValue, $newValue) {
		return utf8_str_replace($searchValue, $newValue, $this->value);
	}

	public function slice($start, $end = NULL) {
		$chars = utf8_split($this->value);
		if ($end !== NULL) $end -= $start;
		$chars = array_slice($chars, $start, $end);
		return new String(implode('', $chars));
	}

	public function split($separator, $limit = NULL) {
		if ($separator == '') {
			$parts = utf8_split($this->value);
		} else {
			$parts = explode('%%%dmx%%%', $this->replace($separator, '%%%dmx%%%'));
		}
		return $limit === NULL ? $parts : array_slice($parts, 0, $limit);
	}

	public function substr($start, $length = NULL) {
		return new String(utf8_substr($this->value, $start, $length));
	}

	public function substring($start, $end = NULL) {
		if ($end === NULL) $end = PHP_INT_MAX;
		if ($start < 0) $start = 0;
		if ($end < 0) $end = 0;
		if ($end < $start) {
			$t = $end;
			$end = $start;
			$start = $t;
		}
		return new String(utf8_substr($this->value, $start, $end - $start));
	}

	public function toLowerCase() {
		return new String(utf8_strtolower($this->value));
	}

	public function toString() {
		return new String($this->value);
	}

	public function toUpperCase() {
		return new String(utf8_strtoupper($this->value));
	}

	public function trim() {
		return new String(utf8_trim($this->value));
	}

	public function valueOf() {
		return (string)$this->value;
	}
}