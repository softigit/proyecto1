<?php session_start(); 

if ($_SESSION['idEmpresa']!="" ){
   $nivel = $_SESSION['nivel']; 	
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
        <div class='content' data-role='content'>
          <h2>B&uacute;squeda por equipo</h2>
          <ul data-inset='true' data-role='listview' data-theme='d'>
            <li>
              <form action="ordenMantencion.php" method="post" name="form3" id="form3">
                 <button aria-label='button1' data-theme='chase' name='button1' role='button' type="submit">
                    <span aria-hidden='true'>VOLVER</span>
                  </button>
              </form>  
            </li>
          <li>
         <form name="form1" id="form1" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" >
     <h3>Sucursal:</h3>
     <select name="idSucursal" >
  <?php 
  mysql_select_db($database_conexion1, $conexion1);
   $query_Sucursal1 = "SELECT * FROM sucursal where  idEmpresa='$cia' ORDER BY nombreSucursal ASC";
$Sucursal1 = mysql_query($query_Sucursal1, $conexion1) or die(mysql_error());
$numeroSucursal = mysql_num_rows($Sucursal1);
$row_Sucursal1 = mysql_fetch_assoc($Sucursal1);
if (isset($_POST["idSucursal"])!= ""){  
     $sucursal=$_POST["idSucursal"];
	 $nroEquipo=$_POST["nroEquipo"];
	 echo "<option value='".$sucursal."' SELECTED>".devuelveNombre($sucursal,'sucursal','idSucursal','nombreSucursal')."</option>";
}
do {  
?>
        <option value="<?php echo $row_Sucursal1['idSucursal']?>" ><?php echo $row_Sucursal1['nombreSucursal'];?></option>
        <?php
} while ($row_Sucursal1 = mysql_fetch_assoc($Sucursal1));

?>

      </select>
      <h3>Nro Equipo:</h3>
      <input type="tel"  name="nroEquipo" id="nroEquipo" value="<?php echo @$nroEquipo; ?>" size="8" />
             
          
          <center>
 <button aria-label='button1' data-theme='chase' name='button1' role='button' type='submit' value='submit' >
              <span aria-hidden='true'>Buscar</span>
          </button>
</center>
         </form> 
        <?php  if (isset($_POST["nroEquipo"])!= ""){
				 $sql="SELECT a.idmantencion, 

a.idEquipo,
a.fecha,
a.tipoTrabajo,
a.observacion,
b.idEquipo,
b.nroEquipo as nroEquipo,
b.oficinaSala as oficinaSala,
b.idEdificio,
c.idEdificio,
c.nombreEdificio as nombreEdificio,
d.nombreSucursal as nombreSucursal
from 
mantencion as a,
equipo as b,
edificio as c,
sucursal as d
where a.idEquipo = b.idEquipo
and b.idEdificio = c.idEdificio 
and c.idSucursal = '$sucursal' 
and c.idSucursal = d.idSucursal 
and b.nroEquipo = '$nroEquipo' 
order by a.fecha;";
 mysql_select_db($database_conexion1, $conexion1);
   //echo $sql;
  $result = mysql_query($sql, $conexion1) or die(mysql_error());
  $numero = mysql_num_rows($result);
  
  if ($numero<1) {
	echo "<h3>EL NUMERO DE EQUIPO INGRESADO, NO EXISTE O NO CORRESPONDE A SUCURSAL SELECCIONADA</h3>";
}else {
	echo '<p align="right">Mantenciones : '.$numero.'</p>';

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
function cargapagina(pagina,equipo,sucursal,mes,anio){
	 window.location ="mantencionPorFecha3.php?idM="+pagina+"&idE="+equipo+"&sucursal="+sucursal;
	
}
</script>
<div id="contenedor">
    <div id="contenidos">
        <div id="columna1" style="background-color:#EDE4DA;">Fecha</div>
        <div id="columna2" style="background-color:#EDE4DA;">Tipo</div>
        <div id="columna3" style="background-color:#EDE4DA;">Obs.</div>
    </div>
    <?php
	$i=0;
	 while($row_Mantencion=mysql_fetch_assoc($result)){
		if ($i%2==0){
			$color="EDE4BA;";
		}else{
			$color="FFF;";
		}
		?>

    <div id="contenidos" onclick="cargapagina(<?php echo $row_Mantencion["idmantencion"].','.$row_Mantencion["nroEquipo"].','.$sucursal;?>);">
     <div id="columna1" style="background-color:#<?php echo $color;?>" ><?php  
	  $fecha_array=explode('-', $row_Mantencion['fecha']);
 echo $fecha=$fecha_array[2].'-'.$fecha_array[1].'-'.$fecha_array[0]; ?></div>
        <div id="columna2" style="background-color:#<?php echo $color;?>" ><?php  echo $row_Mantencion['tipoTrabajo']==1 ? 'Mantención' : 'Reparación';  ?></div>
        <div id="columna3" style="background-color:#<?php echo $color;?>"><?php echo chop($row_Mantencion["observacion"]); ?></div>
       
    </div>

    <?php $i++;} ?>
    
    
    
    
    
    
    </div>


		 
<?php		 }
} ?>       
        
        
        
        
     
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