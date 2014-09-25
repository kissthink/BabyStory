-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 25-09-2014 a las 16:14:51
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
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE IF NOT EXISTS `comentarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) DEFAULT NULL,
  `historia_id` int(11) DEFAULT NULL,
  `comentario` longtext COLLATE utf8_unicode_ci NOT NULL,
  `calificacion` int(11) NOT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_F54B3FC0DB38439E` (`usuario_id`),
  KEY `IDX_F54B3FC0F8FA80EF` (`historia_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `componentes`
--

INSERT INTO `componentes` (`id`, `papa_id`, `hijo_id`, `historia_id`, `tipo`, `componente`, `tipoUsuario`, `position`) VALUES
(1, 1, NULL, 4, 6, 'Voy a marcarle a mi hija para saber como esta', 1, 1),
(2, 1, 4, 4, 6, 'Papa quiero ir a una fiesta con un amigo', 2, 2),
(3, 1, 4, 5, 6, 'Papa me llevas al parque?', 2, 1),
(4, 1, NULL, 5, 6, 'Si amor claro, solo deja que termine de trabajar...', 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hijos`
--

CREATE TABLE IF NOT EXISTS `hijos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `papa_id` int(11) DEFAULT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `apodo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usarApodo` tinyint(1) NOT NULL,
  `fechaNacimiento` date NOT NULL,
  `biografia` longtext COLLATE utf8_unicode_ci,
  `imagen` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `sexo` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_47676A0051E4BF21` (`papa_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `hijos`
--

INSERT INTO `hijos` (`id`, `papa_id`, `nombre`, `apodo`, `usarApodo`, `fechaNacimiento`, `biografia`, `imagen`, `created_at`, `updated_at`, `sexo`) VALUES
(2, 4, 'PEPE', 'PEPE', 1, '2009-01-01', 'bla bla bla', '8016e536b6bef50b4e5d565c54b92021617cbcfd.png', '2014-09-22 13:50:08', '2014-09-22 13:50:08', 1),
(3, 4, 'pepa', 'pepa', 1, '2009-01-01', 'bla bla bla', '0f6186a83fd3b6427852d0c697c8c9de40ddd233.png', '2014-09-22 13:51:00', '2014-09-22 14:16:24', 1),
(4, 1, 'Susana Nahomi', 'Solecito', 1, '2008-02-16', 'Es una presiona niña', '1d42e0eb99364bdd301c91e0e4ffb2f62c713499.jpeg', '2014-09-22 13:51:17', '2014-09-24 19:48:31', 2),
(5, 1, 'Jose Santiago Rodriguez', 'Pepe', 1, '2009-02-24', 'Es un luchador...', '3531c2b01795cc058f9285f876aa648490ab2f12.jpeg', '2014-09-22 14:04:50', '2014-09-22 14:04:50', 1);

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
  `usuario_id` int(11) DEFAULT NULL,
  `clave` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hijo_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_AB9D0BA7DB38439E` (`usuario_id`),
  KEY `IDX_AB9D0BA7230917F5` (`hijo_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `historias`
--

INSERT INTO `historias` (`id`, `historia`, `fecha`, `created_at`, `updated_at`, `usuario_id`, `clave`, `hijo_id`) VALUES
(1, 'bla bla bla bla bla', '2014-09-22', '2014-09-22 14:20:12', '2014-09-22 14:20:12', 4, NULL, NULL),
(2, 'bla bla bla bla bla', '2014-09-22', '2014-09-22 14:20:13', '2014-09-22 14:20:13', 4, NULL, NULL),
(3, 'El nacimiento de mi bebe', '2008-02-16', '2014-09-25 00:22:41', '2014-09-25 00:22:41', 1, 'eccbc87e4b5ce2fe28308fd9f2a7baf3', 4),
(4, 'Historia reciente', '2014-09-25', '2014-09-25 00:42:21', '2014-09-25 00:42:21', 1, 'a87ff679a2f3e71d9181a67b7542122c', 4),
(5, 'otra historia con mi hija', '2014-08-01', '2014-09-25 00:56:10', '2014-09-25 00:56:10', 1, 'e4da3b7fbbce2345d7772b0674a318d5', 4);

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
  `ciudad` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `biografia` longtext COLLATE utf8_unicode_ci,
  `serMadre` longtext COLLATE utf8_unicode_ci,
  `imagen` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `sexo` int(11) NOT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `password`, `salt`, `email`, `ciudad`, `biografia`, `serMadre`, `imagen`, `created_at`, `updated_at`, `is_active`, `sexo`, `link`) VALUES
(1, 'richpolis', 'hQBGFvH7A/VuwC3qWBUPWYPXoHY1iZgrJUFPD4pcm0ps/4Fd8aMAlOuzoGWQSd7J+mpU4sFkn+8hqr2eQ+2WTQ==', 'd0rsg9j2gd4css0gssco80skgsswcco', 'richpolis@gmail.com', 'Ciudad de Mexico', 'Sin datos', 'Sin datos', '13ded0a1830f21a5307ec581497ea6e2332dc73d.jpeg', '2014-09-18 13:48:08', '2014-09-24 18:00:15', 1, 1, NULL),
(2, 'Admin', 'bR62F5MIGE5z9fkZwyZ2znakE+50o2zDKuEnjvUKCZk0rkMcFAicg+6TnssRybgpks8mxIZzSHWPSQk+rQCAGw==', 'ae22c0egkq8s4c40go40os4kkoggg8g', 'admin@babystory.com', 'Ciudad de Mexico', 'Sin datos', 'Sin datos', NULL, '2014-09-18 13:48:08', '2014-09-22 14:18:26', 1, 0, NULL),
(3, 'Usuario1', 'nwBI3usJ4DC3wLfW5zdPp8O5jMYFHHWg1nxu4lCWKVXGJb+EP5j/0fPgsr/ub1UC/g5lwS+evdlcZhWr3jGlmQ==', 'r187znlhxios4sg8coc4k4wc4g00k4c', 'usuario1@babystory.com', 'Ciudad de Mexico', 'Sin datos', 'Sin datos', '47da38a53cfa670de2bf4fa54002e0a3a15be117.png', '2014-09-18 13:48:08', '2014-09-25 05:05:25', 1, 0, NULL),
(4, 'sarevalox', 'aYcWP9i0GRQi9GunainSjjkFNZYVlHiqhn+7AYFsfHwRB3/eQH/34g9RlSfFrDSveiWlQcgk3qBUdARbkyQSqQ==', 't7usn7tyki8c0s884k4sgs88s804ook', 'sarevalox@gmail.com', 'Santiago', 'Bla bla bla', '123', 'e297f28236a8c6ec0a010ab20668173d4743764d.png', '2014-09-22 13:26:41', '2014-09-22 13:48:40', 1, 0, NULL),
(5, 'ernestina', '31yyuB94vscJEl24IaLgKTpySwBm9NilZtuFubsmk1T40yCNtlbYz5wHgnjPLqRubmMmVxNd6NL/77ge2eh8hw==', 'ph8g27iu1msgocwwckwg4ogskgsk0so', 'richpolis@hotmail.com', 'Ciudad de Mexico', 'Biografia', 'Ser madre es....', '19f7d69ea2e82457403e9e8b21e480f3817cb818.png', '2014-09-22 13:28:30', '2014-09-22 13:47:47', 1, 0, NULL);

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
(3, 16),
(4, 16),
(5, 16);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `FK_F54B3FC0DB38439E` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `FK_F54B3FC0F8FA80EF` FOREIGN KEY (`historia_id`) REFERENCES `historias` (`id`);

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
-- Filtros para la tabla `historias`
--
ALTER TABLE `historias`
  ADD CONSTRAINT `FK_AB9D0BA7230917F5` FOREIGN KEY (`hijo_id`) REFERENCES `hijos` (`id`),
  ADD CONSTRAINT `FK_AB9D0BA7DB38439E` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `usuario_rol`
--
ALTER TABLE `usuario_rol`
  ADD CONSTRAINT `FK_72EDD1A44BAB96C` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `FK_72EDD1A4DB38439E` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
