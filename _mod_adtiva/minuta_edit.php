<?php require_once('../Connections/oConnContratos.php'); ?>
<?php require_once('../Connections/oConnContratos.php'); ?>
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
$formValidation->addField("email", false, "text", "email", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

//start Trigger_CheckMaster trigger
//remove this line if you want to edit the code by hand
function Trigger_CheckMaster(&$tNG) {
  // check master record for contrato_minuta
  $tblFldObj = new tNG_CheckMasterRecord($tNG);
  $tblFldObj->setTable("contractor_master");
  $tblFldObj->setFieldName("contractor_doc_id");
  $tblFldObj->setFkFieldName("nit");
  $tblFldObj->setErrorMsg("El valor ingresado no es v�lido o no existe en los registros de contratistas");
  return $tblFldObj->Execute();
}
//end Trigger_CheckMaster trigger

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
$query_rabancos = "SELECT * FROM tipo_banco ORDER BY nom_banco ASC";
$rabancos = mysql_query($query_rabancos, $oConnContratos) or die(mysql_error());
$row_rabancos = mysql_fetch_assoc($rabancos);
$totalRows_rabancos = mysql_num_rows($rabancos);

mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rstipocuenta = "SELECT * FROM tipo_cta_banco";
$rstipocuenta = mysql_query($query_rstipocuenta, $oConnContratos) or die(mysql_error());
$row_rstipocuenta = mysql_fetch_assoc($rstipocuenta);
$totalRows_rstipocuenta = mysql_num_rows($rstipocuenta);

mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rsmodalidad = "SELECT * FROM contrato_modalidad";
$rsmodalidad = mysql_query($query_rsmodalidad, $oConnContratos) or die(mysql_error());
$row_rsmodalidad = mysql_fetch_assoc($rsmodalidad);
$totalRows_rsmodalidad = mysql_num_rows($rsmodalidad);

mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rstipocontrato = "SELECT * FROM tipo_contrato";
$rstipocontrato = mysql_query($query_rstipocontrato, $oConnContratos) or die(mysql_error());
$row_rstipocontrato = mysql_fetch_assoc($rstipocontrato);
$totalRows_rstipocontrato = mysql_num_rows($rstipocontrato);

// Make an insert transaction instance
$ins_contrato_minuta = new tNG_multipleInsert($conn_oConnContratos);
$tNGs->addTransaction($ins_contrato_minuta);
// Register triggers
$ins_contrato_minuta->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_contrato_minuta->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_contrato_minuta->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$ins_contrato_minuta->registerTrigger("BEFORE", "Trigger_CheckMaster", 40);
// Add columns
$ins_contrato_minuta->setTable("contrato_minuta");
$ins_contrato_minuta->addColumn("No", "DOUBLE_TYPE", "POST", "No");
$ins_contrato_minuta->addColumn("fecha", "DATE_TYPE", "POST", "fecha");
$ins_contrato_minuta->addColumn("nombre", "STRING_TYPE", "POST", "nombre");
$ins_contrato_minuta->addColumn("nit", "STRING_TYPE", "POST", "nit");
$ins_contrato_minuta->addColumn("nit_dv", "NUMERIC_TYPE", "POST", "nit_dv");
$ins_contrato_minuta->addColumn("direc", "STRING_TYPE", "POST", "direc");
$ins_contrato_minuta->addColumn("email", "STRING_TYPE", "POST", "email");
$ins_contrato_minuta->addColumn("tel", "STRING_TYPE", "POST", "tel");
$ins_contrato_minuta->addColumn("banco", "STRING_TYPE", "POST", "banco");
$ins_contrato_minuta->addColumn("cuenta", "STRING_TYPE", "POST", "cuenta");
$ins_contrato_minuta->addColumn("tipo", "STRING_TYPE", "POST", "tipo");
$ins_contrato_minuta->addColumn("objeto", "STRING_TYPE", "POST", "objeto");
$ins_contrato_minuta->addColumn("valor", "DOUBLE_TYPE", "POST", "valor");
$ins_contrato_minuta->addColumn("rubro", "STRING_TYPE", "POST", "rubro");
$ins_contrato_minuta->addColumn("cdp", "STRING_TYPE", "POST", "cdp");
$ins_contrato_minuta->addColumn("plazo", "STRING_TYPE", "POST", "plazo");
$ins_contrato_minuta->addColumn("garantia", "STRING_TYPE", "POST", "garantia");
$ins_contrato_minuta->addColumn("superv", "STRING_TYPE", "POST", "superv");
$ins_contrato_minuta->addColumn("formapago", "STRING_TYPE", "POST", "formapago");
$ins_contrato_minuta->addColumn("NaturalezaContratista", "STRING_TYPE", "POST", "NaturalezaContratista");
$ins_contrato_minuta->addColumn("ModalidadContratacion", "STRING_TYPE", "POST", "ModalidadContratacion");
$ins_contrato_minuta->addColumn("ClaseContrato", "STRING_TYPE", "POST", "ClaseContrato");
$ins_contrato_minuta->addColumn("NombreSupervisor", "STRING_TYPE", "POST", "NombreSupervisor");
$ins_contrato_minuta->addColumn("dependencia", "STRING_TYPE", "POST", "dependencia");
$ins_contrato_minuta->addColumn("representantelegal", "STRING_TYPE", "POST", "representantelegal");
$ins_contrato_minuta->addColumn("Otrosi_Adicional_1", "STRING_TYPE", "POST", "Otrosi_Adicional_1");
$ins_contrato_minuta->addColumn("Otrosi2", "STRING_TYPE", "POST", "Otrosi2");
$ins_contrato_minuta->addColumn("Inicia", "DATE_TYPE", "POST", "Inicia");
$ins_contrato_minuta->addColumn("Termina", "DATE_TYPE", "POST", "Termina");
$ins_contrato_minuta->addColumn("clausula_ambiental", "STRING_TYPE", "POST", "clausula_ambiental");
$ins_contrato_minuta->addColumn("Resol_Sello", "STRING_TYPE", "POST", "Resol_Sello");
$ins_contrato_minuta->addColumn("ctrl", "NUMERIC_TYPE", "POST", "ctrl");
$ins_contrato_minuta->setPrimaryKey("Id", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_contrato_minuta = new tNG_multipleUpdate($conn_oConnContratos);
$tNGs->addTransaction($upd_contrato_minuta);
// Register triggers
$upd_contrato_minuta->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_contrato_minuta->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_contrato_minuta->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$upd_contrato_minuta->registerTrigger("BEFORE", "Trigger_CheckMaster", 40);
// Add columns
$upd_contrato_minuta->setTable("contrato_minuta");
$upd_contrato_minuta->addColumn("No", "DOUBLE_TYPE", "POST", "No");
$upd_contrato_minuta->addColumn("fecha", "DATE_TYPE", "POST", "fecha");
$upd_contrato_minuta->addColumn("nombre", "STRING_TYPE", "POST", "nombre");
$upd_contrato_minuta->addColumn("nit", "STRING_TYPE", "POST", "nit");
$upd_contrato_minuta->addColumn("nit_dv", "NUMERIC_TYPE", "POST", "nit_dv");
$upd_contrato_minuta->addColumn("direc", "STRING_TYPE", "POST", "direc");
$upd_contrato_minuta->addColumn("email", "STRING_TYPE", "POST", "email");
$upd_contrato_minuta->addColumn("tel", "STRING_TYPE", "POST", "tel");
$upd_contrato_minuta->addColumn("banco", "STRING_TYPE", "POST", "banco");
$upd_contrato_minuta->addColumn("cuenta", "STRING_TYPE", "POST", "cuenta");
$upd_contrato_minuta->addColumn("tipo", "STRING_TYPE", "POST", "tipo");
$upd_contrato_minuta->addColumn("objeto", "STRING_TYPE", "POST", "objeto");
$upd_contrato_minuta->addColumn("valor", "DOUBLE_TYPE", "POST", "valor");
$upd_contrato_minuta->addColumn("rubro", "STRING_TYPE", "POST", "rubro");
$upd_contrato_minuta->addColumn("cdp", "STRING_TYPE", "POST", "cdp");
$upd_contrato_minuta->addColumn("plazo", "STRING_TYPE", "POST", "plazo");
$upd_contrato_minuta->addColumn("garantia", "STRING_TYPE", "POST", "garantia");
$upd_contrato_minuta->addColumn("superv", "STRING_TYPE", "POST", "superv");
$upd_contrato_minuta->addColumn("formapago", "STRING_TYPE", "POST", "formapago");
$upd_contrato_minuta->addColumn("NaturalezaContratista", "STRING_TYPE", "POST", "NaturalezaContratista");
$upd_contrato_minuta->addColumn("ModalidadContratacion", "STRING_TYPE", "POST", "ModalidadContratacion");
$upd_contrato_minuta->addColumn("ClaseContrato", "STRING_TYPE", "POST", "ClaseContrato");
$upd_contrato_minuta->addColumn("NombreSupervisor", "STRING_TYPE", "POST", "NombreSupervisor");
$upd_contrato_minuta->addColumn("dependencia", "STRING_TYPE", "POST", "dependencia");
$upd_contrato_minuta->addColumn("representantelegal", "STRING_TYPE", "POST", "representantelegal");
$upd_contrato_minuta->addColumn("Otrosi_Adicional_1", "STRING_TYPE", "POST", "Otrosi_Adicional_1");
$upd_contrato_minuta->addColumn("Otrosi2", "STRING_TYPE", "POST", "Otrosi2");
$upd_contrato_minuta->addColumn("Inicia", "DATE_TYPE", "POST", "Inicia");
$upd_contrato_minuta->addColumn("Termina", "DATE_TYPE", "POST", "Termina");
$upd_contrato_minuta->addColumn("clausula_ambiental", "STRING_TYPE", "POST", "clausula_ambiental");
$upd_contrato_minuta->addColumn("Resol_Sello", "STRING_TYPE", "POST", "Resol_Sello");
$upd_contrato_minuta->addColumn("ctrl", "NUMERIC_TYPE", "POST", "ctrl");
$upd_contrato_minuta->setPrimaryKey("Id", "NUMERIC_TYPE", "GET", "Id");

// Make an instance of the transaction object
$del_contrato_minuta = new tNG_multipleDelete($conn_oConnContratos);
$tNGs->addTransaction($del_contrato_minuta);
// Register triggers
$del_contrato_minuta->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_contrato_minuta->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$del_contrato_minuta->setTable("contrato_minuta");
$del_contrato_minuta->setPrimaryKey("Id", "NUMERIC_TYPE", "GET", "Id");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rscontrato_minuta = $tNGs->getRecordset("contrato_minuta");
$row_rscontrato_minuta = mysql_fetch_assoc($rscontrato_minuta);
$totalRows_rscontrato_minuta = mysql_num_rows($rscontrato_minuta);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
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
  duplicate_buttons: false,
  show_as_grid: false,
  merge_down_value: true
}
</script>
<link rel="stylesheet" href="../_jquery/_desktop/_app/themes/south-street/jquery.ui.all.css">
	<script src="../_jquery/_desktop/_app/jquery-1.9.1.js"></script>
	<script src="../_jquery/_desktop/_app/ui/jquery.ui.core.js"></script>
	<script src="../_jquery/_desktop/_app/ui/jquery.ui.widget.js"></script>
	<script src="../_jquery/_desktop/_app/ui/jquery.ui.datepicker.js"></script>
	<link rel="stylesheet" href="../_jquery/_desktop/_app/_modules/demos.css">
	<script>
	$(function() {
		$( "#datepicker" ).datepicker({
			changeMonth: true,
			changeYear: true
		});
		$( "#ini" ).datepicker({
			changeMonth: true,
			changeYear: true
		});
		$( "#fin" ).datepicker({
			changeMonth: true,
			changeYear: true
		});
	});
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
    <td>&nbsp;
      <?php
	echo $tNGs->getErrorMsg();
?>
      <div class="KT_tng">
        <h1>
          <?php 
// Show IF Conditional region1 
if (@$_GET['Id'] == "") {
?>
            <?php echo NXT_getResource("Insert_FH"); ?>
            <?php 
// else Conditional region1
} else { ?>
            <?php echo NXT_getResource("Update_FH"); ?>
      <?php } 
// endif Conditional region1
?>
            minuta
        </h1>
        <div class="KT_tngform">
          <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
            <?php $cnt1 = 0; ?>
            <?php do { ?>
              <?php $cnt1++; ?>
              <?php 
// Show IF Conditional region1 
if (@$totalRows_rscontrato_minuta > 1) {
?>
                <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
                <?php } 
// endif Conditional region1
?>
              <table cellpadding="2" cellspacing="0" class="KT_tngtable">
                <tr>
                  <td class="KT_th"><label for="No_<?php echo $cnt1; ?>">No:</label></td>
                  <td><input type="text" name="No_<?php echo $cnt1; ?>" id="No_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscontrato_minuta['No']); ?>" size="32" />
                      <?php echo $tNGs->displayFieldHint("No");?> <?php echo $tNGs->displayFieldError("contrato_minuta", "No", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="fecha_<?php echo $cnt1; ?>">Fecha:</label></td>
                  <td><input type="text" name="fecha_<?php echo $cnt1; ?>" id="datepicker" value="<?php echo KT_formatDate($row_rscontrato_minuta['fecha']); ?>" size="10" maxlength="22" />
                      <?php echo $tNGs->displayFieldHint("fecha");?> <?php echo $tNGs->displayFieldError("contrato_minuta", "fecha", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="nit_<?php echo $cnt1; ?>">Nit / Documento:</label></td>
                  <td><input type="text" name="nit_<?php echo $cnt1; ?>" id="nit_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscontrato_minuta['nit']); ?>" size="32" maxlength="255" />
                      <?php echo $tNGs->displayFieldHint("nit");?> <?php echo $tNGs->displayFieldError("contrato_minuta", "nit", $cnt1); ?> <input name="nombre_<?php echo $cnt1; ?>" type="hidden" id="nombre_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscontrato_minuta['nombre']); ?>" />
                  <?php echo $tNGs->displayFieldHint("nombre");?> <?php echo $tNGs->displayFieldError("contrato_minuta", "nombre", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="nit_dv_<?php echo $cnt1; ?>">D&iacute;gito de verificaci&oacute;n:</label></td>
                  <td><input type="text" name="nit_dv_<?php echo $cnt1; ?>" id="nit_dv_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscontrato_minuta['nit_dv']); ?>" size="2" />
                      <?php echo $tNGs->displayFieldHint("nit_dv");?> <?php echo $tNGs->displayFieldError("contrato_minuta", "nit_dv", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="direc_<?php echo $cnt1; ?>">Direcci&oacute;n:</label></td>
                  <td><input type="text" name="direc_<?php echo $cnt1; ?>" id="direc_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscontrato_minuta['direc']); ?>" size="60" maxlength="255" />
                      <?php echo $tNGs->displayFieldHint("direc");?> <?php echo $tNGs->displayFieldError("contrato_minuta", "direc", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="email_<?php echo $cnt1; ?>">Email:</label></td>
                  <td><input type="text" name="email_<?php echo $cnt1; ?>" id="email_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscontrato_minuta['email']); ?>" size="60" maxlength="255" />
                      <?php echo $tNGs->displayFieldHint("email");?> <?php echo $tNGs->displayFieldError("contrato_minuta", "email", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="tel_<?php echo $cnt1; ?>">Tel&eacute;fono:</label></td>
                  <td><input type="text" name="tel_<?php echo $cnt1; ?>" id="tel_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscontrato_minuta['tel']); ?>" size="32" maxlength="255" />
                      <?php echo $tNGs->displayFieldHint("tel");?> <?php echo $tNGs->displayFieldError("contrato_minuta", "tel", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="banco_<?php echo $cnt1; ?>">Banco:</label></td>
                  <td><select name="banco_<?php echo $cnt1; ?>" id="banco_<?php echo $cnt1; ?>">
                    <?php
do {  
?><option value="<?php echo $row_rabancos['nom_banco']?>"<?php if (!(strcmp($row_rabancos['nom_banco'], KT_escapeAttribute($row_rscontrato_minuta['banco'])))) {echo "selected=\"selected\"";} ?>><?php echo $row_rabancos['nom_banco']?></option>
                    <?php
} while ($row_rabancos = mysql_fetch_assoc($rabancos));
  $rows = mysql_num_rows($rabancos);
  if($rows > 0) {
      mysql_data_seek($rabancos, 0);
	  $row_rabancos = mysql_fetch_assoc($rabancos);
  }
?>
                  </select>
                    <?php echo $tNGs->displayFieldHint("banco");?> <?php echo $tNGs->displayFieldError("contrato_minuta", "banco", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="cuenta_<?php echo $cnt1; ?>">N&uacute;mero de cuenta:</label></td>
                  <td><input type="text" name="cuenta_<?php echo $cnt1; ?>" id="cuenta_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscontrato_minuta['cuenta']); ?>" size="32" maxlength="255" />
                      <?php echo $tNGs->displayFieldHint("cuenta");?> <?php echo $tNGs->displayFieldError("contrato_minuta", "cuenta", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="tipo_<?php echo $cnt1; ?>">Tipo:</label></td>
                  <td><select name="tipo_<?php echo $cnt1; ?>" id="tipo_<?php echo $cnt1; ?>">
                    <?php
do {  
?>
                    <option value="<?php echo $row_rstipocuenta['des_cuenta']?>"<?php if (!(strcmp($row_rstipocuenta['des_cuenta'], KT_escapeAttribute($row_rscontrato_minuta['tipo'])))) {echo "selected=\"selected\"";} ?>><?php echo $row_rstipocuenta['des_cuenta']?></option>
<?php
} while ($row_rstipocuenta = mysql_fetch_assoc($rstipocuenta));
  $rows = mysql_num_rows($rstipocuenta);
  if($rows > 0) {
      mysql_data_seek($rstipocuenta, 0);
	  $row_rstipocuenta = mysql_fetch_assoc($rstipocuenta);
  }
?>
                  </select>
                    <?php echo $tNGs->displayFieldHint("tipo");?> <?php echo $tNGs->displayFieldError("contrato_minuta", "tipo", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="objeto_<?php echo $cnt1; ?>">Objeto:</label></td>
                  <td><textarea name="objeto_<?php echo $cnt1; ?>" id="objeto_<?php echo $cnt1; ?>" cols="50" rows="5"><?php echo KT_escapeAttribute($row_rscontrato_minuta['objeto']); ?></textarea>
                      <?php echo $tNGs->displayFieldHint("objeto");?> <?php echo $tNGs->displayFieldError("contrato_minuta", "objeto", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="valor_<?php echo $cnt1; ?>">Valor:</label></td>
                  <td><input type="text" name="valor_<?php echo $cnt1; ?>" id="valor_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscontrato_minuta['valor']); ?>" size="32" />
                      <?php echo $tNGs->displayFieldHint("valor");?> <?php echo $tNGs->displayFieldError("contrato_minuta", "valor", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="rubro_<?php echo $cnt1; ?>">Rubro:</label></td>
                  <td><input type="text" name="rubro_<?php echo $cnt1; ?>" id="rubro_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscontrato_minuta['rubro']); ?>" size="32" maxlength="255" />
                      <?php echo $tNGs->displayFieldHint("rubro");?> <?php echo $tNGs->displayFieldError("contrato_minuta", "rubro", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="cdp_<?php echo $cnt1; ?>">Cdp:</label></td>
                  <td><input type="text" name="cdp_<?php echo $cnt1; ?>" id="cdp_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscontrato_minuta['cdp']); ?>" size="32" maxlength="255" />
                      <?php echo $tNGs->displayFieldHint("cdp");?> <?php echo $tNGs->displayFieldError("contrato_minuta", "cdp", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="plazo_<?php echo $cnt1; ?>">Plazo:</label></td>
                  <td><textarea name="plazo_<?php echo $cnt1; ?>" id="plazo_<?php echo $cnt1; ?>" cols="50" rows="5"><?php echo KT_escapeAttribute($row_rscontrato_minuta['plazo']); ?></textarea>
                      <?php echo $tNGs->displayFieldHint("plazo");?> <?php echo $tNGs->displayFieldError("contrato_minuta", "plazo", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="garantia_<?php echo $cnt1; ?>">Garantia:</label></td>
                  <td><textarea name="garantia_<?php echo $cnt1; ?>" id="garantia_<?php echo $cnt1; ?>" cols="50" rows="5"><?php echo KT_escapeAttribute($row_rscontrato_minuta['garantia']); ?></textarea>
                      <?php echo $tNGs->displayFieldHint("garantia");?> <?php echo $tNGs->displayFieldError("contrato_minuta", "garantia", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="superv_<?php echo $cnt1; ?>">Cargo del supervisor :</label></td>
                  <td><input type="text" name="superv_<?php echo $cnt1; ?>" id="superv_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscontrato_minuta['superv']); ?>" size="100" maxlength="255" />
                      <?php echo $tNGs->displayFieldHint("superv");?> <?php echo $tNGs->displayFieldError("contrato_minuta", "superv", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="formapago_<?php echo $cnt1; ?>">Forma de pago:</label></td>
                  <td><textarea name="formapago_<?php echo $cnt1; ?>" id="formapago_<?php echo $cnt1; ?>" cols="50" rows="5"><?php echo KT_escapeAttribute($row_rscontrato_minuta['formapago']); ?></textarea>
                      <?php echo $tNGs->displayFieldHint("formapago");?> <?php echo $tNGs->displayFieldError("contrato_minuta", "formapago", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="NaturalezaContratista_<?php echo $cnt1; ?>">Naturaleza Contratista:</label></td>
                  <td><select name="NaturalezaContratista_<?php echo $cnt1; ?>" id="NaturalezaContratista_<?php echo $cnt1; ?>">
                    <option value="Persona Jur&iacute;dica">Persona Jur&iacute;dica</option>
                    <option value="Persona Natural">Persona Natural</option>
                  </select>
                  <?php echo $tNGs->displayFieldHint("NaturalezaContratista");?> <?php echo $tNGs->displayFieldError("contrato_minuta", "NaturalezaContratista", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="ModalidadContratacion_<?php echo $cnt1; ?>">Modalidad Contratacion:</label></td>
                  <td><select name="ModalidadContratacion_<?php echo $cnt1; ?>" id="ModalidadContratacion_<?php echo $cnt1; ?>">
                    <?php
do {  
?>
                    <option value="<?php echo $row_rsmodalidad['des_mod_proceso']?>"<?php if (!(strcmp($row_rsmodalidad['des_mod_proceso'], KT_escapeAttribute($row_rscontrato_minuta['ModalidadContratacion'])))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsmodalidad['des_mod_proceso']?></option>
                    <?php
} while ($row_rsmodalidad = mysql_fetch_assoc($rsmodalidad));
  $rows = mysql_num_rows($rsmodalidad);
  if($rows > 0) {
      mysql_data_seek($rsmodalidad, 0);
	  $row_rsmodalidad = mysql_fetch_assoc($rsmodalidad);
  }
?>
                  </select>
                  <?php echo $tNGs->displayFieldHint("ModalidadContratacion");?> <?php echo $tNGs->displayFieldError("contrato_minuta", "ModalidadContratacion", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="ClaseContrato_<?php echo $cnt1; ?>">Clase Contrato:</label></td>
                  <td><select name="ClaseContrato_<?php echo $cnt1; ?>" id="ClaseContrato_<?php echo $cnt1; ?>">
                    <?php
do {  
?>
                    <option value="<?php echo $row_rstipocontrato['nom_tipocontrato']?>"<?php if (!(strcmp($row_rstipocontrato['nom_tipocontrato'], KT_escapeAttribute($row_rscontrato_minuta['ClaseContrato'])))) {echo "selected=\"selected\"";} ?>><?php echo $row_rstipocontrato['nom_tipocontrato']?></option>
                    <?php
} while ($row_rstipocontrato = mysql_fetch_assoc($rstipocontrato));
  $rows = mysql_num_rows($rstipocontrato);
  if($rows > 0) {
      mysql_data_seek($rstipocontrato, 0);
	  $row_rstipocontrato = mysql_fetch_assoc($rstipocontrato);
  }
?>
                  </select>
                  <?php echo $tNGs->displayFieldHint("ClaseContrato");?> <?php echo $tNGs->displayFieldError("contrato_minuta", "ClaseContrato", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="NombreSupervisor_<?php echo $cnt1; ?>">Nombre Supervisor:</label></td>
                  <td><input type="text" name="NombreSupervisor_<?php echo $cnt1; ?>" id="NombreSupervisor_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscontrato_minuta['NombreSupervisor']); ?>" size="32" maxlength="255" />
                      <?php echo $tNGs->displayFieldHint("NombreSupervisor");?> <?php echo $tNGs->displayFieldError("contrato_minuta", "NombreSupervisor", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="dependencia_<?php echo $cnt1; ?>">Dependencia del supervisor:</label></td>
                  <td><input type="text" name="dependencia_<?php echo $cnt1; ?>" id="dependencia_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscontrato_minuta['dependencia']); ?>" size="32" maxlength="255" />
                      <?php echo $tNGs->displayFieldHint("dependencia");?> <?php echo $tNGs->displayFieldError("contrato_minuta", "dependencia", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="representantelegal_<?php echo $cnt1; ?>">Representante legal:</label></td>
                  <td><input type="text" name="representantelegal_<?php echo $cnt1; ?>" id="representantelegal_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscontrato_minuta['representantelegal']); ?>" size="32" maxlength="255" />
                      <?php echo $tNGs->displayFieldHint("representantelegal");?> <?php echo $tNGs->displayFieldError("contrato_minuta", "representantelegal", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="Otrosi_Adicional_1_<?php echo $cnt1; ?>">Otrosi_Adicional_1:</label></td>
                  <td><textarea name="Otrosi_Adicional_1_<?php echo $cnt1; ?>" cols="50" rows="5" id="Otrosi_Adicional_1_<?php echo $cnt1; ?>"><?php echo KT_escapeAttribute($row_rscontrato_minuta['Otrosi_Adicional_1']); ?></textarea>
                      <?php echo $tNGs->displayFieldHint("Otrosi_Adicional_1");?> <?php echo $tNGs->displayFieldError("contrato_minuta", "Otrosi_Adicional_1", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="Otrosi2_<?php echo $cnt1; ?>">Otrosi2:</label></td>
                  <td><textarea name="Otrosi2_<?php echo $cnt1; ?>" cols="50" rows="5" id="Otrosi2_<?php echo $cnt1; ?>"><?php echo KT_escapeAttribute($row_rscontrato_minuta['Otrosi2']); ?></textarea>
                      <?php echo $tNGs->displayFieldHint("Otrosi2");?> <?php echo $tNGs->displayFieldError("contrato_minuta", "Otrosi2", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="Inicia_<?php echo $cnt1; ?>">Inicia:</label></td>
                  <td><input type="text" name="Inicia_<?php echo $cnt1; ?>" id="ini" value="<?php echo KT_formatDate($row_rscontrato_minuta['Inicia']); ?>" size="10" maxlength="22" />
                      <?php echo $tNGs->displayFieldHint("Inicia");?> <?php echo $tNGs->displayFieldError("contrato_minuta", "Inicia", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="Termina_<?php echo $cnt1; ?>">Termina:</label></td>
                  <td><input type="text" name="Termina_<?php echo $cnt1; ?>" id="fin" value="<?php echo KT_formatDate($row_rscontrato_minuta['Termina']); ?>" size="10" maxlength="22" />
                      <?php echo $tNGs->displayFieldHint("Termina");?> <?php echo $tNGs->displayFieldError("contrato_minuta", "Termina", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="clausula_ambiental_<?php echo $cnt1; ?>">Clausula_ambiental:</label></td>
                  <td><textarea name="clausula_ambiental_<?php echo $cnt1; ?>" cols="50" rows="5" id="clausula_ambiental_<?php echo $cnt1; ?>"><?php echo KT_escapeAttribute($row_rscontrato_minuta['clausula_ambiental']); ?></textarea>
                      <?php echo $tNGs->displayFieldHint("clausula_ambiental");?> <?php echo $tNGs->displayFieldError("contrato_minuta", "clausula_ambiental", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="Resol_Sello_<?php echo $cnt1; ?>">Resol_Sello:</label></td>
                  <td><input type="text" name="Resol_Sello_<?php echo $cnt1; ?>" id="Resol_Sello_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscontrato_minuta['Resol_Sello']); ?>" size="32" maxlength="255" />
                      <?php echo $tNGs->displayFieldHint("Resol_Sello");?> <?php echo $tNGs->displayFieldError("contrato_minuta", "Resol_Sello", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th">&nbsp;</td>
                  <td><input name="ctrl_<?php echo $cnt1; ?>" type="hidden" id="ctrl_<?php echo $cnt1; ?>" value="1" />
                      <?php echo $tNGs->displayFieldHint("ctrl");?> <?php echo $tNGs->displayFieldError("contrato_minuta", "ctrl", $cnt1); ?> </td>
                </tr>
              </table>
              <input type="hidden" name="kt_pk_contrato_minuta_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rscontrato_minuta['kt_pk_contrato_minuta']); ?>" />
              <?php } while ($row_rscontrato_minuta = mysql_fetch_assoc($rscontrato_minuta)); ?>
            <div class="KT_bottombuttons">
              <div>
                <?php 
      // Show IF Conditional region1
      if (@$_GET['Id'] == "") {
      ?>
                  <input type="submit" name="KT_Insert1" id="KT_Insert1" value="Grabar" />
                  <?php 
      // else Conditional region1
      } else { ?>
                  <div class="KT_operations">
                    <input type="submit" name="KT_Insert1" value="<?php echo NXT_getResource("Insert as new_FB"); ?>" onclick="nxt_form_insertasnew(this, 'Id')" />
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
mysql_free_result($rabancos);

mysql_free_result($rstipocuenta);

mysql_free_result($rsmodalidad);

mysql_free_result($rstipocontrato);
?>
