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
$conn_oConnAlmacen = new KT_connection($oConnAlmacen, $database_oConnAlmacen);

// Start trigger
$formValidation = new tNG_FormValidation();
$formValidation->addField("almovinddia_id", true, "numeric", "", "", "", "");
$formValidation->addField("ditipoestruc", true, "text", "", "", "", "");
$formValidation->addField("dicuenta", true, "numeric", "", "", "", "");
$formValidation->addField("dicodelem", true, "numeric", "", "", "", "");
$formValidation->addField("dialmacen", true, "numeric", "", "", "", "");
$formValidation->addField("di_nroplaca", true, "text", "", "", "", "");
$formValidation->addField("difuncionario", true, "text", "", "", "", "");
$formValidation->addField("di_estadoelem", true, "text", "", "", "", "");
$formValidation->addField("di_detalleestado", true, "text", "", "", "", "");
$formValidation->addField("diconceptoadq", true, "numeric", "", "", "", "");
$formValidation->addField("di_fechacompra", true, "date", "", "", "", "");
$formValidation->addField("di_valorcompra", true, "double", "", "", "", "");
$formValidation->addField("di_vrmejoras", true, "double", "", "", "", "");
$formValidation->addField("di_vrdesmejoras", true, "double", "", "", "", "");
$formValidation->addField("di_vrvaloriza", true, "double", "", "", "", "");
$formValidation->addField("di_vrdesvaloriza", true, "double", "", "", "", "");
$formValidation->addField("di_vidautiltot", true, "text", "", "", "", "");
$formValidation->addField("di_vidautilres", true, "text", "", "", "", "");
$formValidation->addField("di_fechaultdep", true, "date", "", "", "", "");
$formValidation->addField("diconceptoultdep", true, "text", "", "", "", "");
$formValidation->addField("di_estadoconserva", true, "text", "", "", "", "");
$formValidation->addField("di_fechaultmovto", true, "date", "", "", "", "");
$formValidation->addField("dicodconcepto", true, "numeric", "", "", "", "");
$formValidation->addField("di_valorultmovto", true, "double", "", "", "", "");
$formValidation->addField("di_vrajusinfacum", true, "double", "", "", "", "");
$formValidation->addField("di_vracumdepreacum", true, "double", "", "", "", "");
$formValidation->addField("di_vrajusacumdep", true, "double", "", "", "", "");
$formValidation->addField("di_vrdepredifacum", true, "double", "", "", "", "");
$formValidation->addField("di_vrajusinfult", true, "double", "", "", "", "");
$formValidation->addField("di_vrdepreacumult", true, "double", "", "", "", "");
$formValidation->addField("di_vrajusdepult", true, "double", "", "", "", "");
$formValidation->addField("di_vrdepredifult", true, "double", "", "", "", "");
$formValidation->addField("di_otraplaca", true, "text", "", "", "", "");
$formValidation->addField("di_nroplacastma", true, "text", "", "", "", "");
$formValidation->addField("sys_user", true, "text", "", "", "", "");
$formValidation->addField("sys_date", true, "date", "", "", "", "");
$formValidation->addField("sys_time", true, "date", "", "", "", "");
$formValidation->addField("sys_sts", true, "numeric", "", "", "", "");
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

$colname_rslegaliza = "-1";
if (isset($_GET['almovinddia_id'])) {
  $colname_rslegaliza = $_GET['almovinddia_id'];
}
mysql_select_db($database_oConnAlmacen, $oConnAlmacen);
$query_rslegaliza = sprintf("SELECT * FROM q_almacen_600_700 WHERE almovinddia_id = %s", GetSQLValueString($colname_rslegaliza, "int"));
$rslegaliza = mysql_query($query_rslegaliza, $oConnAlmacen) or die(mysql_error());
$row_rslegaliza = mysql_fetch_assoc($rslegaliza);
$totalRows_rslegaliza = mysql_num_rows($rslegaliza);

$colname_rsvalidator = "-1";
if (isset($_GET['almovinddia_id'])) {
  $colname_rsvalidator = $_GET['almovinddia_id'];
}
mysql_select_db($database_oConnAlmacen, $oConnAlmacen);
$query_rsvalidator = sprintf("SELECT aldevindiv_id, almovinddia_id FROM aldevindiv WHERE almovinddia_id = %s", GetSQLValueString($colname_rsvalidator, "int"));
$rsvalidator = mysql_query($query_rsvalidator, $oConnAlmacen) or die(mysql_error());
$row_rsvalidator = mysql_fetch_assoc($rsvalidator);
$totalRows_rsvalidator = mysql_num_rows($rsvalidator);

// Make an insert transaction instance
$ins_aldevindiv = new tNG_multipleInsert($conn_oConnAlmacen);
$tNGs->addTransaction($ins_aldevindiv);
// Register triggers
$ins_aldevindiv->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_aldevindiv->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_aldevindiv->registerTrigger("END", "Trigger_Default_Redirect", 99, "ok.php");
// Add columns
$ins_aldevindiv->setTable("aldevindiv");
$ins_aldevindiv->addColumn("almovinddia_id", "NUMERIC_TYPE", "POST", "almovinddia_id");
$ins_aldevindiv->addColumn("ditipoestruc", "STRING_TYPE", "POST", "ditipoestruc");
$ins_aldevindiv->addColumn("dicuenta", "NUMERIC_TYPE", "POST", "dicuenta");
$ins_aldevindiv->addColumn("dicodelem", "NUMERIC_TYPE", "POST", "dicodelem");
$ins_aldevindiv->addColumn("dialmacen", "NUMERIC_TYPE", "POST", "dialmacen");
$ins_aldevindiv->addColumn("di_nroplaca", "STRING_TYPE", "POST", "di_nroplaca");
$ins_aldevindiv->addColumn("di_nroserie", "STRING_TYPE", "POST", "di_nroserie");
$ins_aldevindiv->addColumn("difuncionario", "STRING_TYPE", "POST", "difuncionario");
$ins_aldevindiv->addColumn("di_estadoelem", "STRING_TYPE", "POST", "di_estadoelem");
$ins_aldevindiv->addColumn("di_detalleestado", "STRING_TYPE", "POST", "di_detalleestado");
$ins_aldevindiv->addColumn("diconceptoadq", "NUMERIC_TYPE", "POST", "diconceptoadq");
$ins_aldevindiv->addColumn("di_fechacompra", "DATE_TYPE", "POST", "di_fechacompra");
$ins_aldevindiv->addColumn("di_valorcompra", "DOUBLE_TYPE", "POST", "di_valorcompra");
$ins_aldevindiv->addColumn("di_vrmejoras", "DOUBLE_TYPE", "POST", "di_vrmejoras");
$ins_aldevindiv->addColumn("di_vrdesmejoras", "DOUBLE_TYPE", "POST", "di_vrdesmejoras");
$ins_aldevindiv->addColumn("di_vrvaloriza", "DOUBLE_TYPE", "POST", "di_vrvaloriza");
$ins_aldevindiv->addColumn("di_vrdesvaloriza", "DOUBLE_TYPE", "POST", "di_vrdesvaloriza");
$ins_aldevindiv->addColumn("di_vidautiltot", "STRING_TYPE", "POST", "di_vidautiltot");
$ins_aldevindiv->addColumn("di_vidautilres", "STRING_TYPE", "POST", "di_vidautilres");
$ins_aldevindiv->addColumn("di_fechaultdep", "DATE_TYPE", "POST", "di_fechaultdep");
$ins_aldevindiv->addColumn("diconceptoultdep", "STRING_TYPE", "POST", "diconceptoultdep");
$ins_aldevindiv->addColumn("di_estadoconserva", "STRING_TYPE", "POST", "di_estadoconserva");
$ins_aldevindiv->addColumn("di_fechaultmovto", "DATE_TYPE", "POST", "di_fechaultmovto");
$ins_aldevindiv->addColumn("dicodconcepto", "NUMERIC_TYPE", "POST", "dicodconcepto");
$ins_aldevindiv->addColumn("di_valorultmovto", "DOUBLE_TYPE", "POST", "di_valorultmovto");
$ins_aldevindiv->addColumn("di_vrajusinfacum", "DOUBLE_TYPE", "POST", "di_vrajusinfacum");
$ins_aldevindiv->addColumn("di_vracumdepreacum", "DOUBLE_TYPE", "POST", "di_vracumdepreacum");
$ins_aldevindiv->addColumn("di_vrajusacumdep", "DOUBLE_TYPE", "POST", "di_vrajusacumdep");
$ins_aldevindiv->addColumn("di_vrdepredifacum", "DOUBLE_TYPE", "POST", "di_vrdepredifacum");
$ins_aldevindiv->addColumn("di_vrajusinfult", "DOUBLE_TYPE", "POST", "di_vrajusinfult");
$ins_aldevindiv->addColumn("di_vrdepreacumult", "DOUBLE_TYPE", "POST", "di_vrdepreacumult");
$ins_aldevindiv->addColumn("di_vrajusdepult", "DOUBLE_TYPE", "POST", "di_vrajusdepult");
$ins_aldevindiv->addColumn("di_vrdepredifult", "DOUBLE_TYPE", "POST", "di_vrdepredifult");
$ins_aldevindiv->addColumn("di_otraplaca", "STRING_TYPE", "POST", "di_otraplaca");
$ins_aldevindiv->addColumn("di_nroplacastma", "STRING_TYPE", "POST", "di_nroplacastma");
$ins_aldevindiv->addColumn("sys_user", "STRING_TYPE", "POST", "sys_user");
$ins_aldevindiv->addColumn("sys_date", "DATE_TYPE", "POST", "sys_date");
$ins_aldevindiv->addColumn("sys_time", "DATE_TYPE", "POST", "sys_time");
$ins_aldevindiv->addColumn("sys_sts", "NUMERIC_TYPE", "POST", "sys_sts");
$ins_aldevindiv->setPrimaryKey("aldevindiv_id", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_aldevindiv = new tNG_multipleUpdate($conn_oConnAlmacen);
$tNGs->addTransaction($upd_aldevindiv);
// Register triggers
$upd_aldevindiv->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_aldevindiv->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_aldevindiv->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$upd_aldevindiv->setTable("aldevindiv");
$upd_aldevindiv->addColumn("almovinddia_id", "NUMERIC_TYPE", "POST", "almovinddia_id");
$upd_aldevindiv->addColumn("ditipoestruc", "STRING_TYPE", "POST", "ditipoestruc");
$upd_aldevindiv->addColumn("dicuenta", "NUMERIC_TYPE", "POST", "dicuenta");
$upd_aldevindiv->addColumn("dicodelem", "NUMERIC_TYPE", "POST", "dicodelem");
$upd_aldevindiv->addColumn("dialmacen", "NUMERIC_TYPE", "POST", "dialmacen");
$upd_aldevindiv->addColumn("di_nroplaca", "STRING_TYPE", "POST", "di_nroplaca");
$upd_aldevindiv->addColumn("di_nroserie", "STRING_TYPE", "POST", "di_nroserie");
$upd_aldevindiv->addColumn("difuncionario", "STRING_TYPE", "POST", "difuncionario");
$upd_aldevindiv->addColumn("di_estadoelem", "STRING_TYPE", "POST", "di_estadoelem");
$upd_aldevindiv->addColumn("di_detalleestado", "STRING_TYPE", "POST", "di_detalleestado");
$upd_aldevindiv->addColumn("diconceptoadq", "NUMERIC_TYPE", "POST", "diconceptoadq");
$upd_aldevindiv->addColumn("di_fechacompra", "DATE_TYPE", "POST", "di_fechacompra");
$upd_aldevindiv->addColumn("di_valorcompra", "DOUBLE_TYPE", "POST", "di_valorcompra");
$upd_aldevindiv->addColumn("di_vrmejoras", "DOUBLE_TYPE", "POST", "di_vrmejoras");
$upd_aldevindiv->addColumn("di_vrdesmejoras", "DOUBLE_TYPE", "POST", "di_vrdesmejoras");
$upd_aldevindiv->addColumn("di_vrvaloriza", "DOUBLE_TYPE", "POST", "di_vrvaloriza");
$upd_aldevindiv->addColumn("di_vrdesvaloriza", "DOUBLE_TYPE", "POST", "di_vrdesvaloriza");
$upd_aldevindiv->addColumn("di_vidautiltot", "STRING_TYPE", "POST", "di_vidautiltot");
$upd_aldevindiv->addColumn("di_vidautilres", "STRING_TYPE", "POST", "di_vidautilres");
$upd_aldevindiv->addColumn("di_fechaultdep", "DATE_TYPE", "POST", "di_fechaultdep");
$upd_aldevindiv->addColumn("diconceptoultdep", "STRING_TYPE", "POST", "diconceptoultdep");
$upd_aldevindiv->addColumn("di_estadoconserva", "STRING_TYPE", "POST", "di_estadoconserva");
$upd_aldevindiv->addColumn("di_fechaultmovto", "DATE_TYPE", "POST", "di_fechaultmovto");
$upd_aldevindiv->addColumn("dicodconcepto", "NUMERIC_TYPE", "POST", "dicodconcepto");
$upd_aldevindiv->addColumn("di_valorultmovto", "DOUBLE_TYPE", "POST", "di_valorultmovto");
$upd_aldevindiv->addColumn("di_vrajusinfacum", "DOUBLE_TYPE", "POST", "di_vrajusinfacum");
$upd_aldevindiv->addColumn("di_vracumdepreacum", "DOUBLE_TYPE", "POST", "di_vracumdepreacum");
$upd_aldevindiv->addColumn("di_vrajusacumdep", "DOUBLE_TYPE", "POST", "di_vrajusacumdep");
$upd_aldevindiv->addColumn("di_vrdepredifacum", "DOUBLE_TYPE", "POST", "di_vrdepredifacum");
$upd_aldevindiv->addColumn("di_vrajusinfult", "DOUBLE_TYPE", "POST", "di_vrajusinfult");
$upd_aldevindiv->addColumn("di_vrdepreacumult", "DOUBLE_TYPE", "POST", "di_vrdepreacumult");
$upd_aldevindiv->addColumn("di_vrajusdepult", "DOUBLE_TYPE", "POST", "di_vrajusdepult");
$upd_aldevindiv->addColumn("di_vrdepredifult", "DOUBLE_TYPE", "POST", "di_vrdepredifult");
$upd_aldevindiv->addColumn("di_otraplaca", "STRING_TYPE", "POST", "di_otraplaca");
$upd_aldevindiv->addColumn("di_nroplacastma", "STRING_TYPE", "POST", "di_nroplacastma");
$upd_aldevindiv->addColumn("sys_user", "STRING_TYPE", "POST", "sys_user");
$upd_aldevindiv->addColumn("sys_date", "DATE_TYPE", "POST", "sys_date");
$upd_aldevindiv->addColumn("sys_time", "DATE_TYPE", "POST", "sys_time");
$upd_aldevindiv->addColumn("sys_sts", "NUMERIC_TYPE", "POST", "sys_sts");
$upd_aldevindiv->setPrimaryKey("aldevindiv_id", "NUMERIC_TYPE", "GET", "aldevindiv_id");

// Make an instance of the transaction object
$del_aldevindiv = new tNG_multipleDelete($conn_oConnAlmacen);
$tNGs->addTransaction($del_aldevindiv);
// Register triggers
$del_aldevindiv->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_aldevindiv->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$del_aldevindiv->setTable("aldevindiv");
$del_aldevindiv->setPrimaryKey("aldevindiv_id", "NUMERIC_TYPE", "GET", "aldevindiv_id");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsaldevindiv = $tNGs->getRecordset("aldevindiv");
$row_rsaldevindiv = mysql_fetch_assoc($rsaldevindiv);
$totalRows_rsaldevindiv = mysql_num_rows($rsaldevindiv);
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
<link href="../_css/jqueryslidemenu.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php if ($totalRows_rsvalidator == 0) { // Show if recordset empty ?>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><?php
	echo $tNGs->getErrorMsg();
?></td>
    </tr>
    <tr>
      <td>&nbsp; </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Al presionar el bot&oacute;n <span class="titlenormaltextbold">ingresar</span> confirma el registro de la placa n&uacute;mero <span class="frmtablahead"><?php echo $row_rslegaliza['midnroplaca']; ?></span> al inventario global de la Superintendencia Nacional de Salud</td>
    </tr>
    <tr>
      <td><div class="KT_tng">
        <h1>
          <?php 
// Show IF Conditional region1 
if (@$_GET['aldevindiv_id'] == "") {
?>
            <?php echo NXT_getResource("Insert_FH"); ?>
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
if (@$totalRows_rsaldevindiv > 1) {
?>
                <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
                <?php } 
// endif Conditional region1
?>
              <table cellpadding="2" cellspacing="0" class="KT_tngtable">
                <tr>
                  <td class="KT_th"><label for="dicuenta_<?php echo $cnt1; ?>"></label>
                        <label for="dicodelem_<?php echo $cnt1; ?>"></label>
                        <label for="sys_sts_<?php echo $cnt1; ?>"></label></td>
                  <td><p>
                    <input type="hidden" name="almovinddia_id_<?php echo $cnt1; ?>" id="almovinddia_id_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rslegaliza['almovinddia_id']); ?>" size="7" />
                    <?php echo $tNGs->displayFieldHint("almovinddia_id");?> <?php echo $tNGs->displayFieldError("aldevindiv", "almovinddia_id", $cnt1); ?>
                    <input type="hidden" name="ditipoestruc_<?php echo $cnt1; ?>" id="ditipoestruc_<?php echo $cnt1; ?>" value="V" size="2" maxlength="2" />
                    <?php echo $tNGs->displayFieldHint("ditipoestruc");?> <?php echo $tNGs->displayFieldError("aldevindiv", "ditipoestruc", $cnt1); ?>
                    <input name="dicuenta_<?php echo $cnt1; ?>" type="hidden" id="dicuenta_<?php echo $cnt1; ?>" value="<?php echo $row_rslegaliza['midcuenta']; ?>" size="7" />
                    <?php echo $tNGs->displayFieldHint("dicuenta");?> <?php echo $tNGs->displayFieldError("aldevindiv", "dicuenta", $cnt1); ?>
                    <input name="dicodelem_<?php echo $cnt1; ?>" type="hidden" id="dicodelem_<?php echo $cnt1; ?>" value="<?php echo $row_rslegaliza['midcodelem']; ?>" size="7" />
                    <?php echo $tNGs->displayFieldHint("dicodelem");?> <?php echo $tNGs->displayFieldError("aldevindiv", "dicodelem", $cnt1); ?>
                    <input name="dialmacen_<?php echo $cnt1; ?>" type="hidden" id="dialmacen_<?php echo $cnt1; ?>" value="<?php echo $row_rslegaliza['midalmacen']; ?>" size="7" />
                    <?php echo $tNGs->displayFieldHint("dialmacen");?> <?php echo $tNGs->displayFieldError("aldevindiv", "dialmacen", $cnt1); ?>
                    <input name="di_nroplaca_<?php echo $cnt1; ?>" type="hidden" id="di_nroplaca_<?php echo $cnt1; ?>" value="<?php echo $row_rslegaliza['midnroplaca']; ?>" size="32" maxlength="255" />
                    <?php echo $tNGs->displayFieldHint("di_nroplaca");?> <?php echo $tNGs->displayFieldError("aldevindiv", "di_nroplaca", $cnt1); ?>
                    <input name="di_nroserie_<?php echo $cnt1; ?>" type="hidden" id="di_nroserie_<?php echo $cnt1; ?>" value="<?php echo $row_rslegaliza['midnroserie']; ?>" size="32" maxlength="255" />
                    <?php echo $tNGs->displayFieldHint("di_nroserie");?> <?php echo $tNGs->displayFieldError("aldevindiv", "di_nroserie", $cnt1); ?>
                    <input name="difuncionario_<?php echo $cnt1; ?>" type="hidden" id="difuncionario_<?php echo $cnt1; ?>" value="<?php echo $row_rslegaliza['sys_document_func']; ?>" size="32" maxlength="255" />
                    <?php echo $tNGs->displayFieldHint("difuncionario");?> <?php echo $tNGs->displayFieldError("aldevindiv", "difuncionario", $cnt1); ?>
                    <input type="hidden" name="di_estadoelem_<?php echo $cnt1; ?>" id="di_estadoelem_<?php echo $cnt1; ?>" value="B" size="32" maxlength="255" />
                    <?php echo $tNGs->displayFieldHint("di_estadoelem");?> <?php echo $tNGs->displayFieldError("aldevindiv", "di_estadoelem", $cnt1); ?>
                    <input type="hidden" name="di_detalleestado_<?php echo $cnt1; ?>" id="di_detalleestado_<?php echo $cnt1; ?>" value="DADO AL SERVICIO" size="32" maxlength="255" />
                    <?php echo $tNGs->displayFieldHint("di_detalleestado");?> <?php echo $tNGs->displayFieldError("aldevindiv", "di_detalleestado", $cnt1); ?>
                    <input type="hidden" name="diconceptoadq_<?php echo $cnt1; ?>" id="diconceptoadq_<?php echo $cnt1; ?>" value="8" size="7" />
                    <?php echo $tNGs->displayFieldHint("diconceptoadq");?> <?php echo $tNGs->displayFieldError("aldevindiv", "diconceptoadq", $cnt1); ?>
                    <input name="di_fechacompra_<?php echo $cnt1; ?>" type="hidden" id="di_fechacompra_<?php echo $cnt1; ?>" value="<?php echo $row_rslegaliza['midfechadoc']; ?>" size="10" maxlength="22" />
                    <?php echo $tNGs->displayFieldHint("di_fechacompra");?> <?php echo $tNGs->displayFieldError("aldevindiv", "di_fechacompra", $cnt1); ?>
                    <input name="di_valorcompra_<?php echo $cnt1; ?>" type="hidden" id="di_valorcompra_<?php echo $cnt1; ?>" value="<?php echo $row_rslegaliza['mid_valormovto']; ?>" size="7" />
                    <?php echo $tNGs->displayFieldHint("di_valorcompra");?> <?php echo $tNGs->displayFieldError("aldevindiv", "di_valorcompra", $cnt1); ?></p>
                        <p>
                          <input type="hidden" name="di_vrmejoras_<?php echo $cnt1; ?>" id="di_vrmejoras_<?php echo $cnt1; ?>" value="0" size="7" />
                          <?php echo $tNGs->displayFieldHint("di_vrmejoras");?> <?php echo $tNGs->displayFieldError("aldevindiv", "di_vrmejoras", $cnt1); ?>
                          <input type="hidden" name="di_vrdesmejoras_<?php echo $cnt1; ?>" id="di_vrdesmejoras_<?php echo $cnt1; ?>" value="0" size="7" />
                          <?php echo $tNGs->displayFieldHint("di_vrdesmejoras");?> <?php echo $tNGs->displayFieldError("aldevindiv", "di_vrdesmejoras", $cnt1); ?>
                          <input type="hidden" name="di_vrvaloriza_<?php echo $cnt1; ?>" id="di_vrvaloriza_<?php echo $cnt1; ?>" value="0" size="7" />
                          <?php echo $tNGs->displayFieldHint("di_vrvaloriza");?> <?php echo $tNGs->displayFieldError("aldevindiv", "di_vrvaloriza", $cnt1); ?>
                          <input type="hidden" name="di_vrdesvaloriza_<?php echo $cnt1; ?>" id="di_vrdesvaloriza_<?php echo $cnt1; ?>" value="0" size="7" />
                          <?php echo $tNGs->displayFieldHint("di_vrdesvaloriza");?> <?php echo $tNGs->displayFieldError("aldevindiv", "di_vrdesvaloriza", $cnt1); ?>
                          <input type="hidden" name="di_vidautiltot_<?php echo $cnt1; ?>" id="di_vidautiltot_<?php echo $cnt1; ?>" value="0" size="32" maxlength="255" />
                          <?php echo $tNGs->displayFieldHint("di_vidautiltot");?> <?php echo $tNGs->displayFieldError("aldevindiv", "di_vidautiltot", $cnt1); ?>
                          <input type="hidden" name="di_vidautilres_<?php echo $cnt1; ?>" id="di_vidautilres_<?php echo $cnt1; ?>" value="0" size="32" maxlength="255" />
                          <?php echo $tNGs->displayFieldHint("di_vidautilres");?> <?php echo $tNGs->displayFieldError("aldevindiv", "di_vidautilres", $cnt1); ?>
                          <input type="hidden" name="di_fechaultdep_<?php echo $cnt1; ?>" id="di_fechaultdep_<?php echo $cnt1; ?>" value="<?php echo $row_rslegaliza['midfechadoc']; ?>" size="10" maxlength="22" />
                          <?php echo $tNGs->displayFieldHint("di_fechaultdep");?> <?php echo $tNGs->displayFieldError("aldevindiv", "di_fechaultdep", $cnt1); ?>
                          <input type="hidden" name="diconceptoultdep_<?php echo $cnt1; ?>" id="diconceptoultdep_<?php echo $cnt1; ?>" value="1" size="32" maxlength="255" />
                          <?php echo $tNGs->displayFieldHint("diconceptoultdep");?> <?php echo $tNGs->displayFieldError("aldevindiv", "diconceptoultdep", $cnt1); ?>
                          <input type="hidden" name="di_estadoconserva_<?php echo $cnt1; ?>" id="di_estadoconserva_<?php echo $cnt1; ?>" value="2" size="32" maxlength="255" />
                          <?php echo $tNGs->displayFieldHint("di_estadoconserva");?> <?php echo $tNGs->displayFieldError("aldevindiv", "di_estadoconserva", $cnt1); ?>
                          <input type="hidden" name="di_fechaultmovto_<?php echo $cnt1; ?>" id="di_fechaultmovto_<?php echo $cnt1; ?>" value="<?php echo $row_rslegaliza['midfechadoc']; ?>" size="10" maxlength="22" />
                          <?php echo $tNGs->displayFieldHint("di_fechaultmovto");?> <?php echo $tNGs->displayFieldError("aldevindiv", "di_fechaultmovto", $cnt1); ?>
                          <input type="hidden" name="dicodconcepto_<?php echo $cnt1; ?>" id="dicodconcepto_<?php echo $cnt1; ?>" value="1" size="7" />
                          <?php echo $tNGs->displayFieldHint("dicodconcepto");?> <?php echo $tNGs->displayFieldError("aldevindiv", "dicodconcepto", $cnt1); ?>
                          <input type="hidden" name="di_valorultmovto_<?php echo $cnt1; ?>" id="di_valorultmovto_<?php echo $cnt1; ?>" value="<?php echo $row_rslegaliza['mid_valormovto']; ?>" size="7" />
                          <?php echo $tNGs->displayFieldHint("di_valorultmovto");?> <?php echo $tNGs->displayFieldError("aldevindiv", "di_valorultmovto", $cnt1); ?>
                          <input type="hidden" name="di_vrajusinfacum_<?php echo $cnt1; ?>" id="di_vrajusinfacum_<?php echo $cnt1; ?>" value="0" size="7" />
                          <?php echo $tNGs->displayFieldHint("di_vrajusinfacum");?> <?php echo $tNGs->displayFieldError("aldevindiv", "di_vrajusinfacum", $cnt1); ?></p>
                    <p>
                          <input type="hidden" name="di_vracumdepreacum_<?php echo $cnt1; ?>" id="di_vracumdepreacum_<?php echo $cnt1; ?>" value="0" size="7" />
                          <?php echo $tNGs->displayFieldHint("di_vracumdepreacum");?> <?php echo $tNGs->displayFieldError("aldevindiv", "di_vracumdepreacum", $cnt1); ?>
                          <input type="hidden" name="di_vrajusacumdep_<?php echo $cnt1; ?>" id="di_vrajusacumdep_<?php echo $cnt1; ?>" value="0" size="7" />
                          <?php echo $tNGs->displayFieldHint("di_vrajusacumdep");?> <?php echo $tNGs->displayFieldError("aldevindiv", "di_vrajusacumdep", $cnt1); ?>
                          <input type="hidden" name="di_vrdepredifacum_<?php echo $cnt1; ?>" id="di_vrdepredifacum_<?php echo $cnt1; ?>" value="0" size="7" />
                          <?php echo $tNGs->displayFieldHint("di_vrdepredifacum");?> <?php echo $tNGs->displayFieldError("aldevindiv", "di_vrdepredifacum", $cnt1); ?>
                          <input type="hidden" name="di_vrajusinfult_<?php echo $cnt1; ?>" id="di_vrajusinfult_<?php echo $cnt1; ?>" value="0" size="7" />
                          <?php echo $tNGs->displayFieldHint("di_vrajusinfult");?> <?php echo $tNGs->displayFieldError("aldevindiv", "di_vrajusinfult", $cnt1); ?>
                          <input type="hidden" name="di_vrdepreacumult_<?php echo $cnt1; ?>" id="di_vrdepreacumult_<?php echo $cnt1; ?>" value="0" size="7" />
                          <?php echo $tNGs->displayFieldHint("di_vrdepreacumult");?> <?php echo $tNGs->displayFieldError("aldevindiv", "di_vrdepreacumult", $cnt1); ?>
                          <input type="hidden" name="di_vrajusdepult_<?php echo $cnt1; ?>" id="di_vrajusdepult_<?php echo $cnt1; ?>" value="0" size="7" />
                          <?php echo $tNGs->displayFieldHint("di_vrajusdepult");?> <?php echo $tNGs->displayFieldError("aldevindiv", "di_vrajusdepult", $cnt1); ?>
                          <input type="hidden" name="di_vrdepredifult_<?php echo $cnt1; ?>" id="di_vrdepredifult_<?php echo $cnt1; ?>" value="0" size="7" />
                          <?php echo $tNGs->displayFieldHint("di_vrdepredifult");?> <?php echo $tNGs->displayFieldError("aldevindiv", "di_vrdepredifult", $cnt1); ?>
                          <input type="hidden" name="di_otraplaca_<?php echo $cnt1; ?>" id="di_otraplaca_<?php echo $cnt1; ?>" value="0" size="32" maxlength="255" />
                          <?php echo $tNGs->displayFieldHint("di_otraplaca");?> <?php echo $tNGs->displayFieldError("aldevindiv", "di_otraplaca", $cnt1); ?>
                          <input name="di_nroplacastma_<?php echo $cnt1; ?>" type="hidden" id="di_nroplacastma_<?php echo $cnt1; ?>" value="<?php echo $row_rslegaliza['sys_doclasedoc_id_fk']; ?>" size="32" maxlength="255" />
                          <?php echo $tNGs->displayFieldHint("di_nroplacastma");?> <?php echo $tNGs->displayFieldError("aldevindiv", "di_nroplacastma", $cnt1); ?>
                          <input name="sys_user_<?php echo $cnt1; ?>" type="hidden" id="sys_user_<?php echo $cnt1; ?>" value="<?php echo $_SESSION['kt_login_user']; ?>" size="32" maxlength="60" />
                          <?php echo $tNGs->displayFieldHint("sys_user");?> <?php echo $tNGs->displayFieldError("aldevindiv", "sys_user", $cnt1); ?>
                          <input type="hidden" name="sys_date_<?php echo $cnt1; ?>" id="sys_date_<?php echo $cnt1; ?>" value="<?php echo $fecha; ?>" size="10" maxlength="22" />
                          <?php echo $tNGs->displayFieldHint("sys_date");?> <?php echo $tNGs->displayFieldError("aldevindiv", "sys_date", $cnt1); ?>
                          <input type="hidden" name="sys_time_<?php echo $cnt1; ?>" id="sys_time_<?php echo $cnt1; ?>" value="<?php echo $hora; ?>" size="10" maxlength="22" />
                          <?php echo $tNGs->displayFieldHint("sys_time");?> <?php echo $tNGs->displayFieldError("aldevindiv", "sys_time", $cnt1); ?>
                          <input type="hidden" name="sys_sts_<?php echo $cnt1; ?>" id="sys_sts_<?php echo $cnt1; ?>" value="1" size="2" />
                          <?php echo $tNGs->displayFieldHint("sys_sts");?> <?php echo $tNGs->displayFieldError("aldevindiv", "sys_sts", $cnt1); ?> </p></td>
                </tr>
              </table>
              <input type="hidden" name="kt_pk_aldevindiv_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rsaldevindiv['kt_pk_aldevindiv']); ?>" />
              <?php } while ($row_rsaldevindiv = mysql_fetch_assoc($rsaldevindiv)); ?>
            <div class="KT_bottombuttons">
              <div>
                <?php 
      // Show IF Conditional region1
      if (@$_GET['aldevindiv_id'] == "") {
      ?>
                  <input type="submit" name="KT_Insert1" id="KT_Insert1" value="Ingresar" />
                  <?php 
      // else Conditional region1
      } else { ?>
                  <?php }
      // endif Conditional region1
      ?>
              </div>
            </div>
          </form>
        </div>
        <br class="clearfixplain" />
      </div></td>
    </tr>
  </table>
  <?php } // Show if recordset empty ?>
<p>&nbsp;</p>
<?php if ($totalRows_rsvalidator > 0) { // Show if recordset not empty ?>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="titlemsg2">El n&uacute;mero de placa solicitado ya fu&eacute; vinculado al inventario general de la SNS<br />
        Transacci&oacute;n: <?php echo $row_rsvalidator['aldevindiv_id']; ?></td>
    </tr>
  </table>
  <?php } // Show if recordset not empty ?>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($rslegaliza);

mysql_free_result($rsvalidator);
?>
