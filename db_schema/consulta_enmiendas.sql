select e.id, 
if (e.id,CONCAT("http://enmiendas.andaluciapodemos.info/enmienda/",e.id,"/"),'') Enlace,
e.idPropuesta, e.idCategoria, e.tipo, e.nombre, e.apellidos, e.cp, e.email, 
e.telefono, e.motivacion, e.publica, 
e.redaccion, e.created_at, 
INET_NTOA(e.ip) ip, c.nombre Categoria, p.texto Propuesta
from adelante_programa_enmiendas e
left join adelante_programa_propuestas p on p.id = e.idPropuesta
left join adelante_programa_categorias c on c.id = e.idCategoria
order by e.created_at desc