<?php require_once('../../Connections/oConnCERT.php'); ?>
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

$colname_rsinfouser = "-1";
if (isset($_GET['productor_id'])) {
  $colname_rsinfouser = $_GET['productor_id'];
}
mysql_select_db($database_oConnCERT, $oConnCERT);
$query_rsinfouser = sprintf("SELECT Productores.productor_id, Productores.productor_nit, Productores.productor_raz, Productores.productor_dir, Productores.productor_rep_leg, Productores.productor_rep_nit, Productores.productor_ciu, Productores.productor_tel, Productores.productor_email, Productores.productor_url, Productores.productor_status, Productores.productor_level, Productores.productor_rdn, Productores.productor_statusupd, Productores.productor_fechaupd, Productores.productor_horaupd, cert_cities.NomMunicipio, cert_states.NomDpto FROM Productores INNER JOIN cert_cities ON Productores.productor_ciu = cert_cities.CodCiudad INNER JOIN cert_states ON cert_cities.CodDpto = cert_states.CodDpto WHERE productor_id = %s", GetSQLValueString($colname_rsinfouser, "int"));
$rsinfouser = mysql_query($query_rsinfouser, $oConnCERT) or die(mysql_error());
$row_rsinfouser = mysql_fetch_assoc($rsinfouser);
$totalRows_rsinfouser = mysql_num_rows($rsinfouser);

$colname_rsinfosolicitud = "-1";
if (isset($_GET['solcert_id'])) {
  $colname_rsinfosolicitud = $_GET['solcert_id'];
}
mysql_select_db($database_oConnCERT, $oConnCERT);
$query_rsinfosolicitud = sprintf("SELECT * FROM q_output_001 WHERE solcert_id = %s", GetSQLValueString($colname_rsinfosolicitud, "int"));
$rsinfosolicitud = mysql_query($query_rsinfosolicitud, $oConnCERT) or die(mysql_error());
$row_rsinfosolicitud = mysql_fetch_assoc($rsinfosolicitud);
$totalRows_rsinfosolicitud = mysql_num_rows($rsinfosolicitud);

$colname_rsinfosolicituda = "-1";
if (isset($_GET['solcert_id'])) {
  $colname_rsinfosolicituda = $_GET['solcert_id'];
}
mysql_select_db($database_oConnCERT, $oConnCERT);
$query_rsinfosolicituda = sprintf("SELECT * FROM q_output_002 WHERE solcert_id = %s", GetSQLValueString($colname_rsinfosolicituda, "int"));
$rsinfosolicituda = mysql_query($query_rsinfosolicituda, $oConnCERT) or die(mysql_error());
$row_rsinfosolicituda = mysql_fetch_assoc($rsinfosolicituda);
$totalRows_rsinfosolicituda = mysql_num_rows($rsinfosolicituda);



$colname_rsconcept = "-1";
if (isset($_GET['solcert_id'])) {
  $colname_rsconcept = $_GET['solcert_id'];
}
mysql_select_db($database_oConnCERT, $oConnCERT);
$query_rsconcept = sprintf("SELECT * FROM q_case_1_concept WHERE solcert_id_fk = %s AND vm1_concept = 1", GetSQLValueString($colname_rsconcept, "text"));
$rsconcept = mysql_query($query_rsconcept, $oConnCERT) or die(mysql_error());
//$row_rsconcept = mysql_fetch_assoc($rsconcept);
$totalRows_rsconcept = mysql_num_rows($rsconcept);

$colname_rsconcepta = "-1";
if (isset($_GET['solcert_id'])) {
  $colname_rsconcepta = $_GET['solcert_id'];
}
mysql_select_db($database_oConnCERT, $oConnCERT);
$query_rsconcepta = sprintf("SELECT * FROM q_case_1_concept WHERE solcert_id_fk = %s AND vm1_concept = 2", GetSQLValueString($colname_rsconcepta, "text"));
$rsconcepta = mysql_query($query_rsconcepta, $oConnCERT) or die(mysql_error());
//$row_rsconcepta = mysql_fetch_assoc($rsconcepta);
$totalRows_rsconcepta = mysql_num_rows($rsconcepta);


$colname_rsconcepte = "-1";
if (isset($_GET['solcert_id'])) {
  $colname_rsconcepte = $_GET['solcert_id'];
}
mysql_select_db($database_oConnCERT, $oConnCERT);
$query_rsconcepte = sprintf("SELECT * FROM q_case_1_concept WHERE solcert_id_fk = %s AND vm1_concept = 3", GetSQLValueString($colname_rsconcepte, "text"));
$rsconcepte = mysql_query($query_rsconcepte, $oConnCERT) or die(mysql_error());
//$row_rsconcepte = mysql_fetch_assoc($rsconcepte);
$totalRows_rsconcepte = mysql_num_rows($rsconcepte);


$colname_rsconcepto = "-1";
if (isset($_GET['solcert_id'])) {
  $colname_rsconcepto = $_GET['solcert_id'];
}
mysql_select_db($database_oConnCERT, $oConnCERT);
$query_rsconcepto = sprintf("SELECT * FROM q_case_1_concept WHERE solcert_id_fk = %s AND vm1_concept = 4", GetSQLValueString($colname_rsconcepto, "text"));
$rsconcepto = mysql_query($query_rsconcepto, $oConnCERT) or die(mysql_error());
//$row_rsconcepto = mysql_fetch_assoc($rsconcepto);
$totalRows_rsconcepto = mysql_num_rows($rsconcepto);

$caso1 = utf8_encode("NO Producción Nacional, SI Maquinaria Pesada");
$caso2 = utf8_encode("NO Producción Nacional, NO Maquinaria Pesada");
$caso3 = utf8_encode("SI Producción Nacional, SI Maquinaria Pesada");
$caso4 = utf8_encode("SI Producción Nacional, NO Maquinaria Pesada");
?>
<?php
/**
*  Example of use of HTML to docx converter
*/


// Load the files we need:

require_once 'phpword/PHPWord.php';
require_once 'simplehtmldom/simple_html_dom.php';
require_once 'htmltodocx_converter/h2d_htmlconverter.php';
require_once 'example_files/styles.inc';



// Functions to support this example.
require_once 'documentation/support_functions.inc';

// HTML fragment we want to parse:



$html = utf8_encode($row_rsinfosolicitud['resp_msj']);
$texto0 = utf8_encode("SDAO- <br />");
$texto1 = utf8_encode("Asunto:<br />");
$texto2 = utf8_encode("Certificación Producción Nacional - Maquinaria  Pesada<br />");
$texto3 = utf8_encode("Respuesta a su radicado ".$row_rsinfosolicitud['solcert_rad']." del ".$row_rsinfosolicitud['solcert_date']."<br />");
$texto4 = utf8_encode("Fecha de respuesta ".$row_rsinfosolicitud['resp_date']);
$representante = utf8_encode($row_rsinfouser['productor_rep_leg']);
$cargo = utf8_encode($row_rsinfouser['productor_rep_nit']);
$empresa = utf8_encode($row_rsinfouser['productor_raz']);
$direccion = utf8_encode($row_rsinfouser['productor_dir']);
$ciudad = utf8_encode($row_rsinfouser['NomMunicipio'].' - '.$row_rsinfouser['NomDpto']);
$correo = utf8_encode($row_rsinfouser['productor_email']);
$telefono = utf8_encode($row_rsinfouser['productor_tel']);
$trato = utf8_encode("Señor(a)");
$proyecta = utf8_encode("Proyectó: ".$row_rsinfosolicitud['usr_name'].' '.$row_rsinfosolicitud['usr_lname']);
$revisayfirma = utf8_encode("Revisa, aprueba y firma: EDILBERTO RODRIGUEZ POLOCHE");
$firmaimagen = '<img src="firmajpg2.jpg"/><br>';
$notauno = utf8_encode("Notas:<br>Para efectos de admisibilidad y fuerza probatoria según lo dispuesto en la ley 527 de 1999, el interesado puede probar la validez del mismo a través del siguiente sitio WEB: http://www.vuce.gov.co  usando el código de verificación de la certificación ubicado en la parte superior del mismo.");
$notados = utf8_encode("<br><br>La coincidencia entre la información desplegada en pantalla y la contenida en la certificación impresa, confirma la autenticidad de la certificación emitida.");
$notatres = utf8_encode("Cordialmente, <br/><br/><br/>Firma válida<br/><br/>");
//$firma = $pdf->Image('../images/signjpg.jpg', '', '', 40, 40, '', '', 'T', false, 300, '', false, false, 0, false, false, false);
$fecharespuesta = utf8_encode("Fecha de respuesta: ".$row_rsinfosolicitud['resp_date']."<br>Entidad: Ministerio de Comercio, Industria y Turismo<br>Lugar: Bogotá.<br />");
$firmadopor = ("<strong>EDILBERTO RODRIGUEZ POLOCHE</strong><br />Coordinador  Grupo Registro de Productores de Bienes Nacionales<br /><br />Firmado digitalmente");
$radicado = utf8_encode($row_rsinfosolicitud['solcert_rad']);
$hastext = utf8_encode("Código de verificación: ");
$hasha = $row_rsinfosolicitud['resp_signedhash'];






 
// New Word Document:
$phpword_object = new PHPWord();
$section = $phpword_object->createSection();

// HTML Dom object:
$html_dom = new simple_html_dom();
$html_dom->load('<html><body>'.$texto0.'<br />'.$hastext.'<strong>'.$hasha.'</strong>'.'<br />'.$trato.'<br />'.$representante.'<br />'.$cargo.'<br /><strong>'.$empresa.'</strong><br />'.$direccion.'<br />'.$ciudad.'<br />'.$telefono.'<br />'.$correo.'<br /><br /><br />'.$texto1.$texto2.$texto3.$texto4.$html.'<br />'.$notatres.'<br />'.$firmadopor.'<br />'.$proyecta.'<br />'.$revisayfirma.'<br />'.$fecharespuesta.$notauno.'<br />'.$notados.'</body></html>');

// Note, we needed to nest the html in a couple of dummy elements.

// Create the dom array of elements which we are going to work on:
$html_dom_array = $html_dom->find('html',0)->children();

// We need this for setting base_root and base_path in the initial_state array
// (below). We are using a function here (derived from Drupal) to create these
// paths automatically - you may want to do something different in your
// implementation. This function is in the included file 
// documentation/support_functions.inc.
$paths = htmltodocx_paths();

// Provide some initial settings:
$initial_state = array(
  // Required parameters:
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


// Add header
$header = $section->createHeader();
$table = $header->addTable();
$table->addRow();
//$table->addCell(4500)->addText('This is the header.');
$table->addCell(4500)->addImage('logo_vuce_3.png');

// Add footer
$footer = $section->createFooter();
$table = $footer->addTable();
$table->addRow();
//$table->addCell(4500)->addText('This is the footer.');
$table->addCell(4500)->addImage('logo_vuce_4.png');
$footer->addPreserveText('Pagina {PAGE} de {NUMPAGES}', array('align'=>'right'));

// Convert the HTML and put it into the PHPWord object
htmltodocx_insert_html($section, $html_dom_array[0]->nodes, $initial_state);

//$section = $PHPWord->createSection(array('orientation'=>'landscape'));
//$section = $phpword_object->createSection(array('orientation'=>'landscape'));

//AQUI COMIENZA LA TABLA DE CONCEPTOS
// Define table style arrays
$styleTable = array('borderSize'=>6, 'borderColor'=>'000000', 'cellMargin'=>80);
$styleFirstRow = array('borderBottomSize'=>18, 'borderBottomColor'=>'000000', 'bgColor'=>'CCCCCC');

// Define cell style arrays
$styleCell = array('valign'=>'center');
//$styleCellBTLR = array('valign'=>'center', 'textDirection'=>PHPWord_Style_Cell::TEXT_DIR_BTLR);

// Define font style for first row
$fontStyle = array('bold'=>true, 'align'=>'center');

// Add table style
$phpword_object->addTableStyle('myOwnTableStyle', $styleTable, $styleFirstRow);

if ($totalRows_rsconcept > 0) {

//COMIENZO CASO 1
$section->addText($caso1, array('bold'=>true,'name'=>'Verdana', 'color'=>'006699'));
$section->addTextBreak(1);

// Add table
$table = $section->addTable('myOwnTableStyle');

// Add row
$table->addRow(900);

// Add cells
$table->addCell(4000, $styleCell)->addText('SUBPARTIDA', $fontStyle);
$table->addCell(4000, $styleCell)->addText('NOMBRE TECNICO', $fontStyle);
$table->addCell(4000, $styleCell)->addText('NUMERO DE MAQUINAS', $fontStyle);

// Add more rows / cells
//$i = 0;
while ($row_rsconcept = mysql_fetch_array($rsconcept)){
// 	$i++; 
	$table->addRow();
	$table->addCell(4000)->addText(utf8_encode($row_rsconcept['vm1_subpartida']));
	$table->addCell(4000)->addText(utf8_encode($row_rsconcept['vm1_nomtec']));
	$table->addCell(4000)->addText(utf8_encode($row_rsconcept['vm1_number']));
	
}
}

if ($totalRows_rsconcepta > 0) {
//COMIENZO CASO 2
$section->addTextBreak(1);
$section->addText($caso2, array('bold'=>true,'name'=>'Verdana', 'color'=>'006699'));
$section->addTextBreak(1);

$phpword_object->addTableStyle('myOwnTableStyle2', $styleTable, $styleFirstRow);

$table = $section->addTable('myOwnTableStyle2');

// Add row
$table->addRow(900);

// Add cells
$table->addCell(4000, $styleCell)->addText('SUBPARTIDA', $fontStyle);
$table->addCell(4000, $styleCell)->addText('NOMBRE TECNICO', $fontStyle);
$table->addCell(4000, $styleCell)->addText('NUMERO DE MAQUINAS', $fontStyle);

// Add more rows / cells
//$i = 0;
while ($row_rsconcepta = mysql_fetch_array($rsconcepta)){
// 	$i++; 
	$table->addRow();
	$table->addCell(4000)->addText(utf8_encode($row_rsconcepta['vm1_subpartida']));
	$table->addCell(4000)->addText(utf8_encode($row_rsconcepta['vm1_nomtec']));
	$table->addCell(4000)->addText(utf8_encode($row_rsconcepta['vm1_number']));
	
}
}
// FIN CASO 2

if ($totalRows_rsconcepte > 0) {
//COMIENZO CASO 3
$section->addTextBreak(1);
$section->addText($caso3, array('bold'=>true,'name'=>'Verdana', 'color'=>'006699'));
$section->addTextBreak(1);

$phpword_object->addTableStyle('myOwnTableStyle2', $styleTable, $styleFirstRow);



$table = $section->addTable('myOwnTableStyle2');

// Add row
$table->addRow(900);

// Add cells
$table->addCell(4000, $styleCell)->addText('SUBPARTIDA', $fontStyle);
$table->addCell(4000, $styleCell)->addText('NOMBRE TECNICO', $fontStyle);
$table->addCell(4000, $styleCell)->addText('NUMERO DE MAQUINAS', $fontStyle);

// Add more rows / cells
//$i = 0;
while ($row_rsconcepte = mysql_fetch_array($rsconcepte)){
// 	$i++; 
	$table->addRow();
	$table->addCell(4000)->addText(utf8_encode($row_rsconcepte['vm1_subpartida']));
	$table->addCell(4000)->addText(utf8_encode($row_rsconcepte['vm1_nomtec']));
	$table->addCell(4000)->addText(utf8_encode($row_rsconcepte['vm1_number']));
	
}
}

// FIN CASO 3

if ($totalRows_rsconcepto > 0) {
//COMIENZO CASO 4

$section->addTextBreak(1);
$section->addText($caso4, array('bold'=>true,'name'=>'Verdana', 'color'=>'006699'));
$section->addTextBreak(1);

$phpword_object->addTableStyle('myOwnTableStyle2', $styleTable, $styleFirstRow);

$table = $section->addTable('myOwnTableStyle2');

// Add row
$table->addRow(900);

// Add cells
$table->addCell(4000, $styleCell)->addText('SUBPARTIDA', $fontStyle);
$table->addCell(4000, $styleCell)->addText('NOMBRE TECNICO', $fontStyle);
$table->addCell(4000, $styleCell)->addText('NUMERO DE MAQUINAS', $fontStyle);

// Add more rows / cells
//$i = 0;
while ($row_rsconcepto = mysql_fetch_array($rsconcepto)){
// 	$i++; 
	$table->addRow();
	$table->addCell(4000)->addText(utf8_encode($row_rsconcepto['vm1_subpartida']));
	$table->addCell(4000)->addText(utf8_encode($row_rsconcepto['vm1_nomtec']));
	$table->addCell(4000)->addText(utf8_encode($row_rsconcepto['vm1_number']));
	
}
}

// FIN CASO 4

//AQUI FINALIZA LA SECCION DE CONCEPTOS

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
header('Content-Disposition: attachment; filename='.$radicado.'.docx');
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