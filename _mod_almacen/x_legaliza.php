<?php require_once('../Connections/oConnAlmacen.php'); ?>
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
$formValidation->addField("md_legalizado", true, "text", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

// Make an insert transaction instance
$ins_almovtodia = new tNG_multipleInsert($conn_oConnAlmacen);
$tNGs->addTransaction($ins_almovtodia);
// Register triggers
$ins_almovtodia->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_almovtodia->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_almovtodia->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$ins_almovtodia->setTable("almovtodia");
$ins_almovtodia->addColumn("md_legalizado", "STRING_TYPE", "POST", "md_legalizado");
$ins_almovtodia->setPrimaryKey("almovtodia_id", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_almovtodia = new tNG_multipleUpdate($conn_oConnAlmacen);
$tNGs->addTransaction($upd_almovtodia);
// Register triggers
$upd_almovtodia->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_almovtodia->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_almovtodia->registerTrigger("END", "Trigger_Default_Redirect", 99, "ok.php");
// Add columns
$upd_almovtodia->setTable("almovtodia");
$upd_almovtodia->addColumn("md_legalizado", "STRING_TYPE", "POST", "md_legalizado");
$upd_almovtodia->setPrimaryKey("almovtodia_id", "NUMERIC_TYPE", "GET", "almovtodia_id");

// Make an instance of the transaction object
$del_almovtodia = new tNG_multipleDelete($conn_oConnAlmacen);
$tNGs->addTransaction($del_almovtodia);
// Register triggers
$del_almovtodia->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_almovtodia->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$del_almovtodia->setTable("almovtodia");
$del_almovtodia->setPrimaryKey("almovtodia_id", "NUMERIC_TYPE", "GET", "almovtodia_id");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsalmovtodia = $tNGs->getRecordset("almovtodia");
$row_rsalmovtodia = mysql_fetch_assoc($rsalmovtodia);
$totalRows_rsalmovtodia = mysql_num_rows($rsalmovtodia);
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
if (@$_GET['almovtodia_id'] == "") {
?>
      <?php echo NXT_getResource("Insert_FH"); ?>
      <?php 
// else Conditional region1
} else { ?>
      <?php echo NXT_getResource("Update_FH"); ?>
      <?php } 
// endif Conditional region1
?>
    Almovtodia </h1>
  <div class="KT_tngform">
    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
      <?php $cnt1 = 0; ?>
      <?php do { ?>
        <?php $cnt1++; ?>
        <?php 
// Show IF Conditional region1 
if (@$totalRows_rsalmovtodia > 1) {
?>
          <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
          <?php } 
// endif Conditional region1
?>
        <table cellpadding="2" cellspacing="0" class="KT_tngtable">
          <tr>
            <td class="KT_th"><label for="md_legalizado_<?php echo $cnt1; ?>">Confirma que desea legalizar el movimiento?:</label></td>
            <td><input name="md_legalizado_<?php echo $cnt1; ?>" type="text" id="md_legalizado_<?php echo $cnt1; ?>" value="S" size="2" maxlength="2" readonly="true" />
                <?php echo $tNGs->displayFieldHint("md_legalizado");?> <?php echo $tNGs->displayFieldError("almovtodia", "md_legalizado", $cnt1); ?> </td>
          </tr>
        </table>
        <input type="hidden" name="kt_pk_almovtodia_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rsalmovtodia['kt_pk_almovtodia']); ?>" />
        <?php } while ($row_rsalmovtodia = mysql_fetch_assoc($rsalmovtodia)); ?>
      <div class="KT_bottombuttons">
        <div>
          <?php 
      // Show IF Conditional region1
      if (@$_GET['almovtodia_id'] == "") {
      ?>
            <input type="submit" name="KT_Insert1" id="KT_Insert1" value="<?php echo NXT_getResource("Insert_FB"); ?>" />
            <?php 
      // else Conditional region1
      } else { ?>
            <input type="submit" name="KT_Update1" value="Confirmar" />
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
