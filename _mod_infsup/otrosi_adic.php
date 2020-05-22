<?php require_once('../Connections/oConnContratos.php'); ?>
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
$formValidation->addField("cont_otrosi_type", true, "numeric", "", "", "", "");
$formValidation->addField("cont_valoradic_fecha", true, "date", "", "", "", "");
$formValidation->addField("cont_valoradic", true, "double", "", "", "", "");
$formValidation->addField("cont_valorvigente", true, "text", "", "", "", "");
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

$colname_rsinfocont = "-1";
if (isset($_GET['doc_id'])) {
  $colname_rsinfocont = $_GET['doc_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rsinfocont = sprintf("SELECT * FROM contrato WHERE id_cont = %s", GetSQLValueString($colname_rsinfocont, "int"));
$rsinfocont = mysql_query($query_rsinfocont, $oConnContratos) or die(mysql_error());
$row_rsinfocont = mysql_fetch_assoc($rsinfocont);
$totalRows_rsinfocont = mysql_num_rows($rsinfocont);

// Make an insert transaction instance
$ins_contrato = new tNG_multipleInsert($conn_oConnContratos);
$tNGs->addTransaction($ins_contrato);
// Register triggers
$ins_contrato->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_contrato->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_contrato->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$ins_contrato->setTable("contrato");
$ins_contrato->addColumn("cont_otrosi_type", "NUMERIC_TYPE", "POST", "cont_otrosi_type");
$ins_contrato->addColumn("cont_valoradic_fecha", "DATE_TYPE", "POST", "cont_valoradic_fecha");
$ins_contrato->addColumn("cont_valoradic", "DOUBLE_TYPE", "POST", "cont_valoradic");
$ins_contrato->addColumn("cont_valorvigente", "STRING_TYPE", "POST", "cont_valorvigente");
$ins_contrato->setPrimaryKey("id_cont", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_contrato = new tNG_multipleUpdate($conn_oConnContratos);
$tNGs->addTransaction($upd_contrato);
// Register triggers
$upd_contrato->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_contrato->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_contrato->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$upd_contrato->setTable("contrato");
$upd_contrato->addColumn("cont_otrosi_type", "NUMERIC_TYPE", "POST", "cont_otrosi_type");
$upd_contrato->addColumn("cont_valoradic_fecha", "DATE_TYPE", "POST", "cont_valoradic_fecha");
$upd_contrato->addColumn("cont_valoradic", "DOUBLE_TYPE", "POST", "cont_valoradic");
$upd_contrato->addColumn("cont_valorvigente", "STRING_TYPE", "POST", "cont_valorvigente");
$upd_contrato->setPrimaryKey("id_cont", "NUMERIC_TYPE", "GET", "id_cont");

// Make an instance of the transaction object
$del_contrato = new tNG_multipleDelete($conn_oConnContratos);
$tNGs->addTransaction($del_contrato);
// Register triggers
$del_contrato->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_contrato->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$del_contrato->setTable("contrato");
$del_contrato->setPrimaryKey("id_cont", "NUMERIC_TYPE", "GET", "id_cont");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rscontrato = $tNGs->getRecordset("contrato");
$row_rscontrato = mysql_fetch_assoc($rscontrato);
$totalRows_rscontrato = mysql_num_rows($rscontrato);
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
if (@$_GET['id_cont'] == "") {
?>
      <?php echo NXT_getResource("Insert_FH"); ?>
      <?php 
// else Conditional region1
} else { ?>
      <?php echo NXT_getResource("Update_FH"); ?>
      <?php } 
// endif Conditional region1
?>
    Contrato </h1>
  <div class="KT_tngform">
    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
      <?php $cnt1 = 0; ?>
      <?php do { ?>
        <?php $cnt1++; ?>
        <?php 
// Show IF Conditional region1 
if (@$totalRows_rscontrato > 1) {
?>
          <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
          <?php } 
// endif Conditional region1
?>
        <table cellpadding="2" cellspacing="0" class="KT_tngtable">
          <tr>
            <td class="KT_th"><label for="cont_otrosi_type_<?php echo $cnt1; ?>">Cont_otrosi_type:</label></td>
            <td><input type="text" name="cont_otrosi_type_<?php echo $cnt1; ?>" id="cont_otrosi_type_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscontrato['cont_otrosi_type']); ?>" size="2" />
                <?php echo $tNGs->displayFieldHint("cont_otrosi_type");?> <?php echo $tNGs->displayFieldError("contrato", "cont_otrosi_type", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="cont_valoradic_fecha_<?php echo $cnt1; ?>">Cont_valoradic_fecha:</label></td>
            <td><input type="text" name="cont_valoradic_fecha_<?php echo $cnt1; ?>" id="cont_valoradic_fecha_<?php echo $cnt1; ?>" value="<?php echo KT_formatDate($row_rscontrato['cont_valoradic_fecha']); ?>" size="10" maxlength="22" />
                <?php echo $tNGs->displayFieldHint("cont_valoradic_fecha");?> <?php echo $tNGs->displayFieldError("contrato", "cont_valoradic_fecha", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="cont_valoradic_<?php echo $cnt1; ?>">Cont_valoradic:</label></td>
            <td><input type="text" name="cont_valoradic_<?php echo $cnt1; ?>" id="cont_valoradic_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscontrato['cont_valoradic']); ?>" size="7" />
                <?php echo $tNGs->displayFieldHint("cont_valoradic");?> <?php echo $tNGs->displayFieldError("contrato", "cont_valoradic", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="cont_valorvigente_<?php echo $cnt1; ?>">Cont_valorvigente:</label></td>
            <td><input type="text" name="cont_valorvigente_<?php echo $cnt1; ?>" id="cont_valorvigente_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscontrato['cont_valorvigente']); ?>" size="20" maxlength="20" />
                <?php echo $tNGs->displayFieldHint("cont_valorvigente");?> <?php echo $tNGs->displayFieldError("contrato", "cont_valorvigente", $cnt1); ?> </td>
          </tr>
        </table>
        <input type="hidden" name="kt_pk_contrato_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rscontrato['kt_pk_contrato']); ?>" />
        <?php } while ($row_rscontrato = mysql_fetch_assoc($rscontrato)); ?>
      <div class="KT_bottombuttons">
        <div>
          <?php 
      // Show IF Conditional region1
      if (@$_GET['id_cont'] == "") {
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
mysql_free_result($rsinfocont);
?>
