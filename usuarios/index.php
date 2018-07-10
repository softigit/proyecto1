<?php 
 session_start(); 
   if (($_SESSION['nivel']==0) &&  ($_SESSION['id']!="")){
   require_once('../Connections/conexion1.php'); 
   require_once('../funciones.php');
   ?>
  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
      <meta content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=0" name="viewport" />
      <meta charset="ISO-8859-1" />
      <meta name="apple-mobile-web-app-capable" content="yes" /> 
      <link href="../lib/jquery.mobile-1.3.2.min.css" rel="stylesheet" />
      <link href="../themes/chase/chase.css" rel="stylesheet" />
      <link href="../lib/jquery.mobile.datebox.1.4.0.min.css" rel="stylesheet"  />
      <script src="../lib/jquery-1.9.1.min.js"></script>
      <script src="../lib/jquery.mobile-1.3.2.min.js"></script>
      <script type="text/javascript">
        $(document).bind("mobileinit", function(){
          $.extend( $.mobile , {
           ajaxFormsEnabled = false; });
        });
      </script>            
        <title>DEMO MANTENCIÓN</title>
    </head>
    <body>
      <div data-role='page' data-theme='chase' id='contacto'>
        <div class='content' data-role='content'>
          <h2>Gestion de usuarios</h2>
          <ul data-inset='true' data-role='listview' data-theme='d'>
            <li>
              <a href='#'><!--usuarios/new.php-->
                <div class='menu-text-with-icon'>
                  NUEVO USUARIO SISTEMA
                </div>
              </a>
            </li>
          </ul>
          <ul data-inset='true' data-role='listview' data-theme='d'>
            <li>
              <a href='#'><!--usuarios/new2.php-->
                <div class='menu-text-with-icon'>
                  NUEVO USUARIO CLIENTE
                </div>
              </a>
            </li>
          </ul>
          <ul data-inset='true' data-role='listview' data-theme='d'>
            <li>
              <a href='#'><!--usuarios/list_client.php-->
                <div class='menu-text-with-icon'>
                 LISTADO DE USUARIOS CLIENTES
                </div>
              </a>
            </li>
          </ul>
          <ul data-inset='true' data-role='listview' data-theme='d'>
            <li>
              <a href='#'><!--usuarios/list_user.php-->
                <div class='menu-text-with-icon'>
                 LISTADO DE USUARIOS SISTEMA
                </div>
              </a>
            </li>
          </ul>
          <ul data-inset='true' data-role='listview' data-theme='d'>
            <li>
              <a href='../menuAdministrador.php'><!--usuarios/list_user.php-->
                <div class='menu-text-with-icon'>
                 VOLVER
                </div>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </body>
  </html>
<?php
  } 
  else {
    $exitGoTo="../index.php";
    header(sprintf("Location: %s", $exitGoTo));  
  }
  ?>