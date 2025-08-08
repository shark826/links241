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
$stmt = $pdo->query("SELECT links.id as link_id, links.category, links.title, links.url, links.description, links.created_at, 
                     category.id as cat_id, category.cat_title from links LEFT JOIN category ON category=category.id ORDER BY created_at DESC");
$links = $stmt->fetchAll();
$stmt2 = $pdo->query("SELECT * FROM category ORDER BY id");
$categs = $stmt2->fetchAll();


if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM links WHERE id = ?");
    if ($stmt->execute([$id])) {
        $message = 'Ссылка успешно удалена';
        header('Location: manage_links.php');
            exit;
    } else {
        $message = 'Ошибка при удалении ссылки';
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление ссылками</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container-md clink2">
        <h2>Управление ссылками</h2>
        <a class="abutton" href="./">Назад в админ-панель</a>
        <h3>Список ссылок</h3>
        <hr>
        <div class="row f-s-13">
            <div class="col-1 fs-5 tablhd">Категория</div>
            <div class="col-3 fs-5 tablhd">Название</div>
            <div class="col-2 fs-5 tablhd">URL</div>
            <div class="col-4 fs-5 tablhd">Описание</div>
            <div class="col-1 fs-5 tablhd">Дата</div>
            <div class="col-1 fs-5 tablhd">Действие</div>
            <hr>
           
            <?php foreach ($links as $link): ?>
            <div class="col-1 border-end text-wrap"><?php echo htmlspecialchars($link['cat_title']); ?></div>
            <div class="col-3 border-end"><?php echo htmlspecialchars($link['title']); ?></div>
            <div class="col-2 border-end fw-bold"><?php echo htmlspecialchars($link['url']); ?></div>
            <div class="col-4 lh-1 border-end"><?php echo htmlspecialchars($link['description'] ?? ''); ?></div>
            <div class="col-1 border-end"><?php echo $link['created_at']; ?></div>
            <div class="col-1 border-end">
                <a class="btn btn-sm btn-primary" href="<?php echo "edit_link.php?id=".$link['link_id']; ?>"><img src="./img/edit.png" width="20" height="20" alt=""></a>
                <a class="btn btn-sm btn-danger" href="manage_links.php?delete=<?php echo $link['link_id']; ?>" onclick="return confirm('Вы уверены, что хотите удалить эту ссылку?');"><img src="./img/rf.png" width="20" height="20" alt=""></a> 
            </div>
            <?php endforeach; ?>
            
        </div>

    </div>
    <br>
    <p>version <?php echo $versite; ?></p>
</body>
</html>