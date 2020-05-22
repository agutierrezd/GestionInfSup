<?php require_once('../Connections/oConnUsers.php'); ?>
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
$tfi_listglobal_users2 = new TFI_TableFilter($conn_oConnUsers, "tfi_listglobal_users2");
$tfi_listglobal_users2->addColumn("global_users.Username", "STRING_TYPE", "Username", "%");
$tfi_listglobal_users2->addColumn("global_users.usr_name", "STRING_TYPE", "usr_name", "%");
$tfi_listglobal_users2->addColumn("global_users.usr_lname", "STRING_TYPE", "usr_lname", "%");
$tfi_listglobal_users2->addColumn("global_status.id_status", "NUMERIC_TYPE", "usr_status", "=");
$tfi_listglobal_users2->addColumn("global_rol_c.id_rol", "NUMERIC_TYPE", "global_rol_contratos", "=");
$tfi_listglobal_users2->addColumn("global_users.usr_email", "STRING_TYPE", "usr_email", "%");
$tfi_listglobal_users2->addColumn("global_users.idusrglobal", "NUMERIC_TYPE", "idusrglobal", "=");
$tfi_listglobal_users2->Execute();

// Sorter
$tso_listglobal_users2 = new TSO_TableSorter("rsglobal_users1", "tso_listglobal_users2");
$tso_listglobal_users2->addColumn("global_users.Username");
$tso_listglobal_users2->addColumn("global_users.usr_name");
$tso_listglobal_users2->addColumn("global_users.usr_lname");
$tso_listglobal_users2->addColumn("global_status.status_name");
$tso_listglobal_users2->addColumn("global_rol_c.rol_name");
$tso_listglobal_users2->addColumn("global_users.usr_email");
$tso_listglobal_users2->addColumn("global_users.idusrglobal");
$tso_listglobal_users2->setDefault("global_users.Username");
$tso_listglobal_users2->Execute();

// Navigation
$nav_listglobal_users2 = new NAV_Regular("nav_listglobal_users2", "rsglobal_users1", "../", $_SERVER['PHP_SELF'], 15);

mysql_select_db($database_oConnUsers, $oConnUsers);
$query_Recordset1 = "SELECT status_name, id_status FROM global_status ORDER BY status_name";
$Recordset1 = mysql_query($query_Recordset1, $oConnUsers) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_oConnUsers, $oConnUsers);
$query_Recordset2 = "SELECT rol_name, id_site_fk FROM global_rol ORDER BY rol_name";
$Recordset2 = mysql_query($query_Recordset2, $oConnUsers) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

//NeXTenesio3 Special List Recordset
$maxRows_rsglobal_users1 = $_SESSION['max_rows_nav_listglobal_users2'];
$pageNum_rsglobal_users1 = 0;
if (isset($_GET['pageNum_rsglobal_users1'])) {
  $pageNum_rsglobal_users1 = $_GET['pageNum_rsglobal_users1'];
}
$startRow_rsglobal_users1 = $pageNum_rsglobal_users1 * $maxRows_rsglobal_users1;

// Defining List Recordset variable
$NXTFilter_rsglobal_users1 = "1=1";
if (isset($_SESSION['filter_tfi_listglobal_users2'])) {
  $NXTFilter_rsglobal_users1 = $_SESSION['filter_tfi_listglobal_users2'];
}
// Defining List Recordset variable
$NXTSort_rsglobal_users1 = "global_users.Username";
if (isset($_SESSION['sorter_tso_listglobal_users2'])) {
  $NXTSort_rsglobal_users1 = $_SESSION['sorter_tso_listglobal_users2'];
}
mysql_select_db($database_oConnUsers, $oConnUsers);

$query_rsglobal_users1 = "SELECT global_users.Username, global_users.usr_name, global_users.usr_lname, global_status.status_name AS usr_status, global_rol_c.rol_name AS global_rol_contratos, global_users.usr_email, global_users.idusrglobal FROM (global_users LEFT JOIN global_status ON global_users.usr_status = global_status.id_status) LEFT JOIN global_rol_c ON global_users.global_rol_contratos = global_rol_c.id_rol WHERE {$NXTFilter_rsglobal_users1} AND global_users.global_rol_contratos <> 3 ORDER BY {$NXTSort_rsglobal_users1}";
$query_limit_rsglobal_users1 = sprintf("%s LIMIT %d, %d", $query_rsglobal_users1, $startRow_rsglobal_users1, $maxRows_rsglobal_users1);
$rsglobal_users1 = mysql_query($query_limit_rsglobal_users1, $oConnUsers) or die(mysql_error());
$row_rsglobal_users1 = mysql_fetch_assoc($rsglobal_users1);

if (isset($_GET['totalRows_rsglobal_users1'])) {
  $totalRows_rsglobal_users1 = $_GET['totalRows_rsglobal_users1'];
} else {
  $all_rsglobal_users1 = mysql_query($query_rsglobal_users1);
  $totalRows_rsglobal_users1 = mysql_num_rows($all_rsglobal_users1);
}
$totalPages_rsglobal_users1 = ceil($totalRows_rsglobal_users1/$maxRows_rsglobal_users1)-1;
//End NeXTenesio3 Special List Recordset

$nav_listglobal_users2->checkBoundries();

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
  .KT_col_Username {width:140px; overflow:hidden;}
  .KT_col_usr_name {width:210px; overflow:hidden;}
  .KT_col_usr_lname {width:210px; overflow:hidden;}
  .KT_col_usr_status {width:140px; overflow:hidden;}
  .KT_col_global_rol_contratos {width:140px; overflow:hidden;}
  .KT_col_usr_email {width:210px; overflow:hidden;}
  .KT_col_idusrglobal {width:70px; overflow:hidden;}
</style>

</head>

<body>
<?php
  mxi_includes_start("../inc_top.php");
  require(basename("../inc_top.php"));
  mxi_includes_end();
?>
<div class="KT_tng" id="listglobal_users2">
  <h1> Lista global de usuarios
    <?php
  $nav_listglobal_users2->Prepare();
  require("../includes/nav/NAV_Text_Statistics.inc.php");
?>
  </h1>
  <div class="KT_tnglist">
    <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
      <div class="KT_options"> <a href="<?php echo $nav_listglobal_users2->getShowAllLink(); ?>"><?php echo NXT_getResource("Show"); ?>
            <?php 
  // Show IF Conditional region1
  if (@$_GET['show_all_nav_listglobal_users2'] == 1) {
?>
            <?php echo $_SESSION['default_max_rows_nav_listglobal_users2']; ?>
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
  if (@$_SESSION['has_filter_tfi_listglobal_users2'] == 1) {
?>
                            <a href="<?php echo $tfi_listglobal_users2->getResetFilterLink(); ?>"><?php echo NXT_getResource("Reset filter"); ?></a>
                            <?php 
  // else Conditional region2
  } else { ?>
                            <a href="<?php echo $tfi_listglobal_users2->getShowFilterLink(); ?>"><?php echo NXT_getResource("Show filter"); ?></a>
                            <?php } 
  // endif Conditional region2
?>
      </div>
      <table cellpadding="2" cellspacing="0" class="KT_tngtable">
        <thead>
          <tr class="KT_row_order">
            <th>&nbsp;</th>
            <th id="Username" class="KT_sorter KT_col_Username <?php echo $tso_listglobal_users2->getSortIcon('global_users.Username'); ?>"> <a href="<?php echo $tso_listglobal_users2->getSortLink('global_users.Username'); ?>">USUARIO</a> </th>
            <th id="usr_name" class="KT_sorter KT_col_usr_name <?php echo $tso_listglobal_users2->getSortIcon('global_users.usr_name'); ?>"> <a href="<?php echo $tso_listglobal_users2->getSortLink('global_users.usr_name'); ?>">NOMBRES</a> </th>
            <th id="usr_lname" class="KT_sorter KT_col_usr_lname <?php echo $tso_listglobal_users2->getSortIcon('global_users.usr_lname'); ?>"> <a href="<?php echo $tso_listglobal_users2->getSortLink('global_users.usr_lname'); ?>">APELLIDOS</a> </th>
            <th id="usr_status" class="KT_sorter KT_col_usr_status <?php echo $tso_listglobal_users2->getSortIcon('global_status.status_name'); ?>"> <a href="<?php echo $tso_listglobal_users2->getSortLink('global_status.status_name'); ?>">ESTADO</a> </th>
            <th id="global_rol_contratos" class="KT_sorter KT_col_global_rol_contratos <?php echo $tso_listglobal_users2->getSortIcon('global_rol_c.rol_name'); ?>"> <a href="<?php echo $tso_listglobal_users2->getSortLink('global_rol_c.rol_name'); ?>">ROL ACTUAL</a> </th>
            <th id="usr_email" class="KT_sorter KT_col_usr_email <?php echo $tso_listglobal_users2->getSortIcon('global_users.usr_email'); ?>"> <a href="<?php echo $tso_listglobal_users2->getSortLink('global_users.usr_email'); ?>">CORREO</a> </th>
            <th id="idusrglobal" class="KT_sorter KT_col_idusrglobal <?php echo $tso_listglobal_users2->getSortIcon('global_users.idusrglobal'); ?>"> <a href="<?php echo $tso_listglobal_users2->getSortLink('global_users.idusrglobal'); ?>">ID</a> </th>
            <th>&nbsp;</th>
          </tr>
          <?php 
  // Show IF Conditional region3
  if (@$_SESSION['has_filter_tfi_listglobal_users2'] == 1) {
?>
          <tr class="KT_row_filter">
            <td>&nbsp;</td>
            <td><input type="text" name="tfi_listglobal_users2_Username" id="tfi_listglobal_users2_Username" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listglobal_users2_Username']); ?>" size="20" maxlength="30" /></td>
            <td><input type="text" name="tfi_listglobal_users2_usr_name" id="tfi_listglobal_users2_usr_name" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listglobal_users2_usr_name']); ?>" size="30" maxlength="60" /></td>
            <td><input type="text" name="tfi_listglobal_users2_usr_lname" id="tfi_listglobal_users2_usr_lname" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listglobal_users2_usr_lname']); ?>" size="30" maxlength="60" /></td>
            <td><select name="tfi_listglobal_users2_usr_status" id="tfi_listglobal_users2_usr_status">
              <option value="" <?php if (!(strcmp("", @$_SESSION['tfi_listglobal_users2_usr_status']))) {echo "SELECTED";} ?>><?php echo NXT_getResource("None"); ?></option>
              <?php
do {  
?>
              <option value="<?php echo $row_Recordset1['id_status']?>"<?php if (!(strcmp($row_Recordset1['id_status'], @$_SESSION['tfi_listglobal_users2_usr_status']))) {echo "SELECTED";} ?>><?php echo $row_Recordset1['status_name']?></option>
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
            <td><select name="tfi_listglobal_users2_global_rol_contratos" id="tfi_listglobal_users2_global_rol_contratos">
              <option value="" <?php if (!(strcmp("", @$_SESSION['tfi_listglobal_users2_global_rol_contratos']))) {echo "SELECTED";} ?>><?php echo NXT_getResource("None"); ?></option>
              <?php
do {  
?>
              <option value="<?php echo $row_Recordset2['id_site_fk']?>"<?php if (!(strcmp($row_Recordset2['id_site_fk'], @$_SESSION['tfi_listglobal_users2_global_rol_contratos']))) {echo "SELECTED";} ?>><?php echo $row_Recordset2['rol_name']?></option>
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
            <td><input type="text" name="tfi_listglobal_users2_usr_email" id="tfi_listglobal_users2_usr_email" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listglobal_users2_usr_email']); ?>" size="30" maxlength="50" /></td>
            <td><input type="text" name="tfi_listglobal_users2_idusrglobal" id="tfi_listglobal_users2_idusrglobal" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listglobal_users2_idusrglobal']); ?>" size="10" maxlength="100" /></td>
            <td><input type="submit" name="tfi_listglobal_users2" value="<?php echo NXT_getResource("Filter"); ?>" /></td>
          </tr>
          <?php } 
  // endif Conditional region3
?>
        </thead>
        <tbody>
          <?php if ($totalRows_rsglobal_users1 == 0) { // Show if recordset empty ?>
          <tr>
            <td colspan="9"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
          </tr>
          <?php } // Show if recordset empty ?>
          <?php if ($totalRows_rsglobal_users1 > 0) { // Show if recordset not empty ?>
          <?php do { ?>
          <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
            <td><input type="hidden" name="idusrglobal" class="id_field" value="<?php echo $row_rsglobal_users1['idusrglobal']; ?>" />
              <a href="usuarios_edit.php?idusrglobal=<?php echo $row_rsglobal_users1['idusrglobal']; ?>&amp;vinc=3" title="Vincular usuario"><img src="../img_mcit/icon/vinc_user_326.png" width="32" height="32" border="0" /></a></td>
            <td><div class="KT_col_Username"><?php echo KT_FormatForList($row_rsglobal_users1['Username'], 20); ?></div></td>
            <td><div class="KT_col_usr_name"><?php echo KT_FormatForList($row_rsglobal_users1['usr_name'], 30); ?></div></td>
            <td><div class="KT_col_usr_lname"><?php echo KT_FormatForList($row_rsglobal_users1['usr_lname'], 30); ?></div></td>
            <td><div class="KT_col_usr_status"><?php echo KT_FormatForList($row_rsglobal_users1['usr_status'], 20); ?></div></td>
            <td><div class="KT_col_global_rol_contratos"><?php echo KT_FormatForList($row_rsglobal_users1['global_rol_contratos'], 20); ?></div></td>
            <td><div class="KT_col_usr_email"><?php echo $row_rsglobal_users1['usr_email']; ?></div></td>
            <td><div class="KT_col_idusrglobal"><?php echo KT_FormatForList($row_rsglobal_users1['idusrglobal'], 10); ?></div></td>
            <td>&nbsp;</td>
          </tr>
          <?php } while ($row_rsglobal_users1 = mysql_fetch_assoc($rsglobal_users1)); ?>
          <?php } // Show if recordset not empty ?>
        </tbody>
      </table>
      <div class="KT_bottomnav">
        <div>
          <?php
            $nav_listglobal_users2->Prepare();
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

mysql_free_result($rsglobal_users1);
?>
