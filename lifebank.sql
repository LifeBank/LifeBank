-- phpMyAdmin SQL Dump
-- version 2.10.1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Jun 15, 2013 at 05:19 PM
-- Server version: 5.0.45
-- PHP Version: 5.2.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Database: `lifebank`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `activities`
-- 

CREATE TABLE `activities` (
  `log_id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `action` text NOT NULL,
  `object` varchar(100) NOT NULL,
  `object_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY  (`log_id`),
  KEY `FK_activities` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `activities`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `hospitals`
-- 

CREATE TABLE `hospitals` (
  `hospital_id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `logo` varchar(255) default NULL,
  `phone` varchar(20),
  `email` varchar(255),
  `address` varchar(255) NOT NULL,
  `state` varchar(255),
  `location` int(11) NOT NULL,
  `lga` varchar(255),
  `status` int(1) NOT NULL default '0',
  PRIMARY KEY  (`hospital_id`),
  KEY `FK_hospitals` (`location`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `hospitals`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `hospital_admin`
-- 

CREATE TABLE `hospital_admin` (
  `hospital_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY  (`hospital_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `hospital_admin`
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
  `username` varchar(255),
  `name` varchar(255),
  `email` varchar(255) NOT NULL,
  `avatar` varchar(255) default NULL,
  `phone` varchar(50) default NULL,
  `password` varchar(50) NOT NULL,
  `location` int(11),
  `blood_group` enum('A+','A-','B+','B-','AB+','AB-','O+','O-'),
  `verified` int(1) NOT NULL default '0',
  `status` int(1) NOT NULL default '1',
  `last_login` datetime,
  `date` datetime NOT NULL,
  `donated_times` int(11),
  `referrals` int(11) default '0',
  PRIMARY KEY  (`user_id`),
  UNIQUE KEY `email` (`email`),
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
-- Constraints for table `activities`
-- 
ALTER TABLE `activities`
  ADD CONSTRAINT `activities_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

-- 
-- Constraints for table `hospitals`
-- 
ALTER TABLE `hospitals`
  ADD CONSTRAINT `hospitals_ibfk_1` FOREIGN KEY (`location`) REFERENCES `locations` (`location_id`);

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
