-- ============================================================================
-- SMART BUS PORTAL - COMPLETE DATABASE SETUP SCRIPT
-- ============================================================================
-- Database: smart_bus_portal
-- Description: Complete setup script for Smart Bus Portal project
-- Run this script on a new system to set up the entire database
-- ============================================================================

-- Create database if it doesn't exist
CREATE DATABASE IF NOT EXISTS `smart_bus_portal` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `smart_bus_portal`;

-- Set timezone
SET time_zone = '+05:30';

-- ============================================================================
-- TABLE: platform_incharges
-- Description: Stores login credentials for platform incharge staff
-- ============================================================================
CREATE TABLE IF NOT EXISTS `platform_incharges` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `district` VARCHAR(100) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `district` (`district`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Platform incharge staff login credentials';

-- ============================================================================
-- TABLE: passengers
-- Description: Stores passenger information for the portal
-- ============================================================================
CREATE TABLE IF NOT EXISTS `passengers` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(200) NOT NULL,
  `mobile_number` VARCHAR(15) NOT NULL,
  `password_hash` VARCHAR(255) DEFAULT 'NO_PASSWORD',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `last_login` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mobile_number` (`mobile_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Passenger accounts';

-- ============================================================================
-- TABLE: buses
-- Description: Main table storing all bus information
-- ============================================================================
CREATE TABLE IF NOT EXISTS `buses` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `incharge_id` INT(11) NOT NULL,
  `bus_number` VARCHAR(100) NOT NULL,
  `route` VARCHAR(255) NOT NULL,
  `bus_type` ENUM('SETC', 'Point-To-Point', 'Route Bus') NOT NULL DEFAULT 'SETC',
  `district` VARCHAR(100) NOT NULL,
  
  -- Shift timings (up to 6 shifts per day)
  `shift1_time` TIME DEFAULT NULL,
  `shift2_time` TIME DEFAULT NULL,
  `shift3_time` TIME DEFAULT NULL,
  `shift4_time` TIME DEFAULT NULL,
  `shift5_time` TIME DEFAULT NULL,
  `shift6_time` TIME DEFAULT NULL,
  
  -- Route stops (up to 9 stops)
  `stop1` VARCHAR(200) DEFAULT NULL,
  `stop2` VARCHAR(200) DEFAULT NULL,
  `stop3` VARCHAR(200) DEFAULT NULL,
  `stop4` VARCHAR(200) DEFAULT NULL,
  `stop5` VARCHAR(200) DEFAULT NULL,
  `stop6` VARCHAR(200) DEFAULT NULL,
  `stop7` VARCHAR(200) DEFAULT NULL,
  `stop8` VARCHAR(200) DEFAULT NULL,
  `stop9` VARCHAR(200) DEFAULT NULL,
  
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  PRIMARY KEY (`id`),
  UNIQUE KEY `bus_number` (`bus_number`),
  KEY `bus_type` (`bus_type`),
  KEY `district` (`district`),
  KEY `incharge_id` (`incharge_id`),
  FOREIGN KEY (`incharge_id`) REFERENCES `platform_incharges`(`id`) ON DELETE CASCADE,
  KEY `idx_type_district` (`bus_type`, `district`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='All bus information';

-- ============================================================================
-- TABLE: attendance
-- Description: Daily attendance and status tracking for buses
-- ============================================================================
CREATE TABLE IF NOT EXISTS `attendance` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `bus_id` INT(11) NOT NULL,
  `attendance_date` DATE NOT NULL,
  `status` ENUM('Present', 'Absent') NOT NULL DEFAULT 'Present',
  `detailed_status` VARCHAR(100) DEFAULT 'Scheduled' COMMENT 'Scheduled, Departured, Delayed, Arrived, Not Available',
  `marked_by` INT(11) DEFAULT NULL COMMENT 'Platform incharge ID who marked attendance',
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  
  PRIMARY KEY (`id`),
  UNIQUE KEY `bus_date` (`bus_id`, `attendance_date`),
  KEY `bus_id` (`bus_id`),
  KEY `attendance_date` (`attendance_date`),
  FOREIGN KEY (`bus_id`) REFERENCES `buses`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`marked_by`) REFERENCES `platform_incharges`(`id`) ON DELETE SET NULL,
  KEY `idx_date_status` (`attendance_date`, `status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Daily bus attendance and status';

-- ============================================================================
-- TABLE: special_buses
-- Description: Special occasion/festival bus schedules
-- ============================================================================
CREATE TABLE IF NOT EXISTS `special_buses` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `bus_number` VARCHAR(100) NOT NULL,
  `route` VARCHAR(255) NOT NULL,
  `occasion` VARCHAR(200) NOT NULL COMMENT 'Festival or event name',
  `start_date` DATE NOT NULL COMMENT 'Service start date',
  `end_date` DATE NOT NULL COMMENT 'Service end date',
  `district` VARCHAR(100) NOT NULL COMMENT 'District where bus operates',
  
  -- Shift timings
  `shift1_time` TIME DEFAULT NULL,
  `shift2_time` TIME DEFAULT NULL,
  `shift3_time` TIME DEFAULT NULL,
  `shift4_time` TIME DEFAULT NULL,
  `shift5_time` TIME DEFAULT NULL,
  `shift6_time` TIME DEFAULT NULL,
  
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  
  PRIMARY KEY (`id`),
  KEY `district` (`district`),
  KEY `dates` (`start_date`, `end_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Special occasion/festival bus schedules';

-- ============================================================================
-- TABLE: feedback
-- Description: User feedback and suggestions
-- ============================================================================
CREATE TABLE IF NOT EXISTS `feedback` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(200) DEFAULT NULL,
  `message` TEXT NOT NULL,
  `submitted_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  
  PRIMARY KEY (`id`),
  KEY `submitted_at` (`submitted_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='User feedback';

-- ============================================================================
-- INITIAL DATA - Platform Incharges
-- Description: Default platform incharge accounts for all 38 Tamil Nadu districts
-- Default password: "admin" (should be changed after first login in production)
-- ============================================================================

INSERT INTO `platform_incharges` (`username`, `password`, `district`) VALUES
('tirunelveli_admin', 'admin', 'Tirunelveli'),
('chennai_admin', 'admin', 'Chennai'),
('madurai_admin', 'admin', 'Madurai'),
('coimbatore_admin', 'admin', 'Coimbatore'),
('salem_admin', 'admin', 'Salem'),
('tiruchirappalli_admin', 'admin', 'Tiruchirappalli'),
('tiruppur_admin', 'admin', 'Tiruppur'),
('erode_admin', 'admin', 'Erode'),
('vellore_admin', 'admin', 'Vellore'),
('thoothukudi_admin', 'admin', 'Thoothukudi'),
('dindigul_admin', 'admin', 'Dindigul'),
('thanjavur_admin', 'admin', 'Thanjavur'),
('ranipet_admin', 'admin', 'Ranipet'),
('sivaganga_admin', 'admin', 'Sivaganga'),
('karur_admin', 'admin', 'Karur'),
('ramanathapuram_admin', 'admin', 'Ramanathapuram'),
('virudhunagar_admin', 'admin', 'Virudhunagar'),
('tiruvannamalai_admin', 'admin', 'Tiruvannamalai'),
('nilgiris_admin', 'admin', 'Nilgiris'),
('namakkal_admin', 'admin', 'Namakkal'),
('cuddalore_admin', 'admin', 'Cuddalore'),
('kancheepuram_admin', 'admin', 'Kancheepuram'),
('kanniyakumari_admin', 'admin', 'Kanniyakumari'),
('nagapattinam_admin', 'admin', 'Nagapattinam'),
('viluppuram_admin', 'admin', 'Viluppuram'),
('tiruvallur_admin', 'admin', 'Tiruvallur'),
('dharmapuri_admin', 'admin', 'Dharmapuri'),
('krishnagiri_admin', 'admin', 'Krishnagiri'),
('ariyalur_admin', 'admin', 'Ariyalur'),
('perambalur_admin', 'admin', 'Perambalur'),
('pudukkottai_admin', 'admin', 'Pudukkottai'),
('theni_admin', 'admin', 'Theni'),
('tiruvarur_admin', 'admin', 'Tiruvarur'),
('tenkasi_admin', 'admin', 'Tenkasi'),
('mayiladuthurai_admin', 'admin', 'Mayiladuthurai'),
('chengalpattu_admin', 'admin', 'Chengalpattu'),
('tirupathur_admin', 'admin', 'Tirupathur'),
('kallakurichi_admin', 'admin', 'Kallakurichi')
ON DUPLICATE KEY UPDATE `password` = VALUES(`password`);

-- ============================================================================
-- SAMPLE DATA - Buses (Optional - for testing)
-- ============================================================================
-- Uncomment the following section if you want sample bus data

/*
INSERT INTO `buses` (`incharge_id`, `bus_number`, `route`, `bus_type`, `district`, `shift1_time`, `shift2_time`, `stop1`, `stop2`, `stop3`) VALUES
(1, 'TN 72 N 7457', 'Madurai - Thoothukudi', 'SETC', 'Madurai', '10:30:00', '12:30:00', 'Madurai', 'Aruppukottai', 'Ettayapuram'),
(2, 'TN 01 AB 1234', 'Chennai - Coimbatore', 'Point-To-Point', 'Chennai', '06:00:00', '14:00:00', 'Chennai', 'Coimbatore', NULL),
(3, 'TN 45 CD 5678', 'Salem - Erode', 'Route Bus', 'Salem', '08:00:00', '16:00:00', 'Salem', 'Namakkal', 'Erode');
*/

-- ============================================================================
-- INDEXES AND OPTIMIZATIONS
-- ============================================================================
-- Additional indexes for better query performance

-- Composite index for common queries on attendance table
-- ALTER TABLE `attendance` ADD INDEX `idx_date_status` (`attendance_date`, `status`);

-- Index for bus search by type and district
-- ALTER TABLE `buses` ADD INDEX `idx_type_district` (`bus_type`, `district`);

-- ============================================================================
-- VIEWS (Optional - for easier data access
-- )
-- ============================================================================

-- View: Active buses with latest attendance status
CREATE OR REPLACE VIEW `bus_status_today` AS
SELECT 
    b.id,
    b.bus_number,
    b.route,
    b.bus_type,
    b.district,
    COALESCE(a.status, 'Not Marked') as attendance_status,
    COALESCE(a.detailed_status, 'Scheduled') as detailed_status,
    a.updated_at as status_updated_at
FROM buses b
LEFT JOIN attendance a ON b.id = a.bus_id AND a.attendance_date = CURDATE();

-- ============================================================================
-- GRANT PERMISSIONS (Optional - adjust as needed)
-- ============================================================================
-- If you're using a specific database user instead of root, uncomment and modify:
-- GRANT ALL PRIVILEGES ON smart_bus_portal.* TO 'your_username'@'localhost';
-- FLUSH PRIVILEGES;

-- ============================================================================
-- VERIFICATION QUERIES
-- ============================================================================
-- Run these queries to verify the setup:

-- Check all tables
SHOW TABLES;

-- Check platform incharges count (should be 38)
SELECT COUNT(*) as total_districts FROM platform_incharges;

-- Check table structures
-- DESCRIBE buses;
-- DESCRIBE attendance;
-- DESCRIBE platform_incharges;
-- DESCRIBE passengers;
-- DESCRIBE special_buses;

-- ============================================================================
-- SETUP COMPLETE
-- ============================================================================
-- Database setup is now complete!
-- 
-- Next steps:
-- 1. Copy all project files to the new system
-- 2. Update db.php if needed (database credentials)
-- 3. Start XAMPP and test the application
-- 4. Change default passwords for platform incharges
-- 
-- For more details, see DEPLOYMENT_GUIDE.md
-- ============================================================================
