<?php require_once('../Connections/oConnContratos.php'); ?>
<?php require_once('../Connections/global.php'); ?>
<?php
/*
Análisis, Diseño y Desarrollo: Alex Fernando Gutierrez
correo: dito73@gmail.com
correo inst: agutierrezd@mincit.gov.co
celular: 3017874143
*/
require_once('../includes/common/KT_common.php');

// Load the tNG classes
require_once('../includes/tng/tNG.inc.php');

// Load the KT_back class
require_once('../includes/nxt/KT_back.php');

// Make a transaction dispatcher instance
$tNGs = new tNG_dispatcher("../");

// Make unified connection variable
$conn_oConnContratos = new KT_connection($oConnContratos, $database_oConnContratos);

// Start trigger
$formValidation = new tNG_FormValidation();
$formValidation->addField("sys_status", true, "numeric", "", "", "", "");
$formValidation->addField("sys_radicauser", true, "text", "", "", "", "");
$formValidation->addField("sys_radicadate", true, "date", "", "", "", "");
$formValidation->addField("sys_radicatime", true, "date", "", "", "", "");
$formValidation->addField("sys_radicaperiodo", true, "text", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

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

$colname_RsInfoCert = "-1";
if (isset($_GET['cxc_id'])) {
  $colname_RsInfoCert = $_GET['cxc_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_RsInfoCert = sprintf("SELECT * FROM q_info_certpago WHERE cxc_id = %s", GetSQLValueString($colname_RsInfoCert, "int"));
$RsInfoCert = mysql_query($query_RsInfoCert, $oConnContratos) or die(mysql_error());
$row_RsInfoCert = mysql_fetch_assoc($RsInfoCert);
$totalRows_RsInfoCert = mysql_num_rows($RsInfoCert);

$colname_RsAnexosList = "-1";
if (isset($_GET['inf_id'])) {
  $colname_RsAnexosList = $_GET['inf_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_RsAnexosList = sprintf("SELECT * FROM informe_intersup_anexos WHERE inf_id_fk = %s", GetSQLValueString($colname_RsAnexosList, "int"));
$RsAnexosList = mysql_query($query_RsAnexosList, $oConnContratos) or die(mysql_error());
$row_RsAnexosList = mysql_fetch_assoc($RsAnexosList);
$totalRows_RsAnexosList = mysql_num_rows($RsAnexosList);

$colname_RsInfoNominaBase = "-1";
if (isset($_GET['doc_id'])) {
  $colname_RsInfoNominaBase = $_GET['doc_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_RsInfoNominaBase = sprintf("SELECT * FROM q_nomina_base WHERE id_cont = %s", GetSQLValueString($colname_RsInfoNominaBase, "int"));
$RsInfoNominaBase = mysql_query($query_RsInfoNominaBase, $oConnContratos) or die(mysql_error());
$row_RsInfoNominaBase = mysql_fetch_assoc($RsInfoNominaBase);
$totalRows_RsInfoNominaBase = mysql_num_rows($RsInfoNominaBase);

mysql_select_db($database_oConnContratos, $oConnContratos);
$query_RsPeriodoNomina = "SELECT * FROM q_nomina_fecha_ctrl WHERE nomina_estado = 1";
$RsPeriodoNomina = mysql_query($query_RsPeriodoNomina, $oConnContratos) or die(mysql_error());
$row_RsPeriodoNomina = mysql_fetch_assoc($RsPeriodoNomina);
$totalRows_RsPeriodoNomina = mysql_num_rows($RsPeriodoNomina);

$colname_RsAnexosCont = "-1";
if (isset($_GET['doc_id'])) {
  $colname_RsAnexosCont = $_GET['doc_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_RsAnexosCont = sprintf("SELECT * FROM q_info_attached WHERE id_cont_fk = %s", GetSQLValueString($colname_RsAnexosCont, "int"));
$RsAnexosCont = mysql_query($query_RsAnexosCont, $oConnContratos) or die(mysql_error());
$row_RsAnexosCont = mysql_fetch_assoc($RsAnexosCont);
$totalRows_RsAnexosCont = mysql_num_rows($RsAnexosCont);

$colname_RsAttachMaster = "-1";
if (isset($_GET['doc_id'])) {
  $colname_RsAttachMaster = $_GET['doc_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_RsAttachMaster = sprintf("SELECT * FROM q_anexos_master WHERE contractor_id_fk = %s", GetSQLValueString($colname_RsAttachMaster, "int"));
$RsAttachMaster = mysql_query($query_RsAttachMaster, $oConnContratos) or die(mysql_error());
$row_RsAttachMaster = mysql_fetch_assoc($RsAttachMaster);
$totalRows_RsAttachMaster = mysql_num_rows($RsAttachMaster);

// Make an insert transaction instance
$ins_informe_intersup_cxc = new tNG_multipleInsert($conn_oConnContratos);
$tNGs->addTransaction($ins_informe_intersup_cxc);
// Register triggers
$ins_informe_intersup_cxc->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_informe_intersup_cxc->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_informe_intersup_cxc->registerTrigger("END", "Trigger_Default_Redirect", 99, "ok.php");
// Add columns
$ins_informe_intersup_cxc->setTable("informe_intersup_cxc");
$ins_informe_intersup_cxc->addColumn("sys_status", "NUMERIC_TYPE", "POST", "sys_status");
$ins_informe_intersup_cxc->addColumn("sys_radicauser", "STRING_TYPE", "POST", "sys_radicauser");
$ins_informe_intersup_cxc->addColumn("sys_radicadate", "DATE_TYPE", "POST", "sys_radicadate");
$ins_informe_intersup_cxc->addColumn("sys_radicatime", "DATE_TYPE", "POST", "sys_radicatime");
$ins_informe_intersup_cxc->addColumn("sys_radicaperiodo", "STRING_TYPE", "POST", "sys_radicaperiodo");
$ins_informe_intersup_cxc->setPrimaryKey("cxc_id", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_informe_intersup_cxc = new tNG_multipleUpdate($conn_oConnContratos);
$tNGs->addTransaction($upd_informe_intersup_cxc);
// Register triggers
$upd_informe_intersup_cxc->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_informe_intersup_cxc->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_informe_intersup_cxc->registerTrigger("END", "Trigger_Default_Redirect", 99, "ok.php");
// Add columns
$upd_informe_intersup_cxc->setTable("informe_intersup_cxc");
$upd_informe_intersup_cxc->addColumn("sys_status", "NUMERIC_TYPE", "POST", "sys_status");
$upd_informe_intersup_cxc->addColumn("sys_radicauser", "STRING_TYPE", "POST", "sys_radicauser");
$upd_informe_intersup_cxc->addColumn("sys_radicadate", "DATE_TYPE", "POST", "sys_radicadate");
$upd_informe_intersup_cxc->addColumn("sys_radicatime", "DATE_TYPE", "POST", "sys_radicatime");
$upd_informe_intersup_cxc->addColumn("sys_radicaperiodo", "STRING_TYPE", "POST", "sys_radicaperiodo");
$upd_informe_intersup_cxc->setPrimaryKey("cxc_id", "NUMERIC_TYPE", "GET", "cxc_id");

// Make an instance of the transaction object
$del_informe_intersup_cxc = new tNG_multipleDelete($conn_oConnContratos);
$tNGs->addTransaction($del_informe_intersup_cxc);
// Register triggers
$del_informe_intersup_cxc->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_informe_intersup_cxc->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$del_informe_intersup_cxc->setTable("informe_intersup_cxc");
$del_informe_intersup_cxc->setPrimaryKey("cxc_id", "NUMERIC_TYPE", "GET", "cxc_id");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsinforme_intersup_cxc = $tNGs->getRecordset("informe_intersup_cxc");
$row_rsinforme_intersup_cxc = mysql_fetch_assoc($rsinforme_intersup_cxc);
$totalRows_rsinforme_intersup_cxc = mysql_num_rows($rsinforme_intersup_cxc);

// Download File downloadObj1
$downloadObj1 = new tNG_Download("../", "KT_download1");
// Execute
$downloadObj1->setFolder("../_attach_infanexos/");
$downloadObj1->setRenameRule("{RsAnexosList.anexo_file}");
$downloadObj1->Execute();

// Download File downloadObj5
$downloadObj5 = new tNG_Download("../", "KT_download5");
// Execute
$downloadObj5->setFolder("../../contratistas/_anexos/docs/");
$downloadObj5->setRenameRule("{RsAttachMaster.att_doc}");
$downloadObj5->Execute();

// Download File downloadObj4
$downloadObj4 = new tNG_Download("../", "KT_download4");
// Execute
$downloadObj4->setFolder("../_attached/");
$downloadObj4->setRenameRule("{RsAnexosCont.att_file}");
$downloadObj4->Execute();

// Download File downloadObj3
$downloadObj3 = new tNG_Download("../", "KT_download3");
// Execute
$downloadObj3->setFolder("../Firma_digital/signed/certfirmados/");
$downloadObj3->setRenameRule("{RsInfoCert.cert_file}");
$downloadObj3->Execute();

// Download File downloadObj2
$downloadObj2 = new tNG_Download("../", "KT_download2");
// Execute
$downloadObj2->setFolder("../Firma_digital/signed/");
$downloadObj2->setRenameRule("{RsInfoCert.sign_file}");
$downloadObj2->Execute();
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link rel="stylesheet" href="../_jquery/_desktop/_app/themes/south-street/jquery.ui.all.css">
	<script src="../_jquery/_desktop/_app/jquery-1.9.1.js"></script>
	<script src="../_jquery/_desktop/_app/ui/jquery.ui.core.js"></script>
	<script src="../_jquery/_desktop/_app/ui/jquery.ui.widget.js"></script>
	<script src="../_jquery/_desktop/_app/ui/jquery.ui.tabs.js"></script>
<script>
	$(function() {
		$( "#tabs" ).tabs();
	});
	</script>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script src="../includes/skins/style.js" type="text/javascript"></script>
<?php echo $tNGs->displayValidationRules();?>
<script src="../includes/nxt/scripts/form.js" type="text/javascript"></script>
<script src="../includes/nxt/scripts/form.js.php" type="text/javascript"></script>
<script type="text/javascript">
$NXT_FORM_SETTINGS = {
  duplicate_buttons: false,
  show_as_grid: true,
  merge_down_value: true
}
</script>
</head>

<body>
<div id="tabs">
	<h2>Recibo de Certificado para pago de honorarios para el certificado No. <?php echo $row_RsInfoCert['inf_hash_fk']; ?></h2>
    <table width="100%" border="0" cellspacing="2" cellpadding="2">
      <tr>
        <td width="12%">Contratista:</td>
        <td colspan="3"><?php echo $row_RsInfoCert['cxc_razonsocial']; ?></td>
      </tr>
      <tr>
        <td>Contrato</td>
        <td><?php echo $row_RsInfoCert['cxc_cont']; ?> de <?php echo $row_RsInfoCert['cxc_anio']; ?></td>
        <td colspan="2"><table width="100%" border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td class="ui-state-default">ANEXO</td>
            <td class="ui-state-default">DESCARGAR</td>
          </tr>
          <?php do { ?>
            <tr>
              <td class="ui-state-highlight"><?php echo $row_RsAnexosCont['att_type_name']; ?></td>
              <td class="ui-state-highlight"><a href="<?php echo $downloadObj4->getDownloadLink(); ?>"><?php echo $row_RsAnexosCont['att_file']; ?></a></td>
            </tr>
            <?php } while ($row_RsAnexosCont = mysql_fetch_assoc($RsAnexosCont)); ?>
        </table></td>
      </tr>
      <tr>
        <td>Sueldo mensual</td>
        <td colspan="3"><?php echo number_format($row_RsInfoNominaBase['cont_valormensual'],0,'.',','); ?></td>
      </tr>
      <tr>
        <td>Informe de actividades</td>
        <td width="22%"><a href="<?php echo $downloadObj2->getDownloadLink(); ?>">
          <?php 
// Show If File Exists (region1)
if (tNG_fileExists("../Firma_digital/signed/", "{RsInfoCert.sign_file}")) {
?>
            <img src="icons/informe.png" width="48" height="48" border="0" />
            <?php } 
// EndIf File Exists (region1)
?></a></td>
        <td width="23%">Certificado de recibo a satisfacción</td>
        <td width="43%"><a href="<?php echo $downloadObj3->getDownloadLink(); ?>">
          <?php 
// Show If File Exists (region2)
if (tNG_fileExists("../Firma_digital/signed/certfirmados/", "{RsInfoCert.cert_file}")) {
?>
            <img src="icons/crs.png" width="48" height="48" border="0" />
            <?php } 
// EndIf File Exists (region2)
?></a></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4"><table width="100%" border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td colspan="8" class="ui-state-default" align="center">SISTEMA SEGURIDAD SOCIAL INTEGRAL Y ARL</td>
          </tr>
          <tr>
            <td class="ui-state-default"> BASE 40 %</td>
            <td class="ui-state-default">SALUD</td>
            <td class="ui-state-default">PENSION</td>
            <td class="ui-state-default">FONDO DE SOLIDARIDAD PENSIONAL</td>
            <td class="ui-state-default">RIESGOS LABORALES ARL</td>
            <td class="ui-state-default">TOTAL A PAGAR</td>
            <td class="ui-state-default">VALOR PAGADO</td>
            <td class="ui-state-default">DIFERENCIA</td>
          </tr>
          
                <tr><td class="ui-state-highlight" align="center"><?php echo number_format((($row_RsInfoNominaBase['cont_valormensual']*40)/100),0,'.',','); ?></td>
            <td class="ui-state-highlight" align="right"><?php echo number_format($row_RsInfoNominaBase['salud'],0,'.',','); ?></td>
            <td class="ui-state-highlight" align="right"><?php echo number_format($row_RsInfoNominaBase['PENSION'],0,'.',','); ?></td>
            <td class="ui-state-highlight" align="right"><?php echo number_format($row_RsInfoNominaBase['SOLID'],0,'.',','); ?></td>
            <td class="ui-state-highlight" align="right"><?php echo number_format($row_RsInfoNominaBase['ARL'],0,'.',','); ?></td>
            <td class="ui-state-highlight" align="right"><?php echo number_format(($row_RsInfoNominaBase['salud'] + $row_RsInfoNominaBase['PENSION'] + $row_RsInfoNominaBase['SOLID'] + $row_RsInfoNominaBase['ARL']),0,'.',','); ?></td>
            <td class="ui-state-highlight" align="right"><?php echo $row_RsInfoCert['cxc_planillavalor']; ?></td>
            <td class="ui-state-highlight" align="right"><?php echo number_format(($row_RsInfoCert['cxc_planillavalor']-($row_RsInfoNominaBase['salud'] + $row_RsInfoNominaBase['PENSION'] + $row_RsInfoNominaBase['SOLID'] + $row_RsInfoNominaBase['ARL'])),0,'.',','); ?></td>
          </tr>
         
        </table></td>
      </tr>
      <tr>
        <td>Anexos</td>
        <td colspan="3"><table width="100%" border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td class="ui-state-default">ANEXO</td>
            <td class="ui-state-default">DESCARGAR</td>
          </tr>
          <?php do { ?>
            <tr>
              <td class="ui-state-highlight"><?php echo $row_RsAnexosList['anexo_titulo']; ?></td>
              <td class="ui-state-highlight"><a href="<?php echo $downloadObj1->getDownloadLink(); ?>"><?php echo $row_RsAnexosList['anexo_file']; ?></a></td>
            </tr>
            <?php } while ($row_RsAnexosList = mysql_fetch_assoc($RsAnexosList)); ?>
        </table>
          <table width="100%" border="0" cellspacing="2" cellpadding="2">
            <tr>
              <td class="ui-state-default">OTROS ANEXOS</td>
              <td class="ui-state-default">DESCARGAR</td>
            </tr>
            <tr>
              <td class="ui-state-highlight"><?php echo $row_RsAttachMaster['anexos_name']; ?></td>
              <td class="ui-state-highlight"><a href="<?php echo $downloadObj5->getDownloadLink(); ?>"><?php echo $row_RsAttachMaster['att_doc']; ?></a></td>
            </tr>
          </table>
        <p>&nbsp;</p></td>
      </tr>
      <tr>
        <td colspan="4">&nbsp;Recibido por: <?php echo $row_RsInfoCert['sys_radicauser']; ?><br />
          Fecha de recibo:<?php echo $row_RsInfoCert['sys_radicadate']; ?></td>
      </tr>
    </table>
</div>
</body>
</html>
<?php
mysql_free_result($RsInfoCert);

mysql_free_result($RsAnexosList);

mysql_free_result($RsInfoNominaBase);

mysql_free_result($RsPeriodoNomina);

mysql_free_result($RsAnexosCont);

mysql_free_result($RsAttachMaster);
?>
