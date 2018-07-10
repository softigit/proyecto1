<?php 
require_once("lib/class.excel.writer.php");
require_once('Connections/conexion1.php');
require_once('funciones.php');
     $mes= $_GET['mes'];
		 $anio = $_GET['anio'];
		 $idSucursal=$_GET["idSucursal"];
     if (($mes == "01") || ($mes == "02") || ($mes == "03")){
        $mes1 = "01";$mes2 = "02";$mes3 = "03";
        }
     if (($mes == "04") || ($mes == "05") || ($mes == "06")){
        $mes1 = "04";$mes2 = "05";$mes3 = "06";
        }
     if (($mes == "07") || ($mes == "08") || ($mes == "09")){
        $mes1 = "07";$mes2 = "08";$mes3 = "09";
        }
     if (($mes == "10") || ($mes == "11") || ($mes == "12")){
        $mes1 = "10";$mes2 = "11";$mes3 = "12";
        }
		 $sql="SELECT a.idmantencion, 
EXTRACT(MONTH FROM a.fecha) AS mes,
EXTRACT(YEAR FROM a.fecha) AS anio,
a.*,
b.idEquipo,
b.nroEquipo as nroEquipo,
b.oficinaSala as oficinaSala,
b.idEdificio,
c.idEdificio,
c.nombreEdificio as nombreEdificio,
d.nombreSucursal as nombreSucursal
from 
mantencion as a,
equipo as b,
edificio as c,
sucursal as d
where a.idEquipo = b.idEquipo
and ( EXTRACT(MONTH FROM a.fecha) = '$mes1' 
or EXTRACT(MONTH FROM a.fecha) = '$mes2'
or EXTRACT(MONTH FROM a.fecha) = '$mes3')
and EXTRACT(YEAR FROM a.fecha) = '$anio'
and b.idEdificio = c.idEdificio";
if ($idSucursal !='T'){
$sql.=" and c.idSucursal = '$idSucursal' ";}
$sql.="  and c.idSucursal = d.idSucursal order by d.nombreSucursal,b.nroEquipo ;";
 mysql_select_db($database_conexion1, $conexion1);
  $result = mysql_query($sql, $conexion1) or die(mysql_error());
  $numero = mysql_num_rows($result);
  $meses = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
	$titulosColumnas = array(
'A&Ntilde;O', //A1
'MES', //B3
'CAMPUS', //C3
'EDIFICIO',//D3
'NRO',//E3
'OFICINA', //F3
'FECHA', //G3
'PILA', //H3
'CONTROL', //I3
'SE&Ntilde;AL',//J3
'TEMPERATURA', //K3
'INYECCION', //L3
'RETORNO', //M3
'LIMP.FILTRO', //N3
'BANDEJA DESAGUE',//O3
'BOMBA', //P3
'REAP. TERMINALES', //Q3
'LIMP. CONDENSADORES', //R3
'CONSUMO', //S3
'CARGA', //T3
'OBS', //U3
'TECNICO' //V3

);


/* empieza detectar dispositivo*/
$tablet_browser = 0;
$mobile_browser = 0;
$body_class = 'desktop';
 
if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
    $tablet_browser++;
    $body_class = "tablet";
}
 
if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
    $mobile_browser++;
    $body_class = "mobile";
}
 
if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
    $mobile_browser++;
    $body_class = "mobile";
}
 
$mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
$mobile_agents = array(
    'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
    'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
    'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
    'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
    'newt','noki','palm','pana','pant','phil','play','port','prox',
    'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
    'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
    'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
    'wapr','webc','winw','winw','xda ','xda-');
 
if (in_array($mobile_ua,$mobile_agents)) {
    $mobile_browser++;
}
 
if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'opera mini') > 0) {
    $mobile_browser++;
    //Check for tablets on opera mini alternative headers
    $stock_ua = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])?$_SERVER['HTTP_X_OPERAMINI_PHONE_UA']:(isset($_SERVER['HTTP_DEVICE_STOCK_UA'])?$_SERVER['HTTP_DEVICE_STOCK_UA']:''));
    if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
      $tablet_browser++;
    }
}
/*termina detectar dispositivo*/

if ($tablet_browser > 0 || $mobile_browser > 0  ) {
// Si es tablet has lo que necesites
   //print 'es tablet o mobil';
  if ($numero==0){ 
   echo "<html><head></head><body><H2>No existen Mantenciones</H2></body></Html>";
  }
  if ($numero>0){ 
  //echo $sql;
   echo "<html><head></head><body><H2>Informe de Mantenci&oacute;n</H2>";
   echo "<b>Fecha Informe:  ".date("d-m-Y")."</b></br>";
   echo "<b>".$meses[$mes-1]." ".$anio."</b></br>";
   echo "<table border='1'>";
   echo "<tr bgcolor='D5C9C9'>";
   foreach($titulosColumnas  as $cod=>$val){echo "<td>".$val."</td>";}
   echo "</tr>";
   
   while($fila = mysql_fetch_array($result)){
	echo "<tr>";
	    $sucursal=$fila['nombreSucursal'];
      $fecha_arr=explode('-',$fila['fecha']);
      $fecha=$fecha_arr[2].'-'.$fecha_arr[1].'-'.$fecha_arr[0];
      $tecnico=devuelveNombre($fila['idUsuario'],'usuarios','id','nombres').' '.devuelveNombre($fila['idUsuario'],'usuarios','id','apellidos');
  echo "<td>".$fila['anio']."</td>";
  echo "<td>".$meses[$fila['mes']-1]."</td>";
  echo "<td>".$fila['nombreSucursal']."</td>";
  echo "<td>".$fila['nombreEdificio']."</td>";
  echo "<td>".$fila['nroEquipo']."</td>";
  echo "<td>".$fila['oficinaSala']."</td>";
  echo "<td>".$fecha."</td>";
  echo "<td>",($fila['pila']>0)?"Si":"No", "</td>";
  echo "<td>",($fila['control']>0)?"Si":"No", "</td>";
  echo "<td>",($fila['senal']>0)?"Si":"No", "</td>";
  echo "<td>",($fila['temperatura']>0)?"Si":"No", "</td>";
  echo "<td>".$fila['inyeccion']."</td>";
  echo "<td>".$fila['retorno']."</td>";
  echo "<td>",($fila['filtro']>0)?"Si":"No", "</td>";
  echo "<td>",($fila['desague']>0)?"Si":"No", "</td>";
  echo "<td>",($fila['bomba']>0)?"Si":"No", "</td>";
  echo "<td>",($fila['terminales']>0)?"Si":"No", "</td>";
  echo "<td>",($fila['condensadores']>0)?"Si":"No", "</td>";
  echo "<td>".$fila['consumo']."</td>";
  echo "<td>".$fila['carga']."</td>";
  echo "<td>&nbsp;".$fila['observacion']."</td>";
  echo "<td>".$tecnico."</td>";
  echo "</tr>";
  } 
echo "</table>";
   
   echo "</body> </html>";
}
}
/*
else if ($mobile_browser > 0) {
// Si es dispositivo mobil has lo que necesites
   print 'es un mobil';
}*/
else {
// Si es ordenador de escritorio has lo que necesites
//   print 'es un ordenador de escritorio';



 
	if ($numero>0){  

	$xls = new ExcelWriter();

$xls_date = array('type'=>'date');
$xls_int = array('type'=>'int');
$xls->OpenRow();
$xls->NewCell("Informe de Mantención",false,array('bold'=>true));
$xls->CloseRow();
$xls->OpenRow();
$xls->NewCell("Fecha Informe:  ".date("d-m-Y"),false,array('bold'=>true));
$xls->CloseRow();
$xls->OpenRow();
$xls->NewCell($meses[$mes-1],false,array('bold'=>true));
$xls->NewCell($anio,false,array('bold'=>true));
$xls->CloseRow();
$xls->OpenRow();
$xls->CloseRow();

$xls->OpenRow();
	foreach($titulosColumnas  as $cod=>$val)	$xls->NewCell($val,true,array('bold'=>true,'align'=>'center','background'=>'D5C9C9'));
	$xls->CloseRow();
	
$rowCount = 1;
while($fila = mysql_fetch_array($result)){
  if ($fila['observacion'] == ''){
    $xls->OpenRow();
      $xls->NewCell($fila['anio'],false);
      $xls->NewCell($meses[$fila['mes']-1],false);
      $xls->NewCell($fila['nombreSucursal'],false);
      $sucursal=$fila['nombreSucursal'];
      $xls->NewCell($fila['nombreEdificio'],false);
      $xls->NewCell($fila['nroEquipo'],false);
      $xls->NewCell($fila['oficinaSala'],false);
      $fecha_arr=explode('-',$fila['fecha']);
      $fecha=$fecha_arr[2].'-'.$fecha_arr[1].'-'.$fecha_arr[0];
      $xls->NewCell($fecha,false);
    	$xls->NewCell(($fila['pila']>0)?"Si":"No",false);
    	$xls->NewCell(($fila['control']>0)?"Si":"No",false);
    	$xls->NewCell(($fila['senal']>0)?"Si":"No",false);
    	$xls->NewCell(($fila['temperatura']>0)?"Si":"No",false);
    	$xls->NewCell($fila['inyeccion'],false,$xls_int);
    	$xls->NewCell($fila['retorno'],false,$xls_int);
    	$xls->NewCell(($fila['filtro']>0)?"Si":"No",false);
    	$xls->NewCell(($fila['desague']>0)?"Si":"No",false);
    	$xls->NewCell(($fila['bomba']>0)?"Si":"No",false);
    	$xls->NewCell(($fila['terminales']>0)?"Si":"No",false);
    	$xls->NewCell(($fila['condensadores']>0)?"Si":"No",false);
    	$xls->NewCell($fila['consumo'],false,$xls_int);
    	$xls->NewCell($fila['carga'],false,$xls_int);
    	$xls->NewCell($fila['observacion'],false);
    	$tecnico=devuelveNombre($fila['idUsuario'],'usuarios','id','nombres').' '.devuelveNombre($fila['idUsuario'],'usuarios','id','apellidos');
    	$xls->NewCell($tecnico,false);
    	//$xls->NewCell(strlen($tecnico),false,array('width'=>strlen($titulosColumnas[20])*6)););
    $xls->CloseRow();
    }
  else{
    $xls->OpenRow();
      $xls->NewCell($fila['anio'],true,array('bold'=>true,'background'=>'FF0000','align'=>'center'));
      $xls->NewCell($meses[$fila['mes']-1],true,array('bold'=>true,'background'=>'FF0000','align'=>'center'));
      $xls->NewCell($fila['nombreSucursal'],true,array('bold'=>true,'background'=>'FF0000','align'=>'center'));
      $sucursal=$fila['nombreSucursal'];
      $xls->NewCell($fila['nombreEdificio'],true,array('bold'=>true,'background'=>'FF0000','align'=>'center'));
      $xls->NewCell($fila['nroEquipo'],true,array('bold'=>true,'background'=>'FF0000','align'=>'center'));
      $xls->NewCell($fila['oficinaSala'],true,array('bold'=>true,'background'=>'FF0000','align'=>'center'));
      $fecha_arr=explode('-',$fila['fecha']);
      $fecha=$fecha_arr[2].'-'.$fecha_arr[1].'-'.$fecha_arr[0];
      $xls->NewCell($fecha,true,array('bold'=>true,'background'=>'FF0000','align'=>'center'));
      $xls->NewCell(($fila['pila']>0)?"Si":"No",true,array('bold'=>true,'background'=>'FF0000','align'=>'center'));
      $xls->NewCell(($fila['control']>0)?"Si":"No",true,array('bold'=>true,'background'=>'FF0000','align'=>'center'));
      $xls->NewCell(($fila['senal']>0)?"Si":"No",true,array('bold'=>true,'background'=>'FF0000','align'=>'center'));
      $xls->NewCell(($fila['temperatura']>0)?"Si":"No",true,array('bold'=>true,'background'=>'FF0000','align'=>'center'));
      $xls->NewCell($fila['inyeccion'],true,array('bold'=>true,'background'=>'FF0000','align'=>'center'),$xls_int);
      $xls->NewCell($fila['retorno'],true,array('bold'=>true,'background'=>'FF0000','align'=>'center'),$xls_int);
      $xls->NewCell(($fila['filtro']>0)?"Si":"No",true,array('bold'=>true,'background'=>'FF0000','align'=>'center'));
      $xls->NewCell(($fila['desague']>0)?"Si":"No",true,array('bold'=>true,'background'=>'FF0000','align'=>'center'));
      $xls->NewCell(($fila['bomba']>0)?"Si":"No",true,array('bold'=>true,'background'=>'FF0000','align'=>'center'));
      $xls->NewCell(($fila['terminales']>0)?"Si":"No",true,array('bold'=>true,'background'=>'FF0000','align'=>'center'));
      $xls->NewCell(($fila['condensadores']>0)?"Si":"No",true,array('bold'=>true,'background'=>'FF0000','align'=>'center'));
      $xls->NewCell($fila['consumo'],true,array('bold'=>true,'background'=>'FF0000','align'=>'center'),$xls_int);
      $xls->NewCell($fila['carga'],true,array('bold'=>true,'background'=>'FF0000','align'=>'center'),$xls_int);
      $xls->NewCell($fila['observacion'],true,array('bold'=>true,'background'=>'FF0000','align'=>'center'));
      $tecnico=devuelveNombre($fila['idUsuario'],'usuarios','id','nombres').' '.devuelveNombre($fila['idUsuario'],'usuarios','id','apellidos');
      $xls->NewCell($tecnico,true,array('bold'=>true,'background'=>'FF0000','align'=>'center'));
      //$xls->NewCell(strlen($tecnico),false,array('width'=>strlen($titulosColumnas[20])*6)););
    $xls->CloseRow();
    }    
}

$nombre_archivo="Mantenciones_".$sucursal."_".date("Y-m-d").".xls";
$xls->GetXLS(1,$nombre_archivo);


}
else{
    print_r('No hay resultados para mostrar');
}
}
	?>
