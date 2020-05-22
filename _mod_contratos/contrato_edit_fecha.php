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
$formValidation->addField("cont_fecha_inicio", true, "date", "", "", "", "");
$formValidation->addField("cont_fechafinal", true, "date", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

// Make an insert transaction instance
$ins_contrato = new tNG_multipleInsert($conn_oConnContratos);
$tNGs->addTransaction($ins_contrato);
// Register triggers
$ins_contrato->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_contrato->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_contrato->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$ins_contrato->setTable("contrato");
$ins_contrato->addColumn("cont_fecha_inicio", "DATE_TYPE", "POST", "cont_fecha_inicio");
$ins_contrato->addColumn("cont_fechafinal", "DATE_TYPE", "POST", "cont_fechafinal");
$ins_contrato->setPrimaryKey("id_cont", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_contrato = new tNG_multipleUpdate($conn_oConnContratos);
$tNGs->addTransaction($upd_contrato);
// Register triggers
$upd_contrato->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_contrato->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_contrato->registerTrigger("END", "Trigger_Default_Redirect", 99, "ok.php");
// Add columns
$upd_contrato->setTable("contrato");
$upd_contrato->addColumn("cont_fecha_inicio", "DATE_TYPE", "POST", "cont_fecha_inicio");
$upd_contrato->addColumn("cont_estado", "NUMERIC_TYPE", "POST", "estado");
$upd_contrato->addColumn("cont_fechafinal", "DATE_TYPE", "POST", "cont_fechafinal");
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
	<link rel="stylesheet" href="../_jquery/_desktop/_app/themes/south-street/jquery.ui.all.css">
	<script src="../_jquery/_desktop/_app/jquery-1.9.1.js"></script>
	<script src="../_jquery/_desktop/_app/ui/jquery.ui.core.js"></script>
	<script src="../_jquery/_desktop/_app/ui/jquery.ui.widget.js"></script>
	<script src="../_jquery/_desktop/_app/ui/jquery.ui.datepicker.js"></script>
	<link rel="stylesheet" href="../_jquery/_desktop/_app/_modules/demos.css">
	<script>
	$(function() {
		$( "#fechai" ).datepicker({
			changeMonth: true,
			changeYear: true
		});
		$( "#fechaf" ).datepicker({
			changeMonth: true,
			changeYear: true
		});
	});
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
  </h1>
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
            <td width="16%" class="KT_th"><label for="cont_fecha_inicio_<?php echo $cnt1; ?>">FECHA INICIO DEL CONTRATO:</label></td>
            <td width="84%"><input type="text" name="cont_fecha_inicio_<?php echo $cnt1; ?>" id="fechai" value="<?php echo KT_formatDate($row_rscontrato['cont_fecha_inicio']); ?>" size="10" maxlength="22" />
                <?php echo $tNGs->displayFieldHint("cont_fecha_inicio");?> <?php echo $tNGs->displayFieldError("contrato", "cont_fecha_inicio", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="cont_fechafinal_<?php echo $cnt1; ?>">FECHA FINAL DEL CONTRATO:</label></td>
            <td><input type="text" name="cont_fechafinal_<?php echo $cnt1; ?>" id="fechaf" value="<?php echo KT_formatDate($row_rscontrato['cont_fechafinal']); ?>" size="10" maxlength="22" />
                <?php echo $tNGs->displayFieldHint("cont_fechafinal");?> <?php echo $tNGs->displayFieldError("contrato", "cont_fechafinal", $cnt1); ?> <input name="estado" type="hidden" id="estado" value="2" /></td>
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
