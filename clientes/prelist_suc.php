<?php 
	session_start(); 
   if (($_SESSION['nivel']==0) &&  ($_SESSION['id']!="") || ($_SESSION['id']==70)){
  		require_once('../Connections/conexion1.php'); 
  		require_once('../funciones.php');    
	    $cliente = $_POST["idEmpresa"];
    	$exitGoTo="list_suc.php?idE=".$cliente."";
  		header(sprintf("Location: %s", $exitGoTo));
  		} 
  	else {
    	$exitGoTo="../index.php";
    	header(sprintf("Location: %s", $exitGoTo));  
  		}  	
	?>