<?php require_once('../../Connections/oConnCERT.php'); ?>
<?php
mysql_select_db($database_oConnCERT, $oConnCERT);
$query_Recordset1 = "SELECT * FROM cert_master WHERE solcert_id = 5";
$Recordset1 = mysql_query($query_Recordset1, $oConnCERT) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<?php echo utf8_encode($row_Recordset1['resp_msj']); ?>

