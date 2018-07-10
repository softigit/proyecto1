<?php 
	session_start(); 
   if (($_SESSION['nivel']==0) &&  ($_SESSION['id']!="")){
  		require_once('../Connections/conexion1.php'); 
  		require_once('../funciones.php');
  		$cliente = $_POST["cliente"];
  		$name = strtoupper($_POST["name"]);  		
      $encargado = strtoupper($_POST["encargado"]);     
      $mail = $_POST["mail"];     
      $tecnico = $_POST["tecnico"];   

		  mysql_select_db($database_conexion1, $conexion1);
		  $sql="INSERT INTO sucursal (nombreSucursal,idEmpresa,Encargado,Email,Tecnico) VALUES ('$name',$cliente,'$encargado','$mail',$tecnico)";
		  mysql_query($sql, $conexion1) or die(mysql_error());

      $sql2 = "SELECT * FROM empresas  WHERE idEmpresa = $cliente";
      $result2  = mysql_query($sql2, $conexion1) or die(mysql_error());
      while ($empresas = mysql_fetch_array($result2)){
        $cia = $empresas["nombreEmpresa"];
        }

      /*correos a enviar*/
        $ciaMail = strtoupper($cia);
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
        $mail->IsHTML(true); // El correo se envÃ­a como HTML
        $mail->Subject = $ciaMail." - SUCURSAL CREADA"; 
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
                    <td colspan="5"><strong>Informamos se ha creado la sucursal '.$name.' asociada al cliente '.$ciaMail.'</strong></td>
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
        $mail->AltBody = "Nueva Sucursal"; // Texto sin html
        $exito = $mail->Send();   
      //fin correo  

      $exitGoTo="list_suc.php?idE=".$cliente."";
    	header(sprintf("Location: %s", $exitGoTo)); 
  		}
  	else {
    	$exitGoTo="../index.php";
    	header(sprintf("Location: %s", $exitGoTo));  
  		}  		