-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 20, 2022 at 07:25 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `internget`
--

-- --------------------------------------------------------

--
-- Table structure for table `Application`
--

CREATE TABLE `Application` (
  `student_email` varchar(255) NOT NULL,
  `internship_id` mediumint(9) NOT NULL,
  `date_created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Domain`
--

CREATE TABLE `Domain` (
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `DomainOfInternship`
--

CREATE TABLE `DomainOfInternship` (
  `domain_name` varchar(100) NOT NULL,
  `internship_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Internship`
--

CREATE TABLE `Internship` (
  `id` mediumint(9) NOT NULL,
  `pos_name` varchar(100) NOT NULL,
  `org_email` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `workplace_mode` enum('remote','hybrid','in-office') DEFAULT NULL,
  `hourly_pay` mediumint(9) NOT NULL DEFAULT 0,
  `start_date` date DEFAULT NULL,
  `duration` tinyint(4) DEFAULT NULL,
  `days_per_week` tinyint(4) DEFAULT NULL,
  `hours_per_week` int(11) DEFAULT NULL,
  `time_type` enum('part-time','full-time','project-based') DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `bonus` tinyint(1) DEFAULT NULL,
  `is_filled` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Organization`
--

CREATE TABLE `Organization` (
  `name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `city` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Organization`
--

INSERT INTO `Organization` (`name`, `email`, `password`, `city`, `country`) VALUES
('x', 'nadman.ash.khan@gmail.com', '$2y$10$xE6q/WQC8/eSsbuns9XS6ejH2ZGLq/z6EjiqnPhGb6BE3qxqE.YWm', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Position`
--

CREATE TABLE `Position` (
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Skill`
--

CREATE TABLE `Skill` (
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Skill`
--

INSERT INTO `Skill` (`name`) VALUES
('css'),
('html'),
('html-5'),
('javascript'),
('web development');

-- --------------------------------------------------------

--
-- Table structure for table `SkillLearnableForInternship`
--

CREATE TABLE `SkillLearnableForInternship` (
  `skill_name` varchar(100) NOT NULL,
  `internship_id` mediumint(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `SkillRequiredForInternship`
--

CREATE TABLE `SkillRequiredForInternship` (
  `skill_name` varchar(100) NOT NULL,
  `internship_id` mediumint(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Student`
--

CREATE TABLE `Student` (
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Student`
--

INSERT INTO `Student` (`email`, `name`, `password`) VALUES
('nadman.ash.khan@gmail.com', 'x', '$2y$10$AO0n0no3xiqMll92eyHLveyT4oS.WpD76Y8JhUZQQMpnQD9PGvRwC'),
('tanvir.khan01@northsouth.edu', 'Tanvir Khan', '$2y$10$EtczFfZqzXUGH0XepJcAOuLkXThDRvq1BqAc5I5iSNDwbaAc8x5cm');

-- --------------------------------------------------------

--
-- Table structure for table `Tag`
--

CREATE TABLE `Tag` (
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `TagForInternship`
--

CREATE TABLE `TagForInternship` (
  `tag_name` varchar(100) NOT NULL,
  `internship_id` mediumint(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Application`
--
ALTER TABLE `Application`
  ADD PRIMARY KEY (`student_email`,`internship_id`);

--
-- Indexes for table `Domain`
--
ALTER TABLE `Domain`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `DomainOfInternship`
--
ALTER TABLE `DomainOfInternship`
  ADD PRIMARY KEY (`domain_name`);

--
-- Indexes for table `Internship`
--
ALTER TABLE `Internship`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Organization`
--
ALTER TABLE `Organization`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `Position`
--
ALTER TABLE `Position`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `Skill`
--
ALTER TABLE `Skill`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `SkillLearnableForInternship`
--
ALTER TABLE `SkillLearnableForInternship`
  ADD PRIMARY KEY (`skill_name`,`internship_id`);

--
-- Indexes for table `SkillRequiredForInternship`
--
ALTER TABLE `SkillRequiredForInternship`
  ADD PRIMARY KEY (`skill_name`);

--
-- Indexes for table `Student`
--
ALTER TABLE `Student`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `Tag`
--
ALTER TABLE `Tag`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `TagForInternship`
--
ALTER TABLE `TagForInternship`
  ADD PRIMARY KEY (`tag_name`,`internship_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Internship`
--
ALTER TABLE `Internship`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
