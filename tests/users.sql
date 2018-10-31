-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mer. 31 oct. 2018 à 04:00
-- Version du serveur :  10.1.36-MariaDB
-- Version de PHP :  7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `laravel`
--

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fax` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `occupation` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `login_failures` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `locked` tinyint(1) NOT NULL,
  `ip` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `mobile`, `phone`, `fax`, `occupation`, `login_failures`, `locked`, `ip`, `last_login`, `email_verified_at`, `remember_token`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Rebecca', 'Reynolds', 'admin@contact.de', '$2y$10$zex7zEXX2/T7sPofWXEdceahNutM6Vy9Mnh4HJOUFUnXqT7ygqSC.', '+1.707.270.4759', '545.717.6134 x32431', '632.991.7340', 'Welder-Fitter', 0, 0, NULL, NULL, '2018-10-31 02:00:20', 'EPlXX8nlnt', NULL, '2018-10-31 02:00:20', '2018-10-31 02:00:20'),
(2, 'Johan', 'Franecki', 'umcglynn@example.net', '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', '+1-623-845-0323', '547-372-5759', '628-735-8933 x95857', 'Nutritionist', 0, 0, NULL, NULL, NULL, 'KH7wc9N0ls', NULL, '2018-10-31 02:00:20', '2018-10-31 02:00:20'),
(3, 'Penelope', 'Carroll', 'hank76@example.org', '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', '359-537-6537 x774', '(547) 806-2053 x621', '(745) 420-4615 x8801', 'Mechanical Equipment Sales Representative', 0, 0, NULL, NULL, NULL, 's0SSGPVIDD', NULL, '2018-10-31 02:00:20', '2018-10-31 02:00:20'),
(4, 'Lorine', 'Parker', 'lwalker@example.com', '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', '+1-518-446-3713', '373.333.9666 x383', '1-897-343-6434 x4606', 'Gaming Manager', 0, 0, NULL, NULL, NULL, 'osU105ZQtk', NULL, '2018-10-31 02:00:20', '2018-10-31 02:00:20'),
(5, 'Eda', 'Koepp', 'schamberger.terrell@example.net', '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', '+13953416930', '820.463.1400 x050', '289-831-5849 x538', 'Streetcar Operator', 0, 0, NULL, NULL, NULL, 'jjtppoY3P1', NULL, '2018-10-31 02:00:20', '2018-10-31 02:00:20'),
(6, 'Amara', 'Cummings', 'neil.lind@example.org', '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', '1-425-658-5239 x922', '1-927-331-0622', '+1 (769) 969-6157', 'Bookbinder', 0, 0, NULL, NULL, NULL, 'DhUWeK1AoA', NULL, '2018-10-31 02:00:20', '2018-10-31 02:00:20'),
(7, 'Easton', 'Mitchell', 'swillms@example.com', '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', '715-623-0986', '257-409-0124 x851', '1-330-771-1248 x69919', 'Host and Hostess', 0, 0, NULL, NULL, NULL, 'k9SLX2URF2', NULL, '2018-10-31 02:00:20', '2018-10-31 02:00:20'),
(8, 'Miracle', 'Schmitt', 'rschmidt@example.net', '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', '928.482.5563', '+1.250.579.2466', '1-570-868-4147', 'Railroad Inspector', 0, 0, NULL, NULL, NULL, 'dEmzov6cpY', NULL, '2018-10-31 02:00:20', '2018-10-31 02:00:20'),
(9, 'Savannah', 'Kuvalis', 'wava.hyatt@example.com', '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', '454-770-8595 x55454', '763-266-7479 x30526', '489.655.8323 x6669', 'Food Batchmaker', 0, 0, NULL, NULL, NULL, 'ImJJG1Cs2S', NULL, '2018-10-31 02:00:20', '2018-10-31 02:00:20'),
(10, 'Owen', 'Cruickshank', 'amely03@example.net', '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', '302.734.6419', '786.634.5000 x297', '(438) 768-7481', 'Insurance Sales Agent', 0, 0, NULL, NULL, NULL, 'DN0khLzk60', NULL, '2018-10-31 02:00:20', '2018-10-31 02:00:20'),
(11, 'Jazmin', 'Friesen', 'xfranecki@example.org', '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', '1-691-260-0535', '(221) 612-9008 x256', '+1-904-314-8960', 'Program Director', 0, 0, NULL, NULL, NULL, 'd7giirqpiI', NULL, '2018-10-31 02:00:20', '2018-10-31 02:00:20');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
