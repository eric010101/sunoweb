-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- 主機： localhost:3306
-- 產生時間： 2024 年 06 月 15 日 12:39
-- 伺服器版本： 8.0.37-0ubuntu0.24.04.1
-- PHP 版本： 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `music_app`
--

-- --------------------------------------------------------

--
-- 資料表結構 `songs`
--

CREATE TABLE `songs` (
  `id` varchar(36) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `image_url` text,
  `lyric` text,
  `audio_url` text,
  `video_url` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `model_name` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `gpt_description_prompt` text,
  `prompt` text,
  `type` varchar(50) DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `error_message` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `suno_accounts`
--

CREATE TABLE `suno_accounts` (
  `id` int NOT NULL,
  `credits_left` int DEFAULT NULL,
  `period` varchar(255) DEFAULT NULL,
  `monthly_limit` int DEFAULT NULL,
  `monthly_usage` int DEFAULT NULL,
  `suno_id` varchar(255) DEFAULT NULL,
  `suno_password` varchar(255) DEFAULT NULL,
  `suno_cookie` text,
  `create_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `activate_status` tinyint(1) DEFAULT NULL,
  `earn_credit` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `type` varchar(255) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 傾印資料表的資料 `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `created_at`, `type`, `active`) VALUES
(1, '0986576086', '$2y$10$FTKE/92Ai8ysGQm69rhVPuWdjQRjXTscxiVtton3HpcNVOwyIJVmC', 'pengyauwang@hotmail.com', '2024-06-14 10:49:10', NULL, NULL);

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `songs`
--
ALTER TABLE `songs`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `suno_accounts`
--
ALTER TABLE `suno_accounts`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `suno_accounts`
--
ALTER TABLE `suno_accounts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
