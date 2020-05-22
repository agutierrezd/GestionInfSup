<?php

namespace DataBindings\Data;

use DataBindings\Renderer\Parser;

class DataSet
{
	private $id;

	private function __construct($id)
	{
		$this->id = $id;
	}

	public static function create($cfg) {
		$ch = FALSE;

		if (is_null($cfg) || !isset($cfg->id) || !isset($cfg->url)) return $ch;
		
		$dataset = new DataSet($cfg->id);
		
		$loadTime = -microtime(TRUE);

		if (strpos($cfg->url, '{{') !== FALSE) {
			Parser::parseTemplate($cfg->url, Scope::globalScope(), function($value) use ($dataset) {
				$dataset->load($value);
			});
		} else {
			$ch = $dataset->load($cfg->url, TRUE);
		}

		global $timings;
		$timings['Dataset '.$cfg->id] = $loadTime + microtime(TRUE);

		return $ch;
	}

	public function load($url, $async = FALSE) {
		if (strpos($url, '://') === FALSE) {
			$url = 'http' . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 's' : '') . '://'
			     . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'] . $_SERVER['SERVER_PORT'])
			     . ($url[0] == '/' ? '' : rtrim(dirname(preg_replace('/\?.*/', '', $_SERVER['REQUEST_URI'])),'\\') . '/') . $url;
		}

		$url = Parser::parseTemplate($url, Scope::globalScope());

		$ch = curl_init(str_replace(' ', '+', $url));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);

		if ($async) return $ch;

		$result = curl_exec($ch);

		$err = curl_errno($ch);

		if ($err) {
			if ($err == 28) {
				header($_SERVER['SERVER_PROTOCOL'] . ' 504 Gateway Timeout', TRUE, 504);
				$error = 'Timeout getting the url "' . $url . '".';
			} else {
				header($_SERVER['SERVER_PROTOCOL'] . ' 502 Bad Gateway', TRUE, 502);
				$error = curl_error($ch);
			}
			curl_close($ch);
			exit($error);
		} else {
			$globalScope = Scope::globalScope();
			$data = json_decode(preg_replace('/^\w+\(|\);?&/', '', $result));
			$globalScope->add($this->id, $data);
		}

		curl_close($ch);
	}

	private function loadLocal($file) {
		if (file_exists($file)) {
			ob_start();
			include($file);
			$result = ob_get_clean();
		} else {
			$result = FALSE;
		}
		return $result;
	}
}
