CREATE DATABASE IF NOT EXISTS ams_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE ams_db;

CREATE TABLE IF NOT EXISTS users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  student_no VARCHAR(50) NULL UNIQUE,
  full_name VARCHAR(150) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('admin','teacher','student') NOT NULL DEFAULT 'student',
  course VARCHAR(100) NULL,
  year_level VARCHAR(50) NULL,
  section VARCHAR(50) NULL,
  status ENUM('active','inactive') NOT NULL DEFAULT 'active',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS attendance (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  student_id INT UNSIGNED NOT NULL,
  attendance_date DATE NOT NULL,
  status ENUM('Present','Late','Absent') NOT NULL,
  time_in TIME NULL,
  time_out TIME NULL,
  remarks VARCHAR(255) NULL,
  recorded_by INT UNSIGNED NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY uq_student_date (student_id, attendance_date),
  CONSTRAINT fk_att_student FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE,
  CONSTRAINT fk_att_recorder FOREIGN KEY (recorded_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Demo accounts. Passwords are:
-- admin123 / teacher123 / student123
INSERT IGNORE INTO users (student_no,full_name,email,password,role,course,year_level,section) VALUES
('ADMIN-001','System Administrator','admin@ams.local','$2y$12$Ri7UXIi2EZMXCe0S5a.8N.1Bdmgolo/vh4zEH3gUq8zgW7mzx2XZC','admin','Administration',NULL,'ADMIN'),
('TCH-001','Maria Santos','teacher@ams.local','$2y$12$9IbMac22knBjizcHmij0GewdwCgpmbzPE/bHkHUXDf9YhJJI2ll4K','teacher','BSIT','Faculty','IT'),
('2026-0001','Juan Dela Cruz','student@ams.local','$2y$12$z0izYLp7zR5s6wHy9ST2tezFzaLps0jp57r/pw0Av1bqtT95vDL.W','student','BSIT','4th Year','IT-401'),
('2026-0002','Ana Reyes','ana@ams.local','$2y$12$z0izYLp7zR5s6wHy9ST2tezFzaLps0jp57r/pw0Av1bqtT95vDL.W','student','BSIT','4th Year','IT-401'),
('2026-0003','Mark Garcia','mark@ams.local','$2y$12$z0izYLp7zR5s6wHy9ST2tezFzaLps0jp57r/pw0Av1bqtT95vDL.W','student','BSIT','3rd Year','IT-302');

INSERT IGNORE INTO attendance (student_id,attendance_date,status,time_in,remarks,recorded_by)
SELECT id,CURDATE(),'Present','08:02:00','On time',2 FROM users WHERE student_no='2026-0001';
INSERT IGNORE INTO attendance (student_id,attendance_date,status,time_in,remarks,recorded_by)
SELECT id,CURDATE(),'Late','08:24:00','Traffic',2 FROM users WHERE student_no='2026-0002';
INSERT IGNORE INTO attendance (student_id,attendance_date,status,time_in,remarks,recorded_by)
SELECT id,CURDATE(),'Absent',NULL,'No attendance recorded',2 FROM users WHERE student_no='2026-0003';
