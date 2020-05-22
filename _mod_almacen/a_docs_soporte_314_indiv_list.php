<?php require_once('../Connections/oConnAlmacen.php'); ?>
<?php
/*
Análisis, Diseño y Desarrollo: Alex Fernando Gutierrez
correo: dito73@gmail.com
correo inst: agutierrezd@mincit.gov.co
celular: 3017874143
*/
require_once('../includes/common/KT_common.php');

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
$tfi_listrslistind1 = new TFI_TableFilter($conn_oConnAlmacen, "tfi_listrslistind1");
$tfi_listrslistind1->addColumn("midnroplaca", "STRING_TYPE", "midnroplaca", "%");
$tfi_listrslistind1->addColumn("midnroserie", "STRING_TYPE", "midnroserie", "%");
$tfi_listrslistind1->addColumn("midfuncionario", "STRING_TYPE", "midfuncionario", "%");
$tfi_listrslistind1->addColumn("mid_valunit", "NUMERIC_TYPE", "mid_valunit", "=");
$tfi_listrslistind1->addColumn("mid_tax", "NUMERIC_TYPE", "mid_tax", "=");
$tfi_listrslistind1->addColumn("mid_valormovto", "NUMERIC_TYPE", "mid_valormovto", "=");
$tfi_listrslistind1->addColumn("co_nomconcepto", "STRING_TYPE", "co_nomconcepto", "%");
$tfi_listrslistind1->addColumn("almovinddia_id", "NUMERIC_TYPE", "almovinddia_id", "=");
$tfi_listrslistind1->Execute();

// Sorter
$tso_listrslistind1 = new TSO_TableSorter("rslistind", "tso_listrslistind1");
$tso_listrslistind1->addColumn("midnroplaca");
$tso_listrslistind1->addColumn("midnroserie");
$tso_listrslistind1->addColumn("midfuncionario");
$tso_listrslistind1->addColumn("mid_valunit");
$tso_listrslistind1->addColumn("mid_tax");
$tso_listrslistind1->addColumn("mid_valormovto");
$tso_listrslistind1->addColumn("co_nomconcepto");
$tso_listrslistind1->addColumn("almovinddia_id");
$tso_listrslistind1->setDefault("midnroplaca");
$tso_listrslistind1->Execute();

// Navigation
$nav_listrslistind1 = new NAV_Regular("nav_listrslistind1", "rslistind", "../", $_SERVER['PHP_SELF'], 25);

//NeXTenesio3 Special List Recordset
$maxRows_rslistind = $_SESSION['max_rows_nav_listrslistind1'];
$pageNum_rslistind = 0;
if (isset($_GET['pageNum_rslistind'])) {
  $pageNum_rslistind = $_GET['pageNum_rslistind'];
}
$startRow_rslistind = $pageNum_rslistind * $maxRows_rslistind;

$colname_rslistind = "-1";
if (isset($_GET['almovdevdia_id'])) {
  $colname_rslistind = $_GET['almovdevdia_id'];
}
// Defining List Recordset variable
$NXTFilter_rslistind = "1=1";
if (isset($_SESSION['filter_tfi_listrslistind1'])) {
  $NXTFilter_rslistind = $_SESSION['filter_tfi_listrslistind1'];
}
// Defining List Recordset variable
$NXTSort_rslistind = "midnroplaca";
if (isset($_SESSION['sorter_tso_listrslistind1'])) {
  $NXTSort_rslistind = $_SESSION['sorter_tso_listrslistind1'];
}
mysql_select_db($database_oConnAlmacen, $oConnAlmacen);

$query_rslistind = sprintf("SELECT almovinddia.midnroplaca, almovinddia.midnroserie, almovinddia.midfuncionario, almovinddia.mid_valunit, almovinddia.mid_tax, almovinddia.mid_valormovto, almovinddia.mid_coddetalleestado, almovinddia.almovinddia_id, almovinddia.doclasedoc_id_fk, almovinddia.almovdevdia_id_fk, alconceptos.co_nomconcepto FROM almovinddia INNER JOIN alconceptos ON almovinddia.mid_coddetalleestado = alconceptos.co_codconcepto WHERE almovdevdia_id_fk = %s AND  {$NXTFilter_rslistind} ORDER BY {$NXTSort_rslistind} ", GetSQLValueString($colname_rslistind, "int"));
$query_limit_rslistind = sprintf("%s LIMIT %d, %d", $query_rslistind, $startRow_rslistind, $maxRows_rslistind);
$rslistind = mysql_query($query_limit_rslistind, $oConnAlmacen) or die(mysql_error());
$row_rslistind = mysql_fetch_assoc($rslistind);

if (isset($_GET['totalRows_rslistind'])) {
  $totalRows_rslistind = $_GET['totalRows_rslistind'];
} else {
  $all_rslistind = mysql_query($query_rslistind);
  $totalRows_rslistind = mysql_num_rows($all_rslistind);
}
$totalPages_rslistind = ceil($totalRows_rslistind/$maxRows_rslistind)-1;
//End NeXTenesio3 Special List Recordset

$colname_rsinfoalmovdevdia = "-1";
if (isset($_GET['almovdevdia_id'])) {
  $colname_rsinfoalmovdevdia = $_GET['almovdevdia_id'];
}
mysql_select_db($database_oConnAlmacen, $oConnAlmacen);
$query_rsinfoalmovdevdia = sprintf("SELECT * FROM q_almovdevdia WHERE almovdevdia_id = %s", GetSQLValueString($colname_rsinfoalmovdevdia, "int"));
$rsinfoalmovdevdia = mysql_query($query_rsinfoalmovdevdia, $oConnAlmacen) or die(mysql_error());
$row_rsinfoalmovdevdia = mysql_fetch_assoc($rsinfoalmovdevdia);
$totalRows_rsinfoalmovdevdia = mysql_num_rows($rsinfoalmovdevdia);

$nav_listrslistind1->checkBoundries();
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:: Almac&eacute;n ::.</title>
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
  .KT_col_midnroplaca {width:140px; overflow:hidden;}
  .KT_col_midnroserie {width:140px; overflow:hidden;}
  .KT_col_midfuncionario {width:140px; overflow:hidden;}
  .KT_col_mid_valunit {width:140px; overflow:hidden;}
  .KT_col_mid_tax {width:140px; overflow:hidden;}
  .KT_col_mid_valormovto {width:140px; overflow:hidden;}
  .KT_col_co_nomconcepto {width:140px; overflow:hidden;}
  .KT_col_almovinddia_id {width:140px; overflow:hidden;}
</style>
<link href="../_css/jqueryslidemenu.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="600" border="0" cellspacing="2" cellpadding="0">
      <tr>
        <td class="frmtablahead">CUENTA</td>
        <td class="frmtablahead">COD ELEMENTO</td>
        <td class="frmtablahead">&nbsp;</td>
      </tr>
      <tr>
        <td class="frmtablabody"><?php echo $row_rsinfoalmovdevdia['mddcuenta']; ?></td>
        <td class="frmtablabody"><?php echo $row_rsinfoalmovdevdia['mddcodelem']; ?></td>
        <td class="frmtablabody">&nbsp;</td>
      </tr>
      <tr>
        <td class="frmtablahead">PRESENTACI&Oacute;N</td>
        <td class="frmtablahead">MARCA</td>
        <td class="frmtablahead">&nbsp;</td>
      </tr>
      <tr>
        <td class="frmtablabody"><?php echo $row_rsinfoalmovdevdia['um_nomunimed']; ?></td>
        <td class="frmtablabody"><?php echo $row_rsinfoalmovdevdia['ma_nommarca']; ?></td>
        <td class="frmtablabody">&nbsp;</td>
      </tr>
      <tr>
        <td class="frmtablahead">CANTIDAD</td>
        <td class="frmtablahead">VALOR UNITARIO</td>
        <td class="frmtablahead">TOTAL</td>
      </tr>
      <tr>
        <td class="frmtablabody"><?php echo $row_rsinfoalmovdevdia['mdd_cantmovto']; ?></td>
        <td class="frmtablabody" align="right"><?php echo number_format($row_rsinfoalmovdevdia['mdd_valunit'],2,',','.'); ?> (<?php echo $row_rsinfoalmovdevdia['tax_name']; ?>)</td>
        <td class="frmtablabody" align="right"><?php echo number_format($row_rsinfoalmovdevdia['mdd_valmovto'],2,',','.'); ?></td>
      </tr>
      <tr>
        <td colspan="3" class="frmtablahead">NOMBRE DEL ELEMENTO</td>
      </tr>
      <tr>
        <td colspan="3" class="frmtablabody"><?php echo $row_rsinfoalmovdevdia['ed_nomelemento']; ?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>N&uacute;mero de placas registradas</td>
        <td><?php echo $totalRows_rslistind; ?>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<p>&nbsp;
<div class="KT_tng" id="listrslistind1">
  <h1> Almovinddia
    <?php
  $nav_listrslistind1->Prepare();
  require("../includes/nav/NAV_Text_Statistics.inc.php");
?>
  </h1>
  <div class="KT_tnglist">
    <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
      <div class="KT_options"> <a href="<?php echo $nav_listrslistind1->getShowAllLink(); ?>"><?php echo NXT_getResource("Show"); ?>
        <?php 
  // Show IF Conditional region1
  if (@$_GET['show_all_nav_listrslistind1'] == 1) {
?>
          <?php echo $_SESSION['default_max_rows_nav_listrslistind1']; ?>
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
  if (@$_SESSION['has_filter_tfi_listrslistind1'] == 1) {
?>
                  <a href="<?php echo $tfi_listrslistind1->getResetFilterLink(); ?>"><?php echo NXT_getResource("Reset filter"); ?></a>
                  <?php 
  // else Conditional region2
  } else { ?>
                  <a href="<?php echo $tfi_listrslistind1->getShowFilterLink(); ?>"><?php echo NXT_getResource("Show filter"); ?></a>
                  <?php } 
  // endif Conditional region2
?>
      </div>
      <table cellpadding="2" cellspacing="0" class="KT_tngtable">
        <thead>
          <tr class="KT_row_order">
            <th> <input type="checkbox" name="KT_selAll" id="KT_selAll"/>
            </th>
            <th id="midnroplaca" class="KT_sorter KT_col_midnroplaca <?php echo $tso_listrslistind1->getSortIcon('midnroplaca'); ?>"> <a href="<?php echo $tso_listrslistind1->getSortLink('midnroplaca'); ?>">PLACA</a> </th>
            <th id="midnroserie" class="KT_sorter KT_col_midnroserie <?php echo $tso_listrslistind1->getSortIcon('midnroserie'); ?>"> <a href="<?php echo $tso_listrslistind1->getSortLink('midnroserie'); ?>">SERIE</a> </th>
            <th id="midfuncionario" class="KT_sorter KT_col_midfuncionario <?php echo $tso_listrslistind1->getSortIcon('midfuncionario'); ?>"> <a href="<?php echo $tso_listrslistind1->getSortLink('midfuncionario'); ?>">FUNCIONARIO</a> </th>
            <th id="mid_valunit" class="KT_sorter KT_col_mid_valunit <?php echo $tso_listrslistind1->getSortIcon('mid_valunit'); ?>"> <a href="<?php echo $tso_listrslistind1->getSortLink('mid_valunit'); ?>">VALOR UNITARIO</a> </th>
            <th id="mid_tax" class="KT_sorter KT_col_mid_tax <?php echo $tso_listrslistind1->getSortIcon('mid_tax'); ?>"> <a href="<?php echo $tso_listrslistind1->getSortLink('mid_tax'); ?>">IMPUESTO</a> </th>
            <th id="mid_valormovto" class="KT_sorter KT_col_mid_valormovto <?php echo $tso_listrslistind1->getSortIcon('mid_valormovto'); ?>"> <a href="<?php echo $tso_listrslistind1->getSortLink('mid_valormovto'); ?>">VALOR MOV</a> </th>
            <th id="co_nomconcepto" class="KT_sorter KT_col_co_nomconcepto <?php echo $tso_listrslistind1->getSortIcon('co_nomconcepto'); ?>"> <a href="<?php echo $tso_listrslistind1->getSortLink('co_nomconcepto'); ?>">ESTADO</a> </th>
            <th id="almovinddia_id" class="KT_sorter KT_col_almovinddia_id <?php echo $tso_listrslistind1->getSortIcon('almovinddia_id'); ?>"> <a href="<?php echo $tso_listrslistind1->getSortLink('almovinddia_id'); ?>">ID</a> </th>
            <th>&nbsp;</th>
          </tr>
          <?php 
  // Show IF Conditional region3
  if (@$_SESSION['has_filter_tfi_listrslistind1'] == 1) {
?>
            <tr class="KT_row_filter">
              <td>&nbsp;</td>
              <td><input type="text" name="tfi_listrslistind1_midnroplaca" id="tfi_listrslistind1_midnroplaca" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrslistind1_midnroplaca']); ?>" size="20" maxlength="20" /></td>
              <td><input type="text" name="tfi_listrslistind1_midnroserie" id="tfi_listrslistind1_midnroserie" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrslistind1_midnroserie']); ?>" size="20" maxlength="20" /></td>
              <td><input type="text" name="tfi_listrslistind1_midfuncionario" id="tfi_listrslistind1_midfuncionario" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrslistind1_midfuncionario']); ?>" size="20" maxlength="20" /></td>
              <td><input type="text" name="tfi_listrslistind1_mid_valunit" id="tfi_listrslistind1_mid_valunit" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrslistind1_mid_valunit']); ?>" size="20" maxlength="100" /></td>
              <td><input type="text" name="tfi_listrslistind1_mid_tax" id="tfi_listrslistind1_mid_tax" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrslistind1_mid_tax']); ?>" size="20" maxlength="100" /></td>
              <td><input type="text" name="tfi_listrslistind1_mid_valormovto" id="tfi_listrslistind1_mid_valormovto" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrslistind1_mid_valormovto']); ?>" size="20" maxlength="100" /></td>
              <td><input type="text" name="tfi_listrslistind1_co_nomconcepto" id="tfi_listrslistind1_co_nomconcepto" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrslistind1_co_nomconcepto']); ?>" size="20" maxlength="20" /></td>
              <td><input type="text" name="tfi_listrslistind1_almovinddia_id" id="tfi_listrslistind1_almovinddia_id" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrslistind1_almovinddia_id']); ?>" size="20" maxlength="100" /></td>
              <td><input type="submit" name="tfi_listrslistind1" value="<?php echo NXT_getResource("Filter"); ?>" /></td>
            </tr>
            <?php } 
  // endif Conditional region3
?>
        </thead>
        <tbody>
          <?php if ($totalRows_rslistind == 0) { // Show if recordset empty ?>
            <tr>
              <td colspan="10"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
            </tr>
            <?php } // Show if recordset empty ?>
          <?php if ($totalRows_rslistind > 0) { // Show if recordset not empty ?>
            <?php do { ?>
              <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
                <td><input type="checkbox" name="kt_pk_almovinddia" class="id_checkbox" value="<?php echo $row_rslistind['almovinddia_id']; ?>" />
                    <input type="hidden" name="almovinddia_id" class="id_field" value="<?php echo $row_rslistind['almovinddia_id']; ?>" />
                </td>
                <td><div class="KT_col_midnroplaca"><?php echo KT_FormatForList($row_rslistind['midnroplaca'], 20); ?></div></td>
                <td><div class="KT_col_midnroserie"><?php echo KT_FormatForList($row_rslistind['midnroserie'], 20); ?></div></td>
                <td><div class="KT_col_midfuncionario"><?php echo KT_FormatForList($row_rslistind['midfuncionario'], 20); ?></div></td>
                <td align="right"><div class="KT_col_mid_valunit"><?php echo KT_FormatForList($row_rslistind['mid_valunit'], 20); ?></div></td>
                <td><div class="KT_col_mid_tax"><?php echo KT_FormatForList($row_rslistind['mid_tax'], 20); ?></div></td>
                <td><div class="KT_col_mid_valormovto"><?php echo KT_FormatForList($row_rslistind['mid_valormovto'], 20); ?></div></td>
                <td><div class="KT_col_co_nomconcepto"><?php echo $row_rslistind['co_nomconcepto']; ?></div></td>
                <td><div class="KT_col_almovinddia_id"><?php echo KT_FormatForList($row_rslistind['almovinddia_id'], 20); ?></div></td>
                <td><a class="KT_edit_link" href="a_docs_soporte_314_indiv_edit.php?almovinddia_id=<?php echo $row_rslistind['almovinddia_id']; ?>&amp;KT_back=1&amp;almovdevdia_id=<?php echo $_GET['almovdevdia_id']; ?>&amp;doclasedoc_id=<?php echo $_GET['doclasedoc_id']; ?>&amp;as_id=<?php echo $_GET['as_id']; ?>&amp;hash_id=<?php echo $_GET['as_id']; ?>&amp;anio_id=<?php echo $_GET['anio_id']; ?>"><?php echo NXT_getResource("edit_one"); ?></a> <a class="KT_delete_link" href="#delete"><?php echo NXT_getResource("delete_one"); ?></a> </td>
              </tr>
              <?php } while ($row_rslistind = mysql_fetch_assoc($rslistind)); ?>
            <?php } // Show if recordset not empty ?>
        </tbody>
      </table>
      <div class="KT_bottomnav">
        <div>
          <?php
            $nav_listrslistind1->Prepare();
            require("../includes/nav/NAV_Text_Navigation.inc.php");
          ?>
        </div>
      </div>
      <div class="KT_bottombuttons">
        <div class="KT_operations"> <a class="KT_edit_op_link" href="#" onclick="nxt_list_edit_link_form(this); return false;"><?php echo NXT_getResource("edit_all"); ?></a> <a class="KT_delete_op_link" href="#" onclick="nxt_list_delete_link_form(this); return false;"><?php echo NXT_getResource("delete_all"); ?></a> </div>
<span>&nbsp;</span><?php 
// Show IF Conditional region4 
if (@$totalRows_rslistind < @$row_rsinfoalmovdevdia['mdd_cantmovto']) {
?>
        <input name="no_new" type="text" id="no_new" value="<?php echo ($row_rsinfoalmovdevdia['mdd_cantmovto']-$totalRows_rslistind); ?>" readonly="true" />
        
          <a class="KT_additem_op_link" href="a_docs_soporte_314_indiv_edit.php?KT_back=1&amp;almovdevdia_id=<?php echo $_GET['almovdevdia_id']; ?>&amp;doclasedoc_id=<?php echo $_GET['doclasedoc_id']; ?>&amp;as_id=<?php echo $_GET['as_id']; ?>&amp;hash_id=<?php echo $_GET['as_id']; ?>&amp;anio_id=<?php echo $_GET['anio_id']; ?>" onclick="return nxt_list_additem(this)"><?php echo NXT_getResource("add new"); ?></a>
          <?php } 
// endif Conditional region4
?> </div>
    </form>
  </div>
  <br class="clearfixplain" />
</div>
<p>&nbsp;</p>
</p>
</body>
</html>
<?php
mysql_free_result($rslistind);

mysql_free_result($rsinfoalmovdevdia);
?>
