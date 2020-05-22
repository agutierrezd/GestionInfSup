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
$formValidation->addField("send_mail", true, "text", "email", "", "", "");
$formValidation->addField("send_copy", false, "text", "email", "", "", "");
$formValidation->addField("send_fecha", true, "date", "datetime", "", "", "");
$formValidation->addField("send_file", true, "", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

//start Trigger_SendEmail trigger
//remove this line if you want to edit the code by hand
function Trigger_SendEmail(&$tNG) {
  $emailObj = new tNG_Email($tNG);
  $emailObj->setFrom("{KT_defaultSender}");
  $emailObj->setTo("{send_mail}");
  $emailObj->setCC("{send_copy}");
  $emailObj->setBCC("agutierrezd@mincit.gov.co");
  $emailObj->setSubject("Notificacion de pago MinCIT, Radicado: {hr_id_fk}");
  //FromFile method
  $emailObj->setContentFile("hr_not_user.html");
  $emailObj->setEncoding("ISO-8859-1");
  $emailObj->setFormat("HTML/Text");
  $emailObj->setImportance("High");
  //Attachments
  $emailObj->addAttachment("custom");
  $emailObj->setAttachmentBaseFolder("../_attach_notificaciones/");
  $emailObj->setAttachmentRenameRule("{send_file}");
  return $emailObj->Execute();
}
//end Trigger_SendEmail trigger

//start Trigger_Compare trigger
//remove this line if you want to edit the code by hand
function Trigger_Compare(&$tNG) {
	$fieldCompareObj = new tNG_FieldCompare($tNG);
	$fieldCompareObj->addField("send_file", "{POST.tcompare}", "==", "Verifique el nombre del documento .PDF que est� adjuntando.");
	return $fieldCompareObj->Execute();	
}
//end Trigger_Compare trigger

//start Trigger_FileDelete trigger
//remove this line if you want to edit the code by hand 
function Trigger_FileDelete(&$tNG) {
  $deleteObj = new tNG_FileDelete($tNG);
  $deleteObj->setFolder("../_attach_notificaciones/");
  $deleteObj->setDbFieldName("send_file");
  return $deleteObj->Execute();
}
//end Trigger_FileDelete trigger

//start Trigger_FileUpload trigger
//remove this line if you want to edit the code by hand 
function Trigger_FileUpload(&$tNG) {
  $uploadObj = new tNG_FileUpload($tNG);
  $uploadObj->setFormFieldName("send_file");
  $uploadObj->setDbFieldName("send_file");
  $uploadObj->setFolder("../_attach_notificaciones/");
  $uploadObj->setMaxSize(10500);
  $uploadObj->setAllowedExtensions("pdf");
  $uploadObj->setRename("custom");
  $uploadObj->setRenameRule("{hr_id_fk}_{send_id}.{KT_ext}");
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

$colname_rsinfohr = "-1";
if (isset($_GET['hr_id'])) {
  $colname_rsinfohr = $_GET['hr_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rsinfohr = sprintf("SELECT * FROM q_hoja_ruta_notpago WHERE hr_id_fk = %s", GetSQLValueString($colname_rsinfohr, "int"));
$rsinfohr = mysql_query($query_rsinfohr, $oConnContratos) or die(mysql_error());
$row_rsinfohr = mysql_fetch_assoc($rsinfohr);
$totalRows_rsinfohr = mysql_num_rows($rsinfohr);

$colname_rscontratistas = "-1";
if (isset($_GET['contractor_doc_id'])) {
  $colname_rscontratistas = $_GET['contractor_doc_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rscontratistas = sprintf("SELECT * FROM contractor_master WHERE contractor_doc_id = %s", GetSQLValueString($colname_rscontratistas, "text"));
$rscontratistas = mysql_query($query_rscontratistas, $oConnContratos) or die(mysql_error());
$row_rscontratistas = mysql_fetch_assoc($rscontratistas);
$totalRows_rscontratistas = mysql_num_rows($rscontratistas);

$colname_rsctrlsend = "-1";
if (isset($_GET['hr_id'])) {
  $colname_rsctrlsend = $_GET['hr_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rsctrlsend = sprintf("SELECT * FROM hoja_ruta_notuser WHERE hr_id_fk = %s", GetSQLValueString($colname_rsctrlsend, "int"));
$rsctrlsend = mysql_query($query_rsctrlsend, $oConnContratos) or die(mysql_error());
$row_rsctrlsend = mysql_fetch_assoc($rsctrlsend);
$totalRows_rsctrlsend = mysql_num_rows($rsctrlsend);

$colname_RsAviso = "-1";
if (isset($_GET['hr_id'])) {
  $colname_RsAviso = $_GET['hr_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_RsAviso = sprintf("SELECT * FROM q_hoja_ruta_maestra_info_2015 WHERE hr_id = %s", GetSQLValueString($colname_RsAviso, "int"));
$RsAviso = mysql_query($query_RsAviso, $oConnContratos) or die(mysql_error());
$row_RsAviso = mysql_fetch_assoc($RsAviso);
$totalRows_RsAviso = mysql_num_rows($RsAviso);

// Make an insert transaction instance
$ins_hoja_ruta_notuser = new tNG_multipleInsert($conn_oConnContratos);
$tNGs->addTransaction($ins_hoja_ruta_notuser);
// Register triggers
$ins_hoja_ruta_notuser->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_hoja_ruta_notuser->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_hoja_ruta_notuser->registerTrigger("END", "Trigger_Default_Redirect", 99, "ok.php");
$ins_hoja_ruta_notuser->registerTrigger("AFTER", "Trigger_FileUpload", 97);
$ins_hoja_ruta_notuser->registerTrigger("AFTER", "Trigger_SendEmail", 98);
$ins_hoja_ruta_notuser->registerTrigger("BEFORE", "Trigger_Compare", 11);
// Add columns
$ins_hoja_ruta_notuser->setTable("hoja_ruta_notuser");
$ins_hoja_ruta_notuser->addColumn("hr_id_fk", "NUMERIC_TYPE", "POST", "hr_id_fk");
$ins_hoja_ruta_notuser->addColumn("send_mail", "STRING_TYPE", "POST", "send_mail");
$ins_hoja_ruta_notuser->addColumn("send_copy", "STRING_TYPE", "POST", "send_copy");
$ins_hoja_ruta_notuser->addColumn("send_fecha", "DATE_TYPE", "POST", "send_fecha");
$ins_hoja_ruta_notuser->addColumn("send_file", "FILE_TYPE", "FILES", "send_file");
$ins_hoja_ruta_notuser->setPrimaryKey("send_id", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_hoja_ruta_notuser = new tNG_multipleUpdate($conn_oConnContratos);
$tNGs->addTransaction($upd_hoja_ruta_notuser);
// Register triggers
$upd_hoja_ruta_notuser->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_hoja_ruta_notuser->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_hoja_ruta_notuser->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$upd_hoja_ruta_notuser->registerTrigger("AFTER", "Trigger_FileUpload", 97);
$upd_hoja_ruta_notuser->registerTrigger("AFTER", "Trigger_SendEmail", 98);
$upd_hoja_ruta_notuser->registerTrigger("BEFORE", "Trigger_Compare", 11);
// Add columns
$upd_hoja_ruta_notuser->setTable("hoja_ruta_notuser");
$upd_hoja_ruta_notuser->addColumn("hr_id_fk", "NUMERIC_TYPE", "POST", "hr_id_fk");
$upd_hoja_ruta_notuser->addColumn("send_mail", "STRING_TYPE", "POST", "send_mail");
$upd_hoja_ruta_notuser->addColumn("send_copy", "STRING_TYPE", "POST", "send_copy");
$upd_hoja_ruta_notuser->addColumn("send_fecha", "DATE_TYPE", "POST", "send_fecha");
$upd_hoja_ruta_notuser->addColumn("send_file", "FILE_TYPE", "FILES", "send_file");
$upd_hoja_ruta_notuser->setPrimaryKey("send_id", "NUMERIC_TYPE", "GET", "send_id");

// Make an instance of the transaction object
$del_hoja_ruta_notuser = new tNG_multipleDelete($conn_oConnContratos);
$tNGs->addTransaction($del_hoja_ruta_notuser);
// Register triggers
$del_hoja_ruta_notuser->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_hoja_ruta_notuser->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$del_hoja_ruta_notuser->registerTrigger("AFTER", "Trigger_FileDelete", 98);
// Add columns
$del_hoja_ruta_notuser->setTable("hoja_ruta_notuser");
$del_hoja_ruta_notuser->setPrimaryKey("send_id", "NUMERIC_TYPE", "GET", "send_id");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rshoja_ruta_notuser = $tNGs->getRecordset("hoja_ruta_notuser");
$row_rshoja_ruta_notuser = mysql_fetch_assoc($rshoja_ruta_notuser);
$totalRows_rshoja_ruta_notuser = mysql_num_rows($rshoja_ruta_notuser);

// Download File downloadObj1
$downloadObj1 = new tNG_Download("../", "KT_download1");
// Execute
$downloadObj1->setFolder("../_attach_notificaciones/");
$downloadObj1->setRenameRule("{rsctrlsend.send_file}");
$downloadObj1->Execute();
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
<?php if ($totalRows_rsctrlsend == 0) { // Show if recordset empty ?>
  <div class="KT_tng">
    <h1> Notificaci�n de pago </h1>
    <div class="KT_tngform">
      <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" enctype="multipart/form-data">
        <?php $cnt1 = 0; ?>
        <?php do { ?>
          <?php $cnt1++; ?>
          <?php 
// Show IF Conditional region1 
if (@$totalRows_rshoja_ruta_notuser > 1) {
?>
            <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
            <?php } 
// endif Conditional region1
?>
          <table cellpadding="2" cellspacing="0" class="KT_tngtable">
            <tr>
              <td class="KT_th"><label for="hr_id_fk_<?php echo $cnt1; ?>"></label></td>
              <td><input name="hr_id_fk_<?php echo $cnt1; ?>" type="hidden" id="hr_id_fk_<?php echo $cnt1; ?>" value="<?php echo $row_rsinfohr['hr_id_fk']; ?>" />
                  <?php echo $tNGs->displayFieldHint("hr_id_fk");?> <?php echo $tNGs->displayFieldError("hoja_ruta_notuser", "hr_id_fk", $cnt1); ?>
                  <input name="tcompare" type="hidden" id="tcompare" value="<?php echo $row_rsinfohr['hr_id_fk'].'.pdf'; ?>" /></td>
            </tr>
            <tr>
              <td class="KT_th"><label for="send_mail_<?php echo $cnt1; ?>">Notificar a :</label></td>
              <td><input name="send_mail_<?php echo $cnt1; ?>" type="text" id="send_mail_<?php echo $cnt1; ?>" value="<?php echo $row_rscontratistas['contractor_email']; ?>" size="32" maxlength="60" />
                  <?php echo $tNGs->displayFieldHint("send_mail");?> <?php echo $tNGs->displayFieldError("hoja_ruta_notuser", "send_mail", $cnt1); ?> </td>
            </tr>
            <tr>
              <td class="KT_th"><label for="send_copy_<?php echo $cnt1; ?>">Copiar a:</label></td>
              <td><input type="text" name="send_copy_<?php echo $cnt1; ?>" id="send_copy_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rshoja_ruta_notuser['send_copy']); ?>" size="32" maxlength="60" />
                  <?php echo $tNGs->displayFieldHint("send_copy");?> <?php echo $tNGs->displayFieldError("hoja_ruta_notuser", "send_copy", $cnt1); ?> </td>
            </tr>
            <tr>
              <td class="KT_th"><label for="send_fecha_<?php echo $cnt1; ?>">Fecha de envio:</label></td>
              <td><input name="send_fecha_<?php echo $cnt1; ?>" type="text" id="send_fecha_<?php echo $cnt1; ?>" value="<?php echo $fechac; ?>" size="20" maxlength="22" readonly="true" />
                  <?php echo $tNGs->displayFieldHint("send_fecha");?> <?php echo $tNGs->displayFieldError("hoja_ruta_notuser", "send_fecha", $cnt1); ?> </td>
            </tr>
            <tr>
              <td class="KT_th"><label for="send_file_<?php echo $cnt1; ?>">Adjuntar notificaci&oacute;n:</label></td>
              <td><input type="file" name="send_file_<?php echo $cnt1; ?>" id="send_file_<?php echo $cnt1; ?>" size="32" />
                  <?php echo $tNGs->displayFieldError("hoja_ruta_notuser", "send_file", $cnt1); ?>
                  <?php
	echo $tNGs->getErrorMsg();
?></td>
            </tr>
          </table>
          <input type="hidden" name="kt_pk_hoja_ruta_notuser_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rshoja_ruta_notuser['kt_pk_hoja_ruta_notuser']); ?>" />
          <?php } while ($row_rshoja_ruta_notuser = mysql_fetch_assoc($rshoja_ruta_notuser)); ?>
        <div class="KT_bottombuttons">
          <div>
            <?php 
      // Show IF Conditional region1
      if (@$_GET['send_id'] == "") {
      ?>
              <input type="submit" name="KT_Insert1" id="KT_Insert1" value="Enviar" />
              <?php 
      // else Conditional region1
      } else { ?>
              <input type="submit" name="KT_Update1" value="Enviar" />
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
  <?php } // Show if recordset empty ?>
<p>&nbsp;</p>
<?php if ($totalRows_rsctrlsend > 0) { // Show if recordset not empty ?>
  <table width="95%" border="0" cellspacing="2" cellpadding="0">
    <tr>
      <td colspan="2" class="titlemsg2">La notificaci&oacute;n ya fu&eacute; realizada!</td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td width="15%">Fecha de env&iacute;o:</td>
      <td width="85%"><?php echo $row_rsctrlsend['send_fecha']; ?></td>
    </tr>
    <tr>
      <td>Copiado a los correos:</td>
      <td><?php echo $row_rsctrlsend['send_mail']; ?>;<?php echo $row_rsctrlsend['send_copy']; ?></td>
    </tr>
    <tr>
      <td>Documento adjunto:</td>
      <td><a href="<?php echo $downloadObj1->getDownloadLink(); ?>"><?php echo $row_rsctrlsend['send_file']; ?></a></td>
    </tr>
    <tr>
      <td>Notificaciones realizadas</td>
      <td><?php echo $row_RsAviso['QSEND']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><a href="hr_not_user_2.php?hr_id=<?php echo $_GET['hr_id']; ?>&amp;contractor_doc_id=<?php echo $_GET['contractor_doc_id']; ?>">Notificar nuevamente</a></td>
    </tr>
  </table>
  <?php } // Show if recordset not empty ?>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($rsinfohr);

mysql_free_result($rscontratistas);

mysql_free_result($rsctrlsend);

mysql_free_result($RsAviso);
?>
