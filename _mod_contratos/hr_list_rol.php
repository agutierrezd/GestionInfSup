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
$tfi_listrslisthr1 = new TFI_TableFilter($conn_oConnContratos, "tfi_listrslisthr1");
$tfi_listrslisthr1->addColumn("hr_id", "NUMERIC_TYPE", "hr_id", "=");
$tfi_listrslisthr1->addColumn("hr_anio", "DATE_TYPE", "hr_anio", "=");
$tfi_listrslisthr1->addColumn("hr_fechaingreso", "DATE_TYPE", "hr_fechaingreso", "=");
$tfi_listrslisthr1->addColumn("hr_nit_contra_ta", "STRING_TYPE", "hr_nit_contra_ta", "%");
$tfi_listrslisthr1->addColumn("contractor_name", "STRING_TYPE", "contractor_name", "%");
$tfi_listrslisthr1->addColumn("hr_asunto", "STRING_TYPE", "hr_asunto", "%");
$tfi_listrslisthr1->addColumn("hr_valor", "NUMERIC_TYPE", "hr_valor", "=");
$tfi_listrslisthr1->addColumn("CONTRATOID", "STRING_TYPE", "CONTRATOID", "%");
$tfi_listrslisthr1->addColumn("hr_estado_firma", "STRING_TYPE", "hr_estado_firma", "%");
$tfi_listrslisthr1->Execute();

// Sorter
$tso_listrslisthr1 = new TSO_TableSorter("rslisthr", "tso_listrslisthr1");
$tso_listrslisthr1->addColumn("hr_id");
$tso_listrslisthr1->addColumn("hr_anio");
$tso_listrslisthr1->addColumn("hr_fechaingreso");
$tso_listrslisthr1->addColumn("hr_nit_contra_ta");
$tso_listrslisthr1->addColumn("contractor_name");
$tso_listrslisthr1->addColumn("hr_asunto");
$tso_listrslisthr1->addColumn("hr_valor");
$tso_listrslisthr1->addColumn("CONTRATOID");
$tso_listrslisthr1->addColumn("hr_estado_firma");
$tso_listrslisthr1->setDefault("hr_id DESC");
$tso_listrslisthr1->Execute();

// Navigation
$nav_listrslisthr1 = new NAV_Regular("nav_listrslisthr1", "rslisthr", "../", $_SERVER['PHP_SELF'], 15);

//NeXTenesio3 Special List Recordset
$maxRows_rslisthr = $_SESSION['max_rows_nav_listrslisthr1'];
$pageNum_rslisthr = 0;
if (isset($_GET['pageNum_rslisthr'])) {
  $pageNum_rslisthr = $_GET['pageNum_rslisthr'];
}
$startRow_rslisthr = $pageNum_rslisthr * $maxRows_rslisthr;

// Defining List Recordset variable
$NXTFilter_rslisthr = "1=1";
if (isset($_SESSION['filter_tfi_listrslisthr1'])) {
  $NXTFilter_rslisthr = $_SESSION['filter_tfi_listrslisthr1'];
}
// Defining List Recordset variable
$NXTSort_rslisthr = "hr_id DESC";
if (isset($_SESSION['sorter_tso_listrslisthr1'])) {
  $NXTSort_rslisthr = $_SESSION['sorter_tso_listrslisthr1'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);

$query_rslisthr = "SELECT * FROM q_hoja_ruta_maestra_info_2015 WHERE {$NXTFilter_rslisthr} ORDER BY {$NXTSort_rslisthr} ";
$query_limit_rslisthr = sprintf("%s LIMIT %d, %d", $query_rslisthr, $startRow_rslisthr, $maxRows_rslisthr);
$rslisthr = mysql_query($query_limit_rslisthr, $oConnContratos) or die(mysql_error());
$row_rslisthr = mysql_fetch_assoc($rslisthr);

if (isset($_GET['totalRows_rslisthr'])) {
  $totalRows_rslisthr = $_GET['totalRows_rslisthr'];
} else {
  $all_rslisthr = mysql_query($query_rslisthr);
  $totalRows_rslisthr = mysql_num_rows($all_rslisthr);
}
$totalPages_rslisthr = ceil($totalRows_rslisthr/$maxRows_rslisthr)-1;
//End NeXTenesio3 Special List Recordset

$nav_listrslisthr1->checkBoundries();
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
  record_counter: false
}
</script>
<style type="text/css">
  /* Dynamic List row settings */
  .KT_col_hr_id {width:140px; overflow:hidden;}
  .KT_col_hr_anio {width:140px; overflow:hidden;}
  .KT_col_hr_fechaingreso {width:140px; overflow:hidden;}
  .KT_col_hr_nit_contra_ta {width:140px; overflow:hidden;}
  .KT_col_contractor_name {width:140px; overflow:hidden;}
  .KT_col_hr_asunto {width:140px; overflow:hidden;}
  .KT_col_hr_valor {width:140px; overflow:hidden;}
  .KT_col_CONTRATOID {width:140px; overflow:hidden;}
  .KT_col_hr_estado_firma {width:140px; overflow:hidden;}
</style>
<script type="text/javascript" src="../_jquery/hs/highslide/highslide-with-html.js"></script>
<link rel="stylesheet" type="text/css" href="../_jquery/hs/highslide/highslide.css" />
<script type="text/javascript">
hs.graphicsDir = '../_jquery/hs/highslide/graphics/';
hs.outlineType = 'rounded-white';
hs.wrapperClassName = 'draggable-header';
</script>
<link href="../_css/jqueryslidemenu.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php
  mxi_includes_start("../inc_top.php");
  require(basename("../inc_top.php"));
  mxi_includes_end();
?>
<p>&nbsp;
<div class="KT_tng" id="listrslisthr1">
  <h1> Asignados
    <?php
  $nav_listrslisthr1->Prepare();
  require("../includes/nav/NAV_Text_Statistics.inc.php");
?>
  </h1>
  <table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>
  <div class="KT_tnglist">
    <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
      <div class="KT_options"> <a href="<?php echo $nav_listrslisthr1->getShowAllLink(); ?>"><?php echo NXT_getResource("Show"); ?>
            <?php 
  // Show IF Conditional region1
  if (@$_GET['show_all_nav_listrslisthr1'] == 1) {
?>
              <?php echo $_SESSION['default_max_rows_nav_listrslisthr1']; ?>
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
  if (@$_SESSION['has_filter_tfi_listrslisthr1'] == 1) {
?>
                  <a href="<?php echo $tfi_listrslisthr1->getResetFilterLink(); ?>"><?php echo NXT_getResource("Reset filter"); ?></a>
                  <?php 
  // else Conditional region2
  } else { ?>
                  <a href="<?php echo $tfi_listrslisthr1->getShowFilterLink(); ?>"><?php echo NXT_getResource("Show filter"); ?></a>
                  <?php } 
  // endif Conditional region2
?>
      </div>
      <table cellpadding="2" cellspacing="0" class="KT_tngtable">
        <thead>
          <tr class="KT_row_order">
            <th>&nbsp;</th>
            <th id="hr_id" class="KT_sorter KT_col_hr_id <?php echo $tso_listrslisthr1->getSortIcon('hr_id'); ?>"> <a href="<?php echo $tso_listrslisthr1->getSortLink('hr_id'); ?>">RADICADO</a> </th>
            <th id="hr_anio" class="KT_sorter KT_col_hr_anio <?php echo $tso_listrslisthr1->getSortIcon('hr_anio'); ?>"> <a href="<?php echo $tso_listrslisthr1->getSortLink('hr_anio'); ?>">PERIODO</a> </th>
            <th id="hr_fechaingreso" class="KT_sorter KT_col_hr_fechaingreso <?php echo $tso_listrslisthr1->getSortIcon('hr_fechaingreso'); ?>"> <a href="<?php echo $tso_listrslisthr1->getSortLink('hr_fechaingreso'); ?>">FECHA REGISTRO</a> </th>
            <th id="hr_nit_contra_ta" class="KT_sorter KT_col_hr_nit_contra_ta <?php echo $tso_listrslisthr1->getSortIcon('hr_nit_contra_ta'); ?>"> <a href="<?php echo $tso_listrslisthr1->getSortLink('hr_nit_contra_ta'); ?>">DOCUMENTO</a> </th>
            <th id="contractor_name" class="KT_sorter KT_col_contractor_name <?php echo $tso_listrslisthr1->getSortIcon('contractor_name'); ?>"> <a href="<?php echo $tso_listrslisthr1->getSortLink('contractor_name'); ?>">BENEFICIARIO</a> </th>
            <th id="hr_asunto" class="KT_sorter KT_col_hr_asunto <?php echo $tso_listrslisthr1->getSortIcon('hr_asunto'); ?>"> <a href="<?php echo $tso_listrslisthr1->getSortLink('hr_asunto'); ?>">ASUNTO</a> </th>
            <th id="hr_valor" class="KT_sorter KT_col_hr_valor <?php echo $tso_listrslisthr1->getSortIcon('hr_valor'); ?>"> <a href="<?php echo $tso_listrslisthr1->getSortLink('hr_valor'); ?>">VALOR</a> </th>
            <th id="CONTRATOID" class="KT_sorter KT_col_CONTRATOID <?php echo $tso_listrslisthr1->getSortIcon('CONTRATOID'); ?>"> <a href="<?php echo $tso_listrslisthr1->getSortLink('CONTRATOID'); ?>">CONTRATO</a> </th>
            <th id="hr_estado_firma" class="KT_sorter KT_col_hr_estado_firma <?php echo $tso_listrslisthr1->getSortIcon('hr_estado_firma'); ?>"> <a href="<?php echo $tso_listrslisthr1->getSortLink('hr_estado_firma'); ?>">ESTADO PAGO</a> </th>
            <th>&nbsp;</th>
          </tr>
          <?php 
  // Show IF Conditional region3
  if (@$_SESSION['has_filter_tfi_listrslisthr1'] == 1) {
?>
            <tr class="KT_row_filter">
              <td>&nbsp;</td>
              <td><input type="text" name="tfi_listrslisthr1_hr_id" id="tfi_listrslisthr1_hr_id" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrslisthr1_hr_id']); ?>" size="20" maxlength="100" /></td>
              <td><input type="text" name="tfi_listrslisthr1_hr_anio" id="tfi_listrslisthr1_hr_anio" value="<?php echo @$_SESSION['tfi_listrslisthr1_hr_anio']; ?>" size="10" maxlength="22" /></td>
              <td><input type="text" name="tfi_listrslisthr1_hr_fechaingreso" id="tfi_listrslisthr1_hr_fechaingreso" value="<?php echo @$_SESSION['tfi_listrslisthr1_hr_fechaingreso']; ?>" size="10" maxlength="22" /></td>
              <td><input type="text" name="tfi_listrslisthr1_hr_nit_contra_ta" id="tfi_listrslisthr1_hr_nit_contra_ta" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrslisthr1_hr_nit_contra_ta']); ?>" size="20" maxlength="20" /></td>
              <td><input type="text" name="tfi_listrslisthr1_contractor_name" id="tfi_listrslisthr1_contractor_name" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrslisthr1_contractor_name']); ?>" size="20" maxlength="20" /></td>
              <td><input type="text" name="tfi_listrslisthr1_hr_asunto" id="tfi_listrslisthr1_hr_asunto" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrslisthr1_hr_asunto']); ?>" size="20" maxlength="20" /></td>
              <td><input type="text" name="tfi_listrslisthr1_hr_valor" id="tfi_listrslisthr1_hr_valor" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrslisthr1_hr_valor']); ?>" size="20" maxlength="100" /></td>
              <td><input type="text" name="tfi_listrslisthr1_CONTRATOID" id="tfi_listrslisthr1_CONTRATOID" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrslisthr1_CONTRATOID']); ?>" size="20" maxlength="20" /></td>
              <td><input type="text" name="tfi_listrslisthr1_hr_estado_firma" id="tfi_listrslisthr1_hr_estado_firma" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrslisthr1_hr_estado_firma']); ?>" size="20" maxlength="20" /></td>
              <td><input type="submit" name="tfi_listrslisthr1" value="<?php echo NXT_getResource("Filter"); ?>" /></td>
            </tr>
            <?php } 
  // endif Conditional region3
?>
        </thead>
        <tbody>
          <?php if ($totalRows_rslisthr == 0) { // Show if recordset empty ?>
            <tr>
              <td colspan="11"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
            </tr>
            <?php } // Show if recordset empty ?>
          <?php if ($totalRows_rslisthr > 0) { // Show if recordset not empty ?>
            <?php do { ?>
              <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
                <td><input type="hidden" name="hr_id" class="id_field" value="<?php echo $row_rslisthr['hr_id']; ?>" /><a href="hr_history_2015.php?hr_id=<?php echo $row_rslisthr['hr_id']; ?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )" title="historial"><img src="icons/326_history.png" width="32" height="32" border="0" /></a></td>
                <td><div class="titlemsg2"><?php echo KT_FormatForList($row_rslisthr['hr_id'], 20); ?></div></td>
                <td><div class="KT_col_hr_anio"><?php echo KT_formatDate($row_rslisthr['hr_anio']); ?></div></td>
                <td><div class="KT_col_hr_fechaingreso"><?php echo KT_formatDate($row_rslisthr['hr_fechaingreso']); ?></div></td>
                <td><div class="KT_col_hr_nit_contra_ta"><?php echo KT_FormatForList($row_rslisthr['hr_nit_contra_ta'], 20); ?></div></td>
                <td><div class="KT_col_contractor_name"><?php echo $row_rslisthr['contractor_name']; ?></div></td>
                <td><div class="KT_col_hr_asunto"><?php echo KT_FormatForList($row_rslisthr['hr_asunto'], 20); ?></div></td>
                <td align="right"><?php echo number_format($row_rslisthr['hr_valor'],2,',','.'); ?></td>
                <td align="center"><div class="KT_col_CONTRATOID"><a href="hr_info_contrato.php?CONTRATOID=<?php echo $row_rslisthr['CONTRATOID']; ?>&amp;Q=<?php echo $row_rslisthr['VIGENCIA']; ?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )" title="Informaci�n sobre este contrato"><?php echo KT_FormatForList($row_rslisthr['CONTRATOID'], 20); ?></a></div></td>
                <td align="center"><?php 
// Show IF Conditional region6 
if (@$row_rslisthr['not_status'] == 1) {
?><a href="hr_end_view.php?hr_id=<?php echo $row_rslisthr['hr_id']; ?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )" title="Ver comprobante de pago"><img src="icons/326_ok_1.png" border="0" /></a>
                <?php } 
// endif Conditional region7
?>
                <?php 
// Show IF Conditional region11 
if (@$row_rslisthr['not_status'] == 1) {
?>
                    <a href="valida_view_deducciones.php?obligacion=<?php echo $row_rslisthr['hrnoypay_obliga_num']; ?>&amp;doc=<?php echo $row_rslisthr['hr_nit_contra_ta']; ?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )" title="Ver detalle"><img src="icons/_324_pay.png" width="32" height="32" border="0" /></a>
                  <?php } 
// endif Conditional region11
?></td>
                <td><?php 
// Show IF Conditional region10 
if (@$row_rslisthr['hr_estado_firma'] == "N" and $row_rslisthr['not_status'] == "") {
?>
                    <table width="100%" border="0" cellspacing="2" cellpadding="0">
                      <tr>
                        <td align="center"><a href="hr_update_user.php?contractor_doc_id=<?php echo $row_rslisthr['hr_nit_contra_ta']; ?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )" title="Actualizar informaci�n del contratista"><img src="icons/326_User-Profile.png" width="32" height="32" border="0" /></a></td>
                        <?php 
// Show IF Conditional region4 
if (@$row_rslisthr['sys_update'] == 3 and $row_rslisthr['hr_id_fk'] == "") {
?>
                          <td align="center"><a href="hr_not_pago.php?hr_id=<?php echo $row_rslisthr['hr_id']; ?>&amp;contractor_doc_id=<?php echo $row_rslisthr['hr_nit_contra_ta']; ?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )" title="Crear notificaci�n de pago"><img src="icons/326_Payment-02.png" width="32" height="32" border="0" /></a> </td>
                          <?php } 
// endif Conditional region4
?>
                        <?php 
// Show IF Conditional region5 
if (@$row_rslisthr['hr_id_fk'] != "") {
?>
                          <td align="center"><a href="hr_not_pago.php?hr_id=<?php echo $row_rslisthr['hr_id']; ?>&amp;contractor_doc_id=<?php echo $row_rslisthr['hr_nit_contra_ta']; ?>&amp;hrnoypay_id=<?php echo $row_rslisthr['hrnoypay_id']; ?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )" title="Modificar notificaci�n de pago"><img src="icons/326_edit.png" width="32" height="32" border="0" /></a> </td>
                          <td align="center"><a href="../_gendraft/htmltodocx/_gen_not_pago.php?hr_id=<?php echo $row_rslisthr['hr_id']; ?>&amp;contractor_doc_id=<?php echo $row_rslisthr['hr_nit_contra_ta']; ?>&amp;hrnoypay_id=<?php echo $row_rslisthr['hrnoypay_id']; ?>" title="Generar documento para firma"><img src="icons/326_word_2.png" width="32" height="32" border="0" /></a></td>
                          <?php } 
// endif Conditional region5
?>
                        <td align="center"><a href="hr_not_user.php?hr_id=<?php echo $row_rslisthr['hr_id']; ?>&amp;contractor_doc_id=<?php echo $row_rslisthr['hr_nit_contra_ta']; ?>" title="Notificar al usuario" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )"><img src="icons/326_send_mail.png" width="32" height="32" border="0" /></a></td>
                      </tr>
                    </table>
                    <?php } 
// endif Conditional region10
?> 
                    </td>
              </tr>
              <?php } while ($row_rslisthr = mysql_fetch_assoc($rslisthr)); ?>
            <?php } // Show if recordset not empty ?>
        </tbody>
      </table>
      <div class="KT_bottomnav">
        <div>
          <?php
            $nav_listrslisthr1->Prepare();
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
</p>
<?php
  mxi_includes_start("../inc_foot.php");
  require(basename("../inc_foot.php"));
  mxi_includes_end();
?>
</body>
</html>
<?php
mysql_free_result($rslisthr);
?>
