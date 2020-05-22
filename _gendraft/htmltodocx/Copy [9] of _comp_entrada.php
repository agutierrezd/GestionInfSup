<?php require_once('../../Connections/oConnAlmacen.php'); ?>
<?php require_once('../../Connections/toletter.php'); ?>
<?php require_once('../../Connections/global.php'); ?>
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

$colname_rscea = "-1";
if (isset($_GET['doclasedoc_id'])) {
  $colname_rscea = $_GET['doclasedoc_id'];
}
mysql_select_db($database_oConnAlmacen, $oConnAlmacen);
$query_rscea = sprintf("SELECT * FROM q_comprobantes_entrada WHERE doclasedoc_id_fk = %s", GetSQLValueString($colname_rscea, "int"));
$rscea = mysql_query($query_rscea, $oConnAlmacen) or die(mysql_error());
//$row_rscea = mysql_fetch_assoc($rscea);
$totalRows_rscea = mysql_num_rows($rscea);

$colname_rssuma = "-1";
if (isset($_GET['doclasedoc_id'])) {
  $colname_rssuma = $_GET['doclasedoc_id'];
}
mysql_select_db($database_oConnAlmacen, $oConnAlmacen);
$query_rssuma = sprintf("SELECT * FROM q_comprobantes_entrada_suma WHERE doclasedoc_id_fk = %s", GetSQLValueString($colname_rssuma, "int"));
$rssuma = mysql_query($query_rssuma, $oConnAlmacen) or die(mysql_error());
$row_rssuma = mysql_fetch_assoc($rssuma);
$totalRows_rssuma = mysql_num_rows($rssuma);

$colname_rsalmovtodia = "-1";
if (isset($_GET['doclasedoc_id'])) {
  $colname_rsalmovtodia = $_GET['doclasedoc_id'];
}
mysql_select_db($database_oConnAlmacen, $oConnAlmacen);
$query_rsalmovtodia = sprintf("SELECT * FROM q_almovtodia WHERE doclasedoc_id_fk = %s", GetSQLValueString($colname_rsalmovtodia, "int"));
$rsalmovtodia = mysql_query($query_rsalmovtodia, $oConnAlmacen) or die(mysql_error());
$row_rsalmovtodia = mysql_fetch_assoc($rsalmovtodia);
$totalRows_rsalmovtodia = mysql_num_rows($rsalmovtodia);

$colname_rsgedocumentos = "-1";
if (isset($_GET['doclasedoc_id'])) {
  $colname_rsgedocumentos = $_GET['doclasedoc_id'];
}
mysql_select_db($database_oConnAlmacen, $oConnAlmacen);
$query_rsgedocumentos = sprintf("SELECT * FROM q_master_gedocumentos WHERE doclasedoc_id = %s", GetSQLValueString($colname_rsgedocumentos, "int"));
$rsgedocumentos = mysql_query($query_rsgedocumentos, $oConnAlmacen) or die(mysql_error());
$row_rsgedocumentos = mysql_fetch_assoc($rsgedocumentos);
$totalRows_rsgedocumentos = mysql_num_rows($rsgedocumentos);

$colname_rsresumen = "-1";
if (isset($_GET['doclasedoc_id'])) {
  $colname_rsresumen = $_GET['doclasedoc_id'];
}
mysql_select_db($database_oConnAlmacen, $oConnAlmacen);
$query_rsresumen = sprintf("SELECT * FROM q_comprobantes_entrada_resumen WHERE doclasedoc_id_fk = %s", GetSQLValueString($colname_rsresumen, "int"));
$rsresumen = mysql_query($query_rsresumen, $oConnAlmacen) or die(mysql_error());
//$row_rsresumen = mysql_fetch_assoc($rsresumen);
$totalRows_rsresumen = mysql_num_rows($rsresumen);
?>
<?php require_once('../../Connections/oConnContratos.php'); ?>
<?php
require_once 'phpword/PHPWord.php';
require_once 'simplehtmldom/simple_html_dom.php';
require_once 'htmltodocx_converter/h2d_htmlconverter.php';
require_once 'example_files/styles.inc';
require_once 'documentation/support_functions.inc';

//Declaración de variables
$texto0 = utf8_encode("MINISTERIO DE COMERCIO, INDUSTRIA Y TURISMO<br /><br />");
$texto1 = utf8_encode("COMPROBANTE DE ENTRADA A ALMACÉN<br /><br />");
$texto2 = utf8_encode("TIPO DE NOVEDAD:<strong> [".$row_rsalmovtodia['mdconcepto']."] ".$row_rsalmovtodia['co_nomconcepto']." -> ".$row_rsalmovtodia['cd_nombredoc']."</strong><br />");
$texto3 = utf8_encode("FECHA DEL COMPROBANTE:<strong> ".$row_rsalmovtodia['mdfechadoc']."</strong>       NÚMERO DE COMPROBANTE:<strong> ".$row_rsgedocumentos['do_nrodoc']."</strong><br />");
$texto4 = utf8_encode("ALMACEN AFECTADO:<strong> [".$row_rsalmovtodia['mdalmacen']."] ".$row_rsalmovtodia['ascodalmacen_nombre']."</strong> <br />");
$texto5 = utf8_encode("PROVEEDOR / ENTREGADOR:<strong> [".$row_rsgedocumentos['doccnit']."] ".$row_rsgedocumentos['pr_nomproveed']."</strong> <br />");
$texto7 = utf8_encode("DIRECCION: ".$row_rsgedocumentos['pr_replegproveed']." TELÉFONO: ".$row_rsgedocumentos['pr_telproveed']." <br />");
$texto8 = utf8_encode("DESCRIPCIÓN:<strong> ".$row_rsgedocumentos['do_detalle']."</strong> <br />");
$texto9 = utf8_encode("ESTADO DEL DOCUMENTO:<strong> ".$row_rsalmovtodia['legal_name']."</strong> ");
$texto10 = utf8_encode("  ESTADO DE ELEMENTOS: NUEVO <br />");
$qtyelementos = $totalRows_rscea;
$total = $row_rssuma['TOTALDOC'];
$V=new EnLetras();
$texto11 = utf8_encode("SON:  ");
$texto12 = utf8_encode("DEPENDENCIA ACTUAL: [".$row_rsalmovtodia['mddependencia']."] ".$row_rsalmovtodia['de_nomdep']." ");
$texto13 = utf8_encode("<br />CANTIDAD DE ELEMENTOS: ".$qtyelementos."<br />");
$notauno = utf8_encode("Notas:<br>Para efectos de admisibilidad y fuerza probatoria según lo dispuesto en la ley 527 de 1999, el interesado puede probar la validez del mismo a través del siguiente sitio WEB: http://servicios.mincit.gov.co/contratos");
$notados = utf8_encode("<br>La coincidencia entre la información desplegada en pantalla y la contenida en informe impreso, confirma la autenticidad del informe emitido.<br/>El documento debe estar firmado digitalmente por el supervisor del contrato <br /> <br /> ");
$texto14 = utf8_encode("<br /><br />ALMACENISTA:<strong> FERNANDO MARTINEZ MENDEZ</strong><br />");
$texto15 = utf8_encode("<br />CC: 79.468.777  DE BOGOTA <br />");
$fechagen = utf8_encode("Fecha de generación del comprobante: ".$fechac."<br />");

//Fin declaración de variables

// Nuevo documento Word:
$phpword_object = new PHPWord();
$section = $phpword_object->createSection();

// Objeto dom HTML:
$html_dom = new simple_html_dom();
$html_dom->load('<html><body>'.$texto2.$texto3.$texto4.$texto5.$texto6.$texto8.$texto9.$texto10.'</body></html>');
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
  
//CREACION DE ANCABEZADO DE PAGINA
$header = $section->createHeader();
$table = $header->addTable();
$table->addRow();
//$table->addCell(4500)->addText('This is the header.');
$table->addCell(4500)->addImage('logo_c_entrada.png');
//FIN ENCABEZADO DE PAGINA

// INICIO PIE DE PAGINA
$footer = $section->createFooter();
$table = $footer->addTable();
$table->addRow();
//$table->addCell(4500)->addText('This is the footer.');
$table->addCell(4500)->addImage('logo_vuce_x.png');
$footer->addPreserveText('Pagina {PAGE} de {NUMPAGES}', array('align'=>'right'));
//FIN PIE DE PAGINA

// Convert the HTML and put it into the PHPWord object
htmltodocx_insert_html($section, $html_dom_array[0]->nodes, $initial_state);

//**********************************

// INICIA CREACION DE TABLA ELEMENTOS
$styleTable = array('borderSize'=>4, 'borderColor'=>'000000', 'cellMargin'=>70);
$styleFirstRow = array('borderBottomSize'=>16, 'borderBottomColor'=>'000000', 'bgColor'=>'F7F7F7');

// Define cell style arrays
$styleCell = array('valign'=>'center');

// Define font style for first row
$fontStyle = array('bold'=>true, 'align'=>'center');

// Add table style
$phpword_object->addTableStyle('myOwnTableStyle', $styleTable, $styleFirstRow);

// Add table
$table = $section->addTable('myOwnTableStyle');

// Add row
$table->addRow(500);
$cant = 1;

// Add cells
$table->addCell(2500, $styleCell)->addText('CUENTA', $fontStyle);
$table->addCell(2500, $styleCell)->addText('CODIGO', $fontStyle);
$table->addCell(2500, $styleCell)->addText('NOMBRE', $fontStyle);
$table->addCell(2500, $styleCell)->addText('PLACA', $fontStyle);
$table->addCell(2500, $styleCell)->addText('VR. UNITARIO', $fontStyle);
$table->addCell(2500, $styleCell)->addText('VALOR + IVA', $fontStyle);


//for($i = 1; $i <= 10; $i++) {
while ($row_rscea = mysql_fetch_array($rscea)){
	$table->addRow();
	$table->addCell(2500)->addText(utf8_encode($row_rscea['ca_codcuenta']));
	$table->addCell(2500)->addText(utf8_encode($row_rscea['mddcodelem']));
	$table->addCell(2500)->addText(utf8_encode($row_rscea['ed_nomelemento']));
	$table->addCell(2500)->addText(utf8_encode($row_rscea['midnroplaca']));
	$table->addCell(2500)->addText(number_format($row_rscea['mid_valunit'],2,",","."));
	$table->addCell(2500)->addText(number_format($row_rscea['mid_valormovto'],2,",","."));
//}
}
	
// FIN CREACION DE TABLA ELEMENTOS

//*************************************

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
$table->addCell(9000, $styleCelly)->addText("RESUMEN DEL COMPROBANTE:", $fontStyley);

//**************************************

//*************************************
// INICIA CREACION DE TABLA RESUMEN
$styleTableD = array('borderSize'=>6, 'borderColor'=>'000000', 'cellMargin'=>80);
$styleFirstRowD = array('borderBottomSize'=>18, 'borderBottomColor'=>'000000', 'bgColor'=>'F7F7F7');

// Define cell style arrays
$styleCellD = array('valign'=>'center');

// Define font style for first row
$fontStyleD = array('bold'=>true, 'align'=>'center');

// Add table style
$phpword_object->addTableStyle('myOwnTableStyle', $styleTableD, $styleFirstRowD);

// Add table
$table = $section->addTable('myOwnTableStyle');

// Add row
$table->addRow(500);
$cant = 1;

// Add cells
$table->addCell(2500, $styleCell)->addText('', $fontStyle);
$table->addCell(2500, $styleCell)->addText('', $fontStyle);
$table->addCell(2500, $styleCell)->addText('CANTIDAD', $fontStyle);
$table->addCell(2500, $styleCell)->addText('SUBTOTAL', $fontStyle);
$table->addCell(2500, $styleCell)->addText('TOTAL + IVA', $fontStyle);



//for($i = 1; $i <= 10; $i++) {
while ($row_rsresumen = mysql_fetch_array($rsresumen)){
	$table->addRow();
	$table->addCell(2500)->addText(utf8_encode($row_rsresumen['ca_codcuenta']));
	$table->addCell(2500)->addText(utf8_encode($row_rsresumen['ca_nomcuenta']));
	$table->addCell(2500)->addText(utf8_encode($row_rsresumen['QTYELEM']));
	$table->addCell(2500)->addText(utf8_encode(number_format($row_rsresumen['SUBTOTAL'],2,',','.')));
	$table->addCell(2500)->addText(utf8_encode(number_format($row_rsresumen['TOTALGRAL'],2,',','.')));
//}
}
	
// FIN CREACION DE TABLA RESUMEN
//****************************************************************

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
$table->addCell(9000, $styleCelly)->addText("TOTAL GENERAL: ( $ ".number_format($total,2,',','.').") ".utf8_encode($V->ValorEnLetras($total,"pesos")), $fontStyley);

//****************************************************************
	
//$html = file_get_contents('untitled.php');

//$section = $phpword_object->createSection();

// HTML Dom object:
$html_dom2 = new simple_html_dom();
$html_dom2->load('<html><body>'.$texto14.$texto15.'</body></html>');

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

// Convert the HTML and put it into the PHPWord object
htmltodocx_insert_html($section, $html_dom_array[0]->nodes, $initial_state);
//FIN DE TABLA
//************************************
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
header('Content-Disposition: attachment; filename='.$row_rssuma['doclasedoc_id_fk'].'.docx');
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
mysql_free_result($rscea);

mysql_free_result($rssuma);

mysql_free_result($rsalmovtodia);

mysql_free_result($rsgedocumentos);

mysql_free_result($rsresumen);
?>