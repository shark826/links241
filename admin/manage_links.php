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
$stmt = $pdo->query("SELECT links.id as link_id, links.category, links.title, links.url, links.scale_link, links.description, links.created_at, 
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
    <?php
    include_once('../layouts/head.php');
    ?>
    <title>Управление ссылками</title>

</head>
<body>
    <div class="container-md clink2">
        <h2 class='ubuntu-bold'>Управление ссылками</h2>
        <h3 class="ubuntu-regular">Список ссылок</h3>
        <a class="abutton ubuntu-medium" href="./">Назад в админ-панель</a>
        <a class="btn btn-outline-secondary ubuntu-medium" href="./add_link.php">Добавить ссылку</a>
        
        <hr>
        <div class="row f-s-13">
            <div class="col-1 fs-5 tablhd ubuntu-regular">Категория</div>
            <div class="col-3 fs-5 tablhd ubuntu-regular">Название</div>
            <div class="col-2 fs-5 tablhd ubuntu-regular">URL</div>
            <div class="col-1 fs-5 tablhd ubuntu-regular">Вес ссылки</div>
            <div class="col-3 fs-5 tablhd ubuntu-regular">Описание</div>
            <div class="col-1 fs-5 tablhd ubuntu-regular">Дата</div>
            <div class="col-1 fs-5 tablhd ubuntu-regular">Действие</div>
            <hr>
           
            <?php foreach ($links as $link): ?>
            <div class="col-1 border-end text-wrap"><?php echo htmlspecialchars($link['cat_title']); ?></div>
            <div class="col-3 border-end"><?php echo htmlspecialchars($link['title']); ?></div>
            <div class="col-2 border-end fw-bold"><?php echo htmlspecialchars($link['url']); ?></div>
            <div class="col-1 border-end fw-bold"><?php echo htmlspecialchars($link['scale_link']); ?></div>
            <div class="col-3 lh-1 border-end"><?php echo htmlspecialchars($link['description'] ?? ''); ?></div>
            <div class="col-1 border-end"><?php echo $link['created_at']; ?></div>
            <div class="col-1 border-end">
                <div class="dropdown">
                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" style="font-size=8px;">
                    Действие
                </button>
                <ul class="dropdown-menu dropdown-menu-local" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item fs-8" href="<?php echo "edit_link.php?id=".$link['link_id']; ?>">Изменить</a></li>
                    <li><a class="dropdown-item" href="manage_links.php?delete=<?php echo $link['link_id']; ?>" onclick="return confirm('Вы уверены, что хотите удалить эту ссылку?');">Удалить</a></li>
                    
                </ul>
                </div>
                <!-- <a class="btn btn-sm btn-primary" href="<?php echo "edit_link.php?id=".$link['link_id']; ?>"><img src="./img/edit.png" width="20" height="20" alt=""></a>
                <a class="btn btn-sm btn-danger" href="manage_links.php?delete=<?php echo $link['link_id']; ?>" onclick="return confirm('Вы уверены, что хотите удалить эту ссылку?');"><img src="./img/rf.png" width="20" height="20" alt=""></a>  -->
            </div>
            <?php endforeach; ?>
            
        </div>

    </div>
    <br>
    <p class="ubuntu-light">version <?php echo $versite; ?></p>
     <!-- <script src="../js/bootstrap.min.js"></script> -->
      <script src="../js/bootstrap.bundle.min.js"></script>
     <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> -->
</body>
</html>