<?php require_once('../Connections/oConnAlmacen.php'); ?>
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
$formValidation->addField("doclasedoc_id_fk", true, "numeric", "", "", "", "");
$formValidation->addField("almovdevdia_id_fk", true, "numeric", "", "", "", "");
$formValidation->addField("midclasedoc", true, "numeric", "", "", "", "");
$formValidation->addField("midnrodoc", true, "numeric", "", "", "", "");
$formValidation->addField("midfechadoc", true, "date", "", "", "", "");
$formValidation->addField("midalmacen", true, "text", "", "", "", "");
$formValidation->addField("midtipoestruc", true, "text", "", "", "", "");
$formValidation->addField("midcuenta", true, "text", "", "", "", "");
$formValidation->addField("midcodelem", true, "numeric", "", "", "", "");
$formValidation->addField("midnroplaca", true, "text", "", "", "", "");
$formValidation->addField("midnroserie", true, "text", "", "", "", "");
$formValidation->addField("midfuncionario", true, "text", "", "", "", "");
$formValidation->addField("mid_valunit", true, "double", "", "", "", "");
$formValidation->addField("mid_tax", true, "double", "", "", "", "");
$formValidation->addField("mid_valormovto", true, "double", "", "", "", "");
$formValidation->addField("mid_vidautiladi", true, "numeric", "", "", "", "");
$formValidation->addField("mid_estadocons", true, "text", "", "", "", "");
$formValidation->addField("mid_estadoelem", true, "text", "", "", "", "");
$formValidation->addField("mid_coddetalleestado", true, "numeric", "", "", "", "");
$formValidation->addField("mid_detalleestado", true, "text", "", "", "", "");
$formValidation->addField("geusuario", true, "text", "", "", "", "");
$formValidation->addField("gefechaactua", true, "date", "", "", "", "");
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

$colname_rsinfoalmovdevdia = "-1";
if (isset($_GET['almovdevdia_id'])) {
  $colname_rsinfoalmovdevdia = $_GET['almovdevdia_id'];
}
mysql_select_db($database_oConnAlmacen, $oConnAlmacen);
$query_rsinfoalmovdevdia = sprintf("SELECT * FROM q_almovdevdia WHERE almovdevdia_id = %s", GetSQLValueString($colname_rsinfoalmovdevdia, "int"));
$rsinfoalmovdevdia = mysql_query($query_rsinfoalmovdevdia, $oConnAlmacen) or die(mysql_error());
$row_rsinfoalmovdevdia = mysql_fetch_assoc($rsinfoalmovdevdia);
$totalRows_rsinfoalmovdevdia = mysql_num_rows($rsinfoalmovdevdia);

$colname_rsinfogendocumentos = "-1";
if (isset($_GET['doclasedoc_id'])) {
  $colname_rsinfogendocumentos = $_GET['doclasedoc_id'];
}
mysql_select_db($database_oConnAlmacen, $oConnAlmacen);
$query_rsinfogendocumentos = sprintf("SELECT * FROM gedocumentos WHERE doclasedoc_id = %s", GetSQLValueString($colname_rsinfogendocumentos, "int"));
$rsinfogendocumentos = mysql_query($query_rsinfogendocumentos, $oConnAlmacen) or die(mysql_error());
$row_rsinfogendocumentos = mysql_fetch_assoc($rsinfogendocumentos);
$totalRows_rsinfogendocumentos = mysql_num_rows($rsinfogendocumentos);

mysql_select_db($database_oConnAlmacen, $oConnAlmacen);
$query_rsconceptos = "SELECT * FROM alconceptos WHERE co_ctrl = 1";
$rsconceptos = mysql_query($query_rsconceptos, $oConnAlmacen) or die(mysql_error());
$row_rsconceptos = mysql_fetch_assoc($rsconceptos);
$totalRows_rsconceptos = mysql_num_rows($rsconceptos);

// Make an insert transaction instance
$ins_almovinddia = new tNG_multipleInsert($conn_oConnAlmacen);
$tNGs->addTransaction($ins_almovinddia);
// Register triggers
$ins_almovinddia->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_almovinddia->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_almovinddia->registerTrigger("END", "Trigger_Default_Redirect", 99, "transact_02.php?almovdevdia_id={GET.almovdevdia_id}&doclasedoc_id={GET.doclasedoc_id}&as_id={GET.as_id}&hash_id={GET.hash_id}&anio_id={GET.anio_id}");
// Add columns
$ins_almovinddia->setTable("almovinddia");
$ins_almovinddia->addColumn("doclasedoc_id_fk", "NUMERIC_TYPE", "POST", "doclasedoc_id_fk");
$ins_almovinddia->addColumn("almovdevdia_id_fk", "NUMERIC_TYPE", "POST", "almovdevdia_id_fk");
$ins_almovinddia->addColumn("midclasedoc", "NUMERIC_TYPE", "POST", "midclasedoc");
$ins_almovinddia->addColumn("midnrodoc", "NUMERIC_TYPE", "POST", "midnrodoc");
$ins_almovinddia->addColumn("midfechadoc", "DATE_TYPE", "POST", "midfechadoc");
$ins_almovinddia->addColumn("midalmacen", "STRING_TYPE", "POST", "midalmacen");
$ins_almovinddia->addColumn("midtipoestruc", "STRING_TYPE", "POST", "midtipoestruc");
$ins_almovinddia->addColumn("midcuenta", "STRING_TYPE", "POST", "midcuenta");
$ins_almovinddia->addColumn("midcodelem", "NUMERIC_TYPE", "POST", "midcodelem");
$ins_almovinddia->addColumn("midnroplaca", "STRING_TYPE", "POST", "midnroplaca");
$ins_almovinddia->addColumn("midnroserie", "STRING_TYPE", "POST", "midnroserie");
$ins_almovinddia->addColumn("midfuncionario", "STRING_TYPE", "POST", "midfuncionario");
$ins_almovinddia->addColumn("mid_valunit", "DOUBLE_TYPE", "POST", "mid_valunit");
$ins_almovinddia->addColumn("mid_tax", "DOUBLE_TYPE", "POST", "mid_tax");
$ins_almovinddia->addColumn("mid_valormovto", "DOUBLE_TYPE", "POST", "mid_valormovto");
$ins_almovinddia->addColumn("mid_vidautiladi", "NUMERIC_TYPE", "POST", "mid_vidautiladi");
$ins_almovinddia->addColumn("mid_estadocons", "STRING_TYPE", "POST", "mid_estadocons");
$ins_almovinddia->addColumn("mid_estadoelem", "STRING_TYPE", "POST", "mid_estadoelem");
$ins_almovinddia->addColumn("mid_coddetalleestado", "NUMERIC_TYPE", "POST", "mid_coddetalleestado");
$ins_almovinddia->addColumn("mid_detalleestado", "STRING_TYPE", "POST", "mid_detalleestado");
$ins_almovinddia->addColumn("geusuario", "STRING_TYPE", "POST", "geusuario");
$ins_almovinddia->addColumn("gefechaactua", "DATE_TYPE", "POST", "gefechaactua");
$ins_almovinddia->setPrimaryKey("almovinddia_id", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_almovinddia = new tNG_multipleUpdate($conn_oConnAlmacen);
$tNGs->addTransaction($upd_almovinddia);
// Register triggers
$upd_almovinddia->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_almovinddia->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_almovinddia->registerTrigger("END", "Trigger_Default_Redirect", 99, "transact_02.php?almovdevdia_id={GET.almovdevdia_id}&doclasedoc_id={GET.doclasedoc_id}&as_id={GET.as_id}&hash_id={GET.hash_id}&anio_id={GET.anio_id}");
// Add columns
$upd_almovinddia->setTable("almovinddia");
$upd_almovinddia->addColumn("doclasedoc_id_fk", "NUMERIC_TYPE", "POST", "doclasedoc_id_fk");
$upd_almovinddia->addColumn("almovdevdia_id_fk", "NUMERIC_TYPE", "POST", "almovdevdia_id_fk");
$upd_almovinddia->addColumn("midclasedoc", "NUMERIC_TYPE", "POST", "midclasedoc");
$upd_almovinddia->addColumn("midnrodoc", "NUMERIC_TYPE", "POST", "midnrodoc");
$upd_almovinddia->addColumn("midfechadoc", "DATE_TYPE", "POST", "midfechadoc");
$upd_almovinddia->addColumn("midalmacen", "STRING_TYPE", "POST", "midalmacen");
$upd_almovinddia->addColumn("midtipoestruc", "STRING_TYPE", "POST", "midtipoestruc");
$upd_almovinddia->addColumn("midcuenta", "STRING_TYPE", "POST", "midcuenta");
$upd_almovinddia->addColumn("midcodelem", "NUMERIC_TYPE", "POST", "midcodelem");
$upd_almovinddia->addColumn("midnroplaca", "STRING_TYPE", "POST", "midnroplaca");
$upd_almovinddia->addColumn("midnroserie", "STRING_TYPE", "POST", "midnroserie");
$upd_almovinddia->addColumn("midfuncionario", "STRING_TYPE", "POST", "midfuncionario");
$upd_almovinddia->addColumn("mid_valunit", "DOUBLE_TYPE", "POST", "mid_valunit");
$upd_almovinddia->addColumn("mid_tax", "DOUBLE_TYPE", "POST", "mid_tax");
$upd_almovinddia->addColumn("mid_valormovto", "DOUBLE_TYPE", "POST", "mid_valormovto");
$upd_almovinddia->addColumn("mid_vidautiladi", "NUMERIC_TYPE", "POST", "mid_vidautiladi");
$upd_almovinddia->addColumn("mid_estadocons", "STRING_TYPE", "POST", "mid_estadocons");
$upd_almovinddia->addColumn("mid_estadoelem", "STRING_TYPE", "POST", "mid_estadoelem");
$upd_almovinddia->addColumn("mid_coddetalleestado", "NUMERIC_TYPE", "POST", "mid_coddetalleestado");
$upd_almovinddia->addColumn("mid_detalleestado", "STRING_TYPE", "POST", "mid_detalleestado");
$upd_almovinddia->addColumn("geusuario", "STRING_TYPE", "POST", "geusuario");
$upd_almovinddia->addColumn("gefechaactua", "DATE_TYPE", "POST", "gefechaactua");
$upd_almovinddia->setPrimaryKey("almovinddia_id", "NUMERIC_TYPE", "GET", "almovinddia_id");

// Make an instance of the transaction object
$del_almovinddia = new tNG_multipleDelete($conn_oConnAlmacen);
$tNGs->addTransaction($del_almovinddia);
// Register triggers
$del_almovinddia->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_almovinddia->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$del_almovinddia->setTable("almovinddia");
$del_almovinddia->setPrimaryKey("almovinddia_id", "NUMERIC_TYPE", "GET", "almovinddia_id");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsalmovinddia = $tNGs->getRecordset("almovinddia");
$row_rsalmovinddia = mysql_fetch_assoc($rsalmovinddia);
$totalRows_rsalmovinddia = mysql_num_rows($rsalmovinddia);
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
  duplicate_buttons: true,
  show_as_grid: true,
  merge_down_value: true
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
if (@$_GET['almovinddia_id'] == "") {
?>
      <?php echo NXT_getResource("Insert_FH"); ?>
      <?php 
// else Conditional region1
} else { ?>
      <?php echo NXT_getResource("Update_FH"); ?>
      <?php } 
// endif Conditional region1
?>
    Almovinddia </h1>
  <div class="KT_tngform">
    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
      <?php $cnt1 = 0; ?>
      <?php do { ?>
        <?php $cnt1++; ?>
        <?php 
// Show IF Conditional region1 
if (@$totalRows_rsalmovinddia > 1) {
?>
          <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
          <?php } 
// endif Conditional region1
?>
        <table cellpadding="2" cellspacing="0" class="KT_tngtable">
          <tr>
            <td class="KT_th">&nbsp;</td>
            <td><input name="doclasedoc_id_fk_<?php echo $cnt1; ?>" type="hidden" id="doclasedoc_id_fk_<?php echo $cnt1; ?>" value="<?php echo $row_rsinfoalmovdevdia['doclasedoc_id_fk']; ?>" size="7" />
                <?php echo $tNGs->displayFieldHint("doclasedoc_id_fk");?> <?php echo $tNGs->displayFieldError("almovinddia", "doclasedoc_id_fk", $cnt1); ?> <input name="almovdevdia_id_fk_<?php echo $cnt1; ?>" type="hidden" id="almovdevdia_id_fk_<?php echo $cnt1; ?>" value="<?php echo $row_rsinfoalmovdevdia['almovdevdia_id']; ?>" size="7" />
                <?php echo $tNGs->displayFieldHint("almovdevdia_id_fk");?> <?php echo $tNGs->displayFieldError("almovinddia", "almovdevdia_id_fk", $cnt1); ?> <input name="midclasedoc_<?php echo $cnt1; ?>" type="hidden" id="midclasedoc_<?php echo $cnt1; ?>" value="<?php echo $row_rsinfogendocumentos['doclasedoc']; ?>" size="7" />
                <?php echo $tNGs->displayFieldHint("midclasedoc");?> <?php echo $tNGs->displayFieldError("almovinddia", "midclasedoc", $cnt1); ?> <input name="midnrodoc_<?php echo $cnt1; ?>" type="hidden" id="midnrodoc_<?php echo $cnt1; ?>" value="<?php echo $row_rsinfogendocumentos['do_nrodoc']; ?>" size="7" />
                <?php echo $tNGs->displayFieldHint("midnrodoc");?> <?php echo $tNGs->displayFieldError("almovinddia", "midnrodoc", $cnt1); ?> <input name="midfechadoc_<?php echo $cnt1; ?>" type="hidden" id="midfechadoc_<?php echo $cnt1; ?>" value="<?php echo $row_rsinfogendocumentos['do_fechadoc']; ?>" size="10" maxlength="22" />
                <?php echo $tNGs->displayFieldHint("midfechadoc");?> <?php echo $tNGs->displayFieldError("almovinddia", "midfechadoc", $cnt1); ?> <input name="midalmacen_<?php echo $cnt1; ?>" type="hidden" id="midalmacen_<?php echo $cnt1; ?>" value="<?php echo $row_rsinfogendocumentos['docodregion']; ?>" size="3" maxlength="3" />
                <?php echo $tNGs->displayFieldHint("midalmacen");?> <?php echo $tNGs->displayFieldError("almovinddia", "midalmacen", $cnt1); ?> <input type="hidden" name="midtipoestruc_<?php echo $cnt1; ?>" id="midtipoestruc_<?php echo $cnt1; ?>" value="V" size="2" maxlength="2" />
                <?php echo $tNGs->displayFieldHint("midtipoestruc");?> <?php echo $tNGs->displayFieldError("almovinddia", "midtipoestruc", $cnt1); ?> <input name="midcuenta_<?php echo $cnt1; ?>" type="hidden" id="midcuenta_<?php echo $cnt1; ?>" value="<?php echo $row_rsinfoalmovdevdia['mddcuenta']; ?>" size="32" maxlength="50" />
                <?php echo $tNGs->displayFieldHint("midcuenta");?> <?php echo $tNGs->displayFieldError("almovinddia", "midcuenta", $cnt1); ?> <input name="midcodelem_<?php echo $cnt1; ?>" type="hidden" id="midcodelem_<?php echo $cnt1; ?>" value="<?php echo $row_rsinfoalmovdevdia['mddcodelem']; ?>" size="7" />
                <?php echo $tNGs->displayFieldHint("midcodelem");?> <?php echo $tNGs->displayFieldError("almovinddia", "midcodelem", $cnt1); ?> </td>
          </tr>
          
          <tr>
            <td class="KT_th"><label for="midnroplaca_<?php echo $cnt1; ?>">PLACA:</label></td>
            <td><input type="text" name="midnroplaca_<?php echo $cnt1; ?>" id="midnroplaca_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsalmovinddia['midnroplaca']); ?>" size="20" maxlength="20" />
                <?php echo $tNGs->displayFieldHint("midnroplaca");?> <?php echo $tNGs->displayFieldError("almovinddia", "midnroplaca", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="midnroserie_<?php echo $cnt1; ?>">SERIE:</label></td>
            <td><input type="text" name="midnroserie_<?php echo $cnt1; ?>" id="midnroserie_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsalmovinddia['midnroserie']); ?>" size="32" maxlength="100" />
                <?php echo $tNGs->displayFieldHint("midnroserie");?> <?php echo $tNGs->displayFieldError("almovinddia", "midnroserie", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="midfuncionario_<?php echo $cnt1; ?>">FUNCIONARIO:</label></td>
            <td><input type="text" name="midfuncionario_<?php echo $cnt1; ?>" id="midfuncionario_<?php echo $cnt1; ?>" value="700" size="20" maxlength="20" />
                <?php echo $tNGs->displayFieldHint("midfuncionario");?> <?php echo $tNGs->displayFieldError("almovinddia", "midfuncionario", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="mid_valunit_<?php echo $cnt1; ?>">VALOR UNITARIO:</label></td>
            <td><input name="mid_valunit_<?php echo $cnt1; ?>" type="text" id="mid_valunit_<?php echo $cnt1; ?>" value="<?php echo $row_rsinfoalmovdevdia['mdd_valunit']; ?>" size="7" />
                <?php echo $tNGs->displayFieldHint("mid_valunit");?> <?php echo $tNGs->displayFieldError("almovinddia", "mid_valunit", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="mid_tax_<?php echo $cnt1; ?>">IMPUESTO:</label></td>
            <td><input name="mid_tax_<?php echo $cnt1; ?>" type="text" id="mid_tax_<?php echo $cnt1; ?>" value="<?php echo $row_rsinfoalmovdevdia['mdd_tax']; ?>" size="7" />
                <?php echo $tNGs->displayFieldHint("mid_tax");?> <?php echo $tNGs->displayFieldError("almovinddia", "mid_tax", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th">&nbsp;</td>
            <td><input type="hidden" name="mid_valormovto_<?php echo $cnt1; ?>" id="mid_valormovto_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsalmovinddia['mid_valormovto']); ?>" size="7" />
                <?php echo $tNGs->displayFieldHint("mid_valormovto");?> <?php echo $tNGs->displayFieldError("almovinddia", "mid_valormovto", $cnt1); ?> <input type="hidden" name="mid_vidautiladi_<?php echo $cnt1; ?>" id="mid_vidautiladi_<?php echo $cnt1; ?>" value="0" size="7" />
                <?php echo $tNGs->displayFieldHint("mid_vidautiladi");?> <?php echo $tNGs->displayFieldError("almovinddia", "mid_vidautiladi", $cnt1); ?> <input type="hidden" name="mid_estadocons_<?php echo $cnt1; ?>" id="mid_estadocons_<?php echo $cnt1; ?>" value="1" size="2" maxlength="2" />
                <?php echo $tNGs->displayFieldHint("mid_estadocons");?> <?php echo $tNGs->displayFieldError("almovinddia", "mid_estadocons", $cnt1); ?> <input type="hidden" name="mid_estadoelem_<?php echo $cnt1; ?>" id="mid_estadoelem_<?php echo $cnt1; ?>" value="B" size="2" maxlength="2" />
                <?php echo $tNGs->displayFieldHint("mid_estadoelem");?> <?php echo $tNGs->displayFieldError("almovinddia", "mid_estadoelem", $cnt1); ?> </td>
          </tr>
          
          <tr>
            <td class="KT_th"><label for="mid_coddetalleestado_<?php echo $cnt1; ?>">Mid_coddetalleestado:</label></td>
            <td><select name="mid_coddetalleestado_<?php echo $cnt1; ?>" id="mid_coddetalleestado_<?php echo $cnt1; ?>">
              <?php
do {  
?>
              <option value="<?php echo $row_rsconceptos['co_codconcepto']?>"<?php if (!(strcmp($row_rsconceptos['co_codconcepto'], KT_escapeAttribute($row_rsalmovinddia['mid_coddetalleestado'])))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsconceptos['co_nomconcepto']?></option>
              <?php
} while ($row_rsconceptos = mysql_fetch_assoc($rsconceptos));
  $rows = mysql_num_rows($rsconceptos);
  if($rows > 0) {
      mysql_data_seek($rsconceptos, 0);
	  $row_rsconceptos = mysql_fetch_assoc($rsconceptos);
  }
?>
            </select>
            <?php echo $tNGs->displayFieldHint("mid_coddetalleestado");?> <?php echo $tNGs->displayFieldError("almovinddia", "mid_coddetalleestado", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th">&nbsp;</td>
            <td><input type="hidden" name="mid_detalleestado_<?php echo $cnt1; ?>" id="mid_detalleestado_<?php echo $cnt1; ?>" value="x" size="32" maxlength="100" />
                <?php echo $tNGs->displayFieldHint("mid_detalleestado");?> <?php echo $tNGs->displayFieldError("almovinddia", "mid_detalleestado", $cnt1); ?> <input name="geusuario_<?php echo $cnt1; ?>" type="hidden" id="geusuario_<?php echo $cnt1; ?>" value="<?php echo $_SESSION['kt_login_user']; ?>" size="20" maxlength="20" />
                <?php echo $tNGs->displayFieldHint("geusuario");?> <?php echo $tNGs->displayFieldError("almovinddia", "geusuario", $cnt1); ?> <input type="hidden" name="gefechaactua_<?php echo $cnt1; ?>" id="gefechaactua_<?php echo $cnt1; ?>" value="<?php echo $fecha; ?>" size="10" maxlength="22" />
                <?php echo $tNGs->displayFieldHint("gefechaactua");?> <?php echo $tNGs->displayFieldError("almovinddia", "gefechaactua", $cnt1); ?> </td>
          </tr>
        </table>
        <input type="hidden" name="kt_pk_almovinddia_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rsalmovinddia['kt_pk_almovinddia']); ?>" />
        <?php } while ($row_rsalmovinddia = mysql_fetch_assoc($rsalmovinddia)); ?>
      <div class="KT_bottombuttons">
        <div>
          <?php 
      // Show IF Conditional region1
      if (@$_GET['almovinddia_id'] == "") {
      ?>
            <input type="submit" name="KT_Insert1" id="KT_Insert1" value="<?php echo NXT_getResource("Insert_FB"); ?>" />
            <?php 
      // else Conditional region1
      } else { ?>
            <div class="KT_operations">
              <input type="submit" name="KT_Insert1" value="<?php echo NXT_getResource("Insert as new_FB"); ?>" onclick="nxt_form_insertasnew(this, 'almovinddia_id')" />
            </div>
            <input type="submit" name="KT_Update1" value="<?php echo NXT_getResource("Update_FB"); ?>" />
            <input type="submit" name="KT_Delete1" value="<?php echo NXT_getResource("Delete_FB"); ?>" onclick="return confirm('<?php echo NXT_getResource("Are you sure?"); ?>');" />
            <?php }
      // endif Conditional region1
      ?>
          <input type="button" name="KT_Cancel1" value="<?php echo NXT_getResource("Cancel_FB"); ?>" onclick="return UNI_navigateCancel(event, '../includes/nxt/back.php')" />
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
mysql_free_result($rsinfoalmovdevdia);

mysql_free_result($rsinfogendocumentos);

mysql_free_result($rsconceptos);
?>
