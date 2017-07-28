-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 28, 2017 at 09:51 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.0.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `bigcommerce-ktc`
--

-- --------------------------------------------------------

--
-- Table structure for table `big_orders`
--

CREATE TABLE `big_orders` (
  `id` int(5) UNSIGNED NOT NULL,
  `store_id` int(5) UNSIGNED NOT NULL COMMENT 'Store table id',
  `increment_id` varchar(50) NOT NULL COMMENT 'Magento store order id',
  `base_currency_code` varchar(10) NOT NULL,
  `customer_email` varchar(100) NOT NULL,
  `customer_firstname` varchar(100) NOT NULL,
  `customer_lastname` varchar(100) NOT NULL,
  `customer_moddlename` varchar(100) DEFAULT NULL,
  `store_name` varchar(100) NOT NULL,
  `order_create_date` varchar(100) NOT NULL COMMENT 'Order create date in magento store',
  `shipping_description` varchar(100) NOT NULL,
  `base_grand_total` decimal(10,2) UNSIGNED NOT NULL,
  `discount_amount` decimal(10,2) UNSIGNED NOT NULL,
  `total_qty_ordered` int(3) UNSIGNED NOT NULL,
  `customer_id` int(5) UNSIGNED NOT NULL,
  `order_description` text NOT NULL COMMENT 'Order json data dump',
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `big_order_address`
--

CREATE TABLE `big_order_address` (
  `id` int(5) UNSIGNED NOT NULL,
  `order_id` int(5) UNSIGNED NOT NULL COMMENT 'Order id from orders table',
  `shipping_region` varchar(100) NOT NULL,
  `shipping_postcode` varchar(20) NOT NULL,
  `shipping_firstname` varchar(100) NOT NULL,
  `shipping_lastname` varchar(100) NOT NULL,
  `shipping_street` varchar(100) NOT NULL,
  `shipping_city` varchar(100) NOT NULL,
  `shipping_email` varchar(100) NOT NULL,
  `shipping_telephone` varchar(20) NOT NULL,
  `shipping_country_id` varchar(50) NOT NULL,
  `billing_region` varchar(100) NOT NULL,
  `billing_postcode` varchar(20) NOT NULL,
  `billing_lastname` varchar(100) NOT NULL,
  `billing_firstname` varchar(100) NOT NULL,
  `billing_street` varchar(100) NOT NULL,
  `billing_city` varchar(100) NOT NULL,
  `billing_email` varchar(100) NOT NULL,
  `billing_telephone` varchar(100) NOT NULL,
  `billing_country_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `big_store`
--

CREATE TABLE `big_store` (
  `id` int(5) UNSIGNED NOT NULL,
  `store_context` varchar(50) NOT NULL,
  `store_scope` text NOT NULL,
  `store_token` varchar(100) NOT NULL,
  `store_username` varchar(150) NOT NULL,
  `store_email` varchar(150) NOT NULL,
  `store_id` int(5) UNSIGNED NOT NULL,
  `store_status` tinyint(1) NOT NULL DEFAULT '1',
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `big_orders`
--
ALTER TABLE `big_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_id` (`store_id`),
  ADD KEY `increment_id` (`increment_id`);

--
-- Indexes for table `big_order_address`
--
ALTER TABLE `big_order_address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `big_store`
--
ALTER TABLE `big_store`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `store_context` (`store_context`),
  ADD UNIQUE KEY `store_id` (`store_id`);

--
-- Indexes for table `big_user`
--
ALTER TABLE `big_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `email_2` (`email`),
  ADD KEY `store_id` (`store_id`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `big_orders`
--
ALTER TABLE `big_orders`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `big_order_address`
--
ALTER TABLE `big_order_address`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `big_store`
--
ALTER TABLE `big_store`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `big_user`
--
ALTER TABLE `big_user`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;COMMIT;
