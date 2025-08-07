CREATE DATABASE IF NOT EXISTS links_db;
USE links_db;

DROP TABLE IF EXISTS links;
CREATE TABLE links (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category INT(11) NOT NULL,
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

DROP TABLE IF EXISTS category;
CREATE TABLE category (
  id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  cat_title varchar(255) NOT NULL
);

INSERT INTO category (id, cat_title) VALUES
(1,	'Админские штучки'),
(2,	'Общее'),
(3,	'ПТК и АРМы'),
(4,	'Интернет ресурсы'),
(5,	'for tests');

-- Добавление тестового админа (пароль: admin123)
INSERT INTO admins (username, password) VALUES ('admin', '$2y$12$VxPElKt2IiYALaDjkCXXHenzppJetb6BBgYuwbP8dpkzSAoBgfJYS');


