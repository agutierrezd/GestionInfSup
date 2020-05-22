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



//MENU A

// FIN MENU A

//MENU B

// FIN MENU B
//MENU C

// FIN MENU C
//MENU D

// FIN MENU D
//MENU E

// FIN MENU E
//MENU F

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
    <td height="19">&nbsp;</td>
  </tr>
  <tr>
    <td height="77"><div id="smoothmenu1" class="ddsmoothmenu">
<ul>
   <li><a href="#">CONTRATOS</a>
    <ul>
      
        <li><a href="dashboard.php">Regresar</a></li>
  
    </ul>
  </li>
</ul>
<div align="right"><span class="mincit_textuser">&nbsp;&nbsp;</span>
<br style="clear: left" />
</div>
    </div></td>
  </tr>
</table>
</body>
</html>