<?php require_once('../../Connections/oConnPPSYV.php'); ?>
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

//NeXTenesio3 Special List Recordset
$colname_rsRZones = "-1";
if (isset($_GET['periodo'])) {
  $colname_rsRZones = $_GET['periodo'];
}
$colano_rsRZones = "-1";
if (isset($_GET['year'])) {
  $colano_rsRZones = $_GET['year'];
}
// Defining List Recordset variable
$NXTFilter_rsRZones = "1=1";
if (isset($_SESSION['filter_tfi_listrsRZones1'])) {
  $NXTFilter_rsRZones = $_SESSION['filter_tfi_listrsRZones1'];
}
// Defining List Recordset variable
$NXTSort_rsRZones = "PROMTOTAL DESC";
if (isset($_SESSION['sorter_tso_listrsRZones1'])) {
  $NXTSort_rsRZones = $_SESSION['sorter_tso_listrsRZones1'];
}
mysql_select_db($database_oConnPPSYV, $oConnPPSYV);

$query_rsRZones = sprintf("SELECT * FROM q_resultado_ppsyv_area WHERE trimestre = %s AND reg_ano = %s ORDER BY PROMTOTAL DESC", GetSQLValueString($colname_rsRZones, "text"),GetSQLValueString($colano_rsRZones, "text"));
$rsRZones = mysql_query($query_rsRZones, $oConnPPSYV) or die(mysql_error());
$row_rsRZones = mysql_fetch_assoc($rsRZones);
$totalRows_rsRZones = mysql_num_rows($rsRZones);
//End NeXTenesio3 Special List Recordset

$vClass = $row_Recordset1['Class'];
$vLevel = $row_Recordset1['intLevel'];
$vQualifier = $row_rspbl['pbl_ano'];
$vRegion = trim($row_Recordset2['Province'])." ".trim($row_Recordset2['Region']);
$vSchoolType = $row_Recordset1['School Type'];
//$vJumpType = $row_Recordset1['JType'];



/**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2009 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 * 
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2009 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.7.1, 2009-11-02
 */

/** Error reporting */
error_reporting(E_ALL);

/** PHPExcel */
require_once '../Classes/PHPExcel.php';

require_once '../Classes/PHPExcel/Cell/AdvancedValueBinder.php';

/** PHPExcel_IOFactory */
require_once '../Classes/PHPExcel/IOFactory.php';

/** PHPExcel_RichText */
require_once '../Classes/PHPExcel/RichText.php';


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set properties
$objPHPExcel->getProperties()->setCreator("c-Roach designs")
							 ->setLastModifiedBy("Roche De Kock")
							 ->setTitle("SANEF Schools Export")
							 ->setSubject("Running Order")
							 ->setDescription("Running Order Export")
							 ->setKeywords("office 2003 openxml php")
							 ->setCategory("Results");


$title = array(
    'font' => array(
        'name' => 'Tahoma',
        'size' => 11,
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



// Add some data
$objPHPExcel->getActiveSheet()->duplicateStyleArray($title, 'A1:G1');
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Puesto')->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('B1', 'Area')->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('C1', 'Camara Escondida (40%)')->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('D1', 'Evaluacion V.S. (20%)')->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('E1', 'Sondeo a Clientes (20%)')->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('F1', 'Evaluacion de Imagen (20%)')->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('G1', 'Total (100%)')->getColumnDimension('G')->setAutoSize(true);



//$objPHPExcel->getActiveSheet()->getStyle('A1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB(PHPExcel_Style_Color::COLOR_GREEN);
//$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
//$objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
//$objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
//$objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
//$objPHPExcel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
//$objPHPExcel->getActiveSheet()->getStyle('G1')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
//$objPHPExcel->getActiveSheet()->getStyle('H1')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
//$objPHPExcel->getActiveSheet()->getStyle('I1')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
//$objPHPExcel->getActiveSheet()->getStyle('J1')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);


$xlsRow = 2;
$xlsNr = 1;

//->getColumnDimension('C')->setAutoSize(true)
do {
$objPHPExcel->getActiveSheet()->setCellValue('A'.$xlsRow, $xlsNr)->getStyle('A2:A'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('B'.$xlsRow, $row_rsRZones['pbl_area'])->getStyle('B2:B'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('C'.$xlsRow, $row_rsRZones['PROMCE'])->getStyle('C2:C'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('D'.$xlsRow, $row_rsRZones['PROMEVS'])->getStyle('D2:D'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('E'.$xlsRow, $row_rsRZones['PROMSC'])->getStyle('E2:E'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('F'.$xlsRow, $row_rsRZones['PROMREx'])->getStyle('F2:F'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('G'.$xlsRow, $row_rsRZones['PROMTOTAL'])->getStyle('G2:G'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);


$xlsRow++;
$xlsNr++;

} while ($row_rsRZones = mysql_fetch_assoc($rsRZones));
 

// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Ranking area por trimestre');
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename='.$vQualifier.'_Ranking area por trimestre.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output'); 
exit;

mysql_free_result($rsRZones);
?>