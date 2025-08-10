<?php
require_once '../config.php';

if (isLoggedIn()) {
    header('Location: index.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->execute([$username]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin'] = true;
        header('Location: index.php');
        exit;
    } else {
        $error = 'Неверное имя пользователя или пароль';
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
<?php
 include_once('../layouts/head.php');
 ?>
 <title>Вход в админ-панель</title>

</head>
<body>
    <div class="container">
        <h2 class='ubuntu-bold'>Вход в админ-панель</h2>
        <?php if ($error): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php else:
            echo ' '; 
         endif; ?>
        <form method="post">
            <div class="form-group">
                <label for="username">Имя пользователя</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Пароль</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button class= "ubuntu-medium" type="submit">Войти</button>
            <p class="ubuntu-light">version <?php echo $versite; ?></p>
        </form>
    </div>
</body>
</html>
