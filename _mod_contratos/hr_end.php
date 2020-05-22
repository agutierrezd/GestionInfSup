<?php require_once('../Connections/oConnContratos.php'); ?>
<?php
//MX Widgets3 include
require_once('../includes/wdg/WDG.php');

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
$formValidation = new tNG_FormValidation();
$formValidation->addField("hr_estado_firma", true, "text", "", "", "", "");
$formValidation->addField("hr_estado_numero", true, "text", "", "", "", "");
$formValidation->addField("hr_estado_fecha", true, "date", "", "", "", "");
$formValidation->addField("hr_estado_user", true, "text", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

// Make an update transaction instance
$upd_hoja_ruta_2015 = new tNG_update($conn_oConnContratos);
$tNGs->addTransaction($upd_hoja_ruta_2015);
// Register triggers
$upd_hoja_ruta_2015->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_hoja_ruta_2015->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_hoja_ruta_2015->registerTrigger("END", "Trigger_Default_Redirect", 99, "ok.php");
// Add columns
$upd_hoja_ruta_2015->setTable("hoja_ruta_2015");
$upd_hoja_ruta_2015->addColumn("hr_estado_firma", "STRING_TYPE", "POST", "hr_estado_firma");
$upd_hoja_ruta_2015->addColumn("hr_estado_numero", "STRING_TYPE", "POST", "hr_estado_numero");
$upd_hoja_ruta_2015->addColumn("hr_estado_fecha", "DATE_TYPE", "POST", "hr_estado_fecha");
$upd_hoja_ruta_2015->addColumn("hr_estado_user", "STRING_TYPE", "POST", "hr_estado_user");
$upd_hoja_ruta_2015->setPrimaryKey("hr_id", "NUMERIC_TYPE", "GET", "hr_id");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rshoja_ruta_2015 = $tNGs->getRecordset("hoja_ruta_2015");
$row_rshoja_ruta_2015 = mysql_fetch_assoc($rshoja_ruta_2015);
$totalRows_rshoja_ruta_2015 = mysql_num_rows($rshoja_ruta_2015);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:wdg="http://ns.adobe.com/addt">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script src="../includes/skins/style.js" type="text/javascript"></script>
<?php echo $tNGs->displayValidationRules();?>
<script type="text/javascript" src="../includes/common/js/sigslot_core.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="../includes/wdg/classes/Calendar.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/SmartDate.js"></script>
<script type="text/javascript" src="../includes/wdg/calendar/calendar_stripped.js"></script>
<script type="text/javascript" src="../includes/wdg/calendar/calendar-setup_stripped.js"></script>
<script src="../includes/resources/calendar.js"></script>
</head>

<body>
<?php
	echo $tNGs->getErrorMsg();
?>
<form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
  <table cellpadding="2" cellspacing="0" class="KT_tngtable">
    <tr>
      <td width="38%" class="KT_th">Hoja ruta No.</td>
      <td width="62%"><input name="hr_estado_firma" type="hidden" id="hr_estado_firma" value="S" />
          <?php echo $tNGs->displayFieldHint("hr_estado_firma");?> <?php echo $tNGs->displayFieldError("hoja_ruta_2015", "hr_estado_firma"); ?> <?php echo $_GET['hr_id']; ?></td>
    </tr>
    <tr>
      <td class="KT_th"><label for="hr_estado_numero">Número de comprobante:</label></td>
      <td><input type="text" name="hr_estado_numero" id="hr_estado_numero" value="<?php echo KT_escapeAttribute($row_rshoja_ruta_2015['hr_estado_numero']); ?>" size="32" />
          <?php echo $tNGs->displayFieldHint("hr_estado_numero");?> <?php echo $tNGs->displayFieldError("hoja_ruta_2015", "hr_estado_numero"); ?> </td>
    </tr>
    <tr>
      <td class="KT_th"><label for="hr_estado_fecha">Fecha de comprobante:</label></td>
      <td><input type="text" name="hr_estado_fecha" id="hr_estado_fecha" value="<?php echo KT_formatDate($row_rshoja_ruta_2015['hr_estado_fecha']); ?>" size="32" wdg:mondayfirst="false" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:type="widget" wdg:singleclick="false" wdg:restricttomask="yes" />
          <?php echo $tNGs->displayFieldHint("hr_estado_fecha");?> <?php echo $tNGs->displayFieldError("hoja_ruta_2015", "hr_estado_fecha"); ?> </td>
    </tr>
    <tr>
      <td class="KT_th">&nbsp;</td>
      <td><input name="hr_estado_user" type="hidden" id="hr_estado_user" value="<?php echo $_SESSION['kt_login_user']; ?>" />
          <?php echo $tNGs->displayFieldHint("hr_estado_user");?> <?php echo $tNGs->displayFieldError("hoja_ruta_2015", "hr_estado_user"); ?> </td>
    </tr>
    <tr class="KT_buttons">
      <td colspan="2"><input type="submit" name="KT_Update1" id="KT_Update1" value="Guardar" />
      </td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
</body>
</html>
