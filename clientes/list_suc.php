<?php 
 session_start(); 
if (($_SESSION['nivel']==0) &&  ($_SESSION['id']!="") || ($_SESSION['id']==70)){
  	require_once('../Connections/conexion1.php'); 
  	require_once('../funciones.php');
  	$idE = $_GET["idE"];
  	$sql = "SELECT * FROM sucursal  WHERE idEmpresa = $idE ORDER BY nombreSucursal ASC";
  	mysql_select_db($database_conexion1, $conexion1);
  	$result  = mysql_query($sql, $conexion1) or die(mysql_error());

  	$sql2 = "SELECT * FROM empresas  WHERE idEmpresa = $idE";
  	$result2  = mysql_query($sql2, $conexion1) or die(mysql_error());
  	while ($empresas = mysql_fetch_array($result2)){
  		$cia = $empresas["nombreEmpresa"];
  		}
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
    </head>
    <style type="text/css">
    #contenedor{
 		display: table;
		border: 1px solid #D3D3D3;
		width: 100%;
		text-align: center;
		margin: 0 auto;
		}
    #contenidos{
        display: table-row;
        }
    #columnaEncb{
		display: table-cell;
		font-size: 16px;
		border: 1px solid #D3D3D3;
		vertical-align: middle;
		padding: 10px;                   
		}  
    #columna1{
		border: 1px solid #D3D3D3;
		display: table-cell;
		font-size: 14px;
		padding: 10px;
		text-align: center;
		vertical-align: middle;
		width: 7%
		}  
    #columna2{
		border: 1px solid #D3D3D3;
		display: table-cell;
		font-size: 14px;
		padding: 10px;
		text-align: justify;
		vertical-align: middle;
		width: 14%
		}    
    #columna3{
		border: 1px solid #D3D3D3;
		display: table-cell;
		font-size: 14px;
		padding: 10px;
		text-align: justify;
		vertical-align: middle;
		width: 7%
		}   
    </style>
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
          	<h2>Sucursales: "<?= $cia;?>"</h2>
            <ul data-inset='true' data-role='listview' data-theme='d'>
		        <li>
	                <form name="1" action="seleccionarEmpresa.php" method="post">
	                    <center>
	                      <button aria-label='button1' data-theme='chase' name='button1' role='button' type='submit' value='submit' >
	                        <span aria-hidden='true'>Volver</span>
	                      </button>
	                    </center>
	                </form>
		            <div id="contenedor">          	
			            <div id="contenidos">
			                <div id="columnaEncb" style="background-color:#EDE4DA;">#</div>
			                <div id="columnaEncb" style="background-color:#EDE4DA;">Nombre</div>
	                    <? if ($_SESSION['id']!=70){?>  
			                <div id="columnaEncb" style="background-color:#EDE4DA;"></div>
			            <?}?>    
			                <div id="columnaEncb" style="background-color:#EDE4DA;"></div>
	                    <? if ($_SESSION['id']!=70){?>  
			                <div id="columnaEncb" style="background-color:#EDE4DA;"></div>
						<?}?>			            
			            </div>
		                <?php
		                	$i=1;
		    	            while($rowSucursal=mysql_fetch_assoc($result)){
		    	            	$idSucursal = $rowSucursal["idSucursal"];
		    		            if ($i%2==0){ $color="EDE4BA;";}
		                    else{ $color="FFF;";}
		    		            ?>
		                	<div id="contenidos">
		                  		<div id="columna1" style="background-color:#<?php echo $color;?>">                  			
				                	<?php echo $i;?>
				                </div>                  
		    	          		<div id="columna2" style="background-color:#<?php echo $color;?>">                  			
				                	<?php echo strtoupper($rowSucursal["nombreSucursal"])."&nbsp;".strtoupper($rowCliente["apellidos"]); ?>
				                </div>   
		                    <? if ($_SESSION['id']!=70){?>               
		    	          		<div id="columna3" style="background-color:#<?php echo $color;?>">                  			
				        			<form name="1" action="editSucursal.php" method="post">
										<input type="hidden" name="idSucursal" id="idSucursal" value="<?php echo $rowSucursal["idSucursal"];?>">
								        <center>
 											<button aria-label='button1' data-theme='chase' name='button1' role='button' type='submit' value='submit' >
              									<span aria-hidden='true'>Editar</span>
          									</button>
										</center>
									</form>
				                </div>
				            <?}?>                  
		    	          		<div id="columna3" style="background-color:#<?php echo $color;?>">                  			
									<form name="2" action="list_bul.php?idS=<?= $idSucursal;?>" method="post">
								        <center>
 											<button aria-label='button1' data-theme='chase' name='button1' role='button' type='submit' value='submit' >
              									<span aria-hidden='true'>Edificios</span>
          									</button>
										</center>
									</form>		
				                </div>     
		                    <? if ($_SESSION['id']!=70){?>  				                                                            
		    	          		<div id="columna3" style="background-color:#<?php echo $color;?>">                  			
									<form name="2" action="newBuilding.php" method="post">
										<input type="hidden" name="idSucursal" id="idSucursal" value="<?php echo $rowSucursal["idSucursal"];?>">
										<input type="hidden" name="idEmpresa" id="idEmpresa" value="<?php echo $rowSucursal["idEmpresa"];?>">
								        <center>
 											<button aria-label='button1' data-theme='chase' name='button1' role='button' type='submit' value='submit' >
              									<span aria-hidden='true'>Nuevo</span>
          									</button>
										</center>
									</form>		
				                </div> 
				             <?}?>
		                	</div>  
		                <?php $i++; } ?>  
		            </div>	 
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