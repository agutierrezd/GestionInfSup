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

// Load the KT_back class
require_once('../includes/nxt/KT_back.php');

// Make a transaction dispatcher instance
$tNGs = new tNG_dispatcher("../");

// Make unified connection variable
$conn_oConnContratos = new KT_connection($oConnContratos, $database_oConnContratos);

// Start trigger
$formValidation = new tNG_FormValidation();
$formValidation->addField("id_cont_fk", true, "numeric", "", "", "", "");
$formValidation->addField("os_type_type", true, "numeric", "", "", "", "");
$formValidation->addField("os_fecha", true, "date", "", "", "", "");
$formValidation->addField("os_valor", true, "double", "", "", "", "");
$formValidation->addField("sys_user", true, "text", "", "", "", "");
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

$colname_rsinfotype = "-1";
if (isset($_GET['otrosi_id'])) {
  $colname_rsinfotype = $_GET['otrosi_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rsinfotype = sprintf("SELECT * FROM contrato_otrosi_type WHERE otrosi_id = %s", GetSQLValueString($colname_rsinfotype, "int"));
$rsinfotype = mysql_query($query_rsinfotype, $oConnContratos) or die(mysql_error());
$row_rsinfotype = mysql_fetch_assoc($rsinfotype);
$totalRows_rsinfotype = mysql_num_rows($rsinfotype);

// Make an insert transaction instance
$ins_contrato_os = new tNG_multipleInsert($conn_oConnContratos);
$tNGs->addTransaction($ins_contrato_os);
// Register triggers
$ins_contrato_os->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_contrato_os->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_contrato_os->registerTrigger("END", "Trigger_Default_Redirect", 99, "ok.php");
// Add columns
$ins_contrato_os->setTable("contrato_os");
$ins_contrato_os->addColumn("id_cont_fk", "NUMERIC_TYPE", "POST", "id_cont_fk");
$ins_contrato_os->addColumn("os_type_type", "NUMERIC_TYPE", "POST", "os_type_type");
$ins_contrato_os->addColumn("os_fecha", "DATE_TYPE", "POST", "os_fecha");
$ins_contrato_os->addColumn("os_valor", "DOUBLE_TYPE", "POST", "os_valor");
$ins_contrato_os->addColumn("sys_user", "STRING_TYPE", "POST", "sys_user");
$ins_contrato_os->setPrimaryKey("os_id", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_contrato_os = new tNG_multipleUpdate($conn_oConnContratos);
$tNGs->addTransaction($upd_contrato_os);
// Register triggers
$upd_contrato_os->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_contrato_os->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_contrato_os->registerTrigger("END", "Trigger_Default_Redirect", 99, "ok.php");
// Add columns
$upd_contrato_os->setTable("contrato_os");
$upd_contrato_os->addColumn("id_cont_fk", "NUMERIC_TYPE", "POST", "id_cont_fk");
$upd_contrato_os->addColumn("os_type_type", "NUMERIC_TYPE", "POST", "os_type_type");
$upd_contrato_os->addColumn("os_fecha", "DATE_TYPE", "POST", "os_fecha");
$upd_contrato_os->addColumn("os_valor", "DOUBLE_TYPE", "POST", "os_valor");
$upd_contrato_os->addColumn("sys_user", "STRING_TYPE", "POST", "sys_user");
$upd_contrato_os->setPrimaryKey("os_id", "NUMERIC_TYPE", "GET", "os_id");

// Make an instance of the transaction object
$del_contrato_os = new tNG_multipleDelete($conn_oConnContratos);
$tNGs->addTransaction($del_contrato_os);
// Register triggers
$del_contrato_os->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_contrato_os->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$del_contrato_os->setTable("contrato_os");
$del_contrato_os->setPrimaryKey("os_id", "NUMERIC_TYPE", "GET", "os_id");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rscontrato_os = $tNGs->getRecordset("contrato_os");
$row_rscontrato_os = mysql_fetch_assoc($rscontrato_os);
$totalRows_rscontrato_os = mysql_num_rows($rscontrato_os);
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
</script>
	<link rel="stylesheet" href="../_jquery/_desktop/_app/themes/south-street/jquery.ui.all.css">
<script src="../_jquery/_desktop/_app/jquery-1.9.1.js"></script>
<script src="../_jquery/_desktop/_app/ui/jquery.ui.core.js"></script>
<script src="../_jquery/_desktop/_app/ui/jquery.ui.widget.js"></script>
<script src="../_jquery/_desktop/_app/ui/jquery.ui.datepicker.js"></script>
	<link rel="stylesheet" href="../_jquery/_desktop/_app/_modules/demos.css">
<script>
	$(function() {
		$( "#os_fecha" ).datepicker({
			changeMonth: true,
			changeYear: true
		});
	});
	</script>
</head>

<body>
<?php
	echo $tNGs->getErrorMsg();
?>
<div class="KT_tng">
  <h1>
    <?php 
// Show IF Conditional region1 
if (@$_GET['os_id'] == "") {
?>
      <?php echo NXT_getResource("Insert_FH"); ?>
      <?php 
// else Conditional region1
} else { ?>
      <?php echo NXT_getResource("Update_FH"); ?>
      <?php } 
// endif Conditional region1
?>
    Contrato_os </h1>
  <div class="KT_tngform">
    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
      <?php $cnt1 = 0; ?>
      <?php do { ?>
        <?php $cnt1++; ?>
        <?php 
// Show IF Conditional region1 
if (@$totalRows_rscontrato_os > 1) {
?>
          <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
          <?php } 
// endif Conditional region1
?>
        <table cellpadding="2" cellspacing="0" class="KT_tngtable">
          <tr>
            <td width="17%" class="KT_th">&nbsp;</td>
            <td width="83%"><input name="id_cont_fk_<?php echo $cnt1; ?>" type="hidden" id="id_cont_fk_<?php echo $cnt1; ?>" value="<?php echo $_GET['doc_id']; ?>" />
                <?php echo $tNGs->displayFieldHint("id_cont_fk");?> <?php echo $tNGs->displayFieldError("contrato_os", "id_cont_fk", $cnt1); ?> <input name="sys_user_<?php echo $cnt1; ?>" type="hidden" id="sys_user_<?php echo $cnt1; ?>" value="<?php echo $_SESSION['kt_login_user']; ?>" />
                <?php echo $tNGs->displayFieldHint("sys_user");?> <?php echo $tNGs->displayFieldError("contrato_os", "sys_user", $cnt1); ?> <input name="os_type_type_<?php echo $cnt1; ?>" type="hidden" id="os_type_type_<?php echo $cnt1; ?>" value="<?php echo $_GET['otrosi_id']; ?>" />
                <?php echo $tNGs->displayFieldHint("os_type_type");?> <?php echo $tNGs->displayFieldError("contrato_os", "os_type_type", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="os_fecha">Fecha en la que se reduce:</label></td>
            <td><input type="text" name="os_fecha" id="os_fecha" value="<?php echo $fecha; ?>" size="10" maxlength="22" />
                <?php echo $tNGs->displayFieldHint("os_fecha");?> <?php echo $tNGs->displayFieldError("contrato_os", "os_fecha", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="os_valor_<?php echo $cnt1; ?>">Valor que se reduce:</label></td>
            <td><input type="text" name="os_valor_<?php echo $cnt1; ?>" id="os_valor_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscontrato_os['os_valor']); ?>" size="15" />
                <?php echo $tNGs->displayFieldHint("os_valor");?> <?php echo $tNGs->displayFieldError("contrato_os", "os_valor", $cnt1); ?> </td>
          </tr>
        </table>
        <input type="hidden" name="kt_pk_contrato_os_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rscontrato_os['kt_pk_contrato_os']); ?>" />
        <?php } while ($row_rscontrato_os = mysql_fetch_assoc($rscontrato_os)); ?>
      <div class="KT_bottombuttons">
        <div>
          <?php 
      // Show IF Conditional region1
      if (@$_GET['os_id'] == "") {
      ?>
            <input type="submit" name="KT_Insert1" id="KT_Insert1" value="Guardar" />
            <?php 
      // else Conditional region1
      } else { ?>
            <input type="submit" name="KT_Update1" value="Modificar" />
            <input type="submit" name="KT_Delete1" value="<?php echo NXT_getResource("Delete_FB"); ?>" onclick="return confirm('<?php echo NXT_getResource("Are you sure?"); ?>');" />
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
mysql_free_result($rsinfotype);
?>
