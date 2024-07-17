-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 17, 2024 at 08:28 AM
-- Server version: 10.6.18-MariaDB-cll-lve
-- PHP Version: 8.1.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `midscblk_school_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `Classes`
--

CREATE TABLE `Classes` (
  `ClassID` int(11) NOT NULL,
  `ClassName` varchar(255) NOT NULL,
  `Capacity` int(11) NOT NULL,
  `TeacherID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `Classes`
--

INSERT INTO `Classes` (`ClassID`, `ClassName`, `Capacity`, `TeacherID`) VALUES
(1, 'Reception Year', 30, 1),
(2, 'Year One', 30, 2),
(3, 'Year Two', 30, NULL),
(4, 'Year Three', 30, NULL),
(5, 'Year Four', 30, NULL),
(6, 'Year Five', 30, NULL),
(7, 'Year Six', 30, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `DinnerMoney`
--

CREATE TABLE `DinnerMoney` (
  `DinnerMoneyID` int(11) NOT NULL,
  `PupilID` int(11) DEFAULT NULL,
  `Amount` decimal(10,2) NOT NULL,
  `PaymentDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `DinnerMoney`
--

INSERT INTO `DinnerMoney` (`DinnerMoneyID`, `PupilID`, `Amount`, `PaymentDate`) VALUES
(1, 1, 3.00, '2024-01-01'),
(2, 2, 2.50, '2024-01-01');

-- --------------------------------------------------------

--
-- Table structure for table `LibraryBooks`
--

CREATE TABLE `LibraryBooks` (
  `BookID` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Author` varchar(255) NOT NULL,
  `ISBN` varchar(255) DEFAULT NULL,
  `AvailableCopies` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `LibraryBooks`
--

INSERT INTO `LibraryBooks` (`BookID`, `Title`, `Author`, `ISBN`, `AvailableCopies`) VALUES
(1, 'The Great Gatsby', 'F. Scott Fitzgerald', '9780743273565', 5),
(2, 'To Kill a Mockingbird', 'Harper Lee', '9780061120084', 3);

-- --------------------------------------------------------

--
-- Table structure for table `Parents`
--

CREATE TABLE `Parents` (
  `ParentID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Phone` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `Parents`
--

INSERT INTO `Parents` (`ParentID`, `Name`, `Address`, `Email`, `Phone`) VALUES
(1, 'David Johnson', '789 Pine St', 'david.johnson@example.com', '111-222-3333'),
(2, 'Emma Brown', '321 Maple St', 'emma.brown@example.com', '444-555-6666');

-- --------------------------------------------------------

--
-- Table structure for table `PupilParent`
--

CREATE TABLE `PupilParent` (
  `PupilID` int(11) NOT NULL,
  `ParentID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `PupilParent`
--

INSERT INTO `PupilParent` (`PupilID`, `ParentID`) VALUES
(1, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `Pupils`
--

CREATE TABLE `Pupils` (
  `PupilID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `MedicalInfo` text NOT NULL,
  `ClassID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `Pupils`
--

INSERT INTO `Pupils` (`PupilID`, `Name`, `Address`, `MedicalInfo`, `ClassID`) VALUES
(1, 'Alice Johnson', '789 Pine St', 'None', 1),
(2, 'Bob Brown', '321 Maple St', 'Asthma', 2);

-- --------------------------------------------------------

--
-- Table structure for table `Salaries`
--

CREATE TABLE `Salaries` (
  `SalaryID` int(11) NOT NULL,
  `StaffType` varchar(255) NOT NULL,
  `StaffID` int(11) NOT NULL,
  `Amount` decimal(10,2) NOT NULL,
  `PaymentDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `Salaries`
--

INSERT INTO `Salaries` (`SalaryID`, `StaffType`, `StaffID`, `Amount`, `PaymentDate`) VALUES
(1, 'Teacher', 1, 5000.00, '2024-01-01'),
(2, 'TeachingAssistant', 1, 3000.00, '2024-01-01');

-- --------------------------------------------------------

--
-- Table structure for table `Teachers`
--

CREATE TABLE `Teachers` (
  `TeacherID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Phone` varchar(255) DEFAULT NULL,
  `AnnualSalary` decimal(10,2) DEFAULT NULL,
  `BackgroundCheck` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `Teachers`
--

INSERT INTO `Teachers` (`TeacherID`, `Name`, `Address`, `Phone`, `AnnualSalary`, `BackgroundCheck`) VALUES
(1, 'John Doe', '123 Main St', '123-456-7890', 50000.00, 'Clear'),
(2, 'Jane Smith', '456 Oak St', '987-654-3210', 55000.00, 'Clear');

-- --------------------------------------------------------

--
-- Table structure for table `TeachingAssistants`
--

CREATE TABLE `TeachingAssistants` (
  `TAID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Phone` varchar(255) DEFAULT NULL,
  `Salary` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `TeachingAssistants`
--

INSERT INTO `TeachingAssistants` (`TAID`, `Name`, `Address`, `Phone`, `Salary`) VALUES
(1, 'Tom White', '654 Elm St', '555-123-4567', 30000.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Classes`
--
ALTER TABLE `Classes`
  ADD PRIMARY KEY (`ClassID`),
  ADD KEY `TeacherID` (`TeacherID`);

--
-- Indexes for table `DinnerMoney`
--
ALTER TABLE `DinnerMoney`
  ADD PRIMARY KEY (`DinnerMoneyID`),
  ADD KEY `PupilID` (`PupilID`);

--
-- Indexes for table `LibraryBooks`
--
ALTER TABLE `LibraryBooks`
  ADD PRIMARY KEY (`BookID`);

--
-- Indexes for table `Parents`
--
ALTER TABLE `Parents`
  ADD PRIMARY KEY (`ParentID`);

--
-- Indexes for table `PupilParent`
--
ALTER TABLE `PupilParent`
  ADD PRIMARY KEY (`PupilID`,`ParentID`),
  ADD KEY `ParentID` (`ParentID`);

--
-- Indexes for table `Pupils`
--
ALTER TABLE `Pupils`
  ADD PRIMARY KEY (`PupilID`),
  ADD KEY `ClassID` (`ClassID`);

--
-- Indexes for table `Salaries`
--
ALTER TABLE `Salaries`
  ADD PRIMARY KEY (`SalaryID`);

--
-- Indexes for table `Teachers`
--
ALTER TABLE `Teachers`
  ADD PRIMARY KEY (`TeacherID`);

--
-- Indexes for table `TeachingAssistants`
--
ALTER TABLE `TeachingAssistants`
  ADD PRIMARY KEY (`TAID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Classes`
--
ALTER TABLE `Classes`
  MODIFY `ClassID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `DinnerMoney`
--
ALTER TABLE `DinnerMoney`
  MODIFY `DinnerMoneyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `LibraryBooks`
--
ALTER TABLE `LibraryBooks`
  MODIFY `BookID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `Parents`
--
ALTER TABLE `Parents`
  MODIFY `ParentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `Pupils`
--
ALTER TABLE `Pupils`
  MODIFY `PupilID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `Salaries`
--
ALTER TABLE `Salaries`
  MODIFY `SalaryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `Teachers`
--
ALTER TABLE `Teachers`
  MODIFY `TeacherID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `TeachingAssistants`
--
ALTER TABLE `TeachingAssistants`
  MODIFY `TAID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Classes`
--
ALTER TABLE `Classes`
  ADD CONSTRAINT `Classes_ibfk_1` FOREIGN KEY (`TeacherID`) REFERENCES `Teachers` (`TeacherID`);

--
-- Constraints for table `DinnerMoney`
--
ALTER TABLE `DinnerMoney`
  ADD CONSTRAINT `DinnerMoney_ibfk_1` FOREIGN KEY (`PupilID`) REFERENCES `Pupils` (`PupilID`);

--
-- Constraints for table `PupilParent`
--
ALTER TABLE `PupilParent`
  ADD CONSTRAINT `PupilParent_ibfk_1` FOREIGN KEY (`PupilID`) REFERENCES `Pupils` (`PupilID`),
  ADD CONSTRAINT `PupilParent_ibfk_2` FOREIGN KEY (`ParentID`) REFERENCES `Parents` (`ParentID`);

--
-- Constraints for table `Pupils`
--
ALTER TABLE `Pupils`
  ADD CONSTRAINT `Pupils_ibfk_1` FOREIGN KEY (`ClassID`) REFERENCES `Classes` (`ClassID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
