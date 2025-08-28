<?php
require_once '../config.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$message = '';


$id = $_GET['id'] ?? 0;


if (!$id) {
    header('Location: manage_links.php');
    exit;
}


// $stmt = $pdo->query("SELECT links.id as link_id, links.category, links.title, links.url, links.description, links.created_at, 
//                      category.id as cat_id, category.cat_title from links LEFT JOIN category ON category=category.id ORDER BY created_at DESC");
// $links = $stmt->fetchAll();


// Получение данных ссылки
$stmt = $pdo->prepare("SELECT links.id as link_id, links.category, links.title, links.url, links.scale_link, links.description, links.created_at, 
                     category.id as cat_id, category.cat_title from links LEFT JOIN category ON category=category.id WHERE links.id = ?");
                    
$stmt->execute([$id]);
$link = $stmt->fetch();


if (!$link) {
    header('Location: manage_links.php');
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categid = $_POST['categs'] ?? '';
    $title = $_POST['title'] ?? '';
    $url = $_POST['url'] ?? '';
    $scale_link = $_POST['scale_link'] ?? '';
    $description = $_POST['description'] ?? '';

    if ($title && $url && $categid) {
        $stmt = $pdo->prepare("UPDATE links SET category = ?, title = ?, url = ?, scale_link = ?, description = ? WHERE id = ?");
        if ($stmt->execute([$categid, $title, $url, $scale_link, $description, $id])) {
            $message = 'Ссылка успешно обновлена';
            header('Location: manage_links.php');
            exit;
        } else {
            $message = 'Ошибка при обновлении ссылки';
        }
    } else {
        $message = 'Заполните обязательные поля';
    }
}


// $linkid=$_GET['id'];

// // Получение списка ссылок
// $stmt = $pdo->query("SELECT * from links LEFT JOIN category ON category=category.id ORDER BY created_at DESC");
// $links = $stmt->fetchAll();
$stmt2 = $pdo->query("SELECT * FROM category ORDER BY id");
$categs = $stmt2->fetchAll();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <?php
    include_once('../layouts/head.php');
    ?>
    <title>Обновить ссылку</title>

</head>
<body>
        <div class="container clink2">
            
            <h3>Редактировать ссылку</h3>
            <form method="post">
                <div class="form-group">
                    <label for="categs">Каегория ссылки:</label>
                    <select name="categs" id="categs">
                        <?php
                        foreach ($categs as $categ):
                            if ($categ['id'] == $link['category']) {
                               echo '<option value="'.htmlspecialchars($categ['id']).'" selected>'.htmlspecialchars($categ['cat_title'])."</option>\n"; 
                            } else {
                               echo '<option value="'.htmlspecialchars($categ['id']).'">'.htmlspecialchars($categ['cat_title'])."</option>\n";
                            }
                            
                        endforeach;
                        ?>
                        <!-- <option value="dog">Dog</option>
                        <option value="cat" selected>Cat</option> -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="title">Название</label>
                    <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($link['title']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="url">URL</label>
                    <input type="url" id="url" name="url" value="<?php echo htmlspecialchars($link['url']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="scale_link">Вес ссылки (от 0 до 10, где 10 более значимый вес)</label>
                    <input type="number" min="0" max="10" id="scale_link" name="scale_link" value="<?php echo htmlspecialchars($link['scale_link']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="description">Описание</label>
                    <textarea id="description" name="description"><?php echo htmlspecialchars($link['description'] ?? ''); ?></textarea>
                </div>
                <button type="submit">Изменить & Закрыть</button>
                <a class="abutton" href="./manage_links.php">Назад к ссылкам</a>
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

 