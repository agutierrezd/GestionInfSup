<?php require_once('../Connections/oConnContratos.php'); ?>
<?php
/*
Análisis, Diseño y Desarrollo: Alex Fernando Gutierrez
correo: dito73@gmail.com
correo inst: agutierrezd@mincit.gov.co
celular: 3017874143
*/
require_once('../includes/common/KT_common.php');

// Load the tNG classes
require_once('../includes/tng/tNG.inc.php');

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
$tfi_listrsinfanexos1 = new TFI_TableFilter($conn_oConnContratos, "tfi_listrsinfanexos1");
$tfi_listrsinfanexos1->addColumn("anexo_titulo", "STRING_TYPE", "anexo_titulo", "%");
$tfi_listrsinfanexos1->addColumn("anexo_fecha", "DATE_TYPE", "anexo_fecha", "=");
$tfi_listrsinfanexos1->addColumn("anexo_file", "STRING_TYPE", "anexo_file", "%");
$tfi_listrsinfanexos1->addColumn("inf_id_fk", "NUMERIC_TYPE", "inf_id_fk", "=");
$tfi_listrsinfanexos1->Execute();

// Sorter
$tso_listrsinfanexos1 = new TSO_TableSorter("rsinfanexos", "tso_listrsinfanexos1");
$tso_listrsinfanexos1->addColumn("anexo_titulo");
$tso_listrsinfanexos1->addColumn("anexo_fecha");
$tso_listrsinfanexos1->addColumn("anexo_file");
$tso_listrsinfanexos1->addColumn("inf_id_fk");
$tso_listrsinfanexos1->setDefault("inf_id_fk");
$tso_listrsinfanexos1->Execute();

// Navigation
$nav_listrsinfanexos1 = new NAV_Regular("nav_listrsinfanexos1", "rsinfanexos", "../", $_SERVER['PHP_SELF'], 10);

//NeXTenesio3 Special List Recordset
$maxRows_rsinfanexos = $_SESSION['max_rows_nav_listrsinfanexos1'];
$pageNum_rsinfanexos = 0;
if (isset($_GET['pageNum_rsinfanexos'])) {
  $pageNum_rsinfanexos = $_GET['pageNum_rsinfanexos'];
}
$startRow_rsinfanexos = $pageNum_rsinfanexos * $maxRows_rsinfanexos;

$colname_rsinfanexos = "-1";
if (isset($_GET['inf_id'])) {
  $colname_rsinfanexos = $_GET['inf_id'];
}
// Defining List Recordset variable
$NXTFilter_rsinfanexos = "1=1";
if (isset($_SESSION['filter_tfi_listrsinfanexos1'])) {
  $NXTFilter_rsinfanexos = $_SESSION['filter_tfi_listrsinfanexos1'];
}
// Defining List Recordset variable
$NXTSort_rsinfanexos = "inf_id_fk";
if (isset($_SESSION['sorter_tso_listrsinfanexos1'])) {
  $NXTSort_rsinfanexos = $_SESSION['sorter_tso_listrsinfanexos1'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);

$query_rsinfanexos = sprintf("SELECT * FROM informe_intersup_anexos WHERE inf_id_fk = %s AND  {$NXTFilter_rsinfanexos}  ORDER BY  {$NXTSort_rsinfanexos} ", GetSQLValueString($colname_rsinfanexos, "int"));
$query_limit_rsinfanexos = sprintf("%s LIMIT %d, %d", $query_rsinfanexos, $startRow_rsinfanexos, $maxRows_rsinfanexos);
$rsinfanexos = mysql_query($query_limit_rsinfanexos, $oConnContratos) or die(mysql_error());
$row_rsinfanexos = mysql_fetch_assoc($rsinfanexos);

if (isset($_GET['totalRows_rsinfanexos'])) {
  $totalRows_rsinfanexos = $_GET['totalRows_rsinfanexos'];
} else {
  $all_rsinfanexos = mysql_query($query_rsinfanexos);
  $totalRows_rsinfanexos = mysql_num_rows($all_rsinfanexos);
}
$totalPages_rsinfanexos = ceil($totalRows_rsinfanexos/$maxRows_rsinfanexos)-1;
//End NeXTenesio3 Special List Recordset

$nav_listrsinfanexos1->checkBoundries();

// Download File downloadObj1
$downloadObj1 = new tNG_Download("../", "KT_download1");
// Execute
$downloadObj1->setFolder("../_attach_infanexos/");
$downloadObj1->setRenameRule("{rsinfanexos.anexo_file}");
$downloadObj1->Execute();
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script src="../includes/skins/style.js" type="text/javascript"></script>
<script src="../includes/nxt/scripts/list.js" type="text/javascript"></script>
<script src="../includes/nxt/scripts/list.js.php" type="text/javascript"></script>
<script type="text/javascript">
$NXT_LIST_SETTINGS = {
  duplicate_buttons: false,
  duplicate_navigation: false,
  row_effects: true,
  show_as_buttons: true,
  record_counter: false
}
</script>
<style type="text/css">
  /* Dynamic List row settings */
  .KT_col_anexo_titulo {width:140px; overflow:hidden;}
  .KT_col_anexo_fecha {width:140px; overflow:hidden;}
  .KT_col_anexo_file {width:140px; overflow:hidden;}
  .KT_col_inf_id_fk {width:140px; overflow:hidden;}
</style>
</head>

<body>
<div class="KT_tng" id="listrsinfanexos1">
  <h1> Informes anexos
    <?php
  $nav_listrsinfanexos1->Prepare();
  require("../includes/nav/NAV_Text_Statistics.inc.php");
?>
  </h1>
  <div class="KT_tnglist">
    <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
      <div class="KT_options"> <a href="<?php echo $nav_listrsinfanexos1->getShowAllLink(); ?>"><?php echo NXT_getResource("Show"); ?>
        <?php 
  // Show IF Conditional region1
  if (@$_GET['show_all_nav_listrsinfanexos1'] == 1) {
?>
          <?php echo $_SESSION['default_max_rows_nav_listrsinfanexos1']; ?>
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
            <th class="KT_sorter KT_col_anexo_titulo <?php echo $tso_listrsinfanexos1->getSortIcon('anexo_titulo'); ?>" id="anexo_titulo"> <a href="<?php echo $tso_listrsinfanexos1->getSortLink('anexo_titulo'); ?>">Nombre del documento</a> </th>
            <th id="anexo_file" class="KT_sorter KT_col_anexo_file <?php echo $tso_listrsinfanexos1->getSortIcon('anexo_file'); ?>"> <a href="<?php echo $tso_listrsinfanexos1->getSortLink('anexo_file'); ?>">Adjunto</a> </th>
            <th colspan="2" class="KT_sorter KT_col_inf_id_fk <?php echo $tso_listrsinfanexos1->getSortIcon('inf_id_fk'); ?>" id="inf_id_fk">&nbsp;</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($totalRows_rsinfanexos == 0) { // Show if recordset empty ?>
            <tr>
              <td colspan="5"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
            </tr>
            <?php } // Show if recordset empty ?>
          <?php if ($totalRows_rsinfanexos > 0) { // Show if recordset not empty ?>
            <?php do { ?>
              <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
                <td><input type="checkbox" name="kt_pk_informe_intersup_anexos" class="id_checkbox" value="<?php echo $row_rsinfanexos['inf_anexo_id']; ?>" />
                    <input type="hidden" name="inf_anexo_id" class="id_field" value="<?php echo $row_rsinfanexos['inf_anexo_id']; ?>" />                </td>
                <td><div class="KT_col_anexo_titulo"><?php echo $row_rsinfanexos['anexo_titulo']; ?></div>                  <div class="KT_col_anexo_fecha"></div></td>
                <td><div class="KT_col_anexo_file"><a href="<?php echo $downloadObj1->getDownloadLink(); ?>"><?php echo $row_rsinfanexos['anexo_file']; ?></a></div></td>
                <td><div class="KT_col_inf_id_fk"></div></td>
                <td><a class="KT_edit_link" href="infanexos_edit.php?inf_anexo_id=<?php echo $row_rsinfanexos['inf_anexo_id']; ?>&amp;KT_back=1&amp;inf_id=<?php echo $_GET['inf_id']; ?>&amp;doc_id=<?php echo $_GET['doc_id']; ?>"><?php echo NXT_getResource("edit_one"); ?></a> <a class="KT_delete_link" href="#delete"><?php echo NXT_getResource("delete_one"); ?></a> </td>
              </tr>
              <?php } while ($row_rsinfanexos = mysql_fetch_assoc($rsinfanexos)); ?>
            <?php } // Show if recordset not empty ?>
        </tbody>
      </table>
      <div class="KT_bottomnav">
        <div>
          <?php
            $nav_listrsinfanexos1->Prepare();
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
        <a class="KT_additem_op_link" href="infanexos_edit.php?KT_back=1&amp;inf_id=<?php echo $_GET['inf_id']; ?>&amp;doc_id=<?php echo $_GET['doc_id']; ?>" onclick="return nxt_list_additem(this)"><?php echo NXT_getResource("add new"); ?></a> </div>
    </form>
  </div>
  <br class="clearfixplain" />
</div>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($rsinfanexos);
?>
