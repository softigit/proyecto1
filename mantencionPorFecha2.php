<?php session_start(); 

if ($_SESSION['idEmpresa']!="" ){
  $nivel = $_SESSION['nivel']; 	
  if ($_GET["idM"]==""){
  	$exitGoTo="menu.php";
	  header(sprintf("Location: %s", $exitGoTo));  	
	  }
  $cia=$_SESSION['idEmpresa'];
	$idM=$_GET["idM"];
  require_once('Connections/conexion1.php'); 
  require_once('funciones.php');
  mysql_select_db($database_conexion1, $conexion1);
  $sql="Select * from mantencion where idmantencion=$idM";
  $Mantencion1 = mysql_query($sql, $conexion1) or die(mysql_error());
  $row_Mantencion1 = mysql_fetch_assoc($Mantencion1);
  if ($row_Mantencion1==""){
	  $exitGoTo="menu.php";
	  header(sprintf("Location: %s", $exitGoTo));  	
	  }
  $idEquipo = $_GET["idE"];  
  $sqlEquipo="Select * from equipo where idEquipo = $idEquipo";
  $equipos = mysql_query($sqlEquipo, $conexion1) or die(mysql_error());
  $rowEquipos = mysql_fetch_assoc($equipos);    
  $nroEquipo = $rowEquipos["nroEquipo"];

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

    <title>M&amp;U Mobile</title>
   
</head>

<body>
<div data-role='page' data-theme='chase' id='contacto'>

        <div class='content' data-role='content'>
          <h2>Revisar Mantención Equipo N° <?php echo $nroEquipo; ?>  </h2>
          <ul data-inset='true' data-role='listview' data-theme='d'>
          <li>
     
          <div id="contenedor">
    <div id="contenidos">
        <div id="columna1">Fecha</div>
        <div id="columna2">
 <?php 
 $fecha_array=explode('-', $row_Mantencion1['fecha']);
 echo $fecha=$fecha_array[2].'-'.$fecha_array[1].'-'.$fecha_array[0];
 //echo date("d-m-Y"); ?></div>
       
    </div>
	
    <div id="contenidos">
        <div id="columna1">Pila:</div>
      <div id="columna2"> 
  <?php echo $row_Mantencion1['pila']==1 ? 'Si' : 'No'; ?>
  
   </div>
   </div>
   <div id="contenidos">
        <div id="columna1"> Control:</div>
        <div id="columna2">
  <?php echo $row_Mantencion1['control']==1 ? 'Si' : 'No'; ?>
 
 </div>
 </div>
   <div id="contenidos">
        <div id="columna1">Señal:</div>
 <div id="columna2">
  <?php echo $row_Mantencion1['senal']==1 ? 'Si' : 'No'; ?>
 
 </div>
 </div>
<div id="contenidos">
<div id="columna1">Temperatura:</div>
<div id="columna2">
   <?php echo $row_Mantencion1['temperatura']==1 ? 'Si' : 'No'; ?>
</div></div>
<div id="contenidos">
<div id="columna1">  Inyecci&oacute;n:</div>
 <div id="columna2"> 
 <?php echo $row_Mantencion1['inyeccion'];?>
 </div></div>
 <div id="contenidos">
<div id="columna1">Retorno:</div>
<div id="columna2">
 <?php echo $row_Mantencion1['retorno'];?>
</div></div>	

<div id="contenidos">
        <div id="columna1">Limp. Filtro:</div>
        <div id="columna2">
  <?php echo $row_Mantencion1['filtro']==1 ? 'Si' : 'No'; ?>
</div>
</div>
 <div id="contenidos">
<div id="columna1">Bandeja<br />Desague:</div>
   <div id="columna2">
   <?php echo $row_Mantencion1['desague']==1 ? 'Si' : 'No'; ?>

   </div></div>
    <div id="contenidos">
<div id="columna1">Bomba:</div>
   <div id="columna2">
   <?php echo $row_Mantencion1['bomba']==1 ? 'Si' : 'No'; ?>

   </div></div>
   <div id="contenidos">
<div id="columna1">Reap.<br />Terminales:</div>
<div id="columna2">
 <?php echo $row_Mantencion1['terminales']==1 ? 'Si' : 'No'; ?>
  </div></div>
     <div id="contenidos">
<div id="columna1">Limp.<br />Condensadores:</div>
  <div id="columna2">
 <?php echo $row_Mantencion1['condensadores']==1 ? 'Si' : 'No'; ?>
    </div></div>
     <div id="contenidos">
<div id="columna1">Limp.Tarjeta:</div>
<div id="columna2">
     <?php echo $row_Mantencion1['tarjeta']==1 ? 'Si' : 'No'; ?>
  
    </div></div>
    <div id="contenidos">
<div id="columna1">Consumo:</div>
<div id="columna2">
   <?php echo $row_Mantencion1['consumo'];?>
   </div></div>
   <div id="contenidos">
<div id="columna1">Carga:</div>
<div id="columna2">
  <?php echo $row_Mantencion1['carga'];?>
   </div></div>
    <div id="contenidos">
<div id="columna1">Obs:</div>
<div id="columna2">
  <textarea name="observacion" cols="32">
  <?php echo $row_Mantencion1['observacion'];?>
  </textarea>
 </div></div>
     <div id="contenidos">
<div id="columna1">Técnico:</div>
<div id="columna2">
  <?php echo  devuelveNombre($row_Mantencion1['idUsuario'],'usuarios','id','nombres').'<br />'.devuelveNombre($row_Mantencion1['idUsuario'],'usuarios','id','apellidos');?>
  </div></div>
  <?php if ($row_Mantencion1['foto1']!=""){ ?>

<div id="contenidos">
<div id="columna1">Registro 1:</div>
<div id="columna2">
 <a href="<?php echo $row_Mantencion1['foto1'];?>" target="new"> <img src="<?php echo $row_Mantencion1['foto1'];?>" height="100px" width="100px"/>
</a>
  
 </div></div>
 
 <?php } if ($row_Mantencion1['foto2']!=""){ ?>
 <div id="contenidos">
 <div id="columna1">Registro 2:</div>
<div id="columna2">
 <a href="<?php echo $row_Mantencion1['foto2'];?>" target="new"> <img src="<?php echo $row_Mantencion1['foto2'];?>" height="100px" width="100px"/>
</a>
  
 </div></div>
 <?php } ?>
 
 </div>
         <!-- aqui va el contenido --> 
         
</li>
  <?php $nivel; if (($nivel == 1) || ($nivel == 5)){?>
    <form name="1" action="mantencionPorFechaTecnico.php" method="post">
      <input type="hidden" name="idSucursal" id="idSucursal" value=<?php echo $_GET['sucursal']; ?>  />
      <input name="mes" type="hidden" id="mes" value=<?php echo $_GET['mes']; ?> />
      <input name="anio" type="hidden" id="anio" value=<?php echo $_GET['anio']; ?> />
      <center>
        <button aria-label='button1' data-theme='chase' name='button1' role='button' type='submit' value='submit' >
          <span aria-hidden='true'>Volver Listado</span>
        </button>
      </center>
    </form>
  <?php } ?> 
  <?php if (($nivel == 0) || ($nivel == 4) || ($nivel == 3)){?>
    <form name="1" action="mantencionPorFecha.php" method="post">
      <input type="hidden" name="idSucursal" id="idSucursal" value=<?php echo $_GET['sucursal']; ?>  />
      <input name="mes" type="hidden" id="mes" value=<?php echo $_GET['mes']; ?> />
      <input name="anio" type="hidden" id="anio" value=<?php echo $_GET['anio']; ?> />
      <center>
        <button aria-label='button1' data-theme='chase' name='button1' role='button' type='submit' value='submit' >
          <span aria-hidden='true'>Volver Listado</span>
        </button>
      </center>
    </form>
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