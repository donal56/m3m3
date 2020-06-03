CREATE DEFINER=`root`@`localhost` PROCEDURE `comments`(IN `url` text, IN `type` text, IN `user` int)
BEGIN
	IF url IS NOT NULL THEN
		SET @user = user;
		SET @url = url;
		
		SET @query = "SELECT 
		c.*,
		u.username poster,
		u.avatar poster_avatar,
		c.media REGEXP '(.mp4|.avi|.webm)$' es_video,
		IFNULL(l.numero, 0) puntuacion,
		pun.puntaje me_gusta
		FROM comentario c
		INNER JOIN publicacion p ON c.id_publicacion = p.id
		LEFT JOIN (SELECT pun.id_comentario, sum(pun.puntaje) numero FROM puntaje_comentario pun GROUP BY pun.id_comentario) l ON l.id_comentario = c.id
		LEFT JOIN puntaje_comentario pun ON (pun.id_comentario = c.id AND pun.id_usuario = ?)
		INNER JOIN usuario u ON c.id_usuario = u.id
		WHERE p.url= ? ";
		
		CASE type
			WHEN "destacado" THEN
				SET @query = CONCAT(@query, "ORDER BY puntuacion DESC ");
			WHEN "nuevo" THEN
				SET @query = CONCAT(@query, "ORDER BY c.fecha_creacion DESC ");
			ELSE
				BEGIN END;
		END CASE;		
		
		PREPARE stmt FROM @query;
		EXECUTE stmt USING @user, @url;
		DEALLOCATE PREPARE stmt;
		
	END IF;
END