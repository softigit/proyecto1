<?php 
  //error_reporting(E_ALL);
  session_start(); 
  if ($_SESSION['idEmpresa']!="" ){
	  if ($_POST["idorden"]==""){
	    $exitGoTo="EstadoOrdenesAdmin.php";
	    header(sprintf("Location: %s", $exitGoTo));  	
	    }
	  $cia=$_SESSION['idEmpresa'];
	  $idUsuario=$_SESSION['id'];
    $idAgenda = $_POST["idorden"];
    $idSucursal = $_POST["idsucursal"];
    require_once('Connections/conexion1.php'); 
    mysql_select_db($database_conexion1, $conexion1);    
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
            <a class='top-left-link home' data-icon='home' href='menuAdministrador.php'>Inicio</a>
          </div>
          <div class='content' data-role='content'>
            <ul data-inset='true' data-role='listview' data-theme='d'>
              <li>
                <form action="gestionOrdenesAdmin2.php?idAg=<?php echo $idAgenda;?>" method="post">
                  <center>
                    <button aria-label='button1' data-theme='chase' name='button1' role='button' type='submit' value='submit' >
                      <span aria-hidden='true'>Volver</span>
                    </button>
                  </center>
                </form>
              </li>
            </ul>
            <form action="editaNumeroAdmin2Fin.php" method="post" name="form1" id="form1">
              <input type="hidden" name="idorden" value="<?php echo $idAgenda;?>">               
               <ul data-inset='true' data-role='listview' data-theme='d'>
                  <li>
                    Orden Folio: <?php echo $idAgenda;?>
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
                        while ($row_Sucursal = mysql_fetch_array($Sucursal1)){
                          if ($row_Sucursal['idSucursal'] == $idSucursal){
                            echo '<option value="'.$row_Sucursal['idSucursal'].'" selected>'.$row_Sucursal['nombreSucursal'].'</option>';
                            }
                          else{
                            echo '<option value="'.$row_Sucursal['idSucursal'].'">'.$row_Sucursal['nombreSucursal'].'</option>';
                            }
                          }
                        ?>
                    </select>
                  </li>
                  <li>
                    Nro Equipo:
                    <input type="number" name="nequipo"/>
                  </li>                  
                  <li>  
                    <input name="submit" type="submit" data-theme='chase' id="button" value="Actualizar" />
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