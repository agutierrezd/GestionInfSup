<?php require_once('../Connections/oConnContratos.php'); ?>
<?php
/*
Análisis, Diseño y Desarrollo: Alex Fernando Gutierrez
correo: dito73@gmail.com
correo inst: agutierrezd@mincit.gov.co
celular: 3017874143
*/
require_once('../includes/common/KT_common.php');

// Load the required classes
require_once('../includes/tfi/TFI.php');
require_once('../includes/tso/TSO.php');
require_once('../includes/nav/NAV.php');

// Make unified connection variable
$conn_oConnContratos = new KT_connection($oConnContratos, $database_oConnContratos);

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

// Filter
$tfi_listrslistamparos1 = new TFI_TableFilter($conn_oConnContratos, "tfi_listrslistamparos1");
$tfi_listrslistamparos1->addColumn("poli_fechaexpedicion", "DATE_TYPE", "poli_fechaexpedicion", "=");
$tfi_listrslistamparos1->addColumn("poli_numero", "STRING_TYPE", "poli_numero", "%");
$tfi_listrslistamparos1->addColumn("nom_aseguradora", "STRING_TYPE", "nom_aseguradora", "%");
$tfi_listrslistamparos1->addColumn("poliza_type_name", "STRING_TYPE", "poliza_type_name", "%");
$tfi_listrslistamparos1->addColumn("poli_porcentaje", "NUMERIC_TYPE", "poli_porcentaje", "=");
$tfi_listrslistamparos1->addColumn("poli_valor", "NUMERIC_TYPE", "poli_valor", "=");
$tfi_listrslistamparos1->Execute();

// Sorter
$tso_listrslistamparos1 = new TSO_TableSorter("rslistamparos", "tso_listrslistamparos1");
$tso_listrslistamparos1->addColumn("poli_fechaexpedicion");
$tso_listrslistamparos1->addColumn("poli_numero");
$tso_listrslistamparos1->addColumn("nom_aseguradora");
$tso_listrslistamparos1->addColumn("poliza_type_name");
$tso_listrslistamparos1->addColumn("poli_porcentaje");
$tso_listrslistamparos1->addColumn("poli_valor");
$tso_listrslistamparos1->setDefault("poli_fechaexpedicion");
$tso_listrslistamparos1->Execute();

// Navigation
$nav_listrslistamparos1 = new NAV_Regular("nav_listrslistamparos1", "rslistamparos", "../", $_SERVER['PHP_SELF'], 10);

//NeXTenesio3 Special List Recordset
$maxRows_rslistamparos = $_SESSION['max_rows_nav_listrslistamparos1'];
$pageNum_rslistamparos = 0;
if (isset($_GET['pageNum_rslistamparos'])) {
  $pageNum_rslistamparos = $_GET['pageNum_rslistamparos'];
}
$startRow_rslistamparos = $pageNum_rslistamparos * $maxRows_rslistamparos;

$colname_rslistamparos = "-1";
if (isset($_GET['id_att'])) {
  $colname_rslistamparos = $_GET['id_att'];
}
// Defining List Recordset variable
$NXTFilter_rslistamparos = "1=1";
if (isset($_SESSION['filter_tfi_listrslistamparos1'])) {
  $NXTFilter_rslistamparos = $_SESSION['filter_tfi_listrslistamparos1'];
}
// Defining List Recordset variable
$NXTSort_rslistamparos = "poli_fechaexpedicion";
if (isset($_SESSION['sorter_tso_listrslistamparos1'])) {
  $NXTSort_rslistamparos = $_SESSION['sorter_tso_listrslistamparos1'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);

$query_rslistamparos = sprintf("SELECT polizas_master.poliza_id, polizas_master.id_cont_fk, polizas_master.id_att_fk, polizas_master.poli_numero, polizas_master.poli_compania, polizas_aseguradoras.nom_aseguradora, polizas_master.poli_fechaexpedicion, polizas_master.poli_codamparo, polizas_tipo.poliza_type_name, polizas_master.poli_fechaaprobacion, polizas_master.poli_porcentaje, polizas_master.poli_valor, polizas_master.poli_vigenciadesde, polizas_master.poli_vigenciahasta, polizas_master.sys_user, polizas_master.sys_date, polizas_master.sys_time FROM polizas_master INNER JOIN polizas_aseguradoras ON polizas_master.poli_compania = polizas_aseguradoras.codigo INNER JOIN polizas_tipo ON polizas_master.poli_codamparo = polizas_tipo.poliza_type_id WHERE id_att_fk = %s AND  {$NXTFilter_rslistamparos}  ORDER BY  {$NXTSort_rslistamparos} ", GetSQLValueString($colname_rslistamparos, "int"));
$query_limit_rslistamparos = sprintf("%s LIMIT %d, %d", $query_rslistamparos, $startRow_rslistamparos, $maxRows_rslistamparos);
$rslistamparos = mysql_query($query_limit_rslistamparos, $oConnContratos) or die(mysql_error());
$row_rslistamparos = mysql_fetch_assoc($rslistamparos);

if (isset($_GET['totalRows_rslistamparos'])) {
  $totalRows_rslistamparos = $_GET['totalRows_rslistamparos'];
} else {
  $all_rslistamparos = mysql_query($query_rslistamparos);
  $totalRows_rslistamparos = mysql_num_rows($all_rslistamparos);
}
$totalPages_rslistamparos = ceil($totalRows_rslistamparos/$maxRows_rslistamparos)-1;
//End NeXTenesio3 Special List Recordset

$nav_listrslistamparos1->checkBoundries();
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script src="../includes/skins/style.js" type="text/javascript"></script>
<script src="../includes/nxt/scripts/list.js" type="text/javascript"></script>
<script src="../includes/nxt/scripts/list.js.php" type="text/javascript"></script>
<script type="text/javascript">
$NXT_LIST_SETTINGS = {
  duplicate_buttons: false,
  duplicate_navigation: false,
  row_effects: true,
  show_as_buttons: true,
  record_counter: true
}
</script>
<style type="text/css">
  /* Dynamic List row settings */
  .KT_col_poli_fechaexpedicion {width:140px; overflow:hidden;}
  .KT_col_poli_numero {width:140px; overflow:hidden;}
  .KT_col_nom_aseguradora {width:140px; overflow:hidden;}
  .KT_col_poliza_type_name {width:140px; overflow:hidden;}
  .KT_col_poli_porcentaje {width:140px; overflow:hidden;}
  .KT_col_poli_valor {width:140px; overflow:hidden;}
</style>
</head>

<body>
<div class="KT_tng" id="listrslistamparos1">
  <h1> Amparos
    <?php
  $nav_listrslistamparos1->Prepare();
  require("../includes/nav/NAV_Text_Statistics.inc.php");
?>
  </h1>
  <div class="KT_tnglist">
    <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
      <div class="KT_options"> <a href="<?php echo $nav_listrslistamparos1->getShowAllLink(); ?>"><?php echo NXT_getResource("Show"); ?>
        <?php 
  // Show IF Conditional region1
  if (@$_GET['show_all_nav_listrslistamparos1'] == 1) {
?>
          <?php echo $_SESSION['default_max_rows_nav_listrslistamparos1']; ?>
          <?php 
  // else Conditional region1
  } else { ?>
          <?php echo NXT_getResource("all"); ?>
          <?php } 
  // endif Conditional region1
?>
            <?php echo NXT_getResource("records"); ?></a> &nbsp;
      &nbsp; </div>
      <table cellpadding="2" cellspacing="0" class="KT_tngtable">
        <thead>
          <tr class="KT_row_order">
            <th> <input type="checkbox" name="KT_selAll" id="KT_selAll"/>
            </th>
            <th id="poli_fechaexpedicion" class="KT_sorter KT_col_poli_fechaexpedicion <?php echo $tso_listrslistamparos1->getSortIcon('poli_fechaexpedicion'); ?>"> <a href="<?php echo $tso_listrslistamparos1->getSortLink('poli_fechaexpedicion'); ?>">FECHAS</a> </th>
            <th id="poli_numero" class="KT_sorter KT_col_poli_numero <?php echo $tso_listrslistamparos1->getSortIcon('poli_numero'); ?>"> <a href="<?php echo $tso_listrslistamparos1->getSortLink('poli_numero'); ?>">NUMERO DE POLIZA</a> </th>
            <th id="nom_aseguradora" class="KT_sorter KT_col_nom_aseguradora <?php echo $tso_listrslistamparos1->getSortIcon('nom_aseguradora'); ?>"> <a href="<?php echo $tso_listrslistamparos1->getSortLink('nom_aseguradora'); ?>">ASEGURADORA</a> </th>
            <th id="poliza_type_name" class="KT_sorter KT_col_poliza_type_name <?php echo $tso_listrslistamparos1->getSortIcon('poliza_type_name'); ?>"> <a href="<?php echo $tso_listrslistamparos1->getSortLink('poliza_type_name'); ?>">AMPAROS</a> </th>
            <th id="poli_porcentaje" class="KT_sorter KT_col_poli_porcentaje <?php echo $tso_listrslistamparos1->getSortIcon('poli_porcentaje'); ?>"> <a href="<?php echo $tso_listrslistamparos1->getSortLink('poli_porcentaje'); ?>">%PART</a> </th>
            <th id="poli_valor" class="KT_sorter KT_col_poli_valor <?php echo $tso_listrslistamparos1->getSortIcon('poli_valor'); ?>"> <a href="<?php echo $tso_listrslistamparos1->getSortLink('poli_valor'); ?>">VALOR</a> </th>
            <th>&nbsp;</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($totalRows_rslistamparos == 0) { // Show if recordset empty ?>
            <tr>
              <td colspan="8"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
            </tr>
            <?php } // Show if recordset empty ?>
          <?php if ($totalRows_rslistamparos > 0) { // Show if recordset not empty ?>
            <?php do { ?>
              <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
                <td><input type="checkbox" name="kt_pk_polizas_master" class="id_checkbox" value="<?php echo $row_rslistamparos['poliza_id']; ?>" />
                    <input type="hidden" name="poliza_id" class="id_field" value="<?php echo $row_rslistamparos['poliza_id']; ?>" />
                </td>
                <td><div class="KT_col_poli_fechaexpedicion"><?php echo KT_formatDate($row_rslistamparos['poli_fechaexpedicion']); ?></div></td>
                <td><div class="KT_col_poli_numero"><?php echo KT_FormatForList($row_rslistamparos['poli_numero'], 20); ?></div></td>
                <td><div class="KT_col_nom_aseguradora"><?php echo KT_FormatForList($row_rslistamparos['nom_aseguradora'], 20); ?></div></td>
                <td><div class="KT_col_poliza_type_name"><?php echo $row_rslistamparos['poliza_type_name']; ?></div></td>
                <td><div class="KT_col_poli_porcentaje"><?php echo KT_FormatForList($row_rslistamparos['poli_porcentaje'], 20); ?></div></td>
                <td><div class="KT_col_poli_valor"><?php echo KT_FormatForList($row_rslistamparos['poli_valor'], 20); ?></div></td>
                <td><?php 
// Show IF Conditional region3 
if (@$_SESSION['kt_login_level'] == 2) {
?>
                    <a class="KT_edit_link" href="amparos_edit.php?poliza_id=<?php echo $row_rslistamparos['poliza_id']; ?>&amp;KT_back=1&amp;id_cont=<?php echo $_GET['id_cont']; ?>&amp;id_att=<?php echo $_GET['id_att']; ?>"><?php echo NXT_getResource("edit_one"); ?></a> <a class="KT_delete_link" href="#delete"><?php echo NXT_getResource("delete_one"); ?></a>
                    <?php } 
// endif Conditional region3
?> </td>
              </tr>
              <?php } while ($row_rslistamparos = mysql_fetch_assoc($rslistamparos)); ?>
            <?php } // Show if recordset not empty ?>
        </tbody>
      </table>
      <div class="KT_bottomnav">
        <div>
          <?php
            $nav_listrslistamparos1->Prepare();
            require("../includes/nav/NAV_Text_Navigation.inc.php");
          ?>
        </div>
      </div>
      <div class="KT_bottombuttons">
        <?php 
// Show IF Conditional region2 
if (@$_SESSION['kt_login_level'] == 2) {
?>
          <div class="KT_operations"> <a class="KT_edit_op_link" href="#" onclick="nxt_list_edit_link_form(this); return false;"><?php echo NXT_getResource("edit_all"); ?></a> <a class="KT_delete_op_link" href="#" onclick="nxt_list_delete_link_form(this); return false;"><?php echo NXT_getResource("delete_all"); ?></a> </div>
<span>&nbsp;</span>
          <select name="no_new" id="no_new">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
          </select>
          <a class="KT_additem_op_link" href="amparos_edit.php?KT_back=1&amp;id_cont=<?php echo $_GET['id_cont']; ?>&amp;id_att=<?php echo $_GET['id_att']; ?>" onclick="return nxt_list_additem(this)"><?php echo NXT_getResource("add new"); ?></a>
          <?php } 
// endif Conditional region2
?> </div>
    </form>
  </div>
  <br class="clearfixplain" />
</div>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($rslistamparos);
?>
