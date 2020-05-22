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

mysql_select_db($database_oConnPPSYV, $oConnPPSYV);
mysql_set_charset('utf8',$oConnPPSYV);
$query_rspbl = "SELECT * FROM report_resultado_ppsyv ORDER BY PROMTOTAL DESC";
$rspbl = mysql_query($query_rspbl, $oConnPPSYV) or die(mysql_error());
$row_rspbl = mysql_fetch_assoc($rspbl);
$totalRows_rspbl = mysql_num_rows($rspbl);

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
$objPHPExcel->getActiveSheet()->duplicateStyleArray($title, 'A1:K1');
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Puesto')->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('B1', 'PBL')->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('C1', 'Nombre')->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('D1', 'TM')->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('E1', 'Ciudad')->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('F1', 'Trimestre')->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('G1', 'Camara Escondida (40%)')->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('H1', 'Evaluacion V.S. (20%)')->getColumnDimension('H')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('I1', 'Sondeo a Clientes (20%)')->getColumnDimension('I')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('J1', 'Evaluacion de Imagen REX (20%) ')->getColumnDimension('J')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('K1', 'Total (100%)')->getColumnDimension('K')->setAutoSize(true);



$xlsRow = 2;
$xlsNr = 1;

//->getColumnDimension('C')->setAutoSize(true)
do {
$objPHPExcel->getActiveSheet()->setCellValue('A'.$xlsRow, $xlsNr)->getStyle('A2:A'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('B'.$xlsRow, $row_rspbl['idpbl'])->getStyle('B2:B'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('C'.$xlsRow, $row_rspbl['pbl_name'])->getStyle('C2:C'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('D'.$xlsRow, $row_rspbl['pbl_tm'])->getStyle('D2:D'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('E'.$xlsRow, $row_rspbl['pbl_ciudad'])->getStyle('E2:E'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('F'.$xlsRow, $row_rspbl['PERIODO'])->getStyle('F2:F'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('G'.$xlsRow, $row_rspbl['PROMCE'])->getStyle('G2:G'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('H'.$xlsRow, $row_rspbl['PROMEVS'])->getStyle('H2:H'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('I'.$xlsRow, $row_rspbl['PROMSC'])->getStyle('I2:I'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('J'.$xlsRow, $row_rspbl['PROMREx'])->getStyle('J2:J'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('K'.$xlsRow, $row_rspbl['PROMTOTAL'])->getStyle('K2:K'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);


$xlsRow++;
$xlsNr++;

} while ($row_rspbl = mysql_fetch_assoc($rspbl));
 

// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('RESULTADO_PPSYV');
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename='.$vQualifier.'_RESULTADO_PPSYV.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output'); 
exit;

mysql_free_result($rspbl);
?>