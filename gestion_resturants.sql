-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-08-2020 a las 14:35:36
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
(1, 'COCINA'),
(2, 'BAR'),
(3, 'POSTRES'),
(4, 'TODOS');

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
(6, 1, 'COMIDAS', 1, '2020-06-12 19-54-15'),
(7, 1, 'BEBIDAS', 2, '2020-06-12 19-54-20'),
(8, 1, 'POSTRES', 3, '2020-06-12 19-54-25');

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
(1, 1, 'COMBO 1', '', '', 10, 1, '', '', '', '2020-06-29 2-22-39'),
(3, 1, 'COMBO 2', 'combo-3.jpg', 'Combo de una pizza con un refresco', 20, 1, '', '', '', '2020-06-30 3-57-12'),
(4, 1, 'ALCOHOL', 'combo-4.jpg', 'asd', 50, 1, '', '', '', '2020-07-16 2-42-43');

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
(1, 1, 7, 2, '', '', '', '2020-06-30 3-28-20'),
(2, 1, 6, 2, '', '', '', '2020-06-30 3-28-20'),
(6, 2, 7, 2, '', '', '', '2020-06-30 4-30-49'),
(7, 3, 6, 1, '', '', '', '2020-07-10 21-34-00'),
(8, 3, 7, 1, '', '', '', '2020-07-10 21-34-00'),
(9, 4, 8, 2, '', '', '', '2020-07-16 2-48-43'),
(10, 4, 7, 2, '', '', '', '2020-07-16 2-48-43');

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
(1, 1, 12, '', '', '', '2020-06-30 3-28-20'),
(2, 1, 2, '', '', '', '2020-06-30 3-28-20'),
(3, 1, 9, '', '', '', '2020-06-30 3-28-20'),
(4, 1, 11, '', '', '', '2020-06-30 3-28-20'),
(5, 1, 10, '', '', '', '2020-06-30 3-28-20'),
(6, 1, 4, '', '', '', '2020-06-30 3-28-20'),
(7, 3, 1, '', '', '', '2020-07-10 21-34-00'),
(8, 3, 13, '', '', '', '2020-07-10 21-34-00'),
(9, 3, 6, '', '', '', '2020-07-10 21-34-00'),
(10, 4, 5, '', '', '', '2020-07-16 2-48-43'),
(11, 4, 9, '', '', '', '2020-07-16 2-48-43'),
(12, 4, 2, '', '', '', '2020-07-16 2-48-43'),
(13, 4, 12, '', '', '', '2020-07-16 2-48-43');

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
(3, 'Menus', 'fas fa-home', 'Menus/', 0),
(4, 'Mesas', 'fas fa-utensils', 'Mesas/', 0),
(5, 'Monitoreo', 'fas fa-receipt', 'Monitoreo/', 1),
(6, 'Pedidos', 'fas fa-receipt', 'Pedidos/', 1),
(7, 'Contabilidad', 'fas fa-home', '#Caja', 0),
(8, 'Usuario', 'fas fa-users', 'Usuarios/', 0),
(9, 'Configuracion', 'fas fa-chart-area', 'Configuracion/', 0);

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
(1, 5, 'Cocina', 'far fa-circle', 'Monitoreo/Cocina/'),
(2, 5, 'Camarero', 'far fa-circle', 'Monitoreo/Camarero/'),
(3, 5, 'Caja', 'far fa-circle', 'Monitoreo/Caja/'),
(4, 6, 'Para llevar', 'far fa-circle', 'Monitoreo/Postres/'),
(5, 6, 'Gestion', 'far fa-circle', 'Monitoreo/Postres/');

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
  `aux_1` text COLLATE utf8_spanish_ci NOT NULL,
  `aux_2` text COLLATE utf8_spanish_ci NOT NULL,
  `aux_3` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha_registro` varchar(20) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `mesas`
--

INSERT INTO `mesas` (`idMesa`, `idRestaurant`, `status`, `alias`, `usuario`, `clave`, `aux_1`, `aux_2`, `aux_3`, `fecha_registro`) VALUES
(1, 1, 'ABIERTA', 'MESA 1', 'mesa1', '1234', '', '', '', '2020-06-17 13-43-37'),
(2, 1, 'CERRADA', 'MESA 2', 'mesa2', '1234', '', '', '', '2020-06-17 13-55-42'),
(3, 1, 'ABIERTA', 'MESA 3', 'mesa3', '1234', '', '', '', '2020-06-17 13-55-50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `idPedido` bigint(20) NOT NULL,
  `idRestaurant` int(11) NOT NULL,
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
  `para_llevar` tinyint(4) NOT NULL,
  `aux_1` text COLLATE utf8_spanish_ci,
  `aux_2` text COLLATE utf8_spanish_ci,
  `aux_3` text COLLATE utf8_spanish_ci,
  `fecha_registro` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_modificacion` varchar(20) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

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
(2, 2),
(2, 3),
(2, 4),
(2, 8),
(3, 1),
(3, 2),
(3, 3),
(3, 4),
(3, 5),
(3, 6),
(3, 7),
(3, 8),
(4, 2),
(4, 3),
(4, 4),
(4, 8),
(3, 9),
(4, 1),
(4, 9),
(2, 1),
(1, 9),
(2, 9),
(5, 1),
(5, 2),
(5, 3),
(5, 4),
(5, 5),
(6, 2),
(6, 3),
(6, 4),
(6, 5),
(6, 6),
(6, 7),
(6, 8),
(7, 2),
(7, 3),
(7, 4),
(7, 7),
(7, 8),
(6, 2),
(6, 3),
(6, 4),
(6, 5),
(6, 6),
(6, 7),
(6, 8),
(7, 2),
(7, 3),
(7, 4),
(7, 7),
(7, 8),
(6, 2),
(6, 3),
(6, 4),
(6, 5),
(6, 6),
(6, 7),
(6, 8),
(7, 2),
(7, 3),
(7, 4),
(7, 7),
(7, 8),
(6, 1),
(6, 9),
(7, 1);

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
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(3, 1),
(3, 2),
(3, 3),
(3, 4),
(3, 5),
(1, 6),
(1, 7),
(3, 6),
(3, 7),
(5, 1),
(5, 2),
(6, 1),
(6, 2),
(6, 3),
(6, 4),
(6, 5),
(6, 6),
(6, 7),
(6, 1),
(6, 2),
(6, 3),
(6, 4),
(6, 5),
(6, 6),
(6, 7),
(6, 1),
(6, 2),
(6, 3),
(6, 4),
(6, 5),
(6, 6),
(6, 7);

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
(1, 1, 6, 'PIZZA MARGARITA', 'PIZZA CON ALGUNOS INGREDIENTES', 'PLATO-1.JPG', 1, 1000, 2000, NULL, NULL, NULL, '2020-06-12 18-52-39'),
(2, 1, 7, 'VINO TINTO', 'BEBIDA MUY RICA', 'PLATO-2.JPG', 1, 10, 110, NULL, NULL, NULL, '2020-06-12 18-53-35'),
(4, 1, 6, 'PASTA EN SALSA', 'CON SALSA', 'PLATO-4.JPG', 1, 10, 100, NULL, NULL, NULL, '2020-06-12 19-44-37'),
(5, 1, 8, 'HELADO DE VAINILLA', 'UN POSTRE MUY SABROSO', 'PLATO-5.JPG', 1, 100, 150, NULL, NULL, NULL, '2020-06-13 5-45-29'),
(6, 1, 7, 'COCA-COLA', 'REFRESCO', 'PLATO-6.JPG', 1, 100, 200, NULL, NULL, NULL, '2020-06-13 6-48-44'),
(7, 1, 7, 'FRESCOLITA', 'REFRESCO', 'PLATO-7.JPG', 1, 100, 200, NULL, NULL, NULL, '2020-06-13 6-49-02'),
(8, 1, 7, '7UP', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using Content here, content here, making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for lorem ipsum will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', 'PLATO-8.JPG', 1, 100, 200, NULL, NULL, NULL, '2020-06-13 6-49-18'),
(9, 1, 7, 'LICOR TIPO A', 'LICORES', 'PLATO-9.JPG', 1, 150, 375, NULL, NULL, NULL, '2020-06-13 6-49-38'),
(10, 1, 6, 'PASTICHO', 'PASTA', 'PLATO-10.JPG', 1, 500, 750, NULL, NULL, NULL, '2020-06-13 6-50-12'),
(11, 1, 6, 'PESCADO FRITO', 'PESCADOS', 'PLATO-11.JPG', 1, 1000, 1500, NULL, NULL, NULL, '2020-06-13 6-50-37'),
(12, 1, 7, 'WHISKY', 'LICORES', 'PLATO-12.JPG', 1, 500, 750, NULL, NULL, NULL, '2020-06-13 6-51-01'),
(13, 1, 7, 'PEPSI', 'REFRESCO', 'PLATO-13.JPG', 1, 100, 200, NULL, NULL, NULL, '2020-06-13 6-51-35');

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
  `servicio` tinyint(4) NOT NULL DEFAULT '0',
  `aux_1` text COLLATE utf8_spanish_ci,
  `aux_2` text COLLATE utf8_spanish_ci,
  `aux_3` text COLLATE utf8_spanish_ci,
  `fecha_registro` varchar(20) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `restaurantes`
--

INSERT INTO `restaurantes` (`idRestaurant`, `documento`, `nombre`, `direccion`, `telefono`, `correo`, `logo`, `facebook`, `twitter`, `instagram`, `whatsapp`, `activo`, `imagencomanda`, `titulocomanda`, `textocomanda`, `imagencombo`, `titulocombo`, `textocombo`, `servicio`, `aux_1`, `aux_2`, `aux_3`, `fecha_registro`) VALUES
(1, 'J254099046', 'Empresa de Jefferson CA', 'En un comercio', '', '', 'logo.png', '', '', '', '', 1, 'imgcomanda.png', 'CARTAS', 'Elije un platillo entre nuestra carta', 'imgcombo.png', 'MENUS', 'Elije un combo y aprovecha nuestros descuentos', 1, NULL, NULL, NULL, '2020-06-11 1-14-34'),
(2, 'J227640502', 'Amargados Asociados CA', 'En un comercio de nuevo', '', '', 'logo.svg', NULL, NULL, NULL, NULL, 1, '', '', '', '', '', '', 0, NULL, NULL, NULL, '2020-06-11 1-15-30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `idRol` int(11) NOT NULL,
  `idRestaurant` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `responsable` bit(1) NOT NULL,
  `fecha_registro` varchar(20) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`idRol`, `idRestaurant`, `nombre`, `descripcion`, `responsable`, `fecha_registro`) VALUES
(1, 1, 'GERENTE', '', b'1', '2020-06-11 1-14-34'),
(2, 1, 'BASICO', '', b'0', '2020-06-11 1-14-34'),
(3, 2, 'GERENTE', '', b'1', '2020-06-11 1-15-30'),
(4, 2, 'BASICO', '', b'0', '2020-06-11 1-15-30'),
(5, 1, 'TETST', '', b'0', '2020-07-05 14-32-10');

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
(1, 1, 'admin', 'admin', 'Jefferson Torres', 'V25409904', 1, '', '', 'jefersonugas@gmail.com', 'usuario-admin.jpg', 1, NULL, NULL, NULL, '2020-06-11 15-1-45', '2020-08-09 8:17:59'),
(2, 2, 'katthyg', 'katthyg', 'Katiuska Gonzalez', 'V22764050', 3, 'En una casa de nuevo', '04262889861', 'jeffersonjtorresu@gmail.com', NULL, 1, NULL, NULL, NULL, '2020-06-11 1-15-30', '2020-06-11 1-15-30'),
(3, 1, 'test', '123', 'Test User', '000000', 2, 'Por alli', '04241738615', 'test@gmail.com', NULL, 1, NULL, NULL, NULL, '2020-08-02 7:30:58', '2020-08-09 8:29:57');

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
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`idPedido`);

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
  MODIFY `idComboCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `combos_platos`
--
ALTER TABLE `combos_platos`
  MODIFY `idComboPlato` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
