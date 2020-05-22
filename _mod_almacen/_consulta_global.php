<?php require_once('../Connections/oConnAlmacen.php'); ?>
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

$colname_rsbusca = "-1";
if (isset($_GET['buscar'])) {
  $colname_rsbusca = $_GET['buscar'];
}
mysql_select_db($database_oConnAlmacen, $oConnAlmacen);
$query_rsbusca = sprintf("SELECT * FROM q_inventario_central_master WHERE buscador LIKE %s", GetSQLValueString("%" . $colname_rsbusca . "%", "text"));
$rsbusca = mysql_query($query_rsbusca, $oConnAlmacen) or die(mysql_error());
$row_rsbusca = mysql_fetch_assoc($rsbusca);
$totalRows_rsbusca = mysql_num_rows($rsbusca);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:: Contrataci&oacute;n :: MinCIT ::.</title>
<link rel="stylesheet" href="../_jquery/_desktop/_app/themes/south-street/jquery.ui.all.css">
<script src="../_jquery/_desktop/_app/ui/jquery.ui.core.js"></script>
<script src="../_jquery/_desktop/_app/ui/jquery.ui.widget.js"></script>
<script src="../_jquery/_desktop/_app/ui/jquery.ui.tabs.js"></script>
	<script src="../_jquery/_desktop/_app/ui/jquery.ui.button.js"></script>
	<script src="../_jquery/_desktop/_app/ui/jquery.ui.position.js"></script>
	<script src="../_jquery/_desktop/_app/ui/jquery.ui.menu.js"></script>
   	<script src="../_jquery/_desktop/_app/ui/jquery.ui.button.js"></script>
	<link rel="stylesheet" href="../_jquery/_desktop/_app/_modules/demos.css">
    <style>
		.ui-menu { position: absolute; width: 100px; }
	</style>
<script>
	$(function() {
		$( "#tabs" ).tabs();
		
		$( "#rerun" )
			.button()
			.click(function() {
				alert( "Seleccionar acción" );
			})
			.next()
				.button({
					text: false,
					icons: {
						primary: "ui-icon-triangle-1-s"
					}
				})
				.click(function() {
					var menu = $( this ).parent().next().show().position({
						my: "left top",
						at: "left bottom",
						of: this
					});
					$( document ).one( "click", function() {
						menu.hide();
					});
					return false;
				})
				.parent()
					.buttonset()
					.next()
						.hide()
						.menu();
	});
	</script>
<link href="../_css/jqueryslidemenu.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../_jquery/hs/highslide/highslide-with-html.js"></script>
<link rel="stylesheet" type="text/css" href="../_jquery/hs/highslide/highslide.css" />
<script type="text/javascript">
hs.graphicsDir = '../_jquery/hs/highslide/graphics/';
hs.outlineType = 'rounded-white';
hs.wrapperClassName = 'draggable-header';
</script>

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
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><form action="_consulta_global.php" method="get" name="form1" id="form1">
      <input name="buscar" type="text" id="buscar" value="<?php echo $_GET['buscar']; ?>" size="60" />
      <input type="submit" name="id" id="id" value="Encontrar" />
            </form>    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <?php 
// Show IF Conditional region2 
if (@$_GET['buscar'] != "") {
?>
    <tr>
      <td class="titlemsg2"><?php echo $totalRows_rsbusca; ?> registros encontrados</td>
    </tr>
    <?php } 
// endif Conditional region2
?>
</table>
<?php 
// Show IF Conditional region1 
if (@$_GET['buscar'] != "") {
?>
  <table width="100%" border="0" cellspacing="2" cellpadding="0">
    <tr>
      <td class="frmtablahead">PLACA</td>
      <td class="frmtablahead">&nbsp;</td>
      <td class="frmtablahead">FUNCIONARIO</td>
      <td class="frmtablahead">&nbsp;</td>
      <td class="frmtablahead">FECHA DE COMPRA</td>
      <td class="frmtablahead">PRECIO DE COMPRA</td>
      <td class="frmtablahead">&nbsp;</td>
    </tr>
    <?php do { ?>
      <tr>
        <td class="frmtablabody"><span class="titlemsg2"><?php echo $row_rsbusca['di_nroplaca']; ?><br />
        </span>    <span class="titlenormaltextbold">Serie:<?php echo $row_rsbusca['di_nroserie']; ?></span></td>
        <td class="frmtablabody"><?php echo $row_rsbusca['ca_nomcuenta']; ?> <br />
          <textarea name="textarea" id="textarea" cols="45" rows="3"><?php echo $row_rsbusca['ed_nomelemento']; ?></textarea>
          <br />        </td>
        <td class="frmtablabody"><table width="90%" border="0" cellspacing="2" cellpadding="0">
            <tr>
              <td width="19%" class="frmtablahead">Documento:</td>
              <td width="81%" class="frmtablabody"><?php echo $row_rsbusca['difuncionario']; ?></td>
            </tr>
            <tr>
              <td class="frmtablahead">Nombres:</td>
              <td class="frmtablabody"><?php echo $row_rsbusca['func_nombres']; ?></td>
            </tr>
            <tr>
              <td class="frmtablahead">Dependencia:</td>
              <td class="frmtablabody"><?php echo $row_rsbusca['de_nomdep']; ?></td>
            </tr>
          </table></td>
        <td class="frmtablabody"><table width="200" border="0" cellspacing="2" cellpadding="0">
          <tr>
            <td width="41%" class="frmtablahead">Cuenta:</td>
            <td width="59%" class="frmtablabody"><?php echo $row_rsbusca['dicuenta']; ?></td>
          </tr>
          <tr>
            <td class="frmtablahead">Elemento:</td>
            <td class="frmtablabody"><?php echo $row_rsbusca['dicodelem']; ?></td>
          </tr>
          <tr>
            <td class="frmtablahead">Almac&eacute;n:</td>
            <td class="frmtablabody"><?php echo $row_rsbusca['dialmacen']; ?></td>
          </tr>
        </table>        </td>
        <td class="frmtablabody"><p><?php echo $row_rsbusca['di_fechacompra']; ?><br />
        </p>        </td>
        <td class="frmtablabody" align="right"><?php echo $row_rsbusca['di_valorultmovto']; ?></td>
        <td class="frmtablabody">&nbsp;</td>
      </tr>
      <?php } while ($row_rsbusca = mysql_fetch_assoc($rsbusca)); ?>
</table>
  <?php } 
// endif Conditional region1
?><p>&nbsp;</p>
<?php
  mxi_includes_start("../inc_foot.php");
  require(basename("../inc_foot.php"));
  mxi_includes_end();
?>
</body>
</html>
<?php
mysql_free_result($rsbusca);
?>
