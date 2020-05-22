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
$tfi_listrsfindplaca1 = new TFI_TableFilter($conn_oConnAlmacen, "tfi_listrsfindplaca1");
$tfi_listrsfindplaca1->addColumn("midnroplaca", "STRING_TYPE", "midnroplaca", "%");
$tfi_listrsfindplaca1->addColumn("midnroserie", "STRING_TYPE", "midnroserie", "%");
$tfi_listrsfindplaca1->addColumn("ca_nomcuenta", "STRING_TYPE", "ca_nomcuenta", "%");
$tfi_listrsfindplaca1->addColumn("ed_nomelemento", "STRING_TYPE", "ed_nomelemento", "%");
$tfi_listrsfindplaca1->addColumn("ma_nommarca", "STRING_TYPE", "ma_nommarca", "%");
$tfi_listrsfindplaca1->addColumn("um_nomunimed", "STRING_TYPE", "um_nomunimed", "%");
$tfi_listrsfindplaca1->addColumn("mid_valormovto", "NUMERIC_TYPE", "mid_valormovto", "=");
$tfi_listrsfindplaca1->Execute();

// Sorter
$tso_listrsfindplaca1 = new TSO_TableSorter("rsfindplaca", "tso_listrsfindplaca1");
$tso_listrsfindplaca1->addColumn("midnroplaca");
$tso_listrsfindplaca1->addColumn("midnroserie");
$tso_listrsfindplaca1->addColumn("ca_nomcuenta");
$tso_listrsfindplaca1->addColumn("ed_nomelemento");
$tso_listrsfindplaca1->addColumn("ma_nommarca");
$tso_listrsfindplaca1->addColumn("um_nomunimed");
$tso_listrsfindplaca1->addColumn("mid_valormovto");
$tso_listrsfindplaca1->setDefault("midnroplaca");
$tso_listrsfindplaca1->Execute();

// Navigation
$nav_listrsfindplaca1 = new NAV_Regular("nav_listrsfindplaca1", "rsfindplaca", "../", $_SERVER['PHP_SELF'], 25);

//NeXTenesio3 Special List Recordset
$maxRows_rsfindplaca = $_SESSION['max_rows_nav_listrsfindplaca1'];
$pageNum_rsfindplaca = 0;
if (isset($_GET['pageNum_rsfindplaca'])) {
  $pageNum_rsfindplaca = $_GET['pageNum_rsfindplaca'];
}
$startRow_rsfindplaca = $pageNum_rsfindplaca * $maxRows_rsfindplaca;

$colname_rsfindplaca = "-1";
if (isset($_GET['plaque'])) {
  $colname_rsfindplaca = $_GET['plaque'];
}
// Defining List Recordset variable
$NXTFilter_rsfindplaca = "1=1";
if (isset($_SESSION['filter_tfi_listrsfindplaca1'])) {
  $NXTFilter_rsfindplaca = $_SESSION['filter_tfi_listrsfindplaca1'];
}
// Defining List Recordset variable
$NXTSort_rsfindplaca = "midnroplaca";
if (isset($_SESSION['sorter_tso_listrsfindplaca1'])) {
  $NXTSort_rsfindplaca = $_SESSION['sorter_tso_listrsfindplaca1'];
}
mysql_select_db($database_oConnAlmacen, $oConnAlmacen);

$query_rsfindplaca = sprintf("SELECT aldevindiv.aldevindiv_id, aldevindiv.almovinddia_id, aldevindiv.dicuenta, aldevindiv.dicodelem, aldevindiv.dialmacen, aldevindiv.di_nroplaca, aldevindiv.di_nroserie, aldevindiv.difuncionario, aldevindiv.di_estadoelem, aldevindiv.di_detalleestado, aldevindiv.diconceptoadq, aldevindiv.di_fechacompra, aldevindiv.di_valorcompra, aldevindiv.di_vidautiltot, aldevindiv.di_estadoconserva, aldevindiv.di_fechaultmovto, aldevindiv.dicodconcepto, aldevindiv.di_otraplaca, aldevindiv.di_nroplacastma, aldevindiv.transact_id_fk, aldevindiv.estado_elemento, aldevindiv.resolucion_baja_num, aldevindiv.resolucion_baja_date, aldevindiv.resolucion_baja_obs, alelemdevolutivo.ed_nomelemento, alelemdevolutivo.edunidad, geunidmedida.um_nomunimed, alelemdevolutivo.edmarca, almarcas.ma_codmarca, almarcas.ma_nommarca FROM aldevindiv INNER JOIN alelemdevolutivo ON aldevindiv.dicuenta = alelemdevolutivo.edcuenta AND aldevindiv.dicodelem = alelemdevolutivo.ed_codelem LEFT JOIN geunidmedida ON alelemdevolutivo.edunidad = geunidmedida.um_codunimed LEFT JOIN almarcas ON alelemdevolutivo.edmarca = geunidmedida.um_codunimed WHERE aldevindiv.di_nroplaca = %s AND aldevindiv.difuncionario = '650'", GetSQLValueString($colname_rsfindplaca, "text"));
$query_limit_rsfindplaca = sprintf("%s LIMIT %d, %d", $query_rsfindplaca, $startRow_rsfindplaca, $maxRows_rsfindplaca);
$rsfindplaca = mysql_query($query_limit_rsfindplaca, $oConnAlmacen) or die(mysql_error());
$row_rsfindplaca = mysql_fetch_assoc($rsfindplaca);

if (isset($_GET['totalRows_rsfindplaca'])) {
  $totalRows_rsfindplaca = $_GET['totalRows_rsfindplaca'];
} else {
  $all_rsfindplaca = mysql_query($query_rsfindplaca);
  $totalRows_rsfindplaca = mysql_num_rows($all_rsfindplaca);
}
$totalPages_rsfindplaca = ceil($totalRows_rsfindplaca/$maxRows_rsfindplaca)-1;
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

$nav_listrsfindplaca1->checkBoundries();
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
  .KT_col_midnroplaca {width:140px; overflow:hidden;}
  .KT_col_midnroserie {width:140px; overflow:hidden;}
  .KT_col_ca_nomcuenta {width:140px; overflow:hidden;}
  .KT_col_ed_nomelemento {width:140px; overflow:hidden;}
  .KT_col_ma_nommarca {width:140px; overflow:hidden;}
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
  <tr>
    <td><table width="80%" border="0" align="center" cellpadding="0" cellspacing="3">
      <tr>
        <td><form id="form2" name="form2" method="get" action="a_docs_soporte_322_vinc.php?as_id=<?php echo $_GET['as_id']; ?>&amp;doclasedoc_id=<?php echo $row_rsinfogendocumentos['doclasedoc_id']; ?>&amp;anio_id=<?php echo $_GET['anio_id']; ?>&amp;hash_id=<?php echo $_GET['hash_id']; ?>&amp;lnk=<?php echo $_GET['lnk']; ?>&amp;numdocumento=<?php echo $_GET['numdocumento']; ?>">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="19%">N&uacute;mero de placa:</td>
                <td width="31%"><input name="plaque" type="text" id="plaque" value="<?php echo $_GET['plaque']; ?>" />
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
</table>
<div class="KT_tng" id="listrsfindplaca1">
  <h1>Placas
    <?php
  $nav_listrsfindplaca1->Prepare();
  require("../includes/nav/NAV_Text_Statistics.inc.php");
?>
  </h1>
  <div class="KT_tnglist">
    <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
      <div class="KT_options"> <a href="<?php echo $nav_listrsfindplaca1->getShowAllLink(); ?>"><?php echo NXT_getResource("Show"); ?>
        <?php 
  // Show IF Conditional region1
  if (@$_GET['show_all_nav_listrsfindplaca1'] == 1) {
?>
          <?php echo $_SESSION['default_max_rows_nav_listrsfindplaca1']; ?>
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
            <th id="midnroplaca" class="KT_sorter KT_col_midnroplaca <?php echo $tso_listrsfindplaca1->getSortIcon('midnroplaca'); ?>"> <a href="<?php echo $tso_listrsfindplaca1->getSortLink('midnroplaca'); ?>">PLACA</a> </th>
            <th id="midnroserie" class="KT_sorter KT_col_midnroserie <?php echo $tso_listrsfindplaca1->getSortIcon('midnroserie'); ?>"> <a href="<?php echo $tso_listrsfindplaca1->getSortLink('midnroserie'); ?>">SERIE</a> </th>
            <th id="ca_nomcuenta" class="KT_sorter KT_col_ca_nomcuenta <?php echo $tso_listrsfindplaca1->getSortIcon('ca_nomcuenta'); ?>"> <a href="<?php echo $tso_listrsfindplaca1->getSortLink('ca_nomcuenta'); ?>">CUENTA</a> </th>
            <th id="ed_nomelemento" class="KT_sorter KT_col_ed_nomelemento <?php echo $tso_listrsfindplaca1->getSortIcon('ed_nomelemento'); ?>"> <a href="<?php echo $tso_listrsfindplaca1->getSortLink('ed_nomelemento'); ?>">ELEMENTO</a> </th>
            <th id="ma_nommarca" class="KT_sorter KT_col_ma_nommarca <?php echo $tso_listrsfindplaca1->getSortIcon('ma_nommarca'); ?>"> <a href="<?php echo $tso_listrsfindplaca1->getSortLink('ma_nommarca'); ?>">MARCA</a> </th>
            <th id="um_nomunimed" class="KT_sorter KT_col_um_nomunimed <?php echo $tso_listrsfindplaca1->getSortIcon('um_nomunimed'); ?>"> <a href="<?php echo $tso_listrsfindplaca1->getSortLink('um_nomunimed'); ?>">PRESENTACION</a> </th>
            <th id="mid_valormovto" class="KT_sorter KT_col_mid_valormovto <?php echo $tso_listrsfindplaca1->getSortIcon('mid_valormovto'); ?>"> <a href="<?php echo $tso_listrsfindplaca1->getSortLink('mid_valormovto'); ?>">VALOR MOVIMIENTO</a> </th>
            <th>&nbsp;</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($totalRows_rsfindplaca == 0) { // Show if recordset empty ?>
            <tr>
              <td colspan="9"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
            </tr>
            <?php } // Show if recordset empty ?>
          <?php if ($totalRows_rsfindplaca > 0) { // Show if recordset not empty ?>
            <?php do { ?>
              <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
                <td align="center"><a href="transact_placa_baja.php?as_id=<?php echo $_GET['as_id']; ?>&amp;doclasedoc_id=<?php echo $row_rsinfogendocumentos['doclasedoc_id']; ?>&amp;anio_id=<?php echo $_GET['anio_id']; ?>&amp;hash_id=<?php echo $_GET['hash_id']; ?>&amp;lnk=<?php echo $_GET['lnk']; ?>&amp;numdocumento=800&amp;aldevindiv_id=<?php echo $row_rsfindplaca['aldevindiv_id']; ?>&amp;fechaasiento=<?php echo $_GET['fechaasiento']; ?>&amp;consecutivo=<?php echo $_GET['consecutivo']; ?>&amp;plaque=<?php echo $_GET['plaque']; ?>" title="Vincular esta placa al comprobante">
                  <?php 
// Show IF Conditional region2 
if (@$row_rsfindplaca['sys_status'] == "") {
?>
                    <img src="325_link.png" width="32" height="32" border="0" />
                    <?php } 
// endif Conditional region2
?></a>
                  <input type="hidden" name="almovinddia_id" class="id_field" value="<?php echo $row_rsfindplaca['aldevindiv_id']; ?>" />
                </td><td><div class="KT_col_midnroplaca"><?php echo KT_FormatForList($row_rsfindplaca['di_nroplaca'], 20); ?></div></td>
                <td><div class="KT_col_midnroserie"><?php echo KT_FormatForList($row_rsfindplaca['di_nroserie'], 20); ?></div></td>
                <td><div class="KT_col_ca_nomcuenta"><?php echo $row_rsfindplaca['dicuenta']; ?></div></td>
                <td><textarea name="textarea" id="textarea" cols="45" rows="2"><?php echo $row_rsfindplaca['ed_nomelemento']; ?></textarea></td>
                <td><div class="KT_col_ma_nommarca"><?php echo KT_FormatForList($row_rsfindplaca['ma_nommarca'], 20); ?></div></td>
                <td><div class="KT_col_um_nomunimed"><?php echo KT_FormatForList($row_rsfindplaca['um_nomunimed'], 20); ?></div></td>
                <td align="right"><div class="KT_col_mid_valormovto"><?php echo number_format($row_rsfindplaca['di_valorcompra'],2,',','.'); ?></div></td>
                <td align="center"><a href="a_docs_soporte_315_vinc_2.php?as_id=<?php echo $_GET['as_id']; ?>&amp;doclasedoc_id=<?php echo $row_rsinfogendocumentos['doclasedoc_id']; ?>&amp;anio_id=<?php echo $_GET['anio_id']; ?>&amp;hash_id=<?php echo $_GET['hash_id']; ?>&amp;lnk=<?php echo $_GET['lnk']; ?>&amp;numdocumento=<?php echo $_GET['numdocumento']; ?>" title="Vincular esta placa al comprobante"></a></td>
              </tr>
              <?php } while ($row_rsfindplaca = mysql_fetch_assoc($rsfindplaca)); ?>
            <?php } // Show if recordset not empty ?>
        </tbody>
      </table>
      <div class="KT_bottomnav">
        <div>
          <?php
            $nav_listrsfindplaca1->Prepare();
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
mysql_free_result($rsfindplaca);

mysql_free_result($rsinfogendocumentos);
?>
