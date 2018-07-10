<?php session_start(); 

if ($_SESSION['idEmpresa']!="" ){
	if ($_GET["idAgenda"]==""){
	$exitGoTo="menu.php";
	 header(sprintf("Location: %s", $exitGoTo));  	

	}
	 $cia=$_SESSION['idEmpresa'];
	 
require_once('Connections/conexion1.php'); 
require_once('funciones.php');

      $sql="SELECT * FROM 
agenda 
where
idAgenda='".$_GET["idAgenda"]."'";
 mysql_select_db($database_conexion1, $conexion1);
  $result = mysql_query($sql, $conexion1) or die(mysql_error());
  $row_Mantencion=mysql_fetch_assoc($result);
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
          <h2>Servicio Técnico</h2>
            <form name="1" action="estadoSolicitudes.php" method="post">
              <center>
                <button aria-label='button1' data-theme='chase' name='button1' role='button' type='submit' value='submit' >
                  <span aria-hidden='true'>Volver</span>
                </button>
              </center>
            </form>
          <ul data-inset='true' data-role='listview' data-theme='d'>
          <li>
          <?php $idEmpresa =$row_Mantencion["idEmpresa"];echo devuelveNombre($idEmpresa,'empresas','idEmpresa','nombreEmpresa'); ?>
    <div id="contenedor">

    <div id="contenidos">    
      <div id="columna1" style="background-color:#FFC" >Nro Orden</div>
      <div id="columna2" style="background-color:#FFC" ><?php  echo $row_Mantencion['idAgenda']; ?>
    </div>
  </div>
            
    <div id="contenidos"> 	 
      <div id="columna1" style="background-color:#FFC" >Sucursal</div>
      <div id="columna2" style="background-color:#FFC" ><?php  echo devuelveNombre($row_Mantencion['idSucursal'],'sucursal','idSucursal','nombreSucursal'); ?>
    </div>
	</div>
	
<div id="contenidos"> 	 
         <div id="columna1" style="background-color:#FFC" >Fecha Solicitud
         </div>
      <div id="columna2" style="background-color:#FFC" ><?php  $fecha_hora_array=explode(' ',$row_Mantencion['fecha']);
	  $fecha_array=explode('-', $fecha_hora_array[0]);
 
 echo $fecha_array[2].'-'.$fecha_array[1].'-'.$fecha_array[0].' '.$fecha_hora_array[1];  ?>
      </div>
	  	
</div>
<div id="contenidos"> 	 
         <div id="columna1" style="background-color:#FFC" >Usuario
         </div>
      <div id="columna2" style="background-color:#FFC" ><?php  echo devuelveNombre($row_Mantencion['idusuario'],'usuarios','id','nombres')." ".devuelveNombre($row_Mantencion['idusuario'],'usuarios','id','apellidos'); ?>
      </div>
	</div>
  <!--celular -->
  <div id="contenidos"> 	 
         <div id="columna1" style="background-color:#FFC" >Teléfono
         </div>
      <div id="columna2" style="background-color:#FFC" ><?php  echo devuelveNombre($row_Mantencion['idusuario'],'usuarios','id','fonoContacto');  ?>
      </div>
	</div>  
    
<!-- detalle -->
<div id="contenidos"> 	 
         <div id="columna1" style="background-color:#FFC" >Nro. Equipo
         </div>
      <div id="columna2" style="background-color:#FFC" ><?php  echo $row_Mantencion['nroEquipo']; ?>
      </div>
           
	</div>
    <?php if ($row_Mantencion['comentario1']!="0"){ ?>  
<div id="contenidos"> 	 
         <div id="columna1" style="background-color:#FFC" >Obs 1
         </div>
      <div id="columna2" style="background-color:#FFC" ><?php  echo devuelveNombre($row_Mantencion['comentario1'],'comentario','idComentario','comentario'); ?>
      </div>
           
	</div>
<?php } 
if ($row_Mantencion['comentario2']!="0"){ ?>  
<div id="contenidos"> 	 
         <div id="columna1" style="background-color:#FFC" >Obs 2
         </div>
      <div id="columna2" style="background-color:#FFC" ><?php  echo devuelveNombre($row_Mantencion['comentario2'],'comentario','idComentario','comentario'); ?>
      </div>
           
	</div>
<?php } 
if ( $row_Mantencion['comentario3']!=0){ ?>  
<div id="contenidos"> 	 
         <div id="columna1" style="background-color:#FFC" >Obs 3
         </div>
      <div id="columna2" style="background-color:#FFC" ><?php  echo devuelveNombre($row_Mantencion['comentario3'],'comentario','idComentario','comentario'); ?>
      </div>
           
	</div>
<?php } 
if ( $row_Mantencion['comentario']!=""){ ?>  
<div id="contenidos"> 	 
         <div id="columna1" style="background-color:#FFC" >Comentario  </div>
      <div id="columna2" style="background-color:#FFC" ><?php  echo $row_Mantencion['comentario']; ?>
      </div>
           
	</div>
<?php } ?>


</div>
         <!-- aqui va el contenido --> 
         
</li>
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