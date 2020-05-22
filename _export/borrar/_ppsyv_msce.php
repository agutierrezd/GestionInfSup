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
$query_Recordset1 = sprintf("SELECT q_resultado_concurso_01.idcycle, q_resultado_concurso_01.idcyclepbl, q_resultado_concurso_01.idpbl, q_resultado_concurso_01.pbl_name, q_resultado_concurso_01.pbl_ciudad, q_resultado_concurso_01.pbl_area, q_resultado_concurso_01.pbl_tm, q_resultado_concurso_01.cycle_status, q_resultado_concurso_01.PESO_CE, q_resultado_concurso_01.PESO_EVS, q_resultado_concurso_01.PESO_SC, q_resultado_concurso_01.PESO_REx, (PESO_CE+PESO_EVS+PESO_SC+PESO_REx) AS TOTALR, q_resultado_concurso_01.cycle_ms_tri, q_resultado_concurso_01.reg_ano FROM q_resultado_concurso_01 WHERE idpbl = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $oConnPPSYV) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$vClass = $row_Recordset1['Class'];
$vLevel = $row_Recordset1['intLevel'];
$vQualifier = $row_Recordset1['idpbl'];
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
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Orden');
$objPHPExcel->getActiveSheet()->setCellValue('B1', 'PBL');
$objPHPExcel->getActiveSheet()->setCellValue('C1', 'NOMBRE');
$objPHPExcel->getActiveSheet()->setCellValue('D1', 'AREA');
$objPHPExcel->getActiveSheet()->setCellValue('E1', 'TM');
$objPHPExcel->getActiveSheet()->setCellValue('F1', 'Camara Escondida 40%');
$objPHPExcel->getActiveSheet()->setCellValue('G1', 'Evaluacion de imagen REX 20%');
$objPHPExcel->getActiveSheet()->setCellValue('H1', 'Sondeo a Clientes 20%');
$objPHPExcel->getActiveSheet()->setCellValue('I1', 'Evaluacin V.S 20%');
$objPHPExcel->getActiveSheet()->setCellValue('J1', 'Total 100%');
$objPHPExcel->getActiveSheet()->setCellValue('K1', 'Ciclo');



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




$xlsRow = 2;
$xlsNr = 1;

do {
$objPHPExcel->getActiveSheet()->setCellValue('A'.$xlsRow, $xlsNr);
$objPHPExcel->getActiveSheet()->setCellValue('B'.$xlsRow, $row_Recordset1['idpbl']);
$objPHPExcel->getActiveSheet()->setCellValue('C'.$xlsRow, $row_Recordset1['pbl_name']);
$objPHPExcel->getActiveSheet()->setCellValue('D'.$xlsRow, $row_Recordset1['pbl_area']);
$objPHPExcel->getActiveSheet()->setCellValue('E'.$xlsRow, $row_Recordset1['pbl_tm']);
$objPHPExcel->getActiveSheet()->setCellValue('F'.$xlsRow, $row_Recordset1['PESO_CE']);
$objPHPExcel->getActiveSheet()->setCellValue('G'.$xlsRow, $row_Recordset1['PESO_REx']);
$objPHPExcel->getActiveSheet()->setCellValue('H'.$xlsRow, $row_Recordset1['PESO_SC']);
$objPHPExcel->getActiveSheet()->setCellValue('I'.$xlsRow, $row_Recordset1['PESO_EVS']);
$objPHPExcel->getActiveSheet()->setCellValue('J'.$xlsRow, $row_Recordset1['TOTALR']);
$objPHPExcel->getActiveSheet()->setCellValue('K'.$xlsRow, $row_Recordset1['cycle_ms_tri']);


$xlsRow++;
$xlsNr++;

} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
 

// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('MSCE');
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename='.$vQualifier.'_PPSYV_MSCE.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output'); 
exit;


mysql_free_result($Recordset1);


?>


?>
