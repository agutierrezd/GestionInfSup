<?php session_start(); ?>
<?php require_once('../Connections/oConnContratos.php'); ?>
<?php
// Require the MXI classes
require_once ('../includes/mxi/MXI.php');

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

$colname_rsliststats = "-1";
if (isset($_SESSION['kt_login_id'])) {
  $colname_rsliststats = $_SESSION['kt_login_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rsliststats = sprintf("SELECT * FROM q_global_informes_entregados WHERE idusrglobal_fk = %s ORDER BY NCONTRATO ASC", GetSQLValueString($colname_rsliststats, "int"));
$rsliststats = mysql_query($query_rsliststats, $oConnContratos) or die(mysql_error());
$row_rsliststats = mysql_fetch_assoc($rsliststats);
$totalRows_rsliststats = mysql_num_rows($rsliststats);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:: Contrataci&oacute;n :: MinCIT ::.</title>
<link href="../_css/jqueryslidemenu.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php
  mxi_includes_start("../inc_top.php");
  require(basename("../inc_top.php"));
  mxi_includes_end();
?>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="2" cellpadding="0">
      <tr class="frmtablahead">
        <td>PERIODO</td>
        <td>CONTRATO</td>
        <td>NOMBRE</td>
        <td>INFORME SUGERIDOS</td>
        <td>PERIODICIDAD</td>
        <td>INFORMES REGISTRADOS</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <?php do { ?>
        <tr class="frmtablabody">
          <td ><?php echo $row_rsliststats['cont_ano']; ?></td>
          <td ><?php echo $row_rsliststats['NCONTRATO']; ?></td>
          <td ><?php echo $row_rsliststats['contractor_name']; ?></td>
          <td ><?php echo $row_rsliststats['cont_informessug']; ?></td>
          <td ><?php echo $row_rsliststats['periodo_name']; ?></td>
          <td ><?php echo $row_rsliststats['QTYINFORMES']; ?></td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
        </tr>
        <?php } while ($row_rsliststats = mysql_fetch_assoc($rsliststats)); ?>

    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>
<?php
  mxi_includes_start("../inc_foot.php");
  require(basename("../inc_foot.php"));
  mxi_includes_end();
?>
</body>
</html>
<?php
mysql_free_result($rsliststats);
?>
