SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `detalles_reserva` (
  `id_detalle_reserva` int(11) NOT NULL,
  `id_reserva` int(11) NOT NULL,
  `id_servicio` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `detalles_reserva` (`id_detalle_reserva`, `id_reserva`, `id_servicio`, `cantidad`, `estado`) VALUES
(1, 1, 2, NULL, 1),
(2, 2, 2, NULL, 1),
(3, 3, 3, NULL, 1),
(4, 4, 3, NULL, 1),
(5, 5, 6, NULL, 1);

CREATE TABLE `reservas` (
  `id_reserva` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_administrador` int(11) DEFAULT NULL,
  `fecha_reserva` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date DEFAULT NULL,
  `estado` enum('pendiente','ejecutada','cancelada') DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `reservas` (`id_reserva`, `id_usuario`, `id_administrador`, `fecha_reserva`, `fecha_inicio`, `fecha_fin`, `estado`) VALUES
(1, 6, 0, '2024-09-21 17:27:18', '2024-09-26', NULL, 'ejecutada'),
(2, 2, 5, '2024-09-21 17:29:31', '2024-10-11', NULL, 'pendiente'),
(3, 6, 0, '2024-09-21 22:02:22', '2024-09-30', NULL, 'cancelada'),
(4, 6, 0, '2024-09-22 15:18:52', '2024-09-22', NULL, 'pendiente'),
(5, 6, 0, '2024-09-22 17:25:31', '2024-09-23', NULL, 'pendiente');

CREATE TABLE `servicios` (
  `id_servicio` int(11) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `servicios` (`id_servicio`, `descripcion`, `precio`) VALUES
(1, 'Mesa 1', NULL),
(2, 'Mesa 2', NULL),
(3, 'Mesa 3', NULL),
(4, 'Mesa 4', NULL),
(5, 'Mesa 5', NULL),
(6, 'Mesa 6', NULL),
(7, 'Mesa Familiar #1', NULL);

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `tipo` char(20) NOT NULL,
  `nombre` varchar(250) NOT NULL,
  `contrasena` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `usuarios` (`id_usuario`, `correo`, `tipo`, `nombre`, `contrasena`) VALUES
(1, 'lucas@gmail.com', 'cliente', 'Lucas Fernandez', '$2y$10$zJ8T1M6LZzUJ1phkj7bm4eGgBL4vR7Z.8m8C8s2yLZp58VdDrDHeO'),
(2, 'carla@gmail.com', 'cliente', 'Carla Lopez', '$2y$10$R89mB3U0M8S4Tr5eF1s1P.7N5/3DqD8r8gr2G7zA3cU0cYgWczF2e'),
(3, 'jorge@gmail.com', 'administrador', 'Jorge Salinas', '$2y$10$qB5DfOHuC2nVLo4edPzH9eX/RLkZ8KpFxI7bKJ28nC8Q/z97JSO1i'),
(4, 'sandra@gmail.com', 'cliente', 'Sandra Gonzalez', '$2y$10$W6xR9IuA2F7mJxy/c5gjR.1zBBdVFlNVBp/mX8c7sB3kFj3.vU0/.'),
(5, 'david@gmail.com', 'administrador', 'David Perez', '$2y$10$Y5S1XkVEdV/YU1J5H4j4ve6frCZOBKk7Yt5hnX/7Clx6FsByzWFS6'),
(6, 'marta@gmail.com', 'cliente', 'Marta Ramirez', '$2y$10$Z8Q9uHZy/G1HlF49Wz.7AeHn1Rm9G2kUrLs/lS8ZwD0H8Ovkv6d02');

ALTER TABLE `detalles_reserva`
  ADD PRIMARY KEY (`id_detalle_reserva`),
  ADD KEY `id_reserva` (`id_reserva`),
  ADD KEY `id_servicio` (`id_servicio`);

ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id_reserva`),
  ADD KEY `id_usuario` (`id_usuario`);

ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id_servicio`);

ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `correo` (`correo`);

ALTER TABLE `detalles_reserva`
  MODIFY `id_detalle_reserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

ALTER TABLE `reservas`
  MODIFY `id_reserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

ALTER TABLE `servicios`
  MODIFY `id_servicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `detalles_reserva`
  ADD CONSTRAINT `detalles_reserva_ibfk_1` FOREIGN KEY (`id_reserva`) REFERENCES `reservas` (`id_reserva`),
  ADD CONSTRAINT `detalles_reserva_ibfk_2` FOREIGN KEY (`id_servicio`) REFERENCES `servicios` (`id_servicio`);

ALTER TABLE `reservas`
  ADD CONSTRAINT `fk_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE;
COMMIT;