<?php require_once('../Connections/oConnContratos.php'); ?>
<?php require_once('../Connections/oConConfig.php'); ?>
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
$conn_oConConfig = new KT_connection($oConConfig, $database_oConConfig);

// Start trigger
$formValidation = new tNG_FormValidation();
$formValidation->addField("id_cont_fk", true, "numeric", "", "", "", "");
$formValidation->addField("inf_consecutivo", true, "numeric", "", "", "", "");
$formValidation->addField("inf_hash", true, "text", "", "", "", "");
$formValidation->addField("inf_estado", true, "numeric", "", "", "", "");
$formValidation->addField("inf_fechapresenta", true, "date", "", "", "", "");
$formValidation->addField("inf_periodicidad", true, "numeric", "", "", "", "");
$formValidation->addField("inf_fecharep_i", true, "date", "", "", "", "");
$formValidation->addField("inf_fecharep_f", true, "date", "", "", "", "");
$formValidation->addField("inf_numerocontrato", true, "text", "", "", "", "");
$formValidation->addField("inf_doccontratista", true, "text", "", "", "", "");
$formValidation->addField("inf_nombrecontratista", true, "text", "", "", "", "");
$formValidation->addField("inf_valorcontrato", true, "double", "", "", "", "");
$formValidation->addField("inf_cdp", true, "text", "", "", "", "");
$formValidation->addField("inf_rp", true, "text", "", "", "", "");
$formValidation->addField("inf_rubrocode", true, "text", "", "", "", "");
$formValidation->addField("inf_rubroname", true, "text", "", "", "", "");
$formValidation->addField("inf_objeto", true, "text", "", "", "", "");
$formValidation->addField("inf_fechasuscripcion", true, "date", "", "", "", "");
$formValidation->addField("inf_fechacont_i", true, "date", "", "", "", "");
$formValidation->addField("inf_fechacont_f", true, "date", "", "", "", "");
$formValidation->addField("inf_plazo", true, "text", "", "", "", "");
$formValidation->addField("inf_vigencia", true, "text", "", "", "", "");
$formValidation->addField("inf_intersup", true, "text", "", "", "", "");
$formValidation->addField("inf_nombre", true, "text", "", "", "", "");
$formValidation->addField("inf_cargo", true, "text", "", "", "", "");
$formValidation->addField("inf_dependencia", true, "text", "", "", "", "");
$formValidation->addField("inf_avgejecucion", true, "double", "", "", "", "");
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

$colname_rsnumeroinforme = "-1";
if (isset($_GET['doc_id'])) {
  $colname_rsnumeroinforme = $_GET['doc_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rsnumeroinforme = sprintf("SELECT * FROM q_informe_contador WHERE id_cont_fk = %s", GetSQLValueString($colname_rsnumeroinforme, "int"));
$rsnumeroinforme = mysql_query($query_rsnumeroinforme, $oConnContratos) or die(mysql_error());
$row_rsnumeroinforme = mysql_fetch_assoc($rsnumeroinforme);
$totalRows_rsnumeroinforme = mysql_num_rows($rsnumeroinforme);

$colname_rsfechavence = "-1";
if (isset($_GET['doc_id'])) {
  $colname_rsfechavence = $_GET['doc_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rsfechavence = sprintf("SELECT * FROM q_informe_f1 WHERE id_cont = %s", GetSQLValueString($colname_rsfechavence, "int"));
$rsfechavence = mysql_query($query_rsfechavence, $oConnContratos) or die(mysql_error());
$row_rsfechavence = mysql_fetch_assoc($rsfechavence);
$totalRows_rsfechavence = mysql_num_rows($rsfechavence);

$colname_rssupervisor = "-1";
if (isset($_GET['doc_id'])) {
  $colname_rssupervisor = $_GET['doc_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rssupervisor = sprintf("SELECT * FROM q_global_supervisores WHERE id_cont_fk = %s AND sup_status = '1'", GetSQLValueString($colname_rssupervisor, "int"));
$rssupervisor = mysql_query($query_rssupervisor, $oConnContratos) or die(mysql_error());
$row_rssupervisor = mysql_fetch_assoc($rssupervisor);
$totalRows_rssupervisor = mysql_num_rows($rssupervisor);

$colname_rsnumeroinformes2 = "-1";
if (isset($_GET['doc_id'])) {
  $colname_rsnumeroinformes2 = $_GET['doc_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rsnumeroinformes2 = sprintf("SELECT * FROM q_informe_f2 WHERE id_cont_fk = %s", GetSQLValueString($colname_rsnumeroinformes2, "int"));
$rsnumeroinformes2 = mysql_query($query_rsnumeroinformes2, $oConnContratos) or die(mysql_error());
$row_rsnumeroinformes2 = mysql_fetch_assoc($rsnumeroinformes2);
$totalRows_rsnumeroinformes2 = mysql_num_rows($rsnumeroinformes2);

// Make an insert transaction instance
$ins_informe_intersup = new tNG_multipleInsert($conn_oConConfig);
$tNGs->addTransaction($ins_informe_intersup);
// Register triggers
$ins_informe_intersup->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_informe_intersup->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_informe_intersup->registerTrigger("END", "Trigger_Default_Redirect", 99, "ok_a.php");
// Add columns
$ins_informe_intersup->setTable("informe_intersup");
$ins_informe_intersup->addColumn("id_cont_fk", "NUMERIC_TYPE", "POST", "id_cont_fk");
$ins_informe_intersup->addColumn("inf_consecutivo", "NUMERIC_TYPE", "POST", "inf_consecutivo");
$ins_informe_intersup->addColumn("inf_hash", "STRING_TYPE", "POST", "inf_hash");
$ins_informe_intersup->addColumn("inf_estado", "NUMERIC_TYPE", "POST", "inf_estado");
$ins_informe_intersup->addColumn("inf_fechapresenta", "DATE_TYPE", "POST", "inf_fechapresenta");
$ins_informe_intersup->addColumn("inf_periodicidad", "NUMERIC_TYPE", "POST", "inf_periodicidad");
$ins_informe_intersup->addColumn("inf_fecharep_i", "DATE_TYPE", "POST", "inf_fecharep_i");
$ins_informe_intersup->addColumn("inf_fecharep_f", "DATE_TYPE", "POST", "inf_fecharep_f");
$ins_informe_intersup->addColumn("inf_numerocontrato", "STRING_TYPE", "POST", "inf_numerocontrato");
$ins_informe_intersup->addColumn("inf_doccontratista", "STRING_TYPE", "POST", "inf_doccontratista");
$ins_informe_intersup->addColumn("inf_nombrecontratista", "STRING_TYPE", "POST", "inf_nombrecontratista");
$ins_informe_intersup->addColumn("inf_valorcontrato", "DOUBLE_TYPE", "POST", "inf_valorcontrato");
$ins_informe_intersup->addColumn("inf_cdp", "STRING_TYPE", "POST", "inf_cdp");
$ins_informe_intersup->addColumn("inf_rp", "STRING_TYPE", "POST", "inf_rp");
$ins_informe_intersup->addColumn("inf_rubrocode", "STRING_TYPE", "POST", "inf_rubrocode");
$ins_informe_intersup->addColumn("inf_rubroname", "STRING_TYPE", "POST", "inf_rubroname");
$ins_informe_intersup->addColumn("inf_objeto", "STRING_TYPE", "POST", "inf_objeto");
$ins_informe_intersup->addColumn("inf_fechasuscripcion", "DATE_TYPE", "POST", "inf_fechasuscripcion");
$ins_informe_intersup->addColumn("inf_fechacont_i", "DATE_TYPE", "POST", "inf_fechacont_i");
$ins_informe_intersup->addColumn("inf_fechacont_f", "DATE_TYPE", "POST", "inf_fechacont_f");
$ins_informe_intersup->addColumn("inf_plazo", "STRING_TYPE", "POST", "inf_plazo");
$ins_informe_intersup->addColumn("inf_vigencia", "STRING_TYPE", "POST", "inf_vigencia");
$ins_informe_intersup->addColumn("inf_intersup", "STRING_TYPE", "POST", "inf_intersup");
$ins_informe_intersup->addColumn("inf_nombre", "STRING_TYPE", "POST", "inf_nombre");
$ins_informe_intersup->addColumn("inf_cargo", "STRING_TYPE", "POST", "inf_cargo");
$ins_informe_intersup->addColumn("inf_dependencia", "STRING_TYPE", "POST", "inf_dependencia");
$ins_informe_intersup->addColumn("inf_avgejecucion", "DOUBLE_TYPE", "POST", "inf_avgejecucion");
$ins_informe_intersup->setPrimaryKey("inf_id", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_informe_intersup = new tNG_multipleUpdate($conn_oConConfig);
$tNGs->addTransaction($upd_informe_intersup);
// Register triggers
$upd_informe_intersup->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_informe_intersup->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_informe_intersup->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$upd_informe_intersup->setTable("informe_intersup");
$upd_informe_intersup->addColumn("id_cont_fk", "NUMERIC_TYPE", "POST", "id_cont_fk");
$upd_informe_intersup->addColumn("inf_consecutivo", "NUMERIC_TYPE", "POST", "inf_consecutivo");
$upd_informe_intersup->addColumn("inf_hash", "STRING_TYPE", "POST", "inf_hash");
$upd_informe_intersup->addColumn("inf_estado", "NUMERIC_TYPE", "POST", "inf_estado");
$upd_informe_intersup->addColumn("inf_fechapresenta", "DATE_TYPE", "POST", "inf_fechapresenta");
$upd_informe_intersup->addColumn("inf_periodicidad", "NUMERIC_TYPE", "POST", "inf_periodicidad");
$upd_informe_intersup->addColumn("inf_fecharep_i", "DATE_TYPE", "POST", "inf_fecharep_i");
$upd_informe_intersup->addColumn("inf_fecharep_f", "DATE_TYPE", "POST", "inf_fecharep_f");
$upd_informe_intersup->addColumn("inf_numerocontrato", "STRING_TYPE", "POST", "inf_numerocontrato");
$upd_informe_intersup->addColumn("inf_doccontratista", "STRING_TYPE", "POST", "inf_doccontratista");
$upd_informe_intersup->addColumn("inf_nombrecontratista", "STRING_TYPE", "POST", "inf_nombrecontratista");
$upd_informe_intersup->addColumn("inf_valorcontrato", "DOUBLE_TYPE", "POST", "inf_valorcontrato");
$upd_informe_intersup->addColumn("inf_cdp", "STRING_TYPE", "POST", "inf_cdp");
$upd_informe_intersup->addColumn("inf_rp", "STRING_TYPE", "POST", "inf_rp");
$upd_informe_intersup->addColumn("inf_rubrocode", "STRING_TYPE", "POST", "inf_rubrocode");
$upd_informe_intersup->addColumn("inf_rubroname", "STRING_TYPE", "POST", "inf_rubroname");
$upd_informe_intersup->addColumn("inf_objeto", "STRING_TYPE", "POST", "inf_objeto");
$upd_informe_intersup->addColumn("inf_fechasuscripcion", "DATE_TYPE", "POST", "inf_fechasuscripcion");
$upd_informe_intersup->addColumn("inf_fechacont_i", "DATE_TYPE", "POST", "inf_fechacont_i");
$upd_informe_intersup->addColumn("inf_fechacont_f", "DATE_TYPE", "POST", "inf_fechacont_f");
$upd_informe_intersup->addColumn("inf_plazo", "STRING_TYPE", "POST", "inf_plazo");
$upd_informe_intersup->addColumn("inf_vigencia", "STRING_TYPE", "POST", "inf_vigencia");
$upd_informe_intersup->addColumn("inf_intersup", "STRING_TYPE", "POST", "inf_intersup");
$upd_informe_intersup->addColumn("inf_nombre", "STRING_TYPE", "POST", "inf_nombre");
$upd_informe_intersup->addColumn("inf_cargo", "STRING_TYPE", "POST", "inf_cargo");
$upd_informe_intersup->addColumn("inf_dependencia", "STRING_TYPE", "POST", "inf_dependencia");
$upd_informe_intersup->addColumn("inf_avgejecucion", "DOUBLE_TYPE", "POST", "inf_avgejecucion");
$upd_informe_intersup->setPrimaryKey("inf_id", "NUMERIC_TYPE", "GET", "inf_id");

// Make an instance of the transaction object
$del_informe_intersup = new tNG_multipleDelete($conn_oConConfig);
$tNGs->addTransaction($del_informe_intersup);
// Register triggers
$del_informe_intersup->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_informe_intersup->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$del_informe_intersup->setTable("informe_intersup");
$del_informe_intersup->setPrimaryKey("inf_id", "NUMERIC_TYPE", "GET", "inf_id");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsinforme_intersup = $tNGs->getRecordset("informe_intersup");
$row_rsinforme_intersup = mysql_fetch_assoc($rsinforme_intersup);
$totalRows_rsinforme_intersup = mysql_num_rows($rsinforme_intersup);

$fechainicio = date("Y-m-d",strtotime($row_rsinfocont['FECHAI'] + 2 ."months"));
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
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
</head>

<body>
<?php
	echo $tNGs->getErrorMsg();
?>
<div class="KT_tng">
  <h1>
    <?php 
// Show IF Conditional region1 
if (@$_GET['inf_id'] == "") {
?>
      CREAR INFORME BORRADOR
          <?php 
// else Conditional region1
} else { ?>
      <?php echo NXT_getResource("Update_FH"); ?>
      <?php } 
// endif Conditional region1
?>
  </h1>
  <div class="KT_tngform">
    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
      <?php $cnt1 = 0; ?>
      <?php do { ?>
        <?php $cnt1++; ?>
        <?php 
// Show IF Conditional region1 
if (@$totalRows_rsinforme_intersup > 1) {
?>
          <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
          <?php } 
// endif Conditional region1
?>
        <table cellpadding="2" cellspacing="0" class="KT_tngtable">
          <tr>
            <td width="16%" class="KT_th">Se va a crear el informe n&uacute;mero:</td>
      <td width="84%"><input type="hidden" name="id_cont_fk_<?php echo $cnt1; ?>" id="id_cont_fk_<?php echo $cnt1; ?>" value="<?php echo $row_rsinfocont['id_cont']; ?>" size="7" />
                <?php echo $tNGs->displayFieldHint("id_cont_fk");?> <?php echo $tNGs->displayFieldError("informe_intersup", "id_cont_fk", $cnt1); ?> <input name="inf_consecutivo_<?php echo $cnt1; ?>" type="hidden" id="inf_consecutivo_<?php echo $cnt1; ?>" value="<?php echo ($row_rsnumeroinforme['NUMINFORME'] + 1); ?>" size="7" />
                <?php echo $tNGs->displayFieldHint("inf_consecutivo");?> <?php echo $tNGs->displayFieldError("informe_intersup", "inf_consecutivo", $cnt1); ?> <input type="hidden" name="inf_hash_<?php echo $cnt1; ?>" id="inf_hash_<?php echo $cnt1; ?>" value="<?php echo $letra.$numero; ?>" size="10" maxlength="10" />
                <?php echo $tNGs->displayFieldHint("inf_hash");?> <?php echo $tNGs->displayFieldError("informe_intersup", "inf_hash", $cnt1); ?> <input type="hidden" name="inf_estado_<?php echo $cnt1; ?>" id="inf_estado_<?php echo $cnt1; ?>" value="1" size="2" />
                <?php echo $tNGs->displayFieldHint("inf_estado");?> <?php echo $tNGs->displayFieldError("informe_intersup", "inf_estado", $cnt1); ?> <input type="hidden" name="inf_fechapresenta_<?php echo $cnt1; ?>" id="inf_fechapresenta_<?php echo $cnt1; ?>" value="<?php echo $fecha; ?>" size="10" maxlength="22" />
                <?php echo $tNGs->displayFieldHint("inf_fechapresenta");?> <?php echo $tNGs->displayFieldError("informe_intersup", "inf_fechapresenta", $cnt1); ?> <input name="inf_periodicidad_<?php echo $cnt1; ?>" type="hidden" id="inf_periodicidad_<?php echo $cnt1; ?>" value="<?php echo $row_rsinfocont['cont_periodicidad']; ?>" size="2" />
                <?php echo $tNGs->displayFieldHint("inf_periodicidad");?> <?php echo $tNGs->displayFieldError("informe_intersup", "inf_periodicidad", $cnt1); ?> <input name="inf_fecharep_i_<?php echo $cnt1; ?>" type="hidden" id="inf_fecharep_i_<?php echo $cnt1; ?>" value="<?php echo $row_rsnumeroinformes2['NEWFECHAI']; ?>" size="10" maxlength="22" />
                <?php echo $tNGs->displayFieldHint("inf_fecharep_i");?> <?php echo $tNGs->displayFieldError("informe_intersup", "inf_fecharep_i", $cnt1); ?> <input name="inf_fecharep_f_<?php echo $cnt1; ?>" type="hidden" id="inf_fecharep_f_<?php echo $cnt1; ?>" value="<?php echo $row_rsnumeroinformes2['NEWFECHAF']; ?>" size="10" maxlength="22" />
              <?php echo $tNGs->displayFieldHint("inf_fecharep_f");?> <?php echo $tNGs->displayFieldError("informe_intersup", "inf_fecharep_f", $cnt1); ?> <input name="inf_numerocontrato_<?php echo $cnt1; ?>" type="hidden" id="inf_numerocontrato_<?php echo $cnt1; ?>" value="<?php echo $row_rsinfocont['CONTRATOID']; ?>" size="20" maxlength="20" />
            <?php echo $tNGs->displayFieldHint("inf_numerocontrato");?> <?php echo $tNGs->displayFieldError("informe_intersup", "inf_numerocontrato", $cnt1); ?> <input name="inf_doccontratista_<?php echo $cnt1; ?>" type="hidden" id="inf_doccontratista_<?php echo $cnt1; ?>" value="<?php echo $row_rsinfocont['DOCID']; ?>" size="15" maxlength="15" />
            <?php echo $tNGs->displayFieldHint("inf_doccontratista");?> <?php echo $tNGs->displayFieldError("informe_intersup", "inf_doccontratista", $cnt1); ?> <input name="inf_nombrecontratista_<?php echo $cnt1; ?>" type="hidden" id="inf_nombrecontratista_<?php echo $cnt1; ?>" value="<?php echo $row_rsinfocont['contractor_name']; ?>" size="32" maxlength="120" />
            <?php echo $tNGs->displayFieldHint("inf_nombrecontratista");?> <?php echo $tNGs->displayFieldError("informe_intersup", "inf_nombrecontratista", $cnt1); ?> <input name="inf_valorcontrato_<?php echo $cnt1; ?>" type="hidden" id="inf_valorcontrato_<?php echo $cnt1; ?>" value="<?php echo $row_rsinfocont['VALORI']; ?>" size="7" />
            <?php echo $tNGs->displayFieldHint("inf_valorcontrato");?> <?php echo $tNGs->displayFieldError("informe_intersup", "inf_valorcontrato", $cnt1); ?> <input name="inf_cdp_<?php echo $cnt1; ?>" type="hidden" id="inf_cdp_<?php echo $cnt1; ?>" value="<?php echo $row_rsinfocont['CDP']; ?>" size="10" maxlength="10" />
            <?php echo $tNGs->displayFieldHint("inf_cdp");?> <?php echo $tNGs->displayFieldError("informe_intersup", "inf_cdp", $cnt1); ?> <input name="inf_rp_<?php echo $cnt1; ?>" type="hidden" id="inf_rp_<?php echo $cnt1; ?>" value="<?php echo $row_rsinfocont['RP']; ?>" size="10" maxlength="10" />
            <?php echo $tNGs->displayFieldHint("inf_rp");?> <?php echo $tNGs->displayFieldError("informe_intersup", "inf_rp", $cnt1); ?> <input name="inf_rubrocode_<?php echo $cnt1; ?>" type="hidden" id="inf_rubrocode_<?php echo $cnt1; ?>" value="<?php echo $row_rsinfocont['cont_codrubro']; ?>" size="20" maxlength="20" />
            <?php echo $tNGs->displayFieldHint("inf_rubrocode");?> <?php echo $tNGs->displayFieldError("informe_intersup", "inf_rubrocode", $cnt1); ?> <input type="hidden" name="inf_rubroname_<?php echo $cnt1; ?>" id="inf_rubroname_<?php echo $cnt1; ?>" value="." size="32" maxlength="200" />
            <?php echo $tNGs->displayFieldHint("inf_rubroname");?> <?php echo $tNGs->displayFieldError("informe_intersup", "inf_rubroname", $cnt1); ?> <input name="inf_objeto_<?php echo $cnt1; ?>" type="hidden" id="inf_objeto_<?php echo $cnt1; ?>" value="<?php echo $row_rsinfocont['cont_objeto']; ?>" size="32" />
            <?php echo $tNGs->displayFieldHint("inf_objeto");?> <?php echo $tNGs->displayFieldError("informe_intersup", "inf_objeto", $cnt1); ?> <input name="inf_fechasuscripcion_<?php echo $cnt1; ?>" type="hidden" id="inf_fechasuscripcion_<?php echo $cnt1; ?>" value="<?php echo $row_rsinfocont['cont_fechaapertura']; ?>" size="10" maxlength="22" />
            <?php echo $tNGs->displayFieldHint("inf_fechasuscripcion");?> <?php echo $tNGs->displayFieldError("informe_intersup", "inf_fechasuscripcion", $cnt1); ?> <?php echo ($row_rsnumeroinforme['NUMINFORME'] + 1); ?></td>
          </tr>
          
          <tr>
            <td class="KT_th"><label for="inf_avgejecucion_<?php echo $cnt1; ?>"></label></td>
            <td><input name="inf_fechacont_i_<?php echo $cnt1; ?>" type="hidden" id="inf_fechacont_i_<?php echo $cnt1; ?>" value="<?php echo $row_rsinfocont['FECHAI']; ?>" size="10" maxlength="22" />
                <?php echo $tNGs->displayFieldHint("inf_fechacont_i");?> <?php echo $tNGs->displayFieldError("informe_intersup", "inf_fechacont_i", $cnt1); ?> <input name="inf_fechacont_f_<?php echo $cnt1; ?>" type="hidden" id="inf_fechacont_f_<?php echo $cnt1; ?>" value="<?php echo $row_rsinfocont['FECHAF']; ?>" size="10" maxlength="22" />
                <?php echo $tNGs->displayFieldHint("inf_fechacont_f");?> <?php echo $tNGs->displayFieldError("informe_intersup", "inf_fechacont_f", $cnt1); ?> <input name="inf_plazo_<?php echo $cnt1; ?>" type="hidden" id="inf_plazo_<?php echo $cnt1; ?>" value="<?php echo $row_rsinfocont['QTYDIAS']; ?>" size="32" maxlength="100" />
                <?php echo $tNGs->displayFieldHint("inf_plazo");?> <?php echo $tNGs->displayFieldError("informe_intersup", "inf_plazo", $cnt1); ?> <input name="inf_vigencia_<?php echo $cnt1; ?>" type="hidden" id="inf_vigencia_<?php echo $cnt1; ?>" value="<?php echo $fecha; ?>" size="32" maxlength="100" />
                <?php echo $tNGs->displayFieldHint("inf_vigencia");?> <?php echo $tNGs->displayFieldError("informe_intersup", "inf_vigencia", $cnt1); ?> <input name="inf_intersup_<?php echo $cnt1; ?>" type="hidden" id="inf_intersup_<?php echo $cnt1; ?>" value="<?php echo $row_rssupervisor['usr_personalid']; ?>" size="32" maxlength="100" />
                <?php echo $tNGs->displayFieldHint("inf_intersup");?> <?php echo $tNGs->displayFieldError("informe_intersup", "inf_intersup", $cnt1); ?> <input name="inf_nombre_<?php echo $cnt1; ?>" type="hidden" id="inf_nombre_<?php echo $cnt1; ?>" value="<?php echo $row_rssupervisor['usr_name'].' '.$row_rssupervisor['usr_lname']; ?>" size="32" maxlength="120" />
                <?php echo $tNGs->displayFieldHint("inf_nombre");?> <?php echo $tNGs->displayFieldError("informe_intersup", "inf_nombre", $cnt1); ?> <input name="inf_cargo_<?php echo $cnt1; ?>" type="hidden" id="inf_cargo_<?php echo $cnt1; ?>" value="<?php echo $row_rssupervisor['nomcar']; ?>" size="32" maxlength="120" />
                <?php echo $tNGs->displayFieldHint("inf_cargo");?> <?php echo $tNGs->displayFieldError("informe_intersup", "inf_cargo", $cnt1); ?> <input name="inf_dependencia_<?php echo $cnt1; ?>" type="hidden" id="inf_dependencia_<?php echo $cnt1; ?>" value="<?php echo $row_rssupervisor['dpd_dsdpn_b']; ?>" size="32" maxlength="120" />
                <?php echo $tNGs->displayFieldHint("inf_dependencia");?> <?php echo $tNGs->displayFieldError("informe_intersup", "inf_dependencia", $cnt1); ?> <input type="hidden" name="inf_avgejecucion_<?php echo $cnt1; ?>" id="inf_avgejecucion_<?php echo $cnt1; ?>" value="0" size="7" />
            <?php echo $tNGs->displayFieldHint("inf_avgejecucion");?> <?php echo $tNGs->displayFieldError("informe_intersup", "inf_avgejecucion", $cnt1); ?>Presione el bot&oacute;n &quot;Crear borrador&quot;</td>
          </tr>
        </table>
        <input type="hidden" name="kt_pk_informe_intersup_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rsinforme_intersup['kt_pk_informe_intersup']); ?>" />
        <?php } while ($row_rsinforme_intersup = mysql_fetch_assoc($rsinforme_intersup)); ?>
      <div class="KT_bottombuttons">
        <div>
          <?php 
      // Show IF Conditional region1
      if (@$_GET['inf_id'] == "") {
      ?>
            <input type="submit" name="KT_Insert1" id="KT_Insert1" value="Crear borrador" />
            <?php 
      // else Conditional region1
      } else { ?>
            <div class="KT_operations">
              <input type="submit" name="KT_Insert1" value="Crear borrador" onclick="nxt_form_insertasnew(this, 'inf_id')" />
            </div>
            <input type="submit" name="KT_Update1" value="<?php echo NXT_getResource("Update_FB"); ?>" />
            <?php }
      // endif Conditional region1
      ?>
        </div>
      </div>
    </form>
  </div>
  <br class="clearfixplain" />
</div>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($rsinfocont);

mysql_free_result($rsnumeroinforme);

mysql_free_result($rsfechavence);

mysql_free_result($rssupervisor);

mysql_free_result($rsnumeroinformes2);
?>
