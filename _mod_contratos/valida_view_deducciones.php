<?php require_once('../Connections/oConnContratos.php'); ?>
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

$colname_RsDeducc = "-1";
if (isset($_GET['doc'])) {
  $colname_RsDeducc = $_GET['doc'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_RsDeducc = sprintf("SELECT * FROM `_deducciones` WHERE `Num Doc Ter` = %s ORDER BY `Fecha Ejec.` ASC", GetSQLValueString($colname_RsDeducc, "text"));
$RsDeducc = mysql_query($query_RsDeducc, $oConnContratos) or die(mysql_error());
$row_RsDeducc = mysql_fetch_assoc($RsDeducc);
$totalRows_RsDeducc = mysql_num_rows($RsDeducc);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO8859-1" />
<title>Untitled Document</title>
<link href="../_css/jqueryslidemenu.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" border="0" cellspacing="2" cellpadding="0">
  <tr>
    <td width="14%">&nbsp;</td>
    <td width="46%">CEDULA:<?php echo $row_RsDeducc['Num Doc Ter']; ?></td>
    <td width="40%"><?php echo $row_RsDeducc['Beneficiario Orden Pago']; ?></td>
  </tr>
  <tr>
    <td colspan="3"><table width="100%" border="0" cellspacing="2" cellpadding="0">
      <tr>
        <td class="frmtablahead">FECHA</td>
        <td class="frmtablahead">OBLIGACION</td>
        <td class="frmtablahead">ORDEN DE PAGO</td>
        <td class="frmtablahead">CONCEPTO</td>
        <td class="frmtablahead">BENEFICIARIO DEDUCCION</td>
        <td class="frmtablahead">TARIFA</td>
        <td class="frmtablahead">BASE</td>
        <td class="frmtablahead">VALOR</td>
        </tr>
      <?php do { ?>
        <tr>
          <td class="frmtablabody"><?php echo $row_RsDeducc['Fecha Ejec.']; ?></td>
          <td class="frmtablabody"><?php echo $row_RsDeducc['Obligacion']; ?></td>
          <td class="frmtablabody"><?php echo $row_RsDeducc['Orden Pago']; ?></td>
          <td class="frmtablabody"><?php echo $row_RsDeducc['Descrip Posicion Pago No Pptal']; ?></td>
          <td class="frmtablabody"><?php echo $row_RsDeducc['Beneficiario Deduccion']; ?></td>
          <td class="frmtablabody"><div align="center"><?php echo $row_RsDeducc['Tarifa']; ?></div></td>
          <td class="frmtablabody" align="right"><?php echo $row_RsDeducc['Base']; ?></td>
          <td class="frmtablabody" align="right"><?php echo $row_RsDeducc['Valor Doc']; ?></td>
          </tr>
        <?php } while ($row_RsDeducc = mysql_fetch_assoc($RsDeducc)); ?>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($RsDeducc);
?>
