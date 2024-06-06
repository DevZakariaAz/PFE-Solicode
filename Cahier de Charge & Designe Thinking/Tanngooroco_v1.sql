-- Dumping structure for table `admin`
CREATE TABLE `admin` (
  `adminid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`adminid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping structure for table `category`
CREATE TABLE `category` (
  `categoryid` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(255) NOT NULL,
  PRIMARY KEY (`categoryid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping structure for table `category_publication`
CREATE TABLE `category_publication` (
  `publicationid` int(11) NOT NULL,
  `categoryid` int(11) NOT NULL,
  PRIMARY KEY (`publicationid`,`categoryid`),
  KEY `categoryid` (`categoryid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping structure for table `cuisine`
CREATE TABLE `cuisine` (
  `cuisineid` int(11) NOT NULL AUTO_INCREMENT,
  `description` text DEFAULT NULL,
  `nationalite` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`cuisineid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping structure for table `publication`
CREATE TABLE `publication` (
  `publicationid` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `coverimage` varchar(255) DEFAULT NULL,
  `cuisineid` int(11) DEFAULT NULL,
  PRIMARY KEY (`publicationid`),
  KEY `cuisineid` (`cuisineid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping structure for table `review`
CREATE TABLE `review` (
  `reviewid` int(11) NOT NULL AUTO_INCREMENT,
  `rating` int(11) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `publicationid` int(11) DEFAULT NULL,
  PRIMARY KEY (`reviewid`),
  KEY `userid` (`userid`),
  KEY `publicationid` (`publicationid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping structure for table `user`
CREATE TABLE `user` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `coverimage` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping foreign key constraints for table `category_publication`
ALTER TABLE `category_publication`
  ADD CONSTRAINT `category_publication_ibfk_1` FOREIGN KEY (`publicationid`) REFERENCES `publication` (`publicationid`),
  ADD CONSTRAINT `category_publication_ibfk_2` FOREIGN KEY (`categoryid`) REFERENCES `category` (`categoryid`);

-- Dumping foreign key constraints for table `publication`
ALTER TABLE `publication`
  ADD CONSTRAINT `publication_ibfk_2` FOREIGN KEY (`cuisineid`) REFERENCES `cuisine` (`cuisineid`);

-- Dumping foreign key constraints for table `review`
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`),
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`publicationid`) REFERENCES `publication` (`publicationid`);

-- Dumping data for table `admin`
INSERT INTO `admin` (`username`, `email`, `password`)
VALUES 
('admin1', 'admin1@example.com', 'adminpassword123'),
('admin2', 'admin2@example.com', 'adminpassword456');

-- Dumping data for table `category`
INSERT INTO `category` (`category`)
VALUES 
('Historical Site'),
('Landmark');

-- Dumping data for table `cuisine`
INSERT INTO `cuisine` (`description`, `nationalite`)
VALUES 
('French cuisine includes dishes like croissants and escargot', 'French'),
('Mexican cuisine includes dishes like tacos and burritos', 'Mexican');

-- Dumping data for table `publication`
INSERT INTO `publication` (`titre`, `description`, `type`, `location`, `coverimage`, `cuisineid`)
VALUES 
('Chichen Itza', 'A famous historical site.', 'destination', 'Yucatán, Mexico', 'chichenitza.jpg', NULL),
('Great Wall of China', 'A historic fortification.', 'destination', 'China', 'greatwall.jpg', NULL),
('Statue of Liberty', 'A symbol of freedom.', 'destination', 'New York, USA', 'statueofliberty.jpg', NULL),
('Machu Picchu', 'An ancient Incan city.', 'destination', 'Cusco, Peru', 'machupicchu.jpg', NULL),
('Eiffel Tower', 'An iconic Parisian landmark.', 'destination', 'Paris, France', 'eiffeltower.jpg', NULL);

-- Dumping data for table `category_publication`
-- Note: Adjust the publication IDs according to the order they were inserted, assuming they are auto-incremented sequentially.
INSERT INTO `category_publication` (`publicationid`, `categoryid`)
VALUES 
(1, 2),  -- Chichen Itza as a Landmark
(2, 2),  -- Great Wall of China as a Landmark
(3, 2),  -- Statue of Liberty as a Landmark
(4, 1),  -- Machu Picchu as a Historical Site
(5, 2);  -- Eiffel Tower as a Landmark

-- Dumping data for table `review`
INSERT INTO `review` (`rating`, `comment`, `userid`, `publicationid`)
VALUES 
(4, 'A must-see for history lovers.', 1, 1),      -- Review for Chichen Itza
(5, 'Breathtaking views.', 2, 2),                 -- Review for Great Wall of China
(5, 'Iconic and inspiring.', 1, 3),               -- Review for Statue of Liberty
(5, 'Incredible historical site.', 2, 4),         -- Review for Machu Picchu
(5, 'Magnificent and iconic.', 1, 5);             -- Review for Eiffel Tower

-- Dumping data for table `user`
INSERT INTO `user` (`username`, `email`, `password`, `coverimage`)
VALUES 
('user1', 'user1@example.com', 'userpassword123', 'user1.jpg'),
('user2', 'user2@example.com', 'userpassword456', 'user2.jpg'),
('user3', 'user3@example.com', 'userpassword789', 'user3.jpg'),
('user4', 'user4@example.com', 'userpassword101112', 'user4');
