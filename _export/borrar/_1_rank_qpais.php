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

$colname_rsinfopais = "-1";
if (isset($_GET['pais'])) {
  $colname_rsinfopais = $_GET['pais'];
}
mysql_select_db($database_oConnPPSYV, $oConnPPSYV);
$query_rsinfopais = sprintf("SELECT * FROM ppsyv_region_pais WHERE idpais = %s", GetSQLValueString($colname_rsinfopais, "int"));
$rsinfopais = mysql_query($query_rsinfopais, $oConnPPSYV) or die(mysql_error());
$row_rsinfopais = mysql_fetch_assoc($rsinfopais);
$totalRows_rsinfopais = mysql_num_rows($rsinfopais);

$colname_rsinfomes = "-1";
if (isset($_GET['paismes'])) {
  $colname_rsinfomes = $_GET['paismes'];
}
mysql_select_db($database_oConnPPSYV, $oConnPPSYV);
$query_rsinfomes = sprintf("SELECT * FROM global_cycles WHERE numciclo = %s", GetSQLValueString($colname_rsinfomes, "int"));
$rsinfomes = mysql_query($query_rsinfomes, $oConnPPSYV) or die(mysql_error());
$row_rsinfomes = mysql_fetch_assoc($rsinfomes);
$totalRows_rsinfomes = mysql_num_rows($rsinfomes);


//NeXTenesio3 Special List Recordset
// Defining List Recordset variable
$colname_rsq = "-1";
if (isset($_GET['pais'])) {
  $colname_rsq = $_GET['pais'];
}
$colano_rsq = "-1";
if (isset($_GET['paisano'])) {
  $colano_rsq = $_GET['paisano'];
}
$colperiodo_rsq = "-1";
if (isset($_GET['paisperiodo'])) {
  $colperiodo_rsq = $_GET['paisperiodo'];
}
$colmes_rsq = "-1";
if (isset($_GET['paismes'])) {
  $colmes_rsq = $_GET['paismes'];
}
mysql_select_db($database_oConnPPSYV, $oConnPPSYV);
mysql_set_charset('utf8',$oConnPPSYV);
$tm = $_GET['tm'];
$tmano = $_GET['tmano'];
$tmperiodo = $_GET['tmperiodo'];
$tmmes = $_GET['tmmes'];

$condiciones = "";
$valoresq = ($colname_rsq && $colano_rsq && $colperiodo_rsq);

if ($colmes_rsq == "") {$condiciones .= "SELECT * FROM report_resultado_ppsyv WHERE pbl_pais = %s AND reg_ano = %s AND periodo = %s ";} else {$condiciones .= "SELECT * FROM report_resultado_ppsyv_2 WHERE pbl_pais = %s AND reg_ano = %s AND periodo = %s AND ciclo = %s";}

$query_rsq = sprintf("$condiciones ORDER BY promtotal desc", GetSQLValueString($colname_rsq, "text"),GetSQLValueString($colano_rsq, "int"),GetSQLValueString($colperiodo_rsq, "int"),GetSQLValueString($colmes_rsq, "int"));
$rsq = mysql_query($query_rsq, $oConnPPSYV) or die(mysql_error());
$row_rsq = mysql_fetch_assoc($rsq);
$totalRows_rsq = mysql_num_rows($rsq);
//End NeXTenesio3 Special List Recordset

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

$objPHPExcel->setActiveSheetIndex();
$objPHPExcel->getActiveSheet()->duplicateStyleArray($title2, 'A1');
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'RANKING POR PAIS  '.$row_rsinfopais['pais_name']);
$objPHPExcel->getActiveSheet()->mergeCells('A1:K1');
$objPHPExcel->getActiveSheet()->getStyle('A1:K1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->duplicateStyleArray($title, 'A2:K2');
$objPHPExcel->getActiveSheet()->setCellValue('A2', 'Puesto');
$objPHPExcel->getActiveSheet()->setCellValue('B2', 'PBL');
$objPHPExcel->getActiveSheet()->setCellValue('C2', 'Nombre E/S');
$objPHPExcel->getActiveSheet()->setCellValue('D2', 'TM');
$objPHPExcel->getActiveSheet()->setCellValue('E2', 'Ciudad');
$objPHPExcel->getActiveSheet()->setCellValue('F2', utf8_encode('Area'));
$objPHPExcel->getActiveSheet()->setCellValue('G2', utf8_encode('Camara Escondida (40%)'));
$objPHPExcel->getActiveSheet()->setCellValue('H2', utf8_encode('Evaluacion V.S. (20%)'));
$objPHPExcel->getActiveSheet()->setCellValue('I2', 'Sondeo Clientes (20%)');
$objPHPExcel->getActiveSheet()->setCellValue('J2', 'Imagen REX (20%) ');
$objPHPExcel->getActiveSheet()->setCellValue('K2', 'Total (100%)');



$objPHPExcel->getActiveSheet()->getStyle('G2')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('H2')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('I2')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('J2')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('K2')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);


$xlsRow = 3;
$xlsNr = 1;

//->getColumnDimension('C')->setAutoSize(true)
do {
$objPHPExcel->getActiveSheet()->setCellValue('A'.$xlsRow, $xlsNr);
$objPHPExcel->getActiveSheet()->setCellValue('B'.$xlsRow, $row_rsq['idpbl']);
$objPHPExcel->getActiveSheet()->setCellValue('C'.$xlsRow, $row_rsq['pbl_name']);
$objPHPExcel->getActiveSheet()->setCellValue('D'.$xlsRow, $row_rsq['pbl_tm']);
$objPHPExcel->getActiveSheet()->setCellValue('E'.$xlsRow, $row_rsq['pbl_ciudad']);
$objPHPExcel->getActiveSheet()->setCellValue('F'.$xlsRow, $row_rsq['pbl_area']);
$objPHPExcel->getActiveSheet()->setCellValue('G'.$xlsRow, $row_rsq['PROMCE']);
$objPHPExcel->getActiveSheet()->setCellValue('H'.$xlsRow, $row_rsq['PROMEVS']);
$objPHPExcel->getActiveSheet()->setCellValue('I'.$xlsRow, $row_rsq['PROMSC']);
$objPHPExcel->getActiveSheet()->setCellValue('J'.$xlsRow, $row_rsq['PROMREx']);
$objPHPExcel->getActiveSheet()->setCellValue('K'.$xlsRow, $row_rsq['PROMTOTAL']);


$xlsRow++;
$xlsNr++;

} while ($row_rsq = mysql_fetch_assoc($rsq));
 

// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Ranking '.$row_rsinfomes['nameciclo']);
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);


//////////////////////////////////////////////////////////////////////////////////////////////
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel; charset=utf-8');
header('Content-Disposition: attachment;filename='.$_GET['pais'].'_Ranking_pais_mes_'.$_GET['paismes'].'.xls');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output'); 
exit;


mysql_free_result($rsq);

mysql_free_result($rsinfopais);

mysql_free_result($rsinfomes);
?>