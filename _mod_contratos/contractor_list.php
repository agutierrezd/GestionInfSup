<?php require_once('../Connections/oConnContratos.php'); ?>
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
$tfi_listcontractor_master2 = new TFI_TableFilter($conn_oConnContratos, "tfi_listcontractor_master2");
$tfi_listcontractor_master2->addColumn("contractor_type.contractor_type", "STRING_TYPE", "contractor_type", "%");
$tfi_listcontractor_master2->addColumn("contractor_master.contractor_doc_id", "STRING_TYPE", "contractor_doc_id", "%");
$tfi_listcontractor_master2->addColumn("contractor_master.contractor_name", "STRING_TYPE", "contractor_name", "%");
$tfi_listcontractor_master2->addColumn("contractor_master.contractor_email", "STRING_TYPE", "contractor_email", "%");
$tfi_listcontractor_master2->addColumn("contractor_master.contractor_phone", "STRING_TYPE", "contractor_phone", "%");
$tfi_listcontractor_master2->addColumn("contractor_master.contractor_mobile", "STRING_TYPE", "contractor_mobile", "%");
$tfi_listcontractor_master2->addColumn("global_mun.CodCiudad", "STRING_TYPE", "contractor_city", "%");
$tfi_listcontractor_master2->Execute();

// Sorter
$tso_listcontractor_master2 = new TSO_TableSorter("rscontractor_master1", "tso_listcontractor_master2");
$tso_listcontractor_master2->addColumn("contractor_type.contractor_type");
$tso_listcontractor_master2->addColumn("contractor_master.contractor_doc_id");
$tso_listcontractor_master2->addColumn("contractor_master.contractor_name");
$tso_listcontractor_master2->addColumn("contractor_master.contractor_email");
$tso_listcontractor_master2->addColumn("contractor_master.contractor_phone");
$tso_listcontractor_master2->addColumn("contractor_master.contractor_mobile");
$tso_listcontractor_master2->addColumn("global_mun.NomMunicipio");
$tso_listcontractor_master2->setDefault("contractor_master.contractor_doc_id");
$tso_listcontractor_master2->Execute();

// Navigation
$nav_listcontractor_master2 = new NAV_Regular("nav_listcontractor_master2", "rscontractor_master1", "../", $_SERVER['PHP_SELF'], 25);

mysql_select_db($database_oConnContratos, $oConnContratos);
$query_Recordset1 = "SELECT NomMunicipio, CodCiudad FROM global_mun ORDER BY NomMunicipio";
$Recordset1 = mysql_query($query_Recordset1, $oConnContratos) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_oConnContratos, $oConnContratos);
$query_Recordset2 = "SELECT contractor_type, contractor_type FROM contractor_type ORDER BY contractor_type";
$Recordset2 = mysql_query($query_Recordset2, $oConnContratos) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

//NeXTenesio3 Special List Recordset
$maxRows_rscontractor_master1 = $_SESSION['max_rows_nav_listcontractor_master2'];
$pageNum_rscontractor_master1 = 0;
if (isset($_GET['pageNum_rscontractor_master1'])) {
  $pageNum_rscontractor_master1 = $_GET['pageNum_rscontractor_master1'];
}
$startRow_rscontractor_master1 = $pageNum_rscontractor_master1 * $maxRows_rscontractor_master1;

// Defining List Recordset variable
$NXTFilter_rscontractor_master1 = "1=1";
if (isset($_SESSION['filter_tfi_listcontractor_master2'])) {
  $NXTFilter_rscontractor_master1 = $_SESSION['filter_tfi_listcontractor_master2'];
}
// Defining List Recordset variable
$NXTSort_rscontractor_master1 = "contractor_master.contractor_doc_id";
if (isset($_SESSION['sorter_tso_listcontractor_master2'])) {
  $NXTSort_rscontractor_master1 = $_SESSION['sorter_tso_listcontractor_master2'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);

$query_rscontractor_master1 = "SELECT contractor_type.contractor_type AS contractor_type, contractor_master.contractor_doc_id, contractor_master.contractor_name, contractor_master.contractor_email, contractor_master.contractor_phone, contractor_master.contractor_mobile, global_mun.NomMunicipio AS contractor_city, contractor_master.contractor_id FROM (contractor_master LEFT JOIN contractor_type ON contractor_master.contractor_type = contractor_type.contractor_type) LEFT JOIN global_mun ON contractor_master.contractor_city = global_mun.CodCiudad WHERE {$NXTFilter_rscontractor_master1} ORDER BY {$NXTSort_rscontractor_master1}";
$query_limit_rscontractor_master1 = sprintf("%s LIMIT %d, %d", $query_rscontractor_master1, $startRow_rscontractor_master1, $maxRows_rscontractor_master1);
$rscontractor_master1 = mysql_query($query_limit_rscontractor_master1, $oConnContratos) or die(mysql_error());
$row_rscontractor_master1 = mysql_fetch_assoc($rscontractor_master1);

if (isset($_GET['totalRows_rscontractor_master1'])) {
  $totalRows_rscontractor_master1 = $_GET['totalRows_rscontractor_master1'];
} else {
  $all_rscontractor_master1 = mysql_query($query_rscontractor_master1);
  $totalRows_rscontractor_master1 = mysql_num_rows($all_rscontractor_master1);
}
$totalPages_rscontractor_master1 = ceil($totalRows_rscontractor_master1/$maxRows_rscontractor_master1)-1;
//End NeXTenesio3 Special List Recordset

$nav_listcontractor_master2->checkBoundries();

// Require the MXI classes
require_once ('../includes/mxi/MXI.php');
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:: Contrataci&oacute;n :: MinCIT ::.</title><link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" /><script src="../includes/common/js/base.js" type="text/javascript"></script><script src="../includes/common/js/utility.js" type="text/javascript"></script><script src="../includes/skins/style.js" type="text/javascript"></script><script src="../includes/nxt/scripts/list.js" type="text/javascript"></script><script src="../includes/nxt/scripts/list.js.php" type="text/javascript"></script><script type="text/javascript">
$NXT_LIST_SETTINGS = {
  duplicate_buttons: true,
  duplicate_navigation: true,
  row_effects: true,
  show_as_buttons: true,
  record_counter: true
}
</script><style type="text/css">
  /* Dynamic List row settings */
  .KT_col_contractor_type {width:50px; overflow:hidden;}
  .KT_col_contractor_doc_id {width:50px; overflow:hidden;}
  .KT_col_contractor_name {width:160px; overflow:hidden;}
  .KT_col_contractor_email {width:105px; overflow:hidden;}
  .KT_col_contractor_phone {width:70px; overflow:hidden;}
  .KT_col_contractor_mobile {width:70px; overflow:hidden;}
  .KT_col_contractor_city {width:105px; overflow:hidden;}
</style>

</head>

<body>
<?php
  mxi_includes_start("../inc_top.php");
  require(basename("../inc_top.php"));
  mxi_includes_end();
?>
<div class="KT_tng" id="listcontractor_master2">
  <h1> Listado general de contratistas
    <?php
  $nav_listcontractor_master2->Prepare();
  require("../includes/nav/NAV_Text_Statistics.inc.php");
?>
  </h1>
  <div class="KT_tnglist">
    <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
      <div class="KT_options"> <a href="<?php echo $nav_listcontractor_master2->getShowAllLink(); ?>"><?php echo NXT_getResource("Show"); ?>
            <?php 
  // Show IF Conditional region1
  if (@$_GET['show_all_nav_listcontractor_master2'] == 1) {
?>
            <?php echo $_SESSION['default_max_rows_nav_listcontractor_master2']; ?>
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
  if (@$_SESSION['has_filter_tfi_listcontractor_master2'] == 1) {
?>
                            <a href="<?php echo $tfi_listcontractor_master2->getResetFilterLink(); ?>"><?php echo NXT_getResource("Reset filter"); ?></a>
                            <?php 
  // else Conditional region2
  } else { ?>
                            <a href="<?php echo $tfi_listcontractor_master2->getShowFilterLink(); ?>"><?php echo NXT_getResource("Show filter"); ?></a>
                            <?php } 
  // endif Conditional region2
?>
      </div>
      <table cellpadding="2" cellspacing="0" class="KT_tngtable">
        <thead>
          <tr class="KT_row_order">
            <th> <input type="checkbox" name="KT_selAll" id="KT_selAll"/>
            </th>
            <th id="contractor_type" class="KT_sorter KT_col_contractor_type <?php echo $tso_listcontractor_master2->getSortIcon('contractor_type.contractor_type'); ?>"> <a href="<?php echo $tso_listcontractor_master2->getSortLink('contractor_type.contractor_type'); ?>">CLASE DE DOCUMENTO</a> </th>
            <th id="contractor_doc_id" class="KT_sorter KT_col_contractor_doc_id <?php echo $tso_listcontractor_master2->getSortIcon('contractor_master.contractor_doc_id'); ?>"> <a href="<?php echo $tso_listcontractor_master2->getSortLink('contractor_master.contractor_doc_id'); ?>">NUMERO DE DOCUMENTO</a> </th>
            <th id="contractor_name" class="KT_sorter KT_col_contractor_name <?php echo $tso_listcontractor_master2->getSortIcon('contractor_master.contractor_name'); ?>"> <a href="<?php echo $tso_listcontractor_master2->getSortLink('contractor_master.contractor_name'); ?>">NOMBRE / RAZON SOCIAL</a> </th>
            <th id="contractor_email" class="KT_sorter KT_col_contractor_email <?php echo $tso_listcontractor_master2->getSortIcon('contractor_master.contractor_email'); ?>"> <a href="<?php echo $tso_listcontractor_master2->getSortLink('contractor_master.contractor_email'); ?>">CORREO ELECTRONICO</a> </th>
            <th id="contractor_phone" class="KT_sorter KT_col_contractor_phone <?php echo $tso_listcontractor_master2->getSortIcon('contractor_master.contractor_phone'); ?>"> <a href="<?php echo $tso_listcontractor_master2->getSortLink('contractor_master.contractor_phone'); ?>">TELEFONO</a> </th>
            <th id="contractor_mobile" class="KT_sorter KT_col_contractor_mobile <?php echo $tso_listcontractor_master2->getSortIcon('contractor_master.contractor_mobile'); ?>"> <a href="<?php echo $tso_listcontractor_master2->getSortLink('contractor_master.contractor_mobile'); ?>">CELULAR</a> </th>
            <th id="contractor_city" class="KT_sorter KT_col_contractor_city <?php echo $tso_listcontractor_master2->getSortIcon('global_mun.NomMunicipio'); ?>"> <a href="<?php echo $tso_listcontractor_master2->getSortLink('global_mun.NomMunicipio'); ?>">CIUDAD</a> </th>
            <th>&nbsp;</th>
          </tr>
          <?php 
  // Show IF Conditional region3
  if (@$_SESSION['has_filter_tfi_listcontractor_master2'] == 1) {
?>
          <tr class="KT_row_filter">
            <td>&nbsp;</td>
            <td><select name="tfi_listcontractor_master2_contractor_type" id="tfi_listcontractor_master2_contractor_type">
              <option value="" <?php if (!(strcmp("", @$_SESSION['tfi_listcontractor_master2_contractor_type']))) {echo "SELECTED";} ?>><?php echo NXT_getResource("None"); ?></option>
              <?php
do {  
?>
              <option value="<?php echo $row_Recordset2['contractor_type']?>"<?php if (!(strcmp($row_Recordset2['contractor_type'], @$_SESSION['tfi_listcontractor_master2_contractor_type']))) {echo "SELECTED";} ?>><?php echo $row_Recordset2['contractor_type']?></option>
              <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
            </select>
            </td>
            <td><input type="text" name="tfi_listcontractor_master2_contractor_doc_id" id="tfi_listcontractor_master2_contractor_doc_id" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listcontractor_master2_contractor_doc_id']); ?>" size="10" maxlength="20" /></td>
            <td><input type="text" name="tfi_listcontractor_master2_contractor_name" id="tfi_listcontractor_master2_contractor_name" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listcontractor_master2_contractor_name']); ?>" size="20" maxlength="255" /></td>
            <td><input type="text" name="tfi_listcontractor_master2_contractor_email" id="tfi_listcontractor_master2_contractor_email" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listcontractor_master2_contractor_email']); ?>" size="15" maxlength="100" /></td>
            <td><input type="text" name="tfi_listcontractor_master2_contractor_phone" id="tfi_listcontractor_master2_contractor_phone" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listcontractor_master2_contractor_phone']); ?>" size="10" maxlength="10" /></td>
            <td><input type="text" name="tfi_listcontractor_master2_contractor_mobile" id="tfi_listcontractor_master2_contractor_mobile" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listcontractor_master2_contractor_mobile']); ?>" size="10" maxlength="10" /></td>
            <td><select name="tfi_listcontractor_master2_contractor_city" id="tfi_listcontractor_master2_contractor_city">
              <option value="" <?php if (!(strcmp("", @$_SESSION['tfi_listcontractor_master2_contractor_city']))) {echo "SELECTED";} ?>><?php echo NXT_getResource("None"); ?></option>
              <?php
do {  
?>
              <option value="<?php echo $row_Recordset1['CodCiudad']?>"<?php if (!(strcmp($row_Recordset1['CodCiudad'], @$_SESSION['tfi_listcontractor_master2_contractor_city']))) {echo "SELECTED";} ?>><?php echo $row_Recordset1['NomMunicipio']?></option>
              <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
            </select>
            </td>
            <td><input type="submit" name="tfi_listcontractor_master2" value="<?php echo NXT_getResource("Filter"); ?>" /></td>
          </tr>
          <?php } 
  // endif Conditional region3
?>
        </thead>
        <tbody>
          <?php if ($totalRows_rscontractor_master1 == 0) { // Show if recordset empty ?>
          <tr>
            <td colspan="9"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
          </tr>
          <?php } // Show if recordset empty ?>
          <?php if ($totalRows_rscontractor_master1 > 0) { // Show if recordset not empty ?>
          <?php do { ?>
          <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
            <td><input type="checkbox" name="kt_pk_contractor_master" class="id_checkbox" value="<?php echo $row_rscontractor_master1['contractor_id']; ?>" />
                <input type="hidden" name="contractor_id" class="id_field" value="<?php echo $row_rscontractor_master1['contractor_id']; ?>" />
            </td>
            <td><div class="KT_col_contractor_type"><?php echo $row_rscontractor_master1['contractor_type']; ?></div></td>
            <td><div class="KT_col_contractor_doc_id"><?php echo $row_rscontractor_master1['contractor_doc_id']; ?></div></td>
            <td><div class="KT_col_contractor_name"><?php echo $row_rscontractor_master1['contractor_name']; ?></div></td>
            <td><div class="KT_col_contractor_email"><?php echo $row_rscontractor_master1['contractor_email']; ?></div></td>
            <td><div class="KT_col_contractor_phone"><?php echo KT_FormatForList($row_rscontractor_master1['contractor_phone'], 10); ?></div></td>
            <td><div class="KT_col_contractor_mobile"><?php echo KT_FormatForList($row_rscontractor_master1['contractor_mobile'], 10); ?></div></td>
            <td><div class="KT_col_contractor_city"><?php echo KT_FormatForList($row_rscontractor_master1['contractor_city'], 15); ?></div></td>
            <td><a class="KT_edit_link" href="contractor_edit.php?contractor_id=<?php echo $row_rscontractor_master1['contractor_id']; ?>&amp;KT_back=1"><?php echo NXT_getResource("edit_one"); ?></a> <a class="KT_delete_link" href="#delete"><?php echo NXT_getResource("delete_one"); ?></a> </td>
          </tr>
          <?php } while ($row_rscontractor_master1 = mysql_fetch_assoc($rscontractor_master1)); ?>
          <?php } // Show if recordset not empty ?>
        </tbody>
      </table>
      <div class="KT_bottomnav">
        <div>
          <?php
            $nav_listcontractor_master2->Prepare();
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
        <a class="KT_additem_op_link" href="contractor_edit.php?KT_back=1" onclick="return nxt_list_additem(this)"><?php echo NXT_getResource("add new"); ?></a> </div>
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
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($rscontractor_master1);
?>
