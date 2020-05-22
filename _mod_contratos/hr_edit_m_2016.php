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
$formValidation->addField("hr_valor", true, "double", "", "", "", "");
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

$colname_RsInfoHR = "-1";
if (isset($_GET['hr_id'])) {
  $colname_RsInfoHR = $_GET['hr_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_RsInfoHR = sprintf("SELECT * FROM q_hoja_ruta_maestra_2016 WHERE hr_id = %s", GetSQLValueString($colname_RsInfoHR, "int"));
$RsInfoHR = mysql_query($query_RsInfoHR, $oConnContratos) or die(mysql_error());
$row_RsInfoHR = mysql_fetch_assoc($RsInfoHR);
$totalRows_RsInfoHR = mysql_num_rows($RsInfoHR);

// Make an insert transaction instance
$ins_hoja_ruta_2016 = new tNG_multipleInsert($conn_oConnContratos);
$tNGs->addTransaction($ins_hoja_ruta_2016);
// Register triggers
$ins_hoja_ruta_2016->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_hoja_ruta_2016->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_hoja_ruta_2016->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$ins_hoja_ruta_2016->setTable("hoja_ruta_2016");
$ins_hoja_ruta_2016->addColumn("hr_valor", "DOUBLE_TYPE", "POST", "hr_valor");
$ins_hoja_ruta_2016->setPrimaryKey("hr_id", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_hoja_ruta_2016 = new tNG_multipleUpdate($conn_oConnContratos);
$tNGs->addTransaction($upd_hoja_ruta_2016);
// Register triggers
$upd_hoja_ruta_2016->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_hoja_ruta_2016->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_hoja_ruta_2016->registerTrigger("END", "Trigger_Default_Redirect", 99, "ok.php");
// Add columns
$upd_hoja_ruta_2016->setTable("hoja_ruta_2016");
$upd_hoja_ruta_2016->addColumn("hr_valor", "DOUBLE_TYPE", "POST", "hr_valor");
$upd_hoja_ruta_2016->setPrimaryKey("hr_id", "NUMERIC_TYPE", "GET", "hr_id");

// Make an instance of the transaction object
$del_hoja_ruta_2016 = new tNG_multipleDelete($conn_oConnContratos);
$tNGs->addTransaction($del_hoja_ruta_2016);
// Register triggers
$del_hoja_ruta_2016->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_hoja_ruta_2016->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$del_hoja_ruta_2016->setTable("hoja_ruta_2016");
$del_hoja_ruta_2016->setPrimaryKey("hr_id", "NUMERIC_TYPE", "GET", "hr_id");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rshoja_ruta_2016 = $tNGs->getRecordset("hoja_ruta_2016");
$row_rshoja_ruta_2016 = mysql_fetch_assoc($rshoja_ruta_2016);
$totalRows_rshoja_ruta_2016 = mysql_num_rows($rshoja_ruta_2016);
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
<link href="../_css/jqueryslidemenu.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php
	echo $tNGs->getErrorMsg();
?>
<div class="KT_tng">
  <h1>
    <?php 
// Show IF Conditional region1 
if (@$_GET['hr_id'] == "") {
?>
      <?php echo NXT_getResource("Insert_FH"); ?>
      <?php 
// else Conditional region1
} else { ?>
      <?php echo NXT_getResource("Update_FH"); ?>
      <?php } 
// endif Conditional region1
?>
    Hoja ruta 2015 </h1>
  <div class="KT_tngform">
    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
      <?php $cnt1 = 0; ?>
      <?php do { ?>
        <?php $cnt1++; ?>
        <?php 
// Show IF Conditional region1 
if (@$totalRows_rshoja_ruta_2016 > 1) {
?>
          <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
          <?php } 
// endif Conditional region1
?>
        <table cellpadding="2" cellspacing="0" class="KT_tngtable">
          <tr>
            <td class="KT_th">No. HR:</td>
            <td><span class="titlemsg2"><?php echo $row_RsInfoHR['hr_id']; ?></span></td>
          </tr>
          <tr>
            <td class="KT_th">Fecha:</td>
            <td><?php echo $row_RsInfoHR['hr_fechaingreso']; ?></td>
          </tr>
          <tr>
            <td class="KT_th">Asunto:</td>
            <td><?php echo $row_RsInfoHR['hr_asunto']; ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="hr_valor_<?php echo $cnt1; ?>">Nuevo valor:</label></td>
            <td><input type="text" name="hr_valor_<?php echo $cnt1; ?>" id="hr_valor_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rshoja_ruta_2016['hr_valor']); ?>" size="20" />
                <?php echo $tNGs->displayFieldHint("hr_valor");?> <?php echo $tNGs->displayFieldError("hoja_ruta_2016", "hr_valor", $cnt1); ?> </td>
          </tr>
        </table>
        <input type="hidden" name="kt_pk_hoja_ruta_2016_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rshoja_ruta_2016['kt_pk_hoja_ruta_2016']); ?>" />
        <?php } while ($row_rshoja_ruta_2016 = mysql_fetch_assoc($rshoja_ruta_2016)); ?>
      <div class="KT_bottombuttons">
        <div>
          <?php 
      // Show IF Conditional region1
      if (@$_GET['hr_id'] == "") {
      ?>
            <input type="submit" name="KT_Insert1" id="KT_Insert1" value="<?php echo NXT_getResource("Insert_FB"); ?>" />
            <?php 
      // else Conditional region1
      } else { ?>
            <input type="submit" name="KT_Update1" value="Guardar" />
            <?php }
      // endif Conditional region1
      ?>
        </div>
      </div>
    </form>
  </div>
  <br class="clearfixplain" />
</div>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($RsInfoHR);
?>
