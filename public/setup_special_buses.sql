-- Quick Database Setup for Special Buses Feature
-- Run this SQL in phpMyAdmin or MySQL console

CREATE TABLE IF NOT EXISTS `special_buses` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `bus_number` VARCHAR(100) NOT NULL,
  `route` VARCHAR(255) NOT NULL,
  `occasion` VARCHAR(200) NOT NULL COMMENT 'Festival or event name',
  `start_date` DATE NOT NULL COMMENT 'Service start date',
  `end_date` DATE NOT NULL COMMENT 'Service end date',
  `district` VARCHAR(100) NOT NULL COMMENT 'District where bus operates',
  `shift1_time` TIME DEFAULT NULL,
  `shift2_time` TIME DEFAULT NULL,
  `shift3_time` TIME DEFAULT NULL,
  `shift4_time` TIME DEFAULT NULL,
  `shift5_time` TIME DEFAULT NULL,
  `shift6_time` TIME DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `district` (`district`),
  KEY `dates` (`start_date`,`end_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Stores special occasion/festival bus schedules';

-- Example data (optional)
-- INSERT INTO special_buses (bus_number, route, occasion, start_date, end_date, district) 
-- VALUES ('TN-01-SP-2024', 'Chennai - Madurai', 'Pongal Festival', '2026-01-14', '2026-01-17', 'Chennai');
