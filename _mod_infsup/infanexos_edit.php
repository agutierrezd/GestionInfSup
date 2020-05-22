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
$formValidation->addField("inf_id_fk", true, "numeric", "", "", "", "");
$formValidation->addField("id_cont_fk", true, "numeric", "", "", "", "");
$formValidation->addField("anexo_titulo", true, "text", "", "", "", "");
$formValidation->addField("anexo_file", true, "", "", "", "", "");
$formValidation->addField("anexo_fecha", true, "date", "", "", "", "");
$formValidation->addField("anexo_hora", true, "date", "", "", "", "");
$formValidation->addField("anexo_usuario", true, "text", "", "", "", "");
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

$colname_rsinfolist = "-1";
if (isset($_GET['inf_id'])) {
  $colname_rsinfolist = $_GET['inf_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rsinfolist = sprintf("SELECT * FROM informe_intersup WHERE inf_id = %s", GetSQLValueString($colname_rsinfolist, "int"));
$rsinfolist = mysql_query($query_rsinfolist, $oConnContratos) or die(mysql_error());
$row_rsinfolist = mysql_fetch_assoc($rsinfolist);
$totalRows_rsinfolist = mysql_num_rows($rsinfolist);

//start Trigger_FileDelete trigger
//remove this line if you want to edit the code by hand 
function Trigger_FileDelete(&$tNG) {
  $deleteObj = new tNG_FileDelete($tNG);
  $deleteObj->setFolder("../_attach_infanexos/");
  $deleteObj->setDbFieldName("anexo_file");
  return $deleteObj->Execute();
}
//end Trigger_FileDelete trigger

//start Trigger_FileUpload trigger
//remove this line if you want to edit the code by hand 
function Trigger_FileUpload(&$tNG) {
  $uploadObj = new tNG_FileUpload($tNG);
  $uploadObj->setFormFieldName("anexo_file");
  $uploadObj->setDbFieldName("anexo_file");
  $uploadObj->setFolder("../_attach_infanexos/");
  $uploadObj->setMaxSize(10500);
  $uploadObj->setAllowedExtensions("pdf, doc, docx, xls, xlsx, rar, zip, jpg, png, jpeg");
  $uploadObj->setRename("custom");
  $uploadObj->setRenameRule("{rsinfolist.inf_numerocontrato}_{id_cont_fk}_{inf_id_fk}_{inf_anexo_id}.{KT_ext}");
  return $uploadObj->Execute();
}
//end Trigger_FileUpload trigger

// Make an insert transaction instance
$ins_informe_intersup_anexos = new tNG_multipleInsert($conn_oConnContratos);
$tNGs->addTransaction($ins_informe_intersup_anexos);
// Register triggers
$ins_informe_intersup_anexos->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_informe_intersup_anexos->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_informe_intersup_anexos->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$ins_informe_intersup_anexos->registerTrigger("AFTER", "Trigger_FileUpload", 97);
// Add columns
$ins_informe_intersup_anexos->setTable("informe_intersup_anexos");
$ins_informe_intersup_anexos->addColumn("inf_id_fk", "NUMERIC_TYPE", "POST", "inf_id_fk");
$ins_informe_intersup_anexos->addColumn("id_cont_fk", "NUMERIC_TYPE", "POST", "id_cont_fk");
$ins_informe_intersup_anexos->addColumn("anexo_titulo", "STRING_TYPE", "POST", "anexo_titulo");
$ins_informe_intersup_anexos->addColumn("anexo_file", "FILE_TYPE", "FILES", "anexo_file");
$ins_informe_intersup_anexos->addColumn("anexo_fecha", "DATE_TYPE", "POST", "anexo_fecha");
$ins_informe_intersup_anexos->addColumn("anexo_hora", "DATE_TYPE", "POST", "anexo_hora");
$ins_informe_intersup_anexos->addColumn("anexo_usuario", "STRING_TYPE", "POST", "anexo_usuario");
$ins_informe_intersup_anexos->setPrimaryKey("inf_anexo_id", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_informe_intersup_anexos = new tNG_multipleUpdate($conn_oConnContratos);
$tNGs->addTransaction($upd_informe_intersup_anexos);
// Register triggers
$upd_informe_intersup_anexos->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_informe_intersup_anexos->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_informe_intersup_anexos->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$upd_informe_intersup_anexos->registerTrigger("AFTER", "Trigger_FileUpload", 97);
// Add columns
$upd_informe_intersup_anexos->setTable("informe_intersup_anexos");
$upd_informe_intersup_anexos->addColumn("inf_id_fk", "NUMERIC_TYPE", "POST", "inf_id_fk");
$upd_informe_intersup_anexos->addColumn("id_cont_fk", "NUMERIC_TYPE", "POST", "id_cont_fk");
$upd_informe_intersup_anexos->addColumn("anexo_titulo", "STRING_TYPE", "POST", "anexo_titulo");
$upd_informe_intersup_anexos->addColumn("anexo_file", "FILE_TYPE", "FILES", "anexo_file");
$upd_informe_intersup_anexos->addColumn("anexo_fecha", "DATE_TYPE", "POST", "anexo_fecha");
$upd_informe_intersup_anexos->addColumn("anexo_hora", "DATE_TYPE", "POST", "anexo_hora");
$upd_informe_intersup_anexos->addColumn("anexo_usuario", "STRING_TYPE", "POST", "anexo_usuario");
$upd_informe_intersup_anexos->setPrimaryKey("inf_anexo_id", "NUMERIC_TYPE", "GET", "inf_anexo_id");

// Make an instance of the transaction object
$del_informe_intersup_anexos = new tNG_multipleDelete($conn_oConnContratos);
$tNGs->addTransaction($del_informe_intersup_anexos);
// Register triggers
$del_informe_intersup_anexos->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_informe_intersup_anexos->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$del_informe_intersup_anexos->registerTrigger("AFTER", "Trigger_FileDelete", 98);
// Add columns
$del_informe_intersup_anexos->setTable("informe_intersup_anexos");
$del_informe_intersup_anexos->setPrimaryKey("inf_anexo_id", "NUMERIC_TYPE", "GET", "inf_anexo_id");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsinforme_intersup_anexos = $tNGs->getRecordset("informe_intersup_anexos");
$row_rsinforme_intersup_anexos = mysql_fetch_assoc($rsinforme_intersup_anexos);
$totalRows_rsinforme_intersup_anexos = mysql_num_rows($rsinforme_intersup_anexos);
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
if (@$_GET['inf_anexo_id'] == "") {
?>
      <?php echo NXT_getResource("Insert_FH"); ?>
      <?php 
// else Conditional region1
} else { ?>
      <?php echo NXT_getResource("Update_FH"); ?>
      <?php } 
// endif Conditional region1
?>
    Informe_intersup_anexos </h1>
  <div class="KT_tngform">
    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" enctype="multipart/form-data">
      <?php $cnt1 = 0; ?>
      <?php do { ?>
        <?php $cnt1++; ?>
        <?php 
// Show IF Conditional region1 
if (@$totalRows_rsinforme_intersup_anexos > 1) {
?>
          <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
          <?php } 
// endif Conditional region1
?>
        <table cellpadding="2" cellspacing="0" class="KT_tngtable">
          <tr>
            <td width="16%" class="KT_th">&nbsp;</td>
            <td width="84%"><input name="inf_id_fk_<?php echo $cnt1; ?>" type="hidden" id="inf_id_fk_<?php echo $cnt1; ?>" value="<?php echo $_GET['inf_id']; ?>" size="7" />
                <?php echo $tNGs->displayFieldHint("inf_id_fk");?> <?php echo $tNGs->displayFieldError("informe_intersup_anexos", "inf_id_fk", $cnt1); ?> <input name="id_cont_fk_<?php echo $cnt1; ?>" type="hidden" id="id_cont_fk_<?php echo $cnt1; ?>" value="<?php echo $_GET['doc_id']; ?>" size="7" />
                <?php echo $tNGs->displayFieldHint("id_cont_fk");?> <?php echo $tNGs->displayFieldError("informe_intersup_anexos", "id_cont_fk", $cnt1); ?> <input type="hidden" name="anexo_fecha_<?php echo $cnt1; ?>" id="anexo_fecha_<?php echo $cnt1; ?>" value="<?php echo $fecha; ?>" size="10" maxlength="22" />
                <?php echo $tNGs->displayFieldHint("anexo_fecha");?> <?php echo $tNGs->displayFieldError("informe_intersup_anexos", "anexo_fecha", $cnt1); ?>
                <input type="hidden" name="anexo_hora_<?php echo $cnt1; ?>" id="anexo_hora_<?php echo $cnt1; ?>" value="<?php echo $hora; ?>" size="10" maxlength="22" />
                <?php echo $tNGs->displayFieldHint("anexo_hora");?> <?php echo $tNGs->displayFieldError("informe_intersup_anexos", "anexo_hora", $cnt1); ?>
                <input name="anexo_usuario_<?php echo $cnt1; ?>" type="hidden" id="anexo_usuario_<?php echo $cnt1; ?>" value="<?php echo $_SESSION['kt_login_user']; ?>" size="32" maxlength="60" />
                <?php echo $tNGs->displayFieldHint("anexo_usuario");?> <?php echo $tNGs->displayFieldError("informe_intersup_anexos", "anexo_usuario", $cnt1); ?>Para los contratos de Prestaci�n de Servicios Profesionales y de Apoyo a la Gesti�n, s�lo ser� el informe de actividades del Contratista </td>
          </tr>
          
          <tr>
            <td class="KT_th"><label for="anexo_titulo_<?php echo $cnt1; ?>">Descripci&oacute;n del documento adjunto:</label></td>
            <td><input type="text" name="anexo_titulo_<?php echo $cnt1; ?>" id="anexo_titulo_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsinforme_intersup_anexos['anexo_titulo']); ?>" size="70" maxlength="150" />
                <?php echo $tNGs->displayFieldHint("anexo_titulo");?> <?php echo $tNGs->displayFieldError("informe_intersup_anexos", "anexo_titulo", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="anexo_file_<?php echo $cnt1; ?>">Seleccionar documento:</label></td>
            <td><input type="file" name="anexo_file_<?php echo $cnt1; ?>" id="anexo_file_<?php echo $cnt1; ?>" size="32" />
                <?php echo $tNGs->displayFieldError("informe_intersup_anexos", "anexo_file", $cnt1); ?> </td>
          </tr>
        </table>
        <input type="hidden" name="kt_pk_informe_intersup_anexos_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rsinforme_intersup_anexos['kt_pk_informe_intersup_anexos']); ?>" />
        <?php } while ($row_rsinforme_intersup_anexos = mysql_fetch_assoc($rsinforme_intersup_anexos)); ?>
      <div class="KT_bottombuttons">
        <div>
          <?php 
      // Show IF Conditional region1
      if (@$_GET['inf_anexo_id'] == "") {
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
mysql_free_result($rsinfolist);
?>
