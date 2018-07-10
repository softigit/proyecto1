<?php 
require_once('Connections/conexion1.php'); 
require_once('funciones.php');

if ( is_session_started() === FALSE) session_start(); 
$nivel=$_SESSION["nivel"];
if ($nivel==2 ||$nivel==0 ){
$razonSocial='';
$rut='';	
$email='';
$direccion='';


if (isset($_POST["rut"])!= "" ){
	$vowels = array(".", "-");
$rut = str_replace($vowels, "", $_POST["rut"]);
	$rut=strtoupper($rut);
	if (validaRut($rut))$razonSocial=razonSocial($rut);
}
	

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
          <h2>Cotización</h2>
          <ul data-inset='true' data-role='listview' data-theme='d'>
          <li>
         <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"
 name="form1" id="form1">
    <h3>Ingrese el Rut:</h3>
         <input type="text"  placeholder="Rut sin . ni -" name="rut" id="rut" value="<?php echo $rut;?>"/>
       
      <button aria-label='button1' data-theme='chase' name='button1' role='button' type="submit"  >
              <span aria-hidden='true'>Consultar Rut</span>
            </button>
     
           <?php if (!validaRut($rut)){ ?>
           
           <p  class="negative-currency" > Rut Incorrecto</p>
           <?php } ?>
         </form>

<?php if ($rut!='' && validaRut($rut)){ ?>
<script language="javascript" src="regiones.js"></script>

 <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="form2" id="form2">
  <input type="hidden" name="rutEmpresa" id="rutEmpresa" value="<?php echo isset($_POST["idEmpresa"]); ?>" />
         <h3> Razón Social</h3>
         <input type="text" name="razonSocial" id="razonSocial" value="<?php echo $razonSocial;?>"/>
         <h3> Correo Electrónico</h3>
         <input type="text" name="email" id="email" value="<?php echo $email;?>"/>
          <h3> Contacto</h3>
         <input type="text" name="email" id="email" value="<?php echo $email;?>"/>
         <h3> Dirección</h3>
         <input type="text" name="direccion" id="direccion" value="<?php echo $direccion;?>"/>
     <h3>Región </h3>
    <select name="region" class="bordeform" id="region" onchange="javascript:regiones(region.selectedIndex+1,0);">
                            <option>Seleccione</option>
                            <option value="RM">RM</option>
                            <option value="XV">XV</option>
                            <option value="I">I</option>
                            <option value="II">II</option>
                            <option value="III">III</option>
                            <option value="IV">IV</option>
                            <option value="V">V</option>
                            <option value="VI">VI</option>
                            <option value="VII">VII</option>
                            <option value="VIII">VIII</option>
                            <option value="IX">IX</option>
                            <option value="X">X</option>
                            <option value="XI">XI</option>
                            <option value="XII">XII</option>
                            <option value="XIII">XIII</option>
                            <option value="XIV">XIV</option>
                            
                          </select>
<h3>Comuna </h3>
         <select name="comuna" class="bordeform" id="comuna">
                            <option>Seleccione</option>
                          
                          </select>

          </form>
         <?php } ?>
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