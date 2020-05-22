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
$tfi_listrslist1 = new TFI_TableFilter($conn_oConnContratos, "tfi_listrslist1");
$tfi_listrslist1->addColumn("hr_id", "NUMERIC_TYPE", "hr_id", "=");
$tfi_listrslist1->addColumn("hr_anio", "DATE_TYPE", "hr_anio", "=");
$tfi_listrslist1->addColumn("hr_fechaingreso", "DATE_TYPE", "hr_fechaingreso", "=");
$tfi_listrslist1->addColumn("hr_asunto", "STRING_TYPE", "hr_asunto", "%");
$tfi_listrslist1->addColumn("hr_valor", "DOUBLE_TYPE", "hr_valor", "=");
$tfi_listrslist1->addColumn("hr_nit_contra_ta", "STRING_TYPE", "hr_nit_contra_ta", "%");
$tfi_listrslist1->addColumn("contractor_name", "STRING_TYPE", "contractor_name", "%");
$tfi_listrslist1->addColumn("CONTRATOID", "STRING_TYPE", "CONTRATOID", "%");
$tfi_listrslist1->addColumn("hr_estado_firma", "STRING_TYPE", "hr_estado_firma", "%");
$tfi_listrslist1->Execute();

// Sorter
$tso_listrslist1 = new TSO_TableSorter("rslist", "tso_listrslist1");
$tso_listrslist1->addColumn("hr_id");
$tso_listrslist1->addColumn("hr_anio");
$tso_listrslist1->addColumn("hr_fechaingreso");
$tso_listrslist1->addColumn("hr_asunto");
$tso_listrslist1->addColumn("hr_valor");
$tso_listrslist1->addColumn("hr_nit_contra_ta");
$tso_listrslist1->addColumn("contractor_name");
$tso_listrslist1->addColumn("CONTRATOID");
$tso_listrslist1->addColumn("hr_estado_firma");
$tso_listrslist1->setDefault("hr_id DESC");
$tso_listrslist1->Execute();

// Navigation
$nav_listrslist1 = new NAV_Regular("nav_listrslist1", "rslist", "../", $_SERVER['PHP_SELF'], 25);

//NeXTenesio3 Special List Recordset
$maxRows_rslist = $_SESSION['max_rows_nav_listrslist1'];
$pageNum_rslist = 0;
if (isset($_GET['pageNum_rslist'])) {
  $pageNum_rslist = $_GET['pageNum_rslist'];
}
$startRow_rslist = $pageNum_rslist * $maxRows_rslist;

// Defining List Recordset variable
$NXTFilter_rslist = "1=1";
if (isset($_SESSION['filter_tfi_listrslist1'])) {
  $NXTFilter_rslist = $_SESSION['filter_tfi_listrslist1'];
}
// Defining List Recordset variable
$NXTSort_rslist = "hr_id DESC";
if (isset($_SESSION['sorter_tso_listrslist1'])) {
  $NXTSort_rslist = $_SESSION['sorter_tso_listrslist1'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);

$query_rslist = "SELECT * FROM q_hoja_ruta_maestra_info WHERE {$NXTFilter_rslist} ORDER BY {$NXTSort_rslist} ";
$query_limit_rslist = sprintf("%s LIMIT %d, %d", $query_rslist, $startRow_rslist, $maxRows_rslist);
$rslist = mysql_query($query_limit_rslist, $oConnContratos) or die(mysql_error());
$row_rslist = mysql_fetch_assoc($rslist);

if (isset($_GET['totalRows_rslist'])) {
  $totalRows_rslist = $_GET['totalRows_rslist'];
} else {
  $all_rslist = mysql_query($query_rslist);
  $totalRows_rslist = mysql_num_rows($all_rslist);
}
$totalPages_rslist = ceil($totalRows_rslist/$maxRows_rslist)-1;
//End NeXTenesio3 Special List Recordset

$nav_listrslist1->checkBoundries();

// Download File downloadObj1
$downloadObj1 = new tNG_Download("../", "KT_download1");
// Execute
$downloadObj1->setFolder("../_attach_pagos/");
$downloadObj1->setRenameRule("{rslist.hr_file}");
$downloadObj1->Execute();

// Download File downloadObj2
$downloadObj2 = new tNG_Download("../", "KT_download2");
// Execute
$downloadObj2->setFolder("../_attach_pagos/");
$downloadObj2->setRenameRule("{rslist.hr_file}");
$downloadObj2->Execute();
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
  .KT_col_hr_id {width:100px; overflow:hidden;}
  .KT_col_hr_anio {width:100px; overflow:hidden;}
  .KT_col_hr_fechaingreso {width:100px; overflow:hidden;}
  .KT_col_hr_asunto {width:140px; overflow:hidden;}
  .KT_col_hr_valor {width:140px; overflow:hidden;}
  .KT_col_hr_nit_contra_ta {width:140px; overflow:hidden;}
  .KT_col_contractor_name {width:140px; overflow:hidden;}
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
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;
      <div class="KT_tng" id="listrslist1">
        <h1> Hoja de Ruta
          <?php
  $nav_listrslist1->Prepare();
  require("../includes/nav/NAV_Text_Statistics.inc.php");
?>
        </h1>
        <div class="KT_tnglist">
          <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
            <div class="KT_options"> <a href="<?php echo $nav_listrslist1->getShowAllLink(); ?>"><?php echo NXT_getResource("Show"); ?>
              <?php 
  // Show IF Conditional region1
  if (@$_GET['show_all_nav_listrslist1'] == 1) {
?>
                <?php echo $_SESSION['default_max_rows_nav_listrslist1']; ?>
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
  if (@$_SESSION['has_filter_tfi_listrslist1'] == 1) {
?>
                  <a href="<?php echo $tfi_listrslist1->getResetFilterLink(); ?>"><?php echo NXT_getResource("Reset filter"); ?></a>
                  <?php 
  // else Conditional region2
  } else { ?>
                  <a href="<?php echo $tfi_listrslist1->getShowFilterLink(); ?>"><?php echo NXT_getResource("Show filter"); ?></a>
                  <?php } 
  // endif Conditional region2
?>
            </div>
            <table cellpadding="2" cellspacing="0" class="KT_tngtable">
              <thead>
                <tr class="KT_row_order">
                  <th>&nbsp;</th>
                  <th id="hr_id" class="KT_sorter KT_col_hr_id <?php echo $tso_listrslist1->getSortIcon('hr_id'); ?>"> <a href="<?php echo $tso_listrslist1->getSortLink('hr_id'); ?>">RADICADO</a> </th>
                  <th id="hr_anio" class="KT_sorter KT_col_hr_anio <?php echo $tso_listrslist1->getSortIcon('hr_anio'); ?>"> <a href="<?php echo $tso_listrslist1->getSortLink('hr_anio'); ?>">PERIODO</a> </th>
                  <th id="hr_fechaingreso" class="KT_sorter KT_col_hr_fechaingreso <?php echo $tso_listrslist1->getSortIcon('hr_fechaingreso'); ?>"> <a href="<?php echo $tso_listrslist1->getSortLink('hr_fechaingreso'); ?>">FECHA DE REGISTRO</a> </th>
                  <th id="hr_asunto" class="KT_sorter KT_col_hr_asunto <?php echo $tso_listrslist1->getSortIcon('hr_asunto'); ?>"> <a href="<?php echo $tso_listrslist1->getSortLink('hr_asunto'); ?>">ASUNTO</a> </th>
                  <th id="hr_valor" class="KT_sorter KT_col_hr_valor <?php echo $tso_listrslist1->getSortIcon('hr_valor'); ?>"> <a href="<?php echo $tso_listrslist1->getSortLink('hr_valor'); ?>">VALOR</a> </th>
                  <th id="hr_nit_contra_ta" class="KT_sorter KT_col_hr_nit_contra_ta <?php echo $tso_listrslist1->getSortIcon('hr_nit_contra_ta'); ?>"> <a href="<?php echo $tso_listrslist1->getSortLink('hr_nit_contra_ta'); ?>">DOCUMENTO</a> </th>
                  <th id="contractor_name" class="KT_sorter KT_col_contractor_name <?php echo $tso_listrslist1->getSortIcon('contractor_name'); ?>"> <a href="<?php echo $tso_listrslist1->getSortLink('contractor_name'); ?>">BENEFICIARIO</a> </th>
                  <th id="CONTRATOID" class="KT_sorter KT_col_CONTRATOID <?php echo $tso_listrslist1->getSortIcon('CONTRATOID'); ?>"> <a href="<?php echo $tso_listrslist1->getSortLink('CONTRATOID'); ?>">CONTRATO</a> </th>
                  <th id="hr_estado_firma" class="KT_sorter KT_col_hr_estado_firma <?php echo $tso_listrslist1->getSortIcon('hr_estado_firma'); ?>"> <a href="<?php echo $tso_listrslist1->getSortLink('hr_estado_firma'); ?>">ESTADO PAGO </a> </th>
                  <th>&nbsp;</th>
                </tr>
                <?php 
  // Show IF Conditional region3
  if (@$_SESSION['has_filter_tfi_listrslist1'] == 1) {
?>
                  <tr class="KT_row_filter">
                    <td>&nbsp;</td>
                    <td><input type="text" name="tfi_listrslist1_hr_id" id="tfi_listrslist1_hr_id" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrslist1_hr_id']); ?>" size="20" maxlength="100" /></td>
                    <td><input type="text" name="tfi_listrslist1_hr_anio" id="tfi_listrslist1_hr_anio" value="<?php echo @$_SESSION['tfi_listrslist1_hr_anio']; ?>" size="10" maxlength="22" /></td>
                    <td><input type="text" name="tfi_listrslist1_hr_fechaingreso" id="tfi_listrslist1_hr_fechaingreso" value="<?php echo @$_SESSION['tfi_listrslist1_hr_fechaingreso']; ?>" size="10" maxlength="22" /></td>
                    <td><input type="text" name="tfi_listrslist1_hr_asunto" id="tfi_listrslist1_hr_asunto" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrslist1_hr_asunto']); ?>" size="20" maxlength="20" /></td>
                    <td><input type="text" name="tfi_listrslist1_hr_valor" id="tfi_listrslist1_hr_valor" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrslist1_hr_valor']); ?>" size="20" maxlength="100" /></td>
                    <td><input type="text" name="tfi_listrslist1_hr_nit_contra_ta" id="tfi_listrslist1_hr_nit_contra_ta" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrslist1_hr_nit_contra_ta']); ?>" size="20" maxlength="20" /></td>
                    <td><input type="text" name="tfi_listrslist1_contractor_name" id="tfi_listrslist1_contractor_name" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrslist1_contractor_name']); ?>" size="20" maxlength="20" /></td>
                    <td><input type="text" name="tfi_listrslist1_CONTRATOID" id="tfi_listrslist1_CONTRATOID" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrslist1_CONTRATOID']); ?>" size="20" maxlength="20" /></td>
                    <td><input type="text" name="tfi_listrslist1_hr_estado_firma" id="tfi_listrslist1_hr_estado_firma" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrslist1_hr_estado_firma']); ?>" size="20" maxlength="20" /></td>
                    <td><input type="submit" name="tfi_listrslist1" value="<?php echo NXT_getResource("Filter"); ?>" /></td>
                  </tr>
                  <?php } 
  // endif Conditional region3
?>
              </thead>
              <tbody>
                <?php if ($totalRows_rslist == 0) { // Show if recordset empty ?>
                  <tr>
                    <td colspan="11"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
                  </tr>
                  <?php } // Show if recordset empty ?>
                <?php if ($totalRows_rslist > 0) { // Show if recordset not empty ?>
                  <?php do { ?>
                    <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
                      <td><input type="hidden" name="hr_id" class="id_field" value="<?php echo $row_rslist['hr_id']; ?>" />
                        <table width="100%" border="0" cellspacing="2" cellpadding="0">
                            <tr>
                              <?php 
// Show If File Exists (region6)
if (tNG_fileExists("../_attach_pagos/", "{rslist.hr_file}")) {
?><td align="center"><a href="<?php echo $downloadObj2->getDownloadLink(); ?>">
                                
                                  <img src="icons/326_Download.png" width="32" height="32" border="0" />
                                  </a></td><?php } 
// EndIf File Exists (region6)
?>
                              <td align="center"><a href="hr_history.php?hr_id=<?php echo $row_rslist['hr_id']; ?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )" title="historial"><img src="icons/326_history.png" width="32" height="32" border="0" /></a></td>
                              <td align="center"><a href="send_hr.php?hr_id=<?php echo $row_rslist['hr_id']; ?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )" title="Realizar acci�n">
                                
                                  <img src="icons/326_send_mail.png" width="32" height="32" border="0" />
                                  </a></td>
                              
                            </tr>
                          </table></td>
                      <td><div class="titlemsg2"><?php echo $row_rslist['hr_id']; ?></div></td>
                      <td><div class="KT_col_hr_anio"><?php echo KT_formatDate($row_rslist['hr_anio']); ?></div></td>
                      <td><div class="KT_col_hr_fechaingreso"><?php echo $row_rslist['hr_fechaingreso']; ?></div></td>
                      <td><textarea name="textarea" id="textarea" cols="38" rows="3"><?php echo $row_rslist['hr_asunto']; ?></textarea></td>
                      <td align="right"><div class="KT_col_hr_valor">
                        <?php 
// Show IF Conditional region9 
if (@$_SESSION['kt_login_level'] == 2) {
?><a href="hr_edit_m.php?hr_id=<?php echo $row_rslist['hr_id']; ?>&amp;KT_back=1" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )" title="Modificar valor">
                          <img src="icons/242_edit.png" width="24" height="24" border="0" /></a>
                          <?php } 
// endif Conditional region9
?>$<?php echo number_format($row_rslist['hr_valor'],0,',',','); ?></div></td>
                      <td><div class="KT_col_hr_nit_contra_ta"><?php echo KT_FormatForList($row_rslist['hr_nit_contra_ta'], 20); ?></div></td>
                      <td><div class="KT_col_contractor_name"><?php echo $row_rslist['contractor_name']; ?></div></td>
                      <td><div class="KT_col_CONTRATOID"><a href="hr_info_contrato.php?CONTRATOID=<?php echo $row_rslist['CONTRATOID']; ?>&amp;Q=<?php echo $row_rslist['VIGENCIA']; ?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )" title="Informaci�n del contrato"><?php echo KT_FormatForList($row_rslist['CONTRATOID'], 20); ?></a></div></td>
                      <td align="center"><div class="KT_col_hr_estado_firma">
                        <p>
                          <?php 
// Show IF Conditional region8 
if (@$row_rslist['hr_estado_firma'] == "S") {
?>
                            <a href="hr_end_view.php?hr_id=<?php echo $row_rslist['hr_id']; ?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )" title="Ver comprobante de pago"><img src="icons/326_ok_1.png" width="32" height="32" border="0" /></a>
                            <?php } 
// endif Conditional region8
?><br />
                            <br />
                            <br />
                          </p>
                      </div></td>
                      <td><?php 
// Show IF Conditional region5 
if (@$row_rslist['evento_type'] == 1 and $_SESSION['kt_login_level'] == 2) {
?><a href="hr_edit.php?hr_id=<?php echo $row_rslist['hr_id']; ?>&amp;KT_back=1" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )" title="Crear Hoja Ruta">
                        
                          <img src="icons/326_edit.png" width="32" height="32" border="0" />
                         </a><?php } 
// endif Conditional region5
?><a href="hr_attach.php?hr_id=<?php echo $row_rslist['hr_id']; ?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )" title="Adjuntar soporte documental"><img src="icons/326_Attach.png" width="32" height="32" border="0" /></a><?php 
// Show IF Conditional region6 
if (@$row_rslist['evento_type'] == 1 and $_SESSION['kt_login_level'] == 2) {
?><a href="send_hr_001a.php?hr_id=<?php echo $row_rslist['hr_id']; ?>" title="Enviar a Contabilidad">
                      
                        <img src="icons/326_Transaction-Fee.png" width="32" height="32" border="0" />
                        </a>
                             <?php } 
// endif Conditional region6
?></td>
                    </tr>
                    <?php } while ($row_rslist = mysql_fetch_assoc($rslist)); ?>
                  <?php } // Show if recordset not empty ?>
              </tbody>
            </table>
            <div class="KT_bottomnav">
              <div>
                <?php
            $nav_listrslist1->Prepare();
            require("../includes/nav/NAV_Text_Navigation.inc.php");
          ?>
              </div>
            </div>
            <div class="KT_bottombuttons">
              <div class="KT_operations"></div>
<span>&nbsp;</span><a href="hr_new_2.php" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )" title="Crear Hoja Ruta">
<?php 
// Show IF Conditional region9 
if (@$_SESSION['kt_login_level'] == 2) {
?>
  <img src="icons/326_pay.png" width="32" height="32" border="0" />
  <?php } 
// endif Conditional region9
?></a> </div>
          </form>
        </div>
        <br class="clearfixplain" />
      </div>
    <p>&nbsp;</p></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
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
mysql_free_result($rslist);
?>
