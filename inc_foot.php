<?php require_once('Connections/oConnUsers.php'); ?>
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

mysql_select_db($database_oConnUsers, $oConnUsers);
mysql_query("SET NAMES 'utf8'");
$query_rsinfofoot = "SELECT * FROM global_sites WHERE IdSite = 15";
$rsinfofoot = mysql_query($query_rsinfofoot, $oConnUsers) or die(mysql_error());
$row_rsinfofoot = mysql_fetch_assoc($rsinfofoot);
$totalRows_rsinfofoot = mysql_num_rows($rsinfofoot);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="_css/ddsmoothmenu.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="500" border="0" align="center" cellpadding="0" cellspacing="2">
  <tr>
    <td class="mincit_textfoot1"><?php echo $row_rsinfofoot['foot_line_1']; ?></td>
  </tr>
  <tr>
    <td class="mincit_textfoot2"><?php echo $row_rsinfofoot['foot_line_2']; ?></td>
  </tr>
  <tr>
    <td class="mincit_textfoot2"><?php echo $row_rsinfofoot['foot_line_3']; ?></td>
  </tr>
  <tr>
    <td class="mincit_textfoot2">Contacto: <?php echo $row_rsinfofoot['notify_email']; ?></td>
  </tr>
  <tr>
    <td class="mincit_textfoot2"><?php echo $row_rsinfofoot['Version_Num']; ?>-<?php echo $row_rsinfofoot['copyright']; ?></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($rsinfofoot);
?>
