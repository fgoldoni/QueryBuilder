CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `mobile`, `phone`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Rebecca', 'Reynolds', 'admin@contact.de', '+1.707.270.4759', '545.717.6134 x32431', NULL, '2018-10-31 02:00:20', '2018-10-31 02:00:20'),
(2, 'Johan', 'Franecki', 'umcglynn@example.net', '+1-623-845-0323', '547-372-5759', NULL, '2018-10-31 02:00:20', '2018-10-31 02:00:20'),
(3, 'Penelope', 'Carroll', 'hank76@example.org', '359-537-6537 x774', '(547) 806-2053 x621', NULL, '2018-10-31 02:00:20', '2018-10-31 02:00:20'),
(4, 'Lorine', 'Parker', 'lwalker@example.com', '+1-518-446-3713', '373.333.9666 x383', NULL, '2018-10-31 02:00:20', '2018-10-31 02:00:20'),
(5, 'Eda', 'Koepp', 'schamberger.terrell@example.net', '+13953416930', '820.463.1400 x050', NULL, '2018-10-31 02:00:20', '2018-10-31 02:00:20'),
(6, 'Amara', 'Cummings', 'neil.lind@example.org', '1-425-658-5239 x922', '1-927-331-0622', NULL, '2018-10-31 02:00:20', '2018-10-31 02:00:20'),
(7, 'Easton', 'Mitchell', 'swillms@example.com', '715-623-0986', '257-409-0124 x851', NULL, '2018-10-31 02:00:20', '2018-10-31 02:00:20'),
(8, 'Miracle', 'Schmitt', 'rschmidt@example.net', '928.482.5563', '+1.250.579.2466', NULL, '2018-10-31 02:00:20', '2018-10-31 02:00:20'),
(9, 'Savannah', 'Kuvalis', 'wava.hyatt@example.com', '454-770-8595 x55454', '763-266-7479 x30526', NULL, '2018-10-31 02:00:20', '2018-10-31 02:00:20'),
(10, 'Owen', 'Cruickshank', 'amely03@example.net', '302.734.6419', '786.634.5000 x297', NULL, '2018-10-31 02:00:20', '2018-10-31 02:00:20'),
(11, 'Jazmin', 'Friesen', 'xfranecki@example.org', '1-691-260-0535', '(221) 612-9008 x256', NULL, '2018-10-31 02:00:20', '2018-10-31 02:00:20');

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;
