-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 01 2024 г., 19:42
-- Версия сервера: 8.0.30
-- Версия PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `dtair`
--

-- --------------------------------------------------------

--
-- Структура таблицы `destinations`
--

CREATE TABLE `destinations` (
  `id` int NOT NULL,
  `title` text NOT NULL,
  `img` text NOT NULL,
  `price` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `destinations`
--

INSERT INTO `destinations` (`id`, `title`, `img`, `price`) VALUES
(1, 'Mumbai', 'img/destinations/mumbai.png', 1500),
(2, 'Bangalore', 'img/destinations/bangalore.png', 1700),
(3, 'Chennai', 'img/destinations/chennai.png', 1560),
(4, 'Kolkata', 'img/destinations/kolkata.png', 1670),
(5, 'Delhi', 'img/destinations/delhi.png', 1100),
(6, 'Hyderabad', 'img/destinations/hyderad.png', 1234);

-- --------------------------------------------------------

--
-- Структура таблицы `favorite_locations`
--

CREATE TABLE `favorite_locations` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `destination_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `favorite_locations`
--

INSERT INTO `favorite_locations` (`id`, `user_id`, `destination_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `favorite_places`
--

CREATE TABLE `favorite_places` (
  `id` int NOT NULL,
  `place_id` int NOT NULL,
  `user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `flights`
--

CREATE TABLE `flights` (
  `id` int NOT NULL,
  `date` date DEFAULT NULL,
  `airline` varchar(100) DEFAULT NULL,
  `ch_code` varchar(10) DEFAULT NULL,
  `num_code` int DEFAULT NULL,
  `dep_time` time DEFAULT NULL,
  `departure_destination` int DEFAULT NULL,
  `time_taken` varchar(20) DEFAULT NULL,
  `stop` varchar(20) DEFAULT NULL,
  `arr_time` time DEFAULT NULL,
  `arrival_destination` int DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `Type` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `history`
--

CREATE TABLE `history` (
  `id` int NOT NULL,
  `userid` int NOT NULL,
  `query` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `places`
--

CREATE TABLE `places` (
  `id` int NOT NULL,
  `destination_id` int NOT NULL,
  `title` text NOT NULL,
  `subtitle` text NOT NULL,
  `img` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `places`
--

INSERT INTO `places` (`id`, `destination_id`, `title`, `subtitle`, `img`) VALUES
(1, 1, 'Шиваджи Парк', 'Исторический парк в центре города.', 'shivaji_park.jpg'),
(2, 1, 'Музей Природы и Истории Бомбея', 'Интересный музей, посвященный истории и культуре города.', 'bombay_natural_history_museum.jpg'),
(3, 1, 'Музей Ганди', 'Музей, посвященный жизни и делам Махатмы Ганди.', 'gandhi_museum.jpg'),
(4, 1, 'Буддийский храм Трёх Драгоценностей', 'Знаменитый буддийский храм в Мумбаи.', 'buddhist_temple.jpg'),
(5, 1, 'Электрический поезд Мумбаи', 'Популярный способ передвижения по городу.', 'mumbai_local_train.jpg'),
(6, 2, 'Парк Куббон', 'Один из самых больших парков в городе.', 'cubbon_park.jpg'),
(7, 2, 'Лалбаг Крепость', 'Историческая крепость, построенная в 16 веке.', 'lalbagh_fort.jpg'),
(8, 2, 'Виджая Лаксми', 'Знаменитый храм Виджая Лаксми в Бангалоре.', 'vidya_lakshmi_temple.jpg'),
(9, 2, 'Башня Бангалора', 'Высокое здание с панорамным видом на город.', 'bangalore_tower.jpg'),
(10, 2, 'Фольклорный музей Карнатаки', 'Музей, демонстрирующий традиционные культурные артефакты.', 'karnataka_folk_museum.jpg'),
(11, 3, 'Парк Марина', 'Один из самых больших пляжей в мире.', 'marina_beach.jpg'),
(12, 3, 'Красная Крепость', 'Историческая крепость, стратегически важное сооружение.', 'red_fort.jpg'),
(13, 3, 'Храм Капалишвар', 'Древний храм, посвященный богу Шиве.', 'kapaleeshwar_temple.jpg'),
(14, 3, 'Галерея Шудха', 'Искусство и культура в одном месте.', 'sudha_gallery.jpg'),
(15, 3, 'Национальный парк Гандхи', 'Заповедник, который является домом для различных видов флоры и фауны.', 'gandhi_national_park.jpg'),
(16, 4, 'Парк Экоспера', 'Популярный парк для отдыха и релаксации.', 'ecospark.jpg'),
(17, 4, 'Храм Кали', 'Исторический храм, посвященный богине Кали.', 'kali_temple.jpg'),
(18, 4, 'Парк Нефтяных Работников', 'Зеленая зона для прогулок и спорта.', 'oil_workers_park.jpg'),
(19, 4, 'Кампани Парк', 'Парк с многочисленными аттракциями и развлечениями.', 'company_park.jpg'),
(20, 4, 'Музей Индии', 'Музей, демонстрирующий богатое культурное наследие Индии.', 'india_museum.jpg'),
(21, 5, 'Красный Форт', 'Знаменитый красный каменный форт.', 'red_fort.jpg'),
(22, 5, 'Индийский ворота', 'Архитектурный памятник времен Британского Разделения Индии.', 'india_gate.jpg'),
(23, 5, 'Кутуб-Минар', 'Древний минарет, построенный в период Делийского султаната.', 'qutub_minar.jpg'),
(24, 5, 'Ганди-Смрити', 'Мемориал, посвященный Махатме Ганди.', 'gandhi_smriti.jpg'),
(25, 5, 'Бангла Сахиб', 'Священный сикхский храм.', 'bangla_sahib.jpg'),
(26, 6, 'Харджонг', 'Старинная резиденция Низамов.', 'chowmahalla_palace.jpg'),
(27, 6, 'Рамоуд', 'Дворец и здание правительства.', 'ramoji_film_city.jpg'),
(28, 6, 'Сторожевой Дом', 'Здание, ранее использовавшееся для военного наблюдения.', 'watch_tower.jpg'),
(29, 6, 'Будда-Статуя', 'Огромная статуя Будды в историческом парке.', 'buddha_statue.jpg'),
(30, 6, 'Рамоуд', 'Красивый дворец, открытый для посещения.', 'ramoji_film_city2.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `login` text NOT NULL,
  `password` text NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_seens` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `profile_pic` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `username` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `reg_date`, `last_seens`, `profile_pic`, `username`) VALUES
(1, 'liker', '', '2024-06-01 08:53:08', '2024-06-01 11:53:08', NULL, NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `destinations`
--
ALTER TABLE `destinations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `favorite_locations`
--
ALTER TABLE `favorite_locations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `destination_id` (`destination_id`);

--
-- Индексы таблицы `favorite_places`
--
ALTER TABLE `favorite_places`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `flights`
--
ALTER TABLE `flights`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `places`
--
ALTER TABLE `places`
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
-- AUTO_INCREMENT для таблицы `destinations`
--
ALTER TABLE `destinations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `favorite_locations`
--
ALTER TABLE `favorite_locations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `favorite_places`
--
ALTER TABLE `favorite_places`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `flights`
--
ALTER TABLE `flights`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `history`
--
ALTER TABLE `history`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `places`
--
ALTER TABLE `places`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `favorite_locations`
--
ALTER TABLE `favorite_locations`
  ADD CONSTRAINT `favorite_locations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `favorite_locations_ibfk_2` FOREIGN KEY (`destination_id`) REFERENCES `destinations` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
