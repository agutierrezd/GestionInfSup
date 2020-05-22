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
$formValidation->addField("evento_mail_1", true, "text", "", "", "", "");
$formValidation->addField("evento_fechaa", true, "date", "", "", "", "");
$formValidation->addField("evento_responsable", true, "text", "", "", "", "");
$formValidation->addField("evento_fechaoper", true, "date", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

//start Trigger_SendEmail trigger
//remove this line if you want to edit the code by hand
function Trigger_SendEmail(&$tNG) {
  $emailObj = new tNG_Email($tNG);
  $emailObj->setFrom("{KT_defaultSender}");
  $emailObj->setTo("{evento_mail_1}");
  $emailObj->setCC("{evento_mail_2}");
  $emailObj->setBCC("agutierrezd@mincit.gov.co");
  $emailObj->setSubject("Entrega de cuenta para trámite, Radicado: {hr_id_fk}");
  //FromFile method
  $emailObj->setContentFile("send_hr_001.html");
  $emailObj->setEncoding("UTF-8");
  $emailObj->setFormat("HTML/Text");
  $emailObj->setImportance("High");
  return $emailObj->Execute();
}
//end Trigger_SendEmail trigger

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

$colname_rsinfohr = "-1";
if (isset($_GET['hr_id'])) {
  $colname_rsinfohr = $_GET['hr_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rsinfohr = sprintf("SELECT * FROM hoja_ruta WHERE hr_id = %s", GetSQLValueString($colname_rsinfohr, "int"));
$rsinfohr = mysql_query($query_rsinfohr, $oConnContratos) or die(mysql_error());
$row_rsinfohr = mysql_fetch_assoc($rsinfohr);
$totalRows_rsinfohr = mysql_num_rows($rsinfohr);

$colname_rsevento = "-1";
if (isset($_SESSION['kt_login_level'])) {
  $colname_rsevento = $_SESSION['kt_login_level'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rsevento = sprintf("SELECT * FROM hoja_ruta_event_type WHERE evento_id_rol_fk = %s", GetSQLValueString($colname_rsevento, "int"));
$rsevento = mysql_query($query_rsevento, $oConnContratos) or die(mysql_error());
$row_rsevento = mysql_fetch_assoc($rsevento);
$totalRows_rsevento = mysql_num_rows($rsevento);

// Make an insert transaction instance
$ins_hoja_ruta_event = new tNG_multipleInsert($conn_oConnContratos);
$tNGs->addTransaction($ins_hoja_ruta_event);
// Register triggers
$ins_hoja_ruta_event->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_hoja_ruta_event->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_hoja_ruta_event->registerTrigger("END", "Trigger_Default_Redirect", 99, "ok.php");
$ins_hoja_ruta_event->registerTrigger("AFTER", "Trigger_SendEmail", 98);
// Add columns
$ins_hoja_ruta_event->setTable("hoja_ruta_event");
$ins_hoja_ruta_event->addColumn("hr_id_fk", "NUMERIC_TYPE", "POST", "hr_id_fk");
$ins_hoja_ruta_event->addColumn("evento_type", "NUMERIC_TYPE", "POST", "evento_type");
$ins_hoja_ruta_event->addColumn("evento_mail_1", "STRING_TYPE", "POST", "evento_mail_1");
$ins_hoja_ruta_event->addColumn("evento_mail_2", "STRING_TYPE", "POST", "evento_mail_2");
$ins_hoja_ruta_event->addColumn("evento_fechaa", "DATE_TYPE", "POST", "evento_fechaa");
$ins_hoja_ruta_event->addColumn("evento_responsable", "STRING_TYPE", "POST", "evento_responsable");
$ins_hoja_ruta_event->addColumn("evento_fechaoper", "DATE_TYPE", "POST", "evento_fechaoper");
$ins_hoja_ruta_event->setPrimaryKey("evento_id", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_hoja_ruta_event = new tNG_multipleUpdate($conn_oConnContratos);
$tNGs->addTransaction($upd_hoja_ruta_event);
// Register triggers
$upd_hoja_ruta_event->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_hoja_ruta_event->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_hoja_ruta_event->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$upd_hoja_ruta_event->registerTrigger("AFTER", "Trigger_SendEmail", 98);
// Add columns
$upd_hoja_ruta_event->setTable("hoja_ruta_event");
$upd_hoja_ruta_event->addColumn("hr_id_fk", "NUMERIC_TYPE", "POST", "hr_id_fk");
$upd_hoja_ruta_event->addColumn("evento_type", "NUMERIC_TYPE", "POST", "evento_type");
$upd_hoja_ruta_event->addColumn("evento_mail_1", "STRING_TYPE", "POST", "evento_mail_1");
$upd_hoja_ruta_event->addColumn("evento_mail_2", "STRING_TYPE", "POST", "evento_mail_2");
$upd_hoja_ruta_event->addColumn("evento_fechaa", "DATE_TYPE", "POST", "evento_fechaa");
$upd_hoja_ruta_event->addColumn("evento_responsable", "STRING_TYPE", "POST", "evento_responsable");
$upd_hoja_ruta_event->addColumn("evento_fechaoper", "DATE_TYPE", "POST", "evento_fechaoper");
$upd_hoja_ruta_event->setPrimaryKey("evento_id", "NUMERIC_TYPE", "GET", "evento_id");

// Make an instance of the transaction object
$del_hoja_ruta_event = new tNG_multipleDelete($conn_oConnContratos);
$tNGs->addTransaction($del_hoja_ruta_event);
// Register triggers
$del_hoja_ruta_event->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_hoja_ruta_event->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$del_hoja_ruta_event->setTable("hoja_ruta_event");
$del_hoja_ruta_event->setPrimaryKey("evento_id", "NUMERIC_TYPE", "GET", "evento_id");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rshoja_ruta_event = $tNGs->getRecordset("hoja_ruta_event");
$row_rshoja_ruta_event = mysql_fetch_assoc($rshoja_ruta_event);
$totalRows_rshoja_ruta_event = mysql_num_rows($rshoja_ruta_event);
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
  </h1>
  <div class="KT_tngform">
    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
      <?php $cnt1 = 0; ?>
      <?php do { ?>
        <?php $cnt1++; ?>
        <?php 
// Show IF Conditional region1 
if (@$totalRows_rshoja_ruta_event > 1) {
?>
          <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
          <?php } 
// endif Conditional region1
?>
        <table cellpadding="2" cellspacing="0" class="KT_tngtable">
          <tr>
            <td class="KT_th">Acción</td>
            <td><select name="evento_type_<?php echo $cnt1; ?>" id="evento_type_<?php echo $cnt1; ?>">
              <?php
do {  
?>
              <option value="<?php echo $row_rsevento['evento_type_id']?>"><?php echo $row_rsevento['evento_type_name']?></option>
              <?php
} while ($row_rsevento = mysql_fetch_assoc($rsevento));
  $rows = mysql_num_rows($rsevento);
  if($rows > 0) {
      mysql_data_seek($rsevento, 0);
	  $row_rsevento = mysql_fetch_assoc($rsevento);
  }
?>
            </select>
<input name="hr_id_fk_<?php echo $cnt1; ?>" type="hidden" id="hr_id_fk_<?php echo $cnt1; ?>" value="<?php echo $row_rsinfohr['hr_id']; ?>" size="6" />
                <?php echo $tNGs->displayFieldHint("hr_id_fk");?> <?php echo $tNGs->displayFieldError("hoja_ruta_event", "hr_id_fk", $cnt1); ?><?php echo $tNGs->displayFieldHint("evento_type");?> <?php echo $tNGs->displayFieldError("hoja_ruta_event", "evento_type", $cnt1); ?> <input name="evento_responsable_<?php echo $cnt1; ?>" type="hidden" id="evento_responsable_<?php echo $cnt1; ?>" value="<?php echo $_SESSION['kt_login_user']; ?>" size="32" maxlength="40" />
                <?php echo $tNGs->displayFieldHint("evento_responsable");?> <?php echo $tNGs->displayFieldError("hoja_ruta_event", "evento_responsable", $cnt1); ?> <input type="hidden" name="evento_fechaoper_<?php echo $cnt1; ?>" id="evento_fechaoper_<?php echo $cnt1; ?>" value="<?php echo $fechac; ?>" size="10" maxlength="22" />
            <?php echo $tNGs->displayFieldHint("evento_fechaoper");?> <?php echo $tNGs->displayFieldError("hoja_ruta_event", "evento_fechaoper", $cnt1); ?> </td>
          </tr>
          
          <tr>
            <td class="KT_th"><label for="evento_mail_1_<?php echo $cnt1; ?>">Destinatario principal:</label></td>
            <td><input type="text" name="evento_mail_1_<?php echo $cnt1; ?>" id="evento_mail_1_<?php echo $cnt1; ?>" value="notificaciones@mincit.gov.co" size="32" maxlength="100" />
                <?php echo $tNGs->displayFieldHint("evento_mail_1");?> <?php echo $tNGs->displayFieldError("hoja_ruta_event", "evento_mail_1", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="evento_mail_2_<?php echo $cnt1; ?>">Con copia a:</label></td>
            <td><input name="evento_mail_2_<?php echo $cnt1; ?>" type="text" id="evento_mail_2_<?php echo $cnt1; ?>" size="32" maxlength="100" />
                <?php echo $tNGs->displayFieldHint("evento_mail_2");?> <?php echo $tNGs->displayFieldError("hoja_ruta_event", "evento_mail_2", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="evento_fechaa_<?php echo $cnt1; ?>">Fecha:</label></td>
            <td><input name="evento_fechaa_<?php echo $cnt1; ?>" type="text" id="evento_fechaa_<?php echo $cnt1; ?>" value="<?php echo $fechac; ?>" size="20" maxlength="22" readonly="true" />
                <?php echo $tNGs->displayFieldHint("evento_fechaa");?> <?php echo $tNGs->displayFieldError("hoja_ruta_event", "evento_fechaa", $cnt1); ?> </td>
          </tr>
        </table>
        <input type="hidden" name="kt_pk_hoja_ruta_event_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rshoja_ruta_event['kt_pk_hoja_ruta_event']); ?>" />
        <?php } while ($row_rshoja_ruta_event = mysql_fetch_assoc($rshoja_ruta_event)); ?>
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
mysql_free_result($rsinfohr);

mysql_free_result($rsevento);
?>
