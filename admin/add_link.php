<?php
require_once '../config.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categid = $_POST['categs'] ?? '';
    $title = $_POST['title'] ?? '';
    $url = $_POST['url'] ?? '';
    $scale_link = $_POST['scale_link'] ?? '';
    $description = $_POST['description'] ?? '';
    
    if ($title && $url && $categid && $scale_link > -1) {
        $stmt = $pdo->prepare("INSERT INTO links (category, title, url, scale_link, description) VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$categid, $title, $url, $scale_link, $description])) {
            $message = 'Ссылка успешно добавлена';
        } else {
            $message = 'Ошибка при добавлении ссылки';
        }
    } else {
        $message = 'Заполните обязательные поля';
    }
}

// Получение списка ссылок
$stmt = $pdo->query("SELECT * from links LEFT JOIN category ON category=category.id ORDER BY created_at DESC");
$links = $stmt->fetchAll();
$stmt2 = $pdo->query("SELECT * FROM category ORDER BY id");
$categs = $stmt2->fetchAll();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <?php
    include_once('../layouts/head.php');
    ?>
    <title>Добавить ссылку</title>

</head>
<body>
        <div class="container clink2">

            <h3>Добавить новую ссылку</h3>
            <form method="post">
                <div class="form-group">
                    <label for="categs">Каегория ссылки:</label>
                    <select name="categs" id="categs">
                        <?php
                        foreach ($categs as $categ):
                            echo '<option value="'.htmlspecialchars($categ['id']).'">'.htmlspecialchars($categ['cat_title'])."</option>\n";
                        endforeach;
                        ?>
                        <!-- <option value="dog">Dog</option>
                        <option value="cat">Cat</option> -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="title">Название</label>
                    <input type="text" id="title" name="title" placeholder="Label" required>
                </div>
                <div class="form-group">
                    <label for="url">URL</label>
                    <input type="url" id="url" name="url" placeholder="http(s)://IP o URL" required>
                </div>
                <div class="form-group">
                    <label for="scale_link">Вес ссылки (от 0 до 10, где 10 более значимый вес)</label>
                    <input type="number" min="0" max="10" id="scale_link" name="scale_link" value="0" required>
                </div>
                <div class="form-group">
                    <label for="description">Описание</label>
                    <textarea id="description" name="description"></textarea>
                </div>
                <button type="submit">Добавить</button>
                <a class="abutton" href="./">Назад в админ-панель</a>
            </form> 
            <br>
            <br>
            
                <?php if ($message): ?>
                    <p class="<?php echo strpos($message, 'Ошибка') === false ? 'success' : 'error'; ?>">
                        <?php echo $message; ?>
                    </p>
                <?php endif; ?>
        </div>
</body>

 