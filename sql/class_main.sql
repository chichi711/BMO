-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- 主機： localhost
-- 產生時間： 2021 年 01 月 30 日 21:15
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
-- 資料表結構 `class_main`
--

CREATE TABLE `class_main` (
  `main_id` int(2) NOT NULL,
  `main_sort` int(2) NOT NULL,
  `main_name` varchar(100) NOT NULL,
  `main_link` varchar(200) NOT NULL DEFAULT '#'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `class_main`
--

INSERT INTO `class_main` (`main_id`, `main_sort`, `main_name`, `main_link`) VALUES
(1, 0, '中文書', '#'),
(2, 1, '外文書', '#'),
(3, 2, '雜誌', '#'),
(4, 3, 'MOOK', '#');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `class_main`
--
ALTER TABLE `class_main`
  ADD PRIMARY KEY (`main_id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `class_main`
--
ALTER TABLE `class_main`
  MODIFY `main_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
