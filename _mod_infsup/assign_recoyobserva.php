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
$formValidation->addField("inf_recomyobserva", true, "text", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

// Make an insert transaction instance
$ins_informe_intersup = new tNG_multipleInsert($conn_oConnContratos);
$tNGs->addTransaction($ins_informe_intersup);
// Register triggers
$ins_informe_intersup->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_informe_intersup->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_informe_intersup->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$ins_informe_intersup->setTable("informe_intersup");
$ins_informe_intersup->addColumn("inf_recomyobserva", "STRING_TYPE", "POST", "inf_recomyobserva");
$ins_informe_intersup->setPrimaryKey("inf_id", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_informe_intersup = new tNG_multipleUpdate($conn_oConnContratos);
$tNGs->addTransaction($upd_informe_intersup);
// Register triggers
$upd_informe_intersup->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_informe_intersup->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_informe_intersup->registerTrigger("END", "Trigger_Default_Redirect", 99, "ok.php");
// Add columns
$upd_informe_intersup->setTable("informe_intersup");
$upd_informe_intersup->addColumn("inf_recomyobserva", "STRING_TYPE", "POST", "inf_recomyobserva");
$upd_informe_intersup->setPrimaryKey("inf_id", "NUMERIC_TYPE", "GET", "inf_id");

// Make an instance of the transaction object
$del_informe_intersup = new tNG_multipleDelete($conn_oConnContratos);
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
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
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
      <?php echo NXT_getResource("Insert_FH"); ?>
      <?php 
// else Conditional region1
} else { ?>
      <?php echo NXT_getResource("Update_FH"); ?>
      <?php } 
// endif Conditional region1
?>
    Informe_intersup </h1>
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
            <td width="20%" class="KT_th">RECOMENDACIONES Y OBSERVACIONES<br />
            PARA EL ORDENADOR DEL GASTO</td>
            <td width="80%">Descripción de las observaciones o recomendaciones que se tengan para el Ordenador del Gasto, <br />
            si a bien lo tiene el supervisor / interventor del contrato. Anotar otros aspectos que el supervisor<br /> 
            considere indispensables relatar en el informe -inconvenientes, soluciones, <br />
            aspectos positivos que arrojó la ejecución del contrato o convenio, recomendaciones para futuras contrataciones,</td>
          </tr>
          <tr>
            <td class="KT_th">&nbsp;</td>
            <td><textarea name="inf_recomyobserva_<?php echo $cnt1; ?>" id="inf_recomyobserva_<?php echo $cnt1; ?>" cols="70" rows="10"><?php echo KT_escapeAttribute($row_rsinforme_intersup['inf_recomyobserva']); ?></textarea>
                <?php echo $tNGs->displayFieldHint("inf_recomyobserva");?> <?php echo $tNGs->displayFieldError("informe_intersup", "inf_recomyobserva", $cnt1); ?> </td>
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
            <input type="submit" name="KT_Insert1" id="KT_Insert1" value="<?php echo NXT_getResource("Insert_FB"); ?>" />
            <?php 
      // else Conditional region1
      } else { ?>
            <input type="submit" name="KT_Update1" value="Guardar" />
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
