-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-10-2020 a las 12:51:07
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `areas_monitoreo`
--

CREATE TABLE `areas_monitoreo` (
  `idAreaMonitoreo` int(11) NOT NULL,
  `nombre` varchar(200) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `monedas`
--

CREATE TABLE `monedas` (
  `idMoneda` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `simbolo` varchar(10) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos_a`
--

CREATE TABLE `permisos_a` (
  `idRol` int(11) NOT NULL,
  `idMenuA` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos_b`
--

CREATE TABLE `permisos_b` (
  `idRol` int(11) NOT NULL,
  `idMenuB` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles_permisos`
--

CREATE TABLE `roles_permisos` (
  `idRol` int(11) NOT NULL,
  `idRestaurant` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

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
  MODIFY `idComboCategoria` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `combos_platos`
--
ALTER TABLE `combos_platos`
  MODIFY `idComboPlato` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `monedas`
--
ALTER TABLE `monedas`
  MODIFY `idMoneda` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
