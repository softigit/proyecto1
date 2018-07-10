<?php 
 session_start(); 
  if (($_SESSION['nivel']==0) &&  ($_SESSION['id']!="")){
  require_once('../Connections/conexion1.php'); 
  require_once('../funciones.php');
  mysql_select_db($database_conexion1, $conexion1);
  $idEdificio = $_POST["idEdificio"];  
  $idSucursal = $_POST["idSucursal"]; 
  $idEmpresa  = $_POST["idEmpresa"]; 

  $sql="SELECT * FROM sucursal WHERE idSucursal = $idSucursal ORDER BY nombreSucursal ASC";
  $sucursal = mysql_query($sql, $conexion1) or die(mysql_error());


  $sql2="SELECT * FROM empresas WHERE idEmpresa = $idEmpresa and estado = 0 ORDER BY nombreEmpresa ASC";
  $empresas = mysql_query($sql2, $conexion1) or die(mysql_error());

  $sql3="SELECT * FROM edificio WHERE idEdificio = $idEdificio";
  $edificios = mysql_query($sql3, $conexion1) or die(mysql_error());

  $query_Marcas = "SELECT * FROM marcas where marca <>'OTRA' ORDER BY marca ASC";
  $Marcas = mysql_query($query_Marcas, $conexion1) or die(mysql_error());
  $row_Marcas = mysql_fetch_assoc($Marcas);
  $totalRows_Marcas = mysql_num_rows($Marcas);


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
            <h2>Nuevo Equipo</h2>
            <ul data-inset='true' data-role='listview' data-theme='d'>
                <li>
                  <form name="1" action="list_bul.php?idS=<?= $idSucursal;?>" method="post">
	                    <center>
	                      <button aria-label='button1' data-theme='chase' name='button1' role='button' type='submit' value='submit' >
	                        <span aria-hidden='true'>Volver</span>
	                      </button>
	                    </center>
	                </form>
	                <form name="dos" action="createBuilding.php" method="post">
                    		<div id="contenidos">
                      			<div id="columna1">
                        			Cliente
                      			</div>
                            <div id="columna2">
                              <select name="cliente">
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
                              Sucursal
                            </div>
                            <div id="columna2">
                              <select name="sucursa">
                                  <?php
                                    while ($rowSucursal = mysql_fetch_array($sucursal)){
                                      echo '<option value="'.$rowSucursal["idSucursal"].'">'.$rowSucursal["nombreSucursal"].'</option>';  
                                      }
                                    ?>
                              </select> 
                            </div>              
                        </div> 
                        <div id="contenidos">
                            <div id="columna1">
                              Nombre Edificio
                            </div>
                            <div id="columna2">
                              <select name="edificio">
                                  <?php
                                    while ($rowEdificio = mysql_fetch_array($edificios)){
                                      echo '<option value="'.$rowEdificio["idEdificio"].'">'.$rowEdificio["nombreEdificio"].'</option>';  
                                      }
                                    ?>
                              </select> 
                            </div>              
                        </div> 
                        <div id="contenidos">
                            <div id="columna1">
                              Numero Equipo
                            </div>
                            <div id="columna2">
                              <input type="number" name="nroEquipo" required> 
                            </div>              
                        </div>
                        <div id="contenidos">
                            <div id="columna1">
                              Marca
                            </div>
                            <div id="columna2">
                              <select name="idMarca" id="idMarca" >
                                <?php
                                  do { ?>
                                    <option value="<?php echo $row_Marcas['idMarca']?>">
                                      <?php echo $row_Marcas['marca']?>
                                    </option>
                                <?php
                                    } while ($row_Marcas = mysql_fetch_assoc($Marcas));
                                  $rows = mysql_num_rows($Marcas);
                                  if($rows > 0) {
                                    mysql_data_seek($Marcas, 0);
                                    $row_Marcas = mysql_fetch_assoc($Marcas);
                                      }?>
                                    <option value="14">OTRA </option>
                              </select>
                            </div>              
                        </div>
                        <div id="contenidos">
                            <div id="columna1">
                              Presentacion
                            </div>
                            <div id="columna2">
                              <select name="presentacion" id="presentacion" >
                                  <option value="Split Muro">Split Muro </option>
                                  <option value="Split Cassette">Split Cassette</option>
                                  <option value="Split Piso-Cielo">Split Piso-Cielo</option>
                                  <option value="Ducto">Ducto</option>
                                  <option value="Compacto">Compacto</option>
                                  <option value="Mochila">Mochila</option>
                                  <option value="Ventana">Ventana</option>
                                  <option value="Chiller">Chiller </option>
                              </select>
                            </div>              
                        </div>
                        <div id="contenidos">
                            <div id="columna1">
                              Btu
                            </div>
                            <div id="columna2">
                              <select name="btu"  id="btu" >
                                <option value="9.000">9.000</option>
                                <option value="12.000">12.000</option>
                                <option value="18.000">18.000</option>
                                <option value="24.000">24.000</option>
                                <option value="36.000">36.000</option>
                                <option value="48.000">48.000</option>
                                <option value="60.000">60.000</option>
                              </select>
                            </div>              
                        </div>
                        <div id="contenidos">
                            <div id="columna1">
                              Refrigerante
                            </div>
                            <div id="columna2">
                              <select name="refrigerante" id="refrigerante">
                                <option value="R-22">R-22</option>
                                <option value="R-410a">R-410a</option>
                                <option value="R-410 Inverter">R-410 Inverter</option>
                                <option value="R-407">R-407</option>
                              </select>
                            </div>              
                        </div>
                        <div id="contenidos">
                            <div id="columna1">
                              Fecha Instalaci&oacute;n:
                            </div>
                            <div id="columna2">
                              <input type="date" size="15" name="f_rangeStart" id="f_rangeStart"/>
                            </div>              
                        </div>
                         <div id="contenidos">
                            <div id="columna1">
                              Piso
                            </div>
                            <div id="columna2">
                              <select name="piso" size="1" id="piso" >
                                <?php for ($i=-4;$i<21;$i++){
                                  if ($i!=0){
                                    echo '<option value="'.$i.'">'.$i.'</option>';
                                    }
                                }?>
                              </select>
                            </div>              
                        </div> 
                         <div id="contenidos">
                            <div id="columna1">
                              Oficina/Sala
                            </div>
                            <div id="columna2">
                              <input type="text" name="oficinaSala" value="" size="20" />
                            </div>              
                        </div> 
                         <div id="contenidos">
                            <div id="columna1">
                              Mail Usuario
                            </div>
                            <div id="columna2">
                              <input type="email" name="mailUsuario" value="" size="32" />
                            </div>              
                        </div>  
                         <div id="contenidos">
                            <div id="columna1">
                              Usuario
                            </div>
                            <div id="columna2">
                              <input type="text" name="usuario" value="" size="32" />
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