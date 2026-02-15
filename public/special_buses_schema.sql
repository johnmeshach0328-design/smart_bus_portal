-- Create special_buses table for festival/occasion buses
CREATE TABLE IF NOT EXISTS `special_buses` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `bus_number` VARCHAR(100) NOT NULL,
  `route` VARCHAR(255) NOT NULL,
  `occasion` VARCHAR(200) NOT NULL,
  `start_date` DATE NOT NULL,
  `end_date` DATE NOT NULL,
  `district` VARCHAR(100) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
