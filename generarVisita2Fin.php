<?php session_start(); 
  if ($_SESSION['idEmpresa']!="" ){
 	if ($_POST["tipoSolicitud"]==""){
	    $exitGoTo="menu.php";
	    header(sprintf("Location: %s", $exitGoTo));  	
		}
    $idUsuario=$_SESSION['id'];
    $cia=$_SESSION['idEmpresa'];   
    require_once('Connections/conexion1.php'); 
    require_once('funciones.php');
	$fechaVisita 	= $_POST["fechaVisita"];
	$jornadaVisita	= $_POST["jornadaVisita"];
	$idSucursal		= $_POST["idSucursal"];
	$responsable	= $_POST["responsable"];
	$tecnico		= $_POST["tecnico"];
	$nroEquipo		= $_POST["nroEquipo"];
	$comentario1	= $_POST["comentario1"];
	$comentario2	= $_POST["comentario2"];
	$comentario3	= $_POST["comentario3"];
	$comentarios	= $_POST["comentarios"];
	$requiere		= $_POST["requiere"];
	switch($requiere){
	    case '1':$estado = "En espera de Tecnico"; break;
	    case '2':$estado = "Pendiente de Aprobacion"; break;
	    case '3':$estado = "Pendiente de Cotizacion"; break;
	    case '4':$estado = "Listo y Pendiente de Cotizacion"; break;
	    case '5':$estado = "Listo para Comenzar"; break;
	    case '6':$estado = "En Proceso"; break;
	    case '7':$estado = "Listo"; break;
	    }	
	switch($comentario1){
	    case '1':$coment1 = "Equipo gotea"; break;
	    case '2':$coment1 = "Equipo no enciende"; break;
	    case '3':$coment1 = "Equipo no enfria"; break;
	    case '4':$coment1 = "Equipo emite ruido"; break;
	    case '5':$coment1 = "Otro"; break;
	    case '6':$coment1 = "Equipo no genera calor"; break;
	    }		
	switch($comentario2){
	    case '1':$coment2 = "Equipo gotea"; break;
	    case '2':$coment2 = "Equipo no enciende"; break;
	    case '3':$coment2 = "Equipo no enfria"; break;
	    case '4':$coment2 = "Equipo emite ruido"; break;
	    case '5':$coment2 = "Otro"; break;
	    case '6':$coment2 = "Equipo no genera calor"; break;
	    }	
	switch($comentario3){
	    case '1':$coment3 = "Equipo gotea"; break;
	    case '2':$coment3 = "Equipo no enciende"; break;
	    case '3':$coment3 = "Equipo no enfria"; break;
	    case '4':$coment3 = "Equipo emite ruido"; break;
	    case '5':$coment3 = "Otro"; break;
	    case '6':$coment3 = "Equipo no genera calor"; break;
	    }		        
    mysql_select_db($database_conexion1, $conexion1);	    
	$queryAgenda = "select * from agenda order by idAgenda DESC";
	$agendaArray = mysql_query($queryAgenda, $conexion1) or die(mysql_error());
	$agendas = mysql_fetch_assoc($agendaArray);
	$idAgenda = $agendas['idAgenda'] + 1;		

	if 	($nroEquipo == ''){
		$nroEquipo = 99999;
		$equipo = "No informado";
		}
	else{
		$equipo = $nroEquipo;
		}	
	$sql="INSERT INTO agenda (idAgenda,idEmpresa,idusuario,tipoSolicitud,comentario,fechaVisita,jornadaVisita,idUsuarioConfirma,estado,idSucursal,comentario1,comentario2,comentario3,nroEquipo,idTecnico,requiere) 
	VALUES ($idAgenda,$cia,$idUsuario,1,'$comentarios','$fechaVisita','$jornadaVisita',$responsable,'$estado',$idSucursal,$comentario1,$comentario2,$comentario3,$nroEquipo,$tecnico,$requiere)";
	mysql_query($sql, $conexion1) or die(mysql_error());
	/*servicio de correo*/
		/*data correo*/
			$idMandante = $responsable;
			$idTecnico = $tecnico;
			$fechaSolicitud = date("d-m-Y");

		    $queryMandante = "select * from usuarios where id = $idMandante";
		    $mandanteArray = mysql_query($queryMandante, $conexion1) or die(mysql_error());
		    $mandantes = mysql_fetch_assoc($mandanteArray);
		    $mandante = $mandantes['nombres']." ".$mandantes['apellidos'];		
			$fonoContacto = $mandantes['fonoContacto'];
			$mandaneteMail = $mandantes['correoContacto'];

		    $querySucursal = "select * from sucursal where idSucursal = $idSucursal";
		    $sucursalArray = mysql_query($querySucursal, $conexion1) or die(mysql_error());
		    $sucursales = mysql_fetch_assoc($sucursalArray);
		    $sucursal = $sucursales['nombreSucursal'];
		    $idEmpresa = $sucursales['idEmpresa'];

		    $queryempresas = "select * from empresas where idEmpresa = $idEmpresa";
		    $empresaArray = mysql_query($queryempresas, $conexion1) or die(mysql_error());
		    $empresas = mysql_fetch_assoc($empresaArray);
		    $empresa = $empresas['nombreEmpresa'];		    

		    $queryTecnico = "select * from usuarios where id = $idTecnico";
		    $tecnicoArray = mysql_query($queryTecnico, $conexion1) or die(mysql_error());
		    $tecnicos = mysql_fetch_assoc($tecnicoArray);	

		/*fin data correo*/
		/*correos a enviar*/
			$copia1 = "claudiamyu@gmail.com";//claudia
			$copia2 = $tecnicos['correoContacto'];//tecnico
			$copia3 = "plataformamyu@gmail.com";//Francisco
		/*FIn correos enviar*/
		//$host_mail="localhost";
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
		$mail->Subject = "Sol N-.".$idAgenda." Creada"; 
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
						    <td colspan="2"><strong>Fecha  Solicitud</strong></td>
						    <td width="35%">'.$fechaSolicitud.'</td>
						    <td width="21%">&nbsp;</td>
						    <td width="21%">&nbsp;</td>
						</tr>
						<tr>
						    <td colspan="2"><strong>Numero:</strong></td>
						    <td colspan="3">'.$idAgenda.'</td>
						</tr>
						<tr>
						    <td colspan="2"><strong>Estado:</strong></td>
						    <td colspan="3">'.$estado.'</td>
						</tr>
						<tr>
						    <td colspan="2"><strong>Solicita:</strong></td>
						    <td colspan="3">'.$mandante.'</td>
						</tr>
						<tr>
						    <td colspan="2"><strong>Fono:</strong></td>
						    <td colspan="3">'.$fonoContacto.'</td>
						</tr>
						<tr>
						    <td colspan="2"><strong>Empresa:</strong></td>
						    <td colspan="3">'.$empresa.'</td>
						</tr>
						<tr>
						  	<td colspan="2"><strong>Sucursal:</strong></td>
						    <td colspan="3">'.$sucursal.'</td>
						</tr>
						<tr>
						  	<td colspan="2"><strong>Nro Equipo:</strong></td>
						    <td colspan="3">'.$equipo.'</td>
						</tr>
						<tr>
						    <td colspan="5">&nbsp;</td>
						</tr>
						<tr>
						    <td colspan="2"><strong>Fecha de visita</strong></td>
						    <td>'.$fechaVisita.'</td>
						    <td>&nbsp;</td>
						    <td>&nbsp;</td>
						</tr>
						<tr>
						    <td colspan="2"><strong>Jornada de Visita</strong></td>
						    <td>'.$jornadaVisita.'</td>
						    <td>&nbsp;</td>
						    <td>&nbsp;</td>
						</tr> 
						<tr>
						    <td colspan="2"><strong>Comentario 1</strong></td>
						    <td colspan="3">'.$coment1.'</td>
						</tr>
						<tr>
						    <td colspan="2"><strong>Comentario 2</strong></td>
						    <td colspan="3">'.$coment2.'</td>
						</tr>
						<tr>
						    <td colspan="2"><strong>Comentario 3</strong></td>
						    <td colspan="3">'.$coment3.'</td>
						</tr>
						<tr>
						    <td colspan="2"><strong>Obs</strong></td>
						    <td colspan="3">'.$comentarios.'</td>
						</tr>
						<tr>
						    <td width="13%">&nbsp;</td>
						    <td width="10%">&nbsp;</td>
						    <td>&nbsp;</td>
						    <td>&nbsp;</td>
						    <td>&nbsp;</td>
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
		$mail->AltBody = "Orden de visita - Creada"; // Texto sin html
		$exito = $mail->Send(); 

    $exitGoTo="ordenVisita2.php";
    header(sprintf("Location: %s", $exitGoTo)); 
    } else {
  	$exitGoTo="index.php";
	  header(sprintf("Location: %s", $exitGoTo));  
    }