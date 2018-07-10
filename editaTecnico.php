<?php session_start(); 

if ($_SESSION['idEmpresa']!="" ){
	if ($_GET["idE"]==""){
	$exitGoTo="menuTecnico2.php";
	 header(sprintf("Location: %s", $exitGoTo));  	
	}	
	$cia=$_SESSION['idEmpresa'];
	$idE=$_GET["idE"];

  require_once('Connections/conexion1.php'); 
  require_once('funciones.php');
  mysql_select_db($database_conexion1, $conexion1);
  $query_equipo = "SELECT * FROM equipo where  idEquipo = $idE";
  $equipo_array = mysql_query($query_equipo, $conexion1) or die(mysql_error());
  $equipos      = mysql_fetch_assoc($equipo_array);

  $query_Marcas = "SELECT * FROM marcas where marca <>'OTRA' ORDER BY marca ASC";
  $Marcas = mysql_query($query_Marcas, $conexion1) or die(mysql_error());
  $row_Marcas = mysql_fetch_assoc($Marcas);
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
          <h2>DATOS EQUIPO N° <?php echo $equipos['nroEquipo']; ?>  </h2>
            <ul data-inset='true' data-role='listview' data-theme='d'>
              <li>
                <form name="1" action="mantencionPorFechaTecnico.php" method="post">
                <input type="hidden" name="idSucursal" id="idSucursal" value=<?php echo $_GET['sucursal']; ?>  />
                <input name="mes" type="hidden" id="mes" value=<?php echo $_GET['mes']; ?> />
                <input name="anio" type="hidden" id="anio" value=<?php echo $_GET['anio']; ?> />
                <center>
                  <button aria-label='button1' data-theme='chase' name='button1' role='button' type='submit' value='submit' >
                    <span aria-hidden='true'>VOLVER</span>
                  </button>
                </center>
                </form>
              </li> 
            </ul>           
          <form name="1" action="actuEquipoTecnico.php" method="post">
            <input type="hidden" name="idSucursal" id="idSucursal" value=<?php echo $_GET['sucursal']; ?>  />
            <input type="hidden" name="idEquipo" id="idEquipo" value=<?php echo $_GET['idE']; ?>  />
            <input type="hidden" name="mes" id="mes" value=<?php echo $_GET['mes']; ?> />
            <input type="hidden" name="anio" id="anio" value=<?php echo $_GET['anio']; ?> />
            <ul data-inset='true' data-role='listview' data-theme='d'>
              <li>
                <div id="contenedor">
                  <div id="contenidos">
                    <div id="columna1">
                       Numero de Equipo
                    </div>
                    <div id="columna2">
                      <input type="number" name="NroEquipo" id="NroEquipo" value="<?php echo $equipos['nroEquipo'];?>" required/>
                    </div>       
                  </div>
                </div>        
                <div id="contenedor">
                  <div id="contenidos">
                    <div id="columna1">
                       Marca
                    </div>
                    <div id="columna2">
                      <select name="IdMarca" id="IdMarca">
                      <?php
                        do { ?>
                          <option value="<?php echo $row_Marcas['idMarca']?>" <?php if ($row_Marcas['idMarca'] == $equipos['idMarca']){?>selected<?php } ?>>
                            <?php echo $row_Marcas['marca']?>
                          </option>
                        <?php } 
                        while ($row_Marcas = mysql_fetch_assoc($Marcas));
                        $rows = mysql_num_rows($Marcas);
                        if($rows > 0) {
                          mysql_data_seek($Marcas, 0);
                          $row_Marcas = mysql_fetch_assoc($Marcas);
                          }
                        ?>
                          <option value="14">OTRA </option>
                      </select>
                    </div>       
                  </div>
                </div>   
                <div id="contenedor">
                  <div id="contenidos">
                    <div id="columna1">
                       Presentación
                    </div>
                    <div id="columna2">
                      <select name="presentacion" id="presentacion">
                        <option value="Split Muro" <?php if ($equipos['presentacion'] == "Split Muro"){?>selected<?php }?>>
                          Split Muro
                        </option>           
                        <option value="Split Cassette" <?php if ($equipos['presentacion'] == "Split Cassette"){?>selected<?php }?>>
                          Split Cassette
                        </option>
                        <option value="Split Piso-Cielo" <?php if ($equipos['presentacion'] == "SSplit Piso-Cielo"){?>selected<?php }?>>
                          Split Piso-Cielo
                        </option>
                        <option value="Ducto" <?php if ($equipos['presentacion'] == "Ducto"){?>selected<?php }?>>
                          Ducto
                        </option>
                        <option value="Compacto" <?php if ($equipos['presentacion'] == "Compacto"){?>selected<?php }?>>
                          Compacto
                        </option>
                        <option value="Mochila" <?php if ($equipos['presentacion'] == "Mochila"){?>selected<?php }?>>
                          Mochila
                        </option>
                        <option value="Ventana" <?php if ($equipos['presentacion'] == "Ventana"){?>selected<?php }?>>
                          Ventana
                        </option>
                        <option value="Chiller" <?php if ($equipos['presentacion'] == "Chiller"){?>selected<?php }?>>
                          Chiller
                        </option>
                        <option value="S/D" <?php if ($equipos['presentacion'] == "S/D"){?>selected<?php }?>>
                          S/D
                        </option>
                      </select>  
                    </div>       
                  </div>
                </div>   
                <div id="contenedor">
                  <div id="contenidos">
                    <div id="columna1">
                       Btu
                    </div>
                    <div id="columna2">
                      <select name="btu" id="btu">
                        <option value="9.000" <?php if ($equipos['btu'] == "9.000"){?>selected<?php }?>>
                          9.000
                        </option>
                        <option value="12.000" <?php if ($equipos['btu'] == "12.000"){?>selected<?php }?>>
                          12.000
                        </option>
                        <option value="18.000" <?php if ($equipos['btu'] == "18.000"){?>selected<?php }?>>
                          18.000
                        </option>
                        <option value="24.000" <?php if ($equipos['btu'] == "24.000"){?>selected<?php }?>>
                          24.000
                        </option>
                        <option value="36.000" <?php if ($equipos['btu'] == "36.000"){?>selected<?php }?>>
                          36.000
                        </option>
                        <option value="48.000" <?php if ($equipos['btu'] == "48.000"){?>selected<?php }?>>
                          48.000
                        </option>
                        <option value="60.000" <?php if ($equipos['btu'] == "60.000"){?>selected<?php }?>>
                          60.000
                        </option> 
                        <option value="S/D"<?php if ($equipos['btu'] == "S/D"){?>selected<?php }?>>
                          S/D
                        </option> 
                      </select>                     
                    </div>       
                  </div>
                </div> 
                <div id="contenedor">
                  <div id="contenidos">
                    <div id="columna1">
                       Refrigerante
                    </div>
                    <div id="columna2">
                      <select name="refrigerante" id="refrigerante">
                        <option value="R-22" <?php if ($equipos['refrigerante'] == "R-22"){?>selected<?php }?>>
                          R-22
                        </option>
                        <option value="R-410a" <?php if ($equipos['refrigerante'] == "R-410a"){?>selected<?php }?>>
                          R-410a
                        </option>
                        <option value="R-410 Inverter" <?php if ( $equipos['refrigerante'] == "R-410 Inverter"){?>selected<?php }?>>
                          R-410 Inverter
                        </option>
                        <option value="R-407" <?php if ($equipos['refrigerante'] == "R-407"){?>selected<?php }?>>
                          R-407
                        </option>
                        <option value="S/D" <?php if ($equipos['refrigerante'] == "S/D"){?>selected<?php }?>>
                          S/D
                        </option>                        
                      </select>                      
                    </div>       
                  </div>
                </div> 
                <div id="contenedor">
                  <div id="contenidos">
                    <div id="columna1">
                       Piso
                    </div>
                    <div id="columna2">
                      <input type="text" name="piso" id="piso" value="<?php echo $equipos['piso'];?>" required/>
                    </div>       
                  </div>
                </div> 
                <div id="contenedor">
                  <div id="contenidos">
                    <div id="columna1">
                       Oficina
                    </div>
                    <div id="columna2">
                      <input type="text" name="oficinaSala" id="oficinaSala" value="<?php echo $equipos['oficinaSala'];?>" required/>
                    </div>       
                  </div>
                </div> 
              </li>
              <li>
                <center>
                  <button aria-label='button1' data-theme='chase' name='button1' role='button' type='submit' value='submit' >
                    <span aria-hidden='true'>ACTUALIZAR</span>
                  </button>
                </center>
              </li>
            </ul>
          </form> 
          <ul data-inset='true' data-role='listview' data-theme='d'>
            <li>
              <a href="http://www.myu.cl/intranet/IngresamantencionTecnico2.php?idE=<?php echo $_GET['idE'];?>&sucursal=<?php echo $_GET['sucursal'];?>&mes=<?php echo $_GET['mes'];?>&anio=<?php echo $_GET['anio'];?>">
                <div aria-label='button1' data-theme='chase'></div>
                  <div class='menu-text-with-icon'>
                    AGREGAR MANTENCION
                  </div>
                </div>
              </a>
            </li> 
          </ul>                       
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