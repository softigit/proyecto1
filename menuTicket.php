<?php
  session_start(); 
  require_once('funciones.php');
  if (isset($_POST["idEmpresa"])){
    $_SESSION['idEmpresa'] =$_POST["idEmpresa"];
    }
  if ($_SESSION['id']!=""){
    $idUsuario=$_SESSION['id'];
    $nivel=$_SESSION["nivel"];
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
            <h2>Orden de Visitas</h2>
                <ul data-inset='true' data-role='listview' data-theme='d'>
                  <li>
                    <a href='ordenVisita2.php'>
                      <div class='menu-icon more-disclosures-icon ui-li-thumb menu-item-icon'></div>
                      <div class='menu-text-with-icon'>
                       ORDEN DE VISITA
                      </div>
                    </a>
                  </li>
                </ul>
                <ul data-inset='true' data-role='listview' data-theme='d'>
                  <li>
                    <a href='seleccionarEmpresa3.php'>
                      <div class='menu-icon home-cambiarEmpresa-icon ui-li-thumb menu-item-icon'></div>
                      <div class='menu-text-with-icon'>
                        VOLVER
                      </div>
                    </a>
                  </li>
                </ul>
                <form action="siteminder\cruce.php" name="salir" id="salir" method="post">
                  <ul data-inset='true' data-role='listview' data-theme='d'>
                    <li>
                      <input type="hidden" name="auth_contextId" id="auth_contextId" value="logout" />
                        <a href='#'>
                          <div class='menu-icon more-privacy-icon ui-li-thumb menu-item-icon'></div>
                          <div class='menu-text-with-icon' onclick="salir.submit()">
                            CERRAR SESI�N
                          </div>
                        </a>
                    </li>
                  </ul>
                </form>
            </div>
          </div>
      </body>
    </html>
    <?php } else {
    	 $exitGoTo="index.php";
    	 header(sprintf("Location: %s", $exitGoTo));  
      }
    ?>