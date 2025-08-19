
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
        <div class="row">
            <p class="padmin"><a href="/">Домой</a></p>
            <p class="padmin"><a href="add_link.php">Добавить ссылку</a></p>
            <p class="padmin"><a href="manage_links.php">Управление ссылками</a></p>
            <p class="padmin"><a href="logout.php">Выйти</a></p>
        </div>

        <br>
        <p class="ubuntu-light">version <?php echo $versite; ?></p>
    </div>
</body>
</html>
