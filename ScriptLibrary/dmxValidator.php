<?php
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// DMX Validator PHP 1.5.5
//
// Copyright (c) 2006-2009 DMXzone
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
require_once('dmxXMLParser.php');
require_once("vatchecker_class.php");

class dmxValidator
{	
	var $forms;
	var $script_folder;
	var $form;
	var $valid;
	var $validated;
	var $report_type;
	var $report_div_id;
	var $error_font;
	var $error_font_size;
	var $error_color;
	var $error_bold;
	var $error_italic;
	var $error_image;
	var $error_fixed;
	var $error_padding;
	var $border_size;
	var $border_style;
	var $border_color;
	var $error_bg_color;
	var $report_header_text;
	var $report_footer_text;
	var $report_list_style;
	var $cs_validate_on_change;
	var $cs_validate_on_submit;
	var $masks;
	var $hints;
	var $conditional_actions;
	var $use_custom_hint_class;
	var $custom_hint_class;
	var $hint_border_color;
	var $hint_border_size;
	var $hint_border_style;
	var $hint_bg_color;
	var $hint_text_color;
	var $hint_text_font;
	var $hint_text_size;
	var $hint_text_bold;
	var $hint_text_italic;
	var $hint_box_width;
	var $translation;	
	var $use_custom_focus_class;
	var $custom_focus_class;
	var $focus_border_style;
	var $focus_border_size;
	var $focus_border_color;
	var $focus_bg_color;
	var $focus_text_color;
	var $use_custom_valid_class;
	var $custom_valid_class;
	var $valid_border_style;
	var $valid_border_size;
	var $valid_border_color;
	var $valid_bg_color;
	var $valid_text_color;
	var $use_custom_invalid_class;
	var $custom_invalid_class;
	var $invalid_border_style;
	var $invalid_border_size;
	var $invalid_border_color;
	var $invalid_bg_color;
	var $invalid_text_color;
	var $tooltip_position;
	var $hint_tooltip_position;
	var $css_hint_file;
	var $css_error_file;
	var $error_preset;
	var $hint_preset;
	var $hint_image;
	var $hint_fixed;
	var $hint_padding;	
	var $use_bot_check;
	var $is_bot;
	var $reenable_javascript;
	
	function dmxValidator()
	{
		$this->forms = array();
		$this->masks = array();
		$this->hints = array();
		$this->conditional_actions = array();
		
		$this->script_folder = "ScriptLibrary";
		$this->form;
		$this->valid = true;
		$this->validated = false;
		$this->report_type = 0;
		$this->report_div_id = "";
		$this->error_font = "Arial";
		$this->error_font_size = 12;
		$this->error_color = "#FF0000";
		$this->error_bold = true;
		$this->error_italic = true;
		$this->error_image = "";
		$this->border_size = 1;
		$this->border_color = "#FFFFFF";
		$this->report_header_text  = "Your form contains the following errors: ";
		$this->report_footer_text = "Please fix them before submitting.";
		$this->report_list_style = 0;
		$this->cs_validate_on_change = true;
		$this->cs_validate_on_submit = true;		
		$this->use_custom_hint_class = false;
		$this->custom_hint_class = "";
		$this->hint_border_color = "#36393D";
		$this->hint_border_size = 1;
		$this->hint_border_style = "solid";
		$this->hint_bg_color = "#FFFF88";
		$this->hint_text_color = "#008C00";
		$this->hint_text_font = "arial";
		$this->hint_text_size = 12;
		$this->hint_text_bold = false;
		$this->hint_text_italic = false;
		$this->hint_box_width = 200;
		$this->translation = new dmx_val_translation();
		$this->use_custom_focus_class = false;
		$this->custom_focus_class = "";
		$this->focus_border_style = "solid";
		$this->focus_border_size = 1;
		$this->focus_border_color = "#FFFFFF";
		$this->focus_bg_color = "#000000";
		$this->focus_text_color = "#FFFFFF";
		$this->use_custom_valid_class = false;
		$this->custom_valid_class = "";
		$this->valid_border_style = "solid";
		$this->valid_border_size = 1;
		$this->valid_border_color = "#FFFFFF";
		$this->valid_bg_color = "#000000";
		$this->valid_text_color = "#FFFFFF";
		$this->use_custom_invalid_class = false;
		$this->custom_invalid_class = "";
		$this->invalid_border_style = "solid";
		$this->invalid_border_size = 1;
		$this->invalid_border_color = "#FFFFFF";
		$this->invalid_bg_color = "#000000";
		$this->invalid_text_color  = "#FFFFFF";
		$this->tooltip_position = "top";
		$this->hint_tooltip_position = "top";
		$this->css_hint_file = "";
		$this->css_error_file = "";
		$this->error_preset = "";
		$this->hint_preset = "";
		$this->error_fixed = "";		
		$this->error_padding = 4;
		$this->hint_padding = 4;
		$this->hint_fixed = "";
		$this->hint_image = "";
		$this->border_style = "solid";
		$this->error_bg_color = "#FFFFFF";
		$this->use_bot_check = false;
		$this->is_bot = false;
		$this->reenable_javascript = false;
	}
	
	function get_css()
	{
		$str = "<style type=\"text/css\"><!-- \n";
		if($this->use_custom_focus_class != "custom")
		{
			$str .= "input:focus, select:focus, textarea:focus {\n";
			$str .= "border:".$this->focus_border_size."px ".$this->focus_border_style." ".$this->focus_border_color." !important;\n";
			$str .= "background-color:".$this->focus_bg_color." !important;\n";
			$str .= "color:".$this->focus_text_color." !important;}\n";
		}
		
		if($this->use_custom_valid_class != "custom")
		{
			$str .= ".dmxvalvalid {\n";
			$str .= "border:".$this->valid_border_size."px ".$this->valid_border_style." ".$this->valid_border_color." !important;\n";
			$str .= "background-color:".$this->valid_bg_color." !important;\n";
			$str .= "color:".$this->valid_text_color." !important;}\n";
		}
		if($this->use_custom_invalid_class != "custom")
		{
			$str .= ".dmxvalinvalid {\n";
			$str .= "border:".$this->invalid_border_size."px ".$this->invalid_border_style." ".$this->invalid_border_color." !important;\n";
			$str .= "background-color:".$this->invalid_bg_color." !important;\n";
			$str .= "color:".$this->invalid_text_color." !important;}\n";
		}
		$str .= ".dmxerrorreport {\n";
		$str .=	"border-color: ".$this->border_color." !important;\n";
		$str .=	"border-width: ".$this->border_size."px !important;\n";
		$str .=	"font-size: ".$this->error_font_size."pt !important;\n";
		$str .=	"font-family: ".$this->error_font." !important;\n";
		if ($_SERVER['REQUEST_METHOD'] === 'POST')
		{		
			$str .= "display: none;\n";
		}	
		else
		{
			$str .= "display: none;\n";
		}
		$str .= "color: ".$this->error_color.";\n";
		$str .= $this->error_bold ? "font-weight: bold;\n" : "";
		$str .= $this->error_italic ? "font-weight: bold;\n" : "";		
		$str .= "}\n label.dmxError {";
		if ($this->error_fixed != "Custom")
		{
			$str .= "background-image: url(".$this->error_fixed.") !important;\n";
			$str .= "background-repeat: no-repeat;\n padding-left: ".$this->error_padding."px !important;";		
		}
		else
		{
			if($this->error_image != "")
			{
				$str .= "background-image: url(".$this->error_image.") !important;\n";				
				$str .= "background-repeat: no-repeat;\n padding-left: ".$this->error_padding."px !important;";		
			}
		}
		$str .= "font-size: ".$this->error_font_size."pt !important;\n";
		$str .= "font-family: \"".$this->error_font."\" !important;\n";
		$str .= "color: ".$this->error_color." !important;\n";
		$str .= "background-color: ".$this->error_bg_color." !important;\n";
		$str .= $this->error_bold ? "font-weight: bold !important;\n" : "";
		$str .= $this->error_italic ? "font-style:italic !important;\n" : "";
		$str .= "}\n --></style>";
		return $str;
	}
	
	function get_javascript()
	{		
		$str = '';
		$str .= "<script type='text/javascript'><!-- \n";
		$str .=	"jQuery(document).ready(function(){";
		if (!$this->valid && $this->report_type == 3)
		{				
			$str .= '$("#'.$this->report_div_id.'").css("display", "block");';
		}
		if ($this->use_custom_focus_class == "custom")
		{
			foreach ($this->forms as $form)
			{
				foreach ($form->elements as $element)
				{
					$str .= '$("[name=\''.$element->name.'\']").focus(function (){$(this).addClass("'.$this->custom_focus_class.'")});'."\n";
					$str .= '$("[name=\''.$element->name.'\']").blur(function (){$(this).removeClass("'.$this->custom_focus_class.'")});'."\n";
				}
			}
		}
		if ($this->use_bot_check)
		{
			if(session_id() == "")
			{
				session_start();
			} 
			foreach ($this->forms as $key=>$form)
			{				
				$str .= "\$('#".$key."').append('<input type=\"hidden\" value=\"".session_id()."\" name=\"dmx_botcheck_".$key."\">');";
			}
		}			
		if (count($this->conditional_actions) > 0)
		{	
			foreach ($this->conditional_actions as $ca)
			{	
			  $str .=  "if (\$(\"[name='".$ca->dependent_el."']\").attr('type') != 'radio' && \$(\"[name='".$ca->dependent_el."']\").attr('type') != 'checkbox') {";
				if ($ca->action == "2")
				{
					$str .= "$(\"[name='".$ca->dependent_el."']\").change(function () {";
					switch(strtolower($ca->type))
					{
						case "show":
							$ca->dependent_val = str_replace("'", "\"", $ca->dependent_val);
							$str .= "showBlock('".$ca->dependent_el."', '".$ca->dependent_val."', '".$ca->container."','".$ca->speed."'); });\n";
							$str .= "showBlock('".$ca->dependent_el."', '".$ca->dependent_val."', '".$ca->container."','".$ca->speed."');\n";
							break;
						case "fade":
							$ca->dependent_val = str_replace("'", "\"", $ca->dependent_val);
							$str.= "fadeBlock('".$ca->dependent_el."', '".$ca->dependent_val."', '".$ca->container."','".$ca->speed."'); });\n";
							$str.= "fadeBlock('".$ca->dependent_el."', '".$ca->dependent_val."', '".$ca->container."','".$ca->speed."');\n";
							break;
						case "slide":
							$ca->dependent_val = str_replace("'", "\"", $ca->dependent_val);
							$str .= "slideBlock('".$ca->dependent_el."', '".$ca->dependent_val."', '".$ca->container."','".$ca->speed."'); });\n";
							$str .= "slideBlock('".$ca->dependent_el."', '".$ca->dependent_val."', '".$ca->container."','".$ca->speed."');\n";
							break;
					}
				}	
				else 
				{
					If ($ca->action == "1")
					{
					$ca->dependent_val = str_replace("'", "\"", $ca->dependent_val);
					$str .= "$(\"[name='".$ca->dependent_el."']\").change(function () {";
					$str .= "condDisable('".$ca->dependent_el."', '".$ca->dependent_val."', '".$ca->disable_el."'); });\n";
					$str .= "condDisable('".$ca->dependent_el."', '".$ca->dependent_val."', '".$ca->disable_el."');\n";
					}
				}
				$str .= "} else {";
        if ($ca->action == "2")
				{
					$str .= "$(\"[name='".$ca->dependent_el."']\").click(function () {";
					switch(strtolower($ca->type))
					{
						case "show":
							$ca->dependent_val = str_replace("'", "\"", $ca->dependent_val);
							$str .= "showBlock('".$ca->dependent_el."', '".$ca->dependent_val."', '".$ca->container."','".$ca->speed."'); });\n";
							$str .= "showBlock('".$ca->dependent_el."', '".$ca->dependent_val."', '".$ca->container."','".$ca->speed."');\n";
							break;
						case "fade":
							$ca->dependent_val = str_replace("'", "\"", $ca->dependent_val);
							$str.= "fadeBlock('".$ca->dependent_el."', '".$ca->dependent_val."', '".$ca->container."','".$ca->speed."'); });\n";
							$str.= "fadeBlock('".$ca->dependent_el."', '".$ca->dependent_val."', '".$ca->container."','".$ca->speed."');\n";
							break;
						case "slide":
							$ca->dependent_val = str_replace("'", "\"", $ca->dependent_val);
							$str .= "slideBlock('".$ca->dependent_el."', '".$ca->dependent_val."', '".$ca->container."','".$ca->speed."'); });\n";
							$str .= "slideBlock('".$ca->dependent_el."', '".$ca->dependent_val."', '".$ca->container."','".$ca->speed."');\n";
							break;
					}
				}	
				else 
				{
					If ($ca->action == "1")
					{
					$ca->dependent_val = str_replace("'", "\"", $ca->dependent_val);
					$str .= "$(\"[name='".$ca->dependent_el."']\").click(function () {";
					$str .= "condDisable('".$ca->dependent_el."', '".$ca->dependent_val."', '".$ca->disable_el."'); });\n";
					$str .= "condDisable('".$ca->dependent_el."', '".$ca->dependent_val."', '".$ca->disable_el."');\n";
					}
				} 
        $str .= "}";
			}
		}
		if (count($this->hints) > 0)
		{		
			if ($this->custom_hint_class == "")
			{
				$hc = "";
			}	
			else
			{
				$hc = $this->custom_hint_class;
			}
			foreach ($this->hints as $key=>$val)
			{
				//added hoverintent
				$str .= "$('[name=\"".$key."\"]').hoverIntent({sensitivity: 3, interval: 300, over: function(e) {buildPrompt(this, '".$val."', 'hint', true, '".$this->hint_tooltip_position."')}, timeout: 500, out: function(e) { closePrompt(this,'hint')} });";
				$str .= "$('[name=\"".$key."\"]').each(function(){var elforlab = this; if ($(this).attr('id') != undefined && $('label[for=' + $(this).attr('id') + ']').length > 0) {";
				$str .= "$('label[for=' + $(this).attr('id') + ']').hoverIntent({sensitivity: 3, interval: 300, over: function(e) {buildPrompt(elforlab, '".$val."', 'hint', true, '".$this->hint_tooltip_position."')}, timeout: 500, out: function(e) { closePrompt(elforlab,'hint')} });";
				$str .= '} else{if($(this).parent().get(0).tagName.toLowerCase() == "label") {$(this).parent().hoverIntent({sensitivity: 3, interval: 300, over: function(e) {buildPrompt(elforlab, "'.$val.'", "hint", true, "'.$this->hint_tooltip_position.'")}, timeout: 500, out: function(e) { closePrompt(elforlab,"hint")} })} }';
				$str .= "});";				
				$str .= "$('[name=\"".$key."\"]').bind('focus', function(e) { buildPrompt(this, '".$val."', 'hint', true, '".$this->hint_tooltip_position."')});";
				$str .=	"$('[name=\"".$key."\"]').bind('blur', function(e) { closePrompt(this,'hint')});";				
			}

		}
		if (count($this->masks) > 0)
		{
			$str .= "$.mask.definitions['0'] = '[0]';\n";
			$str .= "$.mask.definitions['1'] = '[0-1]';\n";
			$str .= "$.mask.definitions['2'] = '[0-2]';\n";
			$str .= "$.mask.definitions['3'] = '[0-3]';\n";
			$str .= "$.mask.definitions['4'] = '[0-4]';\n";
			$str .= "$.mask.definitions['5'] = '[0-5]';\n";
			$str .= "$.mask.definitions['6'] = '[0-6]';\n";
			$str .= "$.mask.definitions['7'] = '[0-7]';\n";
			$str .= "$.mask.definitions['8'] = '[0-8]';\n";
			$str .= "$.mask.definitions['z'] = '[a-z]';\n";
			$str .= "$.mask.definitions['Z'] = '[A-Z]';\n";
			$str .= "$.mask.definitions['^'] = '[+-A]';\n";
			$str .= "$.mask.definitions['X'] = '[xX]';\n";
			foreach ($this->masks as $key=>$val)
			{
				$str .= "$('[name=".$key."]').mask(\"".$val."\");\n";
			}
		}
		if (isset($_SERVER['HTTP_REFERER']))
			{
				if (strpos($_SERVER['HTTP_REFERER'], "?") !== false)
				{
					$ref = substr($_SERVER['HTTP_REFERER'], 0, strpos($_SERVER['HTTP_REFERER'], "?"));
				}
				else
				{
					$ref = $_SERVER['HTTP_REFERER'];
				}
			}
			else
			{
				$ref = '';
			}
			$pageURL = 'http';
			if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
			$pageURL .= "://";
			if (isset($_SERVER["SERVER_PORT"]) && $_SERVER["SERVER_PORT"] != "80") 
			{
				$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
			} 
			else 
			{
				$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
			}			
		if (strtolower($_SERVER["REQUEST_METHOD"]) != "post" || $ref != $pageURL || $this->reenable_javascript)
		{
			if ($this->report_list_style == 0)
			{
				$listEl = "<ul></ul>";
			}	
			else 
			{
				$listEl = "<ol></ol>";	
			}
			if ($this->report_type == 3)
			{
				$str .= "var container = $('#".$this->report_div_id."');container.addClass('dmxerrorreport');\n";								
				$str .= "container.html('".$this->report_header_text.$listEl.$this->report_footer_text."');\n";
				if ($this->report_list_style == 0)
				{
					$str .= "var containerlist = $('#".$this->report_div_id." > ul');\n";
				}	
				else
				{
					$str .= "var containerlist = $('#".$this->report_div_id." > ol');\n";
				}
			}
	        foreach($this->forms as $key=>$form)
			{
				if ($this->report_type == 1 OR $this->report_type == 2)
				{
					if ($this->report_type == 1)
					{
						$repLoc = "after";
					}	
					else
					{
						$repLoc = "before";	
					}					
					$str .= "$('#".$key."').".$repLoc."('<div class=\"dmxerrorreport\" id=\"dmxerrorfor".$key."\">".$this->report_header_text.$listEl.$this->report_footer_text."</div>'); var container = $('#dmxerrorfor".$key."');\n";					
					if ($this->report_list_style == 0)
					{
						$str .= "var containerlist = $('#dmxerrorfor".$key." > ul');\n";
					}	
					else
					{
						$str .= "var containerlist = $('#dmxerrorfor".$key." > ol');\n";
					}
				}
				$str .= "jQuery('#".$key."').validate({";
				if(($this->use_custom_invalid_class == "custom") && ($this->use_custom_valid_class -= "custom"))
				{
						$str .= 'highlight: function(element, errorClass){$(element).addClass("'.$this->custom_invalid_class.'");$(element).removeClass("'.$this->custom_valid_class.'")},'."\n";
						$str .= 'unhighlight: function(element, errorClass){$(element).addClass("'.$this->custom_valid_class.'");$(element).removeClass("'.$this->custom_invalid_class.'")},'."\n";
				}					
				else
				{
					if($this->use_custom_invalid_class == "custom")
					{
						$str .= 'highlight: function(element, errorClass){$(element).addClass("'.$this->custom_invalid_class.'");$(element).removeClass("dmxvalvalid")},'."\n";
						$str .= 'unhighlight: function(element, errorClass){$(element).addClass("dmxvalvalid");$(element).removeClass("'.$this->custom_invalid_class.'")},'."\n";
					}	
					else
					{
						if ($this->use_custom_valid_class == "custom")
						{
							$str .= 'highlight: function(element, errorClass){$(element).addClass("dmxvalinvalid");$(element).removeClass("'.$this->custom_valid_class.'")},'."\n";
							$str .= 'unhighlight: function(element, errorClass){$(element).addClass("'.$this->custom_valid_class.'");$(element).removeClass("dmxvalinvalid")},'."\n";
						}
						else
						{
							$str .= 'highlight: function(element, errorClass){$(element).addClass("dmxvalinvalid");$(element).removeClass("dmxvalvalid");},'."\n";
							$str .= 'unhighlight: function(element, errorClass){$(element).addClass("dmxvalvalid");$(element).removeClass("dmxvalinvalid")},'."\n";
						}
					}
				}
				$str .= "rules:{";
	      foreach($form->elements as $element)
				{
					if (count($element->rules) >0)
					{
						$str .= "'".$element->name."' :{";							
						foreach ($element->rules as $rule)
						{	   
							$args3 = explode(",", $rule->params);
              $args3[count($args3) -1] = str_replace("'", "\'",$args3[count($args3) -1]);
              $args4 = implode("','", $args3); 	
							//$args = "['".str_replace(",", "','",$rule->params)."']";
							$args = "['".$args4."']";
							$str .= $rule->name.":".$args."," ; 						
						}
						$str = substr($str, 0, strlen($str) - 1)."},";
					}	
	      }
				$str = substr($str, 0, strlen($str) - 1)."}";				
				if ($this->report_type > 0 && $this->report_type < 4)
				{
					$str .= ",messages:{";
					foreach ($form->elements as $element)
					{
						if (count($element->rules) >0)
						{
			        $str .= "'".$element->name."' :{";
			        foreach ($element->rules as $rule)
							{							
			          if ($rule->name == "equalToCond")
								{
			            $args2 = "'input[name=".$rule->params."]'";
								}	
								else
								{
									if(is_array($rule->params))
									{
										$args2 = "[".implode(",", $rule->params)."]";
									}	
									else
									{
										if (is_string($rule->params))
										{
											$args2 = $rule->params;
										}	
										else
										{
											if (is_bool($rule->params))
											{
												$args2 = "true";
											}	
											else
											{
												$args2 = $rule->params;
											}	
										}		
									}									
								}					
								if ($rule->name == "ajaxexistscond")
								{
									$str .= "remote".":\"".$this->get_best_display_name($element).": " & $this->get_error($form->name, $element->name, $rule->name)."\",";
								}							
			          $str .= $rule->name.":\"".$this->get_best_display_name($element).": ".$this->get_error($form->name, $element->name, $rule->name)."\",";						
							}
							$str = substr($str, 0, strlen($str) - 1)."},";
						}	
		      }
		      $str = substr($str, 0, strlen($str) - 1)."}";
				}	
				else				
				{
					$str .= ",messages:{";
					foreach ($form->elements as $element)
					{
						if (count($element->rules) >0)
						{
							$str .= "'".$element->name."' :{";					
							foreach ($element->rules as $rule)
							{
								if ($rule->name == "equalTo")
								{
									$args2 = "'input[name=".$rule->params."]'";
								}	
								else
								{
									if ($rule->name == "range")
									{
										$args2 = explode(",", $rule->params);
									}	
									else
									{
										if ($rule->name == "rangelength")
										{
											$args2 = explode(",", $rule->params);
										}	
										else
										{
											if (is_array($rule->params))
											{
												$args2 .= "[".implode(",", $rule->params)."]";
											}	
											else
											{
												if (is_string($rule->params))
												{
													$args2 = $rule->params;
												}	
												else
												{
													if (is_bool($rule->params))
													{
														$args2 = "true";
													}	
													else
													{
														$args2 = $rule->params;
													}
												}	
											}	
										}	
									}	
								}	
								if ($rule->name == "ajaxexistscond")
								{
									$str .= "remote: \"".$this->get_error($form->name, $element->name, $rule->name)."\",";
								}
								$str .= $rule->name.": \"".$this->get_error($form->name, $element->name, $rule->name)."\",";
							}
							$str = substr($str, 0, strlen($str) - 1)."},";
						}						
					}
					$str = substr($str, 0, strlen($str) - 1)."}";
				}		
				if($this->cs_validate_on_submit)
				{
					$str .= ", onsubmit: true";
				}	
				else
				{
					$str .= ", onsubmit: false";
				}
				if (!$this->cs_validate_on_change)
				{
					$str .= ", onfocusout: false";
					$str .= ", onkeyup: false";
					$str .= ", onclick: false";
				}
				$str .= ", errorClass: 'dmxError'";
				if ($this->report_type == 1 || $this->report_type == 2 || $this->report_type == 3)
				{
					$str .= ", errorContainer: container";
					$str .= ", errorLabelContainer: containerlist";
					$str .= ", wrapper: 'li'";
				}
				if ($this->report_type == 0)
				{
					$str .= ", errorPlacement:  function(error, element) {\n";
					$str .= "if ($('[name=' +element.attr('name') +']').length > 1) {\n";
					$str .= "if($('[name=' + element.attr('name') +']:last').parent()[0].tagName.toLowerCase() == 'label') {\n";
					$str .= "error.insertAfter($('[name=' + element.attr('name') + ']:last').parent()[0]); }\n";
					$str .= "else {\n";
					$str .= "error.insertAfter($('[name=' + element.attr('name') + ']:last')); }}\n";
					$str .= "else {\n";
					$str .= "if ($('[name=' + element.attr('name') +']').parent()[0].tagName.toLowerCase() == 'label') {\n";
					$str .= "error.insertAfter($('[name=' + element.attr('name') + ']').parent()); }\n";
					$str .= "else {\n";
					$str .= "error.insertAfter(element) }}}";
				}
				if ($this->report_type == 4)
				{
					$str .= ", showErrors: function(errorMap, errorList) {\n";
					$str .= "for (var i = 0; i < this.successList.length; i++) {\n";
					$str .= "this.settings.unhighlight.call( this, this.successList[i], this.settings.errorClass );";
					$str .= "closePrompt(this.successList[i], 'error'); }\n";
					$str .= "if(errorList.length < 1)document.MM_returnValue = true;\n";
					$str .= "for (var i = 0; i < errorList.length; i++) {\n";		
          $str .= "document.MM_returnValue = false;";	
					$str .= "this.settings.highlight && this.settings.highlight.call( this, this.errorList[i].element, this.settings.errorClass );";
					$str .= "if($('.dmxTooltipError[name=\"dmx_' + escape(errorList[i].element.name) +'\"]').length > 0) {\n";
					$str .= "updatePrompt(errorList[i].element, errorList[i].message, '".$this->tooltip_position."');";
					$str .= "} else {\n";
					$str .= "if (errorList[i].element.type && errorList[i].element.type == 'checkbox' || errorList[i].element.type == 'radio'){ \n";
					$str .= "buildPrompt(errorList[i].element, errorList[i].message, 'load', false, '".$this->tooltip_position."'); }";
					$str .= "else { \n";
					$str .= "buildPrompt(errorList[i].element, errorList[i].message, 'load', true, '".$this->tooltip_position."');";
					$str .= "}}};} \n";
				}
				$str .= "});";
				$str .= "var onsubmit = $('#".$key."').attr(\"onsubmit\");"; 
        $str .= "$('#".$key."').removeAttr(\"onsubmit\").submit(new Function(onsubmit));";
	    }      
		}
		$str .= "});\n";
		$str .= "--></script>";
		return $str;
	}
	
	function get_rule_obj($form, $element, $rule)
	{
		if(is_object($form))
		{
			$form = $form->name;
		}
		if(is_object($element))
		{
			$element = $element->name;
		}		
		foreach ($this->forms[$form]->elements[$element]->rules as $myrule)
		{
			if ($myrule->name == $rule)
			{
				return $myrule;
			}
		}
		return "";
	}
	
	function get_error($form, $element, $rule_name)        
	{		
		$rule = $this->get_rule_obj($form, $element,$rule_name);
		if ($rule->custom_message != '')
		{
			return $rule->custom_message;
		}
		else
		{
			if ($this->translation->has_xml != true)
			{
				$this->translation->load($this->get_lang_file());
			}
			$args_arr = explode(",", $rule->params);
			if ($rule_name != "requiredcond" && $rule_name != "allformats")
			{
				return $this->translation->value_ex($rule->name, $args_arr);  
			}
			else
			{
				return $this->translation->value_ex("requiredcond",$args_arr);
			}
		}
  }
	
	function generate_error($form, $element, $rule)
	{		
		if (strtolower($_SERVER["REQUEST_METHOD"]) == "post")
		{
			if (isset($this->forms[$form]->elements[$element]->rules[$rule]) && $this->forms[$form]->elements[$element]->rules[$rule]->error)
			{		
				echo "<label class=\"dmxError\" for=\"".$element."\" generated=\"true\" style=\"padding-left: 5px; display: inline;\"> ".$this->get_error($form, $element, $rule)."</label>";								
			}
		}
	}
	
	function generate_javascript_and_css()
	{
		echo $this->get_css();
		echo $this->get_javascript();		
	}
	
	function error_report_full($dpt)
	{	
		$str = '';
		if(strtolower($_SERVER["REQUEST_METHOD"]) == "post")
		{		
			if(!$this->valid)
			{
				if($this->report_type == 1 || $this->report_type == 2)
				{
					$str .= "<div class=\"dmxerrorreport\">";
				}
				if($this->report_header_text != '')
				{
					$str .= $this->report_header_text;
				}
				if($this->report_list_style == 0)
				{
					$str .= "<ul>";
				}	
				else 
				{
					$str .= "<ol>";
				}
				foreach($this->forms as $form)
				{
					foreach ($form->elements as $element)
					{
						foreach($element->rules as $rule)
							{
								if ($rule->error)
								{
									$str .=  "<li><label class=\"dmxError\" for=\"".$element->name."\" generated=\"true\" style=\"display: inline;\"> ".$this->get_best_display_name($element).": ".$this->get_error($form->name, $element->name, $rule->name)."</label></li>";
								}	
							}
						
					}
				}
		    if($this->report_list_style == 0)
				{
					$str .= "</ul>";
				}	
				else 
				{
					$str .= "</ol>";
				}
				if($this->report_footer_text != '')
				{
					$str .= $this->report_footer_text;
				}
				if($this->report_type == 1 || $this->report_type == 2)
				{
					$str .= "</div>";
				}
			}
		}
		echo $str;
	}
	
	function error_report($form)
	{	
		$str = '';
		if (strtolower($_SERVER["REQUEST_METHOD"]) == "post")
		{	
			if(!$this->valid)
			{
				if($this->report_type == 1 || $this->report_type == 2)
				{
					$str .= "<div class=\"dmxerrorreport\" style=\"display: block\">";
				}
				if($this->report_header_text != '')
				{
					$str .= $this->report_header_text;
				}
				if($this->report_list_style == 0)
				{
					$str .= "<ul>";
				}
				else 
				{
					$str .= "<ol>";
				}				 
				foreach ($this->forms[$form]->elements as $element)
				{
					
						foreach ($element->rules as $rule)
						{
							if($rule->error)
							{
								$str .= "<li><label class=\"dmxError\" for=\"".$element->name."\" generated=\"true\" style=\"display: inline;\"> ".$this->get_best_display_name($element).": ".$this->get_error($form, $element->name, $rule->name)."</label></li>";
							}	
						}
				}
				
			  if ($this->report_list_style == 0)
				{
					$str .= "</ul>";
				}	
				else 
				{
					$str .= "</ol>";
				}
				if ($this->report_footer_text != '')
				{
					$str .= $this->report_footer_text;
				}
				if($this->report_type == 1 || $this->report_type == 2)
				{
					$str .= "</div>";
				}
			}
		}
		echo $str;
	}
	
	function get_best_display_name($element)
	{
		if ($element->err_label != '')
		{
			return $element->err_label;
		}
		else
		{
			return $element->name;
		}
	}
	
	function get_mask($mask, $format)
	{
		$mask_spec = '';
		switch(strtolower($mask))
		{
			case "date":
				switch($format)
				{
					case "dd.mm.yyyy":
						$mask_spec = "39.19.2999";
						break;
					case "yyyy.dd.mm":
						$mask_spec = "2999.39.19";
						break;
					case "mm.dd.yyyy":
						$mask_spec = "19.39.2999";
						break;
					case "yyyy.mm.dd":
						$mask_spec = "2999.19.39";
						break;
					case "mm.dd.yy":
						$mask_spec = "19.39.99";
						break;
					case "yy.mm.dd":
						$mask_spec = "99.19.39";
						break;
					case "dd.mm.yy":
						$mask_spec = "39.19.99";
						break;
					case "yy.dd.mm":
						$mask_spec = "99.39.19";
						break;					
					case "dd-mm-yyyy":
						$mask_spec = "39-19-2999";
						break;
					case "yyyy-dd-mm":
						$mask_spec = "2999-39-19";
						break;
					case "mm-dd-yyyy":
						$mask_spec = "19-39-2999";
						break;
					case "yyyy-mm-dd":
						$mask_spec = "2999-19-39";
						break;
					case "mm-dd-yy":
						$mask_spec = "19-39-99";
						break;
					case "yy-mm-dd":
						$mask_spec = "99-19-39";
						break;
					case "dd-mm-yy":
						$mask_spec = "39-19-99";
						break;
					case "yy-dd-mm":
						$mask_spec = "99-39-19";
						break;					
					case "dd/mm/yyyy":
						$mask_spec = "39/19/2999";
						break;
					case "yyyy/dd/mm":
						$mask_spec = "2999/39/19";
						break;
					case "mm/dd/yyyy":
						$mask_spec = "19/39/2999";
						break;
					case "yyyy/mm/dd":
						$mask_spec = "2999/19/39";
						break;
					case "mm/dd/yy":
						$mask_spec = "19/39/99";
						break;
					case "yy/mm/dd":
						$mask_spec = "99/19/39";
						break;
					case "dd/mm/yy":
						$mask_spec = "39/19/99";
						break;
					case "yy/dd/mm":
						$mask_spec = "99/39/19";
						break;					
				}		
				break;
			case "time":
				switch($format)
				{
					case "hh:mm:ss":
						$mask_spec = "29:59:59";
						break;
					case "hh:mm":
						$mask_spec = "29:59";
						break;
					case "hh.mm.ss":
						$mask_spec = "29.59.59";
						break;
					case "hh.mm":
						$mask_spec = "29.59";
						break;
				}
				break;
			case "creditcard":
				switch($format)
				{
					case "16 digit":
					$mask_spec = "9999 9999 9999 9999";
					break;
				}
				break;
			case "expdate":	
				switch($format)
				{
					case "mm/yy":
						$mask_spec = "19/99";
						break;
					case "yy/mm":
						$mask_spec = "99/19";
						break;
					case "mmyy":
						$mask_spec = "1999";
						break;
					case "yymm":
						$mask_spec = "9919";
						break;
					case "mm-yy":
						$mask_spec = "19-99";
						break;
					case "yy-mm":
						$mask_spec = "99-19";
						break;
				}
				break;
			case "seccode":
				switch($format)
				{
					case "3 digit":
						$mask_spec = "999";
						break;
				}
				break;
			case "phone":
				switch($format)
				{
					case "Australia":
						$mask_spec = "(09) 9999 9999";
						break;
					case "Brazil":
						$mask_spec = "(99) 9999-9999";
						break;
					case "Denmark":
						$mask_spec = "9999 9999";
						break;
					case "France":
						$mask_spec = "99 99 99 99";
						break;
					case "Germany":
						$mask_spec = "09999 s999999";
						break;
					case "Netherlands":
						$mask_spec = "0999 999999";
						break;
					case "North America":						
						$mask_spec = "(999) 999-9999";
						break;
					case "Spain":
						$mask_spec = "999 99 99 99";
						break;
					case "Switzerland":
						$mask_spec = "099 999 99 99";
						break;
				}
				break;
			case "zipcode":
				switch($format)
				{
					case "Canada":
						$mask_spec = "a9a 9a9";
						break;
					case "Netherlands":
						$mask_spec = "9999 aa";
						break;
					case "United States":
						$mask_spec = "99999";
						break;
				}
				break;
			case "ssn":
				switch($format)
				{
					case "Austria(SSN)":
						$mask_spec = "9999999999";
						break;
					case "Belgium(NN)":
						$mask_spec = "99999999999";
						break;
					case "Bulgaria(UCN)":
						$mask_spec = "9999999999";
						break;
					case "Canada(SIN)":
						$mask_spec = "999-999-999";
						break;
					case "China(ID)":
						$mask_spec = "999999999999999999";
						break;
					case "Denmark(CPR)":
						$mask_spec = "999999-9999";
						break;
					case "Finland(HETU)":
						$mask_spec = "999999^999*";
						break;
					case "France(INSEE)":
						$mask_spec = "999999999999999";
						break;
					case "Netherlands(BSN)":
						$mask_spec = "999999999";
						break;
					case "New Zealand(NHI)":
						$mask_spec = "aaa9999";
						break;
					case "Norway(BN)":
						$mask_spec = "99999999999";
						break;
					case "Spain(DNI)":
						$mask_spec = "X-9999999-a";
						break;
					case "Sweden(PIN)":
						$mask_spec = "9999999999";
						break;
					case "Turkey":
						$mask_spec = "99999999999";
						break;
					case "United Kingdom(NI)":
						$mask_spec = "aa999999*";
						break;
					case "United States(SSN)":
						$mask_spec = "999-99-999";
						break;
				}
			break;	
			case "custom":				
				$mask_spec = $format;
				break;
		}
		return $mask_spec;
	}
	
	function set_conditional_action($args, $cond_act, $cond_cont, $element)		
	{
		$my_act = new dmx_conditional_action();		
		$temp_arr = explode(",", $args);  		
		$mind = count($temp_arr) - 2;
		$basen = $temp_arr[$mind];
		$my_act->dependent_el = $basen;
		$my_act->dependent_val = $temp_arr[count($temp_arr) -1];
		$my_act->action = $cond_act;
		if ($cond_act != 0 && $cond_act != 1)
		{
			$con_arr = explode(",", $cond_cont);			
			$my_act->container = $con_arr[0];		
			$my_act->type =$con_arr[1];		
			$my_act->speed =$con_arr[2];		
		}
		else
		{
			if ($cond_act ==1)
			{
				$my_act->disable_el = $element;
			}
		}
		$this->conditional_actions[] = $my_act;
	}
	
	function add_rule($form, $element, $command, $arguments, $required, $custom_message, $err_label, $cond_act, $cond_cont)
	{
		if(!isset($this->forms[$form]))
		{
			$this->forms[$form] = new dmx_validate_form();
			$this->forms[$form]->name = $form;
		}
		if(!isset($this->forms[$form]->elements[$element]) &&(!($command == "allformats" && $required=="false")))
		{
			$this->forms[$form]->elements[$element] = new dmx_validate_element();
			$this->forms[$form]->elements[$element]->name = $element;			
			$this->forms[$form]->elements[$element]->errLabel = $err_label;	
		}		
		$arguments = $this->replace_placeholders($arguments);		
		if ($command != "allformats")
		{			
			$this->forms[$form]->elements[$element]->add_rule($command, $arguments, $custom_message);
		}
		if($required == "true")
		{			
			$this->forms[$form]->elements[$element]->add_rule("requiredcond", $arguments, $custom_message);
		}
		if ($cond_act != 0)
		{			
			$this->set_conditional_action($arguments, $cond_act, $cond_cont, $element);
		}				
  }
	
	function add_mask($form, $element, $mask_type, $mask_format)
	{		
		$my_mask = $this->get_mask($mask_type, $mask_format);
		$this->masks[$element] = $my_mask;
	}
	
	function replace_placeholders($str)
	{
		if (strpos($str, "##curmonth##") !== false)
		{
			$str = str_replace("##curmonth##", date('n'), $str);			
		}
		if (strpos($str, "##curyear##") !== false)
		{
			$str =  str_replace("##curyear##", date('Y'), $str);
		}
		if (strpos($str, "##curday##") !== false)
		{
			$str = str_replace("##curday##",date('j'), $str);
		}
		if (strpos($str, "##curweekday##") !== false)
		{
			$str = str_replace("##curweekday##",date('w'), $str);
		}
		return $str;
	}
	function add_hint($form, $element, $hint)
	{
		$this->hints[$element] = $hint;
	}
	
	function show_bot_check_error()
	{
		if(strtolower($_SERVER['REQUEST_METHOD']) == "post")
		{
			if ($this->is_bot)
			{
				echo "<label class=\"dmxError\">You did not pass the bot check. Please make sure you have javascript and cookies enabled.</label>";
			}				
		}
	}
	
	function validate()
	{	
		if (strtolower($_SERVER['REQUEST_METHOD']) == "post")
		{  
			if (isset($_SERVER['HTTP_REFERER']))
			{
				if (strpos($_SERVER['HTTP_REFERER'], "?") !== false)
				{
					$ref = substr($_SERVER['HTTP_REFERER'], 0, strpos($_SERVER['HTTP_REFERER'], "?"));
				}
				else
				{
					$ref = $_SERVER['HTTP_REFERER'];
				}
			}
			else
			{
				$ref = '';
			}
			$pageURL = 'http';
			if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
			$pageURL .= "://";
			if (isset($_SERVER["SERVER_PORT"]) && $_SERVER["SERVER_PORT"] != "80") 
			{
				$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["SCRIPT_NAME"];
			} 
			else 
			{
				$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["SCRIPT_NAME"];
			}
			if($ref == '' || $ref == $pageURL)
			{
				$has_error = false;
	      foreach ($this->forms as $fkey=>$form)
				{   
					if($this->use_bot_check)
					{
						if(session_id() == "")
						{
							session_start();
						} 
						if (!(isset($_POST["dmx_botcheck_".$fkey]) && $_POST["dmx_botcheck_".$fkey] == session_id()))
						{
							$this->is_bot = true;
							$this->valid = false;
							$has_error = true;
							break;
						}
					}
	        foreach ($form->elements as $ekey=>$element)
					{
						$element->name = str_replace('[]', '', $element->name);						
						if(isset($_POST[$element->name]))
						{
		          if ($_POST[$element->name] != '')
							{						
		            foreach ($element->rules as $rkey=>$val)
								{	
									$args = $val->params;																		
									if (!$this->{$val->name}($element->name, $args))
									{						
										$has_error = true;
										$this->valid = false;
										$this->forms[$fkey]->elements[$ekey]->rules[$rkey]->error = true;
										break;
									}
		            }
							}
							else
							{
								foreach ($element->rules as $rkey=>$val)
								{
									if ($val->name == "requiredcond")
									{
										$args = $val->params;									
										if(!$this->requiredcond($element->name, $args))
										{
											$has_error = true;
											$this->valid = false;
											$this->forms[$fkey]->elements[$ekey]->rules[$rkey]->error = true;
											break;
										}
									}
								}
		          }
						}											
						else
						{
							foreach ($element->rules as $rkey=>$val)
							{
								if ($val->name == "requiredcond" || $val->name == "minrequiredcond")
								{		
									$params = explode(",",$val->params);								
									$offset = count($params) - 2;
									if (count($params) > 0)
									{
										if ($params[$offset] != '')
										{										
											
											if ($this->check_condition($params[$offset], $params[$offset +1]))
											{
												$has_error = true;
												$this->valid = false;
												$this->forms[$fkey]->elements[$ekey]->rules[$rkey]->error = true;
												break;								
											}
										}
										else
										{
											$has_error = true;
											$this->valid = false;
											$this->forms[$fkey]->elements[$ekey]->rules[$rkey]->error = true;
											break;								
										}
									}									
								}
							}
	          }
	        }
	      }
	      $this->validated = true;
	      $this->valid = !$has_error;
				if(!$this->valid)
				{
					if (class_exists('pureFileUpload'))
					{
						$this->clean_ppu();
					}
					$GLOBALS['mm_abort_edit'] = true; 
					//$mm_abort_edit = true;				
				}
			}
    }
    return $this->valid;
  }
	
	function clean_ppu()
	{
	
	}
	
	function requiredcond($element, $param)
	{
		$params = explode(",",$param);
		$offset = count($params) - 2;
		if (count($params) > 0)
		{
			if ($params[$offset] != '')
			{
				if (!$this->check_condition($params[$offset], $params[$offset +1]))
				{
					return true;
				}
			}
		}
    return ($_POST[$element] != '' && strlen($_POST[$element]) > 0);
  }
	
	function minlengthcond($element, $param)
	{
		if($_POST[$element] == '')
		{
			return true;
		}
		$params = explode(",",$param);
		if (count($params) > 0)
		{
			if($params[1] != '')
			{
				if(!$this->check_condition($params[1], $params[2]))
				{
					return true;
				}
			}
		}
    return strlen($_POST[$element]) >= intval($params[0]);
  }
	
	function numbercompcond($element, $param)
	{
		if ($_POST[$element] == '')
		{
			return true;
		}
		$params = explode( ",", $param);
		if (count($params) > 0)
		{
			if($params[1] != '')
			{
				if(!$this->check_condition($params[1], $params[2]))
				{
					return true;
				}
			}
		}
		if (!is_numeric($_POST[$element]))
		{
				return false;
		}
    return eval($_POST[$element].$params[0]);
  }
	
	function maxlengthcond($element, $param)
	{
		if ($_POST[$element] == '')
		{
			return true;
		}
		$params = explode(",", $param);
		if (count($params) > 0)
		{
			if ($params[1] != '')
			{
				if(!$this->check_condition($params[1], $params[2]))
				{
					return true;
				}
			}
		}
    return strlen($_POST[$element]) <= intval($params[0]);
  }
	
	function rangelengthcond($element, $param)
	{
		if($_POST[$element] == '')
		{
			return true;
		}
    $params = explode( ",", $param);		
		if (count($params) > 2)
		{
			if($params[2] != '')
			{
				if(!$this->check_condition($params[2], $params[3]))
				{
					return true;
				}
			}
		}
		$length = strlen($_POST[$element]);
    return $length >= intval($params[0]) && $length <= intval($params[1]);
  }
	
	function minrequiredcond($element, $param)
	{
		$element = str_replace('[]', '', $element);		
		$params = explode(",",$param);
		if (count($params) > 0)
		{
			if($params[1] != '')
			{
				if(!$this->check_condition($params[1], $params[2]))
				{
					return true;
				}
			}
		}
		if (!isset($_POST[$element]) && intval($params[0]) > 0)
		{
			return false;
		}		
		if(!isset($_POST[$element]) || !is_array($_POST[$element]))
		{
			return true;
		}
		return (count($_POST[$element]) >= intval($params[0]));
	}
	
	function maxrequiredcond($element, $param)		
	{
		$element = str_replace('[]', '', $element);
		$params = explode( ",", $param);
		if(count($params) > 0)
		{
			if($params[1] != '')
			{
				if(!$this->check_condition($params[1], $params[2]))
				{
					return true;
				}
			}
		}
		if(!isset($_POST[$element]) || !is_array($_POST[$element]))
		{
			return true;
		}		
		return (count($_POST[$element]) <= intval($params[0]));
	}
	
	function mincond($element, $param)
	{
		if($_POST[$element] == '')
		{
			return true;
		}
		$params = explode( ",", $param);
		if(count($params) > 0)
		{
			if ($params[1] != '')
			{
				if(!$this->check_condition($params[1], $params[2]))
				{
					return true;
				}
			}
		}
		if(!is_numeric($_POST[$element]))
		{
			return false;
		}
    return $_POST[$element] >= $params[0];
  }
	
	function sessioncond($element, $param)
	{
		if($_POST[$element] == '')
		{
			return true;
		}
		$params = explode( ",", $param);
		if(count($params) > 0)
		{
			if ($params[1] != '')
			{
				if(!$this->check_condition($params[1], $params[2]))
				{
					return true;
				}
			}
		}
		if(!isset($_SESSION))
		{
			session_start();
		}
		if (isset($_SESSION[$params[0]]))
		{
			if($_POST[$element] == $_SESSION[$params[0]])
			{
				return true;
			}
		}
    return false;
  }	
	
	function ajaxexistscond($element, $param)
	{
		return $this->remotecond($element, $param);
	}
	
	function remotecond($element, $param)
	{
		if($_POST[$element] == '')
		{
			return true;
		}
		$params = explode(",", $param);
		if (count($params) > 0)
		{
			if($params[1] != '')
			{
				if(!$this->check_condition($params[1], $params[2]))
				{
					return true;
				}
			}
		}		
		$r_url = $params[0]."?".$element."=".$_POST[$element];		
		/*if (isset($_SERVER['HTTPS']))
		{
			$full_url = "https://";
		}	
		else
		{*/
			$full_url = "http://";
		//}
		$full_url .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"];			
		$relPath = $_SERVER["SCRIPT_NAME"];
		$slashpos = strrpos($relPath, "/");
		if ($slashpos > 0)
		{
			$relPath = substr($relPath, 0, $slashpos);
		}
		else
		{
			$relPath= "";
		}
		$full_url .= $relPath;
		if (substr($full_url, -1) == '/' && substr($r_url, 0, 1) == "/")
		{
			$r_url = $full_url.substr($r_url, 1);
		}	
		else
		{
			if (substr($full_url, -1) == '/' || substr($r_url, 0, 1) == '/')			
			{
				$r_url = $full_url.$r_url;
			}	
			else
			{
				$r_url = $full_url."/".$r_url;
			}
		}		
		if (function_exists('curl_init'))
		{
			$curl_handle = curl_init($r_url);
			curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
			if (curl_exec($curl_handle) == "true")
			{
				return true;
			}		
			else
			{
				return false;
			}
		}
		else		
		{
			if(ini_get('allow_url_fopen') == "1")
			{
				if (file_get_contents($r_url) == "true")
				{
					return true;
				}		
				else
				{
					return false;
				}
			}
		}
		return true;
	}
	
	function maxcond($element, $param)
	{
		if($_POST[$element] == '')
		{
			return true;
		}
		$params = explode(",",$param);
		if(count($params) > 0)
		{
			if($params[1] != '')
			{
				if(!$this->check_condition($params[1], $params[2]))
				{
					return true;
				}
			}
		}
		if(!is_numeric($_POST[$element]))
		{
			return false;			
		}		
		return intval(params(0)) <= intval($_POST[$element]);			
  }
	
	function rangecond($element, $param)
	{
		if($_POST[$element] == '')
		{
			return true;
		}
    $value = $_POST[$element];
    $params = explode(",", $param);				
		if (count($params) > 1)
		{
			if($params[2] != '')
			{
				if(!$this->check_condition($params[2], $params[3]))
				{
					return true;
				}
			}
		}
    return ($value >= $params[0] && $value <= $params[1]);
  }
  
  function charactersetcond($element, $param)
	{	
		if($_POST[$element] == '')
		{
			return true;
		}
		$params = explode(",", $param);
		$l = count($params);
		if(count($params) > 0)
		{
			if($params[$l-2] != '')
			{
				if(!$this->check_condition($params[$l-2], $params[$l-1]))
				{
					return true;
				}
			}
		}		
		$rex = '/^[\s';
		for ($i = 0; $i < $l-2; $i++)
		{
        $rex .= $this->get_charset_regex($params[$i]);
    }
    $rex .= ']*$/u'; 
    return preg_match($rex, $_POST[$element]) > 0;		
  }
  
  function get_charset_regex($lang)
  {
    switch (strtolower($lang))
    {
      case "armenian":
        return "\x{0530}-\x{058A}\x{FB00}-\x{FB4F}";
        break;
      case "coptic":
        return "\x{2C80}-\x{2CFF}\x{0370}-\x{03FF}";
        break;
      case "cyrillic":
        return "\x{0400}-\x{04FF}\x{0500}-\x{0525}\x{2DE0}-\x{2DFF}\x{A640}-\x{A697}";
        break;
      case "georgian":
        return "\x{10A0}-\x{10FC}\x{2D00}-\x{2D25}";
        break;
      case "glagolitic":
        return "\x{2C00}-\x{2C5E}";
        break;
      case "latin":
        return "\x{0000}-\x{007F}\x{0080}-\x{00FF}\x{0100}-\x{017F}\x{0180}-\x{024F}\x{2C60}-\x{2C7F}\x{A270}-\x{A7FF}\x{1E00}-\x{1EFF}\x{FB00}-\x{FB4F}\x{FF10}-\x{FFEE}";
        break;
      case "arabic":
        return "\x{0600}-\x{06FF}\x{0750}-\x{077F}\x{FB50}-\x{FC3F}\x{FE70}-\x{FEFF}";
        break;
      case "hebrew":
        return "\x{0591}-\x{05F4}\x{FB00}-\x{FB4F}";
        break;
      case "samaritan":
        return "\x{0800}-\x{083E}";
        break;
      case "syriac":
        return "\x{0700}-\x{074F}";
        break;
      case "mongolian":
        return "\x{1800}-\x{18AA}";
        break;
      case "phags-pa":
        return "\x{A840}-\x{A877}";
        break;
      case "tibetan":
        return "\x{0F00}-\x{0FD8}";
        break;
      case "bengali":
        return "\x{0980}-\x{09FB}";
        break;
      case "devanagari":
        return "\x{0900}-\x{097F}\x{A8E0}-\x{A8FB}";
        break;
      case "gujarati":
        return "\x{0A81}-\x{0AF1}";
        break;
      case "gurmukhi":
        return "\x{0A01}-\x{0A75}";
        break;
      case "kannada":
        return "\x{0C82}-\x{0CF2}";
        break;
      case "limbu":
        return "\x{1900}-\x{194F}";
        break;
      case "malayalam":
        return "\x{0D02}-\x{0D7F}";
        break;
      case "oriya":
        return "\x{0B01}-\x{0B71}";
        break;
      case "sinhala":
        return "\x{0D82}-\x{0DF4}";
        break;
      case "tamil":
        return "\x{0B82}-\x{0BFA}";
        break;
      case "telugu":
        return "\x{0C01}-\x{0C7F}";
        break;
      case "thaana":
        return "\x{0780}-\x{07B1}";
        break;
      case "vedic extensions":
        return "\x{1CD0}-\x{1CF2}";
        break;
      case "balinese":
        return "\x{1B00}-\x{1B7C}";
        break;
      case "buginese":
        return "\x{1A00}-\x{1A1F}";
        break;
      case "cham":
        return "\x{AA00}-\x{AA5F}";
        break;
      case "javanese":
        return "\x{A980}-\x{A9DF}";
        break;
      case "kayah li":
        return "\x{A900}-\x{A92F}";
        break;
      case "khmer":
        return "\x{1780}-\x{17F9}\x{19E0}-\x{19FF}";
        break;
      case "lao":
        return "\x{0E81}-\x{0EDD}";
        break;
      case "myanmar":
        return "\x{1000}-\x{109F}\x{AA60}-\x{AA7B}";
        break;
      case "new tai lue":
        return "\x{1980}-\x{19DF}";
        break;
      case "rejang":
        return "\x{A930}-\x{A95F}";
        break;
      case "sundanese":
        return "\x{1B80}-\x{1BB9}";
        break;
      case "tai le":
        return "\x{1950}-\x{1974}";
        break;
      case "tai tham":
        return "\x{1A20}-\x{1AAD}";
        break;
      case "tai viet":
        return "\x{AA80}-\x{AADF}";
        break;
      case "thai":
        return "\x{0E01}-\x{0E5B}";
        break;
      case "tagalog":
        return "\x{1700}-\x{1714}";
        break;
      case "bopomofo":
        return "\x{3100}-\x{312D}\x{31A0}-\x{31B7}";
        break;
      case "cjk unified ideographs":
        return "\x{4E00}-\x{9FCB}\x{3400}-\x{4DB5}";
        break;
      case "cjk compatibility ideographs":
        return "\x{F900}-\x{FAD9}";
        break;
      case "cjk radicals":
        return "\x{2F00}-\x{2FD5}\x{2E80}-\x{2EF3}\x{31C0}-\x{31E3}\x{2FF0}-\x{2FFB}";
        break;
      case "hangul jamo":
        return "\x{1100}-\x{11FF}\x{A960}-\x{A97C}\x{D780}-\x{D7FB}\x{3131}-\x{318E}\x{FF01}-\x{FFEE}";
        break;
      case "hangul syllables":
        return "\x{AC00}-\x{D7A3}";
        break;
      case "hiragana":
        return "\x{0341}-\x{309F}";
        break;
      case "katakana":
        return "\x{30A0}-\x{30FF}\x{31F0}-\x{31FF}\x{FF01}-\x{FFEE}";
        break;
      case "lisu":
        return "\x{A4D0}-\x{A4FF}";
        break;
      case "yi":
        return "\x{A000}-\x{A48C}\x{A490}-\x{A4C6}";
        break;
    }
    return '';
  }
    
  function emailcond($element, $param)
	{	
		if($_POST[$element] == '')
		{
			return true;
		}
		$params = explode(",", $param);
		
		if(count($params) > 0)
		{
			if($params[1] != '')
			{
				if(!$this->check_condition($params[1], $params[2]))
				{
					return true;
				}
			}
		}		
    return preg_match('/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/', $_POST[$element]) > 0;		
  }
	
	function letterscond($element, $param)
	{		
		if($_POST[$element] == '')
		{
			return true;
		}
		$params = explode(",", $param);
		if(count($params) > 0)
		{
			if($params[1] != '')
			{
				if(!$this->check_condition($params[1], $params[2]))
				{
					return true;
				}
			}
		}		
		if ($params[0] == 'true')
		{
			$rex = '/^[a-zA-Z\s]*$/';
		}
		else
		{
			$rex = '/^[a-zA-Z]*$/';
		}
    return preg_match($rex, $_POST[$element]) > 0;		
  }
	
	function alphanumericcond($element, $param)
	{		
		if($_POST[$element] == '')
		{
			return true;
		}
		$params = explode(",", $param);
		if(count($params) > 0)
		{
			if($params[1] != '')
			{
				if(!$this->check_condition($params[1], $params[2]))
				{
					return true;
				}
			}
		}		
		if ($params[0] == 'true')
		{
			$rex = '/^[a-zA-Z0-9\s]*$/';
		}
		else
		{
			$rex = '/^[a-zA-Z0-9]*$/';
		}
    return preg_match($rex, $_POST[$element]) > 0;		
  }
	
	function alphanumericlatcond($element, $param)
	{		
		if($_POST[$element] == '')
		{
			return true;
		}
		$params = explode(",", $param);
		if(count($params) > 0)
		{
			if($params[1] != '')
			{
				if(!$this->check_condition($params[1], $params[2]))
				{
					return true;
				}
			}
		}		
		if ($params[0] == 'true')
		{
			$rex = '/^[a-zA-Z0-9\s\x{00c0}-\x{00D6}\x{00D8}-\x{00F6}\x{00F8}-\x{017E}]*$/u';
		}
		else
		{
			$rex = '/^[a-zA-Z0-9\x{00c0}-\x{00D6}\x{00D8}-\x{00F6}\x{00F8}-\x{017E}]*$/u';
		}
    return preg_match($rex, $_POST[$element]) > 0;		
  }
  
	function urlcond($element, $param)
	{
		if($_POST[$element] == '')
		{
			return true;
		}
		$params = explode(",", $param); 
		if(count($params) > 0)
		{
			if($params[1] != '')
			{
				if(!$this->check_condition($params[1], $params[2]))
				{
					return true;
				}
			}
		}
    return (preg_match('/^((ftp|(http(s)?))://)?(\.?([a-z0-9-]+))+\.[a-z]{2,6}(:[0-9]{1,5})?(/[a-zA-Z0-9.,;\?|\'+&%\$#=~_-]+)*$/i', $_POST[$element]) > 0);
  }
    
  function datecond($element, $param)
	{
		if($_POST[$element] == '')
		{
			return true;
		}
		$params = explode(",", $param);
		if(count($params) > 0)
		{
			if ($params[1] != '')
			{
				if(!$this->check_condition($params[1], $params[2]))
				{
					return true;
				}
			}
		}
    return preg_match('/^\d{2,4}[\/\-\.]\d{1,2}[\/\-\.]\d{1,2}$/', $_POST[$element]) >0 || preg_match('/^\d{1,2}[\/\-\.]\d{1,2}[\/\-\.]\d{2,4}$/', $_POST[$element]) >0;
  }
	
	function dateisocond($element, $param)
	{
		if($_POST[$element] == '')
		{
			return true;
		}
		$params = explode(",", $param);
		if(count($params) > 0)
		{
			if ($params[1] != '')
			{
				if(!$this->check_condition($params[1], $params[2]))
				{
					return true;
				}
			}
		}
    return preg_match('/^\d{2,4}[\/\-\.]\d{1,2}[\/\-\.]\d{1,2}$/', $_POST[$element]) >0 || preg_match('/^\d{1,2}[\/\-\.]\d{1,2}[\/\-\.]\d{2,4}$/', $_POST[$element]) >0;
  }
  
  function dateDEcond($element, $param)
	{
		if($_POST[$element] == '')
		{
			return true;
		}
		$params = explode(",", $param);
		if(count($params) > 0)
		{
			if ($params[1] != '')
			{
				if(!$this->check_condition($params[1], $params[2]))
				{
					return true;
				}
			}
		}
    return preg_match('/^\d{1,2}\.\d{1,2}\.\d{2,4}$/', $_POST[$element]) >0;
  }
    
	function numbercond($element, $param)
	{
		if($_POST[$element] == '')
		{
			return true;
		}
		$params = explode(",", $param);
		if(count($params) > 0)
		{
			if($params[1] != '')
			{
				if(!$this->check_condition($params[1], $params[2]))
				{
					return true;
				}
			}
		}
    return preg_match('/^-?(?:\d+|\d{1,3}(?:,\d{3})+)(?:\.\d+)?$/', $_POST[$element]) > 0;
  }
	
	function digitscond($element, $param)
	{
		if($_POST[$element] == '')
		{
			return true;
		}
		$params = explode(",", $param);
		if(count($params) > 0)
		{
			if ($params[1] != '')
			{
				if(!$this->check_condition($params[1], $params[2]))
				{
					return true;
				}
			}
		}
    return preg_match('/^\d+$/', $_POST[$element]) > 0;
  }
	
	function forbiddencond($element, $param)
	{
		if($_POST[$element] == '')
		{
			return true;
		}
		$params = explode(",", $param);
		if(count($params) > 0)
		{
			if ($params[1] != '')
			{
				if(!$this->check_condition($params[1], $params[2]))
				{
					return true;
				}
			}
		}
    return $this->check_forbidden($_POST[$element]);
  }
	
	function check_forbidden($el_val)
	{
		$words_array = file($this->script_folder."/validator_forbidden.txt");
		for ($i=0; $i < count($words_array); $i++)
		{
			if (substr_count($el_val,trim($words_array[$i])) > 0)
			{
				return false;
			}
		}
		return true;
	}
	
	function ibancond($element, $param)
	{
		if($_POST[$element] == '')
		{
			return true;
		}
		$params = explode(",", $param);
		if(count($params) > 0)
		{
			if($params[1] != '')
			{
				if(!$this->check_condition($params[1], $params[2]))
				{				
					return true;
				}
			}
		}
		$value = $_POST[$element];
		$value = preg_replace( '/\s+/', "",$value);
		return $this->isValidIBAN($value);
	}
	

	function isValidIBAN($data, $reformat = true, $countryCode=null, $printErrors=false)
	{
		$str = $data;
		if (strtolower(substr($str, 0, 4)) == "iban")
		{
			$str = substr($str, 4);
		}
		if(!empty($str)){
			if($reformat){
				$str = preg_replace('/[\W_]+/', '', strtoupper($str) );
			}	
			$errors = array();
			if( 4 > strlen($str) || strlen($str) > 34 ){
				$errors[] = 'Invalid string length';
			}
			if(is_numeric($str[0]) || is_numeric($str[1])){
				$errors[] = 'Invalid chars at 0, 1';
			}
			if(!is_numeric($str[2]) || !is_numeric($str[3])){
				$errors[] = 'Invalid chars at 3, 4';
			}
			if(!empty($countryCode)){
				if(!in_array(strtolower(substr($str, 0, 2)), array_map('strtolower', $countryCode)) ){
					$errors[] = 'Invalid Country code. Only accepting '. implode(', ', $countryCode);
				}
			}
			$ibanReplaceChars = range('A','Z');
			foreach (range(10,35) as $tempvalue) {
				$ibanReplaceValues[]=strval($tempvalue);
			}
			$tmpIBAN = substr($str, 4).substr($str, 0, 4);
			$tmpIBAN = str_replace($ibanReplaceChars, $ibanReplaceValues, $tmpIBAN);
			$tmpValue = intval(substr($tmpIBAN, 0, 1));
			for ($i = 1; $i < strlen($tmpIBAN); $i++) {
				$tmpValue *= 10;
				$tmpValue += intval(substr($tmpIBAN,$i,1));
				$tmpValue %= 97;
			}
			if ($tmpValue != 1) {
				$errors[] = 'Invalid checksum';
			}
			if($printErrors){
				echo implode("\n", $errors);
			}
			if(empty($errors)){
				return true;
			}
		}
		return false;
	}

	function vatcond($element, $param)
	{
		if($_POST[$element] == '')
		{
			return true;
		}
		$params = explode(",", $param);
		if(count($params) > 0)
		{
			if($params[1] != '')
			{
				if(!$this->check_condition($params[1], $params[2]))
				{
					return true;
				}
			}
		}
		$value = $_POST[$element];
		$value = preg_replace( '/\s+/', "",$value);		
		return $this->check_vat_number($value);
	}
	
	function check_vat_number($val)
	{
		$vat = new VATChecker("data_vat.xml", "error_vat.xml", "fr");
		return $vat->check($val);
	}
	
	function creditcardcond($element, $param)
	{		
		if($_POST[$element] == '')
		{
			return true;
		}
		$params = explode(",", $param);
		$offset = count($params) - 2;
		if($params[$offset] != '')
		{
			if($this->check_condition($params[$offset], $params[$offset + 1]))
			{
				return true;
			}
		}
		$value = $_POST[$element];
		$value = preg_replace('/\s+/', '',$value);		
		for ($i = 0; $i <= $offset; $i++)
		{
			switch(strtolower($params[$i]))
			{
				case "mastercard":
					if (preg_match('/^5[1-5][0-9]{14}$/',$value) > 0 && $this->luhn_check($value))
					{						
						return true;
					}
					break;
				case "visa":
					if (preg_match('/^4[0-9]{12}(?:[0-9]{3})?$/', $value) > 0 && $this->luhn_check($value))
					{
						return true;
					}
					break;
				case "americanexpress":
					if (preg_match('/^3[47][0-9]{13}$/', $value) > 0 && $this->luhn_check($value))
					{
						return true;
					}
					break;
				case "dinersclub":
					if (preg_match('/^3(?:0[0-5]|[68][0-9])[0-9]{11}$/', $value) > 0 && $this->luhn_check($value))
					{
						return true;
					}
					break;
				case "discover":
					if(preg_match('/^6(?:011|5[0-9]{2})[0-9]{12}$/', $value) > 0 && $this->luhn_check($value))
					{
						return true;
					}
					break;
				case "jcb":				
					if(preg_match('/^(?:2131|1800|3\d{4})\d{11}$/', $value) > 0 && $this->luhn_check($value))
					{
						return true;
					}
					break;
			}
		}
		return false;
	}
	
	function acceptcond($element, $param)
	{
		if($_POST[$element] == '')
		{
			return true;
		}
		$params = explode(",", $param);
		if(count($params) > 0)
		{
			if($params[1] != '')
			{
				if(!$this->check_condition($params[1], $params[2]))
				{
					return true;
				}
			}
		}
    if(is_string($params[0]))
		{
      $params[0] = "png|jpe?g|gif";
    }
		if(preg_match('/.('.$params[0].')$/', $_POST[$element]) >0)
		{
			return true;
		}
    return false;
  }
	
	function allowedcond($element, $param)
	{
		if($_POST[$element] == '')
		{
			return true;
		}
		$params = explode(",", $param);
		if(count($params) > 0)
		{
			if($params[1] != '')
			{
				if(!$this->check_condition($params[1], $params[2]))
				{
					return true;
				}
			}
		}
		$params[0] = preg_quote($this->fix_string($params[0]), '/');		
		$params[0] = str_replace(' ', '\\s',$params[0]);
		if(preg_match('/^['.$params[0].']*$/', $_POST[$element]) >0)
		{
			return true;
		}
    return false;
  }
	
	function fix_string($str)
	{
		return str_replace(array('&#39;','&#34;','&#92;','&#44;'), array('\'','"','\\',','), $str);
	}
	
	function disallowedcond($element, $param)
	{
		if($_POST[$element] == '')
		{
			return true;
		}
		$params = explode(",", $param);
		if(count($params) > 0)
		{
			if($params[1] != '')
			{
				if(!$this->check_condition($params[1], $params[2]))
				{
					return true;
				}
			}
		}   
		$params[0] = preg_quote($this->fix_string($params[0]), '/');	
		$params[0] = str_replace(' ', '\\s',$params[0]);
		if(preg_match('/^[^'.$params[0].']*$/', $_POST[$element]) >0)
		{
			return true;
		}
    return false;
  }
		
	function equaltocond($element, $param)
	{
		if($_POST[$element] == '')
		{
			return true;
		}
		$params = explode(",", $param);
		if(count($params) > 0)
		{
			if($params[1] != '')
			{
				if(!$this->check_condition($params[1], $params[2]))
				{
					return true;
				}
			}
		}
    return ($_POST[$element] == $_POST[$params[0]]);
  }

	function notequaltocond($element, $param)
	{
		if($_POST[$element] == '')
		{
			return true;
		}
		$params = explode(",", $param);
		if(count($params) > 0)
		{
			if($params[1] != '')
			{
				if(!$this->check_condition($params[1], $params[2]))
				{
					return true;
				}
			}
		}
    return ($_POST[$element] != $_POST[$params[0]]);
  }
  	
	function luhn_check($number)
	{	
		$doubledNumber  = "";
		$odd            = false;
		for($i = strlen($number)-1; $i >=0; $i--)
		{
			$doubledNumber .= ($odd) ? $number[$i]*2 : $number[$i];
			$odd            = !$odd;
		}
    $sum = 0;
		for($i = 0; $i < strlen($doubledNumber); $i++)
		{
				$sum += (int)$doubledNumber[$i];
		}
        # A valid number doesn't have a remainder after mod10\
        # or equal to 0
        return (($sum % 10 ==0) && ($sum != 0));
	}
	
	function check_condition($elem, $val)
	{
		//radiobutton check				
		if (!isset($_POST[$elem]))
		{
			return false;
		}
		$elval = "\"".$_POST[$elem]."\"";
		if(is_array($elem))
		{
		
		}
		else
		{			
			$sppos = strpos($val, " ");
			$actval = substr($val, $sppos +1);
			if (!is_numeric($actval) || $actval === true || $actval === false)
			{
				$val = substr($val, 0, $sppos)."'".$actval."'";
			}
			if(eval("return ".$elval.$val.";"))
			{
				return true;
			}	
			else
			{
				return false;
			}
		}
		return true;
	}
	
		
	function get_lang_file()
	{
	 
	  $lang = explode( ",", $_SERVER["HTTP_ACCEPT_LANGUAGE"]);	    
	  for($i = 0; $i < count($lang); $i++)
		{
			$curLang = "";	
			$my_file = '';			
			for($j = 0; $j < strlen($lang[$i]); $j++)
			{				
				$char = ord(substr(strtolower($lang[$i]), $j, 1));
				if ($char >= 97 And $char <= 122)
				{
					$curLang = $curLang.chr($char);
					if (strlen($curLang) == 2)
					{
						break;
					}							
				}
			}			
			if (strlen($curLang) == 2)
			{
				$my_file = $this->script_folder."/localization/dmxValidator_".$curLang.".xml";
				if(file_exists($my_file))
				{
					return $my_file;
				}	      
				else
				{
					$my_file = '';
				}
			}
		}
	 return $this->script_folder."/localization/dmxValidator_en.xml";
	}
	
}

class dmx_conditional_action
{
	var $dependent_el;
	var $dependent_val;
	var $action;
	var $type;
	var $speed;
	var $container;
	
	function dmx_conditional_action()
	{
		$dependent_el = '';
		$dependent_val = '';
		$disable_el = '';
		$action = '';
		$container = '';
		$type = '';
		$speed = '';
	}
}

class dmx_validate_form
{
	var $name;
  var $elements;
	
	function dmx_validate_form()
	{
        $this->name = "form1";
        $this->elements = array();
  }	

}

class dmx_validate_element
{
	var $rules;	
	var $name;
  var $error;
  var $err_label;
	
	function dmx_validate_element()
	{
    $this->name = "";
    $this->error = '';
		$this->err_label = "";       
    $this->rules = array();	   
  }
	
	function set_error($err)
	{
		$this->error = $err;
	}
	
	function add_rule($command, $arguments, $custom_message)
	{
		$ctr = 0;
		$keyname = $command;
		while (array_key_exists($keyname.$ctr, $this->rules))
		{
			$ctr += 1;
		}
		//add custom message stuff here
		$newrule = new dmx_validate_rule();
		$newrule->name = $command;
		$newrule->params = $arguments;
		$newrule->custom_message = $custom_message;
		$this->rules[$keyname] = $newrule;       
	}
    
}

class dmx_val_translation
{ 
  var $xml;
  var $has_xml;
  
  function dmx_val_translation()
  {
	$this->has_xml = false;
  }
  
	function load($file)  
	{
		$this->xml = new XMLParser(file_get_contents($file));
		$this->xml->Parse();
		$this->has_xml = true;
	}
  
	function value($resname)    
	{
		if(!isset($this->xml))
		{
			return "XML file for ".$resname." not found.";     
		}
	
		foreach ($this->xml->document->rule as $rule)
		{
			if($rule->tagAttrs['name'] == $resname)
			{
				return $rule->tagData;
			}
		}
		return "Translation for ".$resname." not found.";     
	} 
    
  
	function value_ex($resname, $params)
	{
	   	if(!isset($this->xml))
		{
			return "XML file for ".$resname." not found.";
		}
		
		foreach ($this->xml->document->rule as $rule)
		{
			if($rule->tagAttrs['name'] == $resname)
			{
				$retval = $rule->tagData;
			}
		}
		if (isset($retval))
		{
			if (isset($params))
			{
				for ($i = 0; $i < count($params); $i++)
				{
					$retval = str_replace('{'.$i.'}', $params[$i], $retval);
				}
				return $retval;
			}
		}
		return "Translation for ".$resname." not found.";
	}
}


class dmx_validate_rule
{
	var $name;
	var $params;
	var $message;
	var $custom_message;
	var $error;
	
	function dmx_validate_rule()
	{
		$this->name = '';	
		$this->params = '';
		$this->error = false;
	}
}

function dmxSetValue($str, $postval)	
{
	if (strtolower($_SERVER["REQUEST_METHOD"]) == "post" && isset($_POST[$postval]))
	{
		return $_POST[$postval];
	}	
	else
	{
		return $str;
	}
}

function dmxSetRadio($str, $postval)
{
	if (strtolower($_SERVER["REQUEST_METHOD"]) == "post" && isset($_POST[$postval]))
	{
		if ($str == $_POST[$postval])
		{
			return "checked";
		}
	}
}

function dmxSetCheckbox($str, $postval)
{
	$postval = str_replace('[]', '', $postval);
	if (strtolower($_SERVER["REQUEST_METHOD"]) == "post" && isset($_POST[$postval]))
	{		
		$foundVal = false;
		
		if (is_array($_POST[$postval]))
		{	
			$cbArr = $_POST[$postval];
			for ($i = 0; $i < count($cbArr); $i++)
			{
				if ($str == trim($cbArr[$i]))
				{
					$foundVal = true;
				}
			}
			if ($foundVal)
			{
				return "checked";
			}			
		}	
		else
		{
			if ($str == $_POST[$postval])
			{
				return "checked";
			}
		}
	}
	return "";
}

function dmxSetSelectOption($str, $postval, $multi)
{
	$postval = str_replace('[]', '', $postval);
	if (strtolower($_SERVER["REQUEST_METHOD"]) == "post" && isset($_POST[$postval]))
	{
		if ($multi)
		{
			$foundVal = false;
			$cbArr = $_POST[$postval];
			for ($i = 0; $i < count($cbArr); $i++)
			{
				if ($str == trim($cbArr[$i]))
				{
					$foundVal = true;
				}
			}
			if ($foundVal)
			{
				return "selected";
			}
		}
		else
		{
			if ($str == $postval)
			{
				return "selected";
			}
		}
	}
	return "";
}
?>