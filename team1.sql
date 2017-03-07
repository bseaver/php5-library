-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Mar 08, 2017 at 12:14 AM
-- Server version: 5.5.42
-- PHP Version: 5.6.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `library_test`
--
CREATE DATABASE IF NOT EXISTS `library_test` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `library_test`;

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

DROP TABLE IF EXISTS `authors`;
CREATE TABLE `authors` (
  `id` bigint(20) unsigned NOT NULL,
  `author_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=309 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `authors_books`
--

DROP TABLE IF EXISTS `authors_books`;
CREATE TABLE `authors_books` (
  `id` bigint(20) unsigned NOT NULL,
  `author_id` bigint(20) DEFAULT NULL,
  `book_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=221 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

DROP TABLE IF EXISTS `books`;
CREATE TABLE `books` (
  `id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `publish_date` date DEFAULT NULL,
  `synopsis` varchar(255) DEFAULT NULL,
  `genre_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=309 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `book_copies`
--

DROP TABLE IF EXISTS `book_copies`;
CREATE TABLE `book_copies` (
  `id` bigint(20) unsigned NOT NULL,
  `book_condition` tinyint(4) DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `book_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `checkouts`
--

DROP TABLE IF EXISTS `checkouts`;
CREATE TABLE `checkouts` (
  `id` bigint(20) unsigned NOT NULL,
  `book_copy_id` bigint(20) DEFAULT NULL,
  `patron_id` bigint(20) DEFAULT NULL,
  `checkout_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `returned_date` date DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `still_out` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=573 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `genre`
--

DROP TABLE IF EXISTS `genre`;
CREATE TABLE `genre` (
  `id` bigint(20) unsigned NOT NULL,
  `genre_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

DROP TABLE IF EXISTS `genres`;
CREATE TABLE `genres` (
  `id` bigint(20) unsigned NOT NULL,
  `genre_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=278 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `genres_books`
--

DROP TABLE IF EXISTS `genres_books`;
CREATE TABLE `genres_books` (
  `id` bigint(20) unsigned NOT NULL,
  `genre_id` bigint(20) DEFAULT NULL,
  `book_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=221 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `patrons`
--

DROP TABLE IF EXISTS `patrons`;
CREATE TABLE `patrons` (
  `id` bigint(20) unsigned NOT NULL,
  `patron_name` varchar(255) DEFAULT NULL,
  `contact_info` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=122 DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `authors_books`
--
ALTER TABLE `authors_books`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `book_copies`
--
ALTER TABLE `book_copies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `checkouts`
--
ALTER TABLE `checkouts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `genres_books`
--
ALTER TABLE `genres_books`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `patrons`
--
ALTER TABLE `patrons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `authors`
--
ALTER TABLE `authors`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=309;
--
-- AUTO_INCREMENT for table `authors_books`
--
ALTER TABLE `authors_books`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=221;
--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=309;
--
-- AUTO_INCREMENT for table `book_copies`
--
ALTER TABLE `book_copies`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `checkouts`
--
ALTER TABLE `checkouts`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=573;
--
-- AUTO_INCREMENT for table `genre`
--
ALTER TABLE `genre`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `genres`
--
ALTER TABLE `genres`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=278;
--
-- AUTO_INCREMENT for table `genres_books`
--
ALTER TABLE `genres_books`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=221;
--
-- AUTO_INCREMENT for table `patrons`
--
ALTER TABLE `patrons`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=122;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
