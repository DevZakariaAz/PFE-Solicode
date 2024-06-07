-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2024 at 03:23 PM
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
-- Database: `tangorocco_v1`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adminid` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adminid`, `username`, `email`, `password`) VALUES
(1, 'admin1', 'admin1@example.com', 'password1'),
(2, 'admin2', 'admin2@example.com', 'password2'),
(3, 'admin3', 'admin3@example.com', 'password3');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `categoryid` int(11) NOT NULL,
  `category` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`categoryid`, `category`) VALUES
(1, 'Historical'),
(2, 'Nature'),
(3, 'Cultural'),
(4, 'Culinary');

-- --------------------------------------------------------

--
-- Table structure for table `category_publication`
--

CREATE TABLE `category_publication` (
  `publicationid` int(11) NOT NULL,
  `categoryid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category_publication`
--

INSERT INTO `category_publication` (`publicationid`, `categoryid`) VALUES
(1, 1),
(1, 2),
(2, 1),
(2, 3),
(3, 3),
(4, 2),
(5, 1),
(5, 3),
(6, 3),
(7, 4),
(8, 4),
(9, 4),
(10, 4),
(11, 4),
(12, 4);

-- --------------------------------------------------------

--
-- Table structure for table `cuisine`
--

CREATE TABLE `cuisine` (
  `cuisineid` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `nationalite` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cuisine`
--

INSERT INTO `cuisine` (`cuisineid`, `description`, `nationalite`) VALUES
(1, 'Traditional Moroccan', 'Moroccan'),
(2, 'French Cuisine', 'French'),
(3, 'Italian Cuisine', 'Italian');

-- --------------------------------------------------------

--
-- Table structure for table `publication`
--

CREATE TABLE `publication` (
  `publicationid` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `coverimage` varchar(255) DEFAULT NULL,
  `cuisineid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `publication`
--

INSERT INTO `publication` (`publicationid`, `titre`, `description`, `type`, `location`, `coverimage`, `cuisineid`) VALUES
(1, 'Cap Spartel', 'A picturesque cape located on the Atlantic coast near Tangier. Cap Spartel offers stunning panoramic views of the sea and the surrounding landscape.', 'destination', 'Tangier', 'Cap_Spartel.png', NULL),
(2, 'Old Medina', 'The historic heart of Tangier, Old Medina is a labyrinth of narrow streets, bustling souks, and ancient architecture. Explore its winding alleys and discover hidden gems at every turn.', 'destination', 'Tangier', 'Old_Medina.png', NULL),
(3, 'Mosque Lalla Abla', 'A tranquil oasis of spirituality, Mosque Lalla Abla is known for its serene ambiance and exquisite Islamic architecture. Visitors can experience a sense of peace and reflection within its sacred walls.', 'destination', 'Tangier', 'Mosque_Lalla_Abla.png', NULL),
(4, 'Hercules Caves', 'Steeped in myth and legend, Hercules Caves are a natural wonder located along the coast of Tangier. Explore the caverns and marvel at the impressive rock formations that have captivated visitors for centuries.', 'destination', 'Tangier', 'Hercules_Caves.png', NULL),
(5, 'Tangier American Legation', 'A symbol of historic diplomacy, the Tangier American Legation is the only National Historic Landmark located outside of the United States. Discover its rich heritage and cultural significance.', 'destination', 'Tangier', 'American_Legation.png', NULL),
(6, 'Grand Socco', 'At the heart of Tangier lies Grand Socco, a bustling square where locals and tourists converge. Experience the vibrant energy of this lively marketplace and immerse yourself in the sights and sounds of Moroccan culture.', 'destination', 'Tangier', 'Grand_Socco.png', NULL),
(7, 'RR Ice', 'Cool off with a sweet treat at RR Ice, a popular ice cream shop beloved by locals and visitors alike. Indulge in a variety of flavors and enjoy refreshing desserts in a relaxed atmosphere.', 'restaurant', 'Tangier', 'RR_Ice.png', 1),
(8, 'El Morocco Club', 'Experience fine dining at its best at El Morocco Club, where culinary excellence meets Moroccan hospitality. Savor exquisite dishes crafted from the freshest ingredients and immerse yourself in a world of luxury.', 'restaurant', 'Tangier', 'El_Morocco_Club.png', 2),
(9, 'Cafe Hafa', 'Perched on a cliff overlooking the Strait of Gibraltar, Cafe Hafa offers breathtaking views and a charming ambiance. Relax with a cup of tea or coffee and soak in the beauty of the Mediterranean.', 'restaurant', 'Tangier', 'Cafe_Hafa.png', 1),
(10, 'Le Saveur du Poisson', 'Embark on a culinary journey at Le Saveur du Poisson, where the flavors of the sea come to life in every dish. Delight in the freshest seafood and savor the taste of Morocco with each bite.', 'restaurant', 'Tangier', 'Le_Saveur_du_Poisson.png', 1),
(11, 'Restaurant Rif Kebdani', 'Savor the authentic flavors of Morocco at Restaurant Rif Kebdani, a hidden gem known for its traditional cuisine and warm hospitality. Enjoy a taste of local culture in every mouthwatering dish.', 'restaurant', 'Tangier', 'Restaurant_Rif_Kebdani.png', 1),
(12, 'Anna & Paolo', 'Transport your taste buds to Italy at Anna & Paolo, where the essence of Italian cuisine is celebrated in every bite. From classic pasta dishes to artisanal pizzas, experience the flavors of Italy in Tangier.', 'restaurant', 'Tangier', 'Anna_and_Paolo.png', 3);

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `reviewid` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `publicationid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`reviewid`, `rating`, `comment`, `userid`, `publicationid`) VALUES
(1, 4, 'Beautiful views and great place to visit.', 1, 1),
(2, 5, 'A must-see historical site.', 2, 2),
(3, 4, 'Very peaceful and spiritual place.', 3, 3),
(4, 3, 'Interesting but crowded.', 4, 4),
(5, 5, 'Great insight into history and culture.', 5, 5),
(6, 4, 'Nice place to hang out.', 1, 6),
(7, 5, 'Amazing ice cream!', 2, 7),
(8, 5, 'Elegant dining experience.', 3, 8),
(9, 4, 'Wonderful sea views while enjoying coffee.', 4, 9),
(10, 5, 'Best seafood in Tangier!', 5, 10),
(11, 4, 'Delicious traditional Moroccan food.', 1, 11),
(12, 5, 'Authentic Italian cuisine.', 2, 12),
(13, 4, 'Great place!', 1, 1),
(14, 5, 'Amazing experience!', 2, 2),
(15, 3, 'Decent food but service could be better', 3, 3),
(28, 4, 'Great place!', 1, 1),
(29, 5, 'Amazing experience!', 2, 2),
(30, 3, 'Decent food but service could be better', 3, 3),
(31, 4, 'Beautiful view!', 4, 1),
(32, 5, 'Delicious food!', 5, 2),
(33, 4, 'Friendly staff!', 6, 3),
(34, 3, 'Disappointed with the cleanliness', 7, 1),
(35, 4, 'Good ambiance', 8, 2),
(36, 5, 'Best experience ever!', 9, 3),
(37, 2, 'Not worth the price', 10, 1),
(38, 5, 'Highly recommended!', 11, 2),
(39, 4, 'Great place for families', 12, 3);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userid` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `coverimage` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userid`, `username`, `email`, `password`, `coverimage`) VALUES
(1, 'Ahmed', 'ahmed@example.com', 'password1', 'cover1.jpg'),
(2, 'Adam', 'adam@example.com', 'password2', 'cover2.jpg'),
(3, 'Zakaria', 'zakaria@example.com', 'password3', 'cover3.jpg'),
(4, 'Sarah', 'sarah@example.com', 'password4', 'cover4.jpg'),
(5, 'Fatima', 'fatima@example.com', 'password5', 'cover5.jpg'),
(6, 'Oussama', 'oussama@example.com', 'password123', 'oussama.jpg'),
(7, 'Akram', 'akram@example.com', 'password456', 'akram.jpg'),
(8, 'Jalal', 'jalal@example.com', 'password789', 'jalal.jpg'),
(9, 'Mariam', 'mariam@example.com', 'passwordabc', 'mariam.jpg'),
(10, 'Aya', 'aya@example.com', 'passworddef', 'aya.jpg'),
(11, 'Ikram', 'ikram@example.com', 'passwordghi', 'ikram.jpg'),
(12, 'Khouala', 'khouala@example.com', 'passwordjkl', 'khouala.jpg'),
(13, 'Ilyass', 'ilyass@example.com', 'passwordmno', 'ilyass.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adminid`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`categoryid`);

--
-- Indexes for table `category_publication`
--
ALTER TABLE `category_publication`
  ADD PRIMARY KEY (`publicationid`,`categoryid`),
  ADD KEY `categoryid` (`categoryid`);

--
-- Indexes for table `cuisine`
--
ALTER TABLE `cuisine`
  ADD PRIMARY KEY (`cuisineid`);

--
-- Indexes for table `publication`
--
ALTER TABLE `publication`
  ADD PRIMARY KEY (`publicationid`),
  ADD KEY `cuisineid` (`cuisineid`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`reviewid`),
  ADD KEY `userid` (`userid`),
  ADD KEY `publicationid` (`publicationid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `adminid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `categoryid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cuisine`
--
ALTER TABLE `cuisine`
  MODIFY `cuisineid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `publication`
--
ALTER TABLE `publication`
  MODIFY `publicationid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `reviewid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `category_publication`
--
ALTER TABLE `category_publication`
  ADD CONSTRAINT `category_publication_ibfk_1` FOREIGN KEY (`publicationid`) REFERENCES `publication` (`publicationid`),
  ADD CONSTRAINT `category_publication_ibfk_2` FOREIGN KEY (`categoryid`) REFERENCES `category` (`categoryid`);

--
-- Constraints for table `publication`
--
ALTER TABLE `publication`
  ADD CONSTRAINT `publication_ibfk_2` FOREIGN KEY (`cuisineid`) REFERENCES `cuisine` (`cuisineid`);

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`),
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`publicationid`) REFERENCES `publication` (`publicationid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
