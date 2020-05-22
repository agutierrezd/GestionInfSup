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
$tfi_listrslistcontsup1 = new TFI_TableFilter($conn_oConnContratos, "tfi_listrslistcontsup1");
$tfi_listrslistcontsup1->addColumn("NCONTRATO", "STRING_TYPE", "NCONTRATO", "%");
$tfi_listrslistcontsup1->addColumn("cont_fecha_inicio", "DATE_TYPE", "cont_fecha_inicio", "=");
$tfi_listrslistcontsup1->addColumn("cont_fechafinal", "DATE_TYPE", "cont_fechafinal", "=");
$tfi_listrslistcontsup1->addColumn("cont_nit_contra_ta", "STRING_TYPE", "cont_nit_contra_ta", "%");
$tfi_listrslistcontsup1->addColumn("contractor_name", "STRING_TYPE", "contractor_name", "%");
$tfi_listrslistcontsup1->addColumn("periodo_name", "STRING_TYPE", "periodo_name", "%");
$tfi_listrslistcontsup1->addColumn("cont_informessug", "NUMERIC_TYPE", "cont_informessug", "=");
$tfi_listrslistcontsup1->Execute();

// Sorter
$tso_listrslistcontsup1 = new TSO_TableSorter("rslistcontsup", "tso_listrslistcontsup1");
$tso_listrslistcontsup1->addColumn("NCONTRATO");
$tso_listrslistcontsup1->addColumn("cont_fecha_inicio");
$tso_listrslistcontsup1->addColumn("cont_fechafinal");
$tso_listrslistcontsup1->addColumn("cont_nit_contra_ta");
$tso_listrslistcontsup1->addColumn("contractor_name");
$tso_listrslistcontsup1->addColumn("periodo_name");
$tso_listrslistcontsup1->addColumn("cont_informessug");
$tso_listrslistcontsup1->setDefault("NCONTRATO");
$tso_listrslistcontsup1->Execute();

// Navigation
$nav_listrslistcontsup1 = new NAV_Regular("nav_listrslistcontsup1", "rslistcontsup", "../", $_SERVER['PHP_SELF'], 15);

//NeXTenesio3 Special List Recordset
$maxRows_rslistcontsup = $_SESSION['max_rows_nav_listrslistcontsup1'];
$pageNum_rslistcontsup = 0;
if (isset($_GET['pageNum_rslistcontsup'])) {
  $pageNum_rslistcontsup = $_GET['pageNum_rslistcontsup'];
}
$startRow_rslistcontsup = $pageNum_rslistcontsup * $maxRows_rslistcontsup;

$colname_rslistcontsup = "-1";
if (isset($_SESSION['kt_login_user'])) {
  $colname_rslistcontsup = $_SESSION['kt_login_user'];
}
$valoranio_rslistcontsup = "-1";
if (isset($_GET['anio_id'])) {
  $valoranio_rslistcontsup = $_GET['anio_id'];
}
// Defining List Recordset variable
$NXTFilter_rslistcontsup = "1=1";
if (isset($_SESSION['filter_tfi_listrslistcontsup1'])) {
  $NXTFilter_rslistcontsup = $_SESSION['filter_tfi_listrslistcontsup1'];
}
// Defining List Recordset variable
$NXTSort_rslistcontsup = "NCONTRATO";
if (isset($_SESSION['sorter_tso_listrslistcontsup1'])) {
  $NXTSort_rslistcontsup = $_SESSION['sorter_tso_listrslistcontsup1'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
mysql_query("SET NAMES 'utf8'");
$query_rslistcontsup = sprintf("SELECT * FROM q_global_supervisores WHERE Username = %s AND sup_status = 1 AND cont_ano = %s AND  {$NXTFilter_rslistcontsup}  ORDER BY  {$NXTSort_rslistcontsup} ", GetSQLValueString($colname_rslistcontsup, "text"),GetSQLValueString($valoranio_rslistcontsup, "text"));
$query_limit_rslistcontsup = sprintf("%s LIMIT %d, %d", $query_rslistcontsup, $startRow_rslistcontsup, $maxRows_rslistcontsup);
$rslistcontsup = mysql_query($query_limit_rslistcontsup, $oConnContratos) or die(mysql_error());
$row_rslistcontsup = mysql_fetch_assoc($rslistcontsup);

if (isset($_GET['totalRows_rslistcontsup'])) {
  $totalRows_rslistcontsup = $_GET['totalRows_rslistcontsup'];
} else {
  $all_rslistcontsup = mysql_query($query_rslistcontsup);
  $totalRows_rslistcontsup = mysql_num_rows($all_rslistcontsup);
}
$totalPages_rslistcontsup = ceil($totalRows_rslistcontsup/$maxRows_rslistcontsup)-1;
//End NeXTenesio3 Special List Recordset

$nav_listrslistcontsup1->checkBoundries();
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:: Contrataci&oacute;n :: MinCIT ::.</title>
<link rel="stylesheet" href="../_jquery/_desktop/_app/themes/cupertino/jquery.ui.all.css">
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
<link href="../_css/jqueryslidemenu.css" rel="stylesheet" type="text/css" />
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
  record_counter: true
}
</script>
<style type="text/css">
  /* Dynamic List row settings */
  .KT_col_NCONTRATO {width:70px; overflow:hidden;}
  .KT_col_cont_fecha_inicio {width:84px; overflow:hidden;}
  .KT_col_cont_fechafinal {width:84px; overflow:hidden;}
  .KT_col_cont_nit_contra_ta {width:105px; overflow:hidden;}
  .KT_col_contractor_name {width:280px; overflow:hidden;}
  .KT_col_periodo_name {width:56px; overflow:hidden;}
  .KT_col_cont_informessug {width:56px; overflow:hidden;}
</style>
</head>

<body>
<?php
  mxi_includes_start("../inc_top_2.php");
  require(basename("../inc_top_2.php"));
  mxi_includes_end();
?>
<div>
	<div>
		<button id="rerun">VIGENCIAS</button>
		<button id="select">...</button>
	</div>
	<ul>
    		<li><a href="dashboard.php?anio_id=<?php echo $ano; ?>"><?php echo $ano; ?></a></li>
             <li><a href="dashboard.php?anio_id=2016">2016</a></li>
            <li><a href="dashboard.php?anio_id=2015">2015</a></li>
            <li><a href="dashboard.php?anio_id=2014">2014</a></li>
	</ul>
</div>
<div class="KT_tng" id="listrslistcontsup1">
  <h1> Informes de supervisi&oacute;n
    <?php
  $nav_listrslistcontsup1->Prepare();
  require("../includes/nav/NAV_Text_Statistics.inc.php");
?>
  </h1>
  <div class="KT_tnglist">
    <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
      <div class="KT_options"> <a href="<?php echo $nav_listrslistcontsup1->getShowAllLink(); ?>"><?php echo NXT_getResource("Show"); ?>
            <?php 
  // Show IF Conditional region1
  if (@$_GET['show_all_nav_listrslistcontsup1'] == 1) {
?>
              <?php echo $_SESSION['default_max_rows_nav_listrslistcontsup1']; ?>
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
  if (@$_SESSION['has_filter_tfi_listrslistcontsup1'] == 1) {
?>
                  <a href="<?php echo $tfi_listrslistcontsup1->getResetFilterLink(); ?>"><?php echo NXT_getResource("Reset filter"); ?></a>
                  <?php 
  // else Conditional region2
  } else { ?>
                  <a href="<?php echo $tfi_listrslistcontsup1->getShowFilterLink(); ?>"><?php echo NXT_getResource("Show filter"); ?></a>
                  <?php } 
  // endif Conditional region2
?>
      </div>
      <table cellpadding="2" cellspacing="0" class="KT_tngtable">
        <thead>
          <tr class="KT_row_order">
            <th>&nbsp;</th>
            <th id="NCONTRATO" class="KT_sorter KT_col_NCONTRATO <?php echo $tso_listrslistcontsup1->getSortIcon('NCONTRATO'); ?>"> <a href="<?php echo $tso_listrslistcontsup1->getSortLink('NCONTRATO'); ?>">CONTRATO</a> </th>
            <th id="cont_fecha_inicio" class="KT_sorter KT_col_cont_fecha_inicio <?php echo $tso_listrslistcontsup1->getSortIcon('cont_fecha_inicio'); ?>"> <a href="<?php echo $tso_listrslistcontsup1->getSortLink('cont_fecha_inicio'); ?>">FECHA INICIO DEL CONTRATO</a> </th>
            <th id="cont_fechafinal" class="KT_sorter KT_col_cont_fechafinal <?php echo $tso_listrslistcontsup1->getSortIcon('cont_fechafinal'); ?>"> <a href="<?php echo $tso_listrslistcontsup1->getSortLink('cont_fechafinal'); ?>">FECHA FINAL DEL CONTRATO</a> </th>
            <th id="cont_nit_contra_ta" class="KT_sorter KT_col_cont_nit_contra_ta <?php echo $tso_listrslistcontsup1->getSortIcon('cont_nit_contra_ta'); ?>"> <a href="<?php echo $tso_listrslistcontsup1->getSortLink('cont_nit_contra_ta'); ?>">DOCUMENTO / NIT</a> </th>
            <th id="contractor_name" class="KT_sorter KT_col_contractor_name <?php echo $tso_listrslistcontsup1->getSortIcon('contractor_name'); ?>"> <a href="<?php echo $tso_listrslistcontsup1->getSortLink('contractor_name'); ?>">NOMBRES / RAZON SOCIAL</a> </th>
            <th id="periodo_name" class="KT_sorter KT_col_periodo_name <?php echo $tso_listrslistcontsup1->getSortIcon('periodo_name'); ?>"> <a href="<?php echo $tso_listrslistcontsup1->getSortLink('periodo_name'); ?>">PERIODICIDAD</a> </th>
            <th id="cont_informessug" class="KT_sorter KT_col_cont_informessug <?php echo $tso_listrslistcontsup1->getSortIcon('cont_informessug'); ?>"> <a href="<?php echo $tso_listrslistcontsup1->getSortLink('cont_informessug'); ?>">No. INFORMES SUGERIDOS</a> </th>
            <th>&nbsp;</th>
          </tr>
          <?php 
  // Show IF Conditional region3
  if (@$_SESSION['has_filter_tfi_listrslistcontsup1'] == 1) {
?>
            <tr class="KT_row_filter">
              <td>&nbsp;</td>
              <td><input type="text" name="tfi_listrslistcontsup1_NCONTRATO" id="tfi_listrslistcontsup1_NCONTRATO" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrslistcontsup1_NCONTRATO']); ?>" size="10" maxlength="20" /></td>
              <td><input type="text" name="tfi_listrslistcontsup1_cont_fecha_inicio" id="tfi_listrslistcontsup1_cont_fecha_inicio" value="<?php echo @$_SESSION['tfi_listrslistcontsup1_cont_fecha_inicio']; ?>" size="10" maxlength="22" /></td>
              <td><input type="text" name="tfi_listrslistcontsup1_cont_fechafinal" id="tfi_listrslistcontsup1_cont_fechafinal" value="<?php echo @$_SESSION['tfi_listrslistcontsup1_cont_fechafinal']; ?>" size="10" maxlength="22" /></td>
              <td><input type="text" name="tfi_listrslistcontsup1_cont_nit_contra_ta" id="tfi_listrslistcontsup1_cont_nit_contra_ta" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrslistcontsup1_cont_nit_contra_ta']); ?>" size="15" maxlength="15" /></td>
              <td><input type="text" name="tfi_listrslistcontsup1_contractor_name" id="tfi_listrslistcontsup1_contractor_name" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrslistcontsup1_contractor_name']); ?>" size="40" maxlength="20" /></td>
              <td><input type="text" name="tfi_listrslistcontsup1_periodo_name" id="tfi_listrslistcontsup1_periodo_name" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrslistcontsup1_periodo_name']); ?>" size="8" maxlength="20" /></td>
              <td><input type="text" name="tfi_listrslistcontsup1_cont_informessug" id="tfi_listrslistcontsup1_cont_informessug" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrslistcontsup1_cont_informessug']); ?>" size="8" maxlength="100" /></td>
              <td><input type="submit" name="tfi_listrslistcontsup1" value="<?php echo NXT_getResource("Filter"); ?>" /></td>
            </tr>
            <?php } 
  // endif Conditional region3
?>
        </thead>
        <tbody>
          <?php if ($totalRows_rslistcontsup == 0) { // Show if recordset empty ?>
            <tr>
              <td colspan="9"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
            </tr>
            <?php } // Show if recordset empty ?>
          <?php if ($totalRows_rslistcontsup > 0) { // Show if recordset not empty ?>
            <?php do { ?>
              <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
                <td><a href="cont_adm.php?hash=<?php echo $row_rslistcontsup['cont_nit_contra_ta']; ?>&amp;cod_ver=<?php echo $row_rslistcontsup['cont_hash_fk']; ?>&amp;doc_id=<?php echo $row_rslistcontsup['id_cont_fk']; ?>&amp;cont_id=<?php echo $row_rslistcontsup['id_cont_fk']; ?>&amp;anio_id=<?php echo $row_rslistcontsup['cont_ano']; ?>"><img src="icons/321_tab.png" width="48" height="48" border="0" /></a>
                  <input type="hidden" name="interventor_id" class="id_field" value="<?php echo $row_rslistcontsup['interventor_id']; ?>" />
                </td><td><div class="KT_col_NCONTRATO"><?php echo KT_FormatForList($row_rslistcontsup['NCONTRATO'], 10); ?></div></td>
                <td><div class="KT_col_cont_fecha_inicio"><?php echo KT_formatDate($row_rslistcontsup['cont_fecha_inicio']); ?></div></td>
                <td><div class="KT_col_cont_fechafinal"><?php echo KT_formatDate($row_rslistcontsup['cont_fechafinal']); ?></div></td>
                <td><div class="KT_col_cont_nit_contra_ta"><?php echo KT_FormatForList($row_rslistcontsup['cont_nit_contra_ta'], 15); ?></div></td>
                <td><div class="KT_col_contractor_name"><?php echo $row_rslistcontsup['contractor_name']; ?></div></td>
                <td><div class="KT_col_periodo_name"><?php echo $row_rslistcontsup['periodo_name']; ?></div></td>
                <td><div class="KT_col_cont_informessug"><?php echo KT_FormatForList($row_rslistcontsup['cont_informessug'], 8); ?></div></td>
                <td>&nbsp;</td>
              </tr>
              <?php } while ($row_rslistcontsup = mysql_fetch_assoc($rslistcontsup)); ?>
            <?php } // Show if recordset not empty ?>
        </tbody>
      </table>
      <div class="KT_bottomnav">
        <div>
          <?php
            $nav_listrslistcontsup1->Prepare();
            require("../includes/nav/NAV_Text_Navigation.inc.php");
          ?>
        </div>
      </div>
      <div class="KT_bottombuttons">
        <div class="KT_operations"></div>
        <span>&nbsp;</span></div>
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
mysql_free_result($rslistcontsup);
?>
