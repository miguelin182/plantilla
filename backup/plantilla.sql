-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-10-2018 a las 17:16:33
-- Versión del servidor: 10.1.35-MariaDB
-- Versión de PHP: 7.1.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `plantilla`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacora`
--

CREATE TABLE `bitacora` (
  `id_bit` bigint(20) NOT NULL,
  `id_emp` bigint(20) NOT NULL,
  `id_cli` bigint(20) NOT NULL,
  `accion` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `bitacora`
--

INSERT INTO `bitacora` (`id_bit`, `id_emp`, `id_cli`, `accion`, `updated_at`, `created_at`) VALUES
(1, 1, 7, 1, '2018-10-02 00:00:00', '2018-10-02 00:00:00'),
(2, 1, 7, 2, '2018-10-02 00:00:00', '2018-10-02 00:00:00'),
(3, 1, 7, 2, '2018-10-05 09:12:32', '2018-10-05 09:12:32'),
(4, 1, 8, 1, '2018-10-05 09:27:15', '2018-10-05 09:27:15'),
(5, 1, 8, 2, '2018-10-05 09:29:43', '2018-10-05 09:29:43'),
(6, 1, 8, 2, '2018-10-05 10:06:16', '2018-10-05 10:06:16'),
(7, 1, 8, 2, '2018-10-05 10:06:57', '2018-10-05 10:06:57'),
(8, 1, 9, 1, '2018-10-05 12:14:26', '2018-10-05 12:14:26'),
(9, 1, 9, 2, '2018-10-05 12:15:00', '2018-10-05 12:15:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` bigint(20) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `rfc` varchar(50) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `celular` varchar(30) NOT NULL,
  `email` varchar(200) DEFAULT NULL,
  `persona` varchar(20) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `nombre`, `rfc`, `telefono`, `celular`, `email`, `persona`, `created_at`, `updated_at`) VALUES
(7, 'asdadwd', 'adawdawd', '123123', '123123', 'example@gmail.com', 'Moral', '2018-09-25 12:55:28', '2018-09-25 12:55:28'),
(8, 'Platanito S.A de C.V', 'sfrrgergerg', '123123', '1234567891', 'contacto@platanito.com.mx', 'Moral', '2018-10-05 09:27:15', '2018-10-05 09:27:15'),
(9, 'miguel f;dm\'zslc,d fascvfgfsa', 'wdgbrafswdcfvbghres', '123123', '166465235', 'contacto@platanito.com.mx', 'Física', '2018-10-05 12:14:26', '2018-10-05 12:14:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresas`
--

CREATE TABLE `empresas` (
  `id_empresa` bigint(20) NOT NULL,
  `razon_social` varchar(200) NOT NULL,
  `direccion` varchar(200) NOT NULL,
  `email_empresa` varchar(100) NOT NULL,
  `rfc` varchar(50) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `representante` varchar(200) NOT NULL,
  `email_representante` varchar(100) NOT NULL,
  `celular` varchar(20) NOT NULL,
  `giro` varchar(200) NOT NULL,
  `sector` varchar(200) NOT NULL,
  `id_usuario` bigint(20) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `empresas`
--

INSERT INTO `empresas` (`id_empresa`, `razon_social`, `direccion`, `email_empresa`, `rfc`, `telefono`, `representante`, `email_representante`, `celular`, `giro`, `sector`, `id_usuario`, `created_at`, `updated_at`) VALUES
(1, 'Platanitos S.A. de C.V.', 'pewfmpewf', 'okfpwef@gmail.com', 'wefwef', '213123', 'eweerwe', 'okfpwef@gmail.com', '123123', 'saesf', 'ewfwefwe', 1, '2018-09-20 00:00:00', '2018-09-20 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados`
--

CREATE TABLE `estados` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `municipios`
--

CREATE TABLE `municipios` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `estado_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `update_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos_negados`
--

CREATE TABLE `permisos_negados` (
  `id` int(10) UNSIGNED NOT NULL,
  `permiso_id` int(10) UNSIGNED NOT NULL,
  `rol_id` int(10) UNSIGNED NOT NULL,
  `crated_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `relsyscliemp`
--

CREATE TABLE `relsyscliemp` (
  `id_rel` bigint(20) NOT NULL,
  `id_cli` bigint(20) NOT NULL,
  `id_emp` bigint(20) NOT NULL,
  `monto` varchar(20) DEFAULT NULL,
  `activo` int(11) NOT NULL DEFAULT '1',
  `plazo` int(11) DEFAULT NULL,
  `estado1` varchar(50) DEFAULT NULL,
  `estado2` varchar(50) DEFAULT NULL,
  `estado3` varchar(50) DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `relsyscliemp`
--

INSERT INTO `relsyscliemp` (`id_rel`, `id_cli`, `id_emp`, `monto`, `activo`, `plazo`, `estado1`, `estado2`, `estado3`, `updated_at`, `created_at`) VALUES
(1, 7, 1, '', 1, 0, 'No pago', NULL, NULL, '2018-10-05 09:32:39', '2018-09-25 12:58:42'),
(2, 7, 1, '', 1, 0, NULL, NULL, NULL, '2018-09-25 15:41:02', '2018-09-25 15:41:02'),
(3, 7, 1, '', 1, 0, NULL, NULL, NULL, '2018-10-05 08:58:38', '2018-10-05 08:58:38'),
(6, 8, 1, '', 1, 0, NULL, NULL, NULL, '2018-10-05 09:29:42', '2018-10-05 09:29:42'),
(7, 8, 1, '', 1, 0, NULL, NULL, NULL, '2018-10-05 10:06:15', '2018-10-05 10:06:15'),
(8, 8, 1, '', 1, 0, NULL, NULL, NULL, '2018-10-05 10:06:56', '2018-10-05 10:06:56'),
(9, 9, 1, '', 1, 0, NULL, NULL, NULL, '2018-10-05 12:15:00', '2018-10-05 12:15:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 1, '2018-09-06 00:00:00', '2018-09-06 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL DEFAULT '7c4a8d09ca3762af61e59520943dc26494f8941b',
  `rol_id` int(10) UNSIGNED NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `id_emp` bigint(20) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `password`, `rol_id`, `status`, `id_emp`, `updated_at`, `created_at`) VALUES
(1, 'Miguel Angel Becerra Valerio', 'miguelvaleriobe@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 1, 1, 1, '2018-09-06 00:00:00', '2018-09-06 00:00:00');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  ADD PRIMARY KEY (`id_bit`),
  ADD KEY `id_emp` (`id_emp`),
  ADD KEY `id_cli` (`id_cli`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`),
  ADD UNIQUE KEY `rfc` (`rfc`);

--
-- Indices de la tabla `empresas`
--
ALTER TABLE `empresas`
  ADD PRIMARY KEY (`id_empresa`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `estados`
--
ALTER TABLE `estados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `municipios`
--
ALTER TABLE `municipios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `estado_municipio_idx` (`estado_id`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `permisos_negados`
--
ALTER TABLE `permisos_negados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permiso_negado_idx` (`permiso_id`),
  ADD KEY `rol_negado_idx` (`rol_id`);

--
-- Indices de la tabla `relsyscliemp`
--
ALTER TABLE `relsyscliemp`
  ADD PRIMARY KEY (`id_rel`),
  ADD KEY `id_cli` (`id_cli`),
  ADD KEY `id_emp` (`id_emp`) USING BTREE;

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `roles_usuario_idx` (`rol_id`),
  ADD KEY `id_emp` (`id_emp`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  MODIFY `id_bit` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `empresas`
--
ALTER TABLE `empresas`
  MODIFY `id_empresa` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `municipios`
--
ALTER TABLE `municipios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permisos_negados`
--
ALTER TABLE `permisos_negados`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `relsyscliemp`
--
ALTER TABLE `relsyscliemp`
  MODIFY `id_rel` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `municipios`
--
ALTER TABLE `municipios`
  ADD CONSTRAINT `estado_municipio` FOREIGN KEY (`estado_id`) REFERENCES `estados` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `permisos_negados`
--
ALTER TABLE `permisos_negados`
  ADD CONSTRAINT `permiso_negado` FOREIGN KEY (`permiso_id`) REFERENCES `permisos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `rol_negado` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `relsyscliemp`
--
ALTER TABLE `relsyscliemp`
  ADD CONSTRAINT `relsyscliemp_ibfk_1` FOREIGN KEY (`id_emp`) REFERENCES `empresas` (`id_empresa`),
  ADD CONSTRAINT `relsyscliemp_ibfk_2` FOREIGN KEY (`id_cli`) REFERENCES `clientes` (`id_cliente`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `roles_usuario` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
