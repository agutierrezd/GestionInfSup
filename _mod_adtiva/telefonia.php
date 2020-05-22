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
$tfi_listrslistconsumo1 = new TFI_TableFilter($conn_oConnContratos, "tfi_listrslistconsumo1");
$tfi_listrslistconsumo1->addColumn("ref_numero", "STRING_TYPE", "ref_numero", "%");
$tfi_listrslistconsumo1->addColumn("ref_corte", "STRING_TYPE", "ref_corte", "%");
$tfi_listrslistconsumo1->addColumn("num_numero", "STRING_TYPE", "num_numero", "%");
$tfi_listrslistconsumo1->addColumn("num_dependencia", "STRING_TYPE", "num_dependencia", "%");
$tfi_listrslistconsumo1->addColumn("num_funcionario", "STRING_TYPE", "num_funcionario", "%");
$tfi_listrslistconsumo1->addColumn("num_fechaasigna", "DATE_TYPE", "num_fechaasigna", "=");
$tfi_listrslistconsumo1->addColumn("estado_name", "STRING_TYPE", "estado_name", "%");
$tfi_listrslistconsumo1->Execute();

// Sorter
$tso_listrslistconsumo1 = new TSO_TableSorter("rslistconsumo", "tso_listrslistconsumo1");
$tso_listrslistconsumo1->addColumn("ref_numero");
$tso_listrslistconsumo1->addColumn("ref_corte");
$tso_listrslistconsumo1->addColumn("num_numero");
$tso_listrslistconsumo1->addColumn("num_dependencia");
$tso_listrslistconsumo1->addColumn("num_funcionario");
$tso_listrslistconsumo1->addColumn("num_fechaasigna");
$tso_listrslistconsumo1->addColumn("estado_name");
$tso_listrslistconsumo1->setDefault("ref_numero");
$tso_listrslistconsumo1->Execute();

// Navigation
$nav_listrslistconsumo1 = new NAV_Regular("nav_listrslistconsumo1", "rslistconsumo", "../", $_SERVER['PHP_SELF'], 15);

mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rstipoconsumo = "SELECT * FROM eco_telefonia_tipoconsumo ORDER BY tipoc_name ASC";
$rstipoconsumo = mysql_query($query_rstipoconsumo, $oConnContratos) or die(mysql_error());
$row_rstipoconsumo = mysql_fetch_assoc($rstipoconsumo);
$totalRows_rstipoconsumo = mysql_num_rows($rstipoconsumo);

//NeXTenesio3 Special List Recordset
$maxRows_rslistconsumo = $_SESSION['max_rows_nav_listrslistconsumo1'];
$pageNum_rslistconsumo = 0;
if (isset($_GET['pageNum_rslistconsumo'])) {
  $pageNum_rslistconsumo = $_GET['pageNum_rslistconsumo'];
}
$startRow_rslistconsumo = $pageNum_rslistconsumo * $maxRows_rslistconsumo;

$colname_rslistconsumo = "-1";
if (isset($_GET['tipoc_id'])) {
  $colname_rslistconsumo = $_GET['tipoc_id'];
}
// Defining List Recordset variable
$NXTFilter_rslistconsumo = "1=1";
if (isset($_SESSION['filter_tfi_listrslistconsumo1'])) {
  $NXTFilter_rslistconsumo = $_SESSION['filter_tfi_listrslistconsumo1'];
}
// Defining List Recordset variable
$NXTSort_rslistconsumo = "ref_numero";
if (isset($_SESSION['sorter_tso_listrslistconsumo1'])) {
  $NXTSort_rslistconsumo = $_SESSION['sorter_tso_listrslistconsumo1'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);

$query_rslistconsumo = sprintf("SELECT * FROM q_tel_001 WHERE tipoc_id = %s AND  {$NXTFilter_rslistconsumo}  ORDER BY  {$NXTSort_rslistconsumo} ", GetSQLValueString($colname_rslistconsumo, "int"));
$query_limit_rslistconsumo = sprintf("%s LIMIT %d, %d", $query_rslistconsumo, $startRow_rslistconsumo, $maxRows_rslistconsumo);
$rslistconsumo = mysql_query($query_limit_rslistconsumo, $oConnContratos) or die(mysql_error());
$row_rslistconsumo = mysql_fetch_assoc($rslistconsumo);

if (isset($_GET['totalRows_rslistconsumo'])) {
  $totalRows_rslistconsumo = $_GET['totalRows_rslistconsumo'];
} else {
  $all_rslistconsumo = mysql_query($query_rslistconsumo);
  $totalRows_rslistconsumo = mysql_num_rows($all_rslistconsumo);
}
$totalPages_rslistconsumo = ceil($totalRows_rslistconsumo/$maxRows_rslistconsumo)-1;
//End NeXTenesio3 Special List Recordset

$nav_listrslistconsumo1->checkBoundries();
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
<link href="../demos.css" rel="stylesheet" type="text/css">
	<style>
		.ui-menu {
	position: absolute;
	width: 280px;
}
	</style>
<script>
	$(function() {
		$( "#rerun" )
			.button()
			.click(function() {
				alert( "Seleccionar tipo de consumo" );
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
  record_counter: true
}
</script>
<style type="text/css">
  /* Dynamic List row settings */
  .KT_col_ref_numero {width:140px; overflow:hidden;}
  .KT_col_ref_corte {width:140px; overflow:hidden;}
  .KT_col_num_numero {width:140px; overflow:hidden;}
  .KT_col_num_dependencia {width:140px; overflow:hidden;}
  .KT_col_num_funcionario {width:140px; overflow:hidden;}
  .KT_col_num_fechaasigna {width:140px; overflow:hidden;}
  .KT_col_estado_name {width:140px; overflow:hidden;}
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
		<button id="rerun">Tipo de consumo</button>
		<button id="select">Tipo</button>
	</div>
<ul>
		<?php do { ?>
		  <li><a href="telefonia.php?tipoc_id=<?php echo $row_rstipoconsumo['tipoc_id']; ?>"><?php echo $row_rstipoconsumo['tipoc_name']; ?></a></li>
		  <?php } while ($row_rstipoconsumo = mysql_fetch_assoc($rstipoconsumo)); ?>
          <li><a href="telefonia_add.php">Agregar registro</a></li>
	</ul>
</div>
<?php 
// Show IF Conditional region4 
if (@$_GET['tipoc_id'] != "") {
?>
  <table width="500" border="0" cellspacing="2" cellpadding="0">
    <tr>
      <td width="129" align="center"><img src="icons/_488_new.png" width="48" height="48" /></td>
      <td width="85">&nbsp;</td>
      <td width="212">&nbsp;</td>
      <td width="30">&nbsp;</td>
      <td width="32">&nbsp;</td>
    </tr>
    <tr>
      <td align="center">Agregar referencia</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
      </table>
  <?php } 
// endif Conditional region4
?><br />

<div class="KT_tng" id="listrslistconsumo1">
  <h1>Referencias y n&uacute;meros asociados
    <?php
  $nav_listrslistconsumo1->Prepare();
  require("../includes/nav/NAV_Text_Statistics.inc.php");
?>
  </h1>
  <div class="KT_tnglist">
    <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
      <div class="KT_options"> <a href="<?php echo $nav_listrslistconsumo1->getShowAllLink(); ?>"><?php echo NXT_getResource("Show"); ?>
            <?php 
  // Show IF Conditional region1
  if (@$_GET['show_all_nav_listrslistconsumo1'] == 1) {
?>
              <?php echo $_SESSION['default_max_rows_nav_listrslistconsumo1']; ?>
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
  if (@$_SESSION['has_filter_tfi_listrslistconsumo1'] == 1) {
?>
                  <a href="<?php echo $tfi_listrslistconsumo1->getResetFilterLink(); ?>"><?php echo NXT_getResource("Reset filter"); ?></a>
                  <?php 
  // else Conditional region2
  } else { ?>
                  <a href="<?php echo $tfi_listrslistconsumo1->getShowFilterLink(); ?>"><?php echo NXT_getResource("Show filter"); ?></a>
                  <?php } 
  // endif Conditional region2
?>
      </div>
      <table cellpadding="2" cellspacing="0" class="KT_tngtable">
        <thead>
          <tr class="KT_row_order">
            <th> <input type="checkbox" name="KT_selAll" id="KT_selAll"/>
            </th>
            <th id="ref_numero" class="KT_sorter KT_col_ref_numero <?php echo $tso_listrslistconsumo1->getSortIcon('ref_numero'); ?>"> <a href="<?php echo $tso_listrslistconsumo1->getSortLink('ref_numero'); ?>">REFERENCIA</a> </th>
            <th id="ref_corte" class="KT_sorter KT_col_ref_corte <?php echo $tso_listrslistconsumo1->getSortIcon('ref_corte'); ?>"> <a href="<?php echo $tso_listrslistconsumo1->getSortLink('ref_corte'); ?>">CORTE</a> </th>
            <th id="num_numero" class="KT_sorter KT_col_num_numero <?php echo $tso_listrslistconsumo1->getSortIcon('num_numero'); ?>"> <a href="<?php echo $tso_listrslistconsumo1->getSortLink('num_numero'); ?>">NUMERO ASOCIADO</a> </th>
            <th id="num_dependencia" class="KT_sorter KT_col_num_dependencia <?php echo $tso_listrslistconsumo1->getSortIcon('num_dependencia'); ?>"> <a href="<?php echo $tso_listrslistconsumo1->getSortLink('num_dependencia'); ?>">DEPENDENCIA</a> </th>
            <th id="num_funcionario" class="KT_sorter KT_col_num_funcionario <?php echo $tso_listrslistconsumo1->getSortIcon('num_funcionario'); ?>"> <a href="<?php echo $tso_listrslistconsumo1->getSortLink('num_funcionario'); ?>">RESPONSABLE</a> </th>
            <th id="num_fechaasigna" class="KT_sorter KT_col_num_fechaasigna <?php echo $tso_listrslistconsumo1->getSortIcon('num_fechaasigna'); ?>"> <a href="<?php echo $tso_listrslistconsumo1->getSortLink('num_fechaasigna'); ?>">FECHA ASIGNACION</a> </th>
            <th id="estado_name" class="KT_sorter KT_col_estado_name <?php echo $tso_listrslistconsumo1->getSortIcon('estado_name'); ?>"> <a href="<?php echo $tso_listrslistconsumo1->getSortLink('estado_name'); ?>">ESTADO</a> </th>
            <th>&nbsp;</th>
          </tr>
          <?php 
  // Show IF Conditional region3
  if (@$_SESSION['has_filter_tfi_listrslistconsumo1'] == 1) {
?>
            <tr class="KT_row_filter">
              <td>&nbsp;</td>
              <td><input type="text" name="tfi_listrslistconsumo1_ref_numero" id="tfi_listrslistconsumo1_ref_numero" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrslistconsumo1_ref_numero']); ?>" size="20" maxlength="20" /></td>
              <td><input type="text" name="tfi_listrslistconsumo1_ref_corte" id="tfi_listrslistconsumo1_ref_corte" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrslistconsumo1_ref_corte']); ?>" size="20" maxlength="20" /></td>
              <td><input type="text" name="tfi_listrslistconsumo1_num_numero" id="tfi_listrslistconsumo1_num_numero" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrslistconsumo1_num_numero']); ?>" size="20" maxlength="20" /></td>
              <td><input type="text" name="tfi_listrslistconsumo1_num_dependencia" id="tfi_listrslistconsumo1_num_dependencia" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrslistconsumo1_num_dependencia']); ?>" size="20" maxlength="20" /></td>
              <td><input type="text" name="tfi_listrslistconsumo1_num_funcionario" id="tfi_listrslistconsumo1_num_funcionario" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrslistconsumo1_num_funcionario']); ?>" size="20" maxlength="20" /></td>
              <td><input type="text" name="tfi_listrslistconsumo1_num_fechaasigna" id="tfi_listrslistconsumo1_num_fechaasigna" value="<?php echo @$_SESSION['tfi_listrslistconsumo1_num_fechaasigna']; ?>" size="10" maxlength="22" /></td>
              <td><input type="text" name="tfi_listrslistconsumo1_estado_name" id="tfi_listrslistconsumo1_estado_name" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrslistconsumo1_estado_name']); ?>" size="20" maxlength="20" /></td>
              <td><input type="submit" name="tfi_listrslistconsumo1" value="<?php echo NXT_getResource("Filter"); ?>" /></td>
            </tr>
            <?php } 
  // endif Conditional region3
?>
        </thead>
        <tbody>
          <?php if ($totalRows_rslistconsumo == 0) { // Show if recordset empty ?>
            <tr>
              <td colspan="9"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
            </tr>
            <?php } // Show if recordset empty ?>
          <?php if ($totalRows_rslistconsumo > 0) { // Show if recordset not empty ?>
            <?php do { ?>
              <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
                <td><input type="checkbox" name="kt_pk_" class="id_checkbox" value="<?php echo $row_rslistconsumo['ref_id']; ?>" />
                    <input type="hidden" name="ref_id" class="id_field" value="<?php echo $row_rslistconsumo['ref_id']; ?>" />
                </td>
                <td><div class="KT_col_ref_numero"><?php echo KT_FormatForList($row_rslistconsumo['ref_numero'], 20); ?></div></td>
                <td><div class="KT_col_ref_corte"><?php echo KT_FormatForList($row_rslistconsumo['ref_corte'], 20); ?></div></td>
                <td><div class="KT_col_num_numero"><?php echo KT_FormatForList($row_rslistconsumo['num_numero'], 20); ?></div></td>
                <td><div class="KT_col_num_dependencia"><?php echo $row_rslistconsumo['num_dependencia']; ?></div></td>
                <td><div class="KT_col_num_funcionario"><?php echo $row_rslistconsumo['num_funcionario']; ?></div></td>
                <td><div class="KT_col_num_fechaasigna"><?php echo KT_formatDate($row_rslistconsumo['num_fechaasigna']); ?></div></td>
                <td><div class="KT_col_estado_name"><?php echo KT_FormatForList($row_rslistconsumo['estado_name'], 20); ?></div></td>
                <td><a class="KT_edit_link" href="telefonia_edit_2.php?ref_id=<?php echo $row_rslistconsumo['ref_id']; ?>&amp;KT_back=1"><?php echo NXT_getResource("edit_one"); ?></a> <a class="KT_delete_link" href="#delete"><?php echo NXT_getResource("delete_one"); ?></a> </td>
              </tr>
              <?php } while ($row_rslistconsumo = mysql_fetch_assoc($rslistconsumo)); ?>
            <?php } // Show if recordset not empty ?>
        </tbody>
      </table>
      <div class="KT_bottomnav">
        <div>
          <?php
            $nav_listrslistconsumo1->Prepare();
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
        <a class="KT_additem_op_link" href="telefonia_edit_2.php?KT_back=1" onclick="return nxt_list_additem(this)"><?php echo NXT_getResource("add new"); ?></a> </div>
    </form>
  </div>
  <br class="clearfixplain" />
</div>
<p>&nbsp;</p>
<table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>
<?php
  mxi_includes_start("../inc_foot.php");
  require(basename("../inc_foot.php"));
  mxi_includes_end();
?>
</body>
</html>
<?php
mysql_free_result($rstipoconsumo);

mysql_free_result($rslistconsumo);
?>
