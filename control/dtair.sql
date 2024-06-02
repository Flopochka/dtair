-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 02 2024 г., 13:57
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
(3, 1, 3),
(4, 2, 1),
(5, 2, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `favorite_places`
--

CREATE TABLE `favorite_places` (
  `id` int NOT NULL,
  `place_id` int NOT NULL,
  `user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `favorite_places`
--

INSERT INTO `favorite_places` (`id`, `place_id`, `user_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 6, 1),
(5, 7, 1),
(6, 8, 1),
(7, 11, 1),
(8, 12, 1),
(9, 13, 1),
(10, 16, 1),
(11, 17, 1),
(12, 18, 1),
(13, 21, 1),
(14, 22, 1),
(15, 23, 1),
(16, 26, 1),
(17, 27, 1),
(18, 28, 1),
(19, 11, 2),
(20, 12, 2);

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
(1, 1, 'Шиваджи Парк', 'Исторический парк в центре города.', 'img/places/Шиваджи Парк.jpg'),
(2, 1, 'Музей Природы и Истории Бомбея', 'Интересный музей, посвященный истории и культуре города.', 'img/places/Музей Природы и Истории Бомбея.jpg'),
(3, 1, 'Музей Ганди', 'Музей, посвященный жизни и делам Махатмы Ганди.', 'img/places/Музей Ганди.jpg'),
(4, 1, 'Буддийский храм Трёх Драгоценностей', 'Знаменитый буддийский храм в Мумбаи.', 'img/places/Буддийский храм Трёх Драгоценностей.jpg'),
(5, 1, 'Электрический поезд Мумбаи', 'Популярный способ передвижения по городу.', 'img/places/Электрический поезд Мумбаи.jpg'),
(6, 2, 'Парк Куббон', 'Один из самых больших парков в городе.', 'img/places/Парк Куббон.jpg'),
(7, 2, 'Лалбаг Крепость', 'Историческая крепость, построенная в 16 веке.', 'img/places/Лалбаг Крепость.jpg'),
(8, 2, 'Виджая Лаксми', 'Знаменитый храм Виджая Лаксми в Бангалоре.', 'img/places/Виджая Лаксми.jpg'),
(9, 2, 'Башня Бангалора', 'Высокое здание с панорамным видом на город.', 'img/places/Башня Бангалора.jpg'),
(10, 2, 'Фольклорный музей Карнатаки', 'Музей, демонстрирующий традиционные культурные артефакты.', 'img/places/Фольклорный музей Карнатаки.jpg'),
(11, 3, 'Парк Марина', 'Один из самых больших пляжей в мире.', 'img/places/Парк Марина.jpg'),
(12, 3, 'Красная Крепость', 'Историческая крепость, стратегически важное сооружение.', 'img/places/Красная Крепость.jpg'),
(13, 3, 'Храм Капалишвар', 'Древний храм, посвященный богу Шиве.', 'img/places/Храм Капалишвар.jpg'),
(14, 3, 'Галерея Шудха', 'Искусство и культура в одном месте.', 'img/places/Галерея Шудха.jpg'),
(15, 3, 'Национальный парк Гандхи', 'Заповедник, который является домом для различных видов флоры и фауны.', 'img/places/Национальный парк Гандхи.jpg'),
(16, 4, 'Парк Экоспера', 'Популярный парк для отдыха и релаксации.', 'img/places/Парк Экоспера.jpg'),
(17, 4, 'Храм Кали', 'Исторический храм, посвященный богине Кали.', 'img/places/Храм Кали.jpg'),
(18, 4, 'Парк Нефтяных Работников', 'Зеленая зона для прогулок и спорта.', 'img/places/Парк Нефтяных Работников.jpg'),
(19, 4, 'Кампани Парк', 'Парк с многочисленными аттракциями и развлечениями.', 'img/places/Кампани Парк.jpg'),
(20, 4, 'Музей Индии', 'Музей, демонстрирующий богатое культурное наследие Индии.', 'img/places/Кампани Парк.jpg'),
(21, 5, 'Красный Форт', 'Знаменитый красный каменный форт.', 'img/places/Кампани Парк.jpg'),
(22, 5, 'Индийский ворота', 'Архитектурный памятник времен Британского Разделения Индии.', 'img/places/Индийский ворота.jpg'),
(23, 5, 'Кутуб-Минар', 'Древний минарет, построенный в период Делийского султаната.', 'img/places/Кутуб-Минар.jpg'),
(24, 5, 'Ганди-Смрити', 'Мемориал, посвященный Махатме Ганди.', 'img/places/Ганди-Смрити.jpg'),
(25, 5, 'Бангла Сахиб', 'Священный сикхский храм.', 'img/places/Бангла Сахиб.jpg'),
(26, 6, 'Харджонг', 'Старинная резиденция Низамов.', 'img/places/Харджонг.jpg'),
(27, 6, 'Рамоуд', 'Дворец и здание правительства.', 'img/places/Рамоуд.jpg'),
(28, 6, 'Сторожевой Дом', 'Здание, ранее использовавшееся для военного наблюдения.', 'img/places/Сторожевой Дом.jpg'),
(29, 6, 'Будда-Статуя', 'Огромная статуя Будды в историческом парке.', 'img/places/Будда-Статуя.jpg'),
(30, 6, 'Рамоуд', 'Красивый дворец, открытый для посещения.', 'img/places/Рамоуд.jpg');

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
  `profile_pic` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'img/profile/nopicture.jpg',
  `username` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `reg_date`, `last_seens`, `profile_pic`, `username`) VALUES
(1, 'liker', '', '2024-06-01 08:53:08', '2024-06-01 11:53:08', NULL, NULL),
(2, 'fff', '$2y$10$9IKWjmBS.mm.IjNVnaBNyuVIZj9YfXImhvJqbwqKPp68/XagMDP/G', '2024-06-02 09:38:20', '2024-06-02 12:38:23', 'img/profile/nopicture.jpg', 'fff');

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `favorite_places`
--
ALTER TABLE `favorite_places`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
