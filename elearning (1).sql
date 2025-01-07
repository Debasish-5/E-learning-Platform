-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 07, 2025 at 07:27 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `elearning`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `duration` varchar(100) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `youtube_video_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `title`, `description`, `duration`, `image_url`, `youtube_video_id`) VALUES
(1, 'C-Programming Language', 'Learn the basics of C programming, covering variables, loops, functions, and arrays.\r\nSyllabus: \r\n1. Introduction to C \r\n2. Variables and Data Types \r\n3. Control Structures \r\n4. Functions\r\n5. Arrays and Strings\r\n6. Pointers and Memory Management', '1:33:23 hr', 'img/c-course.png', 'YXcgD8hRHYY'),
(2, 'C++ Programming Language', 'Master the C++ programming language, including object-oriented programming concepts and advanced features. \r\nSyllabus: \r\n1. Introduction to C++\r\n2. Classes and Objects\r\n3. Inheritance and Polymorphism\r\n4. Memory Management\r\n5. Templates and Exceptions\r\n6. STL.', '1:16:48 hr', 'img/c++-course.png', 'yGB9jhsEsr8'),
(3, 'Java Programming Language', 'Explore Java programming fundamentals, focusing on object-oriented programming and core libraries. \r\nSyllabus: \r\n1. Introduction to Java\r\n2. Variables and Data Types\r\n3. Control Statements\r\n4. Object-Oriented Programming\r\n5. Exception Handling\r\n6. Collections and Streams', '2:04:35 hr', 'img/java corse.png', 'UmnCZ7-9yDY'),
(4, 'JavaScript Programming Language', 'Learn JavaScript basics for web development, including DOM manipulation and asynchronous programming. \r\nSyllabus:\r\n1. Introduction to JavaScript\r\n2. Variables and Functions\r\n3. DOM Manipulation\r\n4. Events and Listeners\r\n5. Asynchronous Programming (Promises, async/await)\r\n6. Web APIs', '11:47:13 hr\r\n', 'img/js course.png', 'VlPiVmYuoqw'),
(5, 'Python Programming Language', 'Understand the fundamentals of Python, from basic syntax to advanced features like decorators and generators. \r\nSyllabus:\r\n1. Introduction to Python\r\n2. Variables and Data Types\r\n3. Control Flow\r\n4. Functions and Modules\r\n5. File Handling\r\n6. Advanced Python Features (Decorators, Generators, etc.)', '10:53:54 hr', 'img/python course.png', 'UrsmFxEIp5k'),
(6, 'Database Management System', 'Learn how to design, manage, and query databases using SQL and other relational database concepts. \r\nSyllabus: \r\n1. Introduction to DBMS\r\n2. Entity-Relationship Model\r\n3. SQL Basics\r\n4. Advanced SQL (Joins, Subqueries)\r\n5. Normalization and Denormalization\r\n6. Database Security and Optimization', '11:42:06 hr', 'img/database.png', 'dl00fOOYLOM');

-- --------------------------------------------------------

--
-- Table structure for table `course_progress`
--

CREATE TABLE `course_progress` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `progress` int(11) NOT NULL DEFAULT 0,
  `last_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `playback_time` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `enrolled_courses`
--

CREATE TABLE `enrolled_courses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `enrolled_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrolled_courses`
--

INSERT INTO `enrolled_courses` (`id`, `user_id`, `course_id`, `enrolled_at`) VALUES
(6, 1, 1, '2024-12-11 01:28:19'),
(7, 1, 2, '2024-12-13 17:25:41'),
(8, 1, 5, '2024-12-16 21:24:38'),
(9, 1, 3, '2025-01-07 11:47:14');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_img` varchar(255) DEFAULT 'default.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`, `user_img`) VALUES
(1, 'Debasish Pradhan', 'debasishpradhan3214@gmail.com', '1234', '2024-12-16 16:34:01', 'uploads/1734621084_debasish2.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_progress`
--
ALTER TABLE `course_progress`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `enrolled_courses`
--
ALTER TABLE `enrolled_courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `course_progress`
--
ALTER TABLE `course_progress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `enrolled_courses`
--
ALTER TABLE `enrolled_courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `course_progress`
--
ALTER TABLE `course_progress`
  ADD CONSTRAINT `course_progress_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `course_progress_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`);

--
-- Constraints for table `enrolled_courses`
--
ALTER TABLE `enrolled_courses`
  ADD CONSTRAINT `enrolled_courses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `enrolled_courses_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
