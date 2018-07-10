<?php 
 session_start(); 
if ($_SESSION['idEmpresa']!="" ){
		 $cia=$_SESSION['idEmpresa'];
require_once('Connections/conexion1.php'); 
require_once('funciones.php');
	 $idUsuario=$_SESSION['id'];
$editFormAction = $_SERVER['PHP_SELF'];

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = "UPDATE usuarios SET  pass='".$_POST['pass']."', correoContacto='".$_POST['correoContacto']."', fonoContacto='".$_POST['fonoContacto']."' WHERE id='".$idUsuario."'";
  
  mysql_select_db($database_conexion1, $conexion1);
  $Result1 = mysql_query($updateSQL, $conexion1) or die(mysql_error());

  $updateGoTo = "menu.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

	 mysql_select_db($database_conexion1, $conexion1);
$query_Recordset1 = "SELECT * FROM usuarios WHERE id ='".$idUsuario."'";

$Recordset1 = mysql_query($query_Recordset1, $conexion1) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);



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
          <a class='top-left-link home' data-icon='home' href='menu.php'>Inicio</a>
        </div>
        <div class='content' data-role='content'>
          <h2>Datos Personales</h2>
          <ul data-inset='true' data-role='listview' data-theme='d'>
          <li>
       <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">  
      <h3>Nombre de Usuario:</h3>
      <input type="text" name="username" id="username" value="<?php echo $row_Recordset1['username']; ?>" size="25" readonly/>
 
    <hr class="atmbranchlocations-address" data-theme='chase'> 
      <h3>Nombre:</h3>
      <input type="text" name="nombre" id="nombre" value="<?php echo $row_Recordset1['nombres'].' '.$row_Recordset1['apellidos']; ?>" size="25" readonly/>

    <hr class="atmbranchlocations-address" data-theme='chase'> 
      <h3>Correo:</h3>
      <input type="email" name="correoContacto" id="correoContacto" value="<?php echo $row_Recordset1['correoContacto']; ?>" size="25" />
<hr class="atmbranchlocations-address" data-theme='chase'> 
      <h3>Teléfono:</h3>
      <input type="tel" name="fonoContacto" id="fonoContacto" value="<?php echo $row_Recordset1['fonoContacto']; ?>" size="25" />
 <hr class="atmbranchlocations-address" data-theme='chase'> 
      <h3>Password:</h3>
      <input type="password" name="pass" id="pass" value="<?php echo $row_Recordset1['pass']; ?>" size="25" />
  <input type="hidden" name="id" value="<?php echo $row_Recordset1['id']; ?>" />
  <input type="hidden" name="MM_update" value="form1" />
 
            <button aria-label='button1' data-theme='chase' name='button1' role='button' type='submit' value='submit' >
              <span aria-hidden='true'>Actualizar</span>
            </button><!-- aqui va el contenido --> 
        </form> 
</li>
            </ul>
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