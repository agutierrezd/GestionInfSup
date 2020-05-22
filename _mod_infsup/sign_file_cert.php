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
$formValidation->addField("sign_verificacert", true, "numeric", "", "", "", "");
$formValidation->addField("cert_date", true, "date", "", "", "", "");
$formValidation->addField("cert_file", true, "", "", "", "", "");
$formValidation->addField("cert_mail", true, "text", "", "", "", "");
$formValidation->addField("cert_compare", true, "text", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

//start Trigger_Compare trigger
//remove this line if you want to edit the code by hand
function Trigger_Compare(&$tNG) {
	$fieldCompareObj = new tNG_FieldCompare($tNG);
	$fieldCompareObj->addField("cert_file", "{cert_compare}", "==", "El nombre del documento adjunto no es válido, verifique e intente nuevamente.");
	return $fieldCompareObj->Execute();	
}
//end Trigger_Compare trigger

//start Trigger_FileDelete trigger
//remove this line if you want to edit the code by hand 
function Trigger_FileDelete(&$tNG) {
  $deleteObj = new tNG_FileDelete($tNG);
  $deleteObj->setFolder("../Firma_digital/cert/");
  $deleteObj->setDbFieldName("cert_file");
  return $deleteObj->Execute();
}
//end Trigger_FileDelete trigger

//start Trigger_FileUpload trigger
//remove this line if you want to edit the code by hand 
function Trigger_FileUpload(&$tNG) {
  $uploadObj = new tNG_FileUpload($tNG);
  $uploadObj->setFormFieldName("cert_file");
  $uploadObj->setDbFieldName("cert_file");
  $uploadObj->setFolder("../Firma_digital/cert/");
  $uploadObj->setMaxSize(4500);
  $uploadObj->setAllowedExtensions("pdf");
  $uploadObj->setRename("auto");
  return $uploadObj->Execute();
}
//end Trigger_FileUpload trigger

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

$colname_RsInfo = "-1";
if (isset($_GET['inf_id'])) {
  $colname_RsInfo = $_GET['inf_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_RsInfo = sprintf("SELECT * FROM informe_intersup WHERE inf_id = %s", GetSQLValueString($colname_RsInfo, "int"));
$RsInfo = mysql_query($query_RsInfo, $oConnContratos) or die(mysql_error());
$row_RsInfo = mysql_fetch_assoc($RsInfo);
$totalRows_RsInfo = mysql_num_rows($RsInfo);

// Make an insert transaction instance
$ins_informe_intersup = new tNG_multipleInsert($conn_oConnContratos);
$tNGs->addTransaction($ins_informe_intersup);
// Register triggers
$ins_informe_intersup->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_informe_intersup->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_informe_intersup->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$ins_informe_intersup->registerTrigger("BEFORE", "Trigger_Compare", 11);
$ins_informe_intersup->registerTrigger("AFTER", "Trigger_FileUpload", 97);
// Add columns
$ins_informe_intersup->setTable("informe_intersup");
$ins_informe_intersup->addColumn("sign_verificacert", "NUMERIC_TYPE", "POST", "sign_verificacert");
$ins_informe_intersup->addColumn("cert_date", "DATE_TYPE", "POST", "cert_date");
$ins_informe_intersup->addColumn("cert_file", "FILE_TYPE", "FILES", "cert_file");
$ins_informe_intersup->addColumn("cert_mail", "STRING_TYPE", "POST", "cert_mail");
$ins_informe_intersup->addColumn("cert_compare", "STRING_TYPE", "POST", "cert_compare");
$ins_informe_intersup->setPrimaryKey("inf_id", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_informe_intersup = new tNG_multipleUpdate($conn_oConnContratos);
$tNGs->addTransaction($upd_informe_intersup);
// Register triggers
$upd_informe_intersup->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_informe_intersup->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_informe_intersup->registerTrigger("END", "Trigger_Default_Redirect", 99, "ok.php?inf_id={GET.inf_id}");
$upd_informe_intersup->registerTrigger("BEFORE", "Trigger_Compare", 11);
$upd_informe_intersup->registerTrigger("AFTER", "Trigger_FileUpload", 97);
// Add columns
$upd_informe_intersup->setTable("informe_intersup");
$upd_informe_intersup->addColumn("sign_verificacert", "NUMERIC_TYPE", "POST", "sign_verificacert");
$upd_informe_intersup->addColumn("cert_date", "DATE_TYPE", "POST", "cert_date");
$upd_informe_intersup->addColumn("cert_file", "FILE_TYPE", "FILES", "cert_file");
$upd_informe_intersup->addColumn("cert_mail", "STRING_TYPE", "POST", "cert_mail");
$upd_informe_intersup->addColumn("cert_compare", "STRING_TYPE", "POST", "cert_compare");
$upd_informe_intersup->setPrimaryKey("inf_id", "NUMERIC_TYPE", "GET", "inf_id");

// Make an instance of the transaction object
$del_informe_intersup = new tNG_multipleDelete($conn_oConnContratos);
$tNGs->addTransaction($del_informe_intersup);
// Register triggers
$del_informe_intersup->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_informe_intersup->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$del_informe_intersup->registerTrigger("AFTER", "Trigger_FileDelete", 98);
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
<link rel="stylesheet" href="../_jquery/_desktop/_app/themes/south-street/jquery.ui.all.css">
</head>

<body>
<?php
	echo $tNGs->getErrorMsg();
?>
<div class="KT_tng">
  <h1>Subir certificado</h1>
  <div class="KT_tngform">
    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" enctype="multipart/form-data">
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
            <td class="KT_th">&nbsp;</td>
            <td><input name="sign_verificacert_<?php echo $cnt1; ?>" type="hidden" id="sign_verificacert_<?php echo $cnt1; ?>" value="2" />
                <?php echo $tNGs->displayFieldHint("sign_verificacert");?> <?php echo $tNGs->displayFieldError("informe_intersup", "sign_verificacert", $cnt1); ?>El nombre del certificado debe ser <?php echo $row_RsInfo['sign_hash'].".pdf"; ?> </td>
          </tr>
          <tr>
            <td class="KT_th">&nbsp;</td>
            <td><input name="cert_date_<?php echo $cnt1; ?>" type="hidden" id="cert_date_<?php echo $cnt1; ?>" value="<?php echo $fecha; ?>" />
                <?php echo $tNGs->displayFieldHint("cert_date");?> <?php echo $tNGs->displayFieldError("informe_intersup", "cert_date", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="cert_file_<?php echo $cnt1; ?>">Subir documento <?php echo $row_RsInfo['sign_hash'].".pdf"; ?> :</label></td>
            <td><input type="file" name="cert_file_<?php echo $cnt1; ?>" id="cert_file_<?php echo $cnt1; ?>" size="32" />
                <?php echo $tNGs->displayFieldError("informe_intersup", "cert_file", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th">&nbsp;</td>
            <td><input name="cert_mail_<?php echo $cnt1; ?>" type="hidden" id="cert_mail_<?php echo $cnt1; ?>" value="<?php echo $_SESSION['kt_usr_email']; ?>" />
                <?php echo $tNGs->displayFieldHint("cert_mail");?> <?php echo $tNGs->displayFieldError("informe_intersup", "cert_mail", $cnt1); ?> <input name="cert_compare_<?php echo $cnt1; ?>" type="hidden" id="cert_compare_<?php echo $cnt1; ?>" value="<?php echo $row_RsInfo['sign_hash'].".pdf"; ?>" />
                <?php echo $tNGs->displayFieldHint("cert_compare");?> <?php echo $tNGs->displayFieldError("informe_intersup", "cert_compare", $cnt1); ?> </td>
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
            <input type="submit" name="KT_Update1" value="Subir certificado" />
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
mysql_free_result($RsInfo);
?>
