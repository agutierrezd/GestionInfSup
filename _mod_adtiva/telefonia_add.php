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
$formValidation->addField("tipoc_name", true, "text", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

// Make an insert transaction instance
$ins_eco_telefonia_tipoconsumo = new tNG_multipleInsert($conn_oConnContratos);
$tNGs->addTransaction($ins_eco_telefonia_tipoconsumo);
// Register triggers
$ins_eco_telefonia_tipoconsumo->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_eco_telefonia_tipoconsumo->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_eco_telefonia_tipoconsumo->registerTrigger("END", "Trigger_Default_Redirect", 99, "telefonia.php");
// Add columns
$ins_eco_telefonia_tipoconsumo->setTable("eco_telefonia_tipoconsumo");
$ins_eco_telefonia_tipoconsumo->addColumn("tipoc_name", "STRING_TYPE", "POST", "tipoc_name");
$ins_eco_telefonia_tipoconsumo->setPrimaryKey("tipoc_id", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_eco_telefonia_tipoconsumo = new tNG_multipleUpdate($conn_oConnContratos);
$tNGs->addTransaction($upd_eco_telefonia_tipoconsumo);
// Register triggers
$upd_eco_telefonia_tipoconsumo->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_eco_telefonia_tipoconsumo->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_eco_telefonia_tipoconsumo->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$upd_eco_telefonia_tipoconsumo->setTable("eco_telefonia_tipoconsumo");
$upd_eco_telefonia_tipoconsumo->addColumn("tipoc_name", "STRING_TYPE", "POST", "tipoc_name");
$upd_eco_telefonia_tipoconsumo->setPrimaryKey("tipoc_id", "NUMERIC_TYPE", "GET", "tipoc_id");

// Make an instance of the transaction object
$del_eco_telefonia_tipoconsumo = new tNG_multipleDelete($conn_oConnContratos);
$tNGs->addTransaction($del_eco_telefonia_tipoconsumo);
// Register triggers
$del_eco_telefonia_tipoconsumo->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_eco_telefonia_tipoconsumo->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$del_eco_telefonia_tipoconsumo->setTable("eco_telefonia_tipoconsumo");
$del_eco_telefonia_tipoconsumo->setPrimaryKey("tipoc_id", "NUMERIC_TYPE", "GET", "tipoc_id");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rseco_telefonia_tipoconsumo = $tNGs->getRecordset("eco_telefonia_tipoconsumo");
$row_rseco_telefonia_tipoconsumo = mysql_fetch_assoc($rseco_telefonia_tipoconsumo);
$totalRows_rseco_telefonia_tipoconsumo = mysql_num_rows($rseco_telefonia_tipoconsumo);

// Require the MXI classes
require_once ('../includes/mxi/MXI.php');

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
$query_rstipoconsumo = "SELECT * FROM eco_telefonia_tipoconsumo ORDER BY tipoc_name ASC";
$rstipoconsumo = mysql_query($query_rstipoconsumo, $oConnContratos) or die(mysql_error());
$row_rstipoconsumo = mysql_fetch_assoc($rstipoconsumo);
$totalRows_rstipoconsumo = mysql_num_rows($rstipoconsumo);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:: Contrataci&oacute;n :: MinCIT ::.</title>
<!-- AQUI COMIENZA LA BOTONERA -->

	<link rel="stylesheet" href="../_jquery/_desktop/_app/themes/south-street/jquery.ui.all.css">
<script src="../_jquery/_desktop/_app/jquery-1.9.1.js"></script>
<script src="../_jquery/_desktop/_app/ui/jquery.ui.core.js"></script>
<script src="../_jquery/_desktop/_app/ui/jquery.ui.widget.js"></script>
<script src="../_jquery/_desktop/_app/ui/jquery.ui.button.js"></script>
<script src="../_jquery/_desktop/_app/ui/jquery.ui.position.js"></script>
<script src="../_jquery/_desktop/_app/ui/jquery.ui.menu.js"></script>
<link href="../demos.css" rel="stylesheet" type="text/css">
	<style>
		.ui-menu {
	position: absolute;
	width: 280px;
}
	</style>
<script>
	$(function() {
		$( "#rerun" )
			.button()
			.click(function() {
				alert( "Seleccionar tipo de consumo" );
			})
			.next()
				.button({
					text: false,
					icons: {
						primary: "ui-icon-triangle-1-s"
					}
				})
				.click(function() {
					var menu = $( this ).parent().next().show().position({
						my: "left top",
						at: "left bottom",
						of: this
					});
					$( document ).one( "click", function() {
						menu.hide();
					});
					return false;
				})
				.parent()
					.buttonset()
					.next()
						.hide()
						.menu();
	});
	</script>
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
  mxi_includes_start("../inc_top_2.php");
  require(basename("../inc_top_2.php"));
  mxi_includes_end();
?>
<div>
	<div>
		<button id="rerun">Tipo de consumo</button>
		<button id="select">Tipo</button>
	</div>
	<ul>
		<?php do { ?>
		  <li><a href="telefonia.php?tipoc_id=<?php echo $row_rstipoconsumo['tipoc_id']; ?>"><?php echo $row_rstipoconsumo['tipoc_name']; ?></a></li>
		  <?php } while ($row_rstipoconsumo = mysql_fetch_assoc($rstipoconsumo)); ?>
          <li><a href="telefonia_add.php">Agregar registro</a></li>
	</ul>
</div>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;
      <?php
	echo $tNGs->getErrorMsg();
?>
      <div class="KT_tng">
        <h1>
          <?php 
// Show IF Conditional region1 
if (@$_GET['tipoc_id'] == "") {
?>
            <?php echo NXT_getResource("Insert_FH"); ?>
            <?php 
// else Conditional region1
} else { ?>
            <?php echo NXT_getResource("Update_FH"); ?>
            <?php } 
// endif Conditional region1
?>
          Tipo de consumo
        </h1>
        <div class="KT_tngform">
          <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
            <?php $cnt1 = 0; ?>
            <?php do { ?>
              <?php $cnt1++; ?>
              <?php 
// Show IF Conditional region1 
if (@$totalRows_rseco_telefonia_tipoconsumo > 1) {
?>
                <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
                <?php } 
// endif Conditional region1
?>
              <table cellpadding="2" cellspacing="0" class="KT_tngtable">
                <tr>
                  <td class="KT_th"><label for="tipoc_name_<?php echo $cnt1; ?>">Tipo de consumo:</label></td>
                  <td><input type="text" name="tipoc_name_<?php echo $cnt1; ?>" id="tipoc_name_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rseco_telefonia_tipoconsumo['tipoc_name']); ?>" size="50" maxlength="100" />
                      <?php echo $tNGs->displayFieldHint("tipoc_name");?> <?php echo $tNGs->displayFieldError("eco_telefonia_tipoconsumo", "tipoc_name", $cnt1); ?> </td>
                </tr>
              </table>
              <input type="hidden" name="kt_pk_eco_telefonia_tipoconsumo_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rseco_telefonia_tipoconsumo['kt_pk_eco_telefonia_tipoconsumo']); ?>" />
              <?php } while ($row_rseco_telefonia_tipoconsumo = mysql_fetch_assoc($rseco_telefonia_tipoconsumo)); ?>
            <div class="KT_bottombuttons">
              <div>
                <?php 
      // Show IF Conditional region1
      if (@$_GET['tipoc_id'] == "") {
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
mysql_free_result($rstipoconsumo);
?>
