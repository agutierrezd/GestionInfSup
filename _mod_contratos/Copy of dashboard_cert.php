<?php require_once('../Connections/oConnContratos.php'); ?>
<?php
// Load the common classes
require_once('../includes/common/KT_common.php');
?>
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
$tfi_listRsLisCert1 = new TFI_TableFilter($conn_oConnContratos, "tfi_listRsLisCert1");
$tfi_listRsLisCert1->addColumn("ESTADO", "NUMERIC_TYPE", "ESTADO", "=");
$tfi_listRsLisCert1->addColumn("RADICADO", "STRING_TYPE", "RADICADO", "%");
$tfi_listRsLisCert1->addColumn("FECHASOL", "DATE_TYPE", "FECHASOL", "=");
$tfi_listRsLisCert1->addColumn("SOLICITANTE", "STRING_TYPE", "SOLICITANTE", "%");
$tfi_listRsLisCert1->addColumn("CONTRATO", "STRING_TYPE", "CONTRATO", "%");
$tfi_listRsLisCert1->addColumn("VIGENCIA", "DATE_TYPE", "VIGENCIA", "=");
$tfi_listRsLisCert1->addColumn("CERTCUMPLIMIENTO", "STRING_TYPE", "CERTCUMPLIMIENTO", "%");
$tfi_listRsLisCert1->addColumn("DESCRIBEOBLIGA", "STRING_TYPE", "DESCRIBEOBLIGA", "%");
$tfi_listRsLisCert1->addColumn("OBS", "STRING_TYPE", "OBS", "%");
$tfi_listRsLisCert1->Execute();

// Sorter
$tso_listRsLisCert1 = new TSO_TableSorter("RsLisCert", "tso_listRsLisCert1");
$tso_listRsLisCert1->addColumn("ESTADO");
$tso_listRsLisCert1->addColumn("RADICADO");
$tso_listRsLisCert1->addColumn("FECHASOL");
$tso_listRsLisCert1->addColumn("SOLICITANTE");
$tso_listRsLisCert1->addColumn("CONTRATO");
$tso_listRsLisCert1->addColumn("VIGENCIA");
$tso_listRsLisCert1->addColumn("CERTCUMPLIMIENTO");
$tso_listRsLisCert1->addColumn("DESCRIBEOBLIGA");
$tso_listRsLisCert1->addColumn("OBS");
$tso_listRsLisCert1->setDefault("ESTADO");
$tso_listRsLisCert1->Execute();

// Navigation
$nav_listRsLisCert1 = new NAV_Regular("nav_listRsLisCert1", "RsLisCert", "../", $_SERVER['PHP_SELF'], 25);

//NeXTenesio3 Special List Recordset
$maxRows_RsLisCert = $_SESSION['max_rows_nav_listRsLisCert1'];
$pageNum_RsLisCert = 0;
if (isset($_GET['pageNum_RsLisCert'])) {
  $pageNum_RsLisCert = $_GET['pageNum_RsLisCert'];
}
$startRow_RsLisCert = $pageNum_RsLisCert * $maxRows_RsLisCert;

// Defining List Recordset variable
$NXTFilter_RsLisCert = "1=1";
if (isset($_SESSION['filter_tfi_listRsLisCert1'])) {
  $NXTFilter_RsLisCert = $_SESSION['filter_tfi_listRsLisCert1'];
}
// Defining List Recordset variable
$NXTSort_RsLisCert = "ESTADO";
if (isset($_SESSION['sorter_tso_listRsLisCert1'])) {
  $NXTSort_RsLisCert = $_SESSION['sorter_tso_listRsLisCert1'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);

$query_RsLisCert = "SELECT * FROM q_cert_master WHERE ESTADO = 1 AND  {$NXTFilter_RsLisCert}  ORDER BY  {$NXTSort_RsLisCert} ";
$query_limit_RsLisCert = sprintf("%s LIMIT %d, %d", $query_RsLisCert, $startRow_RsLisCert, $maxRows_RsLisCert);
$RsLisCert = mysql_query($query_limit_RsLisCert, $oConnContratos) or die(mysql_error());
$row_RsLisCert = mysql_fetch_assoc($RsLisCert);

if (isset($_GET['totalRows_RsLisCert'])) {
  $totalRows_RsLisCert = $_GET['totalRows_RsLisCert'];
} else {
  $all_RsLisCert = mysql_query($query_RsLisCert);
  $totalRows_RsLisCert = mysql_num_rows($all_RsLisCert);
}
$totalPages_RsLisCert = ceil($totalRows_RsLisCert/$maxRows_RsLisCert)-1;
//End NeXTenesio3 Special List Recordset

$nav_listRsLisCert1->checkBoundries();


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
	<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
	<script src="../includes/common/js/base.js" type="text/javascript"></script>
	<script src="../includes/common/js/utility.js" type="text/javascript"></script>
	<script src="../includes/skins/style.js" type="text/javascript"></script>
	<script src="../includes/nxt/scripts/list.js" type="text/javascript"></script>
	<script src="../includes/nxt/scripts/list.js.php" type="text/javascript"></script>
   	<link rel="stylesheet" href="../_jquery/_desktop/_app/_modules/demos.css">
	<script type="text/javascript">
$NXT_LIST_SETTINGS = {
  duplicate_buttons: false,
  duplicate_navigation: true,
  row_effects: true,
  show_as_buttons: true,
  record_counter: false
</script>
	<style type="text/css">
  /* Dynamic List row settings */
  .KT_col_ESTADO {width:140px; overflow:hidden;}
  .KT_col_RADICADO {width:140px; overflow:hidden;}
  .KT_col_FECHASOL {width:140px; overflow:hidden;}
  .KT_col_SOLICITANTE {width:140px; overflow:hidden;}
  .KT_col_CONTRATO {width:140px; overflow:hidden;}
  .KT_col_VIGENCIA {width:140px; overflow:hidden;}
  .KT_col_CERTCUMPLIMIENTO {width:140px; overflow:hidden;}
  .KT_col_DESCRIBEOBLIGA {width:140px; overflow:hidden;}
  .KT_col_OBS {width:140px; overflow:hidden;}
    </style>
</head>
<body>
<?php
  mxi_includes_start("../inc_top_2.php");
  require(basename("../inc_top_2.php"));
  mxi_includes_end();
?>
<div class="KT_tng" id="listRsLisCert1">
    <h1> Solicitud de certificaciones
      <?php
  $nav_listRsLisCert1->Prepare();
  require("../includes/nav/NAV_Text_Statistics.inc.php");
?>
    </h1>
    <div class="KT_tnglist">
      <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
        <div class="KT_options"> <a href="<?php echo $nav_listRsLisCert1->getShowAllLink(); ?>"><?php echo NXT_getResource("Show"); ?>
          <?php 
  // Show IF Conditional region1
  if (@$_GET['show_all_nav_listRsLisCert1'] == 1) {
?>
            <?php echo $_SESSION['default_max_rows_nav_listRsLisCert1']; ?>
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
  if (@$_SESSION['has_filter_tfi_listRsLisCert1'] == 1) {
?>
                  <a href="<?php echo $tfi_listRsLisCert1->getResetFilterLink(); ?>"><?php echo NXT_getResource("Reset filter"); ?></a>
                  <?php 
  // else Conditional region2
  } else { ?>
                  <a href="<?php echo $tfi_listRsLisCert1->getShowFilterLink(); ?>"><?php echo NXT_getResource("Show filter"); ?></a>
                  <?php } 
  // endif Conditional region2
?>
        </div>
        <table cellpadding="2" cellspacing="0" class="KT_tngtable">
          <thead>
            <tr class="KT_row_order">
              <th> <input type="checkbox" name="KT_selAll" id="KT_selAll"/>
              </th>
              <th id="ESTADO" class="KT_sorter KT_col_ESTADO <?php echo $tso_listRsLisCert1->getSortIcon('ESTADO'); ?>"> <a href="<?php echo $tso_listRsLisCert1->getSortLink('ESTADO'); ?>">ESTADO</a> </th>
              <th id="RADICADO" class="KT_sorter KT_col_RADICADO <?php echo $tso_listRsLisCert1->getSortIcon('RADICADO'); ?>"> <a href="<?php echo $tso_listRsLisCert1->getSortLink('RADICADO'); ?>">RADICADO</a> </th>
              <th id="FECHASOL" class="KT_sorter KT_col_FECHASOL <?php echo $tso_listRsLisCert1->getSortIcon('FECHASOL'); ?>"> <a href="<?php echo $tso_listRsLisCert1->getSortLink('FECHASOL'); ?>">FECHASOL</a> </th>
              <th id="SOLICITANTE" class="KT_sorter KT_col_SOLICITANTE <?php echo $tso_listRsLisCert1->getSortIcon('SOLICITANTE'); ?>"> <a href="<?php echo $tso_listRsLisCert1->getSortLink('SOLICITANTE'); ?>">SOLICITANTE</a> </th>
              <th id="CONTRATO" class="KT_sorter KT_col_CONTRATO <?php echo $tso_listRsLisCert1->getSortIcon('CONTRATO'); ?>"> <a href="<?php echo $tso_listRsLisCert1->getSortLink('CONTRATO'); ?>">CONTRATO</a> </th>
              <th id="VIGENCIA" class="KT_sorter KT_col_VIGENCIA <?php echo $tso_listRsLisCert1->getSortIcon('VIGENCIA'); ?>"> <a href="<?php echo $tso_listRsLisCert1->getSortLink('VIGENCIA'); ?>">VIGENCIA</a> </th>
              <th id="CERTCUMPLIMIENTO" class="KT_sorter KT_col_CERTCUMPLIMIENTO <?php echo $tso_listRsLisCert1->getSortIcon('CERTCUMPLIMIENTO'); ?>"> <a href="<?php echo $tso_listRsLisCert1->getSortLink('CERTCUMPLIMIENTO'); ?>">CERTCUMPLIMIENTO</a> </th>
              <th id="DESCRIBEOBLIGA" class="KT_sorter KT_col_DESCRIBEOBLIGA <?php echo $tso_listRsLisCert1->getSortIcon('DESCRIBEOBLIGA'); ?>"> <a href="<?php echo $tso_listRsLisCert1->getSortLink('DESCRIBEOBLIGA'); ?>">DESCRIBEOBLIGA</a> </th>
              <th id="OBS" class="KT_sorter KT_col_OBS <?php echo $tso_listRsLisCert1->getSortIcon('OBS'); ?>"> <a href="<?php echo $tso_listRsLisCert1->getSortLink('OBS'); ?>">OBS</a> </th>
              <th>&nbsp;</th>
            </tr>
            <?php 
  // Show IF Conditional region3
  if (@$_SESSION['has_filter_tfi_listRsLisCert1'] == 1) {
?>
              <tr class="KT_row_filter">
                <td>&nbsp;</td>
                <td><input type="text" name="tfi_listRsLisCert1_ESTADO" id="tfi_listRsLisCert1_ESTADO" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listRsLisCert1_ESTADO']); ?>" size="20" maxlength="100" /></td>
                <td><input type="text" name="tfi_listRsLisCert1_RADICADO" id="tfi_listRsLisCert1_RADICADO" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listRsLisCert1_RADICADO']); ?>" size="20" maxlength="20" /></td>
                <td><input type="text" name="tfi_listRsLisCert1_FECHASOL" id="tfi_listRsLisCert1_FECHASOL" value="<?php echo @$_SESSION['tfi_listRsLisCert1_FECHASOL']; ?>" size="10" maxlength="22" /></td>
                <td><input type="text" name="tfi_listRsLisCert1_SOLICITANTE" id="tfi_listRsLisCert1_SOLICITANTE" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listRsLisCert1_SOLICITANTE']); ?>" size="20" maxlength="20" /></td>
                <td><input type="text" name="tfi_listRsLisCert1_CONTRATO" id="tfi_listRsLisCert1_CONTRATO" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listRsLisCert1_CONTRATO']); ?>" size="20" maxlength="20" /></td>
                <td><input type="text" name="tfi_listRsLisCert1_VIGENCIA" id="tfi_listRsLisCert1_VIGENCIA" value="<?php echo @$_SESSION['tfi_listRsLisCert1_VIGENCIA']; ?>" size="10" maxlength="22" /></td>
                <td><input type="text" name="tfi_listRsLisCert1_CERTCUMPLIMIENTO" id="tfi_listRsLisCert1_CERTCUMPLIMIENTO" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listRsLisCert1_CERTCUMPLIMIENTO']); ?>" size="20" maxlength="20" /></td>
                <td><input type="text" name="tfi_listRsLisCert1_DESCRIBEOBLIGA" id="tfi_listRsLisCert1_DESCRIBEOBLIGA" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listRsLisCert1_DESCRIBEOBLIGA']); ?>" size="20" maxlength="20" /></td>
                <td><input type="text" name="tfi_listRsLisCert1_OBS" id="tfi_listRsLisCert1_OBS" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listRsLisCert1_OBS']); ?>" size="20" maxlength="20" /></td>
                <td><input type="submit" name="tfi_listRsLisCert1" value="<?php echo NXT_getResource("Filter"); ?>" /></td>
              </tr>
              <?php } 
  // endif Conditional region3
?>
          </thead>
          <tbody>
            <?php if ($totalRows_RsLisCert == 0) { // Show if recordset empty ?>
              <tr>
                <td colspan="11"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
              </tr>
              <?php } // Show if recordset empty ?>
            <?php if ($totalRows_RsLisCert > 0) { // Show if recordset not empty ?>
              <?php do { ?>
                <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
                  <td><input type="checkbox" name="kt_pk_q_cert_master" class="id_checkbox" value="<?php echo $row_RsLisCert['cert_id']; ?>" />
                      <input type="hidden" name="cert_id" class="id_field" value="<?php echo $row_RsLisCert['cert_id']; ?>" />
                  </td>
                  <td><div class="KT_col_ESTADO">
                    <?php 
// Show IF Conditional region4 
if (@$row_RsLisCert['ESTADO'] == 1) {
?>
                        <a href="../_gendraft/htmltodocx/_gen_cert.php?doc_id=<?php echo $row_RsLisCert['id_cont_fk']; ?>&amp;cert_id=<?php echo $row_RsLisCert['cert_id']; ?>"><img src="icons/326_word_2.png" width="32" height="32" /></a>
                      <?php } 
// endif Conditional region4
?></div></td>
                  <td><div class="KT_col_RADICADO"><?php echo KT_FormatForList($row_RsLisCert['RADICADO'], 20); ?></div></td>
                  <td><div class="KT_col_FECHASOL"><?php echo KT_formatDate($row_RsLisCert['FECHASOL']); ?></div></td>
                  <td><div class="KT_col_SOLICITANTE"><?php echo $row_RsLisCert['SOLICITANTE']; ?></div></td>
                  <td><div class="KT_col_CONTRATO"><a href="cont_adm.php?hash=<?php echo md5($row_RsLisCert['cont_nit_contra_ta']); ?>&amp;cod_ver=<?php echo $row_RsLisCert['RADICADO']; ?>&amp;doc_id=<?php echo $row_RsLisCert['id_cont_fk']; ?>&amp;cont_id=<?php echo $row_RsLisCert['RADICADO']; ?>&amp;anio_id=<?php echo $row_RsLisCert['VIGENCIA']; ?>&amp;cdp_id=<?php echo $row_RsLisCert['CONTRATO']; ?>&amp;rp_id=<?php echo $row_RsLisCert['ESTADO']; ?>&amp;rubro_id=<?php echo $row_RsLisCert['cert_califcumpli']; ?>&amp;cc_id=<?php echo $row_RsLisCert['cont_nit_contra_ta']; ?>" target="_blank"><?php echo KT_FormatForList($row_RsLisCert['CONTRATO'], 20); ?></a></div></td>
                  <td><div class="KT_col_VIGENCIA"><?php echo KT_formatDate($row_RsLisCert['VIGENCIA']); ?></div></td>
                  <td><div class="KT_col_CERTCUMPLIMIENTO"><?php echo KT_FormatForList($row_RsLisCert['CERTCUMPLIMIENTO'], 20); ?></div></td>
                  <td><div class="KT_col_DESCRIBEOBLIGA"><?php echo KT_FormatForList($row_RsLisCert['DESCRIBEOBLIGA'], 20); ?></div></td>
                  <td><div class="KT_col_OBS">
                    <textarea name="textarea" id="textarea" cols="45" rows="3"><?php echo $row_RsLisCert['OBS']; ?></textarea>
                    </div></td>
                  <td>&nbsp;</td>
                </tr>
                <?php } while ($row_RsLisCert = mysql_fetch_assoc($RsLisCert)); ?>
              <?php } // Show if recordset not empty ?>
          </tbody>
        </table>
        <div class="KT_bottomnav">
          <div>
            <?php
            $nav_listRsLisCert1->Prepare();
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
  <p><br class="clearfixplain" />
</p>
  <?php
  mxi_includes_start("../inc_foot.php");
  require(basename("../inc_foot.php"));
  mxi_includes_end();
?>
</body>
</html>
<?php
mysql_free_result($RsLisCert);

mysql_free_result($rsinfoglobaldash);

mysql_free_result($Recordset1);
?>
