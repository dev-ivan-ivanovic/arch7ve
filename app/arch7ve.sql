-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 06, 2021 at 11:54 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `arch7ve`
--

-- --------------------------------------------------------

--
-- Table structure for table `t_group`
--

CREATE TABLE `t_group` (
  `cGroup` varchar(32) NOT NULL,
  `cGroupHost` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `t_group_access_control`
--

CREATE TABLE `t_group_access_control` (
  `cUser` varchar(32) NOT NULL,
  `cHost` varchar(32) NOT NULL,
  `cGroup` varchar(32) NOT NULL,
  `cGroupHost` varchar(32) NOT NULL,
  `cSelect` char(1) NOT NULL DEFAULT 'N',
  `cInsert` char(1) NOT NULL DEFAULT 'N',
  `cUpdate` char(1) NOT NULL DEFAULT 'N',
  `cDelete` char(1) NOT NULL DEFAULT 'N',
  `cSuperuser` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `t_note`
--

CREATE TABLE `t_note` (
  `cText` varchar(2000) NOT NULL,
  `cDate` date NOT NULL DEFAULT current_timestamp(),
  `cUser` varchar(32) NOT NULL,
  `cHost` varchar(32) NOT NULL,
  `cGroup` varchar(32) NOT NULL,
  `cGroupHost` varchar(32) NOT NULL,
  `cBatch` char(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `t_table_access_control`
--

CREATE TABLE `t_table_access_control` (
  `cUser` varchar(32) NOT NULL,
  `cHost` varchar(32) NOT NULL,
  `cTable` varchar(32) NOT NULL,
  `cSelect` char(1) NOT NULL DEFAULT 'N',
  `cInsert` char(1) NOT NULL DEFAULT 'N',
  `cUpdate` char(1) NOT NULL DEFAULT 'N',
  `cDelete` char(1) NOT NULL DEFAULT 'N',
  `cDrop` char(1) NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_table_access_control`
--

INSERT INTO `t_table_access_control` (`cUser`, `cHost`, `cTable`, `cSelect`, `cInsert`, `cUpdate`, `cDelete`, `cDrop`) VALUES
('admin', 'localhost', 't_group', 'Y', 'Y', 'Y', 'Y', 'N'),
('admin', 'localhost', 't_group_access_control', 'Y', 'Y', 'Y', 'Y', 'N'),
('admin', 'localhost', 't_note', 'Y', 'Y', 'Y', 'Y', 'N'),
('admin', 'localhost', 't_upload', 'Y', 'Y', 'Y', 'Y', 'N'),
('admin', 'localhost', 't_user', 'Y', 'Y', 'Y', 'Y', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `t_upload`
--

CREATE TABLE `t_upload` (
  `cName` varchar(32) NOT NULL,
  `cType` varchar(32) NOT NULL,
  `cSize` bigint(20) UNSIGNED NOT NULL,
  `cPath` varchar(255) NOT NULL,
  `cUser` varchar(32) NOT NULL,
  `cHost` varchar(32) NOT NULL,
  `cBatch` char(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `t_user`
--

CREATE TABLE `t_user` (
  `cUser` varchar(32) NOT NULL,
  `cHost` varchar(32) NOT NULL,
  `cAuth` char(64) NOT NULL,
  `cSuperuser` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_user`
--

INSERT INTO `t_user` (`cUser`, `cHost`, `cAuth`, `cSuperuser`) VALUES
('admin', 'localhost', '4ca20d3214e4830290a0aaa2705142fc415bea149388001c483931cd3f4ea32e', 'Y');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_group`
--
ALTER TABLE `t_group`
  ADD PRIMARY KEY (`cGroup`,`cGroupHost`);
ALTER TABLE `t_group` ADD FULLTEXT KEY `cGroup` (`cGroup`);

--
-- Indexes for table `t_group_access_control`
--
ALTER TABLE `t_group_access_control`
  ADD PRIMARY KEY (`cUser`,`cHost`,`cGroup`,`cGroupHost`);
ALTER TABLE `t_group_access_control` ADD FULLTEXT KEY `cUser` (`cUser`,`cGroup`);

--
-- Indexes for table `t_note`
--
ALTER TABLE `t_note`
  ADD PRIMARY KEY (`cBatch`);
ALTER TABLE `t_note` ADD FULLTEXT KEY `cText` (`cText`,`cUser`,`cGroup`);

--
-- Indexes for table `t_table_access_control`
--
ALTER TABLE `t_table_access_control`
  ADD PRIMARY KEY (`cUser`,`cHost`,`cTable`);

--
-- Indexes for table `t_user`
--
ALTER TABLE `t_user`
  ADD PRIMARY KEY (`cUser`,`cHost`);
ALTER TABLE `t_user` ADD FULLTEXT KEY `cUser` (`cUser`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
