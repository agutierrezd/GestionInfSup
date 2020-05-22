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

$colname_RsInfoContrato = "-1";
if (isset($_GET['CONTRATOID'])) {
  $colname_RsInfoContrato = $_GET['CONTRATOID'];
}
$colnamo_RsInfoContrato = "-1";
if (isset($_GET['Q'])) {
  $colnamo_RsInfoContrato = $_GET['Q'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_RsInfoContrato = sprintf("SELECT * FROM q_001_dashboard WHERE CONTRATOID = %s AND VIGENCIA = %s", GetSQLValueString($colname_RsInfoContrato, "text"),GetSQLValueString($colnamo_RsInfoContrato, "text"));
$RsInfoContrato = mysql_query($query_RsInfoContrato, $oConnContratos) or die(mysql_error());
$row_RsInfoContrato = mysql_fetch_assoc($RsInfoContrato);
$totalRows_RsInfoContrato = mysql_num_rows($RsInfoContrato);

$colname_RsInfoAttach = "-1";
if (isset($_GET['CONTRATOID'])) {
  $colname_RsInfoAttach = $_GET['CONTRATOID'];
}
$colnamo_RsInfoAttach = "-1";
if (isset($_GET['Q'])) {
  $colnamo_RsInfoAttach = $_GET['Q'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_RsInfoAttach = sprintf("SELECT * FROM q_info_attached WHERE CONTRATOID = %s AND VIGENCIA = %s", GetSQLValueString($colname_RsInfoAttach, "text"),GetSQLValueString($colnamo_RsInfoAttach, "text"));
$RsInfoAttach = mysql_query($query_RsInfoAttach, $oConnContratos) or die(mysql_error());
$row_RsInfoAttach = mysql_fetch_assoc($RsInfoAttach);
$totalRows_RsInfoAttach = mysql_num_rows($RsInfoAttach);

// Download File downloadObj1
$downloadObj1 = new tNG_Download("../", "KT_download1");
// Execute
$downloadObj1->setFolder("../_attached/");
$downloadObj1->setRenameRule("{RsInfoAttach.att_file}");
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
    <td width="22%">NÚMERO CONTRATO </td>
    <td width="78%" class="titlemsg2"><?php echo $row_RsInfoContrato['CONTRATOID']; ?>-<?php echo $row_RsInfoContrato['VIGENCIA']; ?></td>
  </tr>
  <tr>
    <td>NOMBRES</td>
    <td class="titlemsg2"><?php echo $row_RsInfoContrato['contractor_name']; ?></td>
  </tr>
  <tr class="frmtablahead">
    <td colspan="2">SOPORTES</td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" border="0" cellspacing="2" cellpadding="0">
      <?php do { ?>
        <tr>
            <td class="frmtablabody"><?php echo $row_RsInfoAttach['att_type_name']; ?></td>
          <td class="frmtablabody"><a href="<?php echo $downloadObj1->getDownloadLink(); ?>"><?php echo $row_RsInfoAttach['att_file']; ?></a></td>
        </tr>
        <?php } while ($row_RsInfoAttach = mysql_fetch_assoc($RsInfoAttach)); ?>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($RsInfoContrato);

mysql_free_result($RsInfoAttach);
?>
