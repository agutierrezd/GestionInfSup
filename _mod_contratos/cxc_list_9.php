<?php require_once('../Connections/oConnContratos.php'); ?>
<?php require_once('../Connections/global.php'); ?>
<?php
// Require the MXI classes
require_once ('../includes/mxi/MXI.php');

// Load the tNG classes
require_once('../includes/tng/tNG.inc.php');

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

mysql_select_db($database_oConnContratos, $oConnContratos);
$query_RsInfoCert = "SELECT * FROM q_info_certpago WHERE sys_status = 9";
$RsInfoCert = mysql_query($query_RsInfoCert, $oConnContratos) or die(mysql_error());
$row_RsInfoCert = mysql_fetch_assoc($RsInfoCert);
$totalRows_RsInfoCert = mysql_num_rows($RsInfoCert);

// Download File downloadObj1
$downloadObj1 = new tNG_Download("../", "KT_download1");
// Execute
$downloadObj1->setFolder("../Firma_digital/signed/");
$downloadObj1->setRenameRule("{RsInfoCert.sign_file}");
$downloadObj1->Execute();

// Download File downloadObj2
$downloadObj2 = new tNG_Download("../", "KT_download2");
// Execute
$downloadObj2->setFolder("../Firma_digital/signed/certfirmados/");
$downloadObj2->setRenameRule("{RsInfoCert.cert_file}");
$downloadObj2->Execute();
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:: Contrataci&oacute;n :: MinCIT ::.</title>
<link href="../_jquery/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="../_jquery/datatables/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="../_jquery/datatables/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="../_jquery/datatables/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="../_jquery/datatables/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../_jquery/datatables/dataTables.bootstrap.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable();
} );
</script>
    <!--start:HS-->
    <script type="text/javascript" src="../_jquery/hs/highslide/highslide-with-html.js"></script>
<link rel="stylesheet" type="text/css" href="../_jquery/hs/highslide/highslide.css" />
<script type="text/javascript">
hs.graphicsDir = '../_jquery/hs/highslide/graphics/';
hs.outlineType = 'rounded-white';
hs.wrapperClassName = 'draggable-header';
</script>
    <!--end:HS-->
</head>

<body>
<?php
  mxi_includes_start("../inc_top_free_2.php");
  require(basename("../inc_top_free_2.php"));
  mxi_includes_end();
?>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="180"><a href="dashboard_all.php?anio_id=<?php echo $ano; ?>">Ir a contratos</a></td>
    <td width="376"><a href="hr_list_<?php echo $ano; ?>.php?show_filter_tfi_listrslist1=1">Ir a hoja ruta</a></td>
    <td width="80">&nbsp;</td>
    <td width="80">&nbsp;</td>
    <td width="84">&nbsp;</td>
  </tr>
</table>
<table width="90%" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>
    <td><table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
      <thead>
        <tr>
          <th>CODIGO CERTIFICADO</th>
          <th>CONTRATO</th>
          <th>NOMBRE</th>
          <th>DOCUMENTO</th>
          <th>FECHA INICIO</th>
          <th>FECHA FINAL</th>
          <th>INFORME</th>
          <th>CRS</th>
          <th>VALOR A PAGAR</th>
          <th>&nbsp;</th>
          <th>&nbsp;</th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <th>CODIGO CERTIFICADO</th>
          <th>CONTRATO</th>
          <th>NOMBRE</th>
          <th>DOCUMENTO</th>
          <th>FECHA INICIO</th>
          <th>FECHA FINAL</th>
          <th>INFORME</th>
          <th>CRS</th>
          <th>VALOR A PAGAR</th>
          <th>&nbsp;</th>
          <th>&nbsp;</th>
        </tr>
      </tfoot>
      <tbody>
        <?php do { ?>
          <tr>
              <td><strong><?php echo $row_RsInfoCert['inf_hash_fk']; ?></strong></td>
            <td><?php echo $row_RsInfoCert['cxc_cont']; ?>&nbsp;DE&nbsp;<?php echo $row_RsInfoCert['cxc_anio']; ?></td>
            <td><?php echo $row_RsInfoCert['cxc_razonsocial']; ?></td>
            <td><?php echo $row_RsInfoCert['cxc_numdoc']; ?></td>
            <td><?php echo $row_RsInfoCert['cxc_periodoi']; ?></td>
            <td><?php echo $row_RsInfoCert['cxc_periodof']; ?></td>
            <td align="center"><a href="<?php echo $downloadObj1->getDownloadLink(); ?>">
              <?php 
// Show If File Exists (region1)
if (tNG_fileExists("../Firma_digital/signed/", "{RsInfoCert.sign_file}")) {
?>
                <img src="icons/informe.png" width="48" height="48" border="0" />
              <?php } 
// EndIf File Exists (region1)
?></a><a href="<?php echo $downloadObj1->getDownloadLink(); ?>"></a></td>
            <td align="center"><a href="<?php echo $downloadObj2->getDownloadLink(); ?>">
              <?php 
// Show If File Exists (region2)
if (tNG_fileExists("../Firma_digital/signed/certfirmados/", "{RsInfoCert.cert_file}")) {
?>
                <img src="icons/crs.png" width="48" height="48" border="0" />
              <?php } 
// EndIf File Exists (region2)
?></a></td>
            <td align="right"><?php echo number_format($row_RsInfoCert['cxc_valor'],2,'.',','); ?></td>
            <td>
            <?php 
// Show If File Exists (region2)
if (tNG_fileExists("../Firma_digital/signed/certfirmados/", "{RsInfoCert.cert_file}")) {
?>
            <a href="cxc_confirm_9.php?cxc_id=<?php echo $row_RsInfoCert['cxc_id']; ?>&amp;inf_id=<?php echo $row_RsInfoCert['inf_id_fk']; ?>&amp;doc_id=<?php echo $row_RsInfoCert['id_cont_fk']; ?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )">Ver información</a>
            <?php } 
// EndIf File Exists (region2)
?>
            </td>
            <td>&nbsp;</td>
          </tr>
          <?php } while ($row_RsInfoCert = mysql_fetch_assoc($RsInfoCert)); ?>
      </tbody>
    </table></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<?php
  mxi_includes_start("../inc_foot.php");
  require(basename("../inc_foot.php"));
  mxi_includes_end();
?>
</body>
</html>
<?php
mysql_free_result($RsInfoCert);
?>
