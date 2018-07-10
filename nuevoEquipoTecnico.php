<?php session_start(); 
  if ($_SESSION['idEmpresa']!=""){
    $cia=$_SESSION['idEmpresa'];
    require_once('Connections/conexion1.php'); 
    require_once('funciones.php');
    if (!function_exists("GetSQLValueString")) {
      function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = ""){
        if (PHP_VERSION < 6) {
          $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
          }
          $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);
          switch ($theType) {
            case "text":
              $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
              break;    
            case "long":
            case "int":
              $theValue = ($theValue != "") ? intval($theValue) : "NULL";
              break;
            case "double":
              $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
              break;
            case "date":
              $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
              break;
            case "defined":
              $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
              break;
            }
        return $theValue;
        }
      }
    $editFormAction = $_SERVER['PHP_SELF'];
    if (isset($_SERVER['QUERY_STRING'])) {
      $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
      }
    if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
      $fecha=explode('-',$_POST['f_rangeStart']);
      $f_rangeStart= $_POST['f_rangeStart'];
      $insertSQL = sprintf("INSERT INTO equipo (nroEquipo, idEdificio, idMarca, presentacion, btu, refrigerante, fechaInstalacion, piso, oficinaSala, usuario, mailUsuario) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nroEquipo'], "text"),
                       GetSQLValueString($_POST['idEdificio'], "int"),
                       GetSQLValueString($_POST['idMarca'], "int"),
                       GetSQLValueString($_POST['presentacion'], "text"),
                       GetSQLValueString($_POST['btu'], "text"),
                       GetSQLValueString($_POST['refrigerante'], "text"),
                       GetSQLValueString($f_rangeStart, "date"),
                       GetSQLValueString($_POST['piso'], "text"),
                       GetSQLValueString($_POST['oficinaSala'], "text"),
                       GetSQLValueString($_POST['usuario'], "text"),
                       GetSQLValueString($_POST['mailUsuario'], "text"));
      mysql_select_db($database_conexion1, $conexion1);
      $Result1 = mysql_query($insertSQL, $conexion1) or die(mysql_error());
      /*correo aviso*/
        /*data correo*/
            $idTecnico = $_SESSION['id'];
            $nroEquipo = $_POST['nroEquipo'];
            $queryTecnico = "select * from usuarios where id = $idTecnico";
            $tecnicoArray = mysql_query($queryTecnico, $conexion1) or die(mysql_error());
            $tecnicos = mysql_fetch_assoc($tecnicoArray); 
            $nombreUsuario = $tecnicos['nombres']." ".$tecnicos['apellidos'];

            $idEdificio =$_POST['idEdificio'];
            $queryEdificio = "select * from edificio where idEdificio = $idEdificio";
            $edificioArray = mysql_query($queryEdificio, $conexion1) or die(mysql_error());
            $edificios = mysql_fetch_assoc($edificioArray); 
            $idSucursal = $edificios['idSucursal'];
    
            $querySucursal = "select * from sucursal where idSucursal = $idSucursal";
            $sucursalArray = mysql_query($querySucursal, $conexion1) or die(mysql_error());
            $sucursales = mysql_fetch_assoc($sucursalArray); 
            $nombreSucursal = $sucursales['nombreSucursal'];
            $idEmpresa = $sucursales['idEmpresa'];

            $queryEmpresa = "select * from empresas where idEmpresa = $idEmpresa";
            $empresaArray = mysql_query($queryEmpresa, $conexion1) or die(mysql_error());
            $empresas = mysql_fetch_assoc($empresaArray); 
            $nombreEmpresa = $empresas['nombreEmpresa'];
        /*fin data correo*/
        /*correos a enviar*/
          $copia1 = "claudiamyu@gmail.com";//claudia
          $copia3 = "plataformamyu@gmail.como";//Francisco
        /*FIn correos enviar*/
        $host_mail="jota.dhn.cl";
        $port_mail=465;
        $username_mail="envios@myu.cl";
        $password_mail="myu2013";
        $logo_mail="http://www.myu.cl/intranet/themes/chase/images/chase_header_logo_130.png";
        require("PHPMailerAutoload.php");
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";
        $mail->Host = $host_mail; 
        $mail->Port = $port_mail;
        $mail->Username = $username_mail; 
        $mail->Password = $password_mail; 
        $mail->From = "envios@myu.cl"; 
        $mail->FromName = "M&U Limitada";
        $mail->AddAddress($copia3); 
        $mail->AddCC($copia1);
        $mail->IsHTML(true); // El correo se envÃ­a como HTML
        $mail->Subject = "Equipo N-.".$nroEquipo." Creado"; 
        $body='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
          <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
              <meta charset="ISO-8859-1" />
            </head>
            <body>
              <table width="100%" border="0">
                  <tr>
                    <td colspan="5" align="center"><img src="'.$logo_mail.'" width="177" height="35" /></td>
                </tr>
              </table>
              <br/><br/>  
              <table width="100%" border="0">
                <tr>
                    <td colspan="5"><strong>Equipo Nro '.$nroEquipo.' ha sido creado por el usario '.$nombreUsuario.'</strong></td>
                </tr>
                <tr>
                    <td colspan="5"><strong>Este equipo pertenece a la sucursal '.$nombreSucursal.' de la empresa '.$nombreEmpresa.'</strong></td>
                </tr>
              </table>  
              <br/><br/>    
              <table width="100%" border="0">
                <tr>
                    <td colspan="5">Los tildes fueron omitidos para mejorar la visualizacion del correo</td>
                  </tr>
              </table>
            </body>
          </html>';
        $mail->Body = $body; 
        $mail->AltBody = "Orden de visita - Cambio de estado"; // Texto sin html
        $exito = $mail->Send(); 
      /*fin correo aviso*/
      $insertGoTo = "menuTecnico2.php";
      if (isset($_SERVER['QUERY_STRING'])) {
        $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
        $insertGoTo .= $_SERVER['QUERY_STRING'];
        }
      header(sprintf("Location: %s", $insertGoTo));
      }

    mysql_select_db($database_conexion1, $conexion1);
    $query_Marcas = "SELECT * FROM marcas where marca <>'OTRA' ORDER BY marca ASC";
    $Marcas = mysql_query($query_Marcas, $conexion1) or die(mysql_error());
    $row_Marcas = mysql_fetch_assoc($Marcas);
    $totalRows_Marcas = mysql_num_rows($Marcas);

    // empreas
    mysql_select_db($database_conexion1, $conexion1);
    $query_Empresas = "SELECT * FROM empresas ORDER BY nombreEmpresa ASC";
    $Empresas1 = mysql_query($query_Empresas, $conexion1) or die(mysql_error());
    $row_Empresas1 = mysql_fetch_assoc($Empresas1);
    ?>
    
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
      <head>
        <meta content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=0" name="viewport" />
        <meta charset="ISO-8859-1" />
        <meta name="apple-mobile-web-app-capable" content="yes" /> 
        <link href="lib/jquery.mobile-1.3.2.min.css" rel="stylesheet" />
        <link href="lib/jquery.mobile.datebox.1.4.0.min.css" rel="stylesheet"  />
        <link href="themes/chase/chase.css" rel="stylesheet" />
        <script src="lib/jquery-1.9.1.min.js"></script>
        <script src="lib/jquery.mobile-1.3.2.min.js"></script>
        <title>M&amp;U Mobile</title>  
      </head>
      <body>
        <div data-role='page' data-theme='chase' id='contacto'>
          <div class='header' data-backbtn='false' data-role='header' data-theme='chase'>
            <div class='logo'></div>
            <a class='top-left-link home' data-icon='home' href='menuTecnico.php'>Inicio</a>
          </div>
        <div class='content' data-role='content'>
        <h2>Agregar equipo AAC</h2>
        <ul data-inset='true' data-role='listview' data-theme='d'>
          <li>
            <form action="menuTecnico2.php" method="post">
              <input type="hidden" id="tipoSolicitud" name="tipoSolicitud" value="2" />
                <center>
                  <button aria-label='button1' data-theme='chase' name='button1' role='button' type='submit' value='submit' >
                    <span aria-hidden='true'>VOLVER</span>
                  </button>
                </center>
            </form>
          </li>
          <li class='phone-link' id='supportTel'>
            <h3>
                Empresa:   <?php 
               echo devuelveNombre($cia,'empresas','idEmpresa','nombreEmpresa');?>  
            </h3>
          </li>
        <?php if ($cia != ""){  ?>
        <li class='phone-link' id='supportTel'>
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="form3" id="form3">
            <input type="hidden" name="idEmpresa" id="idEmpresa" value="<?php echo $_POST["idEmpresa"]; ?>" />
            <h3>Sucursal:</h3>
            <?php 
              $query_Sucursal1 = "SELECT * FROM sucursal where  idEmpresa='$cia' ORDER BY nombreSucursal ASC";
              $Sucursal1 = mysql_query($query_Sucursal1, $conexion1) or die(mysql_error());
              $numeroSucursal = mysql_num_rows($Sucursal1);
              $row_Sucursal1 = mysql_fetch_assoc($Sucursal1);
              ?>
            <select name="idSucursal" onchange=form3.submit() >
              <option value='' selected>Seleccione Sucursal </option>
                <?php 
                  if ($_POST["idSucursal"]!= ""){  
                    $sucursal=$_POST["idSucursal"];
                    echo "<option value='".$sucursal."' SELECTED>".devuelveNombre($sucursal,'sucursal','idSucursal','nombreSucursal')."</option>";
                    }
                  do{?>
                    <option value="<?php echo $row_Sucursal1['idSucursal']?>" ><?php echo $row_Sucursal1['nombreSucursal'];?></option>
                    <?php } 
                  while ($row_Sucursal1 = mysql_fetch_assoc($Sucursal1));
                  ?>
            </select>
          </form>
        </li>    
      <?php } ?>
      <?php if (isset($_POST["idSucursal"])!= "" || $numeroSucursal==1){
         if ($numeroSucursal==1){$sucursal= $row_Sucursal1['idSucursal'];}
           ?>
        <li class='phone-link'>
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="form1" id="form1">


<h3>Edificio:</h3>
      
       <?php 
    $query_Edificio1 = "SELECT * FROM edificio where  idSucursal='$sucursal' ORDER BY nombreEdificio ASC";
$Edificio1 = mysql_query($query_Edificio1, $conexion1) or die(mysql_error());
$row_Edificio1 = mysql_fetch_assoc($Edificio1);
      ?>
      
      <select name="idEdificio" id="idEdificio" />
<?php 
do {  
?>
        <option value="<?php echo $row_Edificio1['idEdificio']?>" ><?php echo $row_Edificio1['nombreEdificio'];?></option>
        <?php
} while ($row_Edificio1 = mysql_fetch_assoc($Edificio1));
?>
      </select>
     <hr class="atmbranchlocations-address" data-theme='chase'> 
      <h3>Nro Equipo:</h3>
      <input type="number" name="nroEquipo" id="nroEquipo" value="" size="8" required/>
 <hr /> 

    <h3>Marca:</h3>
      <select name="idMarca" id="idMarca" >
        <?php
do {  
?>
        <option value="<?php echo $row_Marcas['idMarca']?>"><?php echo $row_Marcas['marca']?></option>
        <?php
} while ($row_Marcas = mysql_fetch_assoc($Marcas));
  $rows = mysql_num_rows($Marcas);
  if($rows > 0) {
      mysql_data_seek($Marcas, 0);
    $row_Marcas = mysql_fetch_assoc($Marcas);
  }
?>
<option value="14">OTRA </option>
      </select>

 <hr /> 
<h3>Presentacion:</h3>
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
  <hr /> 

   <h3>Btu:</h3>
     <select name="btu"  id="btu" >
      <option value="9.000">9.000</option>
<option value="12.000">12.000</option>
<option value="18.000">18.000</option>
<option value="24.000">24.000</option>
<option value="36.000">36.000</option>
<option value="48.000">48.000</option>
<option value="60.000">60.000</option>

      </select>
  <hr /> 

    <h3> Refrigerante:</h3>
     <select name="refrigerante" id="refrigerante">
      <option value="R-22">R-22</option>
  <option value="R-410a">R-410a</option>
  <option value="R-410 Inverter">R-410 Inverter</option>
  <option value="R-407">R-407</option>

      </select>
    <hr /> 
<h3>Fecha Instalaci&oacute;n:</h3>
      
      <input type="date" size="15" name="f_rangeStart" id="f_rangeStart" value="<?php echo date("Y-m-d"); ?>"/>
             
  <hr />  
<h3>Piso:</h3>
      <select name="piso" size="1" id="piso" >
      <?php for ($i=-4;$i<21;$i++){
      if ($i!=0){
      echo '<option value="'.$i.'">'.$i.'</option>';
      }
    }?>
      </select>
    <hr /> 
<h3>Oficina/Sala:</h3>
     <input type="text" name="oficinaSala" value="" size="20" required/>
 <hr /> 
   <h3>Usuario:</h3>
   <input type="text" name="usuario" value="" size="32" required/>
   

 <hr /> 
   <h3>Mail Usuario:</h3>
   
      <input type="email" name="mailUsuario" value="" size="32" required/>
      
      
    <hr /> 
     <button aria-label='button1' data-theme='chase' name='button1' role='button' type='submit' value='submit' >
              <span aria-hidden='true'>Ingresar Equipo</span>
            </button>
   
  <input type="hidden" name="MM_insert" value="form1" />
</form>


<?php } ?>
</li>
</ul>



</div>
</div>
</body>
</html>
<?php
mysql_free_result($Marcas);
} else {
  $exitGoTo="index.php";
   header(sprintf("Location: %s", $exitGoTo));  
}
  ?>
