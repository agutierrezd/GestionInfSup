<?php require_once('../../Connections/oConnContratos.php'); ?>
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

$colname_rspagos = "-1";
if (isset($_GET['id_cont'])) {
  $colname_rspagos = $_GET['id_cont'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rspagos = sprintf("SELECT * FROM contrato_controlpagos WHERE id_cont_fk = %s ORDER BY ctrlpagos_fecha ASC", GetSQLValueString($colname_rspagos, "int"));
$rspagos = mysql_query($query_rspagos, $oConnContratos) or die(mysql_error());
$row_rspagos = mysql_fetch_assoc($rspagos);
$totalRows_rspagos = mysql_num_rows($rspagos);

$colname_rsinfocontrato = "-1";
if (isset($_GET['id_cont'])) {
  $colname_rsinfocontrato = $_GET['id_cont'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rsinfocontrato = sprintf("SELECT * FROM q_001_dashboard WHERE id_cont = %s", GetSQLValueString($colname_rsinfocontrato, "int"));
$rsinfocontrato = mysql_query($query_rsinfocontrato, $oConnContratos) or die(mysql_error());
$row_rsinfocontrato = mysql_fetch_assoc($rsinfocontrato);
$totalRows_rsinfocontrato = mysql_num_rows($rsinfocontrato);

$colname_rscontrolpagado = "-1";
if (isset($_GET['id_cont'])) {
  $colname_rscontrolpagado = $_GET['id_cont'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rscontrolpagado = sprintf("SELECT * FROM q_valorpagado WHERE id_cont_fk = %s", GetSQLValueString($colname_rscontrolpagado, "int"));
$rscontrolpagado = mysql_query($query_rscontrolpagado, $oConnContratos) or die(mysql_error());
$row_rscontrolpagado = mysql_fetch_assoc($rscontrolpagado);
$totalRows_rscontrolpagado = mysql_num_rows($rscontrolpagado);
?>
<?php

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

require_once '../Classes/PHPExcel.php';


// Crea un nuevo doucmento excel
$objPHPExcel = new PHPExcel();

// Propiedades del documento
$objPHPExcel->getProperties()->setCreator("Alex Fernando Gutierrez")
							 ->setLastModifiedBy("Alex Fernando Gutierrez")
							 ->setTitle("Oficina de Sistemas de Informacion")
							 ->setSubject("Oficina de Sistemas de Informacion")
							 ->setDescription("Oficina de Sistemas de Informacion")
							 ->setKeywords("Oficina de Sistemas de Informacion")
							 ->setCategory("Oficina de Sistemas de Informacion");
							 
							 
// ESTILOS

$title = array(
    'font' => array(
        'name' => 'Tahoma',
        'size' => 11,
        'bold' => false,
        'color' => array(
            'rgb' => 'FFFFFF'
        ),
    ),
    'borders' => array(
        'bottom' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array(
                'rgb' => '000000'
            )
        ),
        'right' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array(
                'rgb' => '000000'
            )
        )
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
            'rgb' => '000000',
        ),
    ),
);

// title 2

$title2 = array(
    'font' => array(
        'name' => 'Tahoma',
        'size' => 13,
        'bold' => true,
        'color' => array(
            'rgb' => 'FFFFFF'
        ),
    ),
    'borders' => array(
        'bottom' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array(
                'rgb' => '000000'
            )
        ),
        'right' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array(
                'rgb' => '000000'
            )
        )
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
            'rgb' => '000000',
        ),
    ),
);

// COMIENZO TITLE 3

$title3 = array(
    'font' => array(
        'name' => 'Tahoma',
        'size' => 11,
        'bold' => false,
        'color' => array(
            'rgb' => '000000'
        ),
    ),
    'borders' => array(
        'bottom' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array(
                'rgb' => 'CCCCCC'
            )
        ),
        'right' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array(
                'rgb' => 'CCCCCC'
            )
        )
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
            'rgb' => 'CCCCCC',
        ),
    ),
);


// FIN DE ESTILOS
// Inicio cargue datos

$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->duplicateStyleArray($title2, 'A1');
$objPHPExcel->getActiveSheet()->duplicateStyleArray($title, 'A2');
$objPHPExcel->getActiveSheet()->duplicateStyleArray($title, 'A3');
$objPHPExcel->getActiveSheet()->duplicateStyleArray($title, 'A4');
$objPHPExcel->getActiveSheet()->duplicateStyleArray($title, 'A5');
$objPHPExcel->getActiveSheet()->setCellValue('A1', utf8_encode('MINISTERIO DE COMERCIO, INDUSTRIA Y TURISMO'));
$objPHPExcel->getActiveSheet()->setCellValue('A2', utf8_encode('CONTROL DE PAGOS AL CONTRATO No.: '.$row_rsinfocontrato['CONTRATOID']));
$objPHPExcel->getActiveSheet()->setCellValue('A3', utf8_encode('FECHA DE INICIO: '.$row_rsinfocontrato['FECHAI'].'  FECHA FINAL: '.$row_rsinfocontrato['FECHAF']));
//$objPHPExcel->getActiveSheet()->setCellValue('A4', utf8_encode('CONTRATISTA: '.$row_rsinfocontrato['contractor_nombresfull'].'  DOCUMENTO/NIT: '.$row_rsinfocontrato['DOCID']));
$objPHPExcel->getActiveSheet()->setCellValue('A4', utf8_encode('SUPERVISOR: '.$row_rsinfocontrato['contractor_nombresfull'].'  DOCUMENTO/NIT: '.$row_rsinfocontrato['DOCID']));
$objPHPExcel->getActiveSheet()->setCellValue('A5', utf8_encode('VALOR: '.$row_rsinfocontrato['VALORI'].'  PAGADO: '.$row_rscontrolpagado['valorpagado'].'  SALDO: '.($row_rsinfocontrato['VALORI']-$row_rscontrolpagado['valorpagado'])));
$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
$objPHPExcel->getActiveSheet()->mergeCells('A3:D3');
$objPHPExcel->getActiveSheet()->mergeCells('A4:D4');
$objPHPExcel->getActiveSheet()->mergeCells('A5:D5');
$objPHPExcel->getActiveSheet()->getStyle('A1:D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->duplicateStyleArray($title3, 'A6:D6');
$objPHPExcel->getActiveSheet()->setCellValue('A6', 'CONSECUTIVO  ');
$objPHPExcel->getActiveSheet()->setCellValue('B6', 'FECHA DE REGISTRO  ');
$objPHPExcel->getActiveSheet()->setCellValue('C6', 'DESCRIPCION / CONCEPTO  ');
$objPHPExcel->getActiveSheet()->setCellValue('D6', 'VALOR PAGADO  ');


//$objPHPExcel->getActiveSheet()->getStyle('G2')->getAlignment()->setWrapText(true);
//$objPHPExcel->getActiveSheet()->getStyle('H2')->getAlignment()->setWrapText(true);
//$objPHPExcel->getActiveSheet()->getStyle('I2')->getAlignment()->setWrapText(true);
//$objPHPExcel->getActiveSheet()->getStyle('J2')->getAlignment()->setWrapText(true);
//$objPHPExcel->getActiveSheet()->getStyle('K2')->getAlignment()->setWrapText(true);

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);

//$objPHPExcel->getActiveSheet()->setAutoFilter('A2:K2');


$xlsRow = 7;
$xlsNr = 1;

//->getColumnDimension('C')->setAutoSize(true)
do {
$objPHPExcel->getActiveSheet()->setCellValue('A'.$xlsRow, $xlsNr)->getStyle('A7:A'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('B'.$xlsRow, $row_rspagos['ctrlpagos_fecha'])->getStyle('B7:B'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('C'.$xlsRow, $row_rspagos['ctrlpagos_desc'])->getStyle('C7:C'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('D'.$xlsRow, $row_rspagos['ctrlpagos_valor'])->getStyle('D7:D'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



$xlsRow++;
$xlsNr++;

} while ($row_rspagos = mysql_fetch_assoc($rspagos));
 

// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('REGISTRO DE PAGOS');
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="pagos.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;

mysql_free_result($rspagos);

mysql_free_result($rsinfocontrato);

mysql_free_result($rscontrolpagado);
?>
