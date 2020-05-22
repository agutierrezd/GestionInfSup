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
$formValidation->addField("edtipoestruc", true, "text", "", "", "", "");
$formValidation->addField("edcuenta", true, "text", "", "", "", "");
$formValidation->addField("ed_codelem", true, "numeric", "", "", "", "");
$formValidation->addField("ed_nomelemento", true, "text", "", "", "", "");
$formValidation->addField("edunidad", true, "text", "", "", "", "");
$formValidation->addField("edmarca", true, "numeric", "", "", "", "");
$formValidation->addField("ed_modeloelem", true, "text", "", "", "", "");
$formValidation->addField("edproveedor", true, "text", "", "", "", "");
$formValidation->addField("ed_valunit", true, "double", "", "", "", "");
$formValidation->addField("ed_codelemrel", true, "numeric", "", "", "", "");
$formValidation->addField("ed_localizacion", true, "text", "", "", "", "");
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
$query_rscuentas = "SELECT * FROM alcuentasalma ORDER BY ca_nomcuenta ASC";
$rscuentas = mysql_query($query_rscuentas, $oConnAlmacen) or die(mysql_error());
$row_rscuentas = mysql_fetch_assoc($rscuentas);
$totalRows_rscuentas = mysql_num_rows($rscuentas);

mysql_select_db($database_oConnAlmacen, $oConnAlmacen);
$query_rspresenta = "SELECT * FROM geunidmedida ORDER BY um_nomunimed ASC";
$rspresenta = mysql_query($query_rspresenta, $oConnAlmacen) or die(mysql_error());
$row_rspresenta = mysql_fetch_assoc($rspresenta);
$totalRows_rspresenta = mysql_num_rows($rspresenta);

mysql_select_db($database_oConnAlmacen, $oConnAlmacen);
$query_rsmarcas = "SELECT * FROM almarcas ORDER BY ma_nommarca ASC";
$rsmarcas = mysql_query($query_rsmarcas, $oConnAlmacen) or die(mysql_error());
$row_rsmarcas = mysql_fetch_assoc($rsmarcas);
$totalRows_rsmarcas = mysql_num_rows($rsmarcas);

mysql_select_db($database_oConnAlmacen, $oConnAlmacen);
$query_rslocale = "SELECT * FROM inv_almacen WHERE ascodalmacen_estado = 1";
$rslocale = mysql_query($query_rslocale, $oConnAlmacen) or die(mysql_error());
$row_rslocale = mysql_fetch_assoc($rslocale);
$totalRows_rslocale = mysql_num_rows($rslocale);

$colname_rscuentaelementos = "-1";
if (isset($_GET['edcuenta'])) {
  $colname_rscuentaelementos = $_GET['edcuenta'];
}
mysql_select_db($database_oConnAlmacen, $oConnAlmacen);
$query_rscuentaelementos = sprintf("SELECT * FROM q_cuenta_elementosd WHERE edcuenta = %s", GetSQLValueString($colname_rscuentaelementos, "text"));
$rscuentaelementos = mysql_query($query_rscuentaelementos, $oConnAlmacen) or die(mysql_error());
$row_rscuentaelementos = mysql_fetch_assoc($rscuentaelementos);
$totalRows_rscuentaelementos = mysql_num_rows($rscuentaelementos);

// Make an insert transaction instance
$ins_alelemdevolutivo = new tNG_multipleInsert($conn_oConnAlmacen);
$tNGs->addTransaction($ins_alelemdevolutivo);
// Register triggers
$ins_alelemdevolutivo->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_alelemdevolutivo->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_alelemdevolutivo->registerTrigger("END", "Trigger_Default_Redirect", 99, "a_elementos_list.php?nomelement={GET.nomelement}");
// Add columns
$ins_alelemdevolutivo->setTable("alelemdevolutivo");
$ins_alelemdevolutivo->addColumn("edtipoestruc", "STRING_TYPE", "POST", "edtipoestruc");
$ins_alelemdevolutivo->addColumn("edcuenta", "STRING_TYPE", "POST", "edcuenta");
$ins_alelemdevolutivo->addColumn("ed_codelem", "NUMERIC_TYPE", "POST", "ed_codelem");
$ins_alelemdevolutivo->addColumn("ed_nomelemento", "STRING_TYPE", "POST", "ed_nomelemento");
$ins_alelemdevolutivo->addColumn("edunidad", "STRING_TYPE", "POST", "edunidad");
$ins_alelemdevolutivo->addColumn("edmarca", "NUMERIC_TYPE", "POST", "edmarca");
$ins_alelemdevolutivo->addColumn("ed_modeloelem", "STRING_TYPE", "POST", "ed_modeloelem");
$ins_alelemdevolutivo->addColumn("edproveedor", "STRING_TYPE", "POST", "edproveedor");
$ins_alelemdevolutivo->addColumn("ed_valunit", "DOUBLE_TYPE", "POST", "ed_valunit");
$ins_alelemdevolutivo->addColumn("ed_codelemrel", "NUMERIC_TYPE", "POST", "ed_codelemrel");
$ins_alelemdevolutivo->addColumn("ed_localizacion", "STRING_TYPE", "POST", "ed_localizacion");
$ins_alelemdevolutivo->setPrimaryKey("alelemdevolutivo_id", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_alelemdevolutivo = new tNG_multipleUpdate($conn_oConnAlmacen);
$tNGs->addTransaction($upd_alelemdevolutivo);
// Register triggers
$upd_alelemdevolutivo->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_alelemdevolutivo->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_alelemdevolutivo->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$upd_alelemdevolutivo->setTable("alelemdevolutivo");
$upd_alelemdevolutivo->addColumn("edtipoestruc", "STRING_TYPE", "POST", "edtipoestruc");
$upd_alelemdevolutivo->addColumn("edcuenta", "STRING_TYPE", "POST", "edcuenta");
$upd_alelemdevolutivo->addColumn("ed_codelem", "NUMERIC_TYPE", "POST", "ed_codelem");
$upd_alelemdevolutivo->addColumn("ed_nomelemento", "STRING_TYPE", "POST", "ed_nomelemento");
$upd_alelemdevolutivo->addColumn("edunidad", "STRING_TYPE", "POST", "edunidad");
$upd_alelemdevolutivo->addColumn("edmarca", "NUMERIC_TYPE", "POST", "edmarca");
$upd_alelemdevolutivo->addColumn("ed_modeloelem", "STRING_TYPE", "POST", "ed_modeloelem");
$upd_alelemdevolutivo->addColumn("edproveedor", "STRING_TYPE", "POST", "edproveedor");
$upd_alelemdevolutivo->addColumn("ed_valunit", "DOUBLE_TYPE", "POST", "ed_valunit");
$upd_alelemdevolutivo->addColumn("ed_codelemrel", "NUMERIC_TYPE", "POST", "ed_codelemrel");
$upd_alelemdevolutivo->addColumn("ed_localizacion", "STRING_TYPE", "POST", "ed_localizacion");
$upd_alelemdevolutivo->setPrimaryKey("alelemdevolutivo_id", "NUMERIC_TYPE", "GET", "alelemdevolutivo_id");

// Make an instance of the transaction object
$del_alelemdevolutivo = new tNG_multipleDelete($conn_oConnAlmacen);
$tNGs->addTransaction($del_alelemdevolutivo);
// Register triggers
$del_alelemdevolutivo->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_alelemdevolutivo->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$del_alelemdevolutivo->setTable("alelemdevolutivo");
$del_alelemdevolutivo->setPrimaryKey("alelemdevolutivo_id", "NUMERIC_TYPE", "GET", "alelemdevolutivo_id");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsalelemdevolutivo = $tNGs->getRecordset("alelemdevolutivo");
$row_rsalelemdevolutivo = mysql_fetch_assoc($rsalelemdevolutivo);
$totalRows_rsalelemdevolutivo = mysql_num_rows($rsalelemdevolutivo);
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
if (@$_GET['alelemdevolutivo_id'] == "") {
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
if (@$totalRows_rsalelemdevolutivo > 1) {
?>
          <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
          <?php } 
// endif Conditional region1
?>
        <table cellpadding="2" cellspacing="0" class="KT_tngtable">
          <tr>
            <td class="KT_th">&nbsp;</td>
            <td><input type="hidden" name="edtipoestruc_<?php echo $cnt1; ?>" id="edtipoestruc_<?php echo $cnt1; ?>" value="V" size="2" maxlength="2" />
                <?php echo $tNGs->displayFieldHint("edtipoestruc");?> <?php echo $tNGs->displayFieldError("alelemdevolutivo", "edtipoestruc", $cnt1); ?> <input type="hidden" name="ed_codelemrel_<?php echo $cnt1; ?>" id="ed_codelemrel_<?php echo $cnt1; ?>" value="0" size="7" />
                <?php echo $tNGs->displayFieldHint("ed_codelemrel");?> <?php echo $tNGs->displayFieldError("alelemdevolutivo", "ed_codelemrel", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="edcuenta_<?php echo $cnt1; ?>">CUENTA:</label></td>
            <td><select name="edcuenta_<?php echo $cnt1; ?>" id="edcuenta_<?php echo $cnt1; ?>">
              <option value="" <?php if (!(strcmp("", $_GET['edcuenta']))) {echo "selected=\"selected\"";} ?>><?php echo NXT_getResource("Select one..."); ?></option>
              <?php
do {  
?><option value="<?php echo $row_rscuentas['ca_codcuenta']?>"<?php if (!(strcmp($row_rscuentas['ca_codcuenta'], $_GET['edcuenta']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rscuentas['ca_nomcuenta'].'  ['.$row_rscuentas['ca_codcuenta'].']'?></option>
              <?php
} while ($row_rscuentas = mysql_fetch_assoc($rscuentas));
  $rows = mysql_num_rows($rscuentas);
  if($rows > 0) {
      mysql_data_seek($rscuentas, 0);
	  $row_rscuentas = mysql_fetch_assoc($rscuentas);
  }
?>
            </select>
                <?php echo $tNGs->displayFieldError("alelemdevolutivo", "edcuenta", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="ed_codelem_<?php echo $cnt1; ?>">COD ELEMENTO:</label></td>
            <td><input name="ed_codelem_<?php echo $cnt1; ?>" type="text" id="ed_codelem_<?php echo $cnt1; ?>" value="<?php echo $row_rscuentaelementos['ULTIMO'] + 1; ?>" size="7" />
                <?php echo $tNGs->displayFieldHint("ed_codelem");?> <?php echo $tNGs->displayFieldError("alelemdevolutivo", "ed_codelem", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="ed_nomelemento_<?php echo $cnt1; ?>">NOMBRE DEL ELEMENTO:</label></td>
            <td><input type="text" name="ed_nomelemento_<?php echo $cnt1; ?>" id="ed_nomelemento_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsalelemdevolutivo['ed_nomelemento']); ?>" size="70" />
                <?php echo $tNGs->displayFieldHint("ed_nomelemento");?> <?php echo $tNGs->displayFieldError("alelemdevolutivo", "ed_nomelemento", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="edunidad_<?php echo $cnt1; ?>">PRESENTACI�N:</label></td>
            <td><select name="edunidad_<?php echo $cnt1; ?>" id="edunidad_<?php echo $cnt1; ?>">
              <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
              <?php 
do {  
?>
              <option value="<?php echo $row_rspresenta['um_codunimed']?>"<?php if (!(strcmp($row_rspresenta['um_codunimed'], $row_rsalelemdevolutivo['edunidad']))) {echo "SELECTED";} ?>><?php echo $row_rspresenta['um_nomunimed']?></option>
              <?php
} while ($row_rspresenta = mysql_fetch_assoc($rspresenta));
  $rows = mysql_num_rows($rspresenta);
  if($rows > 0) {
      mysql_data_seek($rspresenta, 0);
	  $row_rspresenta = mysql_fetch_assoc($rspresenta);
  }
?>
            </select>
                <?php echo $tNGs->displayFieldError("alelemdevolutivo", "edunidad", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="edmarca_<?php echo $cnt1; ?>">MARCA:</label></td>
            <td><select name="edmarca_<?php echo $cnt1; ?>" id="edmarca_<?php echo $cnt1; ?>">
              <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
              <?php 
do {  
?>
              <option value="<?php echo $row_rsmarcas['ma_codmarca']?>"<?php if (!(strcmp($row_rsmarcas['ma_codmarca'], $row_rsalelemdevolutivo['edmarca']))) {echo "SELECTED";} ?>><?php echo $row_rsmarcas['ma_nommarca']?></option>
              <?php
} while ($row_rsmarcas = mysql_fetch_assoc($rsmarcas));
  $rows = mysql_num_rows($rsmarcas);
  if($rows > 0) {
      mysql_data_seek($rsmarcas, 0);
	  $row_rsmarcas = mysql_fetch_assoc($rsmarcas);
  }
?>
            </select>
                <?php echo $tNGs->displayFieldError("alelemdevolutivo", "edmarca", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="ed_modeloelem_<?php echo $cnt1; ?>">MODELO:</label></td>
            <td><input type="text" name="ed_modeloelem_<?php echo $cnt1; ?>" id="ed_modeloelem_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsalelemdevolutivo['ed_modeloelem']); ?>" size="32" maxlength="50" />
                <?php echo $tNGs->displayFieldHint("ed_modeloelem");?> <?php echo $tNGs->displayFieldError("alelemdevolutivo", "ed_modeloelem", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="edproveedor_<?php echo $cnt1; ?>">NIT PROVEEDOR</label></td>
            <td><input type="text" name="edproveedor_<?php echo $cnt1; ?>" id="edproveedor_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsalelemdevolutivo['edproveedor']); ?>" size="32" maxlength="50" />
                <?php echo $tNGs->displayFieldHint("edproveedor");?> <?php echo $tNGs->displayFieldError("alelemdevolutivo", "edproveedor", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="ed_valunit_<?php echo $cnt1; ?>">VALOR UNITARIO:</label></td>
            <td><input type="text" name="ed_valunit_<?php echo $cnt1; ?>" id="ed_valunit_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsalelemdevolutivo['ed_valunit']); ?>" size="10" />
                <?php echo $tNGs->displayFieldHint("ed_valunit");?> <?php echo $tNGs->displayFieldError("alelemdevolutivo", "ed_valunit", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="ed_localizacion_<?php echo $cnt1; ?>">LOCALIZACI&Oacute;N:</label></td>
            <td><select name="ed_localizacion_<?php echo $cnt1; ?>" id="ed_localizacion_<?php echo $cnt1; ?>">
              <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
              <?php 
do {  
?>
              <option value="<?php echo $row_rslocale['ascodalmacen_locale']?>"<?php if (!(strcmp($row_rslocale['ascodalmacen_locale'], $row_rsalelemdevolutivo['ed_localizacion']))) {echo "SELECTED";} ?>><?php echo $row_rslocale['ascodalmacen_nombre']?></option>
              <?php
} while ($row_rslocale = mysql_fetch_assoc($rslocale));
  $rows = mysql_num_rows($rslocale);
  if($rows > 0) {
      mysql_data_seek($rslocale, 0);
	  $row_rslocale = mysql_fetch_assoc($rslocale);
  }
?>
            </select>
                <?php echo $tNGs->displayFieldError("alelemdevolutivo", "ed_localizacion", $cnt1); ?> </td>
          </tr>
        </table>
        <input type="hidden" name="kt_pk_alelemdevolutivo_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rsalelemdevolutivo['kt_pk_alelemdevolutivo']); ?>" />
        <?php } while ($row_rsalelemdevolutivo = mysql_fetch_assoc($rsalelemdevolutivo)); ?>
      <div class="KT_bottombuttons">
        <div>
          <?php 
      // Show IF Conditional region1
      if (@$_GET['alelemdevolutivo_id'] == "") {
      ?>
            <input type="submit" name="KT_Insert1" id="KT_Insert1" value="Grabar" />
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
</body>
</html>
<?php
mysql_free_result($rscuentas);

mysql_free_result($rspresenta);

mysql_free_result($rsmarcas);

mysql_free_result($rslocale);

mysql_free_result($rscuentaelementos);
?>
