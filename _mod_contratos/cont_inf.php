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

$colname_rsinfocont = "-1";
if (isset($_GET['doc_id'])) {
  $colname_rsinfocont = $_GET['doc_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rsinfocont = sprintf("SELECT * FROM q_adm_contratos WHERE id_cont = %s", GetSQLValueString($colname_rsinfocont, "int"));
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
$query_rsattachcont = sprintf("SELECT * FROM contrato_attach WHERE id_cont_fk = %s", GetSQLValueString($colname_rsattachcont, "int"));
$rsattachcont = mysql_query($query_rsattachcont, $oConnContratos) or die(mysql_error());
$row_rsattachcont = mysql_fetch_assoc($rsattachcont);
$totalRows_rsattachcont = mysql_num_rows($rsattachcont);

$colname_rsinfsupa = "-1";
if (isset($_GET['cont_id'])) {
  $colname_rsinfsupa = $_GET['cont_id'];
}
$colanio_rsinfsupa = "-1";
if (isset($_GET['anio_id'])) {
  $colanio_rsinfsupa = $_GET['anio_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rsinfsupa = sprintf("SELECT * FROM interventor_interno WHERE contnumero = %s AND iint_anocont = %s", GetSQLValueString($colname_rsinfsupa, "text"),GetSQLValueString($colanio_rsinfsupa, "text"));
$rsinfsupa = mysql_query($query_rsinfsupa, $oConnContratos) or die(mysql_error());
$row_rsinfsupa = mysql_fetch_assoc($rsinfsupa);
$totalRows_rsinfsupa = mysql_num_rows($rsinfsupa);

$colname_rspagos = "-1";
if (isset($_GET['cdp_id'])) {
  $colname_rspagos = $_GET['cdp_id'];
}
$colcomp_rspagos = "-1";
if (isset($_GET['rp_id'])) {
  $colcomp_rspagos = $_GET['rp_id'];
}
$colrubro_rspagos = "-1";
if (isset($_GET['rubro_id'])) {
  $colrubro_rspagos = $_GET['rubro_id'];
}
$colcedula_rspagos = "-1";
if (isset($_GET['cc_id'])) {
  $colcedula_rspagos = $_GET['cc_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rspagos = sprintf("SELECT * FROM q_obligaciones WHERE CDP = %s AND Compromisos = %s AND RUBRO2 = %s AND q_obligaciones.Identificacion = %s", GetSQLValueString($colname_rspagos, "text"),GetSQLValueString($colcomp_rspagos, "text"),GetSQLValueString($colrubro_rspagos, "text"),GetSQLValueString($colcedula_rspagos, "text"));
$rspagos = mysql_query($query_rspagos, $oConnContratos) or die(mysql_error());
$row_rspagos = mysql_fetch_assoc($rspagos);
$totalRows_rspagos = mysql_num_rows($rspagos);

// Download File downloadObj1
$downloadObj1 = new tNG_Download("../", "KT_download1");
// Execute
$downloadObj1->setFolder("../../adjuntos/contratos/ct/");
$downloadObj1->setRenameRule("{rsattachcont.att_ct}");
$downloadObj1->Execute();

// Download File downloadObj2
$downloadObj2 = new tNG_Download("../", "KT_download2");
// Execute
$downloadObj2->setFolder("../../adjuntos/contratos/sp/");
$downloadObj2->setRenameRule("{rsattachcont.att_sp}");
$downloadObj2->Execute();
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
	  <li><a href="dashboard.php?anio_id=2013" title="Regresa una página atrás">Regresar</a></li>
	</ul>
</div><br />
<table width="100%" border="0" cellspacing="3" cellpadding="0">
  <tr>
    <td colspan="2" class="titlemsg2">Contrato No. <?php echo $row_rsinfocont['contnumero']; ?> de <?php echo $row_rsinfocont['cont_ano']; ?></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td width="50%" class="titlemsg3Gray">Nombre/Razon</td>
    <td width="50%" class="titlemsg3Gray">Nit/Documento</td>
  </tr>
  <tr>
    <td class="titlemsg2"><?php echo $row_rsinfocont['cont_nom_contra_ta']; ?></td>
    <td class="titlemsg2"><?php echo $row_rsinfocont['cont_nit_contra_ta']; ?></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td class="titlemsg3Gray">Valor del contrato </td>
    <td class="titlemsg2">$<?php echo number_format($row_rsinfocont['cont_valori'],0,',','.'); ?></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>
<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Información básica</a></li>
		<li><a href="#tabs-2">Pólizas</a></li>
		<li><a href="#tabs-3">Anexos</a></li>
        <li><a href="#tabs-4">Supervisión</a></li>
        <li><a href="#tabs-5">Adiciones</a></li>
        <li><a href="#tabs-6">Cesión</a></li>
        <li><a href="#tabs-7">Otrosí</a></li>
        <li><a href="#tabs-8">Pagos</a></li>
        <li><a href="#tabs-19">Acta de liquidación</a></li>
  </ul>
	<div id="tabs-1">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="45%"><table width="500" border="0" cellspacing="3" cellpadding="0">
              <tr>
                <td class="titlemsg2">INFORMACI&Oacute;N B&Aacute;SICA</td>
                <td width="10%" align="right">&nbsp;</td>
                <td width="10%" align="right" title="Editar contrato"><a href="#"><img src="icons/_488_edit.png" width="48" height="48" border="0" /></a></td>
              </tr>
            </table>
              <table width="100%" border="0" cellspacing="2" cellpadding="0">
              <tr>
                <td class="frmceldacuatro">No. CDP</td>
                <td class="frmceldacuatro">No. RP</td>
                <td class="frmceldacuatro">Rubro</td>
                <td class="frmceldacuatro">Unidad ejecutora</td>
              </tr>
              <tr>
                <td class="frmceldauno"><?php echo $row_rsinfocompleta['prenumero']; ?></td>
                <td class="frmceldauno"><?php echo $row_rsinfocompleta['numregistro']; ?></td>
                <td class="frmceldauno"><?php echo $row_rsinfocompleta['cont_codrubro']; ?></td>
                <td class="frmceldauno"><?php echo $row_rsinfocompleta['cont_tipopre']; ?></td>
              </tr>
              <tr>
                <td class="frmceldacuatro">Tipo CDP</td>
                <td class="frmceldacuatro">Fecha suscripci&oacute;n</td>
                <td class="frmceldacuatro">Fecha de inicio:</td>
                <td class="frmceldacuatro">Fecha final:</td>
              </tr>
              <tr>
                <td class="frmceldauno"><?php echo $row_rsinfocompleta['cont_tipo']; ?></td>
                <td class="frmceldauno"><?php echo $row_rsinfocompleta['cont_fechaapertura']; ?></td>
                <td class="frmceldauno"><?php echo $row_rsinfocompleta['cont_fecha_inicio']; ?></td>
                <td class="frmceldauno"><?php echo $row_rsinfocompleta['cont_fechafinal']; ?></td>
              </tr>
              <tr>
                <td class="frmceldacuatro">Plazo inicial</td>
                <td class="frmceldacuatro">Fecha plazo</td>
                <td class="frmceldacuatro">Plazo liquidaci&oacute;n</td>
                <td class="frmceldacuatro">Fase</td>
              </tr>
              <tr>
                <td class="frmceldauno"><?php echo $row_rsinfocompleta['cont_plazoi']; ?></td>
                <td class="frmceldauno"><?php echo $row_rsinfocompleta['cont_fecha_saldo']; ?></td>
                <td class="frmceldauno"><?php echo $row_rsinfocompleta['cont_plazol']; ?></td>
                <td class="frmceldauno"><?php echo $row_rsinfocompleta['cont_fase']; ?></td>
              </tr>
              <tr>
                <td colspan="2" class="frmceldacuatro">Modalidad</td>
                <td colspan="2" class="frmceldacuatro">Tipo de contrato</td>
              </tr>
              <tr>
                <td colspan="2" class="frmceldauno"><?php echo $row_rsinfocompleta['cont_modalidad']; ?></td>
                <td colspan="2" class="frmceldauno"><?php echo $row_rsinfocompleta['cont_tipoproceso']; ?></td>
              </tr>
            </table>
            </td>
            <td valign="top"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="2">
              <tr>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td colspan="2">Objeto</td>
              </tr>
              <tr>
                <td colspan="2"><?php echo $row_rsinfocompleta['cont_objeto']; ?></td>
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
<div id="tabs-2">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="45%"><table width="500" border="0" cellspacing="3" cellpadding="0">
              <tr>
                <td width="27%" class="titlemsg2">POLIZAS</td>
                <td width="29%" align="right">&nbsp;</td>
                <td width="12%" align="right">&nbsp;</td>
                <td width="12%" align="right">&nbsp;</td>
                <td width="10%" align="right" title="Registrar póliza">&nbsp;</td>
                <td width="10%" align="right" title="Editar póliza">&nbsp;</td>
              </tr>
            </table></td>
            <td width="55%">&nbsp;</td>
          </tr>
        </table>
  </div>
	<div id="tabs-3">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="38%"><table width="500" border="0" cellspacing="3" cellpadding="0">
              <tr>
                <td class="titlemsg2">ANEXOS</td>
                <td width="12%" align="right">&nbsp;</td>
                <td width="10%" align="right" title="Registrar">&nbsp;</td>
                <td width="10%" align="right" title="Editar p&oacute;liza">&nbsp;</td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="2" cellpadding="0">
              <tr>
                <td class="frmceldacuatro">CONTRATO</td>
                <td class="frmceldacuatro">SOPORTES</td>
              </tr>
              <tr>
                <td class="frmceldauno"><a href="<?php echo $downloadObj1->getDownloadLink(); ?>"><?php echo $row_rsattachcont['att_ct']; ?></a></td>
                <td class="frmceldauno"><a href="<?php echo $downloadObj2->getDownloadLink(); ?>"><?php echo $row_rsattachcont['att_sp']; ?></a></td>
              </tr>
            </table></td>
            <td>&nbsp;</td>
          </tr>
        </table>
  </div>
    <div id="tabs-4">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="46%"><table width="500" border="0" cellspacing="3" cellpadding="0">
              <tr>
                <td class="titlemsg2">SUPERVISORES</td>
                <td width="12%" align="right">&nbsp;</td>
                <td width="10%" align="right" title="Asignar supervisor">&nbsp;</td>
                <td width="10%" align="right" title="Editar">&nbsp;</td>
              </tr>
            </table>
              <table width="100%" border="0" cellspacing="2" cellpadding="0">
              <tr>
                <td class="frmceldacuatro">No. documento</td>
                <td class="frmceldacuatro">Nombre del supervisor/interventor</td>
                <td >&nbsp;</td>
              </tr>
              <?php do { ?>
              <tr>
                <td class="frmceldauno"><?php echo $row_rsinfsupa['iint_numero']; ?></td>
                <td class="frmceldauno"><?php echo $row_rsinfsupa['iint_nombres']; ?></td>
                <td class="frmceldauno" align="center">&nbsp;</td>
              </tr>
              <?php } while ($row_rsinfsupa = mysql_fetch_assoc($rsinfsupa)); ?>
            </table></td>
            <td width="54%">&nbsp;</td>
          </tr>
        </table>
  </div>
    <div id="tabs-5">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="45%"><table width="500" border="0" cellspacing="3" cellpadding="0">
              <tr>
                <td class="titlemsg2">ADICION AL CONTRATO</td>
                <td width="12%" align="right">&nbsp;</td>
                <td width="10%" align="right" title="Registrar">&nbsp;</td>
                <td width="10%" align="right" title="Editar">&nbsp;</td>
              </tr>
            </table></td>
            <td width="55%">&nbsp;</td>
          </tr>
        </table>
  </div>
     <div id="tabs-6">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="73%"><table width="500" border="0" cellspacing="3" cellpadding="0">
              <tr>
                <td class="titlemsg2">CESI&Oacute;N DE CONTRATO</td>
                <td width="12%" align="right" >&nbsp;</td>
                <td width="10%" align="right" title="Registrar">&nbsp;</td>
                <td width="10%" align="right" title="Editar">&nbsp;</td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="2" cellpadding="0">
              <tr>
                <td class="frmceldacuatro">NOMBRE</td>
                <td class="frmceldacuatro">VALOR CESI&Oacute;N</td>
                <td class="frmceldacuatro">FECHA INICIAL</td>
                <td class="frmceldacuatro">FECHA FINAL</td>
                <td class="frmceldacuatro">OBSERVACIONES</td>
              </tr>
              <tr>
                <td class="frmceldauno"><?php echo $row_rsinfocompleta['cont_nom_contra_ces']; ?></td>
                <td class="frmceldauno"><?php echo $row_rsinfocompleta['cesion_valor']; ?></td>
                <td class="frmceldauno"><?php echo $row_rsinfocompleta['cesion_fechai']; ?></td>
                <td class="frmceldauno"><?php echo $row_rsinfocompleta['cesion_fechaf']; ?></td>
                <td class="frmceldauno"><?php echo $row_rsinfocompleta['cesion_observ']; ?></td>
              </tr>

            </table></td>
            <td width="27%">&nbsp;</td>
          </tr>
        </table>
	</div>
    <div id="tabs-7">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="93%"><table width="500" border="0" cellspacing="3" cellpadding="0">
              <tr>
                <td class="titlemsg2">OTROSÍ</td>
                <td width="12%" align="right" >&nbsp;</td>
                <td width="10%" align="right" title="Registrar">&nbsp;</td>
                <td width="10%" align="right" title="Editar">&nbsp;</td>
              </tr>
            </table>
            </td>
            <td width="7%">&nbsp;</td>
          </tr>
        </table>
	</div>
    <div id="tabs-8">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="73%"><table width="500" border="0" cellspacing="3" cellpadding="0">
              <tr>
                <td class="titlemsg2">PAGOS</td>
                <td width="12%" align="right" >&nbsp;</td>
                <td width="10%" align="right" title="Registrar">&nbsp;</td>
                <td width="10%" align="right" title="Editar">&nbsp;</td>
              </tr>
            </table>
              <table width="100%" border="0" cellspacing="2" cellpadding="0">
                <tr>
                  <td class="frmceldacuatro">NUMERO DE ORDEN</td>
                  <td class="frmceldacuatro">FECHA</td>
                  <td class="frmceldacuatro">VALOR</td>
                  <td class="frmceldacuatro">CONCEPTO</td>
                  <td class="frmceldacuatro">MEDIO/BANCO</td>
                </tr>
                <?php do { ?>
                <tr>
                  <td class="frmceldauno"><?php echo $row_rspagos['Ordenes de Pago']; ?></td>
                  <td class="frmceldauno"><?php echo $row_rspagos['Fecha de Creacion']; ?></td>
                  <td class="frmceldauno" align="right"><?php echo number_format($row_rspagos['Valor Actual'],2,',','.'); ?></td>
                  <td class="frmceldauno"><?php echo $row_rspagos['Concepto']; ?></td>
                  <td class="frmceldauno"><?php echo $row_rspagos['Medio de Pago']; ?>-<?php echo $row_rspagos['Entidad Descripcion']; ?></td>
                </tr>
                  <?php } while ($row_rspagos = mysql_fetch_assoc($rspagos)); ?>
              </table></td>
            <td width="27%">&nbsp;</td>
          </tr>
        </table>
	</div>
    <div id="tabs-19">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="73%"><table width="500" border="0" cellspacing="3" cellpadding="0">
              <tr>
                <td class="titlemsg2">ACTA DE LIQUIDACIÓN</td>
                <td width="12%" align="right" >&nbsp;</td>
                <td width="10%" align="right" title="Registrar">&nbsp;</td>
                <td width="10%" align="right" title="Editar">&nbsp;</td>
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
            <td width="27%">&nbsp;</td>
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

mysql_free_result($rsinfsupa);

mysql_free_result($rspagos);
?>
