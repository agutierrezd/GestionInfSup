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
$tfi_listRsInfLey1 = new TFI_TableFilter($conn_oConnContratos, "tfi_listRsInfLey1");
$tfi_listRsInfLey1->addColumn("inf_numerocontrato", "STRING_TYPE", "inf_numerocontrato", "%");
$tfi_listRsInfLey1->addColumn("VIGENCIA", "DATE_TYPE", "VIGENCIA", "=");
$tfi_listRsInfLey1->addColumn("FECHAI", "DATE_TYPE", "FECHAI", "=");
$tfi_listRsInfLey1->addColumn("FECHAF", "DATE_TYPE", "FECHAF", "=");
$tfi_listRsInfLey1->addColumn("inf_nombrecontratista", "STRING_TYPE", "inf_nombrecontratista", "%");
$tfi_listRsInfLey1->addColumn("cont_objeto", "STRING_TYPE", "cont_objeto", "%");
$tfi_listRsInfLey1->addColumn("VALORI", "NUMERIC_TYPE", "VALORI", "=");
$tfi_listRsInfLey1->addColumn("AVGEJECUCION", "STRING_TYPE", "AVGEJECUCION", "%");
$tfi_listRsInfLey1->Execute();

// Sorter
$tso_listRsInfLey1 = new TSO_TableSorter("RsInfLey", "tso_listRsInfLey1");
$tso_listRsInfLey1->addColumn("inf_numerocontrato");
$tso_listRsInfLey1->addColumn("VIGENCIA");
$tso_listRsInfLey1->addColumn("FECHAI");
$tso_listRsInfLey1->addColumn("FECHAF");
$tso_listRsInfLey1->addColumn("inf_nombrecontratista");
$tso_listRsInfLey1->addColumn("cont_objeto");
$tso_listRsInfLey1->addColumn("VALORI");
$tso_listRsInfLey1->addColumn("AVGEJECUCION");
$tso_listRsInfLey1->setDefault("inf_numerocontrato");
$tso_listRsInfLey1->Execute();

// Navigation
$nav_listRsInfLey1 = new NAV_Regular("nav_listRsInfLey1", "RsInfLey", "../", $_SERVER['PHP_SELF'], 25);

//NeXTenesio3 Special List Recordset
$maxRows_RsInfLey = $_SESSION['max_rows_nav_listRsInfLey1'];
$pageNum_RsInfLey = 0;
if (isset($_GET['pageNum_RsInfLey'])) {
  $pageNum_RsInfLey = $_GET['pageNum_RsInfLey'];
}
$startRow_RsInfLey = $pageNum_RsInfLey * $maxRows_RsInfLey;

// Defining List Recordset variable
$NXTFilter_RsInfLey = "1=1";
if (isset($_SESSION['filter_tfi_listRsInfLey1'])) {
  $NXTFilter_RsInfLey = $_SESSION['filter_tfi_listRsInfLey1'];
}
// Defining List Recordset variable
$NXTSort_RsInfLey = "inf_numerocontrato";
if (isset($_SESSION['sorter_tso_listRsInfLey1'])) {
  $NXTSort_RsInfLey = $_SESSION['sorter_tso_listRsInfLey1'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);

$query_RsInfLey = "SELECT * FROM q_leytrans_detail WHERE  {$NXTFilter_RsInfLey}  ORDER BY  {$NXTSort_RsInfLey} ";
$query_limit_RsInfLey = sprintf("%s LIMIT %d, %d", $query_RsInfLey, $startRow_RsInfLey, $maxRows_RsInfLey);
$RsInfLey = mysql_query($query_limit_RsInfLey, $oConnContratos) or die(mysql_error());
$row_RsInfLey = mysql_fetch_assoc($RsInfLey);

if (isset($_GET['totalRows_RsInfLey'])) {
  $totalRows_RsInfLey = $_GET['totalRows_RsInfLey'];
} else {
  $all_RsInfLey = mysql_query($query_RsInfLey);
  $totalRows_RsInfLey = mysql_num_rows($all_RsInfLey);
}
$totalPages_RsInfLey = ceil($totalRows_RsInfLey/$maxRows_RsInfLey)-1;
//End NeXTenesio3 Special List Recordset

$nav_listRsInfLey1->checkBoundries();
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:: Contrataci&oacute;n :: MinCIT ::.</title>
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
  .KT_col_inf_numerocontrato {width:140px; overflow:hidden;}
  .KT_col_VIGENCIA {width:140px; overflow:hidden;}
  .KT_col_FECHAI {width:140px; overflow:hidden;}
  .KT_col_FECHAF {width:140px; overflow:hidden;}
  .KT_col_inf_nombrecontratista {width:140px; overflow:hidden;}
  .KT_col_cont_objeto {width:140px; overflow:hidden;}
  .KT_col_VALORI {width:140px; overflow:hidden;}
  .KT_col_AVGEJECUCION {width:140px; overflow:hidden;}
</style>
</head>

<body>
<?php
  mxi_includes_start("../inc_top_free.php");
  require(basename("../inc_top_free.php"));
  mxi_includes_end();
?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;
      <div class="KT_tng" id="listRsInfLey1">
        <h1> INFORME DE EJECUCI�N CONTRACTUAL 2015
          <?php
  $nav_listRsInfLey1->Prepare();
  require("../includes/nav/NAV_Text_Statistics.inc.php");
?>
        </h1>
        <div class="KT_tnglist">
          <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
            <div class="KT_options"> <a href="<?php echo $nav_listRsInfLey1->getShowAllLink(); ?>"><?php echo NXT_getResource("Show"); ?>
              <?php 
  // Show IF Conditional region1
  if (@$_GET['show_all_nav_listRsInfLey1'] == 1) {
?>
                <?php echo $_SESSION['default_max_rows_nav_listRsInfLey1']; ?>
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
  if (@$_SESSION['has_filter_tfi_listRsInfLey1'] == 1) {
?>
                  <a href="<?php echo $tfi_listRsInfLey1->getResetFilterLink(); ?>"><?php echo NXT_getResource("Reset filter"); ?></a>
                  <?php 
  // else Conditional region2
  } else { ?>
                  <a href="<?php echo $tfi_listRsInfLey1->getShowFilterLink(); ?>"><?php echo NXT_getResource("Show filter"); ?></a>
                  <?php } 
  // endif Conditional region2
?>
            </div>
            <table cellpadding="2" cellspacing="0" class="KT_tngtable">
              <thead>
                <tr class="KT_row_order">
                  <th>&nbsp;</th>
                  <th id="inf_numerocontrato" class="KT_sorter KT_col_inf_numerocontrato <?php echo $tso_listRsInfLey1->getSortIcon('inf_numerocontrato'); ?>"> <a href="<?php echo $tso_listRsInfLey1->getSortLink('inf_numerocontrato'); ?>">CONTRATO</a> </th>
                  <th id="VIGENCIA" class="KT_sorter KT_col_VIGENCIA <?php echo $tso_listRsInfLey1->getSortIcon('VIGENCIA'); ?>"> <a href="<?php echo $tso_listRsInfLey1->getSortLink('VIGENCIA'); ?>">VIGENCIA</a> </th>
                  <th id="FECHAI" class="KT_sorter KT_col_FECHAI <?php echo $tso_listRsInfLey1->getSortIcon('FECHAI'); ?>"> <a href="<?php echo $tso_listRsInfLey1->getSortLink('FECHAI'); ?>">FECHA INICIO</a> </th>
                  <th id="FECHAF" class="KT_sorter KT_col_FECHAF <?php echo $tso_listRsInfLey1->getSortIcon('FECHAF'); ?>"> <a href="<?php echo $tso_listRsInfLey1->getSortLink('FECHAF'); ?>">FECHA FINAL</a> </th>
                  <th id="inf_nombrecontratista" class="KT_sorter KT_col_inf_nombrecontratista <?php echo $tso_listRsInfLey1->getSortIcon('inf_nombrecontratista'); ?>"> <a href="<?php echo $tso_listRsInfLey1->getSortLink('inf_nombrecontratista'); ?>">NOMBRE CONTRATISTA</a> </th>
                  <th id="cont_objeto" class="KT_sorter KT_col_cont_objeto <?php echo $tso_listRsInfLey1->getSortIcon('cont_objeto'); ?>"> <a href="<?php echo $tso_listRsInfLey1->getSortLink('cont_objeto'); ?>">OBJETO</a> </th>
                  <th id="VALORI" class="KT_sorter KT_col_VALORI <?php echo $tso_listRsInfLey1->getSortIcon('VALORI'); ?>"> <a href="<?php echo $tso_listRsInfLey1->getSortLink('VALORI'); ?>">VALOR</a> </th>
                  <th id="AVGEJECUCION" class="KT_sorter KT_col_AVGEJECUCION <?php echo $tso_listRsInfLey1->getSortIcon('AVGEJECUCION'); ?>"> <a href="<?php echo $tso_listRsInfLey1->getSortLink('AVGEJECUCION'); ?>">PORCENTAJE EJECUCI�N</a> </th>
                  <th>&nbsp;</th>
                </tr>
                <?php 
  // Show IF Conditional region3
  if (@$_SESSION['has_filter_tfi_listRsInfLey1'] == 1) {
?>
                  <tr class="KT_row_filter">
                    <td>&nbsp;</td>
                    <td><input type="text" name="tfi_listRsInfLey1_inf_numerocontrato" id="tfi_listRsInfLey1_inf_numerocontrato" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listRsInfLey1_inf_numerocontrato']); ?>" size="20" maxlength="20" /></td>
                    <td>&nbsp;</td>
                    <td><input type="text" name="tfi_listRsInfLey1_FECHAI" id="tfi_listRsInfLey1_FECHAI" value="<?php echo @$_SESSION['tfi_listRsInfLey1_FECHAI']; ?>" size="10" maxlength="22" /></td>
                    <td><input type="text" name="tfi_listRsInfLey1_FECHAF" id="tfi_listRsInfLey1_FECHAF" value="<?php echo @$_SESSION['tfi_listRsInfLey1_FECHAF']; ?>" size="10" maxlength="22" /></td>
                    <td><input type="text" name="tfi_listRsInfLey1_inf_nombrecontratista" id="tfi_listRsInfLey1_inf_nombrecontratista" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listRsInfLey1_inf_nombrecontratista']); ?>" size="20" maxlength="20" /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><input type="text" name="tfi_listRsInfLey1_AVGEJECUCION" id="tfi_listRsInfLey1_AVGEJECUCION" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listRsInfLey1_AVGEJECUCION']); ?>" size="20" maxlength="100" /></td>
                    <td><input type="submit" name="tfi_listRsInfLey1" value="<?php echo NXT_getResource("Filter"); ?>" /></td>
                  </tr>
                  <?php } 
  // endif Conditional region3
?>
              </thead>
              <tbody>
                <?php if ($totalRows_RsInfLey == 0) { // Show if recordset empty ?>
                  <tr>
                    <td colspan="10"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
                  </tr>
                  <?php } // Show if recordset empty ?>
                <?php if ($totalRows_RsInfLey > 0) { // Show if recordset not empty ?>
                  <?php do { ?>
                    <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
                      <td><input type="hidden" name="id_cont_fk" class="id_field" value="<?php echo $row_RsInfLey['id_cont_fk']; ?>" />
                      </td>
                      <td><div class="KT_col_inf_numerocontrato"><?php echo KT_FormatForList($row_RsInfLey['inf_numerocontrato'], 20); ?></div></td>
                      <td><div class="KT_col_VIGENCIA"><?php echo KT_formatDate($row_RsInfLey['VIGENCIA']); ?></div></td>
                      <td><div class="KT_col_FECHAI"><?php echo KT_formatDate($row_RsInfLey['FECHAI']); ?></div></td>
                      <td><div class="KT_col_FECHAF"><?php echo KT_formatDate($row_RsInfLey['FECHAF']); ?></div></td>
                      <td><?php echo $row_RsInfLey['inf_nombrecontratista']; ?></td>
                      <td><textarea name="textarea" id="textarea" cols="45" rows="5"><?php echo $row_RsInfLey['cont_objeto']; ?></textarea></td>
                      <td align="right"><div class="KT_col_VALORI">$&nbsp;<?php echo number_format($row_RsInfLey['VALORI'],2,',','.'); ?></div></td>
                      <td align="center"><div class="KT_col_AVGEJECUCION"><?php echo number_format($row_RsInfLey['AVGEJECUCION'],1,',','.'); ?>%</div></td>
                      <td>&nbsp;</td>
                    </tr>
                    <?php } while ($row_RsInfLey = mysql_fetch_assoc($RsInfLey)); ?>
                  <?php } // Show if recordset not empty ?>
              </tbody>
            </table>
            <div class="KT_bottomnav">
              <div>
                <?php
            $nav_listRsInfLey1->Prepare();
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
    <p>&nbsp;</p></td>
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
mysql_free_result($RsInfLey);
?>
