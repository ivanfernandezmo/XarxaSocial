-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-02-2025 a las 14:47:58
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `xarxasocial`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `follow`
--

CREATE TABLE `follow` (
  `idFollow` int(11) NOT NULL,
  `idUsuarioSeguidor` int(11) NOT NULL,
  `idUsuarioCreador` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `magrada`
--

CREATE TABLE `magrada` (
  `idUsuario` int(11) NOT NULL,
  `idPost` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `post`
--

CREATE TABLE `post` (
  `idPost` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `idUsuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL,
  `mail` varchar(40) NOT NULL,
  `username` varchar(16) NOT NULL,
  `passHash` varchar(60) NOT NULL,
  `userFirstName` varchar(60) NOT NULL,
  `userLastName` varchar(120) NOT NULL,
  `creationDate` datetime NOT NULL,
  `removeDate` datetime DEFAULT NULL,
  `lastSignIn` datetime DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `activationDate` datetime DEFAULT NULL,
  `activationCode` char(64) DEFAULT NULL,
  `resetPassExpiry` datetime DEFAULT NULL,
  `resetPassCode` char(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `mail`, `username`, `passHash`, `userFirstName`, `userLastName`, `creationDate`, `removeDate`, `lastSignIn`, `active`, `activationDate`, `activationCode`, `resetPassExpiry`, `resetPassCode`) VALUES
(1, 'ramon@gmail.com', 'ramon', '123', 'ramon', 'rodriguez', '2025-01-23 15:56:53', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'ramon@gmail.com', 'ramon', '123', 'ramon', 'rodriguez', '2025-01-23 15:56:53', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 'ivan.fernandezm@educem.net', 'ivan', '$2y$12$stgyZcZuM8u84b1FKklu4ud/qvIWkE4KHxzsKr4lTUR7G8ZtORqbK', 'ivan', 'ivan', '2025-02-18 16:00:40', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, '2025-02-18 16:02:14', NULL, NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `follow`
--
ALTER TABLE `follow`
  ADD PRIMARY KEY (`idFollow`),
  ADD KEY `idUsuarioSeguidor` (`idUsuarioSeguidor`),
  ADD KEY `idUsuarioCreador` (`idUsuarioCreador`);

--
-- Indices de la tabla `magrada`
--
ALTER TABLE `magrada`
  ADD PRIMARY KEY (`idUsuario`,`idPost`),
  ADD KEY `idPost` (`idPost`);

--
-- Indices de la tabla `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`idPost`),
  ADD KEY `idUsuario` (`idUsuario`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `follow`
--
ALTER TABLE `follow`
  MODIFY `idFollow` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `post`
--
ALTER TABLE `post`
  MODIFY `idPost` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `follow`
--
ALTER TABLE `follow`
  ADD CONSTRAINT `follow_ibfk_1` FOREIGN KEY (`idUsuarioSeguidor`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `follow_ibfk_2` FOREIGN KEY (`idUsuarioCreador`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `magrada`
--
ALTER TABLE `magrada`
  ADD CONSTRAINT `magrada_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `magrada_ibfk_2` FOREIGN KEY (`idPost`) REFERENCES `post` (`idPost`) ON DELETE CASCADE;

--
-- Filtros para la tabla `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- TAULA PERFIL
CREATE TABLE `xarxasocial`.`perfil` ( 
  `idUsuario` INT NOT NULL, 
  `imatge` LONGTEXT NOT NULL, 
  `descripcio` TEXT NOT NULL, 
  `ubicacio` TEXT NOT NULL, 
  `edat` INT NOT NULL, 
  PRIMARY KEY (`idUsuario`), 
  CONSTRAINT `fk_perfil_usuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuario`(`idUsuario`) 
  ON DELETE CASCADE 
  ON UPDATE CASCADE ) 
ENGINE = InnoDB;

--INSERT EN PERFIL
INSERT INTO `perfil` (`idUsuario`, `imatge`, `descripcio`, `ubicacio`, `edat`) VALUES ('15', '../imatges/perfil-pato.jpg', 'Apasionada por la tecnología y el diseño. 🚀 Amante del café y los viajes. ✈️', 'Barcelona, España', '32');

--INSERT EN POST
INSERT INTO `post` (`titulo`, `descripcion`, `foto`, `idUsuario`) VALUES ('Mi Viaje a Japón', 'Explorando la cultura y gastronomía japonesa. 🍣🏯', '../imatges/posts/japon.jpg', '15');
INSERT INTO `post` (`titulo`, `descripcion`, `foto`, `idUsuario`) VALUES ('Aventuras en la montaña', 'Senderismo y vistas increíbles en los Alpes. ⛰️', '../imatges/posts/montana.jpg', '15');

INSERT INTO post (idUsuario, titulo, descripcion, foto) VALUES
(15, '🌅 Amanecer en Santorini', 'Disfrutando de un amanecer mágico en Santorini. 🌊 Nada como ver el sol salir sobre el mar Egeo. 🇬🇷✨', '../imatges/posts/santorini.jpg'),
(15, '⛩️ Explorando Kyoto', '🏯 Templos ancestrales, 🌸 cerezos en flor y una cultura fascinante. Kyoto es un destino imperdible. 🍣🇯🇵', '../imatges/posts/kyoto.jpg'),
(15, '🚗 Roadtrip por la Costa Amalfitana', '🌊 Carreteras serpenteantes, 🍕 la mejor pizza de Italia y vistas impresionantes. ¡Qué viaje inolvidable! 🇮🇹☀️', '../imatges/posts/amalfi.jpg'),
(15, '🏔️ Aventura en Machu Picchu', 'Después de una caminata agotadora 🥾, la vista de Machu Picchu lo vale todo. 🏛️ Historia y naturaleza en un solo lugar. 🇵🇪', '../imatges/posts/machu_picchu.jpg'),
(15, '🦁 Safari en Kenia', 'Leones, jirafas y atardeceres de película 🌅. África tiene una magia indescriptible. 🦓🌍', '../imatges/posts/safari_kenya.jpg'),
(15, '🎈 Paseo en globo en Capadocia', 'Ver las chimeneas de hadas desde el cielo es una experiencia única. 🏜️ Turquía nunca decepciona. 🇹🇷', '../imatges/posts/capadocia.jpg'),
(15, '🤿 Buceo en la Gran Barrera de Coral', '🌊 Colores vibrantes, 🐠 peces exóticos y la sensación de estar en otro mundo bajo el agua. 🇦🇺', '../imatges/posts/coral.jpg'),
(15, '🎄 Navidad en Nueva York', '❄️ Luces, nieve y un espíritu navideño inigualable. 🏙️ Nueva York en diciembre es pura magia. 🇺🇸', '../imatges/posts/ny.jpg');

--Modificació taula Post per afegir camp Fecha_publicacion

ALTER TABLE post ADD COLUMN fecha_publicacion DATE;

-- INSERTS A MAGRADA
INSERT INTO `magrada` (`idUsuario`, `idPost`) VALUES ('15', '3'), ('15', '2');

-- CONSULTA PER ORDENAR POSTS SEGONS LIKES
SELECT P.idPost, P.titulo, P.descripcion, P.foto, P.fecha_publicacion, COUNT(*) AS total_likes FROM magrada M 
	            RIGHT JOIN post P ON M.idPost = P.idPost
            WHERE P.idUsuario = ' . $id . '
            GROUP BY P.idPost
            ORDER BY total_likes DESC;

-- CREACIÓ TAULA COMENTARI
CREATE TABLE `xarxasocial`.`comentari` ( 
  `idPost` INT NOT NULL,
  `idUsuario` INT NOT NULL,
  `dataComentari` DATETIME NOT NULL,
  `text` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`idUsuario`, `dataComentari`, `idPost`),
  CONSTRAINT `fk_comentaris_post` FOREIGN KEY (`idPost`) REFERENCES `post`(`idPost`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_comentaris_usuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuario`(`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE 
) ENGINE = InnoDB;

-- INSERTS A COMENTARI
INSERT INTO `xarxasocial`.`comentari` (`idPost`, `idUsuario`, `dataComentari`, `text`) VALUES
(2, 1, '2025-03-21 10:15:00', '🇯🇵 ¡Qué hermoso viaje! Japón debe ser increíble. 🍣🏯'),
(2, 2, '2025-03-21 12:30:00', '🍜 Me encantaría probar la gastronomía japonesa. 😋'),
(7, 15, '2025-03-21 14:45:00', '🌸 Explorar Kyoto debe ser mágico en primavera. 🏮'),
(8, 20, '2025-03-21 16:00:00', '🚗 Siempre he querido hacer un roadtrip por Italia. 🍕'),
(9, 1, '2025-03-21 18:20:00', '⛰️ Machu Picchu es un destino soñado. ¡Gran foto! 📸'),
(10, 2, '2025-03-21 20:00:00', '🦒 Safari en Kenia, una experiencia única en la vida. 🌅'),
(11, 15, '2025-03-21 21:10:00', '🎈 Paseo en globo en Capadocia, ¡una vista impresionante! ☁️'),
(12, 20, '2025-03-21 22:30:00', '🐠 Bucear en la Gran Barrera de Coral debe ser asombroso. 🌊'),
(13, 1, '2025-03-21 23:45:00', '❄️ Navidad en Nueva York es un sueño. 🎄🗽'),
(13, 2, '2025-03-22 00:10:00', '✨ Las luces y la nieve hacen que NY sea mágico en diciembre. 🏙️');
