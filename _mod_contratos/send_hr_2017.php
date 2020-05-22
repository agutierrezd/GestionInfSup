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
$formValidation->addField("hr_id_fk", true, "numeric", "", "", "", "");
$formValidation->addField("evento_type", true, "numeric", "", "", "", "");
$formValidation->addField("evento_fechaa", true, "date", "", "", "", "");
$formValidation->addField("evento_obs", true, "text", "", "", "", "");
$formValidation->addField("evento_responsable", true, "text", "", "", "", "");
$formValidation->addField("evento_fechaoper", true, "date", "", "", "", "");
$formValidation->addField("evento_mail_1", true, "text", "", "", "", "");
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

$colname_RsEventType = "-1";
if (isset($_SESSION['kt_login_level'])) {
  $colname_RsEventType = $_SESSION['kt_login_level'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_RsEventType = sprintf("SELECT * FROM hoja_ruta_event_type WHERE evento_id_rol_fk = %s", GetSQLValueString($colname_RsEventType, "int"));
$RsEventType = mysql_query($query_RsEventType, $oConnContratos) or die(mysql_error());
$row_RsEventType = mysql_fetch_assoc($RsEventType);
$totalRows_RsEventType = mysql_num_rows($RsEventType);

// Make an insert transaction instance
$ins_hoja_ruta_event_2017 = new tNG_multipleInsert($conn_oConnContratos);
$tNGs->addTransaction($ins_hoja_ruta_event_2017);
// Register triggers
$ins_hoja_ruta_event_2017->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_hoja_ruta_event_2017->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_hoja_ruta_event_2017->registerTrigger("END", "Trigger_Default_Redirect", 99, "ok.php");
// Add columns
$ins_hoja_ruta_event_2017->setTable("hoja_ruta_event_2017");
$ins_hoja_ruta_event_2017->addColumn("hr_id_fk", "NUMERIC_TYPE", "POST", "hr_id_fk");
$ins_hoja_ruta_event_2017->addColumn("evento_type", "NUMERIC_TYPE", "POST", "evento_type");
$ins_hoja_ruta_event_2017->addColumn("evento_fechaa", "DATE_TYPE", "POST", "evento_fechaa");
$ins_hoja_ruta_event_2017->addColumn("evento_obs", "STRING_TYPE", "POST", "evento_obs");
$ins_hoja_ruta_event_2017->addColumn("evento_responsable", "STRING_TYPE", "POST", "evento_responsable");
$ins_hoja_ruta_event_2017->addColumn("evento_fechaoper", "DATE_TYPE", "POST", "evento_fechaoper");
$ins_hoja_ruta_event_2017->addColumn("evento_mail_1", "STRING_TYPE", "POST", "evento_mail_1");
$ins_hoja_ruta_event_2017->addColumn("evento_mail_2", "STRING_TYPE", "POST", "evento_mail_2");
$ins_hoja_ruta_event_2017->setPrimaryKey("evento_id", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_hoja_ruta_event_2017 = new tNG_multipleUpdate($conn_oConnContratos);
$tNGs->addTransaction($upd_hoja_ruta_event_2017);
// Register triggers
$upd_hoja_ruta_event_2017->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_hoja_ruta_event_2017->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_hoja_ruta_event_2017->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$upd_hoja_ruta_event_2017->setTable("hoja_ruta_event_2017");
$upd_hoja_ruta_event_2017->addColumn("hr_id_fk", "NUMERIC_TYPE", "POST", "hr_id_fk");
$upd_hoja_ruta_event_2017->addColumn("evento_type", "NUMERIC_TYPE", "POST", "evento_type");
$upd_hoja_ruta_event_2017->addColumn("evento_fechaa", "DATE_TYPE", "POST", "evento_fechaa");
$upd_hoja_ruta_event_2017->addColumn("evento_obs", "STRING_TYPE", "POST", "evento_obs");
$upd_hoja_ruta_event_2017->addColumn("evento_responsable", "STRING_TYPE", "POST", "evento_responsable");
$upd_hoja_ruta_event_2017->addColumn("evento_fechaoper", "DATE_TYPE", "POST", "evento_fechaoper");
$upd_hoja_ruta_event_2017->addColumn("evento_mail_1", "STRING_TYPE", "POST", "evento_mail_1");
$upd_hoja_ruta_event_2017->addColumn("evento_mail_2", "STRING_TYPE", "POST", "evento_mail_2");
$upd_hoja_ruta_event_2017->setPrimaryKey("evento_id", "NUMERIC_TYPE", "GET", "evento_id");

// Make an instance of the transaction object
$del_hoja_ruta_event_2017 = new tNG_multipleDelete($conn_oConnContratos);
$tNGs->addTransaction($del_hoja_ruta_event_2017);
// Register triggers
$del_hoja_ruta_event_2017->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_hoja_ruta_event_2017->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$del_hoja_ruta_event_2017->setTable("hoja_ruta_event_2017");
$del_hoja_ruta_event_2017->setPrimaryKey("evento_id", "NUMERIC_TYPE", "GET", "evento_id");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rshoja_ruta_event_2017 = $tNGs->getRecordset("hoja_ruta_event_2017");
$row_rshoja_ruta_event_2017 = mysql_fetch_assoc($rshoja_ruta_event_2017);
$totalRows_rshoja_ruta_event_2017 = mysql_num_rows($rshoja_ruta_event_2017);
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
if (@$_GET['evento_id'] == "") {
?>
      <?php echo NXT_getResource("Insert_FH"); ?>
      <?php 
// else Conditional region1
} else { ?>
      <?php echo NXT_getResource("Update_FH"); ?>
      <?php } 
// endif Conditional region1
?>
    Hoja ruta 2015 </h1>
  <div class="KT_tngform">
    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
      <?php $cnt1 = 0; ?>
      <?php do { ?>
        <?php $cnt1++; ?>
        <?php 
// Show IF Conditional region1 
if (@$totalRows_rshoja_ruta_event_2017 > 1) {
?>
          <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
          <?php } 
// endif Conditional region1
?>
        <table cellpadding="2" cellspacing="0" class="KT_tngtable">
          <tr>
            <td class="KT_th"><label for="hr_id_fk_<?php echo $cnt1; ?>"></label></td>
            <td><input name="hr_id_fk_<?php echo $cnt1; ?>" type="hidden" id="hr_id_fk_<?php echo $cnt1; ?>" value="<?php echo $_GET['hr_id']; ?>" />
                <?php echo $tNGs->displayFieldHint("hr_id_fk");?> <?php echo $tNGs->displayFieldError("hoja_ruta_event_2017", "hr_id_fk", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="evento_type_<?php echo $cnt1; ?>">Destinatario:</label></td>
            <td><select name="evento_type_<?php echo $cnt1; ?>" id="evento_type_<?php echo $cnt1; ?>">
              <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
              <?php 
do {  
?>
              <option value="<?php echo $row_RsEventType['evento_type_id']?>"<?php if (!(strcmp($row_RsEventType['evento_type_id'], $row_rshoja_ruta_event_2017['evento_type']))) {echo "SELECTED";} ?>><?php echo $row_RsEventType['evento_type_name']?></option>
              <?php
} while ($row_RsEventType = mysql_fetch_assoc($RsEventType));
  $rows = mysql_num_rows($RsEventType);
  if($rows > 0) {
      mysql_data_seek($RsEventType, 0);
	  $row_RsEventType = mysql_fetch_assoc($RsEventType);
  }
?>
            </select>
                <?php echo $tNGs->displayFieldError("hoja_ruta_event_2017", "evento_type", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="evento_fechaa_<?php echo $cnt1; ?>">fecha:</label></td>
            <td><input name="evento_fechaa_<?php echo $cnt1; ?>" type="text" id="evento_fechaa_<?php echo $cnt1; ?>" value="<?php echo $fechac; ?>" size="22" maxlength="22" readonly="true" />
            <?php echo $tNGs->displayFieldHint("evento_fechaa");?> <?php echo $tNGs->displayFieldError("hoja_ruta_event_2017", "evento_fechaa", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th">&nbsp;</td>
            <td><input type="hidden" name="evento_obs_<?php echo $cnt1; ?>" id="evento_obs_<?php echo $cnt1; ?>" value="0" size="32" />
                <?php echo $tNGs->displayFieldHint("evento_obs");?> <?php echo $tNGs->displayFieldError("hoja_ruta_event_2017", "evento_obs", $cnt1); ?> <input type="hidden" name="evento_responsable_<?php echo $cnt1; ?>" id="evento_responsable_<?php echo $cnt1; ?>" value="<?php echo $_SESSION['kt_login_user']; ?>" size="32" maxlength="40" />
                <?php echo $tNGs->displayFieldHint("evento_responsable");?> <?php echo $tNGs->displayFieldError("hoja_ruta_event_2017", "evento_responsable", $cnt1); ?> <input type="hidden" name="evento_fechaoper_<?php echo $cnt1; ?>" id="evento_fechaoper_<?php echo $cnt1; ?>" value="<?php echo $fechac; ?>" size="10" maxlength="22" />
                <?php echo $tNGs->displayFieldHint("evento_fechaoper");?> <?php echo $tNGs->displayFieldError("hoja_ruta_event_2017", "evento_fechaoper", $cnt1); ?> <input type="hidden" name="evento_mail_1_<?php echo $cnt1; ?>" id="evento_mail_1_<?php echo $cnt1; ?>" value="0" size="32" maxlength="100" />
                <?php echo $tNGs->displayFieldHint("evento_mail_1");?> <?php echo $tNGs->displayFieldError("hoja_ruta_event_2017", "evento_mail_1", $cnt1); ?> <input type="hidden" name="evento_mail_2_<?php echo $cnt1; ?>" id="evento_mail_2_<?php echo $cnt1; ?>" value="0" size="32" maxlength="100" />
                <?php echo $tNGs->displayFieldHint("evento_mail_2");?> <?php echo $tNGs->displayFieldError("hoja_ruta_event_2017", "evento_mail_2", $cnt1); ?> </td>
          </tr>
        </table>
        <input type="hidden" name="kt_pk_hoja_ruta_event_2017_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rshoja_ruta_event_2017['kt_pk_hoja_ruta_event_2017']); ?>" />
        <?php } while ($row_rshoja_ruta_event_2017 = mysql_fetch_assoc($rshoja_ruta_event_2017)); ?>
      <div class="KT_bottombuttons">
        <div>
          <?php 
      // Show IF Conditional region1
      if (@$_GET['evento_id'] == "") {
      ?>
            <input type="submit" name="KT_Insert1" id="KT_Insert1" value="Guardar" />
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
mysql_free_result($RsEventType);
?>
