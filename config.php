<?php
// Настройки подключения к базе данных
define("DB_SERVER", "localhost");
define("DB_USER", "links_user");
define("DB_PASS", "Gdk2rvkf");
define("DB_NAME", "links_db");

session_start();

// Подключение к базе данных
try {
    $pdo = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_NAME.";charset=utf8mb4", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ошибка подключения: " . $e->getMessage());
}

// Функция для проверки авторизации
function isLoggedIn() {
    return isset($_SESSION['admin']) && $_SESSION['admin'] === true;
}
?>
