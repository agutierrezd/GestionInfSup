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

// Load the tNG classes
require_once('../includes/tng/tNG.inc.php');

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
$tfi_listrslistdocssoporte1 = new TFI_TableFilter($conn_oConnAlmacen, "tfi_listrslistdocssoporte1");
$tfi_listrslistdocssoporte1->addColumn("doclasedoc", "NUMERIC_TYPE", "doclasedoc", "=");
$tfi_listrslistdocssoporte1->addColumn("cd_nombredoc", "STRING_TYPE", "cd_nombredoc", "%");
$tfi_listrslistdocssoporte1->addColumn("do_nrodoc", "NUMERIC_TYPE", "do_nrodoc", "=");
$tfi_listrslistdocssoporte1->addColumn("do_fechadoc", "DATE_TYPE", "do_fechadoc", "=");
$tfi_listrslistdocssoporte1->addColumn("do_detalle", "STRING_TYPE", "do_detalle", "%");
$tfi_listrslistdocssoporte1->addColumn("doccnit", "STRING_TYPE", "doccnit", "%");
$tfi_listrslistdocssoporte1->addColumn("do_file", "STRING_TYPE", "do_file", "%");
$tfi_listrslistdocssoporte1->Execute();

// Sorter
$tso_listrslistdocssoporte1 = new TSO_TableSorter("rslistdocssoporte", "tso_listrslistdocssoporte1");
$tso_listrslistdocssoporte1->addColumn("doclasedoc");
$tso_listrslistdocssoporte1->addColumn("cd_nombredoc");
$tso_listrslistdocssoporte1->addColumn("do_nrodoc");
$tso_listrslistdocssoporte1->addColumn("do_fechadoc");
$tso_listrslistdocssoporte1->addColumn("do_detalle");
$tso_listrslistdocssoporte1->addColumn("doccnit");
$tso_listrslistdocssoporte1->addColumn("do_file");
$tso_listrslistdocssoporte1->setDefault("do_nrodoc DESC");
$tso_listrslistdocssoporte1->Execute();

// Navigation
$nav_listrslistdocssoporte1 = new NAV_Regular("nav_listrslistdocssoporte1", "rslistdocssoporte", "../", $_SERVER['PHP_SELF'], 25);

//NeXTenesio3 Special List Recordset
$maxRows_rslistdocssoporte = $_SESSION['max_rows_nav_listrslistdocssoporte1'];
$pageNum_rslistdocssoporte = 0;
if (isset($_GET['pageNum_rslistdocssoporte'])) {
  $pageNum_rslistdocssoporte = $_GET['pageNum_rslistdocssoporte'];
}
$startRow_rslistdocssoporte = $pageNum_rslistdocssoporte * $maxRows_rslistdocssoporte;

$colname_rslistdocssoporte = "-1";
if (isset($_GET['as_id'])) {
  $colname_rslistdocssoporte = $_GET['as_id'];
}
// Defining List Recordset variable
$NXTFilter_rslistdocssoporte = "1=1";
if (isset($_SESSION['filter_tfi_listrslistdocssoporte1'])) {
  $NXTFilter_rslistdocssoporte = $_SESSION['filter_tfi_listrslistdocssoporte1'];
}
// Defining List Recordset variable
$NXTSort_rslistdocssoporte = "do_nrodoc DESC";
if (isset($_SESSION['sorter_tso_listrslistdocssoporte1'])) {
  $NXTSort_rslistdocssoporte = $_SESSION['sorter_tso_listrslistdocssoporte1'];
}
mysql_select_db($database_oConnAlmacen, $oConnAlmacen);

$query_rslistdocssoporte = sprintf("SELECT * FROM q_master_gedocumentos WHERE alasiento_id_fk = %s AND  {$NXTFilter_rslistdocssoporte} ORDER BY {$NXTSort_rslistdocssoporte} ", GetSQLValueString($colname_rslistdocssoporte, "int"));
$query_limit_rslistdocssoporte = sprintf("%s LIMIT %d, %d", $query_rslistdocssoporte, $startRow_rslistdocssoporte, $maxRows_rslistdocssoporte);
$rslistdocssoporte = mysql_query($query_limit_rslistdocssoporte, $oConnAlmacen) or die(mysql_error());
$row_rslistdocssoporte = mysql_fetch_assoc($rslistdocssoporte);

if (isset($_GET['totalRows_rslistdocssoporte'])) {
  $totalRows_rslistdocssoporte = $_GET['totalRows_rslistdocssoporte'];
} else {
  $all_rslistdocssoporte = mysql_query($query_rslistdocssoporte);
  $totalRows_rslistdocssoporte = mysql_num_rows($all_rslistdocssoporte);
}
$totalPages_rslistdocssoporte = ceil($totalRows_rslistdocssoporte/$maxRows_rslistdocssoporte)-1;
//End NeXTenesio3 Special List Recordset

$colname_rsinfoasiento = "-1";
if (isset($_GET['as_id'])) {
  $colname_rsinfoasiento = $_GET['as_id'];
}
mysql_select_db($database_oConnAlmacen, $oConnAlmacen);
$query_rsinfoasiento = sprintf("SELECT * FROM alasientos WHERE as_id = %s", GetSQLValueString($colname_rsinfoasiento, "int"));
$rsinfoasiento = mysql_query($query_rsinfoasiento, $oConnAlmacen) or die(mysql_error());
$row_rsinfoasiento = mysql_fetch_assoc($rsinfoasiento);
$totalRows_rsinfoasiento = mysql_num_rows($rsinfoasiento);

$nav_listrslistdocssoporte1->checkBoundries();

// Download File downloadObj1
$downloadObj1 = new tNG_Download("../", "KT_download1");
// Execute
$downloadObj1->setFolder("../_attach_almacen/_docs_soporte/");
$downloadObj1->setRenameRule("{rslistdocssoporte.do_file}");
$downloadObj1->Execute();
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
  .KT_col_doclasedoc {width:70px; overflow:hidden;}
  .KT_col_cd_nombredoc {width:175px; overflow:hidden;}
  .KT_col_do_nrodoc {width:70px; overflow:hidden;}
  .KT_col_do_fechadoc {width:105px; overflow:hidden;}
  .KT_col_do_detalle {width:210px; overflow:hidden;}
  .KT_col_doccnit {width:105px; overflow:hidden;}
  .KT_col_do_file {width:105px; overflow:hidden;}
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
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="titlemsg2">ASIENTO N&Uacute;MERO: <?php echo $row_rsinfoasiento['as_nroasiento']; ?> FECHA: <?php echo $row_rsinfoasiento['as_fechaasiento']; ?> ALMAC&Eacute;N: <?php echo $row_rsinfoasiento['ascodalmacen']; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<div class="KT_tng" id="listrslistdocssoporte1">
  <h1> LISTADO DE DOCUMENTOS SOPORTE
    <?php
  $nav_listrslistdocssoporte1->Prepare();
  require("../includes/nav/NAV_Text_Statistics.inc.php");
?>
  </h1>
  <div class="KT_tnglist">
    <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
      <div class="KT_options"> <a href="<?php echo $nav_listrslistdocssoporte1->getShowAllLink(); ?>"><?php echo NXT_getResource("Show"); ?>
        <?php 
  // Show IF Conditional region1
  if (@$_GET['show_all_nav_listrslistdocssoporte1'] == 1) {
?>
          <?php echo $_SESSION['default_max_rows_nav_listrslistdocssoporte1']; ?>
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
  if (@$_SESSION['has_filter_tfi_listrslistdocssoporte1'] == 1) {
?>
                  <a href="<?php echo $tfi_listrslistdocssoporte1->getResetFilterLink(); ?>"><?php echo NXT_getResource("Reset filter"); ?></a>
                  <?php 
  // else Conditional region2
  } else { ?>
                  <a href="<?php echo $tfi_listrslistdocssoporte1->getShowFilterLink(); ?>"><?php echo NXT_getResource("Show filter"); ?></a>
                  <?php } 
  // endif Conditional region2
?>
      </div>
      <table cellpadding="2" cellspacing="0" class="KT_tngtable">
        <thead>
          <tr class="KT_row_order">
            <th> <input type="checkbox" name="KT_selAll" id="KT_selAll"/>
            </th>
            <th id="doclasedoc" class="KT_sorter KT_col_doclasedoc <?php echo $tso_listrslistdocssoporte1->getSortIcon('doclasedoc'); ?>"> <a href="<?php echo $tso_listrslistdocssoporte1->getSortLink('doclasedoc'); ?>">CODIGO DOCUMENTO</a> </th>
            <th id="cd_nombredoc" class="KT_sorter KT_col_cd_nombredoc <?php echo $tso_listrslistdocssoporte1->getSortIcon('cd_nombredoc'); ?>"> <a href="<?php echo $tso_listrslistdocssoporte1->getSortLink('cd_nombredoc'); ?>">NOMBRE DOCUMENTO</a> </th>
            <th id="do_nrodoc" class="KT_sorter KT_col_do_nrodoc <?php echo $tso_listrslistdocssoporte1->getSortIcon('do_nrodoc'); ?>"> <a href="<?php echo $tso_listrslistdocssoporte1->getSortLink('do_nrodoc'); ?>">N&Uacute;MERO DOCUMENTO</a> </th>
            <th id="do_fechadoc" class="KT_sorter KT_col_do_fechadoc <?php echo $tso_listrslistdocssoporte1->getSortIcon('do_fechadoc'); ?>"> <a href="<?php echo $tso_listrslistdocssoporte1->getSortLink('do_fechadoc'); ?>">FECHA DOCUMENTO</a> </th>
            <th id="do_detalle" class="KT_sorter KT_col_do_detalle <?php echo $tso_listrslistdocssoporte1->getSortIcon('do_detalle'); ?>"> <a href="<?php echo $tso_listrslistdocssoporte1->getSortLink('do_detalle'); ?>">DETALLE</a> </th>
            <th id="doccnit" class="KT_sorter KT_col_doccnit <?php echo $tso_listrslistdocssoporte1->getSortIcon('doccnit'); ?>"> <a href="<?php echo $tso_listrslistdocssoporte1->getSortLink('doccnit'); ?>">/ RAZON SOCIAL / PROVEEDOR</a> </th>
            <th id="do_file" class="KT_sorter KT_col_do_file <?php echo $tso_listrslistdocssoporte1->getSortIcon('do_file'); ?>"> <a href="<?php echo $tso_listrslistdocssoporte1->getSortLink('do_file'); ?>">ANEXO</a> </th>
            <th>&nbsp;</th>
          </tr>
          <?php 
  // Show IF Conditional region3
  if (@$_SESSION['has_filter_tfi_listrslistdocssoporte1'] == 1) {
?>
            <tr class="KT_row_filter">
              <td>&nbsp;</td>
              <td><input type="text" name="tfi_listrslistdocssoporte1_doclasedoc" id="tfi_listrslistdocssoporte1_doclasedoc" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrslistdocssoporte1_doclasedoc']); ?>" size="10" maxlength="100" /></td>
              <td><input type="text" name="tfi_listrslistdocssoporte1_cd_nombredoc" id="tfi_listrslistdocssoporte1_cd_nombredoc" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrslistdocssoporte1_cd_nombredoc']); ?>" size="25" maxlength="20" /></td>
              <td><input type="text" name="tfi_listrslistdocssoporte1_do_nrodoc" id="tfi_listrslistdocssoporte1_do_nrodoc" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrslistdocssoporte1_do_nrodoc']); ?>" size="10" maxlength="100" /></td>
              <td><input type="text" name="tfi_listrslistdocssoporte1_do_fechadoc" id="tfi_listrslistdocssoporte1_do_fechadoc" value="<?php echo @$_SESSION['tfi_listrslistdocssoporte1_do_fechadoc']; ?>" size="10" maxlength="22" /></td>
              <td><input type="text" name="tfi_listrslistdocssoporte1_do_detalle" id="tfi_listrslistdocssoporte1_do_detalle" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrslistdocssoporte1_do_detalle']); ?>" size="30" maxlength="20" /></td>
              <td><input type="text" name="tfi_listrslistdocssoporte1_doccnit" id="tfi_listrslistdocssoporte1_doccnit" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrslistdocssoporte1_doccnit']); ?>" size="15" maxlength="20" /></td>
              <td><input type="text" name="tfi_listrslistdocssoporte1_do_file" id="tfi_listrslistdocssoporte1_do_file" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrslistdocssoporte1_do_file']); ?>" size="15" maxlength="100" /></td>
              <td><input type="submit" name="tfi_listrslistdocssoporte1" value="<?php echo NXT_getResource("Filter"); ?>" /></td>
            </tr>
            <?php } 
  // endif Conditional region3
?>
        </thead>
        <tbody>
          <?php if ($totalRows_rslistdocssoporte == 0) { // Show if recordset empty ?>
            <tr>
              <td colspan="9"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
            </tr>
            <?php } // Show if recordset empty ?>
          <?php if ($totalRows_rslistdocssoporte > 0) { // Show if recordset not empty ?>
            <?php do { ?>
              <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
                <td><input type="checkbox" name="kt_pk_q_master_gedocumentos" class="id_checkbox" value="<?php echo $row_rslistdocssoporte['doclasedoc_id']; ?>" />
                    <input type="hidden" name="doclasedoc_id" class="id_field" value="<?php echo $row_rslistdocssoporte['doclasedoc_id']; ?>" />
                    <a href="<?php echo $row_rslistdocssoporte['cd_link']; ?>?as_id=<?php echo $_GET['as_id']; ?>&amp;doclasedoc_id=<?php echo $row_rslistdocssoporte['doclasedoc_id']; ?>&amp;anio_id=<?php echo $_GET['anio_id']; ?>&amp;hash_id=<?php echo $_GET['hash_id']; ?>&amp;lnk=<?php echo $row_rslistdocssoporte['doclasedoc']; ?>&amp;numdocumento=<?php echo $row_rslistdocssoporte['doccnit']; ?>">
                    <?php 
// Show IF Conditional region5 
if (@$row_rslistdocssoporte['doclasedoc'] == 310 or $row_rslistdocssoporte['doclasedoc'] == 315 or $row_rslistdocssoporte['doclasedoc'] == 322) {
?>
                      <img src="325_add_mov_2.png" width="32" height="32" border="0" />
                      <?php } 
// endif Conditional region5
?></a></td>
                <td><div class="KT_col_doclasedoc"><?php echo KT_FormatForList($row_rslistdocssoporte['doclasedoc'], 10); ?><a href="<?php echo $row_rslistdocssoporte['cd_link']; ?>?as_id=<?php echo $_GET['as_id']; ?>&amp;doclasedoc_id=<?php echo $row_rslistdocssoporte['doclasedoc_id']; ?>&amp;anio_id=<?php echo $_GET['anio_id']; ?>&amp;hash_id=<?php echo $_GET['hash_id']; ?>"></a></div></td>
                <td><div class="KT_col_cd_nombredoc"><?php echo KT_FormatForList($row_rslistdocssoporte['cd_nombredoc'], 25); ?></div></td>
                <td><div class="KT_col_do_nrodoc"><?php echo KT_FormatForList($row_rslistdocssoporte['do_nrodoc'], 10); ?></div></td>
                <td><div class="KT_col_do_fechadoc"><?php echo KT_formatDate($row_rslistdocssoporte['do_fechadoc']); ?></div></td>
                <td><div class="KT_col_do_detalle">
                  <textarea name="textarea" id="textarea" cols="45" rows="3"><?php echo $row_rslistdocssoporte['do_detalle']; ?></textarea>
</div></td>
                <td><div class="KT_col_doccnit"><?php echo KT_FormatForList($row_rslistdocssoporte['doccnit'], 15); ?></div>
                  <?php echo $row_rslistdocssoporte['func_nombres']; ?></td>
                <td><div class="KT_col_do_file">
                  <?php 
// Show IF Conditional region4 
if (@$row_rslistdocssoporte['do_file'] != 0) {
?>
                    <a href="<?php echo $downloadObj1->getDownloadLink(); ?>"><?php echo $row_rslistdocssoporte['do_file']; ?></a>
                    <?php } 
// endif Conditional region4
?></div></td>
                <td></td>
              </tr>
              <?php } while ($row_rslistdocssoporte = mysql_fetch_assoc($rslistdocssoporte)); ?>
            <?php } // Show if recordset not empty ?>
        </tbody>
      </table>
      <div class="KT_bottomnav">
        <div>
          <?php
            $nav_listrslistdocssoporte1->Prepare();
            require("../includes/nav/NAV_Text_Navigation.inc.php");
          ?>
        </div>
      </div>
      <div class="KT_bottombuttons"><?php 
// Show IF Conditional region6 
if (@$_SESSION['kt_login_level'] == 8) {
?>
        <div class="KT_operations"> <a class="KT_edit_op_link" href="#" onclick="nxt_list_edit_link_form(this); return false;"><?php echo NXT_getResource("edit_all"); ?></a> <a class="KT_delete_op_link" href="#" onclick="nxt_list_delete_link_form(this); return false;"><?php echo NXT_getResource("delete_all"); ?></a> </div>
<span>&nbsp;</span>
        
          <select name="no_new" id="no_new">
            <option value="1">1</option>
          </select>
          
        <a class="KT_additem_op_link" href="a_docs_soporte_edit_e.php?as_id=<?php echo $_GET['as_id']; ?>&amp;KT_back=1&amp;anio_id=<?php echo $_GET['anio_id']; ?>&amp;hash_id=<?php echo $_GET['hash_id']; ?>" onclick="return nxt_list_additem(this)">Nuevo Egreso.</a><?php } 
// endif Conditional region6
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
mysql_free_result($rslistdocssoporte);

mysql_free_result($rsinfoasiento);
?>
