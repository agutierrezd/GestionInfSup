<?php session_start();?>
<?php require_once('../Connections/oConnContratos.php'); ?>
<?php require_once('../Connections/global.php'); ?>
<?php
//MX Widgets3 include
require_once('../includes/wdg/WDG.php');

/*
Análisis, Diseño y Desarrollo: Alex Fernando Gutierrez
correo: dito73@gmail.com
correo inst: agutierrezd@mincit.gov.co
celular: 3017874143
*/
require_once('../includes/common/KT_common.php');

// Load the tNG classes
require_once('../includes/tng/tNG.inc.php');

// Load the KT_back class
require_once('../includes/nxt/KT_back.php');

// Make a transaction dispatcher instance
$tNGs = new tNG_dispatcher("../");

// Make unified connection variable
$conn_oConnContratos = new KT_connection($oConnContratos, $database_oConnContratos);

// Start trigger
$formValidation = new tNG_FormValidation();
$formValidation->addField("hr_id_fk", true, "numeric", "", "", "", "");
$formValidation->addField("hrnoypay_obliga_num", true, "numeric", "", "", "", "");
$formValidation->addField("hrnoypay_obliga_fecha", true, "date", "", "", "", "");
$formValidation->addField("hrnoypay_not_1", true, "date", "", "", "", "");
$formValidation->addField("hrnoypay_not_2", true, "date", "", "", "", "");
$formValidation->addField("sys_status", true, "numeric", "", "", "", "");
$formValidation->addField("sys_user", true, "text", "", "", "", "");
$formValidation->addField("sys_date", true, "date", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

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

$colname_rsinfo = "-1";
if (isset($_GET['hr_id'])) {
  $colname_rsinfo = $_GET['hr_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rsinfo = sprintf("SELECT * FROM q_hoja_ruta_maestra_info_2015 WHERE hr_id = %s", GetSQLValueString($colname_rsinfo, "int"));
$rsinfo = mysql_query($query_rsinfo, $oConnContratos) or die(mysql_error());
$row_rsinfo = mysql_fetch_assoc($rsinfo);
$totalRows_rsinfo = mysql_num_rows($rsinfo);

$colname_rsinfocontratista = "-1";
if (isset($_GET['contractor_doc_id'])) {
  $colname_rsinfocontratista = $_GET['contractor_doc_id'];
}
mysql_select_db($database_oConnContratos, $oConnContratos);
$query_rsinfocontratista = sprintf("SELECT * FROM q_finder_contractor WHERE contractor_doc_id = %s", GetSQLValueString($colname_rsinfocontratista, "text"));
$rsinfocontratista = mysql_query($query_rsinfocontratista, $oConnContratos) or die(mysql_error());
$row_rsinfocontratista = mysql_fetch_assoc($rsinfocontratista);
$totalRows_rsinfocontratista = mysql_num_rows($rsinfocontratista);

// Make an insert transaction instance
$ins_hoja_ruta_notpago = new tNG_multipleInsert($conn_oConnContratos);
$tNGs->addTransaction($ins_hoja_ruta_notpago);
// Register triggers
$ins_hoja_ruta_notpago->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_hoja_ruta_notpago->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_hoja_ruta_notpago->registerTrigger("END", "Trigger_Default_Redirect", 99, "ok.php");
// Add columns
$ins_hoja_ruta_notpago->setTable("hoja_ruta_notpago");
$ins_hoja_ruta_notpago->addColumn("hr_id_fk", "NUMERIC_TYPE", "POST", "hr_id_fk");
$ins_hoja_ruta_notpago->addColumn("hrnoypay_value", "DOUBLE_TYPE", "POST", "valorapagar");
$ins_hoja_ruta_notpago->addColumn("hrnoypay_sec_1", "STRING_TYPE", "POST", "hrnoypay_sec_1");
$ins_hoja_ruta_notpago->addColumn("hrnoypay_obliga_num", "NUMERIC_TYPE", "POST", "hrnoypay_obliga_num");
$ins_hoja_ruta_notpago->addColumn("hrnoypay_obliga_fecha", "DATE_TYPE", "POST", "hrnoypay_obliga_fecha");
$ins_hoja_ruta_notpago->addColumn("hrnoypay_not_1", "DATE_TYPE", "POST", "hrnoypay_not_1");
$ins_hoja_ruta_notpago->addColumn("hrnoypay_not_2", "DATE_TYPE", "POST", "hrnoypay_not_2");
$ins_hoja_ruta_notpago->addColumn("sys_status", "NUMERIC_TYPE", "POST", "sys_status");
$ins_hoja_ruta_notpago->addColumn("sys_user", "STRING_TYPE", "POST", "sys_user");
$ins_hoja_ruta_notpago->addColumn("sys_date", "DATE_TYPE", "POST", "sys_date");
$ins_hoja_ruta_notpago->setPrimaryKey("hrnoypay_id", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_hoja_ruta_notpago = new tNG_multipleUpdate($conn_oConnContratos);
$tNGs->addTransaction($upd_hoja_ruta_notpago);
// Register triggers
$upd_hoja_ruta_notpago->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_hoja_ruta_notpago->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_hoja_ruta_notpago->registerTrigger("END", "Trigger_Default_Redirect", 99, "ok.php");
// Add columns
$upd_hoja_ruta_notpago->setTable("hoja_ruta_notpago");
$upd_hoja_ruta_notpago->addColumn("hr_id_fk", "NUMERIC_TYPE", "POST", "hr_id_fk");
$upd_hoja_ruta_notpago->addColumn("hrnoypay_value", "DOUBLE_TYPE", "POST", "valorapagar");
$upd_hoja_ruta_notpago->addColumn("hrnoypay_sec_1", "STRING_TYPE", "POST", "hrnoypay_sec_1");
$upd_hoja_ruta_notpago->addColumn("hrnoypay_obliga_num", "NUMERIC_TYPE", "POST", "hrnoypay_obliga_num");
$upd_hoja_ruta_notpago->addColumn("hrnoypay_obliga_fecha", "DATE_TYPE", "POST", "hrnoypay_obliga_fecha");
$upd_hoja_ruta_notpago->addColumn("hrnoypay_not_1", "DATE_TYPE", "POST", "hrnoypay_not_1");
$upd_hoja_ruta_notpago->addColumn("hrnoypay_not_2", "DATE_TYPE", "POST", "hrnoypay_not_2");
$upd_hoja_ruta_notpago->addColumn("sys_status", "NUMERIC_TYPE", "POST", "sys_status");
$upd_hoja_ruta_notpago->addColumn("sys_user", "STRING_TYPE", "POST", "sys_user");
$upd_hoja_ruta_notpago->addColumn("sys_date", "DATE_TYPE", "POST", "sys_date");
$upd_hoja_ruta_notpago->setPrimaryKey("hrnoypay_id", "NUMERIC_TYPE", "GET", "hrnoypay_id");

// Make an instance of the transaction object
$del_hoja_ruta_notpago = new tNG_multipleDelete($conn_oConnContratos);
$tNGs->addTransaction($del_hoja_ruta_notpago);
// Register triggers
$del_hoja_ruta_notpago->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_hoja_ruta_notpago->registerTrigger("END", "Trigger_Default_Redirect", 99, "oka.php");
// Add columns
$del_hoja_ruta_notpago->setTable("hoja_ruta_notpago");
$del_hoja_ruta_notpago->setPrimaryKey("hrnoypay_id", "NUMERIC_TYPE", "GET", "hrnoypay_id");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rshoja_ruta_notpago = $tNGs->getRecordset("hoja_ruta_notpago");
$row_rshoja_ruta_notpago = mysql_fetch_assoc($rshoja_ruta_notpago);
$totalRows_rshoja_ruta_notpago = mysql_num_rows($rshoja_ruta_notpago);

?>
<?php

class EnLetras
{
  var $Void = "";
  var $SP = " ";
  var $Dot = ".";
  var $Zero = "0";
  var $Neg = "Menos";
  
function ValorEnLetras($x, $Moneda ) 
{
    $s="";
    $Ent="";
    $Frc="";
    $Signo="";
        
    if(floatVal($x) < 0)
     $Signo = $this->Neg . " ";
    else
     $Signo = "";
    
    if(intval(number_format($x,2,'.','') )!=$x) //<- averiguar si tiene decimales
      $s = number_format($x,2,'.','');
    else
      $s = number_format($x,0,'.','');
       
    $Pto = strpos($s, $this->Dot);
        
    if ($Pto === false)
    {
      $Ent = $s;
      $Frc = $this->Void;
    }
    else
    {
      $Ent = substr($s, 0, $Pto );
      $Frc =  substr($s, $Pto+1);
    }

    if($Ent == $this->Zero || $Ent == $this->Void)
       $s = "Cero ";
    elseif( strlen($Ent) > 7)
    {
       $s = $this->SubValLetra(intval( substr($Ent, 0,  strlen($Ent) - 6))) . 
             "Millones " . $this->SubValLetra(intval(substr($Ent,-6, 6)));
    }
    else
    {
      $s = $this->SubValLetra(intval($Ent));
    }

    if (substr($s,-9, 9) == "Millones " || substr($s,-7, 7) == "Mill�n ")
       $s = $s . "de ";

    $s = $s . $Moneda;

    if($Frc != $this->Void)
    {
       $s = $s . " Con " . $this->SubValLetra(intval($Frc)) . "Centavos";
       //$s = $s . " " . $Frc . "/100";
    }
    return ($Signo . $s . " ");
   
}


function SubValLetra($numero) 
{
    $Ptr="";
    $n=0;
    $i=0;
    $x ="";
    $Rtn ="";
    $Tem ="";

    $x = trim("$numero");
    $n = strlen($x);

    $Tem = $this->Void;
    $i = $n;
    
    while( $i > 0)
    {
       $Tem = $this->Parte(intval(substr($x, $n - $i, 1). 
                           str_repeat($this->Zero, $i - 1 )));
       If( $Tem != "Cero" )
          $Rtn .= $Tem . $this->SP;
       $i = $i - 1;
    }

    
    //--------------------- GoSub FiltroMil ------------------------------
    $Rtn=str_replace(" Mil Mil", " Un Mil", $Rtn );
    while(1)
    {
       $Ptr = strpos($Rtn, "Mil ");       
       If(!($Ptr===false))
       {
          If(! (strpos($Rtn, "Mil ",$Ptr + 1) === false ))
            $this->ReplaceStringFrom($Rtn, "Mil ", "", $Ptr);
          Else
           break;
       }
       else break;
    }

    //--------------------- GoSub FiltroCiento ------------------------------
    $Ptr = -1;
    do{
       $Ptr = strpos($Rtn, "Cien ", $Ptr+1);
       if(!($Ptr===false))
       {
          $Tem = substr($Rtn, $Ptr + 5 ,1);
          if( $Tem == "M" || $Tem == $this->Void)
             ;
          else          
             $this->ReplaceStringFrom($Rtn, "Cien", "Ciento", $Ptr);
       }
    }while(!($Ptr === false));

    //--------------------- FiltroEspeciales ------------------------------
    $Rtn=str_replace("Diez Un", "Once", $Rtn );
    $Rtn=str_replace("Diez Dos", "Doce", $Rtn );
    $Rtn=str_replace("Diez Tres", "Trece", $Rtn );
    $Rtn=str_replace("Diez Cuatro", "Catorce", $Rtn );
    $Rtn=str_replace("Diez Cinco", "Quince", $Rtn );
    $Rtn=str_replace("Diez Seis", "Dieciseis", $Rtn );
    $Rtn=str_replace("Diez Siete", "Diecisiete", $Rtn );
    $Rtn=str_replace("Diez Ocho", "Dieciocho", $Rtn );
    $Rtn=str_replace("Diez Nueve", "Diecinueve", $Rtn );
    $Rtn=str_replace("Veinte Un", "Veintiun", $Rtn );
    $Rtn=str_replace("Veinte Dos", "Veintidos", $Rtn );
    $Rtn=str_replace("Veinte Tres", "Veintitres", $Rtn );
    $Rtn=str_replace("Veinte Cuatro", "Veinticuatro", $Rtn );
    $Rtn=str_replace("Veinte Cinco", "Veinticinco", $Rtn );
    $Rtn=str_replace("Veinte Seis", "Veintise�s", $Rtn );
    $Rtn=str_replace("Veinte Siete", "Veintisiete", $Rtn );
    $Rtn=str_replace("Veinte Ocho", "Veintiocho", $Rtn );
    $Rtn=str_replace("Veinte Nueve", "Veintinueve", $Rtn );

    //--------------------- FiltroUn ------------------------------
    If(substr($Rtn,0,1) == "M") $Rtn = "Un " . $Rtn;
    //--------------------- Adicionar Y ------------------------------
    for($i=65; $i<=88; $i++)
    {
      If($i != 77)
         $Rtn=str_replace("a " . Chr($i), "* y " . Chr($i), $Rtn);
    }
    $Rtn=str_replace("*", "a" , $Rtn);
    return($Rtn);
}


function ReplaceStringFrom(&$x, $OldWrd, $NewWrd, $Ptr)
{
  $x = substr($x, 0, $Ptr)  . $NewWrd . substr($x, strlen($OldWrd) + $Ptr);
}


function Parte($x)
{
    $Rtn='';
    $t='';
    $i='';
    Do
    {
      switch($x)
      {
         Case 0:  $t = "Cero";break;
         Case 1:  $t = "Un";break;
         Case 2:  $t = "Dos";break;
         Case 3:  $t = "Tres";break;
         Case 4:  $t = "Cuatro";break;
         Case 5:  $t = "Cinco";break;
         Case 6:  $t = "Seis";break;
         Case 7:  $t = "Siete";break;
         Case 8:  $t = "Ocho";break;
         Case 9:  $t = "Nueve";break;
         Case 10: $t = "Diez";break;
         Case 20: $t = "Veinte";break;
         Case 30: $t = "Treinta";break;
         Case 40: $t = "Cuarenta";break;
         Case 50: $t = "Cincuenta";break;
         Case 60: $t = "Sesenta";break;
         Case 70: $t = "Setenta";break;
         Case 80: $t = "Ochenta";break;
         Case 90: $t = "Noventa";break;
         Case 100: $t = "Cien";break;
         Case 200: $t = "Doscientos";break;
         Case 300: $t = "Trescientos";break;
         Case 400: $t = "Cuatrocientos";break;
         Case 500: $t = "Quinientos";break;
         Case 600: $t = "Seiscientos";break;
         Case 700: $t = "Setecientos";break;
         Case 800: $t = "Ochocientos";break;
         Case 900: $t = "Novecientos";break;
         Case 1000: $t = "Mil";break;
         Case 1000000: $t = "Mill�n";break;
      }

      If($t == $this->Void)
      {
        $i = $i + 1;
        $x = $x / 1000;
        If($x== 0) $i = 0;
      }
      else
         break;
           
    }while($i != 0);
   
    $Rtn = $t;
    Switch($i)
    {
       Case 0: $t = $this->Void;break;
       Case 1: $t = " Mil";break;
       Case 2: $t = " Millones";break;
       Case 3: $t = " Billones";break;
    }
    return($Rtn . $t);
}

}

$num=$row_rsinfo['hr_valor'];
$V=new EnLetras();
      
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script src="../includes/skins/style.js" type="text/javascript"></script>
<?php echo $tNGs->displayValidationRules();?>
<script src="../includes/nxt/scripts/form.js" type="text/javascript"></script>
<script src="../includes/nxt/scripts/form.js.php" type="text/javascript"></script>
<script type="text/javascript">
$NXT_FORM_SETTINGS = {
  duplicate_buttons: false,
  show_as_grid: false,
  merge_down_value: false
}
</script>
<script type="text/javascript" src="../includes/common/js/sigslot_core.js"></script>
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="../includes/wdg/classes/Calendar.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/SmartDate.js"></script>
<script type="text/javascript" src="../includes/wdg/calendar/calendar_stripped.js"></script>
<script type="text/javascript" src="../includes/wdg/calendar/calendar-setup_stripped.js"></script>
<script src="../includes/resources/calendar.js"></script>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
</head>

<body>
<?php
	echo $tNGs->getErrorMsg();
?>
<div class="KT_tng">
  <h1>
    <?php 
// Show IF Conditional region1 
if (@$_GET['hrnoypay_id'] == "") {
?>
      <?php echo NXT_getResource("Insert_FH"); ?>
      <?php 
// else Conditional region1
} else { ?>
      <?php echo NXT_getResource("Update_FH"); ?>
      <?php } 
// endif Conditional region1
?>
    Hoja_ruta_notpago <?php echo $row_rsinfo['hr_id']; ?></h1>
  <div class="KT_tngform">
    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
      <?php $cnt1 = 0; ?>
      <?php do { ?>
        <?php $cnt1++; ?>
        <?php 
// Show IF Conditional region1 
if (@$totalRows_rshoja_ruta_notpago > 1) {
?>
          <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
          <?php } 
// endif Conditional region1
?>
          <table width="100%" border="0" cellspacing="2" cellpadding="0">
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><p>Para dar cumplimiento al Decreto 2674 del 21 de diciembre de 2012 y de conformidad con 
                  <input name="hrnoypay_sec_1_<?php echo $cnt1; ?>" type="text" id="hrnoypay_sec_1_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rshoja_ruta_notpago['hrnoypay_sec_1']); ?>" size="50" />
                , Hoja de Ruta No 
                <input name="hr_id_fk_<?php echo $cnt1; ?>" type="text" id="hr_id_fk_<?php echo $cnt1; ?>" value="<?php echo $_GET['hr_id']; ?>" size="7" readonly="true" />
                y Numero de Obligaci&oacute;n 
                <input type="text" name="hrnoypay_obliga_num_<?php echo $cnt1; ?>" id="hrnoypay_obliga_num_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rshoja_ruta_notpago['hrnoypay_obliga_num']); ?>" size="20" maxlength="20" />
                de fecha
                <input name="hrnoypay_obliga_fecha_<?php echo $cnt1; ?>" id="hrnoypay_obliga_fecha_<?php echo $cnt1; ?>" value="<?php echo KT_formatDate($row_rshoja_ruta_notpago['hrnoypay_obliga_fecha']); ?>" size="10" maxlength="22" wdg:mondayfirst="false" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:type="widget" wdg:singleclick="true" wdg:restricttomask="yes" wdg:readonly="true" />
                , me permito  notificarle que el DIA 
                <input name="hrnoypay_not_1_<?php echo $cnt1; ?>" id="hrnoypay_not_1_<?php echo $cnt1; ?>" value="<?php echo KT_formatDate($row_rshoja_ruta_notpago['hrnoypay_not_1']); ?>" size="10" maxlength="22" wdg:mondayfirst="false" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:type="widget" wdg:singleclick="true" wdg:restricttomask="yes" wdg:readonly="true" />
, la Direcci&oacute;n del Tesoro Nacional del Ministerio de Hacienda y Cr&eacute;dito P&uacute;blico le ABONAR&Aacute; a su CUENTA DE <?php echo $row_rsinfocontratista['des_cuenta']; ?> No <?php echo $row_rsinfocontratista['bank_cta_number']; ?>  <?php echo $row_rsinfocontratista['nom_banco']; ?> una transferencia electr&oacute;nica por un valor de 
<input name="valorapagar" type="text" id="valorapagar" value="<?php echo $row_rshoja_ruta_notpago['hrnoypay_value']; ?>" />
  CON  00/100 MCTE </p>
                <p>
                  <input name="hrnoypay_not_2_<?php echo $cnt1; ?>" type="hidden" id="hrnoypay_not_2_<?php echo $cnt1; ?>" value="<?php echo $fecha; ?>" />
                  <input type="hidden" name="sys_status_<?php echo $cnt1; ?>" id="sys_status_<?php echo $cnt1; ?>" value="1" size="2" />
                  <input name="sys_user_<?php echo $cnt1; ?>" type="hidden" id="sys_user_<?php echo $cnt1; ?>" value="<?php echo $_SESSION['kt_login_user']; ?>" size="32" maxlength="60" />
                  <input type="hidden" name="sys_date_<?php echo $cnt1; ?>" id="sys_date_<?php echo $cnt1; ?>" value="<?php echo $fecha; ?>" size="10" maxlength="22" />
                  <br />
              </p>
              </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
          </table>
          <br />
          <br />
          <input type="hidden" name="kt_pk_hoja_ruta_notpago_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rshoja_ruta_notpago['kt_pk_hoja_ruta_notpago']); ?>" />
        <?php } while ($row_rshoja_ruta_notpago = mysql_fetch_assoc($rshoja_ruta_notpago)); ?>
      <div class="KT_bottombuttons">
        <div>
          <?php 
      // Show IF Conditional region1
      if (@$_GET['hrnoypay_id'] == "") {
      ?>
            <input type="submit" name="KT_Insert1" id="KT_Insert1" value="<?php echo NXT_getResource("Insert_FB"); ?>" />
            <?php 
      // else Conditional region1
      } else { ?>
            <input type="submit" name="KT_Update1" value="<?php echo NXT_getResource("Update_FB"); ?>" />
            <input type="submit" name="KT_Delete1" value="<?php echo NXT_getResource("Delete_FB"); ?>" onclick="return confirm('<?php echo NXT_getResource("Are you sure?"); ?>');" />
            <?php }
      // endif Conditional region1
      ?>
        </div>
      </div>
    </form>
  </div>
  <br class="clearfixplain" />
</div>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($rsinfo);

mysql_free_result($rsinfocontratista);
?>
