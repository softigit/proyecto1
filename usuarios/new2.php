<?php 
 session_start(); 
    if (($_SESSION['nivel']==0) &&  ($_SESSION['id']!="")){
    require_once('../Connections/conexion1.php'); 
    require_once('../funciones.php');
	mysql_select_db($database_conexion1, $conexion1);
    $sql = "SELECT * FROM empresas where  idEmpresa != 6 ORDER BY nombreEmpresa ASC";
    $empresasArray = mysql_query($sql, $conexion1) or die(mysql_error());
	$empresas = mysql_fetch_assoc($empresasArray);
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
            <h2>Nuevo usuario</h2>
            <ul data-inset='true' data-role='listview' data-theme='d'>
                <li>
	                <form name="1" action="index.php" method="post">
	                    <center>
	                      <button aria-label='button1' data-theme='chase' name='button1' role='button' type='submit' value='submit' >
	                        <span aria-hidden='true'>Volver</span>
	                      </button>
	                    </center>
	                </form>
	                <form name="dos" action="create2.php" method="post">
	                    <div id="contenedor">
                    		<div id="contenidos">
                      			<div id="columna1">
                        			Nombre de usuario
                      			</div>
                      			<div id="columna2">
                      				<input type="text" name="user" placeholder="Usuario" required>	
	                      		</div>              
                    		</div>
                    		<div id="contenidos">
                      			<div id="columna1">
                        			Contrase&ntilde;a
                      			</div>
                      			<div id="columna2">
                      				<input type="password" name="pass" placeholder="Pass" required>	
	                      		</div>              
                    		</div>   
                    		<div id="contenidos">
                      			<div id="columna1">
                        			Perfil
                      			</div>
                      			<div id="columna2">
                      				<select name="profile">
                      					<option value="3">Administrador de contrato cliente</option>
                      					<option value="4">Encargado de mantenciones cliente</option>
                      				</select>	
	                      		</div>              
                    		</div> 
                    		<div id="contenidos">
                      			<div id="columna1">
                        			Empresa
                      			</div>
                      			<div id="columna2">
          							      <select name="empresa">
            									<?php do{ ?>
              										<option value="<?php echo $empresas['idEmpresa'];?>" ><?php echo $empresas['nombreEmpresa'];?></option>
            							    <?php } 
            										while ($empresas = mysql_fetch_assoc($empresasArray));
            										?>
							                </select>
	                      		</div>              
                    		</div> 
                    		<div id="contenidos">
                      			<div id="columna1">
                        			Nombre
                      			</div>
                      			<div id="columna2">
                      				<input type="text" name="name" placeholder="Nombre" required>	
	                      		</div>              
                    		</div>
                    		<div id="contenidos">
                      			<div id="columna1">
                        			Apellido
                      			</div>
                      			<div id="columna2">
                      				<input type="text" name="last_name" placeholder="Apellido" required>	
	                      		</div>              
                    		</div>
                    		<div id="contenidos">
                      			<div id="columna1">
                        			Correo
                      			</div>
                      			<div id="columna2">
                      				<input type="text" name="mail" placeholder="Correo" required>	
	                      		</div>              
                    		</div>
                    		<div id="contenidos">
                      			<div id="columna1">
                        			Telefono
                      			</div>
                      			<div id="columna2">
                      				<input type="number" name="phone" placeholder="Telefono">	
	                      		</div>              
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
    $exitGoTo="../index.php";
    header(sprintf("Location: %s", $exitGoTo));  
  }
  ?>