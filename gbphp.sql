-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Авг 02 2021 г., 01:23
-- Версия сервера: 5.7.29
-- Версия PHP: 7.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `gbphp`
--

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `id` int(255) NOT NULL,
  `good_id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_avatar` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `text` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `good_id`, `user_id`, `user_name`, `user_avatar`, `title`, `text`) VALUES
(40, 19, 31, 'Kirill', '28334ee1d5ab24fc0b68014a2cfeedb1.jpg', 'отличная куртка', 'тёплая и стильная куртка'),
(41, 15, 31, 'Kirill', '28334ee1d5ab24fc0b68014a2cfeedb1.jpg', 'очень плохие вещи, не покупайте тут ничего', 'в этом магазине в последнее время все вещи очень низкого качества'),
(42, 18, 31, 'Kirill', '28334ee1d5ab24fc0b68014a2cfeedb1.jpg', 'не очень', 'такое низкое качество и за такие деньги'),
(43, 21, 31, 'Kirill', '28334ee1d5ab24fc0b68014a2cfeedb1.jpg', 'отличная вещь', 'стирается легко, можно носить в любую погоду'),
(45, 19, 30, 'Maria', '2d94a18fd8d5a4d6ecc7d56579d70004.jpg', 'супер', 'хорошая вещь, унисекс'),
(46, 15, 30, 'Maria', '2d94a18fd8d5a4d6ecc7d56579d70004.jpg', 'красивая кофточка', 'отличная кофточка, можно носить на работу и в клуб'),
(47, 16, 30, 'Maria', '2d94a18fd8d5a4d6ecc7d56579d70004.jpg', 'любимое', 'моё любимое платье и совсем не дорогое'),
(48, 18, 30, 'Maria', '2d94a18fd8d5a4d6ecc7d56579d70004.jpg', 'в подарок папе', 'купила папе в подарок такой пиджак, он был очень доволен'),
(49, 17, 32, 'Ivan', 'b5fa185c1cfd478b08be19e6554afea1.jpg', 'хороший подарок', 'подарил девушке, но ей не понравилось, бросил её, теперь сам ношу, всем советую)))'),
(51, 19, 32, 'Ivan', 'b5fa185c1cfd478b08be19e6554afea1.jpg', 'хрень', 'позорная вещь, похоже на прикид бомжа'),
(52, 18, 33, 'Vladimir', 'f283c07ac53f3d96b0ebbdad5eafc85a.jpg', 'то что надо', 'давно искал такое пальто'),
(53, 21, 33, 'Vladimir', 'f283c07ac53f3d96b0ebbdad5eafc85a.jpg', 'супер', 'в этой куртке я просто секс, чувствую себя на 1000 баксов=)'),
(54, 20, 33, 'Vladimir', 'f283c07ac53f3d96b0ebbdad5eafc85a.jpg', 'норм', 'норм, все равно выбора нет');

-- --------------------------------------------------------

--
-- Структура таблицы `goods`
--

CREATE TABLE `goods` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `price` varchar(10) NOT NULL,
  `info` text NOT NULL,
  `counter` int(10) NOT NULL DEFAULT '1',
  `img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `goods`
--

INSERT INTO `goods` (`id`, `name`, `price`, `info`, `counter`, `img`) VALUES
(15, 'moshino cheap', '5600', 'Compellingly actualize fully researched processes before proactive outsourcing', 1, 'df1426a4e308542cc7344a4b16011deb.jpg'),
(16, 'Embroidered cotton blouse', '4900', 'Burton Menswear double breasted skinny suit jacket in sage green', 1, '10e78d274dfa34b0ac826b55b40a728e.jpg'),
(17, 'Burton Menswear', '12500', 'Viggo recycled polyester slim fit suit trousers in blue check', 1, '74d0f6ed8ad4445fff5c84b32206534a.jpg'),
(18, 'Metallic knit top', '2990', 'Nike leg-a-see leggings in grey with just do it print', 1, '844ad108ff70f8646649b32515b2ce3f.jpg'),
(19, 'Crew neckline blouse', '5000', 'asos design rivington stretch powerhold denim jeggings in black', 1, '7d8d47d0cf1fa2c6fa32a1bcbdbe2ca6.jpg'),
(20, 'Pleated T-shirt', '11200', 'Brave Soul shontelle brush fur jacket in cream', 1, 'c96e428ca4e6ce89de04c654baca4f73.jpg'),
(21, 'Polka-dot print', '7200', 'Burton Menswear skinny suit trousers in grey & pink stripe', 1, '8e359d47810f11c53f19708a267f8d58.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `info` varchar(200) NOT NULL,
  `counter` int(100) NOT NULL,
  `img` varchar(255) NOT NULL DEFAULT 'img/no_img.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `name`, `price`, `info`, `counter`, `img`) VALUES
(4, 'nokia', 5990, 'good phone', 1, 'img/no_img.jpg'),
(5, 'sony', 5990, 'good', 1, 'img/no_img.jpg'),
(6, 'mobile', 456, 'good sound', 1, 'img/no_img.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `login` varchar(50) NOT NULL COMMENT 'для авторизации',
  `password` varchar(64) NOT NULL,
  `name` varchar(50) NOT NULL DEFAULT 'n/o' COMMENT 'имя пользователя',
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `position` varchar(100) NOT NULL,
  `avatar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='таблица для пользователей';

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `name`, `is_admin`, `position`, `avatar`) VALUES
(3, 'admin', '$2y$10$CICSDfonBbkHfNiVLGwwnuGWqTcUd4ifAKtcnSV7nisqh5/otN27.', 'Konstantin Dryakhlov', 1, 'admin', 'e7df0597c77352d702526c9da68ec482.jpg'),
(30, 'user2', '$2y$10$ter5jjhb3naBufs1zK9f0enZT0o7cEh92D.nQvEjEGz2EZHYmw5B.', 'Maria', 2, 'director', '2d94a18fd8d5a4d6ecc7d56579d70004.jpg'),
(31, 'user3', '$2y$10$.24xKFRQRD3H1x.KXnGbB.0bcFIMovjaGzM9iqTFG3pe3alvuWHyS', 'Kirill', 0, 'manager', '28334ee1d5ab24fc0b68014a2cfeedb1.jpg'),
(32, 'user4', '$2y$10$VydJxFc6F4mUecE5ZIQU2es4gGwzo01YmBP3B4RbO76bpy0ho1cT.', 'Ivan', 0, 'killer', 'b5fa185c1cfd478b08be19e6554afea1.jpg'),
(33, 'user5', '$2y$10$JM/lnLUpXr02kzDluJgH0OIe2fwZwVlfBq9getCpG0aTGKtLKgiIa', 'Vladimir', 0, 'driver', 'f283c07ac53f3d96b0ebbdad5eafc85a.jpg'),
(34, 'user6', '$2y$10$Es.qliu4/eEzzVllpFar/OgvqFkMxbye9626CAwrpOBy4xUThnjF2', 'Neal', 2, 'designer', 'f7abe7652f3e7ba2913f3414f3b775f9.jpg');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `goods`
--
ALTER TABLE `goods`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT для таблицы `goods`
--
ALTER TABLE `goods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
