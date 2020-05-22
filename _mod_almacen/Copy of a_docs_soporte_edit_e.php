<?php require_once('../Connections/oConnAlmacen.php'); ?>
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

// Make a transaction dispatcher instance
$tNGs = new tNG_dispatcher("../");

// Make unified connection variable
$conn_oConnAlmacen = new KT_connection($oConnAlmacen, $database_oConnAlmacen);

// Start trigger
$masterValidation = new tNG_FormValidation();
$masterValidation->addField("alasiento_id_fk", true, "numeric", "", "", "", "");
$masterValidation->addField("doclasedoc", true, "numeric", "", "", "", "");
$masterValidation->addField("do_nrodoc", true, "numeric", "", "", "", "");
$masterValidation->addField("do_fechadoc", true, "date", "", "", "", "");
$masterValidation->addField("docodregion", true, "numeric", "", "", "", "");
$masterValidation->addField("do_detalle", true, "text", "", "", "", "");
$masterValidation->addField("do_tipodoc", true, "text", "", "", "", "");
$masterValidation->addField("doccnit", true, "text", "", "", "", "");
$masterValidation->addField("do_file", true, "text", "", "", "", "");
$masterValidation->addField("sys_user", true, "text", "", "", "", "");
$masterValidation->addField("sys_fecha", true, "date", "", "", "", "");
$tNGs->prepareValidation($masterValidation);
// End trigger

// Start trigger
$detailValidation = new tNG_FormValidation();
$detailValidation->addField("mdclasedoc", true, "numeric", "", "", "", "");
$detailValidation->addField("mdnrodoc", true, "numeric", "", "", "", "");
$detailValidation->addField("mdfechadoc", true, "date", "", "", "", "");
$detailValidation->addField("mdalmacen", true, "text", "", "", "", "");
$detailValidation->addField("mdnroasiento", true, "numeric", "", "", "", "");
$detailValidation->addField("md_tipomovto", true, "text", "", "", "", "");
$detailValidation->addField("mdconcepto", true, "numeric", "", "", "", "");
$detailValidation->addField("md_legalizado", true, "text", "", "", "", "");
$detailValidation->addField("mdtipoestruc", true, "text", "", "", "", "");
$detailValidation->addField("mddependencia", true, "text", "", "", "", "");
$detailValidation->addField("geusuario", true, "text", "", "", "", "");
$detailValidation->addField("gefechaactua", true, "date", "", "", "", "");
$tNGs->prepareValidation($detailValidation);
// End trigger

//start Trigger_LinkTransactions trigger
//remove this line if you want to edit the code by hand 
function Trigger_LinkTransactions(&$tNG) {
	global $ins_almovtodia;
  $linkObj = new tNG_LinkedTrans($tNG, $ins_almovtodia);
  $linkObj->setLink("doclasedoc_id_fk");
  return $linkObj->Execute();
}
//end Trigger_LinkTransactions trigger

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
$query_rsclase = "SELECT * FROM geclasedocto WHERE cd_ctrl = 2";
$rsclase = mysql_query($query_rsclase, $oConnAlmacen) or die(mysql_error());
$row_rsclase = mysql_fetch_assoc($rsclase);
$totalRows_rsclase = mysql_num_rows($rsclase);

mysql_select_db($database_oConnAlmacen, $oConnAlmacen);
$query_rstipodoc = "SELECT * FROM global_type_doc";
$rstipodoc = mysql_query($query_rstipodoc, $oConnAlmacen) or die(mysql_error());
$row_rstipodoc = mysql_fetch_assoc($rstipodoc);
$totalRows_rstipodoc = mysql_num_rows($rstipodoc);

mysql_select_db($database_oConnAlmacen, $oConnAlmacen);
$query_rstipomov = "SELECT * FROM global_type_mov";
$rstipomov = mysql_query($query_rstipomov, $oConnAlmacen) or die(mysql_error());
$row_rstipomov = mysql_fetch_assoc($rstipomov);
$totalRows_rstipomov = mysql_num_rows($rstipomov);

mysql_select_db($database_oConnAlmacen, $oConnAlmacen);
$query_rsconceptos = "SELECT * FROM alconceptos WHERE co_ctrl = 1";
$rsconceptos = mysql_query($query_rsconceptos, $oConnAlmacen) or die(mysql_error());
$row_rsconceptos = mysql_fetch_assoc($rsconceptos);
$totalRows_rsconceptos = mysql_num_rows($rsconceptos);

mysql_select_db($database_oConnAlmacen, $oConnAlmacen);
$query_rsdependencias = "SELECT * FROM gedependencias ORDER BY de_nomdep ASC";
$rsdependencias = mysql_query($query_rsdependencias, $oConnAlmacen) or die(mysql_error());
$row_rsdependencias = mysql_fetch_assoc($rsdependencias);
$totalRows_rsdependencias = mysql_num_rows($rsdependencias);

$colname_rsinfoasiento = "-1";
if (isset($_GET['as_id'])) {
  $colname_rsinfoasiento = $_GET['as_id'];
}
mysql_select_db($database_oConnAlmacen, $oConnAlmacen);
$query_rsinfoasiento = sprintf("SELECT * FROM alasientos WHERE as_id = %s", GetSQLValueString($colname_rsinfoasiento, "int"));
$rsinfoasiento = mysql_query($query_rsinfoasiento, $oConnAlmacen) or die(mysql_error());
$row_rsinfoasiento = mysql_fetch_assoc($rsinfoasiento);
$totalRows_rsinfoasiento = mysql_num_rows($rsinfoasiento);

$colname_rsconsecutivo = "-1";
if (isset($_GET['as_id'])) {
  $colname_rsconsecutivo = $_GET['as_id'];
}
mysql_select_db($database_oConnAlmacen, $oConnAlmacen);
$query_rsconsecutivo = sprintf("SELECT * FROM q_consecut_gedoc WHERE alasiento_id_fk = %s", GetSQLValueString($colname_rsconsecutivo, "int"));
$rsconsecutivo = mysql_query($query_rsconsecutivo, $oConnAlmacen) or die(mysql_error());
$row_rsconsecutivo = mysql_fetch_assoc($rsconsecutivo);
$totalRows_rsconsecutivo = mysql_num_rows($rsconsecutivo);

// Make an insert transaction instance
$ins_gedocumentos = new tNG_insert($conn_oConnAlmacen);
$tNGs->addTransaction($ins_gedocumentos);
// Register triggers
$ins_gedocumentos->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_gedocumentos->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $masterValidation);
$ins_gedocumentos->registerTrigger("END", "Trigger_Default_Redirect", 99, "a_docs_soporte_list_e.php?as_id={GET.as_id}&anio_id={GET.anio_id}&hash_id={GET.hash_id}");
$ins_gedocumentos->registerTrigger("AFTER", "Trigger_LinkTransactions", 98);
$ins_gedocumentos->registerTrigger("ERROR", "Trigger_LinkTransactions", 98);
// Add columns
$ins_gedocumentos->setTable("gedocumentos");
$ins_gedocumentos->addColumn("alasiento_id_fk", "NUMERIC_TYPE", "POST", "alasiento_id_fk");
$ins_gedocumentos->addColumn("doclasedoc", "NUMERIC_TYPE", "POST", "doclasedoc");
$ins_gedocumentos->addColumn("do_nrodoc", "NUMERIC_TYPE", "POST", "do_nrodoc");
$ins_gedocumentos->addColumn("do_fechadoc", "DATE_TYPE", "POST", "do_fechadoc");
$ins_gedocumentos->addColumn("docodregion", "NUMERIC_TYPE", "POST", "docodregion");
$ins_gedocumentos->addColumn("do_detalle", "STRING_TYPE", "POST", "do_detalle");
$ins_gedocumentos->addColumn("do_tipodoc", "STRING_TYPE", "POST", "do_tipodoc");
$ins_gedocumentos->addColumn("doccnit", "STRING_TYPE", "POST", "doccnit");
$ins_gedocumentos->addColumn("do_file", "STRING_TYPE", "POST", "do_file");
$ins_gedocumentos->addColumn("sys_user", "STRING_TYPE", "POST", "sys_user");
$ins_gedocumentos->addColumn("sys_fecha", "DATE_TYPE", "POST", "sys_fecha");
$ins_gedocumentos->setPrimaryKey("doclasedoc_id", "NUMERIC_TYPE");

// Make an insert transaction instance
$ins_almovtodia = new tNG_insert($conn_oConnAlmacen);
$tNGs->addTransaction($ins_almovtodia);
// Register triggers
$ins_almovtodia->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "VALUE", null);
$ins_almovtodia->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $detailValidation);
// Add columns
$ins_almovtodia->setTable("almovtodia");
$ins_almovtodia->addColumn("mdclasedoc", "NUMERIC_TYPE", "POST", "mdclasedoc");
$ins_almovtodia->addColumn("mdnrodoc", "NUMERIC_TYPE", "POST", "mdnrodoc");
$ins_almovtodia->addColumn("mdfechadoc", "DATE_TYPE", "POST", "mdfechadoc");
$ins_almovtodia->addColumn("mdalmacen", "STRING_TYPE", "POST", "mdalmacen");
$ins_almovtodia->addColumn("mdnroasiento", "NUMERIC_TYPE", "POST", "mdnroasiento");
$ins_almovtodia->addColumn("md_tipomovto", "STRING_TYPE", "POST", "md_tipomovto");
$ins_almovtodia->addColumn("mdconcepto", "NUMERIC_TYPE", "POST", "mdconcepto");
$ins_almovtodia->addColumn("md_legalizado", "STRING_TYPE", "POST", "md_legalizado");
$ins_almovtodia->addColumn("mdtipoestruc", "STRING_TYPE", "POST", "mdtipoestruc");
$ins_almovtodia->addColumn("mddependencia", "STRING_TYPE", "POST", "mddependencia");
$ins_almovtodia->addColumn("geusuario", "STRING_TYPE", "POST", "geusuario");
$ins_almovtodia->addColumn("gefechaactua", "DATE_TYPE", "POST", "gefechaactua");
$ins_almovtodia->addColumn("doclasedoc_id_fk", "NUMERIC_TYPE", "VALUE", "");
$ins_almovtodia->setPrimaryKey("almovtodia_id", "NUMERIC_TYPE");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsgedocumentos = $tNGs->getRecordset("gedocumentos");
$row_rsgedocumentos = mysql_fetch_assoc($rsgedocumentos);
$totalRows_rsgedocumentos = mysql_num_rows($rsgedocumentos);

// Get the transaction recordset
$rsalmovtodia = $tNGs->getRecordset("almovtodia");
$row_rsalmovtodia = mysql_fetch_assoc($rsalmovtodia);
$totalRows_rsalmovtodia = mysql_num_rows($rsalmovtodia);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:wdg="http://ns.adobe.com/addt">
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
		$( "#do_fechadoc" ).datepicker({
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
<script type="text/javascript" src="../includes/common/js/sigslot_core.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="../includes/wdg/classes/JSRecordset.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/N1DependentField.js"></script>
<?php
//begin JSRecordset
$jsObject_rsclase = new WDG_JsRecordset("rsclase");
echo $jsObject_rsclase->getOutput();
//end JSRecordset
?>
<script type="text/javascript">
function popup(b_id){
                window.open("a_funcionarios_list.php","Popup","height=500,width=800,,scrollbars=yes,"+ 
                        "directories=yes,location=yes,menubar=yes," + 
                         "resizable=yes status=yes,history=yes top = 50 left = 100");
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
<form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
  <table cellpadding="2" cellspacing="0" class="KT_tngtable">
    <tr>
      <td class="KT_th">&nbsp;</td>
      <td><input name="alasiento_id_fk" type="hidden" id="alasiento_id_fk" value="<?php echo $_GET['as_id']; ?>" />
          <?php echo $tNGs->displayFieldHint("alasiento_id_fk");?> <?php echo $tNGs->displayFieldError("gedocumentos", "alasiento_id_fk"); ?> <input type="hidden" name="docodregion" id="docodregion" value="<?php echo $row_rsinfoasiento['ascodalmacen']; ?>" size="32" />
          <?php echo $tNGs->displayFieldHint("docodregion");?> <?php echo $tNGs->displayFieldError("gedocumentos", "docodregion"); ?> <input type="hidden" name="do_file" id="do_file" value="0" size="32" />
          <?php echo $tNGs->displayFieldHint("do_file");?> <?php echo $tNGs->displayFieldError("gedocumentos", "do_file"); ?>
          <input type="hidden" name="sys_user" id="sys_user" value="<?php echo $_SESSION['kt_login_user']; ?>" size="32" />
          <?php echo $tNGs->displayFieldHint("sys_user");?> <?php echo $tNGs->displayFieldError("gedocumentos", "sys_user"); ?>
          <input type="hidden" name="sys_fecha" id="sys_fecha" value="<?php echo $fechac; ?>" size="32" />
          <?php echo $tNGs->displayFieldHint("sys_fecha");?> <?php echo $tNGs->displayFieldError("gedocumentos", "sys_fecha"); ?> <input name="mdclasedoc" type="hidden" id="mdclasedoc" value="<?php echo KT_escapeAttribute($row_rsalmovtodia['mdclasedoc']); ?>" size="32" wdg:subtype="N1DependentField" wdg:type="widget" wdg:recordset="rsclase" wdg:valuefield="cd_clasedoc" wdg:pkey="cd_clasedoc" wdg:triggerobject="doclasedoc" />
          <?php echo $tNGs->displayFieldHint("mdclasedoc");?> <?php echo $tNGs->displayFieldError("almovtodia", "mdclasedoc"); ?>
          <input type="hidden" name="mdnrodoc" id="mdnrodoc" value="<?php echo $row_rsconsecutivo['qtyconsecutivo'] + 1; ?>" size="32" />
          <?php echo $tNGs->displayFieldHint("mdnrodoc");?> <?php echo $tNGs->displayFieldError("almovtodia", "mdnrodoc"); ?>
          <input type="hidden" name="mdfechadoc" id="mdfechadoc" value="<?php echo $row_rsinfoasiento['as_fechaasiento']; ?>" size="32" />
          <?php echo $tNGs->displayFieldHint("mdfechadoc");?> <?php echo $tNGs->displayFieldError("almovtodia", "mdfechadoc"); ?>
          <input type="hidden" name="mdalmacen" id="mdalmacen" value="<?php echo $row_rsinfoasiento['ascodalmacen']; ?>" size="32" />
          <?php echo $tNGs->displayFieldHint("mdalmacen");?> <?php echo $tNGs->displayFieldError("almovtodia", "mdalmacen"); ?>
          <input type="hidden" name="mdnroasiento" id="mdnroasiento" value="<?php echo $row_rsinfoasiento['as_nroasiento']; ?>" size="32" />
          <?php echo $tNGs->displayFieldHint("mdnroasiento");?> <?php echo $tNGs->displayFieldError("almovtodia", "mdnroasiento"); ?> </td>
    </tr>
    <tr>
      <td class="KT_th"><label for="doclasedoc">Clase:</label></td>
      <td><select name="doclasedoc" id="doclasedoc">
        <?php 
do {  
?>
        <option value="<?php echo $row_rsclase['cd_clasedoc']?>"<?php if (!(strcmp($row_rsclase['cd_clasedoc'], $row_rsgedocumentos['doclasedoc']))) {echo "SELECTED";} ?>><?php echo $row_rsclase['cd_nombredoc']?></option>
        <?php
} while ($row_rsclase = mysql_fetch_assoc($rsclase));
  $rows = mysql_num_rows($rsclase);
  if($rows > 0) {
      mysql_data_seek($rsclase, 0);
	  $row_rsclase = mysql_fetch_assoc($rsclase);
  }
?>
      </select>
          <?php echo $tNGs->displayFieldError("gedocumentos", "doclasedoc"); ?> </td>
    </tr>
    <tr>
      <td class="KT_th"><label for="do_nrodoc">N�mero:</label></td>
      <td><input type="text" name="do_nrodoc" id="do_nrodoc" value="<?php echo $row_rsconsecutivo['qtyconsecutivo'] + 1; ?>" size="32" />
          <?php echo $tNGs->displayFieldHint("do_nrodoc");?> <?php echo $tNGs->displayFieldError("gedocumentos", "do_nrodoc"); ?> </td>
    </tr>
    <tr>
      <td class="KT_th"><label for="do_fechadoc">Fecha:</label></td>
      <td><input name="do_fechadoc" type="text" id="do_fechadoc" value="<?php echo $row_rsinfoasiento['as_fechaasiento']; ?>" size="32" />
          <?php echo $tNGs->displayFieldHint("do_fechadoc");?> <?php echo $tNGs->displayFieldError("gedocumentos", "do_fechadoc"); ?> </td>
    </tr>
    <tr>
      <td class="KT_th"><label for="do_detalle">Detalle:</label></td>
      <td><textarea name="do_detalle" id="do_detalle" cols="50" rows="3"><?php echo KT_escapeAttribute($row_rsgedocumentos['do_detalle']); ?>ASIGNACION BIENES</textarea>
          <?php echo $tNGs->displayFieldHint("do_detalle");?> <?php echo $tNGs->displayFieldError("gedocumentos", "do_detalle"); ?> </td>
    </tr>
    <tr>
      <td class="KT_th"><label for="do_tipodoc">Tipo documento:</label></td>
      <td><select name="do_tipodoc" id="do_tipodoc">
        <?php 
do {  
?>
        <option value="<?php echo $row_rstipodoc['contractor_type_id']?>"<?php if (!(strcmp($row_rstipodoc['contractor_type_id'], $row_rsgedocumentos['do_tipodoc']))) {echo "SELECTED";} ?>><?php echo $row_rstipodoc['contractor_type']?></option>
        <?php
} while ($row_rstipodoc = mysql_fetch_assoc($rstipodoc));
  $rows = mysql_num_rows($rstipodoc);
  if($rows > 0) {
      mysql_data_seek($rstipodoc, 0);
	  $row_rstipodoc = mysql_fetch_assoc($rstipodoc);
  }
?>
      </select>
          <?php echo $tNGs->displayFieldError("gedocumentos", "do_tipodoc"); ?> </td>
    </tr>
    <tr>
      <td class="KT_th"><label for="doccnit">N�mero documento:</label></td>
      <td><input name="doccnit" type="text" id="doccnit" value="<?php echo KT_escapeAttribute($row_rsgedocumentos['doccnit']); ?>" size="32" readonly="true" />
          <?php echo $tNGs->displayFieldHint("doccnit");?> <?php echo $tNGs->displayFieldError("gedocumentos", "doccnit"); ?> <a href="#" onclick="popup();"><img src="325_add_cta.png" width="32" height="32" border="0" /></a></td>
    </tr>
    <tr class="KT_buttons">
      <td colspan="2"><hr />      </td>
    </tr>
    <tr>
      <td class="KT_th"><label for="md_tipomovto">Tipo de movimiento:</label></td>
      <td><select name="md_tipomovto" id="md_tipomovto">
        <?php 
do {  
?>
        <option value="<?php echo $row_rstipomov['typemov_code']?>"<?php if (!(strcmp($row_rstipomov['typemov_code'], $row_rsalmovtodia['md_tipomovto']))) {echo "SELECTED";} ?>><?php echo $row_rstipomov['typemov_name']?></option>
        <?php
} while ($row_rstipomov = mysql_fetch_assoc($rstipomov));
  $rows = mysql_num_rows($rstipomov);
  if($rows > 0) {
      mysql_data_seek($rstipomov, 0);
	  $row_rstipomov = mysql_fetch_assoc($rstipomov);
  }
?>
      </select>
          <?php echo $tNGs->displayFieldError("almovtodia", "md_tipomovto"); ?> </td>
    </tr>
    <tr>
      <td class="KT_th"><label for="mdconcepto">Concepto:</label></td>
      <td><select name="mdconcepto" id="mdconcepto">
        <?php 
do {  
?>
        <option value="<?php echo $row_rsconceptos['co_codconcepto']?>"<?php if (!(strcmp($row_rsconceptos['co_codconcepto'], $row_rsalmovtodia['mdconcepto']))) {echo "SELECTED";} ?>><?php echo $row_rsconceptos['co_nomconcepto']?></option>
        <?php
} while ($row_rsconceptos = mysql_fetch_assoc($rsconceptos));
  $rows = mysql_num_rows($rsconceptos);
  if($rows > 0) {
      mysql_data_seek($rsconceptos, 0);
	  $row_rsconceptos = mysql_fetch_assoc($rsconceptos);
  }
?>
      </select>
          <?php echo $tNGs->displayFieldError("almovtodia", "mdconcepto"); ?> </td>
    </tr>
    <tr>
      <td class="KT_th"><label for="mddependencia">Dependencia:</label></td>
      <td><select name="mddependencia" id="mddependencia">
        <?php 
do {  
?>
        <option value="<?php echo $row_rsdependencias['de_coddep']?>"<?php if (!(strcmp($row_rsdependencias['de_coddep'], $row_rsalmovtodia['mddependencia']))) {echo "SELECTED";} ?>><?php echo $row_rsdependencias['de_nomdep']?></option>
        <?php
} while ($row_rsdependencias = mysql_fetch_assoc($rsdependencias));
  $rows = mysql_num_rows($rsdependencias);
  if($rows > 0) {
      mysql_data_seek($rsdependencias, 0);
	  $row_rsdependencias = mysql_fetch_assoc($rsdependencias);
  }
?>
      </select>
          <?php echo $tNGs->displayFieldError("almovtodia", "mddependencia"); ?> </td>
    </tr>
    <tr>
      <td class="KT_th"></td>
      <td><input type="hidden" name="geusuario" id="geusuario" value="<?php echo $_SESSION['kt_login_user']; ?>" size="32" />
          <?php echo $tNGs->displayFieldHint("geusuario");?> <?php echo $tNGs->displayFieldError("almovtodia", "geusuario"); ?> <input type="hidden" name="gefechaactua" id="gefechaactua" value="<?php echo $fechac; ?>" size="32" />
          <?php echo $tNGs->displayFieldHint("gefechaactua");?> <?php echo $tNGs->displayFieldError("almovtodia", "gefechaactua"); ?> <input type="hidden" name="md_legalizado" id="md_legalizado" value="N" size="32" />
          <?php echo $tNGs->displayFieldHint("md_legalizado");?> <?php echo $tNGs->displayFieldError("almovtodia", "md_legalizado"); ?>
          <input type="hidden" name="mdtipoestruc" id="mdtipoestruc" value="V" size="32" />
          <?php echo $tNGs->displayFieldHint("mdtipoestruc");?> <?php echo $tNGs->displayFieldError("almovtodia", "mdtipoestruc"); ?> </td>
    </tr>
    
    <tr class="KT_buttons">
      <td colspan="2"><input type="submit" name="KT_Insert1" id="KT_Insert1" value="Grabar" />      </td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
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
mysql_free_result($rsclase);

mysql_free_result($rstipodoc);

mysql_free_result($rstipomov);

mysql_free_result($rsconceptos);

mysql_free_result($rsdependencias);

mysql_free_result($rsinfoasiento);

mysql_free_result($rsconsecutivo);
?>