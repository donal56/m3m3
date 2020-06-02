CREATE DEFINER=`root`@`localhost` PROCEDURE `feed`(IN `page` int, IN `type` text, IN `tag` text, IN `user` int)
BEGIN
	SET @paginacion = 3;
	SET @desfase = (page - 1) * @paginacion;
	SET @user = user;
	
	IF page >= 1 AND type IS NOT NULL THEN
		SET @query = "SELECT 
		p.*,
		u.username poster,
		u.avatar poster_avatar,
		p.media REGEXP '(.mp4|.avi|.webm)$' es_video,
		IFNULL(c.numero, 0) comentarios,
		IFNULL(l.numero, 0) puntuacion,
		GROUP_CONCAT(DISTINCT e.nombre ORDER BY e.nombre SEPARATOR ', ') etiquetas,
		pun.puntaje me_gusta
		FROM publicacion p
		INNER JOIN rel_publicacion_etiqueta rel  ON rel.id_publicacion = p.id
		INNER JOIN etiqueta e ON rel.id_etiqueta = e.id
		INNER JOIN usuario u ON p.id_usuario = u.id
		LEFT JOIN (SELECT com.id_publicacion, count(com.id_publicacion) numero FROM comentario com GROUP BY com.id_publicacion) c ON c.id_publicacion = p.id
		LEFT JOIN (SELECT pun.id_publicacion, sum(pun.puntaje) numero FROM puntaje_publicacion pun GROUP BY pun.id_publicacion) l ON l.id_publicacion = p.id
		LEFT JOIN puntaje_publicacion pun ON (pun.id_publicacion = p.id AND pun.id_usuario = ?)
		WHERE e.activo = 1 ";
		
		IF tag IS NOT NULL THEN
				SET @query = CONCAT(@query, " AND e.nombre = '", tag, "' ");
		END IF;
		
		SET @query = CONCAT(@query, "GROUP BY p.id ");
		
		CASE type
			WHEN "popular" THEN
				SET @query = CONCAT(@query, "ORDER BY comentarios DESC ");
			WHEN "tendencia" THEN
				SET @query = CONCAT(@query, "ORDER BY puntuacion DESC ");
			WHEN "nuevo" THEN
				SET @query = CONCAT(@query, "ORDER BY p.fecha_creacion DESC ");
			ELSE
				BEGIN END;
		END CASE;		
		
		SET @query = CONCAT(@query, "LIMIT ? OFFSET ?;");
		
		PREPARE stmt FROM @query;
		EXECUTE stmt USING @user, @paginacion, @desfase;
		DEALLOCATE PREPARE stmt;
		
	END IF;
END