<?php 
  error_reporting(E_ALL);
	session_start(); 
  		require_once('Connections/conexion1.php'); 
  		require_once('funciones.php');
      $idSucursal   = $_POST["idSucursal"];
      $NroEquipo    = $_POST["NroEquipo"];
      $idEquipo     = $_POST["idEquipo"];
      $mes          = $_POST["mes"];
      $anio         = $_POST["anio"];
      $IdMarca      = $_POST["IdMarca"];
      $presentacion = $_POST["presentacion"];
      $btu          = $_POST["btu"];
      $refrigerante = $_POST["refrigerante"];
      $piso         = $_POST["piso"];
      $oficinaSala  = $_POST["oficinaSala"];
      $edificio     = $_POST["edificio"];                    
		  mysql_select_db($database_conexion1, $conexion1);
		  $sql="UPDATE equipo SET nroEquipo = $NroEquipo,IdMarca = $IdMarca, presentacion = '$presentacion', btu = '$btu', refrigerante = '$refrigerante', piso = '$piso', oficinaSala = '$oficinaSala' , idEdificio = $edificio WHERE idEquipo = $idEquipo";
		  mysql_query($sql, $conexion1) or die(mysql_error());
        /*servicio de correo*/
         /*data correo*/
          $idTecnico = $_SESSION['id'];
          $queryTecnico = "select * from usuarios where id = $idTecnico";
          $tecnicoArray = mysql_query($queryTecnico, $conexion1) or die(mysql_error());
          $tecnicos = mysql_fetch_assoc($tecnicoArray); 
          $nombreTecnico = $tecnicos["nombres"]." ".$tecnicos["apellidos"];

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
        $mail->AddAddress($copia2); 
        $mail->IsHTML(true); // El correo se envÃ­a como HTML
        $mail->Subject = "Equipo N-.".$NroEquipo." Editado"; 
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
                    <td colspan="5"><strong>Informamos que el tecnico '.$nombreTecnico.' ha editado el equipo nro '.$NroEquipo.' perteneciente a la sucursal '.$sucursal.' de la empresa '.$empresa.'</strong></td>
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
      $exitGoTo="ingresaMantencionTecnico.php?&idE=$idEquipo&sucursal=$idSucursal&mes=$mes&anio=$anio";
     	header(sprintf("Location: %s", $exitGoTo)); 
		