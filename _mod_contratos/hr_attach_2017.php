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
$formValidation->addField("hr_file", true, "", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

//start Trigger_FileDelete trigger
//remove this line if you want to edit the code by hand 
function Trigger_FileDelete(&$tNG) {
  $deleteObj = new tNG_FileDelete($tNG);
  $deleteObj->setFolder("../_attach_pagos/");
  $deleteObj->setDbFieldName("hr_file");
  return $deleteObj->Execute();
}
//end Trigger_FileDelete trigger

//start Trigger_FileUpload trigger
//remove this line if you want to edit the code by hand 
function Trigger_FileUpload(&$tNG) {
  $uploadObj = new tNG_FileUpload($tNG);
  $uploadObj->setFormFieldName("hr_file");
  $uploadObj->setDbFieldName("hr_file");
  $uploadObj->setFolder("../_attach_pagos/");
  $uploadObj->setMaxSize(10500);
  $uploadObj->setAllowedExtensions("pdf");
  $uploadObj->setRename("custom");
  $uploadObj->setRenameRule("{hr_id}.{KT_ext}");
  return $uploadObj->Execute();
}
//end Trigger_FileUpload trigger

// Make an insert transaction instance
$ins_hoja_ruta_2017 = new tNG_multipleInsert($conn_oConnContratos);
$tNGs->addTransaction($ins_hoja_ruta_2017);
// Register triggers
$ins_hoja_ruta_2017->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_hoja_ruta_2017->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_hoja_ruta_2017->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$ins_hoja_ruta_2017->registerTrigger("AFTER", "Trigger_FileUpload", 97);
// Add columns
$ins_hoja_ruta_2017->setTable("hoja_ruta_2017");
$ins_hoja_ruta_2017->addColumn("hr_file", "FILE_TYPE", "FILES", "hr_file");
$ins_hoja_ruta_2017->setPrimaryKey("hr_id", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_hoja_ruta_2017 = new tNG_multipleUpdate($conn_oConnContratos);
$tNGs->addTransaction($upd_hoja_ruta_2017);
// Register triggers
$upd_hoja_ruta_2017->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_hoja_ruta_2017->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_hoja_ruta_2017->registerTrigger("END", "Trigger_Default_Redirect", 99, "ok.php");
$upd_hoja_ruta_2017->registerTrigger("AFTER", "Trigger_FileUpload", 97);
// Add columns
$upd_hoja_ruta_2017->setTable("hoja_ruta_2017");
$upd_hoja_ruta_2017->addColumn("hr_file", "FILE_TYPE", "FILES", "hr_file");
$upd_hoja_ruta_2017->setPrimaryKey("hr_id", "NUMERIC_TYPE", "GET", "hr_id");

// Make an instance of the transaction object
$del_hoja_ruta_2017 = new tNG_multipleDelete($conn_oConnContratos);
$tNGs->addTransaction($del_hoja_ruta_2017);
// Register triggers
$del_hoja_ruta_2017->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_hoja_ruta_2017->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$del_hoja_ruta_2017->registerTrigger("AFTER", "Trigger_FileDelete", 98);
// Add columns
$del_hoja_ruta_2017->setTable("hoja_ruta_2017");
$del_hoja_ruta_2017->setPrimaryKey("hr_id", "NUMERIC_TYPE", "GET", "hr_id");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rshoja_ruta_2017 = $tNGs->getRecordset("hoja_ruta_2017");
$row_rshoja_ruta_2017 = mysql_fetch_assoc($rshoja_ruta_2017);
$totalRows_rshoja_ruta_2017 = mysql_num_rows($rshoja_ruta_2017);
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
if (@$_GET['hr_id'] == "") {
?>
      <?php echo NXT_getResource("Insert_FH"); ?>
      <?php 
// else Conditional region1
} else { ?>
      <?php echo NXT_getResource("Update_FH"); ?>
      <?php } 
// endif Conditional region1
?>
    Hoja ruta 2017 </h1>
  <div class="KT_tngform">
    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" enctype="multipart/form-data">
      <?php $cnt1 = 0; ?>
      <?php do { ?>
        <?php $cnt1++; ?>
        <?php 
// Show IF Conditional region1 
if (@$totalRows_rshoja_ruta_2017 > 1) {
?>
          <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
          <?php } 
// endif Conditional region1
?>
        <table cellpadding="2" cellspacing="0" class="KT_tngtable">
          <tr>
            <td class="KT_th"><label for="hr_file_<?php echo $cnt1; ?>">Adjunto:</label></td>
            <td><input type="file" name="hr_file_<?php echo $cnt1; ?>" id="hr_file_<?php echo $cnt1; ?>" size="32" />
                <?php echo $tNGs->displayFieldError("hoja_ruta_2017", "hr_file", $cnt1); ?> </td>
          </tr>
        </table>
        <input type="hidden" name="kt_pk_hoja_ruta_2017_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rshoja_ruta_2017['kt_pk_hoja_ruta_2017']); ?>" />
        <?php } while ($row_rshoja_ruta_2017 = mysql_fetch_assoc($rshoja_ruta_2017)); ?>
      <div class="KT_bottombuttons">
        <div>
          <?php 
      // Show IF Conditional region1
      if (@$_GET['hr_id'] == "") {
      ?>
            <input type="submit" name="KT_Insert1" id="KT_Insert1" value="<?php echo NXT_getResource("Insert_FB"); ?>" />
            <?php 
      // else Conditional region1
      } else { ?>
            <input type="submit" name="KT_Update1" value="Adjuntar" />
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
