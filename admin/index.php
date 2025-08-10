
<?php
require_once '../config.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
<?php
  include_once('../layouts/head.php');
 ?>
    <title>Админ-панель</title>
</head>
<body>
    <div class="container ubuntu-medium">
        <h2>Админ-панель</h2>
        <hr>
        <p><a href="/">Домой</a></p>
        <p><a href="add_link.php">Добавить ссылку</a></p>
        <p><a href="manage_links.php">Управление ссылками</a></p>
        <p><a href="logout.php">Выйти</a></p>
        <br>
        <p class="ubuntu-light">version <?php echo $versite; ?></p>
    </div>
</body>
</html>
