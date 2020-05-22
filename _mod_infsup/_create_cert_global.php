<?php require_once('../Connections/oConnContratos.php'); ?>
<?php
//MX Widgets3 include
require_once('../includes/wdg/WDG.php');
?>
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
$formValidation->addField("inf_id_fk", true, "numeric", "", "", "", "");
$formValidation->addField("inf_hash_fk", true, "text", "", "", "", "");
$formValidation->addField("sign_hash_fk", true, "text", "", "", "", "");
$formValidation->addField("certpay_tipocontrato", true, "text", "", "", "", "");
$formValidation->addField("certpay_cont", true, "text", "", "", "", "");
$formValidation->addField("certpay_anio", true, "date", "", "", "", "");
$formValidation->addField("certpay_razonsocial", true, "text", "", "", "", "");
$formValidation->addField("certpay_tipodoc", true, "text", "", "", "", "");
$formValidation->addField("certpay_numdoc", true, "text", "", "", "", "");
$formValidation->addField("certpay_objeto", true, "text", "", "", "", "");
$formValidation->addField("certpay_periodoi", true, "date", "", "", "", "");
$formValidation->addField("certpay_periodof", true, "date", "", "", "", "");
$formValidation->addField("certpay_valor", true, "double", "", "", "", "Ingrese el valor a cancelar");
$formValidation->addField("certpay_fechaelab", true, "date", "date", "", "", "");
$formValidation->addField("sup_name", true, "text", "", "", "", "");
$formValidation->addField("sup_cargo", true, "text", "", "", "", "");
$formValidation->addField("sup_dep", true, "text", "", "", "", "");
$formValidation->addField("sys_user", true, "text", "", "", "", "");
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

$colname_rsinformesreg = "-1";
if (isset($_GET['inf_id'])) {
  $colname_rsinformesreg = $_GET['inf_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rsinformesreg = sprintf("SELECT * FROM q_genera_cert WHERE inf_id = %s", GetSQLValueString($colname_rsinformesreg, "int"));
$rsinformesreg = mysql_query($query_rsinformesreg, $oConnContratos) or die(mysql_error());
$row_rsinformesreg = mysql_fetch_assoc($rsinformesreg);
$totalRows_rsinformesreg = mysql_num_rows($rsinformesreg);

$colname_Rsverifica = "-1";
if (isset($_GET['inf_id'])) {
  $colname_Rsverifica = $_GET['inf_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_Rsverifica = sprintf("SELECT * FROM informe_intersup_global WHERE inf_id_fk = %s", GetSQLValueString($colname_Rsverifica, "int"));
$Rsverifica = mysql_query($query_Rsverifica, $oConnContratos) or die(mysql_error());
$row_Rsverifica = mysql_fetch_assoc($Rsverifica);
$totalRows_Rsverifica = mysql_num_rows($Rsverifica);

$colname_RsContratoReg = "-1";
if (isset($_GET['id_cont'])) {
  $colname_RsContratoReg = $_GET['id_cont'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_RsContratoReg = sprintf("SELECT * FROM q_001_dashboard WHERE id_cont = %s", GetSQLValueString($colname_RsContratoReg, "int"));
$RsContratoReg = mysql_query($query_RsContratoReg, $oConnContratos) or die(mysql_error());
$row_RsContratoReg = mysql_fetch_assoc($RsContratoReg);
$totalRows_RsContratoReg = mysql_num_rows($RsContratoReg);

// Make an insert transaction instance
$ins_informe_intersup_global = new tNG_multipleInsert($conn_oConnContratos);
$tNGs->addTransaction($ins_informe_intersup_global);
// Register triggers
$ins_informe_intersup_global->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_informe_intersup_global->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_informe_intersup_global->registerTrigger("END", "Trigger_Default_Redirect", 99, "x_transact.php?inf_id={GET.inf_id}");
// Add columns
$ins_informe_intersup_global->setTable("informe_intersup_global");
$ins_informe_intersup_global->addColumn("inf_id_fk", "NUMERIC_TYPE", "POST", "inf_id_fk");
$ins_informe_intersup_global->addColumn("inf_hash_fk", "STRING_TYPE", "POST", "inf_hash_fk");
$ins_informe_intersup_global->addColumn("sign_hash_fk", "STRING_TYPE", "POST", "sign_hash_fk");
$ins_informe_intersup_global->addColumn("certpay_tipocontrato", "STRING_TYPE", "POST", "certpay_tipocontrato");
$ins_informe_intersup_global->addColumn("certpay_cont", "STRING_TYPE", "POST", "certpay_cont");
$ins_informe_intersup_global->addColumn("certpay_anio", "DATE_TYPE", "POST", "certpay_anio");
$ins_informe_intersup_global->addColumn("certpay_razonsocial", "STRING_TYPE", "POST", "certpay_razonsocial");
$ins_informe_intersup_global->addColumn("certpay_tipodoc", "STRING_TYPE", "POST", "certpay_tipodoc");
$ins_informe_intersup_global->addColumn("certpay_numdoc", "STRING_TYPE", "POST", "certpay_numdoc");
$ins_informe_intersup_global->addColumn("certpay_objeto", "STRING_TYPE", "POST", "certpay_objeto");
$ins_informe_intersup_global->addColumn("certpay_periodoi", "DATE_TYPE", "POST", "certpay_periodoi");
$ins_informe_intersup_global->addColumn("certpay_periodof", "DATE_TYPE", "POST", "certpay_periodof");
$ins_informe_intersup_global->addColumn("certpay_obs", "STRING_TYPE", "POST", "certpay_obs");
$ins_informe_intersup_global->addColumn("certpay_valor", "DOUBLE_TYPE", "POST", "certpay_valor");
$ins_informe_intersup_global->addColumn("certpay_fechaelab", "DATE_TYPE", "POST", "certpay_fechaelab");
$ins_informe_intersup_global->addColumn("sup_name", "STRING_TYPE", "POST", "sup_name");
$ins_informe_intersup_global->addColumn("sup_cargo", "STRING_TYPE", "POST", "sup_cargo");
$ins_informe_intersup_global->addColumn("sup_dep", "STRING_TYPE", "POST", "sup_dep");
$ins_informe_intersup_global->addColumn("sys_user", "STRING_TYPE", "POST", "sys_user");
$ins_informe_intersup_global->setPrimaryKey("certpay_id", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_informe_intersup_global = new tNG_multipleUpdate($conn_oConnContratos);
$tNGs->addTransaction($upd_informe_intersup_global);
// Register triggers
$upd_informe_intersup_global->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_informe_intersup_global->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_informe_intersup_global->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$upd_informe_intersup_global->setTable("informe_intersup_global");
$upd_informe_intersup_global->addColumn("inf_id_fk", "NUMERIC_TYPE", "POST", "inf_id_fk");
$upd_informe_intersup_global->addColumn("inf_hash_fk", "STRING_TYPE", "POST", "inf_hash_fk");
$upd_informe_intersup_global->addColumn("sign_hash_fk", "STRING_TYPE", "POST", "sign_hash_fk");
$upd_informe_intersup_global->addColumn("certpay_tipocontrato", "STRING_TYPE", "POST", "certpay_tipocontrato");
$upd_informe_intersup_global->addColumn("certpay_cont", "STRING_TYPE", "POST", "certpay_cont");
$upd_informe_intersup_global->addColumn("certpay_anio", "DATE_TYPE", "POST", "certpay_anio");
$upd_informe_intersup_global->addColumn("certpay_razonsocial", "STRING_TYPE", "POST", "certpay_razonsocial");
$upd_informe_intersup_global->addColumn("certpay_tipodoc", "STRING_TYPE", "POST", "certpay_tipodoc");
$upd_informe_intersup_global->addColumn("certpay_numdoc", "STRING_TYPE", "POST", "certpay_numdoc");
$upd_informe_intersup_global->addColumn("certpay_objeto", "STRING_TYPE", "POST", "certpay_objeto");
$upd_informe_intersup_global->addColumn("certpay_periodoi", "DATE_TYPE", "POST", "certpay_periodoi");
$upd_informe_intersup_global->addColumn("certpay_periodof", "DATE_TYPE", "POST", "certpay_periodof");
$upd_informe_intersup_global->addColumn("certpay_obs", "STRING_TYPE", "POST", "certpay_obs");
$upd_informe_intersup_global->addColumn("certpay_valor", "DOUBLE_TYPE", "POST", "certpay_valor");
$upd_informe_intersup_global->addColumn("certpay_fechaelab", "DATE_TYPE", "POST", "certpay_fechaelab");
$upd_informe_intersup_global->addColumn("sup_name", "STRING_TYPE", "POST", "sup_name");
$upd_informe_intersup_global->addColumn("sup_cargo", "STRING_TYPE", "POST", "sup_cargo");
$upd_informe_intersup_global->addColumn("sup_dep", "STRING_TYPE", "POST", "sup_dep");
$upd_informe_intersup_global->addColumn("sys_user", "STRING_TYPE", "POST", "sys_user");
$upd_informe_intersup_global->setPrimaryKey("certpay_id", "NUMERIC_TYPE", "GET", "certpay_id");

// Make an instance of the transaction object
$del_informe_intersup_global = new tNG_multipleDelete($conn_oConnContratos);
$tNGs->addTransaction($del_informe_intersup_global);
// Register triggers
$del_informe_intersup_global->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_informe_intersup_global->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$del_informe_intersup_global->setTable("informe_intersup_global");
$del_informe_intersup_global->setPrimaryKey("certpay_id", "NUMERIC_TYPE", "GET", "certpay_id");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsinforme_intersup_global = $tNGs->getRecordset("informe_intersup_global");
$row_rsinforme_intersup_global = mysql_fetch_assoc($rsinforme_intersup_global);
$totalRows_rsinforme_intersup_global = mysql_num_rows($rsinforme_intersup_global);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:wdg="http://ns.adobe.com/addt">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
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
  show_as_grid: false,
  merge_down_value: false
}
</script>
<script type="text/javascript" src="../includes/common/js/sigslot_core.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="../includes/wdg/classes/Calendar.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/SmartDate.js"></script>
<script type="text/javascript" src="../includes/wdg/calendar/calendar_stripped.js"></script>
<script type="text/javascript" src="../includes/wdg/calendar/calendar-setup_stripped.js"></script>
<script src="../includes/resources/calendar.js"></script>
</head>

<body>
<?php if ($totalRows_Rsverifica > 0) { // Show if recordset not empty ?>
  <table width="100%" border="0" cellspacing="2" cellpadding="0">
    <tr>
      <td>La certificación ya fue generada, ¿desea modificarla?</td>
    </tr>
    <tr>
      <td><a href="_update_cert.php?certpay_id=<?php echo $row_Rsverifica['certpay_id']; ?>&amp;inf_id=<?php echo $row_Rsverifica['inf_id_fk']; ?>">Modificar certificación</a></td>
    </tr>
  </table>
  <?php } // Show if recordset not empty ?>

<?php if ($totalRows_Rsverifica == 0) { // Show if recordset empty ?>
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="2">
    <tr>
      <td>&nbsp;
        <?php
	echo $tNGs->getErrorMsg();
?>
        <div class="KT_tng">
          <div class="KT_tngform">
            <form method="post" id="form2" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
              <?php $cnt1 = 0; ?>
              <?php do { ?>
                <?php $cnt1++; ?>
                <?php 
// Show IF Conditional region1 
if (@$totalRows_rsinforme_intersup_global > 1) {
?>
                  <?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?>
                  <?php } 
// endif Conditional region1
?>
                <p align="center"><strong>EL  SUSCRITO SUPERVISOR DEL CONTRATO ESTATAL DE PRESTACIÓN DE SERVICIOS </strong><br />
                  <strong>No.  <?php echo $row_rsinformesreg['CONTRATOID']; ?> de <?php echo $row_rsinformesreg['VIGENCIA']; ?></strong>
                  <input name="inf_id_fk_<?php echo $cnt1; ?>" type="text" id="inf_id_fk_<?php echo $cnt1; ?>" value="<?php echo $row_RsContratoReg['id_cont']; ?>" />
                  <input name="inf_hash_fk_<?php echo $cnt1; ?>" type="text" id="inf_hash_fk_<?php echo $cnt1; ?>" value="<?php echo $row_RsContratoReg['cont_hash']; ?>" size="10" maxlength="10" />
                  <input name="sign_hash_fk_<?php echo $cnt1; ?>" type="text" id="sign_hash_fk_<?php echo $cnt1; ?>" value="<?php echo $row_RsContratoReg['cont_hash']; ?>" size="20" maxlength="20" />
                  </p>
                <p>&nbsp;</p>
                <p>Por medio de la  presente certifico que recibí el servicio, en desarrollo del <strong>
                  <input name="certpay_tipocontrato_<?php echo $cnt1; ?>" type="text" id="certpay_tipocontrato_<?php echo $cnt1; ?>" value="<?php echo strtoupper($row_rsinformesreg['nom_tipocontrato']); ?>" size="60" maxlength="150" readonly="true" />
                  No. 
                  <input name="certpay_cont_<?php echo $cnt1; ?>" type="text" id="certpay_cont_<?php echo $cnt1; ?>" value="<?php echo $row_rsinformesreg['CONTRATOID']; ?>" size="10" maxlength="10" readonly="true" />
                  de
                  <input name="certpay_anio_<?php echo $cnt1; ?>" type="text" id="certpay_anio_<?php echo $cnt1; ?>" value="<?php echo $row_rsinformesreg['VIGENCIA']; ?>" size="10" maxlength="22" readonly="true" />
                  </strong>suscrito entre La Nación-Ministerio de Comercio,  Industria y Turismo y 
                  <input name="certpay_razonsocial_<?php echo $cnt1; ?>" type="text" id="certpay_razonsocial_<?php echo $cnt1; ?>" value="<?php echo $row_rsinformesreg['contractor_name']; ?>" size="60" maxlength="150" readonly="true" />
                  identificado(a) con 
                  <input name="certpay_tipodoc_<?php echo $cnt1; ?>" type="text" id="certpay_tipodoc_<?php echo $cnt1; ?>" value="<?php echo $row_rsinformesreg['contractor_type']; ?>" size="32" maxlength="50" readonly="true" />
                  No. 
                  <input name="certpay_numdoc_<?php echo $cnt1; ?>" type="text" id="certpay_numdoc_<?php echo $cnt1; ?>" value="<?php echo $row_rsinformesreg['DOCID']; ?>" size="32" maxlength="50" readonly="true" />
                  ,  cuyo objeto es: ”<?php echo $row_rsinformesreg['cont_objeto']; ?>”
                  <input name="certpay_objeto_<?php echo $cnt1; ?>" type="hidden" id="certpay_objeto_<?php echo $cnt1; ?>" value="<?php echo $row_rsinformesreg['cont_objeto']; ?>" /> 
                  El contratista cumplió a satisfacción de conformidad con las  Obligaciones establecidas durante el periodo del 
                  <input name="certpay_periodoi_<?php echo $cnt1; ?>" id="certpay_periodoi_<?php echo $cnt1; ?>" value="<?php echo $row_RsContratoReg['FECHAI']; ?>" size="10" maxlength="22" readonly="true" wdg:mondayfirst="false" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:type="widget" wdg:singleclick="true" wdg:restricttomask="yes" />
                  al 
                  <input name="certpay_periodof_<?php echo $cnt1; ?>" id="certpay_periodof_<?php echo $cnt1; ?>" value="<?php echo $row_RsContratoReg['FECHAF']; ?>" size="10" maxlength="22" readonly="true" wdg:mondayfirst="false" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:type="widget" wdg:singleclick="true" wdg:restricttomask="yes" />
                .</p>
                <p>Que teniendo en cuenta lo  anterior, el contrato se realizó por la suma de  
                  <input name="certpay_valor_<?php echo $cnt1; ?>" type="text" id="certpay_valor_<?php echo $cnt1; ?>" value="<?php echo $row_RsContratoReg['VALORI']; ?>" size="15" />
                  por parte del Ministerio de Comercio,  Industria y Turismo.</p>
                <p>Si existen comentarios adicionales para la elaboración de la certificación, escríbalas en la siguiente casilla, de lo contrario déjela en blanco<br />
                  <textarea name="certpay_obs_<?php echo $cnt1; ?>" cols="50" rows="5" id="certpay_obs_<?php echo $cnt1; ?>"><?php echo KT_escapeAttribute($row_rsinforme_intersup_global['certpay_obs']); ?></textarea>
                  </p>
                <p>Dada  en Bogotá D.C., en la fecha 
                  <input name="certpay_fechaelab_<?php echo $cnt1; ?>" id="certpay_fechaelab_<?php echo $cnt1; ?>" value="<?php echo $fecha; ?>" size="10" maxlength="22" wdg:mondayfirst="false" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:type="widget" wdg:singleclick="true" wdg:restricttomask="yes" />
                  .</p>
                <p>Cordialmente,</p>
                <p>&nbsp;</p>
                <p><strong>
                  <input name="sup_name_<?php echo $cnt1; ?>" type="text" id="sup_name_<?php echo $cnt1; ?>" value="<?php echo $row_rsinformesreg['inf_nombre']; ?>" size="60" maxlength="255" />
                  <br />
                </strong><strong>
                  <input name="sup_cargo_<?php echo $cnt1; ?>" type="text" id="sup_cargo_<?php echo $cnt1; ?>" value="<?php echo $row_rsinformesreg['inf_cargo']; ?>" size="32" maxlength="255" />
                  </strong><br />
                  <strong>
                  <input name="sup_dep_<?php echo $cnt1; ?>" type="text" id="sup_dep_<?php echo $cnt1; ?>" value="<?php echo $row_rsinformesreg['inf_dependencia']; ?>" size="80" maxlength="255" />
                  </strong>
                  <input name="sys_user_<?php echo $cnt1; ?>" type="text" id="sys_user_<?php echo $cnt1; ?>" value="<?php echo $_SESSION['kt_login_user']; ?>" />
                  </p>
                <input type="hidden" name="kt_pk_informe_intersup_global_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rsinforme_intersup_global['kt_pk_informe_intersup_global']); ?>" />
                <?php } while ($row_rsinforme_intersup_global = mysql_fetch_assoc($rsinforme_intersup_global)); ?>
              <div class="KT_bottombuttons">
                <div>
                  <?php 
      // Show IF Conditional region1
      if (@$_GET['certpay_id'] == "") {
      ?>
                    <input type="submit" name="KT_Insert1" id="KT_Insert1" value="Crear certificación" />
                    <?php 
      // else Conditional region1
      } else { ?>
                    <input type="submit" name="KT_Update1" value="<?php echo NXT_getResource("Update_FB"); ?>" />
                    <input type="submit" name="KT_Delete1" value="<?php echo NXT_getResource("Delete_FB"); ?>" onclick="return confirm('<?php echo NXT_getResource("Are you sure?"); ?>');" />
                    <?php }
      // endif Conditional region1
      ?>
                </div>
              </div>
            </form>
          </div>
          <br class="clearfixplain" />
      </div>        <p>&nbsp;</p></td>
    </tr>
  </table>
  <?php } // Show if recordset empty ?>
</body>
</html>
<?php
mysql_free_result($rsinformesreg);

mysql_free_result($Rsverifica);

mysql_free_result($RsContratoReg);
?>
