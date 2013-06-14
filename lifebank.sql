/*Table structure for table `locations` */

DROP TABLE IF EXISTS `locations`;

CREATE TABLE `locations` (
  `location_id` int(11) NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  PRIMARY KEY  (`location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `locations` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

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
  KEY `FK_users` (`location`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`location`) REFERENCES `locations` (`location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `users` */

/*Table structure for table `activities` */

DROP TABLE IF EXISTS `activities`;

CREATE TABLE `activities` (
  `log_id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `action` text NOT NULL,
  `object` varchar(100) NOT NULL,
  `object_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY  (`log_id`),
  KEY `FK_activities` (`user_id`),
  CONSTRAINT `activities_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `activities` */

/*Table structure for table `hospitals` */

DROP TABLE IF EXISTS `hospitals`;

CREATE TABLE `hospitals` (
  `hospital_id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `logo` varchar(255) default NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `location` int(11) NOT NULL,
  `status` int(1) NOT NULL default '0',
  PRIMARY KEY  (`hospital_id`),
  KEY `FK_hospitals` (`location`),
  CONSTRAINT `hospitals_ibfk_1` FOREIGN KEY (`location`) REFERENCES `locations` (`location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `hospitals` */


/*Table structure for table `hospital_admin` */

DROP TABLE IF EXISTS `hospital_admin`;

CREATE TABLE `hospital_admin` (
  `hospital_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY  (`hospital_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `hospital_admin` */

/*Table structure for table `notifications` */

DROP TABLE IF EXISTS `notifications`;

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `action` text NOT NULL,
  `object` varchar(255) NOT NULL,
  `object_id` int(11) NOT NULL,
  `read` int(1) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY  (`notification_id`),
  KEY `FK_notifications` (`user_id`),
  CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `notifications` */

/*Table structure for table `superadmin` */

DROP TABLE IF EXISTS `superadmin`;

CREATE TABLE `superadmin` (
  `user_id` int(11) NOT NULL,
  PRIMARY KEY  (`user_id`),
  CONSTRAINT `superadmin_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `superadmin` */

/*Table structure for table `user_social_acc` */

DROP TABLE IF EXISTS `user_social_acc`;

CREATE TABLE `user_social_acc` (
  `user_id` int(11) NOT NULL,
  `social_id` int(11) NOT NULL,
  `type` enum('t','f') NOT NULL,
  `okey` varchar(255) NOT NULL,
  `otoken` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  PRIMARY KEY  (`social_id`,`type`),
  KEY `FK_user_social_acc` (`user_id`),
  CONSTRAINT `user_social_acc_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `user_social_acc` */