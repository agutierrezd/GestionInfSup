<?php require_once('Connections/oConConfig.php'); ?>
<?php require_once('Connections/oConnUsers.php'); ?>
<?php
/*
Análisis, Diseño y Desarrollo: Alex Fernando Gutierrez
correo: dito73@gmail.com
correo inst: agutierrezd@mincit.gov.co
celular: 3017874143
*/
require_once('includes/common/KT_common.php');

// Load the tNG classes
require_once('includes/tng/tNG.inc.php');

// Make a transaction dispatcher instance
$tNGs = new tNG_dispatcher("");

// Make unified connection variable
$conn_oConnUsers = new KT_connection($oConnUsers, $database_oConnUsers);

//Start Restrict Access To Page
$restrict = new tNG_RestrictAccess($conn_oConnUsers, "");
//Grand Levels: Level
$restrict->addLevel("1");
$restrict->addLevel("2");
$restrict->addLevel("3");
$restrict->addLevel("4");
$restrict->addLevel("5");
$restrict->addLevel("6");
$restrict->addLevel("7");
$restrict->addLevel("8");
$restrict->Execute();
//End Restrict Access To Page

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
//MENU A
$colname_rsposa = "-1";
if (isset($_SESSION['kt_login_level'])) {
  $colname_rsposa = $_SESSION['kt_login_level'];
}
mysql_select_db($database_oConConfig, $oConConfig);
$query_rsposa = sprintf("SELECT * FROM local_menu WHERE menu_ubica = 1 AND menu_rol = %s AND menu_status = 1", GetSQLValueString($colname_rsposa, "text"));
$rsposa = mysql_query($query_rsposa, $oConConfig) or die(mysql_error());
$row_rsposa = mysql_fetch_assoc($rsposa);
$totalRows_rsposa = mysql_num_rows($rsposa);
// FIN MENU A

//MENU B
$colname_rsposb = "-1";
if (isset($_SESSION['kt_login_level'])) {
  $colname_rsposb = $_SESSION['kt_login_level'];
}
mysql_select_db($database_oConConfig, $oConConfig);
$query_rsposb = sprintf("SELECT * FROM local_menu WHERE menu_ubica = 2 AND menu_rol = %s AND menu_status = 1", GetSQLValueString($colname_rsposb, "text"));
$rsposb = mysql_query($query_rsposb, $oConConfig) or die(mysql_error());
$row_rsposb = mysql_fetch_assoc($rsposb);
$totalRows_rsposb = mysql_num_rows($rsposb);
// FIN MENU B
//MENU C
$colname_rsposc = "-1";
if (isset($_SESSION['kt_login_level'])) {
  $colname_rsposc = $_SESSION['kt_login_level'];
}
mysql_select_db($database_oConConfig, $oConConfig);
$query_rsposc = sprintf("SELECT * FROM local_menu WHERE menu_ubica = 3 AND menu_rol = %s AND menu_status = 1", GetSQLValueString($colname_rsposc, "text"));
$rsposc = mysql_query($query_rsposc, $oConConfig) or die(mysql_error());
$row_rsposc = mysql_fetch_assoc($rsposc);
$totalRows_rsposc = mysql_num_rows($rsposc);
// FIN MENU C
//MENU D
$colname_rsposd = "-1";
if (isset($_SESSION['kt_login_level'])) {
  $colname_rsposd = $_SESSION['kt_login_level'];
}
mysql_select_db($database_oConConfig, $oConConfig);
$query_rsposd = sprintf("SELECT * FROM local_menu WHERE menu_ubica = 4 AND menu_rol = %s AND menu_status = 1", GetSQLValueString($colname_rsposd, "text"));
$rsposd = mysql_query($query_rsposd, $oConConfig) or die(mysql_error());
$row_rsposd = mysql_fetch_assoc($rsposd);
$totalRows_rsposd = mysql_num_rows($rsposd);
// FIN MENU D
//MENU E
$colname_rspose = "-1";
if (isset($_SESSION['kt_login_level'])) {
  $colname_rspose = $_SESSION['kt_login_level'];
}
mysql_select_db($database_oConConfig, $oConConfig);
$query_rspose = sprintf("SELECT * FROM local_menu WHERE menu_ubica = 5 AND menu_rol = %s AND menu_status = 1", GetSQLValueString($colname_rspose, "text"));
$rspose = mysql_query($query_rspose, $oConConfig) or die(mysql_error());
$row_rspose = mysql_fetch_assoc($rspose);
$totalRows_rspose = mysql_num_rows($rspose);
// FIN MENU E
//MENU F
$colname_rsposf = "-1";
if (isset($_SESSION['kt_login_level'])) {
  $colname_rsposf = $_SESSION['kt_login_level'];
}
mysql_select_db($database_oConConfig, $oConConfig);
$query_rsposf = sprintf("SELECT * FROM local_menu WHERE menu_ubica = 6 AND menu_rol = %s AND menu_status = 1", GetSQLValueString($colname_rsposf, "text"));
$rsposf = mysql_query($query_rsposf, $oConConfig) or die(mysql_error());
$row_rsposf = mysql_fetch_assoc($rsposf);
$totalRows_rsposf = mysql_num_rows($rsposf);

// Make a logout transaction instance
$logoutTransaction = new tNG_logoutTransaction($conn_oConnUsers);
$tNGs->addTransaction($logoutTransaction);
// Register triggers
$logoutTransaction->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "GET", "KT_logout_now");
$logoutTransaction->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../contratos/index.php");
// Add columns
// End of logout transaction instance

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rscustom = $tNGs->getRecordset("custom");
$row_rscustom = mysql_fetch_assoc($rscustom);
$totalRows_rscustom = mysql_num_rows($rscustom);
// FIN MENU F
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link rel="stylesheet" type="text/css" href="_css/ddsmoothmenu.css" />
<link rel="stylesheet" type="text/css" href="_css/ddsmoothmenu-v.css" />
<script type="text/javascript" src="_js/ddsmoothmenu.js">
</script>
<script type="text/javascript">
ddsmoothmenu.init({
	mainmenuid: "smoothmenu1", //menu DIV id
	orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu', //class added to menu's outer DIV
	//customtheme: ["#1c5a80", "#18374a"],
	method: 'toggle', // set to 'hover' (default) or 'toggle'
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})
</script>
<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script src="includes/common/js/base.js" type="text/javascript"></script>
<script src="includes/common/js/utility.js" type="text/javascript"></script>
<script src="includes/skins/style.js" type="text/javascript"></script>
</head>
<body>
<table width="100%" border="0" cellspacing="2" cellpadding="0">
  <tr>
    <td height="77"><img src="img_mcit/logo_mincit.png" width="960" height="85" /></td>
  </tr>
  <tr>
    <td height="77"><div id="smoothmenu1" class="ddsmoothmenu">
<ul>
 <?php if ($totalRows_rsposa > 0) { // Show if recordset not empty ?>
<li><a href="#">CONTRATOS</a>
  <ul>
    <?php do { ?>
      <li><a href="<?php echo $row_rsposa['menu_link']; ?>"><?php echo $row_rsposa['menu_name']; ?></a></li>
    <?php } while ($row_rsposa = mysql_fetch_assoc($rsposa)); ?>
  </ul>
</li>
 <?php } // Show if recordset not empty ?>
<?php if ($totalRows_rsposb > 0) {?>
<li><a href="#">INFORMES DE SUPERVISI�N</a>
  <ul>
    <?php do { ?>
      <li><a href="<?php echo $row_rsposb['menu_link']; ?>"><?php echo $row_rsposb['menu_name']; ?></a></li>
    <?php } while ($row_rsposb = mysql_fetch_assoc($rsposb)); ?>
  </ul>
</li>
<?php } if ($totalRows_rsposc > 0) { ?>
<li><a href="#">GRUPO ADMINISTRATIVA</a>
  <ul>
    <?php do { ?>
      <li><a href="<?php echo $row_rsposc['menu_link']; ?>"><?php echo $row_rsposc['menu_name']; ?></a></li>
    <?php } while ($row_rsposc = mysql_fetch_assoc($rsposc)); ?>
  </ul>
</li>
<?php } if ($totalRows_rsposd > 0) { ?>
<li><a href="#">ALMACEN</a>
  <ul>
    <?php do { ?>
      <li><a href="<?php echo $row_rsposd['menu_link']; ?>"><?php echo $row_rsposd['menu_name']; ?></a></li>
    <?php } while ($row_rsposd = mysql_fetch_assoc($rsposd)); ?>
  </ul>
</li>
<?php } if ($totalRows_rspose > 0) { ?>
<li><a href="#">E</a>
  <ul>
    <?php do { ?>
      <li><a href="<?php echo $row_rspose['menu_link']; ?>"><?php echo $row_rspose['menu_name']; ?></a></li>
    <?php } while ($row_rspose = mysql_fetch_assoc($rspose)); ?>
  </ul>
</li>
<?php } if ($totalRows_rsposf > 0) { ?>
<li><a href="#">F</a>
  <ul>
    <?php do { ?>
      <li><a href="<?php echo $row_rsposf['menu_link']; ?>"><?php echo $row_rsposf['menu_name']; ?></a></li>
    <?php } while ($row_rsposf = mysql_fetch_assoc($rsposf)); ?>
  </ul>
</li>
<?php }?>
<li><a href="#/style/">PANEL DE CONTROL</a>
 <ul>
  <li><a href="#">Cambiar contrase�a</a></li>
  <li><a href="#">Guia de usuario</a></li>
  <li>
    <?php
	echo $tNGs->getErrorMsg();
?><a href="<?php echo $logoutTransaction->getLogoutLink(); ?>">Cerrar sesi�n</a></li>
</ul>
</li>
</ul>
<div align="right"><span class="mincit_textuser"><?php echo $_SESSION['kt_login_user']; ?>&nbsp;ID:<?php echo $_SESSION['kt_usr_dependencia']; ?><?php echo $_SESSION['kt_login_level']; ?>&nbsp;</span>
<br style="clear: left" />
</div>
    </div>
</td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($rsposa);
mysql_free_result($rsposb);
mysql_free_result($rsposc);
mysql_free_result($rsposd);
mysql_free_result($rspose);
mysql_free_result($rsposf);
?>
