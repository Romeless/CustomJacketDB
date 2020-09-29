CREATE TABLE `users` (
  `id` int(8) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'Primary Key for Users',
  `username` varchar(64) UNIQUE NOT NULL COMMENT 'User Name',
  `fullName` varchar(255) NOT NULL COMMENT 'User Full Name',
  `tokenID` text COMMENT 'Google Token ID for Google Login',
  `password` varchar(100) COMMENT 'User Password for Normal Login',
  `salt` varchar(255) COMMENT 'Salt for Normal Login',
  `avatar` text DEFAULT NULL COMMENT 'Profile Picture Path',
  `email` varchar(255) UNIQUE NOT NULL COMMENT 'User Email',
  `address` varchar(255) DEFAULT NULL COMMENT 'User Address',
  `phoneNumber` varchar(16) DEFAULT NULL COMMENT 'User Phone Number',
  `verified` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'User Email Verification',
  `joinDate` date COMMENT 'User Join Date',
  `lastLogin` date COMMENT 'User Last Login',
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;