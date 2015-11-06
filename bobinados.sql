-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-06-2015 a las 03:23:37
-- Versión del servidor: 5.6.17
-- Versión de PHP: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `bobinados`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE IF NOT EXISTS `cliente` (
  `id_cliente` bigint(20) NOT NULL DEFAULT '0',
  `nom_cliente` varchar(60) NOT NULL,
  `direccion` varchar(60) NOT NULL,
  `telefono` int(11) NOT NULL,
  `fecha_ingre` date NOT NULL,
  `ciudad` varchar(60) NOT NULL,
  PRIMARY KEY (`id_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mantenimiento_motor`
--

CREATE TABLE IF NOT EXISTS `mantenimiento_motor` (
  `id_mantenimiento` bigint(20) NOT NULL AUTO_INCREMENT,
  `num_serie_motor` varchar(50) NOT NULL,
  `id_usuario` bigint(20) NOT NULL,
  `amp` float DEFAULT NULL,
  `voltios` float DEFAULT NULL,
  `balineras` float DEFAULT NULL,
  `sello_mecanico` varchar(40) DEFAULT NULL,
  `cap_arranque` float DEFAULT NULL,
  `cap_marcha` int(11) DEFAULT NULL,
  `otros` text,
  `p_finales` text,
  `observaciones` text,
  PRIMARY KEY (`id_mantenimiento`),
  KEY `num_serie_motor` (`num_serie_motor`,`id_usuario`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `motorl`
--

CREATE TABLE IF NOT EXISTS `motorl` (
  `num_serie_motor` varchar(50) NOT NULL,
  `marca` varchar(50) NOT NULL,
  `hp` float NOT NULL,
  `kw` float NOT NULL,
  `rpm` float NOT NULL,
  `n_fases` int(11) NOT NULL,
  `cotizado` int(11) NOT NULL,
  `autorizado` varchar(50) NOT NULL,
  `id_usu` bigint(20) NOT NULL,
  `id_cliente` bigint(20) NOT NULL,
  `accion` varchar(40) NOT NULL,
  `fe_termi` date DEFAULT NULL,
  `fe_acord` date DEFAULT NULL,
  PRIMARY KEY (`num_serie_motor`),
  KEY `id_usu` (`id_usu`,`id_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rebobinado_motor`
--

CREATE TABLE IF NOT EXISTS `rebobinado_motor` (
  `id_rebobinado` bigint(20) NOT NULL AUTO_INCREMENT,
  `num_serie_motor` varchar(50) NOT NULL,
  `id_usuario` bigint(20) NOT NULL,
  `v` float DEFAULT NULL,
  `am` float DEFAULT NULL,
  `balineras_ref` varchar(40) DEFAULT NULL,
  `cap_marcha` varchar(40) DEFAULT NULL,
  `largo` float DEFAULT NULL,
  `conexiones` int(11) DEFAULT NULL,
  `cap_arranque` float DEFAULT NULL,
  `sello_mecanico` varchar(40) DEFAULT NULL,
  `arr_paso` varchar(40) DEFAULT NULL,
  `arr_espiras` varchar(40) DEFAULT NULL,
  `arr_calibre` varchar(40) DEFAULT NULL,
  `arr_peso_por_bobina` varchar(40) DEFAULT NULL,
  `mar_paso` varchar(40) DEFAULT NULL,
  `mar_espira` varchar(40) DEFAULT NULL,
  `mar_calibre` varchar(40) DEFAULT NULL,
  `mar_peso_por_bobina` varchar(40) DEFAULT NULL,
  `num_ranura` int(11) DEFAULT NULL,
  `observaciones` text,
  `sugerencias` text,
  PRIMARY KEY (`id_rebobinado`),
  KEY `num_serie_motor` (`num_serie_motor`,`id_usuario`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tp_usuarios`
--

CREATE TABLE IF NOT EXISTS `tp_usuarios` (
  `id_tp` int(11) NOT NULL AUTO_INCREMENT,
  `nom_tp` varchar(40) NOT NULL,
  PRIMARY KEY (`id_tp`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `tp_usuarios`
--

INSERT INTO `tp_usuarios` (`id_tp`, `nom_tp`) VALUES
(1, 'Admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usu` bigint(20) NOT NULL AUTO_INCREMENT,
  `nom_usu` varchar(30) NOT NULL,
  `usuario` varchar(30) NOT NULL,
  `pass` varchar(30) NOT NULL,
  `foto` varchar(50) NOT NULL,
  `id_tp_usu` int(11) NOT NULL,
  PRIMARY KEY (`id_usu`),
  KEY `id_tp_usu` (`id_tp_usu`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `mantenimiento_motor`
--
ALTER TABLE `mantenimiento_motor`
  ADD CONSTRAINT `mantenimiento_motor_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usu`) ON UPDATE CASCADE,
  ADD CONSTRAINT `mantenimiento_motor_ibfk_1` FOREIGN KEY (`num_serie_motor`) REFERENCES `motorl` (`num_serie_motor`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `motorl`
--
ALTER TABLE `motorl`
  ADD CONSTRAINT `motorl_ibfk_1` FOREIGN KEY (`id_usu`) REFERENCES `usuarios` (`id_usu`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `rebobinado_motor`
--
ALTER TABLE `rebobinado_motor`
  ADD CONSTRAINT `rebobinado_motor_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usu`) ON UPDATE CASCADE,
  ADD CONSTRAINT `rebobinado_motor_ibfk_1` FOREIGN KEY (`num_serie_motor`) REFERENCES `motorl` (`num_serie_motor`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `tp_usuarios` FOREIGN KEY (`id_tp_usu`) REFERENCES `tp_usuarios` (`id_tp`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
