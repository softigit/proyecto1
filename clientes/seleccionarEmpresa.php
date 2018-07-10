<?php
  require_once('../Connections/conexion1.php'); 
  require_once('../funciones.php');
  session_start(); 
  if (($_SESSION['nivel']==0) &&  ($_SESSION['id']!="") || ($_SESSION['id']==70)){
    mysql_select_db($database_conexion1, $conexion1);
    $query_Empresas = "SELECT * FROM empresas WHERE estado = 0 ORDER BY nombreEmpresa ASC";
    $Empresas1 = mysql_query($query_Empresas, $conexion1) or die(mysql_error());
    $row_Empresas1 = mysql_fetch_assoc($Empresas1);
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $extra = 'index.php'; ?>
  
  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
      <meta content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=0" name="viewport" />
      <meta charset="ISO-8859-1" />
      <meta name="apple-mobile-web-app-capable" content="yes" /> 
      <link href="../lib/jquery.mobile-1.3.2.min.css" rel="stylesheet" />
      <script src="../lib/jquery-1.9.1.min.js"></script>
      <script src="../lib/jquery.mobile-1.3.2.min.js"></script>
      <link href="../themes/chase/chase.css" rel="stylesheet" />
      <link href="../lib/jquery.mobile.datebox.1.4.0.min.css" rel="stylesheet"  />
      <title>M&amp;U Mobile</title>
    </head>
    <body>
      <div data-role='page' data-theme='chase' id='contacto'>
        <div class='header' data-backbtn='false' data-role='header' data-theme='chase'>
          <div class='logo'></div>    
          <? if ($_SESSION['id']!=70){?>
            <a class='top-left-link home' data-icon='home' href='../menuAdministrador.php'>Inicio</a>
          <?}?>
          <? if ($_SESSION['id']==70){?>
            <a class='top-left-link home' data-icon='home' href='../menuTecnico.php'>Inicio</a>
          <?}?> 
        </div>            
        <div class='content' data-role='content'>
          <h2>Seleccione la empresa</h2>     
          <?php $i=0;
			    do { ?>
            <form action="prelist_suc.php" method="post" name="form<?php echo $i;?>" id="form<?php echo $i;?>">
              <ul data-inset='true' data-role='listview' data-theme='d'>           
                <li>
                    <a href='#'>
                      <div class='menu-icon home-find-atm-branch-icon ui-li-thumb menu-item-icon'></div>
                      <div class='menu-text-with-icon' onclick="form<?php echo $i;?>.submit()">
                        <input type="hidden" name="idEmpresa" id="idEmpresa" value="<?php echo $row_Empresas1['idEmpresa'];?>" />
                        <?php echo $row_Empresas1['nombreEmpresa'];?>
                      </div>
                    </a>
                </li>
              </ul>
            </form>
          <?php $i++;} while ($row_Empresas1 = mysql_fetch_assoc($Empresas1));?>
              <ul data-inset='true' data-role='listview' data-theme='d'>           
                <li>
                    <a href='index.php'>
                      <div class='menu-icon home-find-atm-branch-icon ui-li-thumb menu-item-icon'></div>
                      <div class='menu-text-with-icon' onclick="form<?php echo $i;?>.submit()">
                        <input type="hidden" name="idEmpresa" id="idEmpresa" value="<?php echo $row_Empresas1['idEmpresa'];?>" />
                        Volver
                      </div>
                    </a>
                </li>
              </ul>            
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