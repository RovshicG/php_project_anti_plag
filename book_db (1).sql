-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 22 2025 г., 16:36
-- Версия сервера: 8.0.19
-- Версия PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `book_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `articles`
--

CREATE TABLE `articles` (
  `id` int NOT NULL,
  `name_book` varchar(255) DEFAULT NULL,
  `text_book` text,
  `link` varchar(255) DEFAULT NULL,
  `img_book` varchar(255) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `time_insert` timestamp NULL DEFAULT NULL,
  `type_book` varchar(255) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `articles`
--

INSERT INTO `articles` (`id`, `name_book`, `text_book`, `link`, `img_book`, `file_name`, `user_id`, `time_insert`, `type_book`, `author`) VALUES
(1, 'Название защищённой книги', 'Текст книги', 'ссылка', 'image.jpg', 'file.pdf', 1, '2025-01-29 22:26:31', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `books`
--

CREATE TABLE `books` (
  `id` int NOT NULL,
  `name_book` varchar(255) DEFAULT NULL,
  `text_book` text,
  `link` varchar(255) DEFAULT NULL,
  `img_book` varchar(255) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `time_insert` timestamp NULL DEFAULT NULL,
  `type_book` varchar(255) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `books`
--

INSERT INTO `books` (`id`, `name_book`, `text_book`, `link`, `img_book`, `file_name`, `user_id`, `time_insert`, `type_book`, `author`) VALUES
(1, 'Название защищённой книги', 'Текст книги', 'ссылка', 'image.jpg', 'file.pdf', 1, '2025-01-29 22:26:31', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `books_security`
--

CREATE TABLE `books_security` (
  `id` int NOT NULL,
  `name_book` varchar(255) DEFAULT NULL,
  `text_book` text,
  `link` varchar(255) DEFAULT NULL,
  `img_book` varchar(255) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `time_insert` timestamp NULL DEFAULT NULL,
  `type_book` varchar(255) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `books_security`
--

INSERT INTO `books_security` (`id`, `name_book`, `text_book`, `link`, `img_book`, `file_name`, `user_id`, `time_insert`, `type_book`, `author`) VALUES
(1, 'Название защищённой книги', 'Текст книги', 'ссылка', 'image.jpg', 'file.pdf', 1, '2025-01-29 22:26:31', NULL, NULL),
(2, 'Hal', 'ИЧКИ ХИЗМАТНИ ТАШКИЛЛАШТИРИШ ВА ОЛИБ БОРИШ БЎЛИМИ\r\nЎР ҚК Академияси штаб бошлиғининг ўринбосари (ҳарбий хизмат хавфсизлигини) – подполковник Азизбек Расулжонович ХАЛИЛОВ\r\nБўлим шахсий таркиби билан соҳани ривожлантириш бўйича бўлинма командирлари билан мунатазам равишда машғулотлар олиб бормоқда\r\nБўлимнинг асосий вазифалари\r\nКўйидагилардан иборат.\r\nҚўшинлар хизматига доир тадбирларни режалаштириш;\r\nҲарбий ша', 'https', 'uploads/images/img_67c60bca73163.PNG', 'uploads/files/file_67c60bca7357e.docx', 1, '2025-03-03 20:06:32', 'Книга', '0'),
(3, 'Havo hujum', 'АРМИЯ ВА ТАРБИЯ\r\nЯнги Ўзбекистоннинг миллий армиясида\r\nШоирлар ҳам сафдошдир таълим-тарбиясида.\r\n\r\nЯъни ҳар бир ижодкор, ҳар ёзувчи ё адиб — \r\nСардор бўлмоғи керак билимдон ва ботартиб.\r\n\r\nҲар жанговар аскарнинг биз ҳам тенг-тўшларимиз,\r\nҚалам-ла қуролланган қуролли кучларимиз.\r\n\r\nКим Темурхон бобонинг қудратини билмаган?\r\nБобо орзу қилган, лек хаёлига келмаган:\r\n\r\nКимки шубҳа қилгайдир довруғи, камолига — \r\n“Темурбеклар мактаби” жавобдир саволига.\r\n\r\nИнчунин, ҳар бир зобит, ҳар сипоҳ, ҳар байроқдор, \r\nКечган шонли жанглардан бўлмоғи шарт хабардор.\r\n\r\nМиллат хоки пойларин тавоф қилса арзийди, \r\n“Зафарнома” яратмиш мавлоно Али Яздий.\r\n\r\nДавлати пойдорликнинг мангу гувоҳномаси — \r\n“Зафарнома” эмас, бу — буюк халқ шоҳномаси.\r\n\r\nЎпгил, эй Европа сен, бармоқ, узукларидан, \r\nҲануз сабоқ олгайсан “Темур тузуклари”дан.\r\n\r\nБутун олам аҳлига ҳарбий номамдир менинг, \r\nЖангномам, курашномам — “Бобурнома”мдир менинг.\r\n\r\nВатан — жон ва тандадир, жон Ватан — жон ва тандир, \r\nВатанпарвар инсонлар жон чекиб, жон тиккандир.\r\n\r\n“Иёлу Ватан узра то жони бор, — деб айтган, \r\nКиши ҳарб этар токи имкони бор”, деб айтган,\r\n\r\n\r\nНавоий бобомиздан тимсол келтирсам агар, \r\nНеча минг кўнгилларни уйғотмоғи муқаррар.\r\n\r\nҲар шоир, ҳар аскарга қатъият, шиддат керак, \r\nАзму шижоат керак, илму маърифат керак.\r\n\r\nБунда ҳар он асқотар ақлу фаҳму фаросат, \r\nДунёвий билимлар ҳам матонат ва садоқат.\r\n\r\nБу қандай дилбар диёр, дил диёр, дилдор диёр, \r\nАскарлари ҳам бедор, шоирлари ҳам бедор.\r\nСирожиддин САЙЙИД, Олий Мажлис Сенати аъзоси, Ўзбекистон халқ шоири', 'https/', 'uploads/images/img_67cfd78be195c.png', 'uploads/files/file_67cfd78be1b88.docx', 1, '2025-03-11 06:26:17', 'Доклад', '0');

-- --------------------------------------------------------

--
-- Структура таблицы `text_checks`
--

CREATE TABLE `text_checks` (
  `id` int NOT NULL,
  `author` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `check_time` datetime DEFAULT CURRENT_TIMESTAMP,
  `similarity_percentage` decimal(5,2) NOT NULL,
  `checked_by` varchar(255) NOT NULL DEFAULT 'Неизвестный'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `text_checks`
--

INSERT INTO `text_checks` (`id`, `author`, `text`, `check_time`, `similarity_percentage`, `checked_by`) VALUES
(1, 'Gaybullayev Ravshan', 'Граница государства — это линия, которая отделяет территорию одного государства от территории другого или от международных вод и воздушного пространства. Она имеет важное политическое, юридическое, экономическое и стратегическое значение для каждого государства, определяя его территориальные права и обязательства, а также обеспечивая защиту от внешних угроз.\r\nОсновные аспекты государственной границы:\r\n\r\n    Юридическое значение: Государственная граница является признанным международным правом инструментом для разграничения властных территорий. Она определяет, какие земли, воды и воздушное пространство принадлежат государству, а также регулирует права и обязанности, связанные с перемещением людей, товаров и информации через эту границу.\r\n\r\n    Политическое значение: Граница служит символом суверенитета государства. Она отображает независимость государства от других стран, а также ограничивает внешнее вмешательство в дела этого государства. Конфликты вокруг границ могут привести к территориальным спорам и даже войнам, если государства не приходят к соглашению о её демаркации.\r\n\r\n    Экономическое значение: Граница часто влияет на торговые и экономические отношения между странами. Местоположение и характер границы могут способствовать или затруднять развитие транзитной торговли, миграции рабочей силы и ресурсов. Например, определение исключительных экономических зон на море или территории с важными природными ресурсами часто становится предметом переговоров и соглашений между странами.\r\n\r\n    Безопасностное значение: Граница служит барьером для защиты территории государства от внешних угроз, таких как военные агрессии, незаконная миграция и контрабанда. Для защиты границы используются пограничные войска, различные системы контроля и фортификационные сооружения.\r\n\r\n    Культурное и социальное значение: Государственные границы могут влиять на культурные и этнические связи между народами, проживающими по обе стороны. Исторически, многие народности и этнические группы оказались разделены границами, что иногда приводит к культурным и социальным напряжениям.\r\n\r\n    Границы в международных отношениях: Взаимодействие государств по вопросам государственных границ регламентируется международными договорами, соглашениями и обычаями. Такие вопросы, как делимитация, демаркация и охрана границ, решаются через двусторонние или многосторонние переговоры, а также через международные суды.\r\n\r\nРазновидности государственных границ:\r\n\r\n    Сухопутные границы: отделяют государства по суше, часто проходят через реки, горные цепи или лесные массивы.\r\n    Морские границы: разделяют государства по водным просторам, включая территориальные воды и экономические зоны.\r\n    Воздушные границы: ограничивают воздушное пространство государства, что имеет стратегическое значение для авиации и военных операций.\r\n    Границы водного раздела: определяют права на водные ресурсы (реки, озера и т. д.), которые могут быть общими для нескольких государств.\r\n\r\nТаким образом, государственная граница играет ключевую роль в регулировании территориальных, политических, экономических и социально-культурных аспектов взаимодействия между государствами.', '2025-01-22 18:23:23', '100.00', 'Неизвестный'),
(2, 'Гайбуллаев Равшан', 'название', '2025-01-30 12:01:32', '100.00', 'Неизвестный'),
(3, 'Неизвестный автор', 'Граница государства — это линия, которая отделяет', '2025-03-07 01:35:42', '10.30', 'Неизвестный'),
(4, 'Неизвестный автор', 'Граница государства — это линия, которая отделяет ИЧКИ ХИЗМАТНИ ТАШКИЛЛАШТИРИШ ВА ОЛИБ БОРИШ БЎЛИМИ', '2025-03-07 01:36:09', '19.25', 'Неизвестный'),
(5, 'Неизвестный автор', 'Граница государства — это линия, которая отделяет ИЧКИ ХИЗМАТНИ ТАШКИЛЛАШТИРИШ ВА ОЛИБ БОРИШ БЎЛИМИ', '2025-03-07 01:36:45', '64.55', 'Неизвестный'),
(6, 'Неизвестный автор', 'Граница государства — это линия, которая отделяет ИЧКИ ХИЗМАТНИ ТАШКИЛЛАШТИРИШ ВА ОЛИБ БОРИШ БЎЛИМИ', '2025-03-07 01:39:35', '100.00', 'Неизвестный'),
(7, 'Неизвестный автор', 'Граница государства — это линия, которая отделяет ИЧКИ ХИЗМАТНИ ТАШКИЛЛАШТИРИШ ВА ОЛИБ БОРИШ БЎЛИМИ', '2025-03-07 01:42:26', '100.00', 'Неизвестный'),
(8, 'Неизвестный автор', 'ИЧКИ ХИЗМАТНИ ТАШКИЛЛАШТИРИШ ВА ОЛИБ БОРИШ БЎЛИМИ Граница государства — это линия, которая отдел Текст книги', '2025-03-07 01:55:10', '80.18', 'Неизвестный');

-- --------------------------------------------------------

--
-- Структура таблицы `text_checks_single`
--

CREATE TABLE `text_checks_single` (
  `id` int NOT NULL,
  `author` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `check_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `text_checks_single`
--

INSERT INTO `text_checks_single` (`id`, `author`, `text`) VALUES
(1, 'Gaybullayev Ravshan', 'АРМИЯ ВА ТАРБИЯ Янги Ўзбекистоннинг миллий армиясида Шоирлар ҳам сафдошдир таълим-тарбиясида. Яъни ҳар би');

-- --------------------------------------------------------

--
-- Структура таблицы `text_check_results`
--

CREATE TABLE `text_check_results` (
  `id` int NOT NULL,
  `input_text` text NOT NULL,
  `uniqueness` float NOT NULL,
  `checked_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `matches` json NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', 'admin_password', 'admin'),
(2, 'user1', 'user1_password', 'user'),
(3, 'user2', 'user2_password', 'user');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `books_security`
--
ALTER TABLE `books_security`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `text_checks`
--
ALTER TABLE `text_checks`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `text_checks_single`
--
ALTER TABLE `text_checks_single`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `text_check_results`
--
ALTER TABLE `text_check_results`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `books`
--
ALTER TABLE `books`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `books_security`
--
ALTER TABLE `books_security`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `text_checks`
--
ALTER TABLE `text_checks`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `text_check_results`
--
ALTER TABLE `text_check_results`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `books_security`
--
ALTER TABLE `books_security`
  ADD CONSTRAINT `books_security_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
