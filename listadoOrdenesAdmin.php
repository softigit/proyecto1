<?php 
  session_start(); 
  if ($_SESSION['idEmpresa']!="" ){
    $cia=$_SESSION['idEmpresa'];
    if ($_GET["req"]==""){
      $exitGoTo="EstadoOrdenesAdmin.php";
      header(sprintf("Location: %s", $exitGoTo));   
      }
    $requiere = $_GET["req"]; 
    require_once('Connections/conexion1.php'); 
    require_once('funciones.php');
    mysql_select_db($database_conexion1, $conexion1);
    $queryEmpresa = "select * from empresas where idEmpresa = $cia";
    $empresaArray = mysql_query($queryEmpresa, $conexion1) or die(mysql_error());
    $empresaNumero = mysql_num_rows($empresaArray);
    $empresas = mysql_fetch_assoc($empresaArray);
    if ($requiere == 0){
      mysql_select_db($database_conexion1, $conexion1);
	    $queryAgenda = "select * from agenda where idEmpresa = $cia ORDER BY idAgenda DESC";
	    $agendaArray = mysql_query($queryAgenda, $conexion1) or die(mysql_error());
      $agendaTotalNumero = mysql_num_rows($agendaArray);      
	   	}
  	else {
      mysql_select_db($database_conexion1, $conexion1);
	    $queryAgenda = "select * from agenda where idEmpresa = $cia and requiere = $requiere  ORDER BY idAgenda DESC";
      $agendaArray = mysql_query($queryAgenda, $conexion1) or die(mysql_error());
      $agendaTotalNumero = mysql_num_rows($agendaArray);      
		  }		

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
        <h2>Listado Ordenes <?php echo $empresas["nombreEmpresa"]?></h2>
          <ul data-inset='true' data-role='listview' data-theme='d'>
            <li>
              <form action="EstadoOrdenesAdmin.php" method="post">
                <input type="hidden" id="tipoSolicitud" name="tipoSolicitud" value="2" />
                  <center>
                    <button aria-label='button1' data-theme='chase' name='button1' role='button' type='submit' value='submit' >
                      <span aria-hidden='true'>Volver</span>
                    </button>
                  </center>
              </form>
              <div id="contenedorListadoOrden">           
                <div id="contenidosListadoOrden">
                  <div id="columnaEncbListadoOrden" style="background-color:#EDE4DA;">Numero</div>
                  <div id="columnaEncbListadoOrden" style="background-color:#EDE4DA;">Estado</div>
                  <div id="columnaEncbListadoOrden" style="background-color:#EDE4DA;">Fecha Visita</div>
                  <div id="columnaEncbListadoOrden" style="background-color:#EDE4DA;">Sucursal</div>
                  <div id="columnaEncbListadoOrden" style="background-color:#EDE4DA;">Tecnico</div>
                </div>
            <script type="text/javascript" language="javascript">
              function cargapagina(idAg,requiere){
                if (requiere == 0){
                  window.location ="gestionOrdenesAdmin.php?idAg="+idAg;
                  }
                else{
                  window.location ="gestionOrdenesAdmin2.php?idAg="+idAg;
                  }
                }
           </script>  
    				<?php
			       	$i=1;
		    	    while($agendasRow=mysql_fetch_array($agendaArray)){             
						    $color="FFF";
						    $font="000;";
		    	    	if ($agendasRow["requiere"] == 0){
		    	    		if ($agendasRow["estado"]  == 'Pendiente'){
			    	    		$color="FFFFFF;";
			    	    		}
		    	    		if ($agendasRow["estado"]  == 'Listo'){
			    	    		$color="00FF00;";
			    	    		}
		    	    		}
		    	    	if ($agendasRow["requiere"] == 1){$color="CCC;";}		    	    		
		    	    	if ($agendasRow["requiere"] == 2){$color="FF0000;";$font="FFFFFF;";}		    	    		
		    	    	if ($agendasRow["requiere"] == 3){$color="FF0000;";$font="FFFFFF;";}		    	    		
		    	    	if ($agendasRow["requiere"] == 4){$color="FF0000;";$font="FFFFFF;";}		    	    		
		    	    	if ($agendasRow["requiere"] == 5){$color="FFFFFF;";}
		    	    	if ($agendasRow["requiere"] == 6){$color="FFFF00;";$font="000;";}
		    	    	if ($agendasRow["requiere"] == 7){$color="009B00;";$font="FFFFFF;";}
		    	    	?>  	
                    <div id="contenidosListadoOrden" onclick="cargapagina(<?php echo $agendasRow["idAgenda"];?>,<?php echo $requiere;?>);">
		                  <div id="columnaListadoOrden1" style="background-color:#<?php echo $color;?>;color:#<?php echo $font?>">                        
        		               <?php echo $agendasRow["idAgenda"];?>     
		                    </div>                  
        		            <div id="columnaListadoOrden2" style="background-color:#<?php echo $color;?>;color:#<?php echo $font?>">                          
         		               <?php echo $agendasRow["estado"];?>                     
		                    </div> 
          			        <div id="columnaListadoOrden3" style="background-color:#<?php echo $color;?>;color:#<?php echo $font?>">                         
         		               <?php 
            								  $fechaVisita = new DateTime($agendasRow["fechaVisita"]); 
            								  $fechaVisitaFinal = $fechaVisita->format('d-m-Y');
         		               	  echo $fechaVisitaFinal;
         		                  ?> 
			                </div> 
          			        <div id="columnaListadoOrden4" style="background-color:#<?php echo $color;?>;color:#<?php echo $font?>">                          
         		               <?php 
									            $idSucursal = $agendasRow["idSucursal"];
          								    $querySucursal = "select * from sucursal where idSucursal = $idSucursal";
          								    $sucursalArray = mysql_query($querySucursal, $conexion1) or die(mysql_error());
          								    $sucursales = mysql_fetch_assoc($sucursalArray);
         		               		echo $sucursales["nombreSucursal"];
         		               		?> 
			                </div> 			                
          			        <div id="columnaListadoOrden5" style="background-color:#<?php echo $color;?>;color:#<?php echo $font?>">                          
         		               <?php 
          									  $idTecnico = $agendasRow["idTecnico"];
          								    $queryTecnico = "select * from usuarios where id = $idTecnico";
          								    $tecnicoArray = mysql_query($queryTecnico, $conexion1) or die(mysql_error());
          								    $tecnicos = mysql_fetch_assoc($tecnicoArray);
         		               		echo $tecnicos["nombres"]." ".$tecnicos["apellidos"];
         		               		?>          		               
			                </div> 	             
                		</div> 
             		<?$i++; }?>
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