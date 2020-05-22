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

// Require the MXI classes
require_once ('../includes/mxi/MXI.php');

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
$formValidation->addField("contractor_email", true, "text", "email", "", "", "");
$formValidation->addField("contractor_address", true, "text", "", "", "", "");
$formValidation->addField("contractor_city", true, "text", "", "", "", "");
$formValidation->addField("sys_update", true, "numeric", "", "", "", "");
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
  $tblFldObj->setErrorMsg("El n�mero de documento ya existe!");
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
$query_Recordset2 = "SELECT contractor_type, contractor_type FROM contractor_type ORDER BY contractor_type";
$Recordset2 = mysql_query($query_Recordset2, $oConnContratos) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

mysql_select_db($database_oConnContratos, $oConnContratos);
$query_Recordset1 = "SELECT CodDpto, CodCiudad, NomMunicipio FROM global_mun ORDER BY NomMunicipio ASC";
$Recordset1 = mysql_query($query_Recordset1, $oConnContratos) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rsdpto = "SELECT * FROM global_dptos ORDER BY CodDpto ASC";
$rsdpto = mysql_query($query_rsdpto, $oConnContratos) or die(mysql_error());
$row_rsdpto = mysql_fetch_assoc($rsdpto);
$totalRows_rsdpto = mysql_num_rows($rsdpto);

// Make an insert transaction instance
$ins_contractor_master = new tNG_multipleInsert($conn_oConnContratos);
$tNGs->addTransaction($ins_contractor_master);
// Register triggers
$ins_contractor_master->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_contractor_master->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_contractor_master->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$ins_contractor_master->registerTrigger("BEFORE", "Trigger_CheckUnique", 30);
// Add columns
$ins_contractor_master->setTable("contractor_master");
$ins_contractor_master->addColumn("contractor_type", "STRING_TYPE", "POST", "contractor_type");
$ins_contractor_master->addColumn("contractor_doc_id", "STRING_TYPE", "POST", "contractor_doc_id");
$ins_contractor_master->addColumn("contractor_doc_id_dv", "NUMERIC_TYPE", "POST", "contractor_doc_id_dv");
$ins_contractor_master->addColumn("contractor_name", "STRING_TYPE", "POST", "contractor_name");
$ins_contractor_master->addColumn("contractor_email", "STRING_TYPE", "POST", "contractor_email");
$ins_contractor_master->addColumn("contractor_address", "STRING_TYPE", "POST", "contractor_address");
$ins_contractor_master->addColumn("contractor_phone", "STRING_TYPE", "POST", "contractor_phone");
$ins_contractor_master->addColumn("contractor_mobile", "STRING_TYPE", "POST", "contractor_mobile");
$ins_contractor_master->addColumn("contractor_city", "STRING_TYPE", "POST", "contractor_city");
$ins_contractor_master->addColumn("sys_update", "NUMERIC_TYPE", "POST", "sys_update");
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
$upd_contractor_master->addColumn("contractor_email", "STRING_TYPE", "POST", "contractor_email");
$upd_contractor_master->addColumn("contractor_address", "STRING_TYPE", "POST", "contractor_address");
$upd_contractor_master->addColumn("contractor_phone", "STRING_TYPE", "POST", "contractor_phone");
$upd_contractor_master->addColumn("contractor_mobile", "STRING_TYPE", "POST", "contractor_mobile");
$upd_contractor_master->addColumn("contractor_city", "STRING_TYPE", "POST", "contractor_city");
$upd_contractor_master->addColumn("sys_update", "NUMERIC_TYPE", "POST", "sys_update");
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
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:wdg="http://ns.adobe.com/addt">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:: Contrataci&oacute;n :: MinCIT ::.</title>
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
  show_as_grid: true,
  merge_down_value: true
}
</script>
<script type="text/javascript" src="../includes/common/js/sigslot_core.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="../includes/wdg/classes/JSRecordset.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/DependentDropdown.js"></script>
<?php
//begin JSRecordset
$jsObject_Recordset1 = new WDG_JsRecordset("Recordset1");
echo $jsObject_Recordset1->getOutput();
//end JSRecordset
?>
</head>

<body>
<?php
  mxi_includes_start("../inc_top.php");
  require(basename("../inc_top.php"));
  mxi_includes_end();
?>
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;
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
                  <td class="KT_th"><label for="contractor_type_<?php echo $cnt1; ?>">CLASE DE DOCUMENTO:</label></td>
                  <td><select name="contractor_type_<?php echo $cnt1; ?>" id="contractor_type_<?php echo $cnt1; ?>">
                      <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                      <?php 
do {  
?>
                      <option value="<?php echo $row_Recordset2['contractor_type']?>"<?php if (!(strcmp($row_Recordset2['contractor_type'], $row_rscontractor_master['contractor_type']))) {echo "SELECTED";} ?>><?php echo $row_Recordset2['contractor_type']?></option>
                      <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
                    </select>
                      <?php echo $tNGs->displayFieldError("contractor_master", "contractor_type", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="contractor_doc_id_<?php echo $cnt1; ?>">NUMERO DE DOCUMENTO:</label></td>
                  <td><input type="text" name="contractor_doc_id_<?php echo $cnt1; ?>" id="contractor_doc_id_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscontractor_master['contractor_doc_id']); ?>" size="20" maxlength="20" />
                      <?php echo $tNGs->displayFieldHint("contractor_doc_id");?> <?php echo $tNGs->displayFieldError("contractor_master", "contractor_doc_id", $cnt1); ?> No usar puntos, ni comas</td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="contractor_doc_id_dv_<?php echo $cnt1; ?>">DIGITO DE VERIFICACION:</label></td>
                  <td><input type="text" name="contractor_doc_id_dv_<?php echo $cnt1; ?>" id="contractor_doc_id_dv_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscontractor_master['contractor_doc_id_dv']); ?>" size="2" />
                      <?php echo $tNGs->displayFieldHint("contractor_doc_id_dv");?> <?php echo $tNGs->displayFieldError("contractor_master", "contractor_doc_id_dv", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="contractor_name_<?php echo $cnt1; ?>">NOMBRE / RAZON SOCIAL:</label></td>
                  <td><input type="text" name="contractor_name_<?php echo $cnt1; ?>" id="contractor_name_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscontractor_master['contractor_name']); ?>" size="60" maxlength="255" onkeyup="this.value=this.value.toUpperCase()";/>
                      <?php echo $tNGs->displayFieldHint("contractor_name");?> <?php echo $tNGs->displayFieldError("contractor_master", "contractor_name", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="contractor_email_<?php echo $cnt1; ?>">CORREO ELECTRONICO:</label></td>
                  <td><input type="text" name="contractor_email_<?php echo $cnt1; ?>" id="contractor_email_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscontractor_master['contractor_email']); ?>" size="32" maxlength="100" />
                      <?php echo $tNGs->displayFieldHint("contractor_email");?> <?php echo $tNGs->displayFieldError("contractor_master", "contractor_email", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="contractor_address_<?php echo $cnt1; ?>">DIRECCION PARA CORRESPONDENCIA:</label></td>
                  <td><input type="text" name="contractor_address_<?php echo $cnt1; ?>" id="contractor_address_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscontractor_master['contractor_address']); ?>" size="70" maxlength="200" />
                      <?php echo $tNGs->displayFieldHint("contractor_address");?> <?php echo $tNGs->displayFieldError("contractor_master", "contractor_address", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="contractor_phone_<?php echo $cnt1; ?>">TELEFONO FIJO:</label></td>
                  <td><input type="text" name="contractor_phone_<?php echo $cnt1; ?>" id="contractor_phone_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscontractor_master['contractor_phone']); ?>" size="10" maxlength="10" />
                      <?php echo $tNGs->displayFieldHint("contractor_phone");?> <?php echo $tNGs->displayFieldError("contractor_master", "contractor_phone", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="contractor_mobile_<?php echo $cnt1; ?>">CELULAR:</label></td>
                  <td><input type="text" name="contractor_mobile_<?php echo $cnt1; ?>" id="contractor_mobile_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscontractor_master['contractor_mobile']); ?>" size="10" maxlength="10" />
                      <?php echo $tNGs->displayFieldHint("contractor_mobile");?> <?php echo $tNGs->displayFieldError("contractor_master", "contractor_mobile", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="contractor_city_<?php echo $cnt1; ?>">CIUDAD:</label></td>
                  <td><select name="dpto" id="dpto">
                    <?php
do {  
?>
                    <option value="<?php echo $row_rsdpto['CodDpto']?>"><?php echo $row_rsdpto['NomDpto']?></option>
                    <?php
} while ($row_rsdpto = mysql_fetch_assoc($rsdpto));
  $rows = mysql_num_rows($rsdpto);
  if($rows > 0) {
      mysql_data_seek($rsdpto, 0);
	  $row_rsdpto = mysql_fetch_assoc($rsdpto);
  }
?>
                  </select>
<select name="contractor_city_<?php echo $cnt1; ?>" id="contractor_city_<?php echo $cnt1; ?>" wdg:subtype="DependentDropdown" wdg:type="widget" wdg:recordset="Recordset1" wdg:displayfield="NomMunicipio" wdg:valuefield="CodCiudad" wdg:fkey="CodDpto" wdg:triggerobject="dpto" wdg:selected="<?php echo $row_rscontractor_master['contractor_city'] ?>">
  <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                    </select>
                      <?php echo $tNGs->displayFieldError("contractor_master", "contractor_city", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th">&nbsp;</td>
                  <td><input type="hidden" name="sys_update_<?php echo $cnt1; ?>" id="sys_update_<?php echo $cnt1; ?>" value="1" size="2" />
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
      if (@$_GET['contractor_id'] == "") {
      ?>
                  <input type="submit" name="KT_Insert1" id="KT_Insert1" value="<?php echo NXT_getResource("Insert_FB"); ?>" />
                  <?php 
      // else Conditional region1
      } else { ?>
                  <div class="KT_operations">
                    <input type="submit" name="KT_Insert1" value="Duplicar" onclick="nxt_form_insertasnew(this, 'contractor_id')" />
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
    <p>&nbsp;</p></td>
  </tr>
</table>
<p>&nbsp;</p>
<?php
  mxi_includes_start("../inc_foot.php");
  require(basename("../inc_foot.php"));
  mxi_includes_end();
?>
</body>
</html>
<?php
mysql_free_result($Recordset2);

mysql_free_result($Recordset1);

mysql_free_result($rsdpto);
?>
