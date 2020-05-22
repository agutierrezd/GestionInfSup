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

mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rsinformesreg = "SELECT * FROM informe_intersup WHERE inf_id = 1 ORDER BY inf_consecutivo ASC";
$rsinformesreg = mysql_query($query_rsinformesreg, $oConnContratos) or die(mysql_error());
$row_rsinformesreg = mysql_fetch_assoc($rsinformesreg);
$totalRows_rsinformesreg = mysql_num_rows($rsinformesreg);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php 
if (@$row_rsinformesreg['inf_otrosaspectostecnicos'] != "") {
?>
  <?php echo $row_rsinformesreg['inf_otrosaspectostecnicos']; ?>
  <?php } 
?>
</body>
</html>
<?php
mysql_free_result($rsinformesreg);
?>
