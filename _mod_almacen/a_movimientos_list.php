<?php require_once('../Connections/oConnAlmacen.php'); ?>
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
$conn_oConnAlmacen = new KT_connection($oConnAlmacen, $database_oConnAlmacen);

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
$tfi_listrslistasientos1 = new TFI_TableFilter($conn_oConnAlmacen, "tfi_listrslistasientos1");
$tfi_listrslistasientos1->addColumn("ascodalmacen", "NUMERIC_TYPE", "ascodalmacen", "=");
$tfi_listrslistasientos1->addColumn("as_nroasiento", "NUMERIC_TYPE", "as_nroasiento", "=");
$tfi_listrslistasientos1->addColumn("as_fechaasiento", "DATE_TYPE", "as_fechaasiento", "=");
$tfi_listrslistasientos1->addColumn("as_estadoasien", "STRING_TYPE", "as_estadoasien", "%");
$tfi_listrslistasientos1->Execute();

// Sorter
$tso_listrslistasientos1 = new TSO_TableSorter("rslistasientos", "tso_listrslistasientos1");
$tso_listrslistasientos1->addColumn("ascodalmacen");
$tso_listrslistasientos1->addColumn("as_nroasiento");
$tso_listrslistasientos1->addColumn("as_fechaasiento");
$tso_listrslistasientos1->addColumn("as_estadoasien");
$tso_listrslistasientos1->setDefault("as_nroasiento DESC");
$tso_listrslistasientos1->Execute();

// Navigation
$nav_listrslistasientos1 = new NAV_Regular("nav_listrslistasientos1", "rslistasientos", "../", $_SERVER['PHP_SELF'], 25);

//NeXTenesio3 Special List Recordset
$maxRows_rslistasientos = $_SESSION['max_rows_nav_listrslistasientos1'];
$pageNum_rslistasientos = 0;
if (isset($_GET['pageNum_rslistasientos'])) {
  $pageNum_rslistasientos = $_GET['pageNum_rslistasientos'];
}
$startRow_rslistasientos = $pageNum_rslistasientos * $maxRows_rslistasientos;

$colname_rslistasientos = "-1";
if (isset($_GET['anio_id'])) {
  $colname_rslistasientos = $_GET['anio_id'];
}
// Defining List Recordset variable
$NXTFilter_rslistasientos = "1=1";
if (isset($_SESSION['filter_tfi_listrslistasientos1'])) {
  $NXTFilter_rslistasientos = $_SESSION['filter_tfi_listrslistasientos1'];
}
// Defining List Recordset variable
$NXTSort_rslistasientos = "as_nroasiento DESC";
if (isset($_SESSION['sorter_tso_listrslistasientos1'])) {
  $NXTSort_rslistasientos = $_SESSION['sorter_tso_listrslistasientos1'];
}
mysql_select_db($database_oConnAlmacen, $oConnAlmacen);

$query_rslistasientos = sprintf("SELECT * FROM q_asientos_master WHERE PERIODO = %s AND  {$NXTFilter_rslistasientos}  ORDER BY  {$NXTSort_rslistasientos} ", GetSQLValueString($colname_rslistasientos, "int"));
$query_limit_rslistasientos = sprintf("%s LIMIT %d, %d", $query_rslistasientos, $startRow_rslistasientos, $maxRows_rslistasientos);
$rslistasientos = mysql_query($query_limit_rslistasientos, $oConnAlmacen) or die(mysql_error());
$row_rslistasientos = mysql_fetch_assoc($rslistasientos);

if (isset($_GET['totalRows_rslistasientos'])) {
  $totalRows_rslistasientos = $_GET['totalRows_rslistasientos'];
} else {
  $all_rslistasientos = mysql_query($query_rslistasientos);
  $totalRows_rslistasientos = mysql_num_rows($all_rslistasientos);
}
$totalPages_rslistasientos = ceil($totalRows_rslistasientos/$maxRows_rslistasientos)-1;
//End NeXTenesio3 Special List Recordset

mysql_select_db($database_oConnAlmacen, $oConnAlmacen);
$query_rsperiodos = "SELECT * FROM global_periodos ORDER BY periodo_name DESC";
$rsperiodos = mysql_query($query_rsperiodos, $oConnAlmacen) or die(mysql_error());
$row_rsperiodos = mysql_fetch_assoc($rsperiodos);
$totalRows_rsperiodos = mysql_num_rows($rsperiodos);

$nav_listrslistasientos1->checkBoundries();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:: Contrataci&oacute;n :: MinCIT ::.</title>
<link rel="stylesheet" href="../_jquery/_desktop/_app/themes/south-street/jquery.ui.all.css">
<script src="../_jquery/_desktop/_app/jquery-1.9.1.js"></script>
<script src="../_jquery/_desktop/_app/ui/jquery.ui.core.js"></script>
<script src="../_jquery/_desktop/_app/ui/jquery.ui.widget.js"></script>
<script src="../_jquery/_desktop/_app/ui/jquery.ui.tabs.js"></script>
	<script src="../_jquery/_desktop/_app/ui/jquery.ui.button.js"></script>
	<script src="../_jquery/_desktop/_app/ui/jquery.ui.position.js"></script>
	<script src="../_jquery/_desktop/_app/ui/jquery.ui.menu.js"></script>
   	<script src="../_jquery/_desktop/_app/ui/jquery.ui.button.js"></script>
	<link rel="stylesheet" href="../_jquery/_desktop/_app/_modules/demos.css">
    <style>
		.ui-menu { position: absolute; width: 100px; }
	</style>
<script>
	$(function() {
		$( "#tabs" ).tabs();
		
		$( "#rerun" )
			.button()
			.click(function() {
				alert( "Seleccionar acci�n" );
			})
			.next()
				.button({
					text: false,
					icons: {
						primary: "ui-icon-triangle-1-s"
					}
				})
				.click(function() {
					var menu = $( this ).parent().next().show().position({
						my: "left top",
						at: "left bottom",
						of: this
					});
					$( document ).one( "click", function() {
						menu.hide();
					});
					return false;
				})
				.parent()
					.buttonset()
					.next()
						.hide()
						.menu();
	});
	</script>
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
  .KT_col_ascodalmacen {width:140px; overflow:hidden;}
  .KT_col_as_nroasiento {width:140px; overflow:hidden;}
  .KT_col_as_fechaasiento {width:140px; overflow:hidden;}
  .KT_col_as_estadoasien {width:140px; overflow:hidden;}
</style>
<link href="../_css/jqueryslidemenu.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php
  mxi_includes_start("../inc_top_2.php");
  require(basename("../inc_top_2.php"));
  mxi_includes_end();
?>
<div>
	<div>
		<button id="rerun">PERIODOS</button>
		<button id="select">PERIODOS</button>
	</div>
	<ul>
	  <?php do { ?>
      <li><a href="a_movimientos_list.php?anio_id=<?php echo $row_rsperiodos['periodo_name']; ?>" title="Seleccionar periodo"><?php echo $row_rsperiodos['periodo_name']; ?></a></li>
	  <?php } while ($row_rsperiodos = mysql_fetch_assoc($rsperiodos)); ?>
    </ul>
</div>
<div class="KT_tng" id="listrslistasientos1">
  <h1><span class="titlemsg2">INGRESOS</span>
    <?php
  $nav_listrslistasientos1->Prepare();
  require("../includes/nav/NAV_Text_Statistics.inc.php");
?>
  </h1>
  <div class="KT_tnglist">
    <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
      <div class="KT_options"> <a href="<?php echo $nav_listrslistasientos1->getShowAllLink(); ?>"><?php echo NXT_getResource("Show"); ?>
        <?php 
  // Show IF Conditional region1
  if (@$_GET['show_all_nav_listrslistasientos1'] == 1) {
?>
          <?php echo $_SESSION['default_max_rows_nav_listrslistasientos1']; ?>
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
  if (@$_SESSION['has_filter_tfi_listrslistasientos1'] == 1) {
?>
                  <a href="<?php echo $tfi_listrslistasientos1->getResetFilterLink(); ?>"><?php echo NXT_getResource("Reset filter"); ?></a>
                  <?php 
  // else Conditional region2
  } else { ?>
                  <a href="<?php echo $tfi_listrslistasientos1->getShowFilterLink(); ?>"><?php echo NXT_getResource("Show filter"); ?></a>
                  <?php } 
  // endif Conditional region2
?>
      </div>
      <table cellpadding="2" cellspacing="0" class="KT_tngtable">
        <thead>
          <tr class="KT_row_order">
            <th>ACCIONES</th>
            <th id="ascodalmacen" class="KT_sorter KT_col_ascodalmacen <?php echo $tso_listrslistasientos1->getSortIcon('ascodalmacen'); ?>"> <a href="<?php echo $tso_listrslistasientos1->getSortLink('ascodalmacen'); ?>">ALMACEN</a> </th>
            <th id="as_nroasiento" class="KT_sorter KT_col_as_nroasiento <?php echo $tso_listrslistasientos1->getSortIcon('as_nroasiento'); ?>"> <a href="<?php echo $tso_listrslistasientos1->getSortLink('as_nroasiento'); ?>">No. ASIENTO</a> </th>
            <th id="as_fechaasiento" class="KT_sorter KT_col_as_fechaasiento <?php echo $tso_listrslistasientos1->getSortIcon('as_fechaasiento'); ?>"> <a href="<?php echo $tso_listrslistasientos1->getSortLink('as_fechaasiento'); ?>">FECHA</a> </th>
            <th id="as_estadoasien" class="KT_sorter KT_col_as_estadoasien <?php echo $tso_listrslistasientos1->getSortIcon('as_estadoasien'); ?>"> <a href="<?php echo $tso_listrslistasientos1->getSortLink('as_estadoasien'); ?>">ESTADO</a> </th>
            <th>&nbsp;</th>
          </tr>
          <?php 
  // Show IF Conditional region3
  if (@$_SESSION['has_filter_tfi_listrslistasientos1'] == 1) {
?>
            <tr class="KT_row_filter">
              <td>&nbsp;</td>
              <td><input type="text" name="tfi_listrslistasientos1_ascodalmacen" id="tfi_listrslistasientos1_ascodalmacen" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrslistasientos1_ascodalmacen']); ?>" size="20" maxlength="100" /></td>
              <td><input type="text" name="tfi_listrslistasientos1_as_nroasiento" id="tfi_listrslistasientos1_as_nroasiento" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrslistasientos1_as_nroasiento']); ?>" size="20" maxlength="100" /></td>
              <td><input type="text" name="tfi_listrslistasientos1_as_fechaasiento" id="tfi_listrslistasientos1_as_fechaasiento" value="<?php echo @$_SESSION['tfi_listrslistasientos1_as_fechaasiento']; ?>" size="10" maxlength="22" /></td>
              <td><input type="text" name="tfi_listrslistasientos1_as_estadoasien" id="tfi_listrslistasientos1_as_estadoasien" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrslistasientos1_as_estadoasien']); ?>" size="20" maxlength="20" /></td>
              <td><input type="submit" name="tfi_listrslistasientos1" value="<?php echo NXT_getResource("Filter"); ?>" /></td>
            </tr>
            <?php } 
  // endif Conditional region3
?>
        </thead>
        <tbody>
          <?php if ($totalRows_rslistasientos == 0) { // Show if recordset empty ?>
            <tr>
              <td colspan="6"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
            </tr>
            <?php } // Show if recordset empty ?>
          <?php if ($totalRows_rslistasientos > 0) { // Show if recordset not empty ?>
            <?php do { ?>
              <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
                <td><input type="hidden" name="as_id" class="id_field" value="<?php echo $row_rslistasientos['as_id']; ?>" />
                  <a href="a_docs_soporte_list.php?as_id=<?php echo $row_rslistasientos['as_id']; ?>&amp;anio_id=<?php echo $_GET['anio_id']; ?>&amp;hash_id=<?php echo md5($row_rslistasientos['as_id']); ?>" title="Ver / Crear movimientos"><img src="325_docs.png" width="32" height="32" border="0" /></a></td>
                <td><div class="KT_col_ascodalmacen"><span class="titlemsg2"><?php echo KT_FormatForList($row_rslistasientos['ascodalmacen'], 20); ?></span></div></td>
                <td><div class="KT_col_as_nroasiento"><span class="titlemsg2"><?php echo KT_FormatForList($row_rslistasientos['as_nroasiento'], 20); ?></span></div></td>
                <td><div class="titlemsg2"><?php echo KT_formatDate($row_rslistasientos['as_fechaasiento']); ?></div></td>
                <td><div class="KT_col_as_estadoasien"><?php echo KT_FormatForList($row_rslistasientos['as_estadoasien'], 20); ?></div></td>
                <td><?php 
// Show IF Conditional region4 
if (@$row_rslistasientos['as_estadoasien'] == "A" and $_SESSION['kt_login_level'] == 8) {
?>
                    <a class="KT_edit_link" href="a_movimientos_edit.php?cod_almacen=<?php echo $row_rslistasientos['ascodalmacen']; ?>&amp;as_id=<?php echo $row_rslistasientos['as_id']; ?>&amp;KT_back=1"><?php echo NXT_getResource("edit_one"); ?></a>
                <?php } 
// endif Conditional region4
?></td>
              </tr>
              <?php } while ($row_rslistasientos = mysql_fetch_assoc($rslistasientos)); ?>
            <?php } // Show if recordset not empty ?>
        </tbody>
      </table>
      <div class="KT_bottomnav">
        <div>
          <?php
            $nav_listrslistasientos1->Prepare();
            require("../includes/nav/NAV_Text_Navigation.inc.php");
          ?>
        </div>
      </div>
      <div class="KT_bottombuttons">
        <div class="KT_operations"><a class="KT_delete_op_link" href="#" onclick="nxt_list_delete_link_form(this); return false;"></a> </div>
<span>&nbsp;</span>
        <?php 
// Show IF Conditional region5 
if (@$_SESSION['kt_login_level'] == 8) {
?>
          <select name="no_new" id="no_new">
            <option value="1">1</option>
          </select>
          <?php } 
// endif Conditional region5
?>
        <?php 
// Show IF Conditional region6 
if (@$_SESSION['kt_login_level'] == 8) {
?>
          <a class="KT_additem_op_link" href="a_movimientos_edit.php?cod_almacen=<?php echo $row_rslistasientos['ascodalmacen']; ?>&amp;KT_back=1&amp;anio_id=<?php echo $_GET['anio_id']; ?>" onclick="return nxt_list_additem(this)"><?php echo NXT_getResource("add new"); ?></a>
          <?php } 
// endif Conditional region6
?> </div>
    </form>
  </div>
  <br class="clearfixplain" />
</div>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<?php
  mxi_includes_start("../inc_foot.php");
  require(basename("../inc_foot.php"));
  mxi_includes_end();
?>
</body>
</html>
<?php
mysql_free_result($rslistasientos);

mysql_free_result($rsperiodos);
?>
