-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 18, 2024 at 06:36 AM
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
-- Database: `games_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrators`
--

CREATE TABLE `administrators` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `administrators`
--

INSERT INTO `administrators` (`admin_id`, `username`, `email`, `password`, `created_at`) VALUES
(1, 'MochammadRealdy', 'aldyap17403@gmail.com', 'password123', '2024-06-10 05:53:25'),
(2, 'StevenNugroho', 'stevennugroho@example.com', 'ubjqwiubfouq213', '2024-06-10 05:54:19');

-- --------------------------------------------------------

--
-- Table structure for table `admin_reviews`
--

CREATE TABLE `admin_reviews` (
  `review_id` int(11) NOT NULL,
  `game_id` char(5) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `review_text` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `game_id` char(5) NOT NULL CHECK (`game_id` regexp '^[0-9][0-9][0-9][0-9]$'),
  `game_name` varchar(100) NOT NULL,
  `steam_link` varchar(255) DEFAULT NULL,
  `epicgames_link` varchar(255) DEFAULT NULL,
  `other_link` varchar(255) DEFAULT NULL,
  `game_image` varchar(255) DEFAULT NULL,
  `accessibility_category` set('colorblind','deaf','non-inclusive','colorblind-deaf') NOT NULL DEFAULT 'non-inclusive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`game_id`, `game_name`, `steam_link`, `epicgames_link`, `other_link`, `game_image`, `accessibility_category`) VALUES
('1001', 'Lethal Company', 'https://store.steampowered.com/app/1966720/Lethal_Company/', NULL, NULL, 'https://shared.akamai.steamstatic.com/store_item_assets/steam/apps/1966720/capsule_616x353.jpg?t=1700231592', 'non-inclusive'),
('1002', 'Five Nights at Freddy\'s: Sister Location', 'https://store.steampowered.com/app/506610/Five_Nights_at_Freddys_Sister_Location/', NULL, 'www.xbox.com/games/store/five-nights-at-freddys-sister-location/9ndh606jxlwj', 'https://store-images.s-microsoft.com/image/apps.22637.13548731491092101.6235d68d-70f8-4721-b320-8a2dd5ee8939.14e4f8c4-a683-4530-8cb8-157c50d64066?q=90&w=480&h=270', 'non-inclusive'),
('1003', 'Don\'t Starve Together', 'https://store.steampowered.com/app/322330/Dont_Starve_Together/', NULL, 'https://www.klei.com/games/dont-starve-together', 'https://assets.nintendo.com/image/upload/c_fill,w_1200/q_auto:best/f_auto/dpr_2.0/ncom/software/switch/70010000019795/081425533fd5a75ad96eb4333f260edf690b91110402ac801e07fd332035da8e', 'deaf'),
('1004', 'Cookie Clicker', 'https://store.steampowered.com/app/1454400/Cookie_Clicker/', NULL, 'https://cookieclicker.com', 'https://play-lh.googleusercontent.com/Z1MOuuiD05ZN5LkVmMEvKF0mqAc-FknaQ2j8s4dZiO-LSPQX4EEA3RVJdlQEtxe96ok', 'colorblind-deaf'),
('1005', 'Portal 2', 'https://store.steampowered.com/app/620/Portal_2/', NULL, NULL, 'https://cdn.akamai.steamstatic.com/steam/apps/620/header.jpg', 'colorblind-deaf'),
('1006', 'SCP Containment Breach', NULL, NULL, 'https://www.scpcbgame.com', 'https://upload.wikimedia.org/wikipedia/commons/5/54/SCP_-_Containment_Breach.jpg', 'non-inclusive'),
('1007', 'Five Nights at Freddy\'s: Security Breach', 'https://store.steampowered.com/app/747660/Five_Nights_at_Freddys_Security_Breach/', 'https://store.epicgames.com/en-US/p/five-nights-at-freddys-security-breach-8dee2a', 'https://www.playstation.com/en-us/games/five-nights-at-freddys-security-breach/', 'https://shared.akamai.steamstatic.com/store_item_assets/steam/apps/747660/header.jpg?t=1686587905', 'deaf'),
('1008', 'Oxygen Not Included', 'https://store.steampowered.com/app/457140/Oxygen_Not_Included/', 'https://store.epicgames.com/en-US/p/oxygen-not-included', 'https://www.klei.com/games/oxygen-not-included', 'https://shared.akamai.steamstatic.com/store_item_assets/steam/apps/457140/header.jpg?t=1701909927', 'deaf'),
('1009', 'BioShock Infinite', 'https://store.steampowered.com/app/8870/BioShock_Infinite/', 'https://store.epicgames.com/en-US/p/bioshock-infinite-complete-edition', 'https://2k.com/en-US/game/bioshock-infinite/', 'https://shared.akamai.steamstatic.com/store_item_assets/steam/apps/8870/capsule_616x353.jpg?t=1602794480', 'deaf'),
('1010', 'Minecraft', NULL, NULL, 'https://www.minecraft.net/en-us', 'https://www.minecraft.net/content/dam/franchise/experiments/1075955/BentoHero_4x_Vanilla_1920x1080.jpg', 'deaf'),
('1011', 'Five Nights at Freddy\'s', 'https://store.steampowered.com/app/319510/Five_Nights_at_Freddys/', NULL, NULL, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQUKMuWRWSdxSFr_8xHM50riG2tKDh0apYmyA&s', 'non-inclusive'),
('1012', 'Baldurs Gate 3', 'https://store.steampowered.com/app/1086940/Baldurs_Gate_3/', NULL, NULL, 'https://shared.akamai.steamstatic.com/store_item_assets/steam/apps/1086940/header.jpg?t=1713271288', 'colorblind-deaf'),
('1013', 'Apex Legends', 'https://store.steampowered.com/app/1172470/Apex_Legends/', NULL, NULL, 'https://shared.akamai.steamstatic.com/store_item_assets/steam/apps/1172470/header.jpg?t=1717672601', 'colorblind-deaf'),
('1014', 'For The King II', 'https://store.steampowered.com/app/1676840/For_The_King_II/', NULL, NULL, 'https://shared.akamai.steamstatic.com/store_item_assets/steam/apps/1676840/header.jpg?t=1714138179', 'deaf'),
('1015', 'Immortals Of Aveum', 'https://store.steampowered.com/app/2009100/Immortals_of_Aveum/', 'https://store.epicgames.com/en-US/p/immortals-of-aveum', 'https://www.ea.com/games/immortals-of-aveum/immortals-of-aveum/buy/pc', 'https://shared.akamai.steamstatic.com/store_item_assets/steam/apps/2009100/header.jpg?t=1712668977', 'colorblind-deaf'),
('1016', 'Everspace 2', 'https://store.steampowered.com/app/1128920/EVERSPACE_2/', NULL, NULL, 'https://shared.akamai.steamstatic.com/store_item_assets/steam/apps/1128920/header.jpg?t=1714441717', 'colorblind-deaf'),
('1017', 'The Witcher 3: Wild Hunt', 'https://store.steampowered.com/app/292030/The_Witcher_3_Wild_Hunt/', NULL, 'https://www.xbox.com/en-US/games/store/the-witcher-3-wild-hunt/BR765873CQJD/0001', 'https://shared.akamai.steamstatic.com/store_item_assets/steam/apps/292030/header.jpg?t=1716793585', 'deaf'),
('1018', 'Starfield', NULL, NULL, 'https://www.xbox.com/en-US/games/store/starfield/9NCJSXWZTP88/0010', 'https://shared.akamai.steamstatic.com/store_item_assets/steam/apps/1716740/header.jpg?t=1718028618', 'deaf'),
('1019', 'Cyberpunk 2077', 'https://store.steampowered.com/app/1091500/Cyberpunk_2077/', 'https://store.epicgames.com/en-US/p/cyberpunk-2077', 'https://www.xbox.com/en-us/games/store/cyberpunk-2077/bx3m8l83bbrw', 'https://shared.akamai.steamstatic.com/store_item_assets/steam/apps/1091500/header.jpg?t=1718101184', 'colorblind-deaf'),
('1020', 'Dying Light 2', 'https://store.steampowered.com/app/534380/Dying_Light_2_Stay_Human_Reloaded_Edition/', NULL, NULL, 'https://shared.akamai.steamstatic.com/store_item_assets/steam/apps/534380/header.jpg?t=1717592174', 'colorblind-deaf'),
('1021', 'The Outlast Trials', 'https://store.steampowered.com/app/1304930/The_Outlast_Trials/', 'https://store.epicgames.com/en-US/p/the-outlast-trials', NULL, 'https://shared.akamai.steamstatic.com/store_item_assets/steam/apps/1304930/header.jpg?t=1709677975', 'non-inclusive'),
('1022', 'GTFO', 'https://store.steampowered.com/app/493520/GTFO/', NULL, NULL, 'https://shared.akamai.steamstatic.com/store_item_assets/steam/apps/493520/header.jpg?t=1717587899', 'non-inclusive'),
('1023', 'Gotham Knights', 'https://store.steampowered.com/app/1496790/Gotham_Knights/', NULL, NULL, 'https://shared.akamai.steamstatic.com/store_item_assets/steam/apps/1496790/header.jpg?t=1708021189', 'colorblind-deaf');

-- --------------------------------------------------------

--
-- Table structure for table `game_tags`
--

CREATE TABLE `game_tags` (
  `game_id` char(5) NOT NULL,
  `tag_id` int(11) NOT NULL,
  `tag_type` enum('positive','negative') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `game_tags`
--

INSERT INTO `game_tags` (`game_id`, `tag_id`, `tag_type`) VALUES
('1001', 1, 'positive'),
('1001', 2, 'negative'),
('1002', 2, 'negative'),
('1003', 1, 'negative'),
('1007', 2, 'negative'),
('1010', 1, 'negative'),
('1011', 2, 'negative'),
('1012', 1, 'negative'),
('1012', 2, 'negative'),
('1013', 1, 'negative'),
('1013', 2, 'negative'),
('1014', 1, 'positive');

-- --------------------------------------------------------

--
-- Table structure for table `game_views`
--

CREATE TABLE `game_views` (
  `view_id` int(11) NOT NULL,
  `game_id` char(5) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `view_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `tag_id` int(11) NOT NULL,
  `tag_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`tag_id`, `tag_name`) VALUES
(1, 'Arachnophobia'),
(3, 'Photosensitivity'),
(2, 'Robophobia');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `profile_picture` varchar(255) NOT NULL DEFAULT 'C:\\xampp\\htdocs\\Software-Engineering\\default_user_icon.png',
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `image_type` enum('local','online') NOT NULL DEFAULT 'local'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `profile_picture`, `password`, `created_at`, `image_type`) VALUES
(1, 'CraigGames', 'craiggames@gmail.com', 'https://drive.google.com/file/d/1MRaRgDvma7UCqWmkxId9WKNRqF1MVCl4/view?usp=sharing', 'craiglistboughtpassword', '2024-06-10 05:51:46', 'online'),
(2, 'MemezMeister', 'steven10302311@gmail.com', 'https://drive.google.com/file/d/1MRaRgDvma7UCqWmkxId9WKNRqF1MVCl4/view?usp=sharing', '$2y$10$eWTHHI03h9OewIXdMoHPC.fwf3VofH69sk5T44KlGzmGFFeKC3RvW', '2024-06-10 15:37:23', 'online'),
(3, 'MemezMcMuffin', 'steven5658118@gmail.com', 'https://us-tuna-sounds-images.voicemod.net/78f23c41-369a-4769-9568-7aae749c4e06-1704762972412.jpg', '$2y$10$IZ0olNgosS9boajnH284X.5pM5ME01IlBN..PeL96hqKMrDhGu3Xy', '2024-06-13 14:27:48', 'online');

-- --------------------------------------------------------

--
-- Table structure for table `user_reviews`
--

CREATE TABLE `user_reviews` (
  `review_id` int(11) NOT NULL,
  `game_id` char(5) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `review_text` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_tags`
--

CREATE TABLE `user_tags` (
  `user_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_tags`
--

INSERT INTO `user_tags` (`user_id`, `tag_id`) VALUES
(3, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrators`
--
ALTER TABLE `administrators`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `admin_reviews`
--
ALTER TABLE `admin_reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `game_id` (`game_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`game_id`);

--
-- Indexes for table `game_tags`
--
ALTER TABLE `game_tags`
  ADD PRIMARY KEY (`game_id`,`tag_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- Indexes for table `game_views`
--
ALTER TABLE `game_views`
  ADD PRIMARY KEY (`view_id`),
  ADD KEY `game_id` (`game_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`tag_id`),
  ADD UNIQUE KEY `tag_name` (`tag_name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_reviews`
--
ALTER TABLE `user_reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `game_id` (`game_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_tags`
--
ALTER TABLE `user_tags`
  ADD PRIMARY KEY (`user_id`,`tag_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrators`
--
ALTER TABLE `administrators`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admin_reviews`
--
ALTER TABLE `admin_reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `game_views`
--
ALTER TABLE `game_views`
  MODIFY `view_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `tag_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_reviews`
--
ALTER TABLE `user_reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_reviews`
--
ALTER TABLE `admin_reviews`
  ADD CONSTRAINT `admin_reviews_ibfk_1` FOREIGN KEY (`game_id`) REFERENCES `games` (`game_id`),
  ADD CONSTRAINT `admin_reviews_ibfk_2` FOREIGN KEY (`admin_id`) REFERENCES `administrators` (`admin_id`);

--
-- Constraints for table `game_tags`
--
ALTER TABLE `game_tags`
  ADD CONSTRAINT `game_tags_ibfk_1` FOREIGN KEY (`game_id`) REFERENCES `games` (`game_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `game_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`tag_id`) ON DELETE CASCADE;

--
-- Constraints for table `game_views`
--
ALTER TABLE `game_views`
  ADD CONSTRAINT `game_views_ibfk_1` FOREIGN KEY (`game_id`) REFERENCES `games` (`game_id`),
  ADD CONSTRAINT `game_views_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `user_reviews`
--
ALTER TABLE `user_reviews`
  ADD CONSTRAINT `user_reviews_ibfk_1` FOREIGN KEY (`game_id`) REFERENCES `games` (`game_id`),
  ADD CONSTRAINT `user_reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `user_tags`
--
ALTER TABLE `user_tags`
  ADD CONSTRAINT `user_tags_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `user_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`tag_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;