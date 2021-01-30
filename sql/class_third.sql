-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- 主機： localhost
-- 產生時間： 2021 年 01 月 30 日 22:36
-- 伺服器版本： 10.4.17-MariaDB
-- PHP 版本： 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `bmo`
--

-- --------------------------------------------------------

--
-- 資料表結構 `class_third`
--

CREATE TABLE `class_third` (
  `third_id` int(3) NOT NULL,
  `third_sort` int(2) NOT NULL,
  `sub_id` int(2) NOT NULL,
  `third_name` varchar(100) NOT NULL,
  `third_link` varchar(200) NOT NULL DEFAULT '#'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `class_third`
--

INSERT INTO `class_third` (`third_id`, `third_sort`, `sub_id`, `third_name`, `third_link`) VALUES
(1, 0, 1, '現代華文創作', '#'),
(2, 1, 1, '現代詩', '#'),
(3, 2, 1, '旅行飲食／自然文學', '#'),
(4, 3, 1, '現代翻譯文學', '#'),
(5, 4, 1, '推理／犯罪小說', '#'),
(6, 5, 1, '恐怖／驚悚小說', '#'),
(7, 6, 1, '奇幻／科幻小說', '#'),
(8, 7, 1, '歷史／武俠小說', '#'),
(9, 8, 1, '愛情小說', '#');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `class_third`
--
ALTER TABLE `class_third`
  ADD PRIMARY KEY (`third_id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `class_third`
--
ALTER TABLE `class_third`
  MODIFY `third_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
