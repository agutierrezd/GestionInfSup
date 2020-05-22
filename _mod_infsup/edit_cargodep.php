<?php require_once('../Connections/oConnUsers.php'); ?>
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
$conn_oConnUsers = new KT_connection($oConnUsers, $database_oConnUsers);

// Start trigger
$formValidation = new tNG_FormValidation();
$formValidation->addField("usr_dep", true, "numeric", "", "", "", "");
$formValidation->addField("usr_cargo", true, "numeric", "", "", "", "");
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

mysql_select_db($database_oConnUsers, $oConnUsers);
$query_rsdep = "SELECT * FROM mcit_dependencias ORDER BY dpd_dsdpn_b ASC";
$rsdep = mysql_query($query_rsdep, $oConnUsers) or die(mysql_error());
$row_rsdep = mysql_fetch_assoc($rsdep);
$totalRows_rsdep = mysql_num_rows($rsdep);

mysql_select_db($database_oConnUsers, $oConnUsers);
$query_rscargo = "SELECT * FROM mcit_cargos ORDER BY nomcar ASC";
$rscargo = mysql_query($query_rscargo, $oConnUsers) or die(mysql_error());
$row_rscargo = mysql_fetch_assoc($rscargo);
$totalRows_rscargo = mysql_num_rows($rscargo);

// Make an insert transaction instance
$ins_global_users = new tNG_multipleInsert($conn_oConnUsers);
$tNGs->addTransaction($ins_global_users);
// Register triggers
$ins_global_users->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_global_users->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_global_users->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$ins_global_users->setTable("global_users");
$ins_global_users->addColumn("usr_dep", "NUMERIC_TYPE", "POST", "usr_dep");
$ins_global_users->addColumn("usr_cargo", "NUMERIC_TYPE", "POST", "usr_cargo");
$ins_global_users->setPrimaryKey("idusrglobal", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_global_users = new tNG_multipleUpdate($conn_oConnUsers);
$tNGs->addTransaction($upd_global_users);
// Register triggers
$upd_global_users->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_global_users->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_global_users->registerTrigger("END", "Trigger_Default_Redirect", 99, "okm.php");
// Add columns
$upd_global_users->setTable("global_users");
$upd_global_users->addColumn("usr_dep", "NUMERIC_TYPE", "POST", "usr_dep");
$upd_global_users->addColumn("usr_cargo", "NUMERIC_TYPE", "POST", "usr_cargo");
$upd_global_users->setPrimaryKey("idusrglobal", "NUMERIC_TYPE", "GET", "idusrglobal");

// Make an instance of the transaction object
$del_global_users = new tNG_multipleDelete($conn_oConnUsers);
$tNGs->addTransaction($del_global_users);
// Register triggers
$del_global_users->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_global_users->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$del_global_users->setTable("global_users");
$del_global_users->setPrimaryKey("idusrglobal", "NUMERIC_TYPE", "GET", "idusrglobal");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsglobal_users = $tNGs->getRecordset("global_users");
$row_rsglobal_users = mysql_fetch_assoc($rsglobal_users);
$totalRows_rsglobal_users = mysql_num_rows($rsglobal_users);
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
if (@$_GET['idusrglobal'] == "") {
?>
      <?php echo NXT_getResource("Insert_FH"); ?>
      <?php 
// else Conditional region1
} else { ?>
      <?php echo NXT_getResource("Update_FH"); ?>
      <?php } 
// endif Conditional region1
?>
    Global_users </h1>
  <div class="KT_tngform">
    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
      <?php $cnt1 = 0; ?>
      <?php do { ?>
        <?php $cnt1++; ?>
        <?php 
// Show IF Conditional region1 
if (@$totalRows_rsglobal_users > 1) {
?>
          <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
          <?php } 
// endif Conditional region1
?>
        <table cellpadding="2" cellspacing="0" class="KT_tngtable">
          <tr>
            <td class="KT_th"><label for="usr_dep_<?php echo $cnt1; ?>">DEPENDENCIA:</label></td>
            <td><select name="usr_dep_<?php echo $cnt1; ?>" id="usr_dep_<?php echo $cnt1; ?>">
              <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
              <?php 
do {  
?>
              <option value="<?php echo $row_rsdep['dpd_id']?>"<?php if (!(strcmp($row_rsdep['dpd_id'], $row_rsglobal_users['usr_dep']))) {echo "SELECTED";} ?>><?php echo $row_rsdep['dpd_dsdpn_b']?></option>
              <?php
} while ($row_rsdep = mysql_fetch_assoc($rsdep));
  $rows = mysql_num_rows($rsdep);
  if($rows > 0) {
      mysql_data_seek($rsdep, 0);
	  $row_rsdep = mysql_fetch_assoc($rsdep);
  }
?>
            </select>
                <?php echo $tNGs->displayFieldError("global_users", "usr_dep", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="usr_cargo_<?php echo $cnt1; ?>">CARGO:</label></td>
            <td><select name="usr_cargo_<?php echo $cnt1; ?>" id="usr_cargo_<?php echo $cnt1; ?>">
              <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
              <?php 
do {  
?>
              <option value="<?php echo $row_rscargo['cargo_id']?>"<?php if (!(strcmp($row_rscargo['cargo_id'], $row_rsglobal_users['usr_cargo']))) {echo "SELECTED";} ?>><?php echo $row_rscargo['nomcar']?></option>
              <?php
} while ($row_rscargo = mysql_fetch_assoc($rscargo));
  $rows = mysql_num_rows($rscargo);
  if($rows > 0) {
      mysql_data_seek($rscargo, 0);
	  $row_rscargo = mysql_fetch_assoc($rscargo);
  }
?>
            </select>
                <?php echo $tNGs->displayFieldError("global_users", "usr_cargo", $cnt1); ?> </td>
          </tr>
        </table>
        <input type="hidden" name="kt_pk_global_users_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rsglobal_users['kt_pk_global_users']); ?>" />
        <?php } while ($row_rsglobal_users = mysql_fetch_assoc($rsglobal_users)); ?>
      <div class="KT_bottombuttons">
        <div>
          <?php 
      // Show IF Conditional region1
      if (@$_GET['idusrglobal'] == "") {
      ?>
            <input type="submit" name="KT_Insert1" id="KT_Insert1" value="<?php echo NXT_getResource("Insert_FB"); ?>" />
            <?php 
      // else Conditional region1
      } else { ?>
            <input type="submit" name="KT_Update1" value="<?php echo NXT_getResource("Update_FB"); ?>" />
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
mysql_free_result($rsdep);

mysql_free_result($rscargo);
?>
