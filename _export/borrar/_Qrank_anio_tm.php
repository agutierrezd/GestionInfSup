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

$colname_rsq1vsq2 = "-1";
if (isset($_GET['yeart'])) {
  $colname_rsq1vsq2 = $_GET['yeart'];
}
$coltm_rsq1vsq2 = "-1";
if (isset($_GET['rtm'])) {
  $coltm_rsq1vsq2 = $_GET['rtm'];
}
mysql_select_db($database_oConnPPSYV, $oConnPPSYV);
mysql_set_charset('utf8',$oConnPPSYV);
$query_rsq1vsq2 = sprintf("SELECT * FROM q_ranking_ano WHERE reg_ano = %s and pbl_tm_user = %s ORDER BY promedio DESC", GetSQLValueString($colname_rsq1vsq2, "date"),GetSQLValueString($coltm_rsq1vsq2, "text"));
$rsq1vsq2 = mysql_query($query_rsq1vsq2, $oConnPPSYV) or die(mysql_error());
$row_rsq1vsq2 = mysql_fetch_assoc($rsq1vsq2);
$totalRows_rsq1vsq2 = mysql_num_rows($rsq1vsq2);








//End NeXTenesio3 Special List Recordset

$vClass = $row_Recordset1['Class'];
$vLevel = $row_Recordset1['intLevel'];
$vQualifier = $row_rspbl['pbl_ano'];
$vQualifier2 = $_GET['periodo'];
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
//$objPHPExcel->createSheet();

$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->duplicateStyleArray($title2, 'A1');
$objPHPExcel->getActiveSheet()->setCellValue('A1', utf8_encode('RANKING AÑO  '.$_GET['yeart']));
$objPHPExcel->getActiveSheet()->mergeCells('A1:L1');
$objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->duplicateStyleArray($title, 'A2:L2');
$objPHPExcel->getActiveSheet()->setCellValue('A2', 'PUESTO');
$objPHPExcel->getActiveSheet()->setCellValue('B2', 'PBL');
$objPHPExcel->getActiveSheet()->setCellValue('C2', 'NOMBRE DEL PBL');
$objPHPExcel->getActiveSheet()->setCellValue('D2', 'CIUDAD');
$objPHPExcel->getActiveSheet()->setCellValue('E2', 'DEALER');
$objPHPExcel->getActiveSheet()->setCellValue('F2', 'TM');
$objPHPExcel->getActiveSheet()->setCellValue('G2', 'PAIS');
$objPHPExcel->getActiveSheet()->setCellValue('H2', 'PERIODO 1');
$objPHPExcel->getActiveSheet()->setCellValue('I2', 'PERIODO 2');
$objPHPExcel->getActiveSheet()->setCellValue('J2', 'PERIODO 3');
$objPHPExcel->getActiveSheet()->setCellValue('K2', 'PERIODO 4');
$objPHPExcel->getActiveSheet()->setCellValue('L2', 'PROMEDIO   GENERAL');


$objPHPExcel->getActiveSheet()->getStyle('L2')->getAlignment()->setWrapText(true);


$xlsRow = 3;
$xlsNr = 1;

//->getColumnDimension('C')->setAutoSize(true)
do {
$objPHPExcel->getActiveSheet()->setCellValue('A'.$xlsRow, $xlsNr);
$objPHPExcel->getActiveSheet()->setCellValue('B'.$xlsRow, $row_rsq1vsq2['idpbl']);
$objPHPExcel->getActiveSheet()->setCellValue('C'.$xlsRow, $row_rsq1vsq2['pbl_name']);
$objPHPExcel->getActiveSheet()->setCellValue('D'.$xlsRow, $row_rsq1vsq2['pbl_ciudad']);
$objPHPExcel->getActiveSheet()->setCellValue('E'.$xlsRow, $row_rsq1vsq2['pbl_dealer']);
$objPHPExcel->getActiveSheet()->setCellValue('F'.$xlsRow, $row_rsq1vsq2['pbl_tm_user']);
$objPHPExcel->getActiveSheet()->setCellValue('G'.$xlsRow, $row_rsq1vsq2['pais_name']);
$objPHPExcel->getActiveSheet()->setCellValue('H'.$xlsRow, $row_rsq1vsq2['PERIODO_1']);
$objPHPExcel->getActiveSheet()->setCellValue('I'.$xlsRow, $row_rsq1vsq2['PERIODO_2']);
$objPHPExcel->getActiveSheet()->setCellValue('J'.$xlsRow, $row_rsq1vsq2['PERIODO_3']);
$objPHPExcel->getActiveSheet()->setCellValue('K'.$xlsRow, $row_rsq1vsq2['PERIODO_4']);
$objPHPExcel->getActiveSheet()->setCellValue('L'.$xlsRow, number_format($row_rsq1vsq2['promedio'],2));
	
$objPHPExcel->getActiveSheet()->getStyle('A3:L'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);


$xlsRow++;
$xlsNr++;

} while ($row_rsq1vsq2 = mysql_fetch_assoc($rsq1vsq2));
 

// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('RANKING_CONSOLIDADO');
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel; charset=utf-8');
header('Content-Disposition: attachment;filename=RANKING_CONSOLIDADO.xls');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output'); 
exit;

mysql_free_result($rsq1vsq2);
?>