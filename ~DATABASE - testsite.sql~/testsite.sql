-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 01 2020 г., 21:44
-- Версия сервера: 5.7.25
-- Версия PHP: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `testsite`
--

-- --------------------------------------------------------

--
-- Структура таблицы `coments`
--

CREATE TABLE `coments` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `coment` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  `status` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `coments`
--

INSERT INTO `coments` (`id`, `name`, `coment`, `date`, `user_id`, `status`) VALUES
(22, 'ss', 'rgergeg', '2020-02-15 12:39:24', 265, 1),
(23, 'ss', 'fbdgdfv sdfdfg sdff sdf', '2020-02-15 12:39:28', 265, 1),
(25, 'john', 'edg gdfzgdzf gdzfgzdfgzd', '2020-02-15 12:44:59', 266, 1),
(26, 'john', 'aerterg ergdg dfgdzgdgcgbdb ', '2020-02-15 12:45:08', 266, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `password_confirmation` varchar(255) NOT NULL,
  `password_cookie_token` varchar(255) NOT NULL,
  `image` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Хранение основных данных о пользователях';

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `email`, `password`, `password_confirmation`, `password_cookie_token`, `image`) VALUES
(265, 'ss', 'ss@test.net', '$2y$10$aQ6Pbeo0fzGgEkdseEy.7erNTW87/TMnYzBarFZy1x2dVBeU96.GK', '$2y$10$D.DjCu7.lnZubvZziBnDH.wVfXcY.ZzPDfNWNzr0kCPfVkqGdwKq.', 'cbd69230d553c4fd7b5bc61f2fe21cf2', 0x433a2f4f5350616e656c2f646f6d61696e732f66697273742e746573742f696d672f356535626561373536396132322e6a7067),
(266, 'john', 'john@gmail.com', '$2y$10$lkYbT8EjBEr9zAwKnVPq..iIamXdeYocLXcATxykNBOqiMqgOnbNm', '$2y$10$WAQPn8v5IXsjILhhGp6pLu084vDuEypCM.UoT3l/imxCTvRShVb2W', '', 0x433a2f4f5350616e656c2f646f6d61696e732f66697273742e746573742f696d672f75736572322e6a7067),
(268, 'dave', 'dave@gmail.com', '$2y$10$mrsd191FSeqfFw8typVN4em.B78bh5sMP4BQXDKN0USelWku4h8bW', '$2y$10$pOzNeqBASGNdri9mmT46yeJz.NhtK8X.ljwV86MNYxROoIwoON0em', '', 0x433a2f4f5350616e656c2f646f6d61696e732f66697273742e746573742f696d672f356535626661303930626636392e6a7067);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `coments`
--
ALTER TABLE `coments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `coments`
--
ALTER TABLE `coments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=271;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `coments`
--
ALTER TABLE `coments`
  ADD CONSTRAINT `coments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
