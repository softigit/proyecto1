<?php session_start(); 
if ($_SESSION['idEmpresa']!=""){
	 $cia=$_SESSION['idEmpresa'];
require_once('Connections/conexion1.php'); 
require_once('funciones.php');
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

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
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

//buscar equipo
$nroEquipo='';
if (isset($_POST["nroEquipo"])!= "" ){
	$nroEquipo=$_POST["nroEquipo"];
	
}




?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=0" name="viewport" />

<meta charset="ISO-8859-1" />
  <meta name="apple-mobile-web-app-capable" content="yes" /> 
  
   <link href="lib/jquery.mobile-1.3.2.min.css" rel="stylesheet" />
  <link href="lib/jquery.mobile.datebox.1.4.0.min.css" rel="stylesheet"  />
   
    
<link href="themes/chase/chase.css" rel="stylesheet" />
   
    
    
   <script src="lib/jquery-1.9.1.min.js"></script>
    <script src="lib/jquery.mobile-1.3.2.min.js"></script>

  
      


    <title>M&amp;U Mobile</title>
   
</head>

<body>
 <div data-role='page' data-theme='chase' id='contacto'>
        <div class='header' data-backbtn='false' data-role='header' data-theme='chase'>
          <div class='logo'></div>
          <a class='top-left-link home' data-icon='home' href='menu.php'>Inicio</a>
        </div>
        <div class='content' data-role='content'>
  <h2>
            Agregar Mantención            
          </h2>
           <ul data-inset='true' data-role='listview' data-theme='d'>
           <li class='phone-link' id='supportTel'>
          

   
  <h3>Empresa:   <?php 
		echo devuelveNombre($cia,'empresas','idEmpresa','nombreEmpresa');
?>	</h3>
      	
    </li>
    
     
 <?php if ($cia != ""){  ?>
 <li class='phone-link' id='supportTel'>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"
 name="form4" id="form4">

   <input type="hidden" name="idEmpresa" id="idEmpresa" value="<?php echo isset($_POST["idEmpresa"]); ?>" />
    <h3>Sucursal:</h3>
      
      <?php 
	  $query_Sucursal1 = "SELECT * FROM sucursal where  idEmpresa='$cia' ORDER BY nombreSucursal ASC";
$Sucursal1 = mysql_query($query_Sucursal1, $conexion1) or die(mysql_error());
$numeroSucursal = mysql_num_rows($Sucursal1);
$row_Sucursal1 = mysql_fetch_assoc($Sucursal1);
//echo $_POST["idSucursal"];
      ?>
    <select name="idSucursal" onchange="form4.submit()" >
  <?php if (@$_POST["idSucursal"]=="") { ?>
  <option value="" SELECTED>Seleccione Sucursal</option>
  <?php }
if (isset($_POST["idSucursal"])!= ""){  
     $sucursal=$_POST["idSucursal"];
	 echo "<option value='".$sucursal."'>".devuelveNombre($sucursal,'sucursal','idSucursal','nombreSucursal')."</option>";
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
    
	<?php } ?>
    
    
    
    
    
    
<?php if (isset($_POST["idSucursal"])!= "" || $numeroSucursal==1){
	if ($numeroSucursal==1){$sucursal= $row_Sucursal1['idSucursal'];}
	  ?>

<li class='phone-link'>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="form1" id="form1">

      <h3>Nro Equipo:</h3>
      <input type="tel" name="nroEquipo" id="nroEquipo" value="<?php echo $nroEquipo;?>" size="8" />
    
    
      <button aria-label='button1' data-theme='chase' name='button1' role='button' type='submit' value='submit' >
              <span aria-hidden='true'>Consultar Equipo</span>
          </button>
   
  <input type="hidden" name="MM_insert" value="form1" />
  <input type="hidden" name="idSucursal" value="<?php echo $sucursal;?>" /> 
  
</form>


<?php } ?>

</li>
</ul>
<?php 
if (isset($_POST["nroEquipo"])!= "" ){
	if ($numeroSucursal==1){$sucursal= $row_Sucursal1['idSucursal'];}
	
	$sqlEquipo="SELECT 
a.idEquipo,
b.nombreEdificio,
a.piso,
d.marca,
a.presentacion,
a.btu,
a.usuario,
a.oficinaSala
 FROM 
equipo as a ,
edificio as b,
sucursal as c,
marcas as d

WHERE a.nroEquipo=$nroEquipo and
a.idMarca = d.idMarca and
a.idEdificio = b.idEdificio and
b.idSucursal = c.idSucursal and
c.idSucursal=$sucursal";
$Equipo1 = mysql_query($sqlEquipo, $conexion1) or die(mysql_error());
$numeroEquipo = mysql_num_rows($Equipo1);
$row_Equipo1 = mysql_fetch_assoc($Equipo1);
	  ?>

           <ul data-inset='true' data-role='listview' data-theme='d'>
           <li >
           <form action="generarMantencion.php" method="post" name="form3" id="form3" target="_self">
                   
<?php if ($numeroEquipo<1) {
	echo "<h3>No Existen coincidencias</h3>";
}else {
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
	background-color:#EDE4DA;
    vertical-align: middle;
	text-align:left;
    padding: 10px;
	
}


</style>
<div id="contenedor">
    <div id="contenidos">
        <div id="columna1">Edificio</div>
        <div id="columna2"><?php echo chop($row_Equipo1["nombreEdificio"]); ?></div>
       
    </div>
    <div id="contenidos">
        <div id="columna1">Piso</div>
        <div id="columna2"><?php echo $row_Equipo1["piso"]; ?>     </div> </div>
    <div id="contenidos">
        <div id="columna1">Marca</div>
        <div id="columna2"><?php echo $row_Equipo1["marca"]; ?>    </div></div>
      <div id="contenidos">
        <div id="columna1">Presentación</div>
        <div id="columna2"><?php echo $row_Equipo1["presentacion"]; ?></div> </div>
      <div id="contenidos">
        <div id="columna1">BTU</div>
        <div id="columna2"><?php echo $row_Equipo1["btu"]; ?></div> </div>
     <div id="contenidos">
        <div id="columna1">Usuario</div>
        <div id="columna2"><?php echo $row_Equipo1["usuario"]; ?></div> </div>
     <div id="contenidos">
        <div id="columna1">Oficina/Sala</div>
        <div id="columna2"><?php echo $row_Equipo1["oficinaSala"]; ?></div> </div>
    
    
</div>
 <button aria-label='button1' data-theme='chase' name='button1' role='button' type='submit' value='submit' >
              <span aria-hidden='true'>Generar Mantención</span>
          </button>
   
  <input type="hidden" name="MM_insert" value="form3" />
  <input type="hidden" name="idEquipo" id="idEquipo" value="<?php echo $row_Equipo1["idEquipo"]; ?>" />
<input type="hidden" name="nroEquipo" id="nroEquipo" value="<?php echo $nroEquipo;?> " />

<?php } ?>
</form>
</li>
</ul>
<?php } ?>
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
