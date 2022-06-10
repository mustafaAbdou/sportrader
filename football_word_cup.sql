-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 10, 2022 at 02:21 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `football_word_cup`
--

-- --------------------------------------------------------

--
-- Table structure for table `lega_stage`
--

CREATE TABLE `lega_stage` (
  `id` int(9) NOT NULL,
  `scope` varchar(225) NOT NULL,
  `numOfGames` int(11) NOT NULL,
  `numOfTeams` int(11) NOT NULL,
  `dateCreated` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lega_stage`
--

INSERT INTO `lega_stage` (`id`, `scope`, `numOfGames`, `numOfTeams`, `dateCreated`) VALUES
(1, 'final world cup', 1, 2, '2022-06-10 07:53:57'),
(2, 'semi-final world cup', 2, 4, '2022-06-10 07:53:59'),
(3, 'Quarter-finals world cup', 4, 8, '2022-06-10 07:54:01'),
(4, 'stage 2', 8, 16, '2022-06-10 08:15:35');

-- --------------------------------------------------------

--
-- Table structure for table `live_score_board`
--

CREATE TABLE `live_score_board` (
  `id` int(10) NOT NULL,
  `matchID` int(10) NOT NULL,
  `teamAscore` int(2) NOT NULL DEFAULT 0,
  `teamBscore` int(2) DEFAULT 0,
  `matchResault` varchar(50) GENERATED ALWAYS AS (case when `teamAscore` < `teamBscore` then 'B win' when `teamAscore` > `teamBscore` then 'A win' when `teamAscore` = `teamBscore` then 'Draw' end) STORED,
  `dateCreate` timestamp NOT NULL DEFAULT current_timestamp(),
  `dateModified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `live_score_board`
--

INSERT INTO `live_score_board` (`id`, `matchID`, `teamAscore`, `teamBscore`, `dateCreate`, `dateModified`) VALUES
(1, 1, 6, 6, '2022-06-10 08:29:16', '2022-06-10 08:30:08'),
(2, 2, 10, 2, '2022-06-10 08:29:16', '2022-06-10 08:30:13'),
(3, 3, 0, 5, '2022-06-10 08:29:45', '2022-06-10 08:30:17'),
(4, 4, 3, 1, '2022-06-10 08:29:45', '2022-06-10 08:30:23'),
(5, 5, 2, 2, '2022-06-10 08:29:45', '2022-06-10 08:30:29');

-- --------------------------------------------------------

--
-- Table structure for table `matches`
--

CREATE TABLE `matches` (
  `id` int(10) NOT NULL,
  `scopeLegaStage` int(9) NOT NULL,
  `teamA` int(10) NOT NULL,
  `teamB` int(10) NOT NULL,
  `matchStartDate` timestamp NULL DEFAULT current_timestamp(),
  `matchEndDate` timestamp NULL DEFAULT NULL,
  `place` varchar(20) DEFAULT NULL,
  `dateCreated` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `matches`
--

INSERT INTO `matches` (`id`, `scopeLegaStage`, `teamA`, `teamB`, `matchStartDate`, `matchEndDate`, `place`, `dateCreated`) VALUES
(1, 4, 19, 20, '2022-06-10 08:17:59', NULL, 'Qatar stadium 1', '2022-06-10 08:17:59'),
(2, 4, 15, 16, '2022-06-10 08:17:59', NULL, 'Qatar stadium 2', '2022-06-10 08:17:59'),
(3, 4, 13, 14, '2022-06-11 08:17:59', NULL, 'Qatar stadium 3', '2022-06-10 08:17:59'),
(4, 4, 21, 22, '2022-06-11 08:17:59', NULL, 'Qatar stadium 4', '2022-06-10 08:17:59'),
(5, 4, 17, 18, '2022-06-12 08:17:59', NULL, 'Qatar stadium 5', '2022-06-10 08:17:59');

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `id` int(10) NOT NULL,
  `uid` int(9) DEFAULT NULL,
  `name` varchar(225) DEFAULT NULL,
  `dateCreated` timestamp NULL DEFAULT current_timestamp(),
  `dateModified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`id`, `uid`, `name`, `dateCreated`, `dateModified`) VALUES
(13, 179292, 'Mexico', '2022-06-10 07:38:40', '2022-06-10 07:39:41'),
(14, 933480, 'Canada', '2022-06-10 07:38:40', '2022-06-10 07:39:53'),
(15, 614676, 'Spain', '2022-06-10 07:40:33', '2022-06-10 07:40:33'),
(16, 595679, 'Brazil', '2022-06-10 07:40:33', '2022-06-10 07:40:33'),
(17, 134366, 'Germany', '2022-06-10 07:40:33', '2022-06-10 07:40:33'),
(18, 884793, 'France', '2022-06-10 07:40:33', '2022-06-10 07:40:33'),
(19, 20870, 'Uruguay', '2022-06-10 07:40:33', '2022-06-10 07:40:33'),
(20, 449969, 'Italy', '2022-06-10 07:40:33', '2022-06-10 07:40:33'),
(21, 187235, 'Argentina', '2022-06-10 07:40:33', '2022-06-10 07:40:33'),
(22, 586269, 'Australia', '2022-06-10 07:40:33', '2022-06-10 07:40:33');

--
-- Triggers `teams`
--
DELIMITER $$
CREATE TRIGGER `random_uid` BEFORE INSERT ON `teams` FOR EACH ROW BEGIN
    SET new.uid = (SELECT LPAD(FLOOR(RAND() * 999999.99), 9, '0'));
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lega_stage`
--
ALTER TABLE `lega_stage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `live_score_board`
--
ALTER TABLE `live_score_board`
  ADD PRIMARY KEY (`id`),
  ADD KEY `matchID` (`matchID`);

--
-- Indexes for table `matches`
--
ALTER TABLE `matches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `scopeLegaStage` (`scopeLegaStage`),
  ADD KEY `teamA` (`teamA`),
  ADD KEY `teamB` (`teamB`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lega_stage`
--
ALTER TABLE `lega_stage`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `live_score_board`
--
ALTER TABLE `live_score_board`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `matches`
--
ALTER TABLE `matches`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `live_score_board`
--
ALTER TABLE `live_score_board`
  ADD CONSTRAINT `live_score_board_ibfk_1` FOREIGN KEY (`matchID`) REFERENCES `matches` (`id`);

--
-- Constraints for table `matches`
--
ALTER TABLE `matches`
  ADD CONSTRAINT `matches_ibfk_1` FOREIGN KEY (`teamA`) REFERENCES `teams` (`id`),
  ADD CONSTRAINT `matches_ibfk_2` FOREIGN KEY (`teamB`) REFERENCES `teams` (`id`),
  ADD CONSTRAINT `matches_ibfk_3` FOREIGN KEY (`scopeLegaStage`) REFERENCES `lega_stage` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
