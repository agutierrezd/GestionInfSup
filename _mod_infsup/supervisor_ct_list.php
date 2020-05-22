<?php require_once('../Connections/oConnContratos.php'); ?>
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
$tfi_listq_global_supervisores1 = new TFI_TableFilter($conn_oConnContratos, "tfi_listq_global_supervisores1");
$tfi_listq_global_supervisores1->addColumn("q_global_supervisores.NCONTRATO", "STRING_TYPE", "NCONTRATO", "%");
$tfi_listq_global_supervisores1->addColumn("q_global_supervisores.cont_ano", "DATE_TYPE", "cont_ano", "=");
$tfi_listq_global_supervisores1->addColumn("q_global_supervisores.usr_name", "STRING_TYPE", "usr_name", "%");
$tfi_listq_global_supervisores1->addColumn("q_global_supervisores.cont_nit_contra_ta", "STRING_TYPE", "cont_nit_contra_ta", "%");
$tfi_listq_global_supervisores1->addColumn("q_global_supervisores.contractor_name", "STRING_TYPE", "contractor_name", "%");
$tfi_listq_global_supervisores1->addColumn("q_global_supervisores.cont_fecha_inicio", "DATE_TYPE", "cont_fecha_inicio", "=");
$tfi_listq_global_supervisores1->addColumn("q_global_supervisores.cont_fechafinal", "DATE_TYPE", "cont_fechafinal", "=");
$tfi_listq_global_supervisores1->addColumn("q_global_supervisores.periodo_name", "STRING_TYPE", "periodo_name", "%");
$tfi_listq_global_supervisores1->addColumn("q_global_supervisores.cont_informessug", "NUMERIC_TYPE", "cont_informessug", "=");
$tfi_listq_global_supervisores1->addColumn("q_global_supervisores.id_cont_fk", "NUMERIC_TYPE", "id_cont_fk", "=");
$tfi_listq_global_supervisores1->Execute();

// Sorter
$tso_listq_global_supervisores1 = new TSO_TableSorter("rsq_global_supervisores1", "tso_listq_global_supervisores1");
$tso_listq_global_supervisores1->addColumn("q_global_supervisores.NCONTRATO");
$tso_listq_global_supervisores1->addColumn("q_global_supervisores.cont_ano");
$tso_listq_global_supervisores1->addColumn("q_global_supervisores.usr_name");
$tso_listq_global_supervisores1->addColumn("q_global_supervisores.cont_nit_contra_ta");
$tso_listq_global_supervisores1->addColumn("q_global_supervisores.contractor_name");
$tso_listq_global_supervisores1->addColumn("q_global_supervisores.cont_fecha_inicio");
$tso_listq_global_supervisores1->addColumn("q_global_supervisores.cont_fechafinal");
$tso_listq_global_supervisores1->addColumn("q_global_supervisores.periodo_name");
$tso_listq_global_supervisores1->addColumn("q_global_supervisores.cont_informessug");
$tso_listq_global_supervisores1->addColumn("q_global_supervisores.id_cont_fk");
$tso_listq_global_supervisores1->setDefault("q_global_supervisores.NCONTRATO");
$tso_listq_global_supervisores1->Execute();

// Navigation
$nav_listq_global_supervisores1 = new NAV_Regular("nav_listq_global_supervisores1", "rsq_global_supervisores1", "../", $_SERVER['PHP_SELF'], 25);

//NeXTenesio3 Special List Recordset
$maxRows_rsq_global_supervisores1 = $_SESSION['max_rows_nav_listq_global_supervisores1'];
$pageNum_rsq_global_supervisores1 = 0;
if (isset($_GET['pageNum_rsq_global_supervisores1'])) {
  $pageNum_rsq_global_supervisores1 = $_GET['pageNum_rsq_global_supervisores1'];
}
$startRow_rsq_global_supervisores1 = $pageNum_rsq_global_supervisores1 * $maxRows_rsq_global_supervisores1;

// Defining List Recordset variable
$NXTFilter_rsq_global_supervisores1 = "1=1";
if (isset($_SESSION['filter_tfi_listq_global_supervisores1'])) {
  $NXTFilter_rsq_global_supervisores1 = $_SESSION['filter_tfi_listq_global_supervisores1'];
}
// Defining List Recordset variable
$NXTSort_rsq_global_supervisores1 = "q_global_supervisores.NCONTRATO";
if (isset($_SESSION['sorter_tso_listq_global_supervisores1'])) {
  $NXTSort_rsq_global_supervisores1 = $_SESSION['sorter_tso_listq_global_supervisores1'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);

$query_rsq_global_supervisores1 = "SELECT q_global_supervisores.NCONTRATO, q_global_supervisores.cont_ano, q_global_supervisores.usr_name,q_global_supervisores.usr_lname, q_global_supervisores.cont_nit_contra_ta, q_global_supervisores.contractor_name, q_global_supervisores.cont_fecha_inicio, q_global_supervisores.cont_fechafinal, q_global_supervisores.periodo_name, q_global_supervisores.cont_informessug, q_global_supervisores.id_cont_fk FROM q_global_supervisores WHERE {$NXTFilter_rsq_global_supervisores1} ORDER BY {$NXTSort_rsq_global_supervisores1}";
$query_limit_rsq_global_supervisores1 = sprintf("%s LIMIT %d, %d", $query_rsq_global_supervisores1, $startRow_rsq_global_supervisores1, $maxRows_rsq_global_supervisores1);
$rsq_global_supervisores1 = mysql_query($query_limit_rsq_global_supervisores1, $oConnContratos) or die(mysql_error());
$row_rsq_global_supervisores1 = mysql_fetch_assoc($rsq_global_supervisores1);

if (isset($_GET['totalRows_rsq_global_supervisores1'])) {
  $totalRows_rsq_global_supervisores1 = $_GET['totalRows_rsq_global_supervisores1'];
} else {
  $all_rsq_global_supervisores1 = mysql_query($query_rsq_global_supervisores1);
  $totalRows_rsq_global_supervisores1 = mysql_num_rows($all_rsq_global_supervisores1);
}
$totalPages_rsq_global_supervisores1 = ceil($totalRows_rsq_global_supervisores1/$maxRows_rsq_global_supervisores1)-1;
//End NeXTenesio3 Special List Recordset

$nav_listq_global_supervisores1->checkBoundries();
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:: Contrataci&oacute;n :: MinCIT ::.</title>
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
  record_counter: false
}
</script>
<style type="text/css">
  /* Dynamic List row settings */
  .KT_col_NCONTRATO {width:140px; overflow:hidden;}
  .KT_col_cont_ano {width:140px; overflow:hidden;}
  .KT_col_usr_name {width:140px; overflow:hidden;}
  .KT_col_cont_nit_contra_ta {width:105px; overflow:hidden;}
  .KT_col_contractor_name {width:140px; overflow:hidden;}
  .KT_col_cont_fecha_inicio {width:140px; overflow:hidden;}
  .KT_col_cont_fechafinal {width:140px; overflow:hidden;}
  .KT_col_periodo_name {width:140px; overflow:hidden;}
  .KT_col_cont_informessug {width:140px; overflow:hidden;}
  .KT_col_id_cont_fk {width:140px; overflow:hidden;}
</style>
</head>

<body>
<?php
  mxi_includes_start("../inc_top.php");
  require(basename("../inc_top.php"));
  mxi_includes_end();
?>
<p>&nbsp;
<div class="KT_tng" id="listq_global_supervisores1">
  <h1> Q_global_supervisores
    <?php
  $nav_listq_global_supervisores1->Prepare();
  require("../includes/nav/NAV_Text_Statistics.inc.php");
?>
  </h1>
  <div class="KT_tnglist">
    <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
      <div class="KT_options"> <a href="<?php echo $nav_listq_global_supervisores1->getShowAllLink(); ?>"><?php echo NXT_getResource("Show"); ?>
            <?php 
  // Show IF Conditional region1
  if (@$_GET['show_all_nav_listq_global_supervisores1'] == 1) {
?>
              <?php echo $_SESSION['default_max_rows_nav_listq_global_supervisores1']; ?>
              <?php 
  // else Conditional region1
  } else { ?>
              <?php echo NXT_getResource("all"); ?>
              <?php } 
  // endif Conditional region1
?>
            <?php echo NXT_getResource("records"); ?></a> &nbsp;
        &nbsp;
                <?php 
  // Show IF Conditional region2
  if (@$_SESSION['has_filter_tfi_listq_global_supervisores1'] == 1) {
?>
                  <a href="<?php echo $tfi_listq_global_supervisores1->getResetFilterLink(); ?>"><?php echo NXT_getResource("Reset filter"); ?></a>
                  <?php 
  // else Conditional region2
  } else { ?>
                  <a href="<?php echo $tfi_listq_global_supervisores1->getShowFilterLink(); ?>"><?php echo NXT_getResource("Show filter"); ?></a>
                  <?php } 
  // endif Conditional region2
?>
      </div>
      <table cellpadding="2" cellspacing="0" class="KT_tngtable">
        <thead>
          <tr class="KT_row_order">
            <th> <input type="checkbox" name="KT_selAll" id="KT_selAll"/>
            </th>
            <th id="NCONTRATO" class="KT_sorter KT_col_NCONTRATO <?php echo $tso_listq_global_supervisores1->getSortIcon('q_global_supervisores.NCONTRATO'); ?>"> <a href="<?php echo $tso_listq_global_supervisores1->getSortLink('q_global_supervisores.NCONTRATO'); ?>">NUMERO</a> </th>
            <th id="cont_ano" class="KT_sorter KT_col_cont_ano <?php echo $tso_listq_global_supervisores1->getSortIcon('q_global_supervisores.cont_ano'); ?>"> <a href="<?php echo $tso_listq_global_supervisores1->getSortLink('q_global_supervisores.cont_ano'); ?>">PERIODO</a> </th>
            <th id="usr_name" class="KT_sorter KT_col_usr_name <?php echo $tso_listq_global_supervisores1->getSortIcon('q_global_supervisores.usr_name'); ?>"> <a href="<?php echo $tso_listq_global_supervisores1->getSortLink('q_global_supervisores.usr_name'); ?>">SUPERVISOR</a> </th>
            <th id="cont_nit_contra_ta" class="KT_sorter KT_col_cont_nit_contra_ta <?php echo $tso_listq_global_supervisores1->getSortIcon('q_global_supervisores.cont_nit_contra_ta'); ?>"> <a href="<?php echo $tso_listq_global_supervisores1->getSortLink('q_global_supervisores.cont_nit_contra_ta'); ?>">NIT/DOC</a> </th>
            <th id="contractor_name" class="KT_sorter KT_col_contractor_name <?php echo $tso_listq_global_supervisores1->getSortIcon('q_global_supervisores.contractor_name'); ?>"> <a href="<?php echo $tso_listq_global_supervisores1->getSortLink('q_global_supervisores.contractor_name'); ?>">NOMBRE/RAZON SOCIAL</a> </th>
            <th id="cont_fecha_inicio" class="KT_sorter KT_col_cont_fecha_inicio <?php echo $tso_listq_global_supervisores1->getSortIcon('q_global_supervisores.cont_fecha_inicio'); ?>"> <a href="<?php echo $tso_listq_global_supervisores1->getSortLink('q_global_supervisores.cont_fecha_inicio'); ?>">FECHA INICIO</a> </th>
            <th id="cont_fechafinal" class="KT_sorter KT_col_cont_fechafinal <?php echo $tso_listq_global_supervisores1->getSortIcon('q_global_supervisores.cont_fechafinal'); ?>"> <a href="<?php echo $tso_listq_global_supervisores1->getSortLink('q_global_supervisores.cont_fechafinal'); ?>">FECHA FINAL</a> </th>
            <th id="periodo_name" class="KT_sorter KT_col_periodo_name <?php echo $tso_listq_global_supervisores1->getSortIcon('q_global_supervisores.periodo_name'); ?>"> <a href="<?php echo $tso_listq_global_supervisores1->getSortLink('q_global_supervisores.periodo_name'); ?>">PERIODICIDAD</a> </th>
            <th id="cont_informessug" class="KT_sorter KT_col_cont_informessug <?php echo $tso_listq_global_supervisores1->getSortIcon('q_global_supervisores.cont_informessug'); ?>"> <a href="<?php echo $tso_listq_global_supervisores1->getSortLink('q_global_supervisores.cont_informessug'); ?>">INF. SUGERIDOS</a> </th>
            <th id="id_cont_fk" class="KT_sorter KT_col_id_cont_fk <?php echo $tso_listq_global_supervisores1->getSortIcon('q_global_supervisores.id_cont_fk'); ?>"> <a href="<?php echo $tso_listq_global_supervisores1->getSortLink('q_global_supervisores.id_cont_fk'); ?>">ID</a> </th>
            <th>&nbsp;</th>
          </tr>
          <?php 
  // Show IF Conditional region3
  if (@$_SESSION['has_filter_tfi_listq_global_supervisores1'] == 1) {
?>
            <tr class="KT_row_filter">
              <td>&nbsp;</td>
              <td><input type="text" name="tfi_listq_global_supervisores1_NCONTRATO" id="tfi_listq_global_supervisores1_NCONTRATO" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listq_global_supervisores1_NCONTRATO']); ?>" size="20" maxlength="26" /></td>
              <td><input type="text" name="tfi_listq_global_supervisores1_cont_ano" id="tfi_listq_global_supervisores1_cont_ano" value="<?php echo @$_SESSION['tfi_listq_global_supervisores1_cont_ano']; ?>" size="10" maxlength="22" /></td>
              <td><input type="text" name="tfi_listq_global_supervisores1_usr_name" id="tfi_listq_global_supervisores1_usr_name" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listq_global_supervisores1_usr_name']); ?>" size="20" maxlength="60" /></td>
              <td><input type="text" name="tfi_listq_global_supervisores1_cont_nit_contra_ta" id="tfi_listq_global_supervisores1_cont_nit_contra_ta" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listq_global_supervisores1_cont_nit_contra_ta']); ?>" size="15" maxlength="15" /></td>
              <td><input type="text" name="tfi_listq_global_supervisores1_contractor_name" id="tfi_listq_global_supervisores1_contractor_name" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listq_global_supervisores1_contractor_name']); ?>" size="20" maxlength="100" /></td>
              <td><input type="text" name="tfi_listq_global_supervisores1_cont_fecha_inicio" id="tfi_listq_global_supervisores1_cont_fecha_inicio" value="<?php echo @$_SESSION['tfi_listq_global_supervisores1_cont_fecha_inicio']; ?>" size="10" maxlength="22" /></td>
              <td><input type="text" name="tfi_listq_global_supervisores1_cont_fechafinal" id="tfi_listq_global_supervisores1_cont_fechafinal" value="<?php echo @$_SESSION['tfi_listq_global_supervisores1_cont_fechafinal']; ?>" size="10" maxlength="22" /></td>
              <td><input type="text" name="tfi_listq_global_supervisores1_periodo_name" id="tfi_listq_global_supervisores1_periodo_name" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listq_global_supervisores1_periodo_name']); ?>" size="20" maxlength="30" /></td>
              <td><input type="text" name="tfi_listq_global_supervisores1_cont_informessug" id="tfi_listq_global_supervisores1_cont_informessug" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listq_global_supervisores1_cont_informessug']); ?>" size="20" maxlength="100" /></td>
              <td><input type="text" name="tfi_listq_global_supervisores1_id_cont_fk" id="tfi_listq_global_supervisores1_id_cont_fk" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listq_global_supervisores1_id_cont_fk']); ?>" size="20" maxlength="100" /></td>
              <td><input type="submit" name="tfi_listq_global_supervisores1" value="<?php echo NXT_getResource("Filter"); ?>" /></td>
            </tr>
            <?php } 
  // endif Conditional region3
?>
        </thead>
        <tbody>
          <?php if ($totalRows_rsq_global_supervisores1 == 0) { // Show if recordset empty ?>
            <tr>
              <td colspan="12"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
            </tr>
            <?php } // Show if recordset empty ?>
          <?php if ($totalRows_rsq_global_supervisores1 > 0) { // Show if recordset not empty ?>
            <?php do { ?>
              <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
                <td><input type="checkbox" name="kt_pk_q_global_supervisores" class="id_checkbox" value="<?php echo $row_rsq_global_supervisores1['id_cont_fk']; ?>" />
                    <input type="hidden" name="id_cont_fk" class="id_field" value="<?php echo $row_rsq_global_supervisores1['id_cont_fk']; ?>" />
                </td>
                <td><div class="KT_col_NCONTRATO"><?php echo KT_FormatForList($row_rsq_global_supervisores1['NCONTRATO'], 20); ?></div></td>
                <td><div class="KT_col_cont_ano"><?php echo KT_formatDate($row_rsq_global_supervisores1['cont_ano']); ?></div></td>
                <td><div class="KT_col_usr_name"><?php echo $row_rsq_global_supervisores1['usr_name'].' '.$row_rsq_global_supervisores1['usr_lname']; ?></div></td>
                <td><div class="KT_col_cont_nit_contra_ta"><?php echo KT_FormatForList($row_rsq_global_supervisores1['cont_nit_contra_ta'], 15); ?></div></td>
                <td><div class="KT_col_contractor_name"><?php echo $row_rsq_global_supervisores1['contractor_name']; ?></div></td>
                <td><div class="KT_col_cont_fecha_inicio"><?php echo KT_formatDate($row_rsq_global_supervisores1['cont_fecha_inicio']); ?></div></td>
                <td><div class="KT_col_cont_fechafinal"><?php echo KT_formatDate($row_rsq_global_supervisores1['cont_fechafinal']); ?></div></td>
                <td><div class="KT_col_periodo_name"><?php echo KT_FormatForList($row_rsq_global_supervisores1['periodo_name'], 20); ?></div></td>
                <td><div class="KT_col_cont_informessug"><?php echo KT_FormatForList($row_rsq_global_supervisores1['cont_informessug'], 20); ?></div></td>
                <td><div class="KT_col_id_cont_fk"><?php echo KT_FormatForList($row_rsq_global_supervisores1['id_cont_fk'], 20); ?></div></td>
                <td><a class="KT_edit_link" href="supervisor_ct_edit.php?id_cont_fk=<?php echo $row_rsq_global_supervisores1['id_cont_fk']; ?>&amp;KT_back=1"><?php echo NXT_getResource("edit_one"); ?></a> <a class="KT_delete_link" href="#delete"><?php echo NXT_getResource("delete_one"); ?></a> </td>
              </tr>
              <?php } while ($row_rsq_global_supervisores1 = mysql_fetch_assoc($rsq_global_supervisores1)); ?>
            <?php } // Show if recordset not empty ?>
        </tbody>
      </table>
      <div class="KT_bottomnav">
        <div>
          <?php
            $nav_listq_global_supervisores1->Prepare();
            require("../includes/nav/NAV_Text_Navigation.inc.php");
          ?>
        </div>
      </div>
      <div class="KT_bottombuttons">
        <div class="KT_operations"> <a class="KT_edit_op_link" href="#" onclick="nxt_list_edit_link_form(this); return false;"><?php echo NXT_getResource("edit_all"); ?></a> <a class="KT_delete_op_link" href="#" onclick="nxt_list_delete_link_form(this); return false;"><?php echo NXT_getResource("delete_all"); ?></a> </div>
        <span>&nbsp;</span>
        <select name="no_new" id="no_new">
          <option value="1">1</option>
          <option value="3">3</option>
          <option value="6">6</option>
        </select>
        <a class="KT_additem_op_link" href="supervisor_ct_edit.php?KT_back=1" onclick="return nxt_list_additem(this)"><?php echo NXT_getResource("add new"); ?></a> </div>
    </form>
  </div>
  <br class="clearfixplain" />
</div>
<p>&nbsp;</p>
</p>
<?php
  mxi_includes_start("../inc_foot.php");
  require(basename("../inc_foot.php"));
  mxi_includes_end();
?>
</body>
</html>
<?php
mysql_free_result($rsq_global_supervisores1);
?>
