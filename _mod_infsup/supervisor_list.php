<?php require_once('../Connections/oConnUsers.php'); ?>
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
$conn_oConnUsers = new KT_connection($oConnUsers, $database_oConnUsers);

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
$tfi_listrslistsup1 = new TFI_TableFilter($conn_oConnUsers, "tfi_listrslistsup1");
$tfi_listrslistsup1->addColumn("Username", "STRING_TYPE", "Username", "%");
$tfi_listrslistsup1->addColumn("usr_name", "STRING_TYPE", "usr_name", "%");
$tfi_listrslistsup1->addColumn("usr_lname", "STRING_TYPE", "usr_lname", "%");
$tfi_listrslistsup1->addColumn("usr_email", "STRING_TYPE", "usr_email", "%");
$tfi_listrslistsup1->addColumn("idusrglobal", "NUMERIC_TYPE", "idusrglobal", "=");
$tfi_listrslistsup1->Execute();

// Sorter
$tso_listrslistsup1 = new TSO_TableSorter("rslistsup", "tso_listrslistsup1");
$tso_listrslistsup1->addColumn("Username");
$tso_listrslistsup1->addColumn("usr_name");
$tso_listrslistsup1->addColumn("usr_lname");
$tso_listrslistsup1->addColumn("usr_email");
$tso_listrslistsup1->addColumn("idusrglobal");
$tso_listrslistsup1->setDefault("Username");
$tso_listrslistsup1->Execute();

// Navigation
$nav_listrslistsup1 = new NAV_Regular("nav_listrslistsup1", "rslistsup", "../", $_SERVER['PHP_SELF'], 15);

//NeXTenesio3 Special List Recordset
$maxRows_rslistsup = $_SESSION['max_rows_nav_listrslistsup1'];
$pageNum_rslistsup = 0;
if (isset($_GET['pageNum_rslistsup'])) {
  $pageNum_rslistsup = $_GET['pageNum_rslistsup'];
}
$startRow_rslistsup = $pageNum_rslistsup * $maxRows_rslistsup;

// Defining List Recordset variable
$NXTFilter_rslistsup = "1=1";
if (isset($_SESSION['filter_tfi_listrslistsup1'])) {
  $NXTFilter_rslistsup = $_SESSION['filter_tfi_listrslistsup1'];
}
// Defining List Recordset variable
$NXTSort_rslistsup = "Username";
if (isset($_SESSION['sorter_tso_listrslistsup1'])) {
  $NXTSort_rslistsup = $_SESSION['sorter_tso_listrslistsup1'];
}
mysql_select_db($database_oConnUsers, $oConnUsers);
mysql_query("SET NAMES 'utf8'");
$query_rslistsup = "SELECT * FROM global_users WHERE global_rol_contratos = 3 AND  {$NXTFilter_rslistsup}  ORDER BY  {$NXTSort_rslistsup} ";
$query_limit_rslistsup = sprintf("%s LIMIT %d, %d", $query_rslistsup, $startRow_rslistsup, $maxRows_rslistsup);
$rslistsup = mysql_query($query_limit_rslistsup, $oConnUsers) or die(mysql_error());
$row_rslistsup = mysql_fetch_assoc($rslistsup);

if (isset($_GET['totalRows_rslistsup'])) {
  $totalRows_rslistsup = $_GET['totalRows_rslistsup'];
} else {
  $all_rslistsup = mysql_query($query_rslistsup);
  $totalRows_rslistsup = mysql_num_rows($all_rslistsup);
}
$totalPages_rslistsup = ceil($totalRows_rslistsup/$maxRows_rslistsup)-1;
//End NeXTenesio3 Special List Recordset

$nav_listrslistsup1->checkBoundries();
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
  duplicate_buttons: true,
  duplicate_navigation: true,
  row_effects: true,
  show_as_buttons: true,
  record_counter: true
}
</script>
<style type="text/css">
  /* Dynamic List row settings */
  .KT_col_Username {width:140px; overflow:hidden;}
  .KT_col_usr_name {width:210px; overflow:hidden;}
  .KT_col_usr_lname {width:210px; overflow:hidden;}
  .KT_col_usr_email {width:140px; overflow:hidden;}
  .KT_col_idusrglobal {width:70px; overflow:hidden;}
</style>
<script type="text/javascript" src="../_jquery/hs/highslide/highslide-with-html.js"></script>
<link rel="stylesheet" type="text/css" href="../_jquery/hs/highslide/highslide.css" />
<script type="text/javascript">
hs.graphicsDir = '../_jquery/hs/highslide/graphics/';
hs.outlineType = 'rounded-white';
hs.wrapperClassName = 'draggable-header';
</script>
</head>

<body>
<?php
  mxi_includes_start("../inc_top.php");
  require(basename("../inc_top.php"));
  mxi_includes_end();
?>
<div class="KT_tng" id="listrslistsup1">
  <h1> Listado de supervisores
    <?php
  $nav_listrslistsup1->Prepare();
  require("../includes/nav/NAV_Text_Statistics.inc.php");
?>
  </h1>
  <div class="KT_tnglist">
    <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
      <div class="KT_options"> <a href="<?php echo $nav_listrslistsup1->getShowAllLink(); ?>"><?php echo NXT_getResource("Show"); ?>
            <?php 
  // Show IF Conditional region1
  if (@$_GET['show_all_nav_listrslistsup1'] == 1) {
?>
              <?php echo $_SESSION['default_max_rows_nav_listrslistsup1']; ?>
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
  if (@$_SESSION['has_filter_tfi_listrslistsup1'] == 1) {
?>
                  <a href="<?php echo $tfi_listrslistsup1->getResetFilterLink(); ?>"><?php echo NXT_getResource("Reset filter"); ?></a>
                  <?php 
  // else Conditional region2
  } else { ?>
                  <a href="<?php echo $tfi_listrslistsup1->getShowFilterLink(); ?>"><?php echo NXT_getResource("Show filter"); ?></a>
                  <?php } 
  // endif Conditional region2
?>
      </div>
      <table cellpadding="2" cellspacing="0" class="KT_tngtable">
        <thead>
          <tr class="KT_row_order">
            <th>&nbsp;</th>
            <th id="Username" class="KT_sorter KT_col_Username <?php echo $tso_listrslistsup1->getSortIcon('Username'); ?>"> <a href="<?php echo $tso_listrslistsup1->getSortLink('Username'); ?>">USUARIO</a> </th>
            <th id="usr_name" class="KT_sorter KT_col_usr_name <?php echo $tso_listrslistsup1->getSortIcon('usr_name'); ?>"> <a href="<?php echo $tso_listrslistsup1->getSortLink('usr_name'); ?>">NOMBRES</a> </th>
            <th id="usr_lname" class="KT_sorter KT_col_usr_lname <?php echo $tso_listrslistsup1->getSortIcon('usr_lname'); ?>"> <a href="<?php echo $tso_listrslistsup1->getSortLink('usr_lname'); ?>">APELLIDOS</a> </th>
            <th id="usr_email" class="KT_sorter KT_col_usr_email <?php echo $tso_listrslistsup1->getSortIcon('usr_email'); ?>"> <a href="<?php echo $tso_listrslistsup1->getSortLink('usr_email'); ?>">CORREO</a> </th>
            <th id="idusrglobal" class="KT_sorter KT_col_idusrglobal <?php echo $tso_listrslistsup1->getSortIcon('idusrglobal'); ?>"> <a href="<?php echo $tso_listrslistsup1->getSortLink('idusrglobal'); ?>">ID</a> </th>
            <th>&nbsp;</th>
          </tr>
          <?php 
  // Show IF Conditional region3
  if (@$_SESSION['has_filter_tfi_listrslistsup1'] == 1) {
?>
            <tr class="KT_row_filter">
              <td>&nbsp;</td>
              <td><input type="text" name="tfi_listrslistsup1_Username" id="tfi_listrslistsup1_Username" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrslistsup1_Username']); ?>" size="20" maxlength="20" /></td>
              <td><input type="text" name="tfi_listrslistsup1_usr_name" id="tfi_listrslistsup1_usr_name" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrslistsup1_usr_name']); ?>" size="30" maxlength="20" /></td>
              <td><input type="text" name="tfi_listrslistsup1_usr_lname" id="tfi_listrslistsup1_usr_lname" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrslistsup1_usr_lname']); ?>" size="30" maxlength="20" /></td>
              <td><input type="text" name="tfi_listrslistsup1_usr_email" id="tfi_listrslistsup1_usr_email" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrslistsup1_usr_email']); ?>" size="20" maxlength="20" /></td>
              <td><input type="text" name="tfi_listrslistsup1_idusrglobal" id="tfi_listrslistsup1_idusrglobal" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrslistsup1_idusrglobal']); ?>" size="10" maxlength="100" /></td>
              <td><input type="submit" name="tfi_listrslistsup1" value="<?php echo NXT_getResource("Filter"); ?>" /></td>
            </tr>
            <?php } 
  // endif Conditional region3
?>
        </thead>
        <tbody>
          <?php if ($totalRows_rslistsup == 0) { // Show if recordset empty ?>
            <tr>
              <td colspan="7"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
            </tr>
            <?php } // Show if recordset empty ?>
          <?php if ($totalRows_rslistsup > 0) { // Show if recordset not empty ?>
            <?php do { ?>
              <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
                <td><input type="hidden" name="idusrglobal" class="id_field" value="<?php echo $row_rslistsup['idusrglobal']; ?>" />
                    <a href="usuarios_edit.php?idusrglobal=<?php echo $row_rslistsup['idusrglobal']; ?>&amp;vinc=7" title="Desvincular como supervisor"><img src="../img_mcit/icon/vinc_user__2_326.png" width="32" height="32" border="0" /></a><a href="usuarios_edit.php?idusrglobal=<?php echo $row_rslistsup['idusrglobal']; ?>&amp;vinc=7"></a><a href="edit_cargodep.php?idusrglobal=<?php echo $row_rslistsup['idusrglobal']; ?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )"><img src="../_mod_contratos/icons/326_edit_2.png" width="32" height="32" border="0" /></a></td>
                <td><div class="KT_col_Username"><?php echo KT_FormatForList($row_rslistsup['Username'], 20); ?></div></td>
                <td><div class="KT_col_usr_name"><?php echo KT_FormatForList($row_rslistsup['usr_name'], 30); ?></div></td>
                <td><div class="KT_col_usr_lname"><?php echo KT_FormatForList($row_rslistsup['usr_lname'], 30); ?></div></td>
                <td><div class="KT_col_usr_email"><?php echo $row_rslistsup['usr_email']; ?></div></td>
                <td><div class="KT_col_idusrglobal"><?php echo KT_FormatForList($row_rslistsup['idusrglobal'], 10); ?></div></td>
                <td>&nbsp;</td>
              </tr>
              <?php } while ($row_rslistsup = mysql_fetch_assoc($rslistsup)); ?>
            <?php } // Show if recordset not empty ?>
        </tbody>
      </table>
      <div class="KT_bottomnav">
        <div>
          <?php
            $nav_listrslistsup1->Prepare();
            require("../includes/nav/NAV_Text_Navigation.inc.php");
          ?>
        </div>
      </div>
      <div class="KT_bottombuttons">
        <div class="KT_operations"></div>
        <span>&nbsp;</span><a class="KT_additem_op_link" href="usuarios_list.php?KT_back=1" onclick="return nxt_list_additem(this)">Vincular</a> </div>
    </form>
  </div>
  <br class="clearfixplain" />
</div>
<?php
  mxi_includes_start("../inc_foot.php");
  require(basename("../inc_foot.php"));
  mxi_includes_end();
?>
</body>
</html>
<?php
mysql_free_result($rslistsup);
?>
