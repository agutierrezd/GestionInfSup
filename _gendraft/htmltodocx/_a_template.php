<?php
require_once 'phpword/PHPWord.php';
require_once 'simplehtmldom/simple_html_dom.php';
require_once 'htmltodocx_converter/h2d_htmlconverter.php';
require_once 'example_files/styles.inc';
require_once 'documentation/support_functions.inc';

//Declaración de variables
$texto0 = utf8_encode("INFORME No.: <br />");
$texto1 = utf8_encode("FECHA EN QUE SE RINDE EL INFORME: <br />");
$texto2 = utf8_encode("PERIODICIDAD: <br />");
$texto3 = utf8_encode("PERIODO REPORTADO: (DESDE  <br />");
$texto4 = utf8_encode("El presente informe se presenta en cumplimiento de lo dispuesto en la Resoluci&oacute;n No. 5352 del 30 de diciembre de 2011 Por la cual se adopta el manual de Contrataci&oacute;n, supervisi&oacute;n o interventoria del Ministerio de Comercio Industria y Turismo y se dictan otras disposiciones.");
$texto5 = utf8_encode("<table border='1' cellspacing='0' cellpadding='0' width='385'>
  <tr>
    <td width='54' valign='top'><p><strong>Desde</strong></p></td>
    <td width='198' valign='top'><p><strong>&nbsp;</strong></p></td>
    <td width='47' valign='top'><p><strong>Hasta</strong></p></td>
    <td width='227' valign='top'><p><strong>&nbsp;</strong></p></td>
  </tr>
</table>");
$texto6 = utf8_encode("<br /><br /><strong>1.	ASPECTOS GENERALES, ADMINISTRATIVOS Y LEGALES</strong><br />");
$texto7 = utf8_encode("N° CONTRATO O CONVENIO: <br />");
$texto8 = utf8_encode("NOMBRE DEL CONTRATISTA: <br />");
$texto9 = utf8_encode("1.1	Información financiera<br />");
$texto10 = utf8_encode("N° CONTRATO O CONVENIO: XXXXX  C.D.P: XXXXXX R.P.:XXXXX <br /> ");
$texto11 = utf8_encode("Proyecto de inversión: XXXXX <br /> ");
$texto12 = utf8_encode("1.2	Ejecución del Contrato<br />");
$texto13 = utf8_encode("Fecha	de	suscripción del  contrato o de la cesión –según el caso: XXXXX <br /> ");
$texto14 = utf8_encode("Fecha de inicio: XXXXX  Fecha de Terminación: XXXXXXXX <br /> ");
$texto15 = utf8_encode("Plazo: XXXXX Vigencia: XXXXXX Modificaciones en el plazo: XXXXXX<br /> ");
$texto16 = utf8_encode("Objeto del contrato: XXXXX <br /> ");
$texto17 = utf8_encode("Objeto del contrato: XXXXX <br /> ");
$texto18 = utf8_encode("Objeto del contrato: XXXXX <br /> ");






$texto88 = utf8_encode("NOTA: En este ítem dependiendo del contrato / convenio de que se trate, se debe indicar cuando haya lugar a ello, pago anticipado, anticipo (amortización), gastos, inversiones realizadas, etc. Gastos efectuados, seguimiento a los dineros invertidos si es el caso y en caso de ser aplicable hacer referencia a las consignaciones efectuadas por el Ministerio. Igualmente deben consignarse las adiciones o reducciones en valor que se presentes.");



//Fin declaración de variables

// Nuevo documento Word:
$phpword_object = new PHPWord();
$section = $phpword_object->createSection();

// Objeto dom HTML:
$html_dom = new simple_html_dom();
$html_dom->load('<html><body>'.$texto0.$texto1.$texto2.$texto3.$texto5.$texto4.$texto6.$texto7.$texto8.$texto9.$texto10.$texto11.'</body></html>');
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
$table->addCell(4500)->addImage('logo_c_r.png');
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

// INICIA CREACION DE TABLA
$styleTable = array('borderSize'=>6, 'borderColor'=>'006699', 'cellMargin'=>80);
$styleFirstRow = array('borderBottomSize'=>18, 'borderBottomColor'=>'0000FF', 'bgColor'=>'66BBFF');

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

// Add cells
$table->addCell(2500, $styleCell)->addText('Row 1', $fontStyle);
$table->addCell(2500, $styleCell)->addText('Row 2', $fontStyle);
$table->addCell(2500, $styleCell)->addText('Row 3', $fontStyle);
$table->addCell(2500, $styleCell)->addText('Row 4', $fontStyle);

for($i = 1; $i <= 10; $i++) {
	$table->addRow();
	$table->addCell(2500)->addText("Cell $i");
	$table->addCell(2500)->addText("Cell $i");
	$table->addCell(2500)->addText("Cell $i");
	$table->addCell(2500)->addText("Cell $i");
}

//$html = file_get_contents('untitled.php');

//$section = $phpword_object->createSection();

// HTML Dom object:
$html_dom2 = new simple_html_dom();
$html_dom2->load('<html><body>'. $texto0 . $texto1 . $texto2 . '</body></html>');

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
header('Content-Disposition: attachment; filename=aa.docx');
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