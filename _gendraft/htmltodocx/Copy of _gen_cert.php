<?php require_once('../../Connections/oConnContratos.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$colname_rsinformesreg = "-1";
if (isset($_GET['cert_id'])) {
  $colname_rsinformesreg = $_GET['cert_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rsinformesreg = sprintf("SELECT * FROM q_cert_master WHERE cert_id = %s", GetSQLValueString($colname_rsinformesreg, "int"));
$rsinformesreg = mysql_query($query_rsinformesreg, $oConnContratos) or die(mysql_error());
$row_rsinformesreg = mysql_fetch_assoc($rsinformesreg);
$totalRows_rsinformesreg = mysql_num_rows($rsinformesreg);

$colname_rsinfodash = "-1";
if (isset($_GET['doc_id'])) {
  $colname_rsinfodash = $_GET['doc_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rsinfodash = sprintf("SELECT * FROM q_001_dashboard WHERE id_cont = %s", GetSQLValueString($colname_rsinfodash, "int"));
$rsinfodash = mysql_query($query_rsinfodash, $oConnContratos) or die(mysql_error());
$row_rsinfodash = mysql_fetch_assoc($rsinfodash);
$totalRows_rsinfodash = mysql_num_rows($rsinfodash);

$colname_rsinfosupervisor = "-1";
if (isset($_GET['doc_id'])) {
  $colname_rsinfosupervisor = $_GET['doc_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rsinfosupervisor = sprintf("SELECT * FROM q_global_supervisores WHERE id_cont_fk = %s AND q_global_supervisores.sup_status = 1", GetSQLValueString($colname_rsinfosupervisor, "int"));
$rsinfosupervisor = mysql_query($query_rsinfosupervisor, $oConnContratos) or die(mysql_error());
$row_rsinfosupervisor = mysql_fetch_assoc($rsinfosupervisor);
$totalRows_rsinfosupervisor = mysql_num_rows($rsinfosupervisor);

$colname_rsinfanexos = "-1";
if (isset($_GET['inf_id'])) {
  $colname_rsinfanexos = $_GET['inf_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rsinfanexos = sprintf("SELECT * FROM informe_intersup_anexos WHERE inf_id_fk = %s", GetSQLValueString($colname_rsinfanexos, "int"));
$rsinfanexos = mysql_query($query_rsinfanexos, $oConnContratos) or die(mysql_error());
//$row_rsinfanexos = mysql_fetch_assoc($rsinfanexos);
$totalRows_rsinfanexos = mysql_num_rows($rsinfanexos);

$colname_rsgarantias = "-1";
if (isset($_GET['doc_id'])) {
  $colname_rsgarantias = $_GET['doc_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rsgarantias = sprintf("SELECT * FROM q_garantias WHERE id_cont_fk = %s", GetSQLValueString($colname_rsgarantias, "int"));
$rsgarantias = mysql_query($query_rsgarantias, $oConnContratos) or die(mysql_error());
//$row_rsgarantias = mysql_fetch_assoc($rsgarantias);
$totalRows_rsgarantias = mysql_num_rows($rsgarantias);

$colname_rspagos = "-1";
if (isset($_GET['doc_id'])) {
  $colname_rspagos = $_GET['doc_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rspagos = sprintf("SELECT * FROM contrato_controlpagos WHERE id_cont_fk = %s ORDER BY sys_fecha ASC", GetSQLValueString($colname_rspagos, "int"));
$rspagos = mysql_query($query_rspagos, $oConnContratos) or die(mysql_error());
//$row_rspagos = mysql_fetch_assoc($rspagos);
$totalRows_rspagos = mysql_num_rows($rspagos);
?>
<?php

class EnLetras
{
  var $Void = "";
  var $SP = " ";
  var $Dot = ".";
  var $Zero = "0";
  var $Neg = "Menos";
  
function ValorEnLetras($x, $Moneda ) 
{
    $s="";
    $Ent="";
    $Frc="";
    $Signo="";
        
    if(floatVal($x) < 0)
     $Signo = $this->Neg . " ";
    else
     $Signo = "";
    
    if(intval(number_format($x,2,'.','') )!=$x) //<- averiguar si tiene decimales
      $s = number_format($x,2,'.','');
    else
      $s = number_format($x,0,'.','');
       
    $Pto = strpos($s, $this->Dot);
        
    if ($Pto === false)
    {
      $Ent = $s;
      $Frc = $this->Void;
    }
    else
    {
      $Ent = substr($s, 0, $Pto );
      $Frc =  substr($s, $Pto+1);
    }

    if($Ent == $this->Zero || $Ent == $this->Void)
       $s = "Cero ";
    elseif( strlen($Ent) > 7)
    {
       $s = $this->SubValLetra(intval( substr($Ent, 0,  strlen($Ent) - 6))) . 
             "Millones " . $this->SubValLetra(intval(substr($Ent,-6, 6)));
    }
    else
    {
      $s = $this->SubValLetra(intval($Ent));
    }

    if (substr($s,-9, 9) == "Millones " || substr($s,-7, 7) == "Millón ")
       $s = $s . "de ";

    $s = $s . $Moneda;

    if($Frc != $this->Void)
    {
       $s = $s . " Con " . $this->SubValLetra(intval($Frc)) . "Centavos";
       //$s = $s . " " . $Frc . "/100";
    }
    return ($Signo . $s . " ");
   
}


function SubValLetra($numero) 
{
    $Ptr="";
    $n=0;
    $i=0;
    $x ="";
    $Rtn ="";
    $Tem ="";

    $x = trim("$numero");
    $n = strlen($x);

    $Tem = $this->Void;
    $i = $n;
    
    while( $i > 0)
    {
       $Tem = $this->Parte(intval(substr($x, $n - $i, 1). 
                           str_repeat($this->Zero, $i - 1 )));
       If( $Tem != "Cero" )
          $Rtn .= $Tem . $this->SP;
       $i = $i - 1;
    }

    
    //--------------------- GoSub FiltroMil ------------------------------
    $Rtn=str_replace(" Mil Mil", " Un Mil", $Rtn );
    while(1)
    {
       $Ptr = strpos($Rtn, "Mil ");       
       If(!($Ptr===false))
       {
          If(! (strpos($Rtn, "Mil ",$Ptr + 1) === false ))
            $this->ReplaceStringFrom($Rtn, "Mil ", "", $Ptr);
          Else
           break;
       }
       else break;
    }

    //--------------------- GoSub FiltroCiento ------------------------------
    $Ptr = -1;
    do{
       $Ptr = strpos($Rtn, "Cien ", $Ptr+1);
       if(!($Ptr===false))
       {
          $Tem = substr($Rtn, $Ptr + 5 ,1);
          if( $Tem == "M" || $Tem == $this->Void)
             ;
          else          
             $this->ReplaceStringFrom($Rtn, "Cien", "Ciento", $Ptr);
       }
    }while(!($Ptr === false));

    //--------------------- FiltroEspeciales ------------------------------
    $Rtn=str_replace("Diez Un", "Once", $Rtn );
    $Rtn=str_replace("Diez Dos", "Doce", $Rtn );
    $Rtn=str_replace("Diez Tres", "Trece", $Rtn );
    $Rtn=str_replace("Diez Cuatro", "Catorce", $Rtn );
    $Rtn=str_replace("Diez Cinco", "Quince", $Rtn );
    $Rtn=str_replace("Diez Seis", "Dieciseis", $Rtn );
    $Rtn=str_replace("Diez Siete", "Diecisiete", $Rtn );
    $Rtn=str_replace("Diez Ocho", "Dieciocho", $Rtn );
    $Rtn=str_replace("Diez Nueve", "Diecinueve", $Rtn );
    $Rtn=str_replace("Veinte Un", "Veintiun", $Rtn );
    $Rtn=str_replace("Veinte Dos", "Veintidos", $Rtn );
    $Rtn=str_replace("Veinte Tres", "Veintitres", $Rtn );
    $Rtn=str_replace("Veinte Cuatro", "Veinticuatro", $Rtn );
    $Rtn=str_replace("Veinte Cinco", "Veinticinco", $Rtn );
    $Rtn=str_replace("Veinte Seis", "Veintiseís", $Rtn );
    $Rtn=str_replace("Veinte Siete", "Veintisiete", $Rtn );
    $Rtn=str_replace("Veinte Ocho", "Veintiocho", $Rtn );
    $Rtn=str_replace("Veinte Nueve", "Veintinueve", $Rtn );

    //--------------------- FiltroUn ------------------------------
    If(substr($Rtn,0,1) == "M") $Rtn = "Un " . $Rtn;
    //--------------------- Adicionar Y ------------------------------
    for($i=65; $i<=88; $i++)
    {
      If($i != 77)
         $Rtn=str_replace("a " . Chr($i), "* y " . Chr($i), $Rtn);
    }
    $Rtn=str_replace("*", "a" , $Rtn);
    return($Rtn);
}


function ReplaceStringFrom(&$x, $OldWrd, $NewWrd, $Ptr)
{
  $x = substr($x, 0, $Ptr)  . $NewWrd . substr($x, strlen($OldWrd) + $Ptr);
}


function Parte($x)
{
    $Rtn='';
    $t='';
    $i='';
    Do
    {
      switch($x)
      {
         Case 0:  $t = "Cero";break;
         Case 1:  $t = "Un";break;
         Case 2:  $t = "Dos";break;
         Case 3:  $t = "Tres";break;
         Case 4:  $t = "Cuatro";break;
         Case 5:  $t = "Cinco";break;
         Case 6:  $t = "Seis";break;
         Case 7:  $t = "Siete";break;
         Case 8:  $t = "Ocho";break;
         Case 9:  $t = "Nueve";break;
         Case 10: $t = "Diez";break;
         Case 20: $t = "Veinte";break;
         Case 30: $t = "Treinta";break;
         Case 40: $t = "Cuarenta";break;
         Case 50: $t = "Cincuenta";break;
         Case 60: $t = "Sesenta";break;
         Case 70: $t = "Setenta";break;
         Case 80: $t = "Ochenta";break;
         Case 90: $t = "Noventa";break;
         Case 100: $t = "Cien";break;
         Case 200: $t = "Doscientos";break;
         Case 300: $t = "Trescientos";break;
         Case 400: $t = "Cuatrocientos";break;
         Case 500: $t = "Quinientos";break;
         Case 600: $t = "Seiscientos";break;
         Case 700: $t = "Setecientos";break;
         Case 800: $t = "Ochocientos";break;
         Case 900: $t = "Novecientos";break;
         Case 1000: $t = "Mil";break;
         Case 1000000: $t = "Millón";break;
      }

      If($t == $this->Void)
      {
        $i = $i + 1;
        $x = $x / 1000;
        If($x== 0) $i = 0;
      }
      else
         break;
           
    }while($i != 0);
   
    $Rtn = $t;
    Switch($i)
    {
       Case 0: $t = $this->Void;break;
       Case 1: $t = " Mil";break;
       Case 2: $t = " Millones";break;
       Case 3: $t = " Billones";break;
    }
    return($Rtn . $t);
}

}

$num=$row_rsinformesreg['certpay_valor'];
$V=new EnLetras();
      
?>
<?php
require_once 'phpword/PHPWord.php';
require_once 'simplehtmldom/simple_html_dom.php';
require_once 'htmltodocx_converter/h2d_htmlconverter.php';
require_once 'example_files/styles.inc';
require_once 'documentation/support_functions.inc';

//Declaración de variables
$texto0 = utf8_encode("RADICADO No.: ". $row_rsinformesreg['RADICADO']);
$texto1 = utf8_encode("<br /><br /><strong>LA SUSCRITA COORDINADORA DEL GRUPO DE CONTRATOS DEL MINISTERIO DE COMERCIO, INDUSTRIA Y TURISMO</strong><br />");
$texto2 = utf8_encode("<div align='center'><strong>CERTIFICA QUE:</strong></div>");
$texto3 = utf8_encode($row_rsinformesreg['SOLICITANTE']."&nbsp;suscribió con el Ministerio de Comercio, Industria y Turismo, el siguiente Contrato:");
$texto4 = utf8_encode("<br />".$row_rsinformesreg['certpay_obs']."");
$texto5 = utf8_encode("<br />Que teniendo en cuenta lo anterior, es procedente cancelar la suma de <strong>".strtoupper($V->ValorEnLetras($num,"PESOS"))."</strong> ($". number_format($row_rsinformesreg['certpay_valor'],2,',','.').") por parte del Ministerio de Comercio, Industria y Turismo.");
$texto5a = utf8_encode("<br />Dada en Bogotá D.C., en la fecha: ".$row_rsinformesreg['certpay_fechaelab']."");
$texto6 = utf8_encode("<br /><br />Cordialmente,");
$texto7 = utf8_encode("<br /><br /><strong>CLAUDIA LILIANA MARTÍNEZ MELO<strong>");
$texto8 = utf8_encode("<br />Coordinadora Grupo Contratos");
$notauno = utf8_encode("Notas:<br>Para efectos de admisibilidad y fuerza probatoria según lo dispuesto en la ley 527 de 1999, el interesado puede probar la validez del mismo a través del siguiente sitio WEB: http://servicios.mincit.gov.co/contratos");
$notados = utf8_encode("<br>La coincidencia entre la información desplegada en pantalla y la contenida en informe impreso, confirma la autenticidad del informe emitido.<br/>El documento debe estar firmado digitalmente por el supervisor del contrato <br /> <br /> ");


//Fin declaración de variables

// Nuevo documento Word:
$phpword_object = new PHPWord();
$section = $phpword_object->createSection();

// Objeto dom HTML:
$html_dom = new simple_html_dom();
$html_dom->load('<html><body>'.$texto0.$texto1.$texto2.$texto3.$texto4.$texto5a.$texto6.$texto7.$texto8.'</body></html>');
//Fin Objeto HTML

// Cración de array de documento:
$html_dom_array = $html_dom->find('html',0)->children();
$paths = htmltodocx_paths();
$initial_state = array(
  'phpword_object' => &$phpword_object, // Must be passed by reference.
  // 'base_root' => 'http://test.local', // Required for link elements - change it to your domain.
  // 'base_path' => '/htmltodocx/documentation/', // Path from base_root to whatever url your links are relative to.
  'base_root' => $paths['base_root'],
  'base_path' => $paths['base_path'],
  // Optional parameters - showing the defaults if you don't set anything:
  'current_style' => array('size' => '11'), // The PHPWord style on the top element - may be inherited by descendent elements.
  'parents' => array(0 => 'body'), // Our parent is body.
  'list_depth' => 0, // This is the current depth of any current list.
  'context' => 'section', // Possible values - section, footer or header.
  'pseudo_list' => TRUE, // NOTE: Word lists not yet supported (TRUE is the only option at present).
  'pseudo_list_indicator_font_name' => 'Wingdings', // Bullet indicator font.
  'pseudo_list_indicator_font_size' => '7', // Bullet indicator size.
  'pseudo_list_indicator_character' => 'l ', // Gives a circle bullet point with wingdings.
  'table_allowed' => TRUE, // Note, if you are adding this html into a PHPWord table you should set this to FALSE: tables cannot be nested in PHPWord.
  'treat_div_as_paragraph' => TRUE, // If set to TRUE, each new div will trigger a new line in the Word document.
      
  // Optional - no default:    
  'style_sheet' => htmltodocx_styles_example(), // This is an array (the "style sheet") - returned by htmltodocx_styles_example() here (in styles.inc) - see this function for an example of how to construct this array.
  );
  
// CREACION DE ANCABEZADO DE PAGINA
$header = $section->createHeader();
$table = $header->addTable();
$table->addRow();
//$table->addCell(4500)->addText('This is the header.');
$table->addCell(4500)->addImage('rs.png');
//FIN ENCABEZADO DE PAGINA

// INICIO PIE DE PAGINA
$footer = $section->createFooter();
$table = $footer->addTable();
$table->addRow();
//$table->addCell(4500)->addText('This is the footer.');
$table->addCell(4500)->addImage('logo_vuce_4.png');
$footer->addPreserveText('Pagina {PAGE} de {NUMPAGES}', array('align'=>'right'));
//FIN PIE DE PAGINA

// Convert the HTML and put it into the PHPWord object
htmltodocx_insert_html($section, $html_dom_array[0]->nodes, $initial_state);

//**********************************

$styleTabley = array('borderSize'=>6, 'borderColor'=>'006699');
$styleFirstRowy = array('borderBottomSize'=>18, 'borderBottomColor'=>'0000FF', 'bgColor'=>'66BBFF');

// Define cell style arrays
$styleCelly = array('valign'=>'center');

// Define font style for first row
$fontStyley = array('bold'=>false, 'align'=>'center');

// Add table style
$phpword_object->addTableStyle('myOwnTableStylez', $styleTablex, $styleFirstRowx);

// Add table
$table = $section->addTable('myOwnTableStyley');

// Add row
$table->addRow(900);

// Add cells
$table->addCell(9000, $styleCelly)->addText("-------------------", $fontStyley);

//********************************
	
//$html = file_get_contents('untitled.php');

//$section = $phpword_object->createSection();

// HTML Dom object:
$html_dom2 = new simple_html_dom();
$html_dom2->load('<html><body>'.$notauno.$notados.'</body></html>');

$html_dom_array = $html_dom2->find('html',0)->children();

// We need this for setting base_root and base_path in the initial_state array
// (below). We are using a function here (derived from Drupal) to create these
// paths automatically - you may want to do something different in your
// implementation. This function is in the included file 
// documentation/support_functions.inc.
$paths = htmltodocx_paths();
$initial_state = array(
  // Required parameters:
  'phpword_object' => &$phpword_object, // Must be passed by reference.
  // 'base_root' => 'http://test.local', // Required for link elements - change it to your domain.
  // 'base_path' => '/htmltodocx/documentation/', // Path from base_root to whatever url your links are relative to.
  'base_root' => $paths['base_root'],
  'base_path' => $paths['base_path'],
  // Optional parameters - showing the defaults if you don't set anything:
  'current_style' => array('size' => '8'), // The PHPWord style on the top element - may be inherited by descendent elements.
  'parents' => array(0 => 'body'), // Our parent is body.
  'list_depth' => 0, // This is the current depth of any current list.
  'context' => 'section', // Possible values - section, footer or header.
  'pseudo_list' => TRUE, // NOTE: Word lists not yet supported (TRUE is the only option at present).
  'pseudo_list_indicator_font_name' => 'Wingdings', // Bullet indicator font.
  'pseudo_list_indicator_font_size' => '7', // Bullet indicator size.
  'pseudo_list_indicator_character' => 'l ', // Gives a circle bullet point with wingdings.
  'table_allowed' => TRUE, // Note, if you are adding this html into a PHPWord table you should set this to FALSE: tables cannot be nested in PHPWord.
  'treat_div_as_paragraph' => TRUE, // If set to TRUE, each new div will trigger a new line in the Word document.
      
  // Optional - no default:    
  'style_sheet' => htmltodocx_styles_example(), // This is an array (the "style sheet") - returned by htmltodocx_styles_example() here (in styles.inc) - see this function for an example of how to construct this array.
  );    

// Convert the HTML and put it into the PHPWord object
htmltodocx_insert_html($section, $html_dom_array[0]->nodes, $initial_state);
//FIN DE TABLA


//************************************

// INICIA CREACION DE TABLA ANEXOS


// FIN TABLA ANEXOS

//*************************fin de otra tabla

//$section = $PHPWord->createSection(array('orientation'=>'landscape'));
//$section = $phpword_object->createSection(array('orientation'=>'landscape'));


//$section = $phpword_object->createSection();


//$section->addText($texto2, array('bold'=>true,'name'=>'Verdana', 'color'=>'006699'));


// Clear the HTML dom object:
$html_dom->clear(); 
unset($html_dom);

// Save File
$h2d_file_uri = tempnam('', 'htd');
$objWriter = PHPWord_IOFactory::createWriter($phpword_object, 'Word2007');
$objWriter->save($h2d_file_uri);

// Download the file:
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename='.$row_rsinformesreg['RADICADO'].'.docx');
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: ' . filesize($h2d_file_uri));
ob_clean();
flush();
$status = readfile($h2d_file_uri);
unlink($h2d_file_uri);
exit;
?>
<?php
mysql_free_result($rsinformesreg);

mysql_free_result($rsinfodash);

mysql_free_result($rsinfosupervisor);

mysql_free_result($rsinfanexos);

mysql_free_result($rsgarantias);

mysql_free_result($rspagos);
?>