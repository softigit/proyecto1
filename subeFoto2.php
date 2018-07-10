<?php 
  error_reporting(E_ALL);
 session_start(); 
  if ($_GET["idM"] == ""){
    $exitGoTo="menuAdministrador.php";
    header(sprintf("Location: %s", $exitGoTo));    
    }
  $idM = $_GET["idM"];
  $sucursal = $_GET["idS"];
  require_once('Connections/conexion1.php'); 
  require_once('funciones.php');
  $idUsuario =$_SESSION['id'];

  mysql_select_db($database_conexion1, $conexion1);
  $directorio= "fotos/";
  $nombre_foto1="";
  $nombre_foto2=""; 
  if ($_FILES['foto2']['name']!=""){
      $target_path = $directorio .random_string(15). $_FILES['foto2']['name']; 
      move_uploaded_file($_FILES['foto2']['tmp_name'], $target_path);
      $nombre_foto2=$target_path;
      }
  $sql="UPDATE mantencion SET foto2 = '$nombre_foto2' WHERE idmantencion = $idM";
  mysql_query($sql, $conexion1) or die(mysql_error());
  //echo $sql;
  /*servicio de correo*/
 /*data correo*/
          $idTecnico = $_SESSION['id'];
          $queryTecnico = "select * from usuarios where id = $idTecnico";
          $tecnicoArray = mysql_query($queryTecnico, $conexion1) or die(mysql_error());
          $tecnicos = mysql_fetch_assoc($tecnicoArray); 
          $nombreTecnico = $tecnicos["nombres"]." ".$tecnicos["apellidos"];

          $mantencion = "select * from mantencion where idmantencion = $idM";
          $mantencionArray = mysql_query($mantencion, $conexion1) or die(mysql_error());
          $mantenciones = mysql_fetch_assoc($mantencionArray); 
          $idE = $mantenciones["idEquipo"];
          $fecha = $mantenciones["fecha"]; 
          $desarmaFecha = explode('-',$fecha);
          $anio = $desarmaFecha[0];
          $mes = $desarmaFecha[1];
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
        $mail->Subject = "Foto2 agregada a la mantención N-.".$idM; 
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
                    <td colspan="5"><strong>Informamos que el tecnico '.$nombreTecnico.' ha agregado una segunda foto</strong></td>
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
        $mail->AltBody = "Mantención - ingreso Foto 2"; // Texto sin html
        $exito = $mail->Send();   
      //fin correo  
    
    $exitGoTo="ingresaMantencionTecnico3.php?idM=$idM&idE=$idE&sucursal=$sucursal&mes=$mes&anio=$anio";   
    header(sprintf("Location: %s", $exitGoTo));
  ?>