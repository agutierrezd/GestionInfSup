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
$tfi_listq_minutas_list1 = new TFI_TableFilter($conn_oConnContratos, "tfi_listq_minutas_list1");
$tfi_listq_minutas_list1->addColumn("q_minutas_list.No", "DOUBLE_TYPE", "No", "=");
$tfi_listq_minutas_list1->addColumn("q_minutas_list.fecha", "DATE_TYPE", "fecha", "=");
$tfi_listq_minutas_list1->addColumn("q_minutas_list.ANIO", "NUMERIC_TYPE", "ANIO", "=");
$tfi_listq_minutas_list1->addColumn("q_minutas_list.nit", "STRING_TYPE", "nit", "%");
$tfi_listq_minutas_list1->addColumn("q_minutas_list.contractor_name", "STRING_TYPE", "contractor_name", "%");
$tfi_listq_minutas_list1->addColumn("q_minutas_list.email", "STRING_TYPE", "email", "%");
$tfi_listq_minutas_list1->addColumn("q_minutas_list.valor", "DOUBLE_TYPE", "valor", "=");
$tfi_listq_minutas_list1->addColumn("q_minutas_list.ctrl", "NUMERIC_TYPE", "ctrl", "=");
$tfi_listq_minutas_list1->Execute();

// Sorter
$tso_listq_minutas_list1 = new TSO_TableSorter("rsq_minutas_list1", "tso_listq_minutas_list1");
$tso_listq_minutas_list1->addColumn("q_minutas_list.No");
$tso_listq_minutas_list1->addColumn("q_minutas_list.fecha");
$tso_listq_minutas_list1->addColumn("q_minutas_list.ANIO");
$tso_listq_minutas_list1->addColumn("q_minutas_list.nit");
$tso_listq_minutas_list1->addColumn("q_minutas_list.contractor_name");
$tso_listq_minutas_list1->addColumn("q_minutas_list.email");
$tso_listq_minutas_list1->addColumn("q_minutas_list.valor");
$tso_listq_minutas_list1->addColumn("q_minutas_list.ctrl");
$tso_listq_minutas_list1->setDefault("q_minutas_list.No DESC");
$tso_listq_minutas_list1->Execute();

// Navigation
$nav_listq_minutas_list1 = new NAV_Regular("nav_listq_minutas_list1", "rsq_minutas_list1", "../", $_SERVER['PHP_SELF'], 25);

//NeXTenesio3 Special List Recordset
$maxRows_rsq_minutas_list1 = $_SESSION['max_rows_nav_listq_minutas_list1'];
$pageNum_rsq_minutas_list1 = 0;
if (isset($_GET['pageNum_rsq_minutas_list1'])) {
  $pageNum_rsq_minutas_list1 = $_GET['pageNum_rsq_minutas_list1'];
}
$startRow_rsq_minutas_list1 = $pageNum_rsq_minutas_list1 * $maxRows_rsq_minutas_list1;

// Defining List Recordset variable
$NXTFilter_rsq_minutas_list1 = "1=1";
if (isset($_SESSION['filter_tfi_listq_minutas_list1'])) {
  $NXTFilter_rsq_minutas_list1 = $_SESSION['filter_tfi_listq_minutas_list1'];
}
// Defining List Recordset variable
$NXTSort_rsq_minutas_list1 = "q_minutas_list.No DESC";
if (isset($_SESSION['sorter_tso_listq_minutas_list1'])) {
  $NXTSort_rsq_minutas_list1 = $_SESSION['sorter_tso_listq_minutas_list1'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);

$query_rsq_minutas_list1 = "SELECT q_minutas_list.No, q_minutas_list.fecha, q_minutas_list.ANIO, q_minutas_list.nit, q_minutas_list.contractor_name, q_minutas_list.email, q_minutas_list.valor, q_minutas_list.ctrl, q_minutas_list.Id FROM q_minutas_list WHERE {$NXTFilter_rsq_minutas_list1} ORDER BY {$NXTSort_rsq_minutas_list1}";
$query_limit_rsq_minutas_list1 = sprintf("%s LIMIT %d, %d", $query_rsq_minutas_list1, $startRow_rsq_minutas_list1, $maxRows_rsq_minutas_list1);
$rsq_minutas_list1 = mysql_query($query_limit_rsq_minutas_list1, $oConnContratos) or die(mysql_error());
$row_rsq_minutas_list1 = mysql_fetch_assoc($rsq_minutas_list1);

if (isset($_GET['totalRows_rsq_minutas_list1'])) {
  $totalRows_rsq_minutas_list1 = $_GET['totalRows_rsq_minutas_list1'];
} else {
  $all_rsq_minutas_list1 = mysql_query($query_rsq_minutas_list1);
  $totalRows_rsq_minutas_list1 = mysql_num_rows($all_rsq_minutas_list1);
}
$totalPages_rsq_minutas_list1 = ceil($totalRows_rsq_minutas_list1/$maxRows_rsq_minutas_list1)-1;
//End NeXTenesio3 Special List Recordset

$nav_listq_minutas_list1->checkBoundries();
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
  duplicate_buttons: true,
  duplicate_navigation: true,
  row_effects: true,
  show_as_buttons: true,
  record_counter: false
}
</script>
<style type="text/css">
  /* Dynamic List row settings */
  .KT_col_No {width:140px; overflow:hidden;}
  .KT_col_fecha {width:140px; overflow:hidden;}
  .KT_col_ANIO {width:140px; overflow:hidden;}
  .KT_col_nit {width:140px; overflow:hidden;}
  .KT_col_contractor_name {width:140px; overflow:hidden;}
  .KT_col_email {width:140px; overflow:hidden;}
  .KT_col_valor {width:140px; overflow:hidden;}
  .KT_col_ctrl {width:140px; overflow:hidden;}
</style>
</head>

<body>
<?php
  mxi_includes_start("../inc_top.php");
  require(basename("../inc_top.php"));
  mxi_includes_end();
?>
<div class="KT_tng" id="listq_minutas_list1">
  <h1> Registros
    <?php
  $nav_listq_minutas_list1->Prepare();
  require("../includes/nav/NAV_Text_Statistics.inc.php");
?>
  </h1>
  <div class="KT_tnglist">
    <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
      <div class="KT_options"> <a href="<?php echo $nav_listq_minutas_list1->getShowAllLink(); ?>"><?php echo NXT_getResource("Show"); ?>
        <?php 
  // Show IF Conditional region1
  if (@$_GET['show_all_nav_listq_minutas_list1'] == 1) {
?>
          <?php echo $_SESSION['default_max_rows_nav_listq_minutas_list1']; ?>
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
  if (@$_SESSION['has_filter_tfi_listq_minutas_list1'] == 1) {
?>
                  <a href="<?php echo $tfi_listq_minutas_list1->getResetFilterLink(); ?>"><?php echo NXT_getResource("Reset filter"); ?></a>
                  <?php 
  // else Conditional region2
  } else { ?>
                  <a href="<?php echo $tfi_listq_minutas_list1->getShowFilterLink(); ?>"><?php echo NXT_getResource("Show filter"); ?></a>
                  <?php } 
  // endif Conditional region2
?>
      </div>
      <table cellpadding="2" cellspacing="0" class="KT_tngtable">
        <thead>
          <tr class="KT_row_order">
            <th> <input type="checkbox" name="KT_selAll" id="KT_selAll"/>
            </th>
            <th id="No" class="KT_sorter KT_col_No <?php echo $tso_listq_minutas_list1->getSortIcon('q_minutas_list.No'); ?>"> <a href="<?php echo $tso_listq_minutas_list1->getSortLink('q_minutas_list.No'); ?>">No.</a> </th>
            <th id="fecha" class="KT_sorter KT_col_fecha <?php echo $tso_listq_minutas_list1->getSortIcon('q_minutas_list.fecha'); ?>"> <a href="<?php echo $tso_listq_minutas_list1->getSortLink('q_minutas_list.fecha'); ?>">FECHA</a> </th>
            <th id="ANIO" class="KT_sorter KT_col_ANIO <?php echo $tso_listq_minutas_list1->getSortIcon('q_minutas_list.ANIO'); ?>"> <a href="<?php echo $tso_listq_minutas_list1->getSortLink('q_minutas_list.ANIO'); ?>">A�O</a> </th>
            <th id="nit" class="KT_sorter KT_col_nit <?php echo $tso_listq_minutas_list1->getSortIcon('q_minutas_list.nit'); ?>"> <a href="<?php echo $tso_listq_minutas_list1->getSortLink('q_minutas_list.nit'); ?>">NIT/DOCUMENTO</a> </th>
            <th id="contractor_name" class="KT_sorter KT_col_contractor_name <?php echo $tso_listq_minutas_list1->getSortIcon('q_minutas_list.contractor_name'); ?>"> <a href="<?php echo $tso_listq_minutas_list1->getSortLink('q_minutas_list.contractor_name'); ?>">NOMBRE</a> </th>
            <th id="email" class="KT_sorter KT_col_email <?php echo $tso_listq_minutas_list1->getSortIcon('q_minutas_list.email'); ?>"> <a href="<?php echo $tso_listq_minutas_list1->getSortLink('q_minutas_list.email'); ?>">EMAIL</a> </th>
            <th id="valor" class="KT_sorter KT_col_valor <?php echo $tso_listq_minutas_list1->getSortIcon('q_minutas_list.valor'); ?>"> <a href="<?php echo $tso_listq_minutas_list1->getSortLink('q_minutas_list.valor'); ?>">VALOR</a> </th>
            <th id="ctrl" class="KT_sorter KT_col_ctrl <?php echo $tso_listq_minutas_list1->getSortIcon('q_minutas_list.ctrl'); ?>"> <a href="<?php echo $tso_listq_minutas_list1->getSortLink('q_minutas_list.ctrl'); ?>">ACCION</a> </th>
            <th>&nbsp;</th>
          </tr>
          <?php 
  // Show IF Conditional region3
  if (@$_SESSION['has_filter_tfi_listq_minutas_list1'] == 1) {
?>
            <tr class="KT_row_filter">
              <td>&nbsp;</td>
              <td><input type="text" name="tfi_listq_minutas_list1_No" id="tfi_listq_minutas_list1_No" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listq_minutas_list1_No']); ?>" size="20" maxlength="100" /></td>
              <td><input type="text" name="tfi_listq_minutas_list1_fecha" id="tfi_listq_minutas_list1_fecha" value="<?php echo @$_SESSION['tfi_listq_minutas_list1_fecha']; ?>" size="10" maxlength="22" /></td>
              <td><input type="text" name="tfi_listq_minutas_list1_ANIO" id="tfi_listq_minutas_list1_ANIO" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listq_minutas_list1_ANIO']); ?>" size="20" maxlength="100" /></td>
              <td><input type="text" name="tfi_listq_minutas_list1_nit" id="tfi_listq_minutas_list1_nit" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listq_minutas_list1_nit']); ?>" size="20" maxlength="255" /></td>
              <td><input type="text" name="tfi_listq_minutas_list1_contractor_name" id="tfi_listq_minutas_list1_contractor_name" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listq_minutas_list1_contractor_name']); ?>" size="20" maxlength="255" /></td>
              <td><input type="text" name="tfi_listq_minutas_list1_email" id="tfi_listq_minutas_list1_email" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listq_minutas_list1_email']); ?>" size="20" maxlength="255" /></td>
              <td><input type="text" name="tfi_listq_minutas_list1_valor" id="tfi_listq_minutas_list1_valor" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listq_minutas_list1_valor']); ?>" size="20" maxlength="100" /></td>
              <td><input type="text" name="tfi_listq_minutas_list1_ctrl" id="tfi_listq_minutas_list1_ctrl" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listq_minutas_list1_ctrl']); ?>" size="20" maxlength="100" /></td>
              <td><input type="submit" name="tfi_listq_minutas_list1" value="<?php echo NXT_getResource("Filter"); ?>" /></td>
            </tr>
            <?php } 
  // endif Conditional region3
?>
        </thead>
        <tbody>
          <?php if ($totalRows_rsq_minutas_list1 == 0) { // Show if recordset empty ?>
            <tr>
              <td colspan="10"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
            </tr>
            <?php } // Show if recordset empty ?>
          <?php if ($totalRows_rsq_minutas_list1 > 0) { // Show if recordset not empty ?>
            <?php do { ?>
              <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
                <td><input type="checkbox" name="kt_pk_q_minutas_list" class="id_checkbox" value="<?php echo $row_rsq_minutas_list1['Id']; ?>" />
                    <input type="hidden" name="Id" class="id_field" value="<?php echo $row_rsq_minutas_list1['Id']; ?>" />
                </td>
                <td><div class="KT_col_No"><?php echo KT_FormatForList($row_rsq_minutas_list1['No'], 20); ?></div></td>
                <td><div class="KT_col_fecha"><?php echo KT_formatDate($row_rsq_minutas_list1['fecha']); ?></div></td>
                <td><div class="KT_col_ANIO"><?php echo KT_FormatForList($row_rsq_minutas_list1['ANIO'], 20); ?></div></td>
                <td><div class="KT_col_nit"><?php echo KT_FormatForList($row_rsq_minutas_list1['nit'], 20); ?></div></td>
                <td><div class="KT_col_contractor_name"><?php echo $row_rsq_minutas_list1['contractor_name']; ?></div></td>
                <td><div class="KT_col_email"><?php echo $row_rsq_minutas_list1['email']; ?></div></td>
                <td><div class="KT_col_valor"><?php echo KT_FormatForList($row_rsq_minutas_list1['valor'], 20); ?></div></td>
                <td align="center"><?php 
// Show IF Conditional region4 
if (@$row_rsq_minutas_list1['ctrl'] == 1) {
?>
                    <a href="minuta_estatus.php?Id=<?php echo $row_rsq_minutas_list1['Id']; ?>&amp;ctrl=0" title="Clic para desactivar"><img src="../img_mcit/active.png" width="24" height="24" border="0" /></a>
                    <?php } 
// endif Conditional region4
?>
                  <?php 
// Show IF Conditional region5 
if (@$row_rsq_minutas_list1['ctrl'] == 0) {
?>
                    <a href="minuta_estatus.php?Id=<?php echo $row_rsq_minutas_list1['Id']; ?>&amp;ctrl=1" title="Activar"><img src="../img_mcit/inactive.png" width="24" height="24" border="0" /></a>
                    <?php } 
// endif Conditional region5
?></td>
                <td><a class="KT_edit_link" href="minuta_edit.php?Id=<?php echo $row_rsq_minutas_list1['Id']; ?>&amp;KT_back=1"><?php echo NXT_getResource("edit_one"); ?></a></td>
              </tr>
              <?php } while ($row_rsq_minutas_list1 = mysql_fetch_assoc($rsq_minutas_list1)); ?>
            <?php } // Show if recordset not empty ?>
        </tbody>
      </table>
      <div class="KT_bottomnav">
        <div>
          <?php
            $nav_listq_minutas_list1->Prepare();
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
        <a class="KT_additem_op_link" href="minuta_edit.php?KT_back=1" onclick="return nxt_list_additem(this)"><?php echo NXT_getResource("add new"); ?></a> </div>
    </form>
  </div>
  <br class="clearfixplain" />
</div>
<?php
  mxi_includes_start("../inc_foot.php");
  require(basename("../inc_foot.php"));
  mxi_includes_end();
?>
</body>
</html>
<?php
mysql_free_result($rsq_minutas_list1);
?>
