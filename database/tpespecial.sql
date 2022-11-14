-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-11-2022 a las 23:52:47
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tpespecial`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `brands`
--

CREATE TABLE `brands` (
  `brand_ID` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `country` varchar(45) NOT NULL,
  `foundation` int(11) NOT NULL,
  `website` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `brands`
--

INSERT INTO `brands` (`brand_ID`, `name`, `country`, `foundation`, `website`) VALUES
(2, 'Bagovit', 'Argentina', 1934, 'bagovit.com.ar'),
(8, 'Garnier', 'France', 1904, 'garnier.com.ar'),
(12, 'Neutrogena', 'USA', 1930, 'neutrogena.com.ar'),
(13, 'Nivea', 'Germany', 1911, 'nivea.com.ar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comments`
--

CREATE TABLE `comments` (
  `comment_ID` int(11) NOT NULL,
  `comment` varchar(200) NOT NULL,
  `author` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `comments`
--

INSERT INTO `comments` (`comment_ID`, `comment`, `author`) VALUES
(1, 'La mejor crema que he usado... la recomiendo 100%', 'Laura Lopez'),
(2, 'Una de mis favoritas si o si', 'Gastón Diaz'),
(3, 'Es una genialidad, cero oleosidad aunque transpires, cuando te aplicas tiene la textura de un bloqueador solar liviano, pero pasa 1 minuto y parece que no te hubieras puesto nada de lo liviana que es.', 'Luz Galles'),
(4, 'Me la compré hoy! Veremos cómo me funciona...tengo piel de normal a grasa y necesito hidratación... espero que funcione porque las crema gel no me funcionó ', 'Juan rodriguez'),
(5, 'Lo uso por las mañanas, ningún problema , se absorbe bastante rápido.', 'Antonella Mansilla'),
(6, 'Lo uso hace 3 meses, es muy bueno el kit. Resultados increíbles.', 'Camila Moreno');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `product_ID` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `milliliters` int(11) NOT NULL,
  `price` double NOT NULL,
  `brand_ID` int(11) NOT NULL,
  `comment_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`product_ID`, `name`, `milliliters`, `price`, `brand_ID`, `comment_ID`) VALUES
(3, 'Contorno de Ojos', 120, 1200, 2, 4),
(5, 'Gel facial exfoliante', 30, 1540, 13, 6),
(7, 'Agua micelar bifasica', 200, 2670, 12, 4),
(13, 'Crema Antiage Hidratante', 55, 2878, 2, 1),
(32, 'Serum antimanchas', 30, 2735, 13, 5),
(59, 'Crema reparadora', 120, 1200, 12, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `email`, `password`) VALUES
(1, 'flor.prat.4@gmail.com', '$2a$12$oTLMADqRRSkDvYq1pu4X2.kaahsyrbCvuj4Hb5U766FgweS9gZEkK');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`brand_ID`),
  ADD KEY `company_ID` (`brand_ID`);

--
-- Indices de la tabla `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_ID`),
  ADD KEY `comment_ID` (`comment_ID`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_ID`),
  ADD KEY `company_ID` (`brand_ID`),
  ADD KEY `comment_ID` (`comment_ID`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `brands`
--
ALTER TABLE `brands`
  MODIFY `brand_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `product_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`brand_ID`) REFERENCES `brands` (`brand_ID`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`comment_ID`) REFERENCES `comments` (`comment_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
