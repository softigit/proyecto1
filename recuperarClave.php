<?php 
require_once('Connections/conexion1.php'); 
require_once('funciones.php');
$usuario="";
$numerousuario=0;
$mensaje="";
if (isset($_POST['userid']))
{
	$usuario=$_POST['userid'];
	
	    mysql_select_db($database_conexion1, $conexion1);
	  $query_Sucursal1 = "SELECT * FROM usuarios where  username='$usuario'";
$Usuario1 = mysql_query($query_Sucursal1, $conexion1) or die(mysql_error());
$numerousuario = mysql_num_rows($Usuario1);
$row_Usuario = mysql_fetch_assoc($Usuario1);
if ($numerousuario==0){
	$mensaje="Correo NO registrado";
}else {
		$mensaje="Se ha enviado un correo recordando su contrase&ntilde;a";
		//correo
		require("PHPMailerAutoload.php");
		$host_mail="jota.inc.cl";
$port_mail=465;
$username_mail="contabilidad@myu.cl";
$password_mail="myu2013";
$logo_mail="http://www.myu.cl/intranet/themes/chase/images/chase_header_logo_130.png";
$email=$row_Usuario['username'];
//$email='dcampodo@gmail.com';
$ccEmail='ventas@myu.cl';
$fecha=date("d-m-Y");
$mail = new PHPMailer();
$mail->IsSMTP();
$mail->SMTPAuth = true;
$mail->SMTPSecure = "ssl";
$mail->Host = $host_mail; // "jota.inc.cl";
$mail->Port = $port_mail;

$mail->Username = $username_mail; // Correo completo a utilizar
$mail->Password = $password_mail; // Contraseña
$mail->From = "contabilidad@myu.cl"; // Desde donde enviamos (Para mostrar)
$mail->FromName = "M&U Limitada";
$mail->AddAddress($email); // Esta es la dirección a donde enviamos
//$mail->AddCC($ccEmail); // Copia
//$mail->AddBCC("cuenta@dominio.com"); // Copia oculta

$mail->IsHTML(true); // El correo se envía como HTML
$mail->Subject = "Asistencia de Contrase�a M&U Ltda.";// Este es el titulo del email.
$nombreUsuario =$row_Usuario["nombres"].' '.$row_Usuario["apellidos"];
$pass = $row_Usuario["pass"];


$body='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="ISO-8859-1" />
</head>
<body>

<table width="100%" border="0">
  <tr>
    <td colspan="4" align="center"><img src="'.$logo_mail.'" width="177" height="35" /></td>
  </tr>
  <tr>
    <td colspan="4" align="center"><h2>Asistencia de Contrase&ntilde;a</h2></td>
  </tr>
  <tr>
    <td width="23%"><strong>Fecha  Solicitud</strong></td>
    <td width="35%">'.date("d-m-Y").'</td>
    <td width="21%">&nbsp;</td>
    <td width="21%">&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Hora Solicitud</strong></td>
    <td colspan="2">'.date("H:i:s A",(time()-18000)).'</td>
  </tr>
  <tr>
    <td><strong>Solicita:</strong></td>
    <td colspan="2">'.$nombreUsuario.'</td>
  </tr>
  <tr>
    <td><strong>Usuario:</strong></td>
    <td colspan="2">'.$email.'</td>
  </tr>
  <tr>
    <td><strong>Contrase&ntilde;a:</strong></td>
    <td colspan="2"><H3>'.$pass.'</H3></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
  <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" align="center"><A href="http://www.myu.cl/intranet">http://www.myu.cl/intranet </A></td>
  </tr>
  <tr>
    <td colspan="4"><h6>Los tildes fueron omitidos para mejorar la visualizacion del correo</h6></td>
  </tr>
</table>
</body>
</html>';
$mail->Body = $body; // Mensaje a enviar
$mail->AltBody = "Visita Agendada"; // Texto sin html

//$mail->AddAttachment("imagenes/imagen.jpg", "imagen.jpg");

$exito = $mail->Send(); // Envía el correo.

	
	
}
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
          <a class='top-left-link home' data-icon='home' href='menu.php'>Inicio</a>
        </div>
        <div class='content' data-role='content'>
          <h2>Recuperar Contrase�a</h2>
          <ul data-inset='true' data-role='listview' data-theme='d'>
           <li>
           <div class='form-element'>
           <?php if ($numerousuario==0){ ?>
           
           <form action="recuperarClave.php" method="post" name="form1">
           <?php } else { ?>
        <form action="http://www.myu.cl/intranet"  method="post" name="form1">
        <?php } ?>   
         <label aria-hidden='true' for='userid' id='logon-userid'>Nombre de usuario (Correo)</label>
                <input aria-labelledby='logon-userid' autocapitalize='off' autocomplete='off' id='userid' name='userid' type='text' value='<?php echo $usuario;?>'>
                <p style="color:#F00"><?php echo $mensaje; ?></p>
                
                 <button aria-label='Log' data-theme='chase' name='log' role='button'  value='submit' >
              <span aria-hidden='true'>
              <?php if ($numerousuario==0){ ?>
           
              Enviar
              <?php } else { ?>
              Volver
              <?php } ?>
              </span>
            </button>
                </form>
                </div>
            </li>
            </ul>
        </div>
        
      </div>
	 
 
      
</body>
</html>
