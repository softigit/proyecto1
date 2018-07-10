<?php 
 session_start(); 
    if (($_SESSION['nivel']==0) &&  ($_SESSION['id']!="")){
  	require_once('../Connections/conexion1.php'); 
  	require_once('../funciones.php');
	mysql_select_db($database_conexion1, $conexion1);		
	$idUser = $_POST["idCliente"];
	$sqlUser = "SELECT * FROM usuarios WHERE id = $idUser";
	$userArray = mysql_query($sqlUser, $conexion1) or die(mysql_error());
	$usuarios = mysql_fetch_assoc($userArray);

	$sqlUserEmpr = "SELECT * FROM rel_empresa_usuario WHERE idUsuario = $idUser";
	$userEmpArray = mysql_query($sqlUserEmpr, $conexion1) or die(mysql_error());
	$userEmp = mysql_fetch_assoc($userEmpArray);
	$idEmpresa = $userEmp['idEmpresa'];

	$sqlemp = "SELECT * FROM empresas WHERE idEmpresa = $idEmpresa";
	$empreArray = mysql_query($sqlemp, $conexion1) or die(mysql_error());
	$empresas = mysql_fetch_assoc($empreArray);
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
            <h2>Ficha de usuario</h2>
            <ul data-inset='true' data-role='listview' data-theme='d'>
                <li>
	                <form name="1" action="list_client.php" method="post">
	                    <center>
	                      <button aria-label='button1' data-theme='chase' name='button1' role='button' type='submit' value='submit' >
	                        <span aria-hidden='true'>Volver</span>
	                      </button>
	                    </center>
	                </form>
	                <form name="dos" action="#" method="post">
	                    <div id="contenedor">
                    		<div id="contenidos">
                      			<div id="columna1">
                        			Nombre de usuario
                      			</div>
                      			<div id="columna2">
                      				<?php echo $usuarios['username'];?>	
	                      		</div>              
                    		</div>
                    		<div id="contenidos">
                      			<div id="columna1">
                        			Contrase&ntilde;a
                      			</div>
                      			<div id="columna2">
                      				<?php echo $usuarios['pass'];?>	
	                      		</div>              
                    		</div>   
                    		<div id="contenidos">
                      			<div id="columna1">
                        			Perfil
                      			</div>
                      			<div id="columna2">
                      				<?php 
                      				if ($usuarios['nivel'] == 3)	
                  						$nivel = "Administrador de contrato cliente";
                      				if ($usuarios['nivel'] == 4)	
                   						$nivel = "Encargado de mantenciones cliente";
                  					echo strtoupper($nivel);	
                      				?>	
	                      		</div>              
                    		</div> 
                    		<div id="contenidos">
                      			<div id="columna1">
                        			Empresa
                      			</div>
                      			<div id="columna2">
                      				<?php 
                  					echo strtoupper($empresas['nombreEmpresa']);	
                      				?>	
	                      		</div>              
                    		</div>                     		
                    		<div id="contenidos">
                      			<div id="columna1">
                        			Nombre
                      			</div>
                      			<div id="columna2">
                      				<?php echo $usuarios['nombres'];?>		
	                      		</div>              
                    		</div>
                    		<div id="contenidos">
                      			<div id="columna1">
                        			Apellido
                      			</div>
                      			<div id="columna2">
                      				<?php echo $usuarios['apellidos'];?>	
	                      		</div>              
                    		</div>
                    		<div id="contenidos">
                      			<div id="columna1">
                        			Correo
                      			</div>
                      			<div id="columna2">
                      				<?php echo $usuarios['correoContacto'];?>	
	                      		</div>              
                    		</div>
                    		<div id="contenidos">
                      			<div id="columna1">
                        			Telefono
                      			</div>
                      			<div id="columna2">
                      				<?php echo $usuarios['fonoContacto'];?>	
	                      		</div>              
                    		</div>
    		            </div>
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
    $exitGoTo="../index.php";
    header(sprintf("Location: %s", $exitGoTo));  
  }
  ?>