CREATE DATABASE IF NOT EXISTS links_db;
USE links_db;

CREATE TABLE links (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    url VARCHAR(255) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Добавление тестового админа (пароль: admin123)
INSERT INTO admins (username, password) VALUES ('admin', '$2y$10$2X8z7f6k5Qz3Y9W0r8X1N.k9s1z2y3x4w5v6b7n8m9p0q1r2t3u4v');


