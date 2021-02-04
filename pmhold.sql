-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Фев 04 2021 г., 19:23
-- Версия сервера: 5.7.29
-- Версия PHP: 7.3.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `pmhold`
--

-- --------------------------------------------------------

--
-- Структура таблицы `apple`
--

CREATE TABLE `apple` (
  `id` tinyint(4) NOT NULL,
  `color_css` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'css код цвета',
  `color_rus` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'название цвета по-русски',
  `emergence_time` bigint(20) NOT NULL COMMENT 'время создания',
  `fall_time` bigint(20) NOT NULL DEFAULT '0' COMMENT 'время падения',
  `status_id` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'статус',
  `eating_percent` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'съедено %'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `apple`
--

INSERT INTO `apple` (`id`, `color_css`, `color_rus`, `emergence_time`, `fall_time`, `status_id`, `eating_percent`) VALUES
(2, 'Orange', 'оранжевый', 1612203023, 1612426268, 3, 100),
(3, 'Orange', 'оранжевый', 1612203023, 1612426300, 3, 100),
(4, 'Orange', 'оранжевый', 1612203023, 1612439316, 2, 100),
(6, 'Red', 'красный', 1612271826, 0, 0, 0),
(7, 'GreenYellow', 'желто-зеленый', 1612276088, 1612418400, 3, 0),
(8, 'GreenYellow', 'желто-зеленый', 1612276089, 1612426336, 3, 0),
(9, 'GreenYellow', 'желто-зеленый', 1612276089, 1612425600, 3, 25),
(10, 'GreenYellow', 'желто-зеленый', 1612441723, 1612443731, 1, 50);

-- --------------------------------------------------------

--
-- Структура таблицы `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1612096433),
('m130524_201442_init', 1612096447),
('m190124_110200_add_verification_token_column_to_user_table', 1612096448);

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `verification_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`, `verification_token`) VALUES
(1, 'admin', '_gMMqF8PFP49sDSzyEJlXWFAjUZDjByK', '$2y$13$2GZBL25T4QA0UvG7Qwg3g.vN3RH/hbGyCfccnV1rvgf.wQ4VbbKPa', NULL, 'admin@web-doc.ru', 10, 1612097921, 1612097921, 'c88TYi4E637C_P7wF6wYylPiAiWUhu4p_1612097921');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `apple`
--
ALTER TABLE `apple`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `apple`
--
ALTER TABLE `apple`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
