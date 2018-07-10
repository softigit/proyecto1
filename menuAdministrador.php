<?php 
  session_start(); 
    if (($_SESSION['nivel']==0) &&  ($_SESSION['id']!="")){
    require_once('Connections/conexion1.php'); 
    require_once('funciones.php');
    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
      <head>
        <meta content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=0" name="viewport" />
        <meta charset="UTF-8">
        <meta charset="ISO-8859-1" />
        <meta name="apple-mobile-web-app-capable" content="yes" /> 
        <link href="lib/jquery.mobile-1.3.2.min.css" rel="stylesheet" />
        <script src="lib/jquery-1.9.1.min.js"></script>       
        <script src="lib/jquery.mobile-1.3.2.min.js"></script>
        <link href="themes/chase/chase.css" rel="stylesheet" />
        <link href="lib/jquery.mobile.datebox.1.4.0.min.css" rel="stylesheet"  />
        <title>DEMO MANTENCIÓN</title>
      </head>
    <body>
      <div data-role='page' data-theme='chase' id='home'>
        <div class='content' data-role='content'>
          <ul data-inset='true' data-role='listview' data-theme='d'>
            <li>
              <a href='/Api/Mantencion/sistema/usuarios/index.php'>
                <div class='menu-text-with-icon'>
                 GESTION DE USUARIOS
                </div>
              </a>
            </li>
          </ul>
          <ul data-inset='true' data-role='listview' data-theme='d'>
            <li>
              <a href='#'>
                <div class='menu-text-with-icon'>
                 GESTION DE PROVEEDORES
                </div>
              </a>
            </li>
          </ul>  
          <ul data-inset='true' data-role='listview' data-theme='d'>
            <li>
              <a href='#'>
                <div class='menu-text-with-icon'>
                 GESTION DE EQUIPOS
                </div>
              </a>
            </li>
          </ul>  
      <!--
          <ul data-inset='true' data-role='listview' data-theme='d'>
            <li>
              <a href='seleccionarEmpresa3.php'>
                <div class='menu-icon more-disclosures-icon ui-li-thumb menu-item-icon'></div>
                <div class='menu-text-with-icon'>
                  ORDEN DE VISITA
                </div>
              </a>
            </li>
          </ul>

          <ul data-inset='true' data-role='listview' data-theme='d'>
            <li>
              <a href='http://www.myu.cl/intranet/Im0rt4BD/importaBD.php'>
                <div class='menu-text-with-icon'>
                 CARGA MASIVA DE MANTENCIONES
                </div>
              </a>
            </li>
          </ul>
-->
          <ul data-inset='true' data-role='listview' data-theme='d'>
            <li>
              <a href='/Api/Mantencion/sistema/ordenMantencion.php'><!--seleccionarEmpresa2-->
                <div class='menu-text-with-icon'>
                  REVISAR MANTENCIÓN
                </div>
              </a>
            </li>
          </ul>
          <form action="siteminder\cruce.php" name="salir" id="salir" method="post">
            <ul data-inset='true' data-role='listview' data-theme='d'>
              <li>
                  <input type="hidden" name="auth_contextId" id="auth_contextId" value="logout" />
                    <a href='/Api/Mantencion/sistema/siteminder/cruce.php'>
                      <div class='menu-text-with-icon' onclick="salir.submit()">
                        CERRAR SESSIÓN
                      </div>
                    </a>
              </li>
            </ul>
          </form>
        </div>
      </div>     
    </body>
  </html>
<?php } 
  else {
	 $exitGoTo="index.php";
	 header(sprintf("Location: %s", $exitGoTo));  
   }
	 ?>