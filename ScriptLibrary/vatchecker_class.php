<?php
class VATChecker{
	
	var $langue;
	var $data;
	var $errors;
	var $last_error;
	
	/* Constructor
	* $xml_fic : path to data_vat.xml
	* $xml_error : path to error_vat.xml
	* $langue : language to use
	*/
	function VATChecker($xml_fic, $xml_error, $langue = "en"){
		$this->langue = $langue;
		
		$xml = simplexml_load_file($xml_fic);
		if($xml){
			foreach($xml as $pays){
				$code = (string)$pays->code;
				foreach ($pays->nom as $value)
					if($value['langue'] == $langue)
						$this->data[$code]['nom'] = (string)$value;
				foreach($pays->masques as $masque){
					$this->data[$code]['masques'][] = "/^".(string)$masque->masque."$/";
				}
			}	
		}
		
		$xml = simplexml_load_file($xml_error);
		if($xml){
			foreach($xml as $error){
				$code = (string)$error->code;
				foreach($error->text as $value)
					if($value['langue'] == $langue)
						$this->errors[$code] = (string)$value;	
			}	
		}
	}
	
	function getData(){
		return $this->data;	
	}
	
	function getErrors(){
		return $this->errors;	
	}
	
	function setLastError($num){
		if(array_key_exists($num, $this->getErrors()))
			$this->last_error = $num;
		else 
			$this->last_error = 999;
			
		return false;
	}
	
	function getLastError(){
		return $this->errors[$this->last_error];	
	}
	
	/* Returns country name 
	* $vatno : VAT number
	*
	*/
	function getPays($vatno){
		$code = substr(str_replace(" ", "", strtoupper($vatno)), 0, 2);
		$data = $this->getData();
		if(array_key_exists($code, $data))
			return $data[$code]['nom']; 	
		return false;
	}
	
	/* Checks if vat number is well constructed
	* $vatno : VAT number
	*
	*/
	function checkStructure($vatno){
		if(preg_match("/^([A-Z]{2})/", $vatno, $regs) && array_key_exists($regs[1], $this->getData())){
			$vatno = substr($vatno, 2);
			foreach($this->data[$regs[1]]['masques'] as $masque){
				if(preg_match($masque, $vatno))
					return true;
			}	
		}
		return false;
	}
	
	/* Checks if vat number exists
	* $vatno : VAT number
	*/
	function check($vatno){
		$vatno = str_replace(" ", "", strtoupper($vatno));
		if($this->checkStructure($vatno)){
			return $this->checkMSVAT($vatno);
		}
		return $this->setLastError(1);
	}
	
	
	/* Send request to VIES site and retrieve results
	* $url : Vies' site
	*/
	function loadData($url){
		$url = parse_url($url);
	
		if(!in_array($url['scheme'],array('','http')))
		return;
	
		$fp = fsockopen ($url['host'], ($url['port'] > 0 ? $url['port'] : 80), $errno, $errstr, 2);
		if (!$fp){
			return False;
		}
		else{
			fputs ($fp, "GET ".$url['path']. (isSet($url['query']) ? '?'.$url['query'] : '')." HTTP/1.0\r\n");
			fputs ($fp, "Host: ".$url['host']."\r\n");
			fputs($fp, "Connection: close\r\n\r\n");   			
	
			$data = "";
			stream_set_blocking($fp,false);
			stream_set_timeout($fp, 4);			
			$status = socket_get_status($fp);
			while(!feof($fp) && !$status['timed_out']) {
	   			$data .= fgets($fp, 1000);
	   			$status = socket_get_status($fp);       			
			}
	
			if ( $status['timed_out'] ) 
				return false;
	   		fclose ($fp);
	   		return $data;
		}
	}
	
	/* Send & request to VIES site and interprets results
	* $vatno : VAT number
	*/
	function checkMSVAT($vatno){
		$ViesMS = strtoupper(substr($vatno, 0, 2));
		$vatno = substr($vatno, 2);				
		$urlVies 	= "http://www.europa.eu.int:80/comm/taxation_customs/vies/cgi-bin/viesquer/?VAT=$vatno&MS=$ViesMS&Lang=EN";

		$DataHTML = $this->loadData($urlVies);
		
		$ViesOk		= 'YES, VALID VAT NUMBER';
		$ViesEr		= 'NO, INVALID VAT NUMBER';
	
		if (!$DataHTML)
			return $this->setLastError(2);
		else{
			$DataHTML = '#' . strToUpper($DataHTML);
			return ((strPos($DataHTML,'REQUEST TIME-OUT') > 0) OR (strPos($DataHTML,$ViesOk) > 0)) ? true : $this->setLastError(3);
		} 
	}
}
?>