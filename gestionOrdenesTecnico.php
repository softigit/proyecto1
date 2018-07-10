<?php session_start(); 
  if ($_SESSION['nivel']==1){
    if ($_GET["idAg"]==""){
      $exitGoTo="EstadoOrdenesTecnico.php";
      header(sprintf("Location: %s", $exitGoTo));   
      }
	  $idAgenda=$_GET["idAg"];
	  $idUsuario=$_SESSION['id'];
    require_once('Connections/conexion1.php'); 
    require_once('funciones.php');
    mysql_select_db($database_conexion1, $conexion1);
    $queryAgenda = "select * from agenda where idAgenda = $idAgenda";
    $agendaArray = mysql_query($queryAgenda, $conexion1) or die(mysql_error());
    $agendas = mysql_fetch_assoc($agendaArray);
    //observaciones
    $queryUsuario = "select * from usuarios where id = $idUsuario";
    $usuarioArray = mysql_query($queryUsuario, $conexion1) or die(mysql_error());
    $usuarios = mysql_fetch_assoc($usuarioArray);
    $nombreUsuario=$usuarios['nombres']." ".$usuarios['apellidos'];    

    $queryObservaciones = "select * from agenda_observaciones where agenda_id = $idAgenda";
    $observacionesArray = mysql_query($queryObservaciones, $conexion1) or die(mysql_error());
    $acc = 1;
    while ($row = mysql_fetch_array($observacionesArray)){
      $fecha = date("d-m-Y",strtotime($row["fecha"]));
      $userObserva = $row["usuario_id"];
      $queryUsuario = "select * from usuarios where id = $userObserva";
      $usuarioArray = mysql_query($queryUsuario, $conexion1) or die(mysql_error());
      $usuarios = mysql_fetch_assoc($usuarioArray);
      $nombreUsuarioObserva=$usuarios['nombres']." ".$usuarios['apellidos'];    

      if ($row["observacion"] == 'CAMBIO DE ESTADO'){
          $observa .= $acc."- CAMBIO DE ESTADO HECHO EL ".$fecha." POR ".$nombreUsuarioObserva."<br/>";
        }
      else{
          if (($row["observacion"] == 'CAMBIO DE TECNICO') || ($row["observacion"] == 'CAMBIO DE NUMERO') ){
          $observa .= $acc."- ".strtoupper($row["observacion"])." HECHO EL ".$fecha." POR ".$nombreUsuarioObserva."<br/>";
            }
          else {    
              $observa .= $acc."- ".strtoupper($row["observacion"])." HECHA EL ".$fecha." POR ".$nombreUsuarioObserva."<br/>";
              }
          } 

      $acc++;
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
            <a class='top-left-link home' data-icon='home' href='menuTecnico.php'>Inicio</a>
          </div>
          <div class='content' data-role='content'>
            <h2>Orden de Visita: <?php echo $agendas["idAgenda"];?></h2>
            <ul data-inset='true' data-role='listview' data-theme='d'>
              <li>
                <form action="listadoOrdenesTecnico.php?req=0" method="post">
                  <center>
                    <button aria-label='button1' data-theme='chase' name='button1' role='button' type='submit' value='submit' >
                      <span aria-hidden='true'>Volver</span>
                    </button>
                  </center>
                </form>
              </li>
            </ul>
               <ul data-inset='true' data-role='listview' data-theme='d'>
                  <script language="javascript" type="text/javascript">
                    function confirmar(){
                  	  var txt;
                      var r = confirm("Desea Cambiar el estado");
                      if (r == true) {
                    		form1.submit();
                        txt = "You pressed OK!";} 
                      else {
                        txt = "You pressed Cancel!";
                      }
                    }
              		</script>
                  <li>
                    <?php  
                      $fechaVisita = new DateTime($agendas["fechaVisita"]); 
                      $fechaVisitaFinal = $fechaVisita->format('d-m-Y');
                      ?>
                    Fecha: <?php echo $fechaVisitaFinal;?>
                  </li>
                  <li>
                     Jornada: <?php echo $agendas["jornadaVisita"];?>
                  </li>
                  <li>
                    Empresa:
                      <?php 
                        $idEmpresa = $agendas["idEmpresa"];
                        $queryEmpresa = "select * from empresas where idEmpresa = $idEmpresa";
                        $EmpresaArray = mysql_query($queryEmpresa, $conexion1) or die(mysql_error());
                        $empresas = mysql_fetch_assoc($EmpresaArray);
                        echo $empresas["nombreEmpresa"];                      
                        ?>
                  </li>                    
                  <li>
                    Sucursal:
                      <?php 
                        $idSucursal = $agendas['idSucursal'];
                        $query_Sucursal1 = "SELECT * FROM sucursal where  idSucursal=$idSucursal";
                        $Sucursal1 = mysql_query($query_Sucursal1, $conexion1) or die(mysql_error());
                        $row_Sucursal1 = mysql_fetch_assoc($Sucursal1);      
                        echo $row_Sucursal1['nombreSucursal'];
                        ?>
                  </li>
                  <li>
                    Responsable:
                      <?php 
                        $idUsuarioConfirma = $agendas['idUsuarioConfirma'];
                        $query_usuarios = "SELECT * FROM usuarios where  id=$idUsuarioConfirma";
                        $usuarios = mysql_query($query_usuarios, $conexion1) or die(mysql_error());
                        $row_usuarios = mysql_fetch_assoc($usuarios);      
                        echo $row_usuarios['nombres']." ".$row_usuarios['apellidos'];
                        ?>
                  </li>               
                  <li>
                    <?php
                    if ($agendas['nroEquipo'] == 99999){
                       echo "Nro. Equipo: No informado";
                       ?>
                      <form action="editaNumeroTecnico.php" method="post">
                        <input type="hidden" name="idsucursal" value="<?php echo $agendas['idSucursal']?>">
                        <input type="hidden" name="idorden" value="<?php echo $agendas['idAgenda']?>">
                        <center>
                          <button aria-label='button1' data-theme='chase' name='button1' role='button' type='submit' value='submit' >
                            <span aria-hidden='true'>Editar Numero</span>
                          </button>
                        </center>
                      </form>
                       <?php                       
                      }
                    else{
                      echo "Nro. Equipo: ".$agendas['nroEquipo'];
                      }
                    ?>              
                  </li>
                  <li> Comentario 1:
                    <?php 
                      $com1 = $agendas['comentario1'];
                      switch ($com1) {
                        case '1': $com1Final = "Equipo gotea"; break;
                        case '2': $com1Final = "Equipo no enciende"; break;
                        case '3': $com1Final = "Equipo no enfria"; break;
                        case '4': $com1Final = "Equipo emite ruido"; break;
                        case '5': $com1Final = "Otro"; break;
                        case '6': $com1Final = "Equipo no genera calor"; break;
                        }
                      echo $com1Final    
                    ?>
                  </li>
                  <li> Comentario 2:
                    <?php 
                      $com2 = $agendas['comentario2'];
                      switch ($com2) {
                        case '1': $com2Final = "Equipo gotea"; break;
                        case '2': $com2Final = "Equipo no enciende"; break;
                        case '3': $com2Final = "Equipo no enfria"; break;
                        case '4': $com2Final = "Equipo emite ruido"; break;
                        case '5': $com2Final = "Otro"; break;
                        case '6': $com2Final = "Equipo no genera calor"; break;
                        }
                      echo $com2Final    
                    ?>
                  </li>
                  <li> Comentario 3:
                    <?php 
                      $com3 = $agendas['comentario3'];
                      switch ($com3) {
                        case '1': $com3Final = "Equipo gotea"; break;
                        case '2': $com3Final = "Equipo no enciende"; break;
                        case '3': $com3Final = "Equipo no enfria"; break;
                        case '4': $com3Final = "Equipo emite ruido"; break;
                        case '5': $com3Final = "Otro"; break;
                        case '6': $com3Final = "Equipo no genera calor"; break;
                        }
                      echo $com3Final    
                    ?>
                  </li>
                  <li>
                    Comentarios: <?php echo $agendas['comentario'];?>
                  </li>
                </ul> 
                <form action="generarVisita4Fin.php" method="post" name="form1" id="form1">
                <ul data-inset='true' data-role='listview' data-theme='d'>
                  <li>
                    Observaciones<br/><br/>
                    <?= $observa; ?>
                    <br/>
                  </li>
                  <li> 
                    Nueva Observacion
                    <input name="observa" placeholder="Ingrese una Observacion"/>                               
                    </input>
                  </li>
                  <li>
                    Estado
                    <?php $r = $agendas["requiere"];?>
                    <select name="requiere">
                      <option value="1" <?if($r==1){?>selected<?}?>>
                        En espera de Tecnico
                      </option>
                      <option value="2" <?if($r==2){?>selected<?}?>>
                        Pendiente de aprobacion
                      </option>
                      <option value="3" <?if($r==3){?>selected<?}?>>
                        Pendiente de Cotizacion
                      </option>
                      <option value="4" <?if($r==4){?>selected<?}?>>
                        Listo y Pendiente Cotizacion
                      </option>
                      <option value="5" <?if($r==5){?>selected<?}?>>
                        Listo para Comenzar
                      </option>
                      <option value="6" <?if($r==6){?>selected<?}?>>
                        En proceso
                      </option>
                      <option value="7" <?if($r==7){?>selected<?}?>>
                        Listo
                      </option>
                    </select>
                  </li>
                  <li>  
                    <input type="hidden" name="idAgenda" value="<?php echo $agendas["idAgenda"];?>"/>
                    <input name="button" type="button" data-theme='chase' id="button" onclick="confirmar();" value="Cambiar Estado" />
                  </li>     
              </ul>
            </form>
          </div>     
        </body>
      </html>
<?php
  } else {
  	$exitGoTo="index.php";
	  header(sprintf("Location: %s", $exitGoTo));  
    }
	?>