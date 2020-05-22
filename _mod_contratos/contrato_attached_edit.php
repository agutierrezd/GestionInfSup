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
$formValidation->addField("att_type", true, "numeric", "", "", "", "");
$formValidation->addField("att_file", true, "", "", "", "", "");
$formValidation->addField("sys_user", true, "text", "", "", "", "");
$formValidation->addField("sys_date", true, "date", "", "", "", "");
$formValidation->addField("sys_time", true, "date", "", "", "", "");
$formValidation->addField("sys_stat", true, "numeric", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

//start Trigger_FileDelete trigger
//remove this line if you want to edit the code by hand 
function Trigger_FileDelete(&$tNG) {
  $deleteObj = new tNG_FileDelete($tNG);
  $deleteObj->setFolder("../_attached/");
  $deleteObj->setDbFieldName("att_file");
  return $deleteObj->Execute();
}
//end Trigger_FileDelete trigger

//start Trigger_FileUpload trigger
//remove this line if you want to edit the code by hand 
function Trigger_FileUpload(&$tNG) {
  $uploadObj = new tNG_FileUpload($tNG);
  $uploadObj->setFormFieldName("att_file");
  $uploadObj->setDbFieldName("att_file");
  $uploadObj->setFolder("../_attached/");
  $uploadObj->setMaxSize(20500);
  $uploadObj->setAllowedExtensions("pdf");
  $uploadObj->setRename("custom");
  $uploadObj->setRenameRule("{rscodatt.att_type_cod}_{rscodct.pre_contnumero}_{rscodct.contnumero}_{rscodct.cont_ano}_{id_att}.{KT_ext}");
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

$colname_rscodatt = "-1";
if (isset($_GET['id_att'])) {
  $colname_rscodatt = $_GET['id_att'];
}
$colnamo_rscodatt = "-1";
if (isset($_GET['id_cont'])) {
  $colnamo_rscodatt = $_GET['id_cont'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rscodatt = sprintf("SELECT * FROM q_info_attached WHERE id_att = %s AND id_cont_fk = %s", GetSQLValueString($colname_rscodatt, "int"),GetSQLValueString($colnamo_rscodatt, "int"));
$rscodatt = mysql_query($query_rscodatt, $oConnContratos) or die(mysql_error());
$row_rscodatt = mysql_fetch_assoc($rscodatt);
$totalRows_rscodatt = mysql_num_rows($rscodatt);

$colname_rscodct = "-1";
if (isset($_GET['id_cont'])) {
  $colname_rscodct = $_GET['id_cont'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rscodct = sprintf("SELECT id_cont, pre_contnumero, contnumero, cont_ano FROM contrato WHERE id_cont = %s", GetSQLValueString($colname_rscodct, "int"));
$rscodct = mysql_query($query_rscodct, $oConnContratos) or die(mysql_error());
$row_rscodct = mysql_fetch_assoc($rscodct);
$totalRows_rscodct = mysql_num_rows($rscodct);

// Make an insert transaction instance
$ins_contrato_attached = new tNG_multipleInsert($conn_oConnContratos);
$tNGs->addTransaction($ins_contrato_attached);
// Register triggers
$ins_contrato_attached->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_contrato_attached->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_contrato_attached->registerTrigger("END", "Trigger_Default_Redirect", 99, "ok.php");
$ins_contrato_attached->registerTrigger("AFTER", "Trigger_FileUpload", 97);
// Add columns
$ins_contrato_attached->setTable("contrato_attached");
$ins_contrato_attached->addColumn("id_cont_fk", "NUMERIC_TYPE", "POST", "id_cont_fk");
$ins_contrato_attached->addColumn("att_type", "NUMERIC_TYPE", "POST", "att_type");
$ins_contrato_attached->addColumn("att_file", "FILE_TYPE", "FILES", "att_file");
$ins_contrato_attached->addColumn("sys_user", "STRING_TYPE", "POST", "sys_user");
$ins_contrato_attached->addColumn("sys_date", "DATE_TYPE", "POST", "sys_date");
$ins_contrato_attached->addColumn("sys_time", "DATE_TYPE", "POST", "sys_time");
$ins_contrato_attached->addColumn("sys_stat", "NUMERIC_TYPE", "POST", "sys_stat");
$ins_contrato_attached->setPrimaryKey("id_att", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_contrato_attached = new tNG_multipleUpdate($conn_oConnContratos);
$tNGs->addTransaction($upd_contrato_attached);
// Register triggers
$upd_contrato_attached->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_contrato_attached->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_contrato_attached->registerTrigger("END", "Trigger_Default_Redirect", 99, "okm.php");
$upd_contrato_attached->registerTrigger("AFTER", "Trigger_FileUpload", 97);
// Add columns
$upd_contrato_attached->setTable("contrato_attached");
$upd_contrato_attached->addColumn("id_cont_fk", "NUMERIC_TYPE", "POST", "id_cont_fk");
$upd_contrato_attached->addColumn("att_type", "NUMERIC_TYPE", "POST", "att_type");
$upd_contrato_attached->addColumn("att_file", "FILE_TYPE", "FILES", "att_file");
$upd_contrato_attached->addColumn("sys_user", "STRING_TYPE", "POST", "sys_user");
$upd_contrato_attached->addColumn("sys_date", "DATE_TYPE", "POST", "sys_date");
$upd_contrato_attached->addColumn("sys_time", "DATE_TYPE", "POST", "sys_time");
$upd_contrato_attached->addColumn("sys_stat", "NUMERIC_TYPE", "POST", "sys_stat");
$upd_contrato_attached->setPrimaryKey("id_att", "NUMERIC_TYPE", "GET", "id_att");

// Make an instance of the transaction object
$del_contrato_attached = new tNG_multipleDelete($conn_oConnContratos);
$tNGs->addTransaction($del_contrato_attached);
// Register triggers
$del_contrato_attached->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_contrato_attached->registerTrigger("END", "Trigger_Default_Redirect", 99, "oka.php");
$del_contrato_attached->registerTrigger("AFTER", "Trigger_FileDelete", 98);
// Add columns
$del_contrato_attached->setTable("contrato_attached");
$del_contrato_attached->setPrimaryKey("id_att", "NUMERIC_TYPE", "GET", "id_att");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rscontrato_attached = $tNGs->getRecordset("contrato_attached");
$row_rscontrato_attached = mysql_fetch_assoc($rscontrato_attached);
$totalRows_rscontrato_attached = mysql_num_rows($rscontrato_attached);
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
if (@$_GET['id_att'] == "") {
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
    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" enctype="multipart/form-data">
      <?php $cnt1 = 0; ?>
      <?php do { ?>
        <?php $cnt1++; ?>
        <?php 
// Show IF Conditional region1 
if (@$totalRows_rscontrato_attached > 1) {
?>
          <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
          <?php } 
// endif Conditional region1
?>
        <table cellpadding="2" cellspacing="0" class="KT_tngtable">
          <tr>
            <td width="24%" class="KT_th">&nbsp;</td>
            <td width="76%"><input name="id_cont_fk_<?php echo $cnt1; ?>" type="hidden" id="id_cont_fk_<?php echo $cnt1; ?>" value="<?php echo $row_rscodct['id_cont']; ?>" size="7" />
                <?php echo $tNGs->displayFieldHint("id_cont_fk");?> <?php echo $tNGs->displayFieldError("contrato_attached", "id_cont_fk", $cnt1); ?> <input name="att_type_<?php echo $cnt1; ?>" type="hidden" id="att_type_<?php echo $cnt1; ?>" value="<?php echo $row_rscodatt['att_type']; ?>" size="2" />
                <?php echo $tNGs->displayFieldHint("att_type");?> <?php echo $tNGs->displayFieldError("contrato_attached", "att_type", $cnt1); ?><span class="titlemsg2">  Modificar&nbsp;<?php echo $row_rscodatt['att_type_name']; ?></span></td>
          </tr>
          
          <tr>
            <td class="KT_th"><label for="att_file_<?php echo $cnt1; ?>">Seleccionar <?php echo $row_rscodatt['att_type_name']; ?>:</label></td>
            <td><input type="file" name="att_file_<?php echo $cnt1; ?>" id="att_file_<?php echo $cnt1; ?>" size="32" />
                <?php echo $tNGs->displayFieldError("contrato_attached", "att_file", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th">&nbsp;</td>
            <td><input name="sys_user_<?php echo $cnt1; ?>" type="hidden" id="sys_user_<?php echo $cnt1; ?>" value="<?php echo $_SESSION['kt_login_user']; ?>" size="32" maxlength="60" />
                <?php echo $tNGs->displayFieldHint("sys_user");?> <?php echo $tNGs->displayFieldError("contrato_attached", "sys_user", $cnt1); ?> <input type="hidden" name="sys_date_<?php echo $cnt1; ?>" id="sys_date_<?php echo $cnt1; ?>" value="<?php echo $fecha; ?>" size="10" maxlength="22" />
                <?php echo $tNGs->displayFieldHint("sys_date");?> <?php echo $tNGs->displayFieldError("contrato_attached", "sys_date", $cnt1); ?> <input type="hidden" name="sys_time_<?php echo $cnt1; ?>" id="sys_time_<?php echo $cnt1; ?>" value="<?php echo $hora; ?>" size="10" maxlength="22" />
                <?php echo $tNGs->displayFieldHint("sys_time");?> <?php echo $tNGs->displayFieldError("contrato_attached", "sys_time", $cnt1); ?> <input type="hidden" name="sys_stat_<?php echo $cnt1; ?>" id="sys_stat_<?php echo $cnt1; ?>" value="9" size="2" />
                <?php echo $tNGs->displayFieldHint("sys_stat");?> <?php echo $tNGs->displayFieldError("contrato_attached", "sys_stat", $cnt1); ?> </td>
          </tr>
        </table>
        <input type="hidden" name="kt_pk_contrato_attached_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rscontrato_attached['kt_pk_contrato_attached']); ?>" />
        <?php } while ($row_rscontrato_attached = mysql_fetch_assoc($rscontrato_attached)); ?>
      <div class="KT_bottombuttons">
        <div>
          <?php 
      // Show IF Conditional region1
      if (@$_GET['id_att'] == "") {
      ?>
            <input type="submit" name="KT_Insert1" id="KT_Insert1" value="Guardar" />
            <?php 
      // else Conditional region1
      } else { ?>
            <input type="submit" name="KT_Update1" value="Guardar" />
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
mysql_free_result($rscodatt);

mysql_free_result($rscodct);
?>
