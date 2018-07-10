<?php session_start(); 

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
          <a class='top-left-link home' data-icon='home' href='menu.php'>Inicio</a>
        </div>
        <div class='content' data-role='content'>
          <h2>Listado de Equipos</h2>
          <ul data-inset='true' data-role='listview' data-theme='d'>
          <li>
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"  name="form3" id="form3">

  
    <h3>Sucursal:</h3>
      
      <?php 
	    mysql_select_db($database_conexion1, $conexion1);
	  $query_Sucursal1 = "SELECT * FROM sucursal where  idEmpresa='$cia' ORDER BY nombreSucursal ASC";
$Sucursal1 = mysql_query($query_Sucursal1, $conexion1) or die(mysql_error());
$numeroSucursal = mysql_num_rows($Sucursal1);
$row_Sucursal1 = mysql_fetch_assoc($Sucursal1);
      ?>
    <select name="idSucursal" onchange=form3.submit() >
  <option value="" SELECTED>Seleccione Sucursal</option>
  <?php 
if (isset($_POST["idSucursal"])!= ""){  
     $sucursal=$_POST["idSucursal"];
	 echo "<option value='".$sucursal."' SELECTED>".devuelveNombre($sucursal,'sucursal','idSucursal','nombreSucursal')."</option>";
}
do {  
?>
        <option value="<?php echo $row_Sucursal1['idSucursal']?>" ><?php echo $row_Sucursal1['nombreSucursal'];?></option>
        <?php
} while ($row_Sucursal1 = mysql_fetch_assoc($Sucursal1));

?>
      </select>
    </form>
    </li>
    <?php if (isset($_POST["idSucursal"])!= ""){  
     $sucursal=$_POST["idSucursal"];
	 $sql="select 
a.nroEquipo,
b.nombreEdificio,
a.oficinaSala,
a.piso
from
equipo as a,
edificio as b,
sucursal as c
where
a.idEdificio = b.idEdificio
and b.idSucursal = c.idSucursal
and c.idSucursal = '$sucursal'
order by a.nroEquipo, b.nombreEdificio, a.piso;";
	$result = mysql_query($sql, $conexion1) or die(mysql_error());
  $numero = mysql_num_rows($result);  
	  if ($numero < 1){ echo "No existen equipos ingresados";
	  } else{
	  
	  ?>
    <li>
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
<div id="contenedor">
    <div id="contenidos">
        <div id="columna1" style="background-color:#EDE4DA;">Nro.</div>
        <div id="columna2" style="background-color:#EDE4DA;">Edificio</div>
        <div id="columna3" style="background-color:#EDE4DA;">Piso</div>
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

    <div id="contenidos" >
     <div id="columna1" style="background-color:#<?php echo $color;?>" ><?php echo chop($row_Mantencion["nroEquipo"]); ?></div>
        <div id="columna2" style="background-color:#<?php echo $color;?>" ><?php  	
		echo chop($row_Mantencion["nombreEdificio"].' - '.$row_Mantencion["oficinaSala"]); ?></div>
        <div id="columna3" style="background-color:#<?php echo $color;?>"><?php echo chop($row_Mantencion["piso"]); ?></div>
       
    </div>

    <?php $i++;} ?>
    
    
    </li>
	<?php }} ?>
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