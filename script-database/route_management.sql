-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-08-2025 a las 02:05:01
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
-- Base de datos: `route_management`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `choferes`
--

CREATE TABLE `choferes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `telefono` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `choferes`
--

INSERT INTO `choferes` (`id`, `nombre`, `telefono`) VALUES
(18, 'Alejandro Mis', '9971652000'),
(20, 'Alan Montes', '99712345');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puntos_entrega`
--

CREATE TABLE `puntos_entrega` (
  `id` int(11) NOT NULL,
  `id_ruta` int(11) NOT NULL,
  `dirrecion` varchar(50) NOT NULL,
  `orden` int(11) NOT NULL,
  `entregado` enum('pendiente','listo') DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `puntos_entrega`
--

INSERT INTO `puntos_entrega` (`id`, `id_ruta`, `dirrecion`, `orden`, `entregado`) VALUES
(5, 32, '5', 0, 'pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rutas`
--

CREATE TABLE `rutas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_chofer` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rutas`
--

INSERT INTO `rutas` (`id`, `nombre`, `fecha`, `id_chofer`) VALUES
(31, 'R-28 Ruta 2 Kanasín - Naranjos', '2025-08-19 05:50:05', 20),
(32, 'R-55 Mérida - Cholul', '2025-08-19 05:50:49', 18);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `choferes`
--
ALTER TABLE `choferes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `puntos_entrega`
--
ALTER TABLE `puntos_entrega`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_ruta` (`id_ruta`);

--
-- Indices de la tabla `rutas`
--
ALTER TABLE `rutas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rutas_ibfk_1` (`id_chofer`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `choferes`
--
ALTER TABLE `choferes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `puntos_entrega`
--
ALTER TABLE `puntos_entrega`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `rutas`
--
ALTER TABLE `rutas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `puntos_entrega`
--
ALTER TABLE `puntos_entrega`
  ADD CONSTRAINT `puntos_entrega_ibfk_1` FOREIGN KEY (`id_ruta`) REFERENCES `rutas` (`id`);

--
-- Filtros para la tabla `rutas`
--
ALTER TABLE `rutas`
  ADD CONSTRAINT `rutas_ibfk_1` FOREIGN KEY (`id_chofer`) REFERENCES `choferes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
