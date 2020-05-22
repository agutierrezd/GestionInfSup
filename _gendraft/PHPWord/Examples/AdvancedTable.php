<?php require_once('../../../Connections/oConnCERT.php'); ?>
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

$caso1 = "NO Producción Nacional, SI Maquinaria Pesada";
$caso2 = "NO Producción Nacional, NO Maquinaria Pesada";
$caso3 = "SI Producción Nacional, SI Maquinaria Pesada";
$caso4 = "SI Producción Nacional, NO Maquinaria Pesada";

?>

<?php
require_once '../PHPWord.php';

// New Word Document
$PHPWord = new PHPWord();

// New portrait section
$section = $PHPWord->createSection();

//AQUI COMIENZA LA TABLA DE CONCEPTOS
// Define table style arrays
$styleTable = array('borderSize'=>6, 'borderColor'=>'000000', 'cellMargin'=>80);
$styleFirstRow = array('borderBottomSize'=>18, 'borderBottomColor'=>'000000', 'bgColor'=>'CCCCCC');

// Define cell style arrays
$styleCell = array('valign'=>'center');
$styleCellBTLR = array('valign'=>'center', 'textDirection'=>PHPWord_Style_Cell::TEXT_DIR_BTLR);

// Define font style for first row
$fontStyle = array('bold'=>true, 'align'=>'center');

// Add table style
$PHPWord->addTableStyle('myOwnTableStyle', $styleTable, $styleFirstRow);

if ($totalRows_rsconcept > 0) {

//COMIENZO CASO 1
$section->addText($caso1, array('bold'=>true,'name'=>'Verdana', 'color'=>'006699'));
$section->addTextBreak(1);

// Add table
$table = $section->addTable('myOwnTableStyle');

// Add row
$table->addRow(900);

// Add cells
$table->addCell(3000, $styleCell)->addText('SUBPARTIDA', $fontStyle);
$table->addCell(2000, $styleCell)->addText('NOMBRE TECNICO', $fontStyle);
$table->addCell(2000, $styleCell)->addText('DESCRIPCION', $fontStyle);
$table->addCell(2000, $styleCell)->addText('FUNCION DE LA MAQUINA', $fontStyle);
$table->addCell(2000, $styleCell)->addText('NUMERO DE MAQUINAS', $fontStyle);

// Add more rows / cells
//$i = 0;
while ($row_rsconcept = mysql_fetch_array($rsconcept)){
// 	$i++; 
	$table->addRow();
	$table->addCell(3000)->addText($row_rsconcept['vm1_subpartida']);
	$table->addCell(2000)->addText($row_rsconcept['vm1_nomtec']);
	$table->addCell(2000)->addText($row_rsconcept['vm1_desc']);
	$table->addCell(2000)->addText($row_rsconcept['vm1_func']);
	$table->addCell(2000)->addText($row_rsconcept['vm1_number']);
	
}
}

if ($totalRows_rsconcepta > 0) {
//COMIENZO CASO 2
$section->addTextBreak(1);
$section->addText($caso2, array('bold'=>true,'name'=>'Verdana', 'color'=>'006699'));
$section->addTextBreak(1);

$PHPWord->addTableStyle('myOwnTableStyle2', $styleTable, $styleFirstRow);

$table = $section->addTable('myOwnTableStyle2');

// Add row
$table->addRow(900);

// Add cells
$table->addCell(3000, $styleCell)->addText('SUBPARTIDA', $fontStyle);
$table->addCell(2000, $styleCell)->addText('NOMBRE TECNICO', $fontStyle);
$table->addCell(2000, $styleCell)->addText('DESCRIPCION', $fontStyle);
$table->addCell(2000, $styleCell)->addText('FUNCION DE LA MAQUINA', $fontStyle);
$table->addCell(2000, $styleCell)->addText('NUMERO DE MAQUINAS', $fontStyle);

// Add more rows / cells
//$i = 0;
while ($row_rsconcepta = mysql_fetch_array($rsconcepta)){
// 	$i++; 
	$table->addRow();
	$table->addCell(3000)->addText($row_rsconcepta['vm1_subpartida']);
	$table->addCell(2000)->addText($row_rsconcepta['vm1_nomtec']);
	$table->addCell(2000)->addText($row_rsconcepta['vm1_desc']);
	$table->addCell(2000)->addText($row_rsconcepta['vm1_func']);
	$table->addCell(2000)->addText($row_rsconcepta['vm1_number']);
	
}
}
// FIN CASO 2

if ($totalRows_rsconcepte > 0) {
//COMIENZO CASO 3
$section->addTextBreak(1);
$section->addText($caso3, array('bold'=>true,'name'=>'Verdana', 'color'=>'006699'));
$section->addTextBreak(1);

$PHPWord->addTableStyle('myOwnTableStyle2', $styleTable, $styleFirstRow);



$table = $section->addTable('myOwnTableStyle2');

// Add row
$table->addRow(900);

// Add cells
$table->addCell(3000, $styleCell)->addText('SUBPARTIDA', $fontStyle);
$table->addCell(2000, $styleCell)->addText('NOMBRE TECNICO', $fontStyle);
$table->addCell(2000, $styleCell)->addText('DESCRIPCION', $fontStyle);
$table->addCell(2000, $styleCell)->addText('FUNCION DE LA MAQUINA', $fontStyle);
$table->addCell(2000, $styleCell)->addText('NUMERO DE MAQUINAS', $fontStyle);

// Add more rows / cells
//$i = 0;
while ($row_rsconcepte = mysql_fetch_array($rsconcepte)){
// 	$i++; 
	$table->addRow();
	$table->addCell(3000)->addText($row_rsconcepte['vm1_subpartida']);
	$table->addCell(2000)->addText($row_rsconcepte['vm1_nomtec']);
	$table->addCell(2000)->addText($row_rsconcepte['vm1_desc']);
	$table->addCell(2000)->addText($row_rsconcepte['vm1_func']);
	$table->addCell(2000)->addText($row_rsconcepte['vm1_number']);
	
}
}

// FIN CASO 3

if ($totalRows_rsconcepto > 0) {
//COMIENZO CASO 4

$section->addTextBreak(1);
$section->addText($caso4, array('bold'=>true,'name'=>'Verdana', 'color'=>'006699'));
$section->addTextBreak(1);

$PHPWord->addTableStyle('myOwnTableStyle2', $styleTable, $styleFirstRow);

$table = $section->addTable('myOwnTableStyle2');

// Add row
$table->addRow(900);

// Add cells
$table->addCell(3000, $styleCell)->addText('SUBPARTIDA', $fontStyle);
$table->addCell(2000, $styleCell)->addText('NOMBRE TECNICO', $fontStyle);
$table->addCell(2000, $styleCell)->addText('DESCRIPCION', $fontStyle);
$table->addCell(2000, $styleCell)->addText('FUNCION DE LA MAQUINA', $fontStyle);
$table->addCell(2000, $styleCell)->addText('NUMERO DE MAQUINAS', $fontStyle);

// Add more rows / cells
//$i = 0;
while ($row_rsconcepto = mysql_fetch_array($rsconcepto)){
// 	$i++; 
	$table->addRow();
	$table->addCell(3000)->addText($row_rsconcepto['vm1_subpartida']);
	$table->addCell(2000)->addText($row_rsconcepto['vm1_nomtec']);
	$table->addCell(2000)->addText($row_rsconcepto['vm1_desc']);
	$table->addCell(2000)->addText($row_rsconcepto['vm1_func']);
	$table->addCell(2000)->addText($row_rsconcepto['vm1_number']);
	
}
}

// FIN CASO 4

//AQUI FINALIZA LA SECCION DE CONCEPTOS


// Save File
$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
$objWriter->save('../docx/prueba.docx');
?>
<?php
mysql_free_result($rsconcept);
?>