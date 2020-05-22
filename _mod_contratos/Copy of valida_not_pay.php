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

// Load the tNG classes
require_once('../includes/tng/tNG.inc.php');

// Make a transaction dispatcher instance
$tNGs = new tNG_dispatcher("../");

// Make unified connection variable
$conn_oConnContratos = new KT_connection($oConnContratos, $database_oConnContratos);

// Start trigger
$formValidation = new tNG_FormValidation();
$formValidation->addField("not_status", true, "numeric", "", "", "", "");
$formValidation->addField("not_date", true, "date", "", "", "", "");
$formValidation->addField("not_time", true, "date", "", "", "", "");
$formValidation->addField("not_mail", true, "text", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

//start Trigger_SendEmail trigger
//remove this line if you want to edit the code by hand
function Trigger_SendEmail(&$tNG) {
  $emailObj = new tNG_Email($tNG);
  $emailObj->setFrom("{KT_defaultSender}");
  $emailObj->setTo("{not_mail}");
  $emailObj->setCC("notificaciones@mincit.gov.co");
  $emailObj->setBCC("agutierrezd@mincit.gov.co");
  $emailObj->setSubject("Notificacion de pago Confirmada, Radicado: {RsInfoNotPay.hr_id}");
  //FromFile method
  $emailObj->setContentFile("hr_not_pay_ok.html");
  $emailObj->setEncoding("ISO-8859-1");
  $emailObj->setFormat("HTML/Text");
  $emailObj->setImportance("High");
  return $emailObj->Execute();
}
//end Trigger_SendEmail trigger

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

$colname_RsInfoNotPay = "-1";
if (isset($_GET['hr_id'])) {
  $colname_RsInfoNotPay = $_GET['hr_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_RsInfoNotPay = sprintf("SELECT * FROM q_hoja_ruta_maestra_info_2015 WHERE hr_id = %s", GetSQLValueString($colname_RsInfoNotPay, "int"));
$RsInfoNotPay = mysql_query($query_RsInfoNotPay, $oConnContratos) or die(mysql_error());
$row_RsInfoNotPay = mysql_fetch_assoc($RsInfoNotPay);
$totalRows_RsInfoNotPay = mysql_num_rows($RsInfoNotPay);

// Make an update transaction instance
$upd_hoja_ruta_2015 = new tNG_update($conn_oConnContratos);
$tNGs->addTransaction($upd_hoja_ruta_2015);
// Register triggers
$upd_hoja_ruta_2015->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_hoja_ruta_2015->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_hoja_ruta_2015->registerTrigger("END", "Trigger_Default_Redirect", 99, "completed.php");
$upd_hoja_ruta_2015->registerTrigger("AFTER", "Trigger_SendEmail", 98);
// Add columns
$upd_hoja_ruta_2015->setTable("hoja_ruta_2015");
$upd_hoja_ruta_2015->addColumn("not_status", "NUMERIC_TYPE", "POST", "not_status");
$upd_hoja_ruta_2015->addColumn("not_date", "DATE_TYPE", "POST", "not_date");
$upd_hoja_ruta_2015->addColumn("not_time", "DATE_TYPE", "POST", "not_time");
$upd_hoja_ruta_2015->addColumn("not_mail", "STRING_TYPE", "POST", "not_mail");
$upd_hoja_ruta_2015->setPrimaryKey("hr_id", "NUMERIC_TYPE", "GET", "hr_id");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rshoja_ruta_2015 = $tNGs->getRecordset("hoja_ruta_2015");
$row_rshoja_ruta_2015 = mysql_fetch_assoc($rshoja_ruta_2015);
$totalRows_rshoja_ruta_2015 = mysql_num_rows($rshoja_ruta_2015);

// Download File downloadObj1
$downloadObj1 = new tNG_Download("../", "KT_download1");
// Execute
$downloadObj1->setFolder("../_attach_notificaciones/");
$downloadObj1->setRenameRule("{RsInfoNotPay.send_file}");
$downloadObj1->Execute();
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:: Contrataci&oacute;n :: MinCIT ::.</title>
<link href="../_css/jqueryslidemenu.css" rel="stylesheet" type="text/css" />
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script src="../includes/skins/style.js" type="text/javascript"></script>
<?php echo $tNGs->displayValidationRules();?>
<script type="text/javascript" src="../_jquery/hs/highslide/highslide-with-html.js"></script>
<link rel="stylesheet" type="text/css" href="../_jquery/hs/highslide/highslide.css" />
<script type="text/javascript">
hs.graphicsDir = '../_jquery/hs/highslide/graphics/';
hs.outlineType = 'rounded-white';
hs.wrapperClassName = 'draggable-header';
</script>
<link href="../_css/jqueryslidemenu.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php
  mxi_includes_start("../inc_top_free.php");
  require(basename("../inc_top_free.php"));
  mxi_includes_end();
?>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="2" cellpadding="0">
      <tr>
        <td width="25%" class="frmtablahead">RADICADO</td>
        <td width="75%" class="frmtablabody"><?php echo $row_RsInfoNotPay['hr_id']; ?></td>
      </tr>
      <tr>
        <td class="frmtablahead">OBLIGACION</td>
        <td class="frmtablabody"><?php echo $row_RsInfoNotPay['hrnoypay_obliga_num']; ?></td>
      </tr>
      <tr>
        <td class="frmtablahead">ASUNTO</td>
        <td class="frmtablabody"><?php echo $row_RsInfoNotPay['hr_asunto']; ?></td>
      </tr>
      <tr>
        <td class="frmtablahead">CONTRATO</td>
        <td class="frmtablabody"><?php echo $row_RsInfoNotPay['CONTRATOID']; ?> DE <?php echo $row_RsInfoNotPay['VIGENCIA']; ?></td>
      </tr>
      <tr>
        <td class="frmtablahead">DOCUMENTO</td>
        <td class="frmtablabody"><?php echo $row_RsInfoNotPay['hr_nit_contra_ta']; ?></td>
      </tr>
      <tr>
        <td class="frmtablahead">NOMBRES</td>
        <td class="frmtablabody"><?php echo $row_RsInfoNotPay['contractor_name']; ?></td>
      </tr>
      <tr>
        <td class="frmtablahead">NOTIFICACION</td>
        <td class="frmtablabody"><a href="<?php echo $downloadObj1->getDownloadLink(); ?>">VER NOTIFICACION</a></td>
      </tr>
      <tr>
        <td class="frmtablahead">&nbsp;</td>
        <td class="frmtablabody"><a href="valida_view_deducciones.php?Obligacion=<?php echo $row_RsInfoNotPay['hrnoypay_obliga_num']; ?>&amp;doc=<?php echo $row_RsInfoNotPay['hr_nit_contra_ta']; ?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )">VER HISTORICO DE DEDUCCIONES</a></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><?php 
// Show IF Conditional region2 
if (@$row_RsInfoNotPay['not_status'] == "") {
?>
        <table width="90%" border="0" align="center" cellpadding="0" cellspacing="2">
          <tr>
            <td>&nbsp;
                <?php
	echo $tNGs->getErrorMsg();
?>
                <p>Al aceptar confirmo que la informaci&oacute;n en el adjunto enviado a mi correo electr&oacute;nico con la Hoja de Ruta No.<?php echo $row_RsInfoNotPay['hr_id']; ?> es correcta</p>
              <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
                  <table cellpadding="2" cellspacing="0" class="KT_tngtable">
                    <tr>
                      <td class="KT_th"><label for="not_status_1">Notificarme:</label></td>
                      <td><div>
                          <input <?php if (!(strcmp(KT_escapeAttribute($row_rshoja_ruta_2015['not_status']),"1"))) {echo "CHECKED";} ?> type="radio" name="not_status" id="not_status_1" value="1" />
                          <label for="not_status_1">Si acepto</label>
                        </div>
                          <div>
                            <input <?php if (!(strcmp(KT_escapeAttribute($row_rshoja_ruta_2015['not_status']),"9"))) {echo "CHECKED";} ?> type="radio" name="not_status" id="not_status_2" value="9" />
                            <label for="not_status_2">No acepto</label>
                          </div>
                        <?php echo $tNGs->displayFieldError("hoja_ruta_2015", "not_status"); ?> </td>
                    </tr>
                    <tr>
                      <td class="KT_th"><label for="not_date">Fecha:</label></td>
                      <td><input name="not_date" type="text" id="not_date" value="<?php echo $fecha; ?>" size="32" readonly="true" />
                          <?php echo $tNGs->displayFieldHint("not_date");?> <?php echo $tNGs->displayFieldError("hoja_ruta_2015", "not_date"); ?> </td>
                    </tr>
                    <tr>
                      <td class="KT_th"><label for="not_time">Hora:</label></td>
                      <td><input name="not_time" type="text" id="not_time" value="<?php echo $hora; ?>" size="32" readonly="true" />
                          <?php echo $tNGs->displayFieldHint("not_time");?> <?php echo $tNGs->displayFieldError("hoja_ruta_2015", "not_time"); ?> </td>
                    </tr>
                    <tr>
                      <td class="KT_th">&nbsp;</td>
                      <td><input name="not_mail" type="hidden" id="not_mail" value="llara@mincit.gov.co" />
                          <?php echo $tNGs->displayFieldHint("not_mail");?> <?php echo $tNGs->displayFieldError("hoja_ruta_2015", "not_mail"); ?> </td>
                    </tr>
                    <tr class="KT_buttons">
                      <td colspan="2"><input type="submit" name="KT_Update1" id="KT_Update1" value="Confirmar " />
                      </td>
                    </tr>
                  </table>
              </form>
              <p>&nbsp;</p></td>
          </tr>
        </table>
        <?php } 
// endif Conditional region2
?></td>
  </tr>
  <tr>
    <td><?php 
// Show IF Conditional region1 
if (@$row_RsInfoNotPay['not_status'] == 1) {
?>
        <table width="90%" border="0" align="center" cellpadding="0" cellspacing="2">
          <tr>
            <td class="titlemsg2">La notificaci&oacute;n ya fu&eacute; confirmada con fecha <?php echo $row_RsInfoNotPay['not_date']; ?></td>
          </tr>
        </table>
        <?php } 
// endif Conditional region1
?></td>
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
mysql_free_result($RsInfoNotPay);
?>
