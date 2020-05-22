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
$query_rsq1vsq2 = "SELECT rank_periodo1.pbl, ppsyv_pbl.pbl_name, ppsyv_pbl.pbl_ciudad, ppsyv_pbl.pbl_dealer, ppsyv_pbl.pbl_tm_user AS TM, ppsyv_pbl.pbl_pais, ppsyv_region_pais.pais_name AS PAIS, rank_periodo1.rank AS RANKQ1, rank_periodo1.valor AS VALORQ1, rank_periodo2.rank AS RANKQ2, rank_periodo2.valor AS VALORQ2, (rank_periodo1.rank - rank_periodo2.rank) AS QCOMPARA, IF(rank_periodo2.rank > rank_periodo1.rank, 'arrow_down.png',IF(rank_periodo2.rank < rank_periodo1.rank,'arrow_up.png','arrow_right.png')) AS QIMG, IF(rank_periodo2.rank > rank_periodo1.rank, 'FF0000',IF(rank_periodo2.rank < rank_periodo1.rank,'336600','FFFF00')) AS QCOLOR, IF(rank_periodo2.rank > rank_periodo1.rank, 'FFFFFF',IF(rank_periodo2.rank < rank_periodo1.rank,'FFFFFF','000000')) AS QFUENTE FROM rank_periodo1 INNER JOIN rank_periodo2 ON rank_periodo1.pbl = rank_periodo2.pbl INNER JOIN ppsyv_pbl ON rank_periodo1.pbl = ppsyv_pbl.idpbl INNER JOIN ppsyv_region_pais ON ppsyv_pbl.pbl_pais = ppsyv_region_pais.idpais ORDER BY rank_periodo2.rank , rank_periodo1.rank ";
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
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'COMPARACION DE PERIODO 2 Vs PERIODO 1');
$objPHPExcel->getActiveSheet()->mergeCells('A1:L1');
$objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->duplicateStyleArray($title, 'A2:L2');
$objPHPExcel->getActiveSheet()->setCellValue('A2', 'ID');
$objPHPExcel->getActiveSheet()->setCellValue('B2', 'PBL');
$objPHPExcel->getActiveSheet()->setCellValue('C2', 'NOMBRE DEL PBL');
$objPHPExcel->getActiveSheet()->setCellValue('D2', 'CIUDAD');
$objPHPExcel->getActiveSheet()->setCellValue('E2', 'DEALER');
$objPHPExcel->getActiveSheet()->setCellValue('F2', 'TM');
$objPHPExcel->getActiveSheet()->setCellValue('G2', 'PAIS');
$objPHPExcel->getActiveSheet()->setCellValue('H2', 'PUESTO PERIODO 2');
$objPHPExcel->getActiveSheet()->setCellValue('I2', 'PUNTAJE PERIODO 2');
$objPHPExcel->getActiveSheet()->setCellValue('J2', 'PUESTO PERIODO 1');
$objPHPExcel->getActiveSheet()->setCellValue('K2', 'PUNTAJE PERIODO 1');
$objPHPExcel->getActiveSheet()->setCellValue('L2', 'Q2 Vs Q1');


$objPHPExcel->getActiveSheet()->getStyle('H2')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('I2')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('J2')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('K2')->getAlignment()->setWrapText(true);


$xlsRow = 3;
$xlsNr = 1;

//->getColumnDimension('C')->setAutoSize(true)
do {
$objPHPExcel->getActiveSheet()->setCellValue('A'.$xlsRow, $xlsNr);
$objPHPExcel->getActiveSheet()->setCellValue('B'.$xlsRow, $row_rsq1vsq2['pbl']);
$objPHPExcel->getActiveSheet()->setCellValue('C'.$xlsRow, $row_rsq1vsq2['pbl_name']);
$objPHPExcel->getActiveSheet()->setCellValue('D'.$xlsRow, $row_rsq1vsq2['pbl_ciudad']);
$objPHPExcel->getActiveSheet()->setCellValue('E'.$xlsRow, $row_rsq1vsq2['pbl_dealer']);
$objPHPExcel->getActiveSheet()->setCellValue('F'.$xlsRow, $row_rsq1vsq2['TM']);
$objPHPExcel->getActiveSheet()->setCellValue('G'.$xlsRow, $row_rsq1vsq2['PAIS']);
$objPHPExcel->getActiveSheet()->setCellValue('H'.$xlsRow, $row_rsq1vsq2['RANKQ2']);
$objPHPExcel->getActiveSheet()->setCellValue('I'.$xlsRow, $row_rsq1vsq2['VALORQ2']);
$objPHPExcel->getActiveSheet()->setCellValue('J'.$xlsRow, $row_rsq1vsq2['RANKQ1']);
$objPHPExcel->getActiveSheet()->setCellValue('K'.$xlsRow, $row_rsq1vsq2['VALORQ1']);
$objPHPExcel->getActiveSheet()->setCellValue('L'.$xlsRow, $row_rsq1vsq2['QCOMPARA'])->getStyle('L'.$xlsRow, $row_rsq1vsq2['QCOLOR'])->applyFromArray(
            array('fill' 	=> array(
                    'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
                    'color'		=> array('rgb' => $row_rsq1vsq2['QCOLOR'])
					
            ),
				 'font' => array(
        			'name' => 'Tahoma',
        			'size' => 11,
        			'bold' => true,
        			'color' => array('rgb' => $row_rsq1vsq2['QFUENTE']),
    ),
            )
			
    );
	
$objPHPExcel->getActiveSheet()->getStyle('A3:L'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);




//$objPHPExcel->getActiveSheet()->duplicateStyleArray($title2, 'J3:J'.$xlsRow);

//$objPHPExcel->getActiveSheet()->getStyle('J3:J'.$xlsRow)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($row_rsq1vsq2['QCOLOR']);

//$objPHPExcel->getActiveSheet()->getStyle('J3:J'.$xlsRow)->applyFromArray(
//            array('fill' 	=> array(
//                    'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
//                    'color'		=> array('rgb' => $row_rsq1vsq2['QCOLOR'])
//            ),
//            )
//    );




$xlsRow++;
$xlsNr++;

} while ($row_rsq1vsq2 = mysql_fetch_assoc($rsq1vsq2));
 

// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Q2_VS_Q1');
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel; charset=utf-8');
header('Content-Disposition: attachment;filename=Q2_VS_Q1.xls');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output'); 
exit;

mysql_free_result($rsq1vsq2);
?>