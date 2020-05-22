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

$colname_Recordset1 = "-1";
if (isset($_GET['idpbl'])) {
  $colname_Recordset1 = $_GET['idpbl'];
}
mysql_select_db($database_oConnPPSYV, $oConnPPSYV);
$query_Recordset1 = sprintf("SELECT * FROM ppsyv_tab_ed WHERE ed_pbl_fk = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $oConnPPSYV) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$vClass = $row_Recordset1['Class'];
$vLevel = $row_Recordset1['intLevel'];
$vQualifier = $row_Recordset1['ed_pbl_fk'];
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


$styleThinBlackBorderOutline = array(
	'borders' => array(
		'outline' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
			'color' => array('argb' => 'FF000000'),
		),
	),
);

$styleThickBlackBorderOutline = array(
	'borders' => array(
		'outline' => array(
			'style' => PHPExcel_Style_Border::BORDER_THICK,
			'color' => array('argb' => 'FF000000'),
		),
	),
);

// Add some data
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'ID');
$objPHPExcel->getActiveSheet()->setCellValue('B1', 'PBL');
$objPHPExcel->getActiveSheet()->setCellValue('C1', 'P1');
$objPHPExcel->getActiveSheet()->setCellValue('D1', 'P2');
$objPHPExcel->getActiveSheet()->setCellValue('E1', 'P3');
$objPHPExcel->getActiveSheet()->setCellValue('F1', 'P4');
$objPHPExcel->getActiveSheet()->setCellValue('G1', 'P5');
$objPHPExcel->getActiveSheet()->setCellValue('H1', 'P6');
$objPHPExcel->getActiveSheet()->setCellValue('I1', 'P7');
$objPHPExcel->getActiveSheet()->setCellValue('J1', 'P8');
$objPHPExcel->getActiveSheet()->setCellValue('K1', 'P9');
$objPHPExcel->getActiveSheet()->setCellValue('L1', 'P10');
$objPHPExcel->getActiveSheet()->setCellValue('M1', 'P11');
$objPHPExcel->getActiveSheet()->setCellValue('N1', 'P12');
$objPHPExcel->getActiveSheet()->setCellValue('O1', 'P13');
$objPHPExcel->getActiveSheet()->setCellValue('P1', 'P14');
$objPHPExcel->getActiveSheet()->setCellValue('Q1', 'P15');
$objPHPExcel->getActiveSheet()->setCellValue('R1', 'P16');
$objPHPExcel->getActiveSheet()->setCellValue('S1', 'TOTAL_RESPUESTAS');
$objPHPExcel->getActiveSheet()->setCellValue('T1', 'PROMEDIO 20%');
$objPHPExcel->getActiveSheet()->setCellValue('U1', 'COMENTARIOS');
$objPHPExcel->getActiveSheet()->setCellValue('V1', 'CICLO');



$objPHPExcel->getActiveSheet()->getStyle('A1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB(PHPExcel_Style_Color::COLOR_GREEN);
$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
$objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
$objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
$objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
$objPHPExcel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
$objPHPExcel->getActiveSheet()->getStyle('G1')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
$objPHPExcel->getActiveSheet()->getStyle('H1')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
$objPHPExcel->getActiveSheet()->getStyle('I1')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
$objPHPExcel->getActiveSheet()->getStyle('J1')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
$objPHPExcel->getActiveSheet()->getStyle('K1')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
$objPHPExcel->getActiveSheet()->getStyle('L1')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
$objPHPExcel->getActiveSheet()->getStyle('M1')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
$objPHPExcel->getActiveSheet()->getStyle('N1')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
$objPHPExcel->getActiveSheet()->getStyle('O1')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
$objPHPExcel->getActiveSheet()->getStyle('P1')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
$objPHPExcel->getActiveSheet()->getStyle('Q1')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
$objPHPExcel->getActiveSheet()->getStyle('R1')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
$objPHPExcel->getActiveSheet()->getStyle('S1')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
$objPHPExcel->getActiveSheet()->getStyle('T1')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
$objPHPExcel->getActiveSheet()->getStyle('U1')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
$objPHPExcel->getActiveSheet()->getStyle('V1')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);








$xlsRow = 2;
$xlsNr = 1;


do {
$objPHPExcel->getActiveSheet()->setCellValue('A'.$xlsRow, $xlsNr);
$objPHPExcel->getActiveSheet()->setCellValue('B'.$xlsRow, $row_Recordset1['ed_pbl_fk']);
$objPHPExcel->getActiveSheet()->setCellValue('C'.$xlsRow, $row_Recordset1['ed_q01'])->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('D'.$xlsRow, $row_Recordset1['ed_q02'])->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('E'.$xlsRow, $row_Recordset1['ed_q03'])->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('F'.$xlsRow, $row_Recordset1['ed_q04'])->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('G'.$xlsRow, $row_Recordset1['ed_q05'])->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('H'.$xlsRow, $row_Recordset1['ed_q06'])->getColumnDimension('H')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('I'.$xlsRow, $row_Recordset1['ed_q07'])->getColumnDimension('I')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('J'.$xlsRow, $row_Recordset1['ed_q08'])->getColumnDimension('J')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('K'.$xlsRow, $row_Recordset1['ed_q09'])->getColumnDimension('K')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('L'.$xlsRow, $row_Recordset1['ed_q10'])->getColumnDimension('L')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('M'.$xlsRow, $row_Recordset1['ed_q11'])->getColumnDimension('M')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('N'.$xlsRow, $row_Recordset1['ed_q12'])->getColumnDimension('N')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('O'.$xlsRow, $row_Recordset1['ed_q13'])->getColumnDimension('O')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('P'.$xlsRow, $row_Recordset1['ed_q14'])->getColumnDimension('P')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('Q'.$xlsRow, $row_Recordset1['ed_q15'])->getColumnDimension('Q')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('R'.$xlsRow, $row_Recordset1['ed_q16'])->getColumnDimension('R')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('S'.$xlsRow, $row_Recordset1['ed_totalq'])->getColumnDimension('S')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('T'.$xlsRow, $row_Recordset1['ed_pesototal'])->getColumnDimension('T')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('U'.$xlsRow, $row_Recordset1['ed_comments']);
$objPHPExcel->getActiveSheet()->setCellValue('V'.$xlsRow, $row_Recordset1['ed_cycle']);


$xlsRow++;
$xlsNr++;

} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
 

// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Imagen REx');
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename='.$vQualifier.'_PPSYV_REx.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output'); 
exit;


mysql_free_result($Recordset1);


?>

