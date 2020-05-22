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
$tfi_listrsdocvinc1 = new TFI_TableFilter($conn_oConnAlmacen, "tfi_listrsdocvinc1");
$tfi_listrsdocvinc1->addColumn("midalmacen", "STRING_TYPE", "midalmacen", "%");
$tfi_listrsdocvinc1->addColumn("midcuenta", "STRING_TYPE", "midcuenta", "%");
$tfi_listrsdocvinc1->addColumn("midcodelem", "NUMERIC_TYPE", "midcodelem", "=");
$tfi_listrsdocvinc1->addColumn("ma_nommarca", "STRING_TYPE", "ma_nommarca", "%");
$tfi_listrsdocvinc1->addColumn("midnroplaca", "STRING_TYPE", "midnroplaca", "%");
$tfi_listrsdocvinc1->addColumn("midnroserie", "STRING_TYPE", "midnroserie", "%");
$tfi_listrsdocvinc1->addColumn("um_nomunimed", "STRING_TYPE", "um_nomunimed", "%");
$tfi_listrsdocvinc1->addColumn("mid_valormovto", "NUMERIC_TYPE", "mid_valormovto", "=");
$tfi_listrsdocvinc1->Execute();

// Sorter
$tso_listrsdocvinc1 = new TSO_TableSorter("rsdocvinc", "tso_listrsdocvinc1");
$tso_listrsdocvinc1->addColumn("midalmacen");
$tso_listrsdocvinc1->addColumn("midcuenta");
$tso_listrsdocvinc1->addColumn("midcodelem");
$tso_listrsdocvinc1->addColumn("ma_nommarca");
$tso_listrsdocvinc1->addColumn("midnroplaca");
$tso_listrsdocvinc1->addColumn("midnroserie");
$tso_listrsdocvinc1->addColumn("um_nomunimed");
$tso_listrsdocvinc1->addColumn("mid_valormovto");
$tso_listrsdocvinc1->setDefault("midalmacen");
$tso_listrsdocvinc1->Execute();

// Navigation
$nav_listrsdocvinc1 = new NAV_Regular("nav_listrsdocvinc1", "rsdocvinc", "../", $_SERVER['PHP_SELF'], 25);

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

$colname_rsctrlleg = "-1";
if (isset($_GET['doclasedoc_id'])) {
  $colname_rsctrlleg = $_GET['doclasedoc_id'];
}
mysql_select_db($database_oConnAlmacen, $oConnAlmacen);
$query_rsctrlleg = sprintf("SELECT * FROM q_ctrl_aldevindiv_lagaliza WHERE di_nroplacastma = %s", GetSQLValueString($colname_rsctrlleg, "text"));
$rsctrlleg = mysql_query($query_rsctrlleg, $oConnAlmacen) or die(mysql_error());
$row_rsctrlleg = mysql_fetch_assoc($rsctrlleg);
$totalRows_rsctrlleg = mysql_num_rows($rsctrlleg);

//NeXTenesio3 Special List Recordset
$maxRows_rsdocvinc = $_SESSION['max_rows_nav_listrsdocvinc1'];
$pageNum_rsdocvinc = 0;
if (isset($_GET['pageNum_rsdocvinc'])) {
  $pageNum_rsdocvinc = $_GET['pageNum_rsdocvinc'];
}
$startRow_rsdocvinc = $pageNum_rsdocvinc * $maxRows_rsdocvinc;

$colname_rsdocvinc = "-1";
if (isset($_GET['doclasedoc_id'])) {
  $colname_rsdocvinc = $_GET['doclasedoc_id'];
}
// Defining List Recordset variable
$NXTFilter_rsdocvinc = "1=1";
if (isset($_SESSION['filter_tfi_listrsdocvinc1'])) {
  $NXTFilter_rsdocvinc = $_SESSION['filter_tfi_listrsdocvinc1'];
}
// Defining List Recordset variable
$NXTSort_rsdocvinc = "midalmacen";
if (isset($_SESSION['sorter_tso_listrsdocvinc1'])) {
  $NXTSort_rsdocvinc = $_SESSION['sorter_tso_listrsdocvinc1'];
}
mysql_select_db($database_oConnAlmacen, $oConnAlmacen);

$query_rsdocvinc = sprintf("SELECT * FROM q_almacen_322_bajas WHERE doclasedoc_id_fk = %s AND  {$NXTFilter_rsdocvinc} ORDER BY {$NXTSort_rsdocvinc} ", GetSQLValueString($colname_rsdocvinc, "int"));
$query_limit_rsdocvinc = sprintf("%s LIMIT %d, %d", $query_rsdocvinc, $startRow_rsdocvinc, $maxRows_rsdocvinc);
$rsdocvinc = mysql_query($query_limit_rsdocvinc, $oConnAlmacen) or die(mysql_error());
$row_rsdocvinc = mysql_fetch_assoc($rsdocvinc);

if (isset($_GET['totalRows_rsdocvinc'])) {
  $totalRows_rsdocvinc = $_GET['totalRows_rsdocvinc'];
} else {
  $all_rsdocvinc = mysql_query($query_rsdocvinc);
  $totalRows_rsdocvinc = mysql_num_rows($all_rsdocvinc);
}
$totalPages_rsdocvinc = ceil($totalRows_rsdocvinc/$maxRows_rsdocvinc)-1;
//End NeXTenesio3 Special List Recordset

$nav_listrsdocvinc1->checkBoundries();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
function dmxCalendarFormat($dt,$format) { //v1.01
  if (!is_null($dt)) {
    if ($dt != '') {
      $strDate = is_numeric($dt) ? $dt : strtotime($dt);
      $strRet = $format;
      $strRet = preg_replace('/dd/i','d',$strRet);
      $strRet = preg_replace('/mm/i','m',$strRet);
      $strRet = preg_replace('/yy/i','Y',$strRet);
      $strRet = preg_replace('/hh/i','H',$strRet);
      $strRet = preg_replace('/nn/i','i',$strRet);
      $strRet = preg_replace('/ss/i','s',$strRet);
      return date($strRet,$strDate);
    }
  }
  return '';
}
?>
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
  .KT_col_midalmacen {width:140px; overflow:hidden;}
  .KT_col_midcuenta {width:140px; overflow:hidden;}
  .KT_col_midcodelem {width:140px; overflow:hidden;}
  .KT_col_ma_nommarca {width:140px; overflow:hidden;}
  .KT_col_midnroplaca {width:140px; overflow:hidden;}
  .KT_col_midnroserie {width:140px; overflow:hidden;}
  .KT_col_um_nomunimed {width:140px; overflow:hidden;}
  .KT_col_mid_valormovto {width:140px; overflow:hidden;}
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
        <td width="37%" class="frmtablahead">NUMERO DE ASIENTO</td>
        <td width="29%" class="frmtablahead">FECHA</td>
        <td width="34%" class="frmtablahead">ALMACEN</td>
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
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><?php echo $row_rsctrlleg['qtyc']; ?></td>
      </tr>
      <tr>
        <td><?php 
// Show IF Conditional region7 
if (@$_SESSION['kt_login_level'] == 8) {
?>
            <table width="150" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="center"><a href="../_gendraft/htmltodocx/_comp_egreso_baja.php?doclasedoc_id=<?php echo $row_rsinfogendocumentos['doclasedoc_id']; ?>&amp;numdocumento=<?php echo $row_rsinfousuario['func_doc']; ?>"><img src="321_gencomp.png" width="32" height="32" border="0" /></a></td>
                <td align="center"><a href="x_legaliza.php?almovtodia_id=<?php echo $row_rsinfoalmovtodia['almovtodia_id']; ?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )">
                <?php 
// Show IF Conditional region5 
if (@$row_rsctrlleg['qtyc'] == @$totalRows_rsdocvinc) {
?>
                  <img src="325_legaliza.png" width="32" height="32" border="0" />
                  <?php } 
// endif Conditional region5
?>
                </a></td>
              </tr>
              <tr>
                <td align="center">Generar comprobante</td>
                <td align="center"><?php 
// Show IF Conditional region6 
if (@$row_rsctrlleg['qtyc'] == @$totalRows_rsdocvinc) {
?>
                    Legalizar moviento
  <?php } 
// endif Conditional region6
?>
                </td>
              </tr>
            </table>
            <?php } 
// endif Conditional region7
?></td>
        <td>&nbsp;</td>
        <td class="titlemsg2"><?php echo $row_rsinfoalmovtodia['legal_name']; ?></td>
      </tr>
      <tr>
        <td colspan="3"><hr /></td>
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
            <td><form id="form2" name="form2" method="get" action="a_docs_soporte_322_vinc.php?as_id=<?php echo $_GET['as_id']; ?>&amp;doclasedoc_id=<?php echo $row_rsinfogendocumentos['doclasedoc_id']; ?>&amp;anio_id=<?php echo $_GET['anio_id']; ?>&amp;hash_id=<?php echo $_GET['hash_id']; ?>&amp;lnk=<?php echo $_GET['lnk']; ?>&amp;numdocumento=<?php echo $_GET['numdocumento']; ?>">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="19%">N&uacute;mero de placa:</td>
                    <td width="31%"><input type="text" name="plaque" id="plaque" />
                        <input name="as_id" type="hidden" id="as_id" value="<?php echo $_GET['as_id']; ?>" />
                        <input name="doclasedoc_id" type="hidden" id="doclasedoc_id" value="<?php echo $_GET['doclasedoc_id']; ?>" />
                        <input name="anio_id" type="hidden" id="anio_id" value="<?php echo $_GET['anio_id']; ?>" />
                        <input name="hash_id" type="hidden" id="hash_id" value="<?php echo $_GET['hash_id']; ?>" />
                        <input name="lnk" type="hidden" id="lnk" value="<?php echo $_GET['lnk']; ?>" />
                        <input name="numdocumento" type="hidden" id="numdocumento" value="<?php echo $_GET['numdocumento']; ?>" />
                        <input name="consecutivo" type="hidden" id="consecutivo" value="<?php echo $row_rsinfogendocumentos['do_nrodoc']; ?>" />
                        <input name="fechaasiento" type="hidden" id="fechaasiento" value="<?php echo  dmxCalendarFormat($row_rsinfogendocumentos['do_fechadoc'], "yy-mm-dd") ; ?>" /></td>
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
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<div class="KT_tng" id="listrsdocvinc1">
  <h1> Registros vinculados al comprobante
    <?php
  $nav_listrsdocvinc1->Prepare();
  require("../includes/nav/NAV_Text_Statistics.inc.php");
?>
  </h1>
  <div class="KT_tnglist">
    <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
      <div class="KT_options"> <a href="<?php echo $nav_listrsdocvinc1->getShowAllLink(); ?>"><?php echo NXT_getResource("Show"); ?>
          <?php 
  // Show IF Conditional region1
  if (@$_GET['show_all_nav_listrsdocvinc1'] == 1) {
?>
          <?php echo $_SESSION['default_max_rows_nav_listrsdocvinc1']; ?>
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
            <th> <input type="checkbox" name="KT_selAll" id="KT_selAll"/>            </th>
            <th id="midalmacen" class="KT_sorter KT_col_midalmacen <?php echo $tso_listrsdocvinc1->getSortIcon('midalmacen'); ?>"> <a href="<?php echo $tso_listrsdocvinc1->getSortLink('midalmacen'); ?>">ALMACEN</a> </th>
            <th id="midcuenta" class="KT_sorter KT_col_midcuenta <?php echo $tso_listrsdocvinc1->getSortIcon('midcuenta'); ?>"> <a href="<?php echo $tso_listrsdocvinc1->getSortLink('midcuenta'); ?>">CUENTA</a> </th>
            <th id="midcodelem" class="KT_sorter KT_col_midcodelem <?php echo $tso_listrsdocvinc1->getSortIcon('midcodelem'); ?>"> <a href="<?php echo $tso_listrsdocvinc1->getSortLink('midcodelem'); ?>">CODIGO</a> </th>
            <th id="ma_nommarca" class="KT_sorter KT_col_ma_nommarca <?php echo $tso_listrsdocvinc1->getSortIcon('ma_nommarca'); ?>"> <a href="<?php echo $tso_listrsdocvinc1->getSortLink('ma_nommarca'); ?>">MARCA</a> </th>
            <th id="midnroplaca" class="KT_sorter KT_col_midnroplaca <?php echo $tso_listrsdocvinc1->getSortIcon('midnroplaca'); ?>"> <a href="<?php echo $tso_listrsdocvinc1->getSortLink('midnroplaca'); ?>">PLACA</a> </th>
            <th id="midnroserie" class="KT_sorter KT_col_midnroserie <?php echo $tso_listrsdocvinc1->getSortIcon('midnroserie'); ?>"> <a href="<?php echo $tso_listrsdocvinc1->getSortLink('midnroserie'); ?>">SERIE</a> </th>
            <th id="um_nomunimed" class="KT_sorter KT_col_um_nomunimed <?php echo $tso_listrsdocvinc1->getSortIcon('um_nomunimed'); ?>"> <a href="<?php echo $tso_listrsdocvinc1->getSortLink('um_nomunimed'); ?>">PRESENTACION</a> </th>
            <th id="mid_valormovto" class="KT_sorter KT_col_mid_valormovto <?php echo $tso_listrsdocvinc1->getSortIcon('mid_valormovto'); ?>"> <a href="<?php echo $tso_listrsdocvinc1->getSortLink('mid_valormovto'); ?>">VALOR MOVIMIENTO</a> </th>
            <th>&nbsp;</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($totalRows_rsdocvinc == 0) { // Show if recordset empty ?>
          <tr>
            <td colspan="10"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
          </tr>
          <?php } // Show if recordset empty ?>
          <?php if ($totalRows_rsdocvinc > 0) { // Show if recordset not empty ?>
          <?php do { ?>
          <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
            <td><input type="checkbox" name="kt_pk_q_almacen_600_700" class="id_checkbox" value="<?php echo $row_rsdocvinc['almovinddia_id']; ?>" />
                <input type="hidden" name="almovinddia_id" class="id_field" value="<?php echo $row_rsdocvinc['almovinddia_id']; ?>" />            </td>
            <td><div class="KT_col_midalmacen"><?php echo KT_FormatForList($row_rsdocvinc['midalmacen'], 20); ?></div></td>
            <td><textarea name="textarea" id="textarea" cols="30" rows="2">[<?php echo $row_rsdocvinc['midcuenta']; ?>]-<?php echo $row_rsdocvinc['ca_nomcuenta']; ?></textarea></td>
            <td><textarea name="textarea2" id="textarea2" cols="45" rows="2">[<?php echo $row_rsdocvinc['midcodelem']; ?>]-<?php echo $row_rsdocvinc['ed_nomelemento']; ?></textarea></td>
            <td><div class="KT_col_ma_nommarca"><?php echo KT_FormatForList($row_rsdocvinc['ma_nommarca'], 20); ?></div></td>
            <td><div class="titlemsg3Gray"><?php echo KT_FormatForList($row_rsdocvinc['midnroplaca'], 20); ?></div></td>
            <td><div class="KT_col_midnroserie"><?php echo KT_FormatForList($row_rsdocvinc['midnroserie'], 20); ?></div></td>
            <td><div class="KT_col_um_nomunimed"><?php echo KT_FormatForList($row_rsdocvinc['um_nomunimed'], 20); ?></div></td>
            <td align="right"><div class="KT_col_mid_valormovto"><?php echo number_format($row_rsdocvinc['mid_valormovto'],2,',','.'); ?></div></td>
            <td><?php 
// Show IF Conditional region4 
if (@$row_rsinfoalmovtodia['md_legalizado'] == "N" and $_SESSION['kt_login_level'] == 8) {
?>
                <a class="KT_edit_link" href="a_docs_soporte_315_vinc.php?as_id=<?php echo $_GET['as_id']; ?>&amp;doclasedoc_id=<?php echo $row_rsinfogendocumentos['doclasedoc_id']; ?>&amp;anio_id=<?php echo $_GET['anio_id']; ?>&amp;hash_id=<?php echo $_GET['hash_id']; ?>&amp;lnk=<?php echo $_GET['lnk']; ?>&amp;numdocumento=<?php echo $_GET['numdocumento']; ?>&amp;almovinddia_id=<?php echo $row_rsdocvinc['almovinddia_id']; ?>&amp;KT_back=1"><?php echo NXT_getResource("edit_one"); ?></a> <a class="KT_delete_link" href="#delete"><?php echo NXT_getResource("delete_one"); ?></a>
                <?php } 
// endif Conditional region4
?> </td>
          </tr>
          <?php } while ($row_rsdocvinc = mysql_fetch_assoc($rsdocvinc)); ?>
          <?php } // Show if recordset not empty ?>
        </tbody>
      </table>
      <div class="KT_bottomnav">
        <div>
          <?php
            $nav_listrsdocvinc1->Prepare();
            require("../includes/nav/NAV_Text_Navigation.inc.php");
          ?>
        </div>
      </div>
      <div class="KT_bottombuttons">
        <?php 
// Show IF Conditional region3 
if (@$row_rsinfoalmovtodia['md_legalizado'] == "N") {
?>
          <div class="KT_operations"> <a class="KT_edit_op_link" href="#" onclick="nxt_list_edit_link_form(this); return false;"><?php echo NXT_getResource("edit_all"); ?></a> <a class="KT_delete_op_link" href="#" onclick="nxt_list_delete_link_form(this); return false;"><?php echo NXT_getResource("delete_all"); ?></a> </div>
<span>&nbsp;</span>
          <select name="no_new" id="no_new">
            <option value="1">1</option>
            <option value="3">3</option>
            <option value="6">6</option>
          </select>
          <a class="KT_additem_op_link" href="a_docs_soporte_315_vinc.php?as_id=<?php echo $_GET['as_id']; ?>&amp;doclasedoc_id=<?php echo $row_rsinfogendocumentos['doclasedoc_id']; ?>&amp;anio_id=<?php echo $_GET['anio_id']; ?>&amp;hash_id=<?php echo $_GET['hash_id']; ?>&amp;lnk=<?php echo $_GET['lnk']; ?>&amp;numdocumento=<?php echo $_GET['numdocumento']; ?>&amp;KT_back=1" onclick="return nxt_list_additem(this)"><?php echo NXT_getResource("add new"); ?></a>
          <?php } 
// endif Conditional region3
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

mysql_free_result($rsinfousuario);

mysql_free_result($rsinfoalmovtodia);

mysql_free_result($rsctrlleg);

mysql_free_result($rsdocvinc);
?>
