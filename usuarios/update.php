<?php 
	session_start(); 
   		if (($_SESSION['nivel']==0) &&  ($_SESSION['id']!="")){
  		require_once('../Connections/conexion1.php'); 
  		require_once('../funciones.php');
      $id = $_POST["id"];
  		$user = $_POST["user"];
  		$pass = $_POST["pass"];  		
  		$profile = $_POST["profile"];
  		$name = $_POST["name"];
  		$last_name = $_POST["last_name"];
  		$mail = $_POST["mail"];
  		$phone = $_POST["phone"];
		  mysql_select_db($database_conexion1, $conexion1);
		  $sql="UPDATE usuarios SET username = '$user',pass = '$pass',apellidos = '$last_name',nombres = '$name',correoContacto = '$mail',fonoContacto = $phone WHERE id = $id";
		  mysql_query($sql, $conexion1) or die(mysql_error());
    	$exitGoTo="list_client.php";
    	header(sprintf("Location: %s", $exitGoTo)); 
  		}
  	else {
    	$exitGoTo="../index.php";
    	header(sprintf("Location: %s", $exitGoTo));  
  		}  		