-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 05, 2022 at 03:09 AM
-- Server version: 8.0.31-0ubuntu0.20.04.2
-- PHP Version: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `callandi_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `ASSIGNMENT`
--

CREATE TABLE `ASSIGNMENT` (
  `AssignmentID` int NOT NULL,
  `AssignmentName` varchar(50) NOT NULL,
  `UserID` int NOT NULL,
  `CardID` int NOT NULL,
  `CreateDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

--
-- Dumping data for table `ASSIGNMENT`
--

INSERT INTO `ASSIGNMENT` (`AssignmentID`, `AssignmentName`, `UserID`, `CardID`, `CreateDate`) VALUES
(1, 'New Card', 1, 1, '2022-12-05');

-- --------------------------------------------------------

--
-- Table structure for table `CARD`
--

CREATE TABLE `CARD` (
  `CardID` int NOT NULL,
  `CardName` varchar(50) NOT NULL,
  `Color` varchar(50) NOT NULL,
  `StackID` int NOT NULL,
  `StartDate` date NOT NULL,
  `Active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

--
-- Dumping data for table `CARD`
--

INSERT INTO `CARD` (`CardID`, `CardName`, `Color`, `StackID`, `StartDate`, `Active`) VALUES
(1, 'New Card', '#4e73e0', 7, '2022-12-05', 1);

-- --------------------------------------------------------

--
-- Table structure for table `DEPARTMENT`
--

CREATE TABLE `DEPARTMENT` (
  `DeptID` tinyint NOT NULL,
  `DeptName` varchar(30) NOT NULL,
  `Phone` varchar(13) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

--
-- Dumping data for table `DEPARTMENT`
--

INSERT INTO `DEPARTMENT` (`DeptID`, `DeptName`, `Phone`) VALUES
(1, 'Finance', '(317)111-2222');

-- --------------------------------------------------------

--
-- Table structure for table `DISCUSSION`
--

CREATE TABLE `DISCUSSION` (
  `DiscussionID` int NOT NULL,
  `Name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

-- --------------------------------------------------------

--
-- Table structure for table `DISCUSSION_ACCESS`
--

CREATE TABLE `DISCUSSION_ACCESS` (
  `DiscussionAccessID` int NOT NULL,
  `UserID` int NOT NULL,
  `DiscussionID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

-- --------------------------------------------------------

--
-- Table structure for table `EMPLOYEE`
--

CREATE TABLE `EMPLOYEE` (
  `EID` int NOT NULL,
  `FirstName` varchar(80) NOT NULL,
  `LastName` varchar(80) NOT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `DeptID` tinyint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

-- --------------------------------------------------------

--
-- Table structure for table `FILE`
--

CREATE TABLE `FILE` (
  `FileID` int NOT NULL,
  `FileName` varchar(50) NOT NULL,
  `StackID` int DEFAULT NULL,
  `Attachment` varchar(50) NOT NULL,
  `CreateDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

-- --------------------------------------------------------

--
-- Table structure for table `MESSAGE`
--

CREATE TABLE `MESSAGE` (
  `MessageID` int NOT NULL,
  `MessageText` text NOT NULL,
  `AttachmentFileID` int DEFAULT NULL,
  `DiscussionID` int NOT NULL,
  `CreateDate` date NOT NULL,
  `ExpireDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

-- --------------------------------------------------------

--
-- Table structure for table `NOTIFICATION`
--

CREATE TABLE `NOTIFICATION` (
  `NotificationID` int NOT NULL,
  `Text` varchar(100) NOT NULL,
  `UserID` int NOT NULL,
  `DateNotified` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

-- --------------------------------------------------------

--
-- Table structure for table `PROJECT`
--

CREATE TABLE `PROJECT` (
  `ProjectID` int NOT NULL,
  `Name` varchar(50) NOT NULL,
  `CurrentVersion` varchar(5) NOT NULL,
  `Color` varchar(50) NOT NULL,
  `StartDate` date NOT NULL,
  `Active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

--
-- Dumping data for table `PROJECT`
--

INSERT INTO `PROJECT` (`ProjectID`, `Name`, `CurrentVersion`, `Color`, `StartDate`, `Active`) VALUES
(1, 'Project', '1.0', '#4e73e0', '2022-12-05', 1);

-- --------------------------------------------------------

--
-- Table structure for table `PROJECT_ACCESS`
--

CREATE TABLE `PROJECT_ACCESS` (
  `ProjectAccessID` int NOT NULL,
  `UserID` int NOT NULL,
  `ProjectID` int NOT NULL,
  `AdminPrivilege` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

--
-- Dumping data for table `PROJECT_ACCESS`
--

INSERT INTO `PROJECT_ACCESS` (`ProjectAccessID`, `UserID`, `ProjectID`, `AdminPrivilege`) VALUES
(1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `RELEASE_CONTAINER`
--

CREATE TABLE `RELEASE_CONTAINER` (
  `ReleaseID` int NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Version` varchar(20) NOT NULL,
  `ProjectID` int NOT NULL,
  `ReleaseDate` date NOT NULL,
  `Active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

--
-- Dumping data for table `RELEASE_CONTAINER`
--

INSERT INTO `RELEASE_CONTAINER` (`ReleaseID`, `Name`, `Version`, `ProjectID`, `ReleaseDate`, `Active`) VALUES
(1, 'Current Release - 1.0', '1.0', 3, '2022-12-05', 1),
(2, 'Current Release - 1.0', '1.0', 1, '2022-12-05', 1),
(3, 'New Release - 1.1', '1.1', 1, '2022-12-05', 1);

-- --------------------------------------------------------

--
-- Table structure for table `STACK`
--

CREATE TABLE `STACK` (
  `StackID` int NOT NULL,
  `StackName` varchar(50) NOT NULL,
  `ReleaseContainerID` int NOT NULL,
  `Active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

--
-- Dumping data for table `STACK`
--

INSERT INTO `STACK` (`StackID`, `StackName`, `ReleaseContainerID`, `Active`) VALUES
(1, 'Blocked', 1, 1),
(2, 'In Progress', 1, 1),
(3, 'Done', 1, 1),
(4, 'Blocked', 2, 1),
(5, 'In Progress', 2, 1),
(6, 'Done', 2, 1),
(7, 'Blocked', 3, 1),
(8, 'In Progress', 3, 1),
(9, 'Done', 3, 1),
(10, 'New Stack', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `USER`
--

CREATE TABLE `USER` (
  `UserID` int NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `Gender` varchar(6) CHARACTER SET utf16 COLLATE utf16_general_ci NOT NULL,
  `Position` varchar(50) DEFAULT NULL,
  `StartDate` date NOT NULL,
  `Address` varchar(150) DEFAULT NULL,
  `City` varchar(150) DEFAULT NULL,
  `State` varchar(150) DEFAULT NULL,
  `Active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

--
-- Dumping data for table `USER`
--

INSERT INTO `USER` (`UserID`, `FirstName`, `LastName`, `Username`, `Email`, `Password`, `Gender`, `Position`, `StartDate`, `Address`, `City`, `State`, `Active`) VALUES
(1, 'Caleb', 'Landis', 'callandi', 'callandi@iu.edu', 'test', 'Male', 'Admin', '2022-10-22', '4000 W Street', 'Indianapolis', 'Indiana', 1),
(2, 'Tristan', 'Pickering', 'tpickering', 'tpickering@gmail.com', 'password123456', 'Female', 'Not Admin', '2022-10-22', NULL, NULL, NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ASSIGNMENT`
--
ALTER TABLE `ASSIGNMENT`
  ADD PRIMARY KEY (`AssignmentID`);

--
-- Indexes for table `CARD`
--
ALTER TABLE `CARD`
  ADD PRIMARY KEY (`CardID`);

--
-- Indexes for table `DEPARTMENT`
--
ALTER TABLE `DEPARTMENT`
  ADD PRIMARY KEY (`DeptID`);

--
-- Indexes for table `DISCUSSION`
--
ALTER TABLE `DISCUSSION`
  ADD PRIMARY KEY (`DiscussionID`);

--
-- Indexes for table `DISCUSSION_ACCESS`
--
ALTER TABLE `DISCUSSION_ACCESS`
  ADD PRIMARY KEY (`DiscussionAccessID`),
  ADD KEY `UserID_USER` (`UserID`),
  ADD KEY `DiscussionID_DISCUSSION` (`DiscussionID`);

--
-- Indexes for table `EMPLOYEE`
--
ALTER TABLE `EMPLOYEE`
  ADD PRIMARY KEY (`EID`),
  ADD KEY `DeptID_DEPARTMENT` (`DeptID`);

--
-- Indexes for table `FILE`
--
ALTER TABLE `FILE`
  ADD PRIMARY KEY (`FileID`),
  ADD KEY `StackID_STACK` (`StackID`);

--
-- Indexes for table `MESSAGE`
--
ALTER TABLE `MESSAGE`
  ADD PRIMARY KEY (`MessageID`),
  ADD KEY `FileID_FILE` (`AttachmentFileID`),
  ADD KEY `DiscussionID_DISCUSSION` (`DiscussionID`);

--
-- Indexes for table `NOTIFICATION`
--
ALTER TABLE `NOTIFICATION`
  ADD PRIMARY KEY (`NotificationID`),
  ADD KEY `UserID_USER` (`UserID`) USING BTREE;

--
-- Indexes for table `PROJECT`
--
ALTER TABLE `PROJECT`
  ADD PRIMARY KEY (`ProjectID`);

--
-- Indexes for table `PROJECT_ACCESS`
--
ALTER TABLE `PROJECT_ACCESS`
  ADD PRIMARY KEY (`ProjectAccessID`),
  ADD KEY `UserID_USER` (`UserID`),
  ADD KEY `ProjectID_PROJECT` (`ProjectID`);

--
-- Indexes for table `RELEASE_CONTAINER`
--
ALTER TABLE `RELEASE_CONTAINER`
  ADD PRIMARY KEY (`ReleaseID`),
  ADD KEY `ProjectID_PROJECT` (`ProjectID`);

--
-- Indexes for table `STACK`
--
ALTER TABLE `STACK`
  ADD PRIMARY KEY (`StackID`),
  ADD KEY `ReleaseID_RELEASE_CONTAINER` (`ReleaseContainerID`);

--
-- Indexes for table `USER`
--
ALTER TABLE `USER`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ASSIGNMENT`
--
ALTER TABLE `ASSIGNMENT`
  MODIFY `AssignmentID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `CARD`
--
ALTER TABLE `CARD`
  MODIFY `CardID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `DEPARTMENT`
--
ALTER TABLE `DEPARTMENT`
  MODIFY `DeptID` tinyint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `DISCUSSION`
--
ALTER TABLE `DISCUSSION`
  MODIFY `DiscussionID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `DISCUSSION_ACCESS`
--
ALTER TABLE `DISCUSSION_ACCESS`
  MODIFY `DiscussionAccessID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `EMPLOYEE`
--
ALTER TABLE `EMPLOYEE`
  MODIFY `EID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `FILE`
--
ALTER TABLE `FILE`
  MODIFY `FileID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `MESSAGE`
--
ALTER TABLE `MESSAGE`
  MODIFY `MessageID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `NOTIFICATION`
--
ALTER TABLE `NOTIFICATION`
  MODIFY `NotificationID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `PROJECT`
--
ALTER TABLE `PROJECT`
  MODIFY `ProjectID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `PROJECT_ACCESS`
--
ALTER TABLE `PROJECT_ACCESS`
  MODIFY `ProjectAccessID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `RELEASE_CONTAINER`
--
ALTER TABLE `RELEASE_CONTAINER`
  MODIFY `ReleaseID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `STACK`
--
ALTER TABLE `STACK`
  MODIFY `StackID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `USER`
--
ALTER TABLE `USER`
  MODIFY `UserID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `DISCUSSION_ACCESS`
--
ALTER TABLE `DISCUSSION_ACCESS`
  ADD CONSTRAINT `DISCUSSION_ACCESS_ibfk_1` FOREIGN KEY (`DiscussionID`) REFERENCES `DISCUSSION` (`DiscussionID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `DISCUSSION_ACCESS_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `USER` (`UserID`) ON UPDATE CASCADE;

--
-- Constraints for table `MESSAGE`
--
ALTER TABLE `MESSAGE`
  ADD CONSTRAINT `MESSAGE_ibfk_1` FOREIGN KEY (`DiscussionID`) REFERENCES `DISCUSSION` (`DiscussionID`) ON UPDATE CASCADE;

--
-- Constraints for table `NOTIFICATION`
--
ALTER TABLE `NOTIFICATION`
  ADD CONSTRAINT `NOTIFICATION_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `USER` (`UserID`) ON UPDATE CASCADE;

--
-- Constraints for table `PROJECT_ACCESS`
--
ALTER TABLE `PROJECT_ACCESS`
  ADD CONSTRAINT `PROJECT_ACCESS_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `USER` (`UserID`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
