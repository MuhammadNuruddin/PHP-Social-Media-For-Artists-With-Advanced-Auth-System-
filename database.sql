-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 17, 2021 at 01:32 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ripple`
--

-- --------------------------------------------------------

--
-- Table structure for table `additional_user_info`
--

CREATE TABLE `additional_user_info` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `bio` text DEFAULT NULL,
  `facebook` varchar(250) DEFAULT NULL,
  `instagram` varchar(200) DEFAULT NULL,
  `twitter` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `additional_user_info`
--

INSERT INTO `additional_user_info` (`id`, `user_id`, `bio`, `facebook`, `instagram`, `twitter`) VALUES
(6, 8, 'akinyemi saheed wale omo akin', NULL, NULL, NULL),
(26, 5, NULL, NULL, 'ziauddin', 'zeeya');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `work_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `guest` varchar(10) NOT NULL,
  `guest_name` varchar(250) DEFAULT NULL,
  `commented_on` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `work_id`, `comment`, `guest`, `guest_name`, `commented_on`) VALUES
(1, 5, 36, 'amazing stuff', 'No', NULL, '2021-03-16 12:56:43'),
(2, 5, 30, 'omo, this one mad gan', 'No', NULL, '2021-03-16 12:57:46');

-- --------------------------------------------------------

--
-- Table structure for table `follow`
--

CREATE TABLE `follow` (
  `id` int(20) NOT NULL,
  `follower_id` int(11) NOT NULL,
  `follows_user_id` int(11) NOT NULL,
  `followed_on` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `follow`
--

INSERT INTO `follow` (`id`, `follower_id`, `follows_user_id`, `followed_on`) VALUES
(45, 7, 10, '2021-03-16 08:49:20'),
(46, 10, 5, '2021-03-16 08:55:16'),
(47, 7, 5, '2021-03-16 08:55:59'),
(48, 11, 5, '2021-03-16 08:56:39'),
(49, 8, 10, '2021-03-16 09:06:41'),
(50, 8, 5, '2021-03-16 09:07:00'),
(51, 8, 7, '2021-03-16 09:07:16'),
(59, 5, 10, '2021-03-16 13:05:10');

-- --------------------------------------------------------

--
-- Table structure for table `reaction`
--

CREATE TABLE `reaction` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `work_id` int(11) NOT NULL,
  `reaction` varchar(10) NOT NULL DEFAULT 'like'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reaction`
--

INSERT INTO `reaction` (`id`, `user_id`, `work_id`, `reaction`) VALUES
(1, 5, 25, 'like'),
(2, 6, 25, 'like'),
(3, 6, 26, 'like'),
(4, 6, 32, 'like'),
(5, 6, 30, 'like'),
(7, 5, 20, 'like'),
(8, 6, 33, 'like'),
(9, 6, 23, 'like'),
(37, 8, 30, 'like'),
(38, 8, 31, 'like'),
(39, 8, 21, 'like'),
(40, 8, 22, 'like'),
(41, 8, 23, 'like'),
(42, 8, 25, 'like'),
(43, 5, 32, 'like'),
(44, 5, 21, 'like'),
(45, 5, 22, 'like'),
(47, 5, 30, 'like'),
(48, 7, 30, 'like'),
(49, 7, 31, 'like'),
(50, 7, 22, 'like'),
(52, 7, 21, 'like'),
(54, 7, 34, 'like'),
(57, 7, 25, 'like'),
(58, 9, 31, 'like'),
(59, 9, 30, 'like'),
(60, 10, 26, 'like'),
(61, 10, 25, 'like'),
(62, 5, 35, 'like'),
(63, 5, 34, 'like'),
(64, 11, 30, 'like'),
(65, 11, 35, 'like'),
(66, 5, 31, 'like'),
(67, 5, 36, 'like'),
(68, 8, 36, 'like'),
(69, 8, 34, 'like'),
(70, 10, 38, 'like');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `salt` varchar(250) NOT NULL,
  `email` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `gender` varchar(200) NOT NULL,
  `type` int(10) NOT NULL,
  `avatar` varchar(200) DEFAULT NULL,
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_on` datetime DEFAULT NULL,
  `token` varchar(200) DEFAULT NULL,
  `token_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `salt`, `email`, `phone`, `gender`, `type`, `avatar`, `created_on`, `updated_on`, `token`, `token_expiry`) VALUES
(5, 'nuruddin', '3f550ee02c6cc3dff5a1b1db98e303d5e7fe96e520f0e26db35b9ab4d4de601e', '2059295e854b5143b687e8240fb66f76', 'nuru@email.com', '07089658965', 'male', 1, 'profile_image/img-603b99a415d668.59534397.jpg', '2021-02-22 17:34:58', NULL, NULL, NULL),
(6, 'sanusi', '0d39add41fee3e0e1753de9e948d19ce205b2b8ac21b162b61aa7bf7c6152a6d', '156c0be91b92afc9814009dc883012be', 'sanusi@email.com', '587454', 'male', 1, 'profile_image/img-6033e26585d987.01967026.jpeg', '2021-02-22 17:41:40', NULL, NULL, NULL),
(7, 'ziauddin', '8ffab65d9c86ffdb80eac0b6c602599a096810fcf9a8528f1c7176a22f2f441a', '5020e3b4ee62cd5533c7733480955db4', 'zeeya@email.com', '587454548', 'male', 1, 'profile_image/img-603e02087d8438.85814061.jpg', '2021-02-22 17:48:28', NULL, NULL, NULL),
(8, 'saheed', 'b0485a4de2f7959fd48ac06e9916c01ad3e3c84c212cdbab068dfcba53741cf8', 'ad15230309826ae66e2fb56683a732c1', 'akinyemisaheedwale@gmail.com', '08104322128', 'male', 1, NULL, '2021-02-26 19:41:50', NULL, NULL, NULL),
(9, 'nuruddin6ix', '685c7222498564182e4746032e568b30d655d8ae505ecabefe7610874ccb627d', '5098d0697dac3e9316a9a8fed0ab5b6a', 'nuru6ix@email.com', '0809865244', 'male', 1, NULL, '2021-03-08 10:26:01', NULL, NULL, NULL),
(10, 'bixbie', '4ae23cd7cc6126ea0b26ac2fb4a2bb230d2001dae9ea60de9ca398d298a8b18f', '694a0083ce6a7956e84c292057a6b8c4', 'bixbie@email.com', '0809865278', 'female', 1, 'profile_image/img-60506aa674f348.56301879.jpg', '2021-03-08 10:28:08', NULL, NULL, NULL),
(11, 'rexlex', '47747b877714c4f06a86fe0a517f8433012080a27d272b26046a7a2e3f9e72c6', '2d64188bf99146e5a3a33a501a1425cb', 'rexlex@email.com', '080986525684', 'female', 1, NULL, '2021-03-08 15:19:02', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users_session`
--

CREATE TABLE `users_session` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `hash` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `views`
--

CREATE TABLE `views` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `work_id` int(11) NOT NULL,
  `count` int(11) NOT NULL DEFAULT 1,
  `action` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `views`
--

INSERT INTO `views` (`id`, `user_id`, `work_id`, `count`, `action`) VALUES
(15, NULL, 34, 23, 'view'),
(16, NULL, 33, 9, 'view'),
(17, NULL, 30, 14, 'view'),
(18, NULL, 25, 5, 'view'),
(19, NULL, 23, 3, 'view'),
(20, NULL, 27, 7, 'view'),
(21, NULL, 21, 1, 'view'),
(22, NULL, 28, 2, 'view'),
(23, NULL, 22, 4, 'view'),
(24, NULL, 32, 3, 'view'),
(25, 10, 26, 1, 'view'),
(26, 5, 35, 6, 'view'),
(27, NULL, 18, 1, 'view'),
(28, NULL, 36, 18, 'view'),
(29, 10, 38, 1, 'view'),
(30, NULL, 37, 1, 'view');

-- --------------------------------------------------------

--
-- Table structure for table `work`
--

CREATE TABLE `work` (
  `id` int(11) NOT NULL,
  `user_Id` int(11) NOT NULL,
  `category` varchar(200) NOT NULL,
  `work_title` varchar(200) NOT NULL,
  `work_description` text NOT NULL,
  `img_name` varchar(200) NOT NULL,
  `img_dir` varchar(200) NOT NULL,
  `tag` varchar(200) NOT NULL,
  `uploaded_on` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `work`
--

INSERT INTO `work` (`id`, `user_Id`, `category`, `work_title`, `work_description`, `img_name`, `img_dir`, `tag`, `uploaded_on`) VALUES
(18, 5, 'Sketch', 'I will tell the world', 'No, never!', 'Forever', 'uploads/img-6033de8eb06cc9.77660698.jpg', 'Popular', '2021-02-22 17:40:46'),
(20, 6, 'Picture Drawing', 'Asunder', 'Stand by me', 'Yahh', 'uploads/img-6033df0e8dd3e4.86704780.jpg', 'New', '2021-02-22 17:42:54'),
(21, 6, 'Painting', 'Live the life', 'Burst dada', 'Envy', 'uploads/img-6033df31f06628.33879067.jpg', 'New', '2021-02-22 17:43:29'),
(22, 6, 'Sketch', 'jealousy', 'throw it up', 'Asunder', 'uploads/img-6033df8fd08b78.68637804.jpg', 'Popular', '2021-02-22 17:45:03'),
(23, 5, 'Painting', 'Eazi jeje', 'Take it slow', 'Slowly', 'uploads/img-6033dff3d6cef1.52970537.jpg', 'New', '2021-02-22 17:46:43'),
(25, 7, 'Painting', 'Biggy man', 'whats wrong', 'Crew', 'uploads/img-6033e08e5442a7.41600369.jpg', 'New', '2021-02-22 17:49:18'),
(26, 7, 'Sketch', 'run down', 'shut down', 'rah', 'uploads/img-6033e0b46e3150.01261978.jpg', 'BestWorks', '2021-02-22 17:49:56'),
(27, 7, 'Painting', 'swagger', 'many men wan finish me', 'prolifix', 'uploads/img-6033e1032b3a14.38533617.jpeg', 'New', '2021-02-22 17:51:15'),
(28, 7, 'Graffiti', 'yes am a biggy man', 'rehhh', 'flaver', 'uploads/img-6033e1485abf38.37580994.jpg', 'New', '2021-02-22 17:52:24'),
(30, 5, 'Painting', 'Fly high', 'there will be no me', 'Loaded', 'uploads/img-6037623b2cafc7.97672829.jpg', 'New', '2021-02-25 09:39:23'),
(31, 5, 'Sketch', 'Feel kidz', 'Sure boy', 'Finish', 'uploads/img-6037626fd4be94.88737150.jpg', 'New', '2021-02-25 09:40:15'),
(32, 5, 'Painting', 'If u see', 'Change your mind', 'Know', 'uploads/img-60376297de0103.42575352.jpg', 'TopRated', '2021-02-25 09:40:55'),
(33, 5, 'Painting', 'bamilo', 'shake it', 'babanla', 'uploads/6037637e855051.08334357.jpg', 'BestWorks', '2021-02-25 09:42:50'),
(34, 5, 'Painting', 'All the way', 'You set my soul on fire', 'fight for you', 'uploads/img-603b9e67ee43c5.83244284.jpg', 'Popular', '2021-02-28 14:45:11'),
(35, 5, 'Painting', 'Wicked producer', 'cherish you', 'in the night', 'uploads/img-60463057bf68f2.42452322.jpg', 'New', '2021-03-08 15:10:31'),
(36, 10, 'Painting', 'Mind', 'Just in time', 'come through', 'uploads/img-604c6264c64031.18436389.jpg', 'New', '2021-03-13 07:57:40'),
(37, 10, 'Sketch', 'bump_to', 'Fine by me', 'Risky', 'uploads/img-604c629f7d7743.58208241.jpg', 'New', '2021-03-13 07:58:39'),
(38, 10, 'Picture Drawing', 'take me', 'tell me everything', 'run am', 'uploads/img-604c62cee85201.97915637.jpg', 'New', '2021-03-13 07:59:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `additional_user_info`
--
ALTER TABLE `additional_user_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `follow`
--
ALTER TABLE `follow`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reaction`
--
ALTER TABLE `reaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_session`
--
ALTER TABLE `users_session`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `views`
--
ALTER TABLE `views`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `work`
--
ALTER TABLE `work`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `additional_user_info`
--
ALTER TABLE `additional_user_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `follow`
--
ALTER TABLE `follow`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `reaction`
--
ALTER TABLE `reaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users_session`
--
ALTER TABLE `users_session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `views`
--
ALTER TABLE `views`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `work`
--
ALTER TABLE `work`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
