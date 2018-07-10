<?php 
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
		  mysql_select_db($database_conexion1, $conexion1);
		  $sql="INSERT INTO usuarios (username,pass,apellidos,nombres,nivel,correoContacto,fonoContacto) VALUES ('$user','$pass','$last_name','$name',$profile,'$mail',$phone)";
		  mysql_query($sql, $conexion1) or die(mysql_error());
    	$exitGoTo="list_user.php";
    	header(sprintf("Location: %s", $exitGoTo)); 
  		}
  	else {
    	$exitGoTo="../index.php";
    	header(sprintf("Location: %s", $exitGoTo));  
  		}  		