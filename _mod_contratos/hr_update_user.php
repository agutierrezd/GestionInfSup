<?php require_once('../Connections/oConnContratos.php'); ?>
<?php
//MX Widgets3 include
require_once('../includes/wdg/WDG.php');
?>
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
$formValidation->addField("contractor_email", true, "text", "", "", "", "");
$formValidation->addField("contractor_city", true, "text", "", "", "", "");
$formValidation->addField("bank_name", true, "numeric", "", "", "", "");
$formValidation->addField("bank_cta_type", true, "numeric", "", "", "", "");
$formValidation->addField("bank_cta_number", true, "text", "", "", "", "");
$formValidation->addField("sys_update", true, "numeric", "", "", "", "");
$formValidation->addField("sys_user", true, "text", "", "", "", "");
$formValidation->addField("sys_date", true, "date", "", "", "", "");
$formValidation->addField("sys_time", true, "date", "", "", "", "");
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

mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rsciudades = "SELECT * FROM global_mun";
$rsciudades = mysql_query($query_rsciudades, $oConnContratos) or die(mysql_error());
$row_rsciudades = mysql_fetch_assoc($rsciudades);
$totalRows_rsciudades = mysql_num_rows($rsciudades);

mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rsbancos = "SELECT * FROM tipo_banco";
$rsbancos = mysql_query($query_rsbancos, $oConnContratos) or die(mysql_error());
$row_rsbancos = mysql_fetch_assoc($rsbancos);
$totalRows_rsbancos = mysql_num_rows($rsbancos);

mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rstipocuenta = "SELECT * FROM tipo_cta_banco";
$rstipocuenta = mysql_query($query_rstipocuenta, $oConnContratos) or die(mysql_error());
$row_rstipocuenta = mysql_fetch_assoc($rstipocuenta);
$totalRows_rstipocuenta = mysql_num_rows($rstipocuenta);

mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rsdptos = "SELECT * FROM global_dptos";
$rsdptos = mysql_query($query_rsdptos, $oConnContratos) or die(mysql_error());
$row_rsdptos = mysql_fetch_assoc($rsdptos);
$totalRows_rsdptos = mysql_num_rows($rsdptos);

// Make an insert transaction instance
$ins_contractor_master = new tNG_multipleInsert($conn_oConnContratos);
$tNGs->addTransaction($ins_contractor_master);
// Register triggers
$ins_contractor_master->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_contractor_master->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_contractor_master->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$ins_contractor_master->setTable("contractor_master");
$ins_contractor_master->addColumn("contractor_name", "STRING_TYPE", "VALUE", "");
$ins_contractor_master->addColumn("contractor_email", "STRING_TYPE", "POST", "contractor_email");
$ins_contractor_master->addColumn("contractor_address", "STRING_TYPE", "POST", "contractor_address");
$ins_contractor_master->addColumn("contractor_phone", "STRING_TYPE", "POST", "contractor_phone");
$ins_contractor_master->addColumn("contractor_mobile", "STRING_TYPE", "POST", "contractor_mobile");
$ins_contractor_master->addColumn("contractor_city", "STRING_TYPE", "POST", "contractor_city");
$ins_contractor_master->addColumn("bank_name", "NUMERIC_TYPE", "POST", "bank_name");
$ins_contractor_master->addColumn("bank_cta_type", "NUMERIC_TYPE", "POST", "bank_cta_type");
$ins_contractor_master->addColumn("bank_cta_number", "STRING_TYPE", "POST", "bank_cta_number");
$ins_contractor_master->addColumn("sys_update", "NUMERIC_TYPE", "POST", "sys_update");
$ins_contractor_master->addColumn("sys_user", "STRING_TYPE", "POST", "sys_user");
$ins_contractor_master->addColumn("sys_date", "DATE_TYPE", "POST", "sys_date");
$ins_contractor_master->addColumn("sys_time", "DATE_TYPE", "POST", "sys_time");
$ins_contractor_master->setPrimaryKey("contractor_doc_id", "STRING_TYPE");

// Make an update transaction instance
$upd_contractor_master = new tNG_multipleUpdate($conn_oConnContratos);
$tNGs->addTransaction($upd_contractor_master);
// Register triggers
$upd_contractor_master->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_contractor_master->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_contractor_master->registerTrigger("END", "Trigger_Default_Redirect", 99, "ok.php");
// Add columns
$upd_contractor_master->setTable("contractor_master");
$upd_contractor_master->addColumn("contractor_name", "STRING_TYPE", "CURRVAL", "");
$upd_contractor_master->addColumn("contractor_email", "STRING_TYPE", "POST", "contractor_email");
$upd_contractor_master->addColumn("contractor_address", "STRING_TYPE", "POST", "contractor_address");
$upd_contractor_master->addColumn("contractor_phone", "STRING_TYPE", "POST", "contractor_phone");
$upd_contractor_master->addColumn("contractor_mobile", "STRING_TYPE", "POST", "contractor_mobile");
$upd_contractor_master->addColumn("contractor_city", "STRING_TYPE", "POST", "contractor_city");
$upd_contractor_master->addColumn("bank_name", "NUMERIC_TYPE", "POST", "bank_name");
$upd_contractor_master->addColumn("bank_cta_type", "NUMERIC_TYPE", "POST", "bank_cta_type");
$upd_contractor_master->addColumn("bank_cta_number", "STRING_TYPE", "POST", "bank_cta_number");
$upd_contractor_master->addColumn("sys_update", "NUMERIC_TYPE", "POST", "sys_update");
$upd_contractor_master->addColumn("sys_user", "STRING_TYPE", "POST", "sys_user");
$upd_contractor_master->addColumn("sys_date", "DATE_TYPE", "POST", "sys_date");
$upd_contractor_master->addColumn("sys_time", "DATE_TYPE", "POST", "sys_time");
$upd_contractor_master->setPrimaryKey("contractor_doc_id", "STRING_TYPE", "GET", "contractor_doc_id");

// Make an instance of the transaction object
$del_contractor_master = new tNG_multipleDelete($conn_oConnContratos);
$tNGs->addTransaction($del_contractor_master);
// Register triggers
$del_contractor_master->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_contractor_master->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$del_contractor_master->setTable("contractor_master");
$del_contractor_master->setPrimaryKey("contractor_doc_id", "STRING_TYPE", "GET", "contractor_doc_id");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rscontractor_master = $tNGs->getRecordset("contractor_master");
$row_rscontractor_master = mysql_fetch_assoc($rscontractor_master);
$totalRows_rscontractor_master = mysql_num_rows($rscontractor_master);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:wdg="http://ns.adobe.com/addt">
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
  merge_down_value: false
}
</script>
<script type="text/javascript" src="../includes/common/js/sigslot_core.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="../includes/wdg/classes/JSRecordset.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/DependentDropdown.js"></script>
<?php
//begin JSRecordset
$jsObject_rsciudades = new WDG_JsRecordset("rsciudades");
echo $jsObject_rsciudades->getOutput();
//end JSRecordset
?>
</head>

<body>
<?php
	echo $tNGs->getErrorMsg();
?>
<div class="KT_tng">
  <h1>
    <?php 
// Show IF Conditional region1 
if (@$_GET['contractor_doc_id'] == "") {
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
if (@$totalRows_rscontractor_master > 1) {
?>
          <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
          <?php } 
// endif Conditional region1
?>
        <table cellpadding="2" cellspacing="0" class="KT_tngtable">
          <tr>
            <td class="KT_th">Nombres / Raz&oacute;n social:</td>
            <td><?php echo KT_escapeAttribute($row_rscontractor_master['contractor_name']); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="contractor_email_<?php echo $cnt1; ?>">Correo electr&oacute;nico para notificaciones:</label></td>
            <td><input type="text" name="contractor_email_<?php echo $cnt1; ?>" id="contractor_email_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscontractor_master['contractor_email']); ?>" size="32" maxlength="100" />
                <?php echo $tNGs->displayFieldHint("contractor_email");?> <?php echo $tNGs->displayFieldError("contractor_master", "contractor_email", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="contractor_address_<?php echo $cnt1; ?>">Direcci&oacute;n para env&iacute;o de correspondencia:</label></td>
            <td><input type="text" name="contractor_address_<?php echo $cnt1; ?>" id="contractor_address_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscontractor_master['contractor_address']); ?>" size="32" maxlength="200" />
                <?php echo $tNGs->displayFieldHint("contractor_address");?> <?php echo $tNGs->displayFieldError("contractor_master", "contractor_address", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="contractor_phone_<?php echo $cnt1; ?>">Tel&eacute;fono de contacto:</label></td>
            <td><input type="text" name="contractor_phone_<?php echo $cnt1; ?>" id="contractor_phone_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscontractor_master['contractor_phone']); ?>" size="10" maxlength="10" />
                <?php echo $tNGs->displayFieldHint("contractor_phone");?> <?php echo $tNGs->displayFieldError("contractor_master", "contractor_phone", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="contractor_mobile_<?php echo $cnt1; ?>">Celular de contacto:</label></td>
            <td><input type="text" name="contractor_mobile_<?php echo $cnt1; ?>" id="contractor_mobile_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscontractor_master['contractor_mobile']); ?>" size="10" maxlength="10" />
                <?php echo $tNGs->displayFieldHint("contractor_mobile");?> <?php echo $tNGs->displayFieldError("contractor_master", "contractor_mobile", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="contractor_city">Ciudad:</label></td>
            <td><select name="dpto" id="dpto">
              <?php
do {  
?>
              <option value="<?php echo $row_rsdptos['CodDpto']?>"><?php echo $row_rsdptos['NomDpto']?></option>
              <?php
} while ($row_rsdptos = mysql_fetch_assoc($rsdptos));
  $rows = mysql_num_rows($rsdptos);
  if($rows > 0) {
      mysql_data_seek($rsdptos, 0);
	  $row_rsdptos = mysql_fetch_assoc($rsdptos);
  }
?>
            </select>
<select name="contractor_city" id="contractor_city" wdg:subtype="DependentDropdown" wdg:type="widget" wdg:recordset="rsciudades" wdg:displayfield="NomMunicipio" wdg:valuefield="CodCiudad" wdg:fkey="CodDpto" wdg:triggerobject="dpto" wdg:selected="<?php echo $row_rscontractor_master['contractor_city'] ?>">
  <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
            </select>
                <?php echo $tNGs->displayFieldError("contractor_master", "contractor_city", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="bank_name_<?php echo $cnt1; ?>">Banco donde tiene la cuenta:</label></td>
            <td><select name="bank_name_<?php echo $cnt1; ?>" id="bank_name_<?php echo $cnt1; ?>">
              <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
              <?php 
do {  
?>
              <option value="<?php echo $row_rsbancos['codigo']?>"<?php if (!(strcmp($row_rsbancos['codigo'], $row_rscontractor_master['bank_name']))) {echo "SELECTED";} ?>><?php echo $row_rsbancos['nom_banco']?></option>
              <?php
} while ($row_rsbancos = mysql_fetch_assoc($rsbancos));
  $rows = mysql_num_rows($rsbancos);
  if($rows > 0) {
      mysql_data_seek($rsbancos, 0);
	  $row_rsbancos = mysql_fetch_assoc($rsbancos);
  }
?>
            </select>
                <?php echo $tNGs->displayFieldError("contractor_master", "bank_name", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="bank_cta_type_<?php echo $cnt1; ?>">Tipo de cuenta:</label></td>
            <td><select name="bank_cta_type_<?php echo $cnt1; ?>" id="bank_cta_type_<?php echo $cnt1; ?>">
              <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
              <?php 
do {  
?>
              <option value="<?php echo $row_rstipocuenta['cta_numero']?>"<?php if (!(strcmp($row_rstipocuenta['cta_numero'], $row_rscontractor_master['bank_cta_type']))) {echo "SELECTED";} ?>><?php echo $row_rstipocuenta['des_cuenta']?></option>
              <?php
} while ($row_rstipocuenta = mysql_fetch_assoc($rstipocuenta));
  $rows = mysql_num_rows($rstipocuenta);
  if($rows > 0) {
      mysql_data_seek($rstipocuenta, 0);
	  $row_rstipocuenta = mysql_fetch_assoc($rstipocuenta);
  }
?>
            </select>
                <?php echo $tNGs->displayFieldError("contractor_master", "bank_cta_type", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="bank_cta_number_<?php echo $cnt1; ?>">N&uacute;mero de cuenta:</label></td>
            <td><input type="text" name="bank_cta_number_<?php echo $cnt1; ?>" id="bank_cta_number_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscontractor_master['bank_cta_number']); ?>" size="32" maxlength="100" />
                <?php echo $tNGs->displayFieldHint("bank_cta_number");?> <?php echo $tNGs->displayFieldError("contractor_master", "bank_cta_number", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th">&nbsp;</td>
            <td><input name="sys_update_<?php echo $cnt1; ?>" type="hidden" id="sys_update_<?php echo $cnt1; ?>" value="3" size="2" />
                <?php echo $tNGs->displayFieldHint("sys_update");?> <?php echo $tNGs->displayFieldError("contractor_master", "sys_update", $cnt1); ?> <input name="sys_user_<?php echo $cnt1; ?>" type="hidden" id="sys_user_<?php echo $cnt1; ?>" value="<?php echo $_SESSION['kt_login_user']; ?>" size="32" maxlength="60" />
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
      if (@$_GET['contractor_doc_id'] == "") {
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
mysql_free_result($rsciudades);

mysql_free_result($rsbancos);

mysql_free_result($rstipocuenta);

mysql_free_result($rsdptos);
?>
