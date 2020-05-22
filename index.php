<?php require_once('Connections/oConnUsers.php'); ?>
<?php require_once('Connections/global.php'); ?>
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

// Start trigger
$formValidation = new tNG_FormValidation();
$formValidation->addField("kt_login_user", true, "text", "", "", "", "");
$formValidation->addField("kt_login_password", true, "text", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

// Make a login transaction instance
$loginTransaction = new tNG_login($conn_oConnUsers);
$tNGs->addTransaction($loginTransaction);
// Register triggers
$loginTransaction->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "kt_login1");
$loginTransaction->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$loginTransaction->registerTrigger("END", "Trigger_Default_Redirect", 99, "{kt_login_redirect}");
// Add columns
$loginTransaction->addColumn("kt_login_user", "STRING_TYPE", "POST", "kt_login_user");
$loginTransaction->addColumn("kt_login_password", "STRING_TYPE", "POST", "kt_login_password");
// End of login transaction instance

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rscustom = $tNGs->getRecordset("custom");
$row_rscustom = mysql_fetch_assoc($rscustom);
$totalRows_rscustom = mysql_num_rows($rscustom);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:: Superintendencia Nacional de Salud ::.</title>
<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script src="includes/common/js/base.js" type="text/javascript"></script>
<script src="includes/common/js/utility.js" type="text/javascript"></script>
<script src="includes/skins/style.js" type="text/javascript"></script>
<?php echo $tNGs->displayValidationRules();?>
<link href="_css/jqueryslidemenu.css" rel="stylesheet" type="text/css" />
</head>

<body>
 <div align="center"><img src="../Logo.png" width="299" height="59" /></div>
<p>&nbsp;</p>
<table width="400" border="0" align="center" cellpadding="0" cellspacing="2">
  <tr >
    <td>&nbsp;</td>
  </tr>
  <tr >
    <td>&nbsp;</td>
  </tr>
  <tr class="stverde">
    <td>Informes de supervisión</td>
  </tr>
  <tr>
    <td>&nbsp;
      <?php
	echo $tNGs->getLoginMsg();
?>
      <?php
	echo $tNGs->getErrorMsg();
?>
      <form method="post" id="form1" class="KT_tngformerror" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
        <table cellpadding="2" cellspacing="0" class="KT_tngtable">
          <tr>
            <td class="KT_th"><label for="kt_login_user">Usuario:</label></td>
            <td><input name="kt_login_user" type="text" id="kt_login_user" value="<?php echo KT_escapeAttribute($row_rscustom['kt_login_user']); ?><?php echo $_GET['USERID']; ?>" size="32" />
                <?php echo $tNGs->displayFieldHint("kt_login_user");?> <?php echo $tNGs->displayFieldError("custom", "kt_login_user"); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="kt_login_password">Contrase&ntilde;a:</label></td>
            <td><input type="password" name="kt_login_password" id="kt_login_password" value="" size="32" />
                <?php echo $tNGs->displayFieldHint("kt_login_password");?> <?php echo $tNGs->displayFieldError("custom", "kt_login_password"); ?> </td>
          </tr>
          <tr class="KT_buttons">
            <td colspan="2"><input name="kt_login1" type="submit" id="kt_login1" value="Login" />            </td>
          </tr>
          <tr class="KT_buttons">
            <td colspan="2"><a href="forgot_password.php">¿Olvidó su contraseña?</a></td>
          </tr>
        </table>
      </form>
    <p class="titlemsg2">&nbsp;</p>    </td>
  </tr>
</table>
</body>
</html>
