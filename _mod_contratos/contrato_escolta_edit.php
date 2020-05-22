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

// Load the KT_back class
require_once('../includes/nxt/KT_back.php');

// Make a transaction dispatcher instance
$tNGs = new tNG_dispatcher("../");

// Make unified connection variable
$conn_oConnContratos = new KT_connection($oConnContratos, $database_oConnContratos);

// Start trigger
$formValidation = new tNG_FormValidation();
$formValidation->addField("con_tpident_b", true, "text", "", "", "", "");
$formValidation->addField("con_nrced_b", true, "numeric", "", "", "", "");
$formValidation->addField("con_nomcon_b", true, "text", "", "", "", "");
$formValidation->addField("con_movil_b", true, "text", "", "", "", "");
$formValidation->addField("con_supervisor_b", true, "text", "", "", "", "");
$formValidation->addField("con_fecfin_b", true, "text", "", "", "", "");
$formValidation->addField("con_nrocon_b", true, "text", "", "", "", "");
$formValidation->addField("con_objeto_b", true, "text", "", "", "", "");
$formValidation->addField("con_vrsdo_b", true, "double", "", "", "", "");
$formValidation->addField("con_tpcta_b", true, "text", "", "", "", "");
$formValidation->addField("con_banco_b", true, "double", "", "", "", "");
$formValidation->addField("con_nrcta_b", true, "text", "", "", "", "");
$formValidation->addField("con_etcon_b", true, "text", "", "", "", "");
$formValidation->addField("con_tpcon_b", true, "text", "", "", "", "");
$formValidation->addField("con_login_b", true, "text", "", "", "", "");
$formValidation->addField("con_correo_b", true, "text", "email", "", "", "");
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
$query_Recordset1 = "SELECT des_cuenta, cta_tipotext FROM tipo_cta_banco ORDER BY des_cuenta";
$Recordset1 = mysql_query($query_Recordset1, $oConnContratos) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_oConnContratos, $oConnContratos);
$query_Recordset2 = "SELECT nom_banco, cod_banco FROM tipo_banco ORDER BY nom_banco";
$Recordset2 = mysql_query($query_Recordset2, $oConnContratos) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

// Make an insert transaction instance
$ins_escoltas = new tNG_multipleInsert($conn_oConnContratos);
$tNGs->addTransaction($ins_escoltas);
// Register triggers
$ins_escoltas->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_escoltas->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_escoltas->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$ins_escoltas->setTable("escoltas");
$ins_escoltas->addColumn("con_tpident_b", "STRING_TYPE", "POST", "con_tpident_b");
$ins_escoltas->addColumn("con_nrced_b", "NUMERIC_TYPE", "POST", "con_nrced_b");
$ins_escoltas->addColumn("con_nomcon_b", "STRING_TYPE", "POST", "con_nomcon_b");
$ins_escoltas->addColumn("con_movil_b", "STRING_TYPE", "POST", "con_movil_b");
$ins_escoltas->addColumn("con_supervisor_b", "STRING_TYPE", "POST", "con_supervisor_b");
$ins_escoltas->addColumn("con_fecfin_b", "STRING_TYPE", "POST", "con_fecfin_b");
$ins_escoltas->addColumn("con_nrocon_b", "STRING_TYPE", "POST", "con_nrocon_b");
$ins_escoltas->addColumn("con_objeto_b", "STRING_TYPE", "POST", "con_objeto_b");
$ins_escoltas->addColumn("con_vrsdo_b", "DOUBLE_TYPE", "POST", "con_vrsdo_b");
$ins_escoltas->addColumn("con_tpcta_b", "STRING_TYPE", "POST", "con_tpcta_b");
$ins_escoltas->addColumn("con_banco_b", "DOUBLE_TYPE", "POST", "con_banco_b");
$ins_escoltas->addColumn("con_nrcta_b", "STRING_TYPE", "POST", "con_nrcta_b");
$ins_escoltas->addColumn("con_etcon_b", "STRING_TYPE", "POST", "con_etcon_b");
$ins_escoltas->addColumn("con_tpcon_b", "STRING_TYPE", "POST", "con_tpcon_b");
$ins_escoltas->addColumn("con_login_b", "STRING_TYPE", "POST", "con_login_b");
$ins_escoltas->addColumn("con_correo_b", "STRING_TYPE", "POST", "con_correo_b");
$ins_escoltas->setPrimaryKey("con_idcont_b", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_escoltas = new tNG_multipleUpdate($conn_oConnContratos);
$tNGs->addTransaction($upd_escoltas);
// Register triggers
$upd_escoltas->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_escoltas->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_escoltas->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$upd_escoltas->setTable("escoltas");
$upd_escoltas->addColumn("con_tpident_b", "STRING_TYPE", "POST", "con_tpident_b");
$upd_escoltas->addColumn("con_nrced_b", "NUMERIC_TYPE", "POST", "con_nrced_b");
$upd_escoltas->addColumn("con_nomcon_b", "STRING_TYPE", "POST", "con_nomcon_b");
$upd_escoltas->addColumn("con_movil_b", "STRING_TYPE", "POST", "con_movil_b");
$upd_escoltas->addColumn("con_supervisor_b", "STRING_TYPE", "POST", "con_supervisor_b");
$upd_escoltas->addColumn("con_fecfin_b", "STRING_TYPE", "POST", "con_fecfin_b");
$upd_escoltas->addColumn("con_nrocon_b", "STRING_TYPE", "POST", "con_nrocon_b");
$upd_escoltas->addColumn("con_objeto_b", "STRING_TYPE", "POST", "con_objeto_b");
$upd_escoltas->addColumn("con_vrsdo_b", "DOUBLE_TYPE", "POST", "con_vrsdo_b");
$upd_escoltas->addColumn("con_tpcta_b", "STRING_TYPE", "POST", "con_tpcta_b");
$upd_escoltas->addColumn("con_banco_b", "DOUBLE_TYPE", "POST", "con_banco_b");
$upd_escoltas->addColumn("con_nrcta_b", "STRING_TYPE", "POST", "con_nrcta_b");
$upd_escoltas->addColumn("con_etcon_b", "STRING_TYPE", "POST", "con_etcon_b");
$upd_escoltas->addColumn("con_tpcon_b", "STRING_TYPE", "POST", "con_tpcon_b");
$upd_escoltas->addColumn("con_login_b", "STRING_TYPE", "POST", "con_login_b");
$upd_escoltas->addColumn("con_correo_b", "STRING_TYPE", "POST", "con_correo_b");
$upd_escoltas->setPrimaryKey("con_idcont_b", "NUMERIC_TYPE", "GET", "con_idcont_b");

// Make an instance of the transaction object
$del_escoltas = new tNG_multipleDelete($conn_oConnContratos);
$tNGs->addTransaction($del_escoltas);
// Register triggers
$del_escoltas->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_escoltas->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$del_escoltas->setTable("escoltas");
$del_escoltas->setPrimaryKey("con_idcont_b", "NUMERIC_TYPE", "GET", "con_idcont_b");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsescoltas = $tNGs->getRecordset("escoltas");
$row_rsescoltas = mysql_fetch_assoc($rsescoltas);
$totalRows_rsescoltas = mysql_num_rows($rsescoltas);
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
  show_as_grid: false,
  merge_down_value: false
}
</script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="../includes/wdg/classes/MaskedInput.js"></script>
<script type="text/javascript" src="../includes/common/js/sigslot_core.js"></script>
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
if (@$_GET['con_idcont_b'] == "") {
?>
      <?php echo NXT_getResource("Insert_FH"); ?>
      <?php 
// else Conditional region1
} else { ?>
      <?php echo NXT_getResource("Update_FH"); ?>
      <?php } 
// endif Conditional region1
?>
    Escoltas </h1>
  <div class="KT_tngform">
    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
      <?php $cnt1 = 0; ?>
      <?php do { ?>
        <?php $cnt1++; ?>
        <?php 
// Show IF Conditional region1 
if (@$totalRows_rsescoltas > 1) {
?>
          <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
          <?php } 
// endif Conditional region1
?>
        <table cellpadding="2" cellspacing="0" class="KT_tngtable">
          <tr>
            <td class="KT_th">&nbsp;</td>
            <td><input type="hidden" name="con_tpident_b_<?php echo $cnt1; ?>" id="con_tpident_b_<?php echo $cnt1; ?>" value="CC" size="2" maxlength="2" />
                <?php echo $tNGs->displayFieldHint("con_tpident_b");?> <?php echo $tNGs->displayFieldError("escoltas", "con_tpident_b", $cnt1); ?> <input name="con_nrocon_b_<?php echo $cnt1; ?>" type="hidden" id="con_nrocon_b_<?php echo $cnt1; ?>" value="99" />
                <?php echo $tNGs->displayFieldHint("con_nrocon_b");?> <?php echo $tNGs->displayFieldError("escoltas", "con_nrocon_b", $cnt1); ?> <input name="con_etcon_b_<?php echo $cnt1; ?>" type="hidden" id="con_etcon_b_<?php echo $cnt1; ?>" value="A" />
                <?php echo $tNGs->displayFieldHint("con_etcon_b");?> <?php echo $tNGs->displayFieldError("escoltas", "con_etcon_b", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="con_nrced_b_<?php echo $cnt1; ?>">CEDULA:</label></td>
            <td><input type="text" name="con_nrced_b_<?php echo $cnt1; ?>" id="con_nrced_b_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsescoltas['con_nrced_b']); ?>" size="7" />
                <?php echo $tNGs->displayFieldHint("con_nrced_b");?> <?php echo $tNGs->displayFieldError("escoltas", "con_nrced_b", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="con_nomcon_b">NOMBRES:</label></td>
            <td><input type="text" name="con_nomcon_b" id="con_nomcon_b" value="<?php echo KT_escapeAttribute($row_rsescoltas['con_nomcon_b']); ?>" size="32" maxlength="100" onkeyup="form1.con_nomcon_b.value=form1.con_nomcon_b.value.toUpperCase();" />
                <?php echo $tNGs->displayFieldHint("con_nomcon_b");?> <?php echo $tNGs->displayFieldError("escoltas", "con_nomcon_b", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="con_movil_b_<?php echo $cnt1; ?>">CELULAR:</label></td>
            <td><input type="text" name="con_movil_b_<?php echo $cnt1; ?>" id="con_movil_b_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsescoltas['con_movil_b']); ?>" size="12" maxlength="12" wdg:subtype="MaskedInput" wdg:mask="999-999-9999" wdg:restricttomask="yes" wdg:type="widget" />
                <?php echo $tNGs->displayFieldHint("con_movil_b");?> <?php echo $tNGs->displayFieldError("escoltas", "con_movil_b", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="con_supervisor_b_<?php echo $cnt1; ?>">SUPERVISOR:</label></td>
            <td><input type="text" name="con_supervisor_b_<?php echo $cnt1; ?>" id="con_supervisor_b_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsescoltas['con_supervisor_b']); ?>" size="32" maxlength="100" />
                <?php echo $tNGs->displayFieldHint("con_supervisor_b");?> <?php echo $tNGs->displayFieldError("escoltas", "con_supervisor_b", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="con_fecfin_b_<?php echo $cnt1; ?>">FECHA FINAL CONTRATO:</label></td>
            <td><input type="text" name="con_fecfin_b_<?php echo $cnt1; ?>" id="con_fecfin_b_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsescoltas['con_fecfin_b']); ?>" size="10" maxlength="10" wdg:mondayfirst="false" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:type="widget" wdg:singleclick="true" wdg:restricttomask="yes" />
                <?php echo $tNGs->displayFieldHint("con_fecfin_b");?> <?php echo $tNGs->displayFieldError("escoltas", "con_fecfin_b", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="con_objeto_b_<?php echo $cnt1; ?>">OBJETO:</label></td>
            <td><input type="text" name="con_objeto_b_<?php echo $cnt1; ?>" id="con_objeto_b_<?php echo $cnt1; ?>" value="BRINDAR APOYO Y SEGURIDAD AL MINISTRO" size="70" />
                <?php echo $tNGs->displayFieldHint("con_objeto_b");?> <?php echo $tNGs->displayFieldError("escoltas", "con_objeto_b", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="con_vrsdo_b_<?php echo $cnt1; ?>">SUELDO:</label></td>
            <td><input type="text" name="con_vrsdo_b_<?php echo $cnt1; ?>" id="con_vrsdo_b_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsescoltas['con_vrsdo_b']); ?>" size="7" />
                <?php echo $tNGs->displayFieldHint("con_vrsdo_b");?> <?php echo $tNGs->displayFieldError("escoltas", "con_vrsdo_b", $cnt1); ?> (sin puntos)</td>
          </tr>
          <tr>
            <td class="KT_th"><label for="con_tpcta_b_<?php echo $cnt1; ?>">TIPO CUENTA:</label></td>
            <td><select name="con_tpcta_b_<?php echo $cnt1; ?>" id="con_tpcta_b_<?php echo $cnt1; ?>">
              <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
              <?php 
do {  
?>
              <option value="<?php echo $row_Recordset1['cta_tipotext']?>"<?php if (!(strcmp($row_Recordset1['cta_tipotext'], $row_rsescoltas['con_tpcta_b']))) {echo "SELECTED";} ?>><?php echo $row_Recordset1['des_cuenta']?></option>
              <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
            </select>
                <?php echo $tNGs->displayFieldError("escoltas", "con_tpcta_b", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="con_banco_b_<?php echo $cnt1; ?>">BANCO:</label></td>
            <td><select name="con_banco_b_<?php echo $cnt1; ?>" id="con_banco_b_<?php echo $cnt1; ?>">
              <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
              <?php 
do {  
?>
              <option value="<?php echo $row_Recordset2['cod_banco']?>"<?php if (!(strcmp($row_Recordset2['cod_banco'], $row_rsescoltas['con_banco_b']))) {echo "SELECTED";} ?>><?php echo $row_Recordset2['nom_banco']?></option>
              <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
            </select>
                <?php echo $tNGs->displayFieldError("escoltas", "con_banco_b", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="con_nrcta_b_<?php echo $cnt1; ?>">NUMERO CUENTA:</label></td>
            <td><input type="text" name="con_nrcta_b_<?php echo $cnt1; ?>" id="con_nrcta_b_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsescoltas['con_nrcta_b']); ?>" size="20" maxlength="20" />
                <?php echo $tNGs->displayFieldHint("con_nrcta_b");?> <?php echo $tNGs->displayFieldError("escoltas", "con_nrcta_b", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="con_tpcon_b_<?php echo $cnt1; ?>">CARGO ESCOLTA:</label></td>
            <td><input type="text" name="con_tpcon_b_<?php echo $cnt1; ?>" id="con_tpcon_b_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsescoltas['con_tpcon_b']); ?>" size="32" maxlength="60" />
                <?php echo $tNGs->displayFieldHint("con_tpcon_b");?> <?php echo $tNGs->displayFieldError("escoltas", "con_tpcon_b", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="con_login_b">NOMBRE USUARIO MINCIT:</label></td>
            <td><input type="text" name="con_login_b" id="con_login_b" value="<?php echo KT_escapeAttribute($row_rsescoltas['con_login_b']); ?>" size="32" maxlength="50"onkeyup="form1.con_login_b.value=form1.con_login_b.value.toLowerCase();" />
                <?php echo $tNGs->displayFieldHint("con_login_b");?> <?php echo $tNGs->displayFieldError("escoltas", "con_login_b", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="con_correo_b_<?php echo $cnt1; ?>">CORREC CONTACTO:</label></td>
            <td><input type="text" name="con_correo_b_<?php echo $cnt1; ?>" id="con_correo_b_<?php echo $cnt1; ?>" value="vleon@mincit.gov.co" size="32" maxlength="100" />
                <?php echo $tNGs->displayFieldHint("con_correo_b");?> <?php echo $tNGs->displayFieldError("escoltas", "con_correo_b", $cnt1); ?> </td>
          </tr>
        </table>
        <input type="hidden" name="kt_pk_escoltas_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rsescoltas['kt_pk_escoltas']); ?>" />
        <?php } while ($row_rsescoltas = mysql_fetch_assoc($rsescoltas)); ?>
      <div class="KT_bottombuttons">
        <div>
          <?php 
      // Show IF Conditional region1
      if (@$_GET['con_idcont_b'] == "") {
      ?>
            <input type="submit" name="KT_Insert1" id="KT_Insert1" value="<?php echo NXT_getResource("Insert_FB"); ?>" />
            <?php 
      // else Conditional region1
      } else { ?>
            <div class="KT_operations">
              <input type="submit" name="KT_Insert1" value="<?php echo NXT_getResource("Insert as new_FB"); ?>" onclick="nxt_form_insertasnew(this, 'con_idcont_b')" />
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
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
