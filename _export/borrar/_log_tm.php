<?php session_start(); ?>
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
if (isset($_SESSION['kt_login_user'])) {
  $colname_Recordset1 = $_SESSION['kt_login_user'];
}
mysql_select_db($database_oConnPPSYV, $oConnPPSYV);
$query_Recordset1 = sprintf("SELECT ppsyv_pbl.pbl_name AS nombrepbl, log_users.id_usrlog as codigousuario, users_global.Username as usuario, users_global.usr_name as nombre, users_global.usr_lname as apellido, ppsyv_pbl.pbl_tm as nombretm, ppsyv_pbl.pbl_tm_user as usuariotm, log_users.ip_log as ip, MAX(log_users.datein_log) as entrada, ppsyv_pbl.pbl_ciudad as ciudad, ppsyv_pbl.pbl_dealer as dealer FROM (log_users INNER JOIN users_global ON log_users.id_usrlog = users_global.idusrglobal) INNER JOIN ppsyv_pbl ON users_global.Username = ppsyv_pbl.idpbl WHERE ppsyv_pbl.pbl_tm_user = %s GROUP BY log_users.id_usrlog ORDER BY ppsyv_pbl.pbl_name ASC ", GetSQLValueString($colname_Recordset1, "text"));
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



// Add some data
$objPHPExcel->setActiveSheetIndex(0);
//$objPHPExcel->getActiveSheet()->mergeCells('A1:H1');
$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->duplicateStyleArray($title, 'A1:H1');
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'ID');
$objPHPExcel->getActiveSheet()->setCellValue('B1', 'NOMBRE PBL');
$objPHPExcel->getActiveSheet()->setCellValue('C1', 'PBL');
$objPHPExcel->getActiveSheet()->setCellValue('D1', 'NOMBRE');
$objPHPExcel->getActiveSheet()->setCellValue('E1', 'APELLIDO');
$objPHPExcel->getActiveSheet()->setCellValue('F1', 'CIUDAD');
$objPHPExcel->getActiveSheet()->setCellValue('G1', 'IP');
$objPHPExcel->getActiveSheet()->setCellValue('H1', 'FECHA ULTIMO INGRESO');


$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);


$xlsRow = 2;
$xlsNr = 1;

do {
$objPHPExcel->getActiveSheet()->setCellValue('A'.$xlsRow, $xlsNr);
$objPHPExcel->getActiveSheet()->setCellValue('B'.$xlsRow, utf8_encode($row_Recordset1['nombrepbl']));
$objPHPExcel->getActiveSheet()->setCellValue('C'.$xlsRow, $row_Recordset1['usuario']);
$objPHPExcel->getActiveSheet()->setCellValue('D'.$xlsRow, utf8_encode($row_Recordset1['nombre']));
$objPHPExcel->getActiveSheet()->setCellValue('E'.$xlsRow, utf8_encode($row_Recordset1['apellido']));
$objPHPExcel->getActiveSheet()->setCellValue('F'.$xlsRow, utf8_encode($row_Recordset1['ciudad']));
$objPHPExcel->getActiveSheet()->setCellValue('G'.$xlsRow, $row_Recordset1['ip']);
$objPHPExcel->getActiveSheet()->setCellValue('H'.$xlsRow, $row_Recordset1['entrada'])->getStyle('H2:H'.$xlsRow)->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);


$xlsRow++;
$xlsNr++;

} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
 

// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Ingresos_Dealers');
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename=Ingreso_Dealers.xls');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output'); 
exit;


mysql_free_result($Recordset1);


?>

