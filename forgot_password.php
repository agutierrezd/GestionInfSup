<?php require_once('Connections/oConnUsers.php'); ?>
<?php
/*
Análisis, Diseño y Desarrollo: Alex Fernando Gutierrez
correo: dito73@gmail.com
correo inst: agutierrezd@mincit.gov.co
celular: 3017874143
*/
require_once('includes/common/KT_common.php');
?>
<?php
// Load the tNG classes
require_once('includes/tng/tNG.inc.php');
?>
<?php
// Make a transaction dispatcher instance
$tNGs = new tNG_dispatcher("");
?>
<?php
// Make unified connection variable
$conn_oConnUsers = new KT_connection($oConnUsers, $database_oConnUsers);
?>

<?php
// Start trigger
$formValidation = new tNG_FormValidation();
$formValidation->addField("usr_email", true, "text", "email", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger
?>
<?php
//start Trigger_ForgotPasswordCheckEmail trigger
//remove this line if you want to edit the code by hand
function Trigger_ForgotPasswordCheckEmail(&$tNG) {
  return Trigger_ForgotPassword_CheckEmail($tNG);
}
//end Trigger_ForgotPasswordCheckEmail trigger
?>
<?php
//start Trigger_ForgotPassword_Email trigger
//remove this line if you want to edit the code by hand
function Trigger_ForgotPassword_Email(&$tNG) {
  $emailObj = new tNG_Email($tNG);
  $emailObj->setFrom("{KT_defaultSender}");
  $emailObj->setTo("{usr_email}");
  $emailObj->setCC("");
  $emailObj->setBCC("agutierrezd@mincit.gov.co");
  $emailObj->setSubject("Acceso a Plataforma de Servicios");
  //FromFile method
  $emailObj->setContentFile("includes/mailtemplates/forgot.html");
  $emailObj->setEncoding("ISO-8859-1");
  $emailObj->setFormat("HTML/Text");
  $emailObj->setImportance("Normal");
  return $emailObj->Execute();
}
//end Trigger_ForgotPassword_Email trigger
?>
<?php
// Make an update transaction instance
$forgotpass_transaction = new tNG_update($conn_oConnUsers);
$tNGs->addTransaction($forgotpass_transaction);
// Register triggers
$forgotpass_transaction->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$forgotpass_transaction->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$forgotpass_transaction->registerTrigger("BEFORE", "Trigger_ForgotPasswordCheckEmail", 20);
$forgotpass_transaction->registerTrigger("AFTER", "Trigger_ForgotPassword_Email", 1);
$forgotpass_transaction->registerTrigger("END", "Trigger_Default_Redirect", 99, "{kt_login_redirect}");
// Add columns
$forgotpass_transaction->setTable("global_users");
$forgotpass_transaction->addColumn("usr_email", "STRING_TYPE", "POST", "usr_email");
$forgotpass_transaction->setPrimaryKey("usr_email", "STRING_TYPE", "POST", "usr_email");
?>
<?php
// Execute all the registered transactions
$tNGs->executeTransactions();
?>
<?php
// Get the transaction recordset
$rsglobal_users = $tNGs->getRecordset("global_users");
$row_rsglobal_users = mysql_fetch_assoc($rsglobal_users);
$totalRows_rsglobal_users = mysql_num_rows($rsglobal_users);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Forgot Password Page</title>
<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script src="includes/common/js/base.js" type="text/javascript"></script>
<script src="includes/common/js/utility.js" type="text/javascript"></script>
<script src="includes/skins/style.js" type="text/javascript"></script>

<?php echo $tNGs->displayValidationRules();?>
</head>

<body>
<div align="center"><img src="../../Athena/Logo.png" width="299" height="59" /></div>
<p>&nbsp;</p>
<?php
	echo $tNGs->getErrorMsg();
?>
	<form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
	<table width="500" cellpadding="2" cellspacing="0" class="KT_tngtable">
<tr class="stverde">
			  <td colspan="2" class="KT_th"><div align="center">Módulo de contratos</div></td>
	  </tr>
			<tr>
			  <td colspan="2" class="KT_th">Para acceder a la Plataforma, escriba su correo electrónico en este espacio. <br>
			    Posteriormente presione el botón Enviar Contraseña. <br>
		      El sistema enviará automáticamente la contraseña a su correo electrónico. Siga las instrucciones.</td>
	  </tr>
			<tr>
	<td class="KT_th"><label for="usr_email"> Email:</label></td>
	<td>
		<input type="text" name="usr_email" id="usr_email" value="<?php echo KT_escapeAttribute($row_rsglobal_users['usr_email']); ?>" size="32" />
		<?php echo $tNGs->displayFieldHint("usr_email");?>
		<?php echo $tNGs->displayFieldError("global_users", "usr_email"); ?>	</td>
</tr>
			<tr class="KT_buttons"> 
				<td colspan="2">
					<input type="submit" name="KT_Update1" id="KT_Update1" value="Enviar contrase&ntilde;a" />				</td>
			</tr>      
		</table>
		
</form>
	<p>&nbsp;</p>

</body>
</html>
