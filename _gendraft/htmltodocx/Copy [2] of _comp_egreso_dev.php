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

$colname_rsinfousuario = "-1";
if (isset($_GET['numdocumento'])) {
  $colname_rsinfousuario = $_GET['numdocumento'];
}
mysql_select_db($database_oConnAlmacen, $oConnAlmacen);
$query_rsinfousuario = sprintf("SELECT * FROM q_func_prov_master WHERE func_doc = %s", GetSQLValueString($colname_rsinfousuario, "text"));
$rsinfousuario = mysql_query($query_rsinfousuario, $oConnAlmacen) or die(mysql_error());
$row_rsinfousuario = mysql_fetch_assoc($rsinfousuario);
$totalRows_rsinfousuario = mysql_num_rows($rsinfousuario);

$colname_rsdocvincsum = "-1";
if (isset($_GET['doclasedoc_id'])) {
  $colname_rsdocvincsum = $_GET['doclasedoc_id'];
}
mysql_select_db($database_oConnAlmacen, $oConnAlmacen);
$query_rsdocvincsum = sprintf("SELECT * FROM q_almacen_600_700_sum WHERE sys_doclasedoc_id_fk = %s", GetSQLValueString($colname_rsdocvincsum, "int"));
$rsdocvincsum = mysql_query($query_rsdocvincsum, $oConnAlmacen) or die(mysql_error());
$row_rsdocvincsum = mysql_fetch_assoc($rsdocvincsum);
$totalRows_rsdocvincsum = mysql_num_rows($rsdocvincsum);

$colname_rsdocvincgroup = "-1";
if (isset($_GET['doclasedoc_id'])) {
  $colname_rsdocvincgroup = $_GET['doclasedoc_id'];
}
mysql_select_db($database_oConnAlmacen, $oConnAlmacen);
$query_rsdocvincgroup = sprintf("SELECT * FROM q_almacen_600_700_group WHERE sys_doclasedoc_id_fk = %s", GetSQLValueString($colname_rsdocvincgroup, "int"));
$rsdocvincgroup = mysql_query($query_rsdocvincgroup, $oConnAlmacen) or die(mysql_error());
//$row_rsdocvincgroup = mysql_fetch_assoc($rsdocvincgroup);
$totalRows_rsdocvincgroup = mysql_num_rows($rsdocvincgroup);

//NeXTenesio3 Special List Recordset
$colname_rsdocvinc = "-1";
if (isset($_GET['doclasedoc_id'])) {
  $colname_rsdocvinc = $_GET['doclasedoc_id'];
}
// Defining List Recordset variable
$NXTFilter_rsdocvinc = "1=1";
if (isset($_SESSION['filter_tfi_listrsdocvinc1'])) {
  $NXTFilter_rsdocvinc = $_SESSION['filter_tfi_listrsdocvinc1'];
}
// Defining List Recordset variable
$NXTSort_rsdocvinc = "midalmacen";
if (isset($_SESSION['sorter_tso_listrsdocvinc1'])) {
  $NXTSort_rsdocvinc = $_SESSION['sorter_tso_listrsdocvinc1'];
}
mysql_select_db($database_oConnAlmacen, $oConnAlmacen);

$query_rsdocvinc = sprintf("SELECT * FROM q_almacen_600_700 WHERE sys_doclasedoc_id_fk = %s", GetSQLValueString($colname_rsdocvinc, "int"));
$rsdocvinc = mysql_query($query_rsdocvinc, $oConnAlmacen) or die(mysql_error());
//$row_rsdocvinc = mysql_fetch_assoc($rsdocvinc);
$totalRows_rsdocvinc = mysql_num_rows($rsdocvinc);
//End NeXTenesio3 Special List Recordset
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
$texto2 = utf8_encode("TIPO DE NOVEDAD:<strong> [".$row_rsalmovtodia['mdconcepto']."] ".$row_rsalmovtodia['co_nomconcepto']." - ".$row_rsgedocumentos['cd_nombredoc']."</strong><br />");
$texto3 = utf8_encode("FECHA DEL COMPROBANTE:<strong> ".$row_rsalmovtodia['mdfechadoc']."</strong>       NÚMERO DE COMPROBANTE:<strong> ".$row_rsgedocumentos['do_nrodoc']."</strong><br />");
$texto4 = utf8_encode("ALMACEN AFECTADO:<strong> [".$row_rsalmovtodia['mdalmacen']."] ".$row_rsalmovtodia['ascodalmacen_nombre']."</strong> <br />");
$texto5 = utf8_encode("BENEFICIARIO / RESPONSABLE:<strong> [".$row_rsgedocumentos['doccnit']."] ".$row_rsinfousuario['func_nombres']."</strong> <br />");
$texto7 = utf8_encode("DEPENDENCIA:<strong> ".$row_rsalmovtodia['de_nomdep']."</strong> <br />");
$texto8 = utf8_encode("DESCRIPCIÓN:<strong> ".$row_rsgedocumentos['do_detalle']."</strong> <br />");
$texto9 = utf8_encode("ESTADO DEL DOCUMENTO:<strong> ".$row_rsalmovtodia['legal_name']."</strong> ");
$texto10 = utf8_encode("  ESTADO DE ELEMENTOS: NUEVO <br />");
$qtyelementos = $totalRows_rscea;
$total = $row_rsdocvincsum['TOTALELEMENTOS'];
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
$html_dom->load('<html><body>'.$texto2.$texto3.$texto4.$texto5.$texto7.$texto6.$texto8.$texto9.$texto10.'</body></html>');
//Fin Objeto HTML

// Cración de array de documento:
$html_dom_array = $html_dom->find('html',0)->children();
$paths = htmltodocx_paths();
$initial_state = array(
  'phpword_object' => &$phpword_object, // Must be passed by reference.
  //'base_root' => 'http://test.local', // Required for link elements - change it to your domain.
  //'base_path' => '/htmltodocx/documentation/', // Path from base_root to whatever url your links are relative to.
  'base_root' => $paths['base_root'],
  'base_path' => $paths['base_path'],
  // Optional parameters - showing the defaults if you don't set anything:
  'current_style' => array('size' => '11'), // The PHPWord style on the top element - may be inherited by descendent elements.
  'parents' => array(0 => 'body'), // Our parent is body.
  'list_depth' => 0, // This is the current depth of any current list.
  'context' => 'section', // Possible values - section, footer or header.
  'pseudo_list' => TRUE, // NOTE: Word lists not yet supported (TRUE is the only option at present).
  'pseudo_list_indicator_font_name' => 'Arial', // Bullet indicator font.
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
$table->addCell(4500)->addImage('logo_c_egreso.png');
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
$table->addCell(2500, $styleCell)->addText('MARCA', $fontStyle);
$table->addCell(2500, $styleCell)->addText('PLACA', $fontStyle);
$table->addCell(2500, $styleCell)->addText('VALOR', $fontStyle);


//for($i = 1; $i <= 10; $i++) {
while ($row_rsdocvinc = mysql_fetch_array($rsdocvinc)){
	$table->addRow();
	$table->addCell(2500)->addText(utf8_encode($row_rsdocvinc['midcuenta']));
	$table->addCell(2500)->addText(utf8_encode($row_rsdocvinc['midcodelem']));
	$table->addCell(2500)->addText(utf8_encode($row_rsdocvinc['ed_nomelemento']));
	$table->addCell(2500)->addText(utf8_encode($row_rsdocvinc['ma_nommarca']));
	$table->addCell(2500)->addText(utf8_encode($row_rsdocvinc['midnroplaca']));
	$table->addCell(2500)->addText(number_format($row_rsdocvinc['mid_valormovto'],2,",","."));
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
	
//$html = file_get_contents('untitled.php');

//$section = $phpword_object->createSection();

// INICIA CREACION DE TABLA RESUMEN
$styleTableD = array('borderSize'=>6, 'borderColor'=>'336699', 'cellMargin'=>80);
$styleFirstRowD = array('borderBottomSize'=>18, 'borderBottomColor'=>'336699', 'bgColor'=>'F7F7F7');

// Define cell style arrays
$styleCellD = array('valign'=>'center');

// Define font style for first row
$fontStyleD = array('bold'=>true, 'align'=>'center');

// Add table style
$phpword_object->addTableStyle('myOwnTableStyleD', $styleTableD, $styleFirstRowD);

// Add table
$table = $section->addTable('myOwnTableStyleD');

// Add row
$table->addRow(500);
$cant = 1;

// Add cells
$table->addCell(2500, $styleCellD)->addText('CUENTA', $fontStyleD);
$table->addCell(2500, $styleCellD)->addText('NOMBRE DE LA CUENTA', $fontStyleD);
$table->addCell(2500, $styleCellD)->addText('CANTIDAD', $fontStyleD);
$table->addCell(2500, $styleCellD)->addText('TOTAL + IVA', $fontStyleD);



//for($i = 1; $i <= 10; $i++) {
while ($row_rsdocvincgroup = mysql_fetch_array($rsdocvincgroup)){
	$table->addRow();
	$table->addCell(2500)->addText(utf8_encode($row_rsdocvincgroup['midcuenta']));
	$table->addCell(2500)->addText(utf8_encode($row_rsdocvincgroup['ca_nomcuenta']));
	$table->addCell(2500)->addText(utf8_encode($row_rsdocvincgroup['QTYELEMENTOS']));
	$table->addCell(2500)->addText(utf8_encode(number_format($row_rsdocvincgroup['TOTALELEMENTOS'],2,',','.')));
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
header('Content-Disposition: attachment; filename='.$row_rsgedocumentos['doclasedoc_id'].'.docx');
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
mysql_free_result($rsalmovtodia);

mysql_free_result($rsgedocumentos);

mysql_free_result($rsinfousuario);

mysql_free_result($rsdocvincsum);

mysql_free_result($rsdocvincgroup);

mysql_free_result($rsdocvinc);
?>