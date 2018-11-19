CREATE TABLE `brandboom`.`images` (
  `image_id` INT NOT NULL,
  `filepath` VARCHAR(255) NULL,
  `created_at` DATETIME NULL,
  PRIMARY KEY (`image_id`));


ALTER TABLE `brandboom`.`images` 
CHANGE COLUMN `image_id` `image_id` INT(11) NOT NULL AUTO_INCREMENT ;
