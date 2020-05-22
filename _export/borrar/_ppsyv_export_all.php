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

$colname_ms = "-1";
if (isset($_GET['idpbl'])) {
  $colname_ms = $_GET['idpbl'];
}
mysql_select_db($database_oConnPPSYV, $oConnPPSYV);
$query_ms = sprintf("SELECT * FROM ppsyv_tab_msce WHERE msce_PBL = %s ORDER BY msce_idcycle ASC", GetSQLValueString($colname_ms, "text"));
$ms = mysql_query($query_ms, $oConnPPSYV) or die(mysql_error());
$row_ms = mysql_fetch_assoc($ms);
$totalRows_ms = mysql_num_rows($ms);

$col_sc = "-1";
if (isset($_GET['idpbl'])) {
  $col_sc = $_GET['idpbl'];
}
mysql_select_db($database_oConnPPSYV, $oConnPPSYV);
mysql_set_charset('utf8',$oConnPPSYV);
$query_sc = sprintf("SELECT ppsyv_tab_sc.id_sc, ppsyv_tab_sc.sc_cycle, ppsyv_tab_sc.sc_transacycle, ppsyv_tab_sc.sc_countcycle, ppsyv_tab_sc.sc_pbl_fk, ppsyv_tab_sc.sc_hora, ppsyv_tab_sc.sc_entrenador, ppsyv_encuestador.encuestador_name, ppsyv_tab_sc.sc_namevendedor, q_grupo_vendedores.evs_namec, ppsyv_tab_sc.sc_numencuesta, ppsyv_tab_sc.sc_01, ppsyv_tab_sc.sc_02, ppsyv_tab_sc.sc_03, ppsyv_tab_sc.sc_08, ppsyv_tab_sc.sc_comments, ppsyv_tab_sc.sc_clientehabitual, ppsyv_tab_sc.sc_clientehabitualcomments, ppsyv_tab_sc.user_reg, ppsyv_tab_sc.user_fecha, ppsyv_tab_sc.user_hora, ppsyv_tab_sc.user_status, global_opciones_respuesta.idopcion, global_opciones_respuesta.opcionname, global_opciones_respuesta.opcionevs FROM ppsyv_tab_sc Inner Join global_opciones_respuesta ON ppsyv_tab_sc.sc_clientehabitual = global_opciones_respuesta.idopcion Inner Join ppsyv_encuestador ON ppsyv_tab_sc.sc_entrenador = ppsyv_encuestador.encuestador_docid Left Join q_grupo_vendedores ON ppsyv_tab_sc.sc_namevendedor = q_grupo_vendedores.evs_docuc WHERE sc_pbl_fk = %s", GetSQLValueString($col_sc, "text"));
$sc = mysql_query($query_sc, $oConnPPSYV) or die(mysql_error());
$row_sc = mysql_fetch_assoc($sc);
$totalRows_sc = mysql_num_rows($sc);

$colrex_rex = "-1";
if (isset($_GET['idpbl'])) {
  $colrex_rex = $_GET['idpbl'];
}
mysql_select_db($database_oConnPPSYV, $oConnPPSYV);
$query_rex = sprintf("SELECT * FROM z_rex_01 WHERE ed_pbl_fk = %s", GetSQLValueString($colrex_rex, "text"));
$rex = mysql_query($query_rex, $oConnPPSYV) or die(mysql_error());
$row_rex = mysql_fetch_assoc($rex);
$totalRows_rex = mysql_num_rows($rex);

$colmsce_msce = "-1";
if (isset($_GET['idpbl'])) {
  $colmsce_msce = $_GET['idpbl'];
}
mysql_select_db($database_oConnPPSYV, $oConnPPSYV);
$query_msce = sprintf("SELECT * FROM z_msce WHERE z_msce.idpbl = %s", GetSQLValueString($colmsce_msce, "text"));
$msce = mysql_query($query_msce, $oConnPPSYV) or die(mysql_error());
$row_msce = mysql_fetch_assoc($msce);
$totalRows_msce = mysql_num_rows($msce);

$colname_vis = "-1";
if (isset($_GET['idpbl'])) {
  $colname_vis = $_GET['idpbl'];
}
mysql_select_db($database_oConnPPSYV, $oConnPPSYV);
$query_vis = sprintf("SELECT * FROM ppsyv_tab_vis WHERE vis_pbl_fk = %s", GetSQLValueString($colname_vis, "int"));
$vis = mysql_query($query_vis, $oConnPPSYV) or die(mysql_error());
$row_vis = mysql_fetch_assoc($vis);
$totalRows_vis = mysql_num_rows($vis);

$col_evs = "-1";
if (isset($_GET['idpbl'])) {
  $col_evs = $_GET['idpbl'];
}
mysql_select_db($database_oConnPPSYV, $oConnPPSYV);
mysql_set_charset('utf8',$oConnPPSYV);
$query_evs = sprintf("SELECT ppsyv_tab_evs.id_evs, ppsyv_tab_evs.evs_cycle, ppsyv_tab_evs.evs_pbl_fk, ppsyv_tab_evs.evs_transacycle, ppsyv_tab_evs.evs_countcycle, ppsyv_tab_evs.evs_entrenador, ppsyv_tab_evs.evs_namec, ppsyv_tab_evs.evs_docuc, ppsyv_tab_evs.evs_01, ppsyv_tab_evs.evs_02, ppsyv_tab_evs.evs_03, ppsyv_tab_evs.evs_04, ppsyv_tab_evs.evs_05, UNO.opcionevs AS UNO, DOS.opcionevs AS DOS, TRES.opcionevs AS TRES, CUATRO.opcionevs AS CUATRO, CINCO.opcionevs AS CINCO, ppsyv_tab_evs.evs_comments, ppsyv_tab_evs.user_reg, ppsyv_tab_evs.user_fecha, ppsyv_tab_evs.user_hora, ppsyv_tab_evs.user_status FROM ppsyv_tab_evs Inner Join global_opciones_respuesta AS UNO ON ppsyv_tab_evs.evs_01 = UNO.idopcion Inner Join global_opciones_respuesta AS DOS ON ppsyv_tab_evs.evs_02 = DOS.idopcion Inner Join global_opciones_respuesta AS TRES ON ppsyv_tab_evs.evs_03 = TRES.idopcion Inner Join global_opciones_respuesta AS CUATRO ON ppsyv_tab_evs.evs_04 = CUATRO.idopcion Inner Join global_opciones_respuesta AS CINCO ON ppsyv_tab_evs.evs_05 = CINCO.idopcion WHERE evs_pbl_fk = %s", GetSQLValueString($col_evs, "text"));
$evs = mysql_query($query_evs, $oConnPPSYV) or die(mysql_error());
$row_evs = mysql_fetch_assoc($evs);
$totalRows_evs = mysql_num_rows($evs);
?>
<?php
/**
***********************************************************************************mysql_set_charset('utf8',$oConnPPSYV);
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
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt LGPL
 * @version    1.6.5, 2009-01-05
 */

/** Error reporting */
error_reporting(E_ALL);

/** Include path **/
set_include_path(get_include_path() . PATH_SEPARATOR . '../Classes/');

/** PHPExcel */
require_once '../Classes/PHPExcel.php';

/** PHPExcel_RichText */
require_once '../Classes/PHPExcel/RichText.php';
require_once '../Classes/PHPExcel/IOFactory.php';

// Create new PHPExcel object
//echo date('H:i:s') . " Create new PHPExcel object\n";


$objPHPExcel = new PHPExcel();

// Set properties
//echo date('H:i:s') . " Set properties\n";

$objPHPExcel->getProperties()->setCreator("IBM");
$objPHPExcel->getProperties()->setLastModifiedBy("IBM");
$objPHPExcel->getProperties()->setTitle("Office 2007 XLSX ISP RX Upgrade Document");
$objPHPExcel->getProperties()->setSubject("Office 2007 XLSX ISP RX Upgrade Document");
$objPHPExcel->getProperties()->setDescription("Document for ISP - RX Upgrade Data and Chart.");
$objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
$objPHPExcel->getProperties()->setCategory("Report result file");

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
//********************************************

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
            'rgb' => '006600',
        ),
    ),
);



//*******************************************

$title3 = array(
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
            'rgb' => '0000FF',
        ),
    ),
);



//*******************************************

$title4 = array(
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


//****************************************
$styleArray = array(
      'font' => array(
        'name' => 'Tahoma',
        'size' => '9',
      ),
      'borders' => array(
        'left' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN,
        ),
        'right' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN,
        ),
        'vertical' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN,
        ),
		'bottom' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN,
        ),
      ),
      'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
          'argb' => 'FFFFFFCC',
        ),
      ),
    );
//$worksheet->getStyle('A13:J'.$row)->applyFromArray($styleArray);

$styleArray2 = array(

'borders' => array(

'outline' => array(

'style' => PHPExcel_Style_Border::BORDER_THICK,

'color' => array('argb' => 'FFFF0000'),

'allbordersoutline' => PHPExcel_Style_Border::BORDER_THIN,

),

),

);




////////////////////////////////////////////////////////////////////////////////////////
// Crea hoja de SONDEO A CLIENTES,
$objPHPExcel->getActiveSheet()->duplicateStyleArray($title4, 'A1');
$objPHPExcel->getActiveSheet()->duplicateStyleArray($title4, 'A2');
$objPHPExcel->getActiveSheet()->setCellValue('A1', utf8_encode('PASIÓN POR SERVIR Y VENDER'));
$objPHPExcel->getActiveSheet()->setCellValue('A2', 'SONDEO A CLIENTES PBL: '.$row_sc['sc_pbl_fk'].' Entrenador: '.$row_sc['encuestador_name']);
$objPHPExcel->getActiveSheet()->mergeCells('A1:K1');
$objPHPExcel->getActiveSheet()->mergeCells('A2:K2');
$objPHPExcel->getActiveSheet()->getStyle('A1:K2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->duplicateStyleArray($title, 'A3:K3');
$objPHPExcel->getActiveSheet()->setCellValue('F3', 'CONFIABLE');
$objPHPExcel->getActiveSheet()->setCellValue('G3', 'AMIGABLE');
$objPHPExcel->getActiveSheet()->setCellValue('H3', 'RAPIDO');

$objPHPExcel->getActiveSheet()->duplicateStyleArray($title, 'A4:K4');
$objPHPExcel->getActiveSheet()->setCellValue('A4', 'ID');
$objPHPExcel->getActiveSheet()->setCellValue('B4', 'ORDEN');
$objPHPExcel->getActiveSheet()->setCellValue('C4', 'HORA');
$objPHPExcel->getActiveSheet()->setCellValue('D4', 'VENDEDOR  ');
$objPHPExcel->getActiveSheet()->setCellValue('E4', 'ENCUESTA No.');
$objPHPExcel->getActiveSheet()->setCellValue('F4', 'Min (1) Max (5)');
$objPHPExcel->getActiveSheet()->setCellValue('G4', 'Min (1) Max (5)');
$objPHPExcel->getActiveSheet()->setCellValue('H4', 'Min (1) Max (5)');
$objPHPExcel->getActiveSheet()->setCellValue('I4', 'COMENTARIOS   ');
$objPHPExcel->getActiveSheet()->setCellValue('J4', 'CLIENTE HABITUAL   ');
$objPHPExcel->getActiveSheet()->setCellValue('K4', 'MES   ');

//Define el ancho de las columnas
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getStyle('L3')->getAlignment()->setWrapText(true);




$xlsRow = 5;
$xlsNr = 1;


do {
$objPHPExcel->getActiveSheet()->setCellValue('A'.$xlsRow, $xlsNr)->getStyle('A2:A'.$xlsRow);
$objPHPExcel->getActiveSheet()->setCellValue('B'.$xlsRow, $row_sc['sc_countcycle']);
$objPHPExcel->getActiveSheet()->setCellValue('C'.$xlsRow, $row_sc['sc_hora']);
$objPHPExcel->getActiveSheet()->setCellValue('D'.$xlsRow, $row_sc['evs_namec']);
$objPHPExcel->getActiveSheet()->setCellValue('E'.$xlsRow, $row_sc['sc_numencuesta']);
$objPHPExcel->getActiveSheet()->setCellValue('F'.$xlsRow, $row_sc['sc_01']);
$objPHPExcel->getActiveSheet()->setCellValue('G'.$xlsRow, $row_sc['sc_02']);
$objPHPExcel->getActiveSheet()->setCellValue('H'.$xlsRow, $row_sc['sc_03']);
$objPHPExcel->getActiveSheet()->setCellValue('I'.$xlsRow, $row_sc['sc_comments']);
$objPHPExcel->getActiveSheet()->setCellValue('J'.$xlsRow, $row_sc['opcionname']);
$objPHPExcel->getActiveSheet()->setCellValue('K'.$xlsRow, $row_sc['sc_cycle']);


$xlsRow++;
$xlsNr++;

} while ($row_sc = mysql_fetch_assoc($sc));


// Define nombre de la hoja, orientación y tipo de papel
$objPHPExcel->getActiveSheet()->setTitle('SC');
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);

/////////////////////////////////////////////////////////////////////////////////////////
// Crea hoja de EVALUACION A VENDEDORES DE SERVICIO
$objPHPExcel->createSheet();


$objPHPExcel->setActiveSheetIndex(1);
$objPHPExcel->getActiveSheet()->duplicateStyleArray($title4, 'A1');
$objPHPExcel->getActiveSheet()->duplicateStyleArray($title4, 'A2');
$objPHPExcel->getActiveSheet()->setCellValue('A1', utf8_encode('PASIÓN POR SERVIR Y VENDER'));
$objPHPExcel->getActiveSheet()->setCellValue('A2', utf8_encode('EVALUACIÓN VENDEDORES DE SERVICIOS PBL: '.$row_evs['evs_pbl_fk']));
$objPHPExcel->getActiveSheet()->mergeCells('A1:K1');
$objPHPExcel->getActiveSheet()->mergeCells('A2:K2');
$objPHPExcel->getActiveSheet()->getStyle('A1:K2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->duplicateStyleArray($title, 'A3:K3');
$objPHPExcel->getActiveSheet()->setCellValue('A3', 'ID');
$objPHPExcel->getActiveSheet()->setCellValue('B3', 'ORDEN');
$objPHPExcel->getActiveSheet()->setCellValue('C3', 'NOMBRE')->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('D3', 'DOCUMENTO  ')->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('E3', 'SURTIDOR EN CEROS');
$objPHPExcel->getActiveSheet()->setCellValue('F3', 'BUENA ACTITUD');
$objPHPExcel->getActiveSheet()->setCellValue('G3', 'SERVICIOS ADICIONALES');
$objPHPExcel->getActiveSheet()->setCellValue('H3', utf8_encode('BUENA PRESENTACIÓN'));
$objPHPExcel->getActiveSheet()->setCellValue('I3', utf8_encode('GALÓN ADICIONAL'));
$objPHPExcel->getActiveSheet()->setCellValue('J3', 'COMENTARIOS');
$objPHPExcel->getActiveSheet()->setCellValue('K3', 'MES');


$objPHPExcel->getActiveSheet()->getStyle('F3')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('G3')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('H3')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('I3')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('J3')->getAlignment()->setWrapText(true);

$xlsRow = 4;
$xlsNr = 1;

do {
$objPHPExcel->getActiveSheet()->setCellValue('A'.$xlsRow, $xlsNr)->getStyle('A2:A'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('B'.$xlsRow, $row_evs['evs_countcycle'])->getStyle('B2:B'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('C'.$xlsRow, $row_evs['evs_namec'])->getStyle('C2:C'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('D'.$xlsRow, $row_evs['evs_docuc'])->getStyle('D2:D'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('E'.$xlsRow, $row_evs['evs_01'])->getStyle('E2:E'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('F'.$xlsRow, $row_evs['evs_02'])->getStyle('F2:F'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('G'.$xlsRow, $row_evs['evs_03'])->getStyle('G2:G'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('H'.$xlsRow, $row_evs['evs_04'])->getStyle('H2:H'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('I'.$xlsRow, $row_evs['evs_05'])->getStyle('I2:I'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('J'.$xlsRow, $row_evs['evs_comments'])->getStyle('J2:J'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('K'.$xlsRow, $row_evs['evs_cycle'])->getStyle('K2:K'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);


$xlsRow++;
$xlsNr++;

} while ($row_evs = mysql_fetch_assoc($evs));


$objPHPExcel->getActiveSheet()->setCellValue('N4', '2 = SIEMPRE')->getColumnDimension('N4')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('N5', '1 = A VECES')->getColumnDimension('N5')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('N6', '0 = NUNCA')->getColumnDimension('N6')->setAutoSize(true);


$objPHPExcel->getActiveSheet(1)->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet(1)->getColumnDimension('E')->setAutoSize(true);
//$objPHPExcel->getActiveSheet(1)->getColumnDimension('K')->setAutoSize(true);


$objPHPExcel->getActiveSheet()->setTitle('EVS');
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
////////////////////////////////////////////////////////////////////////////////////////////////
// Crea hoja de Mystery Shopper Cámara escondida
$objPHPExcel->createSheet();


$objPHPExcel->setActiveSheetIndex(2);
$objPHPExcel->getActiveSheet()->duplicateStyleArray($title4, 'A1');
$objPHPExcel->getActiveSheet()->duplicateStyleArray($title4, 'A2');
$objPHPExcel->getActiveSheet()->setCellValue('A1', utf8_encode('PASIÓN POR SERVIR Y VENDER'));
$objPHPExcel->getActiveSheet()->setCellValue('A2', utf8_encode('EVALUACIÓN CÁMARA ESCONDIDA PBL: '.$row_ms['msce_PBL']));
$objPHPExcel->getActiveSheet()->mergeCells('A1:U1');
$objPHPExcel->getActiveSheet()->mergeCells('A2:U2');
$objPHPExcel->getActiveSheet()->getStyle('A1:U2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->duplicateStyleArray($title, 'A3:U3');
$objPHPExcel->getActiveSheet()->setCellValue('D3', 'C1');
$objPHPExcel->getActiveSheet()->setCellValue('E3', 'C2');
$objPHPExcel->getActiveSheet()->setCellValue('F3', 'C');
$objPHPExcel->getActiveSheet()->setCellValue('G3', 'A1');
$objPHPExcel->getActiveSheet()->setCellValue('H3', 'A2');
$objPHPExcel->getActiveSheet()->setCellValue('I3', 'A3');
$objPHPExcel->getActiveSheet()->setCellValue('J3', 'A4');
$objPHPExcel->getActiveSheet()->setCellValue('K3', 'A5');
$objPHPExcel->getActiveSheet()->setCellValue('L3', 'A6');
$objPHPExcel->getActiveSheet()->setCellValue('M3', 'A8');
$objPHPExcel->getActiveSheet()->setCellValue('N3', 'A9');
$objPHPExcel->getActiveSheet()->setCellValue('O3', 'A');
$objPHPExcel->getActiveSheet()->setCellValue('P3', 'R1');
$objPHPExcel->getActiveSheet()->setCellValue('Q3', 'R');


$objPHPExcel->getActiveSheet()->duplicateStyleArray($title, 'A4:V4');
$objPHPExcel->getActiveSheet()->setCellValue('A4', 'ID  ');
$objPHPExcel->getActiveSheet()->setCellValue('B4', 'FECHA ENCUESTA  ');
$objPHPExcel->getActiveSheet()->setCellValue('C4', 'FECHA REGISTRO ');
$objPHPExcel->getActiveSheet()->setCellValue('D4', 'CONTADOR EN CEROS  ');
$objPHPExcel->getActiveSheet()->setCellValue('E4', 'MENCIONO GASOLINA GARANTIZADA');
$objPHPExcel->getActiveSheet()->setCellValue('F4', 'TOTAL');
$objPHPExcel->getActiveSheet()->setCellValue('G4', 'SALUDO AMABLEMENTE');
$objPHPExcel->getActiveSheet()->setCellValue('H4', 'SONRISA/ACTITUD');
$objPHPExcel->getActiveSheet()->setCellValue('I4', 'DESPEDIDA');
$objPHPExcel->getActiveSheet()->setCellValue('J4', 'CARNET VISIBLE');
$objPHPExcel->getActiveSheet()->setCellValue('K4', utf8_encode('PRESENTACIÓN PERSONAL Y UNIFORME LIMPIO Y COMPLETO'));
$objPHPExcel->getActiveSheet()->setCellValue('L4', 'LIMPIEZA EN LA ZONA DE ATENCION');
$objPHPExcel->getActiveSheet()->setCellValue('M4', 'OFERTA DE GL ADICIONAL O PROMOCION VIGENTE');
$objPHPExcel->getActiveSheet()->setCellValue('N4', 'OFERTA DE PRODUCTOS / SERVICIOS ADICIONALES');
$objPHPExcel->getActiveSheet()->setCellValue('O4', 'TOTAL');
$objPHPExcel->getActiveSheet()->setCellValue('P4', 'LO RECONOCIO Y ATENDIO RAPIDAMENTE');
$objPHPExcel->getActiveSheet()->setCellValue('Q4', 'TOTAL');
$objPHPExcel->getActiveSheet()->setCellValue('R4', 'TOTAL PUNTOS');
$objPHPExcel->getActiveSheet()->setCellValue('S4', 'PROMEDIO %');
$objPHPExcel->getActiveSheet()->setCellValue('T4', 'PESO 40%');
$objPHPExcel->getActiveSheet()->setCellValue('U4', 'MES');


$xlsRow = 5;
$xlsNr = 1;


do {
$objPHPExcel->getActiveSheet()->setCellValue('A'.$xlsRow, $xlsNr)->getStyle('A2:A'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('B'.$xlsRow, $row_ms['msce_fecha'])->getStyle('B2:B'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('C'.$xlsRow, $row_ms['reg_fecha'])->getStyle('C2:C'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('D'.$xlsRow, $row_ms['C1'])->getStyle('D2:D'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('E'.$xlsRow, $row_ms['C2'])->getStyle('E2:E'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('F'.$xlsRow, $row_ms['TC'])->getStyle('F2:F'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('G'.$xlsRow, $row_ms['A1'])->getStyle('G2:G'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('H'.$xlsRow, $row_ms['A2'])->getStyle('H2:H'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('I'.$xlsRow, $row_ms['A3'])->getStyle('I2:I'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('J'.$xlsRow, $row_ms['A4'])->getStyle('J2:J'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('K'.$xlsRow, $row_ms['A5'])->getStyle('K2:K'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('L'.$xlsRow, $row_ms['A6'])->getStyle('L2:L'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('M'.$xlsRow, $row_ms['A8'])->getStyle('M2:M'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('N'.$xlsRow, $row_ms['A9'])->getStyle('N2:N'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('O'.$xlsRow, $row_ms['TA'])->getStyle('O2:O'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
//->getStyle('R2:R500')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE)
$objPHPExcel->getActiveSheet()->setCellValue('P'.$xlsRow, $row_ms['R1'])->getStyle('P2:P'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('Q'.$xlsRow, $row_ms['TR'])->getStyle('Q2:Q'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
//->getStyle('V2:V500')->getFont()->setBold(true)->setItalic(true)->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE)
$objPHPExcel->getActiveSheet()->setCellValue('R'.$xlsRow, $row_ms['TT'])->getStyle('R2:R'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('S'.$xlsRow, $row_ms['PROMVALOR']*100)->getStyle('S2:S'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('T'.$xlsRow, $row_ms['PESOVALOR'])->getStyle('T2:T'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('U'.$xlsRow, $row_ms['msce_idcycle'])->getStyle('U2:U'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);


$objPHPExcel->getActiveSheet()->duplicateStyleArray($title2, 'F4:F'.$xlsRow);
$objPHPExcel->getActiveSheet()->duplicateStyleArray($title2, 'O4:O'.$xlsRow);
$objPHPExcel->getActiveSheet()->duplicateStyleArray($title2, 'Q4:Q'.$xlsRow);
$objPHPExcel->getActiveSheet()->duplicateStyleArray($title3, 'T4:T'.$xlsRow);





$xlsRow++;
$xlsNr++;

} while ($row_ms = mysql_fetch_assoc($ms));
 


$objPHPExcel->getActiveSheet()->setTitle('CE');
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
//////////////////////////////////////////////////////////////////////////////////////////////////
// Crea hoja de Evaluación de Imagen REX
$objPHPExcel->createSheet();

$objPHPExcel->setActiveSheetIndex(3);
$objPHPExcel->getActiveSheet()->duplicateStyleArray($title4, 'A1');
$objPHPExcel->getActiveSheet()->duplicateStyleArray($title4, 'A2');
$objPHPExcel->getActiveSheet()->setCellValue('A1', utf8_encode('PASIÓN POR SERVIR Y VENDER'));
$objPHPExcel->getActiveSheet()->setCellValue('A2', utf8_encode('EVALUACIÓN IMAGEN -REX- PBL: '.$row_rex['ed_pbl_fk']));
$objPHPExcel->getActiveSheet()->mergeCells('A1:U1');
$objPHPExcel->getActiveSheet()->mergeCells('A2:U2');
$objPHPExcel->getActiveSheet()->getStyle('A1:U2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->duplicateStyleArray($title, 'A3:U3');
$objPHPExcel->getActiveSheet()->setCellValue('A3', 'ID');
$objPHPExcel->getActiveSheet()->setCellValue('B3', 'P1');
$objPHPExcel->getActiveSheet()->setCellValue('C3', 'P2');
$objPHPExcel->getActiveSheet()->setCellValue('D3', 'P3');
$objPHPExcel->getActiveSheet()->setCellValue('E3', 'P4');
$objPHPExcel->getActiveSheet()->setCellValue('F3', 'P5');
$objPHPExcel->getActiveSheet()->setCellValue('G3', 'P6');
$objPHPExcel->getActiveSheet()->setCellValue('H3', 'P7');
$objPHPExcel->getActiveSheet()->setCellValue('I3', 'P8');
$objPHPExcel->getActiveSheet()->setCellValue('J3', 'P9');
$objPHPExcel->getActiveSheet()->setCellValue('K3', 'P10');
$objPHPExcel->getActiveSheet()->setCellValue('L3', 'P11');
$objPHPExcel->getActiveSheet()->setCellValue('M3', 'P12');
$objPHPExcel->getActiveSheet()->setCellValue('N3', 'P13');
$objPHPExcel->getActiveSheet()->setCellValue('O3', 'P14');
$objPHPExcel->getActiveSheet()->setCellValue('P3', 'P15');
$objPHPExcel->getActiveSheet()->setCellValue('Q3', 'P16');
$objPHPExcel->getActiveSheet()->setCellValue('R3', 'TOTAL_RESPUESTAS');
$objPHPExcel->getActiveSheet()->setCellValue('S3', 'PROMEDIO 20%');
$objPHPExcel->getActiveSheet()->setCellValue('T3', 'COMENTARIOS');
$objPHPExcel->getActiveSheet()->setCellValue('U3', 'MES');


$xlsRow = 4;
$xlsNr = 1;

do {
//** HABILITA EL AUTOAJUSTE DE LA COLUMNA 
$objPHPExcel->getActiveSheet()->setCellValue('A'.$xlsRow, $xlsNr)->getStyle('A2:A'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('B'.$xlsRow, $row_rex['q01'])->getStyle('B2:B'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('C'.$xlsRow, $row_rex['q02'])->getStyle('C2:C'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('D'.$xlsRow, $row_rex['q03'])->getStyle('D2:D'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('E'.$xlsRow, $row_rex['q04'])->getStyle('E2:E'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('F'.$xlsRow, $row_rex['q05'])->getStyle('F2:F'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('G'.$xlsRow, $row_rex['q06'])->getStyle('G2:G'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('H'.$xlsRow, $row_rex['q07'])->getStyle('H2:H'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('I'.$xlsRow, $row_rex['q08'])->getStyle('I2:I'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('J'.$xlsRow, $row_rex['q09'])->getStyle('J2:J'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('K'.$xlsRow, $row_rex['q10'])->getStyle('K2:K'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('L'.$xlsRow, $row_rex['q11'])->getStyle('L2:L'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('M'.$xlsRow, $row_rex['q12'])->getStyle('M2:M'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('N'.$xlsRow, $row_rex['q13'])->getStyle('N2:N'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('O'.$xlsRow, $row_rex['q14'])->getStyle('O2:O'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('P'.$xlsRow, $row_rex['q15'])->getStyle('P2:P'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('Q'.$xlsRow, $row_rex['q16'])->getStyle('Q2:Q'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('R'.$xlsRow, $row_rex['TOTALREX'])->getStyle('R2:R'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('S'.$xlsRow, number_format($row_rex['TOTALREXPROM'],1))->getStyle('S2:S'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('T'.$xlsRow, $row_rex['ed_comments'])->getStyle('T2:T'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('U'.$xlsRow, $row_rex['ed_cycle'])->getStyle('U2:U'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

$objPHPExcel->getActiveSheet()->duplicateStyleArray($title3, 'S2:S'.$xlsRow);


$xlsRow++;
$xlsNr++;

} while ($row_rex = mysql_fetch_assoc($rex));


$objPHPExcel->getActiveSheet()->setCellValue('X2', '0 = No /(No Aplica)')->getColumnDimension('X2')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('X3', '1 = SI')->getColumnDimension('X3')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('X5', 'P1.Carteles de precios y mayor ID en buenas condiciones, actualizados y visibles')->getColumnDimension('X5')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('X6', 'P2.Funcionan todas las luces exteriores, libres de suciedad y sin roturas')->getColumnDimension('X6')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('X7', 'P3.Los carteles en el exterior estAn en buen estado, y muestran mensajes actualizados')->getColumnDimension('X7')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('X8', 'P4.Juegos de calcomanIas de seguridad en las dos caras de todas las columnas.')->getColumnDimension('X8')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('X9', 'P5.Panoramica en buenas condiciones y con apariencia de mantenimiento frecuente.')->getColumnDimension('X9')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('X10', 'P6.El lote esta libre de basura, manchas de derrame, sin riesgo de caidas.')->getColumnDimension('X10')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('X11', 'P7.Dispensadores de combustibles estAn limpios, sin manchas.')->getColumnDimension('X11')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('X12', 'P8.Unidades de servicio en islas estAn disponibles y abastecidas (limpia vidrios, toallas de papel, agua limpia, etc.)')->getColumnDimension('X12')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('X13', 'P9.Los cubos de basura en cada isla estAn limpios y en buen estado. Lleno no mAs de 3/4 partes.')->getColumnDimension('X13')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('X14', 'P10.Exhibidores de lubricantes en pistas son los aprobados, limpios y en buen estado.')->getColumnDimension('X14')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('X15', 'P11.Hay por lo menos un sanitario disponible para los clientes, su acceso estA libre de obstAculos.La cerradura funciona correctamente.')->getColumnDimension('X15')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('X16', 'P12.El inodoro, lavamanos, espejos, piso y paredes en buen estado y limpios.')->getColumnDimension('X16')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('X17', 'P13.El sanitario estA dotado con jabOn, papel higiEnico y toallas de papel.')->getColumnDimension('X17')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('X18', 'P14.Los lockers de empleados estAn limpios, dotados, iluminados y en buen estado.')->getColumnDimension('X18')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('X19', 'P15.Entrada/Salida y el Area de surtidores estAn despejados, sin obstrucciones.')->getColumnDimension('X19')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('X20', 'P16. Las vias de acceso a la zona de lubricaciOn están despejadas y limpias')->getColumnDimension('X20')->setAutoSize(true);




$objPHPExcel->getActiveSheet()->setTitle('REX');
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);

/////////////////////////////////////////////////////////////////////////////////////////
// Crea hoja de VISITA IN SITU,
$objPHPExcel->createSheet();

$objPHPExcel->setActiveSheetIndex(4);
$objPHPExcel->getActiveSheet()->duplicateStyleArray($title4, 'A1');
$objPHPExcel->getActiveSheet()->duplicateStyleArray($title4, 'A2');
$objPHPExcel->getActiveSheet()->setCellValue('A1', utf8_encode('PASIÓN POR SERVIR Y VENDER'));
$objPHPExcel->getActiveSheet()->setCellValue('A2', 'VISITA IN SITU PBL: '.$row_vis['vis_pbl_fk']);
$objPHPExcel->getActiveSheet()->mergeCells('A1:T1');
$objPHPExcel->getActiveSheet()->mergeCells('A2:T2');
$objPHPExcel->getActiveSheet()->getStyle('A1:T2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->duplicateStyleArray($title, 'A3:T3');
$objPHPExcel->getActiveSheet()->setCellValue('A3', 'ID');
$objPHPExcel->getActiveSheet()->setCellValue('B3', 'ATENDIDO POR');
$objPHPExcel->getActiveSheet()->setCellValue('C3', 'CARGO');
$objPHPExcel->getActiveSheet()->setCellValue('D3', 'GASOLINA EXTRA');
$objPHPExcel->getActiveSheet()->setCellValue('E3', 'COMENTARIOS');
$objPHPExcel->getActiveSheet()->setCellValue('F3', 'GASOLINA REGULAR');
$objPHPExcel->getActiveSheet()->setCellValue('G3', 'COMENTARIOS');
$objPHPExcel->getActiveSheet()->setCellValue('H3', 'DIESEL');
$objPHPExcel->getActiveSheet()->setCellValue('I3', 'COMENTARIOS');
$objPHPExcel->getActiveSheet()->setCellValue('J3', 'GAS NATURAL VEHICULAR');
$objPHPExcel->getActiveSheet()->setCellValue('K3', 'COMENTARIOS');
$objPHPExcel->getActiveSheet()->setCellValue('L3', 'LUBRICANTES');
$objPHPExcel->getActiveSheet()->setCellValue('M3', 'COMENTARIOS');
$objPHPExcel->getActiveSheet()->setCellValue('N3', 'TIQUETE PROMEDIO');
$objPHPExcel->getActiveSheet()->setCellValue('O3', 'COMENTARIOS');
$objPHPExcel->getActiveSheet()->setCellValue('P3', 'TEMAS TRATADOS');
$objPHPExcel->getActiveSheet()->setCellValue('Q3', 'COMENTARIOS DEL ENTRENADOR');
$objPHPExcel->getActiveSheet()->setCellValue('R3', utf8_encode('COMENTARIOS DE LA ESTACIÓN'));
$objPHPExcel->getActiveSheet()->setCellValue('S3', utf8_encode('FECHA REALIZACIÓN'));
$objPHPExcel->getActiveSheet()->setCellValue('T3', 'MES');


$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getStyle('E3')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('G3')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('K3')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('O3')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('R3')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('S3')->getAlignment()->setWrapText(true);

$xlsRow = 4;
$xlsNr = 1;

do {
$objPHPExcel->getActiveSheet()->setCellValue('A'.$xlsRow, $xlsNr)->getStyle('A2:A'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('B'.$xlsRow, $row_vis['vis_atendidopor'])->getStyle('B2:B'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('C'.$xlsRow, $row_vis['vis_cargo'])->getStyle('C2:C'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('D'.$xlsRow, $row_vis['vis_ge'])->getStyle('D2:D'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('E'.$xlsRow, $row_vis['vis_gec'])->getStyle('E2:E'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('F'.$xlsRow, $row_vis['vis_gr'])->getStyle('F2:F'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('G'.$xlsRow, $row_vis['vis_grc'])->getStyle('G2:G'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('H'.$xlsRow, $row_vis['vis_diesel'])->getStyle('H2:H'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('I'.$xlsRow, $row_vis['vis_dieselc'])->getStyle('I2:I'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('J'.$xlsRow, $row_vis['vis_gnv'])->getStyle('J2:J'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('K'.$xlsRow, $row_vis['vis_gnvc'])->getStyle('K2:K'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('L'.$xlsRow, $row_vis['vis_lubricante'])->getStyle('L2:L'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('M'.$xlsRow, $row_vis['vis_lubricantec'])->getStyle('M2:M'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('N'.$xlsRow, $row_vis['vis_tpc'])->getStyle('N2:N'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('O'.$xlsRow, $row_vis['vis_tpcc'])->getStyle('O2:O'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('P'.$xlsRow, $row_vis['vis_TCI'])->getStyle('P2:P'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('Q'.$xlsRow, $row_vis['vis_commenttrainter'])->getStyle('Q2:Q'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('R'.$xlsRow, $row_vis['vis_commentstation'])->getStyle('R2:R'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('S'.$xlsRow, $row_vis['vis_fecharealizada'])->getStyle('S2:S'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('T'.$xlsRow, $row_vis['vis_cycle'])->getStyle('T2:T'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);


$xlsRow++;
$xlsNr++;

} while ($row_vis = mysql_fetch_assoc($vis));



$objPHPExcel->getActiveSheet()->setTitle('VIS');
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);




//////////////////////////////////////////////////////////////////////////////////////////
// Crea hoja de PASION POR SERVIR Y VENDER
$objPHPExcel->createSheet();

$objPHPExcel->setActiveSheetIndex(5);
$objPHPExcel->getActiveSheet()->duplicateStyleArray($title4, 'A1');
$objPHPExcel->getActiveSheet()->duplicateStyleArray($title4, 'A2');
$objPHPExcel->getActiveSheet()->setCellValue('A1', utf8_encode('PASIÓN POR SERVIR Y VENDER'));
$objPHPExcel->getActiveSheet()->setCellValue('A2', 'RESUMEN TOTAL CONCURSO PBL: '.$row_msce['idpbl']);
$objPHPExcel->getActiveSheet()->mergeCells('A1:K1');
$objPHPExcel->getActiveSheet()->mergeCells('A2:K2');
$objPHPExcel->getActiveSheet()->getStyle('A1:K2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->duplicateStyleArray($title, 'A3:K3');
$objPHPExcel->getActiveSheet()->setCellValue('A3', 'Orden');
$objPHPExcel->getActiveSheet()->setCellValue('B3', 'Nombre');
$objPHPExcel->getActiveSheet()->setCellValue('C3', utf8_encode('Área'));
$objPHPExcel->getActiveSheet()->setCellValue('D3', 'TM');
$objPHPExcel->getActiveSheet()->setCellValue('E3', utf8_encode('Cámara Escondida 40%  '));
$objPHPExcel->getActiveSheet()->setCellValue('F3', utf8_encode('Evaluación de imagen REX 20%  '));
$objPHPExcel->getActiveSheet()->setCellValue('G3', 'Sondeo a Clientes 20%  ');
$objPHPExcel->getActiveSheet()->setCellValue('H3', utf8_encode('Evaluación V.S 20%  '));
$objPHPExcel->getActiveSheet()->setCellValue('I3', 'Total 100%  ');
$objPHPExcel->getActiveSheet()->setCellValue('J3', utf8_encode('Período'));
$objPHPExcel->getActiveSheet()->setCellValue('K3', 'Mes  ');



$objPHPExcel->getActiveSheet(5)->getStyle('F3')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet(5)->getStyle('G3')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet(5)->getStyle('H3')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet(5)->getStyle('I3')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet(5)->getStyle('J3')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet(5)->getColumnDimension('K')->setAutoSize(true);



$xlsRow = 4;
$xlsNr = 1;

do {
$objPHPExcel->getActiveSheet()->setCellValue('A'.$xlsRow, $xlsNr)->getStyle('A2:A'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('B'.$xlsRow, $row_msce['pbl_name'])->getStyle('B2:B'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('C'.$xlsRow, $row_msce['pbl_area'])->getStyle('C2:C'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('D'.$xlsRow, $row_msce['pbl_tm'])->getStyle('D2:D'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('E'.$xlsRow, $row_msce['PESO_CE'])->getStyle('E2:E'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('F'.$xlsRow, round($row_msce['TOTALREXPROM'],1))->getStyle('F2:F'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('G'.$xlsRow, round($row_msce['PESO_SC'],1))->getStyle('G2:G'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('H'.$xlsRow, round($row_msce['PESO_EVS'],1))->getStyle('H2:H'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('I'.$xlsRow, round($row_msce['TOTALR'],1))->getStyle('I2:I'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('J'.$xlsRow, $row_msce['cycle_ms_tri'])->getStyle('J2:J'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->setCellValue('K'.$xlsRow, $row_msce['idcyclepbl'])->getStyle('K2:K'.$xlsRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

$objPHPExcel->getActiveSheet()->duplicateStyleArray($title3, 'I2:I'.$xlsRow);


$xlsRow++;
$xlsNr++;

} while ($row_msce = mysql_fetch_assoc($msce));


 
$objPHPExcel->getActiveSheet()->setTitle('Resultados del concurso');
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);

//////////////////////////////////////////////////////////////////////////////////////////

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
//header('Content-Type: application/vnd.ms-excel');
//header('Content-Disposition: attachment;filename="01simple.xls"');
//header('Cache-Control: max-age=0');

//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
//$objWriter->save('php://output'); 
//exit;
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename='.$_GET['idpbl'].'"_CONSOLIDADO.xls');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output'); 
exit;
mysql_free_result($ms);

mysql_free_result($sc);

mysql_free_result($rex);

mysql_free_result($msce);

mysql_free_result($vis);

mysql_free_result($evs);
?>
