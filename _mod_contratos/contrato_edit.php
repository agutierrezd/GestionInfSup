<?php require_once('../Connections/oConnContratos.php'); ?>
<?php
//MX Widgets3 include
require_once('../includes/wdg/WDG.php');
?>
<?php require_once('../Connections/oConnContratos.php'); ?>
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
$formValidation->addField("cont_nit_contra_ta", true, "text", "", "", "", "");
$formValidation->addField("cont_codrubro", true, "text", "", "", "", "Seleccionar Rubro.");
$formValidation->addField("prenumero", true, "text", "", "", "", "");
$formValidation->addField("cont_tipo", true, "text", "", "", "", "");
$formValidation->addField("numregistro", true, "text", "", "", "", "");
$formValidation->addField("pre_contnumero", true, "text", "", "", "", "Tipo");
$formValidation->addField("contnumero", true, "text", "", "", "", "N�mero de contrato");
$formValidation->addField("cont_ano", true, "date", "", "", "", "Periodo");
$formValidation->addField("cont_tipopre", true, "text", "", "", "", "");
$formValidation->addField("cont_fase", true, "text", "", "", "", "");
$formValidation->addField("cont_fechaapertura", true, "date", "", "", "", "");
$formValidation->addField("cont_valorinicial", true, "double", "", "", "", "");
$formValidation->addField("cont_modalidad", true, "text", "", "", "", "");
$formValidation->addField("cont_tipoproceso", true, "text", "", "", "", "");
$formValidation->addField("cont_formapago", true, "text", "", "", "", "");
$formValidation->addField("cont_fechasistema", true, "date", "", "", "", "");
$formValidation->addField("cont_valormensual", true, "double", "", "", "", "Ingrese el valor del pago mensual.");
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

$colname_rsprenum = "-1";
if (isset($_SESSION['kt_usr_dependencia'])) {
  $colname_rsprenum = $_SESSION['kt_usr_dependencia'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rsprenum = sprintf("SELECT * FROM contrato_pre ORDER BY codigo ASC", GetSQLValueString($colname_rsprenum, "text"));
$rsprenum = mysql_query($query_rsprenum, $oConnContratos) or die(mysql_error());
$row_rsprenum = mysql_fetch_assoc($rsprenum);
$totalRows_rsprenum = mysql_num_rows($rsprenum);

mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rstipo = "SELECT * FROM contrato_tipo";
$rstipo = mysql_query($query_rstipo, $oConnContratos) or die(mysql_error());
$row_rstipo = mysql_fetch_assoc($rstipo);
$totalRows_rstipo = mysql_num_rows($rstipo);

mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rsfase = "SELECT * FROM contrato_fase WHERE cont_fase = '1'";
$rsfase = mysql_query($query_rsfase, $oConnContratos) or die(mysql_error());
$row_rsfase = mysql_fetch_assoc($rsfase);
$totalRows_rsfase = mysql_num_rows($rsfase);

mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rsmodalidad = "SELECT * FROM contrato_modalidad ORDER BY des_mod_proceso ASC";
$rsmodalidad = mysql_query($query_rsmodalidad, $oConnContratos) or die(mysql_error());
$row_rsmodalidad = mysql_fetch_assoc($rsmodalidad);
$totalRows_rsmodalidad = mysql_num_rows($rsmodalidad);

mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rstipocontrato = "SELECT * FROM tipo_contrato ORDER BY nom_tipocontrato ASC";
$rstipocontrato = mysql_query($query_rstipocontrato, $oConnContratos) or die(mysql_error());
$row_rstipocontrato = mysql_fetch_assoc($rstipocontrato);
$totalRows_rstipocontrato = mysql_num_rows($rstipocontrato);

mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rsformapago = "SELECT * FROM contrato_forma_pago ORDER BY nombre ASC";
$rsformapago = mysql_query($query_rsformapago, $oConnContratos) or die(mysql_error());
$row_rsformapago = mysql_fetch_assoc($rsformapago);
$totalRows_rsformapago = mysql_num_rows($rsformapago);

mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rsrubros = "SELECT DISTINCT(RUBRO), DESCRIPCION FROM ejecucionpresupuestal_2017 ORDER BY RUBRO ASC";
$rsrubros = mysql_query($query_rsrubros, $oConnContratos) or die(mysql_error());
$row_rsrubros = mysql_fetch_assoc($rsrubros);
$totalRows_rsrubros = mysql_num_rows($rsrubros);

mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rsuej = "SELECT * FROM contrato_tipo_unidad";
$rsuej = mysql_query($query_rsuej, $oConnContratos) or die(mysql_error());
$row_rsuej = mysql_fetch_assoc($rsuej);
$totalRows_rsuej = mysql_num_rows($rsuej);

$colname_RsInfoCont = "-1";
if (isset($_GET['id_cont'])) {
  $colname_RsInfoCont = $_GET['id_cont'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_RsInfoCont = sprintf("SELECT * FROM contrato WHERE id_cont = %s", GetSQLValueString($colname_RsInfoCont, "int"));
$RsInfoCont = mysql_query($query_RsInfoCont, $oConnContratos) or die(mysql_error());
$row_RsInfoCont = mysql_fetch_assoc($RsInfoCont);
$totalRows_RsInfoCont = mysql_num_rows($RsInfoCont);

// Make an insert transaction instance
$ins_contrato = new tNG_multipleInsert($conn_oConnContratos);
$tNGs->addTransaction($ins_contrato);
// Register triggers
$ins_contrato->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_contrato->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_contrato->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$ins_contrato->setTable("contrato");
$ins_contrato->addColumn("cont_nit_contra_ta", "STRING_TYPE", "POST", "cont_nit_contra_ta");
$ins_contrato->addColumn("cont_codrubro", "STRING_TYPE", "POST", "cont_codrubro");
$ins_contrato->addColumn("prenumero", "STRING_TYPE", "POST", "prenumero");
$ins_contrato->addColumn("cont_tipo", "STRING_TYPE", "POST", "cont_tipo");
$ins_contrato->addColumn("numregistro", "STRING_TYPE", "POST", "numregistro");
$ins_contrato->addColumn("pre_contnumero", "STRING_TYPE", "POST", "pre_contnumero");
$ins_contrato->addColumn("contnumero", "STRING_TYPE", "POST", "contnumero");
$ins_contrato->addColumn("cont_ano", "DATE_TYPE", "POST", "cont_ano");
$ins_contrato->addColumn("cont_tipopre", "STRING_TYPE", "POST", "cont_tipopre");
$ins_contrato->addColumn("cont_fase", "STRING_TYPE", "POST", "cont_fase");
$ins_contrato->addColumn("cont_fechaapertura", "DATE_TYPE", "POST", "cont_fechaapertura");
$ins_contrato->addColumn("cont_valorinicial", "DOUBLE_TYPE", "POST", "cont_valorinicial");
$ins_contrato->addColumn("cont_modalidad", "STRING_TYPE", "POST", "cont_modalidad");
$ins_contrato->addColumn("cont_tipoproceso", "STRING_TYPE", "POST", "cont_tipoproceso");
$ins_contrato->addColumn("cont_formapago", "STRING_TYPE", "POST", "cont_formapago");
$ins_contrato->addColumn("cont_fechasistema", "DATE_TYPE", "POST", "cont_fechasistema");
$ins_contrato->setPrimaryKey("id_cont", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_contrato = new tNG_multipleUpdate($conn_oConnContratos);
$tNGs->addTransaction($upd_contrato);
// Register triggers
$upd_contrato->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_contrato->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_contrato->registerTrigger("END", "Trigger_Default_Redirect", 99, "ok.php");
// Add columns
$upd_contrato->setTable("contrato");
$upd_contrato->addColumn("cont_nit_contra_ta", "STRING_TYPE", "POST", "cont_nit_contra_ta");
$upd_contrato->addColumn("cont_valormensual", "DOUBLE_TYPE", "POST", "vrmensual");
$upd_contrato->addColumn("cont_codrubro", "STRING_TYPE", "POST", "cont_codrubro");
$upd_contrato->addColumn("prenumero", "STRING_TYPE", "POST", "prenumero");
$upd_contrato->addColumn("cont_tipo", "STRING_TYPE", "POST", "cont_tipo");
$upd_contrato->addColumn("numregistro", "STRING_TYPE", "POST", "numregistro");
$upd_contrato->addColumn("pre_contnumero", "STRING_TYPE", "POST", "pre_contnumero");
$upd_contrato->addColumn("contnumero", "STRING_TYPE", "POST", "contnumero");
$upd_contrato->addColumn("cont_ano", "DATE_TYPE", "POST", "cont_ano");
$upd_contrato->addColumn("cont_tipopre", "STRING_TYPE", "POST", "cont_tipopre");
$upd_contrato->addColumn("cont_fase", "STRING_TYPE", "POST", "cont_fase");
$upd_contrato->addColumn("cont_fechaapertura", "DATE_TYPE", "POST", "cont_fechaapertura");
$upd_contrato->addColumn("cont_valorinicial", "DOUBLE_TYPE", "POST", "cont_valorinicial");
$upd_contrato->addColumn("cont_modalidad", "STRING_TYPE", "POST", "cont_modalidad");
$upd_contrato->addColumn("cont_tipoproceso", "STRING_TYPE", "POST", "cont_tipoproceso");
$upd_contrato->addColumn("cont_formapago", "STRING_TYPE", "POST", "cont_formapago");
$upd_contrato->addColumn("cont_fechasistema", "DATE_TYPE", "POST", "cont_fechasistema");
$upd_contrato->setPrimaryKey("id_cont", "NUMERIC_TYPE", "GET", "id_cont");

// Make an instance of the transaction object
$del_contrato = new tNG_multipleDelete($conn_oConnContratos);
$tNGs->addTransaction($del_contrato);
// Register triggers
$del_contrato->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_contrato->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$del_contrato->setTable("contrato");
$del_contrato->setPrimaryKey("id_cont", "NUMERIC_TYPE", "GET", "id_cont");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rscontrato = $tNGs->getRecordset("contrato");
$row_rscontrato = mysql_fetch_assoc($rscontrato);
$totalRows_rscontrato = mysql_num_rows($rscontrato);
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
  show_as_grid: false,
  merge_down_value: true
}
</script>
<script type="text/javascript">
function popup(b_id){
                window.open("contratistas_list.php","Popup","height=400,width=600,,scrollbars=yes,"+ 
                        "directories=yes,location=yes,menubar=yes," + 
                         "resizable=yes status=yes,history=yes top = 50 left = 100");
            }
 
</script>
<link rel="stylesheet" href="../_jquery/_desktop/_app/themes/south-street/jquery.ui.all.css">
	<script src="../_jquery/_desktop/_app/jquery-1.9.1.js"></script>
	<script src="../_jquery/_desktop/_app/ui/jquery.ui.core.js"></script>
	<script src="../_jquery/_desktop/_app/ui/jquery.ui.widget.js"></script>
	<script src="../_jquery/_desktop/_app/ui/jquery.ui.position.js"></script>
	<script src="../_jquery/_desktop/_app/ui/jquery.ui.menu.js"></script>
	<script src="../_jquery/_desktop/_app/ui/jquery.ui.autocomplete.js"></script>
    <script src="../_jquery/_desktop/_app/ui/jquery.ui.datepicker.js"></script>
   	<link rel="stylesheet" href="../_jquery/_desktop/_app/_modules/demos.css">
	<script>
	$(function() {
		var availableTags = [
		<?php do { ?>
			"<?php echo $row_rsrubros['RUBRO']; ?>",
	    <?php } while ($row_rsrubros = mysql_fetch_assoc($rsrubros)); ?>
			".."
		];
		function split( val ) {
			return val.split( /,\s*/ );
		}
		function extractLast( term ) {
			return split( term ).pop();
		}

		$( "#cont_codrubro" )
			// don't navigate away from the field on tab when selecting an item
			.bind( "keydown", function( event ) {
				if ( event.keyCode === $.ui.keyCode.TAB &&
						$( this ).data( "ui-autocomplete" ).menu.active ) {
					event.preventDefault();
				}
			})
			.autocomplete({
				minLength: 3,
				source: function( request, response ) {
					// delegate back to autocomplete, but extract the last term
					response( $.ui.autocomplete.filter(
						availableTags, extractLast( request.term ) ) );
				},
				focus: function() {
					// prevent value inserted on focus
					return false;
				},
				select: function( event, ui ) {
					var terms = split( this.value );
					// remove the current input
					terms.pop();
					// add the selected item
					terms.push( ui.item.value );
					// add placeholder to get the comma-and-space at the end
					terms.push( "" );
					this.value = terms.join( ", " );
					return false;
				}
			});
		$( "#datepicker" ).datepicker({
		changeMonth: true,
		changeYear: true
		});
	});
	</script>
	<script type="text/javascript" src="../includes/common/js/sigslot_core.js"></script>
	<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js"></script>
	<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js.php"></script>
	<script type="text/javascript" src="../includes/wdg/classes/JSRecordset.js"></script>
	<script type="text/javascript" src="../includes/wdg/classes/CommaCheckboxes.js"></script>
	<?php
//begin JSRecordset
$jsObject_rsrubros = new WDG_JsRecordset("rsrubros");
echo $jsObject_rsrubros->getOutput();
//end JSRecordset
?>
</head>

<body>
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
if (@$_GET['id_cont'] == "") {
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
if (@$totalRows_rscontrato > 1) {
?>
                <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
                <?php } 
// endif Conditional region1
?>
              <table cellpadding="2" cellspacing="0" class="KT_tngtable">
                <tr>
                  <td width="31%" class="KT_th"><label for="cont_nit_contra_ta">Contratista:</label></td>
                  <td width="69%"><input name="cont_nit_contra_ta" type="text" id="cont_nit_contra_ta" value="<?php echo KT_escapeAttribute($row_rscontrato['cont_nit_contra_ta']); ?>" size="15" maxlength="15" readonly="true" />
                      <?php echo $tNGs->displayFieldHint("cont_nit_contra_ta");?> <?php echo $tNGs->displayFieldError("contrato", "cont_nit_contra_ta", $cnt1); ?> <a href="#" onclick="popup();" title="Vincular registro"><img src="../img_mcit/user_add_322.png" width="32" height="32" border="0" />
                      <input type="hidden" name="cont_fechasistema_<?php echo $cnt1; ?>" id="cont_fechasistema_<?php echo $cnt1; ?>" value="<?php echo $fecha; ?>" size="10" maxlength="22" />
                      <?php echo $tNGs->displayFieldHint("cont_fechasistema");?> <?php echo $tNGs->displayFieldError("contrato", "cont_fechasistema", $cnt1); ?> </a></td>
                </tr>

                <tr>
                  <td class="KT_th"><label for="label">Rubro(s):</label></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="2" align="center"><input name="cont_codrubro" id="cont_codrubro" value="<?php echo KT_escapeAttribute($row_rscontrato['cont_codrubro']); ?>" size="32" wdg:recordset="rsrubros" wdg:subtype="CommaCheckboxes" wdg:type="widget" wdg:displayfield="RUBRO" wdg:valuefield="RUBRO" wdg:groupby="7" />
                  <?php echo $tNGs->displayFieldHint("cont_codrubro");?> <?php echo $tNGs->displayFieldError("contrato", "cont_codrubro", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="prenumero_<?php echo $cnt1; ?>">Número CDP:</label></td>
                  <td><input type="text" name="prenumero_<?php echo $cnt1; ?>" id="prenumero_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscontrato['prenumero']); ?>" size="32" maxlength="80" />
                      <?php echo $tNGs->displayFieldHint("prenumero");?> <?php echo $tNGs->displayFieldError("contrato", "prenumero", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="cont_tipo_<?php echo $cnt1; ?>">Tipo CDP:</label></td>
                  <td><select name="cont_tipo_<?php echo $cnt1; ?>" id="cont_tipo_<?php echo $cnt1; ?>">
                      <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                      <?php 
do {  
?>
                      <option value="<?php echo $row_rstipo['codigo']?>"<?php if (!(strcmp($row_rstipo['codigo'], $row_rscontrato['cont_tipo']))) {echo "SELECTED";} ?>><?php echo $row_rstipo['nombre']?></option>
                      <?php
} while ($row_rstipo = mysql_fetch_assoc($rstipo));
  $rows = mysql_num_rows($rstipo);
  if($rows > 0) {
      mysql_data_seek($rstipo, 0);
	  $row_rstipo = mysql_fetch_assoc($rstipo);
  }
?>
                    </select>
                      <?php echo $tNGs->displayFieldError("contrato", "cont_tipo", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="numregistro_<?php echo $cnt1; ?>">Número Registro Presupuestal:</label></td>
                  <td><input type="text" name="numregistro_<?php echo $cnt1; ?>" id="numregistro_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscontrato['numregistro']); ?>" size="50" maxlength="200" />
                      <?php echo $tNGs->displayFieldHint("numregistro");?> <?php echo $tNGs->displayFieldError("contrato", "numregistro", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th">Número de contrato:</td>
                  <td><select name="pre_contnumero_<?php echo $cnt1; ?>" id="pre_contnumero_<?php echo $cnt1; ?>">
                      <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                      <?php 
do {  
?>
                      <option value="<?php echo $row_rsprenum['codigo']?>"<?php if (!(strcmp($row_rsprenum['codigo'], $row_rscontrato['pre_contnumero']))) {echo "SELECTED";} ?>><?php echo $row_rsprenum['codigo']?></option>
                      <?php
} while ($row_rsprenum = mysql_fetch_assoc($rsprenum));
  $rows = mysql_num_rows($rsprenum);
  if($rows > 0) {
      mysql_data_seek($rsprenum, 0);
	  $row_rsprenum = mysql_fetch_assoc($rsprenum);
  }
?>
                    </select>
                      N&uacute;mero:
                      <input type="text" name="contnumero_<?php echo $cnt1; ?>" id="contnumero_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscontrato['contnumero']); ?>" size="20" maxlength="20" />
Vigencia:
<input type="text" name="cont_ano_<?php echo $cnt1; ?>" id="cont_ano_<?php echo $cnt1; ?>" value="<?php echo $ano; ?>" size="10" maxlength="4" />
<?php echo $tNGs->displayFieldHint("cont_ano");?> <?php echo $tNGs->displayFieldError("contrato", "cont_ano", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="">Unidad Ejecutora:</label></td>
                  <td><select name="cont_tipopre_<?php echo $cnt1; ?>" id="cont_tipopre_<?php echo $cnt1; ?>">
                    <?php
do {  
?>
                    <option value="<?php echo $row_rsuej['cod_tipounidad']?>"<?php if (!(strcmp($row_rsuej['cod_tipounidad'], KT_escapeAttribute($row_rscontrato['cont_tipopre'])))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsuej['cod_tipounidad']?></option>
                    <?php
} while ($row_rsuej = mysql_fetch_assoc($rsuej));
  $rows = mysql_num_rows($rsuej);
  if($rows > 0) {
      mysql_data_seek($rsuej, 0);
	  $row_rsuej = mysql_fetch_assoc($rsuej);
  }
?>
                  </select>
                    <?php echo $tNGs->displayFieldHint("cont_tipopre");?> <?php echo $tNGs->displayFieldError("contrato", "cont_tipopre", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="cont_fase_<?php echo $cnt1; ?>">Fase:</label></td>
                  <td><select name="cont_fase_<?php echo $cnt1; ?>" id="cont_fase_<?php echo $cnt1; ?>">
                      <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                      <?php 
do {  
?>
                      <option value="<?php echo $row_rsfase['cont_fase']?>"<?php if (!(strcmp($row_rsfase['cont_fase'], $row_rscontrato['cont_fase']))) {echo "SELECTED";} ?>><?php echo $row_rsfase['fase_nombre']?></option>
                      <?php
} while ($row_rsfase = mysql_fetch_assoc($rsfase));
  $rows = mysql_num_rows($rsfase);
  if($rows > 0) {
      mysql_data_seek($rsfase, 0);
	  $row_rsfase = mysql_fetch_assoc($rsfase);
  }
?>
                    </select>
                      <?php echo $tNGs->displayFieldError("contrato", "cont_fase", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="cont_fechaapertura_<?php echo $cnt1; ?>">Fecha de apertura:</label></td>
                  <td><input type="text" name="cont_fechaapertura_<?php echo $cnt1; ?>" id="datepicker" value="<?php echo KT_formatDate($row_rscontrato['cont_fechaapertura']); ?>" size="10" maxlength="22" />
                      <?php echo $tNGs->displayFieldHint("cont_fechaapertura");?> <?php echo $tNGs->displayFieldError("contrato", "cont_fechaapertura", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="cont_valorinicial_<?php echo $cnt1; ?>">Valor inicial del contrato:</label></td>
                  <td><input type="text" name="cont_valorinicial_<?php echo $cnt1; ?>" id="cont_valorinicial_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscontrato['cont_valorinicial']); ?>" size="20" />
                      <?php echo $tNGs->displayFieldHint("cont_valorinicial");?> <?php echo $tNGs->displayFieldError("contrato", "cont_valorinicial", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th">Pago mensual</td>
                  <td><input name="vrmensual" type="text" id="vrmensual" value="<?php echo $row_RsInfoCont['cont_valormensual']; ?>" /></td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="cont_modalidad_<?php echo $cnt1; ?>">Cont_modalidad:</label></td>
                  <td><select name="cont_modalidad_<?php echo $cnt1; ?>" id="cont_modalidad_<?php echo $cnt1; ?>">
                      <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                      <?php 
do {  
?>
                      <option value="<?php echo $row_rsmodalidad['cod_mod_proceso']?>"<?php if (!(strcmp($row_rsmodalidad['cod_mod_proceso'], $row_rscontrato['cont_modalidad']))) {echo "SELECTED";} ?>><?php echo $row_rsmodalidad['des_mod_proceso']?></option>
                      <?php
} while ($row_rsmodalidad = mysql_fetch_assoc($rsmodalidad));
  $rows = mysql_num_rows($rsmodalidad);
  if($rows > 0) {
      mysql_data_seek($rsmodalidad, 0);
	  $row_rsmodalidad = mysql_fetch_assoc($rsmodalidad);
  }
?>
                    </select>
                      <?php echo $tNGs->displayFieldError("contrato", "cont_modalidad", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="cont_tipoproceso_<?php echo $cnt1; ?>">Tipo de contrato:</label></td>
                  <td><select name="cont_tipoproceso_<?php echo $cnt1; ?>" id="cont_tipoproceso_<?php echo $cnt1; ?>">
                      <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                      <?php 
do {  
?>
                      <option value="<?php echo $row_rstipocontrato['cont_tipo']?>"<?php if (!(strcmp($row_rstipocontrato['cont_tipo'], $row_rscontrato['cont_tipoproceso']))) {echo "SELECTED";} ?>><?php echo $row_rstipocontrato['nom_tipocontrato']?></option>
                      <?php
} while ($row_rstipocontrato = mysql_fetch_assoc($rstipocontrato));
  $rows = mysql_num_rows($rstipocontrato);
  if($rows > 0) {
      mysql_data_seek($rstipocontrato, 0);
	  $row_rstipocontrato = mysql_fetch_assoc($rstipocontrato);
  }
?>
                    </select>
                      <?php echo $tNGs->displayFieldError("contrato", "cont_tipoproceso", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="cont_formapago_<?php echo $cnt1; ?>">Forma de pago:</label></td>
                  <td><select name="cont_formapago_<?php echo $cnt1; ?>" id="cont_formapago_<?php echo $cnt1; ?>">
                      <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                      <?php 
do {  
?>
                      <option value="<?php echo $row_rsformapago['codigo']?>"<?php if (!(strcmp($row_rsformapago['codigo'], $row_rscontrato['cont_formapago']))) {echo "SELECTED";} ?>><?php echo $row_rsformapago['nombre']?></option>
                      <?php
} while ($row_rsformapago = mysql_fetch_assoc($rsformapago));
  $rows = mysql_num_rows($rsformapago);
  if($rows > 0) {
      mysql_data_seek($rsformapago, 0);
	  $row_rsformapago = mysql_fetch_assoc($rsformapago);
  }
?>
                    </select>
                      <?php echo $tNGs->displayFieldError("contrato", "cont_formapago", $cnt1); ?> </td>
                </tr>
              </table>
              <input type="hidden" name="kt_pk_contrato_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rscontrato['kt_pk_contrato']); ?>" />
              <?php } while ($row_rscontrato = mysql_fetch_assoc($rscontrato)); ?>
            <div class="KT_bottombuttons">
              <div>
                <?php 
      // Show IF Conditional region1
      if (@$_GET['id_cont'] == "") {
      ?>
                  <input type="submit" name="KT_Insert1" id="KT_Insert1" value="<?php echo NXT_getResource("Insert_FB"); ?>" />
                  <?php 
      // else Conditional region1
      } else { ?>
                  <div class="KT_operations"></div>
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
    <p>&nbsp;</p></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($rsprenum);

mysql_free_result($rstipo);

mysql_free_result($rsfase);

mysql_free_result($rsmodalidad);

mysql_free_result($rstipocontrato);

mysql_free_result($rsformapago);

mysql_free_result($rsrubros);

mysql_free_result($rsuej);

mysql_free_result($RsInfoCont);
?>
