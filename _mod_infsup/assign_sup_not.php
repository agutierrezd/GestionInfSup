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
$formValidation->addField("sys_user", true, "text", "", "", "", "");
$formValidation->addField("sup_status", true, "numeric", "", "", "", "");
$formValidation->addField("sup_fechanot", true, "date", "", "", "", "");
$formValidation->addField("sup_horanot", true, "date", "", "", "", "");
$formValidation->addField("sup_mailnot", true, "text", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

//start Trigger_SendEmail trigger
//remove this line if you want to edit the code by hand
function Trigger_SendEmail(&$tNG) {
  $emailObj = new tNG_Email($tNG);
  $emailObj->setFrom("{KT_defaultSender}");
  $emailObj->setTo("{sup_mailnot}");
  $emailObj->setCC("agutierrezd@mincit.gov.co");
  $emailObj->setBCC("agutierrezd@mincit.gov.co");
  $emailObj->setSubject("Asignacion de contrato para Supervisar:{rsinfosup.pre_contnumero}{rsinfosup.contnumero} de {rsinfosup.cont_ano}");
  //FromFile method
  $emailObj->setContentFile("send_not_001.html");
  $emailObj->setEncoding("ISO-8859-1");
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

$colname_rsinfosup = "-1";
if (isset($_GET['interventor_id'])) {
  $colname_rsinfosup = $_GET['interventor_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rsinfosup = sprintf("SELECT * FROM q_global_supervisores WHERE interventor_id = %s", GetSQLValueString($colname_rsinfosup, "int"));
$rsinfosup = mysql_query($query_rsinfosup, $oConnContratos) or die(mysql_error());
$row_rsinfosup = mysql_fetch_assoc($rsinfosup);
$totalRows_rsinfosup = mysql_num_rows($rsinfosup);

// Make an insert transaction instance
$ins_interventor_interno = new tNG_multipleInsert($conn_oConnContratos);
$tNGs->addTransaction($ins_interventor_interno);
// Register triggers
$ins_interventor_interno->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_interventor_interno->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_interventor_interno->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$ins_interventor_interno->registerTrigger("AFTER", "Trigger_SendEmail", 98);
// Add columns
$ins_interventor_interno->setTable("interventor_interno");
$ins_interventor_interno->addColumn("sys_user", "STRING_TYPE", "POST", "sys_user");
$ins_interventor_interno->addColumn("sup_status", "NUMERIC_TYPE", "POST", "sup_status");
$ins_interventor_interno->addColumn("sup_fechanot", "DATE_TYPE", "POST", "sup_fechanot");
$ins_interventor_interno->addColumn("sup_horanot", "DATE_TYPE", "POST", "sup_horanot");
$ins_interventor_interno->addColumn("sup_mailnot", "STRING_TYPE", "POST", "sup_mailnot");
$ins_interventor_interno->setPrimaryKey("interventor_id", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_interventor_interno = new tNG_multipleUpdate($conn_oConnContratos);
$tNGs->addTransaction($upd_interventor_interno);
// Register triggers
$upd_interventor_interno->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_interventor_interno->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_interventor_interno->registerTrigger("END", "Trigger_Default_Redirect", 99, "oks.php");
$upd_interventor_interno->registerTrigger("AFTER", "Trigger_SendEmail", 98);
// Add columns
$upd_interventor_interno->setTable("interventor_interno");
$upd_interventor_interno->addColumn("sys_user", "STRING_TYPE", "POST", "sys_user");
$upd_interventor_interno->addColumn("sup_status", "NUMERIC_TYPE", "POST", "sup_status");
$upd_interventor_interno->addColumn("sup_fechanot", "DATE_TYPE", "POST", "sup_fechanot");
$upd_interventor_interno->addColumn("sup_horanot", "DATE_TYPE", "POST", "sup_horanot");
$upd_interventor_interno->addColumn("sup_mailnot", "STRING_TYPE", "POST", "sup_mailnot");
$upd_interventor_interno->setPrimaryKey("interventor_id", "NUMERIC_TYPE", "GET", "interventor_id");

// Make an instance of the transaction object
$del_interventor_interno = new tNG_multipleDelete($conn_oConnContratos);
$tNGs->addTransaction($del_interventor_interno);
// Register triggers
$del_interventor_interno->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_interventor_interno->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$del_interventor_interno->setTable("interventor_interno");
$del_interventor_interno->setPrimaryKey("interventor_id", "NUMERIC_TYPE", "GET", "interventor_id");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsinterventor_interno = $tNGs->getRecordset("interventor_interno");
$row_rsinterventor_interno = mysql_fetch_assoc($rsinterventor_interno);
$totalRows_rsinterventor_interno = mysql_num_rows($rsinterventor_interno);
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
<link href="../_css/jqueryslidemenu.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php
	echo $tNGs->getErrorMsg();
?>
<div class="KT_tng">
  <h1>
    <?php 
// Show IF Conditional region1 
if (@$_GET['interventor_id'] == "") {
?>
      <?php echo NXT_getResource("Insert_FH"); ?>
      <?php 
// else Conditional region1
} else { ?>
      Notificar como supervisor
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
if (@$totalRows_rsinterventor_interno > 1) {
?>
          <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
          <?php } 
// endif Conditional region1
?>
          Al presionar el bot&oacute;n enviar, notificara mediante correo electr&oacute;nico sobre la asignaci&oacute;n como supervisor al correo registrado en la parte inferior.
          <table cellpadding="2" cellspacing="0" class="KT_tngtable">
          <tr>
            <td width="11%" class="KT_th">&nbsp;</td>
            <td width="89%"><input name="sys_user_<?php echo $cnt1; ?>" type="hidden" id="sys_user_<?php echo $cnt1; ?>" value="<?php echo $_SESSION['kt_login_user']; ?>" size="32" maxlength="60" />
                <?php echo $tNGs->displayFieldHint("sys_user");?> <?php echo $tNGs->displayFieldError("interventor_interno", "sys_user", $cnt1); ?> <input type="hidden" name="sup_status_<?php echo $cnt1; ?>" id="sup_status_<?php echo $cnt1; ?>" value="1" size="2" />
                <?php echo $tNGs->displayFieldHint("sup_status");?> <?php echo $tNGs->displayFieldError("interventor_interno", "sup_status", $cnt1); ?> <input type="hidden" name="sup_fechanot_<?php echo $cnt1; ?>" id="sup_fechanot_<?php echo $cnt1; ?>" value="<?php echo $fecha; ?>" size="10" maxlength="22" />
                <?php echo $tNGs->displayFieldHint("sup_fechanot");?> <?php echo $tNGs->displayFieldError("interventor_interno", "sup_fechanot", $cnt1); ?> <input type="hidden" name="sup_horanot_<?php echo $cnt1; ?>" id="sup_horanot_<?php echo $cnt1; ?>" value="<?php echo $hora; ?>" size="10" maxlength="22" />
                <?php echo $tNGs->displayFieldHint("sup_horanot");?> <?php echo $tNGs->displayFieldError("interventor_interno", "sup_horanot", $cnt1); ?> </td>
          </tr>
          
          <tr>
            <td class="KT_th"><label for="sup_mailnot_<?php echo $cnt1; ?>">Se notificar&aacute; al correo:</label></td>
            <td><input name="sup_mailnot_<?php echo $cnt1; ?>" type="text" id="sup_mailnot_<?php echo $cnt1; ?>" value="<?php echo $row_rsinfosup['usr_email']; ?>" size="60" maxlength="100" readonly="true" />
                <?php echo $tNGs->displayFieldHint("sup_mailnot");?> <?php echo $tNGs->displayFieldError("interventor_interno", "sup_mailnot", $cnt1); ?> </td>
          </tr>
        </table>
        <input type="hidden" name="kt_pk_interventor_interno_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rsinterventor_interno['kt_pk_interventor_interno']); ?>" />
        <?php } while ($row_rsinterventor_interno = mysql_fetch_assoc($rsinterventor_interno)); ?>
      <div class="KT_bottombuttons">
        <div>
          <?php 
      // Show IF Conditional region1
      if (@$_GET['interventor_id'] == "") {
      ?>
            <input type="submit" name="KT_Insert1" id="KT_Insert1" value="<?php echo NXT_getResource("Insert_FB"); ?>" />
            <?php 
      // else Conditional region1
      } else { ?>
            <input type="submit" name="KT_Update1" value="Enviar" />
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
mysql_free_result($rsinfosup);
?>
