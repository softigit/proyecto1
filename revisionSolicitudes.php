<?php session_start(); 
if ( $_SESSION['nivel']==1 && $_SESSION['idEmpresa']=="")
$_SESSION['idEmpresa']=6;

if ($_SESSION['idEmpresa']!="" ){
	
	 $cia=$_SESSION['idEmpresa'];
require_once('Connections/conexion1.php'); 
require_once('funciones.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=0" name="viewport" />

<meta charset="ISO-8859-1" />
  <meta name="apple-mobile-web-app-capable" content="yes" /> 
    <link href="lib/jquery.mobile-1.3.2.min.css" rel="stylesheet" />
    <script src="lib/jquery-1.9.1.min.js"></script>
         
     <script src="lib/jquery.mobile-1.3.2.min.js"></script>
<link href="themes/chase/chase.css" rel="stylesheet" />

    <link href="lib/jquery.mobile.datebox.1.4.0.min.css" rel="stylesheet"  />
   


    <title>M&amp;U Mobile</title>
   
</head>

<body>
<div data-role='page' data-theme='chase' id='contacto'>
<div class='header' data-backbtn='false' data-role='header' data-theme='chase'>
          <div class='logo'></div>
          <?php if ($_SESSION['nivel'] == 1) {
			  ?>
          <a class='top-left-link home' data-icon='home' href='menuTecnico.php'>Inicio</a>
          <?php } else { ?>
		<a class='top-left-link home' data-icon='home' href='menu.php'>Inicio</a>	  
		  <?php } ?>
        </div>
        <div class='content' data-role='content'>
          <h2>Revisión Solicitudes Pendientes</h2>
          <ul data-inset='true' data-role='listview' data-theme='d'>
          <li>
      <?php 
        $sql="SELECT * FROM 
agenda 
where
Estado <>'Listo' and
tipoSolicitud=1 
order by idEmpresa,fecha,idSucursal";
 mysql_select_db($database_conexion1, $conexion1);
  $result = mysql_query($sql, $conexion1) or die(mysql_error());
  $numero = mysql_num_rows($result);
  
  if ($numero<1) {
	echo "<h3>No Existen Solicitudes</h3>";
}else {
	echo '<p align="right">Solicitudes : '.$numero.'</p>';

	?>
       <style type="text/css">
#contenedor {
    display: table;
    border: 1px solid #D3D3D3;
    width: 100%;
    text-align: center;
    margin: 0 auto;
	/*para Firefox*/

}
#contenidos {
    display: table-row;
}
 #columna2, #columna3 {
    display: table-cell;
    border: 1px solid #D3D3D3;
    vertical-align: middle;
    padding: 10px;

}
#columna1{
    display: table-cell;
    border: 1px solid #D3D3D3;
	 vertical-align: middle;
	text-align:left;
    padding: 10px;
	
}
</style>
<script type="text/javascript" language="javascript">
function cargapagina(idAgenda){
	 window.location ="revisarSolicitud.php?idAgenda="+idAgenda;
	
}
</script>
<div id="contenedor">
    <div id="contenidos">
        <div id="columna1" style="background-color:#EDE4DA;">Fecha</div>
        <div id="columna2" style="background-color:#EDE4DA;">Sucursal</div>
        <div id="columna3" style="background-color:#EDE4DA;">Estado</div>
    </div>
    <?php
	$i=0;
	$idEmpresa=0;
	 while($row_Mantencion=mysql_fetch_assoc($result)){
		if ($i%2==0){
			$color="EDE4BA;";
		}else{
			$color="FFF;";
		}
		if ($idEmpresa !=$row_Mantencion["idEmpresa"]){
			$idEmpresa =$row_Mantencion["idEmpresa"];
		?>
        <div id="contenidos"> 	 
         <div id="columna1" style="background-color:#FFC" >
         </div>
      <div id="columna2" style="background-color:#FFC" ><?php echo devuelveNombre($idEmpresa,'empresas','idEmpresa','nombreEmpresa'); ?>
      </div>
	  <div id="columna3" style="background-color:#FFC"></div> 
</div>	  
		<?php }?>

    <div id="contenidos" onclick="cargapagina(<?php echo $row_Mantencion["idAgenda"];?>);">
     <div id="columna1" style="background-color:#<?php echo $color;?>  " ><?php
	 $fecha_hoy=mktime(date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")); 
	  $fecha_conhoras = strtotime($row_Mantencion['fechaVisita']);
	 //echo date('Y',  $fecha_conhoras);
	// echo date('Y-m-d H:i:s',$fecha_hoy);
	//echo "<br>";
	 $any=date("Y",$fecha_conhoras); 
$mes=date("m",$fecha_conhoras); 
$dia=date("d",$fecha_conhoras); 
$hora=date("H",$fecha_conhoras); 
$minuto=date("i",$fecha_conhoras); 
$segundo=date("s",$fecha_conhoras); 

	 
	 $fecha_resta= intval( ($fecha_hoy  -  $fecha_conhoras)/60/60); 
	 if ($fecha_resta <=12 ) $luz='Green';
	 if ($fecha_resta >12 && $fecha_resta < 22)  $luz='Yellow';
	  if ($fecha_resta >22 ) $luz='Red';
		 
	 $fecha_hora_array=explode(' ',$row_Mantencion['fechaVisita']);
	  $fecha_array=explode('-', $fecha_hora_array[0]);
 
 echo $fecha_array[2].'-'.$fecha_array[1].'-'.$fecha_array[0];  ?></div>
        <div id="columna2" style="background-color:#<?php echo $color;?>" ><?php  echo devuelveNombre($row_Mantencion['idSucursal'],'sucursal','idSucursal','nombreSucursal');  ?></div>
        <div id="columna3" style="background-color:#<?php echo $color;?>"><?php echo " 
       <img src='lib/images/".$luz."_LED.png' width='32' height='32' />"; //echo chop($row_Mantencion["estado"]); ?></div>
       
    </div>

    <?php $i++;} ?>
      
      
         
</li>
<?php } ?>
            </ul>
        </div>
        
      </div>
	 
 
      
</body>
</html>
<?php

} else {
	$exitGoTo="index.php";
	 header(sprintf("Location: %s", $exitGoTo));  
}
	?>