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
$tfi_listrsalmovconsdia1 = new TFI_TableFilter($conn_oConnAlmacen, "tfi_listrsalmovconsdia1");
$tfi_listrsalmovconsdia1->addColumn("mcdcuenta", "STRING_TYPE", "mcdcuenta", "%");
$tfi_listrsalmovconsdia1->addColumn("mcdcodelem", "NUMERIC_TYPE", "mcdcodelem", "=");
$tfi_listrsalmovconsdia1->addColumn("ec_nomelemento", "STRING_TYPE", "ec_nomelemento", "%");
$tfi_listrsalmovconsdia1->addColumn("um_nomunimed", "STRING_TYPE", "um_nomunimed", "%");
$tfi_listrsalmovconsdia1->addColumn("mcd_cantmovto", "NUMERIC_TYPE", "mcd_cantmovto", "=");
$tfi_listrsalmovconsdia1->addColumn("mcd_valunitant", "NUMERIC_TYPE", "mcd_valunitant", "=");
$tfi_listrsalmovconsdia1->addColumn("tax_name", "STRING_TYPE", "tax_name", "%");
$tfi_listrsalmovconsdia1->addColumn("mcd_valmovto", "NUMERIC_TYPE", "mcd_valmovto", "=");
$tfi_listrsalmovconsdia1->Execute();

// Sorter
$tso_listrsalmovconsdia1 = new TSO_TableSorter("rsalmovconsdia", "tso_listrsalmovconsdia1");
$tso_listrsalmovconsdia1->addColumn("mcdcuenta");
$tso_listrsalmovconsdia1->addColumn("mcdcodelem");
$tso_listrsalmovconsdia1->addColumn("ec_nomelemento");
$tso_listrsalmovconsdia1->addColumn("um_nomunimed");
$tso_listrsalmovconsdia1->addColumn("mcd_cantmovto");
$tso_listrsalmovconsdia1->addColumn("mcd_valunitant");
$tso_listrsalmovconsdia1->addColumn("tax_name");
$tso_listrsalmovconsdia1->addColumn("mcd_valmovto");
$tso_listrsalmovconsdia1->setDefault("mcdcuenta");
$tso_listrsalmovconsdia1->Execute();

// Navigation
$nav_listrsalmovconsdia1 = new NAV_Regular("nav_listrsalmovconsdia1", "rsalmovconsdia", "../", $_SERVER['PHP_SELF'], 25);

$colname_rsinfoasiento = "-1";
if (isset($_GET['as_id'])) {
  $colname_rsinfoasiento = $_GET['as_id'];
}
mysql_select_db($database_oConnAlmacen, $oConnAlmacen);
$query_rsinfoasiento = sprintf("SELECT * FROM alasientos WHERE as_id = %s", GetSQLValueString($colname_rsinfoasiento, "int"));
$rsinfoasiento = mysql_query($query_rsinfoasiento, $oConnAlmacen) or die(mysql_error());
$row_rsinfoasiento = mysql_fetch_assoc($rsinfoasiento);
$totalRows_rsinfoasiento = mysql_num_rows($rsinfoasiento);

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

//NeXTenesio3 Special List Recordset
$maxRows_rsalmovconsdia = $_SESSION['max_rows_nav_listrsalmovconsdia1'];
$pageNum_rsalmovconsdia = 0;
if (isset($_GET['pageNum_rsalmovconsdia'])) {
  $pageNum_rsalmovconsdia = $_GET['pageNum_rsalmovconsdia'];
}
$startRow_rsalmovconsdia = $pageNum_rsalmovconsdia * $maxRows_rsalmovconsdia;

$colname_rsalmovconsdia = "-1";
if (isset($_GET['doclasedoc_id'])) {
  $colname_rsalmovconsdia = $_GET['doclasedoc_id'];
}
// Defining List Recordset variable
$NXTFilter_rsalmovconsdia = "1=1";
if (isset($_SESSION['filter_tfi_listrsalmovconsdia1'])) {
  $NXTFilter_rsalmovconsdia = $_SESSION['filter_tfi_listrsalmovconsdia1'];
}
// Defining List Recordset variable
$NXTSort_rsalmovconsdia = "mcdcuenta";
if (isset($_SESSION['sorter_tso_listrsalmovconsdia1'])) {
  $NXTSort_rsalmovconsdia = $_SESSION['sorter_tso_listrsalmovconsdia1'];
}
mysql_select_db($database_oConnAlmacen, $oConnAlmacen);

$query_rsalmovconsdia = sprintf("SELECT * FROM q_almovconsdia WHERE doclasedoc_id_fk = %s AND  {$NXTFilter_rsalmovconsdia}  ORDER BY  {$NXTSort_rsalmovconsdia} ", GetSQLValueString($colname_rsalmovconsdia, "int"));
$query_limit_rsalmovconsdia = sprintf("%s LIMIT %d, %d", $query_rsalmovconsdia, $startRow_rsalmovconsdia, $maxRows_rsalmovconsdia);
$rsalmovconsdia = mysql_query($query_limit_rsalmovconsdia, $oConnAlmacen) or die(mysql_error());
$row_rsalmovconsdia = mysql_fetch_assoc($rsalmovconsdia);

if (isset($_GET['totalRows_rsalmovconsdia'])) {
  $totalRows_rsalmovconsdia = $_GET['totalRows_rsalmovconsdia'];
} else {
  $all_rsalmovconsdia = mysql_query($query_rsalmovconsdia);
  $totalRows_rsalmovconsdia = mysql_num_rows($all_rsalmovconsdia);
}
$totalPages_rsalmovconsdia = ceil($totalRows_rsalmovconsdia/$maxRows_rsalmovconsdia)-1;
//End NeXTenesio3 Special List Recordset

$nav_listrsalmovconsdia1->checkBoundries();

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
</script>
<style type="text/css">
  /* Dynamic List row settings */
  .KT_col_mcdcuenta {width:140px; overflow:hidden;}
  .KT_col_mcdcodelem {width:140px; overflow:hidden;}
  .KT_col_ec_nomelemento {width:140px; overflow:hidden;}
  .KT_col_um_nomunimed {width:140px; overflow:hidden;}
  .KT_col_mcd_cantmovto {width:140px; overflow:hidden;}
  .KT_col_mcd_valunitant {width:140px; overflow:hidden;}
  .KT_col_tax_name {width:140px; overflow:hidden;}
  .KT_col_mcd_valmovto {width:140px; overflow:hidden;}
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
      <li><a href="a_movimientos_list.php?anio_id=<?php echo $_GET['anio_id']; ?>" title="Regresar">Regresar</a></li>
    </ul>
</div>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="titlemsg2">INGRESO CONSUMO</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="2" cellpadding="0">
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
        <td class="titlemsg2"><?php echo $row_rsinfogendocumentos['do_nrodoc']; ?></td>
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
        <td><table width="150" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center"><a href="../_gendraft/htmltodocx/_comp_entrada_consumo.php?doclasedoc_id=<?php echo $row_rsinfogendocumentos['doclasedoc_id']; ?>"><img src="321_gencomp.png" width="32" height="32" border="0" /></a></td>
            <td align="center"><a href="x_legaliza.php?almovtodia_id=<?php echo $row_rsinfoalmovtodia['almovtodia_id']; ?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )"><img src="325_legaliza.png" width="32" height="32" border="0" /></a></td>
          </tr>
          <tr>
            <td align="center">Generar comprobante</td>
            <td align="center">Legalizar movimiento</td>
          </tr>
        </table></td>
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
<div class="KT_tng" id="listrsalmovconsdia1">
  <h1>
    <?php
  $nav_listrsalmovconsdia1->Prepare();
  require("../includes/nav/NAV_Text_Statistics.inc.php");
?>
  </h1>
  <div class="KT_tnglist">
    <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
      <div class="KT_options"> <a href="<?php echo $nav_listrsalmovconsdia1->getShowAllLink(); ?>"><?php echo NXT_getResource("Show"); ?>
        <?php 
  // Show IF Conditional region1
  if (@$_GET['show_all_nav_listrsalmovconsdia1'] == 1) {
?>
          <?php echo $_SESSION['default_max_rows_nav_listrsalmovconsdia1']; ?>
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
  if (@$_SESSION['has_filter_tfi_listrsalmovconsdia1'] == 1) {
?>
                  <a href="<?php echo $tfi_listrsalmovconsdia1->getResetFilterLink(); ?>"><?php echo NXT_getResource("Reset filter"); ?></a>
                  <?php 
  // else Conditional region2
  } else { ?>
                  <a href="<?php echo $tfi_listrsalmovconsdia1->getShowFilterLink(); ?>"><?php echo NXT_getResource("Show filter"); ?></a>
                  <?php } 
  // endif Conditional region2
?>
      </div>
      <table cellpadding="2" cellspacing="0" class="KT_tngtable">
        <thead>
          <tr class="KT_row_order">
            <th> <input type="checkbox" name="KT_selAll" id="KT_selAll"/>
            </th>
            <th id="mcdcuenta" class="KT_sorter KT_col_mcdcuenta <?php echo $tso_listrsalmovconsdia1->getSortIcon('mcdcuenta'); ?>"> <a href="<?php echo $tso_listrsalmovconsdia1->getSortLink('mcdcuenta'); ?>">CUENTA</a> </th>
            <th id="mcdcodelem" class="KT_sorter KT_col_mcdcodelem <?php echo $tso_listrsalmovconsdia1->getSortIcon('mcdcodelem'); ?>"> <a href="<?php echo $tso_listrsalmovconsdia1->getSortLink('mcdcodelem'); ?>">CODIGO ELEMENTO</a> </th>
            <th id="ec_nomelemento" class="KT_sorter KT_col_ec_nomelemento <?php echo $tso_listrsalmovconsdia1->getSortIcon('ec_nomelemento'); ?>"> <a href="<?php echo $tso_listrsalmovconsdia1->getSortLink('ec_nomelemento'); ?>">NOMBRE ELEMENTO</a> </th>
            <th id="um_nomunimed" class="KT_sorter KT_col_um_nomunimed <?php echo $tso_listrsalmovconsdia1->getSortIcon('um_nomunimed'); ?>"> <a href="<?php echo $tso_listrsalmovconsdia1->getSortLink('um_nomunimed'); ?>">PRESENTACION</a> </th>
            <th id="mcd_cantmovto" class="KT_sorter KT_col_mcd_cantmovto <?php echo $tso_listrsalmovconsdia1->getSortIcon('mcd_cantmovto'); ?>"> <a href="<?php echo $tso_listrsalmovconsdia1->getSortLink('mcd_cantmovto'); ?>">CANTIDAD</a> </th>
            <th id="mcd_valunitant" class="KT_sorter KT_col_mcd_valunitant <?php echo $tso_listrsalmovconsdia1->getSortIcon('mcd_valunitant'); ?>"> <a href="<?php echo $tso_listrsalmovconsdia1->getSortLink('mcd_valunitant'); ?>">VALOR UNITARIO</a> </th>
            <th id="tax_name" class="KT_sorter KT_col_tax_name <?php echo $tso_listrsalmovconsdia1->getSortIcon('tax_name'); ?>"> <a href="<?php echo $tso_listrsalmovconsdia1->getSortLink('tax_name'); ?>">IMPUESTO</a> </th>
            <th id="mcd_valmovto" class="KT_sorter KT_col_mcd_valmovto <?php echo $tso_listrsalmovconsdia1->getSortIcon('mcd_valmovto'); ?>"> <a href="<?php echo $tso_listrsalmovconsdia1->getSortLink('mcd_valmovto'); ?>">VALOR DEL MOVIMIENTO</a> </th>
            <th>&nbsp;</th>
          </tr>
          <?php 
  // Show IF Conditional region3
  if (@$_SESSION['has_filter_tfi_listrsalmovconsdia1'] == 1) {
?>
            <tr class="KT_row_filter">
              <td>&nbsp;</td>
              <td><input type="text" name="tfi_listrsalmovconsdia1_mcdcuenta" id="tfi_listrsalmovconsdia1_mcdcuenta" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrsalmovconsdia1_mcdcuenta']); ?>" size="20" maxlength="20" /></td>
              <td><input type="text" name="tfi_listrsalmovconsdia1_mcdcodelem" id="tfi_listrsalmovconsdia1_mcdcodelem" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrsalmovconsdia1_mcdcodelem']); ?>" size="20" maxlength="100" /></td>
              <td><input type="text" name="tfi_listrsalmovconsdia1_ec_nomelemento" id="tfi_listrsalmovconsdia1_ec_nomelemento" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrsalmovconsdia1_ec_nomelemento']); ?>" size="20" maxlength="20" /></td>
              <td><input type="text" name="tfi_listrsalmovconsdia1_um_nomunimed" id="tfi_listrsalmovconsdia1_um_nomunimed" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrsalmovconsdia1_um_nomunimed']); ?>" size="20" maxlength="20" /></td>
              <td><input type="text" name="tfi_listrsalmovconsdia1_mcd_cantmovto" id="tfi_listrsalmovconsdia1_mcd_cantmovto" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrsalmovconsdia1_mcd_cantmovto']); ?>" size="20" maxlength="100" /></td>
              <td><input type="text" name="tfi_listrsalmovconsdia1_mcd_valunitant" id="tfi_listrsalmovconsdia1_mcd_valunitant" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrsalmovconsdia1_mcd_valunitant']); ?>" size="20" maxlength="100" /></td>
              <td><input type="text" name="tfi_listrsalmovconsdia1_tax_name" id="tfi_listrsalmovconsdia1_tax_name" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrsalmovconsdia1_tax_name']); ?>" size="20" maxlength="20" /></td>
              <td><input type="text" name="tfi_listrsalmovconsdia1_mcd_valmovto" id="tfi_listrsalmovconsdia1_mcd_valmovto" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrsalmovconsdia1_mcd_valmovto']); ?>" size="20" maxlength="100" /></td>
              <td><input type="submit" name="tfi_listrsalmovconsdia1" value="<?php echo NXT_getResource("Filter"); ?>" /></td>
            </tr>
            <?php } 
  // endif Conditional region3
?>
        </thead>
        <tbody>
          <?php if ($totalRows_rsalmovconsdia == 0) { // Show if recordset empty ?>
            <tr>
              <td colspan="10"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
            </tr>
            <?php } // Show if recordset empty ?>
          <?php if ($totalRows_rsalmovconsdia > 0) { // Show if recordset not empty ?>
            <?php do { ?>
              <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
                <td><input type="checkbox" name="kt_pk_" class="id_checkbox" value="<?php echo $row_rsalmovconsdia['almovconsdia_id']; ?>" />
                    <input type="hidden" name="almovconsdia_id" class="id_field" value="<?php echo $row_rsalmovconsdia['almovconsdia_id']; ?>" />
                </td>
                <td><div class="KT_col_mcdcuenta"><?php echo KT_FormatForList($row_rsalmovconsdia['mcdcuenta'], 20); ?></div></td>
                <td><div class="KT_col_mcdcodelem"><?php echo KT_FormatForList($row_rsalmovconsdia['mcdcodelem'], 20); ?></div></td>
                <td><div class="KT_col_ec_nomelemento"><?php echo $row_rsalmovconsdia['ec_nomelemento']; ?></div></td>
                <td><div class="KT_col_um_nomunimed"><?php echo KT_FormatForList($row_rsalmovconsdia['um_nomunimed'], 20); ?></div></td>
                <td><div class="KT_col_mcd_cantmovto" align="center"><?php echo KT_FormatForList($row_rsalmovconsdia['mcd_cantmovto'], 20); ?></div></td>
                <td><div class="KT_col_mcd_valunitant" align="right"><?php echo number_format($row_rsalmovconsdia['mcd_valunitant'],2,',','.'); ?></div></td>
                <td><div class="KT_col_tax_name"><?php echo KT_FormatForList($row_rsalmovconsdia['tax_name'], 20); ?></div></td>
                <td><div class="KT_col_mcd_valmovto" align="right"><?php echo number_format($row_rsalmovconsdia['mcd_valmovto'],2,',','.'); ?></div></td>
                <td><?php 
// Show IF Conditional region5 
if (@$row_rsinfoalmovtodia['md_legalizado'] == "N") {
?>
                    <a class="KT_edit_link" href="a_docs_soporte_311_edit.php?doclasedoc_id=<?php echo $row_rsalmovconsdia['doclasedoc_id_fk']; ?>&amp;anio_id=<?php echo $_GET['anio_id']; ?>&amp;hash_id=<?php echo $_GET['hash_id']; ?>&amp;almovconsdia_id=<?php echo $row_rsalmovconsdia['almovconsdia_id']; ?>&amp;KT_back=1&amp;as_id=<?php echo $_GET['as_id']; ?>"><?php echo NXT_getResource("edit_one"); ?></a>
                    <?php } 
// endif Conditional region5
?> </td>
              </tr>
              <?php } while ($row_rsalmovconsdia = mysql_fetch_assoc($rsalmovconsdia)); ?>
            <?php } // Show if recordset not empty ?>
        </tbody>
      </table>
      <div class="KT_bottomnav">
        <div>
          <?php
            $nav_listrsalmovconsdia1->Prepare();
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
            <option value="3">3</option>
            <option value="6">6</option>
          </select>
          <a class="KT_additem_op_link" href="a_docs_soporte_311_edit.php?doclasedoc_id=<?php echo $row_rsinfogendocumentos['doclasedoc_id']; ?>&amp;anio_id=<?php echo $_GET['anio_id']; ?>&amp;hash_id=<?php echo $_GET['hash_id']; ?>&amp;KT_back=1&amp;as_id=<?php echo $_GET['as_id']; ?>" onclick="return nxt_list_additem(this)"><?php echo NXT_getResource("add new"); ?></a>
          <?php } 
// endif Conditional region4
?> </div>
    </form>
  </div>
  <br class="clearfixplain" />
</div>
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

mysql_free_result($rsinfogendocumentos);

mysql_free_result($rsinfoalmovtodia);

mysql_free_result($rsalmovconsdia);
?>
