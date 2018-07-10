<?php
$hostname_conexion1 = "localhost";
$database_conexion1 = "renegala_mantencion";
$username_conexion1 = "renegala_man";
$password_conexion1 = "man..2016";
$conexion1 = mysql_connect($hostname_conexion1, $username_conexion1, $password_conexion1) or trigger_error(mysql_error(),E_USER_ERROR); 
?>