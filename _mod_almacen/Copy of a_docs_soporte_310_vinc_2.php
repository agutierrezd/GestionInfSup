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

$colname_rsdestalle = "-1";
if (isset($_GET['mcdcuenta'])) {
  $colname_rsdestalle = $_GET['mcdcuenta'];
}
$colnamo_rsdestalle = "-1";
if (isset($_GET['mcdcodelem'])) {
  $colnamo_rsdestalle = $_GET['mcdcodelem'];
}
mysql_select_db($database_oConnAlmacen, $oConnAlmacen);
$query_rsdestalle = sprintf("SELECT * FROM q_almovconsdia_egreso WHERE mcdcuenta = %s AND mcdcodelem = %s", GetSQLValueString($colname_rsdestalle, "text"),GetSQLValueString($colnamo_rsdestalle, "text"));
$rsdestalle = mysql_query($query_rsdestalle, $oConnAlmacen) or die(mysql_error());
$row_rsdestalle = mysql_fetch_assoc($rsdestalle);
$totalRows_rsdestalle = mysql_num_rows($rsdestalle);
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
  mxi_includes_start("../inc_top_2.php");
  require(basename("../inc_top_2.php"));
  mxi_includes_end();
?>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="2" cellpadding="0">
      <tr>
        <td class="frmtablahead">CUENTA</td>
        <td class="frmtablahead">NOMBRE CUENTA</td>
        <td class="frmtablahead">ALMACEN</td>
      </tr>
      <tr>
        <td class="frmtablabody"><?php echo $row_rsdestalle['mcdcuenta']; ?></td>
        <td class="frmtablabody"><?php echo $row_rsdestalle['ca_nomcuenta']; ?></td>
        <td class="frmtablabody"><?php echo $row_rsdestalle['mcdalmacen']; ?></td>
      </tr>
      <tr>
        <td class="frmtablahead">ELEMENTO</td>
        <td class="frmtablahead">NOMBRE DEL ELEMENTO</td>
        <td class="frmtablahead">PRESENTACION</td>
      </tr>

      <tr>
        <td class="frmtablabody"><?php echo $row_rsdestalle['mcdcodelem']; ?></td>
        <td class="frmtablabody"><?php echo $row_rsdestalle['ec_nomelemento']; ?></td>
        <td class="frmtablabody"><?php echo $row_rsdestalle['um_nomunimed']; ?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="95%" border="0" align="center" cellpadding="0" cellspacing="2">
      <tr>
        <td class="frmtablahead">CANTIDAD INGRESADA</td>
        <td class="frmtablahead">CANTIDAD SOLICITADA</td>
        <td class="frmtablahead">SALDO ACTUAL</td>
        <td class="frmtablahead">PRECIO UNITARIO</td>
        <td class="frmtablahead">PRECIO TOTAL</td>
        <td class="frmtablahead">&nbsp;</td>
      </tr>
      <?php do { ?>
        <tr>
          <td class="frmtablabody" align="center"><?php echo $row_rsdestalle['mcd_cantmovto']; ?></td>
          <td class="frmtablabody" align="center"><?php echo $row_rsdestalle['mcd_cantasignada']; ?></td>
          <td class="frmtablabody" align="center"><?php echo $row_rsdestalle['mcd_saldant']; ?></td>
          <td class="frmtablabody" align="right"><?php echo number_format($row_rsdestalle['mcd_valunitant'],2,',','.'); ?></td>
          <td class="frmtablabody" align="right"><?php echo number_format($row_rsdestalle['mcd_valmovto'],2,',','.'); ?></td>
          <td class="frmtablabody" align="center"><a href="a_docs_soporte_310_xinsert.php?almovconsdia_id=<?php echo $row_rsdestalle['almovconsdia_id']; ?>&amp;numdocumento=<?php echo $_GET['numdocumento']; ?>&amp;doclasedoc_id=<?php echo $_GET['doclasedoc_id']; ?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )"><img src="Add_326.png" width="32" height="32" border="0" /></a></td>
        </tr>
        <?php } while ($row_rsdestalle = mysql_fetch_assoc($rsdestalle)); ?>
    </table></td>
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
mysql_free_result($rsdestalle);
?>
