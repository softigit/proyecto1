<?php 
 session_start(); 
if ($_SESSION['nivel']==0){
	require_once('../Connections/conexion1.php'); 
	require_once('../funciones.php');
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
			<meta content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=0" name="viewport" />
			<meta charset="ISO-8859-1" />
  			<meta name="apple-mobile-web-app-capable" content="yes" /> 
    		<link href="../lib/jquery.mobile-1.3.2.min.css" rel="stylesheet" />
			<link href="../themes/chase/chase.css" rel="stylesheet" />
		    <link href="../lib/jquery.mobile.datebox.1.4.0.min.css" rel="stylesheet"  />
    		<script src="../lib/jquery-1.9.1.min.js"></script>
            <script src="../lib/jquery.mobile-1.3.2.min.js"></script>
			<script type="text/javascript">
				$(document).bind("mobileinit", function(){
				  $.extend( $.mobile , {
				   ajaxFormsEnabled = false; });
				});
			</script>            
    		<title>M&amp;U Mobile</title>
		</head>
		<body>
			<div data-role='page' data-theme='chase' id='contacto'>
			<div class='header' data-backbtn='false' data-role='header' data-theme='chase'>
            <div class='logo'></div>
  		        <a class='top-left-link home' data-icon='home' href='../menuAdministrador.php'>Inicio</a>
        	</div>
        	<div class='content' data-role='content'>
          		<h2>CARGA DE MANTENCIONES</h2>
				<h2>SELECCIONE EL ARCHIVO EXCEL:</h2>
				<form data-ajax="false" name="importa" method="post" action="<?php echo $PHP_SELF; ?>" enctype="multipart/form-data" >
					<input type="file" name="excel" />
					<input type="submit" name="enviar"  value="Importar"  />
					<input type="hidden" value="upload" name="action" />
				</form> 
				<?
					error_reporting(0);
					extract($_POST);
					if ($action == "upload"){						
						$archivo = $_FILES['excel']['name'];
						$tipo = $_FILES['excel']['type'];
						$destino = "archivos/".$archivo;
						if ($tipo != "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"){
							echo "<h2>EL ARCHIVO QUE ESTA TRATANDO DE CARGAR NO ES UN EXCEL</h2>";
							unlink($destino);
							break;
							}
		   			    if (copy($_FILES['excel']['tmp_name'],$destino)){
							
							} 
						else{
							echo "<h2>ERROR AL CARGAR EL ARCHIVO INTENTELO NUEAVAMENTE</h2>";
							}
						if (file_exists ("archivos/".$archivo)){
							require_once('../Vendor/Classes/PHPExcel.php');
							require_once('../Vendor/Classes/PHPExcel/Reader/Excel2007.php');
							$objReader = new PHPExcel_Reader_Excel2007();
							$objPHPExcel = $objReader->load("archivos/".$archivo);
							$objFecha = new PHPExcel_Shared_Date();
							$objPHPExcel->setActiveSheetIndex(0);
							$cn = mysql_connect ("127.0.0.1","myucl_test","~BfiW+DUkH8N") or die ("ERROR EN LA CONEXION");
							$db = mysql_select_db ("myucl_intranet2",$cn) or die ("ERROR AL CONECTAR A LA BD");
							for ($i=2;$i<=1500;$i++){
								$_DATOS_EXCEL[$i]['idEquipo'] = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
								$_DATOS_EXCEL[$i]['fecha'] = PHPExcel_Style_NumberFormat::toFormattedString($objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue(), 'YYYY-MM-DD');//$objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue()->setFormatCode('MM-DD-YY');  //$objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
								$_DATOS_EXCEL[$i]['pila']= $objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue();
								$_DATOS_EXCEL[$i]['control']= $objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue();
								$_DATOS_EXCEL[$i]['senal'] = $objPHPExcel->getActiveSheet()->getCell('J'.$i)->getCalculatedValue();
								$_DATOS_EXCEL[$i]['temperatura'] = $objPHPExcel->getActiveSheet()->getCell('K'.$i)->getCalculatedValue();
								$_DATOS_EXCEL[$i]['inyeccion'] = $objPHPExcel->getActiveSheet()->getCell('L'.$i)->getCalculatedValue();
								$_DATOS_EXCEL[$i]['retorno'] = $objPHPExcel->getActiveSheet()->getCell('M'.$i)->getCalculatedValue();
								$_DATOS_EXCEL[$i]['filtro'] = $objPHPExcel->getActiveSheet()->getCell('N'.$i)->getCalculatedValue();
								$_DATOS_EXCEL[$i]['desague'] = $objPHPExcel->getActiveSheet()->getCell('O'.$i)->getCalculatedValue();
								$_DATOS_EXCEL[$i]['bomba'] = $objPHPExcel->getActiveSheet()->getCell('P'.$i)->getCalculatedValue();
								$_DATOS_EXCEL[$i]['terminales'] = $objPHPExcel->getActiveSheet()->getCell('Q'.$i)->getCalculatedValue();
								$_DATOS_EXCEL[$i]['condensadores'] = $objPHPExcel->getActiveSheet()->getCell('R'.$i)->getCalculatedValue();
								$_DATOS_EXCEL[$i]['tarjeta'] = $objPHPExcel->getActiveSheet()->getCell('S'.$i)->getCalculatedValue();
								$_DATOS_EXCEL[$i]['consumo'] = $objPHPExcel->getActiveSheet()->getCell('T'.$i)->getCalculatedValue();
								$_DATOS_EXCEL[$i]['carga'] = $objPHPExcel->getActiveSheet()->getCell('U'.$i)->getCalculatedValue();
								$_DATOS_EXCEL[$i]['obs'] = $objPHPExcel->getActiveSheet()->getCell('V'.$i)->getCalculatedValue();
								$_DATOS_EXCEL[$i]['tecnico'] = $objPHPExcel->getActiveSheet()->getCell('W'.$i)->getCalculatedValue();
								}
							}
							else{
								echo "<h2>NO HA CARGADO EL ARCHIVO EXCEL</h2>";
								}
						$errores=0;
						foreach($_DATOS_EXCEL as $campo => $valor){
							$sql = "INSERT INTO mantencion (idEquipo,fecha,tipoTrabajo,pila,control,senal,filtro,temperatura,inyeccion,retorno,desague,bomba,terminales,condensadores,tarjeta,consumo,carga,observacion,idUsuario) VALUES (";
							foreach ($valor as $campo2 => $valor2){
								if ($campo2 == "idEquipo"){
									$buscaIdEq = mysql_query("SELECT * FROM equipo WHERE nroEquipo = $valor2");				
									while ($roeBeq = mysql_fetch_array($buscaIdEq)){
										$idequipito = $roeBeq["idEquipo"];				
										}
									$sql.= $idequipito.",";
									}
								if ($campo2 == "fecha"){
									$sql.= "'".$valor2."',1,";
									}	
								if ($campo2 == "pila"){
									$compara = strtoupper($valor2);	
									//if (($valor2 == "si") || ($valor2 == "SI") || ($valor2 == "Si")){
									if ($compara == "SI"){
										$sql.= "1,";
										}
									else{
										$sql.= "0,";
										}
									}
								if ($campo2 == "control"){
									$compara = strtoupper($valor2);	
									//if (($valor2 == "si") || ($valor2 == "SI") || ($valor2 == "Si")){
									if ($compara == "SI"){										$sql.= "1,";
										}
									else{
										$sql.= "0,";
										}
									}
								if ($campo2 == "senal"){
									$compara = strtoupper($valor2);	
									//if (($valor2 == "si") || ($valor2 == "SI") || ($valor2 == "Si")){
									if ($compara == "SI"){
										$sql.= "1,";
										}
									else{
										$sql.= "0,";
										}
									}
								if ($campo2 == "filtro"){
									$compara = strtoupper($valor2);	
									//if (($valor2 == "si") || ($valor2 == "SI") || ($valor2 == "Si")){
									if ($compara == "SI"){
										$sql.= "1,";
										}
									else{
										$sql.= "0,";
										}
									}
								if ($campo2 == "temperatura"){
									$compara = strtoupper($valor2);	
									//if (($valor2 == "si") || ($valor2 == "SI") || ($valor2 == "Si")){
									if ($compara == "SI"){
										$sql.= "1,";
										}
									else{
										$sql.= "0,";
										}
									}
								if ($campo2 == "inyeccion"){
									$sql.= $valor2.",";
									}				
								if ($campo2 == "retorno"){
									$sql.= $valor2.",";
									}	
								if ($campo2 == "desague"){
									$compara = strtoupper($valor2);	
									//if (($valor2 == "si") || ($valor2 == "SI") || ($valor2 == "Si")){
									if ($compara == "SI"){
										$sql.= "1,";
										}
									else{
										$sql.= "0,";
										}
									}	
								if ($campo2 == "bomba"){
									$compara = strtoupper($valor2);	
									//if (($valor2 == "si") || ($valor2 == "SI") || ($valor2 == "Si")){
									if ($compara == "SI"){
										$sql.= "1,";
										}
									else{
										$sql.= "0,";
										}
									}	
								if ($campo2 == "terminales"){
									$compara = strtoupper($valor2);	
									//if (($valor2 == "si") || ($valor2 == "SI") || ($valor2 == "Si")){
									if ($compara == "SI"){
										$sql.= "1,";
										}
									else{
										$sql.= "0,";
										}
									}	
								if ($campo2 == "condensadores"){
									$compara = strtoupper($valor2);	
									//if (($valor2 == "si") || ($valor2 == "SI") || ($valor2 == "Si")){
									if ($compara == "SI"){
										$sql.= "1,";
										}
									else{
										$sql.= "0,";
										}
									}	
								if ($campo2 == "tarjeta"){			
									$compara = strtoupper($valor2);	
									//if (($valor2 == "si") || ($valor2 == "SI") || ($valor2 == "Si")){
									if ($compara == "SI"){
										$sql.= "1,";
										}
									else{
										$sql.= "0,";
										}
									}
								if ($campo2 == "consumo"){
									$sql.= $valor2.",";
									}					
								if ($campo2 == "carga"){
									$sql.= $valor2.",";
									}
								if ($campo2 == "obs"){
									$sql.= "'".$valor2."',";
									}
								if ($campo2 == "tecnico"){
										$usuarioSinEsp = str_replace(" ", "-", $valor2);
										$desarma = explode("-",$usuarioSinEsp);
										$n = strtoupper($desarma[0]);	
										$a = strtoupper($desarma[1]);	
										$buscaUser = mysql_query("SELECT * FROM usuarios WHERE nombres = '$n' and apellidos = '$a'");
										while ($rowUser = mysql_fetch_array($buscaUser)){
											$idUser = $rowUser["id"];
											}	
										$sql.= "'".$idUser."');";	
									}
								}
						$result = mysql_query($sql);
						if ($result){ $reg+=1;}
						}
					echo "<h2>ARCHIVO IMPORTADO CON EXITO, EN TOTAL $reg REGISTROS INSERTADOS</h2>";
					}
				    ?>				         		
            </div>     
		</body>
	</html>
<?php
	} 
	else {
		$exitGoTo="index.php";
	 	header(sprintf("Location: %s", $exitGoTo));  
	}
	?>