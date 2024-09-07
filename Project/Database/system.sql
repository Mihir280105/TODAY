-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 05, 2024 at 10:50 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `system`
--

-- --------------------------------------------------------

--
-- Table structure for table `loginsystem`
--

CREATE TABLE `loginsystem` (
  `id` int NOT NULL,
  `profile_picture` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `unm` varchar(50) NOT NULL,
  `pwd` varchar(50) NOT NULL,
  `cpwd` varchar(50) NOT NULL,
  `no` varchar(10) NOT NULL,
  `age` varchar(3) NOT NULL,
  `rd1` varchar(10) NOT NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `loginsystem`
--

INSERT INTO `loginsystem` (`id`, `profile_picture`, `unm`, `pwd`, `cpwd`, `no`, `age`, `rd1`, `role`) VALUES
(1, 'default-profile-pic.png', 'mihir1223', '1', '1', '9033463475', '10', 'Male', ''),
(2, '408e3f85ca209947e9dfcbfc17a8e214.jpeg', 'mihir', '1', '1', '1234567890', '20', 'Male', ''),
(4, 'b7ef00a43fe42ccf3140d78f3e48ad33.jpg', 'jay', 'j', 'j', '9999999999', '20', 'Male', 'admin'),
(7, 'c06f71f52673012b482cb8a7b64e4492.jpg', 'urvashi tank', 'u', 'u', '0000000000', '20', 'Female', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_about`
--

CREATE TABLE `user_about` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_about`
--

INSERT INTO `user_about` (`id`, `user_id`, `content`, `created_at`) VALUES
(39, 2, 'hello guys', '2024-09-01 06:16:02');

-- --------------------------------------------------------

--
-- Table structure for table `user_posts`
--

CREATE TABLE `user_posts` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_posts`
--

INSERT INTO `user_posts` (`id`, `user_id`, `file_path`, `created_at`) VALUES
(13, 1, 'uploads/aadatien_-20230415-0001.mp4', '2024-08-18 13:02:06'),
(14, 1, 'uploads/bharvadan._.91_official-20230314-0001.mp4', '2024-08-18 13:02:26'),
(15, 1, 'uploads/1709224052652.jpg', '2024-08-18 13:02:33'),
(16, 1, 'uploads/87fd2e99ca567b2a5a923b23be362963.jpg', '2024-08-18 13:06:04'),
(17, 1, 'uploads/Cinderella Wallpaper.jpg', '2024-08-18 13:23:02'),
(18, 1, 'uploads/f94840f440a19c057828b799e1786e46.jpg', '2024-08-18 13:23:12'),
(19, 1, 'uploads/f94840f440a19c057828b799e1786e46.jpg', '2024-08-18 13:23:51'),
(20, 1, 'uploads/5be0dc17-76d9-4da5-aba7-2e5003b4d4d6.jpeg', '2024-08-18 13:27:35'),
(21, 1, 'uploads/3500e212-65cd-4ca4-94d6-404c2ea3df8c.jpeg', '2024-08-18 13:30:06'),
(22, 2, 'uploads/aadatien_-20230415-0001.mp4', '2024-08-19 14:34:17'),
(24, 4, 'uploads/Snapchat-553390133.jpg', '2024-08-20 13:30:53'),
(31, 2, 'uploads/Snapchat-553390133.jpg', '2024-08-24 18:06:46'),
(32, 7, 'uploads/Forever love .jpg', '2024-08-27 18:45:50');

-- --------------------------------------------------------

--
-- Table structure for table `user_queries`
--

CREATE TABLE `user_queries` (
  `id` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `query` varchar(255) NOT NULL,
  `about` text NOT NULL,
  `concern` text NOT NULL,
  `submitted_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_queries`
--

INSERT INTO `user_queries` (`id`, `email`, `query`, `about`, `concern`, `submitted_at`) VALUES
(18, 'nakummihir280105@gmail.com', 'Account Issues', 'hii', 'unable to access this account in my mobile', '2024-08-17 09:30:31'),
(19, 'urvashi@gmail.com', 'Privacy and Security', 'hii', 'hillo', '2024-08-27 18:47:14'),
(20, 'siddhraj.nakum777@gmail.com', 'Privacy and Security', 'i am single find a girlfriend for me in this platform', 'abcdefghijklmnopqrstuvwxyz', '2024-09-01 10:07:34'),
(21, 'jay@gmail.com', 'Privacy and Security', 'qfweqf', 'fcewa', '2024-09-05 10:36:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `loginsystem`
--
ALTER TABLE `loginsystem`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_about`
--
ALTER TABLE `user_about`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_posts`
--
ALTER TABLE `user_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_queries`
--
ALTER TABLE `user_queries`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `loginsystem`
--
ALTER TABLE `loginsystem`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user_about`
--
ALTER TABLE `user_about`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `user_posts`
--
ALTER TABLE `user_posts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `user_queries`
--
ALTER TABLE `user_queries`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_about`
--
ALTER TABLE `user_about`
  ADD CONSTRAINT `user_about_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `loginsystem` (`id`);

--
-- Constraints for table `user_posts`
--
ALTER TABLE `user_posts`
  ADD CONSTRAINT `user_posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `loginsystem` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
