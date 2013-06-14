-- phpMyAdmin SQL Dump
-- version 2.10.1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Jun 14, 2013 at 05:02 PM
-- Server version: 5.0.45
-- PHP Version: 5.2.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Database: `lifebank`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `locations`
-- 

CREATE TABLE `locations` (
  `location_id` int(11) NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  PRIMARY KEY  (`location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `locations`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `notifications`
-- 

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `action` text NOT NULL,
  `object` varchar(255) NOT NULL,
  `object_id` int(11) NOT NULL,
  `read` int(1) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY  (`notification_id`),
  KEY `FK_notifications` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `notifications`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `superadmin`
-- 

CREATE TABLE `superadmin` (
  `user_id` int(11) NOT NULL,
  PRIMARY KEY  (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `superadmin`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `users`
-- 

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) default NULL,
  `gender` enum('M','F') NOT NULL,
  `dob` date NOT NULL,
  `password` varchar(50) NOT NULL,
  `location` int(11) NOT NULL,
  `blood_group` enum('A+','A-','B+','B-','AB+','AB-','O+','O-') NOT NULL,
  `verified` int(1) NOT NULL default '0',
  `status` int(1) NOT NULL default '1',
  PRIMARY KEY  (`user_id`),
  KEY `FK_users` (`location`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `users`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `user_social_acc`
-- 

CREATE TABLE `user_social_acc` (
  `user_id` int(11) NOT NULL,
  `social_id` int(11) NOT NULL,
  `type` enum('t','f') NOT NULL,
  `okey` varchar(255) NOT NULL,
  `otoken` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  PRIMARY KEY  (`social_id`,`type`),
  KEY `FK_user_social_acc` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `user_social_acc`
-- 


-- 
-- Constraints for dumped tables
-- 

-- 
-- Constraints for table `notifications`
-- 
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

-- 
-- Constraints for table `superadmin`
-- 
ALTER TABLE `superadmin`
  ADD CONSTRAINT `superadmin_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

-- 
-- Constraints for table `users`
-- 
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`location`) REFERENCES `locations` (`location_id`);

-- 
-- Constraints for table `user_social_acc`
-- 
ALTER TABLE `user_social_acc`
  ADD CONSTRAINT `user_social_acc_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
