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
if (isset($_GET['inf_id'])) {
  $colname_rsinformesreg = $_GET['inf_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rsinformesreg = sprintf("SELECT * FROM informe_intersup WHERE inf_id = %s ORDER BY inf_consecutivo ASC", GetSQLValueString($colname_rsinformesreg, "int"));
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

$colname_rscontrolpagado = "-1";
if (isset($_GET['doc_id'])) {
  $colname_rscontrolpagado = $_GET['doc_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rscontrolpagado = sprintf("SELECT * FROM q_valorpagado WHERE id_cont_fk = %s", GetSQLValueString($colname_rscontrolpagado, "int"));
$rscontrolpagado = mysql_query($query_rscontrolpagado, $oConnContratos) or die(mysql_error());
$row_rscontrolpagado = mysql_fetch_assoc($rscontrolpagado);
$totalRows_rscontrolpagado = mysql_num_rows($rscontrolpagado);

$colname_rscumplimiento = "-1";
if (isset($_GET['inf_id'])) {
  $colname_rscumplimiento = $_GET['inf_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rscumplimiento = sprintf("SELECT * FROM q_informe_f3 WHERE inf_id = %s", GetSQLValueString($colname_rscumplimiento, "int"));
$rscumplimiento = mysql_query($query_rscumplimiento, $oConnContratos) or die(mysql_error());
$row_rscumplimiento = mysql_fetch_assoc($rscumplimiento);
$totalRows_rscumplimiento = mysql_num_rows($rscumplimiento);

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
require_once 'phpword/PHPWord.php';
require_once 'simplehtmldom/simple_html_dom.php';
require_once 'htmltodocx_converter/h2d_htmlconverter.php';
require_once 'example_files/styles.inc';
require_once 'documentation/support_functions.inc';

//Declaración de variables
$texto0 = utf8_encode("CODIGO DE VERIFICACION No.: ". $row_rsinformesreg['sign_hash']);
$texto1 = utf8_encode("<br /><br /><strong>EL(LA) SUSCRITO(A) SUPERVISOR(A) DEL CONTRATO ESTATAL DE PRESTACIÓN DE SERVICIOS PROFESIONALES No. </strong>"."<strong>".$row_rsinformesreg['inf_numerocontrato']." DE </strong>"."<strong>".$row_rsinfodash['VIGENCIA']."</strong><br /><br /><br />");
$texto2 = utf8_encode("<em>Por medio de la presente certifico que recibí el servicio pactado mediante el Contrato Estatal de Prestación de Servicios Profesionales No. ".$row_rsinformesreg['inf_numerocontrato']." DE </strong>"."<strong>".$row_rsinfodash['VIGENCIA']."suscrito entre La Nación-Ministerio de Comercio, Industria y Turismo y ".$row_rsinformesreg['inf_nombrecontratista']." identificado(a) con cédula de ciudadanía No. ".$row_rsinformesreg['inf_doccontratista'].", cuyo objeto es “ ". utf8_encode($row_rsinfodash['cont_objeto']).".”</em>");
$texto3 = utf8_encode("<em>El contratista de conformidad con los entregables pactados presentó el informe de actividades mensual, para el periodo comprendido entre el 08 Febrero de 2015 al 07 de Marzo 2015 por tanto cumplió a satisfacción con las obligaciones pactadas.</em>");
$texto6 = utf8_encode("<br /><br /><strong>1.	ASPECTOS GENERALES, ADMINISTRATIVOS Y LEGALES</strong><br />");
$texto7 = utf8_encode("N° CONTRATO O CONVENIO: ");
$texto7a = utf8_encode($row_rsinformesreg['inf_numerocontrato']." de ".$row_rsinfodash['VIGENCIA']."<br />");
$texto8 = utf8_encode("NOMBRE DEL CONTRATISTA: ");
$texto8a = utf8_encode($row_rsinformesreg['inf_nombrecontratista']." (".$row_rsinformesreg['inf_doccontratista'].")<br />");
$texto9 = utf8_encode("1.1	Información financiera<br />");
$texto10 = utf8_encode("Valor del contrato $: ".number_format($row_rsinformesreg['inf_valorcontrato'],2,",",".")."  C.D.P: ".$row_rsinformesreg['inf_cdp']." R.P.: ".$row_rsinformesreg['inf_rp']." <br />");
$texto11 = utf8_encode("Rubro: ".$row_rsinformesreg['inf_rubrocode']." <br />");
$texto12 = utf8_encode("<br /><br /><strong>Objeto del contrato:</strong><br />");
$texto12a = utf8_encode($row_rsinfodash['cont_objeto']."<br />");
$texto13 = utf8_encode("Fecha	de	suscripción del  contrato o de la cesión según el caso: ".$row_rsinformesreg['inf_fechasuscripcion']."<br />");
$texto14 = utf8_encode("Fecha de inicio: ".$row_rsinformesreg['inf_fechacont_i']."  Fecha de Terminación: ".$row_rsinformesreg['inf_fechacont_f']." <br />");
$texto15 = utf8_encode("Plazo: ".number_format(($row_rsinformesreg['inf_plazo']/30),0,",",".")." meses,  Vigencia: ".$row_rsinfodash['cont_fechavigencia']." Modificaciones en el plazo: ".$row_rsinformesreg['inf_modificacionesplazo']."<br />");
$texto16 = utf8_encode("Supervisor: ".$row_rsinfosupervisor['usr_name']." ".$row_rsinfosupervisor['usr_lname']." <br />");
$texto17 = utf8_encode("Cargo: ".$row_rsinformesreg['inf_cargo']." <br />Dependencia: ".$row_rsinformesreg['inf_dependencia']." <br />");
$texto18 = utf8_encode("INFORMACIÓN FINANCIERA:");
if ($totalRows_rsgarantias > 0) {$texto19 = utf8_encode("<br /><br /><br /><strong>GARANTÍAS:</strong> <br />");}
$texto20 = utf8_encode("Declara conformidad: ".$row_rscumplimiento['conformidad']." <br />".$row_rsinformesreg['inf_declarainconf_obs']." <br />");
$texto21 = utf8_encode("Informa incumplimiento en las obligaciones del Contrato: ".$row_rscumplimiento['cumplimiento']." <br />".$row_rsinformesreg['inf_incumplimiento_obs']." <br />");
if ($row_rsinformesreg['inf_otrosaspectostecnicos'] != "") {$texto22 = utf8_encode("<strong>ASPECTOS TÉCNICOS</strong> <br />".$row_rsinformesreg['inf_otrosaspectostecnicos']." <br />");}
if ($row_rsinformesreg['inf_recomyobserva'] != "") {$texto23 = utf8_encode("<strong>RECOMENDACIONES Y OBSERVACIONES PARA EL ORDENADOR DEL GASTO</strong> <br />".$row_rsinformesreg['inf_recomyobserva']." <br />");}
$texto24 = utf8_encode("Firma: <br /><br />");
$texto25 = utf8_encode($row_rsinfosupervisor['usr_name']." ".$row_rsinfosupervisor['usr_lname']." <br />");
$texto26 = utf8_encode($row_rsinfosupervisor['nomcar']." <br />");
if ($totalRows_rsinfanexos > 0) {$texto27 = utf8_encode("Documentos registrados en el presente informe: <br />");}
$var_infactividades = utf8_encode($row_rsinformesreg['inf_actividades']);
$saldo = utf8_encode(number_format($row_rsinfodash['VALORI'] - $row_rscontrolpagado['valorpagado'],0,',','.'));
$avgejec = utf8_encode("AVANCE EN LA EJECUCIÓN: ".$row_rsinformesreg['inf_avgejecucion']." % (Establecer en porcentaje aproximado cuánto está ejecutado del contrato).");
$texto88 = utf8_encode("NOTA: En este ítem dependiendo del contrato / convenio de que se trate, se debe indicar cuando haya lugar a ello, pago anticipado, anticipo (amortización), gastos, inversiones realizadas, etc. Gastos efectuados, seguimiento a los dineros invertidos si es el caso y en caso de ser aplicable hacer referencia a las consignaciones efectuadas por el Ministerio. Igualmente deben consignarse las adiciones o reducciones en valor que se presentes.");
$texto89 = utf8_encode("NOTA: En el evento que se detallen modificaciones al contrato / convenio, es necesario que se indique la fecha en la cual las mismas se realizaron, fecha de aprobación de la garantía y en general el cumplimiento de otros requisitos señalados en el documento mediante el cual se realizó la modificación. Cabe precisar que no todas las modificaciones implican aprobación de garantías. Es deber del supervisor verificar cada caso particular.");
$notauno = utf8_encode("Notas:<br>Para efectos de admisibilidad y fuerza probatoria según lo dispuesto en la ley 527 de 1999, el interesado puede probar la validez del mismo a través del siguiente sitio WEB: http://servicios.mincit.gov.co/contratos");
$notados = utf8_encode("<br>La coincidencia entre la información desplegada en pantalla y la contenida en informe impreso, confirma la autenticidad del informe emitido.<br/>El documento debe estar firmado digitalmente por el supervisor del contrato <br /> <br /> ");


//Fin declaración de variables

// Nuevo documento Word:
$phpword_object = new PHPWord();
$section = $phpword_object->createSection();

// Objeto dom HTML:
$html_dom = new simple_html_dom();
$html_dom->load('<html><body>'.$texto0.$texto1.$texto2.'</body></html>');
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
header('Content-Disposition: attachment; filename='.$row_rsinformesreg['inf_hash'].'.docx');
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

mysql_free_result($rscontrolpagado);

mysql_free_result($rscumplimiento);

mysql_free_result($rsinfosupervisor);

mysql_free_result($rsinfanexos);

mysql_free_result($rsgarantias);

mysql_free_result($rspagos);
?>