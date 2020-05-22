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
$formValidation->addField("ectipoestruc", true, "text", "", "", "", "");
$formValidation->addField("eccuenta", true, "text", "", "", "", "");
$formValidation->addField("ec_codelem", true, "numeric", "", "", "", "");
$formValidation->addField("ec_nomelemento", true, "text", "", "", "", "");
$formValidation->addField("ecunidad", true, "numeric", "", "", "", "");
$formValidation->addField("ec_codelemrel", true, "numeric", "", "", "", "");
$formValidation->addField("ec_localizacion", true, "text", "", "", "", "");
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
$query_rsloc = "SELECT * FROM inv_almacen WHERE ascodalmacen_estado = 1";
$rsloc = mysql_query($query_rsloc, $oConnAlmacen) or die(mysql_error());
$row_rsloc = mysql_fetch_assoc($rsloc);
$totalRows_rsloc = mysql_num_rows($rsloc);

mysql_select_db($database_oConnAlmacen, $oConnAlmacen);
$query_rsunidades = "SELECT * FROM geunidmedida ORDER BY um_nomunimed ASC";
$rsunidades = mysql_query($query_rsunidades, $oConnAlmacen) or die(mysql_error());
$row_rsunidades = mysql_fetch_assoc($rsunidades);
$totalRows_rsunidades = mysql_num_rows($rsunidades);

$colname_rsinfocuentas = "-1";
if (isset($_GET['eccuenta'])) {
  $colname_rsinfocuentas = $_GET['eccuenta'];
}
mysql_select_db($database_oConnAlmacen, $oConnAlmacen);
$query_rsinfocuentas = sprintf("SELECT * FROM alcuentasalma WHERE ca_codcuenta = %s", GetSQLValueString($colname_rsinfocuentas, "int"));
$rsinfocuentas = mysql_query($query_rsinfocuentas, $oConnAlmacen) or die(mysql_error());
$row_rsinfocuentas = mysql_fetch_assoc($rsinfocuentas);
$totalRows_rsinfocuentas = mysql_num_rows($rsinfocuentas);

$colname_rscuentaelementosc = "-1";
if (isset($_GET['eccuenta'])) {
  $colname_rscuentaelementosc = $_GET['eccuenta'];
}
mysql_select_db($database_oConnAlmacen, $oConnAlmacen);
$query_rscuentaelementosc = sprintf("SELECT * FROM q_cuenta_elementosc WHERE eccuenta = %s", GetSQLValueString($colname_rscuentaelementosc, "text"));
$rscuentaelementosc = mysql_query($query_rscuentaelementosc, $oConnAlmacen) or die(mysql_error());
$row_rscuentaelementosc = mysql_fetch_assoc($rscuentaelementosc);
$totalRows_rscuentaelementosc = mysql_num_rows($rscuentaelementosc);

// Make an insert transaction instance
$ins_alelemconsumo = new tNG_multipleInsert($conn_oConnAlmacen);
$tNGs->addTransaction($ins_alelemconsumo);
// Register triggers
$ins_alelemconsumo->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_alelemconsumo->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_alelemconsumo->registerTrigger("END", "Trigger_Default_Redirect", 99, "a_elementos_list_consumo.php?nomelement={GET.nomelement}");
// Add columns
$ins_alelemconsumo->setTable("alelemconsumo");
$ins_alelemconsumo->addColumn("ectipoestruc", "STRING_TYPE", "POST", "ectipoestruc");
$ins_alelemconsumo->addColumn("eccuenta", "STRING_TYPE", "POST", "eccuenta");
$ins_alelemconsumo->addColumn("ec_codelem", "NUMERIC_TYPE", "POST", "ec_codelem");
$ins_alelemconsumo->addColumn("ec_nomelemento", "STRING_TYPE", "POST", "ec_nomelemento");
$ins_alelemconsumo->addColumn("ecunidad", "NUMERIC_TYPE", "POST", "ecunidad");
$ins_alelemconsumo->addColumn("ec_codelemrel", "NUMERIC_TYPE", "POST", "ec_codelemrel");
$ins_alelemconsumo->addColumn("ec_localizacion", "STRING_TYPE", "POST", "ec_localizacion");
$ins_alelemconsumo->setPrimaryKey("alelemenconsumo_id", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_alelemconsumo = new tNG_multipleUpdate($conn_oConnAlmacen);
$tNGs->addTransaction($upd_alelemconsumo);
// Register triggers
$upd_alelemconsumo->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_alelemconsumo->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_alelemconsumo->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$upd_alelemconsumo->setTable("alelemconsumo");
$upd_alelemconsumo->addColumn("ectipoestruc", "STRING_TYPE", "POST", "ectipoestruc");
$upd_alelemconsumo->addColumn("eccuenta", "STRING_TYPE", "POST", "eccuenta");
$upd_alelemconsumo->addColumn("ec_codelem", "NUMERIC_TYPE", "POST", "ec_codelem");
$upd_alelemconsumo->addColumn("ec_nomelemento", "STRING_TYPE", "POST", "ec_nomelemento");
$upd_alelemconsumo->addColumn("ecunidad", "NUMERIC_TYPE", "POST", "ecunidad");
$upd_alelemconsumo->addColumn("ec_codelemrel", "NUMERIC_TYPE", "POST", "ec_codelemrel");
$upd_alelemconsumo->addColumn("ec_localizacion", "STRING_TYPE", "POST", "ec_localizacion");
$upd_alelemconsumo->setPrimaryKey("alelemenconsumo_id", "NUMERIC_TYPE", "GET", "alelemenconsumo_id");

// Make an instance of the transaction object
$del_alelemconsumo = new tNG_multipleDelete($conn_oConnAlmacen);
$tNGs->addTransaction($del_alelemconsumo);
// Register triggers
$del_alelemconsumo->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_alelemconsumo->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$del_alelemconsumo->setTable("alelemconsumo");
$del_alelemconsumo->setPrimaryKey("alelemenconsumo_id", "NUMERIC_TYPE", "GET", "alelemenconsumo_id");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsalelemconsumo = $tNGs->getRecordset("alelemconsumo");
$row_rsalelemconsumo = mysql_fetch_assoc($rsalelemconsumo);
$totalRows_rsalelemconsumo = mysql_num_rows($rsalelemconsumo);
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
if (@$_GET['alelemenconsumo_id'] == "") {
?>
      <?php echo NXT_getResource("Insert_FH"); ?>
      <?php 
// else Conditional region1
} else { ?>
      <?php echo NXT_getResource("Update_FH"); ?>
      <?php } 
// endif Conditional region1
?>
    Alelemconsumo </h1>
  <div class="KT_tngform">
    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
      <?php $cnt1 = 0; ?>
      <?php do { ?>
        <?php $cnt1++; ?>
        <?php 
// Show IF Conditional region1 
if (@$totalRows_rsalelemconsumo > 1) {
?>
          <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
          <?php } 
// endif Conditional region1
?>
        <table cellpadding="2" cellspacing="0" class="KT_tngtable">
          <tr>
            <td width="17%" class="KT_th">&nbsp;</td>
            <td width="83%"><input name="ec_codelemrel_<?php echo $cnt1; ?>" type="hidden" id="ec_codelemrel_<?php echo $cnt1; ?>" value="9" />
              <?php echo $tNGs->displayFieldHint("ec_codelemrel");?> <?php echo $tNGs->displayFieldError("alelemconsumo", "ec_codelemrel", $cnt1); ?>
<input name="ectipoestruc_<?php echo $cnt1; ?>" type="hidden" id="ectipoestruc_<?php echo $cnt1; ?>" value="V" />
                <?php echo $tNGs->displayFieldHint("ectipoestruc");?> <?php echo $tNGs->displayFieldError("alelemconsumo", "ectipoestruc", $cnt1); ?> <span class="titlemsg2"><?php echo $row_rsinfocuentas['ca_nomcuenta']; ?></span></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="eccuenta_<?php echo $cnt1; ?>">CUENTA:</label></td>
            <td><input name="eccuenta_<?php echo $cnt1; ?>" type="text" id="eccuenta_<?php echo $cnt1; ?>" value="<?php echo $_GET['eccuenta']; ?>" size="32" maxlength="40" readonly="true" />
                <?php echo $tNGs->displayFieldHint("eccuenta");?> <?php echo $tNGs->displayFieldError("alelemconsumo", "eccuenta", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="ec_codelem_<?php echo $cnt1; ?>">CODIGO ELEMENTO:</label></td>
            <td><input name="ec_codelem_<?php echo $cnt1; ?>" type="text" id="ec_codelem_<?php echo $cnt1; ?>" value="<?php echo $row_rscuentaelementosc['ULTIMOC'] + 1; ?>" size="7" />
                <?php echo $tNGs->displayFieldHint("ec_codelem");?> <?php echo $tNGs->displayFieldError("alelemconsumo", "ec_codelem", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="ec_nomelemento_<?php echo $cnt1; ?>">NOMBRE DEL ELEMENTO:</label></td>
            <td><input type="text" name="ec_nomelemento_<?php echo $cnt1; ?>" id="ec_nomelemento_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsalelemconsumo['ec_nomelemento']); ?>" size="40" maxlength="255" />
                <?php echo $tNGs->displayFieldHint("ec_nomelemento");?> <?php echo $tNGs->displayFieldError("alelemconsumo", "ec_nomelemento", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="ecunidad_<?php echo $cnt1; ?>">PRESENTACI&Oacute;N:</label></td>
            <td><select name="ecunidad_<?php echo $cnt1; ?>" id="ecunidad_<?php echo $cnt1; ?>">
              <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
              <?php 
do {  
?>
              <option value="<?php echo $row_rsunidades['um_codunimed']?>"<?php if (!(strcmp($row_rsunidades['um_codunimed'], $row_rsalelemconsumo['ecunidad']))) {echo "SELECTED";} ?>><?php echo $row_rsunidades['um_nomunimed']?></option>
              <?php
} while ($row_rsunidades = mysql_fetch_assoc($rsunidades));
  $rows = mysql_num_rows($rsunidades);
  if($rows > 0) {
      mysql_data_seek($rsunidades, 0);
	  $row_rsunidades = mysql_fetch_assoc($rsunidades);
  }
?>
            </select>
                <?php echo $tNGs->displayFieldError("alelemconsumo", "ecunidad", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="ec_localizacion_<?php echo $cnt1; ?>">LOCALIZACI&Oacute;N:</label></td>
            <td><select name="ec_localizacion_<?php echo $cnt1; ?>" id="ec_localizacion_<?php echo $cnt1; ?>">
              <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
              <?php 
do {  
?>
              <option value="<?php echo $row_rsloc['ascodalmacen_locale']?>"<?php if (!(strcmp($row_rsloc['ascodalmacen_locale'], $row_rsalelemconsumo['ec_localizacion']))) {echo "SELECTED";} ?>><?php echo $row_rsloc['ascodalmacen_nombre']?></option>
              <?php
} while ($row_rsloc = mysql_fetch_assoc($rsloc));
  $rows = mysql_num_rows($rsloc);
  if($rows > 0) {
      mysql_data_seek($rsloc, 0);
	  $row_rsloc = mysql_fetch_assoc($rsloc);
  }
?>
            </select>
                <?php echo $tNGs->displayFieldError("alelemconsumo", "ec_localizacion", $cnt1); ?> </td>
          </tr>
        </table>
        <input type="hidden" name="kt_pk_alelemconsumo_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rsalelemconsumo['kt_pk_alelemconsumo']); ?>" />
        <?php } while ($row_rsalelemconsumo = mysql_fetch_assoc($rsalelemconsumo)); ?>
      <div class="KT_bottombuttons">
        <div>
          <?php 
      // Show IF Conditional region1
      if (@$_GET['alelemenconsumo_id'] == "") {
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
mysql_free_result($rsloc);

mysql_free_result($rsunidades);

mysql_free_result($rsinfocuentas);

mysql_free_result($rscuentaelementosc);
?>
