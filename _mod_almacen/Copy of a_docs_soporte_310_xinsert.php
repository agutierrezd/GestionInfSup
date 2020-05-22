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
$formValidation->addField("almovconsdia_id_fk", true, "numeric", "", "", "", "");
$formValidation->addField("sys_document_func", true, "text", "", "", "", "");
$formValidation->addField("almovconsdiae_cantidad", true, "numeric", "", "", "", "");
$formValidation->addField("sys_doclasedoc_id_fk", true, "numeric", "", "", "", "");
$formValidation->addField("sys_user", true, "text", "", "", "", "");
$formValidation->addField("sys_fecha", true, "date", "", "", "", "");
$formValidation->addField("sys_time", true, "date", "", "", "", "");
$formValidation->addField("sys_status", true, "numeric", "", "", "", "");
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

$colname_rsinfoctrl = "-1";
if (isset($_GET['almovconsdia_id'])) {
  $colname_rsinfoctrl = $_GET['almovconsdia_id'];
}
mysql_select_db($database_oConnAlmacen, $oConnAlmacen);
$query_rsinfoctrl = sprintf("SELECT * FROM almovconsdia WHERE almovconsdia_id = %s", GetSQLValueString($colname_rsinfoctrl, "int"));
$rsinfoctrl = mysql_query($query_rsinfoctrl, $oConnAlmacen) or die(mysql_error());
$row_rsinfoctrl = mysql_fetch_assoc($rsinfoctrl);
$totalRows_rsinfoctrl = mysql_num_rows($rsinfoctrl);

// Make an insert transaction instance
$ins_almovconsdiae = new tNG_multipleInsert($conn_oConnAlmacen);
$tNGs->addTransaction($ins_almovconsdiae);
// Register triggers
$ins_almovconsdiae->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_almovconsdiae->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_almovconsdiae->registerTrigger("END", "Trigger_Default_Redirect", 99, "transact_consumo_saldo.php?almovconsdia_id={GET.almovconsdia_id}");
// Add columns
$ins_almovconsdiae->setTable("almovconsdiae");
$ins_almovconsdiae->addColumn("almovconsdia_id_fk", "NUMERIC_TYPE", "POST", "almovconsdia_id_fk");
$ins_almovconsdiae->addColumn("sys_document_func", "STRING_TYPE", "POST", "sys_document_func");
$ins_almovconsdiae->addColumn("almovconsdiae_cantidad", "NUMERIC_TYPE", "POST", "almovconsdiae_cantidad");
$ins_almovconsdiae->addColumn("sys_doclasedoc_id_fk", "NUMERIC_TYPE", "POST", "sys_doclasedoc_id_fk");
$ins_almovconsdiae->addColumn("sys_user", "STRING_TYPE", "POST", "sys_user");
$ins_almovconsdiae->addColumn("sys_fecha", "DATE_TYPE", "POST", "sys_fecha");
$ins_almovconsdiae->addColumn("sys_time", "DATE_TYPE", "POST", "sys_time");
$ins_almovconsdiae->addColumn("sys_status", "NUMERIC_TYPE", "POST", "sys_status");
$ins_almovconsdiae->setPrimaryKey("almovconsdiae_id", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_almovconsdiae = new tNG_multipleUpdate($conn_oConnAlmacen);
$tNGs->addTransaction($upd_almovconsdiae);
// Register triggers
$upd_almovconsdiae->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_almovconsdiae->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_almovconsdiae->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$upd_almovconsdiae->setTable("almovconsdiae");
$upd_almovconsdiae->addColumn("almovconsdia_id_fk", "NUMERIC_TYPE", "POST", "almovconsdia_id_fk");
$upd_almovconsdiae->addColumn("sys_document_func", "STRING_TYPE", "POST", "sys_document_func");
$upd_almovconsdiae->addColumn("almovconsdiae_cantidad", "NUMERIC_TYPE", "POST", "almovconsdiae_cantidad");
$upd_almovconsdiae->addColumn("sys_doclasedoc_id_fk", "NUMERIC_TYPE", "POST", "sys_doclasedoc_id_fk");
$upd_almovconsdiae->addColumn("sys_user", "STRING_TYPE", "POST", "sys_user");
$upd_almovconsdiae->addColumn("sys_fecha", "DATE_TYPE", "POST", "sys_fecha");
$upd_almovconsdiae->addColumn("sys_time", "DATE_TYPE", "POST", "sys_time");
$upd_almovconsdiae->addColumn("sys_status", "NUMERIC_TYPE", "POST", "sys_status");
$upd_almovconsdiae->setPrimaryKey("almovconsdiae_id", "NUMERIC_TYPE", "GET", "almovconsdiae_id");

// Make an instance of the transaction object
$del_almovconsdiae = new tNG_multipleDelete($conn_oConnAlmacen);
$tNGs->addTransaction($del_almovconsdiae);
// Register triggers
$del_almovconsdiae->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_almovconsdiae->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$del_almovconsdiae->setTable("almovconsdiae");
$del_almovconsdiae->setPrimaryKey("almovconsdiae_id", "NUMERIC_TYPE", "GET", "almovconsdiae_id");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsalmovconsdiae = $tNGs->getRecordset("almovconsdiae");
$row_rsalmovconsdiae = mysql_fetch_assoc($rsalmovconsdiae);
$totalRows_rsalmovconsdiae = mysql_num_rows($rsalmovconsdiae);
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
</head>

<body>
<?php
	echo $tNGs->getErrorMsg();
?>
<div class="KT_tng">
  <h1>
    <?php 
// Show IF Conditional region1 
if (@$_GET['almovconsdiae_id'] == "") {
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
if (@$totalRows_rsalmovconsdiae > 1) {
?>
          <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
          <?php } 
// endif Conditional region1
?>
        <table cellpadding="2" cellspacing="0" class="KT_tngtable">
          <tr>
            <td width="40%" class="KT_th">&nbsp;</td>
      <td width="60%"><input name="almovconsdia_id_fk_<?php echo $cnt1; ?>" type="hidden" id="almovconsdia_id_fk_<?php echo $cnt1; ?>" value="<?php echo $_GET['almovconsdia_id']; ?>" size="7" />
                <?php echo $tNGs->displayFieldHint("almovconsdia_id_fk");?> <?php echo $tNGs->displayFieldError("almovconsdiae", "almovconsdia_id_fk", $cnt1); ?> <input name="sys_document_func_<?php echo $cnt1; ?>" type="hidden" id="sys_document_func_<?php echo $cnt1; ?>" value="<?php echo $_GET['numdocumento']; ?>" size="20" maxlength="20" />
                <?php echo $tNGs->displayFieldHint("sys_document_func");?> <?php echo $tNGs->displayFieldError("almovconsdiae", "sys_document_func", $cnt1); ?> Cantidad m&aacute;xima a solicitar <?php echo $row_rsinfoctrl['mcd_saldant']; ?></td>
          </tr>
          
          <tr>
            <td class="KT_th"><label for="almovconsdiae_cantidad_<?php echo $cnt1; ?>">ASIGNAR CANTIDAD:</label></td>
            <td><input type="text" name="almovconsdiae_cantidad_<?php echo $cnt1; ?>" id="almovconsdiae_cantidad_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsalmovconsdiae['almovconsdiae_cantidad']); ?>" size="7" />
                <?php echo $tNGs->displayFieldHint("almovconsdiae_cantidad");?> <?php echo $tNGs->displayFieldError("almovconsdiae", "almovconsdiae_cantidad", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th">&nbsp;</td>
        <td><input name="sys_doclasedoc_id_fk_<?php echo $cnt1; ?>" type="hidden" id="sys_doclasedoc_id_fk_<?php echo $cnt1; ?>" value="<?php echo $_GET['doclasedoc_id']; ?>" size="7" />
                <?php echo $tNGs->displayFieldHint("sys_doclasedoc_id_fk");?> <?php echo $tNGs->displayFieldError("almovconsdiae", "sys_doclasedoc_id_fk", $cnt1); ?> <input name="sys_user_<?php echo $cnt1; ?>" type="hidden" id="sys_user_<?php echo $cnt1; ?>" value="<?php echo $_SESSION['kt_login_user']; ?>" size="32" maxlength="60" />
                <?php echo $tNGs->displayFieldHint("sys_user");?> <?php echo $tNGs->displayFieldError("almovconsdiae", "sys_user", $cnt1); ?> <input type="hidden" name="sys_fecha_<?php echo $cnt1; ?>" id="sys_fecha_<?php echo $cnt1; ?>" value="<?php echo $fecha; ?>" size="10" maxlength="22" />
                <?php echo $tNGs->displayFieldHint("sys_fecha");?> <?php echo $tNGs->displayFieldError("almovconsdiae", "sys_fecha", $cnt1); ?> <input type="hidden" name="sys_time_<?php echo $cnt1; ?>" id="sys_time_<?php echo $cnt1; ?>" value="<?php echo $hora; ?>" size="10" maxlength="22" />
                <?php echo $tNGs->displayFieldHint("sys_time");?> <?php echo $tNGs->displayFieldError("almovconsdiae", "sys_time", $cnt1); ?> <input type="hidden" name="sys_status_<?php echo $cnt1; ?>" id="sys_status_<?php echo $cnt1; ?>" value="1" size="2" />
                <?php echo $tNGs->displayFieldHint("sys_status");?> <?php echo $tNGs->displayFieldError("almovconsdiae", "sys_status", $cnt1); ?> </td>
          </tr>
        </table>
        <input type="hidden" name="kt_pk_almovconsdiae_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rsalmovconsdiae['kt_pk_almovconsdiae']); ?>" />
        <?php } while ($row_rsalmovconsdiae = mysql_fetch_assoc($rsalmovconsdiae)); ?>
      <div class="KT_bottombuttons">
        <div>
          <?php 
      // Show IF Conditional region1
      if (@$_GET['almovconsdiae_id'] == "") {
      ?>
            <input type="submit" name="KT_Insert1" id="KT_Insert1" value="<?php echo NXT_getResource("Insert_FB"); ?>" />
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
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($rsinfoctrl);
?>
