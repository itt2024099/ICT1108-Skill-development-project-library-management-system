-- Web-Based Library Management System
-- Faculty of Technology, Rajarata University of Sri Lanka
-- Course: ICT 1108 - Skill Development Project I
-- Database Schema: library_db (MySQL / MariaDB)
CREATE DATABASE IF NOT EXISTS `library_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `library_db`;

-- 1. User Roles Table
CREATE TABLE IF NOT EXISTS `roles` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `role_name` VARCHAR(50) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `roles` (`id`, `role_name`) VALUES 
(1, 'Admin'), 
(2, 'Librarian'), 
(3, 'Member')
ON DUPLICATE KEY UPDATE `role_name` = VALUES(`role_name`);

-- 2. Users Table (Students & Staff)
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `role_id` INT NOT NULL DEFAULT 3,
  `reg_no` VARCHAR(50) NOT NULL UNIQUE,
  `full_name` VARCHAR(150) NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  `profile_pic` VARCHAR(255) DEFAULT 'images/default-avatar.png',
  `id_card_front` VARCHAR(255) NULL,
  `id_card_back` VARCHAR(255) NULL,
  `department` VARCHAR(100) DEFAULT 'Information & Communication Technology',
  `academic_year` VARCHAR(20) DEFAULT '2023/2024',
  `status` ENUM('Pending', 'Active', 'Suspended', 'Rejected') NOT NULL DEFAULT 'Pending',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`role_id`) REFERENCES `roles`(`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. Book Categories Table
CREATE TABLE IF NOT EXISTS `categories` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `category_name` VARCHAR(100) NOT NULL UNIQUE,
  `description` TEXT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `categories` (`id`, `category_name`, `description`) VALUES
(1, 'Computer Science & Software', 'Programming, Algorithms, Data Structures, Web Development'),
(2, 'Information Systems & Security', 'Database Design, Cyber Security, Networking, IT Management'),
(3, 'Electronics & Telecommunication', 'Circuits, Microcontrollers, Signal Processing, IoT'),
(4, 'Mathematics & Statistics', 'Linear Algebra, Calculus, Applied Probability'),
(5, 'General Science & Technology', 'Technical Communication, Research Methodology, Innovations')
ON DUPLICATE KEY UPDATE `category_name` = VALUES(`category_name`);

-- 4. Books Table
CREATE TABLE IF NOT EXISTS `books` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `category_id` INT NOT NULL,
  `isbn` VARCHAR(30) NOT NULL UNIQUE,
  `title` VARCHAR(200) NOT NULL,
  `author` VARCHAR(150) NOT NULL,
  `publisher` VARCHAR(100) NULL,
  `published_year` INT NULL,
  `total_copies` INT NOT NULL DEFAULT 1,
  `available_copies` INT NOT NULL DEFAULT 1,
  `shelf_location` VARCHAR(50) NULL,
  `cover_image` VARCHAR(255) DEFAULT 'images/default-book.png',
  `description` TEXT NULL,
  `status` ENUM('Available', 'Borrowed', 'Reserved', 'Under Maintenance') NOT NULL DEFAULT 'Available',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 5. Circulation & Borrowing Log Table
CREATE TABLE IF NOT EXISTS `borrow_records` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `book_id` INT NOT NULL,
  `accession_no` VARCHAR(50) NOT NULL,
  `issue_date` DATE NOT NULL,
  `due_date` DATE NOT NULL,
  `return_date` DATE NULL,
  `fine_amount` DECIMAL(8, 2) NOT NULL DEFAULT 0.00,
  `status` ENUM('Active', 'Returned', 'Overdue') NOT NULL DEFAULT 'Active',
  `issued_by` INT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`book_id`) REFERENCES `books`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 6. Member Bookmarks Table
CREATE TABLE IF NOT EXISTS `bookmarks` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `book_id` INT NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `user_book_unique` (`user_id`, `book_id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`book_id`) REFERENCES `books`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 7. Book Reviews & Feedback Table
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `book_id` INT NOT NULL,
  `rating` TINYINT NOT NULL CHECK (`rating` BETWEEN 1 AND 5),
  `review_text` TEXT NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`book_id`) REFERENCES `books`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Sample Seed Data (Passwords: admin123 for Admin, password123 for Student)
INSERT INTO `users` (`id`, `role_id`, `reg_no`, `full_name`, `email`, `password_hash`, `department`, `status`) VALUES
(1, 1, 'ADM/2026/001', 'Head Librarian', 'admin@tec.rjt.ac.lk', '$2y$10$zZyhRqnj9Lkj2L2HsBj2Keif/aqSKf95XTOvJI4kJ9UK57MgNvEiC', 'Library Administration', 'Active'),
(2, 3, 'ITT/2024/099', 'Dulaj Senarathna', 'itt2024099@tec.rjt.ac.lk', '$2y$10$A41792CTXPHc8wvgP..Xv.xj/E/JzFQ8N8T5W5qTbwF2y0Y5fkEf6', 'Technology', 'Active')
ON DUPLICATE KEY UPDATE `password_hash` = VALUES(`password_hash`);

INSERT INTO `books` (`id`, `category_id`, `isbn`, `title`, `author`, `publisher`, `published_year`, `total_copies`, `available_copies`, `shelf_location`, `status`) VALUES
(1, 1, '978-0132350884', 'Clean Code: A Handbook of Agile Software Craftsmanship', 'Robert C. Martin', 'Prentice Hall', 2008, 5, 3, 'Rack A-12', 'Available'),
(2, 1, '978-0262033848', 'Introduction to Algorithms (4th Edition)', 'Thomas H. Cormen', 'MIT Press', 2022, 6, 2, 'Rack A-15', 'Available'),
(3, 2, '978-0134494166', 'Database System Concepts (7th Edition)', 'Abraham Silberschatz', 'McGraw-Hill', 2019, 4, 4, 'Rack B-04', 'Available'),
(4, 5, '978-0134093413', 'Computer Networks (6th Edition)', 'Andrew S. Tanenbaum', 'Pearson', 2021, 3, 1, 'Rack B-08', 'Available')
ON DUPLICATE KEY UPDATE `isbn` = VALUES(`isbn`);
