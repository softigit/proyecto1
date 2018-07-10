<?php session_start(); 
  if ($_SESSION['idEmpresa']!="" ){
	  $idUsuario=$_SESSION['id'];
	  if ($_POST["tipoSolicitud"]==""){
	    $exitGoTo="menu.php";
	    header(sprintf("Location: %s", $exitGoTo));  	
	    }
  	require_once('Connections/conexion1.php'); 
    require_once('funciones.php');
    mysql_select_db($database_conexion1, $conexion1);
    $sql="SELECT MAX(idAgenda) as idAgenda FROM agenda ORDER BY idAgenda";
    $DetailRS1 = mysql_query($sql, $conexion1) or die(mysql_error());
    $row_DetailRS1 = mysql_fetch_assoc($DetailRS1);
    $numero= $row_DetailRS1['idAgenda']+1;	
    //tipovisita 1:tecnica, 2:comercial
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
    $fecha=date("Y-m-d");
    require_once('funciones.php');
    $email=$_POST['correoContacto'];
    $ccEmail='plataformamyu@gmail.com';
    $ccEmail2='claudiamyu@gmail.com';    
    if (!isset($_POST['fechaVisita'])){
	    $dia_manana = date('d',time()+84600);
      $mes_manana = date('m',time()+84600);
      $ano_manana = date('Y',time()+84600);
      $fecha_manana=$ano_manana.'-'.$mes_manana.'-'.$dia_manana;
	    $_POST['fechaVisita']=$fecha_manana.' '.date("H:i:s");
      }
    if (!isset($_POST["jornadaVisita"])){
	    $_POST["jornadaVisita"]='ma&ntilde;ana';
      }
    if (isset($_POST['fechaVisita'])){
	    if ($_POST["jornadaVisita"]=="ma&ntilde;ana"){
		    $hora_visita="09:00:00";
		    $_POST['fechaVisita']=$_POST['fechaVisita'].' '.$hora_visita;
	      }
      else{
			  $hora_visita="14:00:00";
			  $_POST['fechaVisita']=$_POST['fechaVisita'].' '.$hora_visita;			
	      }
      }
    $tipoSolicitud=$_POST["tipoSolicitud"];
    $comentario1O = $_POST["comentario1"];
    $comentario2O = $_POST["comentario2"];
    $comentario3O = $_POST["comentario3"];
    $comentario1 = $_POST["comentario1"];
    $comentario2 = $_POST["comentario2"];
    $comentario3 = $_POST["comentario3"];
    $escribecomentario='<tr><td colspan="2"><strong>Comentario:</strong></td><td colspan="3">';
    $escribecomentario2='</td> </tr>';
    $frase1='Equipo Gotea';
    $frase2='Equipo no enciende';
    $frase3='Equipo no enfr�a';
    $frase4='Equipo emite ruido';
    $frase5='Otro';
    $frase6="Equipo no genera calor";
    switch($comentario1){
      case 0:	$comentario1='';break;
      case 1: $comentario1=$escribecomentario.$frase1.$escribecomentario2;break;
      case 2: $comentario1=$escribecomentario.$frase2.$escribecomentario2;break;
      case 3: $comentario1=$escribecomentario.$frase3.$escribecomentario2;break;
      case 4: $comentario1=$escribecomentario.$frase4.$escribecomentario2;break;
      case 5: $comentario1=$escribecomentario.$frase5.$escribecomentario2;break;
      case 6: $comentario1=$escribecomentario.$frase6.$escribecomentario2;break;
      }
    switch($comentario2){
      case 0:	$comentario2='';break;
      case 1: $comentario2=$escribecomentario.$frase1.$escribecomentario2;break;
      case 2: $comentario2=$escribecomentario.$frase2.$escribecomentario2;break;
      case 3: $comentario2=$escribecomentario.$frase3.$escribecomentario2;break;
      case 4:$comentario2= $escribecomentario.$frase4.$escribecomentario2;break;
      case 5: $comentario2=$escribecomentario.$frase5.$escribecomentario2;break;
      case 6: $comentario2=$escribecomentario.$frase6.$escribecomentario2;break;
      }
    switch($comentario3){
      case 0:	$comentario3='';break;
      case 1: $comentario3=$escribecomentario.$frase1.$escribecomentario2;break;
      case 2: $comentario3=$escribecomentario.$frase2.$escribecomentario2;break;
      case 3: $comentario3=$escribecomentario.$frase3.$escribecomentario2;break;
      case 4:$comentario3= $escribecomentario.$frase4.$escribecomentario2;break;
      case 5: $comentario3=$escribecomentario.$frase5.$escribecomentario2;break;
      case 6: $comentario3=$escribecomentario.$frase6.$escribecomentario2;break;
      }
    if (!isset($_POST["nroEquipo"])){
	    $nroEquipo='';
	    $_POST["nroEquipo"]=0;
      }
    else{
	    if ($_POST["nroEquipo"]!='' || $_POST["nroEquipo"]!=0){
	      $nroEquipo='<tr><td colspan="2"><strong>Nro. Equipo:</strong></td><td colspan="3">'.$_POST["nroEquipo"].'</td> </tr>';
        }
      }
    if ($tipoSolicitud=='1'){
	    $titulo="Visita Tecnica";
      }
    else{
	    $titulo="Visita Comercial";
      }
	  $comentarios=$_POST['comentarios'];
    if ($comentarios=='Ubicaci�n, Edificio,Piso encargado etc.'){
	    $comentarios='';
      }
require("PHPMailerAutoload.php");
$mail = new PHPMailer();
        //$mail->IsSMTP();
        //$mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";  
        $mail->Host = "localhost"; 
        $mail->Port = 25;
        $mail->Username = $username_mail; 
        $mail->Password = $password_mail; 
$mail->From = "envios@myu.cl"; // Desde donde enviamos (Para mostrar)
$mail->FromName = "M&U Limitada";
$mail->AddAddress($email); // Esta es la dirección a donde enviamos
$mail->AddCC($ccEmail); // Francisco
$mail->AddCC($ccEmail2); // Claudia

$mail->IsHTML(true); // El correo se envía como HTML
$mail->Subject = "Sol.".$titulo." N. 
 ".$numero; // Este es el titulo del email.
//$body = "Hola mundo. Esta es la primer línea<br />";
//$body .= "Acá continuo el <strong>mensaje</strong>";
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
  <tr>
    <td colspan="5" align="center"><h2>Solicitud de '.$titulo.'</h2></td>
  </tr>
  <tr>
    <td colspan="2"><strong>Fecha  Solicitud</strong></td>
    <td width="35%">'.date("d-m-Y").'</td>
    <td width="21%">&nbsp;</td>
    <td width="21%">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><strong>Hora Solicitud</strong></td>
    <td colspan="3">'.date("H:i:s").'</td>
  </tr>
  <tr>
    <td colspan="2"><strong>Solicita:</strong></td>
    <td colspan="3">'.$_POST["solicitante"].'</td>
  </tr>
  <tr>
    <td colspan="2"><strong>Fono:</strong></td>
    <td colspan="3"><a href="tel:'.$_POST["fonoContacto"].'">'.$_POST["fonoContacto"].'</a></td>
  </tr>
  <tr>
    <td colspan="2"><strong>Empresa:</strong></td>
    <td colspan="3">'.$_POST["empresa"].'</td>
  </tr>
  <tr>
  <td colspan="2"><strong>Sucursal:</strong></td>
    <td colspan="3">'.devuelveNombre($_POST['idSucursal'],'sucursal','idSucursal','nombreSucursal').'</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><strong>Fecha de visita</strong></td>
    <td>'.$dia_manana.'-'.$mes_manana.'-'.$ano_manana.'</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><strong>Jornada de Visita</strong></td>
    <td>'.$_POST["jornadaVisita"].'</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>'.$nroEquipo.$comentario1.$comentario2.$comentario3.'
  <tr>
    <td colspan="2"><strong>Obs</strong></td>
    <td colspan="3">'.$_POST["comentarios"].'</td>
  </tr>
  <tr>
    <td width="13%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5"><h6>Los tildes fueron omitidos para mejorar la visualizacion del correo</h6></td>
  </tr>
</table>
</body>
</html>
';


$mail->Body = $body; // Mensaje a enviar
$mail->AltBody = "Visita Agendada"; // Texto sin html

//$mail->AddAttachment("imagenes/imagen.jpg", "imagen.jpg");

$exito = $mail->Send(); // Envía el correo.

if($exito){
$created_date = date("Y-m-d H:i:s");
//$insertSQL="INSERT INTO agenda(fecha, idEmpresa, idusuario, tipoSolicitud, comentario, fechaVisita, jornadaVisita, fechaConfirmado, idUsuarioConfirma,estado,comentario1,comentario2,comentario3,nroEquipo,idSucursal) VALUES ('".$created_date."','".$_SESSION['idEmpresa']."','".$idUsuario."','".$tipoSolicitud."','".$comentarios."','".$_POST['fechaVisita']."','".$_POST['jornadaVisita']."','','".$idUsuario."','En espera de Tecnico','".$comentario1O."','".$comentario2O."','".$comentario3O."','".$_POST['nroEquipo']."','".$_POST['idSucursal']."')";
$insertSQL="INSERT INTO agenda(fecha, idEmpresa, idusuario, tipoSolicitud, comentario, fechaVisita, jornadaVisita, fechaConfirmado, idUsuarioConfirma,estado,comentario1,comentario2,comentario3,nroEquipo,idSucursal,requiere) VALUES ('".$created_date."','".$_SESSION['idEmpresa']."','".$idUsuario."','".$tipoSolicitud."','".$comentarios."','".$_POST['fechaVisita']."','".$_POST['jornadaVisita']."','','".$idUsuario."','En espera de Tecnico','".$comentario1O."','".$comentario2O."','".$comentario3O."','".$_POST['nroEquipo']."','".$_POST['idSucursal']."',1)";
mysql_select_db($database_conexion1, $conexion1);
  $Result1 = mysql_query($insertSQL, $conexion1) or die(mysql_error());	 
header('Location: menu.php');

}else{
echo "Hubo un inconveniente. Contacta a un administrador.";
echo 'Mailer Error: ' . $mail->ErrorInfo;
}
//phpinfo();
?>
<?php

} else {
	$exitGoTo="index.php";
	 header(sprintf("Location: %s", $exitGoTo));  
}
	?>