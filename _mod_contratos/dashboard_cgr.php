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
$tfi_listrsinfoglobaldash1 = new TFI_TableFilter($conn_oConnContratos, "tfi_listrsinfoglobaldash1");
$tfi_listrsinfoglobaldash1->addColumn("cont_estado", "NUMERIC_TYPE", "cont_estado", "=");
$tfi_listrsinfoglobaldash1->addColumn("CONTRATOID", "STRING_TYPE", "CONTRATOID", "%");
$tfi_listrsinfoglobaldash1->addColumn("VIGENCIA", "DATE_TYPE", "VIGENCIA", "=");
$tfi_listrsinfoglobaldash1->addColumn("CDP", "STRING_TYPE", "CDP", "%");
$tfi_listrsinfoglobaldash1->addColumn("RP", "STRING_TYPE", "RP", "%");
$tfi_listrsinfoglobaldash1->addColumn("contractor_type", "STRING_TYPE", "contractor_type", "%");
$tfi_listrsinfoglobaldash1->addColumn("DOCID", "STRING_TYPE", "DOCID", "%");
$tfi_listrsinfoglobaldash1->addColumn("contractor_nombresfull", "STRING_TYPE", "contractor_nombresfull", "%");
$tfi_listrsinfoglobaldash1->addColumn("fase_nombre", "STRING_TYPE", "fase_nombre", "%");
$tfi_listrsinfoglobaldash1->addColumn("FECHAI", "DATE_TYPE", "FECHAI", "=");
$tfi_listrsinfoglobaldash1->addColumn("FECHAF", "DATE_TYPE", "FECHAF", "=");
$tfi_listrsinfoglobaldash1->addColumn("VALORI", "NUMERIC_TYPE", "VALORI", "=");
$tfi_listrsinfoglobaldash1->Execute();

// Sorter
$tso_listrsinfoglobaldash1 = new TSO_TableSorter("rsinfoglobaldash", "tso_listrsinfoglobaldash1");
$tso_listrsinfoglobaldash1->addColumn("cont_estado");
$tso_listrsinfoglobaldash1->addColumn("CONTRATOID");
$tso_listrsinfoglobaldash1->addColumn("VIGENCIA");
$tso_listrsinfoglobaldash1->addColumn("CDP");
$tso_listrsinfoglobaldash1->addColumn("RP");
$tso_listrsinfoglobaldash1->addColumn("contractor_type");
$tso_listrsinfoglobaldash1->addColumn("DOCID");
$tso_listrsinfoglobaldash1->addColumn("contractor_nombresfull");
$tso_listrsinfoglobaldash1->addColumn("fase_nombre");
$tso_listrsinfoglobaldash1->addColumn("FECHAI");
$tso_listrsinfoglobaldash1->addColumn("FECHAF");
$tso_listrsinfoglobaldash1->addColumn("VALORI");
$tso_listrsinfoglobaldash1->setDefault("CONTRATOID DESC");
$tso_listrsinfoglobaldash1->Execute();

// Navigation
$nav_listrsinfoglobaldash1 = new NAV_Regular("nav_listrsinfoglobaldash1", "rsinfoglobaldash", "../", $_SERVER['PHP_SELF'], 25);

//NeXTenesio3 Special List Recordset
$maxRows_rsinfoglobaldash = $_SESSION['max_rows_nav_listrsinfoglobaldash1'];
$pageNum_rsinfoglobaldash = 0;
if (isset($_GET['pageNum_rsinfoglobaldash'])) {
  $pageNum_rsinfoglobaldash = $_GET['pageNum_rsinfoglobaldash'];
}
$startRow_rsinfoglobaldash = $pageNum_rsinfoglobaldash * $maxRows_rsinfoglobaldash;

$colperiodo_rsinfoglobaldash = "-1";
if (isset($_GET['anio_id'])) {
  $colperiodo_rsinfoglobaldash = $_GET['anio_id'];
}
// Defining List Recordset variable
$NXTFilter_rsinfoglobaldash = "1=1";
if (isset($_SESSION['filter_tfi_listrsinfoglobaldash1'])) {
  $NXTFilter_rsinfoglobaldash = $_SESSION['filter_tfi_listrsinfoglobaldash1'];
}
// Defining List Recordset variable
$NXTSort_rsinfoglobaldash = "CONTRATOID DESC";
if (isset($_SESSION['sorter_tso_listrsinfoglobaldash1'])) {
  $NXTSort_rsinfoglobaldash = $_SESSION['sorter_tso_listrsinfoglobaldash1'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);

$query_rsinfoglobaldash = sprintf("SELECT * FROM q_001_dashboard WHERE VIGENCIA = %s AND  {$NXTFilter_rsinfoglobaldash} ORDER BY {$NXTSort_rsinfoglobaldash} ", GetSQLValueString($colperiodo_rsinfoglobaldash, "text"));
$query_limit_rsinfoglobaldash = sprintf("%s LIMIT %d, %d", $query_rsinfoglobaldash, $startRow_rsinfoglobaldash, $maxRows_rsinfoglobaldash);
$rsinfoglobaldash = mysql_query($query_limit_rsinfoglobaldash, $oConnContratos) or die(mysql_error());
$row_rsinfoglobaldash = mysql_fetch_assoc($rsinfoglobaldash);

if (isset($_GET['totalRows_rsinfoglobaldash'])) {
  $totalRows_rsinfoglobaldash = $_GET['totalRows_rsinfoglobaldash'];
} else {
  $all_rsinfoglobaldash = mysql_query($query_rsinfoglobaldash);
  $totalRows_rsinfoglobaldash = mysql_num_rows($all_rsinfoglobaldash);
}
$totalPages_rsinfoglobaldash = ceil($totalRows_rsinfoglobaldash/$maxRows_rsinfoglobaldash)-1;
//End NeXTenesio3 Special List Recordset

mysql_select_db($database_oConnContratos, $oConnContratos);
$query_Recordset1 = "SELECT contractor_type, contractor_type FROM contractor_type ORDER BY contractor_type";
$Recordset1 = mysql_query($query_Recordset1, $oConnContratos) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$nav_listrsinfoglobaldash1->checkBoundries();
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:: Contrataci&oacute;n :: MinCIT ::.</title>
<!-- AQUI COMIENZA LA BOTONERA -->

	<link rel="stylesheet" href="../_jquery/_desktop/_app/themes/south-street/jquery.ui.all.css">
	<script src="../_jquery/_desktop/_app/jquery-1.9.1.js"></script>
	<script src="../_jquery/_desktop/_app/ui/jquery.ui.core.js"></script>
	<script src="../_jquery/_desktop/_app/ui/jquery.ui.widget.js"></script>
	<script src="../_jquery/_desktop/_app/ui/jquery.ui.button.js"></script>
	<script src="../_jquery/_desktop/_app/ui/jquery.ui.position.js"></script>
	<script src="../_jquery/_desktop/_app/ui/jquery.ui.menu.js"></script>
	<link rel="stylesheet" href="../demos.css">
	<style>
		.ui-menu { position: absolute; width: 100px; }
	</style>
	<script>
	$(function() {
		$( "#rerun" )
			.button()
			.click(function() {
				alert( "Seleccionar periodo" );
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
   	<link rel="stylesheet" href="../_jquery/_desktop/_app/_modules/demos.css">
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
  .KT_col_cont_estado {width:140px; overflow:hidden;}
  .KT_col_CONTRATOID {width:140px; overflow:hidden;}
  .KT_col_VIGENCIA {width:140px; overflow:hidden;}
  .KT_col_CDP {width:140px; overflow:hidden;}
  .KT_col_RP {width:140px; overflow:hidden;}
  .KT_col_contractor_type {width:140px; overflow:hidden;}
  .KT_col_DOCID {width:140px; overflow:hidden;}
  .KT_col_contractor_nombresfull {width:140px; overflow:hidden;}
  .KT_col_fase_nombre {width:140px; overflow:hidden;}
  .KT_col_FECHAI {width:140px; overflow:hidden;}
  .KT_col_FECHAF {width:140px; overflow:hidden;}
  .KT_col_VALORI {width:140px; overflow:hidden;}
    </style>
</head>

<body>
<?php
  mxi_includes_start("../inc_top_2.php");
  require(basename("../inc_top_2.php"));
  mxi_includes_end();
?>

<div class="KT_tng" id="listrsinfoglobaldash1">
  <h1> Lista general de contratos - Vigencia <?php echo $_GET['anio_id']; ?>
    <?php
  $nav_listrsinfoglobaldash1->Prepare();
  require("../includes/nav/NAV_Text_Statistics.inc.php");
?>
  </h1>
  <div class="KT_tnglist">
    <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
      <div class="KT_options"> <a href="<?php echo $nav_listrsinfoglobaldash1->getShowAllLink(); ?>"><?php echo NXT_getResource("Show"); ?>
        <?php 
  // Show IF Conditional region1
  if (@$_GET['show_all_nav_listrsinfoglobaldash1'] == 1) {
?>
          <?php echo $_SESSION['default_max_rows_nav_listrsinfoglobaldash1']; ?>
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
  if (@$_SESSION['has_filter_tfi_listrsinfoglobaldash1'] == 1) {
?>
                  <a href="<?php echo $tfi_listrsinfoglobaldash1->getResetFilterLink(); ?>"><?php echo NXT_getResource("Reset filter"); ?></a>
                  <?php 
  // else Conditional region2
  } else { ?>
                  <a href="<?php echo $tfi_listrsinfoglobaldash1->getShowFilterLink(); ?>"><?php echo NXT_getResource("Show filter"); ?></a>
                  <?php } 
  // endif Conditional region2
?>
      </div>
      <table cellpadding="2" cellspacing="0" class="KT_tngtable">
        <thead>
          <tr class="KT_row_order">
            <th>&nbsp;</th>
            <th id="cont_estado" class="KT_sorter KT_col_cont_estado <?php echo $tso_listrsinfoglobaldash1->getSortIcon('cont_estado'); ?>"> <a href="<?php echo $tso_listrsinfoglobaldash1->getSortLink('cont_estado'); ?>">ESTADO</a> </th>
            <th id="CONTRATOID" class="KT_sorter KT_col_CONTRATOID <?php echo $tso_listrsinfoglobaldash1->getSortIcon('CONTRATOID'); ?>"> <a href="<?php echo $tso_listrsinfoglobaldash1->getSortLink('CONTRATOID'); ?>">CONTRATO</a> </th>
            <th id="VIGENCIA" class="KT_sorter KT_col_VIGENCIA <?php echo $tso_listrsinfoglobaldash1->getSortIcon('VIGENCIA'); ?>"> <a href="<?php echo $tso_listrsinfoglobaldash1->getSortLink('VIGENCIA'); ?>">VIGENCIA</a> </th>
            <th id="CDP" class="KT_sorter KT_col_CDP <?php echo $tso_listrsinfoglobaldash1->getSortIcon('CDP'); ?>"> <a href="<?php echo $tso_listrsinfoglobaldash1->getSortLink('CDP'); ?>">CDP</a> </th>
            <th id="RP" class="KT_sorter KT_col_RP <?php echo $tso_listrsinfoglobaldash1->getSortIcon('RP'); ?>"> <a href="<?php echo $tso_listrsinfoglobaldash1->getSortLink('RP'); ?>">REGISTRO<br />PRESUPUESTAL</a> </th>
            <th id="contractor_type" class="KT_sorter KT_col_contractor_type <?php echo $tso_listrsinfoglobaldash1->getSortIcon('contractor_type'); ?>"> <a href="<?php echo $tso_listrsinfoglobaldash1->getSortLink('contractor_type'); ?>">CLASE DE DOCUMENTO</a> </th>
            <th id="DOCID" class="KT_sorter KT_col_DOCID <?php echo $tso_listrsinfoglobaldash1->getSortIcon('DOCID'); ?>"> <a href="<?php echo $tso_listrsinfoglobaldash1->getSortLink('DOCID'); ?>">DOCUMENTO</a> </th>
            <th id="contractor_nombresfull" class="KT_sorter KT_col_contractor_nombresfull <?php echo $tso_listrsinfoglobaldash1->getSortIcon('contractor_nombresfull'); ?>"> <a href="<?php echo $tso_listrsinfoglobaldash1->getSortLink('contractor_nombresfull'); ?>">NOMBRE(S) / RAZON SOCIAL</a> </th>
            <th id="fase_nombre" class="KT_sorter KT_col_fase_nombre <?php echo $tso_listrsinfoglobaldash1->getSortIcon('fase_nombre'); ?>"> <a href="<?php echo $tso_listrsinfoglobaldash1->getSortLink('fase_nombre'); ?>">FASE</a> </th>
            <th id="FECHAI" class="KT_sorter KT_col_FECHAI <?php echo $tso_listrsinfoglobaldash1->getSortIcon('FECHAI'); ?>"> <a href="<?php echo $tso_listrsinfoglobaldash1->getSortLink('FECHAI'); ?>">FECHA INICIO</a> </th>
            <th id="FECHAF" class="KT_sorter KT_col_FECHAF <?php echo $tso_listrsinfoglobaldash1->getSortIcon('FECHAF'); ?>"> <a href="<?php echo $tso_listrsinfoglobaldash1->getSortLink('FECHAF'); ?>">FECHA FINAL</a> </th>
            <th id="VALORI" class="KT_sorter KT_col_VALORI <?php echo $tso_listrsinfoglobaldash1->getSortIcon('VALORI'); ?>"> <a href="<?php echo $tso_listrsinfoglobaldash1->getSortLink('VALORI'); ?>">VALOR DEL CONTRATO</a> </th>
            <th>&nbsp;</th>
          </tr>
          <?php 
  // Show IF Conditional region3
  if (@$_SESSION['has_filter_tfi_listrsinfoglobaldash1'] == 1) {
?>
            <tr class="KT_row_filter">
              <td>&nbsp;</td>
              <td><input type="text" name="tfi_listrsinfoglobaldash1_cont_estado" id="tfi_listrsinfoglobaldash1_cont_estado" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrsinfoglobaldash1_cont_estado']); ?>" size="20" maxlength="100" /></td>
              <td><input type="text" name="tfi_listrsinfoglobaldash1_CONTRATOID" id="tfi_listrsinfoglobaldash1_CONTRATOID" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrsinfoglobaldash1_CONTRATOID']); ?>" size="20" maxlength="20" /></td>
              <td><input type="text" name="tfi_listrsinfoglobaldash1_VIGENCIA" id="tfi_listrsinfoglobaldash1_VIGENCIA" value="<?php echo @$_SESSION['tfi_listrsinfoglobaldash1_VIGENCIA']; ?>" size="10" maxlength="22" /></td>
              <td><input type="text" name="tfi_listrsinfoglobaldash1_CDP" id="tfi_listrsinfoglobaldash1_CDP" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrsinfoglobaldash1_CDP']); ?>" size="20" maxlength="20" /></td>
              <td><input type="text" name="tfi_listrsinfoglobaldash1_RP" id="tfi_listrsinfoglobaldash1_RP" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrsinfoglobaldash1_RP']); ?>" size="20" maxlength="20" /></td>
              <td><select name="tfi_listrsinfoglobaldash1_contractor_type" id="tfi_listrsinfoglobaldash1_contractor_type">
                  <option value="" <?php if (!(strcmp("", @$_SESSION['tfi_listrsinfoglobaldash1_contractor_type']))) {echo "SELECTED";} ?>><?php echo NXT_getResource("None"); ?></option>
                  <?php
do {  
?>
                  <option value="<?php echo $row_Recordset1['contractor_type']?>"<?php if (!(strcmp($row_Recordset1['contractor_type'], @$_SESSION['tfi_listrsinfoglobaldash1_contractor_type']))) {echo "SELECTED";} ?>><?php echo $row_Recordset1['contractor_type']?></option>
                  <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
                </select>
              </td>
              <td><input type="text" name="tfi_listrsinfoglobaldash1_DOCID" id="tfi_listrsinfoglobaldash1_DOCID" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrsinfoglobaldash1_DOCID']); ?>" size="20" maxlength="20" /></td>
              <td><input type="text" name="tfi_listrsinfoglobaldash1_contractor_nombresfull" id="tfi_listrsinfoglobaldash1_contractor_nombresfull" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrsinfoglobaldash1_contractor_nombresfull']); ?>" size="20" maxlength="20" /></td>
              <td><input type="text" name="tfi_listrsinfoglobaldash1_fase_nombre" id="tfi_listrsinfoglobaldash1_fase_nombre" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrsinfoglobaldash1_fase_nombre']); ?>" size="20" maxlength="20" /></td>
              <td><input type="text" name="tfi_listrsinfoglobaldash1_FECHAI" id="tfi_listrsinfoglobaldash1_FECHAI" value="<?php echo @$_SESSION['tfi_listrsinfoglobaldash1_FECHAI']; ?>" size="10" maxlength="22" /></td>
              <td><input type="text" name="tfi_listrsinfoglobaldash1_FECHAF" id="tfi_listrsinfoglobaldash1_FECHAF" value="<?php echo @$_SESSION['tfi_listrsinfoglobaldash1_FECHAF']; ?>" size="10" maxlength="22" /></td>
              <td><input type="text" name="tfi_listrsinfoglobaldash1_VALORI" id="tfi_listrsinfoglobaldash1_VALORI" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrsinfoglobaldash1_VALORI']); ?>" size="20" maxlength="100" /></td>
              <td><input type="submit" name="tfi_listrsinfoglobaldash1" value="<?php echo NXT_getResource("Filter"); ?>" /></td>
            </tr>
            <?php } 
  // endif Conditional region3
?>
        </thead>
        <tbody>
          <?php if ($totalRows_rsinfoglobaldash == 0) { // Show if recordset empty ?>
            <tr>
              <td colspan="14"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
            </tr>
            <?php } // Show if recordset empty ?>
          <?php if ($totalRows_rsinfoglobaldash > 0) { // Show if recordset not empty ?>
            <?php do { ?>
              <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
                <td><a href="cont_adm_cgr.php?hash=<?php echo md5($row_rsinfocontratos['cont_nit_contra_ta']); ?>&amp;cod_ver=<?php echo md5($row_rsinfoglobaldash['cont_hash']); ?>&amp;doc_id=<?php echo $row_rsinfoglobaldash['id_cont']; ?>&amp;cont_id=<?php echo $row_rsinfoglobaldash['cont_hash']; ?>&amp;anio_id=<?php echo $row_rsinfoglobaldash['VIGENCIA']; ?>&amp;cdp_id=<?php echo $row_rsinfoglobaldash['CDP']; ?>&amp;rp_id=<?php echo $row_rsinfoglobaldash['RP']; ?>&amp;rubro_id=<?php echo $row_rsinfoglobaldash['cont_codrubro']; ?>&amp;cc_id=<?php echo $row_rsinfoglobaldash['DOCID']; ?>" title="Administrar contrato"><img src="icons/321_tab.png" width="32" height="32" border="0" /></a>
                  <input type="hidden" name="id_cont" class="id_field" value="<?php echo $row_rsinfoglobaldash['id_cont']; ?>" />
                </td><td align="center"><div class="KT_col_cont_estado" title="<?php echo $row_rsinfoglobaldash['estado_nombre']; ?>"><img src="<?php echo $row_rsinfoglobaldash['estado_img']; ?>" /></div></td>
                <td><div class="KT_col_CONTRATOID"><?php echo KT_FormatForList($row_rsinfoglobaldash['CONTRATOID'], 20); ?></div></td>
                <td><div class="KT_col_VIGENCIA"><?php echo KT_formatDate($row_rsinfoglobaldash['VIGENCIA']); ?></div></td>
                <td><div class="KT_col_CDP"><?php echo KT_FormatForList($row_rsinfoglobaldash['CDP'], 20); ?></div></td>
                <td><div class="KT_col_RP"><?php echo KT_FormatForList($row_rsinfoglobaldash['RP'], 20); ?></div></td>
                <td><div class="KT_col_contractor_type"><?php echo KT_FormatForList($row_rsinfoglobaldash['contractor_type'], 20); ?></div></td>
                <td><div class="KT_col_DOCID"><?php echo KT_FormatForList($row_rsinfoglobaldash['DOCID'], 20); ?></div></td>
                <td><div class="KT_col_contractor_nombresfull"><?php echo $row_rsinfoglobaldash['contractor_name']; ?></div></td>
                <td><div class="KT_col_fase_nombre"><?php echo KT_FormatForList($row_rsinfoglobaldash['fase_nombre'], 20); ?></div></td>
                <td><div class="KT_col_FECHAI"><?php echo KT_formatDate($row_rsinfoglobaldash['FECHAI']); ?></div></td>
                <td><div class="KT_col_FECHAF"><?php echo KT_formatDate($row_rsinfoglobaldash['FECHAF']); ?></div></td>
                <td><div class="KT_col_VALORI" align="right"><?php echo number_format($row_rsinfoglobaldash['VALORI'],2,',','.'); ?></div></td>
                <td>&nbsp;</td>
              </tr>
              <?php } while ($row_rsinfoglobaldash = mysql_fetch_assoc($rsinfoglobaldash)); ?>
            <?php } // Show if recordset not empty ?>
        </tbody>
      </table>
      <div class="KT_bottomnav">
        <div>
          <?php
            $nav_listrsinfoglobaldash1->Prepare();
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
<?php
  mxi_includes_start("../inc_foot.php");
  require(basename("../inc_foot.php"));
  mxi_includes_end();
?>
</body>
</html>
<?php
mysql_free_result($rsinfoglobaldash);

mysql_free_result($Recordset1);
?>
