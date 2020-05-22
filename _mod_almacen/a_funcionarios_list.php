<?php require_once('../Connections/oConnAlmacen.php'); ?>
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

$colname_rsfunclist = "-1";
if (isset($_GET['b'])) {
  $colname_rsfunclist = $_GET['b'];
}
mysql_select_db($database_oConnAlmacen, $oConnAlmacen);
mysql_query("SET NAMES 'utf8'");
$query_rsfunclist = sprintf("SELECT * FROM q_func_prov_master WHERE BUSCAR LIKE %s", GetSQLValueString("%" . $colname_rsfunclist . "%", "text"));
$rsfunclist = mysql_query($query_rsfunclist, $oConnAlmacen) or die(mysql_error());
$row_rsfunclist = mysql_fetch_assoc($rsfunclist);
$totalRows_rsfunclist = mysql_num_rows($rsfunclist);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../_css/jqueryslidemenu.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function closeit(val){
    window.opener.document.forms['form1'].elements['doccnit'].value=val;
	window.close(this);
}
</script>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="frmtablahead">
    <td colspan="5">ELEMENTOS DEVOLUTIVOS</td>
  </tr>
  <tr>
    <td width="5%">&nbsp;</td>
    <td width="53%">&nbsp;</td>
    <td width="14%">&nbsp;</td>
    <td width="14%">&nbsp;</td>
    <td width="14%">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5"><form id="form1" name="form1" method="get" action="a_funcionarios_list.php">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="159" class="titlemsg3Gray">Nombre:</td>
          <td width="447"><input name="b" type="text" class="titlemsg2" id="b" value="<?php echo $_GET['b']; ?>" size="30" /></td>
          <td width="786">&nbsp;
                <input name="button" type="submit" class="titlemsg2" id="button" value="Encontrar" /></td>
        </tr>
      </table>
    </form></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><a href="a_funcionarios_edit.php?b=<?php echo $_GET['b']; ?>" title="crear un nuevo registro"><img src="325_add_mov_2.png" width="32" height="32" border="0" /></a></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5"><?php 
// Show IF Conditional region1 
if (@$_GET['b'] != "") {
?>
        <table width="100%" border="0" cellspacing="2" cellpadding="0">
          <tr>
            <td width="11%" class="frmtablahead">DOCUMENTO</td>
            <td width="27%" class="frmtablahead">NOMBRES</td>
            <td width="12%" class="frmtablahead">COD DEPENDENCIA</td>
            <td width="42%" class="frmtablahead">NOMBRE DEPENDENCIA</td>
            <td width="8%" class="frmtablahead">MODIFICAR</td>
          </tr>
          <?php do { ?>
            <tr>
              <td class="frmtablabody"><a href="#" onclick="closeit('<?php echo $row_rsfunclist['func_doc']; ?>');"><?php echo $row_rsfunclist['func_doc']; ?></a></td>
              <td class="frmtablabody"><?php echo $row_rsfunclist['func_nombres']; ?></td>
              <td class="frmtablabody"><?php echo $row_rsfunclist['func_dep']; ?></td>
              <td class="frmtablabody"><?php echo $row_rsfunclist['de_nomdep']; ?></td>
              <td class="frmtablabody" align="center"><a href="a_funcionarios_edit.php?func_id=<?php echo $row_rsfunclist['func_id']; ?>&amp;b=<?php echo $_GET['b']; ?>" title="Modificar datos"><img src="325_edit.png" width="32" height="32" border="0" /></a></td>
            </tr>
            <?php } while ($row_rsfunclist = mysql_fetch_assoc($rsfunclist)); ?>
</table>
        <?php } 
// endif Conditional region1
?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($rsfunclist);
?>
