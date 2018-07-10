<?php session_start(); 
  if ($_SESSION['idEmpresa']!="" ){
    $idUsuario=$_SESSION['id'];
    $cia=$_SESSION['idEmpresa'];   
    require_once('Connections/conexion1.php'); 
    require_once('funciones.php');
	$requiere		= $_POST["requiere"];
	$idAgenda		= $_POST["idAgenda"];
	$observaHecha	= $_POST["observa"];

	if ($observaHecha == ''){
		$observaHecha = "CAMBIO DE ESTADO";
		}

	switch($requiere){
	    case '1':$estado = "En espera de Tecnico"; break;
	    case '2':$estado = "Pendiente de Aprobacion"; break;
	    case '3':$estado = "Pendiente de Cotizacion"; break;
	    case '4':$estado = "Listo y Pendiente de Cotizacion"; break;
	    case '5':$estado = "Listo para Comenzar"; break;
	    case '6':$estado = "En Proceso"; break;
	    case '7':$estado = "Listo"; break;
	    }	
	$fecha = date("Y-m-d"); 	    
    mysql_select_db($database_conexion1, $conexion1);	    
	$sql="UPDATE agenda SET requiere =  $requiere, estado = '$estado' WHERE idAgenda = $idAgenda";
	mysql_query($sql, $conexion1) or die(mysql_error());
	$sql2="INSERT INTO agenda_observaciones (agenda_id,usuario_id,observacion,fecha) VALUES ($idAgenda,$idUsuario,'$observaHecha','$fecha')";
	mysql_query($sql2, $conexion1) or die(mysql_error());
	if (($requiere == 1) || ($requiere == 2) || ($requiere == 3) || ($requiere == 4) || ($requiere == 5) || ($requiere == 6) || ($requiere == 7)){
	/*servicio de correo*/
		/*data correo*/
		    $queryAgenda = "select * from agenda where idAgenda = $idAgenda";
		    $agendaArray = mysql_query($queryAgenda, $conexion1) or die(mysql_error());
		    $agendas = mysql_fetch_assoc($agendaArray);		
			$idMandante = $agendas['idUsuarioConfirma'];
			$idTecnico = $agendas['idTecnico'];

		    $queryMandante = "select * from usuarios where id = $idMandante";
		    $mandanteArray = mysql_query($queryMandante, $conexion1) or die(mysql_error());
		    $mandantes = mysql_fetch_assoc($mandanteArray);		
			$mandaneteMail = $mandantes['correoContacto'];		    

		    $queryTecnico = "select * from usuarios where id = $idTecnico";
		    $tecnicoArray = mysql_query($queryTecnico, $conexion1) or die(mysql_error());
		    $tecnicos = mysql_fetch_assoc($tecnicoArray);	

		    $queryObservaciones = "select * from agenda_observaciones where agenda_id = $idAgenda";
		    $observacionesArray = mysql_query($queryObservaciones, $conexion1) or die(mysql_error());
		    $acc = 1;
			while ($row = mysql_fetch_array($observacionesArray)){
			    $fecha = date("d-m-Y",strtotime($row["fecha"]));
			      $userObserva = $row["usuario_id"];
			      $queryUsuario = "select * from usuarios where id = $userObserva";
			      $usuarioArray = mysql_query($queryUsuario, $conexion1) or die(mysql_error());
			      $usuarios = mysql_fetch_assoc($usuarioArray);
			      $nombreUsuarioObserva=$usuarios['nombres']." ".$usuarios['apellidos'];    

			      if ($row["observacion"] == 'CAMBIO DE ESTADO'){
			        $observa .= $acc."- CAMBIO DE ESTADO HECHO EL ".$fecha." POR ".$nombreUsuarioObserva."<br/>";
			        }
			      else{
			        $observa .= $acc."- ".strtoupper($row["observacion"])." HECHA EL ".$fecha." POR ".$nombreUsuarioObserva."<br/>";
			        }
			    $acc++;
			    }
		/*fin data correo*/
		/*correos a enviar*/
			$mandaneteMail = $mandantes['correoContacto'];
			$copia3 = "claudiamyu@gmail.com";//claudia
			$copia2 = $tecnicos['correoContacto'];//tecnico
			$copia1 = "plataformamyu@gmail.com";//Francisco
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
		$mail->AddAddress($mandaneteMail); 
		$mail->AddCC($copia1);
		$mail->AddCC($copia3);
		if (($requiere == 1) || ($requiere == 3) || ($requiere == 5) || ($requiere == 6) || ($requiere == 7)){			
			$mail->AddCC($copia2);
			} 
		$mail->IsHTML(true); // El correo se envÃ­a como HTML
		$mail->Subject = "Sol N-.".$idAgenda." Cambio de estado"; 
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
						    <td colspan="5"><strong>La orden de visita numero '.$idAgenda.' ha pasado al estado '.$estado.'</strong></td>
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
		$mail->AltBody = "Orden de visita - Cambio de estado"; // Texto sin html
		$exito = $mail->Send(); 
		}

    $exitGoTo="EstadoOrdenesAdmin.php";
    header(sprintf("Location: %s", $exitGoTo));  		
	  } else {
  	$exitGoTo="index.php";
	  header(sprintf("Location: %s", $exitGoTo));  
    }