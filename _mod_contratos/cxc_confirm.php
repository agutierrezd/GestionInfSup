<?php require_once('../Connections/oConnContratos.php'); ?>
<?php require_once('../Connections/oConnAlmacen.php'); ?>
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

$colname_RsInfoAlmacen = "-1";
if (isset($_GET['difuncionario'])) {
  $colname_RsInfoAlmacen = $_GET['difuncionario'];
}
mysql_select_db($database_oConnAlmacen, $oConnAlmacen);
$query_RsInfoAlmacen = sprintf("SELECT * FROM aldevindiv WHERE difuncionario = %s", GetSQLValueString($colname_RsInfoAlmacen, "text"));
$RsInfoAlmacen = mysql_query($query_RsInfoAlmacen, $oConnAlmacen) or die(mysql_error());
$row_RsInfoAlmacen = mysql_fetch_assoc($RsInfoAlmacen);
$totalRows_RsInfoAlmacen = mysql_num_rows($RsInfoAlmacen);

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
	<h2>Recibo de cuenta de cobro para pago de honorarios para el certificado No. <?php echo $row_RsInfoCert['inf_hash_fk']; ?></h2>
    <table width="100%" border="0" cellspacing="2" cellpadding="2">
      <tr>
        <td width="12%">Contratista:</td>
        <td colspan="5"><?php echo $row_RsInfoCert['cxc_razonsocial']; ?></td>
      </tr>
      <tr>
        <td>Contrato</td>
        <td><?php echo $row_RsInfoCert['cxc_cont']; ?> de <?php echo $row_RsInfoCert['cxc_anio']; ?></td>
        <td colspan="4"><table width="100%" border="0" cellspacing="2" cellpadding="2">
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
        <td colspan="5"><?php echo number_format($row_RsInfoNominaBase['cont_valormensual'],0,'.',','); ?></td>
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
        <td width="21%"><a href="<?php echo $downloadObj3->getDownloadLink(); ?>">
          <?php 
// Show If File Exists (region2)
if (tNG_fileExists("../Firma_digital/signed/certfirmados/", "{RsInfoCert.cert_file}")) {
?>
            <img src="icons/crs.png" width="48" height="48" border="0" />
        <?php } 
// EndIf File Exists (region2)
?></a></td>
        <td width="22%">Inventario:</td>
        <td width="43%"><h2><?php echo $totalRows_RsInfoAlmacen; ?> Elementos asignados</h2></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="5">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="6"><table width="100%" border="0" cellspacing="2" cellpadding="2">
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
        <td colspan="5"><table width="100%" border="0" cellspacing="2" cellpadding="2">
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
        </table></td>
      </tr>
      <tr>
        <td colspan="6">&nbsp;
          <?php
	echo $tNGs->getErrorMsg();
?>
          <div class="KT_tng">
            <h1>&nbsp;</h1>
            <div class="KT_tngform">
              <?php 
// Show IF Conditional region5 
if (@$row_RsPeriodoNomina['CTRLFECHA'] == 1) {
?>
              <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
                <?php $cnt1 = 0; ?>
                <?php do { ?>
                    <?php $cnt1++; ?>
                    <?php 
// Show IF Conditional region3 
if (@$totalRows_rsinforme_intersup_cxc > 1) {
?>
                      <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
                    <?php } 
// endif Conditional region3
?>
                    <table cellpadding="2" cellspacing="0" class="KT_tngtable">
                      <tr>
                        <td colspan="2" class="KT_th"><input name="sys_status_<?php echo $cnt1; ?>" type="hidden" id="sys_status_<?php echo $cnt1; ?>" value="9" />
                          <?php echo $tNGs->displayFieldHint("sys_status");?> <?php echo $tNGs->displayFieldError("informe_intersup_cxc", "sys_status", $cnt1); ?> <input name="sys_radicauser_<?php echo $cnt1; ?>" type="hidden" id="sys_radicauser_<?php echo $cnt1; ?>" value="<?php echo $_SESSION['kt_login_user']; ?>" />
                          <?php echo $tNGs->displayFieldHint("sys_radicauser");?> <?php echo $tNGs->displayFieldError("informe_intersup_cxc", "sys_radicauser", $cnt1); ?> <input name="sys_radicadate_<?php echo $cnt1; ?>" type="hidden" id="sys_radicadate_<?php echo $cnt1; ?>" value="<?php echo $fecha; ?>" />
                          <?php echo $tNGs->displayFieldHint("sys_radicadate");?> <?php echo $tNGs->displayFieldError("informe_intersup_cxc", "sys_radicadate", $cnt1); ?> <input name="sys_radicatime_<?php echo $cnt1; ?>" type="hidden" id="sys_radicatime_<?php echo $cnt1; ?>" value="<?php echo $hora; ?>" />
                        <?php echo $tNGs->displayFieldHint("sys_radicatime");?> <?php echo $tNGs->displayFieldError("informe_intersup_cxc", "sys_radicatime", $cnt1); ?> </td>
                      </tr>
                      
                      <tr>
                        <td width="34%" class="KT_th"><label for="sys_radicaperiodo_<?php echo $cnt1; ?>">Seleccione el periodo para pago masivo:<br />
                        Fecha límite para recepción de certificaciones:&nbsp;<span class="ui-state-error-text"><?php echo $row_RsPeriodoNomina['nomina_fechalimite']; ?></span></label></td>
                        <td width="66%"><select name="sys_radicaperiodo_<?php echo $cnt1; ?>" id="sys_radicaperiodo_<?php echo $cnt1; ?>">
                            <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                            <?php 
do {  
?>
                            <option value="<?php echo $row_RsPeriodoNomina['nomina_periodo']?>"<?php if (!(strcmp($row_RsPeriodoNomina['nomina_periodo'], $row_rsinforme_intersup_cxc['sys_radicaperiodo']))) {echo "SELECTED";} ?>><?php echo $row_RsPeriodoNomina['nomina_periodo']?></option>
                            <?php
} while ($row_RsPeriodoNomina = mysql_fetch_assoc($RsPeriodoNomina));
  $rows = mysql_num_rows($RsPeriodoNomina);
  if($rows > 0) {
      mysql_data_seek($RsPeriodoNomina, 0);
	  $row_RsPeriodoNomina = mysql_fetch_assoc($RsPeriodoNomina);
  }
?>
                          </select>
                            <?php echo $tNGs->displayFieldError("informe_intersup_cxc", "sys_radicaperiodo", $cnt1); ?> </td>
                      </tr>
                    </table>
                    <input type="hidden" name="kt_pk_informe_intersup_cxc_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rsinforme_intersup_cxc['kt_pk_informe_intersup_cxc']); ?>" />
                    <?php } while ($row_rsinforme_intersup_cxc = mysql_fetch_assoc($rsinforme_intersup_cxc)); ?>
                <div class="KT_bottombuttons">
                  <div>
                    <?php 
      // Show IF Conditional region3
      if (@$_GET['cxc_id'] == "") {
      ?>
                        <input type="submit" name="KT_Insert1" id="KT_Insert1" value="Grabar registro" />
                        <?php 
      // else Conditional region3
      } else { ?>
                        <input type="submit" name="KT_Update1" value="Grabar registro" />
                        <?php }
      // endif Conditional region3
      ?>
                  </div>
                </div>
              </form>
                <?php 
// else Conditional region5
} else { ?>
                la fecha límite para recepción de certificaciones estaba programada hasta:&nbsp;<span class="ui-state-error-text"><?php echo $row_RsPeriodoNomina['nomina_fechalimite']; ?></span>
  <?php } 
// endif Conditional region5
?></div>
            <br class="clearfixplain" />
                    </div>          <p>&nbsp;</p></td>
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

mysql_free_result($RsInfoAlmacen);
?>
