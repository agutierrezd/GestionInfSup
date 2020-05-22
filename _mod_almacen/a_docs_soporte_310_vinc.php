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
$tfi_listrsresultado1 = new TFI_TableFilter($conn_oConnAlmacen, "tfi_listrsresultado1");
$tfi_listrsresultado1->addColumn("mcdalmacen", "STRING_TYPE", "mcdalmacen", "%");
$tfi_listrsresultado1->addColumn("mcdcuenta", "STRING_TYPE", "mcdcuenta", "%");
$tfi_listrsresultado1->addColumn("ca_nomcuenta", "STRING_TYPE", "ca_nomcuenta", "%");
$tfi_listrsresultado1->addColumn("mcdcodelem", "NUMERIC_TYPE", "mcdcodelem", "=");
$tfi_listrsresultado1->addColumn("ec_nomelemento", "STRING_TYPE", "ec_nomelemento", "%");
$tfi_listrsresultado1->addColumn("qty", "NUMERIC_TYPE", "qty", "=");
$tfi_listrsresultado1->addColumn("saldoactual", "NUMERIC_TYPE", "saldoactual", "=");
$tfi_listrsresultado1->Execute();

// Sorter
$tso_listrsresultado1 = new TSO_TableSorter("rsresultado", "tso_listrsresultado1");
$tso_listrsresultado1->addColumn("mcdalmacen");
$tso_listrsresultado1->addColumn("mcdcuenta");
$tso_listrsresultado1->addColumn("ca_nomcuenta");
$tso_listrsresultado1->addColumn("mcdcodelem");
$tso_listrsresultado1->addColumn("ec_nomelemento");
$tso_listrsresultado1->addColumn("qty");
$tso_listrsresultado1->addColumn("saldoactual");
$tso_listrsresultado1->setDefault("mcdalmacen");
$tso_listrsresultado1->Execute();

// Navigation
$nav_listrsresultado1 = new NAV_Regular("nav_listrsresultado1", "rsresultado", "../", $_SERVER['PHP_SELF'], 25);

//NeXTenesio3 Special List Recordset
$maxRows_rsresultado = $_SESSION['max_rows_nav_listrsresultado1'];
$pageNum_rsresultado = 0;
if (isset($_GET['pageNum_rsresultado'])) {
  $pageNum_rsresultado = $_GET['pageNum_rsresultado'];
}
$startRow_rsresultado = $pageNum_rsresultado * $maxRows_rsresultado;

$colname_rsresultado = "-1";
if (isset($_GET['qfind'])) {
  $colname_rsresultado = $_GET['qfind'];
}
// Defining List Recordset variable
$NXTFilter_rsresultado = "1=1";
if (isset($_SESSION['filter_tfi_listrsresultado1'])) {
  $NXTFilter_rsresultado = $_SESSION['filter_tfi_listrsresultado1'];
}
// Defining List Recordset variable
$NXTSort_rsresultado = "mcdalmacen";
if (isset($_SESSION['sorter_tso_listrsresultado1'])) {
  $NXTSort_rsresultado = $_SESSION['sorter_tso_listrsresultado1'];
}
mysql_select_db($database_oConnAlmacen, $oConnAlmacen);

$query_rsresultado = sprintf("SELECT * FROM q_almovconsdia_egreso_saldo WHERE buscar LIKE %s AND  {$NXTFilter_rsresultado} ORDER BY {$NXTSort_rsresultado} ", GetSQLValueString("%" . $colname_rsresultado . "%", "text"));
$query_limit_rsresultado = sprintf("%s LIMIT %d, %d", $query_rsresultado, $startRow_rsresultado, $maxRows_rsresultado);
$rsresultado = mysql_query($query_limit_rsresultado, $oConnAlmacen) or die(mysql_error());
$row_rsresultado = mysql_fetch_assoc($rsresultado);

if (isset($_GET['totalRows_rsresultado'])) {
  $totalRows_rsresultado = $_GET['totalRows_rsresultado'];
} else {
  $all_rsresultado = mysql_query($query_rsresultado);
  $totalRows_rsresultado = mysql_num_rows($all_rsresultado);
}
$totalPages_rsresultado = ceil($totalRows_rsresultado/$maxRows_rsresultado)-1;
//End NeXTenesio3 Special List Recordset

$nav_listrsresultado1->checkBoundries();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:: Gestión ::.</title>
<link rel="stylesheet" href="../_jquery/_desktop/_app/themes/south-street/jquery.ui.all.css">
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
<script type="text/javascript" src="../_jquery/hs/highslide/highslide-with-html.js"></script>
<link rel="stylesheet" type="text/css" href="../_jquery/hs/highslide/highslide.css" />
<script type="text/javascript">
hs.graphicsDir = '../_jquery/hs/highslide/graphics/';
hs.outlineType = 'rounded-white';
hs.wrapperClassName = 'draggable-header';
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
  .KT_col_mcdalmacen {width:140px; overflow:hidden;}
  .KT_col_mcdcuenta {width:140px; overflow:hidden;}
  .KT_col_ca_nomcuenta {width:140px; overflow:hidden;}
  .KT_col_mcdcodelem {width:140px; overflow:hidden;}
  .KT_col_ec_nomelemento {width:140px; overflow:hidden;}
  .KT_col_qty {width:140px; overflow:hidden;}
  .KT_col_saldoactual {width:140px; overflow:hidden;}
</style>
</head>

<body>
<?php
  mxi_includes_start("../inc_top.php");
  require(basename("../inc_top.php"));
  mxi_includes_end();
?>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="80%" border="0" align="center" cellpadding="0" cellspacing="3">
      <tr>
        <td><form id="form2" name="form2" method="get" action="a_docs_soporte_310_vinc.php?as_id=<?php echo $_GET['as_id']; ?>&amp;doclasedoc_id=<?php echo $row_rsinfogendocumentos['doclasedoc_id']; ?>&amp;anio_id=<?php echo $_GET['anio_id']; ?>&amp;hash_id=<?php echo $_GET['hash_id']; ?>&amp;lnk=<?php echo $_GET['lnk']; ?>&amp;numdocumento=<?php echo $_GET['numdocumento']; ?>">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td>Nombre o c&oacute;digo del elemento</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><input name="qfind" type="text" id="qfind" value="<?php echo $_GET['qfind']; ?>" size="40" />
                    <input name="as_id" type="hidden" id="as_id" value="<?php echo $_GET['as_id']; ?>" />
                    <input name="doclasedoc_id" type="hidden" id="doclasedoc_id" value="<?php echo $_GET['doclasedoc_id']; ?>" />
                    <input name="anio_id" type="hidden" id="anio_id" value="<?php echo $_GET['anio_id']; ?>" />
                    <input name="hash_id" type="hidden" id="hash_id" value="<?php echo $_GET['hash_id']; ?>" />
                    <input name="lnk" type="hidden" id="lnk" value="<?php echo $_GET['lnk']; ?>" />
                    <input name="numdocumento" type="hidden" id="numdocumento" value="<?php echo $_GET['numdocumento']; ?>" /></td>
                <td width="50%"><input type="submit" name="button" id="button" value="Encontrar" /></td>
              </tr>
            </table>
        </form></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<p>&nbsp;
<div class="KT_tng" id="listrsresultado1">
  <h1> Resultado de la b&uacute;squeda
    <?php
  $nav_listrsresultado1->Prepare();
  require("../includes/nav/NAV_Text_Statistics.inc.php");
?>
  </h1>
  <div class="KT_tnglist">
    <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
      <div class="KT_options"> <a href="<?php echo $nav_listrsresultado1->getShowAllLink(); ?>"><?php echo NXT_getResource("Show"); ?>
        <?php 
  // Show IF Conditional region1
  if (@$_GET['show_all_nav_listrsresultado1'] == 1) {
?>
          <?php echo $_SESSION['default_max_rows_nav_listrsresultado1']; ?>
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
            <th>&nbsp;</th>
            <th id="mcdalmacen" class="KT_sorter KT_col_mcdalmacen <?php echo $tso_listrsresultado1->getSortIcon('mcdalmacen'); ?>"> <a href="<?php echo $tso_listrsresultado1->getSortLink('mcdalmacen'); ?>">ALMACEN</a> </th>
            <th id="mcdcuenta" class="KT_sorter KT_col_mcdcuenta <?php echo $tso_listrsresultado1->getSortIcon('mcdcuenta'); ?>"> <a href="<?php echo $tso_listrsresultado1->getSortLink('mcdcuenta'); ?>">CUENTA</a> </th>
            <th id="ca_nomcuenta" class="KT_sorter KT_col_ca_nomcuenta <?php echo $tso_listrsresultado1->getSortIcon('ca_nomcuenta'); ?>"> <a href="<?php echo $tso_listrsresultado1->getSortLink('ca_nomcuenta'); ?>">NOMBRE CUENTA</a> </th>
            <th id="mcdcodelem" class="KT_sorter KT_col_mcdcodelem <?php echo $tso_listrsresultado1->getSortIcon('mcdcodelem'); ?>"> <a href="<?php echo $tso_listrsresultado1->getSortLink('mcdcodelem'); ?>">ELEMENTO</a> </th>
            <th id="ec_nomelemento" class="KT_sorter KT_col_ec_nomelemento <?php echo $tso_listrsresultado1->getSortIcon('ec_nomelemento'); ?>"> <a href="<?php echo $tso_listrsresultado1->getSortLink('ec_nomelemento'); ?>">NOMBRE ELEMENTO</a> </th>
            <th id="qty" class="KT_sorter KT_col_qty <?php echo $tso_listrsresultado1->getSortIcon('qty'); ?>"> <a href="<?php echo $tso_listrsresultado1->getSortLink('qty'); ?>">REGISTROS</a> </th>
            <th id="saldoactual" class="KT_sorter KT_col_saldoactual <?php echo $tso_listrsresultado1->getSortIcon('saldoactual'); ?>"> <a href="<?php echo $tso_listrsresultado1->getSortLink('saldoactual'); ?>">SALDO ACTUAL</a> </th>
            <th>&nbsp;</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($totalRows_rsresultado == 0) { // Show if recordset empty ?>
            <tr>
              <td colspan="9"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
            </tr>
            <?php } // Show if recordset empty ?>
          <?php if ($totalRows_rsresultado > 0) { // Show if recordset not empty ?>
            <?php do { ?>
              <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
                <td><input type="hidden" name="mcdcuenta" class="id_field" value="<?php echo $row_rsresultado['mcdcuenta']; ?>" />
                </td>
                <td><div class="KT_col_mcdalmacen"><?php echo KT_FormatForList($row_rsresultado['mcdalmacen'], 20); ?></div></td>
                <td><div class="KT_col_mcdcuenta"><?php echo KT_FormatForList($row_rsresultado['mcdcuenta'], 20); ?></div></td>
                <td><div class="KT_col_ca_nomcuenta"><?php echo $row_rsresultado['ca_nomcuenta']; ?></div></td>
                <td><div class="KT_col_mcdcodelem"><?php echo KT_FormatForList($row_rsresultado['mcdcodelem'], 20); ?></div></td>
                <td><div class="KT_col_ec_nomelemento"><textarea name="textarea" id="textarea" cols="45" rows="3"><?php echo $row_rsresultado['ec_nomelemento']; ?></textarea></div></td>
                <td><div class="KT_col_qty"><?php echo KT_FormatForList($row_rsresultado['qty'], 20); ?></div></td>
                <td><div class="KT_col_saldoactual"><?php echo KT_FormatForList($row_rsresultado['saldodisponible'], 20); ?></div></td>
                <td><a href="a_docs_soporte_310_vinc_2.php?as_id=<?php echo $_GET['as_id']; ?>&amp;doclasedoc_id=<?php echo $_GET['doclasedoc_id']; ?>&amp;anio_id=<?php echo $_GET['anio_id']; ?>&amp;hash_id=<?php echo $_GET['hash_id']; ?>&amp;lnk=<?php echo $_GET['lnk']; ?>&amp;numdocumento=<?php echo $_GET['numdocumento']; ?>&amp;mcdcuenta=<?php echo $row_rsresultado['mcdcuenta']; ?>&amp;KT_back=1&amp;mcdcodelem=<?php echo $row_rsresultado['mcdcodelem']; ?>" title="ver detalle">
                  <?php 
// Show IF Conditional region2 
if (@$row_rsresultado['saldodisponible'] > 0) {
?>
                    <img src="325_detail.png" width="32" height="32" border="0" />
                    <?php } 
// endif Conditional region2
?></a></td>
              </tr>
              <?php } while ($row_rsresultado = mysql_fetch_assoc($rsresultado)); ?>
            <?php } // Show if recordset not empty ?>
        </tbody>
      </table>
      <div class="KT_bottomnav">
        <div>
          <?php
            $nav_listrsresultado1->Prepare();
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
mysql_free_result($rsresultado);
?>
