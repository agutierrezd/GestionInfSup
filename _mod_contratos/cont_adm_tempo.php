<?php require_once('../Connections/oConnContratos.php'); ?>
<?php require_once('../Connections/global.php'); ?>
<?php
// Require the MXI classes
require_once ('../includes/mxi/MXI.php');

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

$colname_rsinfocont = "-1";
if (isset($_GET['doc_id'])) {
  $colname_rsinfocont = $_GET['doc_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rsinfocont = sprintf("SELECT * FROM q_001_dashboard WHERE id_cont = %s", GetSQLValueString($colname_rsinfocont, "int"));
$rsinfocont = mysql_query($query_rsinfocont, $oConnContratos) or die(mysql_error());
$row_rsinfocont = mysql_fetch_assoc($rsinfocont);
$totalRows_rsinfocont = mysql_num_rows($rsinfocont);

$colname_rsinfocompleta = "-1";
if (isset($_GET['doc_id'])) {
  $colname_rsinfocompleta = $_GET['doc_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rsinfocompleta = sprintf("SELECT * FROM contrato WHERE id_cont = %s", GetSQLValueString($colname_rsinfocompleta, "int"));
$rsinfocompleta = mysql_query($query_rsinfocompleta, $oConnContratos) or die(mysql_error());
$row_rsinfocompleta = mysql_fetch_assoc($rsinfocompleta);
$totalRows_rsinfocompleta = mysql_num_rows($rsinfocompleta);

$colname_rsattachcont = "-1";
if (isset($_GET['doc_id'])) {
  $colname_rsattachcont = $_GET['doc_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rsattachcont = sprintf("SELECT * FROM q_info_attached WHERE id_cont_fk = %s AND att_type_ctrl = 1 ORDER BY att_type_name ASC", GetSQLValueString($colname_rsattachcont, "int"));
$rsattachcont = mysql_query($query_rsattachcont, $oConnContratos) or die(mysql_error());
$row_rsattachcont = mysql_fetch_assoc($rsattachcont);
$totalRows_rsattachcont = mysql_num_rows($rsattachcont);

$colname_rsattpoliza = "-1";
if (isset($_GET['doc_id'])) {
  $colname_rsattpoliza = $_GET['doc_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rsattpoliza = sprintf("SELECT * FROM contrato_attached WHERE id_cont_fk = %s AND att_type = 1", GetSQLValueString($colname_rsattpoliza, "int"));
$rsattpoliza = mysql_query($query_rsattpoliza, $oConnContratos) or die(mysql_error());
$row_rsattpoliza = mysql_fetch_assoc($rsattpoliza);
$totalRows_rsattpoliza = mysql_num_rows($rsattpoliza);

mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rsanexoslist = "SELECT * FROM contrato_attached_type WHERE att_type_ctrl = 1 ORDER BY att_type_name ASC";
$rsanexoslist = mysql_query($query_rsanexoslist, $oConnContratos) or die(mysql_error());
$row_rsanexoslist = mysql_fetch_assoc($rsanexoslist);
$totalRows_rsanexoslist = mysql_num_rows($rsanexoslist);

$colname_rssupervlist = "-1";
if (isset($_GET['doc_id'])) {
  $colname_rssupervlist = $_GET['doc_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rssupervlist = sprintf("SELECT * FROM q_global_supervisores WHERE id_cont_fk = %s", GetSQLValueString($colname_rssupervlist, "int"));
$rssupervlist = mysql_query($query_rssupervlist, $oConnContratos) or die(mysql_error());
$row_rssupervlist = mysql_fetch_assoc($rssupervlist);
$totalRows_rssupervlist = mysql_num_rows($rssupervlist);

$colname_rscontrolpagado = "-1";
if (isset($_GET['doc_id'])) {
  $colname_rscontrolpagado = $_GET['doc_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rscontrolpagado = sprintf("SELECT * FROM q_valorpagado WHERE id_cont_fk = %s", GetSQLValueString($colname_rscontrolpagado, "int"));
$rscontrolpagado = mysql_query($query_rscontrolpagado, $oConnContratos) or die(mysql_error());
$row_rscontrolpagado = mysql_fetch_assoc($rscontrolpagado);
$totalRows_rscontrolpagado = mysql_num_rows($rscontrolpagado);

$colname_rslistpagos = "-1";
if (isset($_GET['doc_id'])) {
  $colname_rslistpagos = $_GET['doc_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rslistpagos = sprintf("SELECT * FROM contrato_controlpagos WHERE id_cont_fk = %s ORDER BY ctrlpagos_fecha ASC", GetSQLValueString($colname_rslistpagos, "int"));
$rslistpagos = mysql_query($query_rslistpagos, $oConnContratos) or die(mysql_error());
$row_rslistpagos = mysql_fetch_assoc($rslistpagos);
$totalRows_rslistpagos = mysql_num_rows($rslistpagos);

mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rslistotrosi = "SELECT * FROM contrato_otrosi_type ORDER BY otrosi_name ASC";
$rslistotrosi = mysql_query($query_rslistotrosi, $oConnContratos) or die(mysql_error());
$row_rslistotrosi = mysql_fetch_assoc($rslistotrosi);
$totalRows_rslistotrosi = mysql_num_rows($rslistotrosi);

$colname_rsmodlist = "-1";
if (isset($_GET['doc_id'])) {
  $colname_rsmodlist = $_GET['doc_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rsmodlist = sprintf("SELECT contrato_os.os_id, contrato_os.id_cont_fk, contrato_os.os_type_type, contrato_os.os_fecha, contrato_os.os_valor, contrato_os.os_fecha_i, contrato_os.os_fecha_f, contrato_os.os_varios, contrato_os.sys_user, contrato_otrosi_type.otrosi_name, contrato_otrosi_type.otrosi_lnk FROM contrato_os INNER JOIN contrato_otrosi_type ON contrato_os.os_type_type = contrato_otrosi_type.otrosi_id WHERE id_cont_fk = %s", GetSQLValueString($colname_rsmodlist, "int"));
$rsmodlist = mysql_query($query_rsmodlist, $oConnContratos) or die(mysql_error());
$row_rsmodlist = mysql_fetch_assoc($rsmodlist);
$totalRows_rsmodlist = mysql_num_rows($rsmodlist);

// Download File downloadObj1
$downloadObj1 = new tNG_Download("../", "KT_download1");
// Execute
$downloadObj1->setFolder("../../adjuntos/contratos/ct/");
$downloadObj1->setRenameRule("{rsattachcont.att_ct}");
$downloadObj1->Execute();

// Download File downloadObj3
$downloadObj3 = new tNG_Download("../", "KT_download3");
// Execute
$downloadObj3->setFolder("../_attached/");
$downloadObj3->setRenameRule("{rsattpoliza.att_file}");
$downloadObj3->Execute();

// Download File downloadObj1
$downloadObj1 = new tNG_Download("../", "KT_download1");
// Execute
$downloadObj1->setFolder("../_attached/");
$downloadObj1->setRenameRule("{rsattachcont.att_file}");
$downloadObj1->Execute();
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:: Contrataci&oacute;n :: MinCIT ::.</title>
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
<div>
	<div>
		<button id="rerun">ACCIONES</button>
		<button id="select">Acciones</button>
	</div>
	<ul>
	  <li><a href="dashboard.php?anio_id=<?php echo $ano; ?>" title="Regresa una página atrás">Regresar</a></li>
	</ul>
</div><br />
<table width="100%" border="0" cellspacing="3" cellpadding="0">
  <tr>
    <td class="titlemsg2">Contrato No. <?php echo $row_rsinfocont['CONTRATOID']; ?> de <?php echo $row_rsinfocont['VIGENCIA']; ?></td>
    <td colspan="4" class="titlemsg2"><table width="200" border="0" cellspacing="2" cellpadding="0">
      <tr>
        <td class="titlemsg3Gray">Fase:</td>
        <td><span class="titlemsg2"><?php echo $row_rsinfocont['fase_nombre']; ?></span></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="5"><?php 
// Show IF Conditional region10 
if (@$row_rsinfocompleta['cont_otrosi'] == 1) {
?>
        <table width="800" border="0" cellspacing="2" cellpadding="0">
          <tr>
            <td colspan="2">Este contrato presenta modificaciones</td>
          </tr>
          <tr>
            <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="5%" class="frmtablahead">&nbsp;</td>
                  <td width="36%" class="frmtablahead">decripci&oacute;n</td>
                  <td width="19%" class="frmtablahead">Fecha</td>
                  <td width="40%" class="frmtablahead">detalle</td>
                </tr>
                <?php do { ?>
                  <tr>
                    <td class="frmtablabody" align="center"><a href="<?php echo $row_rsmodlist['otrosi_lnk']; ?>?doc_id=<?php echo $row_rsmodlist['id_cont_fk']; ?>&amp;otrosi_id=<?php echo $row_rsmodlist['os_type_type']; ?>&amp;os_id=<?php echo $row_rsmodlist['os_id']; ?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )" title="Editar fecha de contrato"><img src="icons/242_edit.png" width="24" height="24" border="0" /></a></td>
                    <td class="frmtablabody"><?php echo $row_rsmodlist['otrosi_name']; ?></td>
                    <td class="frmtablabody"><?php echo $row_rsmodlist['os_fecha']; ?></td>
                    <td class="frmtablabody"><?php 
// Show IF Conditional region8 
if (@$row_rsmodlist['os_type_type'] == 1 or $row_rsmodlist['os_type_type'] == 2) {
?>
<?php echo number_format($row_rsmodlist['os_valor'],2,',','.'); ?>
<?php } 
// endif Conditional region8
?>
                        <?php 
// Show IF Conditional region8 
if (@$row_rsmodlist['os_type_type'] == 3) {
?>
                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td class="frmtablahead">Fecha inicio</td>
                              <td class="frmtablahead">Fecha final</td>
                            </tr>
                            <tr>
                              <td class="frmtablabody"><?php echo $row_rsmodlist['os_fecha_i']; ?></td>
                              <td class="frmtablabody"><?php echo $row_rsmodlist['os_fecha_f']; ?></td>
                            </tr>
                          </table>
                        <?php } 
// endif Conditional region8
?>
                        <?php 
// Show IF Conditional region9 
if (@$row_rsmodlist['os_type_type'] == 4) {
?>
                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td><textarea name="textarea" id="textarea" cols="45" rows="5"><?php echo $row_rsmodlist['os_varios']; ?></textarea>                              </td>
                            </tr>
                          </table>
                        <?php } 
// endif Conditional region9
?></td>
                  </tr>
                  <?php } while ($row_rsmodlist = mysql_fetch_assoc($rsmodlist)); ?>
            </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        <?php } 
// endif Conditional region10
?></td>
  </tr>
  <tr>
    <td width="54%" height="29" class="titlemsg3Gray">Nombre/Razon</td>
    <td colspan="4" class="titlemsg3Gray">Nit/Documento</td>
  </tr>
  <tr>
    <td class="titlemsg2"><?php echo $row_rsinfocont['contractor_name']; ?></td>
    <td colspan="4" class="titlemsg2"><?php echo $row_rsinfocont['DOCID']; ?></td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr class="titlemsg3Gray">
    <td >&nbsp;</td>
    <td width="12%" >Valor actual</td>
    <td >Valor inicial</td>
    <td width="10%" >Valor pagado</td>
    <td width="12%" >Saldo</td>
  </tr>
  <tr>
    <td class="titlemsg3Gray"><table width="90%" border="0" cellspacing="2" cellpadding="0">
      <tr>
        <td width="36%">Fecha de Inicio</td>
        <td width="33%">Fecha Final</td>
        <td width="19%">Dias contratados</td>
        <td width="12%">&nbsp;</td>
      </tr>
      <tr>
        <td><span class="titlemsg2"><?php echo $row_rsinfocompleta['cont_fecha_inicio']; ?></span></td>
        <td><span class="titlemsg2"><?php echo $row_rsinfocompleta['cont_fechafinal']; ?></span></td>
        <td align="center"><span class="titlemsg2"><?php echo $row_rsinfocont['QTYDIAS']; ?></span></td>
        <td align="center"><a href="contrato_edit_fecha.php?id_cont=<?php echo $row_rsinfocompleta['id_cont']; ?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )" title="Editar fecha de contrato"><img src="../img_mcit/icon/edit_322_a.png" width="32" height="32" border="0" /></a></td>
      </tr>
    </table></td>
    <td class="titlemsg2">$<?php echo number_format($row_rsinfocont['VALORI'],0,',','.'); ?><a href="pop_3.php?id_cont=<?php echo $_GET['doc_id']; ?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )"><img src="icons/325_edit_2.png" width="32" height="32" border="0" /></a></td>
    <td class="titlemsg2">$<?php echo number_format($row_rsinfocont['VALORINICIAL'],0,',','.'); ?><a href="pop_4.php?id_cont=<?php echo $_GET['doc_id']; ?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )"><img src="icons/325_edit_2.png" width="32" height="32" border="0" /></a></td>
    <td class="titlemsg2">$<?php echo number_format($row_rscontrolpagado['valorpagado'],0,',','.'); ?></td>
    <td class="titlemsg2">$<?php echo number_format($row_rsinfocont['VALORI'] - $row_rscontrolpagado['valorpagado'],0,',','.'); ?></td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
</table>
<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Información básica</a></li>
		<li><a href="#tabs-2">Pólizas</a></li>
		<li><a href="#tabs-3">Anexos</a></li>
        <li><a href="#tabs-4">Supervisión</a></li>
        <li><a href="#tabs-5">Control pagos</a></li>
        <li><a href="#tabs-6">Modificaciones</a></li>
        <li><a href="#tabs-9">Acta de liquidación</a></li>
  </ul>
	<div id="tabs-1">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="45%" valign="top"><table width="500" border="0" cellspacing="3" cellpadding="0">
              <tr>
                <td class="titlemsg2">INFORMACI&Oacute;N B&Aacute;SICA</td>
                <td width="10%" align="right">&nbsp;</td>
                <td width="10%" align="right" title="Editar contrato"><a href="contrato_edit.php?id_cont=<?php echo $row_rsinfocompleta['id_cont']; ?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )"><img src="icons/_488_edit.png" width="48" height="48" border="0" /></a></td>
              </tr>
            </table>
              <table width="100%" border="0" cellspacing="2" cellpadding="0">
              <tr class="frmtablahead">
                <td>No. CDP</td>
                <td>No. RP</td>
                <td>Rubro</td>
                <td>Unidad ejecutora</td>
              </tr>
              <tr class="frmtablabody">
                <td ><?php echo $row_rsinfocompleta['prenumero']; ?></td>
                <td ><?php echo $row_rsinfocompleta['numregistro']; ?></td>
                <td ><?php echo $row_rsinfocompleta['cont_codrubro']; ?></td>
                <td ><?php echo $row_rsinfocompleta['cont_tipopre']; ?></td>
              </tr>
              <tr class="frmtablahead">
                <td >Tipo CDP</td>
                <td >Fecha suscripci&oacute;n</td>
                <td >Plazo inicial</td>
                <td >Plazo liquidaci&oacute;n</td>
              </tr>
              <tr class="frmtablabody">
                <td ><?php echo $row_rsinfocont['nombre']; ?></td>
                <td ><?php echo $row_rsinfocompleta['cont_fechaapertura']; ?></td>
                <td ><?php echo $row_rsinfocompleta['cont_plazoi']; ?></td>
                <td ><?php echo $row_rsinfocompleta['cont_plazol']; ?></td>
              </tr>
              <tr class="frmtablahead">
                <td colspan="2" >Modalidad</td>
                <td >Tipo de contrato</td>
                <td >Vigencia</td>
              </tr>
              <tr class="frmtablabody">
                <td colspan="2" ><?php echo $row_rsinfocont['des_mod_proceso']; ?></td>
                <td ><?php echo $row_rsinfocont['nom_tipocontrato']; ?></td>
                <td ><?php echo $row_rsinfocont['cont_fechavigencia']; ?><a href="contractor_edit_vigencia.php?id_cont=<?php echo $row_rsinfocompleta['id_cont']; ?>" title="Fijar vigencia" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )"><img src="icons/242_edit.png" width="24" height="24" border="0" /></a></td>
              </tr>
            </table>
            </td>
            <td valign="top"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="2">
              <tr>
                <td width="91%"></td>
                <td width="9%"></td>
              </tr>
              <tr>
                <td>Objeto del contrato</td>
                <td align="center"><a href="contrato_edit_objeto.php?id_cont=<?php echo $row_rsinfocompleta['id_cont']; ?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )" title="Editar objeto"><img src="../img_mcit/icon/edit_322_a.png" width="32" height="32" border="0" /></a></td>
              </tr>
              <tr>
                <td colspan="2"><div align="justify"><?php echo $row_rsinfocompleta['cont_objeto']; ?></div></td>
              </tr>
              <tr>
                <td colspan="2">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
        </table>
  </div>
<div id="tabs-2">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="45%"><table width="500" border="0" cellspacing="3" cellpadding="0">
              <tr>
                <td width="27%" class="titlemsg2">POLIZAS</td>
                <td width="29%" align="center">&nbsp;</td>
                <td width="12%" align="center">&nbsp;</td>
                <td width="12%" align="center">&nbsp;</td>
                <td width="10%" align="center" title="Registrar póliza"><a href="contrato_attached.php?hash=<?php echo md5($row_rsinfocompleta['cont_hash']); ?>&amp;id_cont=<?php echo $row_rsinfocompleta['id_cont']; ?>&amp;att_type=1" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )"><img src="icons/_488_new.png" width="48" height="48" border="0" /></a></td>
                <td width="10%" align="right" title="Editar póliza">&nbsp;</td>
              </tr>
            </table>
              
              <?php if ($totalRows_rsattpoliza > 0) { // Show if recordset not empty ?>
              <table width="100%" border="0" cellspacing="2" cellpadding="0">
                    <tr class="frmtablahead">
                      <td width="71%" >Documento adjunto</td>
                      <td width="14%" align="center" >Modificar</td>
                      <td width="14%" align="center" >Descargar</td>
                      <td width="15%" align="center" >Amparos</td>
                    </tr>
                    <?php do { ?>
                      <tr class="frmtablabody">
                        <td ><?php echo $row_rsattpoliza['att_file']; ?></td>
                        <td align="center"><a href="contrato_attached_edit.php?hash=<?php echo md5($row_rsinfocompleta['cont_hash']); ?>&amp;id_cont=<?php echo $row_rsinfocompleta['id_cont']; ?>&amp;att_type=1&amp;id_att=<?php echo $row_rsattpoliza['id_att']; ?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )" title="Modificar póliza"><img src="../img_mcit/icon/edit_322_a.png" width="32" height="32" border="0" /></a></td>
                        <td align="center"><a href="<?php echo $downloadObj3->getDownloadLink(); ?>" title="Descargar póliza"><img src="../img_mcit/icon/Attach_322.png" width="32" height="32" border="0" /></a><a href="<?php echo $downloadObj3->getDownloadLink(); ?>"></a></td>
                        <td align="center"><a href="amparos_list.php?id_att=<?php echo $row_rsattpoliza['id_att']; ?>&amp;id_cont=<?php echo $row_rsattpoliza['id_cont_fk']; ?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )" title="Ver registros"><img src="../img_mcit/icon/amparos_322.png" width="32" height="32" border="0" /></a></td>
                    </tr>
                      <?php } while ($row_rsattpoliza = mysql_fetch_assoc($rsattpoliza)); ?>
</table>
                <?php } // Show if recordset not empty ?>
</td>
            <td width="55%"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="2">
              <tr>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td colspan="2">Ayuda:</td>
              </tr>
              <tr>
                <td colspan="2">Registro de p&oacute;lizas y sus correspondientes amparos, adjunte el documento escaneado.</td>
              </tr>
              <tr>
                <td colspan="2">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="2">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="2">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
        </table>
  </div>
	<div id="tabs-3">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="38%" valign="top"><table width="500" border="0" cellspacing="3" cellpadding="0">
              <tr>
                <td class="titlemsg2">ANEXOS VINCULADOS</td>
                <td width="12%" align="right">&nbsp;</td>
                <td width="10%" align="right" title="Registrar">&nbsp;</td>
                <td width="10%" align="right" title="Editar p&oacute;liza">&nbsp;</td>
              </tr>
            </table>
            
              <?php if ($totalRows_rsattachcont > 0) { // Show if recordset not empty ?>
              <table width="100%" border="0" cellspacing="2" cellpadding="0">
                  <tr class="frmtablahead">
                    <td>Tipo de documento</td>
                    <td>Documento adjunto</td>
                    <td>Fecha</td>
                    <td align="center">Descargar</td>
                    <td align="center">Modificar </td>
                  </tr>
                  <?php do { ?>
                  <tr class="frmtablabody">
                    <td><?php echo $row_rsattachcont['att_type_name']; ?></td>
                    <td><?php echo $row_rsattachcont['att_file']; ?></td>
                    <td><?php echo $row_rsattachcont['sys_date']; ?></td>
                    <td align="center"><a href="<?php echo $downloadObj1->getDownloadLink(); ?>"><img src="../img_mcit/icon/Attach_322.png" width="32" height="32" border="0" /></a></td>
                    <td class="frmtablabody" align="center"><a href="contrato_attached_edit.php?hash=<?php echo md5($row_rsinfocompleta['cont_hash']); ?>&amp;id_cont=<?php echo $row_rsinfocompleta['id_cont']; ?>&amp;att_type=<?php echo $row_rsanexoslist['id_att_type']; ?>&amp;id_att=<?php echo $row_rsattachcont['id_att']; ?>" title="Editar para modificar documento adjunto" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )"><img src="../img_mcit/icon/edit_322_a.png" width="32" height="32" border="0" /></a></td>
                  </tr>
                    <?php } while ($row_rsattachcont = mysql_fetch_assoc($rsattachcont)); ?>
              </table>
                <?php } // Show if recordset not empty ?>
</td>
            <td><table width="95%" border="0" align="center" cellpadding="0" cellspacing="2">
              <tr>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td colspan="2">Seleccionar anexo:</td>
              </tr>
              <tr>
                <td colspan="2"><table width="300" border="0" cellspacing="2" cellpadding="0">
                  <tr>
                    <td class="frmtablahead">Clase de documento</td>
                    <td class="frmtablahead">&nbsp;</td>
                  </tr>
                  <?php do { ?>
                    <tr class="frmtablabody">
                      <td ><?php echo $row_rsanexoslist['att_type_name']; ?></td>
                      <td align="center"><a href="contrato_attached.php?hash=<?php echo md5($row_rsinfocompleta['cont_hash']); ?>&amp;id_cont=<?php echo $row_rsinfocompleta['id_cont']; ?>&amp;att_type=<?php echo $row_rsanexoslist['id_att_type']; ?>" title="Adjuntar documento" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )"><img src="../img_mcit/icon/Add_241.png" width="24" height="24" border="0" /></a></td>
                    </tr>
                    <?php } while ($row_rsanexoslist = mysql_fetch_assoc($rsanexoslist)); ?>
                </table></td>
              </tr>
              <tr>
                <td colspan="2">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
        </table>
  </div>
    <div id="tabs-4">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="63%"><?php 
// Show IF Conditional region3 
if (@$row_rsinfocont['QTYDIAS'] != "") {
?>
                <table width="500" border="0" cellspacing="3" cellpadding="0">
                  <tr>
                    <td class="titlemsg2">SUPERVISORES</td>
                    <td width="12%" align="center" title="Administrar supervisores"><a href="../_mod_infsup/supervisor_list.php"><img src="../img_mcit/icon/add_group_488.png" width="48" height="48" border="0" /></a></td>
                    <td width="10%" align="center" title="Asignar supervisor"><a href="../_mod_infsup/assign_sup.php?hash=<?php echo md5($row_rsinfocompleta['cont_hash']); ?>&amp;id_cont=<?php echo $row_rsinfocompleta['id_cont']; ?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )"><img src="icons/_488_new.png" width="48" height="48" border="0" /></a></td>
                    <td width="10%" align="center" title="Editar"><a href="../_mod_infsup/assign_periodo.php?hash=<?php echo md5($row_rsinfocompleta['cont_hash']); ?>&amp;id_cont=<?php echo $row_rsinfocompleta['id_cont']; ?>" title="Fijar periodicidad" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )"><img src="icons/_488_cal.png" width="48" height="48" border="0" /></a></td>
                  </tr>
                </table>
                <?php 
// else Conditional region3
} else { ?>
                No es posible asignar supervisor, ya que no existe fecha de inicio y fecha final del contrato
  <?php } 
// endif Conditional region3
?>
<?php 
// Show IF Conditional region4 
if (@$row_rsinfocont['QTYDIAS'] != "") {
?>
                <table width="100%" border="0" cellspacing="2" cellpadding="0">
                  <tr class="frmtablahead">
                    <td width="10%" >Usuario</td>
                    <td width="56%" >Nombre del supervisor/interventor</td>
                    <td width="13%" >Fecha de asignaci&oacute;n</td>
                    <td width="8%" >Activo</td>
                    <td width="13%" >&nbsp;</td>
                  </tr>
                  <?php do { ?>
                    <tr class="frmtablabody">
                      <td><?php echo $row_rssupervlist['Username']; ?></td>
                      <td><?php echo $row_rssupervlist['usr_name']; ?>&nbsp;<?php echo $row_rssupervlist['usr_lname']; ?><br />
                        <table width="100%" border="0" cellspacing="2" cellpadding="0">
                          <tr>
                            <td width="23%">&nbsp;</td>
                            <td width="47%">&nbsp;</td>
                            <td width="30%" align="center"><a href="../_mod_infsup/edit_cargodep.php?idusrglobal=<?php echo $row_rssupervlist['idusrglobal_fk']; ?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )"><img src="icons/242_edit.png" width="24" height="24" border="0" /></a></td>
                          </tr>
                          <tr>
                            <td class="frmtablahead">Dependencia:</td>
                            <td colspan="2" class="frmceldauno"><?php echo $row_rssupervlist['dpd_dsdpn_b']; ?></td>
                          </tr>
                          <tr>
                            <td class="frmtablahead">Cargo:</td>
                            <td colspan="2" class="frmceldauno"><?php echo $row_rssupervlist['nomcar']; ?></td>
                          </tr>
                        </table>
                      <br /></td>
                      <td align="center"><?php echo $row_rssupervlist['sup_fechanot']; ?></td>
                      <td align="center"><?php 
// Show IF Conditional region1 
if (@$row_rssupervlist['sup_status'] == 1) {
?>
                            <a href="../_mod_infsup/assign_sup_not_2.php?interventor_id=<?php echo $row_rssupervlist['interventor_id']; ?>" title="Desactivar" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )"><img src="../img_mcit/icon/ok_322_a.png" width="32" height="32" border="0" /></a>
                            <?php } 
// endif Conditional region1
?>
                          <?php 
// Show IF Conditional region2 
if (@$row_rssupervlist['sup_status'] == 0) {
?>
                            <a href="../_mod_infsup/assign_sup_not.php?interventor_id=<?php echo $row_rssupervlist['interventor_id']; ?>" title="Activar" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )"><img src="../img_mcit/icon/off_322_b.png" width="32" height="32" border="0" /></a>
                      <?php } 
// endif Conditional region2
?></td>
                      <td class="frmceldauno" align="center"><table width="100" border="0" cellspacing="2" cellpadding="0">
                          <tr>
                            <td>&nbsp;</td>
                            <td><a href="../_mod_infsup/cont_list_adm.php?hash=<?php echo $_GET['hash']; ?>&amp;cod_ver=<?php echo $_GET['cod_ver']; ?>&amp;cont_id=<?php echo $_GET['cont_id']; ?>&amp;anio_id=<?php echo $_GET['anio_id']; ?>&amp;doc_id=<?php echo $_GET['doc_id']; ?>" title="Ver informes registrados"><img src="icons/326_viewinf.png" width="32" height="32" border="0" /></a></td>
                            <td>&nbsp;</td>
                          </tr>
                      </table></td>
                    </tr>
                    <?php } while ($row_rssupervlist = mysql_fetch_assoc($rssupervlist)); ?>
            </table>
                <?php } 
// endif Conditional region4
?></td>
            <td width="37%"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="2">
              <tr>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td colspan="2">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="2">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="2">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="2">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="2">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
        </table>
  </div>
  <div id="tabs-5">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="45%"><table width="500" border="0" cellspacing="3" cellpadding="0">
              <tr>
                <td class="titlemsg2">CONTROL DE PAGOS</td>
                <td width="12%" align="right" >&nbsp;</td>
                <td width="10%" align="right" title="Registrar">&nbsp;</td>
                <td width="10%" align="center" title="Editar"><a href="../_export/_process/_pagos_001.php?id_cont=<?php echo $_GET['doc_id']; ?>"><img src="../img_mcit/icon/export_excel_488.png" width="48" height="48" border="0" /></a></td>
              </tr>
            </table>
              <table width="422" border="0" cellspacing="2" cellpadding="0">
                <tr class="frmtablahead">
                  <td width="86">FECHA</td>
                  <td width="173">DESCRIPCION</td>
                  <td width="155">VALOR</td>
                </tr>
                <?php do { ?>
                <tr class="frmtablabody">
                  <td ><?php echo $row_rslistpagos['ctrlpagos_fecha']; ?></td>
                    <td ><?php echo $row_rslistpagos['ctrlpagos_desc']; ?></td>
                    <td  align="right"><?php echo number_format($row_rslistpagos['ctrlpagos_valor'],0,',','.'); ?></td>
                </tr>
                  <?php } while ($row_rslistpagos = mysql_fetch_assoc($rslistpagos)); ?>
            </table></td>
            <td width="55%"><table width="300" border="0" align="center" cellpadding="0" cellspacing="2">
              <tr>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td colspan="2">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="2">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="2">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="2">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="2">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
        </table>
	</div>
    <div id="tabs-6">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="45%"><table width="500" border="0" cellspacing="3" cellpadding="0">
              <tr>
                <td class="titlemsg2">MODIFICACI&Oacute;N AL CONTRATO</td>
                <td width="12%" align="right">&nbsp;</td>
                <td width="10%" align="center" title="Registrar"><a href="otrosi_activate.php?id_cont=<?php echo $row_rsinfocont['id_cont']; ?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )" title="Activar las funcionalidades del otrosi">
                  <?php 
// Show IF Conditional region6 
if (@$row_rsinfocompleta['cont_otrosi'] == "" or $row_rsinfocompleta['cont_otrosi'] == 0) {
?>
                    <img src="icons/321_check.png" width="32" height="32" border="0" />
                <?php } 
// endif Conditional region6
?></a></td>
                <td width="10%" align="center" title="Editar"><a href="otrosi_deactivate.php?id_cont=<?php echo $row_rsinfocont['id_cont']; ?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )" title="Desactivar las funcionalidades del otrosi">
                  <?php 
// Show IF Conditional region7 
if (@$row_rsinfocompleta['cont_otrosi'] == 1) {
?>
                    <img src="icons/deactivate.png" width="32" height="32" border="0" />
                <?php } 
// endif Conditional region7
?></a></td>
              </tr>
            </table>
              
              <?php 
// Show IF Conditional region5 
if (@$row_rsinfocompleta['cont_otrosi'] == 1) {
?>
                <table width="500" border="0" cellspacing="1" cellpadding="0">
                  <?php do { ?>
                    <tr>
                      <td class="frmtablahead"><?php echo $row_rslistotrosi['otrosi_name']; ?></td>
                      <td width="12%" align="center" class="frmceldauno"><a href="<?php echo $row_rslistotrosi['otrosi_lnk']; ?>?doc_id=<?php echo $row_rsinfocont['id_cont']; ?>&amp;otrosi_id=<?php echo $row_rslistotrosi['otrosi_id']; ?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )" title="Modificar registro"><img src="icons/_add_322.png" width="32" height="32" border="0" /></a></td>
                      <td width="10%" align="right" title="Registrar"></td>
                      <td width="10%" align="right" title="Editar">&nbsp;</td>
                    </tr>
                    <?php } while ($row_rslistotrosi = mysql_fetch_assoc($rslistotrosi)); ?>
                </table>
            <?php } 
// endif Conditional region5
?><p>&nbsp;</p></td>
            <td width="55%"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="2">
              <tr>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td colspan="2">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="2">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="2">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="2">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="2">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
        </table>
  </div>
    <div id="tabs-9">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="73%"><table width="500" border="0" cellspacing="3" cellpadding="0">
              <tr>
                <td class="titlemsg2">ACTA DE LIQUIDACIÓN</td>
                <td width="12%" align="right" >&nbsp;</td>
                <td width="10%" align="right" title="Registrar"><a href="#"><img src="icons/_488_new.png" width="48" height="48" border="0" /></a></td>
                <td width="10%" align="right" title="Editar"><a href="#"><img src="icons/_488_edit.png" width="48" height="48" border="0" /></a></td>
              </tr>
            </table>
              <table width="100%" border="0" cellspacing="2" cellpadding="0">
                <tr>
                  <td class="frmceldacuatro">FECHA</td>
                  <td class="frmceldacuatro">ADJUNTO</td>
                </tr>
                <tr>
                  <td class="frmceldauno">&nbsp;</td>
                  <td class="frmceldauno">&nbsp;</td>
                </tr>
              </table>
            <p>&nbsp;</p></td>
            <td width="27%"><table width="300" border="0" align="center" cellpadding="0" cellspacing="2">
              <tr>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td colspan="2">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="2">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="2">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="2">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="2">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
        </table>
	</div>
</div>

<?php
  mxi_includes_start("../inc_foot.php");
  require(basename("../inc_foot.php"));
  mxi_includes_end();
?>
</body>
</html>
<?php
mysql_free_result($rsinfocont);

mysql_free_result($rsinfocompleta);

mysql_free_result($rsattachcont);

mysql_free_result($rsattpoliza);

mysql_free_result($rsanexoslist);

mysql_free_result($rssupervlist);

mysql_free_result($rscontrolpagado);

mysql_free_result($rslistpagos);

mysql_free_result($rslistotrosi);

mysql_free_result($rsmodlist);
?>
