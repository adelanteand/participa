SELECT 
e.id 'ID Enmienda', 
CONCAT('=HIPERVINCULO(CONCATENAR("http://enmiendas.adelanteandalucia.org/enmienda/";A2;"/");"Enlace")') Hipervinculo,
e.idPropuesta 'ID Propuesta', e.idCategoria 'ID Categoria',
CONCAT(e.nombre, ' ', e.apellidos) 'Proponente',
e.cp, e.email, e.telefono, e.tipo, fnStripTags(e.motivacion) Motivacion, 
fnStripTags(CONVERT(CONVERT(CONVERT(e.redaccion USING latin1) USING binary) USING utf8)) 'Redacción', 
e.fichero, 
e.created_at 'Enviada', 
/*count(*) Contador,*/
IF (e.publica,'SÍ','NO') 'PUBLICADA / En listados', 
ponencia.id 'PONENCIA: ID Valoracion', 
patio.id 'PATIO: ID Valoracion', 
if (ponencia.valoracion IS NULL,'-',ponencia.valoracion) 'PONENCIA: Valoración', 
if (patio.valoracion IS NULL,'-',patio.valoracion) 'PATIO: Valoración', 
if (ponencia.observaciones IS NULL,'-',ponencia.observaciones) 'PONENCIA: Comentarios',
if (patio.observaciones IS NULL,'-',patio.observaciones) 'PATIO: Comentarios',
IF (
	left(e.cp,2) NOT IN ('04','11','14','18','21','23','29','41'),
	'TIPO 1. NO DISCUTIDA EN LOS PATIOS POR SER DE OTRA PROVINCIA',
	IF (
		ponencia.id IS NULL, 
		'TIPO 2. NO VALORADA POR LA PONENCIA',
		IF (
			patio.id IS NULL, 
			'TIPO 3. EL PATIO NO HA ENVIADO VALORACIÓN',
			'-'
		)	
	)
) 'Observacion automática',
NULL '¿PASA AL ANDALUZ?'
FROM adelante_programa_enmiendas e
LEFT JOIN  adelante_programa_enmiendas_valoraciones ponencia ON ponencia.valorador = 'Ponencia' and ponencia.enmiendaID = e.id
LEFT JOIN (
		SELECT v1.*, v2.Contador
		FROM adelante_programa_enmiendas_valoraciones v1
		INNER JOIN
		(
		    SELECT max(created_at) Ultima, enmiendaID, count(*) Contador
		    FROM adelante_programa_enmiendas_valoraciones
		    WHERE valorador != 'Ponencia'
		    GROUP BY enmiendaID
		    ORDER BY created_at DESC
		) v2
		  ON v1.enmiendaID = v2.enmiendaID
		  AND v1.created_at = v2.Ultima
		WHERE v1.valorador != 'Ponencia' 
) patio ON patio.enmiendaID = e.id
/* WHERE LEFT(e.cp,2) = '11' */
GROUP BY e.id 
ORDER BY cast(e.idCategoria as unsigned) ASC
