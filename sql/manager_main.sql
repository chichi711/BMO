-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- 主機： localhost
-- 產生時間： 2021 年 01 月 30 日 21:17
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
-- 資料表結構 `manager_main`
--

CREATE TABLE `manager_main` (
  `manager_id` varchar(50) NOT NULL,
  `manager_pwd` varchar(50) NOT NULL,
  `manager_name` varchar(50) NOT NULL,
  `level` int(1) NOT NULL DEFAULT 2,
  `last_datetime` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `manager_main`
--

INSERT INTO `manager_main` (`manager_id`, `manager_pwd`, `manager_name`, `level`, `last_datetime`) VALUES
('james', 'wolf0719', 'james', 0, '2021-01-30 19:29:31'),
('qq', 'qq', '小小編', 2, '2021-01-30 16:44:53');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `manager_main`
--
ALTER TABLE `manager_main`
  ADD PRIMARY KEY (`manager_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
