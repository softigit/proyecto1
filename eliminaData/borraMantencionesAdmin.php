<?php
 session_start(); 
if ($_SESSION['idEmpresa']!="" ){
	$cia=$_SESSION['idEmpresa'];
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
  		        <a class='top-left-link home' data-icon='home' href='../menu.php'>Inicio</a>
        	</div>
        	<?php
				$idMantenciones = $_POST['idMn'];
				$largoArray = $_POST['largoArray'];
				$sucursal = $_GET['sucursal'];
				$mes = $_GET['mes'];
				$anio = $_GET['anio'];
				$desarmaIdMant = explode('-',$idMantenciones);
				//$acc = 0;
				//echo $idMantenciones."<br/>";
				include('../Connections/con2.php'); 
				for ($i=0; $i<$largoArray;$i++){
					//$acc++;
					$idMan = $desarmaIdMant[$i];
					mysql_query("DELETE FROM mantencion WHERE idmantencion = $idMan");
					}
				//mysql_query("DELETE FROM mantencion WHERE idmantencion = $idM");  
			?>
        	<div class='content' data-role='content'>
 	         	<h2>DATOS ELIMINADOS</h2>	
	            <center>
					<form action="../mantencionPorFechaAdmin.php" method="post" name="form3" id="form3">
						<input type="hidden" name="idSucursal" value="<?= $sucursal?>">
						<input type="hidden" name="mes" value="<?= $mes ?>">
						<input type="hidden" name="anio" value="<?= $anio ?>">
					 	<button aria-label='button1' data-theme='chase' name='button1' role='button' type="submit">
		                	<span aria-hidden='true'>VOLVER</span>
		          	 	</button>
		          	</form> 	
				</center>
					<? error_reporting(0);?>				         		
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
