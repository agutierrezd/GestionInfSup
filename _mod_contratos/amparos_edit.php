<?php require_once('../Connections/oConnContratos.php'); ?>
<?php
//MX Widgets3 include
require_once('../includes/wdg/WDG.php');
?>
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
$formValidation->addField("id_att_fk", true, "numeric", "", "", "", "");
$formValidation->addField("poli_numero", true, "text", "", "", "", "");
$formValidation->addField("poli_compania", true, "numeric", "", "", "", "");
$formValidation->addField("poli_fechaexpedicion", true, "date", "", "", "", "");
$formValidation->addField("poli_codamparo", true, "numeric", "", "", "", "");
$formValidation->addField("poli_porcentaje", true, "double", "", "", "", "");
$formValidation->addField("poli_valor", true, "double", "", "", "", "");
$formValidation->addField("poli_vigenciadesde", true, "date", "", "", "", "");
$formValidation->addField("poli_vigenciahasta", true, "date", "", "", "", "");
$formValidation->addField("sys_user", true, "text", "", "", "", "");
$formValidation->addField("sys_date", true, "date", "", "", "", "");
$formValidation->addField("sys_time", true, "date", "", "", "", "");
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
$query_rsaseguradoras = "SELECT * FROM polizas_aseguradoras ORDER BY nom_aseguradora ASC";
$rsaseguradoras = mysql_query($query_rsaseguradoras, $oConnContratos) or die(mysql_error());
$row_rsaseguradoras = mysql_fetch_assoc($rsaseguradoras);
$totalRows_rsaseguradoras = mysql_num_rows($rsaseguradoras);

mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rsamparo = "SELECT * FROM polizas_tipo ORDER BY poliza_type_name ASC";
$rsamparo = mysql_query($query_rsamparo, $oConnContratos) or die(mysql_error());
$row_rsamparo = mysql_fetch_assoc($rsamparo);
$totalRows_rsamparo = mysql_num_rows($rsamparo);

// Make an insert transaction instance
$ins_polizas_master = new tNG_multipleInsert($conn_oConnContratos);
$tNGs->addTransaction($ins_polizas_master);
// Register triggers
$ins_polizas_master->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_polizas_master->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_polizas_master->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$ins_polizas_master->setTable("polizas_master");
$ins_polizas_master->addColumn("id_cont_fk", "NUMERIC_TYPE", "POST", "id_cont_fk");
$ins_polizas_master->addColumn("id_att_fk", "NUMERIC_TYPE", "POST", "id_att_fk");
$ins_polizas_master->addColumn("poli_numero", "STRING_TYPE", "POST", "poli_numero");
$ins_polizas_master->addColumn("poli_compania", "NUMERIC_TYPE", "POST", "poli_compania");
$ins_polizas_master->addColumn("poli_fechaexpedicion", "DATE_TYPE", "POST", "poli_fechaexpedicion");
$ins_polizas_master->addColumn("poli_codamparo", "NUMERIC_TYPE", "POST", "poli_codamparo");
$ins_polizas_master->addColumn("poli_porcentaje", "DOUBLE_TYPE", "POST", "poli_porcentaje");
$ins_polizas_master->addColumn("poli_valor", "DOUBLE_TYPE", "POST", "poli_valor");
$ins_polizas_master->addColumn("poli_vigenciadesde", "DATE_TYPE", "POST", "poli_vigenciadesde");
$ins_polizas_master->addColumn("poli_vigenciahasta", "DATE_TYPE", "POST", "poli_vigenciahasta");
$ins_polizas_master->addColumn("sys_user", "STRING_TYPE", "POST", "sys_user");
$ins_polizas_master->addColumn("sys_date", "DATE_TYPE", "POST", "sys_date");
$ins_polizas_master->addColumn("sys_time", "DATE_TYPE", "POST", "sys_time");
$ins_polizas_master->setPrimaryKey("poliza_id", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_polizas_master = new tNG_multipleUpdate($conn_oConnContratos);
$tNGs->addTransaction($upd_polizas_master);
// Register triggers
$upd_polizas_master->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_polizas_master->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_polizas_master->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$upd_polizas_master->setTable("polizas_master");
$upd_polizas_master->addColumn("id_cont_fk", "NUMERIC_TYPE", "POST", "id_cont_fk");
$upd_polizas_master->addColumn("id_att_fk", "NUMERIC_TYPE", "POST", "id_att_fk");
$upd_polizas_master->addColumn("poli_numero", "STRING_TYPE", "POST", "poli_numero");
$upd_polizas_master->addColumn("poli_compania", "NUMERIC_TYPE", "POST", "poli_compania");
$upd_polizas_master->addColumn("poli_fechaexpedicion", "DATE_TYPE", "POST", "poli_fechaexpedicion");
$upd_polizas_master->addColumn("poli_codamparo", "NUMERIC_TYPE", "POST", "poli_codamparo");
$upd_polizas_master->addColumn("poli_porcentaje", "DOUBLE_TYPE", "POST", "poli_porcentaje");
$upd_polizas_master->addColumn("poli_valor", "DOUBLE_TYPE", "POST", "poli_valor");
$upd_polizas_master->addColumn("poli_vigenciadesde", "DATE_TYPE", "POST", "poli_vigenciadesde");
$upd_polizas_master->addColumn("poli_vigenciahasta", "DATE_TYPE", "POST", "poli_vigenciahasta");
$upd_polizas_master->addColumn("sys_user", "STRING_TYPE", "POST", "sys_user");
$upd_polizas_master->addColumn("sys_date", "DATE_TYPE", "POST", "sys_date");
$upd_polizas_master->addColumn("sys_time", "DATE_TYPE", "POST", "sys_time");
$upd_polizas_master->setPrimaryKey("poliza_id", "NUMERIC_TYPE", "GET", "poliza_id");

// Make an instance of the transaction object
$del_polizas_master = new tNG_multipleDelete($conn_oConnContratos);
$tNGs->addTransaction($del_polizas_master);
// Register triggers
$del_polizas_master->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_polizas_master->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$del_polizas_master->setTable("polizas_master");
$del_polizas_master->setPrimaryKey("poliza_id", "NUMERIC_TYPE", "GET", "poliza_id");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rspolizas_master = $tNGs->getRecordset("polizas_master");
$row_rspolizas_master = mysql_fetch_assoc($rspolizas_master);
$totalRows_rspolizas_master = mysql_num_rows($rspolizas_master);
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
<script src="../includes/nxt/scripts/form.js" type="text/javascript"></script>
<script src="../includes/nxt/scripts/form.js.php" type="text/javascript"></script>
<script type="text/javascript">
$NXT_FORM_SETTINGS = {
  duplicate_buttons: true,
  show_as_grid: true,
  merge_down_value: true
}
</script>
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
<div class="KT_tng">
  <h1>
    <?php 
// Show IF Conditional region1 
if (@$_GET['poliza_id'] == "") {
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
if (@$totalRows_rspolizas_master > 1) {
?>
          <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
          <?php } 
// endif Conditional region1
?>
        <table cellpadding="2" cellspacing="0" class="KT_tngtable">
          <tr>
            <td class="KT_th"><label for="poli_numero_<?php echo $cnt1; ?>">NUMERO:</label></td>
            <td><input type="text" name="poli_numero_<?php echo $cnt1; ?>" id="poli_numero_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rspolizas_master['poli_numero']); ?>" size="32" maxlength="50" />
                <?php echo $tNGs->displayFieldHint("poli_numero");?> <?php echo $tNGs->displayFieldError("polizas_master", "poli_numero", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="poli_compania_<?php echo $cnt1; ?>">COMPAÑIA:</label></td>
            <td><select name="poli_compania_<?php echo $cnt1; ?>" id="poli_compania_<?php echo $cnt1; ?>">
              <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
              <?php 
do {  
?>
              <option value="<?php echo $row_rsaseguradoras['codigo']?>"<?php if (!(strcmp($row_rsaseguradoras['codigo'], $row_rspolizas_master['poli_compania']))) {echo "SELECTED";} ?>><?php echo $row_rsaseguradoras['nom_aseguradora']?></option>
              <?php
} while ($row_rsaseguradoras = mysql_fetch_assoc($rsaseguradoras));
  $rows = mysql_num_rows($rsaseguradoras);
  if($rows > 0) {
      mysql_data_seek($rsaseguradoras, 0);
	  $row_rsaseguradoras = mysql_fetch_assoc($rsaseguradoras);
  }
?>
            </select>
                <?php echo $tNGs->displayFieldError("polizas_master", "poli_compania", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="poli_fechaexpedicion_<?php echo $cnt1; ?>">FECHA DE EXPEDICION:</label></td>
            <td><input type="text" name="poli_fechaexpedicion_<?php echo $cnt1; ?>" id="poli_fechaexpedicion_<?php echo $cnt1; ?>" value="<?php echo KT_formatDate($row_rspolizas_master['poli_fechaexpedicion']); ?>" size="10" maxlength="22" wdg:mondayfirst="false" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:type="widget" wdg:singleclick="true" wdg:restricttomask="yes" />
                <?php echo $tNGs->displayFieldHint("poli_fechaexpedicion");?> <?php echo $tNGs->displayFieldError("polizas_master", "poli_fechaexpedicion", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="poli_codamparo_<?php echo $cnt1; ?>">AMPARO:</label></td>
            <td><select name="poli_codamparo_<?php echo $cnt1; ?>" id="poli_codamparo_<?php echo $cnt1; ?>">
              <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
              <?php 
do {  
?>
              <option value="<?php echo $row_rsamparo['poliza_type_id']?>"<?php if (!(strcmp($row_rsamparo['poliza_type_id'], $row_rspolizas_master['poli_codamparo']))) {echo "SELECTED";} ?>><?php echo $row_rsamparo['poliza_type_name']?></option>
              <?php
} while ($row_rsamparo = mysql_fetch_assoc($rsamparo));
  $rows = mysql_num_rows($rsamparo);
  if($rows > 0) {
      mysql_data_seek($rsamparo, 0);
	  $row_rsamparo = mysql_fetch_assoc($rsamparo);
  }
?>
            </select>
                <?php echo $tNGs->displayFieldError("polizas_master", "poli_codamparo", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="poli_porcentaje_<?php echo $cnt1; ?>">%PART:</label></td>
            <td><input type="text" name="poli_porcentaje_<?php echo $cnt1; ?>" id="poli_porcentaje_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rspolizas_master['poli_porcentaje']); ?>" size="7" />
                <?php echo $tNGs->displayFieldHint("poli_porcentaje");?> <?php echo $tNGs->displayFieldError("polizas_master", "poli_porcentaje", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="poli_valor_<?php echo $cnt1; ?>">VALOR:</label></td>
            <td><input type="text" name="poli_valor_<?php echo $cnt1; ?>" id="poli_valor_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rspolizas_master['poli_valor']); ?>" size="7" />
                <?php echo $tNGs->displayFieldHint("poli_valor");?> <?php echo $tNGs->displayFieldError("polizas_master", "poli_valor", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="poli_vigenciadesde_<?php echo $cnt1; ?>">VIGENCIA DESDE:</label></td>
            <td><input type="text" name="poli_vigenciadesde_<?php echo $cnt1; ?>" id="poli_vigenciadesde_<?php echo $cnt1; ?>" value="<?php echo KT_formatDate($row_rspolizas_master['poli_vigenciadesde']); ?>" size="10" maxlength="22" wdg:mondayfirst="false" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:type="widget" wdg:singleclick="true" wdg:restricttomask="yes" />
                <?php echo $tNGs->displayFieldHint("poli_vigenciadesde");?> <?php echo $tNGs->displayFieldError("polizas_master", "poli_vigenciadesde", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="poli_vigenciahasta_<?php echo $cnt1; ?>">VIGENCIA HASTA:</label></td>
            <td><input type="text" name="poli_vigenciahasta_<?php echo $cnt1; ?>" id="poli_vigenciahasta_<?php echo $cnt1; ?>" value="<?php echo KT_formatDate($row_rspolizas_master['poli_vigenciahasta']); ?>" size="10" maxlength="22" wdg:mondayfirst="false" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:type="widget" wdg:singleclick="true" wdg:restricttomask="yes" />
                <?php echo $tNGs->displayFieldHint("poli_vigenciahasta");?> <?php echo $tNGs->displayFieldError("polizas_master", "poli_vigenciahasta", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th">&nbsp;</td>
            <td><input name="sys_user_<?php echo $cnt1; ?>" type="hidden" id="sys_user_<?php echo $cnt1; ?>" value="<?php echo $_SESSION['kt_login_user']; ?>" size="32" maxlength="60" />
                <?php echo $tNGs->displayFieldHint("sys_user");?> <?php echo $tNGs->displayFieldError("polizas_master", "sys_user", $cnt1); ?> <input type="hidden" name="sys_date_<?php echo $cnt1; ?>" id="sys_date_<?php echo $cnt1; ?>" value="<?php echo $fecha; ?>" size="10" maxlength="22" />
                <?php echo $tNGs->displayFieldHint("sys_date");?> <?php echo $tNGs->displayFieldError("polizas_master", "sys_date", $cnt1); ?> <input type="hidden" name="sys_time_<?php echo $cnt1; ?>" id="sys_time_<?php echo $cnt1; ?>" value="<?php echo $hora; ?>" size="10" maxlength="22" />
                <?php echo $tNGs->displayFieldHint("sys_time");?> <?php echo $tNGs->displayFieldError("polizas_master", "sys_time", $cnt1); ?> <input name="id_cont_fk_<?php echo $cnt1; ?>" type="hidden" id="id_cont_fk_<?php echo $cnt1; ?>" value="<?php echo $_GET['id_cont']; ?>" size="7" />
                <?php echo $tNGs->displayFieldHint("id_cont_fk");?> <?php echo $tNGs->displayFieldError("polizas_master", "id_cont_fk", $cnt1); ?> <input name="id_att_fk_<?php echo $cnt1; ?>" type="hidden" id="id_att_fk_<?php echo $cnt1; ?>" value="<?php echo $_GET['id_att']; ?>" size="7" />
                <?php echo $tNGs->displayFieldHint("id_att_fk");?> <?php echo $tNGs->displayFieldError("polizas_master", "id_att_fk", $cnt1); ?> </td>
          </tr>
        </table>
        <input type="hidden" name="kt_pk_polizas_master_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rspolizas_master['kt_pk_polizas_master']); ?>" />
        <?php } while ($row_rspolizas_master = mysql_fetch_assoc($rspolizas_master)); ?>
      <div class="KT_bottombuttons">
        <div>
          <?php 
      // Show IF Conditional region1
      if (@$_GET['poliza_id'] == "") {
      ?>
            <input type="submit" name="KT_Insert1" id="KT_Insert1" value="<?php echo NXT_getResource("Insert_FB"); ?>" />
            <?php 
      // else Conditional region1
      } else { ?>
            <div class="KT_operations">
              <input type="submit" name="KT_Insert1" value="<?php echo NXT_getResource("Insert as new_FB"); ?>" onclick="nxt_form_insertasnew(this, 'poliza_id')" />
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
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($rsaseguradoras);

mysql_free_result($rsamparo);
?>
