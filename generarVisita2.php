<?php session_start(); 
  if ($_SESSION['idEmpresa']!="" ){
	  if ($_POST["tipoSolicitud"]==""){
	    $exitGoTo="menuAdministrador.php";
	    header(sprintf("Location: %s", $exitGoTo));  	
	    }
	  $tipoSolicitud=$_POST["tipoSolicitud"];
	  switch($tipoSolicitud){
		  case '1':$solicitud="Visita Técnica"; break;
		  case '2':$solicitud="Visita Comercial"; break;
	    }
	  $cia=$_SESSION['idEmpresa'];
	  $idUsuario=$_SESSION['id'];
    require_once('Connections/conexion1.php'); 
    require_once('funciones.php');
    $seleccion=0;
    $dia_manana = date('d',time()+84600);
    $mes_manana = date('m',time()+84600);
    $ano_manana = date('Y',time()+84600);
    $fecha_manana=$ano_manana.'-'.$mes_manana.'-'.$dia_manana;
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
            <ul data-inset='true' data-role='listview' data-theme='d'>
              <li>
                <form action="ordenVisita2.php" method="post">
                  <center>
                    <button aria-label='button1' data-theme='chase' name='button1' role='button' type='submit' value='submit' >
                      <span aria-hidden='true'>Volver</span>
                    </button>
                  </center>
                </form>
              </li>
            </ul>
            <form action="generarVisita2Fin.php" method="post" name="form1" id="form1">
               <ul data-inset='true' data-role='listview' data-theme='d'>
                  <script language="javascript" type="text/javascript">
                    function confirmar(){
                  	  var txt;
                      var r = confirm("Confirme por favor la visita");
                      if (r == true) {
                    		form1.submit();
                        txt = "You pressed OK!";} 
                      else {
                        txt = "You pressed Cancel!";
                        window.location="menuAdministrador.php";
                      }
                    }
              		</script>
                  <li>
                    Fecha: 
                    <input type="date" name="fechaVisita" id="fechaVisita" value="<?php echo $fecha_manana;?>"/>
                  </li>
                  <li>
                    Jornada
                    <label>
                      <input type="radio" name="jornadaVisita" id="jornadaVisita" value="ma&ntilde;ana" checked="checked" class="ui-radio-on" /> Mañana</label>
                    <label>
                      <input type="radio" name="jornadaVisita" id="jornadaVisita" value="tarde"/>Tarde</label>
                  </li>
                  <li>
                    Sucursal:
                    <select name="idSucursal" >
                      <?php 
                        mysql_select_db($database_conexion1, $conexion1);
                        $query_Sucursal1 = "SELECT * FROM sucursal where  idEmpresa='$cia' ORDER BY nombreSucursal ASC";
                        $Sucursal1 = mysql_query($query_Sucursal1, $conexion1) or die(mysql_error());
                        $numeroSucursal = mysql_num_rows($Sucursal1);
                        $row_Sucursal1 = mysql_fetch_assoc($Sucursal1);
                        do {  
                          ?>
                          <option value="<?php echo $row_Sucursal1['idSucursal']?>" ><?php echo $row_Sucursal1['nombreSucursal'];?></option>
                            <?php
                          } 
                        while ($row_Sucursal1 = mysql_fetch_assoc($Sucursal1));
                        ?>
                    </select>
                  </li>
                  <li>
                    Responsable:
                    <select name="responsable" >
                      <?php 
                        mysql_select_db($database_conexion1, $conexion1);
                        $query_responsable = "select u.estado,u.id,u.nombres,u.correoContacto,u.apellidos,r.idUsuario,r.idEmpresa from usuarios as u, rel_empresa_usuario as r where u.estado = 0 and u.id = r.idUsuario and r.idEmpresa = $cia ORDER BY u.nombres ASC";
                        $responsable = mysql_query($query_responsable, $conexion1) or die(mysql_error());
                        $numeroresponsable = mysql_num_rows($responsable);
                        $row_responsable = mysql_fetch_assoc($responsable);
                        do {  
                          ?>
                          <option value="<?php echo $row_responsable['id']?>" ><?php echo $row_responsable['nombres']." ".$row_responsable['apellidos'];?></option>
                            <?php
                          } 
                        while ($row_responsable = mysql_fetch_assoc($responsable));
                        ?>
                    </select>
                  </li>
                  <li>
                    Tecnico:
                    <select name="tecnico" >
                      <?php 
                        mysql_select_db($database_conexion1, $conexion1);
                        $query_tecnico = "select u.estado,u.id,u.nombres,u.correoContacto,u.apellidos,u.nivel from usuarios as u where u.estado = 0 and (u.nivel = 1 or u.nivel = 5) ORDER BY u.nombres ASC";
                        $tecnico = mysql_query($query_tecnico, $conexion1) or die(mysql_error());
                        $numeroTecnico = mysql_num_rows($tecnico);
                        $row_tecnico = mysql_fetch_assoc($tecnico);
                        do {  
                          ?>
                          <option value="<?php echo $row_tecnico['id']?>" ><?php echo $row_tecnico['nombres']." ".$row_tecnico['apellidos'];?></option>
                            <?php
                          } 
                        while ($row_tecnico = mysql_fetch_assoc($tecnico));
                        ?>
                    </select>
                  </li>                  
                  <li>
                    Nro. Equipo
                    <input type="tel"  name="nroEquipo" id="nroEquipo" value="" size="8" />
                  </li>
                  <li>
                  </li>
                  <li> Comentario 1:
                    <select name="comentario1">
                      <option value="0">Seleccione Opción</option>
                      <option value="1">Equipo gotea</option>
                      <option value="2">Equipo no enciende</option>
                      <option value="3">Equipo no enfría</option>
                      <option value="6">Equipo no genera calor</option>
                      <option value="4">Equipo emite ruido</option>
                      <option value="5">Otro</option>
                    </select>
                  </li>
                  <li> Comentario 2:
                    <select name="comentario2">
                      <option value="0">Seleccione Opción</option>
                      <option value="1">Equipo gotea</option>
                      <option value="2">Equipo no enciende</option>
                      <option value="3">Equipo no enfría</option>
                      <option value="6">Equipo no genera calor</option>
                      <option value="4">Equipo emite ruido</option>
                      <option value="5">Otro</option>
                    </select>
                  </li>
                  <li> Comentario 3:
                    <select name="comentario3">
                      <option value="0">Seleccione Opción</option>
                      <option value="1">Equipo gotea</option>
                      <option value="2">Equipo no enciende</option>
                      <option value="3">Equipo no enfría</option>
                      <option value="6">Equipo no genera calor</option>
                      <option value="4">Equipo emite ruido</option>
                      <option value="5">Otro</option>
                    </select>
                  </li>
                  <li> Comentarios: 
                    <textarea name="comentarios" id="comentarios" placeholder="Ubicación, Edificio,Piso encargado etc."></textarea>          
                    <input type="hidden" name="empresa" id="empresa" value="<?php echo $cia;?>" />
                    <input type="hidden" name="tipoSolicitud" value="<?php echo $tipoSolicitud; ?>" id="tipoSolicitud"/> 
                  </li>         
                  <li>
                    Estado
                    <select name="requiere">
                      <option value="1">En espera de Tecnico</option>
                      <option value="2">Pendiente de aprobacion</option>
                      <option value="3">Pendiente de Cotizacion</option>
                      <option value="4">Listo y Pendiente Cotizacion</option>
                      <option value="5">Listo para Comenzar</option>
                      <option value="6">En proceso</option>
                      <option value="7">Listo</option>
                    </select>
                  </li>
                  <li>  
                    <input name="button" type="button" data-theme='chase' id="button" onclick="confirmar();" value="Agendar" />
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