<?php
  session_start(); 
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
          <a class='top-left-link home' data-icon='home' href='menuAdministrador.php'>Inicio</a>
        </div>
        <div class='content' data-role='content'>
          <h2>Búsqueda por Fecha</h2>
          <ul data-inset='true' data-role='listview' data-theme='d'>
            <li>
              <form action="ordenMantencion2.php" method="post" name="form4" id="form4">
                 <button aria-label='button1' data-theme='chase' name='button1' role='button' type="submit">
                    <span aria-hidden='true'>VOLVER A TIPO DE BUSQUEDA</span>
                  </button>
              </form>  
            </li>
            <li>
            <?php if (!isset($_POST['mes'])){ ?>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="form3" id="form3">
              <select name="mes" id="mes">
              <?php
		            $now = time(); 
                $monthnum = date("m", $now); 
        		   switch($monthnum){
        			  case "01" : 
                  $stringmonth = "Enero"; break;
                case "02" : 
                  $stringmonth = "Febrero"; break;
                case "03" : 
                  $stringmonth = "Marzo"; break;
                case "04" : 
                  $stringmonth = "Abril"; break;
                case "05" : 
                  $stringmonth = "Mayo"; break;
                case "06" : 
                    $stringmonth = "Junio"; break;
                case "07" : 
                    $stringmonth = "Julio"; break;
                case "08" : 
                    $stringmonth = "Agosto"; break;
                case "09" : 
                    $stringmonth = "Septiembre"; break;
                case "10" : 
                    $stringmonth = "Octubre"; break;
                case "11" : 
                    $stringmonth = "Noviembre"; break;
                case "12" : 
                    $stringmonth = "Diciembre";  break;       			  
        		  }
		  ?>
      <option value="<?php echo $monthnum ;?>">
         <?php echo $stringmonth; ?></option>
            <option value="01">Enero</option>
            <option value="02">Febrero</option>
            <option value="03">Marzo</option>
            <option value="04">Abril</option>
            <option value="05">Mayo</option>
            <option value="06">Junio</option>
            <option value="07">Julio</option>
            <option value="08">Agosto</option>
            <option value="09">Septiembre</option>
            <option value="10">Octubre</option>
            <option value="11">Noviembre</option>
            <option value="12">Diciembre</option>
          </select>
          <select name="anio" id="anio">
            <option value="2017">2017</option>
            <option value="2016"  selected="selected">2016</option>
            <option value="2015">2015</option>
            <option value="2014">2014</option>
            <option value="2013">2013</option>
          </select>
         <!-- aqui va el contenido --> 
          <select name="idSucursal" >
          <?php 
            mysql_select_db($database_conexion1, $conexion1);
            $query_Sucursal1 = "SELECT * FROM sucursal where  idEmpresa='$cia' ORDER BY nombreSucursal ASC";
            $Sucursal1 = mysql_query($query_Sucursal1, $conexion1) or die(mysql_error());
            $numeroSucursal = mysql_num_rows($Sucursal1);
            $row_Sucursal1 = mysql_fetch_assoc($Sucursal1);
            if ($_POST["idSucursal"]!= ""){  
              $sucursal=$_POST["idSucursal"];
	            echo "<option value='".$sucursal."' SELECTED>".devuelveNombre($sucursal,'sucursal','idSucursal','nombreSucursal')."</option>";
              }
            do {  
            ?>
            <option value="<?php echo $row_Sucursal1['idSucursal']?>" ><?php echo $row_Sucursal1['nombreSucursal'];?></option>
            <?php
                } while ($row_Sucursal1 = mysql_fetch_assoc($Sucursal1));
              ?>
            <option value="T">Todas</option>
          </select>
          <center>
            <button aria-label='button1' data-theme='chase' name='button1' role='button' type='submit' value='submit' >
                <span aria-hidden='true'>Buscar</span>
            </button>
          </center>
         </form>
         <?php } else { 
		 $mes= $_POST['mes'];
		 $anio = $_POST['anio'];
		 $idSucursal=$_POST["idSucursal"];
		 $sql="SELECT a.idmantencion, 
EXTRACT(MONTH FROM a.fecha) AS mes,
EXTRACT(YEAR FROM a.fecha) AS anio,
a.idEquipo,
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
and EXTRACT(MONTH FROM a.fecha) = '$mes' 
and EXTRACT(YEAR FROM a.fecha) = '$anio'
and b.idEdificio = c.idEdificio";
if ($idSucursal !='T'){
$sql.=" and c.idSucursal = '$idSucursal' ";}
$sql.="  and c.idSucursal = d.idSucursal 
and d.idEmpresa='$cia' order by d.nombreSucursal,b.nroEquipo;";
  mysql_select_db($database_conexion1, $conexion1);
  $result = mysql_query($sql, $conexion1) or die(mysql_error());
  $numero = mysql_num_rows($result);
  /*BUSCAMOS LOS ID*/
$sql2="SELECT a.idmantencion, 
EXTRACT(MONTH FROM a.fecha) AS mes,
EXTRACT(YEAR FROM a.fecha) AS anio,
a.idEquipo,
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
and EXTRACT(MONTH FROM a.fecha) = '$mes' 
and EXTRACT(YEAR FROM a.fecha) = '$anio'
and b.idEdificio = c.idEdificio";
if ($idSucursal !='T'){
$sql2.=" and c.idSucursal = '$idSucursal' ";}
$sql2.="  and c.idSucursal = d.idSucursal 
and d.idEmpresa='$cia' order by a.idmantencion ASC";
  $idMantenciones = "";
  $result2 = mysql_query($sql2, $conexion1) or die(mysql_error());
  while($row_BuscaMantencion2=mysql_fetch_assoc($result2)){
    $idMantenciones = $row_BuscaMantencion2["idmantencion"]."-".$idMantenciones;
    }
  if ($numero<1) {
	echo "<h3>No Existen Mantenciones</h3>";
  ?>
    <form action="mantencionPorFechaAdmin.php" method="post" name="form3" id="form3">
       <button aria-label='button1' data-theme='chase' name='button1' role='button' type="submit">
          <span aria-hidden='true'>VOLVER</span>
        </button>
    </form>   
  <?
  }else {
	echo '<p align="right"><a target="_blank" href="mantencionPorFecha_excel.php?mes='.$mes.'&anio='.$anio.'&idSucursal='.$idSucursal.'"><img src="lib/images/excel_icon.png" width="31" height="31" /></a>&nbsp;&nbsp;&nbsp;Mantenciones : '.$numero.'</p>';

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
	 window.location ="mantencionPorFecha2Admin.php?idM="+pagina+"&idE="+equipo+"&sucursal="+sucursal+"&mes="+mes+"&anio="+anio;
  }
function cargapagina2(pagina,equipo,sucursal,mes,anio){
   window.location ="eliminaData/borraMantencion1.php?idM="+pagina+"&idE="+equipo+"&sucursal="+sucursal+"&mes="+mes+"&anio="+anio;
  }
</script>
<div id="contenedor">
  <ul data-inset='true' data-role='listview' data-theme='d'>
    <li>
     <form action="mantencionPorFechaAdmin.php" method="post" name="form3" id="form3">
        <button aria-label='button1' data-theme='chase' name='button1' role='button' type="submit">
          <span aria-hidden='true'>VOLVER</span>
        </button>
    </form>   
    <form action="eliminaData/borraMantencionesAdmin.php" method="post" name="form3" id="form3">
       <input type="hidden" value="<?= $idMantenciones;?>" name="idMn">        
       <input type="hidden" value="<?= $numero;?>" name="largoArray">        
       <input type="hidden" value="<?= $idSucursal;?>" name="sucursal">               
       <input type="hidden" value="<?= $mes;?>" name="mes">        
       <input type="hidden" value="<?= $anio;?>" name="anio">        
       <button aria-label='button1' data-theme='chase' name='button1' role='button' type="submit">
          <span aria-hidden='true'>BORRA MASIVO</span>
        </button>
    </form>    
    </li>
  </ul>  
    <div id="contenidos">
        <div id="columna1" style="background-color:#EDE4DA;">Nro.</div>
        <div id="columna2" style="background-color:#EDE4DA;">Edificio</div>
        <div id="columna3" style="background-color:#EDE4DA;">Oficina</div>
        <div id="columna3" style="background-color:#EDE4DA;"></div>
        <div id="columna3" style="background-color:#EDE4DA;"></div>
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

    <div id="contenidos">
     <div id="columna1" style="background-color:#<?php echo $color;?>" ><?php echo chop($row_Mantencion["nroEquipo"]); ?></div>
        <div id="columna2" style="background-color:#<?php echo $color;?>" ><?php  if ($idSucursal =='T'){
      		echo chop($row_Mantencion["nombreSucursal"]).'-';}	
		      echo chop($row_Mantencion["nombreEdificio"]); ?>
        </div>
        <div id="columna3" style="background-color:#<?php echo $color;?>"><?php echo chop($row_Mantencion["oficinaSala"]); ?></div>  
        <div id="columna3" style="background-color:#<?php echo $color;?>">
            <button aria-label='button1' data-theme='chase' name='button1' role='button' type='button' value='button' onclick="cargapagina(<?php echo $row_Mantencion["idmantencion"].','.$row_Mantencion["nroEquipo"].','.$idSucursal.','.$mes.','.$anio;?>);">
              VER
            </button>
        </div> 
        <div id="columna3" style="background-color:#<?php echo $color;?>">
            <button aria-label='button1' data-theme='chase' name='button1' role='button' type='button' value='button' onclick="cargapagina2(<?php echo $row_Mantencion["idmantencion"].','.$row_Mantencion["nroEquipo"].','.$idSucursal.','.$mes.','.$anio;?>);">
              Borrar
            </button>
        </div>
      </div>  
    <?php $i++;} ?>
    </div>
<?php		 }
  } ?>
         
      
</body>
</html>
<?php

} else {
	$exitGoTo="index.php";
	 header(sprintf("Location: %s", $exitGoTo));  
}
	?>