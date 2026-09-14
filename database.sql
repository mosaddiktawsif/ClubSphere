CREATE DATABASE IF NOT EXISTS clubsphere_db;
USE clubsphere_db;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('admin', 'moderator', 'captain', 'member') NOT NULL DEFAULT 'member',
    status ENUM('pending', 'approved', 'rejected') NOT NULL DEFAULT 'pending',
    joined_date DATETIME NOT NULL
);

CREATE TABLE IF NOT EXISTS club_fund (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type ENUM('income', 'expense') NOT NULL,
    description VARCHAR(255) NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    transaction_date DATETIME NOT NULL,
    created_by INT,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS tournaments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    game_type VARCHAR(50) NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    prize_pool DECIMAL(10,2) NOT NULL DEFAULT 0,
    region VARCHAR(50) NOT NULL,
    status ENUM('upcoming', 'ongoing', 'completed') NOT NULL DEFAULT 'upcoming',
    created_by INT,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL
);
