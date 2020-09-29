CREATE TABLE `tokens` (
  `id` int(8) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'Primary Key for Token',
  `token` varchar(255) UNIQUE NOT NULL COMMENT 'Token',
  `userID` int(8) UNSIGNED ZEROFILL NOT NULL COMMENT 'Token Owner ID' ,
  `device` varchar(255) COMMENT 'Device Token',
  `createDate` date COMMENT 'Token Date Created',
  `expireDate` date COMMENT 'Token Date Expired',
  PRIMARY KEY(id),
  FOREIGN KEY(userID) REFERENCES kji8wgna4iei3zc4.users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;