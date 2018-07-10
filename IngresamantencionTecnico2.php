<?php 
 session_start(); 
if ($_SESSION['idEmpresa']!="" ){
  if ($_GET["idE"]==""){
    $exitGoTo="menuAdministrador.php";
    header(sprintf("Location: %s", $exitGoTo));    
    }
  $cia=$_SESSION['idEmpresa'];
  require_once('Connections/conexion1.php'); 
  require_once('funciones.php');
  $idEquipo = $_GET["idE"];
  $idUsuario =$_SESSION['id'];
  mysql_select_db($database_conexion1, $conexion1);
  $query_equipo = "SELECT * FROM equipo where  idEquipo = $idEquipo";
  $equipo_array = mysql_query($query_equipo, $conexion1) or die(mysql_error());
  $equipos      = mysql_fetch_assoc($equipo_array);
  $nroEquipo    = $equipos["nroEquipo"];
  
  if (!function_exists("GetSQLValueString")){
    function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = ""){
      if (PHP_VERSION < 6) {
        $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
        }
      $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);
      switch ($theType){
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
    $fp = fopen('data.txt', 'w');
    while ($post = each($_POST)){
      fwrite($fp, $post[0] . " = " . $post[1].'  ');
      }
    fclose($fp);
    $_POST['inyeccion'] = str_replace(",",".",$_POST['inyeccion']);
    $_POST['retorno'] = str_replace(",",".",$_POST['retorno']);
    $_POST['consumo'] = str_replace(",",".",$_POST['consumo']);
    $_POST['carga'] = str_replace(",",".",$_POST['carga']);
    $directorio= "fotos/";
    $nombre_foto1="";
    $nombre_foto2=""; 
    if ($_FILES['foto1']['name']!=""){
      $target_path = $directorio.random_string(15).$_FILES['foto1']['name']; 
      move_uploaded_file($_FILES['foto1']['tmp_name'], $target_path); 
      $nombre_foto1=$target_path;
      }
    if ($_FILES['foto2']['name']!=""){
      $target_path = $directorio .random_string(15). $_FILES['foto2']['name']; 
      move_uploaded_file($_FILES['foto2']['tmp_name'], $target_path);
      $nombre_foto2=$target_path;
      }
    $insertSQL = sprintf("INSERT INTO mantencion (idEquipo, fecha, tipoTrabajo, pila, control, senal, filtro, temperatura, inyeccion, retorno, desague, bomba,terminales, condensadores, tarjeta, consumo, carga,foto1,foto2, observacion, idUsuario) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,$idUsuario)",
    GetSQLValueString($_POST['idEquipo'], "int"),
    GetSQLValueString($_POST['fecha'], "date"),
    GetSQLValueString($_POST['tipoTrabajo'], "int"),
    GetSQLValueString(isset($_POST['pila']) ? "true" : "", "defined","1","0"),
    GetSQLValueString(isset($_POST['control'])? "true" : "", "defined","1","0"),
    GetSQLValueString(isset($_POST['senal'])? "true" : "", "defined","1","0"),
    GetSQLValueString(isset($_POST['filtro'])? "true" : "", "defined","1","0"),
    GetSQLValueString(isset($_POST['temperatura'])? "true" : "", "defined","1","0"),
    GetSQLValueString($_POST['inyeccion'], "float"),
    GetSQLValueString($_POST['retorno'], "float"),
    GetSQLValueString(isset($_POST['desague'])? "true" : "", "defined","1","0"),
    GetSQLValueString(isset($_POST['bomba'])? "true" : "", "defined","1","0"),
    GetSQLValueString(isset($_POST['terminales'])? "true" : "", "defined","1","0"),
    GetSQLValueString(isset($_POST['condensadores'])? "true" : "", "defined","1","0"),
    GetSQLValueString(isset($_POST['tarjeta'])? "true" : "", "defined","1","0"),
    GetSQLValueString($_POST['consumo'], "float"),
    GetSQLValueString($_POST['carga'], "float"),
    GetSQLValueString($nombre_foto1, "text"),
    GetSQLValueString($nombre_foto2, "text"),
    GetSQLValueString($_POST['observacion'], "text"));
    mysql_select_db($database_conexion1, $conexion1);
    $Result1 = mysql_query($insertSQL, $conexion1) or die(mysql_error());
    $insertGoTo = "ingresaMantencionTecnico.php?&idE=$idEquipo&sucursal=$idSucursal&mes=$mes&anio=$anio";
    if (isset($_SERVER['QUERY_STRING'])) {
      $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
      $insertGoTo .= $_SERVER['QUERY_STRING'];
      }
        /*servicio de correo*/
         /*data correo*/
          $idEquipo = $_POST['idEquipo'];
          $queryEquipo = "select * from equipo where idEquipo = $idEquipo";
          $equipoArray = mysql_query($queryEquipo, $conexion1) or die(mysql_error());
          $equipos = mysql_fetch_assoc($equipoArray); 
          $NroEquipo = $equipos["nroEquipo"];

          $idTecnico = $_SESSION['id'];
          $queryTecnico = "select * from usuarios where id = $idTecnico";
          $tecnicoArray = mysql_query($queryTecnico, $conexion1) or die(mysql_error());
          $tecnicos = mysql_fetch_assoc($tecnicoArray); 
          $nombreTecnico = $tecnicos["nombres"]." ".$tecnicos["apellidos"];

          $idEdificio = $equipos["idEdificio"];
          $queryEdificio = "select * from edificio where idEdificio = $idEdificio";
          $edificoArray = mysql_query($queryEdificio, $conexion1) or die(mysql_error());
          $edificios = mysql_fetch_assoc($edificoArray); 
          $idSucursal = $edificios["idSucursal"];

          $querySucursal = "select * from sucursal where idSucursal = $idSucursal";
          $sucursalArray = mysql_query($querySucursal, $conexion1) or die(mysql_error());
          $sucursales = mysql_fetch_assoc($sucursalArray); 
          $sucursal = $sucursales["nombreSucursal"];
          $empresaId = $sucursales["idEmpresa"];

          $queryEmpresa = "select * from empresas where idEmpresa = $empresaId";
          $empresaArray = mysql_query($queryEmpresa, $conexion1) or die(mysql_error());
          $empresas = mysql_fetch_assoc($empresaArray); 
          $empresa = $empresas["nombreEmpresa"];

      /*fin data correo*/
      /*correos a enviar*/
        $copia2 = "plataformamyu@gmail.com";//Francisco
      /*FIn correos enviar*/
        /*
        $host_mail="jota.dhn.cl";
        $port_mail=465;
        $username_mail="envios@myu.cl";
        $password_mail="myu2013";
        */
        $host_mail="mail.myu.cl";
        $port_mail=465;
        $username_mail="envios@myu.cl";
        $password_mail="myu2013";
        $logo_mail="http://www.myu.cl/intranet/themes/chase/images/chase_header_logo_130.png";
        require("PHPMailerAutoload.php");
        $mail = new PHPMailer();
        //$mail->IsSMTP();
        //$mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";  
        $mail->Host = "localhost"; 
        $mail->Port = 25;
        $mail->Username = $username_mail; 
        $mail->Password = $password_mail; 
        $mail->From = "envios@myu.cl"; 
        $mail->FromName = "M&U Limitada";
        $mail->AddAddress($copia2); 
        $mail->IsHTML(true); // El correo se envÃ­a como HTML
        $mail->Subject = "Mantención Finalizada - Equipo N-.".$NroEquipo; 
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
                    <td colspan="5"><strong>Informamos que el tecnico '.$nombreTecnico.' ha finalizado la mantención para el equipo nro '.$NroEquipo.' perteneciente a la sucursal '.$sucursal.' de la empresa '.$empresa.'</strong></td>
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
      //fin correo  


    header(sprintf("Location: %s", $insertGoTo));
    }
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
      <style type="text/css">
        #contenidos {
          display: table-row;
          }
        #contenedor {
          display: table;
          border: 1px solid #D3D3D3;
          width: 100%;
          text-align: center;
          margin: 0 auto;
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
      <body>
        <div data-role='page' data-theme='chase' id='contacto'>
          <div class='header' data-backbtn='false' data-role='header' data-theme='chase'>
            <div class='logo'></div>
            <a class='top-left-link home' data-icon='home' href='menuTecnico.php'>Inicio</a>
          </div>
          <div class='content' data-role='fieldcontain'>
          <h2>
            Agregar Mantenci&oacute;n Equipo Nro:<?php echo $nroEquipo;?>            
          </h2>
          <ul data-inset='true' data-role='listview' data-theme='d'>
            <li>
              <a href="http://www.myu.cl/intranet/ingresaMantencionTecnico.php?idE=<?php echo $_GET['idE'];?>&sucursal=<?php echo $_GET['sucursal'];?>&mes=<?php echo $_GET['mes'];?>&anio=<?php echo $_GET['anio'];?>">
                Volver  
              </a>
            </li> 
            <li >
              <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" enctype="multipart/form-data" data-ajax="false">
                <div id="contenedor">
                  <div id="contenidos">
                    <div id="columna1">Fecha</div>
                    <div id="columna2">
                      <input type="date" name="fecha" id="fecha" value="<?php echo date("Y-m-d"); ?>" />
                    </div>
                  </div>
                  <div id="contenidos">
                    <div id="columna1">Pila:</div>
                    <div id="columna2"> 
                      <input name="pila" id="pila" type="checkbox" class="custom" checked = "checked"/>
                      <label for="pila">&nbsp;</label>
                    </div>
                  </div>
                  <div id="contenidos">
                    <div id="columna1"> Control:</div>
                    <div id="columna2">
                      <input type="checkbox" name="control" id="control" size="32" checked = "checked"/>
                      <label for="control">&nbsp;</label>                 
                    </div>
                  </div>
                  <div id="contenidos">
                    <div id="columna1">Señal:</div>
                    <div id="columna2">
                      <input type="checkbox" name="senal" id="senal" checked = "checked"/>
                      <label for="senal">&nbsp;</label>               
                   </div>
                  </div>
                  <div id="contenidos">
                    <div id="columna1">Temperatura:</div>
                    <div id="columna2">
                      <input type="checkbox" name="temperatura" id="temperatura" checked = "checked"/>
                      <label for="temperatura">&nbsp;</label>
                    </div>
                  </div>
                  <div id="contenidos">
                    <div id="columna1">Inyeccion:</div>
                    <div id="columna2"> 
                      <input type="text" name="inyeccion" size="32" value="0"/>
                    </div>
                  </div>
                  <div id="contenidos">
                    <div id="columna1">Retorno:</div>
                    <div id="columna2">
                      <input type="text" name="retorno" value="0" size="32" />
                    </div>
                  </div>  
                  <div id="contenidos">
                    <div id="columna1">Limp. Filtro:</div>
                    <div id="columna2">
                      <input type="checkbox" name="filtro" id="filtro" checked = "checked"/>
                      <label for="filtro">&nbsp;</label>
                    </div>
                  </div>
                  <div id="contenidos">
                    <div id="columna1">Bandeja Desague:</div>
                    <div id="columna2">
                      <input type="checkbox" name="desague" id="desague" checked = "checked"/>
                      <label for="desague">&nbsp;</label>
                    </div>
                  </div>
                  <div id="contenidos">
                    <div id="columna1">Bomba:</div>
                    <div id="columna2">
                      <input type="checkbox" name="bomba" id="bomba" checked = "checked"/>
                      <label for="bomba">&nbsp;</label>
                    </div>
                  </div>
                  <div id="contenidos">
                    <div id="columna1">Reap.Terminales:</div>
                    <div id="columna2">
                      <input type="checkbox" name="terminales" id="terminales" checked = "checked"/>
                      <label for="terminales">&nbsp;</label>
                    </div>
                  </div>
                  <div id="contenidos">
                    <div id="columna1">Limp.Condensadores:</div>
                    <div id="columna2">
                      <input type="checkbox" name="condensadores" id="condensadores" checked = "checked"/>
                      <label for="condensadores">&nbsp;</label>
                    </div>
                  </div>
                  <div id="contenidos">
                    <div id="columna1">Limp.Tarjeta:</div>
                    <div id="columna2">
                      <input type="checkbox" name="tarjeta" id="tarjeta" checked = "checked"/>                      <label for="tarjeta">&nbsp;</label>
                    </div>
                  </div>
                  <div id="contenidos">
                    <div id="columna1">Consumo:</div>
                    <div id="columna2">
                      <input type="text" name="consumo" value="0" size="32" />
                    </div>
                  </div>
                  <div id="contenidos">
                    <div id="columna1">Carga:</div>
                    <div id="columna2">
                       <input type="text" name="carga" value="0" size="32" />
                    </div>
                  </div>   
                  <div id="contenidos">
                    <div id="columna1">Foto 1:</div>
                    <div id="columna2"> 
                      <input type="file" name="foto1" id="foto1" />
                    </div>
                  </div> 
                  <div id="contenidos">
                    <div id="columna1">Foto 2:</div>
                    <div id="columna2">
                      <input type="file" name="foto2" id="foto2" />
                    </div>
                  </div> 
                  <div id="contenidos">
                    <div id="columna1">Obs:</div>
                    <div id="columna2">
                      <textarea name="observacion" cols="32"></textarea>
                    </div>
                  </div>
                </div>
                <input type="hidden" name="idEquipo" id="idEquipo" value="<?php echo $idEquipo; ?>" />
                <input type="hidden" name="nroEquipo" id="nroEquipo" value="<?php echo $nroEquipo; ?>" />
                <input type="hidden" name="tipoTrabajo" value="1" />
                <input type="hidden" name="MM_insert" value="form1" />
                <center>
                  <button aria-label='button1' data-theme='chase' name='button1' role='button' type='submit' value='submit' >
                    <span aria-hidden='true'>Generar Mantención</span>
                  </button>
                </center>
              </form>
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