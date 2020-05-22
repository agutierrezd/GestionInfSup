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

$colname_RsInfestado = "-1";
if (isset($_GET['SUPUSER'])) {
  $colname_RsInfestado = $_GET['SUPUSER'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_RsInfestado = sprintf("SELECT * FROM q_global_informes_entregados WHERE SUPUSER = %s ORDER BY NCONTRATO ASC", GetSQLValueString($colname_RsInfestado, "text"));
$RsInfestado = mysql_query($query_RsInfestado, $oConnContratos) or die(mysql_error());
$row_RsInfestado = mysql_fetch_assoc($RsInfestado);
$totalRows_RsInfestado = mysql_num_rows($RsInfestado);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:: Contrataci&oacute;n :: MinCIT ::.</title>
<link href="../_css/jqueryslidemenu.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../_jquery/hs/highslide/highslide-with-html.js"></script>
<link rel="stylesheet" type="text/css" href="../_jquery/hs/highslide/highslide.css" />
<script type="text/javascript">
hs.graphicsDir = '../_jquery/hs/highslide/graphics/';
hs.outlineType = 'rounded-white';
hs.wrapperClassName = 'draggable-header';
function MM_popupMsg(msg) { //v1.0
  alert(msg);
}
</script>
<link rel="stylesheet" href="../_jquery/_desktop/_app/themes/south-street/jquery.ui.all.css">
<script src="../_jquery/_desktop/_app/jquery-1.9.1.js"></script>
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
</head>

<body>
<?php
  mxi_includes_start("../inc_top_2.php");
  require(basename("../inc_top_2.php"));
  mxi_includes_end();
?>
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><div>
	<div>
		<button id="rerun">Seleccione</button>
		<button id="select">...</button>
	</div>
	<ul>
    		<li><a href="supervisor_inf_estado.php">Regresar</a></li>
	</ul>
</div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="2" cellpadding="0">
      <tr>
        <td class="frmtablahead">&nbsp;</td>
        <td class="frmtablahead">CONTRATO</td>
        <td class="frmtablahead">SUPERVISOR</td>
        <td class="frmtablahead">CONTRATISTA</td>
        <td class="frmtablahead">INFORMES SUGERIDOS</td>
        <td class="frmtablahead">INFORMES ENTREGADOS</td>
        <td class="frmtablahead">MES INICIO DE CONTRATO</td>
        <td class="frmtablahead">PERIODICIDAD</td>
        <td class="frmtablahead">OTROSI</td>
        <td class="frmtablahead">FECHA INICIO</td>
        <td class="frmtablahead">FECHA FINAL</td>
      </tr>
      <?php do { ?>
        <tr>
          <td class="frmtablabodyW" align="center"><a href="send_not_003.php?doc_id=<?php echo $row_RsInfestado['id_cont_fk']; ?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )">
            <?php 
// Show IF Conditional region2 
if (@$row_RsInfestado['INF_ENTREGADOS'] == "") {
?>
              <img src="icons/324_notmail.png" width="32" height="32" border="0" /><br />
              <?php } 
// endif Conditional region2
?></a><?php echo $row_RsInfestado['QTYMAILSEND']; ?></td>
          <td class="frmtablabody"><?php echo $row_RsInfestado['NCONTRATO']; ?></td>
          <td class="frmtablabody"><?php echo $row_RsInfestado['SUPNAME']." ".$row_RsInfestado['SUPLASTNAME']; ?></td>
          <td class="frmtablabody"><?php echo $row_RsInfestado['contractor_name']; ?></td>
          <td class="frmtablabody"><?php echo $row_RsInfestado['INF_SUGERIDOS']; ?></td>
          <td class="frmtablabody"><?php echo $row_RsInfestado['INF_ENTREGADOS']; ?></td>
          <td class="frmtablabody"><?php echo $row_RsInfestado['MESINICIO']; ?></td>
          <td class="frmtablabody"><?php echo $row_RsInfestado['periodo_name']; ?></td>
          <td class="frmtablabodyW" align="center">
            <?php 
// Show IF Conditional region1 
if (@$row_RsInfestado['cont_otrosi'] == 1) {
?>
              <img src="icons/Shape-Circle.png" width="32" height="32" />
              <?php } 
// endif Conditional region1
?></td>
          <td class="frmtablabody"><?php echo $row_RsInfestado['cont_fecha_inicio']; ?></td>
          <td class="frmtablabody"><?php echo $row_RsInfestado['cont_fechafinal']; ?></td>
        </tr>
        <?php } while ($row_RsInfestado = mysql_fetch_assoc($RsInfestado)); ?>
    </table></td>
  </tr>
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
mysql_free_result($RsInfestado);
?>
