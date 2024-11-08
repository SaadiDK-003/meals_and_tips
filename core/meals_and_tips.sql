-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 08, 2024 at 11:05 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `meals_and_tips`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_recipes_list_approved` ()  SELECT
r.id AS 'recipe_id',
r.recipe_title,
r.ingredients,
r.instructions,
r.recipe_status,
r.recipe_img,
u.id AS 'user_id',
u.username,
c.id AS 'cat_id',
c.category_name
FROM recipes r
INNER JOIN users u
INNER JOIN categories c
WHERE r.nutritionist_id=u.id AND r.cat_id=c.id AND r.recipe_status='1'$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_recipes_list_in_review` ()  SELECT
r.id AS 'recipe_id',
r.recipe_title,
r.ingredients,
r.instructions,
r.recipe_status,
r.recipe_img,
u.id AS 'user_id',
u.username,
c.id AS 'cat_id',
c.category_name
FROM recipes r
INNER JOIN users u
INNER JOIN categories c
WHERE r.nutritionist_id=u.id AND r.cat_id=c.id AND r.recipe_status='0'$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_recipes_list_rejected` ()  SELECT
r.id AS 'recipe_id',
r.recipe_title,
r.ingredients,
r.instructions,
r.recipe_status,
u.id AS 'user_id',
u.username,
c.id AS 'cat_id',
c.category_name
FROM recipes r
INNER JOIN users u
INNER JOIN categories c
WHERE r.nutritionist_id=u.id AND r.cat_id=c.id AND r.recipe_status='2'$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_recipes_list_rejected_by_id` (IN `nutritionist_id` INT)  SELECT
r.id AS 'recipe_id',
r.recipe_title,
r.ingredients,
r.instructions,
r.recipe_status,
u.id AS 'user_id',
u.username,
c.id AS 'cat_id',
c.category_name
FROM recipes r
INNER JOIN users u
INNER JOIN categories c
WHERE r.nutritionist_id=u.id AND r.cat_id=c.id AND r.recipe_status='2' AND r.nutritionist_id=nutritionist_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_recipes_list_review_or_approved_by_id` (IN `nutritionist_id` INT)  SELECT
r.id AS 'recipe_id',
r.recipe_title,
r.ingredients,
r.instructions,
r.recipe_status,
u.id AS 'user_id',
u.username,
c.id AS 'cat_id',
c.category_name
FROM recipes r
INNER JOIN users u
INNER JOIN categories c
WHERE r.nutritionist_id=u.id AND r.cat_id=c.id AND (r.recipe_status='1' || r.recipe_status='0') AND r.nutritionist_id=nutritionist_id$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_img` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `category_img`) VALUES
(1, 'high blood pressure', NULL),
(2, 'obesity', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE `recipes` (
  `id` int(11) NOT NULL,
  `recipe_title` varchar(255) NOT NULL,
  `ingredients` text NOT NULL,
  `instructions` text NOT NULL,
  `nutritionist_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `recipe_status` enum('0','1','2') NOT NULL DEFAULT '0',
  `recipe_img` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`id`, `recipe_title`, `ingredients`, `instructions`, `nutritionist_id`, `cat_id`, `recipe_status`, `recipe_img`) VALUES
(13, 'High-Protein Spinach Dip Is Cheesy & Delicious', '1 cup salt, 2 cup oil', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.', 3, 1, '1', 'recipe_.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','nutritionist','user') NOT NULL DEFAULT 'user',
  `status` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `phone`, `password`, `role`, `status`) VALUES
(1, 'admin', 'admin@gmail.com', NULL, '4297f44b13955235245b2497399d7a93', 'admin', '0'),
(2, 'user', 'user@gmail.com', NULL, '4297f44b13955235245b2497399d7a93', 'user', '0'),
(3, 'nutritionist', 'nutritionist@gmail.com', NULL, '4297f44b13955235245b2497399d7a93', 'nutritionist', '0'),
(4, 'nutritionist1', 'nutritionist1@gmail.com', NULL, '4297f44b13955235245b2497399d7a93', 'nutritionist', '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nutritionist_id` (`nutritionist_id`),
  ADD KEY `recipes_ibfk_2` (`cat_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `recipes`
--
ALTER TABLE `recipes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `recipes`
--
ALTER TABLE `recipes`
  ADD CONSTRAINT `recipes_ibfk_1` FOREIGN KEY (`nutritionist_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `recipes_ibfk_2` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
