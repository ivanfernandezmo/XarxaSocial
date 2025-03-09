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