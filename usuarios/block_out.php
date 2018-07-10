<?php 
	session_start(); 
   		if (($_SESSION['nivel']==0) &&  ($_SESSION['id']!="")){
  		require_once('../Connections/conexion1.php'); 
  		require_once('../funciones.php');
      $id = $_POST["idCliente"];
      $length = 7;
      $randomString = '012..OPQR';
		  mysql_select_db($database_conexion1, $conexion1);
		  $sql="UPDATE usuarios SET pass = '$randomString', estado = 1 WHERE id = $id";
		  mysql_query($sql, $conexion1) or die(mysql_error());
    	$exitGoTo="list_client.php";
    	header(sprintf("Location: %s", $exitGoTo)); 
  		}
  	else {
    	$exitGoTo="../index.php";
    	header(sprintf("Location: %s", $exitGoTo));  
  		}  		