<?php session_start(); 
if ($_SESSION['idEmpresa']!="" ){
	if ($_POST["tipoSolicitud"]==""){
	$exitGoTo="menu.php";
	 header(sprintf("Location: %s", $exitGoTo));  	
	}
	$tipoSolicitud=$_POST["tipoSolicitud"];
	switch($tipoSolicitud){
		case '1':$solicitud="Visita Técnica"; break;
		case '2':$solicitud="Visita Comercial"; break;
	}
	
	 $cia=$_SESSION['idEmpresa'];
	 $idUsuario=$_SESSION['id'];
require_once('Connections/conexion1.php'); 
require_once('funciones.php');
$seleccion=0;
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
          <h2><?php echo $solicitud;?></h2>
          <ul data-inset='true' data-role='listview' data-theme='d'>
          <li>
          <form action="<?php echo $_SERVER['PHP_SELF']; ?> " method="post"  name="form3" id="form3">

         <!-- aqui va el contenido --> 
         <select name="seleccion" onchange=form3.submit()>
 <?php        if (isset($_POST["seleccion"])!= ""){  
     $seleccion=$_POST["seleccion"];
	  if ($seleccion=='1'){
	 echo "<option value='1' SELECTED> Lo antes posible</option>";	 }
	   if ($seleccion=='2'){
	 echo "<option value='2' SELECTED> Fecha Específica</option>";	 }
} 

?>
           <option value="1">Lo antes posible</option>
           <option value="2">Fecha Específica</option>
         </select>
          <input type="hidden" value="<?php echo $tipoSolicitud; ?>" id="tipoSolicitud" name="tipoSolicitud" />
          </form>
</li>
     </ul>
     <form action="enviarCorreo.php" method="post" name="form1" id="form1">
          <ul data-inset='true' data-role='listview' data-theme='d'>
              <script language="javascript" type="text/javascript">

function confirmar()
{
	  var txt;
    var r = confirm("Confirme por favor la visita");
    if (r == true) {
		form1.submit();
        txt = "You pressed OK!";
    } else {
        txt = "You pressed Cancel!";
  window.location="menu.php";
    }
}
//if (!confirm
//("Desea confirmar la visita"))
//window.location="menu.php";form1.submit()}
//history.go(-1);return " "}


		</script>
         <?php if ($seleccion=='2'){ 
		 
$dia_manana = date('d',time()+84600);
$mes_manana = date('m',time()+84600);
$ano_manana = date('Y',time()+84600);

 $fecha_manana=$ano_manana.'-'.$mes_manana.'-'.$dia_manana;

?>
		 
   
    <li>
    
         Fecha: 
         <input type="date" name="fechaVisita" id="fechaVisita" value="<?php echo $fecha_manana;?>"/>
         </li>
         <li>
         <label>
         <input type="radio" name="jornadaVisita" id="jornadaVisita" value="ma&ntilde;ana" checked="checked" class="ui-radio-on" /> Mañana</label>
        <label>
         <input type="radio" name="jornadaVisita" id="jornadaVisita" value="tarde"/>Tarde</label>
    <!--  <input name="userfile" type="file" />-->
   </li>
   
   
   
 <?php } ?>  
  <?php if($tipoSolicitud==1){ ?>
  <li>Sucursal:
    <select name="idSucursal" >
  <?php 
  mysql_select_db($database_conexion1, $conexion1);
   $query_Sucursal1 = "SELECT * FROM sucursal where  idEmpresa='$cia' ORDER BY nombreSucursal ASC";
$Sucursal1 = mysql_query($query_Sucursal1, $conexion1) or die(mysql_error());
$numeroSucursal = mysql_num_rows($Sucursal1);
$row_Sucursal1 = mysql_fetch_assoc($Sucursal1);
/*if ($_POST["idSucursal"]!= ""){  
     $sucursal=$_POST["idSucursal"];
	 echo "<option value='".$sucursal."' SELECTED>".devuelveNombre($sucursal,'sucursal','idSucursal','nombreSucursal')."</option>";
}*/
do {  
?>
        <option value="<?php echo $row_Sucursal1['idSucursal']?>" ><?php echo $row_Sucursal1['nombreSucursal'];?></option>
        <?php
} while ($row_Sucursal1 = mysql_fetch_assoc($Sucursal1));

?>

      </select>
    
    </li>
    <li>
    Nro. Equipo
    <input type="tel"  name="nroEquipo" id="nroEquipo" value="" size="8" />
    </li>
    <?php } ?>
          <li>
         <!-- aqui va el contenido --> 
         Solicitante: <?php echo devuelveNombre($idUsuario,'usuarios','id','nombres').' '.devuelveNombre($idUsuario,'usuarios','id','apellidos'); ?>
        
</li>
<li> Teléfono de contacto: <input type="tel" id="fonoContacto" name="fonoContacto" value="<?php echo devuelveNombre($idUsuario,'usuarios','id','fonoContacto'); ?>" />
</li>
<li> Correo de contacto: <input type="text" id="correoContacto" name="correoContacto" value="<?php echo devuelveNombre($idUsuario,'usuarios','id','correoContacto'); ?>" />
          </li>
         <?php if($tipoSolicitud==1){ ?>
          <li> Comentario 1:
          <select name="comentario1">
            <option value="0">Seleccione Opción</option>
            <option value="1">Equipo gotea</option>
            <option value="2">Equipo no enciende</option>
            <option value="3">Equipo no enfría</option>
            <option value="6">Equipo no genera calor</option>
             <option value="4">Equipo emite ruido</option>
              <option value="5">Otro</option>
          </select>
         </li>
          <li> Comentario 2:
          <select name="comentario2">
          <option value="0">Seleccione Opción</option>
            <option value="1">Equipo gotea</option>
            <option value="2">Equipo no enciende</option>
            <option value="3">Equipo no enfría</option>
              <option value="6">Equipo no genera calor</option>
             <option value="4">Equipo emite ruido</option>
             <option value="5">Otro</option>
          </select>
         </li>
         <li> Comentario 3:
          <select name="comentario3">
          <option value="0">Seleccione Opción</option>
            <option value="1">Equipo gotea</option>
            <option value="2">Equipo no enciende</option>
            <option value="3">Equipo no enfría</option>
            <option value="6">Equipo no genera calor</option>
             <option value="4">Equipo emite ruido</option>
             <option value="5">Otro</option>
          </select>
         </li>
         <?php } ?> 
          <li> Comentarios: 
            <textarea name="comentarios" id="comentarios">Ubicación, Edificio,Piso encargado etc.</textarea>
           
<input type="hidden" name="solicitante" id="solicitante" value="<?php echo devuelveNombre($idUsuario,'usuarios','id','nombres').' '.devuelveNombre($idUsuario,'usuarios','id','apellidos'); ?>" />
<input type="hidden" name="empresa" id="empresa" value="<?php 
		echo devuelveNombre($cia,'empresas','idEmpresa','nombreEmpresa');?>" />
<input type="hidden" value="<?php echo $tipoSolicitud; ?>" id="tipoSolicitud" name="tipoSolicitud" /> 
                  
         
          <input name="button" type="button" data-theme='chase' id="button" onclick="confirmar();" value="Agendar" />
          </li>
         
          </ul>
  </form>
      </div>
	 
 
      
</body>
</html>
<?php

} else {
	$exitGoTo="index.php";
	 header(sprintf("Location: %s", $exitGoTo));  
}
	?>