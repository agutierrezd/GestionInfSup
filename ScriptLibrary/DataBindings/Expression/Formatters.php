<?php

namespace DataBindings\Expression;

require_once(BASE_PATH.'/DataBindings/Vendor/portable-utf8.php');

use \DataBindings\Data\RegExp;

function getDate($value) {
	try {
		$date = new \DateTime($value);
	} catch(\Exception $e) {
		return NULL;
	}

	return $date;
}

function Filter_default($value, $default) {
	return $value == NULL ? $default : $value;
}

function Filter_then($value, $true, $false) {
	return $value ? $true : $false;
}

function Filter_toNumber($value) {
	return (float)$value;
}

function Filter_toString($value) {
	return (string)$value;
}

function Filter_parseJSON($value) {
	return json_encode($value);
}

function Filter_startsWith($value, $string) {
	return strpos($value, $string) === 0;
}

function Filter_endsWith($value, $string) {
	return utf8_substr($value, -utf8_strlen($string)) == $string;
}

function Filter_contains($value, $string) {
	return strpos($value, $string) !== FALSE;
}

function Filter_test($value, $regex) {
	if (!($regex instanceof RegExp)) {
		$regex = new RegExp(preg_quote((string)$regex, '/'));
	}

	return $regex->test($value);
}

function Filter_between($value, $a, $b) {
	return (bool)($a <= $value && $value <= $b);
}

function Filter_floor($value) {
	return floor((float)$value);
}

function Filter_ceil($value) {
	return ceil((float)$value);
}

function Filter_round($value) {
	return round((float)$value);
}

function Filter_abs($value) {
	return abs($value);
}

function Filter_padNumber($value, $digids) {
	if (is_nan($value) || !is_finite($value)) return '';
	return str_pad($value, $digids, '0', STR_PAD_LEFT);
}

function Filter_formatNumber($value, $decimals = 0) {
	if (is_nan($value) || !is_finite($value)) return '';
	if ($decimals) {
		$pow = pow(10, $decimals);
		$value = round($value * $pow) / $pow;
	}
	return (string)$value;
}

function Filter_hex($value) {
	return hexdec($value);
}

function Filter_currency($value, $unit = '$', $separator = '.', $delimiter = ',', $precision = 2) {
	if (is_nan($value) || !is_finite($value)) $value = 0;

	$neg = $value < 0;
	if ($neg) $value *= -1;

	return ($neg ? '-' : '') . $unit . number_format($value, $precision, $delimiter, $separator);
}

function Filter_lowercase($value) {
	$value = (string)$value;
	return utf8_strtolower($value);
}

function Filter_uppercase($value) {
	$value = (string)$value;
	return utf8_strtoupper($value);
}

function Filter_camelize($value) {
	$value = (string)$value;
	return preg_replace_callback('/[-_\s]+(.)?/u', function($matches) { return utf8_strtoupper($matches[1]); }, utf8_trim($value));
}

function Filter_capitalize($value) {
	$value = (string)$value;
	return utf8_strtoupper(substr($value, 0, 1)) . utf8_strtolower(substr($value, 1));
}

function Filter_dasherize($value) {
	$value = (string)$value;
	return utf8_strtolower(preg_replace('/-+/u', '-', preg_replace('/[A-Z]/u', '-\\0', preg_replace('/[_\s]+/u', '-', $value))));
}

function Filter_humanize($value) {
	$value = (string)$value;
	$value = preg_replace('/([a-z\d])([A-Z]+)/u', '\\1_\\2', utf8_trim($value));
	$value = utf8_strtolower(preg_replace('/[-\s]+/u', '_', $value));
	$value = preg_replace('/_id$/u', '', $value);
	$value = utf8_trim(utf8_str_replace('_', ' ', $value));
	return utf8_strtoupper(utf8_substr($value, 0, 1)) . utf8_strtolower(utf8_substr($value, 1));
}

function Filter_slugify($value) {
	$value = (string)$value;
	$value = utf8_strtolower(preg_replace('/[^\w\s]/u', '', $value));
	$value = preg_replace('/[_\s]+/u', '-', $value);
	$value = preg_replace('/-+/u', '-', $value);
	return preg_replace('/^-/u', '', $value);
}

function Filter_underscore($value) {
	$value = (string)$value;
	$value = preg_replace('/([a-z\d])([A-Z]+)/u', '\\1_\\2', utf8_trim($value));
	return utf8_strtolower(preg_replace('/[-\s]+/u', '_', $value));
}

function Filter_titlecase($value) {
	$value = (string)$value;
	return preg_replace_callback('/\b(\w)/u', function($matches) { return utf8_strtoupper($matches[1]); }, utf8_strtolower($value));
}

function Filter_camelcase($value) {
	$value = (string)$value;
	return preg_replace_callback('/\s+(\S)/u', function($matches) { return utf8_strtoupper($matches[1]); }, utf8_strtolower($value));
}

function Filter_replace($value, $search, $replace) {
	$value = (string)$value;
	if (!($search instanceof RegExp)) {
		$search = new RegExp(preg_quote((string)$search, '/'));
	}

	return $search->replace($value, $replace);
}

function Filter_trim($value) {
	return trim($value);
}

function Filter_split($value, $separator) {
	if (!($separator instanceof RegExp)) {
		$separator = new RegExp(preg_quote((string)$separator, '/'));
	}

	return $separator->split($value);
}

function Filter_pad($value, $length, $chr = ' ', $pos = 'left') {
	$pos = $pos == 'right' ? STR_PAD_RIGHT : ($pos == 'center' ? STR_PAD_BOTH : STR_PAD_LEFT);
	return utf8_str_pad($value, (int)$length, $chr, $pos);
}

function Filter_repeat($value, $count) {
	return utf8_str_repeat($value, $count);
}

function Filter_substr($value, $start, $length) {
	if ($start < 0) $start = utf8_strlen($value) - abs($start);
	return utf8_substr($value, $start, $length);
}

function Filter_trunc($value, $num, $useWordBoundary = FALSE, $chr = '…') {
	if (utf8_strlen($value) > $num) {
		$value = utf8_substr($value, 0, $num - 1);

		if ($useWordBoundary && utf8_strpos($value, ' ') !== FALSE) {
			$value = utf8_substr($value, 0, utf8_strrpos($value, ' '));
		}

		$value .= $chr;
	}

	return $value;
}

function Filter_stripTags($value) {
	return preg_replace('/<[^>]+>/u', '', $value);
}

function Filter_wordCount($value) {
	$value = preg_replace('/\.\?!,/u', ' ', $value);
	return count(preg_split('/\s+/u', utf8_trim($value)));
}

function Filter_formatDate($value, $format) {
	$date = getDate($value);

	if (is_null($date)) return NULL;

	$format = preg_replace_callback('/y{1,4}|M{1,2}|d{1,2}|H{1,2}|h{1,2}|m{1,2}|s{1,2}|a/', function($matches) {
		switch ($matches[0]) {
			case 'yyyy': return 'Y';
			case 'yy':   return 'y';
			case 'y':    return 'Y';
			case 'MM':   return 'm';
			case 'M':    return 'n';
			case 'dd':   return 'd';
			case 'd':    return 'j';
			case 'HH':   return 'H';
			case 'H':    return 'G';
			case 'hh':   return 'h';
			case 'h':    return 'g';
			case 'mm':   return 'i';
			case 'm':    return 'i';
			case 'ss':   return 's';
			case 's':    return 's';
			case 'a':    return 'a';
		}
		return $matches[0];
	}, $format);

	return $date->format($format);
}

function Filter_dateAdd($value, $interval, $num) {
	$date = getDate($value);

	if (is_null($date)) return NULL;

	$date->modify($num . ' ' . $interval);

	return $date->format(DATE_W3C);
}

function Filter_dateDiff($value, $interval, $date) {
	$date1 = getDate($value);
	$date2 = getDate($date);

	if (is_null($date1) || is_null($date2)) return NULL;

	$diff = $date1->diff($date2);

	switch ($interval) {
		case 'years':
			return $diff->y;
		case 'months':
			return ($diff->y * 12) + $diff->m;
		case 'weeks':
			return floor($diff->days / 7);
		case 'days':
			return $diff->days;
		case 'hours':
			return ($diff->days * 24) + $diff->h;
		case 'minutes':
			return ($diff->days * 24 * 60) + ($diff->h * 60) + $diff->i;
		case 'seconds':
			return ($diff->days * 24 * 60 * 60) + ($diff->h * 60 * 60) + ($diff->i * 60) + $diff->s;
		case 'hours:minutes':
			return (($diff->days * 24) + $diff->h) . ':' . str_pad($diff->i, 2, '0', STR_PAD_LEFT);
		case 'minutes:seconds':
			return (($diff->days * 24 * 60) + ($diff->h * 60) + $diff->i) . ':' . str_pad($diff->s, 2, '0', STR_PAD_LEFT);
		case 'hours:minutes:seconds':
			return (($diff->days * 24) + $diff->h) . ':' . str_pad($diff->i, 2, '0', STR_PAD_LEFT) . ':' . str_pad($diff->s, 2, '0', STR_PAD_LEFT);
	}

	return NULL;
}

function Filter_join($value, $chr, $prop = NULL) {
	if (!is_array($value)) return $value;
	if ($prop) {
		$arr = array();
		foreach ($value as $key => $value) {
			$arr[] = $value->$prop;
		}
		return implode($chr, $arr);
	}
	return implode($chr, $value);
}

function Filter_top($value, $count) {
	if (!is_array($value)) return $value;
	return array_slice($value, 0, $count);
}

function Filter_last($value, $count) {
	if (!is_array($value)) return $value;
	return array_slice($value, -$count);
}

function Filter_where($value, $prop, $operator, $val) {
	if (!is_array($value)) return $value;

	$results = array();

	foreach ($value as $o) {
		$v = $o->$prop;
		$ok = FALSE;

		switch ($operator) {
			case 'startsWith':
				$ok = strpos($v, $val) === 0;
				break;
			case 'endsWith':
				$ok = substr($v, strlen($val)) == $val;
				break;
			case 'contains':
				$ok = strpos($v, $val) !== FALSE;
				break;
			case '===':
				$ok = $v === $val;
				break;
			case '==':
				$ok = $v == $val;
				break;
			case '!==':
				$ok = $v !== $val;
				break;
			case '!=':
				$ok = $v != $val;
				break;
			case '<':
				$ok = $v < $val;
				break;
			case '<=':
				$ok = $v <= $val;
				break;
			case '>':
				$ok = $v > $val;
				break;
			case '>=':
				$ok = $v >= $val;
				break;
		}

		if ($ok) {
			$results[] = $o;
		}
	}

	return $results;
}

function Filter_unique($value, $prop = NULL) {
	if (!is_array($value)) return $value;

	$results = array();

	foreach ($value as $val) {
		$results[] = $prop ? $val->$prop : $val;
	}

	return array_unique($results);
}

function Filter_groupBy($value, $prop) {
	if (!is_array($value)) return $value;

	$groups = (object)array();

	foreach ($value as $val) {
		$name = (string)$val->$prop;
		if (!isset($groups->$name)) $groups->$name = array();
		$groups->{$name}[] = $val;
	}

	return $groups;
}

function Filter_sort($value, $prop = NULL) {
	if (is_array($value)) {
		if ($prop) {
			usort($value, function($a, $b) use ($prop) {
				return strnatcmp($a->$prop, $b->$prop);
			});
		} else {
			sort($value);
		}
	}

	return $value;
}

function Filter_randomize($value) {
	if (is_array($value)) shuffle($value);
	return $value;
}

function Filter_reverse($value) {
	if (!is_array($value)) return $value;
	return array_reverse($value);
}

function Filter_count($value) {
	if (!is_array($value)) return 0;
	return count($value);
}

function Filter_min($value, $prop = NULL) {
	if (!is_array($value)) return $value;

	$arr = array();

	foreach ($value as $val) {
		$arr[] = $prop ? $val->$prop : $val;
	}

	return min($arr);
}

function Filter_max($value, $prop = NULL) {
	if (!is_array($value)) return $value;

	$arr = array();

	foreach ($value as $val) {
		$arr[] = $prop ? $val->$prop : $val;
	}

	return max($arr);
}

function Filter_sum($value, $prop = NULL) {
	if (!is_array($value)) return $value;

	$arr = array();

	foreach ($value as $val) {
		$arr[] = $prop ? $val->$prop : $val;
	}

	return array_sum($arr);
}

function Filter_avg($value, $prop = NULL) {
	if (!is_array($value)) return $value;

	$arr = array();

	foreach ($value as $val) {
		$arr[] = $prop ? $val->$prop : $val;
	}

	return array_sum($arr) / count($arr);
}

function Filter_keys($value) {
	if (!is_array($value)) return $value;
	return array_keys($value);
}

function Filter_values($value) {
	if (!is_array($value)) return $value;
	return array_values($value);
}