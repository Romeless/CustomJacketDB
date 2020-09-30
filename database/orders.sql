CREATE TABLE `kji8wgna4iei3zc4`.`orders` (
  `id` INT(8) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'Primary Key for Order',
  `userID` INT(8) UNSIGNED ZEROFILL NOT NULL COMMENT 'Orderer User ID',
  `designID` INT(8) UNSIGNED ZEROFILL NOT NULL COMMENT 'Design Order',
  `username` VARCHAR(64) NOT NULL COMMENT 'Username of Orderer',
  `address` VARCHAR(255) NOT NULL COMMENT 'Sent location of Order',
  `email` VARCHAR(255) NOT NULL COMMENT 'E-mail of Orderer',
  `qty` INT(4) NOT NULL DEFAULT 1 COMMENT 'Quantity ordered',
  `status` INT(2) NOT NULL DEFAULT 1 COMMENT '0 - Other\n1 - Ordered\n2 - Paid\n3 - Process\n4 - Shipping\n5 - Received\n6 - Complained\n7 - Canceled \n8 - Canceled by Admin\n9 - Finished',
  `price` INT(16) UNSIGNED NOT NULL DEFAULT 0,
  `phoneNumber` VARCHAR(16) NULL COMMENT 'User phone number',
  `information` TEXT NULL COMMENT 'Additional Information',
  `partnership` VARCHAR(64) NULL COMMENT 'Partner Business Name',
  `partnerAddress` VARCHAR(255) NULL COMMENT 'Address for Partner',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  INDEX `userID_idx` (`userID` ASC),
  INDEX `designID_idx` (`designID` ASC),
  CONSTRAINT `userID`
    FOREIGN KEY (`userID`)
    REFERENCES `kji8wgna4iei3zc4`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `designID`
    FOREIGN KEY (`designID`)
    REFERENCES `kji8wgna4iei3zc4`.`designs` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
);
    
