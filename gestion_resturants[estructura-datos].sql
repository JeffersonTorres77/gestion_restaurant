-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-10-2020 a las 12:50:31
-- Versión del servidor: 10.1.38-MariaDB
-- Versión de PHP: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gestion_resturants`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `adm_menus_a`
--

CREATE TABLE `adm_menus_a` (
  `idMenuA` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `img` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `link` text COLLATE utf8_spanish_ci NOT NULL,
  `con_opciones` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `adm_menus_a`
--

INSERT INTO `adm_menus_a` (`idMenuA`, `nombre`, `img`, `link`, `con_opciones`) VALUES
(1, 'Resturantes', 'fas fa-store', 'Restaurantes/', 1),
(2, 'Roles', 'fas fa-user-cog', 'Roles/', 0),
(3, 'Estadisticas', 'fas fa-chart-line', 'Estadisticas/', 0),
(100, 'Gestion Sistema', 'fas fa-desktop', 'Gestion_Sistema/', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `adm_menus_b`
--

CREATE TABLE `adm_menus_b` (
  `idMenuB` int(11) NOT NULL,
  `idMenuA` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `img` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `link` text COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `adm_menus_b`
--

INSERT INTO `adm_menus_b` (`idMenuB`, `idMenuA`, `nombre`, `img`, `link`) VALUES
(1, 100, 'Usuarios', 'fas fa-users', 'Gestion_Sistema/Usuarios/'),
(2, 1, 'Afiliar', 'fas fa-plus', 'Restaurantes/Registrar/'),
(3, 1, 'Gestion', 'fas fa-store', 'Restaurantes/Gestion/'),
(4, 1, 'Usuarios', 'fas fa-users', 'Usuarios/');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `adm_usuarios`
--

CREATE TABLE `adm_usuarios` (
  `usuario` varchar(32) COLLATE utf8_spanish_ci NOT NULL,
  `clave` varchar(32) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `cedula` varchar(12) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_registro` varchar(20) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `adm_usuarios`
--

INSERT INTO `adm_usuarios` (`usuario`, `clave`, `nombre`, `cedula`, `fecha_registro`) VALUES
('admin', 'admin', 'Administrador por defecto', '123123123', '2020-06-8 19-33-12'),
('edgarl', '12345678', 'Edgar Loma', '123456789', '2020-06-3 20-2-53'),
('jonathanc', '12345678', 'Jonathan Colina', '12345678', '2020-06-3 20-3-15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `areas_monitoreo`
--

CREATE TABLE `areas_monitoreo` (
  `idAreaMonitoreo` int(11) NOT NULL,
  `nombre` varchar(200) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `areas_monitoreo`
--

INSERT INTO `areas_monitoreo` (`idAreaMonitoreo`, `nombre`) VALUES
(1, 'TODOS'),
(2, 'COCINA'),
(3, 'BAR'),
(4, 'POSTRES');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `idCategoria` int(11) NOT NULL,
  `idRestaurant` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `idAreaMonitoreo` int(11) NOT NULL,
  `fecha_registro` varchar(20) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`idCategoria`, `idRestaurant`, `nombre`, `idAreaMonitoreo`, `fecha_registro`) VALUES
(3, 2, 'Combos', 4, '2020-06-09 09:41:00'),
(6, 1, 'COMIDAS', 2, '2020-06-12 19-54-15'),
(7, 1, 'BEBIDAS', 3, '2020-06-12 19-54-20'),
(8, 1, 'POSTRES', 4, '2020-06-12 19-54-25'),
(9, 1, 'test', 1, '2020-10-12 17:27:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `combos`
--

CREATE TABLE `combos` (
  `idCombo` int(11) NOT NULL,
  `idRestaurant` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `imagen` text COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `descuento` double NOT NULL,
  `activo` int(11) NOT NULL,
  `aux_1` text COLLATE utf8_spanish_ci NOT NULL,
  `aux_2` text COLLATE utf8_spanish_ci NOT NULL,
  `aux_3` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha_registro` varchar(20) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `combos`
--

INSERT INTO `combos` (`idCombo`, `idRestaurant`, `nombre`, `imagen`, `descripcion`, `descuento`, `activo`, `aux_1`, `aux_2`, `aux_3`, `fecha_registro`) VALUES
(1, 1, 'COMBO 1', 'recursos/core/img/combo-defecto.jpg', 'Descripcion\ncon\nsalto\nde\nlinea', 10, 1, '', '', '', '2020-06-29 2-22-39'),
(3, 1, 'COMBO 2', 'recursos/restaurantes/1/combo-3.jpg', 'Combo de una pizza con un refresco', 20, 1, '', '', '', '2020-06-30 3-57-12'),
(4, 1, 'ALCOHOL', 'recursos/restaurantes/1/combo-4.jpg', 'asd', 50, 1, '', '', '', '2020-07-16 2-42-43'),
(5, 1, 'Rodrigo', 'recursos/restaurantes/1/combo-5.jpg', 'Menu Rodrigo:\n- Bebidas:\nCoca Cola\n7up\n- Platos\nPasta\nPescado\n- Postres\nHelado de Vainilla\n- Vinos\nVino tinto', 20, 1, '', '', '', '2020-10-12 17:38:56');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `combos_categorias`
--

CREATE TABLE `combos_categorias` (
  `idComboCategoria` int(11) NOT NULL,
  `idCombo` int(11) NOT NULL,
  `idCategoria` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `aux_1` text COLLATE utf8_spanish_ci NOT NULL,
  `aux_2` text COLLATE utf8_spanish_ci NOT NULL,
  `aux_3` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha_registro` varchar(20) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `combos_categorias`
--

INSERT INTO `combos_categorias` (`idComboCategoria`, `idCombo`, `idCategoria`, `cantidad`, `aux_1`, `aux_2`, `aux_3`, `fecha_registro`) VALUES
(6, 2, 7, 2, '', '', '', '2020-06-30 4-30-49'),
(7, 3, 6, 1, '', '', '', '2020-07-10 21-34-00'),
(8, 3, 7, 1, '', '', '', '2020-07-10 21-34-00'),
(9, 4, 8, 2, '', '', '', '2020-07-16 2-48-43'),
(10, 4, 7, 2, '', '', '', '2020-07-16 2-48-43'),
(11, 1, 7, 2, '', '', '', '2020-08-11 8:49:43'),
(12, 1, 6, 2, '', '', '', '2020-08-11 8:49:43'),
(13, 5, 7, 1, '', '', '', '2020-10-12 17:39:33'),
(14, 5, 8, 1, '', '', '', '2020-10-12 17:39:33'),
(15, 5, 6, 1, '', '', '', '2020-10-12 17:39:33');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `combos_platos`
--

CREATE TABLE `combos_platos` (
  `idComboPlato` int(11) NOT NULL,
  `idCombo` int(11) NOT NULL,
  `idPlato` int(11) NOT NULL,
  `aux_1` text COLLATE utf8_spanish_ci NOT NULL,
  `aux_2` text COLLATE utf8_spanish_ci NOT NULL,
  `aux_3` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha_registro` varchar(20) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `combos_platos`
--

INSERT INTO `combos_platos` (`idComboPlato`, `idCombo`, `idPlato`, `aux_1`, `aux_2`, `aux_3`, `fecha_registro`) VALUES
(7, 3, 1, '', '', '', '2020-07-10 21-34-00'),
(8, 3, 13, '', '', '', '2020-07-10 21-34-00'),
(9, 3, 6, '', '', '', '2020-07-10 21-34-00'),
(10, 4, 5, '', '', '', '2020-07-16 2-48-43'),
(11, 4, 9, '', '', '', '2020-07-16 2-48-43'),
(12, 4, 2, '', '', '', '2020-07-16 2-48-43'),
(13, 4, 12, '', '', '', '2020-07-16 2-48-43'),
(14, 1, 12, '', '', '', '2020-08-11 8:49:43'),
(15, 1, 2, '', '', '', '2020-08-11 8:49:43'),
(16, 1, 9, '', '', '', '2020-08-11 8:49:43'),
(17, 1, 11, '', '', '', '2020-08-11 8:49:43'),
(18, 1, 10, '', '', '', '2020-08-11 8:49:43'),
(19, 1, 4, '', '', '', '2020-08-11 8:49:43'),
(20, 5, 8, '', '', '', '2020-10-12 17:39:33'),
(21, 5, 6, '', '', '', '2020-10-12 17:39:33'),
(22, 5, 5, '', '', '', '2020-10-12 17:39:33'),
(23, 5, 2, '', '', '', '2020-10-12 17:39:33'),
(24, 5, 4, '', '', '', '2020-10-12 17:39:33');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE `facturas` (
  `idFactura` bigint(20) NOT NULL,
  `idRestaurant` int(11) NOT NULL,
  `idMesa` int(11) NOT NULL,
  `idMoneda` int(11) NOT NULL,
  `subtotal` float NOT NULL,
  `iva` float NOT NULL,
  `fecha` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `hora` varchar(10) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `facturas`
--

INSERT INTO `facturas` (`idFactura`, `idRestaurant`, `idMesa`, `idMoneda`, `subtotal`, `iva`, `fecha`, `hora`) VALUES
(1, 1, 1, 2, 850, 0, '2020-08-23', '21:56:15'),
(2, 1, 1, 2, 1760, 0, '2020-08-23', '21:56:18'),
(3, 1, 1, 2, 2900, 0, '2020-08-26', '23:03:36'),
(4, 1, 3, 2, 850, 0, '2020-08-26', '23:03:44'),
(5, 1, 1, 2, 1600, 0, '2020-09-14', '11:14:13'),
(6, 1, -1, 2, 223, 0, '2020-09-15', '16:55:13'),
(7, 1, -1, 2, 2510, 0, '2020-09-15', '17:02:39'),
(8, 1, -1, 2, 0, 0, '2020-10-07', '08:11:39'),
(9, 1, -1, 2, 223, 0, '2020-10-07', '08:19:30'),
(10, 1, -1, 2, 1760, 0, '2020-10-07', '08:19:33'),
(11, 1, 1, 2, 2260, 10, '2020-10-13', '08:47:37'),
(12, 1, 1, 2, 100, 10, '2020-10-13', '08:48:47'),
(13, 1, -1, 2, 1860, 10, '2020-10-13', '08:49:38'),
(14, 1, -1, 2, 100, 10, '2020-10-13', '10:27:42'),
(15, 1, 1, 2, 123, 10, '2020-10-13', '10:42:22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas_detalles`
--

CREATE TABLE `facturas_detalles` (
  `idFacturaDetalle` bigint(20) NOT NULL,
  `idFactura` bigint(20) NOT NULL,
  `idMesa` int(11) NOT NULL,
  `idPlato` int(11) NOT NULL,
  `nombrePlato` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `idCombo` int(11) DEFAULT NULL,
  `nombreCombo` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `loteCombo` int(11) DEFAULT NULL,
  `idAreaMonitoreo` int(11) NOT NULL,
  `precioUnitario` double NOT NULL,
  `cantidad` double NOT NULL,
  `descuento` double NOT NULL,
  `precioTotal` double NOT NULL,
  `nota` text COLLATE utf8_spanish_ci NOT NULL,
  `status` int(11) NOT NULL,
  `motivo_cancelado` text COLLATE utf8_spanish_ci,
  `para_llevar` tinyint(4) NOT NULL,
  `aux_1` text COLLATE utf8_spanish_ci,
  `aux_2` text COLLATE utf8_spanish_ci,
  `aux_3` text COLLATE utf8_spanish_ci,
  `fecha_registro` varchar(20) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `facturas_detalles`
--

INSERT INTO `facturas_detalles` (`idFacturaDetalle`, `idFactura`, `idMesa`, `idPlato`, `nombrePlato`, `idCombo`, `nombreCombo`, `loteCombo`, `idAreaMonitoreo`, `precioUnitario`, `cantidad`, `descuento`, `precioTotal`, `nota`, `status`, `motivo_cancelado`, `para_llevar`, `aux_1`, `aux_2`, `aux_3`, `fecha_registro`) VALUES
(1, 1, 1, 4, 'PASTA EN SALSA', 0, 'null', 0, 1, 100, 1, 0, 100, '', 4, NULL, 0, NULL, NULL, NULL, '2020-08-23 21:56:15'),
(2, 1, 1, 10, 'PASTICHO', 0, 'null', 0, 1, 750, 1, 0, 750, '', 4, NULL, 0, NULL, NULL, NULL, '2020-08-23 21:56:15'),
(3, 2, 1, 1, 'PIZZA MARGARITA', 3, 'COMBO 2', 1, 1, 2000, 1, 20, 1600, '', 4, NULL, 0, NULL, NULL, NULL, '2020-08-23 21:56:18'),
(4, 2, 1, 13, 'PEPSI', 3, 'COMBO 2', 1, 2, 200, 1, 20, 160, '', 4, NULL, 0, NULL, NULL, NULL, '2020-08-23 21:56:18'),
(5, -1, 1, 14, 'ASD', 0, 'null', 0, 1, 123, 1, 0, 123, '', 5, '1', 0, NULL, NULL, NULL, '2020-08-23 22:07:41'),
(6, -1, 1, 10, 'PASTICHO', 0, 'null', 0, 1, 750, 1, 0, 750, '', 5, '1', 0, NULL, NULL, NULL, '2020-08-23 22:07:42'),
(7, -1, 1, 8, '7UP', 0, 'null', 0, 2, 200, 1, 0, 200, '', 5, '1', 0, NULL, NULL, NULL, '2020-08-23 22:07:44'),
(8, -1, 1, 5, 'HELADO DE VAINILLA', 0, 'null', 0, 3, 150, 1, 0, 150, '', 5, '1', 0, NULL, NULL, NULL, '2020-08-23 22:07:47'),
(9, 3, 1, 5, 'HELADO DE VAINILLA', 0, 'null', 0, 4, 150, 1, 0, 150, '', 4, NULL, 0, NULL, NULL, NULL, '2020-08-26 23:03:37'),
(10, 3, 1, 8, '7UP', 0, 'null', 0, 3, 200, 1, 0, 200, '', 4, NULL, 0, NULL, NULL, NULL, '2020-08-26 23:03:37'),
(11, 3, 1, 7, 'FRESCOLITA', 0, 'null', 0, 3, 200, 1, 0, 200, '', 4, NULL, 0, NULL, NULL, NULL, '2020-08-26 23:03:37'),
(12, 3, 1, 11, 'PESCADO FRITO', 0, 'null', 0, 2, 1500, 1, 0, 1500, '', 4, NULL, 0, NULL, NULL, NULL, '2020-08-26 23:03:37'),
(13, 3, 1, 10, 'PASTICHO', 0, 'null', 0, 2, 750, 1, 0, 750, '', 4, NULL, 0, NULL, NULL, NULL, '2020-08-26 23:03:37'),
(14, 3, 1, 4, 'PASTA EN SALSA', 0, 'null', 0, 2, 100, 1, 0, 100, '', 4, NULL, 0, NULL, NULL, NULL, '2020-08-26 23:03:37'),
(15, 4, 3, 4, 'PASTA EN SALSA', 0, 'null', 0, 2, 100, 1, 0, 100, '', 4, NULL, 0, NULL, NULL, NULL, '2020-08-26 23:03:44'),
(16, 4, 3, 10, 'PASTICHO', 0, 'null', 0, 2, 750, 1, 0, 750, '', 4, NULL, 0, NULL, NULL, NULL, '2020-08-26 23:03:44'),
(17, -1, 1, 10, 'PASTICHO', 0, 'null', 0, 2, 750, 5, 0, 3750, '', 5, 'Prueba', 0, NULL, NULL, NULL, '2020-09-14 11:08:57'),
(18, 5, 1, 4, 'PASTA EN SALSA', 0, 'null', 0, 2, 100, 1, 0, 100, '', 4, NULL, 0, NULL, NULL, NULL, '2020-09-14 11:14:13'),
(19, 5, 1, 11, 'PESCADO FRITO', 0, 'null', 0, 2, 1500, 1, 0, 1500, '123', 4, NULL, 0, NULL, NULL, NULL, '2020-09-14 11:14:13'),
(20, 6, -1, 14, 'ASD', 0, 'null', 0, 2, 123, 1, 0, 123, '', 4, NULL, 1, NULL, NULL, NULL, '2020-09-15 16:55:13'),
(21, 6, -1, 4, 'PASTA EN SALSA', 0, 'null', 0, 2, 100, 1, 0, 100, '', 4, NULL, 1, NULL, NULL, NULL, '2020-09-15 16:55:13'),
(22, 7, -1, 10, 'PASTICHO', 0, 'null', 0, 2, 750, 1, 0, 750, '', 4, NULL, 1, NULL, NULL, NULL, '2020-09-15 17:02:39'),
(23, 7, -1, 1, 'PIZZA MARGARITA', 3, 'COMBO 2', 1, 2, 2000, 1, 20, 1600, '', 4, NULL, 1, NULL, NULL, NULL, '2020-09-15 17:02:40'),
(24, 7, -1, 13, 'PEPSI', 3, 'COMBO 2', 1, 3, 200, 1, 20, 160, '', 4, NULL, 1, NULL, NULL, NULL, '2020-09-15 17:02:40'),
(25, 9, -1, 14, 'ASD', 0, 'null', 0, 2, 123, 1, 0, 123, '', 4, NULL, 1, NULL, NULL, NULL, '2020-10-07 08:19:30'),
(26, 9, -1, 4, 'PASTA EN SALSA', 0, 'null', 0, 2, 100, 1, 0, 100, '', 4, NULL, 1, NULL, NULL, NULL, '2020-10-07 08:19:30'),
(27, 10, -1, 1, 'PIZZA MARGARITA', 3, 'COMBO 2', 1, 2, 2000, 1, 20, 1600, '', 4, NULL, 1, NULL, NULL, NULL, '2020-10-07 08:19:33'),
(28, 10, -1, 13, 'PEPSI', 3, 'COMBO 2', 1, 3, 200, 1, 20, 160, '', 4, NULL, 1, NULL, NULL, NULL, '2020-10-07 08:19:33'),
(29, 11, 1, 1, 'PIZZA MARGARITA', 3, 'COMBO 2', 1, 2, 2000, 1, 20, 1600, '', 4, NULL, 0, NULL, NULL, NULL, '2020-10-13 08:47:37'),
(30, 11, 1, 13, 'PEPSI', 3, 'COMBO 2', 1, 3, 200, 1, 20, 160, '', 4, NULL, 0, NULL, NULL, NULL, '2020-10-13 08:47:37'),
(31, 11, 1, 4, 'PASTA EN SALSA', 0, 'null', 0, 2, 100, 1, 0, 100, '', 4, NULL, 0, NULL, NULL, NULL, '2020-10-13 08:47:37'),
(32, 11, 1, 13, 'PEPSI', 0, 'null', 0, 3, 200, 2, 0, 400, '', 4, NULL, 0, NULL, NULL, NULL, '2020-10-13 08:47:38'),
(33, 12, 1, 4, 'PASTA EN SALSA', 0, 'null', 0, 2, 100, 1, 0, 100, '', 4, NULL, 0, NULL, NULL, NULL, '2020-10-13 08:48:47'),
(34, 13, -1, 4, 'PASTA EN SALSA', 0, 'null', 0, 2, 100, 1, 0, 100, '', 4, NULL, 1, NULL, NULL, NULL, '2020-10-13 08:49:38'),
(35, 13, -1, 1, 'PIZZA MARGARITA', 3, 'COMBO 2', 2, 2, 2000, 1, 20, 1600, '', 4, NULL, 1, NULL, NULL, NULL, '2020-10-13 08:49:38'),
(36, 13, -1, 13, 'PEPSI', 3, 'COMBO 2', 2, 3, 200, 1, 20, 160, '', 4, NULL, 1, NULL, NULL, NULL, '2020-10-13 08:49:38'),
(37, 14, -1, 4, 'PASTA EN SALSA', 0, 'null', 0, 2, 100, 1, 0, 100, '', 4, NULL, 1, NULL, NULL, NULL, '2020-10-13 10:27:42'),
(38, 15, 1, 14, 'ASD', 0, 'null', 0, 2, 123, 1, 0, 123, '', 4, NULL, 0, NULL, NULL, NULL, '2020-10-13 10:42:22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menus_a`
--

CREATE TABLE `menus_a` (
  `idMenuA` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `img` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `link` text COLLATE utf8_spanish_ci NOT NULL,
  `con_opciones` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `menus_a`
--

INSERT INTO `menus_a` (`idMenuA`, `nombre`, `img`, `link`, `con_opciones`) VALUES
(1, 'Categorias', 'fas fa-tags', 'Categorias/', 0),
(2, 'Platos', 'fas fa-hamburger', 'Platos/', 0),
(3, 'Menus y promociones', 'fas fa-home', 'Menus/', 0),
(4, 'Mesas', 'fas fa-utensils', 'Mesas/', 0),
(5, 'Para llevar', 'fas fa-car', 'Para_Llevar/', 0),
(6, 'Monitoreo', 'fas fa-video', 'Monitoreo/', 1),
(7, 'Facturas', 'fas fa-receipt', 'Facturas/', 1),
(8, 'Estadisticas', 'fas fa-chart-line', 'Estadisticas/', 1),
(9, 'Usuario', 'fas fa-users', 'Usuarios/', 0),
(10, 'Configuracion', 'fas fa-chart-area', 'Configuracion/', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menus_b`
--

CREATE TABLE `menus_b` (
  `idMenuB` int(11) NOT NULL,
  `idMenuA` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `img` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `link` text COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `menus_b`
--

INSERT INTO `menus_b` (`idMenuB`, `idMenuA`, `nombre`, `img`, `link`) VALUES
(-2, 6, 'Pedidos - General', 'far fa-circle', 'Monitoreo/Pedidos/General/'),
(-1, 6, 'Pedidos - Cocina', 'far fa-circle', 'Monitoreo/Pedidos/Cocina/'),
(0, 6, 'Pedidos - Bar', 'far fa-circle', 'Monitoreo/Pedidos/Bar/'),
(1, 6, 'Pedidos - Postres', 'far fa-circle', 'Monitoreo/Pedidos/Postres/'),
(2, 6, 'Camarero', 'fas fa-concierge-bell', 'Monitoreo/Camarero/'),
(3, 6, 'Caja', 'fas fa-cash-register', 'Monitoreo/Caja/'),
(4, 7, 'Hoy', 'far fa-circle', 'Facturas/hoy/'),
(5, 7, 'General', 'far fa-circle', 'Facturas/General/'),
(6, 8, 'Por platillos', 'far fa-circle', 'Estadisticas/Por_Platillos/'),
(7, 10, 'Administración', 'far fa-circle', 'Configuracion/Administracion/'),
(8, 10, 'Datos', 'far fa-circle', 'Configuracion/Datos/'),
(9, 10, 'Redes sociales', 'far fa-circle', 'Configuracion/Redes_Sociales/'),
(10, 8, 'Por Menus', 'far fa-circle', 'Estadisticas/Por_Menus/'),
(11, 8, 'Por Categorias', 'far fa-circle', 'Estadisticas/Por_Categorias/'),
(12, 8, 'Por Areas', 'far fa-circle', 'Estadisticas/Por_Areas/'),
(13, 8, 'Por Mesas', 'far fa-circle', 'Estadisticas/Por_Mesas/'),
(14, 10, 'Servicio', 'far fa-circle', 'Configuracion/Servicio/');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesas`
--

CREATE TABLE `mesas` (
  `idMesa` int(11) NOT NULL,
  `idRestaurant` int(11) NOT NULL,
  `status` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `alias` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `usuario` varchar(32) COLLATE utf8_spanish_ci NOT NULL,
  `clave` varchar(32) COLLATE utf8_spanish_ci NOT NULL,
  `solicitar_camarero` tinyint(4) NOT NULL,
  `aux_1` text COLLATE utf8_spanish_ci NOT NULL,
  `aux_2` text COLLATE utf8_spanish_ci NOT NULL,
  `aux_3` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha_registro` varchar(20) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `mesas`
--

INSERT INTO `mesas` (`idMesa`, `idRestaurant`, `status`, `alias`, `usuario`, `clave`, `solicitar_camarero`, `aux_1`, `aux_2`, `aux_3`, `fecha_registro`) VALUES
(1, 1, 'ABIERTA', 'MESA 1', 'mesa1', '1234', 0, '', '', '', '2020-06-17 13-43-37'),
(2, 1, 'CERRADA', 'MESA 2', 'mesa2', '1234', 0, '', '', '', '2020-06-17 13-55-42'),
(3, 1, 'ABIERTA', 'MESA 3', 'mesa3', '1234', 0, '', '', '', '2020-06-17 13-55-50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `monedas`
--

CREATE TABLE `monedas` (
  `idMoneda` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `simbolo` varchar(10) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `monedas`
--

INSERT INTO `monedas` (`idMoneda`, `nombre`, `simbolo`) VALUES
(1, 'Dolar', '$'),
(2, 'Euro', '€'),
(3, 'Bolivar', 'Bs');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos_a`
--

CREATE TABLE `permisos_a` (
  `idRol` int(11) NOT NULL,
  `idMenuA` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `permisos_a`
--

INSERT INTO `permisos_a` (`idRol`, `idMenuA`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos_b`
--

CREATE TABLE `permisos_b` (
  `idRol` int(11) NOT NULL,
  `idMenuB` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `permisos_b`
--

INSERT INTO `permisos_b` (`idRol`, `idMenuB`) VALUES
(1, -2),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 10),
(1, 11),
(1, 12),
(1, 13),
(1, 7),
(1, 8),
(1, 9),
(1, 14);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `platos`
--

CREATE TABLE `platos` (
  `idPlato` int(11) NOT NULL,
  `idRestaurant` int(11) NOT NULL,
  `idCategoria` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `imagen` text COLLATE utf8_spanish_ci,
  `activo` tinyint(1) NOT NULL,
  `precioCosto` double NOT NULL,
  `precioVenta` double NOT NULL,
  `aux_1` text COLLATE utf8_spanish_ci,
  `aux_2` text COLLATE utf8_spanish_ci,
  `aux_3` text COLLATE utf8_spanish_ci,
  `fecha_registro` varchar(20) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `platos`
--

INSERT INTO `platos` (`idPlato`, `idRestaurant`, `idCategoria`, `nombre`, `descripcion`, `imagen`, `activo`, `precioCosto`, `precioVenta`, `aux_1`, `aux_2`, `aux_3`, `fecha_registro`) VALUES
(1, 1, 6, 'PIZZA MARGARITA', 'PIZZA CON ALGUNOS INGREDIENTES', 'recursos/restaurantes/1/plato-1.jpg', 1, 1000, 2000, NULL, NULL, NULL, '2020-06-12 18-52-39'),
(2, 1, 7, 'VINO TINTO', 'BEBIDA MUY RICA', 'recursos/restaurantes/1/plato-2.jpg', 1, 10, 110, NULL, NULL, NULL, '2020-06-12 18-53-35'),
(4, 1, 6, 'PASTA EN SALSA', 'CON SALSA', 'recursos/restaurantes/1/plato-4.jpg', 1, 10, 100, NULL, NULL, NULL, '2020-06-12 19-44-37'),
(5, 1, 8, 'HELADO DE VAINILLA', 'UN POSTRE MUY SABROSO', 'recursos/restaurantes/1/plato-5.jpg', 1, 100, 150, NULL, NULL, NULL, '2020-06-13 5-45-29'),
(6, 1, 7, 'COCA-COLA', 'REFRESCO', 'recursos/restaurantes/1/plato-6.jpg', 1, 100, 200, NULL, NULL, NULL, '2020-06-13 6-48-44'),
(7, 1, 7, 'FRESCOLITA', 'REFRESCO', 'recursos/restaurantes/1/plato-7.jpg', 1, 100, 200, NULL, NULL, NULL, '2020-06-13 6-49-02'),
(8, 1, 7, '7UP', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using Content here, content here, making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for lorem ipsum will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', 'recursos/restaurantes/1/plato-8.jpg', 1, 100, 100, NULL, NULL, NULL, '2020-06-13 6-49-18'),
(9, 1, 7, 'LICOR TIPO A', 'LICORES', 'recursos/restaurantes/1/plato-9.jpg', 1, 150, 375, NULL, NULL, NULL, '2020-06-13 6-49-38'),
(10, 1, 6, 'PASTICHO', 'PASTA', 'recursos/restaurantes/1/plato-10.jpg', 1, 500, 750, NULL, NULL, NULL, '2020-06-13 6-50-12'),
(11, 1, 6, 'PESCADO FRITO', 'PESCADOS', 'recursos/restaurantes/1/plato-11.jpg', 1, 1000, 1500, NULL, NULL, NULL, '2020-06-13 6-50-37'),
(12, 1, 7, 'WHISKY', 'LICORES', 'recursos/restaurantes/1/plato-12.jpg', 1, 500, 750, NULL, NULL, NULL, '2020-06-13 6-51-01'),
(13, 1, 7, 'PEPSI', 'REFRESCO', 'recursos/restaurantes/1/plato-13.jpg', 1, 100, 200, NULL, NULL, NULL, '2020-06-13 6-51-35'),
(14, 1, 6, 'ASD', 'HOLA MUNDO\n\nINGREDIENTES:\n1\n2\n3\n4', 'recursos/restaurantes/1/plato-14.png', 1, 123, 123, NULL, NULL, NULL, '2020-08-11 8:12:56');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `restaurantes`
--

CREATE TABLE `restaurantes` (
  `idRestaurant` int(11) NOT NULL,
  `documento` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `direccion` text COLLATE utf8_spanish_ci NOT NULL,
  `telefono` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `correo` text COLLATE utf8_spanish_ci NOT NULL,
  `logo` text COLLATE utf8_spanish_ci,
  `facebook` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `twitter` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `instagram` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `whatsapp` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `activo` tinyint(1) NOT NULL,
  `imagencomanda` text COLLATE utf8_spanish_ci NOT NULL,
  `titulocomanda` text COLLATE utf8_spanish_ci NOT NULL,
  `textocomanda` text COLLATE utf8_spanish_ci NOT NULL,
  `imagencombo` text COLLATE utf8_spanish_ci NOT NULL,
  `titulocombo` text COLLATE utf8_spanish_ci NOT NULL,
  `textocombo` text COLLATE utf8_spanish_ci NOT NULL,
  `idMoneda` int(11) NOT NULL,
  `servicio` tinyint(4) NOT NULL DEFAULT '0',
  `imprimirFactura` int(11) NOT NULL DEFAULT '1',
  `iva` float NOT NULL DEFAULT '0',
  `aux_1` text COLLATE utf8_spanish_ci,
  `aux_2` text COLLATE utf8_spanish_ci,
  `aux_3` text COLLATE utf8_spanish_ci,
  `fecha_registro` varchar(20) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `restaurantes`
--

INSERT INTO `restaurantes` (`idRestaurant`, `documento`, `nombre`, `direccion`, `telefono`, `correo`, `logo`, `facebook`, `twitter`, `instagram`, `whatsapp`, `activo`, `imagencomanda`, `titulocomanda`, `textocomanda`, `imagencombo`, `titulocombo`, `textocombo`, `idMoneda`, `servicio`, `imprimirFactura`, `iva`, `aux_1`, `aux_2`, `aux_3`, `fecha_registro`) VALUES
(1, 'J254099046', 'Empresa de Jefferson CA', 'En un comercio', '', '', 'logo.png', '', '', '', '', 1, 'imgcomanda.png', 'Carta', 'Elije un platillo entre nuestra carta', 'imgcombo.png', 'Menus y promociones', 'Elije un menu y aprovecha nuestros descuentos', 2, 1, 1, 10, NULL, NULL, NULL, '2020-06-11 1-14-34'),
(2, 'J227640502', 'Amargados Asociados CA', 'En un comercio de nuevo', '', '', 'logo.svg', NULL, NULL, NULL, NULL, 1, '', '', '', '', '', '', 3, 0, 1, 0, NULL, NULL, NULL, '2020-06-11 1-15-30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `idRol` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `responsable` bit(1) NOT NULL,
  `fecha_registro` varchar(20) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`idRol`, `nombre`, `descripcion`, `responsable`, `fecha_registro`) VALUES
(1, 'Gerente', '', b'1', '2020-09-14 00:00:00'),
(2, 'Caja', '', b'0', '2020-09-14 00:00:00'),
(3, 'Camarero', '', b'0', '2020-09-14 00:00:00'),
(4, 'Cocina', '', b'0', '2020-09-14 00:00:00'),
(5, 'Bar', '', b'0', '2020-09-14 00:00:00'),
(6, 'Mesa de postre', '', b'0', '2020-09-14 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles_permisos`
--

CREATE TABLE `roles_permisos` (
  `idRol` int(11) NOT NULL,
  `idRestaurant` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `roles_permisos`
--

INSERT INTO `roles_permisos` (`idRol`, `idRestaurant`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuario` int(11) NOT NULL,
  `idRestaurant` int(11) NOT NULL,
  `usuario` varchar(32) COLLATE utf8_spanish_ci NOT NULL,
  `clave` varchar(32) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `documento` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `idRol` int(11) NOT NULL,
  `direccion` text COLLATE utf8_spanish_ci,
  `telefono` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `correo` text COLLATE utf8_spanish_ci,
  `foto` text COLLATE utf8_spanish_ci,
  `activo` tinyint(1) NOT NULL,
  `aux_1` text COLLATE utf8_spanish_ci,
  `aux_2` text COLLATE utf8_spanish_ci,
  `aux_3` text COLLATE utf8_spanish_ci,
  `fecha_registro` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_modificacion` varchar(20) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `idRestaurant`, `usuario`, `clave`, `nombre`, `documento`, `idRol`, `direccion`, `telefono`, `correo`, `foto`, `activo`, `aux_1`, `aux_2`, `aux_3`, `fecha_registro`, `fecha_modificacion`) VALUES
(1, 1, 'admin', 'admin', 'Jefferson Torres', 'V25409904', 1, '', '', 'jefersonugas@gmail.com', 'usuario-admin.jpg', 1, NULL, NULL, NULL, '2020-06-11 15-1-45', '2020-08-11 8:8:55'),
(2, 2, 'katthyg', 'katthyg', 'Katiuska Gonzalez', 'V22764050', 3, 'En una casa de nuevo', '04262889861', 'jeffersonjtorresu@gmail.com', NULL, 1, NULL, NULL, NULL, '2020-06-11 1-15-30', '2020-06-11 1-15-30'),
(3, 1, 'test', '123', 'Test User', '000000', 3, 'Por alli', '04241738615', 'test@gmail.com', NULL, 1, NULL, NULL, NULL, '2020-08-02 7:30:58', '2020-09-15 5:22:28');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `adm_menus_a`
--
ALTER TABLE `adm_menus_a`
  ADD PRIMARY KEY (`idMenuA`);

--
-- Indices de la tabla `adm_menus_b`
--
ALTER TABLE `adm_menus_b`
  ADD PRIMARY KEY (`idMenuB`);

--
-- Indices de la tabla `adm_usuarios`
--
ALTER TABLE `adm_usuarios`
  ADD PRIMARY KEY (`usuario`),
  ADD KEY `usuario` (`usuario`);

--
-- Indices de la tabla `areas_monitoreo`
--
ALTER TABLE `areas_monitoreo`
  ADD PRIMARY KEY (`idAreaMonitoreo`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`idCategoria`);

--
-- Indices de la tabla `combos`
--
ALTER TABLE `combos`
  ADD PRIMARY KEY (`idCombo`);

--
-- Indices de la tabla `combos_categorias`
--
ALTER TABLE `combos_categorias`
  ADD PRIMARY KEY (`idComboCategoria`);

--
-- Indices de la tabla `combos_platos`
--
ALTER TABLE `combos_platos`
  ADD PRIMARY KEY (`idComboPlato`);

--
-- Indices de la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD PRIMARY KEY (`idFactura`);

--
-- Indices de la tabla `facturas_detalles`
--
ALTER TABLE `facturas_detalles`
  ADD PRIMARY KEY (`idFacturaDetalle`);

--
-- Indices de la tabla `menus_a`
--
ALTER TABLE `menus_a`
  ADD PRIMARY KEY (`idMenuA`);

--
-- Indices de la tabla `menus_b`
--
ALTER TABLE `menus_b`
  ADD PRIMARY KEY (`idMenuB`);

--
-- Indices de la tabla `mesas`
--
ALTER TABLE `mesas`
  ADD PRIMARY KEY (`idMesa`);

--
-- Indices de la tabla `monedas`
--
ALTER TABLE `monedas`
  ADD PRIMARY KEY (`idMoneda`);

--
-- Indices de la tabla `platos`
--
ALTER TABLE `platos`
  ADD PRIMARY KEY (`idPlato`);

--
-- Indices de la tabla `restaurantes`
--
ALTER TABLE `restaurantes`
  ADD PRIMARY KEY (`idRestaurant`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`idRol`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `combos_categorias`
--
ALTER TABLE `combos_categorias`
  MODIFY `idComboCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `combos_platos`
--
ALTER TABLE `combos_platos`
  MODIFY `idComboPlato` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `monedas`
--
ALTER TABLE `monedas`
  MODIFY `idMoneda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
