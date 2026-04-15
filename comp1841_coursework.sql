-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 15, 2026 at 04:43 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `comp1841_coursework`
--

-- --------------------------------------------------------

--
-- Table structure for table `author`
--

CREATE TABLE `author` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `is_admin` tinyint(1) DEFAULT 0,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `author`
--

INSERT INTO `author` (`id`, `name`, `email`, `is_admin`, `password`) VALUES
(1, 'Nguyen Van A', 'a@greenwich.edu.vn', 1, '$2y$10$NQ0LlUtw9UV9JrPvPKlUuOJxgcMDdevX9QQR2.EXdKJCxLRwqtpQC'),
(2, 'Greenwich Coder', 'coder@greenwich.edu.vn', 0, '$2y$10$NQ0LlUtw9UV9JrPvPKlUuOJxgcMDdevX9QQR2.EXdKJCxLRwqtpQC'),
(3, 'Nick Wilde', 'nick.wilde@zootopia.com', 0, '$2y$10$NQ0LlUtw9UV9JrPvPKlUuOJxgcMDdevX9QQR2.EXdKJCxLRwqtpQC'),
(4, 'Judy Hopps', 'judy.hopps@zootopia.com', 0, '$2y$10$NQ0LlUtw9UV9JrPvPKlUuOJxgcMDdevX9QQR2.EXdKJCxLRwqtpQC'),
(6, 'Pixel Artist', 'pixel.art@game.design', 0, '$2y$10$NQ0LlUtw9UV9JrPvPKlUuOJxgcMDdevX9QQR2.EXdKJCxLRwqtpQC'),
(7, 'Phat Dao', 'phatdao@gmail.com', 0, '$2y$10$NQ0LlUtw9UV9JrPvPKlUuOJxgcMDdevX9QQR2.EXdKJCxLRwqtpQC'),
(9, 'phat dao', 'phat@gmail.com', 0, '$2y$10$qMh1gh.e3qxaL6.HCHAYqObB..a2G8sP5NKLrv4ANMOAQbXvu9.z2');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `review_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `comment_text` text NOT NULL,
  `comment_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `review_id`, `author_id`, `comment_text`, `comment_date`) VALUES
(1, 19, 1, 'good', '2026-04-14 21:12:58');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `message_text` text NOT NULL,
  `date_sent` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `author_id`, `message_text`, `date_sent`) VALUES
(1, 2, 'abcxyz', '2026-03-27'),
(2, 9, 'abc', '2026-04-03');

-- --------------------------------------------------------

--
-- Table structure for table `film`
--

CREATE TABLE `film` (
  `id` int(11) NOT NULL,
  `film_name` varchar(255) NOT NULL,
  `publish_date` date DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `film`
--

INSERT INTO `film` (`id`, `film_name`, `publish_date`, `image`) VALUES
(2, 'Zootopia', '2016-03-04', '1775839161_poster_Zootopia.jpg'),
(8, 'Zootopia 2', '2025-11-13', '1775839239_poster_Zootopia_2.jpg'),
(9, 'How to train your dragon', '2025-06-06', '1775839580_poster_How to train your dragon.jpg'),
(10, 'Avenger: Infinity War', '2018-04-23', '1775839790_poster_avenger infinity war.jpg'),
(11, 'Avenger: Endgame', '2019-04-19', '1775839860_poster_avenger endgame.jpg'),
(12, 'Mufasa: The lion king', '2024-12-18', '1775840049_poster_mufasa the lion king.jpg'),
(13, 'Venom: The last dance', '2024-10-23', '1775840141_poster_venom the last dance.jpg'),
(14, 'Demon Slayer: Kimetsu No Yaiba Infinity Castle', '2025-09-12', '1775840433_poster_infinity castle.jpg'),
(15, 'Spider-Man: Across the Spider-Verse', '2023-05-31', '1775840567_poster_accross the spiderverse.jpg'),
(16, 'Deadpool & Wolverine', '2024-07-26', '1776236994_poster_92f1b0cf6d98a46298d2bb75220cb41b.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `review_text` text NOT NULL,
  `review_date` date NOT NULL,
  `author_id` int(11) DEFAULT NULL,
  `film_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `review_text`, `review_date`, `author_id`, `film_id`, `image`) VALUES
(13, 'Ironman is always cool !!', '2026-04-13', 9, 11, '1776060891_mk85_cutscene.jpg'),
(14, 'These 2 are the best teamates ever ', '2026-04-13', 9, 9, '1776061044_hiccup_n_toothless.jpg'),
(15, 'Bring up the next movie right now', '2026-04-13', 2, 14, '1776061323_akaza vs giyuu.jpg'),
(16, 'I\'ve not seen the first part yet but this one is really good', '2026-04-13', 2, 8, '1776064656_carrot pen.jpg'),
(17, 'An incredibly smart movie! Top-notch animation and a very meaningful message.', '2026-04-13', 3, 2, '1776071064_dd030f4b77d222fd81488c76f8ab9ed4.jpg'),
(18, 'I absolutely loved the pacing of this film. It keeps you hooked from start to finish.', '2026-04-13', 4, 2, '1776071269_a659963bb2def9ae8209ff2281b4a2b4.jpg'),
(19, 'A highly deserving sequel. It expands the world perfectly without losing the charm of the first one.', '2026-04-13', 1, 8, '1776071411_download.jpg'),
(21, 'Visually stunning! Every frame looks like a comic book brought to life.', '2026-04-13', 6, 10, NULL),
(22, 'The crossover event of the century. It met all expectations and delivered an unforgettable conclusion.', '2026-04-13', 7, 10, NULL),
(23, 'An emotional rollercoaster. The perfect ending to over a decade of cinematic universe building.', '2026-04-13', 1, 11, '1776071506_2973f931949da6c75f8c912cc4e599fe.jpg'),
(24, 'Incredibly realistic CGI. The film provides great backstories for the characters.', '2026-04-13', 3, 12, '1776071166_a781c4efe1ea42b3c16438912f71bda0.jpg'),
(25, 'The soundtrack alone is worth the watch. A majestic return to the Pride Lands.', '2026-04-13', 4, 12, '1776071354_001a6a5504baa982f1275e3d48e0a213.jpg'),
(27, 'A blast of pure entertainment. Don\'t overthink the plot, just enjoy the fun ride.', '2026-04-13', 6, 13, NULL),
(28, 'The animation studio outdid themselves again. The fight choreographies are absolutely insane!', '2026-04-13', 7, 14, NULL),
(29, 'A masterpiece of modern animation. The blending of different art styles is incredibly diverse and beautiful.', '2026-04-13', 1, 15, '1776071551_6ad2ee78bcde803909f2b6ce52759e79.jpg'),
(30, 'Even better than the first part. The emotional depth and soundtrack reach absolute perfection.', '2026-04-13', 3, 15, '1776071211_fd5a58d6c97d37f0186e0d82cfff8f07.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `review_id` (`review_id`),
  ADD KEY `author_id` (`author_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author_id` (`author_id`);

--
-- Indexes for table `film`
--
ALTER TABLE `film`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_author` (`author_id`),
  ADD KEY `fk_film` (`film_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `author`
--
ALTER TABLE `author`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `film`
--
ALTER TABLE `film`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`review_id`) REFERENCES `reviews` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `author` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD CONSTRAINT `contact_messages_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `author` (`id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `fk_author` FOREIGN KEY (`author_id`) REFERENCES `author` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_film` FOREIGN KEY (`film_id`) REFERENCES `film` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
