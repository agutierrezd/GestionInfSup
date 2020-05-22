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

$colname_rsHistRank = "-1";
if (isset($_GET['anio'])) {
  $colname_rsHistRank = $_GET['anio'];
}
$colper_rsHistRank = "-1";
if (isset($_GET['q'])) {
  $colper_rsHistRank = $_GET['q'];
}
mysql_select_db($database_oConnPPSYV, $oConnPPSYV);
$query_rsHistRank = sprintf("SELECT rank_periodo_hist.rank_id, rank_periodo_hist.rank, rank_periodo_hist.pbl, rank_periodo_hist.valor, rank_periodo_hist.periodo, rank_periodo_hist.msce, rank_periodo_hist.evs, rank_periodo_hist.sc, rank_periodo_hist.rex, rank_periodo_hist.anio, ppsyv_pbl.pbl_name, ppsyv_pbl.pbl_area, ppsyv_pbl.pbl_tm_user, ppsyv_pbl.pbl_ciudad, ppsyv_pbl.pbl_pais, ppsyv_region_pais.pais_name FROM rank_periodo_hist INNER JOIN ppsyv_pbl ON rank_periodo_hist.pbl = ppsyv_pbl.idpbl INNER JOIN ppsyv_region_pais ON ppsyv_pbl.pbl_pais = ppsyv_region_pais.idpais WHERE rank_periodo_hist.anio = %s AND rank_periodo_hist.periodo = %s ORDER BY rank_periodo_hist.rank", GetSQLValueString($colname_rsHistRank, "date"),GetSQLValueString($colper_rsHistRank, "int"));
$rsHistRank = mysql_query($query_rsHistRank, $oConnPPSYV) or die(mysql_error());
$row_rsHistRank = mysql_fetch_assoc($rsHistRank);
$totalRows_rsHistRank = mysql_num_rows($rsHistRank);

//NeXTenesio3 Special List Recordset
$colano_rsRZones = "-1";
if (isset($_GET['yearr'])) {
  $colano_rsRZones = $_GET['yearr'];
}
$colper_rsRZones = "-1";
if (isset($_GET['periodo'])) {
  $colper_rsRZones = $_GET['periodo'];
}
// Defining List Recordset variable
$NXTFilter_rsRZones = "1=1";
if (isset($_SESSION['filter_tfi_listrsRZones1'])) {
  $NXTFilter_rsRZones = $_SESSION['filter_tfi_listrsRZones1'];
}
// Defining List Recordset variable

//End NeXTenesio3 Special List Recordset

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
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'RANKING ESTACIONES DE SERVICIO ANDEAN '.$_GET['periodo'].'ANO'.$_GET['anio']);
$objPHPExcel->getActiveSheet()->mergeCells('A1:M1');
$objPHPExcel->getActiveSheet()->getStyle('A1:M1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->duplicateStyleArray($title, 'A2:M2');
$objPHPExcel->getActiveSheet()->setCellValue('A2', 'Puesto');
$objPHPExcel->getActiveSheet()->setCellValue('B2', 'PBL');
$objPHPExcel->getActiveSheet()->setCellValue('C2', 'Nombre');
$objPHPExcel->getActiveSheet()->setCellValue('D2', 'TM');
$objPHPExcel->getActiveSheet()->setCellValue('E2', 'Ciudad');
$objPHPExcel->getActiveSheet()->setCellValue('F2', utf8_encode('Área'));
$objPHPExcel->getActiveSheet()->setCellValue('G2', utf8_encode('País'));
$objPHPExcel->getActiveSheet()->setCellValue('H2', utf8_encode('Período'));
$objPHPExcel->getActiveSheet()->setCellValue('I2', utf8_encode('Cámara Escondida (40%)'));
$objPHPExcel->getActiveSheet()->setCellValue('J2', utf8_encode('Evaluación V.S. (20%)'));
$objPHPExcel->getActiveSheet()->setCellValue('K2', 'Sondeo Clientes (20%)');
$objPHPExcel->getActiveSheet()->setCellValue('L2', 'Imagen REX (20%) ');
$objPHPExcel->getActiveSheet()->setCellValue('M2', 'Total (100%)');


$objPHPExcel->getActiveSheet()->getStyle('I2')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('J2')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('K2')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('L2')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('M2')->getAlignment()->setWrapText(true);




$xlsRow = 3;
$xlsNr = 1;

//->getColumnDimension('C')->setAutoSize(true)
do {
$objPHPExcel->getActiveSheet()->setCellValue('A'.$xlsRow, $row_rsHistRank['rank']);
$objPHPExcel->getActiveSheet()->setCellValue('B'.$xlsRow, $row_rsHistRank['pbl']);
$objPHPExcel->getActiveSheet()->setCellValue('C'.$xlsRow, $row_rsHistRank['pbl_name']);
$objPHPExcel->getActiveSheet()->setCellValue('D'.$xlsRow, $row_rsHistRank['pbl_tm_user']);
$objPHPExcel->getActiveSheet()->setCellValue('E'.$xlsRow, $row_rsHistRank['pbl_ciudad']);
$objPHPExcel->getActiveSheet()->setCellValue('F'.$xlsRow, $row_rsHistRank['pbl_area']);
$objPHPExcel->getActiveSheet()->setCellValue('G'.$xlsRow, $row_rsHistRank['pais_name']);
$objPHPExcel->getActiveSheet()->setCellValue('H'.$xlsRow, $row_rsHistRank['periodo']);
$objPHPExcel->getActiveSheet()->setCellValue('I'.$xlsRow, $row_rsHistRank['msce']);
$objPHPExcel->getActiveSheet()->setCellValue('J'.$xlsRow, $row_rsHistRank['evs']);
$objPHPExcel->getActiveSheet()->setCellValue('K'.$xlsRow, $row_rsHistRank['sc']);
$objPHPExcel->getActiveSheet()->setCellValue('L'.$xlsRow, $row_rsHistRank['rex']);
$objPHPExcel->getActiveSheet()->setCellValue('M'.$xlsRow, $row_rsHistRank['valor']);




$xlsRow++;
$xlsNr++;

} while ($row_rsHistRank = mysql_fetch_assoc($rsHistRank));
 

// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Ranking ES Andean');
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);



// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel; charset=utf-8');
header('Content-Disposition: attachment;filename=_Ranking_Periodo_'.$vQualifier2.'.xls');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output'); 
exit;

mysql_free_result($rsHistRank);
?>