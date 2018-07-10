<?
  function numeroEmpresas($idUsuario){
   	include('../Connections/conexion1.php');
 	  mysql_select_db($database_conexion1, $conexion1);
  	$query_Empresas = "SELECT distinct(a.idEmpresa),b.nombreEmpresa FROM `rel_empresa_usuario` as a, empresas as b
    WHERE (a.idEmpresa = b.idEmpresa) and a.idUsuario=$idUsuario order by b.nombreEmpresa ASC";
    $Empresas1 = mysql_query($query_Empresas, $conexion1) or die(mysql_error());
    $numeroEmpresas = mysql_num_rows($Empresas1);
    return $numeroEmpresas;	
    }
function revisarCookie(){
  include('../Connections/conexion1.php'); 
  mysql_select_db($database_conexion1, $conexion1);
  //primero tengo que ver si el usuario está memorizado en una cookie
  if (isset($_COOKIE["id_usuario_dw"]) && isset($_COOKIE["marca_aleatoria_usuario_dw"])){
  //Tengo cookies memorizadas
  //además voy a comprobar que esas variables no estén vacías
    if ($_COOKIE["id_usuario_dw"]!="" || $_COOKIE["marca_aleatoria_usuario_dw"]!=""){
    //Voy a ver si corresponden con algún usuario
      $ssql = "select * from usuarios where id=" . $_COOKIE["id_usuario_dw"] . " and cookie='" . $_COOKIE["marca_aleatoria_usuario_dw"] . "' and cookie<>''";
  	  $rs = mysql_query($ssql);
      if (mysql_num_rows($rs)==1){
        //echo "<b>Tengo un usuario correcto en una cookie</b>";
        $usuario_encontrado = mysql_fetch_object($rs);
        // echo "<br>Eres el usuario número " . $usuario_encontrado->id . ", de nombre " . $usuario_encontrado->username;
        return($usuario_encontrado->username);
   		  //header ("Location: contenidos_protegidos_cookie.php");
        }  
      }   
    }	
  }

function razonSocial($ruta){
  extract($_POST);
  if (strlen($ruta) == 9){
  	$rut=$ruta[0].$ruta[1].$ruta[2].$ruta[3].$ruta[4].$ruta[5].$ruta[6].$ruta[7];
	  $dv=$ruta[8];
    } 
  if (strlen($ruta) == 8){
  	$rut=$ruta[0].$ruta[1].$ruta[2].$ruta[3].$ruta[4].$ruta[5].$ruta[6];
  	$dv=$ruta[7];
    } 
  //set POST variables
  $url = 'https://zeus.sii.cl/cvc_cgi/stc/getstc';
  //$rut='96756430';
  //$dv='3';
  $txt_code='5055';
  $txt_captcha='L2ZwWFk4TnY1YWcyMDE0MTAyNTAyNTA1NmFHM3phbG9nLjRRNTA1NWg5bjRmLzZzSlMuMDB1aEhSbDBuSXVILlFVSTFMa0pPY0U5SE0zSnNkdz09V2pBZTc0bVM3ZEE=';
  $prg='PRG';
  $opc='OPC';
  $aceptar='&nbsp;&nbsp;&nbsp;&nbsp;Consultar situación tributaria&nbsp;&nbsp;&nbsp;&nbsp;';
  $fields_string ='';
  $fields = array(
						'RUT' => urlencode($rut),
						'DV' => urlencode($dv),
						'txt_code' => urlencode($txt_code),
						'txt_captcha' => urlencode($txt_captcha),
						'PRG' => urlencode($prg),
						'OPC' => urlencode($opc),
						'ACEPTAR' => urlencode($aceptar)
				);
				
	foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
  rtrim($fields_string, '&');
  //open connection
  $ch = curl_init();
  //set the url, number of POST vars, POST data
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch,CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // allow https verification if true
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
  curl_setopt($ch,CURLOPT_POST, count($fields));
  curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
  //curl_setopt($ch, CURLOPT_FILE, $fp);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  //$result = curl_exec($ch);
  if( ! $result = curl_exec($ch)){ 
    trigger_error(curl_error($ch)); 
    }  
  //close connection
  curl_close($ch);
  $arreglo2 = explode("text-align:justify'>",$result);
  $arreglo3 = explode("</div>",$arreglo2[1]);
  return $arreglo3[0];
  }

function validaRut($rut){
	$suma =0;
	$factor=0; 
    if(strpos($rut,"-")==false){
        $RUT[0] = substr($rut, 0, -1);
        $RUT[1] = substr($rut, -1);
    }else{
        $RUT = explode("-", trim($rut));
    }
    $elRut = str_replace(".", "", trim($RUT[0]));
    $factor = 2;
    for($i = strlen($elRut)-1; $i >= 0; $i--):
        $factor = $factor > 7 ? 2 : $factor;
        $suma += $elRut{$i}*$factor++;
    endfor;
    $resto = $suma % 11;
    $dv = 11 - $resto;
    if($dv == 11){
        $dv=0;
    }else if($dv == 10){
        $dv="k";
    }else{
        $dv=$dv;
    }
   if($dv == trim(strtolower($RUT[1]))){
       return true;
   }else{
       return false;
   }
}
function is_session_started()
{
    if ( php_sapi_name() !== 'cli' ) {
        if ( version_compare(phpversion(), '5.4.0', '>=') ) {
            return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
        } else {
            return session_id() === '' ? FALSE : TRUE;
        }
    }
    return FALSE;
}

function random_string($length) {
    $key = '';
    $keys = array_merge(range(0, 9), range('a', 'z'));

    for ($i = 0; $i < $length; $i++) {
        $key .= $keys[array_rand($keys)];
    }

    return $key;
}
?>