<?php 
 session_start(); 
  if (($_SESSION['nivel']==0) &&  ($_SESSION['id']!="")){
  require_once('../Connections/conexion1.php'); 
  require_once('../funciones.php');
  mysql_select_db($database_conexion1, $conexion1);
  $sql="SELECT * FROM empresas WHERE estado = 0 ORDER BY nombreEmpresa ASC";
  $empresas = mysql_query($sql, $conexion1) or die(mysql_error());
  $sql2="SELECT * FROM usuarios WHERE estado = 0 and (nivel = 1 or nivel = 10) ORDER BY nombres ASC";
  $tecnicos = mysql_query($sql2, $conexion1) or die(mysql_error());
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
        <title>M&amp;U Mobile</title>
	    <style type="text/css">
	      #contenedor {
	          display: table;
	          border: 1px solid #D3D3D3;
	          width: 100%;
	          text-align: center;
	          margin: 0 auto;
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
    </head>
    <body>
      <div data-role='page' data-theme='chase' id='contacto'>
        <div class='header' data-backbtn='false' data-role='header' data-theme='chase'>
          <div class='logo'></div>
          <a class='top-left-link home' data-icon='home' href='../menuAdministrador.php'>Inicio</a>
        </div>
        <div class='content' data-role='content'>
            <h2>Nueva Sucursal</h2>
            <ul data-inset='true' data-role='listview' data-theme='d'>
                <li>
	                <form name="1" action="index.php" method="post">
	                    <center>
	                      <button aria-label='button1' data-theme='chase' name='button1' role='button' type='submit' value='submit' >
	                        <span aria-hidden='true'>Volver</span>
	                      </button>
	                    </center>
	                </form>
	                <form name="dos" action="create.php" method="post">
                    		<div id="contenidos">
                      			<div id="columna1">
                        			Cliente
                      			</div>
                      			<div id="columna2">
                      				<select name="cliente">
                                  <option value="0" selected>SELECCIONE UN CLIENTE</option>
                                  <?php
                                    while ($row = mysql_fetch_array($empresas)){
                                      echo '<option value="'.$row["idEmpresa"].'">'.$row["nombreEmpresa"].'</option>';  
                                      }
                                    ?>
                      				</select>	
	                      		</div>              
                    		</div> 
                    		<div id="contenidos">
                      			<div id="columna1">
                        			Nombre Sucursal
                      			</div>
                      			<div id="columna2">
                      				<input type="text" name="name" placeholder="Nombre" required>	
	                      		</div>              
                    		</div>
                        <div id="contenidos">
                            <div id="columna1">
                              Encargado
                            </div>
                            <div id="columna2">
                              <input type="text" name="encargado" placeholder="Encargado" required> 
                            </div>              
                        </div>
                        <div id="contenidos">
                            <div id="columna1">
                              Correo Encargado
                            </div>
                            <div id="columna2">
                              <input type="text" name="mail" placeholder="E-mail" required> 
                            </div>              
                        </div>
                        <div id="contenidos">
                            <div id="columna1">
                              Tecnico Asociado
                            </div>
                            <div id="columna2">
                              <select name="tecnico">
                                  <option value="0" selected>SELECCIONE UN TECNICO</option>
                                  <?php
                                    while ($row = mysql_fetch_array($tecnicos)){
                                      $nombre = $row["nombres"]." ".$row["apellidos"];  
                                      echo '<option value="'.$row["id"].'">'.$nombre.'</option>';  
                                      }
                                    ?>
                              </select> 
                            </div>              
                        </div>
	                    <center>
		                    <button aria-label='button1' data-theme='chase' name='button1' role='button' type='submit' value='submit' >
			                    <span aria-hidden='true'>Guardar</span>
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
  } 
  else {
    $exitGoTo="../indexA.php";
    header(sprintf("Location: %s", $exitGoTo));  
  }
  ?>