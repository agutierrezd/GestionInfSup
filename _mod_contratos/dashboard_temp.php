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
$tfi_listrsinfocontratos1 = new TFI_TableFilter($conn_oConnContratos, "tfi_listrsinfocontratos1");
$tfi_listrsinfocontratos1->addColumn("contnumero", "STRING_TYPE", "contnumero", "%");
$tfi_listrsinfocontratos1->addColumn("cont_ano", "STRING_TYPE", "cont_ano", "%");
$tfi_listrsinfocontratos1->addColumn("cont_nit_contra_ta", "STRING_TYPE", "cont_nit_contra_ta", "%");
$tfi_listrsinfocontratos1->addColumn("cont_nom_contra_ta", "STRING_TYPE", "cont_nom_contra_ta", "%");
$tfi_listrsinfocontratos1->addColumn("cont_fecha_inicio", "DATE_TYPE", "cont_fecha_inicio", "=");
$tfi_listrsinfocontratos1->addColumn("cont_fechafinal", "DATE_TYPE", "cont_fechafinal", "=");
$tfi_listrsinfocontratos1->addColumn("cont_valori", "NUMERIC_TYPE", "cont_valori", "=");
$tfi_listrsinfocontratos1->addColumn("iint_nombres", "STRING_TYPE", "iint_nombres", "%");
$tfi_listrsinfocontratos1->Execute();

// Sorter
$tso_listrsinfocontratos1 = new TSO_TableSorter("rsinfocontratos", "tso_listrsinfocontratos1");
$tso_listrsinfocontratos1->addColumn("contnumero");
$tso_listrsinfocontratos1->addColumn("cont_ano");
$tso_listrsinfocontratos1->addColumn("cont_nit_contra_ta");
$tso_listrsinfocontratos1->addColumn("cont_nom_contra_ta");
$tso_listrsinfocontratos1->addColumn("cont_fecha_inicio");
$tso_listrsinfocontratos1->addColumn("cont_fechafinal");
$tso_listrsinfocontratos1->addColumn("cont_valori");
$tso_listrsinfocontratos1->addColumn("iint_nombres");
$tso_listrsinfocontratos1->setDefault("contnumero DESC");
$tso_listrsinfocontratos1->Execute();

// Navigation
$nav_listrsinfocontratos1 = new NAV_Regular("nav_listrsinfocontratos1", "rsinfocontratos", "../", $_SERVER['PHP_SELF'], 25);

//NeXTenesio3 Special List Recordset
$maxRows_rsinfocontratos = $_SESSION['max_rows_nav_listrsinfocontratos1'];
$pageNum_rsinfocontratos = 0;
if (isset($_GET['pageNum_rsinfocontratos'])) {
  $pageNum_rsinfocontratos = $_GET['pageNum_rsinfocontratos'];
}
$startRow_rsinfocontratos = $pageNum_rsinfocontratos * $maxRows_rsinfocontratos;

$colname_rsinfocontratos = "-1";
if (isset($_GET['anio_id'])) {
  $colname_rsinfocontratos = $_GET['anio_id'];
}
$coldep_rsinfocontratos = "-1";
if (isset($_SESSION['kt_usr_dependencia'])) {
  $coldep_rsinfocontratos = $_SESSION['kt_usr_dependencia'];
}
// Defining List Recordset variable
$NXTFilter_rsinfocontratos = "1=1";
if (isset($_SESSION['filter_tfi_listrsinfocontratos1'])) {
  $NXTFilter_rsinfocontratos = $_SESSION['filter_tfi_listrsinfocontratos1'];
}
// Defining List Recordset variable
$NXTSort_rsinfocontratos = "contnumero DESC";
if (isset($_SESSION['sorter_tso_listrsinfocontratos1'])) {
  $NXTSort_rsinfocontratos = $_SESSION['sorter_tso_listrsinfocontratos1'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);

$query_rsinfocontratos = sprintf("SELECT * FROM q_adm_contratos WHERE cont_ano = %s AND sesionusr = %s AND {$NXTFilter_rsinfocontratos} ORDER BY {$NXTSort_rsinfocontratos} ", GetSQLValueString($colname_rsinfocontratos, "text"),GetSQLValueString($coldep_rsinfocontratos, "text"));
$query_limit_rsinfocontratos = sprintf("%s LIMIT %d, %d", $query_rsinfocontratos, $startRow_rsinfocontratos, $maxRows_rsinfocontratos);
$rsinfocontratos = mysql_query($query_limit_rsinfocontratos, $oConnContratos) or die(mysql_error());
$row_rsinfocontratos = mysql_fetch_assoc($rsinfocontratos);

if (isset($_GET['totalRows_rsinfocontratos'])) {
  $totalRows_rsinfocontratos = $_GET['totalRows_rsinfocontratos'];
} else {
  $all_rsinfocontratos = mysql_query($query_rsinfocontratos);
  $totalRows_rsinfocontratos = mysql_num_rows($all_rsinfocontratos);
}
$totalPages_rsinfocontratos = ceil($totalRows_rsinfocontratos/$maxRows_rsinfocontratos)-1;
//End NeXTenesio3 Special List Recordset

$nav_listrsinfocontratos1->checkBoundries();
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
function dmxAdvLayerPopup(sTitle,sURL,sPopupName,sContent,sClass,nPositionLeft,nPositionRight,nWidth,nHeight,nAutoCloseTime,bDragable,bResizable,bOverlay,nOverlayOpacity,sIncomingEffect,sIncomingEffectEasing,nIncomingEffectDuration,bFadeIn,sOutgoingEffect,sOutgoingEffectEasing,nOutgoingEffectDuration,bFadeOut,sSlideEffect,nEffectTime,nSlideTime,bClosable,bWireframe,bgContentColor) { // v1.05
  var aURL, aSlides = sURL.split('|');
  if (aSlides && aSlides.length > 1) {
    aURL = [];
    for (var si=0;si<aSlides.length;si++) {
      var cf=aSlides[si],nW='',nH='',nS='';
      if (cf.substr(cf.length-1,1)==']') {
        var bd=cf.lastIndexOf('[');
        if(bd>0){
          var di=cf.substring(bd+1,cf.length-1);
          var da=di.split('x');
          nW=da[0];nH=da[1];
          if (da.length==3) nS=da[2];
          cf=cf.substring(0,bd)
        }   
      }      
      aURL[si] = new Object();
      aURL[si].src = cf;
      aURL[si].nWidth = (nW!=''?nW:nWidth);
      aURL[si].nHeight = (nH!=''?nH:nHeight);
      aURL[si].nDelay = (nS!=''?nS:nSlideTime);
    }  
  } else aURL = sURL;
  if (!cDMXPopupWindow) {
  	alert('The Advanced Layer Popup script is missing on your website!\nPlease upload the file ScriptLibrary/advLayerPopup.js to your live server.');
  } else {
    if (sClass == 'OS_Look') sClass = (navigator.userAgent.toLowerCase().indexOf('mac')!=-1?'dmxOSX':'dmxXP');  
    cDMXPopupWindow.buildWindow({sTitle: sTitle, sURL: aURL, sPopupName: sPopupName, sContent: sContent, sClass: sClass, aPosition: [nPositionLeft,nPositionRight], aSize: [nWidth,nHeight], nCloseDelay: nAutoCloseTime, bDragable: bDragable, bResizable: bResizable, bOverlay: bOverlay, nOverlayOpacity: nOverlayOpacity, sStartPosition: sIncomingEffect, sStartShowEffect: sIncomingEffectEasing, nIncomingEffectDuration: nIncomingEffectDuration, bFadeIn: bFadeIn, sEndPosition: sOutgoingEffect, sEndShowEffect: sOutgoingEffectEasing, nOutgoingEffectDuration: nOutgoingEffectDuration, bFadeOut: bFadeOut, sSlideEffect: sSlideEffect, nEffectTime: nEffectTime, nSlideTime: nSlideTime, bClosable: bClosable, bWireframe: bWireframe, sContentBgColor: bgContentColor });
  }  
  document.MM_returnValue = false;
}
</script>
<style type="text/css">
  /* Dynamic List row settings */
  .KT_col_contnumero {width:140px; overflow:hidden;}
  .KT_col_cont_ano {width:140px; overflow:hidden;}
  .KT_col_cont_nit_contra_ta {width:140px; overflow:hidden;}
  .KT_col_cont_nom_contra_ta {width:140px; overflow:hidden;}
  .KT_col_cont_fecha_inicio {width:140px; overflow:hidden;}
  .KT_col_cont_fechafinal {width:140px; overflow:hidden;}
  .KT_col_cont_valori {width:140px; overflow:hidden;}
  .KT_col_iint_nombres {width:140px; overflow:hidden;}
</style>
<link href="../Styles/dmxpopup.css" rel="stylesheet" type="text/css" />
<link href="../Styles/OS_Look/OS_Look.css" rel="stylesheet" type="text/css" />
<script src="../ScriptLibrary/advLayerPopup.js" type="text/javascript"></script>
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
	<script>
	$(function() {
		$( "#rerun" )
			.button()
			.click(function() {
				alert( "Seleccionar periodo" );
			})
			.next()
				.button({
					text: false,
					icons: {
						primary: "ui-icon-triangle-1-s"
					}
				})
				.click(function() {
					var menu = $( this ).parent().next().show().position({
						my: "left top",
						at: "left bottom",
						of: this
					});
					$( document ).one( "click", function() {
						menu.hide();
					});
					return false;
				})
				.parent()
					.buttonset()
					.next()
						.hide()
						.menu();
	});
	</script>
</head>

<body>
<?php
  mxi_includes_start("../inc_top_2.php");
  require(basename("../inc_top_2.php"));
  mxi_includes_end();
?>
<div>
	<div>
		<button id="rerun">Seleccione el periodo</button>
		<button id="select">Periodo</button>
	</div>
	<ul>
		<li><a href="dashboard.php?anio_id=2013">2013</a></li>
        <li><a href="dashboard.php?anio_id=2012">2012</a></li>
		<li><a href="dashboard.php?anio_id=2011">2011</a></li>
	</ul>
</div><br />
<div class="KT_tng" id="listrsinfocontratos1">
  <h1>Lista de contratos <?php echo $_GET['anio_id']; ?>&nbsp;
grupo <?php echo $_SESSION['kt_usr_dependencia']; ?>   
<?php
  $nav_listrsinfocontratos1->Prepare();
  require("../includes/nav/NAV_Text_Statistics.inc.php");
?>
  </h1>
  <div class="KT_tnglist">
    <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
      <div class="KT_options"> <a href="<?php echo $nav_listrsinfocontratos1->getShowAllLink(); ?>"><?php echo NXT_getResource("Show"); ?>
            <?php 
  // Show IF Conditional region1
  if (@$_GET['show_all_nav_listrsinfocontratos1'] == 1) {
?>
              <?php echo $_SESSION['default_max_rows_nav_listrsinfocontratos1']; ?>
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
  if (@$_SESSION['has_filter_tfi_listrsinfocontratos1'] == 1) {
?>
                  <a href="<?php echo $tfi_listrsinfocontratos1->getResetFilterLink(); ?>"><?php echo NXT_getResource("Reset filter"); ?></a>
                  <?php 
  // else Conditional region2
  } else { ?>
                  <a href="<?php echo $tfi_listrsinfocontratos1->getShowFilterLink(); ?>"><?php echo NXT_getResource("Show filter"); ?></a>
                  <?php } 
  // endif Conditional region2
?>
      </div>
      <table cellpadding="2" cellspacing="0" class="KT_tngtable">
        <thead>
          <tr class="KT_row_order">
            <th>&nbsp;</th>
            <th id="contnumero" class="KT_sorter KT_col_contnumero <?php echo $tso_listrsinfocontratos1->getSortIcon('contnumero'); ?>"> <a href="<?php echo $tso_listrsinfocontratos1->getSortLink('contnumero'); ?>">CONTRATO</a> </th>
            <th id="cont_ano" class="KT_sorter KT_col_cont_ano <?php echo $tso_listrsinfocontratos1->getSortIcon('cont_ano'); ?>"> <a href="<?php echo $tso_listrsinfocontratos1->getSortLink('cont_ano'); ?>">PERIODO</a> </th>
            <th id="cont_nit_contra_ta" class="KT_sorter KT_col_cont_nit_contra_ta <?php echo $tso_listrsinfocontratos1->getSortIcon('cont_nit_contra_ta'); ?>"> <a href="<?php echo $tso_listrsinfocontratos1->getSortLink('cont_nit_contra_ta'); ?>">NIT/DOC</a> </th>
            <th id="cont_nom_contra_ta" class="KT_sorter KT_col_cont_nom_contra_ta <?php echo $tso_listrsinfocontratos1->getSortIcon('cont_nom_contra_ta'); ?>"> <a href="<?php echo $tso_listrsinfocontratos1->getSortLink('cont_nom_contra_ta'); ?>">RAZON/NOMBRE</a> </th>
            <th id="cont_fecha_inicio" class="KT_sorter KT_col_cont_fecha_inicio <?php echo $tso_listrsinfocontratos1->getSortIcon('cont_fecha_inicio'); ?>"> <a href="<?php echo $tso_listrsinfocontratos1->getSortLink('cont_fecha_inicio'); ?>">FECHA INICIO</a> </th>
            <th id="cont_fechafinal" class="KT_sorter KT_col_cont_fechafinal <?php echo $tso_listrsinfocontratos1->getSortIcon('cont_fechafinal'); ?>"> <a href="<?php echo $tso_listrsinfocontratos1->getSortLink('cont_fechafinal'); ?>">FECHA FINAL</a> </th>
            <th id="cont_valori" class="KT_sorter KT_col_cont_valori <?php echo $tso_listrsinfocontratos1->getSortIcon('cont_valori'); ?>"> <a href="<?php echo $tso_listrsinfocontratos1->getSortLink('cont_valori'); ?>">VALOR INICIAL</a> </th>
            <th id="iint_nombres" class="KT_sorter KT_col_iint_nombres <?php echo $tso_listrsinfocontratos1->getSortIcon('iint_nombres'); ?>"> <a href="<?php echo $tso_listrsinfocontratos1->getSortLink('iint_nombres'); ?>">SUPERVISOR</a> </th>
            <th>&nbsp;</th>
          </tr>
          <?php 
  // Show IF Conditional region3
  if (@$_SESSION['has_filter_tfi_listrsinfocontratos1'] == 1) {
?>
            <tr class="KT_row_filter">
              <td>&nbsp;</td>
              <td><input type="text" name="tfi_listrsinfocontratos1_contnumero" id="tfi_listrsinfocontratos1_contnumero" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrsinfocontratos1_contnumero']); ?>" size="20" maxlength="20" /></td>
              <td><input type="text" name="tfi_listrsinfocontratos1_cont_ano" id="tfi_listrsinfocontratos1_cont_ano" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrsinfocontratos1_cont_ano']); ?>" size="20" maxlength="20" /></td>
              <td><input type="text" name="tfi_listrsinfocontratos1_cont_nit_contra_ta" id="tfi_listrsinfocontratos1_cont_nit_contra_ta" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrsinfocontratos1_cont_nit_contra_ta']); ?>" size="20" maxlength="20" /></td>
              <td><input type="text" name="tfi_listrsinfocontratos1_cont_nom_contra_ta" id="tfi_listrsinfocontratos1_cont_nom_contra_ta" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrsinfocontratos1_cont_nom_contra_ta']); ?>" size="20" maxlength="20" /></td>
              <td><input type="text" name="tfi_listrsinfocontratos1_cont_fecha_inicio" id="tfi_listrsinfocontratos1_cont_fecha_inicio" value="<?php echo @$_SESSION['tfi_listrsinfocontratos1_cont_fecha_inicio']; ?>" size="10" maxlength="22" /></td>
              <td><input type="text" name="tfi_listrsinfocontratos1_cont_fechafinal" id="tfi_listrsinfocontratos1_cont_fechafinal" value="<?php echo @$_SESSION['tfi_listrsinfocontratos1_cont_fechafinal']; ?>" size="10" maxlength="22" /></td>
              <td><input type="text" name="tfi_listrsinfocontratos1_cont_valori" id="tfi_listrsinfocontratos1_cont_valori" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrsinfocontratos1_cont_valori']); ?>" size="20" maxlength="100" /></td>
              <td><input type="text" name="tfi_listrsinfocontratos1_iint_nombres" id="tfi_listrsinfocontratos1_iint_nombres" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrsinfocontratos1_iint_nombres']); ?>" size="20" maxlength="20" /></td>
              <td><input type="submit" name="tfi_listrsinfocontratos1" value="<?php echo NXT_getResource("Filter"); ?>" /></td>
            </tr>
            <?php } 
  // endif Conditional region3
?>
        </thead>
        <tbody>
          <?php if ($totalRows_rsinfocontratos == 0) { // Show if recordset empty ?>
            <tr>
              <td colspan="10"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
            </tr>
            <?php } // Show if recordset empty ?>
          <?php if ($totalRows_rsinfocontratos > 0) { // Show if recordset not empty ?>
            <?php do { ?>
              <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
                <td><a href="cont_adm.php?hash_one=<?php echo md5($row_rsinfocontratos['cont_nit_contra_ta']); ?>&amp;doc_id=<?php echo $row_rsinfocontratos['id_cont']; ?>&amp;hash_two=<?php echo md5($row_rsinfocontratos['id_cont']); ?>&amp;cont_id=<?php echo $row_rsinfocontratos['contnumero']; ?>&amp;anio_id=<?php echo $row_rsinfocontratos['cont_ano']; ?>&amp;cdp_id=<?php echo $row_rsinfocontratos['prenumero']; ?>&amp;rp_id=<?php echo $row_rsinfocontratos['numregistro']; ?>&amp;rubro_id=<?php echo $row_rsinfocontratos['cont_codrubro']; ?>&amp;cc_id=<?php echo $row_rsinfocontratos['DOCUMENTO']; ?>" title="Administrar contrato"><img src="icons/321_tab.png" width="32" height="32" border="0" /></a>
                  <input type="hidden" name="id_cont" class="id_field" value="<?php echo $row_rsinfocontratos['id_cont']; ?>" />
                </td><td><div class="KT_col_contnumero"><?php echo KT_FormatForList($row_rsinfocontratos['contnumero'], 20); ?></div></td>
                <td><div class="KT_col_cont_ano"><?php echo KT_FormatForList($row_rsinfocontratos['cont_ano'], 20); ?></div></td>
                <td><div class="KT_col_cont_nit_contra_ta"><?php echo KT_FormatForList($row_rsinfocontratos['cont_nit_contra_ta'], 20); ?></div></td>
                <td><div class="KT_col_cont_nom_contra_ta"><a href="#"><img src="icons/241_view_1.png" width="24" height="24" border="0" onclick="dmxAdvLayerPopup('INFORMACION DE CONTRATO','../_mod_infsup/info_contrato.php?cont_id=<?php echo $row_rsinfocontratos['contnumero']; ?>&amp;anio_id=<?php echo $row_rsinfocontratos['cont_ano']; ?>&amp;doc_id=<?php echo $row_rsinfocontratos['id_cont']; ?>','CONTRATO','','OS_Look','center','center',650,400,0,true,false,false,80,'','Linear',1,true,'','Linear',1,true,'',1,5,true,false,'#FFFFFF');return document.MM_returnValue" /></a><?php echo $row_rsinfocontratos['cont_nom_contra_ta']; ?></div></td>
                <td><div class="KT_col_cont_fecha_inicio"><?php echo KT_formatDate($row_rsinfocontratos['cont_fecha_inicio']); ?></div></td>
                <td><div class="KT_col_cont_fechafinal"><?php echo KT_formatDate($row_rsinfocontratos['cont_fechafinal']); ?></div></td>
                <td align="right"><div class="KT_col_cont_valori"><?php echo number_format($row_rsinfocontratos['cont_valori'],0,',','.'); ?></div></td>
                <td><div class="KT_col_iint_nombres"><?php echo $row_rsinfocontratos['iint_nombres']; ?></div></td>
                <td><a class="KT_edit_link" href="contrato_adm.php?id_cont=<?php echo $row_rsinfocontratos['id_cont']; ?>&amp;KT_back=1"><?php echo NXT_getResource("edit_one"); ?></a></td>
              </tr>
              <?php } while ($row_rsinfocontratos = mysql_fetch_assoc($rsinfocontratos)); ?>
            <?php } // Show if recordset not empty ?>
        </tbody>
      </table>
      <div class="KT_bottomnav">
        <div>
          <?php
            $nav_listrsinfocontratos1->Prepare();
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
<?php
  mxi_includes_start("../inc_foot.php");
  require(basename("../inc_foot.php"));
  mxi_includes_end();
?>
</body>
</html>
<?php
mysql_free_result($rsinfocontratos);
?>
