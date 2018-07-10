<?php 
 session_start(); 
if (($_SESSION['nivel']==0) &&  ($_SESSION['id']!="") || ($_SESSION['id']==70)){
  	require_once('../Connections/conexion1.php'); 
  	require_once('../funciones.php');
  	$idEq = $_GET["idEq"];
  	mysql_select_db($database_conexion1, $conexion1);
  	$consulta = "SELECT * FROM equipo WHERE idEquipo = $idEq";
  	$result  = mysql_query($consulta, $conexion1) or die(mysql_error());
  	while ($row = mysql_fetch_array($result)){
  		$idEd = $row["idEdificio"];
  		}
  	mysql_query("DELETE FROM equipo WHERE idEquipo = $idEq",$conexion1);
    $exitGoTo="listEquipment.php?idEd=".$idEd."";
   	header(sprintf("Location: %s", $exitGoTo)); 
	}
else {
   	$exitGoTo="../index.php";
   	header(sprintf("Location: %s", $exitGoTo));  
	} 
	?>