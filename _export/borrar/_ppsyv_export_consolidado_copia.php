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
$colano_rsRZones = "-1";
if (isset($_GET['yearr'])) {
  $colano_rsRZones = $_GET['yearr'];
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
mysql_set_charset('utf8',$oConnPPSYV);
$query_rsRZones = sprintf("SELECT * FROM q_ranking_region WHERE reg_ano = %s ", GetSQLValueString($colano_rsRZones, "text"));
$rsRZones = mysql_query($query_rsRZones, $oConnPPSYV) or die(mysql_error());
$row_rsRZones = mysql_fetch_assoc($rsRZones);
$totalRows_rsRZones = mysql_num_rows($rsRZones);
//End NeXTenesio3 Special List Recordset

mysql_select_db($database_oConnPPSYV, $oConnPPSYV);
mysql_set_charset('utf8',$oConnPPSYV);
$query_rspbl = "SELECT * FROM q ORDER BY PROMTOTAL DESC";
$rspbl = mysql_query($query_rspbl, $oConnPPSYV) or die(mysql_error());
$row_rspbl = mysql_fetch_assoc($rspbl);
$totalRows_rspbl = mysql_num_rows($rspbl);

$nameper_rstm = "-1";
if (isset($_GET['periodo'])) {
  $nameper_rstm = $_GET['periodo'];
}
$colano_rstm = "-1";
if (isset($_GET['yearr'])) {
  $colano_rstm = $_GET['yearr'];
}
mysql_select_db($database_oConnPPSYV, $oConnPPSYV);
mysql_set_charset('utf8',$oConnPPSYV);
$query_rstm = sprintf("SELECT * FROM q_ranking_tm2 WHERE cycle_ms_tri = %s AND reg_ano = %s ORDER BY TOTALRANK DESC", GetSQLValueString($nameper_rstm, "int"),GetSQLValueString($colano_rstm, "text"));
$rstm = mysql_query($query_rstm, $oConnPPSYV) or die(mysql_error());
$row_rstm = mysql_fetch_assoc($rstm);
$totalRows_rstm = mysql_num_rows($rstm);

//NeXTenesio3 Special List Recordset
$colname_rsRZonesTrim = "-1";
if (isset($_GET['periodo'])) {
  $colname_rsRZonesTrim = $_GET['periodo'];
}
// Defining List Recordset variable
$NXTFilter_rsRZonesTrim = "1=1";
if (isset($_SESSION['filter_tfi_listrsRZones1'])) {
  $NXTFilter_rsRZonesTrim = $_SESSION['filter_tfi_listrsRZones1'];
}
// Defining List Recordset variable
$NXTSort_rsRZonesTrim = "PROMTOTAL DESC";
if (isset($_SESSION['sorter_tso_listrsRZones1'])) {
  $NXTSort_rsRZonesTrim = $_SESSION['sorter_tso_listrsRZones1'];
}
mysql_select_db($database_oConnPPSYV, $oConnPPSYV);
mysql_set_charset('utf8',$oConnPPSYV);
$query_rsRZonesTrim = sprintf("SELECT * FROM q_resultado_ppsyv_area WHERE trimestre = %s ORDER BY PROMTOTAL DESC", GetSQLValueString($colname_rsRZonesTrim, "int"));
$rsRZonesTrim = mysql_query($query_rsRZonesTrim, $oConnPPSYV) or die(mysql_error());
$row_rsRZonesTrim = mysql_fetch_assoc($rsRZonesTrim);
$totalRows_rsRZonesTrim = mysql_num_rows($rsRZonesTrim);
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




// Add some data
//$objPHPExcel->createSheet();

$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->duplicateStyleArray($title2, 'A1');
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'RANKING ESTACIONES DE SERVICIO ANDEAN '.$_GET['periodo'].'Q'.$_GET['yearr']);
$objPHPExcel->getActiveSheet()->mergeCells('A1:M1');
$objPHPExcel->getActiveSheet()->getStyle('A1:M1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->duplicateStyleArray($title, 'A2:M2');
$objPHPExcel->getActiveSheet()->setCellValue('A2', 'Puesto');
$objPHPExcel->getActiveSheet()->setCellValue('B2', 'PBL');
$objPHPExcel->getActiveSheet()->setCellValue('C2', 'Nombre');
$objPHPExcel->getActiveSheet()->setCellValue('D2', 'TM');
$objPHPExcel->getActiveSheet()->setCellValue('E2', 'Ciudad');
$objPHPExcel->getActiveSheet()->setCellValue('F2', 'AREA');
$objPHPExcel->getActiveSheet()->setCellValue('G2', 'PAIS');
$objPHPExcel->getActiveSheet()->setCellValue('H2', 'Trimestre');
$objPHPExcel->getActiveSheet()->setCellValue('I2', 'Camara Escondida (40%)');
$objPHPExcel->getActiveSheet()->setCellValue('J2', 'Evaluacion V.S. (20%)');
$objPHPExcel->getActiveSheet()->setCellValue('K2', 'Sondeo a Clientes (20%)');
$objPHPExcel->getActiveSheet()->setCellValue('L2', 'Evaluacion de Imagen REX (20%) ');
$objPHPExcel->getActiveSheet()->setCellValue('M2', 'Total (100%)');


$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
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
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);



$xlsRow = 3;
$xlsNr = 1;

//->getColumnDimension('C')->setAutoSize(true)
do {
$objPHPExcel->getActiveSheet()->setCellValue('A'.$xlsRow, $xlsNr);
$objPHPExcel->getActiveSheet()->setCellValue('B'.$xlsRow, $row_rspbl['idpbl']);
$objPHPExcel->getActiveSheet()->setCellValue('C'.$xlsRow, $row_rspbl['pbl_name']);
$objPHPExcel->getActiveSheet()->setCellValue('D'.$xlsRow, $row_rspbl['pbl_tm']);
$objPHPExcel->getActiveSheet()->setCellValue('E'.$xlsRow, $row_rspbl['pbl_ciudad']);
$objPHPExcel->getActiveSheet()->setCellValue('F'.$xlsRow, $row_rspbl['pbl_area']);
$objPHPExcel->getActiveSheet()->setCellValue('G'.$xlsRow, $row_rspbl['pais_name']);
$objPHPExcel->getActiveSheet()->setCellValue('H'.$xlsRow, $row_rspbl['PERIODO']);
$objPHPExcel->getActiveSheet()->setCellValue('I'.$xlsRow, $row_rspbl['PROMCE']);
$objPHPExcel->getActiveSheet()->setCellValue('J'.$xlsRow, $row_rspbl['PROMEVS']);
$objPHPExcel->getActiveSheet()->setCellValue('K'.$xlsRow, $row_rspbl['PROMSC']);
$objPHPExcel->getActiveSheet()->setCellValue('L'.$xlsRow, $row_rspbl['PROMREx']);
$objPHPExcel->getActiveSheet()->setCellValue('M'.$xlsRow, $row_rspbl['PROMTOTAL']);




$xlsRow++;
$xlsNr++;

} while ($row_rspbl = mysql_fetch_assoc($rspbl));
 

// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Ranking ES Andean');
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);


//////////////////////////////////////////////////////////////////////////////////////////////
// HOJA RANKING PAIS

$objPHPExcel->createSheet();

$objPHPExcel->setActiveSheetIndex(1);
$objPHPExcel->getActiveSheet()->duplicateStyleArray($title2, 'A1');
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'RANKING PAIS '.$_GET['periodo'].'Q'.$_GET['yearr']);
$objPHPExcel->getActiveSheet()->mergeCells('A1:H1');
$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->duplicateStyleArray($title, 'A2:H2');
$objPHPExcel->getActiveSheet()->setCellValue('A2', 'ID')->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('B2', 'PAIS  ')->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('C2', 'CANTIDAD PBLS  ')->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('D2', 'Camara Escondida (40%)  ')->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('E2', 'Evaluacion V.S. (20%)  ')->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('F2', 'Sondeo a Clientes (20%)  ')->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('G2', 'Evaluacion de Imagen (20%)  ')->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('H2', 'Total (100%)  ')->getColumnDimension('H')->setAutoSize(true);




$xlsRow = 3;
$xlsNr = 1;

//->getColumnDimension('C')->setAutoSize(true)
do {
$objPHPExcel->getActiveSheet()->setCellValue('A'.$xlsRow, $xlsNr)->getStyle('A2:A'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('B'.$xlsRow, $row_rsRZones['region_name'])->getStyle('B2:B'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('C'.$xlsRow, $row_rsRZones['REGIONQ'])->getStyle('C2:C'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('D'.$xlsRow, $row_rsRZones['PROMCE'])->getStyle('D2:D'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('E'.$xlsRow, $row_rsRZones['PROMEVS'])->getStyle('E2:E'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('F'.$xlsRow, $row_rsRZones['PROMSC'])->getStyle('F2:F'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('G'.$xlsRow, $row_rsRZones['PROMREX'])->getStyle('G2:G'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('H'.$xlsRow, $row_rsRZones['PROMTOTAL'])->getStyle('H2:H'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);




$xlsRow++;
$xlsNr++;

} while ($row_rsRZones = mysql_fetch_assoc($rsRZones));
 

// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Ranking Pais');
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);


///////////////////////////////////////////////////////////////
// HOJA RANKING AREA

$objPHPExcel->createSheet();

$objPHPExcel->setActiveSheetIndex(2);
$objPHPExcel->getActiveSheet()->duplicateStyleArray($title2, 'A1');
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'RANKING AREA '.$_GET['periodo'].'Q'.$_GET['yearr']);
$objPHPExcel->getActiveSheet()->mergeCells('A1:G1');
$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->duplicateStyleArray($title, 'A2:G2');
$objPHPExcel->getActiveSheet()->setCellValue('A2', 'Puesto')->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('B2', 'Area')->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('C2', 'Camara Escondida (40%)')->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('D2', 'Evaluacion V.S. (20%)')->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('E2', 'Sondeo a Clientes (20%)')->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('F2', 'Evaluacion de Imagen (20%)')->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('G2', 'Total (100%)')->getColumnDimension('G')->setAutoSize(true);


$xlsRow = 3;
$xlsNr = 1;


do {
$objPHPExcel->getActiveSheet()->setCellValue('A'.$xlsRow, $xlsNr)->getStyle('A2:A'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('B'.$xlsRow, $row_rsRZonesTrim['pbl_area'])->getStyle('B2:B'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('C'.$xlsRow, $row_rsRZonesTrim['PROMCE'])->getStyle('C2:C'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('D'.$xlsRow, $row_rsRZonesTrim['PROMEVS'])->getStyle('D2:D'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('E'.$xlsRow, $row_rsRZonesTrim['PROMSC'])->getStyle('E2:E'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('F'.$xlsRow, $row_rsRZonesTrim['PROMREx'])->getStyle('F2:F'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('G'.$xlsRow, $row_rsRZonesTrim['PROMTOTAL'])->getStyle('G2:G'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);


$xlsRow++;
$xlsNr++;

} while ($row_rsRZonesTrim = mysql_fetch_assoc($rsRZonesTrim));
 

// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Ranking Area');
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);

//////////////////////////////////////////////////////////////////////////////////////////////
// HOJA RANKING TM

$objPHPExcel->createSheet();

$objPHPExcel->setActiveSheetIndex(3);
$objPHPExcel->getActiveSheet()->duplicateStyleArray($title2, 'A1');
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'RANKING ESTACIONES DE SERVICIO ANDEAN '.$_GET['periodo'].'Q'.$_GET['yearr']);
$objPHPExcel->getActiveSheet()->mergeCells('A1:H1');
$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->duplicateStyleArray($title, 'A2:H2');
$objPHPExcel->getActiveSheet()->setCellValue('A2', 'Puesto')->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('B2', 'TM')->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('C2', 'Camara Escondida (40%)');
$objPHPExcel->getActiveSheet()->setCellValue('D2', 'Evaluacion V.S. (20%)');
$objPHPExcel->getActiveSheet()->setCellValue('E2', 'Sondeo a Clientes (20%)');
$objPHPExcel->getActiveSheet()->setCellValue('F2', 'Evaluacion de Imagen (20%)');
$objPHPExcel->getActiveSheet()->setCellValue('G2', 'Total (100%)');
$objPHPExcel->getActiveSheet()->setCellValue('H2', 'Periodo');


$objPHPExcel->getActiveSheet()->getStyle('C2')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('D2')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('E2')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('F2')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('G2')->getAlignment()->setWrapText(true);



$xlsRow = 3;
$xlsNr = 1;

do {
$objPHPExcel->getActiveSheet()->setCellValue('A'.$xlsRow, $xlsNr)->getStyle('A2:A'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('B'.$xlsRow, $row_rstm['pbl_tm'])->getStyle('B2:B'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('C'.$xlsRow, $row_rstm['CE'])->getStyle('C2:C'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('D'.$xlsRow, $row_rstm['EVS'])->getStyle('D2:D'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('E'.$xlsRow, $row_rstm['SC'])->getStyle('E2:E'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('F'.$xlsRow, $row_rstm['REX'])->getStyle('F2:F'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('G'.$xlsRow, $row_rstm['TOTALRANK'])->getStyle('G2:G'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('H'.$xlsRow, $row_rstm['cycle_ms_tri'])->getStyle('H2:H'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);


$objPHPExcel->getActiveSheet()->duplicateStyleArray($title, 'G2:G'.$xlsRow);


$xlsRow++;
$xlsNr++;

} while ($row_rstm = mysql_fetch_assoc($rstm));
 

// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Ranking TM');
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);




// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename='.$vQualifier.'_Ranking_Q1.xls');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output'); 
exit;

mysql_free_result($rsRZones);

mysql_free_result($rspbl);

mysql_free_result($rstm);

mysql_free_result($rsRZonesTrim);
?>