<?php session_start(); 
if (isset($_POST["idEmpresa"])){
$_SESSION['idEmpresa'] =$_POST["idEmpresa"];
}
if ($_SESSION['id']!=""){
$idUsuario=$_SESSION['id'];
$nivel=$_SESSION["nivel"];
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
          <h2>Edificios</h2>
<ul data-inset='true' data-role='listview' data-theme='d'>
            <li>
              <a href='agregarEdificio.php'>
                <div class='menu-icon home-nuevo-icon ui-li-thumb menu-item-icon'></div>
                <div class='menu-text-with-icon'>
                  Agregar Edificio
                </div>
              </a>
            </li>
            </ul>
            <ul data-inset='true' data-role='listview' data-theme='d'>
            <li>
              <a href='agregarEquipo.php'>
                <div class='menu-icon home-agregarEquipo-icon ui-li-thumb menu-item-icon'></div>
                <div class='menu-text-with-icon'>
                  Editar Edificio
                </div>
              </a>
            </li>
            </ul>
    
    <ul data-inset='true' data-role='listview' data-theme='d'>
            <li>
              <a href='listadoEdificios.php'>
                <div class='menu-icon home-agregarEquipo-icon ui-li-thumb menu-item-icon'></div>
                <div class='menu-text-with-icon'>
                  Listado Edificios
                </div>
              </a>
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