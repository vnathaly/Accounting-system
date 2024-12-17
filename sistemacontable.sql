-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 17, 2024 at 08:22 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sistemacontable`
--

-- --------------------------------------------------------

--
-- Table structure for table `cabecera_transaccion_contable`
--

CREATE TABLE `cabecera_transaccion_contable` (
  `nro_docu` varchar(20) NOT NULL,
  `tipo_entrada` int(11) NOT NULL,
  `fecha_docu` date NOT NULL,
  `tipo_docu` int(11) NOT NULL,
  `descripcion_docu` varchar(50) NOT NULL,
  `hecho_por` varchar(20) NOT NULL,
  `monto_transaccion` double DEFAULT 0,
  `fecha_actualizacion` date DEFAULT NULL,
  `status_actualizacion` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cabecera_transaccion_contable`
--

INSERT INTO `cabecera_transaccion_contable` (`nro_docu`, `tipo_entrada`, `fecha_docu`, `tipo_docu`, `descripcion_docu`, `hecho_por`, `monto_transaccion`, `fecha_actualizacion`, `status_actualizacion`) VALUES
('DOC001', 1, '2024-12-14', 1, 'Registro de Caja General', 'yovanny.q', 5000, '2024-12-14', 1),
('DOC002', 2, '2024-12-14', 1, 'Ajuste a Proveedores', 'admin2', 1500, '2024-12-14', 1),
('DOC003', 3, '2024-12-14', 2, 'Transferencia a Banco', 'usuario1', 2000, '2024-12-14', 1),
('DOC004', 4, '2024-12-14', 2, 'Pago a Proveedores Nacionales', 'yovanny.q', 3000, '2024-12-14', 1),
('DOC005', 5, '2024-12-14', 3, 'Cobro a Clientes', 'admin2', 4000, '2024-12-14', 1);

-- --------------------------------------------------------

--
-- Table structure for table `catalogo_cuenta_contable`
--

CREATE TABLE `catalogo_cuenta_contable` (
  `nro_cta` int(11) NOT NULL,
  `descripcion_cta` varchar(50) NOT NULL,
  `tipo_cta` tinyint(1) NOT NULL,
  `nivel_cta` int(11) NOT NULL,
  `cta_padre` int(11) DEFAULT NULL,
  `grupo_cta` int(11) DEFAULT NULL,
  `fecha_creacion_cta` date NOT NULL,
  `hora_creacion_cta` time NOT NULL,
  `debito_acum_cta` double DEFAULT 0,
  `credito_acum_cta` double DEFAULT 0,
  `balance_cta` double DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `catalogo_cuenta_contable`
--

INSERT INTO `catalogo_cuenta_contable` (`nro_cta`, `descripcion_cta`, `tipo_cta`, `nivel_cta`, `cta_padre`, `grupo_cta`, `fecha_creacion_cta`, `hora_creacion_cta`, `debito_acum_cta`, `credito_acum_cta`, `balance_cta`) VALUES
(1001, 'Caja General', 1, 1, NULL, 1, '2024-12-14', '09:00:00', 10000, 5000, 5000),
(1002, 'Bancos', 1, 1, NULL, 1, '2024-12-14', '09:30:00', 20000, 10000, 10000),
(2001, 'Proveedores Nacionales', 1, 1, NULL, 2, '2024-12-14', '10:00:00', 0, 15000, -15000),
(3001, 'Capital Social', 1, 1, NULL, 3, '2024-12-14', '11:00:00', 0, 50000, -50000),
(4001, 'Ingresos por Ventas', 1, 1, NULL, 4, '2024-12-14', '12:00:00', 0, 30000, -30000);

-- --------------------------------------------------------

--
-- Table structure for table `cuentas_origen_grupo`
--

CREATE TABLE `cuentas_origen_grupo` (
  `id` int(11) NOT NULL,
  `tipo_cuenta` varchar(20) NOT NULL,
  `naturaleza_cuenta` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cuentas_origen_grupo`
--

INSERT INTO `cuentas_origen_grupo` (`id`, `tipo_cuenta`, `naturaleza_cuenta`) VALUES
(1, 'Activo', 'Débito'),
(2, 'Pasivo', 'Crédito'),
(3, 'Capital', 'Crédito'),
(4, 'Ingresos', 'Crédito'),
(5, 'Costos', 'Débito'),
(6, 'Gastos', 'Débito');

-- --------------------------------------------------------

--
-- Table structure for table `tipos_entrada`
--

CREATE TABLE `tipos_entrada` (
  `idnum` int(11) NOT NULL,
  `descripcion` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tipos_entrada`
--

INSERT INTO `tipos_entrada` (`idnum`, `descripcion`) VALUES
(1, 'Entrada de Diario'),
(2, 'Ajuste Contable'),
(3, 'Transferencia Bancaria'),
(4, 'Pago a Proveedores'),
(5, 'Cobro de Clientes');

-- --------------------------------------------------------

--
-- Table structure for table `transaccion_contable`
--

CREATE TABLE `transaccion_contable` (
  `nro_doc` varchar(20) NOT NULL,
  `secuencia_doc` int(11) NOT NULL,
  `cuenta_contable` int(11) NOT NULL,
  `valor_debito` double NOT NULL DEFAULT 0,
  `valor_credito` double NOT NULL DEFAULT 0,
  `comentario` varchar(35) DEFAULT NULL,
  `fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaccion_contable`
--

INSERT INTO `transaccion_contable` (`nro_doc`, `secuencia_doc`, `cuenta_contable`, `valor_debito`, `valor_credito`, `comentario`, `fecha`) VALUES
('DOC001', 1, 1001, 5000, 0, 'Ingreso inicial en caja', NULL),
('DOC002', 1, 2001, 0, 1500, 'Ajuste de proveedor', NULL),
('DOC003', 1, 1002, 2000, 0, 'Transferencia bancaria', NULL),
('DOC004', 1, 2001, 0, 3000, 'Pago a proveedor nacional', NULL),
('DOC005', 1, 4001, 0, 4000, 'Cobro por venta realizada', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `ID` int(11) NOT NULL,
  `usuario` varchar(20) NOT NULL,
  `clave` varchar(255) NOT NULL,
  `nivel_acceso` int(11) NOT NULL,
  `nombre` varchar(15) NOT NULL,
  `apellidos_usuarios` varchar(20) NOT NULL,
  `email_usuario` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`ID`, `usuario`, `clave`, `nivel_acceso`, `nombre`, `apellidos_usuarios`, `email_usuario`) VALUES
(5, 'admin234', 'admin456', 1, '0', 'Gomez', 'maria@example.com'),
(6, 'luissss', 'user123', 0, '0', 'Perezzzz', 'luis.perez@example.c'),
(10, 'da', '$2y$10$BZd', 1, '0', 'DASDFA', 'nathalyvanodiaz2020f'),
(11, 'admin', '$2y$10$gVN', 1, '0', 'ADdfa', 'natianodiaz2020fb@gm'),
(12, 'adss', '$2y$10$/r8', 1, '0', 'safsdf', 'natanodiaz2020fb@gma'),
(13, 'sad', '$2y$10$Ya6', 1, '0', 'sdas', 'nathalyvictorianodia'),
(14, 'sssss', '$2y$10$4xq', 2, '0', 'Victoriano Díaz', 'nathalyvictorianodia'),
(15, 'hjhh', '$2y$10$t.E', 1, '0', 'Victoriano Díaz', 'nathalyvictorianodia'),
(16, 'test', '$2y$10$D0g', 1, '0', 'Victoriano Díaz', 'nathalyvictorianodia'),
(17, 'test2', '$2y$10$zrG', 1, '0', 'Victoriano Díaz', 'nathalyvictorianodia'),
(18, 'test3', '$2y$10$Dwz', 1, '0', 'Victoriano Díaz', 'nathalyvictorianodia'),
(19, '3', '$2y$10$Vfx', 1, '0', 'Victoriano Díaz', 'nathalyvictorianodia'),
(20, 'test1234', '$2y$10$0Nb', 2, '0', 'Victoriano Díaz', 'nathalyvictorianodia'),
(21, 'ahorasi', '$2y$10$4Hnmi6wDCI1D6.fmwQFhPOZEuq2Gap6DC1a21bxh.UnxvKJ4BvMl2', 1, '0', 'Victoriano Díaz', 'nathalyvictorianodia'),
(22, 'admin', '$2y$10$ktGzHu2zMV.RI8iDbqANfuYJg630Egbzn8VdQQHYBD8dH6aY4MVPi', 1, '0', 'Victoriano Díaz', 'nathalyvictorianodia'),
(23, 'user1', '$2y$10$o5EpBjM2GsTDqXfcggvbRuJGZSbivF4ucDzIFUN51g8nOdKkCAOIS', 1, '0', 'Victoriano Díaz', 'nathalyvictorianodia'),
(24, 'admin', '$2y$10$Ivea8aEtNmsUIanLjWvQf.Pf/hbrbetmPEGJ9nmfv1DG0xBjlX2sq', 1, '0', 'admin', 'nathalyvictorianodia'),
(25, 'haaa', '$2y$10$vo/xDi1JtVSqTgj.q7CtkepR2qritCBKjWQrA8u.GU15IOM6/fLyi', 1, '0', 'hiii', 'nathalyvictorianodia'),
(26, 'jjjjjj', '$2y$10$gEQpY6kA0d8NHTy1U1WxbuPCnH2MbL6RmwZ5dC0bzynW0rRdCLe0y', 1, 'fulanito', 'detal', 'nathalyvictorianodia');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cabecera_transaccion_contable`
--
ALTER TABLE `cabecera_transaccion_contable`
  ADD PRIMARY KEY (`nro_docu`),
  ADD KEY `tipo_entrada` (`tipo_entrada`);

--
-- Indexes for table `catalogo_cuenta_contable`
--
ALTER TABLE `catalogo_cuenta_contable`
  ADD PRIMARY KEY (`nro_cta`),
  ADD KEY `cta_padre` (`cta_padre`);

--
-- Indexes for table `cuentas_origen_grupo`
--
ALTER TABLE `cuentas_origen_grupo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tipos_entrada`
--
ALTER TABLE `tipos_entrada`
  ADD PRIMARY KEY (`idnum`);

--
-- Indexes for table `transaccion_contable`
--
ALTER TABLE `transaccion_contable`
  ADD PRIMARY KEY (`nro_doc`,`secuencia_doc`),
  ADD KEY `cuenta_contable` (`cuenta_contable`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cuentas_origen_grupo`
--
ALTER TABLE `cuentas_origen_grupo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tipos_entrada`
--
ALTER TABLE `tipos_entrada`
  MODIFY `idnum` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cabecera_transaccion_contable`
--
ALTER TABLE `cabecera_transaccion_contable`
  ADD CONSTRAINT `cabecera_transaccion_contable_ibfk_1` FOREIGN KEY (`tipo_entrada`) REFERENCES `tipos_entrada` (`idnum`);

--
-- Constraints for table `catalogo_cuenta_contable`
--
ALTER TABLE `catalogo_cuenta_contable`
  ADD CONSTRAINT `catalogo_cuenta_contable_ibfk_1` FOREIGN KEY (`cta_padre`) REFERENCES `catalogo_cuenta_contable` (`nro_cta`) ON DELETE SET NULL;

--
-- Constraints for table `transaccion_contable`
--
ALTER TABLE `transaccion_contable`
  ADD CONSTRAINT `transaccion_contable_ibfk_1` FOREIGN KEY (`nro_doc`) REFERENCES `cabecera_transaccion_contable` (`nro_docu`),
  ADD CONSTRAINT `transaccion_contable_ibfk_2` FOREIGN KEY (`cuenta_contable`) REFERENCES `catalogo_cuenta_contable` (`nro_cta`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
