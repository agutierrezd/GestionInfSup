<?php require_once('../Connections/oConnContratos.php'); ?>
<?php
// Load the tNG classes
require_once('../includes/tng/tNG.inc.php');

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

$colname_rsview = "-1";
if (isset($_GET['hr_id'])) {
  $colname_rsview = $_GET['hr_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rsview = sprintf("SELECT * FROM q_hoja_ruta_maestra_info_2015 WHERE hr_id = %s", GetSQLValueString($colname_rsview, "int"));
$rsview = mysql_query($query_rsview, $oConnContratos) or die(mysql_error());
$row_rsview = mysql_fetch_assoc($rsview);
$totalRows_rsview = mysql_num_rows($rsview);

// Download File downloadObj1
$downloadObj1 = new tNG_Download("../", "KT_download1");
// Execute
$downloadObj1->setFolder("../_attach_notificaciones/");
$downloadObj1->setRenameRule("{rsview.send_file}");
$downloadObj1->Execute();


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
    <td>N&Uacute;MERO DE COMPROBANTE:</td>
    <td><?php echo $row_rsview['hrnoypay_obliga_num']; ?></td>
  </tr>
  <tr>
    <td>FECHA DE CONFIRMACION:</td>
    <td><?php echo $row_rsview['not_date']; ?></td>
  </tr>
  <tr>
    <td>VER ADJUNTO:</td>
    <td><a href="<?php echo $downloadObj1->getDownloadLink(); ?>"><?php echo $row_rsview['send_file']; ?></a></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($rsview);
?>
