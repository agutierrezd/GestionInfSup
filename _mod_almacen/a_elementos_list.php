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

$colname_rsbuscaelementosd = "-1";
if (isset($_GET['nomelement'])) {
  $colname_rsbuscaelementosd = $_GET['nomelement'];
}
mysql_select_db($database_oConnAlmacen, $oConnAlmacen);
$query_rsbuscaelementosd = sprintf("SELECT * FROM q_master_elementosd WHERE buscador LIKE %s ORDER BY ed_codelem DESC", GetSQLValueString("%" . $colname_rsbuscaelementosd . "%", "text"));
$rsbuscaelementosd = mysql_query($query_rsbuscaelementosd, $oConnAlmacen) or die(mysql_error());
$row_rsbuscaelementosd = mysql_fetch_assoc($rsbuscaelementosd);
$totalRows_rsbuscaelementosd = mysql_num_rows($rsbuscaelementosd);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../_css/jqueryslidemenu.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function closeit(val){
    window.opener.document.forms['form1'].elements['mddcodelem'].value=val;
}
function closeit2(val){
	window.opener.document.forms['form1'].elements['mddtipoestruc'].value=val;
}
function closeit3(val){
	window.opener.document.forms['form1'].elements['mdd_valunit'].value=val;
    window.close(this);
}
function closeit4(val){
	window.opener.document.forms['form1'].elements['mddcuenta'].value=val;
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
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5"><form id="form1" name="form1" method="get" action="a_elementos_list.php">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="105" class="titlemsg3Gray">Nombre:</td>
          <td width="524"><input name="nomelement" type="text" class="titlemsg2" id="nomelement" value="<?php echo $_GET['nomelement']; ?>" size="30" /></td>
          <td width="290">&nbsp;
            <input name="button" type="submit" class="titlemsg2" id="button" value="Encontrar" /></td>
        </tr>
      </table>
        </form>    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><?php echo $totalRows_rsbuscaelementosd; ?>&nbsp;Registros encontrados</td>
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
if (@$_GET['nomelement'] != "") {
?>
        <table width="100%" border="0" cellspacing="2" cellpadding="0">
          <tr>
            <td colspan="2" class="frmtablahead">CUENTA</td>
            <td width="18%" class="frmtablahead">COD ELEMENTO</td>
            <td width="12%" class="frmtablahead">ELEMENTO</td>
            <td width="17%" class="frmtablahead">PRESENTACION</td>
            <td width="8%" class="frmtablahead">MARCA</td>
            <td width="18%" class="frmtablahead">VALOR UNITARIO</td>
            <td width="16%" class="frmtablahead">LOCALIZACION</td>
              </tr>
              <?php do { ?>
                <tr>
                  <td width="9%" class="frmtablabody"><a href="#" onclick="closeit('<?php echo $row_rsbuscaelementosd['ed_codelem']; ?>');closeit2('<?php echo $row_rsbuscaelementosd['alelemdevolutivo_id']; ?>');closeit3('<?php echo $row_rsbuscaelementosd['ed_valunit']; ?>');closeit4('<?php echo $row_rsbuscaelementosd['edcuenta']; ?>')" title="Vincular elemento"><?php echo $row_rsbuscaelementosd['edcuenta']; ?></a></td>
                  <td width="2%" align="center" class="frmtablabody"><a href="a_elementos_edit.php?edcuenta=<?php echo $row_rsbuscaelementosd['edcuenta']; ?>&amp;nomelement=<?php echo $_GET['nomelement']; ?>"><img src="244_add.png" width="24" height="24" border="0" /><br />
                  Crear nuevo elemento</a></td>
                  <td class="frmtablabody" align="center"><?php echo $row_rsbuscaelementosd['ed_codelem']; ?></td>
                  <td class="frmtablabody"><?php echo $row_rsbuscaelementosd['ed_nomelemento']; ?></td>
                  <td class="frmtablabody"><?php echo $row_rsbuscaelementosd['um_nomunimed']; ?></td>
                  <td class="frmtablabody"><?php echo $row_rsbuscaelementosd['ma_nommarca']; ?></td>
                  <td class="frmtablabody" align="right"><?php echo number_format($row_rsbuscaelementosd['ed_valunit'],2,',','.'); ?></td>
                  <td class="frmtablabody"><?php echo $row_rsbuscaelementosd['ed_localizacion']; ?></td>
                </tr>
                <?php } while ($row_rsbuscaelementosd = mysql_fetch_assoc($rsbuscaelementosd)); ?>
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
mysql_free_result($rsbuscaelementosd);
?>
