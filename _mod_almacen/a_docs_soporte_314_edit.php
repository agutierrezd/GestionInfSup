<?php require_once('../Connections/oConnAlmacen.php'); ?>
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

// Require the MXI classes
require_once ('../includes/mxi/MXI.php');

// Load the KT_back class
require_once('../includes/nxt/KT_back.php');

// Make a transaction dispatcher instance
$tNGs = new tNG_dispatcher("../");

// Make unified connection variable
$conn_oConnAlmacen = new KT_connection($oConnAlmacen, $database_oConnAlmacen);

// Start trigger
$formValidation = new tNG_FormValidation();
$formValidation->addField("doclasedoc_id_fk", true, "numeric", "", "", "", "");
$formValidation->addField("mddclasedoc", true, "numeric", "", "", "", "");
$formValidation->addField("mddnrodoc", true, "numeric", "", "", "", "");
$formValidation->addField("mddfechadoc", true, "date", "", "", "", "");
$formValidation->addField("mddalmacen", true, "text", "", "", "", "");
$formValidation->addField("mddtipoestruc", true, "text", "", "", "", "");
$formValidation->addField("mddcuenta", true, "text", "", "", "", "");
$formValidation->addField("mddcodelem", true, "numeric", "", "", "", "");
$formValidation->addField("mdd_cantmovto", true, "numeric", "", "", "", "");
$formValidation->addField("mdd_valunit", true, "double", "", "", "", "");
$formValidation->addField("mdd_tax", true, "numeric", "", "", "", "");
$formValidation->addField("geusuario", true, "text", "", "", "", "");
$formValidation->addField("gefechaactua", true, "date", "", "", "", "");
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
$query_rstax = "SELECT * FROM global_type_tax";
$rstax = mysql_query($query_rstax, $oConnAlmacen) or die(mysql_error());
$row_rstax = mysql_fetch_assoc($rstax);
$totalRows_rstax = mysql_num_rows($rstax);

mysql_select_db($database_oConnAlmacen, $oConnAlmacen);
$query_rscuentasd = "SELECT * FROM alcuentasalma WHERE ca_tipocuenta = 'D' ORDER BY ca_nomcuenta ASC";
$rscuentasd = mysql_query($query_rscuentasd, $oConnAlmacen) or die(mysql_error());
$row_rscuentasd = mysql_fetch_assoc($rscuentasd);
$totalRows_rscuentasd = mysql_num_rows($rscuentasd);

$colname_rsgedocumentos = "-1";
if (isset($_GET['doclasedoc_id'])) {
  $colname_rsgedocumentos = $_GET['doclasedoc_id'];
}
mysql_select_db($database_oConnAlmacen, $oConnAlmacen);
$query_rsgedocumentos = sprintf("SELECT * FROM gedocumentos WHERE doclasedoc_id = %s", GetSQLValueString($colname_rsgedocumentos, "int"));
$rsgedocumentos = mysql_query($query_rsgedocumentos, $oConnAlmacen) or die(mysql_error());
$row_rsgedocumentos = mysql_fetch_assoc($rsgedocumentos);
$totalRows_rsgedocumentos = mysql_num_rows($rsgedocumentos);

// Make an insert transaction instance
$ins_almovdevdia = new tNG_multipleInsert($conn_oConnAlmacen);
$tNGs->addTransaction($ins_almovdevdia);
// Register triggers
$ins_almovdevdia->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_almovdevdia->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_almovdevdia->registerTrigger("END", "Trigger_Default_Redirect", 99, "transact_01.php?doclasedoc_id={GET.doclasedoc_id}&hash_id={GET.hash_id}&as_id={GET.as_id}&anio_id={GET.anio_id}");
// Add columns
$ins_almovdevdia->setTable("almovdevdia");
$ins_almovdevdia->addColumn("doclasedoc_id_fk", "NUMERIC_TYPE", "POST", "doclasedoc_id_fk");
$ins_almovdevdia->addColumn("mddclasedoc", "NUMERIC_TYPE", "POST", "mddclasedoc");
$ins_almovdevdia->addColumn("mddnrodoc", "NUMERIC_TYPE", "POST", "mddnrodoc");
$ins_almovdevdia->addColumn("mddfechadoc", "DATE_TYPE", "POST", "mddfechadoc");
$ins_almovdevdia->addColumn("mddalmacen", "STRING_TYPE", "POST", "mddalmacen");
$ins_almovdevdia->addColumn("mddtipoestruc", "STRING_TYPE", "POST", "mddtipoestruc");
$ins_almovdevdia->addColumn("mddcuenta", "STRING_TYPE", "POST", "mddcuenta");
$ins_almovdevdia->addColumn("mddcodelem", "NUMERIC_TYPE", "POST", "mddcodelem");
$ins_almovdevdia->addColumn("mdd_cantmovto", "NUMERIC_TYPE", "POST", "mdd_cantmovto");
$ins_almovdevdia->addColumn("mdd_valunit", "DOUBLE_TYPE", "POST", "mdd_valunit");
$ins_almovdevdia->addColumn("mdd_tax", "DOUBLE_TYPE", "POST", "mdd_tax");
$ins_almovdevdia->addColumn("mdd_valmovto", "DOUBLE_TYPE", "POST", "mdd_valmovto");
$ins_almovdevdia->addColumn("geusuario", "STRING_TYPE", "POST", "geusuario");
$ins_almovdevdia->addColumn("gefechaactua", "DATE_TYPE", "POST", "gefechaactua");
$ins_almovdevdia->setPrimaryKey("almovdevdia_id", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_almovdevdia = new tNG_multipleUpdate($conn_oConnAlmacen);
$tNGs->addTransaction($upd_almovdevdia);
// Register triggers
$upd_almovdevdia->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_almovdevdia->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_almovdevdia->registerTrigger("END", "Trigger_Default_Redirect", 99, "transact_01.php?doclasedoc_id={GET.doclasedoc_id}&hash_id={GET.hash_id}&as_id={GET.as_id}&anio_id={GET.anio_id}");
// Add columns
$upd_almovdevdia->setTable("almovdevdia");
$upd_almovdevdia->addColumn("doclasedoc_id_fk", "NUMERIC_TYPE", "POST", "doclasedoc_id_fk");
$upd_almovdevdia->addColumn("mddclasedoc", "NUMERIC_TYPE", "POST", "mddclasedoc");
$upd_almovdevdia->addColumn("mddnrodoc", "NUMERIC_TYPE", "POST", "mddnrodoc");
$upd_almovdevdia->addColumn("mddfechadoc", "DATE_TYPE", "POST", "mddfechadoc");
$upd_almovdevdia->addColumn("mddalmacen", "STRING_TYPE", "POST", "mddalmacen");
$upd_almovdevdia->addColumn("mddtipoestruc", "STRING_TYPE", "POST", "mddtipoestruc");
$upd_almovdevdia->addColumn("mddcuenta", "STRING_TYPE", "POST", "mddcuenta");
$upd_almovdevdia->addColumn("mddcodelem", "NUMERIC_TYPE", "POST", "mddcodelem");
$upd_almovdevdia->addColumn("mdd_cantmovto", "NUMERIC_TYPE", "POST", "mdd_cantmovto");
$upd_almovdevdia->addColumn("mdd_valunit", "DOUBLE_TYPE", "POST", "mdd_valunit");
$upd_almovdevdia->addColumn("mdd_tax", "DOUBLE_TYPE", "POST", "mdd_tax");
$upd_almovdevdia->addColumn("mdd_valmovto", "DOUBLE_TYPE", "POST", "mdd_valmovto");
$upd_almovdevdia->addColumn("geusuario", "STRING_TYPE", "POST", "geusuario");
$upd_almovdevdia->addColumn("gefechaactua", "DATE_TYPE", "POST", "gefechaactua");
$upd_almovdevdia->setPrimaryKey("almovdevdia_id", "NUMERIC_TYPE", "GET", "almovdevdia_id");

// Make an instance of the transaction object
$del_almovdevdia = new tNG_multipleDelete($conn_oConnAlmacen);
$tNGs->addTransaction($del_almovdevdia);
// Register triggers
$del_almovdevdia->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_almovdevdia->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$del_almovdevdia->setTable("almovdevdia");
$del_almovdevdia->setPrimaryKey("almovdevdia_id", "NUMERIC_TYPE", "GET", "almovdevdia_id");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsalmovdevdia = $tNGs->getRecordset("almovdevdia");
$row_rsalmovdevdia = mysql_fetch_assoc($rsalmovdevdia);
$totalRows_rsalmovdevdia = mysql_num_rows($rsalmovdevdia);
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
<script type="text/javascript">
function popup(b_id){
                window.open("a_elementos_list.php","Popup","height=400,width=600,,scrollbars=yes,"+ 
                        "directories=yes,location=yes,menubar=yes," + 
                         "resizable=yes status=yes,history=yes top = 50 left = 100");
            }
</script>
<link href="../_css/jqueryslidemenu.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php
  mxi_includes_start("../inc_top_2.php");
  require(basename("../inc_top_2.php"));
  mxi_includes_end();
?>
<?php
	echo $tNGs->getErrorMsg();
?>
<div class="KT_tng">
  <h1>
    <?php 
// Show IF Conditional region1 
if (@$_GET['almovdevdia_id'] == "") {
?>
      <?php echo NXT_getResource("Insert_FH"); ?>
      <?php 
// else Conditional region1
} else { ?>
      <?php echo NXT_getResource("Update_FH"); ?>
      <?php } 
// endif Conditional region1
?>
    Almovdevdia </h1>
  <div class="KT_tngform">
    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
      <?php $cnt1 = 0; ?>
      <?php do { ?>
        <?php $cnt1++; ?>
        <?php 
// Show IF Conditional region1 
if (@$totalRows_rsalmovdevdia > 1) {
?>
          <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
          <?php } 
// endif Conditional region1
?>
        <table cellpadding="2" cellspacing="0" class="KT_tngtable">
          <tr>
            <td class="KT_th">&nbsp;</td>
            <td><input name="doclasedoc_id_fk_<?php echo $cnt1; ?>" type="hidden" id="doclasedoc_id_fk_<?php echo $cnt1; ?>" value="<?php echo $row_rsgedocumentos['doclasedoc_id']; ?>" size="7" />
                <?php echo $tNGs->displayFieldHint("doclasedoc_id_fk");?> <?php echo $tNGs->displayFieldError("almovdevdia", "doclasedoc_id_fk", $cnt1); ?> <input name="mddclasedoc_<?php echo $cnt1; ?>" type="hidden" id="mddclasedoc_<?php echo $cnt1; ?>" value="<?php echo $row_rsgedocumentos['doclasedoc']; ?>" size="7" />
                <?php echo $tNGs->displayFieldHint("mddclasedoc");?> <?php echo $tNGs->displayFieldError("almovdevdia", "mddclasedoc", $cnt1); ?> <input name="mddnrodoc_<?php echo $cnt1; ?>" type="hidden" id="mddnrodoc_<?php echo $cnt1; ?>" value="<?php echo $row_rsgedocumentos['do_nrodoc']; ?>" size="7" />
                <?php echo $tNGs->displayFieldHint("mddnrodoc");?> <?php echo $tNGs->displayFieldError("almovdevdia", "mddnrodoc", $cnt1); ?> <input name="mddfechadoc_<?php echo $cnt1; ?>" type="hidden" id="mddfechadoc_<?php echo $cnt1; ?>" value="<?php echo $row_rsgedocumentos['do_fechadoc']; ?>" size="10" maxlength="22" />
                <?php echo $tNGs->displayFieldHint("mddfechadoc");?> <?php echo $tNGs->displayFieldError("almovdevdia", "mddfechadoc", $cnt1); ?> <input name="mddalmacen_<?php echo $cnt1; ?>" type="hidden" id="mddalmacen_<?php echo $cnt1; ?>" value="<?php echo $row_rsgedocumentos['docodregion']; ?>" size="3" maxlength="3" />
                <?php echo $tNGs->displayFieldHint("mddalmacen");?> <?php echo $tNGs->displayFieldError("almovdevdia", "mddalmacen", $cnt1); ?> <input type="hidden" name="mddtipoestruc" id="mddtipoestruc" value="<?php echo KT_escapeAttribute($row_rsalmovdevdia['mddtipoestruc']); ?>" size="2" maxlength="2" />
            <?php echo $tNGs->displayFieldHint("mddtipoestruc");?> <?php echo $tNGs->displayFieldError("almovdevdia", "mddtipoestruc", $cnt1); ?> </td>
          </tr>
          
          <tr>
            <td class="KT_th"><label for="mddcuenta">CUENTA:</label></td>
            <td><input name="mddcuenta" type="text" id="mddcuenta" readonly="true" />
              <?php echo $tNGs->displayFieldError("almovdevdia", "mddcuenta", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="mddcodelem_<?php echo $cnt1; ?>">CODIGO:</label></td>
            <td><input name="mddcodelem" type="text" id="mddcodelem" value="<?php echo $row_rsalmovdevdia['mddcodelem']; ?>" readonly="true" />
              <?php echo $tNGs->displayFieldError("almovdevdia", "mddcodelem", $cnt1); ?> <a href="#" onclick="popup();"><img src="325_add_cta.png" width="32" height="32" border="0" /></a></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="mdd_cantmovto_<?php echo $cnt1; ?>">CANTIDAD:</label></td>
            <td><input type="text" name="mdd_cantmovto_<?php echo $cnt1; ?>" id="mdd_cantmovto_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsalmovdevdia['mdd_cantmovto']); ?>" size="7" />
                <?php echo $tNGs->displayFieldHint("mdd_cantmovto");?> <?php echo $tNGs->displayFieldError("almovdevdia", "mdd_cantmovto", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="mdd_valunit">VALOR UNITARIO:</label></td>
            <td><input name="mdd_valunit" type="text" class="titlemsg2" id="mdd_valunit" value="<?php echo KT_escapeAttribute($row_rsalmovdevdia['mdd_valunit']); ?>" size="15" readonly="true" />
                <?php echo $tNGs->displayFieldHint("mdd_valunit");?> <?php echo $tNGs->displayFieldError("almovdevdia", "mdd_valunit", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="mdd_tax_<?php echo $cnt1; ?>">APLICAR IMPUESTO:</label></td>
            <td><select name="mdd_tax_<?php echo $cnt1; ?>" id="mdd_tax_<?php echo $cnt1; ?>">
              <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
              <?php 
do {  
?>
              <option value="<?php echo $row_rstax['tax_code']?>"<?php if (!(strcmp($row_rstax['tax_code'], $row_rsalmovdevdia['mdd_tax']))) {echo "SELECTED";} ?>><?php echo $row_rstax['tax_name']?></option>
              <?php
} while ($row_rstax = mysql_fetch_assoc($rstax));
  $rows = mysql_num_rows($rstax);
  if($rows > 0) {
      mysql_data_seek($rstax, 0);
	  $row_rstax = mysql_fetch_assoc($rstax);
  }
?>
            </select>
                <?php echo $tNGs->displayFieldError("almovdevdia", "mdd_tax", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="mdd_valmovto_<?php echo $cnt1; ?>"></label></td>
            <td><input name="mdd_valmovto_<?php echo $cnt1; ?>" type="hidden" id="mdd_valmovto_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsalmovdevdia['mdd_valmovto']); ?>" />
                <?php echo $tNGs->displayFieldHint("mdd_valmovto");?> <?php echo $tNGs->displayFieldError("almovdevdia", "mdd_valmovto", $cnt1); ?> <input name="geusuario_<?php echo $cnt1; ?>" type="hidden" id="geusuario_<?php echo $cnt1; ?>" value="<?php echo $_SESSION['kt_login_user']; ?>" size="32" maxlength="50" />
                <?php echo $tNGs->displayFieldHint("geusuario");?> <?php echo $tNGs->displayFieldError("almovdevdia", "geusuario", $cnt1); ?> <input type="hidden" name="gefechaactua_<?php echo $cnt1; ?>" id="gefechaactua_<?php echo $cnt1; ?>" value="<?php echo $fechac; ?>" size="10" maxlength="22" />
            <?php echo $tNGs->displayFieldHint("gefechaactua");?> <?php echo $tNGs->displayFieldError("almovdevdia", "gefechaactua", $cnt1); ?> </td>
          </tr>
        </table>
        <input type="hidden" name="kt_pk_almovdevdia_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rsalmovdevdia['kt_pk_almovdevdia']); ?>" />
        <?php } while ($row_rsalmovdevdia = mysql_fetch_assoc($rsalmovdevdia)); ?>
      <div class="KT_bottombuttons">
        <div>
          <?php 
      // Show IF Conditional region1
      if (@$_GET['almovdevdia_id'] == "") {
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
<?php
  mxi_includes_start("../inc_foot.php");
  require(basename("../inc_foot.php"));
  mxi_includes_end();
?>
</body>
</html>
<?php
mysql_free_result($rstax);

mysql_free_result($rscuentasd);

mysql_free_result($rsgedocumentos);
?>
