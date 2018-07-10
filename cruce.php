<?php

require_once('Connections/conexion1.php'); 
 
if (isset($_POST["auth_contextId"])){
	session_start();
	if ($_POST["auth_contextId"]=="logout"){
	    unset($_SESSION["username"]); 
        unset($_SESSION["nivel"]);
        unset($_SESSION["id"]);
        session_destroy();
        $exitGoTo="index.php";	
        header(sprintf("Location: %s", $exitGoTo));
	}
    if ($_POST["auth_contextId"]=="login"){
        unset($_SESSION["username"]); 
        unset($_SESSION["nivel"]);
        unset($_SESSION["id"]);
        session_destroy();
        $username=$_POST["userid"];
        $pass=$_POST["logon-password"]; //off - on
		$recordar=$_POST["logon-slider"];
        mysql_select_db($database_conexion1, $conexion1);
        $sql = "SELECT * FROM usuarios WHERE username ='$username' and pass = '$pass'";
         $DetailRS1 = mysql_query($sql, $conexion1) or die(mysql_error());
         $row_DetailRS1 = mysql_fetch_assoc($DetailRS1);
         if ( $row_DetailRS1['username']==""){
	         session_start();
	         unset($_SESSION["username"]); 
             unset($_SESSION["nivel"]);
             unset($_SESSION["id"]);
             session_destroy();
	         $exitGoTo="index.php";
	         header('Location:'.$exitGoTo);  
          } else {
            session_start(); /* Creamos la sesión */ 
            $_SESSION['username'] = $_POST["userid"]; 
            $_SESSION['nivel'] =	$row_DetailRS1['nivel'];
            $_SESSION['id'] =	$row_DetailRS1['id'];
			
			if ($recordar=="on"){
				
			 mt_srand (time());
      //generamos un número aleatorio
      $numero_aleatorio = mt_rand(1000000,999999999);
      //2) meto la marca aleatoria en la tabla de usuario
        mysql_select_db($database_conexion1, $conexion1);
	  $ssql = "update usuarios set cookie='$numero_aleatorio' where id=" . $row_DetailRS1['id'];
      mysql_query($ssql);	
	 //3) ahora meto una cookie en el ordenador del usuario con el identificador del usuario y la cookie aleatoria
      setcookie("id_usuario_dw", $row_DetailRS1['id'] , time()+(60*60*24*365));
      setcookie("marca_aleatoria_usuario_dw", $numero_aleatorio, time()+(60*60*24*365));			
			}
			if ($recordar=="off"){
mysql_select_db($database_conexion1, $conexion1);
	  $ssql = "update usuarios set cookie='' where id=" . $row_DetailRS1['id'];
      mysql_query($ssql);	
				
				
			}
			switch ($row_DetailRS1['nivel']){
				case 0: header('Location: menuAdministrador.php');
				         break;
				case 1: header('Location: menuTecnico.php');
				         break;
				case 5: header('Location: menuTecnico.php');
				         break;				         
			   default: header('Location: seleccionarEmpresa.php');
			}
			/*	
			if ($row_DetailRS1['nivel']==1){
			header('Location: menuTecnico.php');	
			}else {
				
            header('Location: seleccionarEmpresa.php');
			}
			*/
         }
     }
}



	 

 