CREATE TABLE `designs` (
  `id` int(8) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'Primary Key for Designs',
  `userID` int(8) UNSIGNED ZEROFILL NOT NULL COMMENT 'Design Owner ID' ,
  `designName` varchar(32) NOT NULL COMMENT 'Design Name',
  `details` text DEFAULT NULL COMMENT 'Design Details',
  `images` text DEFAULT NULL COMMENT 'Design Images Paths',
  `imagesPosition` varchar(255) DEFAULT NULL COMMENT 'Image Positions on Design',
  `information` text DEFAULT NULL COMMENT 'Design Additional Information',
  `createDate` date COMMENT 'Design Date Created',
  `updateDate` date COMMENT 'Design Last Update Date',
  FOREIGN KEY (userID) REFERENCES kji8wgna4iei3zc4.users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;