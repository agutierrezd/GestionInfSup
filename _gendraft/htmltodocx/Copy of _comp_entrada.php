<?php require_once('../../Connections/oConnAlmacen.php'); ?>
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
$row_rscea = mysql_fetch_assoc($rscea);
$totalRows_rscea = mysql_num_rows($rscea);
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
$texto2 = utf8_encode("TIPO DE NOVEDAD: <br />");
$texto3 = utf8_encode("FECHA DEL COMPROBANTE: <br />");
$texto4 = utf8_encode("ALMACEN AFECTADO: <br />");
$texto5 = utf8_encode("PROVEEDOR / ENTREGADOR: <br />");
$texto7 = utf8_encode("DIRECCION: "." TELÉFONO: <br />");
$texto8 = utf8_encode("DESCRIPCIÓN: <br />");
$texto9 = utf8_encode("ESTADO DEL DOCUMENTO: ");
$texto10 = utf8_encode("  ESTADO DE ELEMENTOS:  <br />");
$notauno = utf8_encode("Notas:<br>Para efectos de admisibilidad y fuerza probatoria según lo dispuesto en la ley 527 de 1999, el interesado puede probar la validez del mismo a través del siguiente sitio WEB: http://servicios.mincit.gov.co/contratos");
$notados = utf8_encode("<br>La coincidencia entre la información desplegada en pantalla y la contenida en informe impreso, confirma la autenticidad del informe emitido.<br/>El documento debe estar firmado digitalmente por el supervisor del contrato <br /> <br /> ");


//Fin declaración de variables

// Nuevo documento Word:
$phpword_object = new PHPWord();
$section = $phpword_object->createSection();

// Objeto dom HTML:
$html_dom = new simple_html_dom();
$html_dom->load('<html><body>'.$texto0.$texto1.$texto2.$texto3.$texto4.$texto5.$texto6.$texto7.$texto8.$texto9.$texto10.'</body></html>');
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

// INICIA CREACION DE TABLA FINANCIERA
$styleTable = array('borderSize'=>6, 'borderColor'=>'000000', 'cellMargin'=>80);
$styleFirstRow = array('borderBottomSize'=>18, 'borderBottomColor'=>'000000', 'bgColor'=>'F7F7F7');

// Define cell style arrays
$styleCell = array('valign'=>'center');

// Define font style for first row
$fontStyle = array('bold'=>true, 'align'=>'center');

// Add table style
$phpword_object->addTableStyle('myOwnTableStyle', $styleTable, $styleFirstRow);

// Add table
$table = $section->addTable('myOwnTableStyle');

// Add row
$table->addRow(900);
$cant = 1;

// Add cells
$table->addCell(2500, $styleCell)->addText('CUENTA', $fontStyle);
$table->addCell(2500, $styleCell)->addText('PLACA', $fontStyle);
$table->addCell(2500, $styleCell)->addText('CODIGO', $fontStyle);
$table->addCell(2500, $styleCell)->addText('NOMBRE', $fontStyle);
$table->addCell(2500, $styleCell)->addText('MARCA', $fontStyle);
$table->addCell(2500, $styleCell)->addText('UNIDAD', $fontStyle);
$table->addCell(2500, $styleCell)->addText('CANTIDAD', $fontStyle);
$table->addCell(2500, $styleCell)->addText('VR. UNITARIO', $fontStyle);
$table->addCell(2500, $styleCell)->addText('VR. TOTAL', $fontStyle);


//for($i = 1; $i <= 10; $i++) {
while ($row_rscea = mysql_fetch_array($rscea)){
	$table->addRow();
	$table->addCell(2500)->addText(utf8_encode($row_rscea['ca_codcuenta']));
	$table->addCell(2500)->addText(utf8_encode($row_rscea['midnroplaca']));
	$table->addCell(2500)->addText(utf8_encode($row_rscea['mddcodelem']));
	$table->addCell(2500)->addText(utf8_encode($row_rscea['ed_nomelemento']));
	$table->addCell(2500)->addText(utf8_encode($row_rscea['ma_nommarca']));
	$table->addCell(2500)->addText(utf8_encode($row_rscea['um_nomunimed']));
	$table->addCell(2500)->addText(utf8_encode($cant));
	$table->addCell(2500)->addText(number_format($row_rscea['mid_valunit'],2,",","."));
	$table->addCell(2500)->addText(number_format($row_rscea['mid_valormovto'],2,",","."));
//}
}
	
// FIN CREACION DE TABLA FINANCIERA

//*********************************

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
$table->addCell(9000, $styleCelly)->addText("ACTIVIDADES DESARROLLADAS", $fontStyley);

//********************************
	
//$html = file_get_contents('untitled.php');

//$section = $phpword_object->createSection();

// HTML Dom object:
$html_dom2 = new simple_html_dom();
$html_dom2->load('<html><body>'.$var_infactividades.$texto20.$texto21.$texto22.$texto23.$texto24.$texto25.$texto26.$notauno.$notados.$texto27.'</body></html>');

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

// INICIA CREACION DE TABLA ANEXOS

if ($totalRows_rsinfanexos > 0) {
$styleTablek = array('borderSize'=>1, 'borderColor'=>'000000', 'cellMargin'=>50);
$styleFirstRowk = array('borderBottomSize'=>10, 'borderBottomColor'=>'000000', 'bgColor'=>'F7F7F7');

// Define cell style arrays
$styleCelk = array('valign'=>'center');

// Define font style for first row
$fontStylek = array('bold'=>true, 'align'=>'center');

// Add table style
$phpword_object->addTableStyle('myOwnTableStylek', $styleTablek, $styleFirstRowk);

// Add table
$table = $section->addTable('myOwnTableStylek');

// Add row
$table->addRow(900);

// Add cells
$table->addCell(6000, $styleCell)->addText('TITULO DEL ANEXO', $fontStyle);
$table->addCell(2500, $styleCell)->addText('ARCHIVO ANEXO', $fontStyle);


//for($i = 1; $i <= 10; $i++) {
while ($row_rsinfanexos = mysql_fetch_array($rsinfanexos)){
	$table->addRow();
	$table->addCell(6000)->addText(utf8_encode($row_rsinfanexos['anexo_titulo']));
	$table->addCell(2500)->addText(utf8_encode($row_rsinfanexos['anexo_file']));
}
}

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
header('Content-Disposition: attachment; filename=TEST.docx');
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
?>