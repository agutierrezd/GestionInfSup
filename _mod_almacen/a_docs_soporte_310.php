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
$tfi_listrsinfoasignados1 = new TFI_TableFilter($conn_oConnAlmacen, "tfi_listrsinfoasignados1");
$tfi_listrsinfoasignados1->addColumn("mcdalmacen", "STRING_TYPE", "mcdalmacen", "%");
$tfi_listrsinfoasignados1->addColumn("mcdcuenta", "STRING_TYPE", "mcdcuenta", "%");
$tfi_listrsinfoasignados1->addColumn("ca_nomcuenta", "STRING_TYPE", "ca_nomcuenta", "%");
$tfi_listrsinfoasignados1->addColumn("mcdcodelem", "NUMERIC_TYPE", "mcdcodelem", "=");
$tfi_listrsinfoasignados1->addColumn("ec_nomelemento", "STRING_TYPE", "ec_nomelemento", "%");
$tfi_listrsinfoasignados1->addColumn("QSOLICITADO", "NUMERIC_TYPE", "QSOLICITADO", "=");
$tfi_listrsinfoasignados1->addColumn("VRUNITARIO", "NUMERIC_TYPE", "VRUNITARIO", "=");
$tfi_listrsinfoasignados1->addColumn("VRTOTAL", "NUMERIC_TYPE", "VRTOTAL", "=");
$tfi_listrsinfoasignados1->Execute();

// Sorter
$tso_listrsinfoasignados1 = new TSO_TableSorter("rsinfoasignados", "tso_listrsinfoasignados1");
$tso_listrsinfoasignados1->addColumn("mcdalmacen");
$tso_listrsinfoasignados1->addColumn("mcdcuenta");
$tso_listrsinfoasignados1->addColumn("ca_nomcuenta");
$tso_listrsinfoasignados1->addColumn("mcdcodelem");
$tso_listrsinfoasignados1->addColumn("ec_nomelemento");
$tso_listrsinfoasignados1->addColumn("QSOLICITADO");
$tso_listrsinfoasignados1->addColumn("VRUNITARIO");
$tso_listrsinfoasignados1->addColumn("VRTOTAL");
$tso_listrsinfoasignados1->setDefault("mcdalmacen");
$tso_listrsinfoasignados1->Execute();

// Navigation
$nav_listrsinfoasignados1 = new NAV_Regular("nav_listrsinfoasignados1", "rsinfoasignados", "../", $_SERVER['PHP_SELF'], 25);

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

$colname_rsinfousuario = "-1";
if (isset($_GET['numdocumento'])) {
  $colname_rsinfousuario = $_GET['numdocumento'];
}
mysql_select_db($database_oConnAlmacen, $oConnAlmacen);
$query_rsinfousuario = sprintf("SELECT * FROM q_func_prov_master WHERE func_doc = %s", GetSQLValueString($colname_rsinfousuario, "text"));
$rsinfousuario = mysql_query($query_rsinfousuario, $oConnAlmacen) or die(mysql_error());
$row_rsinfousuario = mysql_fetch_assoc($rsinfousuario);
$totalRows_rsinfousuario = mysql_num_rows($rsinfousuario);

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
$maxRows_rsinfoasignados = $_SESSION['max_rows_nav_listrsinfoasignados1'];
$pageNum_rsinfoasignados = 0;
if (isset($_GET['pageNum_rsinfoasignados'])) {
  $pageNum_rsinfoasignados = $_GET['pageNum_rsinfoasignados'];
}
$startRow_rsinfoasignados = $pageNum_rsinfoasignados * $maxRows_rsinfoasignados;

$colname_rsinfoasignados = "-1";
if (isset($_GET['doclasedoc_id'])) {
  $colname_rsinfoasignados = $_GET['doclasedoc_id'];
}
// Defining List Recordset variable
$NXTFilter_rsinfoasignados = "1=1";
if (isset($_SESSION['filter_tfi_listrsinfoasignados1'])) {
  $NXTFilter_rsinfoasignados = $_SESSION['filter_tfi_listrsinfoasignados1'];
}
// Defining List Recordset variable
$NXTSort_rsinfoasignados = "mcdalmacen";
if (isset($_SESSION['sorter_tso_listrsinfoasignados1'])) {
  $NXTSort_rsinfoasignados = $_SESSION['sorter_tso_listrsinfoasignados1'];
}
mysql_select_db($database_oConnAlmacen, $oConnAlmacen);

$query_rsinfoasignados = sprintf("SELECT * FROM q_almovconsdia_egreso_asignado_global WHERE sys_doclasedoc_id_fk = %s AND  {$NXTFilter_rsinfoasignados}  ORDER BY  {$NXTSort_rsinfoasignados} ", GetSQLValueString($colname_rsinfoasignados, "int"));
$query_limit_rsinfoasignados = sprintf("%s LIMIT %d, %d", $query_rsinfoasignados, $startRow_rsinfoasignados, $maxRows_rsinfoasignados);
$rsinfoasignados = mysql_query($query_limit_rsinfoasignados, $oConnAlmacen) or die(mysql_error());
$row_rsinfoasignados = mysql_fetch_assoc($rsinfoasignados);

if (isset($_GET['totalRows_rsinfoasignados'])) {
  $totalRows_rsinfoasignados = $_GET['totalRows_rsinfoasignados'];
} else {
  $all_rsinfoasignados = mysql_query($query_rsinfoasignados);
  $totalRows_rsinfoasignados = mysql_num_rows($all_rsinfoasignados);
}
$totalPages_rsinfoasignados = ceil($totalRows_rsinfoasignados/$maxRows_rsinfoasignados)-1;
//End NeXTenesio3 Special List Recordset

$nav_listrsinfoasignados1->checkBoundries();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:: Contrataci&oacute;n :: MinCIT ::.</title>
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
  duplicate_buttons: false,
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
  .KT_col_QSOLICITADO {width:140px; overflow:hidden;}
  .KT_col_VRUNITARIO {width:140px; overflow:hidden;}
  .KT_col_VRTOTAL {width:140px; overflow:hidden;}
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
</table>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
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
        <td class="frmtablabody"><?php echo $row_rsinfogendocumentos['do_nrodoc']; ?></td>
        <td class="frmtablabody"><?php echo $row_rsinfogendocumentos['doccnit']; ?></td>
      </tr>
      <tr>
        <td class="frmtablahead">NOMBRES</td>
        <td class="frmtablahead">DOCUMENTO</td>
        <td class="frmtablahead">DEPENDENCIA</td>
      </tr>
      <tr>
        <td class="frmtablabody"><?php echo $row_rsinfousuario['func_nombres']; ?></td>
        <td class="frmtablabody"><?php echo $row_rsinfousuario['func_doc']; ?></td>
        <td class="frmtablabody"><?php echo $row_rsinfoalmovtodia['de_nomdep']; ?></td>
      </tr>
      <tr>
        <td colspan="3" class="frmtablahead">DETALLE</td>
      </tr>
      <tr>
        <td colspan="3" class="frmtablabody"><?php echo $row_rsinfogendocumentos['do_detalle']; ?></td>
      </tr>
      <tr>
        <td colspan="2"><?php 
// Show IF Conditional region5 
if (@$_SESSION['kt_login_level'] == 8) {
?>
            <table width="166" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="84" align="center">&nbsp;</td>
                <td width="82" align="center">&nbsp;</td>
              </tr>
              <tr>
                <td align="center"><a href="../_gendraft/htmltodocx/_comp_egreso_cons.php?doclasedoc_id=<?php echo $row_rsinfogendocumentos['doclasedoc_id']; ?>&amp;numdocumento=<?php echo $row_rsinfousuario['func_doc']; ?>"><img src="321_gencomp.png" width="32" height="32" border="0" /></a></td>
                <td align="center"><a href="x_legaliza.php?almovtodia_id=<?php echo $row_rsinfoalmovtodia['almovtodia_id']; ?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )">
                  <?php 
// Show IF Conditional region3 
if (@$row_rsinfoalmovtodia['md_legalizado'] == "N") {
?>
                    <img src="325_legaliza.png" width="32" height="32" border="0" />
                    <?php } 
// endif Conditional region3
?>
                </a></td>
              </tr>
              <tr>
                <td align="center">Generar comprobante</td>
                <td align="center"><?php 
// Show IF Conditional region4 
if (@$row_rsinfoalmovtodia['md_legalizado'] == "N") {
?>
                      Legalizar documento
                      <?php } 
// endif Conditional region4
?>
                </td>
              </tr>
            </table>
            <?php } 
// endif Conditional region5
?></td>
        <td><?php echo $row_rsinfoalmovtodia['legal_name']; ?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><?php 
// Show IF Conditional region2 
if (@$row_rsinfoalmovtodia['md_legalizado'] == "N" and $_SESSION['kt_login_level'] == 8) {
?>
        <table width="80%" border="0" align="center" cellpadding="0" cellspacing="3">
          <tr>
            <td><form id="form2" name="form2" method="get" action="a_docs_soporte_310_vinc.php?as_id=<?php echo $_GET['as_id']; ?>&amp;doclasedoc_id=<?php echo $row_rsinfogendocumentos['doclasedoc_id']; ?>&amp;anio_id=<?php echo $_GET['anio_id']; ?>&amp;hash_id=<?php echo $_GET['hash_id']; ?>&amp;lnk=<?php echo $_GET['lnk']; ?>&amp;numdocumento=<?php echo $_GET['numdocumento']; ?>">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td>Nombre o c&oacute;digo del elemento</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><input name="qfind" type="text" id="qfind" size="40" />
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
        </table>
        <?php } 
// endif Conditional region2
?></td>
  </tr>
</table>
<p>&nbsp;</p>
<div class="KT_tng" id="listrsinfoasignados1">
  <h1> ELEMENTOS REGISTRADOS
    <?php
  $nav_listrsinfoasignados1->Prepare();
  require("../includes/nav/NAV_Text_Statistics.inc.php");
?>
  </h1>
  <div class="KT_tnglist">
    <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
      <div class="KT_options"> <a href="<?php echo $nav_listrsinfoasignados1->getShowAllLink(); ?>"><?php echo NXT_getResource("Show"); ?>
        <?php 
  // Show IF Conditional region1
  if (@$_GET['show_all_nav_listrsinfoasignados1'] == 1) {
?>
          <?php echo $_SESSION['default_max_rows_nav_listrsinfoasignados1']; ?>
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
            <th id="mcdalmacen" class="KT_sorter KT_col_mcdalmacen <?php echo $tso_listrsinfoasignados1->getSortIcon('mcdalmacen'); ?>"> <a href="<?php echo $tso_listrsinfoasignados1->getSortLink('mcdalmacen'); ?>">ALMACEN</a> </th>
            <th id="mcdcuenta" class="KT_sorter KT_col_mcdcuenta <?php echo $tso_listrsinfoasignados1->getSortIcon('mcdcuenta'); ?>"> <a href="<?php echo $tso_listrsinfoasignados1->getSortLink('mcdcuenta'); ?>">COD. CUENTA</a> </th>
            <th id="ca_nomcuenta" class="KT_sorter KT_col_ca_nomcuenta <?php echo $tso_listrsinfoasignados1->getSortIcon('ca_nomcuenta'); ?>"> <a href="<?php echo $tso_listrsinfoasignados1->getSortLink('ca_nomcuenta'); ?>">NOMBRE CUENTA</a> </th>
            <th id="mcdcodelem" class="KT_sorter KT_col_mcdcodelem <?php echo $tso_listrsinfoasignados1->getSortIcon('mcdcodelem'); ?>"> <a href="<?php echo $tso_listrsinfoasignados1->getSortLink('mcdcodelem'); ?>">COD. ELEMENTO</a> </th>
            <th id="ec_nomelemento" class="KT_sorter KT_col_ec_nomelemento <?php echo $tso_listrsinfoasignados1->getSortIcon('ec_nomelemento'); ?>"> <a href="<?php echo $tso_listrsinfoasignados1->getSortLink('ec_nomelemento'); ?>">NOMBRE ELEMENTO</a> </th>
            <th id="QSOLICITADO" class="KT_sorter KT_col_QSOLICITADO <?php echo $tso_listrsinfoasignados1->getSortIcon('QSOLICITADO'); ?>"> <a href="<?php echo $tso_listrsinfoasignados1->getSortLink('QSOLICITADO'); ?>">CANTIDAD ASIGNADA</a> </th>
            <th id="VRUNITARIO" class="KT_sorter KT_col_VRUNITARIO <?php echo $tso_listrsinfoasignados1->getSortIcon('VRUNITARIO'); ?>"> <a href="<?php echo $tso_listrsinfoasignados1->getSortLink('VRUNITARIO'); ?>">VALOR UNITARIO</a> </th>
            <th id="VRTOTAL" class="KT_sorter KT_col_VRTOTAL <?php echo $tso_listrsinfoasignados1->getSortIcon('VRTOTAL'); ?>"> <a href="<?php echo $tso_listrsinfoasignados1->getSortLink('VRTOTAL'); ?>">VALOR TOTAL</a> </th>
            <th>&nbsp;</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($totalRows_rsinfoasignados == 0) { // Show if recordset empty ?>
            <tr>
              <td colspan="10"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
            </tr>
            <?php } // Show if recordset empty ?>
          <?php if ($totalRows_rsinfoasignados > 0) { // Show if recordset not empty ?>
            <?php do { ?>
              <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
                <td><input type="hidden" name="almovconsdia_id" class="id_field" value="<?php echo $row_rsinfoasignados['almovconsdia_id']; ?>" />
                </td>
                <td><div class="KT_col_mcdalmacen"><?php echo KT_FormatForList($row_rsinfoasignados['mcdalmacen'], 20); ?></div></td>
                <td><div class="KT_col_mcdcuenta"><?php echo KT_FormatForList($row_rsinfoasignados['mcdcuenta'], 20); ?></div></td>
                <td><div class="KT_col_ca_nomcuenta"><?php echo KT_FormatForList($row_rsinfoasignados['ca_nomcuenta'], 20); ?></div></td>
                <td><div class="KT_col_mcdcodelem"><?php echo KT_FormatForList($row_rsinfoasignados['mcdcodelem'], 20); ?></div></td>
                <td><textarea name="textarea" id="textarea" cols="35" rows="2"><?php echo $row_rsinfoasignados['ec_nomelemento']; ?></textarea></td>
                <td><div class="KT_col_QSOLICITADO"><?php echo KT_FormatForList($row_rsinfoasignados['QSOLICITADO'], 20); ?></div></td>
                <td align="right"><div class="KT_col_VRUNITARIO"><?php echo number_format($row_rsinfoasignados['VRUNITARIO'],2,',','.'); ?></div></td>
                <td align="right"><div class="KT_col_VRTOTAL"><?php echo number_format($row_rsinfoasignados['VRTOTAL'],2,',','.'); ?></div></td>
                <td>&nbsp;</td>
              </tr>
              <?php } while ($row_rsinfoasignados = mysql_fetch_assoc($rsinfoasignados)); ?>
            <?php } // Show if recordset not empty ?>
        </tbody>
      </table>
      <div class="KT_bottomnav">
        <div>
          <?php
            $nav_listrsinfoasignados1->Prepare();
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

mysql_free_result($rsinfousuario);

mysql_free_result($rsinfoalmovtodia);

mysql_free_result($rsinfoasignados);
?>
