-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 24, 2024 at 10:40 AM
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_all_users` ()  SELECT
*
FROM users WHERE id != 1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_edu_list` ()  SELECT
ec.id AS 'edu_id',
ec.edu_title,
ec.edu_image,
ec.edu_pdf,
ec.edu_link,
ec.edu_desc,
u.username
FROM edu_content ec
INNER JOIN users u
WHERE ec.nutritionist_id=u.id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_edu_list_by_id` (IN `user_id` INT)  SELECT
ec.id AS 'edu_id',
ec.edu_title,
ec.edu_image,
ec.edu_pdf,
ec.edu_link,
ec.edu_desc,
u.username
FROM edu_content ec
INNER JOIN users u
WHERE ec.nutritionist_id=u.id AND ec.nutritionist_id=user_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_meal_plans` ()  SELECT
mp.id AS 'mp_id',
mp.plan_title,
mp.meal_desc,
mp.breakfast_time,
mp.breakfast_meal,
mp.snack_time,
mp.snack_meal,
mp.lunch_time,
mp.lunch_meal,
mp.dinner_time,
mp.dinner_meal,
c.category_name,
c.category_img
FROM meal_plan mp
INNER JOIN categories c
WHERE mp.cat_id=c.id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_meal_plans_by_ids` (IN `meal_ids` TEXT)  SELECT
mp.id AS 'mp_id',
mp.plan_title,
mp.meal_desc,
mp.breakfast_time,
mp.breakfast_meal,
mp.snack_time,
mp.snack_meal,
mp.lunch_time,
mp.lunch_meal,
mp.dinner_time,
mp.dinner_meal,
c.category_name
FROM meal_plan mp
INNER JOIN categories c ON mp.cat_id = c.id
WHERE FIND_IN_SET(mp.id, meal_ids) > 0$$

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

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_recipes_list_approved_by_recipe_id` (IN `recipe_id` INT)  SELECT
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
WHERE r.nutritionist_id=u.id AND r.cat_id=c.id AND r.recipe_status='1' AND r.id=recipe_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_recipes_list_by_id` (IN `recipe_id` INT)  SELECT DISTINCT
    r.id AS 'recipe_id',
    r.recipe_title,
    r.ingredients,
    r.instructions,
    r.recipe_status,
    r.recipe_img,
    c.id AS 'cat_id',
    c.category_name
FROM recipes r
INNER JOIN categories c ON r.cat_id = c.id
WHERE r.id = recipe_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_recipes_list_fav` (IN `recipe_ids` VARCHAR(255))  SELECT DISTINCT
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
INNER JOIN users u ON r.nutritionist_id = u.id
INNER JOIN categories c ON r.cat_id = c.id
WHERE r.recipe_status = '1'
  AND FIND_IN_SET(r.id, recipe_ids) > 0$$

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
(2, 'obesity', NULL),
(5, 'test123', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `edu_content`
--

CREATE TABLE `edu_content` (
  `id` int(11) NOT NULL,
  `edu_title` varchar(255) NOT NULL,
  `edu_image` text DEFAULT NULL,
  `edu_pdf` text DEFAULT NULL,
  `edu_link` text NOT NULL,
  `edu_desc` text NOT NULL,
  `nutritionist_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `edu_content`
--

INSERT INTO `edu_content` (`id`, `edu_title`, `edu_image`, `edu_pdf`, `edu_link`, `edu_desc`, `nutritionist_id`) VALUES
(6, 'edu_title', 'gtrR35.jpg', 'nadra_pay.pdf', 'https://youtu.be/67J70bGNb-A', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 3);

-- --------------------------------------------------------

--
-- Table structure for table `meal_plan`
--

CREATE TABLE `meal_plan` (
  `id` int(11) NOT NULL,
  `plan_title` varchar(255) NOT NULL,
  `meal_desc` text NOT NULL,
  `cat_id` int(11) NOT NULL,
  `breakfast_time` time NOT NULL,
  `breakfast_meal` text NOT NULL,
  `snack_time` time NOT NULL,
  `snack_meal` text NOT NULL,
  `lunch_time` time NOT NULL,
  `lunch_meal` text NOT NULL,
  `dinner_time` time NOT NULL,
  `dinner_meal` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `meal_plan`
--

INSERT INTO `meal_plan` (`id`, `plan_title`, `meal_desc`, `cat_id`, `breakfast_time`, `breakfast_meal`, `snack_time`, `snack_meal`, `lunch_time`, `lunch_meal`, `dinner_time`, `dinner_meal`) VALUES
(4, 'For Blood Pressure People Healthy Diet', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 1, '07:00:00', 'Eat one boil egg, take 1 cup of Milk, take 2 slices of toast.', '11:30:00', 'Eat some junk food hehe.', '15:30:00', 'Drink Banana Shake, Eat Samosa and chicken roll.', '21:00:00', 'Eat what ever you like.'),
(6, 'Et occaecat laudanti', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English.', 1, '07:50:00', 'Quia corporis velit', '13:27:00', 'Dolorem aspernatur v', '15:00:00', 'Cumque amet et eaqu', '23:22:00', 'Exercitationem labor'),
(7, 'Et eu velit reicien', 'Alias dolore dolorem', 2, '20:59:00', 'Dolores pariatur Do', '09:34:00', 'Esse corporis est ', '20:33:00', 'Adipisicing corporis', '22:18:00', 'Aut itaque debitis s');

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
(23, 'test_recipe_111', '1 cup salt, 2 cup oil', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 3, 1, '1', 'red-forest-trees_.jpg'),
(24, 'test111', '1 cup salt, 2 cup oil, etc...', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 3, 2, '2', 'oii.jpg'),
(25, 'Cumque dolores iure 123555', 'Similique dolorem ad', 'Quam velit incididun', 3, 1, '2', 'edit_wp_mountain.jpg');

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
  `status` enum('0','1') NOT NULL DEFAULT '0',
  `fav_recipes` text DEFAULT NULL,
  `fav_meals` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `phone`, `password`, `role`, `status`, `fav_recipes`, `fav_meals`) VALUES
(1, 'admin', 'admin@gmail.com', NULL, '4297f44b13955235245b2497399d7a93', 'admin', '0', NULL, NULL),
(2, 'user123', 'user@gmail.com', '057696787899', 'a74c9f77c78cd8034be72cca4d49f5f0', 'user', '0', '', ''),
(3, 'nutritionist', 'nutritionist@gmail.com', '5123152121312', '4297f44b13955235245b2497399d7a93', 'nutritionist', '0', NULL, NULL),
(4, 'nutritionist1', 'nutritionist1@gmail.com', NULL, '4297f44b13955235245b2497399d7a93', 'nutritionist', '0', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_meal_plan`
--

CREATE TABLE `user_meal_plan` (
  `id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `days` text NOT NULL,
  `progress` int(11) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `edu_content`
--
ALTER TABLE `edu_content`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nutritionist_id` (`nutritionist_id`);

--
-- Indexes for table `meal_plan`
--
ALTER TABLE `meal_plan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cat_id` (`cat_id`);

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
-- Indexes for table `user_meal_plan`
--
ALTER TABLE `user_meal_plan`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `edu_content`
--
ALTER TABLE `edu_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `meal_plan`
--
ALTER TABLE `meal_plan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `recipes`
--
ALTER TABLE `recipes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_meal_plan`
--
ALTER TABLE `user_meal_plan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `edu_content`
--
ALTER TABLE `edu_content`
  ADD CONSTRAINT `edu_content_ibfk_1` FOREIGN KEY (`nutritionist_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `meal_plan`
--
ALTER TABLE `meal_plan`
  ADD CONSTRAINT `meal_plan_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`id`);

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
