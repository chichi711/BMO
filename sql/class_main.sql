-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- 主機： localhost
-- 產生時間： 2021 年 02 月 07 日 20:13
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
  `menu_id` varchar(20) NOT NULL,
  `main_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `class_main`
--

INSERT INTO `class_main` (`main_id`, `main_sort`, `menu_id`, `main_name`) VALUES
(1, 0, 'books', '文學'),
(2, 10, 'books', '財經企管'),
(3, 11, 'books', '生活風格'),
(4, 12, 'books', '飲食料理'),
(5, 13, 'books', '心理勵志'),
(6, 14, 'books', '醫療保健'),
(7, 16, 'books', '旅遊'),
(8, 17, 'books', '宗教命理'),
(9, 20, 'books', '電腦資訊'),
(10, 0, 'books', '時尚美妝'),
(11, 0, 'books', '影視流行'),
(12, 9, 'books', '教育／親子教養'),
(13, 0, 'books', '童書／青少年文學'),
(14, 0, 'books', '羅曼史'),
(15, 0, 'books', '輕小說'),
(16, 0, 'books', '漫畫'),
(17, 0, 'books', '語言／字辭典'),
(18, 0, 'books', ' 藝術設計'),
(19, 0, 'books', '自然科普'),
(20, 0, 'books', '人文歷史'),
(21, 0, 'books', '社會哲思'),
(22, 0, 'books', '考試書／政府出版品'),
(23, 0, 'books', '參考書'),
(25, 0, 'fbooks', '文學'),
(26, 1, 'fbooks', '童書/青少年讀物'),
(27, 0, 'magazine', '時尚美妝');

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
  MODIFY `main_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
