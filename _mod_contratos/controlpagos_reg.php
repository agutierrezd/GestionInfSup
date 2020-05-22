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
$formValidation->addField("id_cont_fk", true, "numeric", "", "", "", "");
$formValidation->addField("ctrlpagos_fecha", true, "date", "", "", "", "");
$formValidation->addField("ctrlpagos_desc", true, "text", "", "", "", "");
$formValidation->addField("ctrlpagos_valor", true, "double", "", "", "", "");
$formValidation->addField("ctrlpagos_saldo", true, "double", "", "", "", "");
$formValidation->addField("sys_fecha", true, "date", "", "", "", "");
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

$colname_rsinfoct = "-1";
if (isset($_GET['id_cont'])) {
  $colname_rsinfoct = $_GET['id_cont'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rsinfoct = sprintf("SELECT * FROM contrato WHERE id_cont = %s", GetSQLValueString($colname_rsinfoct, "int"));
$rsinfoct = mysql_query($query_rsinfoct, $oConnContratos) or die(mysql_error());
$row_rsinfoct = mysql_fetch_assoc($rsinfoct);
$totalRows_rsinfoct = mysql_num_rows($rsinfoct);

// Make an insert transaction instance
$ins_contrato_controlpagos = new tNG_multipleInsert($conn_oConnContratos);
$tNGs->addTransaction($ins_contrato_controlpagos);
// Register triggers
$ins_contrato_controlpagos->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_contrato_controlpagos->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_contrato_controlpagos->registerTrigger("END", "Trigger_Default_Redirect", 99, "ok.php");
// Add columns
$ins_contrato_controlpagos->setTable("contrato_controlpagos");
$ins_contrato_controlpagos->addColumn("id_cont_fk", "NUMERIC_TYPE", "POST", "id_cont_fk");
$ins_contrato_controlpagos->addColumn("ctrlpagos_fecha", "DATE_TYPE", "POST", "ctrlpagos_fecha");
$ins_contrato_controlpagos->addColumn("ctrlpagos_desc", "STRING_TYPE", "POST", "ctrlpagos_desc");
$ins_contrato_controlpagos->addColumn("ctrlpagos_valor", "DOUBLE_TYPE", "POST", "ctrlpagos_valor");
$ins_contrato_controlpagos->addColumn("ctrlpagos_saldo", "DOUBLE_TYPE", "POST", "ctrlpagos_saldo");
$ins_contrato_controlpagos->addColumn("sys_fecha", "DATE_TYPE", "POST", "sys_fecha");
$ins_contrato_controlpagos->addColumn("sys_user", "STRING_TYPE", "POST", "sys_user");
$ins_contrato_controlpagos->setPrimaryKey("ctrlpagos_id", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_contrato_controlpagos = new tNG_multipleUpdate($conn_oConnContratos);
$tNGs->addTransaction($upd_contrato_controlpagos);
// Register triggers
$upd_contrato_controlpagos->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_contrato_controlpagos->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_contrato_controlpagos->registerTrigger("END", "Trigger_Default_Redirect", 99, "okm.php");
// Add columns
$upd_contrato_controlpagos->setTable("contrato_controlpagos");
$upd_contrato_controlpagos->addColumn("id_cont_fk", "NUMERIC_TYPE", "POST", "id_cont_fk");
$upd_contrato_controlpagos->addColumn("ctrlpagos_fecha", "DATE_TYPE", "POST", "ctrlpagos_fecha");
$upd_contrato_controlpagos->addColumn("ctrlpagos_desc", "STRING_TYPE", "POST", "ctrlpagos_desc");
$upd_contrato_controlpagos->addColumn("ctrlpagos_valor", "DOUBLE_TYPE", "POST", "ctrlpagos_valor");
$upd_contrato_controlpagos->addColumn("ctrlpagos_saldo", "DOUBLE_TYPE", "POST", "ctrlpagos_saldo");
$upd_contrato_controlpagos->addColumn("sys_fecha", "DATE_TYPE", "POST", "sys_fecha");
$upd_contrato_controlpagos->addColumn("sys_user", "STRING_TYPE", "POST", "sys_user");
$upd_contrato_controlpagos->setPrimaryKey("ctrlpagos_id", "NUMERIC_TYPE", "GET", "ctrlpagos_id");

// Make an instance of the transaction object
$del_contrato_controlpagos = new tNG_multipleDelete($conn_oConnContratos);
$tNGs->addTransaction($del_contrato_controlpagos);
// Register triggers
$del_contrato_controlpagos->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_contrato_controlpagos->registerTrigger("END", "Trigger_Default_Redirect", 99, "oka.php");
// Add columns
$del_contrato_controlpagos->setTable("contrato_controlpagos");
$del_contrato_controlpagos->setPrimaryKey("ctrlpagos_id", "NUMERIC_TYPE", "GET", "ctrlpagos_id");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rscontrato_controlpagos = $tNGs->getRecordset("contrato_controlpagos");
$row_rscontrato_controlpagos = mysql_fetch_assoc($rscontrato_controlpagos);
$totalRows_rscontrato_controlpagos = mysql_num_rows($rscontrato_controlpagos);
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
<link rel="stylesheet" href="../_jquery/_desktop/_app/themes/south-street/jquery.ui.all.css">
	<script src="../_jquery/_desktop/_app/jquery-1.9.1.js"></script>
	<script src="../_jquery/_desktop/_app/ui/jquery.ui.core.js"></script>
	<script src="../_jquery/_desktop/_app/ui/jquery.ui.widget.js"></script>
	<script src="../_jquery/_desktop/_app/ui/jquery.ui.datepicker.js"></script>
	<link rel="stylesheet" href="../_jquery/_desktop/_app/_modules/demos.css">
	<script>
	$(function() {
		$( "#datepicker" ).datepicker({
			changeMonth: true,
			changeYear: true
		});
	});
	</script>
	<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js"></script>
	<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js.php"></script>
	<script type="text/javascript" src="../includes/wdg/classes/NumericInput.js"></script>
</head>

<body> 
<?php
	echo $tNGs->getErrorMsg();
?>
<div class="KT_tng">
  <h1>
    <?php 
// Show IF Conditional region1 
if (@$_GET['ctrlpagos_id'] == "") {
?>
      <?php echo NXT_getResource("Insert_FH"); ?>
      <?php 
// else Conditional region1
} else { ?>
      <?php echo NXT_getResource("Update_FH"); ?>
      <?php } 
// endif Conditional region1
?>
    pago </h1>
  <div class="KT_tngform">
    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
      <?php $cnt1 = 0; ?>
      <?php do { ?>
        <?php $cnt1++; ?>
        <?php 
// Show IF Conditional region1 
if (@$totalRows_rscontrato_controlpagos > 1) {
?>
          <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
          <?php } 
// endif Conditional region1
?>
        <table cellpadding="2" cellspacing="0" class="KT_tngtable">
          <tr>
            <td class="KT_th">&nbsp;</td>
            <td><input name="id_cont_fk_<?php echo $cnt1; ?>" type="hidden" id="id_cont_fk_<?php echo $cnt1; ?>" value="<?php echo $row_rsinfoct['id_cont']; ?>" size="7" />
                <?php echo $tNGs->displayFieldHint("id_cont_fk");?> <?php echo $tNGs->displayFieldError("contrato_controlpagos", "id_cont_fk", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="ctrlpagos_fecha_<?php echo $cnt1; ?>">FECHA:</label></td>
            <td><input type="text" name="ctrlpagos_fecha_<?php echo $cnt1; ?>" id="datepicker" value="<?php echo KT_formatDate($row_rscontrato_controlpagos['ctrlpagos_fecha']); ?>" size="10" maxlength="22" />
                <?php echo $tNGs->displayFieldHint("ctrlpagos_fecha");?> <?php echo $tNGs->displayFieldError("contrato_controlpagos", "ctrlpagos_fecha", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="ctrlpagos_desc_<?php echo $cnt1; ?>">DESCRIPCION:</label></td>
            <td><input type="text" name="ctrlpagos_desc_<?php echo $cnt1; ?>" id="ctrlpagos_desc_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscontrato_controlpagos['ctrlpagos_desc']); ?>" size="70" maxlength="200" onkeyup="this.value=this.value.toUpperCase()" />
                <?php echo $tNGs->displayFieldHint("ctrlpagos_desc");?> <?php echo $tNGs->displayFieldError("contrato_controlpagos", "ctrlpagos_desc", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="ctrlpagos_valor_<?php echo $cnt1; ?>">VALOR:</label></td>
            <td><input type="text" name="ctrlpagos_valor_<?php echo $cnt1; ?>" id="ctrlpagos_valor_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscontrato_controlpagos['ctrlpagos_valor']); ?>" size="20" wdg:negatives="no" wdg:subtype="NumericInput" wdg:type="widget" wdg:floats="yes" wdg:spinner="no" />
                <?php echo $tNGs->displayFieldHint("ctrlpagos_valor");?> <?php echo $tNGs->displayFieldError("contrato_controlpagos", "ctrlpagos_valor", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th">&nbsp;</td>
            <td><input type="hidden" name="ctrlpagos_saldo_<?php echo $cnt1; ?>" id="ctrlpagos_saldo_<?php echo $cnt1; ?>" value="0" size="7" />
                <?php echo $tNGs->displayFieldHint("ctrlpagos_saldo");?> <?php echo $tNGs->displayFieldError("contrato_controlpagos", "ctrlpagos_saldo", $cnt1); ?> <input type="hidden" name="sys_fecha_<?php echo $cnt1; ?>" id="sys_fecha_<?php echo $cnt1; ?>" value="<?php echo $fecha; ?>" size="10" maxlength="22" />
                <?php echo $tNGs->displayFieldHint("sys_fecha");?> <?php echo $tNGs->displayFieldError("contrato_controlpagos", "sys_fecha", $cnt1); ?> <input name="sys_user_<?php echo $cnt1; ?>" type="hidden" id="sys_user_<?php echo $cnt1; ?>" value="<?php echo $_SESSION['kt_login_user']; ?>" size="32" maxlength="60" />
            <?php echo $tNGs->displayFieldHint("sys_user");?> <?php echo $tNGs->displayFieldError("contrato_controlpagos", "sys_user", $cnt1); ?> </td>
          </tr>
        </table>
        <input type="hidden" name="kt_pk_contrato_controlpagos_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rscontrato_controlpagos['kt_pk_contrato_controlpagos']); ?>" />
        <?php } while ($row_rscontrato_controlpagos = mysql_fetch_assoc($rscontrato_controlpagos)); ?>
      <div class="KT_bottombuttons">
        <div>
          <?php 
      // Show IF Conditional region1
      if (@$_GET['ctrlpagos_id'] == "") {
      ?>
            <input type="submit" name="KT_Insert1" id="KT_Insert1" value="<?php echo NXT_getResource("Insert_FB"); ?>" />
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
</div>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($rsinfoct);
?>
