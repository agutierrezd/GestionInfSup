<?php require_once('../Connections/oConnContratos.php'); ?>
<?php require_once('../Connections/oConnUsers.php'); ?>
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
$formValidation->addField("cont_hash_fk", true, "text", "", "", "", "");
$formValidation->addField("idusrglobal_fk", true, "numeric", "", "", "", "");
$formValidation->addField("sys_date", true, "date", "", "", "", "");
$formValidation->addField("sys_time", true, "date", "", "", "", "");
$formValidation->addField("sys_user", true, "text", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger
?>
<?php require_once('../Connections/global.php'); ?>
<?php
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

$colname_rsinfocont = "-1";
if (isset($_GET['id_cont'])) {
  $colname_rsinfocont = $_GET['id_cont'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rsinfocont = sprintf("SELECT * FROM contrato WHERE id_cont = %s", GetSQLValueString($colname_rsinfocont, "int"));
$rsinfocont = mysql_query($query_rsinfocont, $oConnContratos) or die(mysql_error());
$row_rsinfocont = mysql_fetch_assoc($rsinfocont);
$totalRows_rsinfocont = mysql_num_rows($rsinfocont);

mysql_select_db($database_oConnUsers, $oConnUsers);
$query_rslistsup = "SELECT idusrglobal, usr_name, usr_lname, global_rol_contratos FROM global_users WHERE global_rol_contratos = 3 AND usr_status = 1 ORDER BY usr_name ASC";
$rslistsup = mysql_query($query_rslistsup, $oConnUsers) or die(mysql_error());
$row_rslistsup = mysql_fetch_assoc($rslistsup);
$totalRows_rslistsup = mysql_num_rows($rslistsup);

$colname_rsrestrictc = "-1";
if (isset($_GET['id_cont'])) {
  $colname_rsrestrictc = $_GET['id_cont'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rsrestrictc = sprintf("SELECT * FROM contrato_attached WHERE id_cont_fk = %s AND att_type = 2", GetSQLValueString($colname_rsrestrictc, "int"));
$rsrestrictc = mysql_query($query_rsrestrictc, $oConnContratos) or die(mysql_error());
$row_rsrestrictc = mysql_fetch_assoc($rsrestrictc);
$totalRows_rsrestrictc = mysql_num_rows($rsrestrictc);

$colname_rsrestricts = "-1";
if (isset($_GET['id_cont'])) {
  $colname_rsrestricts = $_GET['id_cont'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rsrestricts = sprintf("SELECT * FROM contrato_attached WHERE id_cont_fk = %s  AND att_type = 3", GetSQLValueString($colname_rsrestricts, "int"));
$rsrestricts = mysql_query($query_rsrestricts, $oConnContratos) or die(mysql_error());
$row_rsrestricts = mysql_fetch_assoc($rsrestricts);
$totalRows_rsrestricts = mysql_num_rows($rsrestricts);

// Make an insert transaction instance
$ins_interventor_interno = new tNG_multipleInsert($conn_oConnContratos);
$tNGs->addTransaction($ins_interventor_interno);
// Register triggers
$ins_interventor_interno->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_interventor_interno->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_interventor_interno->registerTrigger("END", "Trigger_Default_Redirect", 99, "ok.php");
// Add columns
$ins_interventor_interno->setTable("interventor_interno");
$ins_interventor_interno->addColumn("id_cont_fk", "NUMERIC_TYPE", "POST", "id_cont_fk");
$ins_interventor_interno->addColumn("sup_status", "NUMERIC_TYPE", "POST", "sup_estado");
$ins_interventor_interno->addColumn("cont_hash_fk", "STRING_TYPE", "POST", "cont_hash_fk");
$ins_interventor_interno->addColumn("idusrglobal_fk", "NUMERIC_TYPE", "POST", "idusrglobal_fk");
$ins_interventor_interno->addColumn("sys_date", "DATE_TYPE", "POST", "sys_date");
$ins_interventor_interno->addColumn("sys_time", "DATE_TYPE", "POST", "sys_time");
$ins_interventor_interno->addColumn("sys_user", "STRING_TYPE", "POST", "sys_user");
$ins_interventor_interno->setPrimaryKey("interventor_id", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_interventor_interno = new tNG_multipleUpdate($conn_oConnContratos);
$tNGs->addTransaction($upd_interventor_interno);
// Register triggers
$upd_interventor_interno->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_interventor_interno->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_interventor_interno->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$upd_interventor_interno->setTable("interventor_interno");
$upd_interventor_interno->addColumn("id_cont_fk", "NUMERIC_TYPE", "POST", "id_cont_fk");
$upd_interventor_interno->addColumn("cont_hash_fk", "STRING_TYPE", "POST", "cont_hash_fk");
$upd_interventor_interno->addColumn("idusrglobal_fk", "NUMERIC_TYPE", "POST", "idusrglobal_fk");
$upd_interventor_interno->addColumn("sys_date", "DATE_TYPE", "POST", "sys_date");
$upd_interventor_interno->addColumn("sys_time", "DATE_TYPE", "POST", "sys_time");
$upd_interventor_interno->addColumn("sys_user", "STRING_TYPE", "POST", "sys_user");
$upd_interventor_interno->setPrimaryKey("interventor_id", "NUMERIC_TYPE", "GET", "interventor_id");

// Make an instance of the transaction object
$del_interventor_interno = new tNG_multipleDelete($conn_oConnContratos);
$tNGs->addTransaction($del_interventor_interno);
// Register triggers
$del_interventor_interno->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_interventor_interno->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$del_interventor_interno->setTable("interventor_interno");
$del_interventor_interno->setPrimaryKey("interventor_id", "NUMERIC_TYPE", "GET", "interventor_id");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsinterventor_interno = $tNGs->getRecordset("interventor_interno");
$row_rsinterventor_interno = mysql_fetch_assoc($rsinterventor_interno);
$totalRows_rsinterventor_interno = mysql_num_rows($rsinterventor_interno);
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
<script src="../_jquery/_desktop/_app/jquery-1.9.1.js"></script>
<link href="../_css/jqueryslidemenu.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../_css/messages.css" type="text/css" media="screen" title="default" />
<script src="../_js/messages.js" type="text/javascript"></script>
</head>

<body>
<?php if ($totalRows_rsrestrictc == 0) { // Show if recordset empty ?>
  <div id="message-red">
    
    <table border="0" width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td class="red-left">No puede asignar supervisor ya que no existe el CONTRATO adjunto</td>
        <td class="red-right"><a class="close-red"><img src="../img_mcit/icon_close_red.gif"   alt="" /></a></td>
      </tr>
      </table>
  </div>
  <?php } // Show if recordset empty ?>
<!--fin -->
<?php if ($totalRows_rsrestricts == 0) { // Show if recordset empty ?>
  <div id="message-red">
    <table border="0" width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td class="red-left">No puede asignar supervisor ya que no existen los SOPORTES AL CONTRATO adjuntos</td>
        <td class="red-right"><a class="close-red"><img src="../img_mcit/icon_close_red.gif"   alt="" /></a></td>
      </tr>
    </table>
  </div>
  <?php } // Show if recordset empty ?>
<p>
  <?php
	echo $tNGs->getErrorMsg();
?>
</p>


<?php 
// Show IF Conditional region4 
if ($row_rsrestrictc['att_type'] == 2 and $row_rsrestricts['att_type'] == 3) {
?>
  <div class="KT_tng">
    <h1>
      <?php 
// Show IF Conditional region1 
if (@$_GET['interventor_id'] == "") {
?>
        Asignar supervisor
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
if (@$totalRows_rsinterventor_interno > 1) {
?>
            <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
            <?php } 
// endif Conditional region1
?>
          <table cellpadding="2" cellspacing="0" class="KT_tngtable">
            <tr>
              <td width="13%" class="KT_th">&nbsp;</td>
              <td width="87%"><input name="id_cont_fk_<?php echo $cnt1; ?>" type="hidden" id="id_cont_fk_<?php echo $cnt1; ?>" value="<?php echo $row_rsinfocont['id_cont']; ?>" size="7" />
                <?php echo $tNGs->displayFieldHint("id_cont_fk");?> <?php echo $tNGs->displayFieldError("interventor_interno", "id_cont_fk", $cnt1); ?>
                <input name="cont_hash_fk_<?php echo $cnt1; ?>" type="hidden" id="cont_hash_fk_<?php echo $cnt1; ?>" value="<?php echo $row_rsinfocont['cont_hash']; ?>" size="10" maxlength="10" />
                <?php echo $tNGs->displayFieldHint("cont_hash_fk");?> <?php echo $tNGs->displayFieldError("interventor_interno", "cont_hash_fk", $cnt1); ?><span class="titlemsg2">Contrato: <?php echo $row_rsinfocont['pre_contnumero']; ?><?php echo $row_rsinfocont['contnumero']; ?> de <?php echo $row_rsinfocont['cont_ano']; ?></span></td>
            </tr>
            <tr>
              <td class="KT_th"><label for="idusrglobal_fk_<?php echo $cnt1; ?>">Seleccione el supervisor:</label></td>
              <td><select name="idusrglobal_fk_<?php echo $cnt1; ?>" id="idusrglobal_fk_<?php echo $cnt1; ?>">
                <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                <?php 
do {  
?>
                <option value="<?php echo $row_rslistsup['idusrglobal']?>"<?php if (!(strcmp($row_rslistsup['idusrglobal'], $row_rsinterventor_interno['idusrglobal_fk']))) {echo "SELECTED";} ?>><?php echo $row_rslistsup['usr_name']." ".$row_rslistsup['usr_lname']?></option>
                <?php
} while ($row_rslistsup = mysql_fetch_assoc($rslistsup));
  $rows = mysql_num_rows($rslistsup);
  if($rows > 0) {
      mysql_data_seek($rslistsup, 0);
	  $row_rslistsup = mysql_fetch_assoc($rslistsup);
  }
?>
              </select>
                  <?php echo $tNGs->displayFieldError("interventor_interno", "idusrglobal_fk", $cnt1); ?> </td>
            </tr>
            <tr>
              <td class="KT_th">&nbsp;</td>
              <td><input type="hidden" name="sys_date_<?php echo $cnt1; ?>" id="sys_date_<?php echo $cnt1; ?>" value="<?php echo $fecha; ?>" size="10" maxlength="22" />
                  <?php echo $tNGs->displayFieldHint("sys_date");?> <?php echo $tNGs->displayFieldError("interventor_interno", "sys_date", $cnt1); ?>
                  <input type="hidden" name="sys_time_<?php echo $cnt1; ?>" id="sys_time_<?php echo $cnt1; ?>" value="<?php echo $hora; ?>" size="10" maxlength="22" />
                  <?php echo $tNGs->displayFieldHint("sys_time");?> <?php echo $tNGs->displayFieldError("interventor_interno", "sys_time", $cnt1); ?>
                  <input name="sys_user_<?php echo $cnt1; ?>" type="hidden" id="sys_user_<?php echo $cnt1; ?>" value="<?php echo $_SESSION['kt_login_user']; ?>" size="32" maxlength="60" />
                  <?php echo $tNGs->displayFieldHint("sys_user");?> <?php echo $tNGs->displayFieldError("interventor_interno", "sys_user", $cnt1); ?>
              <input name="sup_estado" type="hidden" id="sup_estado" value="0" /></td>
            </tr>
          </table>
          <input type="hidden" name="kt_pk_interventor_interno_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rsinterventor_interno['kt_pk_interventor_interno']); ?>" />
          <?php } while ($row_rsinterventor_interno = mysql_fetch_assoc($rsinterventor_interno)); ?>
        <div class="KT_bottombuttons">
          <div>
            <?php 
      // Show IF Conditional region1
      if (@$_GET['interventor_id'] == "") {
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
          </div>
        </div>
      </form>
    </div>
    <br class="clearfixplain" />
      </div>
  <?php } 
// endif Conditional region4
?><p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($rsinfocont);

mysql_free_result($rslistsup);

mysql_free_result($rsrestrictc);

mysql_free_result($rsrestricts);
?>
