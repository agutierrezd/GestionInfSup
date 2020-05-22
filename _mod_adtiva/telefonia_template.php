<?php require_once('../Connections/oConnContratos.php'); ?>
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

mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rstipoconsumo = "SELECT * FROM eco_telefonia_tipoconsumo ORDER BY tipoc_name ASC";
$rstipoconsumo = mysql_query($query_rstipoconsumo, $oConnContratos) or die(mysql_error());
$row_rstipoconsumo = mysql_fetch_assoc($rstipoconsumo);
$totalRows_rstipoconsumo = mysql_num_rows($rstipoconsumo);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:: Contrataci&oacute;n :: MinCIT ::.</title>
<!-- AQUI COMIENZA LA BOTONERA -->

	<link rel="stylesheet" href="../_jquery/_desktop/_app/themes/south-street/jquery.ui.all.css">
<script src="../_jquery/_desktop/_app/jquery-1.9.1.js"></script>
<script src="../_jquery/_desktop/_app/ui/jquery.ui.core.js"></script>
<script src="../_jquery/_desktop/_app/ui/jquery.ui.widget.js"></script>
<script src="../_jquery/_desktop/_app/ui/jquery.ui.button.js"></script>
<script src="../_jquery/_desktop/_app/ui/jquery.ui.position.js"></script>
<script src="../_jquery/_desktop/_app/ui/jquery.ui.menu.js"></script>
<link href="../demos.css" rel="stylesheet" type="text/css">
	<style>
		.ui-menu {
	position: absolute;
	width: 280px;
}
	</style>
<script>
	$(function() {
		$( "#rerun" )
			.button()
			.click(function() {
				alert( "Seleccionar tipo de consumo" );
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
</head>

<body>
<?php
  mxi_includes_start("../inc_top_2.php");
  require(basename("../inc_top_2.php"));
  mxi_includes_end();
?>
<div>
	<div>
		<button id="rerun">Tipo de consumo</button>
		<button id="select">Tipo</button>
	</div>
	<ul>
		<?php do { ?>
		  <li><a href="telefonia.php?tipoc_id=<?php echo $row_rstipoconsumo['tipoc_id']; ?>"><?php echo $row_rstipoconsumo['tipoc_name']; ?></a></li>
		  <?php } while ($row_rstipoconsumo = mysql_fetch_assoc($rstipoconsumo)); ?>
          <li><a href="telefonia_add.php">Agregar registro</a></li>
	</ul>
</div>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
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
mysql_free_result($rstipoconsumo);
?>
