-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-03-2023 a las 03:00:21
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sistema`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja`
--

CREATE TABLE `caja` (
  `id` int(11) NOT NULL,
  `caja` varchar(50) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `caja`
--

INSERT INTO `caja` (`id`, `caja`, `estado`) VALUES
(1, 'General', 1),
(2, 'Secundario', 1),
(3, 'Basica', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `estado`) VALUES
(1, 'Cuadernos', 1),
(2, 'Lapiceros', 1),
(3, 'Cartulinas', 1),
(4, 'Carpetas', 1),
(5, 'Tecnologia', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cierre_caja`
--

CREATE TABLE `cierre_caja` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_caja` int(11) NOT NULL,
  `monto_inicial` decimal(10,2) NOT NULL,
  `monto_final` decimal(10,2) NOT NULL DEFAULT 0.00,
  `fecha_apertura` date NOT NULL,
  `fecha_cierre` date NOT NULL DEFAULT '0000-00-00',
  `total_ventas` int(11) NOT NULL DEFAULT 0,
  `monto_total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `cierre_caja`
--

INSERT INTO `cierre_caja` (`id`, `id_usuario`, `id_caja`, `monto_inicial`, `monto_final`, `fecha_apertura`, `fecha_cierre`, `total_ventas`, `monto_total`, `estado`) VALUES
(1, 1, 1, '100.00', '2100.00', '2023-01-28', '2023-01-28', 1, '2200.00', 0),
(2, 1, 1, '100.00', '7949050.00', '2023-01-30', '2023-01-30', 3, '7949150.00', 0),
(3, 1, 1, '1000.00', '18189150.00', '2023-02-25', '2023-02-25', 17, '18190150.00', 0),
(4, 2, 1, '5000.00', '2713200.00', '2023-03-05', '2023-03-05', 1, '2718200.00', 0),
(5, 1, 1, '1000.00', '1050.00', '2023-03-05', '2023-03-05', 1, '2050.00', 0),
(6, 1, 2, '5000.00', '1050.00', '2023-03-05', '2023-03-05', 1, '6050.00', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `dni` varchar(10) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `direccion` text NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `dni`, `nombre`, `telefono`, `direccion`, `estado`) VALUES
(1, '9999999', 'GENERICO', '9999999', 'GENERICO', 1),
(2, '123456', 'Luz leiby Asprilla', '3157589657', 'Barrio Buenos Aires', 1),
(3, '12345', 'Johan Mena', '3124943527', 'Carrera 12 #46-136', 1),
(4, '875248', 'mateo', '3124943527', 'Barrio Buenos Aires', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` int(11) NOT NULL DEFAULT 1,
  `id_proveedor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`id`, `total`, `fecha`, `estado`, `id_proveedor`) VALUES
(1, '75000000.00', '2023-01-25 12:25:21', 0, 1),
(2, '60000.00', '2023-01-25 12:47:49', 0, 1),
(3, '30000.00', '2023-01-25 12:54:30', 1, 1),
(4, '60000.00', '2023-01-25 12:56:31', 0, 1),
(5, '60000.00', '2023-01-25 13:16:55', 0, 1),
(6, '60000.00', '2023-02-08 12:03:41', 1, 1),
(7, '15000.00', '2023-02-08 12:04:57', 1, 1),
(8, '30000000.00', '2023-02-25 23:06:02', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE `configuracion` (
  `id` int(11) NOT NULL,
  `nit` varchar(20) NOT NULL,
  `regimen` varchar(100) NOT NULL,
  `resolucion` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `direccion` varchar(200) NOT NULL,
  `ciudad` varchar(50) NOT NULL,
  `mensaje` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`id`, `nit`, `regimen`, `resolucion`, `nombre`, `telefono`, `direccion`, `ciudad`, `mensaje`) VALUES
(1, '80772379-1', 'Común', 0, 'Jojama', '3124943527', 'carrera 112 # 46 - 136', 'Quibdó - Chocó', 'Gracias por preferirnos, somo papelería y multiservicios en general. ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datella_compras`
--

CREATE TABLE `datella_compras` (
  `id` int(11) NOT NULL,
  `id_compra` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `sub_total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `datella_compras`
--

INSERT INTO `datella_compras` (`id`, `id_compra`, `id_producto`, `cantidad`, `precio`, `sub_total`) VALUES
(1, 1, 3, 50, '1500000.00', '75000000.00'),
(2, 2, 5, 20, '3000.00', '60000.00'),
(3, 3, 5, 10, '3000.00', '30000.00'),
(4, 4, 5, 20, '3000.00', '60000.00'),
(5, 5, 5, 20, '3000.00', '60000.00'),
(6, 6, 5, 20, '3000.00', '60000.00'),
(7, 7, 2, 10, '1500.00', '15000.00'),
(8, 8, 3, 20, '1500000.00', '30000000.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle`
--

CREATE TABLE `detalle` (
  `id` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `sub_total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `detalle`
--

INSERT INTO `detalle` (`id`, `id_producto`, `id_usuario`, `precio`, `cantidad`, `sub_total`) VALUES
(31, 3, 1, '1500000.00', 10, '15000000.00'),
(32, 4, 1, '750000.00', 1, '750000.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_permisos`
--

CREATE TABLE `detalle_permisos` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_permiso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `detalle_permisos`
--

INSERT INTO `detalle_permisos` (`id`, `id_usuario`, `id_permiso`) VALUES
(56, 1, 1),
(57, 1, 3),
(58, 1, 4),
(156, 2, 5),
(157, 2, 8),
(158, 2, 9),
(159, 2, 10),
(160, 2, 15);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_temp`
--

CREATE TABLE `detalle_temp` (
  `id` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `iva` int(11) NOT NULL,
  `descuento` decimal(10,2) NOT NULL DEFAULT 0.00,
  `sub_total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_ventas`
--

CREATE TABLE `detalle_ventas` (
  `id` int(11) NOT NULL,
  `id_venta` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `iva` int(11) NOT NULL,
  `descuento` decimal(10,2) NOT NULL DEFAULT 0.00,
  `precio` decimal(10,2) NOT NULL,
  `sub_total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `detalle_ventas`
--

INSERT INTO `detalle_ventas` (`id`, `id_venta`, `id_producto`, `cantidad`, `iva`, `descuento`, `precio`, `sub_total`) VALUES
(1, 1, 5, 3, 19, '100.00', '2500.00', '8925.00'),
(2, 1, 4, 3, 5, '100.00', '1000.00', '3150.00'),
(3, 2, 3, 2, 19, '20000.00', '1000000.00', '2380000.00'),
(4, 2, 5, 3, 19, '1000.00', '2500.00', '8925.00'),
(5, 2, 1, 4, 0, '0.00', '1000.00', '4000.00'),
(6, 2, 2, 2, 0, '0.00', '1000.00', '2000.00'),
(7, 3, 3, 2, 19, '15.00', '1000000.00', '2380000.00'),
(8, 3, 4, 5, 19, '15.00', '700000.00', '4165000.00'),
(9, 5, 3, 1, 19, '0.00', '1000000.00', '1190000.00'),
(10, 6, 3, 1, 19, '0.00', '1000000.00', '1190000.00'),
(11, 7, 3, 1, 19, '0.00', '1000000.00', '1190000.00'),
(12, 8, 3, 1, 19, '0.00', '1000000.00', '1190000.00'),
(13, 8, 4, 1, 19, '0.00', '700000.00', '833000.00'),
(14, 9, 4, 2, 19, '10.00', '700000.00', '1666000.00'),
(15, 9, 5, 2, 19, '0.00', '2500.00', '5950.00'),
(16, 10, 4, 2, 19, '0.00', '700000.00', '1666000.00'),
(17, 10, 5, 2, 19, '0.00', '2500.00', '5950.00'),
(18, 11, 4, 1, 19, '0.00', '700000.00', '833000.00'),
(19, 11, 5, 1, 19, '0.00', '2500.00', '2975.00'),
(20, 12, 4, 1, 19, '0.00', '700000.00', '833000.00'),
(21, 12, 5, 1, 19, '0.00', '2500.00', '2975.00'),
(22, 13, 4, 1, 19, '0.00', '700000.00', '833000.00'),
(23, 13, 5, 1, 19, '0.00', '2500.00', '2975.00'),
(24, 14, 4, 1, 19, '0.00', '700000.00', '833000.00'),
(25, 14, 5, 1, 19, '0.00', '2500.00', '2975.00'),
(26, 15, 4, 1, 19, '0.00', '700000.00', '833000.00'),
(27, 15, 5, 1, 19, '0.00', '2500.00', '2975.00'),
(28, 16, 4, 1, 19, '10.00', '700000.00', '833000.00'),
(29, 16, 5, 1, 19, '0.00', '2500.00', '2975.00'),
(30, 17, 4, 1, 19, '10.00', '700000.00', '833000.00'),
(31, 18, 4, 1, 19, '15.00', '700000.00', '833000.00'),
(32, 19, 4, 1, 19, '15.00', '700000.00', '833000.00'),
(33, 20, 3, 1, 19, '5.00', '1000000.00', '1190000.00'),
(34, 21, 3, 1, 19, '5.00', '1000000.00', '1190000.00'),
(35, 21, 4, 2, 19, '5.00', '700000.00', '1666000.00'),
(36, 22, 3, 1, 19, '0.00', '1000000.00', '1190000.00'),
(37, 22, 2, 10, 5, '0.00', '1000.00', '10500.00'),
(38, 23, 2, 2, 5, '0.00', '1000.00', '2100.00'),
(39, 24, 2, 1, 5, '0.00', '1000.00', '1050.00'),
(40, 25, 2, 1, 5, '0.00', '1000.00', '1050.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medidas`
--

CREATE TABLE `medidas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `nombre_corto` varchar(5) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `medidas`
--

INSERT INTO `medidas` (`id`, `nombre`, `nombre_corto`, `estado`) VALUES
(1, 'Gramos', 'g', 1),
(2, 'Kilogramos', 'kg', 1),
(3, 'Unidad', 'uds', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id` int(11) NOT NULL,
  `permiso` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id`, `permiso`) VALUES
(1, 'usuarios'),
(2, 'configuracion'),
(3, 'proveedor'),
(4, 'productos'),
(5, 'cajas'),
(6, 'categorias'),
(7, 'medidas'),
(8, 'clientes'),
(9, 'nueva_venta'),
(10, 'historial_venta'),
(11, 'nueva_compra'),
(12, 'historial_compra'),
(14, 'eliminar_clientes'),
(15, 'registrar_clientes'),
(16, 'reportes'),
(17, 'inventario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `codigo` varchar(20) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `precio_compra` decimal(10,2) NOT NULL,
  `precio_venta` decimal(10,2) NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 0,
  `iva` int(11) NOT NULL,
  `descuento` int(11) NOT NULL,
  `id_medida` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  `foto` varchar(50) NOT NULL,
  `vencimiento` varchar(10) NOT NULL,
  `fecha_vencimiento` date DEFAULT NULL,
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `codigo`, `descripcion`, `precio_compra`, `precio_venta`, `cantidad`, `iva`, `descuento`, `id_medida`, `id_categoria`, `id_proveedor`, `foto`, `vencimiento`, `fecha_vencimiento`, `estado`) VALUES
(1, '84566', 'lapiceros y colores', '1500.00', '1000.00', 14, 0, 10, 1, 2, 1, '20230303133643.jpg', 'No', '0000-00-00', 1),
(2, '45265', 'lapicero', '1500.00', '1000.00', 0, 5, 10, 3, 2, 1, '20230303133618.jpg', 'No', '0000-00-00', 1),
(3, '59652', 'Portatil', '1500000.00', '1000000.00', 15, 19, 20, 3, 5, 1, '20230303133552.jpg', 'No', '0000-00-00', 1),
(4, '562566', 'Tablet', '750000.00', '700000.00', 29, 19, 15, 3, 5, 1, '20230303133415.jpg', 'No', '0000-00-00', 1),
(5, '78545', 'Cuaderno rayado', '3000.00', '2500.00', 11, 19, 5, 3, 1, 1, '20230303134949.jpg', 'No', '0000-00-00', 1),
(7, '270001', 'Combo de cuaderno y colores', '15000.00', '10000.00', 15, 0, 0, 1, 1, 1, '20230303135441.jpg', 'No', '0000-00-00', 1),
(8, '2700025', 'prueba', '1500.00', '0.00', 0, 0, 0, 3, 2, 1, '20230303142736.jpg', 'No', '0000-00-00', 1),
(9, '5465', 'pruebas', '0.00', '1000.00', 0, 0, 0, 1, 1, 1, 'default.png', 'No', '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `id` int(11) NOT NULL,
  `nit` varchar(15) NOT NULL,
  `razon_social` varchar(100) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`id`, `nit`, `razon_social`, `nombre`, `telefono`, `direccion`, `estado`) VALUES
(1, '80772379', 'Jojama', 'Haminton Mena Mena', '3124943527', 'Carrera 12 #46-136 barrio Buenos Aires', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(20) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `clave` varchar(100) NOT NULL,
  `id_caja` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `nombre`, `clave`, `id_caja`, `estado`) VALUES
(1, 'admin', 'Jair Mena', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 1, 1),
(2, 'jair', 'Haminton Jair Mena', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` int(11) NOT NULL DEFAULT 1,
  `id_cliente` int(11) NOT NULL,
  `apertura` int(11) NOT NULL DEFAULT 1,
  `pagado` decimal(10,2) NOT NULL,
  `cambio` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `id_usuario`, `total`, `fecha`, `estado`, `id_cliente`, `apertura`, `pagado`, `cambio`) VALUES
(1, 1, '11875.00', '2023-01-30 12:49:30', 1, 3, 0, '0.00', '0.00'),
(2, 1, '2373925.00', '2023-01-31 12:59:55', 1, 3, 0, '0.00', '0.00'),
(3, 1, '5563250.00', '2023-02-22 13:47:55', 1, 2, 0, '0.00', '0.00'),
(4, 1, '1190000.00', '2023-02-25 21:32:31', 1, 1, 0, '0.00', '0.00'),
(5, 1, '1190000.00', '2023-02-25 21:36:19', 1, 1, 0, '0.00', '0.00'),
(6, 1, '1190000.00', '2023-02-25 22:57:21', 1, 2, 0, '0.00', '0.00'),
(7, 1, '1190000.00', '2023-02-25 23:09:45', 1, 2, 0, '0.00', '0.00'),
(8, 1, '2023000.00', '2023-02-27 12:37:28', 1, 1, 0, '2030000.00', '7000.00'),
(9, 1, '1505350.00', '2023-02-27 12:57:29', 1, 2, 0, '2.00', '1600000.00'),
(10, 1, '1671950.00', '2023-02-27 12:59:10', 1, 1, 0, '1700000.00', '28050.00'),
(11, 1, '835975.00', '2023-02-27 13:00:58', 1, 2, 0, '2.00', '836000.00'),
(12, 1, '835975.00', '2023-02-27 13:05:05', 1, 1, 0, '836000.00', '25.00'),
(13, 1, '835975.00', '2023-02-27 13:06:19', 1, 2, 0, '2.00', '836000.00'),
(14, 1, '835975.00', '2023-02-27 13:08:40', 1, 1, 0, '836000.00', '25.00'),
(15, 1, '835975.00', '2023-02-27 13:09:50', 1, 2, 0, '836000.00', '25.00'),
(16, 1, '752675.00', '2023-02-27 13:15:14', 1, 2, 0, '836000.00', '83325.00'),
(17, 1, '749700.00', '2023-02-27 13:19:18', 1, 2, 0, '750000.00', '300.00'),
(18, 1, '708050.00', '2023-02-27 13:38:51', 1, 1, 0, '710000.00', '1950.00'),
(19, 1, '708050.00', '2023-02-27 13:40:45', 1, 2, 0, '710000.00', '1950.00'),
(20, 1, '1130500.00', '2023-02-28 12:10:42', 1, 2, 0, '1150000.00', '19500.00'),
(21, 2, '2713200.00', '2023-03-05 02:31:44', 1, 2, 0, '2800000.00', '86800.00'),
(22, 1, '1200500.00', '2023-03-05 17:30:10', 1, 2, 0, '1250000.00', '49500.00'),
(23, 1, '2100.00', '2023-03-05 17:42:59', 1, 2, 0, '2500.00', '400.00'),
(24, 1, '1050.00', '2023-03-05 17:45:50', 1, 1, 0, '1500.00', '450.00'),
(25, 1, '1050.00', '2023-03-05 17:54:29', 1, 1, 0, '1100.00', '50.00');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `caja`
--
ALTER TABLE `caja`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cierre_caja`
--
ALTER TABLE `cierre_caja`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_proveedor` (`id_proveedor`);

--
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `datella_compras`
--
ALTER TABLE `datella_compras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_compra` (`id_compra`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `detalle`
--
ALTER TABLE `detalle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `detalle_permisos`
--
ALTER TABLE `detalle_permisos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle_temp`
--
ALTER TABLE `detalle_temp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_venta` (`id_venta`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
