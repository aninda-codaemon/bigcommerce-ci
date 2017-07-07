CREATE TABLE `big_store` ( `id` INT(5) UNSIGNED NOT NULL AUTO_INCREMENT , `store_context` VARCHAR(50) NOT NULL , `store_scope` TEXT NOT NULL , `store_token` VARCHAR(100) NOT NULL , `store_username` VARCHAR(150) NOT NULL , `store_email` VARCHAR(150) NOT NULL , `store_id` INT(5) UNSIGNED NOT NULL , `store_status` TINYINT(1) NOT NULL DEFAULT '1' , `create_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , `update_date` TIMESTAMP NULL DEFAULT NULL , PRIMARY KEY (`id`), UNIQUE (`store_context`), UNIQUE (`store_id`)) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `big_user`
--

CREATE TABLE `big_user` (
  `id` int(5) UNSIGNED NOT NULL,
  `store_id` int(5) UNSIGNED NOT NULL COMMENT 'Store id from store table',
  `first_name` varchar(100) CHARACTER SET latin1 NOT NULL,
  `last_name` varchar(100) CHARACTER SET latin1 NOT NULL,
  `email` varchar(100) CHARACTER SET latin1 NOT NULL,
  `phone` varchar(20) CHARACTER SET latin1 NOT NULL,
  `password` varchar(150) CHARACTER SET latin1 NOT NULL,
  `company` varchar(200) CHARACTER SET latin1 NOT NULL,
  `job_title` varchar(100) CHARACTER SET latin1 NOT NULL,
  `signup_flag` tinyint(1) NOT NULL DEFAULT '0',
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `big_user`
--
ALTER TABLE `big_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `email_2` (`email`),
  ADD KEY `store_id` (`store_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `big_user`
--
ALTER TABLE `big_user`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;COMMIT;



