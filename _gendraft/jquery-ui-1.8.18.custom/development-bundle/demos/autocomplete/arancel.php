<?php require_once('../../../../../Connections/oConnCERT.php'); ?>
<?php
// Load the XML classes
require_once('../../../../../includes/XMLExport/XMLExport.php');

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
$query_rslistarancel = "SELECT idarancel, arancel FROM q_arancel_list ORDER BY idarancel ASC";
$rslistarancel = mysql_query($query_rslistarancel, $oConnCERT) or die(mysql_error());
$row_rslistarancel = mysql_fetch_assoc($rslistarancel);
$totalRows_rslistarancel = mysql_num_rows($rslistarancel);

// Begin XMLExport rslistarancel
$xmlExportObj = new XMLExport();
$xmlExportObj->setRecordset($rslistarancel);
$xmlExportObj->addColumn("idarancel", "idarancel");
$xmlExportObj->addColumn("arancel", "arancel");
$xmlExportObj->setMaxRecords("ALL");
$xmlExportObj->setDBEncoding("ISO-8859-1");
$xmlExportObj->setXMLEncoding("ISO-8859-1");
$xmlExportObj->setXMLFormat("NODES");
$xmlExportObj->Execute();
// End XMLExport rslistarancel
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
</body>
</html>
<?php
mysql_free_result($rslistarancel);
?>
