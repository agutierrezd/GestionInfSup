<?php require_once('../Connections/oConnAlmacen.php'); ?>
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
$conn_oConnAlmacen = new KT_connection($oConnAlmacen, $database_oConnAlmacen);

// Start trigger
$formValidation = new tNG_FormValidation();
$formValidation->addField("func_doc", true, "text", "", "", "", "");
$formValidation->addField("func_nombres", true, "text", "", "", "", "");
$formValidation->addField("func_email", true, "text", "email", "", "", "");
$formValidation->addField("func_dep", true, "text", "", "", "", "");
$formValidation->addField("func_tipovinc", true, "numeric", "", "", "", "");
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

mysql_select_db($database_oConnAlmacen, $oConnAlmacen);
$query_rsdependencia = "SELECT Id, de_coddep, de_nomdep FROM gedependencias ORDER BY de_nomdep ASC";
$rsdependencia = mysql_query($query_rsdependencia, $oConnAlmacen) or die(mysql_error());
$row_rsdependencia = mysql_fetch_assoc($rsdependencia);
$totalRows_rsdependencia = mysql_num_rows($rsdependencia);

mysql_select_db($database_oConnAlmacen, $oConnAlmacen);
$query_rstipovinc = "SELECT * FROM global_type_vinc ORDER BY vinc_name ASC";
$rstipovinc = mysql_query($query_rstipovinc, $oConnAlmacen) or die(mysql_error());
$row_rstipovinc = mysql_fetch_assoc($rstipovinc);
$totalRows_rstipovinc = mysql_num_rows($rstipovinc);

// Make an insert transaction instance
$ins_gefuncionarios = new tNG_multipleInsert($conn_oConnAlmacen);
$tNGs->addTransaction($ins_gefuncionarios);
// Register triggers
$ins_gefuncionarios->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_gefuncionarios->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_gefuncionarios->registerTrigger("END", "Trigger_Default_Redirect", 99, "a_funcionarios_list.php?b={GET.b}");
// Add columns
$ins_gefuncionarios->setTable("gefuncionarios");
$ins_gefuncionarios->addColumn("func_doc", "STRING_TYPE", "POST", "func_doc");
$ins_gefuncionarios->addColumn("func_nombres", "STRING_TYPE", "POST", "func_nombres");
$ins_gefuncionarios->addColumn("func_email", "STRING_TYPE", "POST", "func_email");
$ins_gefuncionarios->addColumn("func_dep", "STRING_TYPE", "POST", "func_dep");
$ins_gefuncionarios->addColumn("func_tipovinc", "NUMERIC_TYPE", "POST", "func_tipovinc");
$ins_gefuncionarios->setPrimaryKey("func_id", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_gefuncionarios = new tNG_multipleUpdate($conn_oConnAlmacen);
$tNGs->addTransaction($upd_gefuncionarios);
// Register triggers
$upd_gefuncionarios->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_gefuncionarios->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_gefuncionarios->registerTrigger("END", "Trigger_Default_Redirect", 99, "a_funcionarios_list.php?b={GET.b}");
// Add columns
$upd_gefuncionarios->setTable("gefuncionarios");
$upd_gefuncionarios->addColumn("func_doc", "STRING_TYPE", "POST", "func_doc");
$upd_gefuncionarios->addColumn("func_nombres", "STRING_TYPE", "POST", "func_nombres");
$upd_gefuncionarios->addColumn("func_email", "STRING_TYPE", "POST", "func_email");
$upd_gefuncionarios->addColumn("func_dep", "STRING_TYPE", "POST", "func_dep");
$upd_gefuncionarios->addColumn("func_tipovinc", "NUMERIC_TYPE", "POST", "func_tipovinc");
$upd_gefuncionarios->setPrimaryKey("func_id", "NUMERIC_TYPE", "GET", "func_id");

// Make an instance of the transaction object
$del_gefuncionarios = new tNG_multipleDelete($conn_oConnAlmacen);
$tNGs->addTransaction($del_gefuncionarios);
// Register triggers
$del_gefuncionarios->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_gefuncionarios->registerTrigger("END", "Trigger_Default_Redirect", 99, "a_funcionarios_list.php?b={GET.b}");
// Add columns
$del_gefuncionarios->setTable("gefuncionarios");
$del_gefuncionarios->setPrimaryKey("func_id", "NUMERIC_TYPE", "GET", "func_id");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsgefuncionarios = $tNGs->getRecordset("gefuncionarios");
$row_rsgefuncionarios = mysql_fetch_assoc($rsgefuncionarios);
$totalRows_rsgefuncionarios = mysql_num_rows($rsgefuncionarios);
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
if (@$_GET['func_id'] == "") {
?>
      <?php echo NXT_getResource("Insert_FH"); ?>
      <?php 
// else Conditional region1
} else { ?>
      <?php echo NXT_getResource("Update_FH"); ?>
      <?php } 
// endif Conditional region1
?>
    Gefuncionarios </h1>
  <div class="KT_tngform">
    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
      <?php $cnt1 = 0; ?>
      <?php do { ?>
        <?php $cnt1++; ?>
        <?php 
// Show IF Conditional region1 
if (@$totalRows_rsgefuncionarios > 1) {
?>
          <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
          <?php } 
// endif Conditional region1
?>
        <table cellpadding="2" cellspacing="0" class="KT_tngtable">
          <tr>
            <td class="KT_th"><label for="func_doc_<?php echo $cnt1; ?>">DOCUMENTO:</label></td>
            <td><input type="text" name="func_doc_<?php echo $cnt1; ?>" id="func_doc_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsgefuncionarios['func_doc']); ?>" size="25" maxlength="25" />
                <?php echo $tNGs->displayFieldHint("func_doc");?> <?php echo $tNGs->displayFieldError("gefuncionarios", "func_doc", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="func_nombres_<?php echo $cnt1; ?>">NOMBRES:</label></td>
            <td><input type="text" name="func_nombres_<?php echo $cnt1; ?>" id="func_nombres_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsgefuncionarios['func_nombres']); ?>" size="32" maxlength="255" />
                <?php echo $tNGs->displayFieldHint("func_nombres");?> <?php echo $tNGs->displayFieldError("gefuncionarios", "func_nombres", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="func_email_<?php echo $cnt1; ?>">CORREO ELECTRONICO:</label></td>
            <td><input type="text" name="func_email_<?php echo $cnt1; ?>" id="func_email_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsgefuncionarios['func_email']); ?>" size="32" maxlength="150" />
                <?php echo $tNGs->displayFieldHint("func_email");?> <?php echo $tNGs->displayFieldError("gefuncionarios", "func_email", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="func_dep_<?php echo $cnt1; ?>">DEPENDENCIA:</label></td>
            <td><select name="func_dep_<?php echo $cnt1; ?>" id="func_dep_<?php echo $cnt1; ?>">
              <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
              <?php 
do {  
?>
              <option value="<?php echo $row_rsdependencia['de_coddep']?>"<?php if (!(strcmp($row_rsdependencia['de_coddep'], $row_rsgefuncionarios['func_dep']))) {echo "SELECTED";} ?>><?php echo $row_rsdependencia['de_nomdep']?></option>
              <?php
} while ($row_rsdependencia = mysql_fetch_assoc($rsdependencia));
  $rows = mysql_num_rows($rsdependencia);
  if($rows > 0) {
      mysql_data_seek($rsdependencia, 0);
	  $row_rsdependencia = mysql_fetch_assoc($rsdependencia);
  }
?>
            </select>
                <?php echo $tNGs->displayFieldError("gefuncionarios", "func_dep", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="func_tipovinc_<?php echo $cnt1; ?>">TIPO VINCULACION:</label></td>
            <td><select name="func_tipovinc_<?php echo $cnt1; ?>" id="func_tipovinc_<?php echo $cnt1; ?>">
              <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
              <?php 
do {  
?>
              <option value="<?php echo $row_rstipovinc['vinc_id']?>"<?php if (!(strcmp($row_rstipovinc['vinc_id'], $row_rsgefuncionarios['func_tipovinc']))) {echo "SELECTED";} ?>><?php echo $row_rstipovinc['vinc_name']?></option>
              <?php
} while ($row_rstipovinc = mysql_fetch_assoc($rstipovinc));
  $rows = mysql_num_rows($rstipovinc);
  if($rows > 0) {
      mysql_data_seek($rstipovinc, 0);
	  $row_rstipovinc = mysql_fetch_assoc($rstipovinc);
  }
?>
            </select>
                <?php echo $tNGs->displayFieldError("gefuncionarios", "func_tipovinc", $cnt1); ?> </td>
          </tr>
        </table>
        <input type="hidden" name="kt_pk_gefuncionarios_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rsgefuncionarios['kt_pk_gefuncionarios']); ?>" />
        <?php } while ($row_rsgefuncionarios = mysql_fetch_assoc($rsgefuncionarios)); ?>
      <div class="KT_bottombuttons">
        <div>
          <?php 
      // Show IF Conditional region1
      if (@$_GET['func_id'] == "") {
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
mysql_free_result($rsdependencia);

mysql_free_result($rstipovinc);
?>
