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
$formValidation->addField("id_cont_fk", true, "numeric", "", "", "", "");
$formValidation->addField("not_type", true, "numeric", "", "", "", "");
$formValidation->addField("not_to", true, "text", "email", "", "", "");
$formValidation->addField("not_bcc", true, "text", "email", "", "", "");
$formValidation->addField("not_date", true, "date", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

//start Trigger_SendEmail trigger
//remove this line if you want to edit the code by hand
function Trigger_SendEmail(&$tNG) {
  $emailObj = new tNG_Email($tNG);
  $emailObj->setFrom("{KT_defaultSender}");
  $emailObj->setTo("{not_to}");
  $emailObj->setCC("");
  $emailObj->setBCC("agutierrezd@mincit.gov.co");
  $emailObj->setSubject("Informe de supervisi�n, contrato {RsInfoC.NCONTRATO}");
  //FromFile method
  $emailObj->setContentFile("send_not_003.html");
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

$colname_RsInfoC = "-1";
if (isset($_GET['doc_id'])) {
  $colname_RsInfoC = $_GET['doc_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_RsInfoC = sprintf("SELECT * FROM q_global_informes_entregados WHERE id_cont_fk = %s", GetSQLValueString($colname_RsInfoC, "int"));
$RsInfoC = mysql_query($query_RsInfoC, $oConnContratos) or die(mysql_error());
$row_RsInfoC = mysql_fetch_assoc($RsInfoC);
$totalRows_RsInfoC = mysql_num_rows($RsInfoC);

// Make an insert transaction instance
$ins_informe_intersup_notmail = new tNG_multipleInsert($conn_oConnContratos);
$tNGs->addTransaction($ins_informe_intersup_notmail);
// Register triggers
$ins_informe_intersup_notmail->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_informe_intersup_notmail->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_informe_intersup_notmail->registerTrigger("END", "Trigger_Default_Redirect", 99, "oks.php");
$ins_informe_intersup_notmail->registerTrigger("AFTER", "Trigger_SendEmail", 98);
// Add columns
$ins_informe_intersup_notmail->setTable("informe_intersup_notmail");
$ins_informe_intersup_notmail->addColumn("id_cont_fk", "NUMERIC_TYPE", "POST", "id_cont_fk");
$ins_informe_intersup_notmail->addColumn("not_type", "NUMERIC_TYPE", "POST", "not_type");
$ins_informe_intersup_notmail->addColumn("not_to", "STRING_TYPE", "POST", "not_to");
$ins_informe_intersup_notmail->addColumn("not_bcc", "STRING_TYPE", "POST", "not_bcc");
$ins_informe_intersup_notmail->addColumn("not_date", "DATE_TYPE", "POST", "not_date");
$ins_informe_intersup_notmail->setPrimaryKey("not_id", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_informe_intersup_notmail = new tNG_multipleUpdate($conn_oConnContratos);
$tNGs->addTransaction($upd_informe_intersup_notmail);
// Register triggers
$upd_informe_intersup_notmail->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_informe_intersup_notmail->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_informe_intersup_notmail->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$upd_informe_intersup_notmail->registerTrigger("AFTER", "Trigger_SendEmail", 98);
// Add columns
$upd_informe_intersup_notmail->setTable("informe_intersup_notmail");
$upd_informe_intersup_notmail->addColumn("id_cont_fk", "NUMERIC_TYPE", "POST", "id_cont_fk");
$upd_informe_intersup_notmail->addColumn("not_type", "NUMERIC_TYPE", "POST", "not_type");
$upd_informe_intersup_notmail->addColumn("not_to", "STRING_TYPE", "POST", "not_to");
$upd_informe_intersup_notmail->addColumn("not_bcc", "STRING_TYPE", "POST", "not_bcc");
$upd_informe_intersup_notmail->addColumn("not_date", "DATE_TYPE", "POST", "not_date");
$upd_informe_intersup_notmail->setPrimaryKey("not_id", "NUMERIC_TYPE", "GET", "not_id");

// Make an instance of the transaction object
$del_informe_intersup_notmail = new tNG_multipleDelete($conn_oConnContratos);
$tNGs->addTransaction($del_informe_intersup_notmail);
// Register triggers
$del_informe_intersup_notmail->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_informe_intersup_notmail->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$del_informe_intersup_notmail->setTable("informe_intersup_notmail");
$del_informe_intersup_notmail->setPrimaryKey("not_id", "NUMERIC_TYPE", "GET", "not_id");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsinforme_intersup_notmail = $tNGs->getRecordset("informe_intersup_notmail");
$row_rsinforme_intersup_notmail = mysql_fetch_assoc($rsinforme_intersup_notmail);
$totalRows_rsinforme_intersup_notmail = mysql_num_rows($rsinforme_intersup_notmail);
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
if (@$_GET['not_id'] == "") {
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
if (@$totalRows_rsinforme_intersup_notmail > 1) {
?>
          <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
          <?php } 
// endif Conditional region1
?>
        <table cellpadding="2" cellspacing="0" class="KT_tngtable">
          <tr>
            <td class="KT_th">&nbsp;</td>
            <td><input name="id_cont_fk_<?php echo $cnt1; ?>" type="hidden" id="id_cont_fk_<?php echo $cnt1; ?>" value="<?php echo $row_RsInfoC['id_cont_fk']; ?>" size="7" />
                <?php echo $tNGs->displayFieldHint("id_cont_fk");?> <?php echo $tNGs->displayFieldError("informe_intersup_notmail", "id_cont_fk", $cnt1); ?> <input type="hidden" name="not_type_<?php echo $cnt1; ?>" id="not_type_<?php echo $cnt1; ?>" value="1" size="4" />
                <?php echo $tNGs->displayFieldHint("not_type");?> <?php echo $tNGs->displayFieldError("informe_intersup_notmail", "not_type", $cnt1); ?> </td>
          </tr>
          
          <tr>
            <td class="KT_th"><label for="not_to_<?php echo $cnt1; ?>">Notificar a:</label></td>
            <td><input name="not_to_<?php echo $cnt1; ?>" type="text" id="not_to_<?php echo $cnt1; ?>" value="<?php echo $row_RsInfoC['SUPEMAIL']; ?>" size="32" maxlength="100" readonly="true" />
                <?php echo $tNGs->displayFieldHint("not_to");?> <?php echo $tNGs->displayFieldError("informe_intersup_notmail", "not_to", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="not_bcc_<?php echo $cnt1; ?>">Copiar a:</label></td>
            <td><input type="text" name="not_bcc_<?php echo $cnt1; ?>" id="not_bcc_<?php echo $cnt1; ?>" value="agutierrezd@mincit.gov.co" size="32" maxlength="100" />
                <?php echo $tNGs->displayFieldHint("not_bcc");?> <?php echo $tNGs->displayFieldError("informe_intersup_notmail", "not_bcc", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="not_date_<?php echo $cnt1; ?>">Fecha:</label></td>
            <td><input name="not_date_<?php echo $cnt1; ?>" type="text" id="not_date_<?php echo $cnt1; ?>" value="<?php echo $fechac; ?>" size="20" maxlength="22" readonly="true" />
                <?php echo $tNGs->displayFieldHint("not_date");?> <?php echo $tNGs->displayFieldError("informe_intersup_notmail", "not_date", $cnt1); ?> </td>
          </tr>
        </table>
        <input type="hidden" name="kt_pk_informe_intersup_notmail_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rsinforme_intersup_notmail['kt_pk_informe_intersup_notmail']); ?>" />
        <?php } while ($row_rsinforme_intersup_notmail = mysql_fetch_assoc($rsinforme_intersup_notmail)); ?>
      <div class="KT_bottombuttons">
        <div>
          <?php 
      // Show IF Conditional region1
      if (@$_GET['not_id'] == "") {
      ?>
            <input type="submit" name="KT_Insert1" id="KT_Insert1" value="Notificar" />
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
mysql_free_result($RsInfoC);
?>
