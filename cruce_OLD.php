<?php 
 session_start();
	         unset($_SESSION["username"]); 
             unset($_SESSION["nivel"]);
             unset($_SESSION["id"]);
             session_destroy();
	$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = 'index.php';
header("Location: http://$host$uri/$extra",TRUE,301);
//header("Location: index.php",TRUE,301);
exit;
?>
<meta http-equiv="refresh" content="1;URL=<?php echo "http://$host$uri/$extra";?>" /> 
