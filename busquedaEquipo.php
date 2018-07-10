<?php session_start(); 
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
            <h2>Hist&oacute;rico  de reparaciones</h2>
            <ul data-inset='true' data-role='listview' data-theme='d'>
              <li>
                <form name="1" action="menuTecnico2.php" method="post">
                  <center>
                    <button aria-label='button1' data-theme='chase' name='button1' role='button' type='submit' value='submit' >
                      <span aria-hidden='true'>Volver</span>
                    </button>
                  </center>
                </form>    
              </li>          
              <li>
                <form name="form1" id="form1" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" >
                  <h3>Nro Equipo:</h3>
                  <input type="tel"  name="nroEquipo" id="nroEquipo" value="<?php echo @$nroEquipo; ?>" size="8" />
                  <center>
                    <button aria-label='button1' data-theme='chase' name='button1' role='button' type='submit' value='submit' >
                      <span aria-hidden='true'>Buscar</span>
                    </button>
                  </center>
                </form> 
              <?php  if ((isset($_POST["nroEquipo"])!= "") || (isset($_GET["nroEquipo"])!= "")){
                if (isset($_POST["nroEquipo"])!= ""){
                    $nroEquipo = $_POST["nroEquipo"];
                    }
                if (isset($_GET["nroEquipo"])!= ""){
                    $nroEquipo = $_GET["nroEquipo"];
                    }
                $sql = "SELECT * FROM edificio as ed,equipo as eq, sucursal as suc WHERE suc.idEmpresa = $cia AND suc.idSucursal = ed.idSucursal AND ed.idEdificio = eq.idEdificio  AND eq.nroEquipo = $nroEquipo ORDER BY ed.nombreEdificio ASC";
                mysql_select_db($database_conexion1, $conexion1);
                $result = mysql_query($sql, $conexion1) or die(mysql_error());
                $numero = mysql_num_rows($result);
                if ($numero<1) {
                  echo "<h3>EL NUMERO DE EQUIPO INGRESADO, NO EXISTE O NO CORRESPONDE A ESTA EMPRESA</h3>";
                }else {
                  echo '<p align="right">Equipos : '.$numero.'</p>';
                  ?>
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
                    display: table-cell;
                    font-size: 14px;
                    border: 1px solid #D3D3D3;
                    vertical-align: middle;
                    padding: 10px;
                    width: 15%
                    }  
                  #columna2{
                    display: table-cell;
                    font-size: 14px;
                    border: 1px solid #D3D3D3;
                    vertical-align: middle;
                    padding: 10px;
                    width: 15%
                    }    
                  #columna3{
                    display: table-cell;
                    font-size: 14px;
                    border: 1px solid #D3D3D3;
                    vertical-align: middle;
                    padding: 10px;
                    width: 15%
                    }   
                  #columna4{
                    display: table-cell;
                    font-size: 14px;
                    border: 1px solid #D3D3D3;
                    vertical-align: middle;
                    padding: 10px;
                    width: 15%
                    }   
                  #columna5{
                    display: table-cell;
                    font-size: 14px;
                    border: 1px solid #D3D3D3;
                    vertical-align: middle;
                    padding: 10px;
                    width: 40%
                    }                  
                </style>
              <script type="text/javascript" language="javascript">
                function cargapagina(edificio,equipo,sucursal){
                  window.location ="editaEquipo.php?idEd="+edificio+"&idE="+equipo+"&sucursal="+sucursal;
                  }
              </script>
              <div id="contenedor">
                <div id="contenidos">
                  <div id="columnaEncb" style="background-color:#EDE4DA;">#</div>
                  <div id="columnaEncb" style="background-color:#EDE4DA;">Sucursal</div>
                  <div id="columnaEncb" style="background-color:#EDE4DA;">Edificio</div>
                  <div id="columnaEncb" style="background-color:#EDE4DA;">Nro Equipo</div>
                </div>
                <?php
                  $i=0;
                  $acc=0;
                  while($row_Mantencion=mysql_fetch_assoc($result)){
                    $acc++;
                    if ($i%2==0){
                      $color="EDE4BA;";
                      }
                    else{
                      $color="FFF;";
                      }
                    ?>
                <div id="contenidos" onclick="cargapagina(<?php echo $row_Mantencion["idEdificio"].','.$row_Mantencion["idEquipo"].','.$row_Mantencion["idSucursal"];?>);">
                  <div id="columna1" style="background-color:#<?php echo $color;?>" >
                    <?php  
                      echo $acc;
                      ?>
                  </div>                  
                  <div id="columna2" style="background-color:#<?php echo $color;?>" >                  
                      <?php echo $row_Mantencion['nombreSucursal']; ?>
                  </div>
                  <div id="columna3" style="background-color:#<?php echo $color;?>" >
                      <?php echo $row_Mantencion['nombreEdificio']; ?>
                  </div>
                  <div id="columna4" style="background-color:#<?php echo $color;?>" >
                    <?php echo $nroEquipo; ?>
                  </div>     
                </div>  
                <?php $i++;} ?>  
              </div>   
            <?php }
           } ?>       
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