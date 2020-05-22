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

// Load the KT_back class
require_once('../includes/nxt/KT_back.php');

// Make a transaction dispatcher instance
$tNGs = new tNG_dispatcher("../");

// Make unified connection variable
$conn_oConnAlmacen = new KT_connection($oConnAlmacen, $database_oConnAlmacen);

// Start trigger
$formValidation = new tNG_FormValidation();
$formValidation->addField("doclasedoc_id_fk", true, "numeric", "", "", "", "");
$formValidation->addField("mcdclasedoc", true, "numeric", "", "", "", "");
$formValidation->addField("mcdnrodoc", true, "numeric", "", "", "", "");
$formValidation->addField("mcdfechadoc", true, "date", "", "", "", "");
$formValidation->addField("mcdalmacen", true, "text", "", "", "", "");
$formValidation->addField("mcdtipoestruc", true, "text", "", "", "", "");
$formValidation->addField("mcdcuenta", true, "text", "", "", "", "");
$formValidation->addField("mcdcodelem", true, "numeric", "", "", "", "");
$formValidation->addField("mcd_cantmovto", true, "numeric", "", "", "", "");
$formValidation->addField("mcd_saldant", true, "numeric", "", "", "", "");
$formValidation->addField("mcd_valunitant", true, "double", "", "", "", "");
$formValidation->addField("mcd_tax", true, "numeric", "", "", "", "");
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
$ins_almovconsdia = new tNG_multipleInsert($conn_oConnAlmacen);
$tNGs->addTransaction($ins_almovconsdia);
// Register triggers
$ins_almovconsdia->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_almovconsdia->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_almovconsdia->registerTrigger("END", "Trigger_Default_Redirect", 99, "transact_03.php?as_id={GET.as_id}&doclasedoc_id={rsgedocumentos.doclasedoc_id}&hash_id={GET.hash_id}&anio_id={GET.anio_id}");
// Add columns
$ins_almovconsdia->setTable("almovconsdia");
$ins_almovconsdia->addColumn("doclasedoc_id_fk", "NUMERIC_TYPE", "POST", "doclasedoc_id_fk");
$ins_almovconsdia->addColumn("mcdclasedoc", "NUMERIC_TYPE", "POST", "mcdclasedoc");
$ins_almovconsdia->addColumn("mcdnrodoc", "NUMERIC_TYPE", "POST", "mcdnrodoc");
$ins_almovconsdia->addColumn("mcdfechadoc", "DATE_TYPE", "POST", "mcdfechadoc");
$ins_almovconsdia->addColumn("mcdalmacen", "STRING_TYPE", "POST", "mcdalmacen");
$ins_almovconsdia->addColumn("mcdtipoestruc", "STRING_TYPE", "POST", "mcdtipoestruc");
$ins_almovconsdia->addColumn("mcdcuenta", "STRING_TYPE", "POST", "mcdcuenta");
$ins_almovconsdia->addColumn("mcdcodelem", "NUMERIC_TYPE", "POST", "mcdcodelem");
$ins_almovconsdia->addColumn("mcd_cantmovto", "NUMERIC_TYPE", "POST", "mcd_cantmovto");
$ins_almovconsdia->addColumn("mcd_saldant", "NUMERIC_TYPE", "POST", "mcd_saldant");
$ins_almovconsdia->addColumn("mcd_valunitant", "DOUBLE_TYPE", "POST", "mcd_valunitant");
$ins_almovconsdia->addColumn("mcd_tax", "DOUBLE_TYPE", "POST", "mcd_tax");
$ins_almovconsdia->addColumn("geusuario", "STRING_TYPE", "POST", "geusuario");
$ins_almovconsdia->addColumn("gefechaactua", "DATE_TYPE", "POST", "gefechaactua");
$ins_almovconsdia->setPrimaryKey("almovconsdia_id", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_almovconsdia = new tNG_multipleUpdate($conn_oConnAlmacen);
$tNGs->addTransaction($upd_almovconsdia);
// Register triggers
$upd_almovconsdia->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_almovconsdia->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_almovconsdia->registerTrigger("END", "Trigger_Default_Redirect", 99, "transact_03.php?as_id={GET.as_id}&doclasedoc_id={rsgedocumentos.doclasedoc_id}&hash_id={GET.hash_id}&anio_id={GET.anio_id}");
// Add columns
$upd_almovconsdia->setTable("almovconsdia");
$upd_almovconsdia->addColumn("doclasedoc_id_fk", "NUMERIC_TYPE", "POST", "doclasedoc_id_fk");
$upd_almovconsdia->addColumn("mcdclasedoc", "NUMERIC_TYPE", "POST", "mcdclasedoc");
$upd_almovconsdia->addColumn("mcdnrodoc", "NUMERIC_TYPE", "POST", "mcdnrodoc");
$upd_almovconsdia->addColumn("mcdfechadoc", "DATE_TYPE", "POST", "mcdfechadoc");
$upd_almovconsdia->addColumn("mcdalmacen", "STRING_TYPE", "POST", "mcdalmacen");
$upd_almovconsdia->addColumn("mcdtipoestruc", "STRING_TYPE", "POST", "mcdtipoestruc");
$upd_almovconsdia->addColumn("mcdcuenta", "STRING_TYPE", "POST", "mcdcuenta");
$upd_almovconsdia->addColumn("mcdcodelem", "NUMERIC_TYPE", "POST", "mcdcodelem");
$upd_almovconsdia->addColumn("mcd_cantmovto", "NUMERIC_TYPE", "POST", "mcd_cantmovto");
$upd_almovconsdia->addColumn("mcd_saldant", "NUMERIC_TYPE", "POST", "mcd_saldant");
$upd_almovconsdia->addColumn("mcd_valunitant", "DOUBLE_TYPE", "POST", "mcd_valunitant");
$upd_almovconsdia->addColumn("mcd_tax", "DOUBLE_TYPE", "POST", "mcd_tax");
$upd_almovconsdia->addColumn("geusuario", "STRING_TYPE", "POST", "geusuario");
$upd_almovconsdia->addColumn("gefechaactua", "DATE_TYPE", "POST", "gefechaactua");
$upd_almovconsdia->setPrimaryKey("almovconsdia_id", "NUMERIC_TYPE", "GET", "almovconsdia_id");

// Make an instance of the transaction object
$del_almovconsdia = new tNG_multipleDelete($conn_oConnAlmacen);
$tNGs->addTransaction($del_almovconsdia);
// Register triggers
$del_almovconsdia->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_almovconsdia->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$del_almovconsdia->setTable("almovconsdia");
$del_almovconsdia->setPrimaryKey("almovconsdia_id", "NUMERIC_TYPE", "GET", "almovconsdia_id");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsalmovconsdia = $tNGs->getRecordset("almovconsdia");
$row_rsalmovconsdia = mysql_fetch_assoc($rsalmovconsdia);
$totalRows_rsalmovconsdia = mysql_num_rows($rsalmovconsdia);

// Require the MXI classes
require_once ('../includes/mxi/MXI.php');
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
  duplicate_buttons: true,
  show_as_grid: false,
  merge_down_value: false
}
</script>
<script type="text/javascript">
function popup(b_id){
                window.open("a_elementos_list_consumo.php","Popup","height=400,width=600,,scrollbars=yes,"+ 
                        "directories=yes,location=yes,menubar=yes," + 
                        "resizable=yes status=yes,history=yes top = 50 left = 100");
            }
function MM_findObj(n, d) { //v4.0
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && document.getElementById) x=document.getElementById(n); return x;
}

function tmt_compareField(f1,f2,rule,errorMsg){
	var myErr = "";
	if(eval("MM_findObj('"+f1+"').value"+rule+"MM_findObj('"+f2+"').value")){
		alert(unescape(errorMsg));myErr += 'errorMsg';}
	document.MM_returnValue = (myErr == "");
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
if (@$_GET['almovconsdia_id'] == "") {
?>
            <?php echo NXT_getResource("Insert_FH"); ?>
            <?php 
// else Conditional region1
} else { ?>
            <?php echo NXT_getResource("Update_FH"); ?>
            <?php } 
// endif Conditional region1
?>
          Almovconsdia </h1>
        <div class="KT_tngform">
          <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
            <?php $cnt1 = 0; ?>
            <?php do { ?>
              <?php $cnt1++; ?>
              <?php 
// Show IF Conditional region1 
if (@$totalRows_rsalmovconsdia > 1) {
?>
                <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
                <?php } 
// endif Conditional region1
?>
              <table cellpadding="2" cellspacing="0" class="KT_tngtable">
                <tr>
                  <td class="KT_th">&nbsp;</td>
                <td><input name="doclasedoc_id_fk_<?php echo $cnt1; ?>" type="hidden" id="doclasedoc_id_fk_<?php echo $cnt1; ?>" value="<?php echo $row_rsgedocumentos['doclasedoc_id']; ?>" size="7" />
                      <?php echo $tNGs->displayFieldHint("doclasedoc_id_fk");?> <?php echo $tNGs->displayFieldError("almovconsdia", "doclasedoc_id_fk", $cnt1); ?> <input name="mcdclasedoc_<?php echo $cnt1; ?>" type="hidden" id="mcdclasedoc_<?php echo $cnt1; ?>" value="<?php echo $row_rsgedocumentos['doclasedoc']; ?>" size="7" />
                      <?php echo $tNGs->displayFieldHint("mcdclasedoc");?> <?php echo $tNGs->displayFieldError("almovconsdia", "mcdclasedoc", $cnt1); ?> <input name="mcdnrodoc_<?php echo $cnt1; ?>" type="hidden" id="mcdnrodoc_<?php echo $cnt1; ?>" value="<?php echo $row_rsgedocumentos['do_nrodoc']; ?>" size="7" />
                      <?php echo $tNGs->displayFieldHint("mcdnrodoc");?> <?php echo $tNGs->displayFieldError("almovconsdia", "mcdnrodoc", $cnt1); ?> <input name="mcdfechadoc_<?php echo $cnt1; ?>" type="hidden" id="mcdfechadoc_<?php echo $cnt1; ?>" value="<?php echo $row_rsgedocumentos['do_fechadoc']; ?>" size="10" maxlength="22" />
                      <?php echo $tNGs->displayFieldHint("mcdfechadoc");?> <?php echo $tNGs->displayFieldError("almovconsdia", "mcdfechadoc", $cnt1); ?> <input name="mcdalmacen_<?php echo $cnt1; ?>" type="hidden" id="mcdalmacen_<?php echo $cnt1; ?>" value="<?php echo $row_rsgedocumentos['docodregion']; ?>" size="3" maxlength="3" />
                      <?php echo $tNGs->displayFieldHint("mcdalmacen");?> <?php echo $tNGs->displayFieldError("almovconsdia", "mcdalmacen", $cnt1); ?> <input type="hidden" name="mcdtipoestruc_<?php echo $cnt1; ?>" id="mcdtipoestruc_<?php echo $cnt1; ?>" value="V" size="2" maxlength="2" />
                      <?php echo $tNGs->displayFieldHint("mcdtipoestruc");?> <?php echo $tNGs->displayFieldError("almovconsdia", "mcdtipoestruc", $cnt1); ?> <input name="geusuario_<?php echo $cnt1; ?>" type="hidden" id="geusuario_<?php echo $cnt1; ?>" value="<?php echo $_SESSION['kt_login_user']; ?>" size="32" maxlength="50" />
                      <?php echo $tNGs->displayFieldHint("geusuario");?> <?php echo $tNGs->displayFieldError("almovconsdia", "geusuario", $cnt1); ?> <input type="hidden" name="gefechaactua_<?php echo $cnt1; ?>" id="gefechaactua_<?php echo $cnt1; ?>" value="<?php echo $fecha; ?>" size="10" maxlength="22" />
                      <?php echo $tNGs->displayFieldHint("gefechaactua");?> <?php echo $tNGs->displayFieldError("almovconsdia", "gefechaactua", $cnt1); ?> </td>
                </tr>
                
                <tr>
                  <td class="KT_th"><label for="mcdcuenta">CUENTA:</label></td>
                  <td><input name="mcdcuenta" type="text" id="mcdcuenta" value="<?php echo KT_escapeAttribute($row_rsalmovconsdia['mcdcuenta']); ?>" size="32" maxlength="50" readonly="true" />
                      <?php echo $tNGs->displayFieldHint("mcdcuenta");?> <?php echo $tNGs->displayFieldError("almovconsdia", "mcdcuenta", $cnt1); ?> <a href="#" onclick="popup();"><img src="325_add_cta.png" width="32" height="32" border="0" /></a></td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="mcdcodelem">CODIGO DEL ELEMENTO:</label></td>
                  <td><input name="mcdcodelem" type="text" id="mcdcodelem" value="<?php echo KT_escapeAttribute($row_rsalmovconsdia['mcdcodelem']); ?>" size="7" readonly="true" />
                      <?php echo $tNGs->displayFieldHint("mcdcodelem");?> <?php echo $tNGs->displayFieldError("almovconsdia", "mcdcodelem", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="mcd_cantmovto_<?php echo $cnt1; ?>">CANTIDAD:</label></td>
                  <td><input type="text" name="mcd_cantmovto_<?php echo $cnt1; ?>" id="mcd_cantmovto_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsalmovconsdia['mcd_cantmovto']); ?>" size="7" />
                      <?php echo $tNGs->displayFieldHint("mcd_cantmovto");?> <?php echo $tNGs->displayFieldError("almovconsdia", "mcd_cantmovto", $cnt1); ?></td>
                </tr>
                <tr>
                  <td class="KT_th">CONFIRMAR CANTIDAD:</td>
                  <td><input type="text" name="mcd_saldant_<?php echo $cnt1; ?>" id="mcd_saldant_<?php echo $cnt1; ?>" size="7" />
                    <?php echo $tNGs->displayFieldHint("mcd_saldant");?> <?php echo $tNGs->displayFieldError("almovconsdia", "mcd_saldant", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="mcd_valunitant_<?php echo $cnt1; ?>">VALOR UNITARIO:</label></td>
                  <td><input type="text" name="mcd_valunitant_<?php echo $cnt1; ?>" id="mcd_valunitant_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsalmovconsdia['mcd_valunitant']); ?>" size="7" />
                      <?php echo $tNGs->displayFieldHint("mcd_valunitant");?> <?php echo $tNGs->displayFieldError("almovconsdia", "mcd_valunitant", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="mcd_tax_<?php echo $cnt1; ?>">APLICAR IMPUESTO DEL :</label></td>
                  <td><select name="mcd_tax_<?php echo $cnt1; ?>" id="mcd_tax_<?php echo $cnt1; ?>">
                    <option value="" <?php if (!(strcmp("", $row_rsalmovconsdia['mcd_tax']))) {echo "selected=\"selected\"";} ?>><?php echo NXT_getResource("Select one..."); ?></option>
                    <?php
do {  
?><option value="<?php echo $row_rstax['tax_code']?>"<?php if (!(strcmp($row_rstax['tax_code'], $row_rsalmovconsdia['mcd_tax']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rstax['tax_name']?></option>
                    <?php
} while ($row_rstax = mysql_fetch_assoc($rstax));
  $rows = mysql_num_rows($rstax);
  if($rows > 0) {
      mysql_data_seek($rstax, 0);
	  $row_rstax = mysql_fetch_assoc($rstax);
  }
?>
                    </select>
                      <?php echo $tNGs->displayFieldError("almovconsdia", "mcd_tax", $cnt1); ?> </td>
                </tr>
              </table>
              <input type="hidden" name="kt_pk_almovconsdia_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rsalmovconsdia['kt_pk_almovconsdia']); ?>" />
              <?php } while ($row_rsalmovconsdia = mysql_fetch_assoc($rsalmovconsdia)); ?>
            <div class="KT_bottombuttons">
              <div>
                <?php 
      // Show IF Conditional region1
      if (@$_GET['almovconsdia_id'] == "") {
      ?>
                  <input name="KT_Insert1" type="submit" id="KT_Insert1" onclick="tmt_compareField('mcd_cantmovto_<?php echo $cnt1; ?>','mcd_saldant_<?php echo $cnt1; ?>','!=','La%20cantidad%20solicitada%20y%20la%20confirmaci�n%20no%20coinciden,%20por%20favor%20verifique%20e%20intente%20de%20nuevo');return document.MM_returnValue" value="<?php echo NXT_getResource("Insert_FB"); ?>" />
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
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<?php
  mxi_includes_start("../inc_foot.php");
  require(basename("../inc_foot.php"));
  mxi_includes_end();
?>
</body>
</html>
<?php
mysql_free_result($rstax);

mysql_free_result($rsgedocumentos);
?>