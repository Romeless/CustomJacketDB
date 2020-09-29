CREATE TABLE `admins` (
  `id` int(8) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'Primary Key for Admin',
  `username` varchar(64) UNIQUE NOT NULL COMMENT 'Admin User Name',
  `role` int(2) NOT NULL COMMENT 'Admin Role',
  `password` varchar(100) COMMENT 'Admin Password for Normal Login',
  `salt` varchar(255) COMMENT 'Salt for Normal Login',
  `avatar` text DEFAULT NULL COMMENT 'Profile Picture Path',
  `email` varchar(255) UNIQUE NOT NULL COMMENT 'Admin Email',
  `phoneNumber` varchar(16) DEFAULT NULL COMMENT 'Admin Phone Number',
  `joinDate` date COMMENT 'Admin Join Date',
  `lastLogin` date COMMENT 'Admin Last Login',
  `ip` varchar(64) DEFAULT NULL COMMENT 'Admin Last Login IP',
  PRIMARY KEY(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;