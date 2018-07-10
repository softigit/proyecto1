<?Php 
require_once('Connections/conexion1.php'); 
require_once('funciones.php');
$sql="SELECT 
a.idAgenda as Nro,
a.estado as Estado,
a.fecha as Fecha,
b.nombreEmpresa,
d.nombreSucursal,
a.nroEquipo,
c.nombres, 
c.apellidos,
ifnull(e.comentario ,'')as Comentario1,
ifnull (h.comentario,'') as Comentario2,
ifnull (j.comentario,'') as Comentario3,
a.comentario

FROM 
agenda as a,
empresas as b,
usuarios as c,
sucursal as d,
agenda as f  left join comentario as e on
(f.comentario1 = e.idcomentario ) ,
agenda as g  left join comentario as h on
(g.comentario2 = h.idcomentario ) ,
agenda as i  left join comentario as j on
(i.comentario3 = j.idcomentario ) 

WHERE
a.idEmpresa= b.idEmpresa and
a.idUsuario = c.id and
a.idSucursal =d.idSucursal and 
a.idAgenda = f.idAgenda and
a.idAgenda = g.idAgenda and
a.idAgenda = i.idAgenda and

a.idAgenda >33

order by a.idAgenda";
mysql_select_db($database_conexion1, $conexion1);
  $result = mysql_query($sql, $conexion1) or die(mysql_error());
  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso 8859-1" />
<title>Ordenes de trabajo</title>
</head>

<body>
<table border="1">
<tr align="center">
<td>Nro.</td>
<td>Estado</td>
<td>Fecha</td>
<td>Empresa</td>
<td>Sucursal</td>
<td>Equipo</td>
<td>Solicitante</td>
<td>Comentario 1</td>
<td>Comentario 2</td>
<td>Comentario 3</td>
<td>Observaciones</td>
<td>Comentarios</td>

</tr>
<?php while ($row_Mantencion=mysql_fetch_assoc($result)){ ?>
<tr>
<td><?php echo $row_Mantencion['Nro']; ?></td>
<td><?php echo $row_Mantencion['Estado']; ?></td>
<td><?php echo $row_Mantencion['Fecha']; ?></td>
<td><?php echo $row_Mantencion['nombreEmpresa']; ?></td>
<td align="center"><?php echo $row_Mantencion['nombreSucursal']; ?></td>
<td><?php echo $row_Mantencion['nroEquipo']; ?></td>
<td><?php echo $row_Mantencion['apellidos'].' '.$row_Mantencion['nombres']; ?></td>
<td><?php echo $row_Mantencion['Comentario1']; ?></td>
<td><?php echo $row_Mantencion['Comentario2']; ?></td>
<td><?php echo $row_Mantencion['Comentario3']; ?></td>
<td><?php echo $row_Mantencion['comentario']; ?></td>
<td>&nbsp;</td>

</tr>

<?php } ?>
</table>
</body>
</html>