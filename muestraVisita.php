<?php session_start(); 
if ($_SESSION['idEmpresa']!="" ){
  if ($_GET["idM"]==""){
    $exitGoTo="menu.php";
    header(sprintf("Location: %s", $exitGoTo));   
    }
  $idVista = $_GET["idM"];  
  $cia=$_SESSION['idEmpresa'];
  require_once('Connections/conexion1.php'); 
  require_once('funciones.php');  
  mysql_select_db($database_conexion1, $conexion1);
  $sql="Select * from agenda where idAgenda = $idVista";
  $agenda = mysql_query($sql, $conexion1) or die(mysql_error());
  $row_agenda = mysql_fetch_assoc($agenda);
  $solicitud = $row_agenda['idAgenda'];    
  $idUsuario = $row_agenda['idusuario'];
  $fechaSolicitud = new DateTime($row_agenda['fecha']); 
  $fechaSolicitudFinal = $fechaSolicitud->format('d-m-Y');
  if ($row_agenda['fechaVisita'] == '0000-00-00 00:00:00'){
    $fechaVisitaFinal = "Sin efectuar";
    }
  else{  
    $fechaVisita = new DateTime($row_agenda['fechaVisita']); 
    $fechaVisitaFinal = $fechaVisita->format('d-m-Y');
    }
  $tipoSolicitud = $row_agenda['tipoSolicitud'];  
  switch($tipoSolicitud){
    case '1':$tipoSolicitudFinal="Visita Tecnica"; break;
    case '2':$tipoSolicitudFinal="Visita Comercial"; break;
    }
  $estado = $row_agenda['estado'];  
  $equipo = $row_agenda['nroEquipo'];  
  $comen1 = $row_agenda['comentario1'];  
  if ($comen1 == 1) {$coment1 = "Equipo gotea";}
  if ($comen1 == 2) {$coment1 = "Equipo no enciende";}
  if ($comen1 == 3) {$coment1 = "Equipo no enfría";}
  if ($comen1 == 4) {$coment1 = "Equipo emite ruido";}
  if ($comen1 == 5) {$coment1 = "Otro";}        
  if ($comen1 == 6) {$coment1 = "Equipo no genera calor";}
  $comen2 = $row_agenda['comentario2'];  
  if ($comen2 == 1) {$coment2 = "Equipo gotea";}
  if ($comen2 == 2) {$coment2 = "Equipo no enciende";}
  if ($comen2 == 3) {$coment2 = "Equipo no enfría";}
  if ($comen2 == 4) {$coment2 = "Equipo emite ruido";}
  if ($comen2 == 5) {$coment2 = "Otro";}        
  if ($comen2 == 6) {$coment2 = "Equipo no genera calor";}
  $comen3 = $row_agenda['comentario3'];  
  if ($comen3 == 1) {$coment3 = "Equipo gotea";}
  if ($comen3 == 2) {$coment3 = "Equipo no enciende";}
  if ($comen3 == 3) {$coment3 = "Equipo no enfría";}
  if ($comen3 == 4) {$coment3 = "Equipo emite ruido";}
  if ($comen3 == 5) {$coment3 = "Otro";}        
  if ($comen3 == 6) {$coment3 = "Equipo no genera calor";}
  $comentaTect = $row_agenda['comentario'];  
  $idSucursal = $row_agenda['idSucursal'];  

  mysql_select_db($database_conexion1, $conexion1);
  $query_Sucursal1 = "SELECT * FROM sucursal where  idSucursal = $idSucursal";
  $Sucursal1 = mysql_query($query_Sucursal1, $conexion1) or die(mysql_error());
  $row_Sucursal1 = mysql_fetch_assoc($Sucursal1);
  ?>
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
                <a class='top-left-link home' data-icon='home' href='menu.php'>Inicio</a>
            </div>
            <div class='content' data-role='content'>
              <h2>
                Resumen de solicitud
              </h2>

              <ul data-inset='true' data-role='listview' data-theme='d'>
                <li>
                  <form name="1" action="historicoReparaciones.php" method="post">
                    <input type="hidden" name="idSucursal" id="idSucursal" value="<?php echo $_GET['sucursal']; ?>"  />
                    <input name="nroEquipo" type="hidden" id="nroEquipo" value="<?php echo $_GET["idE"];?>" />
                    <center>
                      <button aria-label='button1' data-theme='chase' name='button1' role='button' type='submit' value='submit' >
                        <span aria-hidden='true'>Volver Listado</span>
                      </button>
                    </center>
                  </form>
                  <div id="contenedor">
                    <div id="contenidos">
                      <div id="columna1">
                        Fecha de solicitud
                      </div>
                      <div id="columna2">
                        <?php echo $fechaSolicitudFinal;?>
                      </div>              
                    </div>
                    <div id="contenidos">
                      <div id="columna1">
                        Fecha Visita
                      </div>
                      <div id="columna2">
                        <?php echo $fechaVisitaFinal;?>
                      </div>              
                    </div>       
                    <div id="contenidos">
                      <div id="columna1">
                        Tipo de solicitud
                      </div>
                      <div id="columna2">
                        <?php echo strtoupper($tipoSolicitudFinal);?>
                      </div>              
                    </div>   
                    <div id="contenidos">
                      <div id="columna1">
                        Estado
                      </div>
                      <div id="columna2">
                        <?php echo strtoupper($estado);?>
                      </div>              
                    </div>       
                    <div id="contenidos">
                      <div id="columna1">
                        Solicitado por
                      </div>
                      <div id="columna2">
                        <?php echo devuelveNombre($idUsuario,'usuarios','id','nombres').' '.devuelveNombre($idUsuario,'usuarios','id','apellidos');?>
                      </div>              
                    </div> 
                    <div id="contenidos">
                      <div id="columna1">
                        Sucursal
                      </div>
                      <div id="columna2">
                        <?php echo strtoupper($row_Sucursal1['nombreSucursal']);?>
                      </div>              
                    </div> 
                    <div id="contenidos">
                      <div id="columna1">
                        Nro. Equipo
                      </div>
                      <div id="columna2">
                        <?php echo $equipo;?>
                      </div>              
                    </div> 
                    <div id="contenidos">
                      <div id="columna1">
                        Comentario Cliente 1
                      </div>
                      <div id="columna2">
                        <?php echo strtoupper($coment1);?>                       
                      </div>                                    
                    </div> 
                    <div id="contenidos">
                      <div id="columna1">
                        Comentario Cliente 2
                      </div>
                      <div id="columna2">
                        <?php echo strtoupper($coment2);?>                                             </div>              
                    </div> 
                    <div id="contenidos">
                      <div id="columna1">
                        Comentario Cliente 3
                      </div>
                      <div id="columna2">
                        <?php echo strtoupper($coment3);?>                       
                      </div>              
                    </div> 
                    <div id="contenidos">
                      <div id="columna1">
                        Comentario Técnico
                      </div>
                      <div id="columna2">
                        <?php echo strtoupper($comentaTect);?>                       
                      </div>              
                    </div>
                  </div>  
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