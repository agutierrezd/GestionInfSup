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

// Load the tNG classes
require_once('../includes/tng/tNG.inc.php');

// Make a transaction dispatcher instance
$tNGs = new tNG_dispatcher("../");

// Make unified connection variable
$conn_oConnContratos = new KT_connection($oConnContratos, $database_oConnContratos);

// Start trigger
$masterValidation = new tNG_FormValidation();
$masterValidation->addField("ctrlpagos_id_fk", true, "numeric", "", "", "", "");
$masterValidation->addField("id_cont_fk", true, "numeric", "", "", "", "");
$masterValidation->addField("hr_anio", true, "date", "", "", "", "");
$masterValidation->addField("hr_nit_contra_ta", true, "text", "", "", "", "");
$masterValidation->addField("hr_asunto", true, "text", "", "", "", "");
$masterValidation->addField("hr_valor", true, "double", "float_positive", "", "", "");
$masterValidation->addField("hr_fechaingreso", true, "date", "", "", "", "");
$masterValidation->addField("sys_user", true, "text", "", "", "", "");
$masterValidation->addField("sys_user_actual", true, "text", "", "", "", "");
$masterValidation->addField("sys_fecha_reg", true, "date", "", "", "", "");
$tNGs->prepareValidation($masterValidation);
// End trigger

// Start trigger
$detailValidation = new tNG_FormValidation();
$detailValidation->addField("evento_type", true, "numeric", "", "", "", "");
$detailValidation->addField("evento_fechaa", true, "date", "", "", "", "");
$detailValidation->addField("evento_responsable", true, "text", "", "", "", "");
$detailValidation->addField("evento_fechaoper", true, "date", "", "", "", "");
$tNGs->prepareValidation($detailValidation);
// End trigger

//start Trigger_LinkTransactions trigger
//remove this line if you want to edit the code by hand 
function Trigger_LinkTransactions(&$tNG) {
	global $ins_hoja_ruta_event;
  $linkObj = new tNG_LinkedTrans($tNG, $ins_hoja_ruta_event);
  $linkObj->setLink("hr_id_fk");
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

$colname_rsinfocont = "-1";
if (isset($_GET['id_cont'])) {
  $colname_rsinfocont = $_GET['id_cont'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rsinfocont = sprintf("SELECT * FROM contrato WHERE id_cont = %s", GetSQLValueString($colname_rsinfocont, "int"));
$rsinfocont = mysql_query($query_rsinfocont, $oConnContratos) or die(mysql_error());
$row_rsinfocont = mysql_fetch_assoc($rsinfocont);
$totalRows_rsinfocont = mysql_num_rows($rsinfocont);

$colname_rsinfopago = "-1";
if (isset($_GET['ctrlpagos_id'])) {
  $colname_rsinfopago = $_GET['ctrlpagos_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rsinfopago = sprintf("SELECT * FROM contrato_controlpagos WHERE ctrlpagos_id = %s", GetSQLValueString($colname_rsinfopago, "int"));
$rsinfopago = mysql_query($query_rsinfopago, $oConnContratos) or die(mysql_error());
$row_rsinfopago = mysql_fetch_assoc($rsinfopago);
$totalRows_rsinfopago = mysql_num_rows($rsinfopago);

$colname_rsctrl = "-1";
if (isset($_GET['ctrlpagos_id'])) {
  $colname_rsctrl = $_GET['ctrlpagos_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rsctrl = sprintf("SELECT * FROM hoja_ruta WHERE ctrlpagos_id_fk = %s", GetSQLValueString($colname_rsctrl, "int"));
$rsctrl = mysql_query($query_rsctrl, $oConnContratos) or die(mysql_error());
$row_rsctrl = mysql_fetch_assoc($rsctrl);
$totalRows_rsctrl = mysql_num_rows($rsctrl);

mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rsempresas = "SELECT contractor_id, contractor_doc_id, contractor_doc_id_dv, contractor_name FROM contractor_master ORDER BY contractor_name ASC";
$rsempresas = mysql_query($query_rsempresas, $oConnContratos) or die(mysql_error());
$row_rsempresas = mysql_fetch_assoc($rsempresas);
$totalRows_rsempresas = mysql_num_rows($rsempresas);

// Make an insert transaction instance
$ins_hoja_ruta = new tNG_insert($conn_oConnContratos);
$tNGs->addTransaction($ins_hoja_ruta);
// Register triggers
$ins_hoja_ruta->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_hoja_ruta->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $masterValidation);
$ins_hoja_ruta->registerTrigger("END", "Trigger_Default_Redirect", 99, "ok.php");
$ins_hoja_ruta->registerTrigger("AFTER", "Trigger_LinkTransactions", 98);
$ins_hoja_ruta->registerTrigger("ERROR", "Trigger_LinkTransactions", 98);
// Add columns
$ins_hoja_ruta->setTable("hoja_ruta_2017");
$ins_hoja_ruta->addColumn("ctrlpagos_id_fk", "NUMERIC_TYPE", "POST", "ctrlpagos_id_fk");
$ins_hoja_ruta->addColumn("id_cont_fk", "NUMERIC_TYPE", "POST", "id_cont_fk");
$ins_hoja_ruta->addColumn("hr_anio", "DATE_TYPE", "POST", "hr_anio");
$ins_hoja_ruta->addColumn("hr_nit_contra_ta", "STRING_TYPE", "POST", "hr_nit_contra_ta");
$ins_hoja_ruta->addColumn("hr_asunto", "STRING_TYPE", "POST", "hr_asunto");
$ins_hoja_ruta->addColumn("hr_valor", "DOUBLE_TYPE", "POST", "hr_valor");
$ins_hoja_ruta->addColumn("hr_fechaingreso", "DATE_TYPE", "POST", "hr_fechaingreso");
$ins_hoja_ruta->addColumn("hr_fecha_salida", "DATE_TYPE", "POST", "hr_fecha_salida");
$ins_hoja_ruta->addColumn("hr_estado_firma", "STRING_TYPE", "POST", "hr_estado_firma");
$ins_hoja_ruta->addColumn("sys_user", "STRING_TYPE", "POST", "sys_user");
$ins_hoja_ruta->addColumn("sys_user_actual", "STRING_TYPE", "POST", "sys_user_actual");
$ins_hoja_ruta->addColumn("sys_fecha_reg", "DATE_TYPE", "POST", "sys_fecha_reg");
$ins_hoja_ruta->setPrimaryKey("hr_id", "NUMERIC_TYPE");

// Make an insert transaction instance
$ins_hoja_ruta_event = new tNG_insert($conn_oConnContratos);
$tNGs->addTransaction($ins_hoja_ruta_event);
// Register triggers
$ins_hoja_ruta_event->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "VALUE", null);
$ins_hoja_ruta_event->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $detailValidation);
// Add columns
$ins_hoja_ruta_event->setTable("hoja_ruta_event_2017");
$ins_hoja_ruta_event->addColumn("evento_type", "NUMERIC_TYPE", "POST", "evento_type");
$ins_hoja_ruta_event->addColumn("evento_fechaa", "DATE_TYPE", "POST", "evento_fechaa");
$ins_hoja_ruta_event->addColumn("evento_obs", "STRING_TYPE", "POST", "evento_obs");
$ins_hoja_ruta_event->addColumn("evento_responsable", "STRING_TYPE", "POST", "evento_responsable");
$ins_hoja_ruta_event->addColumn("evento_fechaoper", "DATE_TYPE", "POST", "evento_fechaoper");
$ins_hoja_ruta_event->addColumn("hr_id_fk", "NUMERIC_TYPE", "VALUE", "");
$ins_hoja_ruta_event->setPrimaryKey("evento_id", "NUMERIC_TYPE");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rshoja_ruta = $tNGs->getRecordset("hoja_ruta_2017");
$row_rshoja_ruta = mysql_fetch_assoc($rshoja_ruta);
$totalRows_rshoja_ruta = mysql_num_rows($rshoja_ruta);

// Get the transaction recordset
$rshoja_ruta_event = $tNGs->getRecordset("hoja_ruta_event_2017");
$row_rshoja_ruta_event = mysql_fetch_assoc($rshoja_ruta_event);
$totalRows_rshoja_ruta_event = mysql_num_rows($rshoja_ruta_event);
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
<link href="../_css/jqueryslidemenu.css" rel="stylesheet" type="text/css" />
</head>

<body>

<?php
	echo $tNGs->getErrorMsg();
?>
<?php if ($totalRows_rsctrl == 0) { // Show if recordset empty ?>
  <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
    <table cellpadding="2" cellspacing="0" class="KT_tngtable">
      <tr>
        <td class="KT_th">&nbsp;</td>
      <td><input name="ctrlpagos_id_fk" type="hidden" id="ctrlpagos_id_fk" value="0" size="32" />
            <?php echo $tNGs->displayFieldHint("ctrlpagos_id_fk");?> <?php echo $tNGs->displayFieldError("hoja_ruta", "ctrlpagos_id_fk"); ?>
            <input name="id_cont_fk" type="hidden" id="id_cont_fk" value="0" size="32" />
            <?php echo $tNGs->displayFieldHint("id_cont_fk");?> <?php echo $tNGs->displayFieldError("hoja_ruta", "id_cont_fk"); ?>
            <input type="hidden" name="hr_anio" id="hr_anio" value="<?php echo $ano; ?>" size="32" />
        <?php echo $tNGs->displayFieldHint("hr_anio");?> <?php echo $tNGs->displayFieldError("hoja_ruta", "hr_anio"); ?></td>
      </tr>
      <tr>
        <td class="KT_th"><label for="">NOMBRES:</label></td>
        <td><select name="hr_nit_contra_ta" id="hr_nit_contra_ta">
          <?php
do {  
?>
          <option value="<?php echo $row_rsempresas['contractor_doc_id']?>"><?php echo $row_rsempresas['contractor_name']?></option>
          <?php
} while ($row_rsempresas = mysql_fetch_assoc($rsempresas));
  $rows = mysql_num_rows($rsempresas);
  if($rows > 0) {
      mysql_data_seek($rsempresas, 0);
	  $row_rsempresas = mysql_fetch_assoc($rsempresas);
  }
?>
        </select>
        <?php echo $tNGs->displayFieldHint("hr_nit_contra_ta");?> <?php echo $tNGs->displayFieldError("hoja_ruta", "hr_nit_contra_ta"); ?> </td>
      </tr>
      <tr>
        <td class="KT_th"><label for="hr_asunto">CONCEPTO:</label></td>
        <td><textarea name="hr_asunto" cols="40" rows="4" id="hr_asunto"><?php echo $row_rsinfopago['ctrlpagos_desc']; ?></textarea>
            <?php echo $tNGs->displayFieldHint("hr_asunto");?> <?php echo $tNGs->displayFieldError("hoja_ruta", "hr_asunto"); ?>
            <input type="hidden" name="hr_fechaingreso" id="hr_fechaingreso" value="<?php echo $fechac; ?>" size="32" />
            <?php echo $tNGs->displayFieldHint("hr_fechaingreso");?> <?php echo $tNGs->displayFieldError("hoja_ruta", "hr_fechaingreso"); ?>
            <input name="hr_fecha_salida" type="hidden" id="hr_fecha_salida" value="<?php echo $fechac; ?>" size="32" />
            <?php echo $tNGs->displayFieldHint("hr_fecha_salida");?> <?php echo $tNGs->displayFieldError("hoja_ruta", "hr_fecha_salida"); ?>
            <input type="hidden" name="hr_estado_firma" id="hr_estado_firma" value="N" size="32" />
            <?php echo $tNGs->displayFieldHint("hr_estado_firma");?> <?php echo $tNGs->displayFieldError("hoja_ruta", "hr_estado_firma"); ?>
            <input type="hidden" name="sys_user" id="sys_user" value="<?php echo $_SESSION['kt_login_user']; ?>" size="32" />
            <?php echo $tNGs->displayFieldHint("sys_user");?> <?php echo $tNGs->displayFieldError("hoja_ruta", "sys_user"); ?>
            <input type="hidden" name="sys_user_actual" id="sys_user_actual" value="<?php echo $_SESSION['kt_login_user']; ?>" size="32" />
            <?php echo $tNGs->displayFieldHint("sys_user_actual");?> <?php echo $tNGs->displayFieldError("hoja_ruta", "sys_user_actual"); ?>
            <input type="hidden" name="sys_fecha_reg" id="sys_fecha_reg" value="<?php echo $fechac; ?>" size="32" />
        <?php echo $tNGs->displayFieldHint("sys_fecha_reg");?> <?php echo $tNGs->displayFieldError("hoja_ruta", "sys_fecha_reg"); ?> </td>
      </tr>
      <tr>
        <td class="KT_th"><label for="hr_valor">VALOR:</label></td>
        <td><input type="text" name="hr_valor" id="hr_valor" value="<?php echo $row_rsinfopago['ctrlpagos_valor']; ?>" size="32" />
            <?php echo $tNGs->displayFieldHint("hr_valor");?> <?php echo $tNGs->displayFieldError("hoja_ruta", "hr_valor"); ?></td>
      </tr>
      <tr class="KT_buttons">
        <td colspan="2"><hr />
        </td>
      </tr>
      <tr>
        <td class="KT_th">FECHA</td>
        <td><input type="hidden" name="evento_type" id="evento_type" value="1" size="32" />
            <?php echo $tNGs->displayFieldHint("evento_type");?> <?php echo $tNGs->displayFieldError("hoja_ruta_event", "evento_type"); ?>
            <input name="evento_fechaa" type="text" id="evento_fechaa" value="<?php echo $fechac; ?>" size="32" readonly="true" />
            <?php echo $tNGs->displayFieldHint("evento_fechaa");?> <?php echo $tNGs->displayFieldError("hoja_ruta_event", "evento_fechaa"); ?>
            <input type="hidden" name="evento_obs" id="evento_obs" value="na" size="32" />
            <?php echo $tNGs->displayFieldHint("evento_obs");?> <?php echo $tNGs->displayFieldError("hoja_ruta_event", "evento_obs"); ?>
            <input type="hidden" name="evento_responsable" id="evento_responsable" value="<?php echo $_SESSION['kt_login_user']; ?>" size="32" />
            <?php echo $tNGs->displayFieldHint("evento_responsable");?> <?php echo $tNGs->displayFieldError("hoja_ruta_event", "evento_responsable"); ?>
            <input type="hidden" name="evento_fechaoper" id="evento_fechaoper" value="<?php echo $fechac; ?>" size="32" />
        <?php echo $tNGs->displayFieldHint("evento_fechaoper");?> <?php echo $tNGs->displayFieldError("hoja_ruta_event", "evento_fechaoper"); ?> </td>
      </tr>
      <tr class="KT_buttons">
        <td colspan="2"><input type="submit" name="KT_Insert1" id="KT_Insert1" value="Crear registro" />
        </td>
      </tr>
    </table>
  </form>
  <?php } // Show if recordset empty ?>
<?php if ($totalRows_rsctrl > 0) { // Show if recordset not empty ?>
  <table width="100%" border="0" cellspacing="2" cellpadding="0">
    <tr class="titlemsg2">
      <td>&nbsp;</td>
      <td>El registro ya está vinculado en la en hoja ruta</td>
    </tr>
    <tr class="titlemsg2">
      <td>&nbsp;</td>
      <td>Radicado número: <?php echo $row_rsctrl['hr_id']; ?></td>
    </tr>
  </table>
  <?php } // Show if recordset not empty ?>
<p>&nbsp;</p>

</body>
</html>
<?php
mysql_free_result($rsinfocont);

mysql_free_result($rsinfopago);

mysql_free_result($rsctrl);

mysql_free_result($rsempresas);
?>
