<?php require_once('../Connections/oConnContratos.php'); ?>
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

$colname_rsmodlist = "-1";
if (isset($_GET['doc_id'])) {
  $colname_rsmodlist = $_GET['doc_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rsmodlist = sprintf("SELECT contrato_os.os_id, contrato_os.id_cont_fk, contrato_os.os_type_type, contrato_os.os_fecha, contrato_os.os_valor, contrato_os.os_fecha_i, contrato_os.os_fecha_f, contrato_os.os_varios, contrato_os.sys_user, contrato_otrosi_type.otrosi_name, contrato_otrosi_type.otrosi_lnk FROM contrato_os INNER JOIN contrato_otrosi_type ON contrato_os.os_type_type = contrato_otrosi_type.otrosi_id WHERE id_cont_fk = %s", GetSQLValueString($colname_rsmodlist, "int"));
$rsmodlist = mysql_query($query_rsmodlist, $oConnContratos) or die(mysql_error());
$row_rsmodlist = mysql_fetch_assoc($rsmodlist);
$totalRows_rsmodlist = mysql_num_rows($rsmodlist);

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
mysql_query("SET NAMES 'utf8'");
$query_rsinfocont = sprintf("SELECT * FROM q_001_dashboard WHERE id_cont = %s", GetSQLValueString($colname_rsinfocont, "int"));
$rsinfocont = mysql_query($query_rsinfocont, $oConnContratos) or die(mysql_error());
$row_rsinfocont = mysql_fetch_assoc($rsinfocont);
$totalRows_rsinfocont = mysql_num_rows($rsinfocont);

$colname_rsinfocompleta = "-1";
if (isset($_GET['doc_id'])) {
  $colname_rsinfocompleta = $_GET['doc_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
mysql_query("SET NAMES 'utf8'");
$query_rsinfocompleta = sprintf("SELECT * FROM contrato WHERE id_cont = %s", GetSQLValueString($colname_rsinfocompleta, "int"));
$rsinfocompleta = mysql_query($query_rsinfocompleta, $oConnContratos) or die(mysql_error());
$row_rsinfocompleta = mysql_fetch_assoc($rsinfocompleta);
$totalRows_rsinfocompleta = mysql_num_rows($rsinfocompleta);

$colname_rsattachcont = "-1";
if (isset($_GET['doc_id'])) {
  $colname_rsattachcont = $_GET['doc_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
mysql_query("SET NAMES 'utf8'");
$query_rsattachcont = sprintf("SELECT * FROM q_info_attached WHERE id_cont_fk = %s AND att_type_ctrl = 1 ORDER BY att_type_name ASC", GetSQLValueString($colname_rsattachcont, "int"));
$rsattachcont = mysql_query($query_rsattachcont, $oConnContratos) or die(mysql_error());
$row_rsattachcont = mysql_fetch_assoc($rsattachcont);
$totalRows_rsattachcont = mysql_num_rows($rsattachcont);

$colname_rsattpoliza = "-1";
if (isset($_GET['doc_id'])) {
  $colname_rsattpoliza = $_GET['doc_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
mysql_query("SET NAMES 'utf8'");
$query_rsattpoliza = sprintf("SELECT * FROM contrato_attached WHERE id_cont_fk = %s AND att_type = 1", GetSQLValueString($colname_rsattpoliza, "int"));
$rsattpoliza = mysql_query($query_rsattpoliza, $oConnContratos) or die(mysql_error());
$row_rsattpoliza = mysql_fetch_assoc($rsattpoliza);
$totalRows_rsattpoliza = mysql_num_rows($rsattpoliza);

$colname_rssupervlist = "-1";
if (isset($_GET['doc_id'])) {
  $colname_rssupervlist = $_GET['doc_id'];
}
$coluser_rssupervlist = "-1";
if (isset($_SESSION['kt_login_user'])) {
  $coluser_rssupervlist = $_SESSION['kt_login_user'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
mysql_query("SET NAMES 'utf8'");
$query_rssupervlist = sprintf("SELECT * FROM q_global_supervisores WHERE id_cont_fk = %s AND Username = %s AND sup_status = 1", GetSQLValueString($colname_rssupervlist, "int"),GetSQLValueString($coluser_rssupervlist, "text"));
$rssupervlist = mysql_query($query_rssupervlist, $oConnContratos) or die(mysql_error());
$row_rssupervlist = mysql_fetch_assoc($rssupervlist);
$totalRows_rssupervlist = mysql_num_rows($rssupervlist);

$colname_rscontrolpagado = "-1";
if (isset($_GET['doc_id'])) {
  $colname_rscontrolpagado = $_GET['doc_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
mysql_query("SET NAMES 'utf8'");
$query_rscontrolpagado = sprintf("SELECT * FROM q_valorpagado WHERE id_cont_fk = %s", GetSQLValueString($colname_rscontrolpagado, "int"));
$rscontrolpagado = mysql_query($query_rscontrolpagado, $oConnContratos) or die(mysql_error());
$row_rscontrolpagado = mysql_fetch_assoc($rscontrolpagado);
$totalRows_rscontrolpagado = mysql_num_rows($rscontrolpagado);

$colname_rslistpagos = "-1";
if (isset($_GET['doc_id'])) {
  $colname_rslistpagos = $_GET['doc_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
mysql_query("SET NAMES 'utf8'");
$query_rslistpagos = sprintf("SELECT * FROM contrato_controlpagos WHERE id_cont_fk = %s ORDER BY ctrlpagos_fecha ASC", GetSQLValueString($colname_rslistpagos, "int"));
$rslistpagos = mysql_query($query_rslistpagos, $oConnContratos) or die(mysql_error());
$row_rslistpagos = mysql_fetch_assoc($rslistpagos);
$totalRows_rslistpagos = mysql_num_rows($rslistpagos);

$colname_rsinformesreg = "-1";
if (isset($_GET['doc_id'])) {
  $colname_rsinformesreg = $_GET['doc_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
mysql_query("SET NAMES 'utf8'");
$query_rsinformesreg = sprintf("SELECT * FROM informe_intersup WHERE id_cont_fk = %s ORDER BY inf_consecutivo ASC", GetSQLValueString($colname_rsinformesreg, "int"));
$rsinformesreg = mysql_query($query_rsinformesreg, $oConnContratos) or die(mysql_error());
$row_rsinformesreg = mysql_fetch_assoc($rsinformesreg);
$totalRows_rsinformesreg = mysql_num_rows($rsinformesreg);

$colname_rsnuminformes = "-1";
if (isset($_GET['doc_id'])) {
  $colname_rsnuminformes = $_GET['doc_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
mysql_query("SET NAMES 'utf8'");
$query_rsnuminformes = sprintf("SELECT * FROM q_informe_f2 WHERE id_cont_fk = %s", GetSQLValueString($colname_rsnuminformes, "int"));
$rsnuminformes = mysql_query($query_rsnuminformes, $oConnContratos) or die(mysql_error());
$row_rsnuminformes = mysql_fetch_assoc($rsnuminformes);
$totalRows_rsnuminformes = mysql_num_rows($rsnuminformes);

// Download File downloadObj1
$downloadObj1 = new tNG_Download("../", "KT_download1");
// Execute
$downloadObj1->setFolder("../_signed/");
$downloadObj1->setRenameRule("{rsinformesreg.sign_file}");
$downloadObj1->Execute();

// Download File downloadObj2
$downloadObj2 = new tNG_Download("../", "KT_download2");
// Execute
$downloadObj2->setFolder("../Firma_digital/signed/");
$downloadObj2->setRenameRule("{rsinformesreg.sign_file}");
$downloadObj2->Execute();

// Download File downloadObj1
$downloadObj9 = new tNG_Download("../", "KT_download9");
// Execute
$downloadObj9->setFolder("../Firma_digital/signed/certfirmados/");
$downloadObj9->setRenameRule("{rsinformesreg.cert_file}");
$downloadObj9->Execute();

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

$avgadv = number_format((($row_rscontrolpagado['valorpagado']/$row_rsinfocont['VALORI'])*100),2); 
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
<link rel="stylesheet" href="../_jquery/_desktop/_app/_modules/demos.css">
    <style>
		.ui-menu { position: absolute; width: 150px; }
	</style>
<script>
	$(function() {
		$( "#tabs" ).tabs();
		
		$( "#rerun" )
			.button()
			.click(function() {
				alert( "Seleccionar acci�n" );
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
function MM_popupMsg(msg) { //v1.0
  alert(msg);
}
</script>
</head>

<body>
<?php
  mxi_includes_start("../inc_top_2.php");
  require(basename("../inc_top_2.php"));
  mxi_includes_end();
?>
<table width="100%" border="0" cellspacing="3" cellpadding="0">
  <tr>
    <td class="titlemsg2">Contrato No. <?php echo $row_rsinfocont['CONTRATOID']; ?> de <?php echo $row_rsinfocont['VIGENCIA']; ?></td>
    <td class="titlemsg2" align="center"><table width="206" border="0" cellspacing="2" cellpadding="0">
                          <tr>
                            <td width="49" align="center"><a href="_create_cert_global.php?inf_id=<?php echo $row_rsinformesreg['inf_id']; ?>&amp;id_cont=<?php echo $_GET['cont_id']; ?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )" title="Generar certificado de recibo a satisfacci�n">
                              
                                
                                  <img src="../img_mcit/icon/aspectotecnico_322.png" border="0" />
                                  
                                </a></td>
                            <td width="45" align="center"><a href="../_gendraft/htmltodocx/_recibo_global.php?doc_id=<?php echo $row_rsinformesreg['id_cont_fk']; ?>&amp;inf_id=<?php echo $_GET['doc_id']; ?>" title="Generar certificacion">
                              
                                <img src="../img_mcit/icon/326_Export_Cert.png" width="32" height="32" border="0" />
                                </a></td>
                            <td width="45" align="center"></td>
                            <td width="45" align="center">&nbsp;</td>
                          </tr>
                        </table></td>
    <td colspan="3" class="titlemsg2"><table width="200" border="0" cellspacing="2" cellpadding="0">
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
    <td width="48%" height="29" colspan="2" class="titlemsg3Gray">Nombre/Razon</td>
    <td colspan="3" class="titlemsg3Gray">Nit/Documento</td>
  </tr>
  <tr>
    <td colspan="2" class="titlemsg2"><?php echo $row_rsinfocont['contractor_name']; ?></td>
    <td colspan="3" class="titlemsg2"><?php echo $row_rsinfocont['DOCID']; ?></td>
  </tr>
  <tr>
    <td colspan="2" class="titlemsg3Gray">Supervisor</td>
    <td class="titlemsg3Gray">Fecha asignaci&oacute;n</td>
    <td class="titlemsg3Gray">Informes sugeridos</td>
    <td class="titlemsg3Gray">Periodicidad</td>
  </tr>
  <tr>
    <td colspan="2" class="titlemsg2"><?php echo $row_rssupervlist['usr_name']; ?>&nbsp;<?php echo $row_rssupervlist['usr_lname']; ?></td>
    <td class="titlemsg2"><?php echo $row_rssupervlist['sup_fechanot']; ?></td>
    <td class="titlemsg2"><?php echo $row_rssupervlist['cont_informessug']; ?></td>
    <td class="titlemsg2"><?php echo $row_rssupervlist['periodo_name']; ?></td>
  </tr>
  <tr class="titlemsg3Gray">
    <td colspan="2" >Objeto del contrato</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
  </tr>
  <tr class="titlemsg3Gray">
    <td colspan="2" ><textarea name="textarea" id="textarea" cols="100px" rows="5"><?php echo $row_rsinfocont['cont_objeto']; ?></textarea></td>
    <td width="22%" >Valor del contrato </td>
    <td width="15%" >Valor pagado</td>
    <td width="15%" >Saldo</td>
  </tr>
  <tr>
    <td colspan="2" class="titlemsg3Gray"><table width="100%" border="0" cellspacing="2" cellpadding="0">
      <tr>
        <td>Fecha de Inicio</td>
        <td>Fecha Final</td>
        <td>Dias contratados</td>
        <td>Pago mensual</td>
      </tr>
      <tr>
        <td><span class="titlemsg2"><?php echo $row_rsinfocompleta['cont_fecha_inicio']; ?></span></td>
        <td><span class="titlemsg2"><?php echo $row_rsinfocompleta['cont_fechafinal']; ?></span></td>
        <td align="center"><span class="titlemsg2"><?php echo $row_rsinfocont['QTYDIAS']; ?></span></td>
        <td align="center"><span class="titlemsg2"><?php echo $row_rsinfocont['cont_valormensual']; ?></span></td>
      </tr>
    </table></td>
    <td class="titlemsg2">$<?php echo number_format($row_rsinfocont['VALORI'],0,',','.'); ?></td>
    <td class="titlemsg2">$<?php echo number_format($row_rscontrolpagado['valorpagado'],0,',','.'); ?></td>
    <td class="titlemsg2">$<?php echo number_format($row_rsinfocont['VALORI'] - $row_rscontrolpagado['valorpagado'],0,',','.'); ?></td>
  </tr>
  <tr>
    <td colspan="5"></td>
  </tr>
</table>
<div id="tabs">
	<ul>
      <li><a href="#tabs-1">INFORME DE SUPERVISIÓN / INTERVENTORÍA</a></li>
  </ul>
    <div id="tabs-1">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><?php 
// Show IF Conditional region3 
if (@$row_rsinfocont['QTYDIAS'] != "") {
?>
                <table width="500" border="0" cellspacing="3" cellpadding="0">
                  <tr>
                    <td class="titlemsg2">Lista de informes registrados</td>
                    <td align="center" title="Administrar supervisores"><div>
                      <div>
                        <button id="rerun">ACCIONES</button>
		  <button id="select">Acciones</button>
	  </div>
	  <ul>
        <?php if ($totalRows_rsnuminformes == 0) { // Show if recordset empty ?>
          <li><a href="create_inf.php?hash_id=<?php echo md5($row_rsinfocont['id_cont']); ?>&amp;anio_id=2013&amp;doc_id=<?php echo $row_rsinfocont['id_cont']; ?>&amp;rubro_id=<?php echo $row_rsinfocont['cont_codrubro']; ?>&amp;avgadv=<?php echo $avgadv; ?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )" title="Crear borrador">Crear borrador</a> </li>
          <?php } // Show if recordset empty ?>
        <?php if ($totalRows_rsnuminformes > 0) { // Show if recordset not empty ?>
          <li><a href="create_inf2.php?hash_id=<?php echo md5($row_rsinfocont['id_cont']); ?>&amp;anio_id=2013&amp;doc_id=<?php echo $row_rsinfocont['id_cont']; ?>&amp;rubro_id=<?php echo $row_rsinfocont['cont_codrubro']; ?>&amp;avgadv=<?php echo $avgadv; ?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )" title="Crear borrador">Crear borrador</a> </li>
          <?php } // Show if recordset not empty ?>
</ul>
                      </div></td>
                  </tr>
                </table>
.<?php } 
// endif Conditional region3
?>
<?php 
// Show IF Conditional region4 
if (@$row_rsinfocont['QTYDIAS'] != "") {
?>
                <table width="100%" border="0" cellspacing="2" cellpadding="0">
                  <tr class="frmtablahead">
                    <td width="9%" >&nbsp;</td>
                    <td width="8%" >&nbsp;</td>
                    <td colspan="3" align="center">PERIODO REPORTADO</td>
                    <td width="9%" >&nbsp;</td>
                    <td width="17%" >&nbsp;</td>
                    <td width="33%" >&nbsp;</td>
                  </tr>
                  <tr class="frmtablahead">
                    <td >CODIGO INFORME</td>
                    <td >NUMERO DE INFORME</td>
                    <td width="10%" align="center">DESDE</td>
                    <td colspan="2" align="center"> HASTA</td>
                    <td colspan="2" align="center">INFORMES DE SUPERVISI&Oacute;N</td>
                    <td align="center">CERTIFICADO DE RECIBO A SATISFACCI&Oacute;N</td>
                  </tr>
                  <?php do { ?>
                    <tr class="frmtablabody">
                      <td><?php echo $row_rsinformesreg['inf_hash']; ?></td>
                      <td align="center"><?php echo $row_rsinformesreg['inf_consecutivo']; ?></td>
                      <td align="center"><?php echo $row_rsinformesreg['inf_fecharep_i']; ?></td>
                      <td width="9%" align="center"><?php echo $row_rsinformesreg['inf_fecharep_f']; ?></td>
                      <td width="5%" align="center"><a href="edit_fecha_reporte.php?inf_id=<?php echo $row_rsinformesreg['inf_id']; ?>&amp;doc_id=<?php echo $row_rsinformesreg['id_cont_fk']; ?>" title="Ajustar periodo" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )">
                        <?php 
// Show IF Conditional region8 
if (@$row_rsinformesreg['inf_estado'] == 1) {
?>
                          <img src="../_mod_contratos/icons/245_date.png" width="24" height="24" border="0" />
                      <?php } 
// endif Conditional region8
?></a></td>
                      <td align="center"><p><a href="sign_file.php?inf_id=<?php echo $row_rsinformesreg['inf_id']; ?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )" title="Adjuntar documento PDF para ser firmado digitalmente">
                      <?php 
// Show IF Conditional region4 
if (@$row_rsinformesreg['inf_estado'] == 1 and $row_rsinformesreg['inf_actividades'] != "") {
?>
                        <img src="../img_mcit/icon/upload_322.png" width="32" height="32" border="0" />
                        <?php } 
// endif Conditional region4
?>
                      </a></p>
                        <?php 
// Show If File Exists (region6)
if (tNG_fileExists("../Firma_digital/signed/", "{rsinformesreg.sign_file}")) {
?>
                        <table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td colspan="4" class="titlenormaltext">Documento firmado digitalmente</td>
                          </tr>
                          <tr>
                            <td colspan="4"><?php echo $row_rsinformesreg['sign_hash']; ?></td>
                          </tr>
                          <tr>
                            <td width="110">&nbsp;</td>
                            <td width="40">&nbsp;</td>
                            <td width="40"><a href="<?php echo $downloadObj2->getDownloadLink(); ?>" title="Descargar documento firmado"><img src="../img_mcit/icon/cert_322.png" alt="" width="32" height="32" border="0" /></a></td>
                            <td width="40"><a href="infanexos_list_view.php?inf_id=<?php echo $row_rsinformesreg['inf_id']; ?>&amp;doc_id=<?php echo $row_rsinformesreg['id_cont_fk']; ?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )" title="Ver documentos adjuntos al informe"><img src="icons/326_veranexos.png" width="32" height="32" border="0" /></a></td>
                          </tr>
                                                      </table>
                        <?php 
// else File Exists (region6)
} else { ?>
                      <form action="../Firma_digital/www/sign_process.php" method="post" name="form1" target="_top" id="form1">
                              <?php 
// Show IF Conditional region7 
if (@$row_rsinformesreg['inf_estado'] == 2) {
?>
                                <table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
                                  <tr>
                                    <td><label>
                                      <input name="inf_id" type="hidden" id="inf_id" value="<?php echo $row_rsinformesreg['sign_file']; ?>" />
                                    </label></td>
                                    <td colspan="4"><label>
                                      <input type="submit" name="button" id="button" value="Firmar informe" />
                                    </label></td>
                                  </tr>
                                  <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td><a href="infanexos_list_view.php?inf_id=<?php echo $row_rsinformesreg['inf_id']; ?>&amp;doc_id=<?php echo $row_rsinformesreg['id_cont_fk']; ?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )" title="Ver documentos adjuntos al informe"><img src="icons/326_veranexos.png" width="32" height="32" border="0" /></a></td>
                                  </tr>
                                </table>
                        <?php } 
// endif Conditional region7
?></form>
  <?php } 
// EndIf File Exists (region6)
?>
                        <table width="40" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>                            </td>
                          </tr>
                        </table></td>
                      <td class="frmceldauno" align="center"><?php 
// Show IF Conditional region7 
if (@$row_rsinformesreg['inf_estado'] == 1) {
?>
      <table width="100" border="0" align="left" cellpadding="0" cellspacing="2">
                            <tr>
                              <td align="center"><a href="edit_activities.php?inf_id=<?php echo $row_rsinformesreg['inf_id']; ?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )" title="Ingresar desarrollo de actividades"><img src="../_mod_contratos/icons/326_rte.png" width="32" height="32" border="0" /></a></td>
                              <td align="center"><a href="assign_avg.php?inf_id=<?php echo $row_rsinformesreg['inf_id']; ?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )" title="Asignar porcentaje de ejecuci�n"><img src="../img_mcit/icon/percent.png" width="32" height="32" border="0" /></a></td>
                              <td align="center"><a href="assign_conformidad.php?inf_id=<?php echo $row_rsinformesreg['inf_id']; ?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )" title="Registrar incumplimientos al contrato"><img src="../img_mcit/icon/Warning_322.png" width="32" height="32" border="0" /></a></td>
                              <td align="center"><a href="assign_aspectostecnicos.php?inf_id=<?php echo $row_rsinformesreg['inf_id']; ?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )" title="Registrar aspectos t�cnicos"><img src="../img_mcit/icon/aspectotecnico_322.png" width="32" height="32" border="0" /></a></td>
                              <td align="center"><a href="assign_recoyobserva.php?inf_id=<?php echo $row_rsinformesreg['inf_id']; ?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )" title="Recomendaciones y Observaciones al ordenador del gasto"><img src="../img_mcit/icon/observaciones_322.png" width="32" height="32" border="0" /></a></td>
                              <td align="center"><a href="infanexos_list.php?inf_id=<?php echo $row_rsinformesreg['inf_id']; ?>&amp;doc_id=<?php echo $row_rsinformesreg['id_cont_fk']; ?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )" title="Registrar documentos anexos al informe"><img src="../_mod_contratos/icons/326_rtf.png" width="32" height="32" border="0" /></a></td>
                              <td align="center"><a href="../_gendraft/htmltodocx/_test_1.php?doc_id=<?php echo $row_rsinformesreg['id_cont_fk']; ?>&amp;inf_id=<?php echo $row_rsinformesreg['inf_id']; ?>" title="Generar borrador del informe">
                                <?php 
// Show IF Conditional region3 
if (@$row_rsinformesreg['inf_actividades'] != "") {
?>
                                  <img src="../_mod_contratos/icons/326_word.png" width="32" height="32" border="0" onclick="MM_popupMsg('A continuaci&oacute;n se genera un documento en formato Word, una vez verificado y corregido guarde el documento como .PDF y s&uacute;balo al sistema para que sea firmado digitalmente por el supervisor.')" />
                                  <?php } 
// endif Conditional region3
?>
                              </a></td>
                              <td align="center">&nbsp;</td>
                            </tr>
                      </table>
                      <?php } 
// endif Conditional region7
?>                      </td>                    
                      <td class="frmceldauno" align="center"><?php 
// Show If File Exists (region9)
if (tNG_fileExists("../Firma_digital/signed/", "{rsinformesreg.sign_file}")) {
?>
                        <table width="206" border="0" cellspacing="2" cellpadding="0">
                          <tr>
                            <td width="49" align="center"><?php 
// Show IF Conditional region12 
if (@$row_rsinformesreg['sign_verificacert'] != 2) {
?><a href="_create_cert.php?inf_id=<?php echo $row_rsinformesreg['inf_id']; ?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )" title="Generar certificado de recibo a satisfacci�n">
                              
                                
                                  <img src="../img_mcit/icon/aspectotecnico_322.png" border="0" />
                                  
                                </a><?php } 
// endif Conditional region12
?></td>
                            <td width="45" align="center"><?php 
// Show IF Conditional region10 
if (@$row_rsinformesreg['sign_verificacert'] == 1) {
?><a href="../_gendraft/htmltodocx/_recibo_sas.php?doc_id=<?php echo $row_rsinformesreg['id_cont_fk']; ?>&amp;inf_id=<?php echo $row_rsinformesreg['inf_id']; ?>" title="Generar borrador recibo a satisfaccion">
                              
                                <img src="../img_mcit/icon/326_Export_Cert.png" width="32" height="32" border="0" />
                                </a><?php } 
// endif Conditional region10
?></td>
                            <td width="45" align="center"><a href="sign_file_cert.php?inf_id=<?php echo $row_rsinformesreg['inf_id']; ?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )">
                              <?php 
// Show IF Conditional region13 
if (@$row_rsinformesreg['sign_verificacert'] == 1) {
?>
                                <img src="../img_mcit/icon/upload_322.png" border="0" />
                                <?php } 
// endif Conditional region13
?></a></td>
                            <td width="45" align="center"><?php 
// Show IF Conditional region12 
if (@$row_rsinformesreg['sign_verificacert'] == 2) {
?>
                                <table width="100%" border="0" cellspacing="2" cellpadding="0">
                                  <tr>
                                    <td>&nbsp;</td>
                                  <td><?php 
// Show If File Exists (region14)
if (tNG_fileExists("../Firma_digital/signed/certfirmados/", "{rsinformesreg.cert_file}")) {
?><a href="<?php echo $downloadObj9->getDownloadLink(); ?>">
                                      
                                        <img src="../img_mcit/icon/cert_322.png" border="0" />
                                        </a><?php 
// else File Exists (region14)
} else { ?>
<form id="form2" name="form2" method="post" action="../Firma_digital/www/sign_process_cert.php">
                                        <input name="inf_id" type="hidden" id="inf_id" value="<?php echo $row_rsinformesreg['cert_file']; ?>" />
                                        <input type="submit" name="button2" id="button2" value="Firmar certificado" />
                                    </form>
<?php } 
// EndIf File Exists (region14)
?>
                                    </td>
                                  </tr>
                                </table>
                            <?php } 
// endif Conditional region12
?></td>
                          </tr>
                        </table>
                      <?php } 
// EndIf File Exists (region9)
?></td>
                    </tr>
                    <?php } while ($row_rsinformesreg = mysql_fetch_assoc($rsinformesreg)); ?>
            </table>
            <?php } 
// endif Conditional region4
?></td>
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
mysql_free_result($rsmodlist);

mysql_free_result($rsinfocont);

mysql_free_result($rsinfocompleta);

mysql_free_result($rsattachcont);

mysql_free_result($rsattpoliza);

mysql_free_result($rssupervlist);

mysql_free_result($rscontrolpagado);

mysql_free_result($rslistpagos);

mysql_free_result($rsinformesreg);

mysql_free_result($rsnuminformes);
?>
