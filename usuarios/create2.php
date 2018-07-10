<?php 
error_reporting(E_ALL);
ini_set('display_errors', '1');
	session_start(); 
    if (($_SESSION['nivel']==0) &&  ($_SESSION['id']!="")){
  		require_once('../Connections/conexion1.php'); 
  		require_once('../funciones.php');
  		$user = $_POST["user"];
  		$pass = $_POST["pass"];  		
  		$profile = $_POST["profile"];
  		$name = $_POST["name"];
  		$last_name = $_POST["last_name"];
  		$mail = $_POST["mail"];
  		$phone = $_POST["phone"];
  		$empresa = $_POST["empresa"];
		mysql_select_db($database_conexion1, $conexion1);		
		$sqlUser = "SELECT * FROM usuarios ORDER BY id DESC LIMIT 1";
		$userArray = mysql_query($sqlUser, $conexion1) or die(mysql_error());
		$usuarios = mysql_fetch_assoc($userArray);
		$idUser = $usuarios["id"] + 1;	
		$sql="INSERT INTO usuarios (id,username,pass,apellidos,nombres,nivel,correoContacto,fonoContacto) VALUES ($idUser,'$user','$pass','$last_name','$name',$profile,'$mail',$phone)";
		mysql_query($sql, $conexion1) or die(mysql_error());
		
		$sql2="INSERT INTO rel_empresa_usuario (idUsuario,idEmpresa) VALUES ($idUser,$empresa)";
		mysql_query($sql2, $conexion1) or die(mysql_error());



    	$exitGoTo="index.php";
    	header(sprintf("Location: %s", $exitGoTo)); 
  		}
  	else {
    	$exitGoTo="../index.php";
    	header(sprintf("Location: %s", $exitGoTo));  
  		}  		