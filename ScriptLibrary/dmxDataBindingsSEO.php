<?php
if (isset($_GET['_escaped_fragment_'])) {
	define('BASE_PATH', realpath(dirname(__FILE__)));

	function dmxAutoloader($class) {
		$filename = BASE_PATH . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
		if (file_exists($filename)) {
			require_once($filename);
			return TRUE;
		}
		return FALSE;
	}

	function get_file_contents($file) {
		global $timings;

		if (file_exists($file)) {
			ob_start();
			include($file);
			$result = ob_get_clean();
		} else {
			$result = FALSE;
		}

		return $result;
	}

	require_once(BASE_PATH.'/DataBindings/Expression/Formatters.php');

	spl_autoload_register('dmxAutoloader');

	unset($_GET['_escaped_fragment_']);

	$timings = array();
	$startTime = -microtime(TRUE);

	$result = get_file_contents($_SERVER['SCRIPT_FILENAME']);

	if (!$result) {
		$url = 'http' . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 's' : '') . '://';
		$url.= isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'] . $_SERVER['SERVER_PORT'];
		$url.= $_SERVER['REQUEST_URI'];
		$url = preg_replace('/_escaped_fragment_(=[^&]*)?&?/i', '', $url);

		$ch = curl_init($url);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);

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
		}

		curl_close($ch);
	}

	$timings['Read current url'] = $startTime + microtime(TRUE);

	$result = \DataBindings\Renderer\Parser::parseHTML($result);

	$timings['Total parsing'] = $startTime + microtime(TRUE);

	$result .= "<!--\r\n";
	foreach ($timings as $key => $value) {
		$result .= $key . ": " . round($value * 1000) . "ms\r\n";
	}
	$result .= "-->";

	header('Content-Type: text/html; charset=utf-8');
	exit($result);
}