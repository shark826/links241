<?php
// Настройки подключения к базе данных
include_once '/var/www/sites/links.cfg/db.php';

session_start();
$versite = "0.25.8.19";

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
