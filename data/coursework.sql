-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Янв 11 2022 г., 11:42
-- Версия сервера: 5.7.29-log
-- Версия PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `coursework`
--
CREATE DATABASE IF NOT EXISTS `coursework` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `coursework`;

-- --------------------------------------------------------

--
-- Структура таблицы `bonus_cards`
--

CREATE TABLE `bonus_cards` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `сard_number` char(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `balance` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `bonus_cards`
--

INSERT INTO `bonus_cards` (`id`, `id_user`, `сard_number`, `date`, `balance`) VALUES
(4, 8, '0000000000000008', '2022-01-05 18:58:23', 0),
(5, 9, '0000000000000009', '2022-01-08 17:00:34', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `by_price`
--

CREATE TABLE `by_price` (
  `id` int(10) NOT NULL,
  `id_good` int(10) NOT NULL,
  `number` int(2) NOT NULL,
  `data_start` date NOT NULL,
  `data_end` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `goods`
--

CREATE TABLE `goods` (
  `id` int(11) NOT NULL,
  `title` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `goods`
--

INSERT INTO `goods` (`id`, `title`, `price`, `description`) VALUES
(1, 'Набор из 6 акриловых призм и линз', 5964, ''),
(2, 'Лента Scotch Expressions Magic Tape', 1578, ''),
(3, 'Записная книжка Five Star Advance', 4771, ''),
(4, 'Детские ножницы', 543, ''),
(5, 'Подставка для книг', 2982, ''),
(6, 'Красочная лента для рукоделия', 320, ''),
(7, 'Чехол для документов ', 4342, ''),
(8, 'Блокнот в твердом переплете', 1732, '');

-- --------------------------------------------------------

--
-- Структура таблицы `holidays`
--

CREATE TABLE `holidays` (
  `id` int(11) NOT NULL,
  `date` char(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `holiday` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount` int(3) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `holidays`
--

INSERT INTO `holidays` (`id`, `date`, `holiday`, `discount`) VALUES
(1, NULL, 'День рождение', 10),
(3, '02-23', '23 февраля', 5),
(4, '12-31', 'Новый год', 7),
(5, '03-08', '8 марта', 9);

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int(10) NOT NULL,
  `id_user` int(10) NOT NULL,
  `amount` float(8,2) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `id_user`, `amount`, `date`) VALUES
(1, 9, 14968.00, '2022-01-08 18:27:28'),
(2, 9, 0.00, '2022-01-08 18:28:06'),
(3, 9, 0.00, '2022-01-08 18:28:11'),
(4, 9, 0.00, '2022-01-08 18:28:12'),
(5, 9, 0.00, '2022-01-08 18:28:35'),
(6, 9, 0.00, '2022-01-08 18:28:37'),
(7, 9, 0.00, '2022-01-08 18:28:40'),
(8, 9, 640.00, '2022-01-08 18:29:36'),
(9, 9, 960.00, '2022-01-08 21:21:59'),
(10, 9, 320.00, '2022-01-08 21:27:23'),
(11, 9, 320.00, '2022-01-08 21:42:53'),
(12, 9, 320.00, '2022-01-08 21:50:45'),
(13, 9, 320.00, '2022-01-08 21:56:19'),
(14, 9, 320.00, '2022-01-08 22:17:34'),
(15, 9, 320.00, '2022-01-08 23:05:31'),
(16, 9, 320.00, '2022-01-09 14:58:15'),
(17, 9, 320.00, '2022-01-09 14:59:22'),
(18, 9, 320.00, '2022-01-09 15:02:36'),
(19, 9, 320.00, '2022-01-09 15:04:44'),
(20, 9, 320.00, '2022-01-09 15:05:21'),
(21, 9, 320.00, '2022-01-09 15:06:08'),
(22, 9, 320.00, '2022-01-09 15:09:51'),
(23, 9, 320.00, '2022-01-09 15:21:27'),
(24, 9, 320.00, '2022-01-09 15:22:08'),
(25, 9, 320.00, '2022-01-09 15:24:39'),
(26, 9, 320.00, '2022-01-09 15:27:16'),
(27, 9, 288.00, '2022-01-09 15:39:36'),
(28, 9, 288.00, '2022-01-09 15:46:00'),
(29, 9, 288.00, '2022-01-09 15:50:00'),
(30, 9, 320.00, '2022-01-09 15:57:00'),
(31, 9, 320.00, '2022-01-09 16:01:47'),
(32, 9, 320.00, '2022-01-09 16:02:29'),
(33, 9, 320.00, '2022-01-09 16:14:38'),
(34, 9, 320.00, '2022-01-09 16:15:35'),
(35, 9, 288.00, '2022-01-09 16:18:14'),
(36, 9, 288.00, '2022-01-09 16:21:21'),
(37, 9, 288.00, '2022-01-09 16:25:59'),
(38, 9, 288.00, '2022-01-09 16:26:14'),
(39, 9, 803.85, '2022-01-09 16:33:40'),
(40, 9, 288.00, '2022-01-09 16:39:13'),
(41, 10, 6284.00, '2022-01-10 12:18:42'),
(42, 9, 1350.96, '2022-01-11 11:30:11');

-- --------------------------------------------------------

--
-- Структура таблицы `order_items`
--

CREATE TABLE `order_items` (
  `id` int(10) NOT NULL,
  `id_order` int(10) NOT NULL,
  `id_good` int(10) NOT NULL,
  `quantity` tinyint(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `order_items`
--

INSERT INTO `order_items` (`id`, `id_order`, `id_good`, `quantity`) VALUES
(1, 1, 7, 2),
(2, 1, 6, 1),
(3, 1, 1, 1),
(4, 8, 6, 2),
(5, 9, 6, 3),
(6, 10, 6, 1),
(7, 11, 6, 1),
(8, 12, 6, 1),
(9, 13, 6, 1),
(10, 14, 6, 1),
(11, 15, 6, 1),
(12, 16, 6, 1),
(13, 17, 6, 1),
(14, 18, 6, 1),
(15, 19, 6, 1),
(16, 20, 6, 1),
(17, 21, 6, 1),
(18, 22, 6, 1),
(19, 23, 6, 1),
(20, 24, 6, 1),
(21, 25, 6, 1),
(22, 26, 6, 1),
(23, 27, 6, 1),
(24, 28, 6, 1),
(25, 29, 6, 1),
(26, 30, 6, 1),
(27, 31, 6, 1),
(28, 32, 6, 1),
(29, 33, 6, 1),
(30, 34, 6, 1),
(31, 35, 6, 1),
(32, 36, 6, 1),
(33, 37, 6, 1),
(34, 38, 6, 1),
(35, 39, 6, 1),
(36, 39, 4, 1),
(37, 40, 6, 1),
(38, 41, 1, 1),
(39, 41, 6, 1),
(40, 42, 6, 4),
(41, 42, 4, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `polls`
--

CREATE TABLE `polls` (
  `id` int(11) NOT NULL,
  `name_poll` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` bit(1) NOT NULL DEFAULT b'1',
  `data_end` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `premium_bonus`
--

CREATE TABLE `premium_bonus` (
  `discount` int(3) NOT NULL,
  `bonus` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `premium_bonus`
--

INSERT INTO `premium_bonus` (`discount`, `bonus`) VALUES
(10, 5);

-- --------------------------------------------------------

--
-- Структура таблицы `premium_users`
--

CREATE TABLE `premium_users` (
  `id_user` int(10) NOT NULL,
  `data_start` date NOT NULL,
  `data_end` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `premium_users`
--

INSERT INTO `premium_users` (`id_user`, `data_start`, `data_end`) VALUES
(9, '2022-01-09', '2022-05-31');

-- --------------------------------------------------------

--
-- Структура таблицы `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `id_poll` int(11) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `shopping_cart`
--

CREATE TABLE `shopping_cart` (
  `id_user` int(10) NOT NULL,
  `id_good` int(10) NOT NULL,
  `number` int(2) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `shopping_cart`
--

INSERT INTO `shopping_cart` (`id_user`, `id_good`, `number`) VALUES
(8, 5, 1),
(8, 1, 2),
(9, 6, 1),
(9, 1, 1),
(9, 4, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `stock`
--

CREATE TABLE `stock` (
  `id` int(11) NOT NULL,
  `id_good` int(11) NOT NULL,
  `discount` int(2) NOT NULL DEFAULT '0',
  `bonuses` int(4) NOT NULL DEFAULT '0',
  `data_start` date NOT NULL,
  `data_end` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `stock`
--

INSERT INTO `stock` (`id`, `id_good`, `discount`, `bonuses`, `data_start`, `data_end`) VALUES
(6, 1, 10, 0, '2022-01-01', '2022-01-31'),
(13, 6, 10, 20, '2022-01-01', '2025-01-28'),
(14, 4, 5, 0, '2022-01-08', '2022-01-31');

-- --------------------------------------------------------

--
-- Структура таблицы `survey_results`
--

CREATE TABLE `survey_results` (
  `id` int(11) NOT NULL,
  `id_question` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `answer` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `date_now` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `birthday` date NOT NULL,
  `username` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `date_now`, `birthday`, `username`, `mail`, `password`) VALUES
(8, '2022-01-05 18:58:22', '2003-01-08', 'Артем', 'a@mai.ru', '$2y$10$kUYpju4qDhLH8mR.26zS4ODYI6s2/OFBeUD2iWGGX4DS04EoV6yQi'),
(9, '2022-01-08 17:00:34', '2002-01-11', 'Maks', 'tutukovz@mail.ru', '$2y$10$S/lGLHzCc0sszzqROJ7Y1.nIMqmYJf3jyYfTtSI8Y7D.x3shpMB7i'),
(10, '2022-01-10 12:00:08', '2022-01-01', 'не участник', 'not@mail.ru', '$2y$10$vV0Luuoi0oxRx4kmIb8pXuuiLING65CQ5iOAkhu/D42pmxyoyTS7O');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `bonus_cards`
--
ALTER TABLE `bonus_cards`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `сard_number` (`сard_number`),
  ADD KEY `id_user` (`id_user`);

--
-- Индексы таблицы `by_price`
--
ALTER TABLE `by_price`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_good` (`id_good`);

--
-- Индексы таблицы `goods`
--
ALTER TABLE `goods`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `goods` ADD FULLTEXT KEY `title` (`title`);

--
-- Индексы таблицы `holidays`
--
ALTER TABLE `holidays`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Индексы таблицы `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_order` (`id_order`),
  ADD KEY `id_good` (`id_good`);

--
-- Индексы таблицы `polls`
--
ALTER TABLE `polls`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `premium_users`
--
ALTER TABLE `premium_users`
  ADD KEY `id_user` (`id_user`);

--
-- Индексы таблицы `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_poll` (`id_poll`);

--
-- Индексы таблицы `shopping_cart`
--
ALTER TABLE `shopping_cart`
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_good` (`id_good`);

--
-- Индексы таблицы `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_good` (`id_good`);

--
-- Индексы таблицы `survey_results`
--
ALTER TABLE `survey_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_question` (`id_question`),
  ADD KEY `id_user` (`id_user`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mail` (`mail`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `bonus_cards`
--
ALTER TABLE `bonus_cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `by_price`
--
ALTER TABLE `by_price`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `goods`
--
ALTER TABLE `goods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `holidays`
--
ALTER TABLE `holidays`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT для таблицы `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT для таблицы `polls`
--
ALTER TABLE `polls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `survey_results`
--
ALTER TABLE `survey_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `bonus_cards`
--
ALTER TABLE `bonus_cards`
  ADD CONSTRAINT `bonus_cards_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `by_price`
--
ALTER TABLE `by_price`
  ADD CONSTRAINT `by_price_ibfk_1` FOREIGN KEY (`id_good`) REFERENCES `goods` (`id`);

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`id_order`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`id_good`) REFERENCES `goods` (`id`);

--
-- Ограничения внешнего ключа таблицы `premium_users`
--
ALTER TABLE `premium_users`
  ADD CONSTRAINT `premium_users_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`id_poll`) REFERENCES `polls` (`id`);

--
-- Ограничения внешнего ключа таблицы `shopping_cart`
--
ALTER TABLE `shopping_cart`
  ADD CONSTRAINT `shopping_cart_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `shopping_cart_ibfk_2` FOREIGN KEY (`id_good`) REFERENCES `goods` (`id`);

--
-- Ограничения внешнего ключа таблицы `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `stock_ibfk_1` FOREIGN KEY (`id_good`) REFERENCES `goods` (`id`);

--
-- Ограничения внешнего ключа таблицы `survey_results`
--
ALTER TABLE `survey_results`
  ADD CONSTRAINT `survey_results_ibfk_1` FOREIGN KEY (`id_question`) REFERENCES `questions` (`id`),
  ADD CONSTRAINT `survey_results_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
