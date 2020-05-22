<?php require_once('../../../../../Connections/oConnContratos.php'); ?>
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

mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rslistfunc = "SELECT contractor_doc_id, contractor_name FROM contractor_master ORDER BY contractor_name ASC";
$rslistfunc = mysql_query($query_rslistfunc, $oConnContratos) or die(mysql_error());
$row_rslistfunc = mysql_fetch_assoc($rslistfunc);
$totalRows_rslistfunc = mysql_num_rows($rslistfunc);

// Begin XMLExport rslistfunc
$xmlExportObj = new XMLExport();
$xmlExportObj->setRecordset($rslistfunc);
$xmlExportObj->addColumn("contractor_doc_id", "geonameId");
$xmlExportObj->addColumn("contractor_name", "countryName");
$xmlExportObj->setMaxRecords("ALL");
$xmlExportObj->setDBEncoding("ISO-8859-1");
$xmlExportObj->setXMLEncoding("ISO-8859-1");
$xmlExportObj->setXMLFormat("NODES");
$xmlExportObj->setRowNode("geoname");
$xmlExportObj->Execute();
// End XMLExport rslistfunc
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
mysql_free_result($rslistfunc);
?>
