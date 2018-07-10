<?php session_start(); 
if ($_SESSION['idEmpresa']!=""){
	 $cia=$_SESSION['idEmpresa'];
require_once('Connections/conexion1.php'); 
require_once('funciones.php');
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
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
  $insertSQL = sprintf("INSERT INTO edificio (idSucursal, nombreEdificio, direccion) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['idSucursal'], "int"),
                       GetSQLValueString($_POST['nombreEdificio'], "text"),
                       GetSQLValueString($_POST['direccion'], "text")  );

  mysql_select_db($database_conexion1, $conexion1);
  $Result2 = mysql_query($insertSQL, $conexion1) or die(mysql_error());

  $insertGoTo = "menu.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
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

<body>
 <div data-role='page' data-theme='chase' id='contacto'>
        <div class='header' data-backbtn='false' data-role='header' data-theme='chase'>
          <div class='logo'></div>
          <a class='top-left-link home' data-icon='home' href='menu.php'>Inicio</a>
        </div>
        <div class='content' data-role='content'>
  <h2>
            Agregar Edificio
            
          </h2>
           <ul data-inset='true' data-role='listview' data-theme='d'> <li class='phone-link' id='supportTel'>
  <h3>Empresa:   <?php 
		echo devuelveNombre($cia,'empresas','idEmpresa','nombreEmpresa');
?>	</h3>
      	
    </li>
    </ul>
            
          
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="form1" id="form1">
  
            <ul data-inset='true' data-role='listview' data-theme='d'>    
           <li class='phone-link' id='supportTel'>
            <?php 
	  $query_Recordset1 = "SELECT * FROM sucursal where  idEmpresa='$cia' ORDER BY nombreSucursal ASC";
$Recordset1 = mysql_query($query_Recordset1, $conexion1) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
      ?>
      <h3>Sucursal:</h3>
      <select name="idSucursal" />
<?php 
do {  
?>
  <option value="<?php echo $row_Recordset1['idSucursal'];?>" ><?php echo $row_Recordset1['nombreSucursal'];?></option>
        <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
?>
      </select>
      
      <h3>Edificio</h3>
      
      <input type="text" name="nombreEdificio" id="nombreEdificio" />
      <h3>Direcci&oacute;n</h3>
      
      <input type="text" name="direccion" id="direccion" />
      
      <button aria-label='button1' data-theme='chase' name='button1' role='button' type='submit' value='submit' >
              <span aria-hidden='true'>Ingresar Edificio</span>
            </button>
    <input type="hidden" name="MM_insert" value="form1" />
</li>
</ul>
</form>






</div>
</div>
</body>
</html>
<?php
mysql_free_result($Recordset1);
} else {
	$exitGoTo="index.php";
	 header(sprintf("Location: %s", $exitGoTo));  
}
	?>