USE clubsphere_db;

ALTER TABLE users
    ADD COLUMN status ENUM('pending', 'approved', 'rejected') NOT NULL DEFAULT 'pending' AFTER role;


UPDATE users SET status = 'approved';

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
