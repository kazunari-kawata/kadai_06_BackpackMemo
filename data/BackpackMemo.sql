-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost
-- 生成日時: 2025 年 7 月 10 日 15:27
-- サーバのバージョン： 10.4.28-MariaDB
-- PHP のバージョン: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `BackpackMemo`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `travelRecord`
--

CREATE TABLE `travelRecord` (
  `id` int(11) NOT NULL,
  `place` varchar(128) NOT NULL,
  `date` date NOT NULL,
  `memo` text NOT NULL,
  `latitude` int(11) NOT NULL,
  `longitude` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- テーブルのデータのダンプ `travelRecord`
--

INSERT INTO `travelRecord` (`id`, `place`, `date`, `memo`, `latitude`, `longitude`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'ワシントン', '2025-07-04', '独立記念日', 39, -77, '2025-07-10 20:45:35', '2025-07-10 22:12:24', NULL),
(5, 'グリニッジ展望台', '2025-07-17', 'fdsaf', 51, 0, '2025-07-10 21:04:28', '2025-07-10 21:04:28', NULL),
(7, 'セレッソフローラ', '2025-07-18', '家', 34, 130, '2025-07-10 21:05:52', '2025-07-10 21:05:52', NULL),
(8, 'ジーズアカデミー福岡', '2025-07-17', '勉強', 34, 130, '2025-07-10 21:06:37', '2025-07-10 21:06:37', NULL);

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `travelRecord`
--
ALTER TABLE `travelRecord`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `travelRecord`
--
ALTER TABLE `travelRecord`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
