CREATE SCHEMA `laravel`;

CREATE TABLE `laravel`.`tasks` (
  `id` INT UNSIGNED NULL AUTO_INCREMENT,
  `task` VARCHAR(255) NULL,
  `description` VARCHAR(255) NULL,
  `status` INT(11) NULL,
PRIMARY KEY (`id`));
