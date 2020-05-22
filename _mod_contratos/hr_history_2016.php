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

$colname_rshistory = "-1";
if (isset($_GET['hr_id'])) {
  $colname_rshistory = $_GET['hr_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rshistory = sprintf("SELECT * FROM q_hoja_ruta_history_2016 WHERE hr_id_fk = %s ORDER BY evento_id DESC", GetSQLValueString($colname_rshistory, "int"));
$rshistory = mysql_query($query_rshistory, $oConnContratos) or die(mysql_error());
$row_rshistory = mysql_fetch_assoc($rshistory);
$totalRows_rshistory = mysql_num_rows($rshistory);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../_css/jqueryslidemenu.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" border="0" cellspacing="2" cellpadding="0">
  <tr>
    <td class="frmtablahead">DEPENDENCIA</td>
    <td class="frmtablahead">UBICACION ACTUAL</td>
    <td class="frmtablahead">FECHA DE OPERACION</td>
  </tr>
  <?php do { ?>
    <tr>
      <td class="frmtablabody"><?php echo $row_rshistory['evento_type_group']; ?></td>
      <td class="frmtablabody"><?php echo $row_rshistory['evento_type_desc']; ?></td>
      <td class="frmtablabody"><?php echo $row_rshistory['evento_fechaoper']; ?></td>
    </tr>
    <?php } while ($row_rshistory = mysql_fetch_assoc($rshistory)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($rshistory);
?>
