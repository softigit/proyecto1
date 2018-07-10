<?php 
 session_start(); 
$_SESSION['idEmpresa'] = 8;
if ($_SESSION['idEmpresa']!="" ){
  $nivel = $_SESSION['nivel']; 
  $cia = $_SESSION['idEmpresa'];
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
    <title>DEMO MANTENCION</title> 
  </head>
  <body>
    <div data-role='page' data-theme='chase' id='contacto'>
    <div class='content' data-role='content'>
      <h2>Buscar Mantención</h2>
      <ul data-inset='true' data-role='listview' data-theme='d'>
        <li>
          <form action="mantencionPorFecha.php" method="post">
            <input type="hidden" id="tipoSolicitud" name="tipoSolicitud" value="1" />
              <center>
                <button aria-label='button1' data-theme='chase' name='button1' role='button' type='submit' value='submit' >
                  <span aria-hidden='true'>Fecha</span>
                </button>
              </center>
          </form>
        </li>
        <li>
          <form action="mantencionPorEquipo.php" method="post">
            <input type="hidden" id="tipoSolicitud" name="tipoSolicitud" value="2" />        
              <center>
 <button aria-label='button1' data-theme='chase' name='button1' role='button' type='submit' value='submit' >
              <span aria-hidden='true'>N° de Equipo</span>
          </button>
</center>
</form>
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