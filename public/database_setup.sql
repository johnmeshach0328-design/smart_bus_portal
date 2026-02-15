-- 1. Create the Database
CREATE DATABASE IF NOT EXISTS smart_bus_portal;
USE smart_bus_portal;

-- 2. Create Platform Incharges Table (Staff Admins)
CREATE TABLE IF NOT EXISTS platform_incharges (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    reg_id VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    district VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 3. Insert All 38 District Administrators
INSERT INTO platform_incharges (username, reg_id, password, district) VALUES
('AriyalurAdmin', 'REG1000', 'TVLAD', 'Ariyalur'),
('ChengalpattuAdmin', 'REG1001', 'TVLAD', 'Chengalpattu'),
('ChennaiAdmin', 'REG1002', 'TVLAD', 'Chennai'),
('CoimbatoreAdmin', 'REG1003', 'TVLAD', 'Coimbatore'),
('CuddaloreAdmin', 'REG1004', 'TVLAD', 'Cuddalore'),
('DharmapuriAdmin', 'REG1005', 'TVLAD', 'Dharmapuri'),
('DindigulAdmin', 'REG1006', 'TVLAD', 'Dindigul'),
('ErodeAdmin', 'REG1007', 'TVLAD', 'Erode'),
('KallakurichiAdmin', 'REG1008', 'TVLAD', 'Kallakurichi'),
('KancheepuramAdmin', 'REG1009', 'TVLAD', 'Kancheepuram'),
('KanniyakumariAdmin', 'REG1010', 'TVLAD', 'Kanniyakumari'),
('KarurAdmin', 'REG1011', 'TVLAD', 'Karur'),
('KrishnagiriAdmin', 'REG1012', 'TVLAD', 'Krishnagiri'),
('MaduraiAdmin', 'REG1013', 'TVLAD', 'Madurai'),
('MayiladuthuraiAdmin', 'REG1014', 'TVLAD', 'Mayiladuthurai'),
('NagapattinamAdmin', 'REG1015', 'TVLAD', 'Nagapattinam'),
('NamakkalAdmin', 'REG1016', 'TVLAD', 'Namakkal'),
('NilgirisAdmin', 'REG1017', 'TVLAD', 'Nilgiris'),
('PerambalurAdmin', 'REG1018', 'TVLAD', 'Perambalur'),
('PudukkottaiAdmin', 'REG1019', 'TVLAD', 'Pudukkottai'),
('RamanathapuramAdmin', 'REG1020', 'TVLAD', 'Ramanathapuram'),
('RanipetAdmin', 'REG1021', 'TVLAD', 'Ranipet'),
('SalemAdmin', 'REG1022', 'TVLAD', 'Salem'),
('SivagangaAdmin', 'REG1023', 'TVLAD', 'Sivaganga'),
('TenkasiAdmin', 'REG1024', 'TVLAD', 'Tenkasi'),
('ThanjavurAdmin', 'REG1025', 'TVLAD', 'Thanjavur'),
('TheniAdmin', 'REG1026', 'TVLAD', 'Theni'),
('ThoothukudiAdmin', 'REG1027', 'TVLAD', 'Thoothukudi'),
('TiruchirappalliAdmin', 'REG1028', 'TVLAD', 'Tiruchirappalli'),
('TirunelveliAdmin', 'REG1029', 'TVLAD', 'Tirunelveli'),
('TirupathurAdmin', 'REG1030', 'TVLAD', 'Tirupathur'),
('TiruppurAdmin', 'REG1031', 'TVLAD', 'Tiruppur'),
('TiruvallurAdmin', 'REG1032', 'TVLAD', 'Tiruvallur'),
('TiruvannamalaiAdmin', 'REG1033', 'TVLAD', 'Tiruvanamalai'),
('TiruvarurAdmin', 'REG1034', 'TVLAD', 'Tiruvarur'),
('VelloreAdmin', 'REG1035', 'TVLAD', 'Vellore'),
('ViluppuramAdmin', 'REG1036', 'TVLAD', 'Viluppuram'),
('VirudhunagarAdmin', 'REG1037', 'TVLAD', 'Virudhunagar');

-- 4. Create Buses Table (With Shits and Stops)
CREATE TABLE IF NOT EXISTS buses (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    incharge_id INT(6) UNSIGNED,
    bus_number VARCHAR(20) NOT NULL,
    route VARCHAR(100) NOT NULL,
    bus_type VARCHAR(50),
    district VARCHAR(50),
    shift1_time VARCHAR(20),
    shift2_time VARCHAR(20),
    shift3_time VARCHAR(20),
    shift4_time VARCHAR(20),
    shift5_time VARCHAR(20),
    shift6_time VARCHAR(20),
    stop1 VARCHAR(100),
    stop2 VARCHAR(100),
    stop3 VARCHAR(100),
    stop4 VARCHAR(100),
    stop5 VARCHAR(100),
    stop6 VARCHAR(100),
    stop7 VARCHAR(100),
    stop8 VARCHAR(100),
    stop9 VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (incharge_id) REFERENCES platform_incharges(id)
);

-- 6. Create Attendance Table
CREATE TABLE IF NOT EXISTS attendance (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    bus_id INT(6) UNSIGNED,
    attendance_date DATE NOT NULL,
    status ENUM('Present', 'Absent') DEFAULT 'Present',
    marked_by INT(6) UNSIGNED,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (bus_id) REFERENCES buses(id),
    FOREIGN KEY (marked_by) REFERENCES platform_incharges(id)
);
