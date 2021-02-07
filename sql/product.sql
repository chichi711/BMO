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
-- 資料表結構 `product`
--

CREATE TABLE `product` (
  `product_id` varchar(20) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `main_img` text NOT NULL,
  `slide_imgs` text DEFAULT NULL,
  `price` int(5) NOT NULL,
  `author` varchar(20) NOT NULL COMMENT '作者',
  `publisher` varchar(20) NOT NULL COMMENT '出版社',
  `publication_date` varchar(20) NOT NULL COMMENT '出版日期',
  `language` varchar(20) NOT NULL,
  `stock` int(10) NOT NULL COMMENT '庫存數量',
  `menu_id` varchar(20) NOT NULL,
  `main_id` int(3) NOT NULL,
  `sub_id` int(5) NOT NULL,
  `status` int(2) NOT NULL,
  `tag` varchar(200) DEFAULT NULL,
  `share` int(5) DEFAULT NULL COMMENT '分享次數',
  `discount_id` int(5) DEFAULT NULL COMMENT '折扣編號'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `main_img`, `slide_imgs`, `price`, `author`, `publisher`, `publication_date`, `language`, `stock`, `menu_id`, `main_id`, `sub_id`, `status`, `tag`, `share`, `discount_id`) VALUES
('P-1612699381', 'BMO', '/upload/product/601fd72015ae3.jpg', '/upload/product/601fd72e630ab.jpg, /upload/product/601fd736997a6.jpg, ', 12, '作者', '作者出版社', '2021-02-03', '語言', 25, 'books', 1, 1, 1, NULL, NULL, NULL);

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
