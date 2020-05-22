<?php
require_once('firmador_pdf.php');

$firmador = new firmador_pdf();

//-- Guardar sesion en XML
//$firmador->set_guardar_sesion_en_xml();

//-- Guardar sesion en BD
//$nombre_base = "toba_trunk";
//$dbh = new PDO("pgsql:host=localhost;dbname=$nombre_base", "postgres", "");
//$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Set Errorhandling to Exception
//$firmador->set_guardar_sesion_en_db($dbh);

//-- Compartir sesion de PHP con el applet
$firmador->set_guardar_sesion_en_php();

//---------------------------------
//-- CASO BASE: Generar applet
//---------------------------------
if (! isset($_GET['accion'])) {
	
	?>
	<html>
		<head>
			<style type="text/css">
				* {    
					font-family: Verdana, Arial, 'sans-serif' !important; 
					font-size: 12px;
				}
			</style>
		</head>
	<body>
		<h2>Firmar certificado de recibo a satisfacción <?php echo $_POST['inf_id']; ?></h2>
	<hr/>
	<div style="width:960px;margin:0 auto;">	
	<?php
	$firmador->set_dimension(500, 120);
	$firmador->set_motivo("Motivo de la firma");
	$docorigen = $_POST['inf_id'];
	$url_actual = $firmador->get_url_base_actual(). $_SERVER['REQUEST_URI'];
	$firmador->generar_applet("firmador.jar", 
								$url_actual."?accion=enviar"."&inf_id=".$docorigen,
								$url_actual."?accion=recibir"."&inf_id=".$docorigen
								);
	$firmador->generar_visor_pdf("pdfobject.min.js", $url_actual."?accion=enviar"."&inf_id=".$docorigen);
	?>
	</div>
	</body>
	</html>
	<?php
die;
}

//---------------------------------
//-- ENVIAR PDFs
//---------------------------------
if ($_GET['accion'] == 'enviar') {
	if (! isset($_GET['codigo'])) {
		header('HTTP/1.1 500 Internal Server Error');
		die("Falta indicar el codigo");
	}
	if (! $firmador->validar_sesion($_GET['codigo'])) {
		header('HTTP/1.1 500 Internal Server Error');
		die("Codigo invalido");   
	}	
	//Enviar PDF
	$firmador->enviar_headers_pdf();
    $docorigena = $_GET['inf_id'];
	$file = '../cert/'.$docorigena;
	$fd = fopen($file,'r');
	fpassthru($fd);
	die;
}

//---------------------------------
//-- RECIBIR PDFs
//---------------------------------
if ($_GET['accion'] == 'recibir') {
	if ( ! $firmador->validar_sesion($_POST['codigo'])) {
		header('HTTP/1.1 500 Internal Server Error');
		die("Codigo invalido");   
	}
	if ($_FILES["md5_fileSigned"]["error"] != UPLOAD_ERR_OK) {
		error_log("Error uploading file");
		header('HTTP/1.1 500 Internal Server Error');
		die;
	}	
	$path = $_FILES['md5_fileSigned']['tmp_name'];
	$docdestinoa = $_GET['inf_id'];
	$destino = '../signed/certfirmados/'.$docdestinoa;
	if (! move_uploaded_file($path, $destino)) {
		error_log("Error uploading file");
		header('HTTP/1.1 500 Internal Server Error');
		die;
	}

	die;
}

?>