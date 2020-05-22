<?php require_once('../Connections/oConnAlmacen.php'); ?>
<?php
// Load the common classes
require_once('../includes/common/KT_common.php');

/*
Análisis, Diseño y Desarrollo: Alex Fernando Gutierrez
correo: dito73@gmail.com
correo inst: agutierrezd@mincit.gov.co
celular: 3017874143
*/
require_once('../includes/common/KT_common.php');

// Load the tNG classes
require_once('../includes/tng/tNG.inc.php');

// Make a transaction dispatcher instance
$tNGs = new tNG_dispatcher("../");

// Make unified connection variable
$conn_oConnAlmacen = new KT_connection($oConnAlmacen, $database_oConnAlmacen);

// Make a custom transaction instance
$customTransaction = new tNG_custom($conn_oConnAlmacen);
$tNGs->addTransaction($customTransaction);
// Register triggers
$customTransaction->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "GET", "aldevindiv_id");
// Set custom transaction SQL
$customTransaction->setSQL("INSERT INTO almovinddia ( midcuenta, midcodelem, midalmacen, midnroplaca, midnroserie, mid_estadoelem, mid_detalleestado, mid_valormovto, resolucion_baja_num, resolucion_baja_date, resolucion_baja_obs, midtipoestruc, doclasedoc_id_fk, midclasedoc,midfuncionario,aldevindiv_id_fk,midnrodoc,midfechadoc,mid_valor_dep_acum )\nSELECT aldevindiv.dicuenta, aldevindiv.dicodelem, aldevindiv.dialmacen, aldevindiv.di_nroplaca, aldevindiv.di_nroserie, aldevindiv.di_estadoelem, aldevindiv.di_detalleestado, aldevindiv.di_valorcompra, aldevindiv.resolucion_baja_num, aldevindiv.resolucion_baja_date, aldevindiv.resolucion_baja_obs, aldevindiv.ditipoestruc,{GET.doclasedoc_id},{GET.lnk},{GET.numdocumento}, {GET.aldevindiv_id},{GET.consecutivo},'{GET.fechaasiento}','0'\nFROM aldevindiv \nWHERE aldevindiv.aldevindiv_id = {GET.aldevindiv_id}");
// Add columns
// End of custom transaction instance

// Make a custom transaction instance
$customTransaction1 = new tNG_custom($conn_oConnAlmacen);
$tNGs->addTransaction($customTransaction1);
// Register triggers
$customTransaction1->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "GET", "plaque");
$customTransaction1->registerTrigger("END", "Trigger_Default_Redirect", 99, "a_docs_soporte_322.php?as_id={GET.as_id}&doclasedoc_id={GET.doclasedoc_id}&anio_id={GET.anio_id}&hash_id={GET.hash_id}&lnk={GET.lnk}&numdocumento={GET.numdocumento}");
// Set custom transaction SQL
$customTransaction1->setSQL("UPDATE aldevindiv SET aldevindiv.difuncionario = 800\nWHERE aldevindiv.di_nroplaca = '{GET.plaque}'");
// Add columns
// End of custom transaction instance

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rscustom = $tNGs->getRecordset("custom");
$row_rscustom = mysql_fetch_assoc($rscustom);
$totalRows_rscustom = mysql_num_rows($rscustom);

$fechac = date("Y-m-d H:i:s"); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script src="../includes/skins/style.js" type="text/javascript"></script>
</head>

<body>
<?php
	echo $tNGs->getErrorMsg();
?>
</body>
</html>
