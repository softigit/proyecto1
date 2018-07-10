<?php 
    require_once('Connections/conexion1.php'); 
    require_once('funciones.php');
	session_start();   
	if ($_POST["idAgenda"]!="" ){
	    $idUsuario			= $_SESSION['id'];
	    $cia				= $_SESSION['idEmpresa'];   
		$idAgenda		 	= $_POST["idAgenda"];

	    mysql_select_db($database_conexion1, $conexion1);	    

		$queryAgenda = "select * from agenda where idAgenda = $idAgenda";
		$agendaArray = mysql_query($queryAgenda, $conexion1) or die(mysql_error());
		$agendas = mysql_fetch_assoc($agendaArray);	
		$tecnico = $agendas["idTecnico"];

		$queryTecnico = "select * from usuarios where id = $tecnico";
		$tecnicoArray = mysql_query($queryTecnico, $conexion1) or die(mysql_error());
		$tecnicos = mysql_fetch_assoc($tecnicoArray);	


		$sql="DELETE FROM agenda WHERE idAgenda = $idAgenda";
		mysql_query($sql, $conexion1) or die(mysql_error());




		/*correos a enviar*/
		$copia1 = "claudiamyu@gmail.com";//claudia
		$copia2 = $tecnicos['correoContacto'];//tecnico
		$copia3 = "plataformamyu@gmail.com";
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
		//$mail->AddCC($copia1);
		$mail->AddCC($copia3);
		$mail->IsHTML(true); // El correo se envÃ­a como HTML
		$mail->Subject = "Sol N-.".$idAgenda." Eliminada"; 
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
							    <td colspan="5"><strong>La orden '.$idAgenda.' ha sido eliminada</strong></td>
							</tr>
						</table>	
						<br/><br/>		
						<table width="100%" border="0">
							<tr>
							    <td colspan="5">Los tildes fueron omitidos para mejorar la visualizacion del correo</td>
						    </tr>
							<tr>
								<td colspan="5">
									A continuacion puede ver las observaciones hechas para esta solicitud: <br/><br/>
									'.$observa.'
								</td>	
							</tr>
						</table>
					</body>
				</html>';
		$mail->Body = $body; 
		$mail->AltBody = "Orden de visita - Orden Eliminada"; // Texto sin html
		$exito = $mail->Send(); 


	    $exitGoTo="listadoOrdenesAdmin.php?req=0";
	   	header(sprintf("Location: %s", $exitGoTo)); 

		}
	else{
		$exitGoTo="index.php";
		header(sprintf("Location: %s", $exitGoTo));  
		}   	
?>