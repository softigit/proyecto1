<?php 
  //error_reporting(E_ALL);
  session_start(); 
  if ($_POST["idorden"]==""){
    $exitGoTo="EstadoOrdenesSupervisor.php";
    header(sprintf("Location: %s", $exitGoTo));  	
    }
	  $idUsuario=$_SESSION['id'];
    $idTecnicoActual = $_POST["idTecnico"];
    $idAgenda = $_POST["idorden"];
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
            <ul data-inset='true' data-role='listview' data-theme='d'>
              <li>
                <form action="gestionOrdenesSupervisor.php?idAg=<?php echo $idAgenda;?>" method="post">
                  <center>
                    <button aria-label='button1' data-theme='chase' name='button1' role='button' type='submit' value='submit' >
                      <span aria-hidden='true'>Volver</span>
                    </button>
                  </center>
                </form>
              </li>
            </ul>
            <form action="editaTecnicoSupFin.php" method="post" name="form1" id="form1">
              <input type="hidden" name="idorden" value="<?php echo $idAgenda;?>">               
              <input type="hidden" name="idTecnicoActual" value="<?php echo $idTecnicoActual;?>">                             
               <ul data-inset='true' data-role='listview' data-theme='d'>
                  <li>
                    Orden Folio: <?php echo $idAgenda;?>
                  </li>
                  <li>
                    Tecnico:
                    <select name="tecnico" >
                      <?php 
                        mysql_select_db($database_conexion1, $conexion1);
                        $query_tecnico = "select u.estado,u.id,u.nombres,u.apellidos,u.nivel from usuarios as u where u.nivel = 1 and u.estado = 0 ORDER BY u.nombres ASC";
                        $tecnico = mysql_query($query_tecnico, $conexion1) or die(mysql_error());
                        $numeroTecnico = mysql_num_rows($tecnico);
                        while ($row_tecnico = mysql_fetch_array($tecnico)){
                          $tecnicoNombre = $row_tecnico['nombres'].' '.$row_tecnico['apellidos'];
                          if ($idTecnicoActual == $row_tecnico['id']){
                            echo '<option value="'.$row_tecnico['id'].'" selected>'.$tecnicoNombre.'</option>';
                            }
                          else{
                            echo '<option value="'.$row_tecnico['id'].'">'.$tecnicoNombre.'</option>';
                            }                                
                          }
                        ?>    
                    </select>
                  </li>                  
                  <li>  
                    <input name="submit" type="submit" data-theme='chase' id="button" value="Actualizar" />
                  </li>     
              </ul>
            </form>
          </div>     
        </body>
      </html>