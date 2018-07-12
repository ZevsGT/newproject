-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июл 12 2018 г., 22:47
-- Версия сервера: 5.6.38
-- Версия PHP: 7.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `project`
--

-- --------------------------------------------------------

--
-- Структура таблицы `answers`
--

CREATE TABLE `answers` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `flag` int(11) UNSIGNED NOT NULL,
  `questions_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `answers`
--

INSERT INTO `answers` (`id`, `name`, `flag`, `questions_id`) VALUES
(135, 'true111', 1, 60),
(136, 'false111', 0, 60),
(137, 'false111', 0, 60),
(138, 'верный', 1, 61),
(139, 'не верны', 0, 61),
(140, 'нет', 0, 61),
(141, 'нет', 0, 61),
(142, 'false111', 0, 60),
(145, 'иваива', 1, 63),
(146, 'иавиавива', 0, 63),
(162, '1', 0, 60),
(168, 'true', 1, 72),
(169, 'false', 0, 72),
(170, 'true 2', 1, 73),
(171, 'false 2', 0, 73),
(172, 'false 2', 0, 73),
(173, 'false 2', 0, 73),
(174, 'true 3', 1, 74),
(175, 'false 3', 0, 74),
(176, 'false 3', 0, 74),
(177, 'true 4', 1, 75),
(178, 'false 4', 0, 75),
(179, 'true 5', 1, 76),
(180, 'false 5', 0, 76),
(181, 'true 6', 1, 77),
(182, 'false 6', 0, 77),
(183, 'true 7', 1, 78),
(184, 'false 7', 0, 78),
(185, 'true 8', 1, 79),
(186, 'false 8', 0, 79),
(187, 'true 9', 1, 80),
(188, 'false 9', 0, 80),
(189, 'true 10', 1, 81),
(190, 'false10', 0, 81),
(191, 'false 10', 0, 81),
(192, 'false 10', 0, 81),
(193, 'false 10', 0, 81),
(194, 'false 10', 0, 81),
(195, 'не верный', 0, 81),
(196, 'false 10', 0, 81),
(197, 'false 10', 0, 81);

-- --------------------------------------------------------

--
-- Структура таблицы `questions`
--

CREATE TABLE `questions` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `testtitle_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `questions`
--

INSERT INTO `questions` (`id`, `name`, `testtitle_id`) VALUES
(60, 'вопрос обновление111', 45),
(61, 'название 21', 45),
(63, 'иапиави', 45),
(72, 'вопрос 1', 56),
(73, 'вопрос 2', 56),
(74, 'вопрос 3', 56),
(75, 'вопрос 4', 56),
(76, 'вопрос 5', 56),
(77, 'вопрос 6', 56),
(78, 'вопрос 7', 56),
(79, 'вопрос 8', 56),
(80, 'вопрос 9', 56),
(81, 'вопрос 10', 56);

-- --------------------------------------------------------

--
-- Структура таблицы `testtitle`
--

CREATE TABLE `testtitle` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `num_quest` int(11) UNSIGNED DEFAULT NULL,
  `passing_score` int(11) UNSIGNED DEFAULT NULL,
  `users_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `testtitle`
--

INSERT INTO `testtitle` (`id`, `name`, `num_quest`, `passing_score`, `users_id`) VALUES
(45, 'название121', 3, 50, 1),
(56, 'Тест', 5, 5, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `login` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `group`, `login`, `password`) VALUES
(1, 'Дмитрий', 'admin', 'bugaty_x3@mail.ru', '123');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_foreignkey_answers_questions` (`questions_id`);

--
-- Индексы таблицы `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_foreignkey_questions_testtitle` (`testtitle_id`);

--
-- Индексы таблицы `testtitle`
--
ALTER TABLE `testtitle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_foreignkey_testtitle_users` (`users_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=198;

--
-- AUTO_INCREMENT для таблицы `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT для таблицы `testtitle`
--
ALTER TABLE `testtitle`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `c_fk_answers_questions_id` FOREIGN KEY (`questions_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `c_fk_questions_testtitle_id` FOREIGN KEY (`testtitle_id`) REFERENCES `testtitle` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `testtitle`
--
ALTER TABLE `testtitle`
  ADD CONSTRAINT `c_fk_testtitle_users_id` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
