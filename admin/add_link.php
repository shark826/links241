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
    $description = $_POST['description'] ?? '';

    if ($title && $url && $categid) {
        $stmt = $pdo->prepare("INSERT INTO links (category, title, url, description) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$categid, $title, $url, $description])) {
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить ссылку</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
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
                    <input type="text" id="title" name="title" required>
                </div>
                <div class="form-group">
                    <label for="url">URL</label>
                    <input type="url" id="url" name="url" required>
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

 