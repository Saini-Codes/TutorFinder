-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 23, 2025 at 05:24 PM
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
-- Database: `tutorfinder`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `aid` int(11) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `email` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`aid`, `username`, `password`, `email`) VALUES
(1, 'Jit', '123', 'jithazra00@gmail.com'),
(3, 'Saini', '1234', 'sainipaul39@gmail.com'),
(5, 'JitHazra194', '12345', 'jithazraedu@gmail.com'),
(6, 'SainiPaul', '123456', '');

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `id` int(11) NOT NULL,
  `tutor_id` int(11) NOT NULL,
  `student_email` varchar(100) NOT NULL,
  `rating` int(11) NOT NULL,
  `review` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`id`, `tutor_id`, `student_email`, `rating`, `review`, `created_at`) VALUES
(1, 5, 'sainipaul39@gmail.com', 4, '', '2025-06-27 08:58:12'),
(2, 5, 'sainipaul39@gmail.com', 2, '', '2025-06-27 09:03:07'),
(3, 1, 'sainipaul39@gmail.com', 5, '', '2025-06-27 09:42:49'),
(4, 1, 'sainipaul39@gmail.com', 3, '', '2025-06-27 09:44:40'),
(5, 2, 'sainipaul39@gmail.com', 5, '', '2025-06-27 09:45:56'),
(6, 2, 'sainipaul39@gmail.com', 4, '', '2025-06-27 09:47:10'),
(7, 1, 'sainipaul39@gmail.com', 5, 'I love this tutor\r\n', '2025-06-27 10:49:29'),
(8, 2, 'sainipaul39@gmail.com', 5, 'I love you\r\n', '2025-06-27 10:53:59'),
(9, 5, 'sainipaul39@gmail.com', 5, '', '2025-06-27 11:22:23'),
(10, 6, 'sainipaul39@gmail.com', 5, '', '2025-06-28 00:40:54'),
(11, 1, 'jithazra00@gmail.com', 5, 'hola', '2025-07-15 08:03:46'),
(12, 3, 'jithazra00@gmail.com', 5, '', '2025-07-15 08:04:29'),
(13, 8, 'jithazraedu@gmail.com', 4, 'Good Teacher', '2025-07-22 20:06:06'),
(14, 8, 'jithazra00@gmail.com', 4, 'Good Tutor', '2025-07-22 21:40:07');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `sid` int(11) NOT NULL,
  `name` text NOT NULL,
  `street` text NOT NULL,
  `city` text NOT NULL,
  `zip` text NOT NULL,
  `district` text NOT NULL,
  `state` text NOT NULL,
  `email` text NOT NULL,
  `phone` text NOT NULL,
  `gender` text NOT NULL,
  `semester` text NOT NULL,
  `profilepic` varchar(255) NOT NULL,
  `profiledir` varchar(255) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `latitude` text NOT NULL,
  `longitude` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`sid`, `name`, `street`, `city`, `zip`, `district`, `state`, `email`, `phone`, `gender`, `semester`, `profilepic`, `profiledir`, `username`, `password`, `latitude`, `longitude`) VALUES
(1, 'Jit Hazra', '4 No Purbanarayanpur', 'Kankinara', '743126', 'North 24 Parganas', 'West Bengal', 'jithazra00@gmail.com', '8918572831', 'Male', 'Semester VI', 'developer.jpg', 'pfp/user_JitHazra1948918572831/', 'JitHazra194', '8918572831@JitHazra', '22.577152', '88.421171'),
(6, 'Saini Paul', 'SahebPukur', 'Halisahar', '743126', 'North 24 Parganas', 'West Bengal', 'sainipaul39@gmail.com', '6291176228', 'Female', 'Semester VI', 'SainiPaul.jpg', 'pfp/user_Saini_Paul6291176228/', 'SainiPaul159', '6291176228@SainiPaul', '22.590259', '88.391680'),
(7, 'Jit Hazra', 'Barishalpara Road', 'Kankinara', '743126', 'North 24 Parganas', 'West Bengal', 'jithazraedu@gmail.com', '9826483535', 'Male', 'Semester V', '8977b78f-3108-4319-82c1-199d1580744d.png', 'pfp/user_Jit_Hazra9826483535/', 'JitHazra750', '9826483535@JitHazra', '22.865314', '88.419040'),
(8, 'Diya Debnath', 'Alaipur Mathpara', 'Madanpur', '741245', 'Nadia', 'West Bengal', 'debnathdiya2004@gmail.com', '7548017775', 'Female', 'Semester VI', 'Diya.jpg', 'pfp/user_Diya_Debnath7548017775/', 'DiyaDebnath101', '7548017775@DiyaDebnath', '22.949488', '88.443336'),
(9, 'Jhumi Debnath', 'Suryanagar,Nasra', 'Ranaghat', '741202', 'Nadia', 'West Bengal', 'jhumidebnath74@gmail.com', '9735387707', 'Female', 'Semester VI', 'Jhumi.jpg', 'pfp/user_Jhumi_Debnath9735387707/', 'JhumiDebnath998', '9735387707@JhumiDebnath', '22.949500', '88.443325');

-- --------------------------------------------------------

--
-- Table structure for table `student_waitlist`
--

CREATE TABLE `student_waitlist` (
  `sid` int(11) NOT NULL,
  `name` text NOT NULL,
  `subject` text NOT NULL,
  `s_email` varchar(50) NOT NULL,
  `semester` text NOT NULL,
  `s_phone` text NOT NULL,
  `t_email` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_waitlist`
--

INSERT INTO `student_waitlist` (`sid`, `name`, `subject`, `s_email`, `semester`, `s_phone`, `t_email`) VALUES
(10, 'Saini Paul', 'computer', 'sainipaul39@gmail.com', 'Semester VI', '6291176228', 'sainipaul39@gmail.com'),
(11, 'Saini Paul', 'Physics', 'sainipaul39@gmail.com', 'Semester VI', '6291176228', 'sainipaul39@gmail.com'),
(34, 'Jit Hazra', 'Computer', 'jithazra00@gmail.com', 'Semester VI', '8918572831', 'paulsaurav4389@gmail.com'),
(35, 'Jit Hazra', 'Computer', 'jithazra00@gmail.com', 'Semester VI', '8918572831', 'paulsaurav4389@gmail.com'),
(36, 'Jit Hazra', 'Computer', 'jithazra00@gmail.com', 'Semester VI', '8918572831', 'paulsaurav4389@gmail.com'),
(37, 'Jit Hazra', 'Computer', 'jithazra00@gmail.com', 'Semester VI', '8918572831', 'paulsaurav4389@gmail.com'),
(38, 'Jit Hazra', 'Computer', 'jithazra00@gmail.com', 'Semester VI', '8918572831', 'paulsaurav4389@gmail.com'),
(39, 'Jit Hazra', 'Computer', 'jithazra00@gmail.com', 'Semester VI', '8918572831', 'paulsaurav4389@gmail.com'),
(40, 'Jit Hazra', 'Computer', 'jithazra00@gmail.com', 'Semester VI', '8918572831', 'paulsaurav4389@gmail.com'),
(41, 'Jit Hazra', 'Computer', 'jithazra00@gmail.com', 'Semester VI', '8918572831', 'paulsaurav4389@gmail.com'),
(42, 'Jit Hazra', 'Computer', 'jithazra00@gmail.com', 'Semester VI', '8918572831', 'paulsaurav4389@gmail.com'),
(43, 'Jit Hazra', 'Computer', 'jithazra00@gmail.com', 'Semester VI', '8918572831', 'hazratumpa00@gmail.com'),
(48, 'Jit Hazra', 'Computer', 'jithazra00@gmail.com', 'Semester VI', '8918572831', 'paulsaurav4389@gmail.com'),
(50, 'Jit Hazra', 'Computer', 'jithazra00@gmail.com', 'Semester VI', '8918572831', 'jithazra00@gmail.com'),
(51, 'Jit Hazra', 'Computer Science', 'jithazra00@gmail.com', 'Semester VI', '8918572831', 'jithazra00@gmail.com'),
(52, 'Jit Hazra', 'Computer', 'jithazra00@gmail.com', 'Semester VI', '8918572831', 'jithazra00@gmail.com'),
(53, 'Jit Hazra', '', 'jithazra00@gmail.com', 'Semester VI', '8918572831', 'paulsaurav4389@gmail.com'),
(54, 'Jit Hazra', 'Computer', 'jithazra00@gmail.com', 'Semester VI', '8918572831', 'paulsaurav4389@gmail.com'),
(55, 'Jit Hazra', 'Math', 'jithazra00@gmail.com', 'Semester VI', '8918572831', 'paulsaurav4389@gmail.com'),
(56, 'Jit Hazra', 'Computer', 'jithazra00@gmail.com', 'Semester VI', '8918572831', 'paulsaurav4389@gmail.com'),
(57, 'Jit Hazra', 'Computer', 'jithazra00@gmail.com', 'Semester VI', '8918572831', 'paulsaurav4389@gmail.com'),
(58, 'Jit Hazra', 'Computer', 'jithazra00@gmail.com', 'Semester VI', '8918572831', 'sainipaul39@gmail.com'),
(59, 'Jit Hazra', 'Computer Science', 'jithazra00@gmail.com', 'Semester VI', '8918572831', 'jithazra00@gmail.com'),
(60, 'Saini Paul', 'Computer', 'sainipaul39@gmail.com', 'Semester VI', '6291176228', 'jithazra00@gmail.com'),
(61, 'Jit Hazra', 'Computer Science', 'jithazraedu@gmail.com', 'Semester V', '9826483535', 'jithazraoptional@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `tutor`
--

CREATE TABLE `tutor` (
  `tid` int(11) NOT NULL,
  `name` text NOT NULL,
  `street` text NOT NULL,
  `city` text NOT NULL,
  `pin` text NOT NULL,
  `district` text NOT NULL,
  `state` text NOT NULL,
  `email` text NOT NULL,
  `phone` text NOT NULL,
  `gender` text NOT NULL,
  `subject1` text NOT NULL,
  `subject2` text NOT NULL,
  `subject3` text NOT NULL,
  `fees1` text NOT NULL,
  `fees2` text NOT NULL,
  `fees3` text NOT NULL,
  `qualifications` text NOT NULL,
  `profession` text NOT NULL,
  `logo` varchar(255) NOT NULL,
  `logoDir` varchar(255) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `latitude` text NOT NULL,
  `longitude` text NOT NULL,
  `interviewStatus` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tutor`
--

INSERT INTO `tutor` (`tid`, `name`, `street`, `city`, `pin`, `district`, `state`, `email`, `phone`, `gender`, `subject1`, `subject2`, `subject3`, `fees1`, `fees2`, `fees3`, `qualifications`, `profession`, `logo`, `logoDir`, `username`, `password`, `latitude`, `longitude`, `interviewStatus`) VALUES
(1, 'Jit Hazra', '4 No Purbanarayanpur', 'Kankinara', '743126', 'North 24 Parganas', 'West Bengal', 'jithazra00@gmail.com', '8918572831', 'Male', 'Computer Science', '', '', '500', '', '', 'B.Sc Hons', 'Working at XYZ Company', 'developer.jpg', 'uploads/user_JitHazra4678918572831/logo/', 'JitHazra467', '8918572831@JitHazra', '', '', ''),
(2, 'Jit Hazra', '4 No Purbanarayanpur', 'Kankinara', '743126', 'North 24 Parganas', 'West Bengal', 'jithazraedu@gmail.com', '8420974327', 'Male', 'Computer Application', 'Chemistry', 'Computer Science', '300', '700', '800', 'M.Tech', 'HOD at ABC College', 'TutorFinderLogo.png', 'uploads/user_Jit_Hazra8420974327/logo/', 'JitHazra769', '8420974327@JitHazra', '22.8651681', '88.4193649', ''),
(3, 'Saini Paul', 'SahebPukur', 'Halisahar', '743136', 'North 24 Parganas', 'West Bengal', 'sainipaul39@gmail.com', '6291176228', 'Female', 'Computer Science', 'English', 'Physics', '500', '200', '800', 'M.Tech, P.H.D', 'Proff. at HighLevel University', 'SainiPaul.jpg', 'uploads/user_Saini_Paul6291176228/logo/', 'SainiPaul369', '6291176228@SainiPaul', '', '', 'Accepted'),
(5, 'Tumpa Hazra', 'Palpara', 'Kankinara', '743126', 'North 24 Parganas', 'West Bengal', 'hazratumpa00@gmail.com', '9123037399', 'Female', 'Math', 'English', 'Bengali', '200', '300', '500', 'M.Tech', 'Proff. at XYZ University', 'logo.jpg', 'uploads/user_Tumpa_Hazra9123037399/logo/', 'TumpaHazra467', '9123037399@TumpaHazra', '22.8651681', '88.4193649', ''),
(6, 'Saini Paul', 'Barishalpara Road', 'Kankinara', '743126', 'Kolkata', 'West Bengal', 'paulsaurav4389@gmail.com', '7402964372', 'Female', 'Math', 'Computer', 'English', '200', '300', '500', 'MTECH', 'Professor at XYZ University', 'th.jpg', 'uploads/user_Saini_Paul7402964372/logo/', 'SainiPaul197', '7402964372@SainiPaul', '22.577152', '88.375296', 'Accepted'),
(8, 'Jit Hazra', 'Barishalpara Road', 'Naihati', '743126', 'North 24 Parganas', 'West Bengal', 'jithazraoptional@gmail.com', '8365937637', 'Male', 'Computer Application', 'Computer Science', 'Math', '500', '700', '600', 'B.Sc Hons', 'Professor at XYZ University', 'th.jpg', 'uploads/user_Jit_Hazra8365937637/logo/', 'JitHazra874', '8376526733@JitHazra', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tutor_waitlist`
--

CREATE TABLE `tutor_waitlist` (
  `tid` int(11) NOT NULL,
  `name` text NOT NULL,
  `street` text NOT NULL,
  `city` text NOT NULL,
  `pin` text NOT NULL,
  `district` text NOT NULL,
  `state` text NOT NULL,
  `email` text NOT NULL,
  `phone` text NOT NULL,
  `gender` text NOT NULL,
  `subject1` text NOT NULL,
  `subject2` text NOT NULL,
  `subject3` text NOT NULL,
  `fees1` text NOT NULL,
  `fees2` text NOT NULL,
  `fees3` text NOT NULL,
  `qualifications` text NOT NULL,
  `profession` text NOT NULL,
  `logo` varchar(255) NOT NULL,
  `cv` varchar(255) NOT NULL,
  `logoDir` varchar(255) NOT NULL,
  `cvDir` varchar(255) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `latitude` text NOT NULL,
  `longitude` text NOT NULL,
  `interview_score` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`aid`),
  ADD UNIQUE KEY `username` (`username`) USING HASH,
  ADD UNIQUE KEY `password` (`password`) USING HASH,
  ADD UNIQUE KEY `email` (`email`) USING HASH;

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`sid`),
  ADD UNIQUE KEY `email` (`email`) USING HASH,
  ADD UNIQUE KEY `phone` (`phone`) USING HASH,
  ADD UNIQUE KEY `password` (`password`) USING HASH;

--
-- Indexes for table `student_waitlist`
--
ALTER TABLE `student_waitlist`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `tutor`
--
ALTER TABLE `tutor`
  ADD PRIMARY KEY (`tid`),
  ADD UNIQUE KEY `email` (`email`) USING HASH,
  ADD UNIQUE KEY `phone` (`phone`) USING HASH;

--
-- Indexes for table `tutor_waitlist`
--
ALTER TABLE `tutor_waitlist`
  ADD PRIMARY KEY (`tid`),
  ADD UNIQUE KEY `email` (`email`) USING HASH,
  ADD UNIQUE KEY `phone` (`phone`) USING HASH;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `aid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `student_waitlist`
--
ALTER TABLE `student_waitlist`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `tutor`
--
ALTER TABLE `tutor`
  MODIFY `tid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tutor_waitlist`
--
ALTER TABLE `tutor_waitlist`
  MODIFY `tid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
