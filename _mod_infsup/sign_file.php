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
$formValidation->addField("inf_estado", true, "numeric", "", "", "", "");
$formValidation->addField("sign_hash", true, "text", "", "", "", "");
$formValidation->addField("sign_date", true, "date", "", "", "", "");
$formValidation->addField("sign_file", true, "", "", "", "", "");
$formValidation->addField("sign_mailnot", true, "text", "", "", "", "");
$formValidation->addField("file_verifica", true, "text", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

//start Trigger_Compare trigger
//remove this line if you want to edit the code by hand
function Trigger_Compare(&$tNG) {
	$fieldCompareObj = new tNG_FieldCompare($tNG);
	$fieldCompareObj->addField("sign_file", "{file_verifica}", "==", "No se permite subir el archivo, ya que no cumple con los requerimientos del nombre o la extensi�n.");
	return $fieldCompareObj->Execute();	
}
//end Trigger_Compare trigger

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

$colname_rsinf = "-1";
if (isset($_GET['inf_id'])) {
  $colname_rsinf = $_GET['inf_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rsinf = sprintf("SELECT * FROM informe_intersup WHERE inf_id = %s", GetSQLValueString($colname_rsinf, "int"));
$rsinf = mysql_query($query_rsinf, $oConnContratos) or die(mysql_error());
$row_rsinf = mysql_fetch_assoc($rsinf);
$totalRows_rsinf = mysql_num_rows($rsinf);

//start Trigger_FileDelete trigger
//remove this line if you want to edit the code by hand 
function Trigger_FileDelete(&$tNG) {
  $deleteObj = new tNG_FileDelete($tNG);
  $deleteObj->setFolder("../Firma_digital/");
  $deleteObj->setDbFieldName("sign_file");
  return $deleteObj->Execute();
}
//end Trigger_FileDelete trigger

//start Trigger_FileUpload trigger
//remove this line if you want to edit the code by hand 
function Trigger_FileUpload(&$tNG) {
  $uploadObj = new tNG_FileUpload($tNG);
  $uploadObj->setFormFieldName("sign_file");
  $uploadObj->setDbFieldName("sign_file");
  $uploadObj->setFolder("../Firma_digital/");
  $uploadObj->setMaxSize(10500);
  $uploadObj->setAllowedExtensions("pdf");
  $uploadObj->setRename("auto");
  return $uploadObj->Execute();
}
//end Trigger_FileUpload trigger

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
$ins_informe_intersup->addColumn("inf_estado", "NUMERIC_TYPE", "POST", "inf_estado");
$ins_informe_intersup->addColumn("sign_hash", "STRING_TYPE", "POST", "sign_hash");
$ins_informe_intersup->addColumn("sign_date", "DATE_TYPE", "POST", "sign_date");
$ins_informe_intersup->addColumn("sign_file", "FILE_TYPE", "FILES", "sign_file");
$ins_informe_intersup->addColumn("sign_mailnot", "STRING_TYPE", "POST", "sign_mailnot");
$ins_informe_intersup->addColumn("file_verifica", "STRING_TYPE", "POST", "file_verifica");
$ins_informe_intersup->setPrimaryKey("inf_id", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_informe_intersup = new tNG_multipleUpdate($conn_oConnContratos);
$tNGs->addTransaction($upd_informe_intersup);
// Register triggers
$upd_informe_intersup->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_informe_intersup->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_informe_intersup->registerTrigger("END", "Trigger_Default_Redirect", 99, "ok.php");
$upd_informe_intersup->registerTrigger("BEFORE", "Trigger_Compare", 11);
$upd_informe_intersup->registerTrigger("AFTER", "Trigger_FileUpload", 97);
// Add columns
$upd_informe_intersup->setTable("informe_intersup");
$upd_informe_intersup->addColumn("inf_estado", "NUMERIC_TYPE", "POST", "inf_estado");
$upd_informe_intersup->addColumn("sign_hash", "STRING_TYPE", "POST", "sign_hash");
$upd_informe_intersup->addColumn("sign_date", "DATE_TYPE", "POST", "sign_date");
$upd_informe_intersup->addColumn("sign_file", "FILE_TYPE", "FILES", "sign_file");
$upd_informe_intersup->addColumn("sign_mailnot", "STRING_TYPE", "POST", "sign_mailnot");
$upd_informe_intersup->addColumn("file_verifica", "STRING_TYPE", "POST", "file_verifica");
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
</head>

<body>
<?php
	echo $tNGs->getErrorMsg();
?>
<div class="KT_tng">
  <h1>&nbsp;</h1>
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
            <td width="19%" class="KT_th">&nbsp;</td>
        <td width="81%"><input type="hidden" name="inf_estado_<?php echo $cnt1; ?>" id="inf_estado_<?php echo $cnt1; ?>" value="2" size="2" />
                <?php echo $tNGs->displayFieldHint("inf_estado");?> <?php echo $tNGs->displayFieldError("informe_intersup", "inf_estado", $cnt1); ?> <input type="hidden" name="sign_hash_<?php echo $cnt1; ?>" id="sign_hash_<?php echo $cnt1; ?>" value="<?php echo $letra.$numeroa.$letrab.$numerob.$letrac; ?>" size="20" maxlength="20" />
                <?php echo $tNGs->displayFieldHint("sign_hash");?> <?php echo $tNGs->displayFieldError("informe_intersup", "sign_hash", $cnt1); ?> <input type="hidden" name="sign_date_<?php echo $cnt1; ?>" id="sign_date_<?php echo $cnt1; ?>" value="<?php echo $fecha; ?>" size="10" maxlength="22" />
            <?php echo $tNGs->displayFieldHint("sign_date");?> <?php echo $tNGs->displayFieldError("informe_intersup", "sign_date", $cnt1); ?> 
                <input name="sign_mailnot_<?php echo $cnt1; ?>" type="hidden" id="sign_mailnot_<?php echo $cnt1; ?>" value="<?php echo $_SESSION['kt_usr_email']; ?>" />
                <?php echo $tNGs->displayFieldHint("sign_mailnot");?> <?php echo $tNGs->displayFieldError("informe_intersup", "sign_mailnot", $cnt1); ?> Seleccione el documento y presione el bot&oacute;n &quot;Subir documento&quot;</td>
          </tr>
          
          <tr>
            <td class="KT_th"><label for="sign_file_<?php echo $cnt1; ?>">Seleccione el archivo .PDF <br />
            que se va a firmar digitalmente:</label></td>
            <td><input type="file" name="sign_file_<?php echo $cnt1; ?>" id="sign_file_<?php echo $cnt1; ?>" size="32" />
                <?php echo $tNGs->displayFieldError("informe_intersup", "sign_file", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th">&nbsp;</td>
            <td><input name="file_verifica_<?php echo $cnt1; ?>" type="hidden" id="file_verifica_<?php echo $cnt1; ?>" value="<?php echo $row_rsinf['inf_hash'].".pdf"; ?>" />
                <?php echo $tNGs->displayFieldHint("file_verifica");?> <?php echo $tNGs->displayFieldError("informe_intersup", "file_verifica", $cnt1); ?> Tip: El nombre del documento a cargar debe ser: <?php echo $row_rsinf['inf_hash'].".pdf"; ?> </td>
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
            <input type="submit" name="KT_Update1" value="Subir documento" />
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
mysql_free_result($rsinf);
?>
