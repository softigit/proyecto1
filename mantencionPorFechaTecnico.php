<?php
  session_start(); 
  if ($_SESSION['idEmpresa']!="" ){
		 $cia=$_SESSION['idEmpresa'];
    require_once('Connections/conexion1.php'); 
    require_once('funciones.php');
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
          <h2>Búsqueda por Fecha</h2>
          <ul data-inset='true' data-role='listview' data-theme='d'>
            <li>
              <form action="menuTecnico2.php" method="post" name="form3" id="form3">
                 <button aria-label='button1' data-theme='chase' name='button1' role='button' type="submit">
                    <span aria-hidden='true'>MENU MANTENCIONES</span>
                  </button>
              </form>  
            </li>
            <li>
              <?php if (!isset($_POST['mes'])){ ?>
              <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="form3" id="form3">
                <select name="mes" id="mes">
                  <?php
		                $now = time(); 
                    $monthnum = date("m", $now); 
        		        switch($monthnum){
              			  case "01" : 
                        $stringmonth = "Enero"; 
                        break;
                      case "02" : 
                        $stringmonth = "Febrero"; 
                        break;
                      case "03" : 
                        $stringmonth = "Marzo"; 
                        break;
                      case "04" : 
                        $stringmonth = "Abril"; 
                        break;
                      case "05" : 
                        $stringmonth = "Mayo"; 
                        break;
                      case "06" : 
                        $stringmonth = "Junio"; 
                        break;
                      case "07" : 
                        $stringmonth = "Julio"; 
                        break;
                      case "08" : 
                        $stringmonth = "Agosto"; 
                        break;
                      case "09" : 
                        $stringmonth = "Septiembre"; 
                        break;
                      case "10" : 
                        $stringmonth = "Octubre"; 
                        break;
                      case "11" : 
                        $stringmonth = "Noviembre"; 
                        break;
                      case "12" : 
                        $stringmonth = "Diciembre";  
                        break;       			  
        		          }
		              ?>
                  <option value="<?php echo $monthnum ;?>"><?php echo $stringmonth; ?></option>
                  <option value="01">Enero</option>
                  <option value="02">Febrero</option>
                  <option value="03">Marzo</option>
                  <option value="04">Abril</option>
                  <option value="05">Mayo</option>
                  <option value="06">Junio</option>
                  <option value="07">Julio</option>
                  <option value="08">Agosto</option>
                  <option value="09">Septiembre</option>
                  <option value="10">Octubre</option>
                  <option value="11">Noviembre</option>
                  <option value="12">Diciembre</option>
                </select>
                <? $year = date("Y", $now);?> 
                <select name="anio" id="anio">
                  <option value="2020" <? if($year == 2020){?>selected="selected"<?}?>>2020</option>
                  <option value="2019" <? if($year == 2019){?>selected="selected"<?}?>>2019</option>
                  <option value="2018" <? if($year == 2018){?>selected="selected"<?}?>>2018</option>
                  <option value="2017" <? if($year == 2017){?>selected="selected"<?}?>>2017</option>
                  <option value="2016" <? if($year == 2016){?>selected="selected"<?}?>>2016</option>
                  <option value="2015">2015</option>
                  <option value="2014">2014</option>
                  <option value="2013">2013</option>
                </select>
                <select name="idSucursal" >
                  <?php 
                    mysql_select_db($database_conexion1, $conexion1);
                    $query_Sucursal1 = "SELECT * FROM sucursal where  idEmpresa='$cia' ORDER BY nombreSucursal ASC";
                    $Sucursal1 = mysql_query($query_Sucursal1, $conexion1) or die(mysql_error());
                    $numeroSucursal = mysql_num_rows($Sucursal1);
                    $row_Sucursal1 = mysql_fetch_assoc($Sucursal1);
                    if ($_POST["idSucursal"]!= ""){  
                      $sucursal=$_POST["idSucursal"];
      	              echo "<option value='".$sucursal."' SELECTED>".devuelveNombre($sucursal,'sucursal','idSucursal','nombreSucursal')."</option>";
                      }
                    do {  
                      ?>
                      <option value="<?php echo $row_Sucursal1['idSucursal']?>" ><?php echo $row_Sucursal1['nombreSucursal'];?></option>
                      <?php
                      } 
                    while ($row_Sucursal1 = mysql_fetch_assoc($Sucursal1));
                    ?>
                    <option value="T">Todas</option>
                </select>
                <center>
                  <button aria-label='button1' data-theme='chase' name='button1' role='button' type='submit' value='submit' >
                      <span aria-hidden='true'>Buscar</span>
                  </button>
                </center>
              </form>
              <?php } 
              else { 
              ?> 
              <li>
                <form action="mantencionPorFechaTecnico.php" method="post" name="form3" id="form3">
                  <button aria-label='button1' data-theme='chase' name='button1' role='button' type="submit">
                    <span aria-hidden='true'>VOLVER</span>
                  </button>
                </form>                
              </li> 
              <?
              $mes= $_POST['mes'];
              $anio = $_POST['anio'];
              $idSucursal=$_POST["idSucursal"];
              $periodo = "";
                if ($idSucursal == 27){
                  if ($mes == 1){
                    $periodo = "ENERO DE ".$anio;
                    $bManIni = $anio."-01-01";
                    $bManFni = $anio."-01-31";
                    }
                  if ($mes == 2){
                    $periodo = "FEBRERO DE ".$anio;
                    $bManIni = $anio."-02-01";
                    $bManFni = $anio."-02-29";
                    }
                  if ($mes == 3){
                    $periodo = "MARZO DE ".$anio;
                    $bManIni = $anio."-03-01";
                    $bManFni = $anio."-03-31";
                    }
                  if ($mes == 4){
                    $periodo = "ABRIL DE ".$anio;
                    $bManIni = $anio."-04-01";
                    $bManFni = $anio."-04-30";
                    }
                  if ($mes == 5){
                    $periodo = "MAYO DE ".$anio;
                    $bManIni = $anio."-05-01";
                    $bManFni = $anio."-05-31";
                    }
                  if ($mes == 6){
                    $periodo = "JUNIO DE ".$anio;
                    $bManIni = $anio."-06-01";
                    $bManFni = $anio."-06-30";
                    }
                  if ($mes == 7){
                    $periodo = "JULIO DE ".$anio;
                    $bManIni = $anio."-07-01";
                    $bManFni = $anio."-07-31";
                    }
                  if ($mes == 8){
                    $periodo = "AGOSTO DE ".$anio;
                    $bManIni = $anio."-08-01";
                    $bManFni = $anio."-08-31";
                    }
                  if ($mes == 9){
                    $periodo = "SEPTIEMBRE DE ".$anio;
                    $bManIni = $anio."-09-01";
                    $bManFni = $anio."-09-30";
                    }
                  if ($mes == 10){
                    $periodo = "OCTUBRE DE ".$anio;
                    $bManIni = $anio."-10-01";
                    $bManFni = $anio."-10-31";
                    }
                  if ($mes == 11){
                    $periodo = "NOVIEMBRE DE ".$anio;
                    $bManIni = $anio."-11-01";
                    $bManFni = $anio."-11-30";
                    }
                  if ($mes == 1){
                    $periodo = "DICIEMBRE DE ".$anio;
                    $bManIni = $anio."-12-01";
                    $bManFni = $anio."-12-31";
                    }
                  }
                else{
                  if (($mes == 1) || ($mes == 2) || ($mes == 3)){
                    $periodo = "PRIMER TRIMESTRE";
                    $bManIni = $anio."-01-01";
                    $bManFni = $anio."-03-31";
                    }
                  if (($mes == 4) || ($mes == 5) || ($mes == 6)){
                    $periodo = "SEGUNDO TRIMESTRE";
                    $bManIni = $anio."-04-01";
                    $bManFni = $anio."-06-30";
                    }
                  if (($mes == 7) || ($mes == 8) || ($mes == 9)){
                    $periodo = "TERCER TRIMESTRE";
                    $bManIni = $anio."-07-01";
                    $bManFni = $anio."-09-30";
                    }
                  if (($mes == 10) || ($mes == 11) || ($mes == 12)){
                    $periodo = "CUARTO TRIMESTRE";
                    $bManIni = $anio."-10-01";
                    $bManFni = $anio."-12-31";
                    }
                  }  
              mysql_select_db($database_conexion1, $conexion1);             
              $bequipo = "SELECT * FROM edificio as ed,equipo as eq WHERE eq.idEdificio = ed.idEdificio and ed.idSucursal = $idSucursal ORDER BY eq.idEdificio,nroEquipo ASC"; 
              $buscaEquipoEdiSucrsual = mysql_query($bequipo,$conexion1)  or die(mysql_error());
              $buscaEquipoEdiSucrsual2 = mysql_query($bequipo,$conexion1)  or die(mysql_error());
              $equiposTotalSucursal = mysql_num_rows($buscaEquipoEdiSucrsual);
              $bsucursal = "SELECT * FROM sucursal where  idEmpresa='$cia' and idSucursal = $idSucursal";
              $Sucursal1 = mysql_query($bsucursal, $conexion1) or die(mysql_error());
              while ($rowSucursal1 = mysql_fetch_array($Sucursal1)){
                $nombreSucursal = $rowSucursal1["nombreSucursal"];
                }
              $noHecha = 0;
              $hecha = 0;
              $observa = 0;
              while ($rowEquipo2 = mysql_fetch_array($buscaEquipoEdiSucrsual2)){
                  $mantencion2 = 0;
                  $idEq = $rowEquipo2["idEquipo"];
                  $bMantencion2 = mysql_query("SELECT * FROM mantencion WHERE idEquipo = $idEq and (fecha BETWEEN '$bManIni' AND '$bManFni')",$conexion1);
                  while ($rowMan2 = mysql_fetch_array($bMantencion2)){
                    $mantencion2 = $rowMan2["idmantencion"];
                    }
                  $bMantencionObser = mysql_query("SELECT * FROM mantencion WHERE idEquipo = $idEq and (fecha BETWEEN '$bManIni' AND '$bManFni') and observacion != ''",$conexion1);          
                  while ($rowManObs = mysql_fetch_array($bMantencionObser)){
                      $observa = $observa + 1;                      
                      }

                    if ($mantencion2 == 0){                    
                      $noHecha = $noHecha + 1;  
                      }
                    else{
                      $hecha = $hecha + 1;  
                      }
                  }
              ?>
              <li>
                <div id="contenedor">
                  <div id="columna1" style="background-color:#EDE4DA;">
                    PERIODO
                  </div>
                  <div id="columna2" style="background-color:#FFF;">
                    <?= $periodo;?>
                  </div> 
                </div> 

                <div id="contenedor">
                  <div id="columna1" style="background-color:#EDE4DA;">
                    SUCURSAL
                  </div>
                  <div id="columna2" style="background-color:#FFF;">
                    <?= strtoupper($nombreSucursal);?>
                  </div> 
                </div> 
                <div id="contenedor">                          
                  <div id="columna1" style="background-color:#EDE4DA;">
                    EQUIPOS  
                  </div>
                  <div id="columna2" style="background-color:#FFF;">
                    <?= $equiposTotalSucursal;?>   
                  </div>  
                </div>                                  
                <div id="contenedor">                          
                  <div id="columna1" style="background-color:#EDE4DA;">
                    MANTEN. HECHAS  
                  </div>
                  <div id="columna2" style="background-color:#FFF;">
                    <?= $hecha;?>   
                  </div>  
                </div> 
                <div id="contenedor">                          
                  <div id="columna1" style="background-color:#EDE4DA;">
                     MANTEN. FALTANTES  
                  </div>
                  <div id="columna2" style="background-color:#FFF;">
                    <?= $noHecha;?>   
                  </div>  
                </div> 
                <div id="contenedor">                          
                  <div id="columna1" style="background-color:#EDE4DA;">
                    INFORME EXCEL 
                  </div>
                  <div id="columna2" style="background-color:#FFF;">
                    <? 
                      if ($hecha == 0){
                        echo 'NO EXISTE INFORME';
                        }
                      else{    
                        if ($idSucursal == 27){
                          echo '<p align="center"><a target="_blank" href="mantencionPorFecha_excel.php?mes='.$mes.'&anio='.$anio.'&idSucursal='.$idSucursal.'"><img src="lib/images/excel_icon.png" width="31" height="31" /></a>';
                          }
                        else {
                          echo '<p align="center"><a target="_blank" href="mantencionPorFecha_excelTrimestral.php?mes='.$mes.'&anio='.$anio.'&idSucursal='.$idSucursal.'"><img src="lib/images/excel_icon.png" width="31" height="31" /></a>';
                          }
                      }      
                      ?>
                  </div>  
                </div> 
                <div id="contenedor">                          
                  <div id="columna1" style="background-color:#EDE4DA;">
                    EQUIPOS OBSERVADOS  
                  </div>
                  <div id="columna2" style="background-color:#FFF;">
                    <?= $observa;?>   
                  </div>  
                </div> 
                <div id="contenedor">                          
                  <div id="columnaSuperTecnico" style="background-color:#EDE4DA;">
                    <div id='equipoVerde2'>OK</div> 
                  </div>  
                  <div id="columnaSuperTecnico" style="background-color:#EDE4DA;">
                    <div id='equipoRojo2'>OBS</div>  
                  </div>                                        
                  <div id="columnaSuperTecnico" style="background-color:#EDE4DA;">
                    <div id='equipoAmarillo2'>PEND</div>  
                  </div>
                  <div id="columnaSuperTecnico" style="background-color:#EDE4DA;">
                    <div id='equipoAnaranjado2'>PEND FOTO</div>  
                  </div>
                </div> 
              </li>
              <? 
              $i = 0;
              echo '<li>';
              echo '<div id="contenidos0">';
              $idEdi = 0;
              $switchMe = 1;
              while ($rowEquipo = mysql_fetch_array($buscaEquipoEdiSucrsual)){
                  $i++;
                  $mantencion = 0;
                  $idEq = $rowEquipo["idEquipo"];
                  if (($idEdi != $rowEquipo["idEdificio"])){
                    $switchMe = 1;
                    echo '<br/><br/>';
                    }
                  if ($switchMe == 1){
                    echo 'EDIFICIO '.$rowEquipo["nombreEdificio"].'<br/></br>';                  //echo "SELECT * FROM mantencion WHERE idEquipo = $idEq and fecha between '$bManIni' and '$bManFni'";
                    $idEdi = $rowEquipo["idEdificio"];
                    $switchMe = 0;
                    }
                  $bMantencion = mysql_query("SELECT * FROM mantencion WHERE idEquipo = $idEq and (fecha BETWEEN '$bManIni' AND '$bManFni')",$conexion1);
                  while ($rowMan = mysql_fetch_array($bMantencion)){
                    $mantencion   = $rowMan["idmantencion"];
                    $obserMuestra = $rowMan["observacion"];
                    $foto1 = $rowMan["foto1"];
                    $foto2 = $rowMan["foto2"];
                    $fotoPend = 0;
                    if (($foto1 == null) || ($foto2 == null)){
                      $fotoPend = 1;
                      }
                    }
                    if ($mantencion == 0){
                      //<div id="columna1" style="background-color:#EDE4DA;">
                      echo "<div id='equipoAmarillo'><a href='http://www.myu.cl/intranet/ingresaMantencionTecnico.php?&idE=".$rowEquipo['idEquipo']."&sucursal=".$rowEquipo['idSucursal']."&mes=".$mes."&anio=".$anio."'>".$rowEquipo["nroEquipo"]."</a></div>";
                      echo "&nbsp;&nbsp;&nbsp;";
                      }
                    else{ 
                        if ($obserMuestra != ''){
                          if ($fotoPend == 0){
                            echo "<div id='equipoRojo'><a href='http://www.myu.cl/intranet/mantencionPorFecha2.php?idM=".$mantencion."&idE=".$rowEquipo['idEquipo']."&sucursal=".$rowEquipo['idSucursal']."&mes=".$mes."&anio=".$anio."'>".$rowEquipo["nroEquipo"]."</a></div>";
                            echo "&nbsp;&nbsp;&nbsp;"; 
                            }
                          if ($fotoPend == 1){
                            echo "<div id='equipoAnaranjado'><a href='http://www.myu.cl/intranet/ingresaMantencionTecnico3.php?idM=".$mantencion."&idE=".$rowEquipo['idEquipo']."&sucursal=".$rowEquipo['idSucursal']."&mes=".$mes."&anio=".$anio."'>".$rowEquipo["nroEquipo"]."</a></div>";
                            echo "&nbsp;&nbsp;&nbsp;"; 
                            }                                                     
                          }
                        else{
                          if ($fotoPend == 0){
                            echo "<div id='equipoVerde'><a href='http://www.myu.cl/intranet/mantencionPorFecha2.php?idM=".$mantencion."&idE=".$rowEquipo['idEquipo']."&sucursal=".$rowEquipo['idSucursal']."&mes=".$mes."&anio=".$anio."'>".$rowEquipo["nroEquipo"]."</a></div>";
                            echo "&nbsp;&nbsp;&nbsp;"; 
                            }
                          if ($fotoPend == 1){
                            echo "<div id='equipoAnaranjado'><a href='http://www.myu.cl/intranet/ingresaMantencionTecnico3.php?idM=".$mantencion."&idE=".$rowEquipo['idEquipo']."&sucursal=".$rowEquipo['idSucursal']."&mes=".$mes."&anio=".$anio."'>".$rowEquipo["nroEquipo"]."</a></div>";
                            echo "&nbsp;&nbsp;&nbsp;"; 
                            }  
                          }
                      }
                  $idEdi = $rowEquipo["idEdificio"];
                  }
                } ?>
              </li>
            </ul>
          </div>       
        </div>     
      </body>
    </html>
<?php
  } 
  else {
	  $exitGoTo="index.php";
	  header(sprintf("Location: %s", $exitGoTo));  
    }
	?>