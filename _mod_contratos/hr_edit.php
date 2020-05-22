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
$formValidation->addField("hr_nit_contra_ta", true, "text", "", "", "", "");
$formValidation->addField("hr_asunto", true, "text", "", "", "", "");
$formValidation->addField("hr_valor", true, "double", "float_positive", "", "", "");
$formValidation->addField("hr_fechaingreso", true, "date", "", "", "", "");
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

mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rsempresas = "SELECT * FROM contractor_master ORDER BY contractor_name ASC";
$rsempresas = mysql_query($query_rsempresas, $oConnContratos) or die(mysql_error());
$row_rsempresas = mysql_fetch_assoc($rsempresas);
$totalRows_rsempresas = mysql_num_rows($rsempresas);

// Make an insert transaction instance
$ins_hoja_ruta = new tNG_multipleInsert($conn_oConnContratos);
$tNGs->addTransaction($ins_hoja_ruta);
// Register triggers
$ins_hoja_ruta->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_hoja_ruta->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_hoja_ruta->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$ins_hoja_ruta->setTable("hoja_ruta");
$ins_hoja_ruta->addColumn("hr_nit_contra_ta", "STRING_TYPE", "POST", "hr_nit_contra_ta");
$ins_hoja_ruta->addColumn("hr_asunto", "STRING_TYPE", "POST", "hr_asunto");
$ins_hoja_ruta->addColumn("hr_valor", "DOUBLE_TYPE", "POST", "hr_valor");
$ins_hoja_ruta->addColumn("hr_fechaingreso", "DATE_TYPE", "POST", "hr_fechaingreso");
$ins_hoja_ruta->setPrimaryKey("hr_id", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_hoja_ruta = new tNG_multipleUpdate($conn_oConnContratos);
$tNGs->addTransaction($upd_hoja_ruta);
// Register triggers
$upd_hoja_ruta->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_hoja_ruta->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_hoja_ruta->registerTrigger("END", "Trigger_Default_Redirect", 99, "ok.php");
// Add columns
$upd_hoja_ruta->setTable("hoja_ruta");
$upd_hoja_ruta->addColumn("hr_nit_contra_ta", "STRING_TYPE", "POST", "hr_nit_contra_ta");
$upd_hoja_ruta->addColumn("hr_asunto", "STRING_TYPE", "POST", "hr_asunto");
$upd_hoja_ruta->addColumn("hr_valor", "DOUBLE_TYPE", "POST", "hr_valor");
$upd_hoja_ruta->addColumn("hr_fechaingreso", "DATE_TYPE", "POST", "hr_fechaingreso");
$upd_hoja_ruta->setPrimaryKey("hr_id", "NUMERIC_TYPE", "GET", "hr_id");

// Make an instance of the transaction object
$del_hoja_ruta = new tNG_multipleDelete($conn_oConnContratos);
$tNGs->addTransaction($del_hoja_ruta);
// Register triggers
$del_hoja_ruta->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_hoja_ruta->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$del_hoja_ruta->setTable("hoja_ruta");
$del_hoja_ruta->setPrimaryKey("hr_id", "NUMERIC_TYPE", "GET", "hr_id");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rshoja_ruta = $tNGs->getRecordset("hoja_ruta");
$row_rshoja_ruta = mysql_fetch_assoc($rshoja_ruta);
$totalRows_rshoja_ruta = mysql_num_rows($rshoja_ruta);
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
    Hoja_ruta </h1>
  <div class="KT_tngform">
    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
      <?php $cnt1 = 0; ?>
      <?php do { ?>
        <?php $cnt1++; ?>
        <?php 
// Show IF Conditional region1 
if (@$totalRows_rshoja_ruta > 1) {
?>
          <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
          <?php } 
// endif Conditional region1
?>
        <table cellpadding="2" cellspacing="0" class="KT_tngtable">
          <tr>
            <td class="KT_th"><label for="hr_nit_contra_ta_<?php echo $cnt1; ?>">NOMBRES:</label></td>
            <td><select name="hr_nit_contra_ta_<?php echo $cnt1; ?>" id="hr_nit_contra_ta_<?php echo $cnt1; ?>">
              <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
              <?php 
do {  
?>
              <option value="<?php echo $row_rsempresas['contractor_doc_id']?>"<?php if (!(strcmp($row_rsempresas['contractor_doc_id'], $row_rshoja_ruta['hr_nit_contra_ta']))) {echo "SELECTED";} ?>><?php echo $row_rsempresas['contractor_name']?></option>
              <?php
} while ($row_rsempresas = mysql_fetch_assoc($rsempresas));
  $rows = mysql_num_rows($rsempresas);
  if($rows > 0) {
      mysql_data_seek($rsempresas, 0);
	  $row_rsempresas = mysql_fetch_assoc($rsempresas);
  }
?>
            </select>
                <?php echo $tNGs->displayFieldError("hoja_ruta", "hr_nit_contra_ta", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="hr_asunto_<?php echo $cnt1; ?>">CONCEPTO:</label></td>
            <td><textarea name="hr_asunto_<?php echo $cnt1; ?>" cols="40" rows="4" id="hr_asunto_<?php echo $cnt1; ?>"><?php echo KT_escapeAttribute($row_rshoja_ruta['hr_asunto']); ?></textarea>
                <?php echo $tNGs->displayFieldHint("hr_asunto");?> <?php echo $tNGs->displayFieldError("hoja_ruta", "hr_asunto", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="hr_valor_<?php echo $cnt1; ?>">VALOR:</label></td>
            <td><input type="text" name="hr_valor_<?php echo $cnt1; ?>" id="hr_valor_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rshoja_ruta['hr_valor']); ?>" size="7" />
                <?php echo $tNGs->displayFieldHint("hr_valor");?> <?php echo $tNGs->displayFieldError("hoja_ruta", "hr_valor", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="hr_fechaingreso_<?php echo $cnt1; ?>">FECHA DE REGISTRO:</label></td>
            <td><input type="text" name="hr_fechaingreso_<?php echo $cnt1; ?>" id="hr_fechaingreso_<?php echo $cnt1; ?>" value="<?php echo $fechac; ?>" size="20" maxlength="22" />
                <?php echo $tNGs->displayFieldHint("hr_fechaingreso");?> <?php echo $tNGs->displayFieldError("hoja_ruta", "hr_fechaingreso", $cnt1); ?> </td>
          </tr>
        </table>
        <input type="hidden" name="kt_pk_hoja_ruta_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rshoja_ruta['kt_pk_hoja_ruta']); ?>" />
        <?php } while ($row_rshoja_ruta = mysql_fetch_assoc($rshoja_ruta)); ?>
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
mysql_free_result($rsempresas);
?>
