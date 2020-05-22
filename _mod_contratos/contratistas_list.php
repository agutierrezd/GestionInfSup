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

$maxRows_rscontratistalist = 25;
$pageNum_rscontratistalist = 0;
if (isset($_GET['pageNum_rscontratistalist'])) {
  $pageNum_rscontratistalist = $_GET['pageNum_rscontratistalist'];
}
$startRow_rscontratistalist = $pageNum_rscontratistalist * $maxRows_rscontratistalist;

$colname_rscontratistalist = "-1";
if (isset($_POST['nombrec'])) {
  $colname_rscontratistalist = $_POST['nombrec'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rscontratistalist = sprintf("SELECT * FROM q_finder_contractor WHERE qfinder LIKE %s ORDER BY contractor_name ASC", GetSQLValueString("%" . $colname_rscontratistalist . "%", "text"));
$query_limit_rscontratistalist = sprintf("%s LIMIT %d, %d", $query_rscontratistalist, $startRow_rscontratistalist, $maxRows_rscontratistalist);
$rscontratistalist = mysql_query($query_limit_rscontratistalist, $oConnContratos) or die(mysql_error());
$row_rscontratistalist = mysql_fetch_assoc($rscontratistalist);

if (isset($_GET['totalRows_rscontratistalist'])) {
  $totalRows_rscontratistalist = $_GET['totalRows_rscontratistalist'];
} else {
  $all_rscontratistalist = mysql_query($query_rscontratistalist);
  $totalRows_rscontratistalist = mysql_num_rows($all_rscontratistalist);
}
$totalPages_rscontratistalist = ceil($totalRows_rscontratistalist/$maxRows_rscontratistalist)-1;
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:: Contratistas ::.</title>
<link href="../_css/jqueryslidemenu.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function closeit(val){
    window.opener.document.forms['form1'].elements['cont_nit_contra_ta'].value=val;
    window.close(this);
}
 
</script>
</head>

<body>
<form id="form1" name="form1" method="post" action="contratistas_list.php">
Ingresar b&uacute;squeda <br />
<input name="nombrec" type="text" id="nombrec" size="50" />
  <input type="submit" name="button" id="button" value="Buscar" />
</form>
Clic en el n&uacute;mero de documento para vincular contratista<br />
<table width="500" border="0" cellspacing="2" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
    <td align="center"><a href="contractor_new.php" title="Nuevo registro"><img src="../img_mcit/user_add_322.png" width="32" height="32" border="0" /></a></td>
  </tr>
  <tr>
    <td width="95" class="frmceldacuatro">Documento</td>
    <td width="399" class="frmceldacuatro">Nombres</td>
  </tr>
  <?php do { ?>
    <tr>
      <td class="frmceldauno"><a href="#" onclick="closeit('<?php echo $row_rscontratistalist['contractor_doc_id']; ?>');"><?php echo $row_rscontratistalist['contractor_doc_id']; ?></a></td>
      <td class="frmceldauno"><?php echo $row_rscontratistalist['contractor_name']; ?></td>
    </tr>
    <?php } while ($row_rscontratistalist = mysql_fetch_assoc($rscontratistalist)); ?>
</table>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($rscontratistalist);
?>
