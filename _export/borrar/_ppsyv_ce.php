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
$query_Recordset1 = sprintf("SELECT * FROM ppsyv_tab_msce WHERE msce_PBL = %s ORDER BY msce_idcycle ASC", GetSQLValueString($colname_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $oConnPPSYV) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$vClass = $row_Recordset1['Class'];
$vLevel = $row_Recordset1['intLevel'];
$vQualifier = $row_Recordset1['msce_PBL'];
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
$objPHPExcel->getActiveSheet()->setCellValue('C1', 'FECHA_ENCUESTA');
$objPHPExcel->getActiveSheet()->setCellValue('D1', 'FECHA_REGISTRO');
$objPHPExcel->getActiveSheet()->setCellValue('E1', 'C1_CONTADOR_EN_CEROS');
$objPHPExcel->getActiveSheet()->setCellValue('F1', 'C2_ENTREGA_CAMBIO_EXACTO_Y_RECIBO');
$objPHPExcel->getActiveSheet()->setCellValue('G1', 'C3_CONOCIMIENTO_PRODUCTOS_Y_PROCEDIMIENTOS');
$objPHPExcel->getActiveSheet()->setCellValue('H1', 'TOTAL_C');
$objPHPExcel->getActiveSheet()->setCellValue('I1', 'A1_SALUDO');
$objPHPExcel->getActiveSheet()->setCellValue('J1', 'A2_SONRISA');
$objPHPExcel->getActiveSheet()->setCellValue('K1', 'A3_DESPEDIDA');
$objPHPExcel->getActiveSheet()->setCellValue('L1', 'A4_CARNET_VISIBLE');
$objPHPExcel->getActiveSheet()->setCellValue('M1', 'A5_PRESENTACION_PERSONAL_Y_UNIFORME_LIMPIO_Y_COMPLETO');
$objPHPExcel->getActiveSheet()->setCellValue('N1', 'A6_LIMPIEZA_');
$objPHPExcel->getActiveSheet()->setCellValue('O1', 'A7_AMBIENTE_SEGURO');
$objPHPExcel->getActiveSheet()->setCellValue('P1', 'A8_OFERTA_DE_GL_ADICIONAL');
$objPHPExcel->getActiveSheet()->setCellValue('Q1', 'A9_OFERTA_DE_PRODUCTOS_ADICIONALES');
$objPHPExcel->getActiveSheet()->setCellValue('R1', 'TOTAL_A');
$objPHPExcel->getActiveSheet()->setCellValue('S1', 'R1_PERSONAL_ADECUADO');
$objPHPExcel->getActiveSheet()->setCellValue('T1', 'R2_TECNOLOGIA_');
$objPHPExcel->getActiveSheet()->setCellValue('U1', 'R3_TIEMPO_DE_TRANSACCIÓN_MAXIMO');
$objPHPExcel->getActiveSheet()->setCellValue('V1', 'TOTAL_R');
$objPHPExcel->getActiveSheet()->setCellValue('W1', 'TOTAL PUNTOS');
$objPHPExcel->getActiveSheet()->setCellValue('X1', 'PROMEDIO %');
$objPHPExcel->getActiveSheet()->setCellValue('Y1', 'PESO 40%');
$objPHPExcel->getActiveSheet()->setCellValue('Z1', 'CICLO');




$objPHPExcel->getActiveSheet()->getStyle('A1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB(PHPExcel_Style_Color::COLOR_GREEN);
$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
$objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
$objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
$objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
$objPHPExcel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
$objPHPExcel->getActiveSheet()->getStyle('G1')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
$objPHPExcel->getActiveSheet()->getStyle('H1')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_GREEN);
$objPHPExcel->getActiveSheet()->getStyle('I1')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
$objPHPExcel->getActiveSheet()->getStyle('J1')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
$objPHPExcel->getActiveSheet()->getStyle('K1')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
$objPHPExcel->getActiveSheet()->getStyle('L1')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
$objPHPExcel->getActiveSheet()->getStyle('M1')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
$objPHPExcel->getActiveSheet()->getStyle('N1')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
$objPHPExcel->getActiveSheet()->getStyle('O1')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
$objPHPExcel->getActiveSheet()->getStyle('P1')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
$objPHPExcel->getActiveSheet()->getStyle('Q1')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
$objPHPExcel->getActiveSheet()->getStyle('R1')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_GREEN);
$objPHPExcel->getActiveSheet()->getStyle('S1')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
$objPHPExcel->getActiveSheet()->getStyle('T1')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
$objPHPExcel->getActiveSheet()->getStyle('U1')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
$objPHPExcel->getActiveSheet()->getStyle('V1')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_GREEN);
$objPHPExcel->getActiveSheet()->getStyle('W1')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKRED);
$objPHPExcel->getActiveSheet()->getStyle('X1')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKRED);
$objPHPExcel->getActiveSheet()->getStyle('Y1')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKRED);
$objPHPExcel->getActiveSheet()->getStyle('Z1')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);





$xlsRow = 2;
$xlsNr = 1;
$promedio = $row_Recordset1['PESOVALOR'];
$azul = ")->getStyle('Y2:Y500')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE)";
$rojo = ")->getStyle('Y2:Y500')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED)";

do {
$objPHPExcel->getActiveSheet()->setCellValue('A'.$xlsRow, $xlsNr);
$objPHPExcel->getActiveSheet()->setCellValue('B'.$xlsRow, $row_Recordset1['msce_PBL']);
$objPHPExcel->getActiveSheet()->setCellValue('C'.$xlsRow, $row_Recordset1['msce_fecha'])->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('D'.$xlsRow, $row_Recordset1['reg_fecha'])->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('E'.$xlsRow, $row_Recordset1['C1']);
$objPHPExcel->getActiveSheet()->setCellValue('F'.$xlsRow, $row_Recordset1['C2']);
$objPHPExcel->getActiveSheet()->setCellValue('G'.$xlsRow, $row_Recordset1['C3']);
$objPHPExcel->getActiveSheet()->setCellValue('H'.$xlsRow, $row_Recordset1['TC'])->getStyle('H2:H500')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
$objPHPExcel->getActiveSheet()->setCellValue('I'.$xlsRow, $row_Recordset1['A1']);
$objPHPExcel->getActiveSheet()->setCellValue('J'.$xlsRow, $row_Recordset1['A2']);
$objPHPExcel->getActiveSheet()->setCellValue('K'.$xlsRow, $row_Recordset1['A3']);
$objPHPExcel->getActiveSheet()->setCellValue('L'.$xlsRow, $row_Recordset1['A4']);
$objPHPExcel->getActiveSheet()->setCellValue('M'.$xlsRow, $row_Recordset1['A5']);
$objPHPExcel->getActiveSheet()->setCellValue('N'.$xlsRow, $row_Recordset1['A6']);
$objPHPExcel->getActiveSheet()->setCellValue('O'.$xlsRow, $row_Recordset1['A7']);
$objPHPExcel->getActiveSheet()->setCellValue('P'.$xlsRow, $row_Recordset1['A8']);
$objPHPExcel->getActiveSheet()->setCellValue('Q'.$xlsRow, $row_Recordset1['A9']);
$objPHPExcel->getActiveSheet()->setCellValue('R'.$xlsRow, $row_Recordset1['TA'])->getStyle('R2:R500')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
$objPHPExcel->getActiveSheet()->setCellValue('S'.$xlsRow, $row_Recordset1['R1']);
$objPHPExcel->getActiveSheet()->setCellValue('T'.$xlsRow, $row_Recordset1['R2']);
$objPHPExcel->getActiveSheet()->setCellValue('U'.$xlsRow, $row_Recordset1['R3']);
$objPHPExcel->getActiveSheet()->setCellValue('V'.$xlsRow, $row_Recordset1['TR'])->getStyle('V2:V500')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
$objPHPExcel->getActiveSheet()->setCellValue('W'.$xlsRow, $row_Recordset1['TT']);
$objPHPExcel->getActiveSheet()->setCellValue('X'.$xlsRow, $row_Recordset1['PROMVALOR']*100);
$objPHPExcel->getActiveSheet()->setCellValue('Y'.$xlsRow, $row_Recordset1['PESOVALOR']);
$objPHPExcel->getActiveSheet()->setCellValue('Z'.$xlsRow, $row_Recordset1['msce_idcycle']);


$xlsRow++;
$xlsNr++;

} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
 

// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Camara_escondida');
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename='.$vQualifier.'_PPSYV_CE.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output'); 
exit;


mysql_free_result($Recordset1);


?>

