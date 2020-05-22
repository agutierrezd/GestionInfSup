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
$formValidation->addField("inf_declarainconf", true, "numeric", "", "", "", "");
$formValidation->addField("inf_incumplimiento", true, "numeric", "", "", "", "");
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
$ins_informe_intersup->addColumn("inf_declarainconf", "NUMERIC_TYPE", "POST", "inf_declarainconf");
$ins_informe_intersup->addColumn("inf_declarainconf_obs", "STRING_TYPE", "POST", "inf_declarainconf_obs");
$ins_informe_intersup->addColumn("inf_incumplimiento", "NUMERIC_TYPE", "POST", "inf_incumplimiento");
$ins_informe_intersup->addColumn("inf_incumplimiento_obs", "STRING_TYPE", "POST", "inf_incumplimiento_obs");
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
$upd_informe_intersup->addColumn("inf_declarainconf", "NUMERIC_TYPE", "POST", "inf_declarainconf");
$upd_informe_intersup->addColumn("inf_declarainconf_obs", "STRING_TYPE", "POST", "inf_declarainconf_obs");
$upd_informe_intersup->addColumn("inf_incumplimiento", "NUMERIC_TYPE", "POST", "inf_incumplimiento");
$upd_informe_intersup->addColumn("inf_incumplimiento_obs", "STRING_TYPE", "POST", "inf_incumplimiento_obs");
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
if (@$totalRows_rsinforme_intersup > 1) {
?>
          <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
          <?php } 
// endif Conditional region1
?>
        <table cellpadding="2" cellspacing="0" class="KT_tngtable">
          <tr>
            <td width="15%" class="KT_th"><label for="inf_declarainconf_<?php echo $cnt1; ?>_1">Declara conformidad:</label></td>
            <td width="85%"><div>
              <input <?php if (!(strcmp(KT_escapeAttribute($row_rsinforme_intersup['inf_declarainconf']),"1"))) {echo "CHECKED";} ?> type="radio" name="inf_declarainconf_<?php echo $cnt1; ?>" id="inf_declarainconf_<?php echo $cnt1; ?>_1" value="1" />
              <label for="inf_declarainconf_<?php echo $cnt1; ?>_1">Si</label>
            </div>
                <div>
                  <input <?php if (!(strcmp(KT_escapeAttribute($row_rsinforme_intersup['inf_declarainconf']),"9"))) {echo "CHECKED";} ?> type="radio" name="inf_declarainconf_<?php echo $cnt1; ?>" id="inf_declarainconf_<?php echo $cnt1; ?>_2" value="9" />
                  <label for="inf_declarainconf_<?php echo $cnt1; ?>_2">No</label>
                </div>
              <?php echo $tNGs->displayFieldError("informe_intersup", "inf_declarainconf", $cnt1); ?> </td>
          </tr>
          <tr>
            <td colspan="2" class="KT_th">Indicar conformidad o inconformidad
con el resultado actividad desarrollada en el per&iacute;odo informado:</td>
          </tr>
          <tr>
            <td class="KT_th"><label for="inf_declarainconf_obs_<?php echo $cnt1; ?>"></label></td>
            <td><textarea name="inf_declarainconf_obs_<?php echo $cnt1; ?>" id="inf_declarainconf_obs_<?php echo $cnt1; ?>" cols="50" rows="5"><?php echo KT_escapeAttribute($row_rsinforme_intersup['inf_declarainconf_obs']); ?></textarea>
                <?php echo $tNGs->displayFieldHint("inf_declarainconf_obs");?> <?php echo $tNGs->displayFieldError("informe_intersup", "inf_declarainconf_obs", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="inf_incumplimiento_<?php echo $cnt1; ?>_1">Informa incumplimiento <br />
            en las obligaciones del Contrato:</label></td>
            <td><div>
              <input <?php if (!(strcmp(KT_escapeAttribute($row_rsinforme_intersup['inf_incumplimiento']),"1"))) {echo "CHECKED";} ?> type="radio" name="inf_incumplimiento_<?php echo $cnt1; ?>" id="inf_incumplimiento_<?php echo $cnt1; ?>_1" value="1" />
              <label for="inf_incumplimiento_<?php echo $cnt1; ?>_1">S&iacute;</label>
            </div>
                <div>
                  <input <?php if (!(strcmp(KT_escapeAttribute($row_rsinforme_intersup['inf_incumplimiento']),"9"))) {echo "CHECKED";} ?> type="radio" name="inf_incumplimiento_<?php echo $cnt1; ?>" id="inf_incumplimiento_<?php echo $cnt1; ?>_2" value="9" />
                  <label for="inf_incumplimiento_<?php echo $cnt1; ?>_2">No</label>
                </div>
              <?php echo $tNGs->displayFieldError("informe_intersup", "inf_incumplimiento", $cnt1); ?> </td>
          </tr>
          <tr>
            <td colspan="2" class="KT_th">Establecer cuando sea el caso, si se presentan incumplimientos a las obligaciones contractuales. 
              <br />
              En caso tal, se&ntilde;alar tambi&eacute;n los requerimientos realizados
y el Memorando con que informa a la Oficina Asesora Jur&iacute;dica sobre el particular:</td>
          </tr>
          <tr>
            <td class="KT_th"><label for="inf_incumplimiento_obs_<?php echo $cnt1; ?>"></label></td>
            <td><textarea name="inf_incumplimiento_obs_<?php echo $cnt1; ?>" id="inf_incumplimiento_obs_<?php echo $cnt1; ?>" cols="50" rows="5"><?php echo KT_escapeAttribute($row_rsinforme_intersup['inf_incumplimiento_obs']); ?></textarea>
                <?php echo $tNGs->displayFieldHint("inf_incumplimiento_obs");?> <?php echo $tNGs->displayFieldError("informe_intersup", "inf_incumplimiento_obs", $cnt1); ?> </td>
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
</body>
</html>
