-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-09-2018 a las 09:28:24
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
(4, 6, '2236548', 'Ã±kjioutuyf', 1, 1, '2018-09-04 20:10:34'),
(5, 9, '15151241', 'unjcmvkdfn', 1, 1, '2018-09-08 15:19:42'),
(6, 8, '123261', 'ahorro\r\nEsta cuent es pretada por noce quien ', 1, 1, '2018-09-08 15:20:07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acount_customer`
--

CREATE TABLE `acount_customer` (
  `id` int(11) NOT NULL,
  `id_customer` int(11) NOT NULL,
  `id_bank_customer` int(11) NOT NULL,
  `number_acount` varchar(50) NOT NULL,
  `descriptions` varchar(250) NOT NULL,
  `type_acount` int(1) NOT NULL,
  `id_user_reg` int(11) NOT NULL,
  `data_time` datetime NOT NULL,
  `stat` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `acount_customer`
--

INSERT INTO `acount_customer` (`id`, `id_customer`, `id_bank_customer`, `number_acount`, `descriptions`, `type_acount`, `id_user_reg`, `data_time`, `stat`) VALUES
(1, 4, 2, '2147483647', 'ijgiejrigjier', 1, 1, '0000-00-00 00:00:00', 1),
(2, 4, 1, '414124', 'dsfgdfhbdfb', 1, 1, '2018-09-07 00:21:03', 1),
(3, 4, 2, '414124', 'qweqw', 2, 1, '2018-09-07 00:25:05', 2),
(4, 5, 5, '123123', 'diyv8sdvj', 1, 1, '2018-09-08 15:31:49', 1),
(5, 5, 2, '414124', '23r23r23r3', 1, 1, '2018-09-08 15:32:54', 1);

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
(8, 'Banesco', 1, 1, '2018-09-03 00:33:40'),
(9, 'Banco Orga', 1, 1, '2018-09-08 15:19:22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bank_customer`
--

CREATE TABLE `bank_customer` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `stat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `bank_customer`
--

INSERT INTO `bank_customer` (`id`, `name`, `stat`) VALUES
(1, 'Banesco', 1),
(2, 'Provincial', 1),
(3, 'BOD', 1),
(4, 'Mercantil', 1),
(5, 'Banco Venezuela', 1);

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
(3, 'Espania', 1, 1, '2018-09-02 07:21:01'),
(4, 'Ecuador', 1, 1, '2018-09-08 15:18:27');

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
(3, 'Cecilia', 'Arandias', 'costos@costos.com', '462154', 2, 'image_users/3_thumb.jpeg', 1, '2017-10-21 13:09:11', 1),
(4, 'Prueba', 'prueba', 'prueba@prueba.com', '123123', 1, 'image_users/4_thumb.jpg', 1, '2018-09-07 04:15:43', 1),
(5, 'cliente pruebna', 'cliente', 'operador@shl.com', '4261648436', 2, 'image_users/5_thumb.jpg', 1, '2018-09-08 20:31:49', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `main_pay`
--

CREATE TABLE `main_pay` (
  `id` int(11) NOT NULL,
  `id_transaction` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `date_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `amount_paid` decimal(11,2) NOT NULL,
  `messaje` text NOT NULL,
  `stat` int(11) NOT NULL,
  `attached` varchar(225) NOT NULL,
  `id_bank` int(11) NOT NULL,
  `id_user_reg` int(4) NOT NULL,
  `id_count_bank` int(4) NOT NULL,
  `time_data` datetime NOT NULL,
  `id_customer` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `main_pay`
--

INSERT INTO `main_pay` (`id`, `id_transaction`, `id_user`, `date_time`, `amount_paid`, `messaje`, `stat`, `attached`, `id_bank`, `id_user_reg`, `id_count_bank`, `time_data`, `id_customer`) VALUES
(2, 4, 1, '2017-10-22 18:32:43', '15000000.00', 'pago completo', 1, 'attached_invoice/2_thumb.jpg', 1, 0, 0, '0000-00-00 00:00:00', 0),
(8, 2, 1, '2017-10-23 00:56:44', '2345.00', 'qwerfds', 1, '', 1, 0, 0, '0000-00-00 00:00:00', 0),
(9, 7, 1, '2018-09-09 20:50:48', '50000.00', '908yu89y8', 1, 'po_bauches/9_thumb.jpg', 2, 1, 5, '0000-00-00 00:00:00', 0),
(10, 7, 1, '2018-09-09 20:53:33', '61000.00', 'iugyuggu', 1, 'po_bauches/10_thumb.jpg', 2, 1, 5, '0000-00-00 00:00:00', 0),
(11, 7, 1, '2018-09-09 20:57:17', '100.00', 'ihiuyfou', 1, 'po_bauches/11_thumb.jpg', 0, 1, 0, '0000-00-00 00:00:00', 0),
(12, 8, 1, '2018-09-09 21:05:55', '100000.00', 'kjkjgg', 1, 'po_bauches/12_thumb.jpg', 0, 1, 0, '0000-00-00 00:00:00', 0),
(13, 8, 1, '2018-09-09 21:22:31', '60000.00', 'bdfbdfb', 1, 'po_bauches/13_thumb.jpg', 5, 1, 4, '0000-00-00 00:00:00', 0),
(14, 8, 1, '2018-09-09 21:23:10', '6650.00', 'uhuhuhu', 1, '', 5, 1, 4, '0000-00-00 00:00:00', 0),
(15, 9, 1, '2018-09-09 21:28:20', '250000.00', 'ihiuyuy', 1, 'po_bauches/15_thumb.jpg', 2, 1, 5, '0000-00-00 00:00:00', 0),
(16, 9, 1, '2018-09-09 21:29:12', '330000.00', 'uygfyufyuf', 1, 'po_bauches/16_thumb.jpg', 2, 1, 5, '0000-00-00 00:00:00', 0),
(17, 10, 1, '2018-09-09 22:08:46', '100000.00', 'gygygyg', 1, 'po_bauches/17_thumb.gif', 5, 1, 4, '2018-09-09 22:08:46', 5),
(18, 10, 1, '2018-09-09 22:10:10', '65000.00', 'mlmlmlvm', 1, 'po_bauches/18_thumb.jpg', 5, 1, 4, '2018-09-09 22:10:10', 5),
(19, 11, 1, '2018-09-10 00:39:59', '200000.00', 'iuhuyfd', 1, 'po_bauches/19_thumb.jpg', 2, 1, 1, '2018-09-10 00:39:59', 4),
(20, 11, 1, '2018-09-10 00:53:00', '200000.00', 'ijgfuun', 1, 'po_bauches/20_thumb.jpg', 2, 1, 1, '2018-09-10 00:53:00', 4),
(21, 11, 1, '2018-09-10 01:09:04', '20000.00', 'iuhygih', 1, 'po_bauches/21_thumb.jpg', 2, 1, 1, '2018-09-10 01:09:04', 4);

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
  `id_bank` int(3) NOT NULL,
  `id_acount` int(4) NOT NULL,
  `type_mov` int(2) NOT NULL,
  `amount` decimal(11,2) NOT NULL,
  `descriptions` varchar(250) NOT NULL,
  `image` varchar(50) NOT NULL,
  `stat` int(2) NOT NULL,
  `id_user_reg` int(4) NOT NULL,
  `data_time` datetime NOT NULL,
  `amount_sales` decimal(11,2) NOT NULL,
  `price_for_dollar` decimal(11,2) NOT NULL,
  `price_sales` decimal(11,2) NOT NULL,
  `id_transaction` int(6) NOT NULL,
  `id_transaction_child` int(8) NOT NULL,
  `id_user` int(4) NOT NULL,
  `id_customer` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `mov_bank`
--

INSERT INTO `mov_bank` (`id`, `id_bank`, `id_acount`, `type_mov`, `amount`, `descriptions`, `image`, `stat`, `id_user_reg`, `data_time`, `amount_sales`, `price_for_dollar`, `price_sales`, `id_transaction`, `id_transaction_child`, `id_user`, `id_customer`) VALUES
(1, 7, 3, 2, '1000000.00', 'prueba', '', 1, 1, '2018-09-03 20:52:13', '0.00', '0.00', '0.00', 0, 0, 0, 0),
(2, 6, 4, 2, '500000.00', 'kujghg', 'mov_image/2_thumb.jpg', 1, 1, '2018-09-04 20:11:42', '0.00', '0.00', '0.00', 0, 0, 0, 0),
(3, 9, 5, 2, '1000000.00', 'eshjbcsmc sknsc\r\nlsmcksmcklsm\r\nnjsncjsnjns\r\nlmscsmc', 'mov_image/3_thumb.jpg', 1, 1, '2018-09-08 15:22:46', '0.00', '0.00', '0.00', 0, 0, 0, 0),
(4, 8, 6, 2, '110000.00', 'qqqqqqqq', 'mov_image/4_thumb.jpg', 1, 1, '2018-09-09 16:00:59', '1000.00', '110.00', '90.00', 0, 0, 0, 0),
(5, 9, 5, 4, '100000.00', 'uygyiun', 'mov_image/5_thumb.jpg', 1, 1, '2018-09-09 23:10:48', '1000.00', '100.00', '80.00', 0, 0, 0, 0),
(6, 9, 5, 1, '200000.00', 'ijgfuun', 'po_bauches/20_thumb.jpg', 1, 1, '2018-09-10 00:53:00', '0.00', '0.00', '0.00', 11, 20, 1, 4),
(7, 6, 4, 1, '20000.00', 'iuhygih', 'po_bauches/21_thumb.jpg', 1, 1, '2018-09-10 01:09:04', '0.00', '110.00', '90.00', 11, 21, 1, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transaction`
--

CREATE TABLE `transaction` (
  `id` int(11) NOT NULL,
  `id_type_transaction` int(11) NOT NULL,
  `id_customer` int(11) NOT NULL,
  `id_acount_bank` int(11) NOT NULL,
  `id_user_register` int(11) NOT NULL,
  `date_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `amount` decimal(11,2) NOT NULL,
  `id_type_coin` int(11) NOT NULL,
  `taza_actual` decimal(11,2) NOT NULL,
  `messaje` text NOT NULL,
  `stat` int(11) NOT NULL,
  `amount_transfer` decimal(11,2) NOT NULL,
  `paidout` decimal(11,2) NOT NULL,
  `time_data` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `transaction`
--

INSERT INTO `transaction` (`id`, `id_type_transaction`, `id_customer`, `id_acount_bank`, `id_user_register`, `date_time`, `amount`, `id_type_coin`, `taza_actual`, `messaje`, `stat`, `amount_transfer`, `paidout`, `time_data`) VALUES
(2, 1, 2, 0, 1, '2017-10-21 19:03:29', '250.00', 1, '30000.00', 'algo', 2, '800000.00', '0.00', '0000-00-00 00:00:00'),
(3, 1, 2, 0, 1, '2017-10-22 08:59:40', '250.00', 1, '30000.00', 'asddcdc', 4, '7500000.00', '0.00', '0000-00-00 00:00:00'),
(4, 1, 3, 0, 1, '2017-10-22 09:01:09', '500.00', 1, '30000.00', 'xqwqdw', 3, '15000000.00', '0.00', '0000-00-00 00:00:00'),
(5, 1, 4, 2, 1, '2018-09-07 23:17:26', '20.00', 1, '1111.00', 'mensaje de prueba', 4, '22220.00', '0.00', '2018-09-07 23:17:26'),
(6, 1, 5, 4, 1, '2018-09-08 15:36:27', '20.00', 6, '11000.00', 'Es Magico !!', 4, '220000.00', '0.00', '2018-09-08 15:36:27'),
(7, 1, 5, 5, 1, '2018-09-09 16:03:00', '100.00', 1, '1111.00', 'okfbnjkfn', 3, '111100.00', '111100.00', '2018-09-09 16:03:00'),
(8, 1, 5, 4, 1, '2018-09-09 21:04:39', '150.00', 1, '1111.00', 'iughiugt', 3, '166650.00', '166650.00', '2018-09-09 21:04:39'),
(9, 1, 5, 5, 1, '2018-09-09 21:27:22', '200.00', 4, '2900.00', 'iopjiihih', 3, '580000.00', '580000.00', '2018-09-09 21:27:22'),
(10, 1, 5, 4, 1, '2018-09-09 22:07:24', '15.00', 6, '11000.00', 'poihuihuguy', 3, '165000.00', '165000.00', '2018-09-09 22:07:24'),
(11, 1, 4, 1, 1, '2018-09-10 00:35:54', '600.00', 7, '700.00', 'uhnuhuj', 3, '420000.00', '420000.00', '2018-09-10 00:35:54');

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
(2, 'Transferencia(Credito)', 1);

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
  `credit` decimal(11,2) NOT NULL,
  `referred` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `user`, `name`, `last_name`, `id_roll_user`, `password`, `image`, `stat`, `location`, `create_date`, `email`, `id_user_reg`, `credit`, `referred`) VALUES
(1, 'chicho', 'Blaster', 'Slovar', 1, '321', 'image_users/1.jpg', 1, 1, '2017-10-19 11:48:15', '', 0, '1000.00', 0),
(2, 'orga', 'duval', 'games', 1, 'cygGLqlfhk6J7w7XuMGWgpQOJWizlAUFi2Yt5/Q68xM=', 'image_users/2_thumb.jpg', 1, 2, '2017-10-19 12:14:46', 'orga@bolivartoday.com', 0, '1000.00', 0),
(3, 'prueba', 'prueba', 'prueba', 3, 'DbOF93Ai+fSAWROreNSOTlIcJ+tTlyY6tpOpJKZsZtQ=', 'image_users/3_thumb.jpg', 1, 3, '2018-09-02 00:29:30', 'prueba@gmail.com', 1, '1000.00', 0),
(4, 'prueba2', 'prueba2', 'prueba2', 3, 'cygGLqlfhk6J7w7XuMGWgpQOJWizlAUFi2Yt5/Q68xM=', 'image_users/4_thumb.jpg', 1, 1, '2018-09-02 00:54:41', 'hh@hh.com', 1, '1000.00', 3),
(5, 'qweq', 'weqweq', 'weqw', 0, 'cygGLqlfhk6J7w7XuMGWgpQOJWizlAUFi2Yt5/Q68xM=', 'image_users/5_thumb.jpg', 1, 2, '2018-09-02 01:00:12', 'eqweq@ada.com', 1, '1000.00', 0);

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
(8, 1, '1000.00', 1, 1, '2018-09-05 00:00:00'),
(9, 1, '1111.00', 1, 1, '2018-09-06 22:31:34'),
(10, 7, '2222.00', 1, 1, '2018-09-06 22:31:50'),
(11, 7, '700.00', 1, 1, '2018-09-08 15:16:27');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `acount_bank`
--
ALTER TABLE `acount_bank`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `acount_customer`
--
ALTER TABLE `acount_customer`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `bank`
--
ALTER TABLE `bank`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `bank_customer`
--
ALTER TABLE `bank_customer`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `acount_customer`
--
ALTER TABLE `acount_customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `bank`
--
ALTER TABLE `bank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `bank_customer`
--
ALTER TABLE `bank_customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `country`
--
ALTER TABLE `country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `main_pay`
--
ALTER TABLE `main_pay`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `master_stat`
--
ALTER TABLE `master_stat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `mov_bank`
--
ALTER TABLE `mov_bank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
