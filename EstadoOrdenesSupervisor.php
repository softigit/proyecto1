<?php 
  session_start(); 
  if ($_SESSION['nivel']==5){
    $idTecnico=$_SESSION['id'];    
    require_once('Connections/conexion1.php'); 
    require_once('funciones.php');
    mysql_select_db($database_conexion1, $conexion1);
    $queryTecnico = "select * from usuarios where id = $idTecnico";
    $tecnicoArray = mysql_query($queryTecnico, $conexion1) or die(mysql_error());
    $tecnicos = mysql_fetch_assoc($tecnicoArray);

    $queryAgTotal = "select * from agenda where requiere = 1 or requiere = 5 or requiere = 6 or requiere = 7 ORDER BY fecha ASC";
    $agTotal = mysql_query($queryAgTotal, $conexion1) or die(mysql_error());
    $agTotalNumero = mysql_num_rows($agTotal);

    $queryAgEst1 = "select * from agenda where requiere = 1 ORDER BY fecha ASC";
    $agEst1 = mysql_query($queryAgEst1, $conexion1) or die(mysql_error());
    $agEst1Numero = mysql_num_rows($agEst1);

    $queryAgEst3 = "select * from agenda where requiere = 3 ORDER BY fecha ASC";
    $agEst3 = mysql_query($queryAgEst3, $conexion1) or die(mysql_error());
    $agEst3Numero = mysql_num_rows($agEst3);

    $queryAgEst4 = "select * from agenda where requiere = 4 ORDER BY fecha ASC";
    $agEst4 = mysql_query($queryAgEst4, $conexion1) or die(mysql_error());
    $agEst4Numero = mysql_num_rows($agEst4);

    $queryAgEst5 = "select * from agenda where  requiere = 5 ORDER BY fecha ASC";
    $agEst5 = mysql_query($queryAgEst5, $conexion1) or die(mysql_error());
    $agEst5Numero = mysql_num_rows($agEst5);

    $queryAgEst6 = "select * from agenda where  requiere = 6 ORDER BY fecha ASC";
    $agEst6 = mysql_query($queryAgEst6, $conexion1) or die(mysql_error());
    $agEst6Numero = mysql_num_rows($agEst6);

    $queryAgEst7 = "select * from agenda where  requiere = 7 ORDER BY fecha ASC";
    $agEst7 = mysql_query($queryAgEst7, $conexion1) or die(mysql_error());
    $agEst7Numero = mysql_num_rows($agEst7);
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
        <a class='top-left-link home' data-icon='home' href='menuTecnico.php'>Inicio</a>
      </div>
      <div class='content' data-role='content'>
        <h2>Estado Ordenes para <?php echo $tecnicos["nombres"]." ".$tecnicos["apellidos"]?></h2>
          <ul data-inset='true' data-role='listview' data-theme='d'>
            <li>
              <form action="menuTecnico.php" method="post">
                  <center>
                    <button aria-label='button1' data-theme='chase' name='button1' role='button' type='submit' value='submit' >
                      <span aria-hidden='true'>Volver</span>
                    </button>
                  </center>
              </form>
              <div id="contenedorOrdenesAdmin">           
                <div id="contenidosOrdenesAdmin">
                  <div id="columnaEncbOrdenesAdmin" style="background-color:#EDE4DA;">#</div>
                  <div id="columnaEncbOrdenesAdmin" style="background-color:#EDE4DA;">Estado</div>
                  <div id="columnaEncbOrdenesAdmin" style="background-color:#EDE4DA;">Solicitudes</div>
                </div>
                <script type="text/javascript" language="javascript">
                  function cargapagina(requiere){
                    window.location ="listadoOrdenesSupervisor.php?req="+requiere;
                    }
                </script>  
                <div id="contenidosOrdenesAdmin" onclick="cargapagina(0);">
                  <div id="columna1OrdenesAdmin" style="background-color:#<?php echo $color;?>">                        
                    1  
                  </div>                  
                  <div id="columna2OrdenesAdmin" style="background-color:#<?php echo $color;?>">                        
                     Todas las ordenes
                  </div> 
                  <div id="columna3OrdenesAdmin" style="background-color:#<?php echo $color;?>">                        
                     <?php echo $agTotalNumero;?> 
                  </div>             
                </div> 

                <div id="contenidosOrdenesAdmin" onclick="cargapagina(1);">
                  <div id="columna1OrdenesAdmin" style="background-color:#<?php echo $color;?>">                        
                    2  
                  </div>                  
                  <div id="columna2OrdenesAdmin" style="background-color:#<?php echo $color;?>">                        
                     En espera de Tecnico  
                  </div> 
                  <div id="columna3OrdenesAdmin" style="background-color:#<?php echo $color;?>">                        
                     <?php echo $agEst1Numero;?> 
                  </div>              
                </div>    


                <div id="contenidosOrdenesAdmin" onclick="cargapagina(1);">
                  <div id="columna1OrdenesAdmin" style="background-color:#<?php echo $color;?>">                        
                    3  
                  </div>                  
                  <div id="columna2OrdenesAdmin" style="background-color:#<?php echo $color;?>">                        
                     Pendiente de Cotizacion 
                  </div> 
                  <div id="columna3OrdenesAdmin" style="background-color:#<?php echo $color;?>">                        
                     <?php echo $agEst3Numero;?> 
                  </div>              
                </div>    

                <div id="contenidosOrdenesAdmin" onclick="cargapagina(6);">
                  <div id="columna1OrdenesAdmin" style="background-color:#<?php echo $color;?>">                        
                    4
                  </div>                  
                  <div id="columna2OrdenesAdmin" style="background-color:#<?php echo $color;?>">                        
                     En Proceso
                  </div> 
                  <div id="columna3OrdenesAdmin" style="background-color:#<?php echo $color;?>">                        
                     <?php echo $agEst6Numero;?> 
                  </div>             
                </div> 

                <div id="contenidosOrdenesAdmin" onclick="cargapagina(7);">
                  <div id="columna1OrdenesAdmin" style="background-color:#<?php echo $color;?>">                        
                    5
                  </div>                  
                  <div id="columna2OrdenesAdmin" style="background-color:#<?php echo $color;?>">                        
                     Listo 
                  </div> 
                  <div id="columna3OrdenesAdmin" style="background-color:#<?php echo $color;?>">                        
                     <?php echo $agEst7Numero;?> 
                  </div>            
                </div>                                                                                                        
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