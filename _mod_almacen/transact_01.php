<?php require_once('../Connections/oConnAlmacen.php'); ?>
<?php
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
$customTransaction->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "GET", "doclasedoc_id");
$customTransaction->registerTrigger("END", "Trigger_Default_Redirect", 99, "a_docs_soporte_314.php?as_id={GET.as_id}&hash_id={GET.hash_id}&anio_id={GET.anio_id}&doclasedoc_id={GET.doclasedoc_id}");
// Set custom transaction SQL
$customTransaction->setSQL("UPDATE almovdevdia SET almovdevdia.mdd_valmovto = ((almovdevdia.mdd_cantmovto * almovdevdia.mdd_valunit)* almovdevdia.mdd_tax)\nWHERE almovdevdia.doclasedoc_id_fk = {GET.doclasedoc_id}");
// Add columns
// End of custom transaction instance

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
