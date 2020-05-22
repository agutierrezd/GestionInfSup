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

mysql_select_db($database_oConnCERT, $oConnCERT);
$query_Recordset1 = "SELECT * FROM q_case_1_concept WHERE solcert_id_fk = 5";
$Recordset1 = mysql_query($query_Recordset1, $oConnCERT) or die(mysql_error());
//$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_oConnCERT, $oConnCERT);
$query_Recordset2 = "SELECT * FROM q_case_1_concept WHERE solcert_id_fk = 5";
$Recordset2 = mysql_query($query_Recordset2, $oConnCERT) or die(mysql_error());
//$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

?>

<?php
require_once '../PHPWord.php';

// New Word Document
$PHPWord = new PHPWord();

// New portrait section
$section = $PHPWord->createSection();

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


// Add table
$table = $section->addTable('myOwnTableStyle');

// Add row
$table->addRow(900);

// Add cells
$table->addCell(3000, $styleCell)->addText('Row 1', $fontStyle);
$table->addCell(2000, $styleCell)->addText('Row 2', $fontStyle);
$table->addCell(2000, $styleCell)->addText('Row 3', $fontStyle);
$table->addCell(2000, $styleCell)->addText('Row 4', $fontStyle);

// Add more rows / cells
//$i = 0;
while ($row_Recordset1 = mysql_fetch_array($Recordset1)){
// 	$i++; 
	$table->addRow();
	$table->addCell(3000)->addText($row_Recordset1['vm1_subpartida']);
	$table->addCell(2000)->addText($row_Recordset1['vm1_nomtec']);
	$table->addCell(2000)->addText("c $i");
	$table->addCell(2000)->addText("d $i");
}

//$section->addText('AQUI VA EL CONCEPTO', array('bold'=>true,'name'=>'Verdana', 'color'=>'006699'));
$section->addTextBreak(2);

$PHPWord->addTableStyle('myOwnTableStyle2', $styleTable, $styleFirstRow);

$table = $section->addTable('myOwnTableStyle2');

// Add row
$table->addRow(900);

// Add cells
$table->addCell(3000, $styleCell)->addText('Row 1', $fontStyle);
$table->addCell(2000, $styleCell)->addText('Row 2', $fontStyle);
$table->addCell(2000, $styleCell)->addText('Row 3', $fontStyle);
$table->addCell(2000, $styleCell)->addText('Row 4', $fontStyle);

// Add more rows / cells
//$i = 0;
while ($row_Recordset2 = mysql_fetch_array($Recordset2)){
// 	$i++; 
	$table->addRow();
	$table->addCell(3000)->addText($row_Recordset2['vm1_subpartida']);
	$table->addCell(2000)->addText($row_Recordset2['vm1_nomtec']);
	$table->addCell(2000)->addText("c $i");
	$table->addCell(2000)->addText("d $i");
}

// Save File
$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
$objWriter->save('../docx/prueba.docx');
?>
<?php
mysql_free_result($Recordset1);
?>