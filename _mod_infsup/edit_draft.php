<?php require_once('../Connections/oConnContratos.php'); ?>
<?php
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

$colname_rsinformeinf = "-1";
if (isset($_GET['inf_id'])) {
  $colname_rsinformeinf = $_GET['inf_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rsinformeinf = sprintf("SELECT * FROM informe_intersup WHERE inf_id = %s", GetSQLValueString($colname_rsinformeinf, "int"));
$rsinformeinf = mysql_query($query_rsinformeinf, $oConnContratos) or die(mysql_error());
$row_rsinformeinf = mysql_fetch_assoc($rsinformeinf);
$totalRows_rsinformeinf = mysql_num_rows($rsinformeinf);

$colname_rsinfocont = "-1";
if (isset($_GET['doc_id'])) {
  $colname_rsinfocont = $_GET['doc_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rsinfocont = sprintf("SELECT * FROM q_001_dashboard WHERE id_cont = %s", GetSQLValueString($colname_rsinfocont, "int"));
$rsinfocont = mysql_query($query_rsinfocont, $oConnContratos) or die(mysql_error());
$row_rsinfocont = mysql_fetch_assoc($rsinfocont);
$totalRows_rsinfocont = mysql_num_rows($rsinfocont);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../_css/jqueryslidemenu.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../_jquery/hs/highslide/highslide-with-html.js"></script>
<link rel="stylesheet" type="text/css" href="../_jquery/hs/highslide/highslide.css" />
<script type="text/javascript">
hs.graphicsDir = '../_jquery/hs/highslide/graphics/';
hs.outlineType = 'rounded-white';
hs.wrapperClassName = 'draggable-header';
</script>
</head>

<body>
<table width="100%" border="0" cellspacing="2" cellpadding="0">
  <tr>
    <td><table width="95%" border="0" align="center" cellpadding="0" cellspacing="2">
      <tr>
        <td>C&oacute;digo de verificaci&oacute;n:</td>
        <td><?php echo $row_rsinformeinf['inf_hash']; ?></td>
      </tr>
      <tr>
        <td width="34%">Informe n&uacute;mero:</td>
        <td width="66%"><?php echo $row_rsinformeinf['inf_consecutivo']; ?></td>
      </tr>
      <tr>
        <td>Fecha en que se rinde el informe</td>
        <td><?php echo $row_rsinformeinf['inf_fechapresenta']; ?></td>
      </tr>
      <tr>
        <td>Periodicidad</td>
        <td><?php echo $row_rsinfocont['periodo_name']; ?></td>
      </tr>
      <tr>
        <td>Periodo reportado</td>
        <td>Desde: <?php echo $row_rsinformeinf['inf_fecharep_i']; ?> Hasta:<?php echo $row_rsinformeinf['inf_fecharep_f']; ?><a href="edit_fecha_reporte.php?inf_id=<?php echo $row_rsinformeinf['inf_id']; ?>&amp;doc_id=<?php echo $row_rsinformeinf['id_cont_fk']; ?>" title="Ajustar periodo" onclick="return hs.htmlExpand(this, { objectType: 'iframe' } )"><img src="../_mod_contratos/icons/245_date.png" width="24" height="24" border="0" /></a></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
      <table width="95%" border="0" align="center" cellpadding="0" cellspacing="2">
        <tr>
          <td colspan="2">ASPECTOS GENERALES, ADMINISTRATIVOS Y LEGALES</td>
        </tr>
        <tr>
          <td width="34%">N° CONTRATO O CONVENIO:</td>
          <td width="66%"><?php echo $row_rsinformeinf['inf_numerocontrato']; ?></td>
        </tr>
        <tr>
          <td>Nombre del contratista:</td>
          <td><?php echo $row_rsinformeinf['inf_nombrecontratista']; ?> (<?php echo $row_rsinformeinf['inf_doccontratista']; ?>)</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td></td>
        </tr>
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
      <table width="95%" border="1" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="3" rowspan="2" valign="top">Valor del contrato:$<?php echo number_format($row_rsinformeinf['inf_valorcontrato'],2,',','.'); ?></td>
          <td colspan="7" valign="top"><p align="center">Informaci&oacute;n    Financiera</p></td>
        </tr>
        <tr>
          <td colspan="7" rowspan="2" valign="top"><p><strong>C.D.P</strong>: <?php echo $row_rsinformeinf['inf_cdp']; ?><br />
                  <strong>R.P.:</strong><?php echo $row_rsinformeinf['inf_rp']; ?><br />
                  <strong>Proyecto de    inversi&oacute;n:</strong> <?php echo $row_rsinformeinf['inf_rubrocode']; ?></p>          </td>
        </tr>
        <tr>
          <td colspan="3" valign="top"><p><strong>Adici&oacute;n/Reducci&oacute;n en valor    del contrato</strong>: (Describirlas adiciones o reducciones, &nbsp;que haya tenido el valor inicial&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; del&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; contrato, estableciendo, referencia,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; valor&nbsp;&nbsp; y    fecha&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; de&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; la modificaci&oacute;n).<br />
            Fecha de adici&oacute;n o reducci&oacute;n, en caso contrario    indicar que <u>no aplica</u>)</p></td>
        </tr>
        <tr>
          <td colspan="10" valign="top"><p><strong>Objeto del    contrato:</strong> <?php echo $row_rsinformeinf['inf_objeto']; ?></p></td>
        </tr>
        <tr>
          <td colspan="2" rowspan="3" valign="top"><p><strong>Fecha&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; de&nbsp; suscripci&oacute;n    del&nbsp; contrato o de la cesi&oacute;n &ndash;seg&uacute;n el    caso.:<?php echo $row_rsinformeinf['inf_fechasuscripcion']; ?></strong></p></td>
          <td colspan="8" valign="top"><p align="center">Ejecuci&oacute;n    del Contrato</p></td>
        </tr>
        <tr>
          <td colspan="5" valign="top"><p><strong>Fecha de    inicio</strong>: <?php echo $row_rsinformeinf['inf_fechacont_i']; ?></p></td>
          <td colspan="3" valign="top"><p align="right"><strong>Fecha de terminaci&oacute;n:</strong><?php echo $row_rsinformeinf['inf_fechacont_f']; ?></p></td>
        </tr>
        <tr>
          <td colspan="2" valign="top"><p><strong>Plazo:</strong>&nbsp;<?php echo $row_rsinformeinf['inf_plazo']; ?></p></td>
          <td colspan="3" valign="top"><p><strong>Vigencia:</strong><?php echo $row_rsinformeinf['inf_vigencia']; ?></p></td>
          <td colspan="3" valign="top"><p><strong>Modificaciones en plazo:</strong><?php echo $row_rsinformeinf['inf_modificacionesplazo']; ?></p></td>
        </tr>
        <tr>
          <td width="229" valign="top"><p align="center"><strong>Interventor/Supervisor </strong></p></td>
          <td colspan="5" valign="top"><p align="center"><strong>Nombre </strong></p></td>
          <td colspan="3" valign="top"><p align="center"><strong>Cargo /No. Contrato</strong></p></td>
          <td width="484" valign="top"><p align="center"><strong>Dependencia</strong></p></td>
        </tr>
        <tr>
          <td valign="top"><?php echo $row_rsinformeinf['inf_intersup']; ?></td>
          <td colspan="5" valign="top"><?php echo $row_rsinformeinf['inf_nombre']; ?></td>
          <td colspan="3" valign="top"><?php echo $row_rsinformeinf['inf_cargo']; ?></td>
          <td valign="top"><?php echo $row_rsinformeinf['inf_dependencia']; ?></td>
        </tr>
        <tr>
          <td colspan="5" valign="top"><p><strong>GARANT&Iacute;AS : </strong></p></td>
          <td colspan="3" valign="top"><p><strong>Fecha aprobaci&oacute;n: </strong></p></td>
          <td colspan="2" valign="top"><p><strong>Vigencia: Desde - </strong>Hasta&hellip;.</p></td>
            </tr>
        <tr>
          <td colspan="5" valign="top"><p><strong>&nbsp;</strong></p></td>
          <td colspan="3" valign="top"><p><strong>&nbsp;</strong></p></td>
          <td colspan="2" valign="top"><p><strong>&nbsp;</strong></p></td>
            </tr>
  &nbsp;
      </table></td>
  </tr>
</table>

<table border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="595" valign="top"><p align="center"><strong>DESCRIPCI&Oacute;N DE AVANCE T&Eacute;CNICO</strong><br />
            <strong>AVANCE EN    LA EJECUCI&Oacute;N:</strong><strong>&nbsp;<?php echo $row_rsinformeinf['inf_avgejecucion']; ?>%</strong></p></td>
  </tr>
  <tr>
    <td width="595" valign="top"><p><strong>ACTIVIDADES    DESARROLLADAS:</strong><br />
    (Descripci&oacute;n de actividades desarrolladas en el periodo    de este informe de conformidad con la cl&aacute;usula de Obligaciones del Contrato, realizadas tanto por el contratista como por    la entidad contratante en el per&iacute;odo correspondiente al informe de    interventor&iacute;a o supervisi&oacute;n.<strong> </strong></p></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" width="595">
  <tr>
    <td width="111" rowspan="3" valign="top"><p align="right">An&aacute;lisis    del Supervisor/ Interventor</p></td>
    <td width="484" valign="top"><p>Declara    conformidad:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Si: _&nbsp;&nbsp; No: _&nbsp;&nbsp; (Indicar    conformidad o inconformidad con el resultado actividad<br />
    desarrollada en el per&iacute;odo informado).</p></td>
  </tr>
  <tr>
    <td width="484" valign="top"><p>Informa    incumplimiento en las obligaciones del Contrato: Si: _ No: _ (Establecer cuando sea el caso, si se    presentan incumplimientos a las obligaciones contractuales). En caso tal,    se&ntilde;alar tambi&eacute;n los requerimientos realizados y el Memorando con que informa    a la Oficina Asesora Jur&iacute;dica sobre el particular.</p></td>
  </tr>
  <tr>
    <td width="484" valign="top"><p><strong>CERTFICACION DE PAGO DE SEGURIDAD SOCIAL Y/O    PARAFISCALES: (D&iacute;a/mes/a&ntilde;o).</strong><br />
      (Establezca la fecha de certificaci&oacute;n de    cumplimiento en relaci&oacute;n con los aportes al Sistema de Seguridad Social Integral    y/o Parafiscales. En caso de ser persona natural se debe    indicar el n&uacute;mero de la planilla o planillas correspondientes en relaci&oacute;n con    el pago de salud y pensiones).&nbsp;</p>
        <p>&nbsp;</p>
      <p>Afiliaci&oacute;n </p>
    </td>
  </tr>
  <tr>
    <td width="111" valign="top"><p>&nbsp;</p></td>
    <td width="484" valign="top"><p><strong>AFILIACION ARP SI______ NO_______</strong></p></td>
  </tr>
</table>
<p><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2. &nbsp;&nbsp;ASPECTOS FINANCIEROS: </strong></p>
<p>El valor ejecutado del contrato o convenio (seg&uacute;n  el caso) es el siguiente:<br />
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br />
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;</p>
<table border="0" cellspacing="0" cellpadding="0" width="595">
  <tr>
    <td width="345" nowrap="nowrap" valign="bottom"><br />
        <strong>INFORMACION DE EJECUCI&Oacute;N Y PAGOS</strong> </td>
    <td width="109" nowrap="nowrap" valign="bottom"><p align="right"><strong>EJECUCI&Oacute;N</strong></p></td>
    <td width="141" nowrap="nowrap" valign="bottom"><p align="right"><strong>&nbsp;SALDO</strong></p></td>
  </tr>
  <tr>
    <td width="345" nowrap="nowrap" valign="bottom"><p><strong>Valor inicial del contrato o convenio (seg&uacute;n el caso).</strong></p></td>
    <td width="109" nowrap="nowrap" valign="bottom"><p align="right"><strong>&nbsp;</strong></p></td>
    <td width="141" nowrap="nowrap" valign="bottom"><p align="right"><strong>&nbsp;</strong></p></td>
  </tr>
  <tr>
    <td width="345" nowrap="nowrap" valign="bottom"><p>1er Pago</p></td>
    <td width="109" nowrap="nowrap" valign="bottom"><p align="right"><strong>$(&hellip;)</strong> </p></td>
    <td width="141" nowrap="nowrap" valign="bottom"><p align="right">&nbsp;</p></td>
  </tr>
  <tr>
    <td width="345" nowrap="nowrap" valign="bottom"><p>2o Pago</p></td>
    <td width="109" nowrap="nowrap" valign="bottom"><p align="right"><strong>$(&hellip;)</strong> </p></td>
    <td width="141" nowrap="nowrap" valign="bottom"><p align="right">&nbsp;</p></td>
  </tr>
  <tr>
    <td width="345" nowrap="nowrap" valign="bottom"><p>3er Pago</p></td>
    <td width="109" nowrap="nowrap" valign="bottom"><p align="right"><strong>$(&hellip;)</strong> </p></td>
    <td width="141" nowrap="nowrap" valign="bottom"><p align="right">&nbsp;</p></td>
  </tr>
  <tr>
    <td width="345" nowrap="nowrap" valign="bottom"><p><strong>Pago / desembolso Pendiente</strong>: </p></td>
    <td width="109" nowrap="nowrap" valign="bottom"><p align="right"><strong>$(&hellip;)</strong> </p></td>
    <td width="141" nowrap="nowrap" valign="bottom"><p align="right"><strong>&nbsp;</strong></p></td>
  </tr>
  <tr>
    <td width="345" nowrap="nowrap" valign="bottom"><p align="right"><strong>Valor ejecutado</strong></p></td>
    <td width="109" nowrap="nowrap" valign="bottom"><p><strong>&nbsp;</strong></p></td>
    <td width="141" nowrap="nowrap" valign="bottom"><p align="right"><strong>$(&hellip;)</strong></p></td>
  </tr>
</table>
<p><strong>&nbsp;</strong></p>
<p><strong>NOTA: </strong>En este &iacute;tem dependiendo del contrato / convenio de  que se trate, se debe indicar cuando haya lugar a ello, pago anticipado,  anticipo (amortizaci&oacute;n), gastos, inversiones realizadas, etc. Gastos  efectuados, seguimiento a los dineros invertidos si es el caso y en caso de ser  aplicable hacer referencia a las consignaciones efectuadas por el Ministerio. Igualmente  deben consignarse las adiciones o reducciones en valor que se presentes. </p>
<p><strong>En el  evento de producirse la Cesi&oacute;n del contrato, deber&aacute; indicarse el monto  ejecutado por el cedente y el que debe ejecutar el cesionario y las fechas a  partir de las cuales ello ocurrir&aacute;.</strong></p>
<ol>
  <li><strong>OTROS ASPECTOS T&Eacute;CNICOS.</strong></li>
</ol>
<p><strong>&nbsp;</strong></p>
<p>Otros aspectos que el supervisor / Interventor considere indispensables  relatar en el informe (inconvenientes, soluciones, aspectos positivos que  arroj&oacute; la ejecuci&oacute;n del contrato / convenio, recomendaciones para futuras  contrataciones, informes o solicitudes a la Oficina Asesora Jur&iacute;dica, etc.).</p>
<p><strong>NOTA: </strong>En caso de que se est&eacute;n supervisando contratos o  convenios sobre bienes inmuebles, debe incluirse la referencia especifica a las  autorizaciones de los gastos, con cargo a los fondos de reposici&oacute;n en aquellos  contratos o convenios que los tengan establecidos, como las fechas de revisi&oacute;n  o variaci&oacute;n de los c&aacute;nones de arrendamiento. </p>
<ol>
  <li><strong>RECOMENDACIONES Y OBSERVACIONES PARA EL ORDENADOR  DEL GASTO.&nbsp; </strong></li>
</ol>
<p><strong>&nbsp;</strong></p>
<p>(Descripci&oacute;n de las observaciones  o recomendaciones que se tengan para el Ordenador del Gasto, si a bien lo tiene  el supervisor / interventor del contrato.  Anotar otros aspectos que el supervisor considere indispensables relatar en el  informe -inconvenientes, soluciones,  aspectos positivos que arroj&oacute; la ejecuci&oacute;n del contrato o convenio,  recomendaciones para futuras contrataciones,</p>
<p><strong>&nbsp; </strong></p>
<p><strong>Firma </strong><strong> </strong></p>
<h1>Nombre del supervisor y/o interventor </h1>
<h1>Cargo</h1>
<p>&nbsp;</p>
<p>Anexo: Detallar los anexos  que se adjuntan. &nbsp;</p>
<p>(Para los contratos de  Prestaci&oacute;n de Servicios Profesionales y de Apoyo a la Gesti&oacute;n, s&oacute;lo ser&aacute; el  informe de actividades del Contratista.</p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($rsinformeinf);

mysql_free_result($rsinfocont);
?>
