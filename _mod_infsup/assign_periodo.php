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
$formValidation->addField("cont_periodicidad", true, "numeric", "", "", "", "");
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

mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rsperidicidad = "SELECT * FROM interventor_periodos";
$rsperidicidad = mysql_query($query_rsperidicidad, $oConnContratos) or die(mysql_error());
$row_rsperidicidad = mysql_fetch_assoc($rsperidicidad);
$totalRows_rsperidicidad = mysql_num_rows($rsperidicidad);

$colname_rsinfo = "-1";
if (isset($_GET['id_cont'])) {
  $colname_rsinfo = $_GET['id_cont'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rsinfo = sprintf("SELECT * FROM q_001_dashboard WHERE id_cont = %s", GetSQLValueString($colname_rsinfo, "int"));
$rsinfo = mysql_query($query_rsinfo, $oConnContratos) or die(mysql_error());
$row_rsinfo = mysql_fetch_assoc($rsinfo);
$totalRows_rsinfo = mysql_num_rows($rsinfo);

// Make an insert transaction instance
$ins_contrato = new tNG_multipleInsert($conn_oConnContratos);
$tNGs->addTransaction($ins_contrato);
// Register triggers
$ins_contrato->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_contrato->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_contrato->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$ins_contrato->setTable("contrato");
$ins_contrato->addColumn("cont_periodicidad", "NUMERIC_TYPE", "POST", "cont_periodicidad");
$ins_contrato->setPrimaryKey("id_cont", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_contrato = new tNG_multipleUpdate($conn_oConnContratos);
$tNGs->addTransaction($upd_contrato);
// Register triggers
$upd_contrato->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_contrato->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_contrato->registerTrigger("END", "Trigger_Default_Redirect", 99, "assign_periodo_2.php?id_cont={GET.id_cont}");
// Add columns
$upd_contrato->setTable("contrato");
$upd_contrato->addColumn("cont_periodicidad", "NUMERIC_TYPE", "POST", "cont_periodicidad");
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
<table width="100%" border="0" cellspacing="2" cellpadding="0">
  <tr>
    <td width="50%" class="titlemsg2">Contrato:</td>
    <td width="50%" class="titlemsg2"><?php echo $row_rsinfo['CONTRATOID']; ?></td>
  </tr>
  <tr>
    <td class="titlemsg2">Fecha inicio:</td>
    <td class="titlemsg2"><?php echo $row_rsinfo['FECHAI']; ?></td>
  </tr>
  <tr>
    <td class="titlemsg2">Fecha final:</td>
    <td class="titlemsg2"><?php echo $row_rsinfo['FECHAF']; ?></td>
  </tr>
  <tr>
    <td class="titlemsg2">Dias contratados:</td>
    <td class="titlemsg2"><?php echo $row_rsinfo['QTYDIAS']; ?></td>
  </tr>
</table>
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
    Contrato </h1>
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
            <td class="KT_th"><label for="cont_periodicidad_<?php echo $cnt1; ?>">Seleccionar periodicidad:</label></td>
            <td><select name="cont_periodicidad_<?php echo $cnt1; ?>" id="cont_periodicidad_<?php echo $cnt1; ?>">
              <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
              <?php 
do {  
?>
              <option value="<?php echo $row_rsperidicidad['id_periodo']?>"<?php if (!(strcmp($row_rsperidicidad['id_periodo'], $row_rscontrato['cont_periodicidad']))) {echo "SELECTED";} ?>><?php echo $row_rsperidicidad['periodo_name']?></option>
              <?php
} while ($row_rsperidicidad = mysql_fetch_assoc($rsperidicidad));
  $rows = mysql_num_rows($rsperidicidad);
  if($rows > 0) {
      mysql_data_seek($rsperidicidad, 0);
	  $row_rsperidicidad = mysql_fetch_assoc($rsperidicidad);
  }
?>
            </select>
                <?php echo $tNGs->displayFieldError("contrato", "cont_periodicidad", $cnt1); ?> </td>
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
            <input type="submit" name="KT_Update1" value="Continuar" />
            <?php }
      // endif Conditional region1
      ?>
        </div>
      </div>
    </form>
  </div>
  <br class="clearfixplain" />
</div>
<br />


<br />
<br />
<br />
<br />


</body>
</html>
<?php
mysql_free_result($rsperidicidad);

mysql_free_result($rsinfo);
?>
