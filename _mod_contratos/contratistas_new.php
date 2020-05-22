<?php require_once('../Connections/oConnContratos.php'); ?>
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
$formValidation->addField("contractor_type", true, "text", "", "", "", "");
$formValidation->addField("contractor_doc_id", true, "text", "", "", "", "");
$formValidation->addField("contractor_name", true, "text", "", "", "", "");
$formValidation->addField("sys_user", true, "text", "", "", "", "");
$formValidation->addField("sys_date", true, "date", "", "", "", "");
$formValidation->addField("sys_time", true, "date", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

//start Trigger_CheckUnique trigger
//remove this line if you want to edit the code by hand
function Trigger_CheckUnique(&$tNG) {
  $tblFldObj = new tNG_CheckUnique($tNG);
  $tblFldObj->setTable("contractor_master");
  $tblFldObj->addFieldName("contractor_doc_id");
  $tblFldObj->setErrorMsg("El valor ingresado ya se encuentra registrado!");
  return $tblFldObj->Execute();
}
//end Trigger_CheckUnique trigger

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
$query_Recordset1 = "SELECT contractor_type, contractor_type FROM contractor_type ORDER BY contractor_type";
$Recordset1 = mysql_query($query_Recordset1, $oConnContratos) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_oConnContratos, $oConnContratos);
$query_Recordset2 = "SELECT contractor_type, contractor_type FROM contractor_type ORDER BY contractor_type";
$Recordset2 = mysql_query($query_Recordset2, $oConnContratos) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

// Make an insert transaction instance
$ins_contractor_master = new tNG_multipleInsert($conn_oConnContratos);
$tNGs->addTransaction($ins_contractor_master);
// Register triggers
$ins_contractor_master->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_contractor_master->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_contractor_master->registerTrigger("END", "Trigger_Default_Redirect", 99, "process_concat_names.php");
$ins_contractor_master->registerTrigger("BEFORE", "Trigger_CheckUnique", 30);
// Add columns
$ins_contractor_master->setTable("contractor_master");
$ins_contractor_master->addColumn("contractor_type", "STRING_TYPE", "POST", "contractor_type");
$ins_contractor_master->addColumn("contractor_doc_id", "STRING_TYPE", "POST", "contractor_doc_id");
$ins_contractor_master->addColumn("contractor_doc_id_dv", "NUMERIC_TYPE", "POST", "contractor_doc_id_dv");
$ins_contractor_master->addColumn("contractor_name", "STRING_TYPE", "POST", "contractor_name");
$ins_contractor_master->addColumn("contractor_lname", "STRING_TYPE", "POST", "contractor_lname");
$ins_contractor_master->addColumn("sys_user", "STRING_TYPE", "POST", "sys_user");
$ins_contractor_master->addColumn("sys_date", "DATE_TYPE", "POST", "sys_date");
$ins_contractor_master->addColumn("sys_time", "DATE_TYPE", "POST", "sys_time");
$ins_contractor_master->setPrimaryKey("contractor_id", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_contractor_master = new tNG_multipleUpdate($conn_oConnContratos);
$tNGs->addTransaction($upd_contractor_master);
// Register triggers
$upd_contractor_master->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_contractor_master->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_contractor_master->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$upd_contractor_master->registerTrigger("BEFORE", "Trigger_CheckUnique", 30);
// Add columns
$upd_contractor_master->setTable("contractor_master");
$upd_contractor_master->addColumn("contractor_type", "STRING_TYPE", "POST", "contractor_type");
$upd_contractor_master->addColumn("contractor_doc_id", "STRING_TYPE", "POST", "contractor_doc_id");
$upd_contractor_master->addColumn("contractor_doc_id_dv", "NUMERIC_TYPE", "POST", "contractor_doc_id_dv");
$upd_contractor_master->addColumn("contractor_name", "STRING_TYPE", "POST", "contractor_name");
$upd_contractor_master->addColumn("contractor_lname", "STRING_TYPE", "POST", "contractor_lname");
$upd_contractor_master->addColumn("sys_user", "STRING_TYPE", "POST", "sys_user");
$upd_contractor_master->addColumn("sys_date", "DATE_TYPE", "POST", "sys_date");
$upd_contractor_master->addColumn("sys_time", "DATE_TYPE", "POST", "sys_time");
$upd_contractor_master->setPrimaryKey("contractor_id", "NUMERIC_TYPE", "GET", "contractor_id");

// Make an instance of the transaction object
$del_contractor_master = new tNG_multipleDelete($conn_oConnContratos);
$tNGs->addTransaction($del_contractor_master);
// Register triggers
$del_contractor_master->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_contractor_master->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$del_contractor_master->setTable("contractor_master");
$del_contractor_master->setPrimaryKey("contractor_id", "NUMERIC_TYPE", "GET", "contractor_id");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rscontractor_master = $tNGs->getRecordset("contractor_master");
$row_rscontractor_master = mysql_fetch_assoc($rscontractor_master);
$totalRows_rscontractor_master = mysql_num_rows($rscontractor_master);
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
  duplicate_buttons: true,
  show_as_grid: false,
  merge_down_value: true
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
if (@$_GET['contractor_id'] == "") {
?>
      <?php echo NXT_getResource("Insert_FH"); ?>
      <?php 
// else Conditional region1
} else { ?>
      <?php echo NXT_getResource("Update_FH"); ?>
      <?php } 
// endif Conditional region1
?>
    Contractor_master </h1>
  <div class="KT_tngform">
    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
      <?php $cnt1 = 0; ?>
      <?php do { ?>
        <?php $cnt1++; ?>
        <?php 
// Show IF Conditional region1 
if (@$totalRows_rscontractor_master > 1) {
?>
          <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
          <?php } 
// endif Conditional region1
?>
        <table cellpadding="2" cellspacing="0" class="KT_tngtable">
          <tr>
            <td class="KT_th"><label for="contractor_type_<?php echo $cnt1; ?>">CLASE DE DOCUMENTO:</label></td>
            <td><select name="contractor_type_<?php echo $cnt1; ?>" id="contractor_type_<?php echo $cnt1; ?>">
              <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
              <?php 
do {  
?>
              <option value="<?php echo $row_Recordset1['contractor_type']?>"<?php if (!(strcmp($row_Recordset1['contractor_type'], $row_rscontractor_master['contractor_type']))) {echo "SELECTED";} ?>><?php echo $row_Recordset1['contractor_type']?></option>
              <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
            </select>
                <?php echo $tNGs->displayFieldError("contractor_master", "contractor_type", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="contractor_doc_id_<?php echo $cnt1; ?>">N�MERO DE DOCUMENTO:</label></td>
            <td><input type="text" name="contractor_doc_id_<?php echo $cnt1; ?>" id="contractor_doc_id_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscontractor_master['contractor_doc_id']); ?>" size="20" maxlength="20" />
                <?php echo $tNGs->displayFieldHint("contractor_doc_id");?> <?php echo $tNGs->displayFieldError("contractor_master", "contractor_doc_id", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="contractor_doc_id_dv_<?php echo $cnt1; ?>">DIGITO DE VERIFICACI�N:</label></td>
            <td><input type="text" name="contractor_doc_id_dv_<?php echo $cnt1; ?>" id="contractor_doc_id_dv_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscontractor_master['contractor_doc_id_dv']); ?>" size="2" />
                <?php echo $tNGs->displayFieldHint("contractor_doc_id_dv");?> <?php echo $tNGs->displayFieldError("contractor_master", "contractor_doc_id_dv", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="contractor_name_<?php echo $cnt1; ?>">NOMBRE(S) / RAZON SOCIAL:</label></td>
            <td><input type="text" name="contractor_name_<?php echo $cnt1; ?>" id="contractor_name_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscontractor_master['contractor_name']); ?>" size="32" maxlength="255" />
                <?php echo $tNGs->displayFieldHint("contractor_name");?> <?php echo $tNGs->displayFieldError("contractor_master", "contractor_name", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="contractor_lname_<?php echo $cnt1; ?>">APELLIDOS:</label></td>
            <td><input type="text" name="contractor_lname_<?php echo $cnt1; ?>" id="contractor_lname_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscontractor_master['contractor_lname']); ?>" size="32" maxlength="100" />
                <?php echo $tNGs->displayFieldHint("contractor_lname");?> <?php echo $tNGs->displayFieldError("contractor_master", "contractor_lname", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th">&nbsp;</td>
            <td><input name="sys_user_<?php echo $cnt1; ?>" type="hidden" id="sys_user_<?php echo $cnt1; ?>" value="<?php echo $_SESSION['kt_login_user']; ?>" size="32" maxlength="60" />
                <?php echo $tNGs->displayFieldHint("sys_user");?> <?php echo $tNGs->displayFieldError("contractor_master", "sys_user", $cnt1); ?> <input type="hidden" name="sys_date_<?php echo $cnt1; ?>" id="sys_date_<?php echo $cnt1; ?>" value="<?php echo $fecha; ?>" size="10" maxlength="22" />
                <?php echo $tNGs->displayFieldHint("sys_date");?> <?php echo $tNGs->displayFieldError("contractor_master", "sys_date", $cnt1); ?> <input type="hidden" name="sys_time_<?php echo $cnt1; ?>" id="sys_time_<?php echo $cnt1; ?>" value="<?php echo $hora; ?>" size="10" maxlength="22" />
                <?php echo $tNGs->displayFieldHint("sys_time");?> <?php echo $tNGs->displayFieldError("contractor_master", "sys_time", $cnt1); ?> </td>
          </tr>
        </table>
        <input type="hidden" name="kt_pk_contractor_master_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rscontractor_master['kt_pk_contractor_master']); ?>" />
        <?php } while ($row_rscontractor_master = mysql_fetch_assoc($rscontractor_master)); ?>
      <div class="KT_bottombuttons">
        <div>
          <?php 
      // Show IF Conditional region1
      if (@$_GET['contractor_id'] == "") {
      ?>
            <input type="submit" name="KT_Insert1" id="KT_Insert1" value="<?php echo NXT_getResource("Insert_FB"); ?>" />
            <?php 
      // else Conditional region1
      } else { ?>
            <div class="KT_operations">
              <input type="submit" name="KT_Insert1" value="<?php echo NXT_getResource("Insert as new_FB"); ?>" onclick="nxt_form_insertasnew(this, 'contractor_id')" />
            </div>
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
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
