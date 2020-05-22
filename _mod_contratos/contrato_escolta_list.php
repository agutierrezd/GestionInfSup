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
$tfi_listescoltas1 = new TFI_TableFilter($conn_oConnContratos, "tfi_listescoltas1");
$tfi_listescoltas1->addColumn("escoltas.con_nrced_b", "NUMERIC_TYPE", "con_nrced_b", "=");
$tfi_listescoltas1->addColumn("escoltas.con_nomcon_b", "STRING_TYPE", "con_nomcon_b", "%");
$tfi_listescoltas1->addColumn("escoltas.con_movil_b", "STRING_TYPE", "con_movil_b", "%");
$tfi_listescoltas1->addColumn("escoltas.con_vrsdo_b", "DOUBLE_TYPE", "con_vrsdo_b", "=");
$tfi_listescoltas1->addColumn("tipo_cta_banco.cta_tipotext", "STRING_TYPE", "con_tpcta_b", "%");
$tfi_listescoltas1->addColumn("tipo_banco.cod_banco", "DOUBLE_TYPE", "con_banco_b", "=");
$tfi_listescoltas1->addColumn("escoltas.con_nrcta_b", "STRING_TYPE", "con_nrcta_b", "%");
$tfi_listescoltas1->addColumn("escoltas.con_login_b", "STRING_TYPE", "con_login_b", "%");
$tfi_listescoltas1->Execute();

// Sorter
$tso_listescoltas1 = new TSO_TableSorter("rsescoltas1", "tso_listescoltas1");
$tso_listescoltas1->addColumn("escoltas.con_nrced_b");
$tso_listescoltas1->addColumn("escoltas.con_nomcon_b");
$tso_listescoltas1->addColumn("escoltas.con_movil_b");
$tso_listescoltas1->addColumn("escoltas.con_vrsdo_b");
$tso_listescoltas1->addColumn("tipo_cta_banco.des_cuenta");
$tso_listescoltas1->addColumn("tipo_banco.nom_banco");
$tso_listescoltas1->addColumn("escoltas.con_nrcta_b");
$tso_listescoltas1->addColumn("escoltas.con_login_b");
$tso_listescoltas1->setDefault("escoltas.con_nrced_b");
$tso_listescoltas1->Execute();

// Navigation
$nav_listescoltas1 = new NAV_Regular("nav_listescoltas1", "rsescoltas1", "../", $_SERVER['PHP_SELF'], 15);

mysql_select_db($database_oConnContratos, $oConnContratos);
$query_Recordset1 = "SELECT des_cuenta, cta_tipotext FROM tipo_cta_banco ORDER BY des_cuenta";
$Recordset1 = mysql_query($query_Recordset1, $oConnContratos) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_oConnContratos, $oConnContratos);
$query_Recordset2 = "SELECT nom_banco, cod_banco FROM tipo_banco ORDER BY nom_banco";
$Recordset2 = mysql_query($query_Recordset2, $oConnContratos) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

//NeXTenesio3 Special List Recordset
$maxRows_rsescoltas1 = $_SESSION['max_rows_nav_listescoltas1'];
$pageNum_rsescoltas1 = 0;
if (isset($_GET['pageNum_rsescoltas1'])) {
  $pageNum_rsescoltas1 = $_GET['pageNum_rsescoltas1'];
}
$startRow_rsescoltas1 = $pageNum_rsescoltas1 * $maxRows_rsescoltas1;

// Defining List Recordset variable
$NXTFilter_rsescoltas1 = "1=1";
if (isset($_SESSION['filter_tfi_listescoltas1'])) {
  $NXTFilter_rsescoltas1 = $_SESSION['filter_tfi_listescoltas1'];
}
// Defining List Recordset variable
$NXTSort_rsescoltas1 = "escoltas.con_nrced_b";
if (isset($_SESSION['sorter_tso_listescoltas1'])) {
  $NXTSort_rsescoltas1 = $_SESSION['sorter_tso_listescoltas1'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);

$query_rsescoltas1 = "SELECT escoltas.con_nrced_b, escoltas.con_nomcon_b, escoltas.con_movil_b, escoltas.con_vrsdo_b, tipo_cta_banco.des_cuenta AS con_tpcta_b, tipo_banco.nom_banco AS con_banco_b, escoltas.con_nrcta_b, escoltas.con_login_b, escoltas.con_idcont_b FROM (escoltas LEFT JOIN tipo_cta_banco ON escoltas.con_tpcta_b = tipo_cta_banco.cta_tipotext) LEFT JOIN tipo_banco ON escoltas.con_banco_b = tipo_banco.cod_banco WHERE {$NXTFilter_rsescoltas1} ORDER BY {$NXTSort_rsescoltas1}";
$query_limit_rsescoltas1 = sprintf("%s LIMIT %d, %d", $query_rsescoltas1, $startRow_rsescoltas1, $maxRows_rsescoltas1);
$rsescoltas1 = mysql_query($query_limit_rsescoltas1, $oConnContratos) or die(mysql_error());
$row_rsescoltas1 = mysql_fetch_assoc($rsescoltas1);

if (isset($_GET['totalRows_rsescoltas1'])) {
  $totalRows_rsescoltas1 = $_GET['totalRows_rsescoltas1'];
} else {
  $all_rsescoltas1 = mysql_query($query_rsescoltas1);
  $totalRows_rsescoltas1 = mysql_num_rows($all_rsescoltas1);
}
$totalPages_rsescoltas1 = ceil($totalRows_rsescoltas1/$maxRows_rsescoltas1)-1;
//End NeXTenesio3 Special List Recordset

$nav_listescoltas1->checkBoundries();
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title><link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" /><script src="../includes/common/js/base.js" type="text/javascript"></script><script src="../includes/common/js/utility.js" type="text/javascript"></script><script src="../includes/skins/style.js" type="text/javascript"></script><script src="../includes/nxt/scripts/list.js" type="text/javascript"></script><script src="../includes/nxt/scripts/list.js.php" type="text/javascript"></script><script type="text/javascript">
$NXT_LIST_SETTINGS = {
  duplicate_buttons: true,
  duplicate_navigation: true,
  row_effects: true,
  show_as_buttons: true,
  record_counter: false
}
</script><style type="text/css">
  /* Dynamic List row settings */
  .KT_col_con_nrced_b {width:140px; overflow:hidden;}
  .KT_col_con_nomcon_b {width:140px; overflow:hidden;}
  .KT_col_con_movil_b {width:140px; overflow:hidden;}
  .KT_col_con_vrsdo_b {width:140px; overflow:hidden;}
  .KT_col_con_tpcta_b {width:140px; overflow:hidden;}
  .KT_col_con_banco_b {width:140px; overflow:hidden;}
  .KT_col_con_nrcta_b {width:140px; overflow:hidden;}
  .KT_col_con_login_b {width:140px; overflow:hidden;}
</style>

</head>

<body>
<div class="KT_tng" id="listescoltas1">
  <h1> Escoltas
    <?php
  $nav_listescoltas1->Prepare();
  require("../includes/nav/NAV_Text_Statistics.inc.php");
?>
  </h1>
  <div class="KT_tnglist">
    <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
      <div class="KT_options"> <a href="<?php echo $nav_listescoltas1->getShowAllLink(); ?>"><?php echo NXT_getResource("Show"); ?>
            <?php 
  // Show IF Conditional region1
  if (@$_GET['show_all_nav_listescoltas1'] == 1) {
?>
            <?php echo $_SESSION['default_max_rows_nav_listescoltas1']; ?>
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
  if (@$_SESSION['has_filter_tfi_listescoltas1'] == 1) {
?>
                            <a href="<?php echo $tfi_listescoltas1->getResetFilterLink(); ?>"><?php echo NXT_getResource("Reset filter"); ?></a>
                            <?php 
  // else Conditional region2
  } else { ?>
                            <a href="<?php echo $tfi_listescoltas1->getShowFilterLink(); ?>"><?php echo NXT_getResource("Show filter"); ?></a>
                            <?php } 
  // endif Conditional region2
?>
      </div>
      <table cellpadding="2" cellspacing="0" class="KT_tngtable">
        <thead>
          <tr class="KT_row_order">
            <th> <input type="checkbox" name="KT_selAll" id="KT_selAll"/>
            </th>
            <th id="con_nrced_b" class="KT_sorter KT_col_con_nrced_b <?php echo $tso_listescoltas1->getSortIcon('escoltas.con_nrced_b'); ?>"> <a href="<?php echo $tso_listescoltas1->getSortLink('escoltas.con_nrced_b'); ?>">CEDULA</a> </th>
            <th id="con_nomcon_b" class="KT_sorter KT_col_con_nomcon_b <?php echo $tso_listescoltas1->getSortIcon('escoltas.con_nomcon_b'); ?>"> <a href="<?php echo $tso_listescoltas1->getSortLink('escoltas.con_nomcon_b'); ?>">NOMBRES</a> </th>
            <th id="con_movil_b" class="KT_sorter KT_col_con_movil_b <?php echo $tso_listescoltas1->getSortIcon('escoltas.con_movil_b'); ?>"> <a href="<?php echo $tso_listescoltas1->getSortLink('escoltas.con_movil_b'); ?>">CELULAR</a> </th>
            <th id="con_vrsdo_b" class="KT_sorter KT_col_con_vrsdo_b <?php echo $tso_listescoltas1->getSortIcon('escoltas.con_vrsdo_b'); ?>"> <a href="<?php echo $tso_listescoltas1->getSortLink('escoltas.con_vrsdo_b'); ?>">SUELDO</a> </th>
            <th id="con_tpcta_b" class="KT_sorter KT_col_con_tpcta_b <?php echo $tso_listescoltas1->getSortIcon('tipo_cta_banco.des_cuenta'); ?>"> <a href="<?php echo $tso_listescoltas1->getSortLink('tipo_cta_banco.des_cuenta'); ?>">TIPO CUENTA</a> </th>
            <th id="con_banco_b" class="KT_sorter KT_col_con_banco_b <?php echo $tso_listescoltas1->getSortIcon('tipo_banco.nom_banco'); ?>"> <a href="<?php echo $tso_listescoltas1->getSortLink('tipo_banco.nom_banco'); ?>">BANCO</a> </th>
            <th id="con_nrcta_b" class="KT_sorter KT_col_con_nrcta_b <?php echo $tso_listescoltas1->getSortIcon('escoltas.con_nrcta_b'); ?>"> <a href="<?php echo $tso_listescoltas1->getSortLink('escoltas.con_nrcta_b'); ?>">NUMERO CUENTA</a> </th>
            <th id="con_login_b" class="KT_sorter KT_col_con_login_b <?php echo $tso_listescoltas1->getSortIcon('escoltas.con_login_b'); ?>"> <a href="<?php echo $tso_listescoltas1->getSortLink('escoltas.con_login_b'); ?>">USUARIO DA</a> </th>
            <th>&nbsp;</th>
          </tr>
          <?php 
  // Show IF Conditional region3
  if (@$_SESSION['has_filter_tfi_listescoltas1'] == 1) {
?>
          <tr class="KT_row_filter">
            <td>&nbsp;</td>
            <td><input type="text" name="tfi_listescoltas1_con_nrced_b" id="tfi_listescoltas1_con_nrced_b" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listescoltas1_con_nrced_b']); ?>" size="20" maxlength="100" /></td>
            <td><input type="text" name="tfi_listescoltas1_con_nomcon_b" id="tfi_listescoltas1_con_nomcon_b" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listescoltas1_con_nomcon_b']); ?>" size="20" maxlength="100" /></td>
            <td><input type="text" name="tfi_listescoltas1_con_movil_b" id="tfi_listescoltas1_con_movil_b" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listescoltas1_con_movil_b']); ?>" size="20" maxlength="12" /></td>
            <td><input type="text" name="tfi_listescoltas1_con_vrsdo_b" id="tfi_listescoltas1_con_vrsdo_b" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listescoltas1_con_vrsdo_b']); ?>" size="20" maxlength="100" /></td>
            <td><select name="tfi_listescoltas1_con_tpcta_b" id="tfi_listescoltas1_con_tpcta_b">
              <option value="" <?php if (!(strcmp("", @$_SESSION['tfi_listescoltas1_con_tpcta_b']))) {echo "SELECTED";} ?>><?php echo NXT_getResource("None"); ?></option>
              <?php
do {  
?>
              <option value="<?php echo $row_Recordset1['cta_tipotext']?>"<?php if (!(strcmp($row_Recordset1['cta_tipotext'], @$_SESSION['tfi_listescoltas1_con_tpcta_b']))) {echo "SELECTED";} ?>><?php echo $row_Recordset1['des_cuenta']?></option>
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
            <td><select name="tfi_listescoltas1_con_banco_b" id="tfi_listescoltas1_con_banco_b">
              <option value="" <?php if (!(strcmp("", @$_SESSION['tfi_listescoltas1_con_banco_b']))) {echo "SELECTED";} ?>><?php echo NXT_getResource("None"); ?></option>
              <?php
do {  
?>
              <option value="<?php echo $row_Recordset2['cod_banco']?>"<?php if (!(strcmp($row_Recordset2['cod_banco'], @$_SESSION['tfi_listescoltas1_con_banco_b']))) {echo "SELECTED";} ?>><?php echo $row_Recordset2['nom_banco']?></option>
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
            <td><input type="text" name="tfi_listescoltas1_con_nrcta_b" id="tfi_listescoltas1_con_nrcta_b" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listescoltas1_con_nrcta_b']); ?>" size="20" maxlength="20" /></td>
            <td><input type="text" name="tfi_listescoltas1_con_login_b" id="tfi_listescoltas1_con_login_b" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listescoltas1_con_login_b']); ?>" size="20" maxlength="50" /></td>
            <td><input type="submit" name="tfi_listescoltas1" value="<?php echo NXT_getResource("Filter"); ?>" /></td>
          </tr>
          <?php } 
  // endif Conditional region3
?>
        </thead>
        <tbody>
          <?php if ($totalRows_rsescoltas1 == 0) { // Show if recordset empty ?>
          <tr>
            <td colspan="10"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
          </tr>
          <?php } // Show if recordset empty ?>
          <?php if ($totalRows_rsescoltas1 > 0) { // Show if recordset not empty ?>
          <?php do { ?>
          <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
            <td><input type="checkbox" name="kt_pk_escoltas" class="id_checkbox" value="<?php echo $row_rsescoltas1['con_idcont_b']; ?>" />
                <input type="hidden" name="con_idcont_b" class="id_field" value="<?php echo $row_rsescoltas1['con_idcont_b']; ?>" />
            </td>
            <td><div class="KT_col_con_nrced_b"><?php echo KT_FormatForList($row_rsescoltas1['con_nrced_b'], 20); ?></div></td>
            <td><?php echo $row_rsescoltas1['con_nomcon_b']; ?></td>
            <td><div class="KT_col_con_movil_b"><?php echo KT_FormatForList($row_rsescoltas1['con_movil_b'], 20); ?></div></td>
            <td align="right"><div class="KT_col_con_vrsdo_b">$<?php echo number_format($row_rsescoltas1['con_vrsdo_b'],0,',','.'); ?></div></td>
            <td><div class="KT_col_con_tpcta_b"><?php echo KT_FormatForList($row_rsescoltas1['con_tpcta_b'], 20); ?></div></td>
            <td><div class="KT_col_con_banco_b"><?php echo KT_FormatForList($row_rsescoltas1['con_banco_b'], 20); ?></div></td>
            <td><div class="KT_col_con_nrcta_b"><?php echo KT_FormatForList($row_rsescoltas1['con_nrcta_b'], 20); ?></div></td>
            <td><div class="KT_col_con_login_b"><?php echo KT_FormatForList($row_rsescoltas1['con_login_b'], 20); ?></div></td>
            <td><a class="KT_edit_link" href="contrato_escolta_edit.php?con_idcont_b=<?php echo $row_rsescoltas1['con_idcont_b']; ?>&amp;KT_back=1"><?php echo NXT_getResource("edit_one"); ?></a> <a class="KT_delete_link" href="#delete"><?php echo NXT_getResource("delete_one"); ?></a> </td>
          </tr>
          <?php } while ($row_rsescoltas1 = mysql_fetch_assoc($rsescoltas1)); ?>
          <?php } // Show if recordset not empty ?>
        </tbody>
      </table>
      <div class="KT_bottomnav">
        <div>
          <?php
            $nav_listescoltas1->Prepare();
            require("../includes/nav/NAV_Text_Navigation.inc.php");
          ?>
        </div>
      </div>
      <div class="KT_bottombuttons">
        <div class="KT_operations"> <a class="KT_edit_op_link" href="#" onclick="nxt_list_edit_link_form(this); return false;"><?php echo NXT_getResource("edit_all"); ?></a> <a class="KT_delete_op_link" href="#" onclick="nxt_list_delete_link_form(this); return false;"><?php echo NXT_getResource("delete_all"); ?></a> </div>
        <span>&nbsp;</span>
        <select name="no_new" id="no_new">
          <option value="1">1</option>
        </select>
        <a class="KT_additem_op_link" href="contrato_escolta_edit.php?KT_back=1" onclick="return nxt_list_additem(this)"><?php echo NXT_getResource("add new"); ?></a> </div>
    </form>
  </div>
  <br class="clearfixplain" />
</div>
<p>&nbsp;</p>

</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($rsescoltas1);
?>
