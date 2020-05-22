<?php require_once('../Connections/oConnContratos.php'); ?>
<?php
// Load the XML classes
require_once('../includes/XMLExport/XMLExport.php');

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
$query_rsminuta = "SELECT * FROM contrato_minuta WHERE ctrl = 1 ORDER BY Id DESC";
$rsminuta = mysql_query($query_rsminuta, $oConnContratos) or die(mysql_error());
$row_rsminuta = mysql_fetch_assoc($rsminuta);
$totalRows_rsminuta = mysql_num_rows($rsminuta);

// Begin XMLExport rsminuta
$xmlExportObj = new XMLExport();
$xmlExportObj->setRecordset($rsminuta);
$xmlExportObj->addColumn("No", "No");
$xmlExportObj->addColumn("fecha", "fecha");
$xmlExportObj->addColumn("contractor_name", "contractor_name");
$xmlExportObj->addColumn("nit", "nit");
$xmlExportObj->addColumn("nit_dv", "nit_dv");
$xmlExportObj->addColumn("direc", "direc");
$xmlExportObj->addColumn("email", "email");
$xmlExportObj->addColumn("tel", "tel");
$xmlExportObj->addColumn("banco", "banco");
$xmlExportObj->addColumn("cuenta", "cuenta");
$xmlExportObj->addColumn("tipo", "tipo");
$xmlExportObj->addColumn("objeto", "objeto");
$xmlExportObj->addColumn("valor", "valor");
$xmlExportObj->addColumn("rubro", "rubro");
$xmlExportObj->addColumn("cdp", "cdp");
$xmlExportObj->addColumn("plazo", "plazo");
$xmlExportObj->addColumn("garantia", "garantia");
$xmlExportObj->addColumn("superv", "superv");
$xmlExportObj->addColumn("formapago", "formapago");
$xmlExportObj->addColumn("NaturalezaContratista", "NaturalezaContratista");
$xmlExportObj->addColumn("ModalidadContratacion", "ModalidadContratacion");
$xmlExportObj->addColumn("ClaseContrato", "ClaseContrato");
$xmlExportObj->addColumn("NombreSupervisor", "NombreSupervisor");
$xmlExportObj->addColumn("dependencia", "dependencia");
$xmlExportObj->addColumn("representantelegal", "representantelegal");
$xmlExportObj->addColumn("Otrosi_Adicional_1", "Otrosi_Adicional_1");
$xmlExportObj->addColumn("Otrosi2", "Otrosi2");
$xmlExportObj->addColumn("Inicia", "Inicia");
$xmlExportObj->addColumn("Termina", "Termina");
$xmlExportObj->addColumn("clausula_ambiental", "clausula_ambiental");
$xmlExportObj->addColumn("Resol_Sello", "Resol_Sello");
$xmlExportObj->addColumn("ctrl", "ctrl");
$xmlExportObj->setMaxRecords("ALL");
$xmlExportObj->setDBEncoding("ISO-8859-1");
$xmlExportObj->setXMLEncoding("ISO-8859-1");
$xmlExportObj->setXMLFormat("NODES");
$xmlExportObj->Execute();
// End XMLExport rsminuta
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
mysql_free_result($rsminuta);
?>
