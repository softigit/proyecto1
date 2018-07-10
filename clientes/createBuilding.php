<?php 
  error_reporting(E_ALL);
  session_start(); 
   if (($_SESSION['nivel']==0) &&  ($_SESSION['id']!="")){
      require_once('../Connections/conexion1.php'); 
      require_once('../funciones.php');
      $idEmpresa = $_POST["cliente"];
      $idSucursal = $_POST["sucursa"];
      $name = $_POST["name"];
      $dire = $_POST["dire"];

      mysql_select_db($database_conexion1, $conexion1);
      $sql="INSERT INTO edificio (nombreEdificio,idSucursal,direccion) VALUES ('$name',$idSucursal,'$dire')";
      mysql_query($sql, $conexion1) or die(mysql_error());

      $sql2 = "SELECT * FROM empresas  WHERE idEmpresa = $idEmpresa";
      $result2  = mysql_query($sql2, $conexion1) or die(mysql_error());
      while ($empresas = mysql_fetch_array($result2)){
        $cia = $empresas["nombreEmpresa"];
        }

      $sql3 = "SELECT * FROM sucursal  WHERE idSucursal = $idSucursal";
      $result3  = mysql_query($sql3, $conexion1) or die(mysql_error());
      while ($sucursal = mysql_fetch_array($result3)){
        $nombreSucursal = $sucursal["nombreSucursal"];
        }

      /*correos a enviar*/
        $ciaMail = strtoupper($cia);
        $nombreSucursalMail = strtoupper($nombreSucursal);
        $nombreEdificioMail = strtoupper($name);
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
        require("../PHPMailerAutoload.php");
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
        $mail->AddAddress("rene@softiago.cl");         
        $mail->IsHTML(true); // El correo se envÃ­a como HTML
        $mail->Subject = $ciaMail." - SUCURSAL ".$nombreSucursalMail." : Nuevo Edificio"; 
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
                    <td colspan="5"><strong>Informamos se ha creado un nuevo edificio asociado al cliente '.$ciaMail.'</strong></td>
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
        $mail->AltBody = "Nuevo Edificio"; // Texto sin html
        $exito = $mail->Send();   
      //fin correo  

      $exitGoTo="list_suc.php?idE=".$idEmpresa."";
      header(sprintf("Location: %s", $exitGoTo)); 
      }
    else {
      $exitGoTo="../index.php";
      header(sprintf("Location: %s", $exitGoTo));  
      }     