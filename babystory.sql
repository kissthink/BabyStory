-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 18-09-2014 a las 23:49:39
-- Versión del servidor: 5.5.16
-- Versión de PHP: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `babystory`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `componentes`
--

CREATE TABLE IF NOT EXISTS `componentes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `papa_id` int(11) DEFAULT NULL,
  `hijo_id` int(11) DEFAULT NULL,
  `historia_id` int(11) DEFAULT NULL,
  `tipo` int(11) NOT NULL,
  `componente` longtext COLLATE utf8_unicode_ci,
  `tipoUsuario` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C474BC8851E4BF21` (`papa_id`),
  KEY `IDX_C474BC88230917F5` (`hijo_id`),
  KEY `IDX_C474BC88F8FA80EF` (`historia_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hijos`
--

CREATE TABLE IF NOT EXISTS `hijos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `papa_id` int(11) DEFAULT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `apodo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `usarApodo` tinyint(1) NOT NULL,
  `fechaNacimiento` date NOT NULL,
  `biografia` longtext COLLATE utf8_unicode_ci NOT NULL,
  `imagen` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_47676A0051E4BF21` (`papa_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `hijos`
--

INSERT INTO `hijos` (`id`, `papa_id`, `nombre`, `apodo`, `usarApodo`, `fechaNacimiento`, `biografia`, `imagen`, `created_at`, `updated_at`) VALUES
(1, 1, 'Susana Nahomi', 'Solecito', 1, '2009-02-16', 'Es el amor de mi vida', NULL, '2014-09-18 22:36:30', '2014-09-18 22:36:30'),
(2, 1, 'Jose Santiago Rodriguez', 'Pepe', 1, '2010-02-24', 'Es rudo', NULL, '2014-09-18 22:45:48', '2014-09-18 22:45:48'),
(3, 1, 'Luis Mateo Rodriguez', 'Matiago', 1, '2014-07-01', 'Esta super grande', NULL, '2014-09-18 22:48:24', '2014-09-18 22:48:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historias`
--

CREATE TABLE IF NOT EXISTS `historias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `historia` longtext COLLATE utf8_unicode_ci NOT NULL,
  `fecha` date NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `historias`
--

INSERT INTO `historias` (`id`, `historia`, `fecha`, `created_at`, `updated_at`) VALUES
(1, 'El lunes vimos a matiago', '2014-09-01', '2014-09-18 23:15:32', '2014-09-18 23:39:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=17 ;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`) VALUES
(15, 'ROLE_ADMIN'),
(16, 'ROLE_USUARIO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ciudad` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `biografia` longtext COLLATE utf8_unicode_ci NOT NULL,
  `serMadre` longtext COLLATE utf8_unicode_ci NOT NULL,
  `imagen` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `password`, `salt`, `email`, `ciudad`, `biografia`, `serMadre`, `imagen`, `created_at`, `updated_at`) VALUES
(1, 'richpolis', 'hQBGFvH7A/VuwC3qWBUPWYPXoHY1iZgrJUFPD4pcm0ps/4Fd8aMAlOuzoGWQSd7J+mpU4sFkn+8hqr2eQ+2WTQ==', 'd0rsg9j2gd4css0gssco80skgsswcco', 'richpolis@gmail.com', 'Ciudad de Mexico', 'Sin datos', 'Sin datos', NULL, '2014-09-18 13:48:08', '2014-09-18 13:48:08'),
(2, 'Admin', 'fVHbBIlthvIjylA1xn7nB/sJXdPEHU0eF41eFpBadqhzuUlNcgTzdaKrEbgf98QdkOllx91JPtFClPuDMITk2A==', 'ae22c0egkq8s4c40go40os4kkoggg8g', 'admin@babystory.com', 'Ciudad de Mexico', 'Sin datos', 'Sin datos', NULL, '2014-09-18 13:48:08', '2014-09-18 22:00:30'),
(3, 'Usuario1', 'nwBI3usJ4DC3wLfW5zdPp8O5jMYFHHWg1nxu4lCWKVXGJb+EP5j/0fPgsr/ub1UC/g5lwS+evdlcZhWr3jGlmQ==', 'r187znlhxios4sg8coc4k4wc4g00k4c', 'usuario1@babystory.com', 'Ciudad de Mexico', 'Sin datos', 'Sin datos', NULL, '2014-09-18 13:48:08', '2014-09-18 22:06:16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_rol`
--

CREATE TABLE IF NOT EXISTS `usuario_rol` (
  `usuario_id` int(11) NOT NULL,
  `rol_id` smallint(6) NOT NULL,
  PRIMARY KEY (`usuario_id`,`rol_id`),
  KEY `IDX_72EDD1A4DB38439E` (`usuario_id`),
  KEY `IDX_72EDD1A44BAB96C` (`rol_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `usuario_rol`
--

INSERT INTO `usuario_rol` (`usuario_id`, `rol_id`) VALUES
(1, 15),
(2, 15),
(3, 16);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `componentes`
--
ALTER TABLE `componentes`
  ADD CONSTRAINT `FK_C474BC88230917F5` FOREIGN KEY (`hijo_id`) REFERENCES `hijos` (`id`),
  ADD CONSTRAINT `FK_C474BC8851E4BF21` FOREIGN KEY (`papa_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `FK_C474BC88F8FA80EF` FOREIGN KEY (`historia_id`) REFERENCES `historias` (`id`);

--
-- Filtros para la tabla `hijos`
--
ALTER TABLE `hijos`
  ADD CONSTRAINT `FK_47676A0051E4BF21` FOREIGN KEY (`papa_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `usuario_rol`
--
ALTER TABLE `usuario_rol`
  ADD CONSTRAINT `FK_72EDD1A44BAB96C` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `FK_72EDD1A4DB38439E` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
