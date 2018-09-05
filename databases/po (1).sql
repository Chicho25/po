-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-09-2018 a las 08:53:59
-- Versión del servidor: 10.1.28-MariaDB
-- Versión de PHP: 5.6.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `po`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acount_bank`
--

CREATE TABLE `acount_bank` (
  `id` int(11) NOT NULL,
  `id_bank` int(11) NOT NULL,
  `number_acount` varchar(30) NOT NULL,
  `descriptions` varchar(250) NOT NULL,
  `stat` int(11) NOT NULL,
  `id_user_reg` int(11) NOT NULL,
  `data_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `acount_bank`
--

INSERT INTO `acount_bank` (`id`, `id_bank`, `number_acount`, `descriptions`, `stat`, `id_user_reg`, `data_time`) VALUES
(2, 7, '15151515', 'Prueba de banco / cuenta', 1, 1, '2018-09-03 01:11:10'),
(3, 7, '9999999', 'otra cuenta', 1, 1, '2018-09-03 19:48:37'),
(4, 6, '2236548', 'Ã±kjioutuyf', 1, 1, '2018-09-04 20:10:34');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bank`
--

CREATE TABLE `bank` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `stat` int(11) NOT NULL,
  `id_user_reg` int(11) NOT NULL,
  `data_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `bank`
--

INSERT INTO `bank` (`id`, `name`, `stat`, `id_user_reg`, `data_time`) VALUES
(6, 'Provincial BBVA', 1, 1, '2018-09-03 00:32:37'),
(7, 'BOD', 1, 1, '2018-09-03 00:33:01'),
(8, 'Banesco', 1, 1, '2018-09-03 00:33:40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `country`
--

CREATE TABLE `country` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `stat` int(11) NOT NULL,
  `id_user_reg` int(11) NOT NULL,
  `data_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `country`
--

INSERT INTO `country` (`id`, `name`, `stat`, `id_user_reg`, `data_time`) VALUES
(1, 'Panama', 1, 0, '0000-00-00 00:00:00'),
(2, 'Uruguay', 1, 0, '0000-00-00 00:00:00'),
(3, 'Espania', 1, 1, '2018-09-02 07:21:01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `id_reside_country` int(11) NOT NULL,
  `image` varchar(250) NOT NULL,
  `stat` int(11) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_user_create` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `customer`
--

INSERT INTO `customer` (`id`, `name`, `last_name`, `email`, `phone`, `id_reside_country`, `image`, `stat`, `create_date`, `id_user_create`) VALUES
(2, 'PEDRO DAVID', 'ARRIETA PEREZ', 'pedroarrieta25@hotmail.com', '32165', 1, 'image_users/2_thumb.png', 1, '2017-10-20 21:54:46', 1),
(3, 'Cecilia', 'Arandias', 'costos@costos.com', '462154', 2, 'image_users/3_thumb.jpeg', 1, '2017-10-21 13:09:11', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `main_pay`
--

CREATE TABLE `main_pay` (
  `id` int(11) NOT NULL,
  `id_transaction` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `date_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `amount_paid` decimal(11,0) NOT NULL,
  `messaje` text NOT NULL,
  `stat` int(11) NOT NULL,
  `attached` varchar(225) NOT NULL,
  `id_bank` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `main_pay`
--

INSERT INTO `main_pay` (`id`, `id_transaction`, `id_user`, `date_time`, `amount_paid`, `messaje`, `stat`, `attached`, `id_bank`) VALUES
(2, 4, 1, '2017-10-22 18:32:43', '15000000', 'pago completo', 1, 'attached_invoice/2_thumb.jpg', 1),
(8, 2, 1, '2017-10-23 00:56:44', '2345', 'qwerfds', 1, '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `master_stat`
--

CREATE TABLE `master_stat` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `stat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `master_stat`
--

INSERT INTO `master_stat` (`id`, `name`, `stat`) VALUES
(1, 'Pendiente por Pago', 1),
(2, 'Abonada', 1),
(3, 'Pagada', 1),
(4, 'Anulada', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mov_bank`
--

CREATE TABLE `mov_bank` (
  `id` int(11) NOT NULL,
  `id_bank` int(11) NOT NULL,
  `id_acount` int(11) NOT NULL,
  `type_mov` int(11) NOT NULL,
  `amount` decimal(11,2) NOT NULL,
  `descriptions` varchar(250) NOT NULL,
  `image` varchar(50) NOT NULL,
  `stat` int(11) NOT NULL,
  `id_user_reg` int(11) NOT NULL,
  `data_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `mov_bank`
--

INSERT INTO `mov_bank` (`id`, `id_bank`, `id_acount`, `type_mov`, `amount`, `descriptions`, `image`, `stat`, `id_user_reg`, `data_time`) VALUES
(1, 7, 3, 2, '1000000.00', 'prueba', '', 1, 1, '2018-09-03 20:52:13'),
(2, 6, 4, 2, '500000.00', 'kujghg', 'mov_image/2_thumb.jpg', 1, 1, '2018-09-04 20:11:42');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transaction`
--

CREATE TABLE `transaction` (
  `id` int(11) NOT NULL,
  `id_type_transaction` int(11) NOT NULL,
  `id_customer` int(11) NOT NULL,
  `id_user_register` int(11) NOT NULL,
  `date_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `amount` decimal(11,2) NOT NULL,
  `id_type_coin` int(11) NOT NULL,
  `price_dollar` decimal(11,2) NOT NULL,
  `messaje` text NOT NULL,
  `stat` int(11) NOT NULL,
  `amount_transfer` decimal(11,2) NOT NULL,
  `remaining` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `transaction`
--

INSERT INTO `transaction` (`id`, `id_type_transaction`, `id_customer`, `id_user_register`, `date_time`, `amount`, `id_type_coin`, `price_dollar`, `messaje`, `stat`, `amount_transfer`, `remaining`) VALUES
(2, 1, 2, 1, '2017-10-21 19:03:29', '250.00', 1, '30000.00', 'algo', 2, '800000.00', '649655.00'),
(3, 1, 2, 1, '2017-10-22 08:59:40', '250.00', 1, '30000.00', 'asddcdc', 4, '7500000.00', '7500000.00'),
(4, 1, 3, 1, '2017-10-22 09:01:09', '500.00', 1, '30000.00', 'xqwqdw', 3, '15000000.00', '0.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `type_coin`
--

CREATE TABLE `type_coin` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `stat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `type_coin`
--

INSERT INTO `type_coin` (`id`, `name`, `stat`) VALUES
(1, 'Dolares(Panama)', 1),
(2, 'Pesos Argentinos', 1),
(3, 'Pesos Colombianos', 1),
(4, 'Soles', 1),
(5, 'Pesos Uruguayos', 1),
(6, 'Euros(Espania)', 1),
(7, 'Dolares(Ecuador)', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `type_mov`
--

CREATE TABLE `type_mov` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `stat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `type_mov`
--

INSERT INTO `type_mov` (`id`, `name`, `stat`) VALUES
(1, 'Transferencia(Debito)', 1),
(2, 'Transferencia(Credito)', 1),
(3, 'Deposito(Debito)', 1),
(4, 'Deposito(Credito)', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `type_transaction`
--

CREATE TABLE `type_transaction` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `stat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `type_transaction`
--

INSERT INTO `type_transaction` (`id`, `name`, `stat`) VALUES
(1, 'Compra Bs.', 1),
(2, 'Compra $', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `type_user`
--

CREATE TABLE `type_user` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `stat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `type_user`
--

INSERT INTO `type_user` (`id`, `name`, `stat`) VALUES
(1, 'Administrador', 1),
(2, 'Contabilidad', 1),
(3, 'Ventas', 1),
(4, 'Pagos', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `id_roll_user` int(11) NOT NULL,
  `password` varchar(50) NOT NULL,
  `image` varchar(250) NOT NULL,
  `stat` int(11) NOT NULL,
  `location` int(11) NOT NULL,
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `email` varchar(100) NOT NULL,
  `id_user_reg` int(11) NOT NULL,
  `percentage` decimal(3,2) NOT NULL,
  `referred` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `user`, `name`, `last_name`, `id_roll_user`, `password`, `image`, `stat`, `location`, `create_date`, `email`, `id_user_reg`, `percentage`, `referred`) VALUES
(1, 'chicho', 'Blaster', 'Slovar', 1, '321', 'image_users/1.jpg', 1, 1, '2017-10-19 11:48:15', '', 0, '0.00', 0),
(2, 'orga', 'duval', 'games', 1, 'cygGLqlfhk6J7w7XuMGWgpQOJWizlAUFi2Yt5/Q68xM=', 'image_users/2_thumb.jpg', 1, 2, '2017-10-19 12:14:46', 'orga@bolivartoday.com', 0, '0.00', 0),
(3, 'prueba', 'prueba', 'prueba', 3, 'DbOF93Ai+fSAWROreNSOTlIcJ+tTlyY6tpOpJKZsZtQ=', 'image_users/3_thumb.jpg', 1, 3, '2018-09-02 00:29:30', 'prueba@gmail.com', 1, '2.00', 0),
(4, 'prueba2', 'prueba2', 'prueba2', 3, 'cygGLqlfhk6J7w7XuMGWgpQOJWizlAUFi2Yt5/Q68xM=', 'image_users/4_thumb.jpg', 1, 1, '2018-09-02 00:54:41', 'hh@hh.com', 1, '0.20', 3),
(5, 'qweq', 'weqweq', 'weqw', 0, 'cygGLqlfhk6J7w7XuMGWgpQOJWizlAUFi2Yt5/Q68xM=', 'image_users/5_thumb.jpg', 1, 2, '2018-09-02 01:00:12', 'eqweq@ada.com', 1, '0.20', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `value_coin`
--

CREATE TABLE `value_coin` (
  `id` int(11) NOT NULL,
  `id_type_coin` int(11) NOT NULL,
  `value_bolivar` decimal(11,2) NOT NULL,
  `id_user_reg` int(11) NOT NULL,
  `stat` int(11) NOT NULL,
  `date_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `value_coin`
--

INSERT INTO `value_coin` (`id`, `id_type_coin`, `value_bolivar`, `id_user_reg`, `stat`, `date_time`) VALUES
(1, 1, '10500.00', 1, 1, '2018-09-04 00:00:00'),
(2, 2, '230.00', 1, 1, '2018-09-04 00:00:00'),
(3, 3, '33.33', 1, 1, '2018-09-04 00:00:00'),
(4, 4, '2900.00', 1, 1, '2018-09-04 00:00:00'),
(5, 5, '288.00', 1, 1, '2018-09-04 00:00:00'),
(6, 6, '11000.00', 1, 1, '2018-09-04 00:00:00'),
(7, 7, '9000.00', 1, 1, '2018-09-04 00:00:00'),
(8, 1, '1000.00', 1, 1, '2018-09-05 00:00:00');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `acount_bank`
--
ALTER TABLE `acount_bank`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `bank`
--
ALTER TABLE `bank`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `main_pay`
--
ALTER TABLE `main_pay`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `master_stat`
--
ALTER TABLE `master_stat`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mov_bank`
--
ALTER TABLE `mov_bank`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `type_coin`
--
ALTER TABLE `type_coin`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `type_mov`
--
ALTER TABLE `type_mov`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `type_transaction`
--
ALTER TABLE `type_transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `type_user`
--
ALTER TABLE `type_user`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `value_coin`
--
ALTER TABLE `value_coin`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `acount_bank`
--
ALTER TABLE `acount_bank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `bank`
--
ALTER TABLE `bank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `country`
--
ALTER TABLE `country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `main_pay`
--
ALTER TABLE `main_pay`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `master_stat`
--
ALTER TABLE `master_stat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `mov_bank`
--
ALTER TABLE `mov_bank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `type_coin`
--
ALTER TABLE `type_coin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `type_mov`
--
ALTER TABLE `type_mov`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `type_transaction`
--
ALTER TABLE `type_transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `type_user`
--
ALTER TABLE `type_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `value_coin`
--
ALTER TABLE `value_coin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
