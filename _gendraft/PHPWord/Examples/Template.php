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
$query_Recordset1 = "SELECT * FROM cert_relmaq_master WHERE solcert_id_fk = 5";
$Recordset1 = mysql_query($query_Recordset1, $oConnCERT) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$value1 = $row_Recordset1['vm1_subpartida'];

?>
<?php
require_once '../PHPWord.php';

$PHPWord = new PHPWord();

$document = $PHPWord->loadTemplate('Template2.docx');
?>

<?php do { ?>

<?php $document->setValue('Value1', $value1);?>

<?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>

<?php $document->save('../docx/Solarsystem.docx');?>

<?php
mysql_free_result($Recordset1);
?>
