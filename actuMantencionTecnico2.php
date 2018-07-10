<?php 
 session_start(); 
if ($_SESSION['idEmpresa']!="" ){
  if ($_GET["idM"]==""){
    $exitGoTo="menuAdministrador.php";
    header(sprintf("Location: %s", $exitGoTo));    
    }
  $cia=$_SESSION['idEmpresa'];
  require_once('Connections/conexion1.php'); 
  require_once('funciones.php');
  $idM = $_GET["idM"];
  $idSucursal = $_GET["sucursal"];
  $mes = $_GET["mes"];
  $anio = $_GET["anio"];
  $idEquipo = $_GET["idE"];
  $idUsuario =$_SESSION['id'];
  mysql_select_db($database_conexion1, $conexion1);
  $sql="Select * from mantencion where idmantencion=$idM";
  $Mantencion1 = mysql_query($sql, $conexion1) or die(mysql_error());
  $row_Mantencion1 = mysql_fetch_assoc($Mantencion1);

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
    if ($_FILES['foto1']['name']!=""){
      $target_path = $directorio.random_string(15).$_FILES['foto1']['name']; 
      move_uploaded_file($_FILES['foto1']['tmp_name'], $target_path); 
      $nombre_foto1=$target_path;
      $updateSQLF1 = "UPDATE mantencion SET foto1 = '$nombre_foto1' where idmantencion = $idM";
      mysql_query($updateSQLF1, $conexion1) or die(mysql_error());
      }
    if ($_FILES['foto2']['name']!=""){
      $target_path = $directorio .random_string(15). $_FILES['foto2']['name']; 
      move_uploaded_file($_FILES['foto2']['tmp_name'], $target_path);
      $nombre_foto2=$target_path;
      $updateSQLF2 = "UPDATE mantencion SET foto2 = '$nombre_foto2' where idmantencion = $idM";
      mysql_query($updateSQLF2, $conexion1) or die(mysql_error());
      }
      $pila = GetSQLValueString(isset($_POST['pila']) ? "true" : "", "defined","1","0");
      $control = GetSQLValueString(isset($_POST['control']) ? "true" : "", "defined","1","0");
      $senal = GetSQLValueString(isset($_POST['senal']) ? "true" : "", "defined","1","0");
      $filtro = GetSQLValueString(isset($_POST['filtro']) ? "true" : "", "defined","1","0");
      $temperatura = GetSQLValueString(isset($_POST['temperatura']) ? "true" : "", "defined","1","0");
      $inyeccion = $_POST['inyeccion'];
      $retorno = $_POST['retorno'];
      $desague = GetSQLValueString(isset($_POST['desague']) ? "true" : "", "defined","1","0");
      $bomba = GetSQLValueString(isset($_POST['bomba']) ? "true" : "", "defined","1","0");
      $terminales = GetSQLValueString(isset($_POST['terminales']) ? "true" : "", "defined","1","0");
      $condensadores  = GetSQLValueString(isset($_POST['condensadores']) ? "true" : "", "defined","1","0");
      $tarjeta = GetSQLValueString(isset($_POST['tarjeta']) ? "true" : "", "defined","1","0");
      $consumo = $_POST['consumo'];
      $carga = $_POST['carga'];
      $observacion = $_POST['observacion'];
      mysql_select_db($database_conexion1, $conexion1);     
      $updateSQL = "UPDATE mantencion SET pila = $pila ,control = $control,senal = $senal,filtro = $filtro,temperatura = $temperatura,inyeccion = $inyeccion,retorno = $retorno,desague = $desague,bomba = $bomba,terminales = $terminales,condensadores = $condensadores,tarjeta = $tarjeta,consumo = $consumo,carga = $carga,observacion = '$observacion',idUsuario = $idUsuario where idmantencion = $idM";
      mysql_query($updateSQL, $conexion1) or die(mysql_error());
      $insertGoTo = "mantencionPorFechaTecnicoView.php?idM=$idM&idE=$idEquipo&sucursal=$idSucursal&mes=$mes&anio=$anio";
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
            <a class='top-left-link home' data-icon='home' href='menuAdministrador.php'>Inicio</a>
          </div>
          <div class='content' data-role='fieldcontain'>
          <h2>
            Agregar Mantenci&oacute;n Equipo Nro:<?php echo $nroEquipo;?>            
          </h2>
          <ul data-inset='true' data-role='listview' data-theme='d'>
            <li>
              <a href="http://www.myu.cl/intranet2/mantencionPorFechaTecnicoView.php?idM=<?php echo $_GET['idM'];?>&idE=<?php echo $_GET['idE'];?>&sucursal=<?php echo $_GET['sucursal'];?>&mes=<?php echo $_GET['mes'];?>&anio=<?php echo $_GET['anio'];?>">
                Volver  
              </a>
            </li> 
            <li>
              <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" enctype="multipart/form-data" data-ajax="false">
                <div id="contenedor">
                  <div id="contenidos">
                    <div id="columna1">Fecha</div>
                    <div id="columna2">
                      <input type="hidden" name="fecha" id="fecha" value="<?php echo date("Y-m-d"); ?>" />
                      <?php echo date("d-m-Y");?>
                    </div>
                  </div>
                  <div id="contenidos">
                    <div id="columna1">Pila:</div>
                    <div id="columna2"> 
                      <input name="pila" id="pila" type="checkbox" class="custom" <?php if ($row_Mantencion1["pila"] == 1){?>checked = "checked"<?php }?>/>
                      <label for="pila">&nbsp;</label>
                    </div>
                  </div>
                  <div id="contenidos">
                    <div id="columna1"> Control:</div>
                    <div id="columna2">
                      <input type="checkbox" name="control" id="control" size="32" <?php if ($row_Mantencion1["control"] == 1){?>checked = "checked"<?php }?>/>
                      <label for="control">&nbsp;</label>                 
                    </div>
                  </div>
                  <div id="contenidos">
                    <div id="columna1">Señal:</div>
                    <div id="columna2">
                      <input type="checkbox" name="senal" id="senal" <?php if ($row_Mantencion1["senal"] == 1){?>checked = "checked"<?php }?>/>
                      <label for="senal">&nbsp;</label>               
                   </div>
                  </div>
                  <div id="contenidos">
                    <div id="columna1">Temperatura:</div>
                    <div id="columna2">
                      <input type="checkbox" name="temperatura" id="temperatura" <?php if ($row_Mantencion1["temperatura"] == 1){?>checked = "checked"<?php }?>/>
                      <label for="temperatura">&nbsp;</label>
                    </div>
                  </div>
                  <div id="contenidos">
                    <div id="columna1">Inyeccion:</div>
                    <div id="columna2"> 
                      <input type="text" name="inyeccion" size="32" value="<?php echo $row_Mantencion1["inyeccion"]?>"/>
                    </div>
                  </div>
                  <div id="contenidos">
                    <div id="columna1">Retorno:</div>
                    <div id="columna2">
                      <input type="text" name="retorno" value="<?php echo $row_Mantencion1["retorno"]?>" size="32" />
                    </div>
                  </div>  
                  <div id="contenidos">
                    <div id="columna1">Limp. Filtro:</div>
                    <div id="columna2">
                      <input type="checkbox" name="filtro" id="filtro" <?php if ($row_Mantencion1["filtro"] == 1){?>checked = "checked"<?php }?>/>
                      <label for="filtro">&nbsp;</label>
                    </div>
                  </div>
                  <div id="contenidos">
                    <div id="columna1">Bandeja Desague:</div>
                    <div id="columna2">
                      <input type="checkbox" name="desague" id="desague" <?php if ($row_Mantencion1["desague"] == 1){?>checked = "checked"<?php }?>/>
                      <label for="desague">&nbsp;</label>
                    </div>
                  </div>
                  <div id="contenidos">
                    <div id="columna1">Bomba:</div>
                    <div id="columna2">
                      <input type="checkbox" name="bomba" id="bomba" <?php if ($row_Mantencion1["bomba"] == 1){?>checked = "checked"<?php }?>/>
                      <label for="bomba">&nbsp;</label>
                    </div>
                  </div>
                  <div id="contenidos">
                    <div id="columna1">Reap.Terminales:</div>
                    <div id="columna2">
                      <input type="checkbox" name="terminales" id="terminales" <?php if ($row_Mantencion1["terminales"] == 1){?>checked = "checked"<?php }?>/>
                      <label for="terminales">&nbsp;</label>
                    </div>
                  </div>
                  <div id="contenidos">
                    <div id="columna1">Limp.Condensadores:</div>
                    <div id="columna2">
                      <input type="checkbox" name="condensadores" id="condensadores" <?php if ($row_Mantencion1["condensadores"] == 1){?>checked = "checked"<?php }?>/>
                      <label for="condensadores">&nbsp;</label>
                    </div>
                  </div>
                  <div id="contenidos">
                    <div id="columna1">Limp.Tarjeta:</div>
                    <div id="columna2">
                      <input type="checkbox" name="tarjeta" id="tarjeta" <?php if ($row_Mantencion1["tarjeta"] == 1){?>checked = "checked"<?php }?>/>  
                      <label for="tarjeta">&nbsp;</label>
                    </div>
                  </div>
                  <div id="contenidos">
                    <div id="columna1">Consumo:</div>
                    <div id="columna2">
                      <input type="text" name="consumo" value="<?php echo $row_Mantencion1["consumo"]?>" size="32" />
                    </div>
                  </div>
                  <div id="contenidos">
                    <div id="columna1">Carga:</div>
                    <div id="columna2">
                       <input type="text" name="carga" value="<?php echo $row_Mantencion1["carga"]?>" size="32" />
                    </div>
                  </div>   
                  <div id="contenidos">
                    <div id="columna1">Foto 1:</div>
                    <div id="columna2"> 
                      <?php if ($row_Mantencion1['foto1']!=""){ ?> 
                        <a href="<?php echo $row_Mantencion1['foto1'];?>" target="new"> 
                          <img src="<?php echo $row_Mantencion1['foto1'];?>" height="100px" width="100px"/>
                        </a>
                      <?php } ?> 
                      <?php if ($row_Mantencion1['foto1']==""){?>                        
                        <input type="file" name="foto1" id="foto1" />
                      <?php } ?>                       
                    </div>
                  </div> 
                  <div id="contenidos">
                    <div id="columna1">Foto 2:</div>
                    <div id="columna2">
                      <?php if ($row_Mantencion1['foto2']!=""){ ?> 
                        <a href="<?php echo $row_Mantencion1['foto2'];?>" target="new"> 
                          <img src="<?php echo $row_Mantencion1['foto2'];?>" height="100px" width="100px"/>
                        </a>
                      <?php } ?>
                      <?php if ($row_Mantencion1['foto2']==""){?>                        
                        <input type="file" name="foto2" id="foto2" />
                      <?php } ?>
                    </div>
                  </div> 
                  <div id="contenidos">
                    <div id="columna1">Obs:</div>
                    <div id="columna2">
                      <textarea name="observacion" cols="32">
                        <?php echo $row_Mantencion1['observacion'];?>
                      </textarea>
                    </div>
                  </div>
                </div>
                <input type="hidden" name="idEquipo" id="idEquipo" value="<?php echo $idEquipo; ?>" />
                <input type="hidden" name="nroEquipo" id="nroEquipo" value="<?php echo $nroEquipo; ?>" />
                <input type="hidden" name="tipoTrabajo" value="1" />
                <input type="hidden" name="MM_insert" value="form1" />
                <center>
                  <button aria-label='button1' data-theme='chase' name='button1' role='button' type='submit' value='submit' >
                    <span aria-hidden='true'>Actualizar Mantención</span>
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