<?php require_once('../../Connections/oConnPN.php'); ?>
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

$colname_rsprocess = "-1";
if (isset($_POST['fecha'])) {
  $colname_rsprocess = $_POST['fecha'];
  $filtrar = $_POST['filtro'];
}
mysql_select_db($database_oConnPN, $oConnPN);
$query_rsprocess = sprintf("SELECT * FROM q_pn_master WHERE FechaVencimiento $filtrar %s", GetSQLValueString($colname_rsprocess, "date"));
$rsprocess = mysql_query($query_rsprocess, $oConnPN) or die(mysql_error());
$row_rsprocess = mysql_fetch_assoc($rsprocess);
$totalRows_rsprocess = mysql_num_rows($rsprocess);
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
        'size' => 10,
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
        'size' => 14,
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

// FIN DE ESTILOS
// Inicio cargue datos

$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->duplicateStyleArray($title2, 'A1');
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'REGISTRO DE PRODUCTORES NACIONALES ' . $_POST['filtro'] . ' a ' . $_POST['fecha']);
$objPHPExcel->getActiveSheet()->mergeCells('A1:K1');
$objPHPExcel->getActiveSheet()->getStyle('A1:K1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->duplicateStyleArray($title, 'A2:K2');
$objPHPExcel->getActiveSheet()->setCellValue('B2', 'NIT');
$objPHPExcel->getActiveSheet()->setCellValue('C2', 'PRODUCTOR NOMBRE');
$objPHPExcel->getActiveSheet()->setCellValue('D2', 'PRODUCTOR DIRECCION');
$objPHPExcel->getActiveSheet()->setCellValue('E2', 'PRODUCTOR TELEFONO');
$objPHPExcel->getActiveSheet()->setCellValue('F2', 'PRODUCTOR CIUDAD');
$objPHPExcel->getActiveSheet()->setCellValue('G2', 'RADICADO');
$objPHPExcel->getActiveSheet()->setCellValue('H2', 'POSICION ARANCELARIA');
$objPHPExcel->getActiveSheet()->setCellValue('I2', 'NOMBRE COMERCIAL');
$objPHPExcel->getActiveSheet()->setCellValue('J2', 'NOMBRE TECNICO');
$objPHPExcel->getActiveSheet()->setCellValue('K2', 'FECHA VENCIMIENTO');

//$objPHPExcel->getActiveSheet()->getStyle('G2')->getAlignment()->setWrapText(true);
//$objPHPExcel->getActiveSheet()->getStyle('H2')->getAlignment()->setWrapText(true);
//$objPHPExcel->getActiveSheet()->getStyle('I2')->getAlignment()->setWrapText(true);
//$objPHPExcel->getActiveSheet()->getStyle('J2')->getAlignment()->setWrapText(true);
//$objPHPExcel->getActiveSheet()->getStyle('K2')->getAlignment()->setWrapText(true);

$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);

//$objPHPExcel->getActiveSheet()->setAutoFilter('A2:K2');


$xlsRow = 3;
$xlsNr = 1;

//->getColumnDimension('C')->setAutoSize(true)
do {
$objPHPExcel->getActiveSheet()->setCellValue('A'.$xlsRow, $xlsNr);
$objPHPExcel->getActiveSheet()->setCellValue('B'.$xlsRow, $row_rsprocess['productor_nit']);
$objPHPExcel->getActiveSheet()->setCellValue('C'.$xlsRow, $row_rsprocess['productor_raz']);
$objPHPExcel->getActiveSheet()->setCellValue('D'.$xlsRow, $row_rsprocess['productor_dir']);
$objPHPExcel->getActiveSheet()->setCellValue('E'.$xlsRow, $row_rsprocess['productor_tel']);
$objPHPExcel->getActiveSheet()->setCellValue('F'.$xlsRow, $row_rsprocess['productor_ciu']);
$objPHPExcel->getActiveSheet()->setCellValue('G'.$xlsRow, $row_rsprocess['radicado'].' ');
$objPHPExcel->getActiveSheet()->setCellValue('H'.$xlsRow, $row_rsprocess['idarancel']);
$objPHPExcel->getActiveSheet()->setCellValue('I'.$xlsRow, $row_rsprocess['NombreComercial']);
$objPHPExcel->getActiveSheet()->setCellValue('J'.$xlsRow, $row_rsprocess['NombreTecnico']);
$objPHPExcel->getActiveSheet()->setCellValue('K'.$xlsRow, $row_rsprocess['FechaVencimiento']);


$xlsRow++;
$xlsNr++;

} while ($row_rsprocess = mysql_fetch_assoc($rsprocess));
 

// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('REGISTROS');
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="reporte_001.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;

mysql_free_result($rsprocess);
?>
