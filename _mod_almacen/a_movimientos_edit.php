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

// Require the MXI classes
require_once ('../includes/mxi/MXI.php');

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
$formValidation->addField("ascodalmacen", true, "numeric", "", "", "", "");
$formValidation->addField("as_nroasiento", true, "numeric", "", "", "", "");
$formValidation->addField("as_fechaasiento", true, "date", "", "", "", "");
$formValidation->addField("as_estadoasien", true, "text", "", "", "", "");
$formValidation->addField("as_aplicadepre", true, "text", "", "", "", "");
$formValidation->addField("sys_user", true, "text", "", "", "", "");
$formValidation->addField("sys_date", true, "date", "", "", "", "");
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
$query_rsalmacen = "SELECT * FROM inv_almacen WHERE ascodalmacen_estado = 1";
$rsalmacen = mysql_query($query_rsalmacen, $oConnAlmacen) or die(mysql_error());
$row_rsalmacen = mysql_fetch_assoc($rsalmacen);
$totalRows_rsalmacen = mysql_num_rows($rsalmacen);

mysql_select_db($database_oConnAlmacen, $oConnAlmacen);
$query_RsUltimoAsiento = "SELECT Max(alasientos.as_nroasiento) + 1 as ultasiento FROM alasientos GROUP BY alasientos.as_nroasiento ORDER BY alasientos.as_nroasiento DESC LIMIT 0, 1";
$RsUltimoAsiento = mysql_query($query_RsUltimoAsiento, $oConnAlmacen) or die(mysql_error());
$row_RsUltimoAsiento = mysql_fetch_assoc($RsUltimoAsiento);
$totalRows_RsUltimoAsiento = mysql_num_rows($RsUltimoAsiento);

// Make an insert transaction instance
$ins_alasientos = new tNG_multipleInsert($conn_oConnAlmacen);
$tNGs->addTransaction($ins_alasientos);
// Register triggers
$ins_alasientos->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_alasientos->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_alasientos->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$ins_alasientos->setTable("alasientos");
$ins_alasientos->addColumn("ascodalmacen", "NUMERIC_TYPE", "POST", "ascodalmacen");
$ins_alasientos->addColumn("as_nroasiento", "NUMERIC_TYPE", "POST", "as_nroasiento");
$ins_alasientos->addColumn("as_fechaasiento", "DATE_TYPE", "POST", "as_fechaasiento");
$ins_alasientos->addColumn("as_estadoasien", "STRING_TYPE", "POST", "as_estadoasien");
$ins_alasientos->addColumn("as_aplicadepre", "STRING_TYPE", "POST", "as_aplicadepre");
$ins_alasientos->addColumn("sys_user", "STRING_TYPE", "POST", "sys_user");
$ins_alasientos->addColumn("sys_date", "DATE_TYPE", "POST", "sys_date");
$ins_alasientos->setPrimaryKey("as_id", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_alasientos = new tNG_multipleUpdate($conn_oConnAlmacen);
$tNGs->addTransaction($upd_alasientos);
// Register triggers
$upd_alasientos->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_alasientos->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_alasientos->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$upd_alasientos->setTable("alasientos");
$upd_alasientos->addColumn("ascodalmacen", "NUMERIC_TYPE", "POST", "ascodalmacen");
$upd_alasientos->addColumn("as_nroasiento", "NUMERIC_TYPE", "POST", "as_nroasiento");
$upd_alasientos->addColumn("as_fechaasiento", "DATE_TYPE", "POST", "as_fechaasiento");
$upd_alasientos->addColumn("as_estadoasien", "STRING_TYPE", "POST", "as_estadoasien");
$upd_alasientos->addColumn("as_aplicadepre", "STRING_TYPE", "POST", "as_aplicadepre");
$upd_alasientos->addColumn("sys_user", "STRING_TYPE", "POST", "sys_user");
$upd_alasientos->addColumn("sys_date", "DATE_TYPE", "POST", "sys_date");
$upd_alasientos->setPrimaryKey("as_id", "NUMERIC_TYPE", "GET", "as_id");

// Make an instance of the transaction object
$del_alasientos = new tNG_multipleDelete($conn_oConnAlmacen);
$tNGs->addTransaction($del_alasientos);
// Register triggers
$del_alasientos->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_alasientos->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$del_alasientos->setTable("alasientos");
$del_alasientos->setPrimaryKey("as_id", "NUMERIC_TYPE", "GET", "as_id");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsalasientos = $tNGs->getRecordset("alasientos");
$row_rsalasientos = mysql_fetch_assoc($rsalasientos);
$totalRows_rsalasientos = mysql_num_rows($rsalasientos);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:: Contrataci&oacute;n :: MinCIT ::.</title>
<link rel="stylesheet" href="../_jquery/_desktop/_app/themes/south-street/jquery.ui.all.css">
	<script src="../_jquery/_desktop/_app/jquery-1.9.1.js"></script>
<script src="../_jquery/_desktop/_app/ui/jquery.ui.core.js"></script>
<script src="../_jquery/_desktop/_app/ui/jquery.ui.widget.js"></script>
<script src="../_jquery/_desktop/_app/ui/jquery.ui.tabs.js"></script>
	<script src="../_jquery/_desktop/_app/ui/jquery.ui.button.js"></script>
	<script src="../_jquery/_desktop/_app/ui/jquery.ui.position.js"></script>
	<script src="../_jquery/_desktop/_app/ui/jquery.ui.menu.js"></script>
   	<script src="../_jquery/_desktop/_app/ui/jquery.ui.button.js"></script>
   	<script src="../_jquery/_desktop/_app/ui/jquery.ui.datepicker.js"></script>
	<link rel="stylesheet" href="../_jquery/_desktop/_app/_modules/demos.css">
    <style>
		.ui-menu { position: absolute; width: 100px; }
	</style>
<script>
	$(function() {
		$( "#tabs" ).tabs();
		
		$( "#rerun" )
			.button()
			.click(function() {
				alert( "Seleccionar acci�n" );
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
    <script>
	$(function() {
		$( "#as_fechaasiento" ).datepicker({
			changeMonth: true,
			changeYear: true
		});
	});
	</script>
<link href="../_css/jqueryslidemenu.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../_jquery/hs/highslide/highslide-with-html.js"></script>
<link rel="stylesheet" type="text/css" href="../_jquery/hs/highslide/highslide.css" />
<script type="text/javascript">
hs.graphicsDir = '../_jquery/hs/highslide/graphics/';
hs.outlineType = 'rounded-white';
hs.wrapperClassName = 'draggable-header';
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
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
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
if (@$_GET['as_id'] == "") {
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
if (@$totalRows_rsalasientos > 1) {
?>
                <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
                <?php } 
// endif Conditional region1
?>
              <table cellpadding="2" cellspacing="0" class="KT_tngtable">
                <tr>
                  <td class="KT_th"><label for="ascodalmacen_<?php echo $cnt1; ?>">Almac&eacute;n:</label></td>
                  <td><select name="ascodalmacen_<?php echo $cnt1; ?>" id="ascodalmacen_<?php echo $cnt1; ?>">
                      <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                      <?php 
do {  
?>
                      <option value="<?php echo $row_rsalmacen['ascodalmacen']?>"<?php if (!(strcmp($row_rsalmacen['ascodalmacen'], $row_rsalasientos['ascodalmacen']))) {echo "SELECTED";} ?>><?php echo $row_rsalmacen['ascodalmacen_nombre']?></option>
                      <?php
} while ($row_rsalmacen = mysql_fetch_assoc($rsalmacen));
  $rows = mysql_num_rows($rsalmacen);
  if($rows > 0) {
      mysql_data_seek($rsalmacen, 0);
	  $row_rsalmacen = mysql_fetch_assoc($rsalmacen);
  }
?>
                    </select>
                      <?php echo $tNGs->displayFieldError("alasientos", "ascodalmacen", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="as_nroasiento_<?php echo $cnt1; ?>">N&uacute;mero:</label></td>
                  <td><input name="as_nroasiento_<?php echo $cnt1; ?>" type="text" id="as_nroasiento_<?php echo $cnt1; ?>" value="<?php echo $row_RsUltimoAsiento['ultasiento']; ?>" size="7" />
                      <?php echo $tNGs->displayFieldHint("as_nroasiento");?> <?php echo $tNGs->displayFieldError("alasientos", "as_nroasiento", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="as_fechaasiento">Fecha:</label></td>
                  <td><input type="text" name="as_fechaasiento" id="as_fechaasiento" value="<?php echo KT_formatDate($row_rsalasientos['as_fechaasiento']); ?>" size="10" maxlength="22" />
                      <?php echo $tNGs->displayFieldHint("as_fechaasiento");?> <?php echo $tNGs->displayFieldError("alasientos", "as_fechaasiento", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="as_estadoasien_<?php echo $cnt1; ?>_1">Estado:</label></td>
                  <td><div>
                      <input <?php if (!(strcmp(KT_escapeAttribute($row_rsalasientos['as_estadoasien']),"A"))) {echo "CHECKED";} ?> type="radio" name="as_estadoasien_<?php echo $cnt1; ?>" id="as_estadoasien_<?php echo $cnt1; ?>_1" value="A" />
                      <label for="as_estadoasien_<?php echo $cnt1; ?>_1">Abierto</label>
                    </div>
                      <div>
                        <input <?php if (!(strcmp(KT_escapeAttribute($row_rsalasientos['as_estadoasien']),"C"))) {echo "CHECKED";} ?> type="radio" name="as_estadoasien_<?php echo $cnt1; ?>" id="as_estadoasien_<?php echo $cnt1; ?>_2" value="C" />
                        <label for="as_estadoasien_<?php echo $cnt1; ?>_2">Cerrado</label>
                      </div>
                    <?php echo $tNGs->displayFieldError("alasientos", "as_estadoasien", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th">&nbsp;</td>
                  <td><input name="as_aplicadepre_<?php echo $cnt1; ?>" type="hidden" id="as_aplicadepre_<?php echo $cnt1; ?>" value="N" />
                      <?php echo $tNGs->displayFieldHint("as_aplicadepre");?> <?php echo $tNGs->displayFieldError("alasientos", "as_aplicadepre", $cnt1); ?> <input name="sys_user_<?php echo $cnt1; ?>" type="hidden" id="sys_user_<?php echo $cnt1; ?>" value="<?php echo $_SESSION['kt_login_user']; ?>" />
                      <?php echo $tNGs->displayFieldHint("sys_user");?> <?php echo $tNGs->displayFieldError("alasientos", "sys_user", $cnt1); ?> <input name="sys_date_<?php echo $cnt1; ?>" type="hidden" id="sys_date_<?php echo $cnt1; ?>" value="<?php echo $fechac; ?>" />
                      <?php echo $tNGs->displayFieldHint("sys_date");?> <?php echo $tNGs->displayFieldError("alasientos", "sys_date", $cnt1); ?> </td>
                </tr>
              </table>
              <input type="hidden" name="kt_pk_alasientos_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rsalasientos['kt_pk_alasientos']); ?>" />
              <?php } while ($row_rsalasientos = mysql_fetch_assoc($rsalasientos)); ?>
            <div class="KT_bottombuttons">
              <div>
                <?php 
      // Show IF Conditional region1
      if (@$_GET['as_id'] == "") {
      ?>
                  <input type="submit" name="KT_Insert1" id="KT_Insert1" value="Guardar" />
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
mysql_free_result($rsalmacen);

mysql_free_result($RsUltimoAsiento);
?>
