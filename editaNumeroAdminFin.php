<?php 
    require_once('Connections/conexion1.php'); 
    require_once('funciones.php');
	session_start();   
	if ($_SESSION['idEmpresa']!="" ){
	    $idUsuario			= $_SESSION['id'];
	    $cia				= $_SESSION['idEmpresa'];   
		$idAgenda		 	= $_POST["idorden"];
		$idSucursal		 	= $_POST["idSucursal"];
		$nequipo 			= $_POST["nequipo"]; 

		$fecha = date("Y-m-d"); 	    
	    mysql_select_db($database_conexion1, $conexion1);	    
		$sql="UPDATE agenda SET idSucursal =  $idSucursal, nroEquipo = $nequipo WHERE idAgenda = $idAgenda";
		mysql_query($sql, $conexion1) or die(mysql_error());

		$observaHecha = "CAMBIO DE NUMERO";
		$sql2="INSERT INTO agenda_observaciones (agenda_id,usuario_id,observacion,fecha) VALUES ($idAgenda,$idUsuario,'$observaHecha','$fecha')";
		mysql_query($sql2, $conexion1) or die(mysql_error());
		//data correo
		$queryAgenda = "select * from agenda where idAgenda = $idAgenda";
		$agendaArray = mysql_query($queryAgenda, $conexion1) or die(mysql_error());
		$agendas = mysql_fetch_assoc($agendaArray);		
		$idTecnico = $agendas['idTecnico'];

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
			  	if (($row["observacion"] == 'CAMBIO DE TECNICO') || ($row["observacion"] == 'CAMBIO DE NUMERO') ){
					$observa .= $acc."- ".strtoupper($row["observacion"])." HECHO EL ".$fecha." POR ".$nombreUsuarioObserva."<br/>";
			   		}
			   	else {		
			       	$observa .= $acc."- ".strtoupper($row["observacion"])." HECHA EL ".$fecha." POR ".$nombreUsuarioObserva."<br/>";
			       	}
			    }
			$acc++;
			}
		/*correos a enviar*/
		$copia1 = "claudiamyu@gmail.com";//claudia
		$copia2 = $tecnicos['correoContacto'];//tecnico
		$copia3 = "plataformamyu@gmail.com";
		$nombreTecnicoNuevo = $tecnicos["nombres"]." ".$tecnicos["apellidos"];
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
		$mail->Subject = "Sol N-.".$idAgenda." Cambio de Numero"; 
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
							    <td colspan="5"><strong>El numero de equipo asociada a la orden de visita numero '.$idAgenda.' ha cambiado al numero '.$nequipo.'</strong></td>
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
		$mail->AltBody = "Orden de visita - Cambio de tecnico"; // Texto sin html
		$exito = $mail->Send(); 


	    $exitGoTo="gestionOrdenesAdmin.php?idAg=".$idAgenda."";
	   	header(sprintf("Location: %s", $exitGoTo)); 

		}
	else{
		$exitGoTo="index.php";
		header(sprintf("Location: %s", $exitGoTo));  
		}   	
?>