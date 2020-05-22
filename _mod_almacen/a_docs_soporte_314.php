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

// Load the tNG classes
require_once('../includes/tng/tNG.inc.php');

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
$tfi_listrsalmovdevdia1 = new TFI_TableFilter($conn_oConnAlmacen, "tfi_listrsalmovdevdia1");
$tfi_listrsalmovdevdia1->addColumn("mddcuenta", "STRING_TYPE", "mddcuenta", "%");
$tfi_listrsalmovdevdia1->addColumn("mddcodelem", "NUMERIC_TYPE", "mddcodelem", "=");
$tfi_listrsalmovdevdia1->addColumn("ed_nomelemento", "STRING_TYPE", "ed_nomelemento", "%");
$tfi_listrsalmovdevdia1->addColumn("ma_nommarca", "STRING_TYPE", "ma_nommarca", "%");
$tfi_listrsalmovdevdia1->addColumn("mdd_cantmovto", "NUMERIC_TYPE", "mdd_cantmovto", "=");
$tfi_listrsalmovdevdia1->addColumn("mdd_valunit", "NUMERIC_TYPE", "mdd_valunit", "=");
$tfi_listrsalmovdevdia1->addColumn("mdd_tax", "NUMERIC_TYPE", "mdd_tax", "=");
$tfi_listrsalmovdevdia1->addColumn("mdd_valmovto", "NUMERIC_TYPE", "mdd_valmovto", "=");
$tfi_listrsalmovdevdia1->Execute();

// Sorter
$tso_listrsalmovdevdia1 = new TSO_TableSorter("rsalmovdevdia", "tso_listrsalmovdevdia1");
$tso_listrsalmovdevdia1->addColumn("mddcuenta");
$tso_listrsalmovdevdia1->addColumn("mddcodelem");
$tso_listrsalmovdevdia1->addColumn("ed_nomelemento");
$tso_listrsalmovdevdia1->addColumn("ma_nommarca");
$tso_listrsalmovdevdia1->addColumn("mdd_cantmovto");
$tso_listrsalmovdevdia1->addColumn("mdd_valunit");
$tso_listrsalmovdevdia1->addColumn("mdd_tax");
$tso_listrsalmovdevdia1->addColumn("mdd_valmovto");
$tso_listrsalmovdevdia1->setDefault("mddcuenta DESC");
$tso_listrsalmovdevdia1->Execute();

// Navigation
$nav_listrsalmovdevdia1 = new NAV_Regular("nav_listrsalmovdevdia1", "rsalmovdevdia", "../", $_SERVER['PHP_SELF'], 25);

$colname_rsinfoasiento = "-1";
if (isset($_GET['as_id'])) {
  $colname_rsinfoasiento = $_GET['as_id'];
}
mysql_select_db($database_oConnAlmacen, $oConnAlmacen);
$query_rsinfoasiento = sprintf("SELECT * FROM alasientos WHERE as_id = %s", GetSQLValueString($colname_rsinfoasiento, "int"));
$rsinfoasiento = mysql_query($query_rsinfoasiento, $oConnAlmacen) or die(mysql_error());
$row_rsinfoasiento = mysql_fetch_assoc($rsinfoasiento);
$totalRows_rsinfoasiento = mysql_num_rows($rsinfoasiento);

//NeXTenesio3 Special List Recordset
$maxRows_rsalmovdevdia = $_SESSION['max_rows_nav_listrsalmovdevdia1'];
$pageNum_rsalmovdevdia = 0;
if (isset($_GET['pageNum_rsalmovdevdia'])) {
  $pageNum_rsalmovdevdia = $_GET['pageNum_rsalmovdevdia'];
}
$startRow_rsalmovdevdia = $pageNum_rsalmovdevdia * $maxRows_rsalmovdevdia;

$colname_rsalmovdevdia = "-1";
if (isset($_GET['doclasedoc_id'])) {
  $colname_rsalmovdevdia = $_GET['doclasedoc_id'];
}
// Defining List Recordset variable
$NXTFilter_rsalmovdevdia = "1=1";
if (isset($_SESSION['filter_tfi_listrsalmovdevdia1'])) {
  $NXTFilter_rsalmovdevdia = $_SESSION['filter_tfi_listrsalmovdevdia1'];
}
// Defining List Recordset variable
$NXTSort_rsalmovdevdia = "mddcuenta DESC";
if (isset($_SESSION['sorter_tso_listrsalmovdevdia1'])) {
  $NXTSort_rsalmovdevdia = $_SESSION['sorter_tso_listrsalmovdevdia1'];
}
mysql_select_db($database_oConnAlmacen, $oConnAlmacen);

$query_rsalmovdevdia = sprintf("SELECT * FROM q_almovdevdia WHERE doclasedoc_id_fk = %s AND  {$NXTFilter_rsalmovdevdia}  ORDER BY  {$NXTSort_rsalmovdevdia} ", GetSQLValueString($colname_rsalmovdevdia, "int"));
$query_limit_rsalmovdevdia = sprintf("%s LIMIT %d, %d", $query_rsalmovdevdia, $startRow_rsalmovdevdia, $maxRows_rsalmovdevdia);
$rsalmovdevdia = mysql_query($query_limit_rsalmovdevdia, $oConnAlmacen) or die(mysql_error());
$row_rsalmovdevdia = mysql_fetch_assoc($rsalmovdevdia);

if (isset($_GET['totalRows_rsalmovdevdia'])) {
  $totalRows_rsalmovdevdia = $_GET['totalRows_rsalmovdevdia'];
} else {
  $all_rsalmovdevdia = mysql_query($query_rsalmovdevdia);
  $totalRows_rsalmovdevdia = mysql_num_rows($all_rsalmovdevdia);
}
$totalPages_rsalmovdevdia = ceil($totalRows_rsalmovdevdia/$maxRows_rsalmovdevdia)-1;
//End NeXTenesio3 Special List Recordset

$colname_rsinfogendocumentos = "-1";
if (isset($_GET['doclasedoc_id'])) {
  $colname_rsinfogendocumentos = $_GET['doclasedoc_id'];
}
mysql_select_db($database_oConnAlmacen, $oConnAlmacen);
$query_rsinfogendocumentos = sprintf("SELECT * FROM gedocumentos WHERE doclasedoc_id = %s", GetSQLValueString($colname_rsinfogendocumentos, "int"));
$rsinfogendocumentos = mysql_query($query_rsinfogendocumentos, $oConnAlmacen) or die(mysql_error());
$row_rsinfogendocumentos = mysql_fetch_assoc($rsinfogendocumentos);
$totalRows_rsinfogendocumentos = mysql_num_rows($rsinfogendocumentos);

$colname_rsinfoalmovtodia = "-1";
if (isset($_GET['doclasedoc_id'])) {
  $colname_rsinfoalmovtodia = $_GET['doclasedoc_id'];
}
mysql_select_db($database_oConnAlmacen, $oConnAlmacen);
$query_rsinfoalmovtodia = sprintf("SELECT * FROM q_almovtodia WHERE doclasedoc_id_fk = %s", GetSQLValueString($colname_rsinfoalmovtodia, "int"));
$rsinfoalmovtodia = mysql_query($query_rsinfoalmovtodia, $oConnAlmacen) or die(mysql_error());
$row_rsinfoalmovtodia = mysql_fetch_assoc($rsinfoalmovtodia);
$totalRows_rsinfoalmovtodia = mysql_num_rows($rsinfoalmovtodia);

$nav_listrsalmovdevdia1->checkBoundries();

// Download File downloadObj1
$downloadObj1 = new tNG_Download("../", "KT_download1");
// Execute
$downloadObj1->setFolder("../_attach_almacen/_docs_soporte/");
$downloadObj1->setRenameRule("{rsinfogendocumentos.do_file}");
$downloadObj1->Execute();
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</script>
<style type="text/css">
  /* Dynamic List row settings */
  .KT_col_mddcuenta {width:140px; overflow:hidden;}
  .KT_col_mddcodelem {width:140px; overflow:hidden;}
  .KT_col_ed_nomelemento {width:140px; overflow:hidden;}
  .KT_col_ma_nommarca {width:140px; overflow:hidden;}
  .KT_col_mdd_cantmovto {width:140px; overflow:hidden;}
  .KT_col_mdd_valunit {width:140px; overflow:hidden;}
  .KT_col_mdd_tax {width:140px; overflow:hidden;}
  .KT_col_mdd_valmovto {width:140px; overflow:hidden;}
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
		<button id="rerun">REGRESAR</button>
		<button id="select">REGRESAR</button>
	</div>
	<ul>
      <li><a href="a_docs_soporte_list.php?as_id=<?php echo $row_rsinfoasiento['as_id']; ?>&amp;anio_id=<?php echo $_GET['anio_id']; ?>&amp;hash_id=<?php echo $_GET['hash_id']; ?>" title="Regresar">Regresar</a></li>
  </ul>
</div>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="titlemsg2">INGRESO DEVOLUTIVO</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="2" cellpadding="0">
      <tr>
        <td class="frmtablahead">&nbsp;</td>
        <td class="frmtablahead">&nbsp;</td>
        <td class="frmtablahead">&nbsp;</td>
      </tr>
      <tr>
        <td class="frmtablahead">NUMERO DE ASIENTO</td>
        <td class="frmtablahead">FECHA</td>
        <td class="frmtablahead">ALMACEN</td>
      </tr>
      <tr>
        <td class="frmtablabody"><?php echo $row_rsinfoasiento['as_nroasiento']; ?></td>
        <td class="frmtablabody"><?php echo $row_rsinfoasiento['as_fechaasiento']; ?></td>
        <td class="frmtablabody"><?php echo $row_rsinfoasiento['ascodalmacen']; ?></td>
      </tr>
      <tr>
        <td class="frmtablahead">CLASE DOCUMENTO</td>
        <td class="frmtablahead">CONSECUTIVO</td>
        <td class="frmtablahead">NIT</td>
      </tr>
      <tr>
        <td class="frmtablabody"><?php echo $row_rsinfogendocumentos['doclasedoc']; ?></td>
        <td class="frmtablabody"><?php echo $row_rsinfogendocumentos['do_nrodoc']; ?></td>
        <td class="frmtablabody"><?php echo $row_rsinfogendocumentos['doccnit']; ?></td>
      </tr>
      <tr>
        <td class="frmtablahead">ANEXO</td>
        <td class="frmtablahead">&nbsp;</td>
        <td class="frmtablahead">ESTADO</td>
      </tr>
      <tr>
        <td class="frmtablabody"><a href="<?php echo $downloadObj1->getDownloadLink(); ?>"><?php echo $row_rsinfogendocumentos['do_file']; ?></a></td>
        <td class="frmtablabody">&nbsp;</td>
        <td class="titlemsg2"><?php echo $row_rsinfoalmovtodia['legal_name']; ?></td>
      </tr>
      <tr>
        <td colspan="3" class="frmtablahead">DETALLE</td>
        </tr>
      <tr>
        <td colspan="3" class="frmtablabody"><?php echo $row_rsinfogendocumentos['do_detalle']; ?></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><?php 
// Show IF Conditional region6 
if (@$_SESSION['kt_login_level'] == 8) {
?>
            <table width="150" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="center"><a href="../_gendraft/htmltodocx/_comp_entrada.php?doclasedoc_id=<?php echo $row_rsinfogendocumentos['doclasedoc_id']; ?>"><img src="321_gencomp.png" width="32" height="32" border="0" /></a></td>
                <td align="center"><a href="x_legaliza.php?almovtodia_id=<?php echo $row_rsinfoalmovtodia['almovtodia_id']; ?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )"><img src="325_legaliza.png" width="32" height="32" border="0" /></a></td>
              </tr>
              <tr>
                <td align="center">Generar comprobante</td>
                <td align="center"><p>Legalizar movimiento</p></td>
              </tr>
            </table>
            <?php } 
// endif Conditional region6
?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3"><hr /></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<p>&nbsp;
<div class="KT_tng" id="listrsalmovdevdia1">
  <h1> Movimiento
    <?php
  $nav_listrsalmovdevdia1->Prepare();
  require("../includes/nav/NAV_Text_Statistics.inc.php");
?>
  </h1>
  <div class="KT_tnglist">
    <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
      <div class="KT_options"> <a href="<?php echo $nav_listrsalmovdevdia1->getShowAllLink(); ?>"><?php echo NXT_getResource("Show"); ?>
        <?php 
  // Show IF Conditional region1
  if (@$_GET['show_all_nav_listrsalmovdevdia1'] == 1) {
?>
          <?php echo $_SESSION['default_max_rows_nav_listrsalmovdevdia1']; ?>
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
  if (@$_SESSION['has_filter_tfi_listrsalmovdevdia1'] == 1) {
?>
                  <a href="<?php echo $tfi_listrsalmovdevdia1->getResetFilterLink(); ?>"><?php echo NXT_getResource("Reset filter"); ?></a>
                  <?php 
  // else Conditional region2
  } else { ?>
                  <a href="<?php echo $tfi_listrsalmovdevdia1->getShowFilterLink(); ?>"><?php echo NXT_getResource("Show filter"); ?></a>
                  <?php } 
  // endif Conditional region2
?>
      </div>
      <table cellpadding="2" cellspacing="0" class="KT_tngtable">
        <thead>
          <tr class="KT_row_order">
            <th> <input type="checkbox" name="KT_selAll" id="KT_selAll"/>
            </th>
            <th id="mddcuenta" class="KT_sorter KT_col_mddcuenta <?php echo $tso_listrsalmovdevdia1->getSortIcon('mddcuenta'); ?>"> <a href="<?php echo $tso_listrsalmovdevdia1->getSortLink('mddcuenta'); ?>">CUENTA</a> </th>
            <th id="mddcodelem" class="KT_sorter KT_col_mddcodelem <?php echo $tso_listrsalmovdevdia1->getSortIcon('mddcodelem'); ?>"> <a href="<?php echo $tso_listrsalmovdevdia1->getSortLink('mddcodelem'); ?>">CODIGO ELEMENTO</a> </th>
            <th id="ed_nomelemento" class="KT_sorter KT_col_ed_nomelemento <?php echo $tso_listrsalmovdevdia1->getSortIcon('ed_nomelemento'); ?>"> <a href="<?php echo $tso_listrsalmovdevdia1->getSortLink('ed_nomelemento'); ?>">NOMBRE ELEMENTO</a> </th>
            <th id="ma_nommarca" class="KT_sorter KT_col_ma_nommarca <?php echo $tso_listrsalmovdevdia1->getSortIcon('ma_nommarca'); ?>"> <a href="<?php echo $tso_listrsalmovdevdia1->getSortLink('ma_nommarca'); ?>">MARCA</a> </th>
            <th id="mdd_cantmovto" class="KT_sorter KT_col_mdd_cantmovto <?php echo $tso_listrsalmovdevdia1->getSortIcon('mdd_cantmovto'); ?>"> <a href="<?php echo $tso_listrsalmovdevdia1->getSortLink('mdd_cantmovto'); ?>">CANTIDAD</a> </th>
            <th id="mdd_valunit" class="KT_sorter KT_col_mdd_valunit <?php echo $tso_listrsalmovdevdia1->getSortIcon('mdd_valunit'); ?>"> <a href="<?php echo $tso_listrsalmovdevdia1->getSortLink('mdd_valunit'); ?>">VALOR UNITARIO</a> </th>
            <th id="mdd_tax" class="KT_sorter KT_col_mdd_tax <?php echo $tso_listrsalmovdevdia1->getSortIcon('mdd_tax'); ?>"> <a href="<?php echo $tso_listrsalmovdevdia1->getSortLink('mdd_tax'); ?>">IMPUESTO</a> </th>
            <th id="mdd_valmovto" class="KT_sorter KT_col_mdd_valmovto <?php echo $tso_listrsalmovdevdia1->getSortIcon('mdd_valmovto'); ?>"> <a href="<?php echo $tso_listrsalmovdevdia1->getSortLink('mdd_valmovto'); ?>">VALOR MOVIMIENTO</a> </th>
            <th>&nbsp;</th>
          </tr>
          <?php 
  // Show IF Conditional region3
  if (@$_SESSION['has_filter_tfi_listrsalmovdevdia1'] == 1) {
?>
            <tr class="KT_row_filter">
              <td>&nbsp;</td>
              <td><input type="text" name="tfi_listrsalmovdevdia1_mddcuenta" id="tfi_listrsalmovdevdia1_mddcuenta" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrsalmovdevdia1_mddcuenta']); ?>" size="20" maxlength="20" /></td>
              <td><input type="text" name="tfi_listrsalmovdevdia1_mddcodelem" id="tfi_listrsalmovdevdia1_mddcodelem" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrsalmovdevdia1_mddcodelem']); ?>" size="20" maxlength="100" /></td>
              <td><input type="text" name="tfi_listrsalmovdevdia1_ed_nomelemento" id="tfi_listrsalmovdevdia1_ed_nomelemento" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrsalmovdevdia1_ed_nomelemento']); ?>" size="20" maxlength="20" /></td>
              <td><input type="text" name="tfi_listrsalmovdevdia1_ma_nommarca" id="tfi_listrsalmovdevdia1_ma_nommarca" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrsalmovdevdia1_ma_nommarca']); ?>" size="20" maxlength="20" /></td>
              <td><input type="text" name="tfi_listrsalmovdevdia1_mdd_cantmovto" id="tfi_listrsalmovdevdia1_mdd_cantmovto" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrsalmovdevdia1_mdd_cantmovto']); ?>" size="20" maxlength="100" /></td>
              <td><input type="text" name="tfi_listrsalmovdevdia1_mdd_valunit" id="tfi_listrsalmovdevdia1_mdd_valunit" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrsalmovdevdia1_mdd_valunit']); ?>" size="20" maxlength="100" /></td>
              <td><input type="text" name="tfi_listrsalmovdevdia1_mdd_tax" id="tfi_listrsalmovdevdia1_mdd_tax" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrsalmovdevdia1_mdd_tax']); ?>" size="20" maxlength="100" /></td>
              <td><input type="text" name="tfi_listrsalmovdevdia1_mdd_valmovto" id="tfi_listrsalmovdevdia1_mdd_valmovto" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrsalmovdevdia1_mdd_valmovto']); ?>" size="20" maxlength="100" /></td>
              <td><input type="submit" name="tfi_listrsalmovdevdia1" value="<?php echo NXT_getResource("Filter"); ?>" /></td>
            </tr>
            <?php } 
  // endif Conditional region3
?>
        </thead>
        <tbody>
          <?php if ($totalRows_rsalmovdevdia == 0) { // Show if recordset empty ?>
            <tr>
              <td colspan="10"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
            </tr>
            <?php } // Show if recordset empty ?>
          <?php if ($totalRows_rsalmovdevdia > 0) { // Show if recordset not empty ?>
            <?php do { ?>
              <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
                <td><input type="checkbox" name="kt_pk_" class="id_checkbox" value="<?php echo $row_rsalmovdevdia['almovdevdia_id']; ?>" />
                    <input type="hidden" name="almovdevdia_id" class="id_field" value="<?php echo $row_rsalmovdevdia['almovdevdia_id']; ?>" />
                </td>
                <td><div class="KT_col_mddcuenta"><?php echo KT_FormatForList($row_rsalmovdevdia['mddcuenta'], 20); ?></div></td>
                <td><div class="KT_col_mddcodelem"><?php echo KT_FormatForList($row_rsalmovdevdia['mddcodelem'], 20); ?></div></td>
                <td><div class="KT_col_ed_nomelemento">
                
                <textarea name="textarea" id="textarea" cols="45" rows="5"><?php echo $row_rsalmovdevdia['ed_nomelemento']; ?></textarea></div></td>
                <td><div class="KT_col_ma_nommarca"><?php echo KT_FormatForList($row_rsalmovdevdia['ma_nommarca'], 20); ?></div></td>
                <td align="center"><div class="KT_col_mdd_cantmovto"><?php echo KT_FormatForList($row_rsalmovdevdia['mdd_cantmovto'], 20); ?><a href="JavaScript:;" title="Individualizar elementos">
                  <?php 
// Show IF Conditional region7 
if (@$_SESSION['kt_login_level'] == 8) {
?>
                    <img src="325_individualizar.png" width="32" height="32" border="0" onclick="MM_openBrWindow('a_docs_soporte_314_indiv_list.php?almovdevdia_id=<?php echo $row_rsalmovdevdia['almovdevdia_id']; ?>&amp;doclasedoc_id=<?php echo $row_rsalmovdevdia['doclasedoc_id_fk']; ?>&amp;as_id=<?php echo $_GET['as_id']; ?>&amp;hash_id=<?php echo $_GET['hash_id']; ?>&amp;anio_id=<?php echo $_GET['anio_id']; ?>','','scrollbars=yes,resizable=yes,width=800,height=600')" />
                    <?php } 
// endif Conditional region7
?></a></div></td>
                <td align="right"><div class="KT_col_mdd_valunit"><?php echo number_format($row_rsalmovdevdia['mdd_valunit'],2,',','.'); ?></div></td>
                <td align="center"><div class="KT_col_mdd_tax"><?php echo KT_FormatForList($row_rsalmovdevdia['mdd_tax'], 20); ?></div></td>
                <td align="right"><div class="KT_col_mdd_valmovto"><?php echo number_format($row_rsalmovdevdia['mdd_valmovto'],2,',','.'); ?></div></td>
                <td><?php 
// Show IF Conditional region5 
if (@$row_rsinfoalmovtodia['md_legalizado'] == "N") {
?>
                    <a class="KT_edit_link" href="a_docs_soporte_314_edit.php?doclasedoc_id=<?php echo $row_rsinfogendocumentos['doclasedoc_id']; ?>&amp;almovdevdia_id=<?php echo $row_rsalmovdevdia['almovdevdia_id']; ?>&amp;KT_back=1&amp;doclasedoc_id=<?php echo $row_rsinfogendocumentos['doclasedoc_id']; ?>&amp;KT_back=1&amp;as_id=<?php echo $_GET['as_id']; ?>&amp;hash_id=<?php echo $_GET['hash_id']; ?>&amp;anio_id=<?php echo $_GET['anio_id']; ?>"><?php echo NXT_getResource("edit_one"); ?></a>
                    <?php } 
// endif Conditional region5
?></td>
              </tr>
              <?php } while ($row_rsalmovdevdia = mysql_fetch_assoc($rsalmovdevdia)); ?>
            <?php } // Show if recordset not empty ?>
        </tbody>
      </table>
      <div class="KT_bottomnav">
        <div>
          <?php
            $nav_listrsalmovdevdia1->Prepare();
            require("../includes/nav/NAV_Text_Navigation.inc.php");
          ?>
        </div>
      </div>
      <div class="KT_bottombuttons">
        <?php 
// Show IF Conditional region4 
if (@$row_rsinfoalmovtodia['md_legalizado'] == "N") {
?>
          <div class="KT_operations"> <a class="KT_edit_op_link" href="#" onclick="nxt_list_edit_link_form(this); return false;"><?php echo NXT_getResource("edit_all"); ?></a> <a class="KT_delete_op_link" href="#" onclick="nxt_list_delete_link_form(this); return false;"><?php echo NXT_getResource("delete_all"); ?></a> </div>
<span>&nbsp;</span>
          <select name="no_new" id="no_new">
            <option value="1">1</option>
          </select>
          <a class="KT_additem_op_link" href="a_docs_soporte_314_edit.php?doclasedoc_id=<?php echo $row_rsinfogendocumentos['doclasedoc_id']; ?>&amp;KT_back=1&amp;as_id=<?php echo $_GET['as_id']; ?>&amp;hash_id=<?php echo $_GET['hash_id']; ?>&amp;anio_id=<?php echo $_GET['anio_id']; ?>" onclick="return nxt_list_additem(this)">Nuevo elemento</a>
          <?php } 
// endif Conditional region4
?> </div>
    </form>
  </div>
  <br class="clearfixplain" />
</div>
<p>&nbsp;</p>
</p>
<p>&nbsp;</p>
<?php
  mxi_includes_start("../inc_foot.php");
  require(basename("../inc_foot.php"));
  mxi_includes_end();
?>
</body>
</html>
<?php
mysql_free_result($rsinfoasiento);

mysql_free_result($rsalmovdevdia);

mysql_free_result($rsinfogendocumentos);

mysql_free_result($rsinfoalmovtodia);
?>
