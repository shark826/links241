<?php
require_once 'config.php';

// Получение списка ссылок
$stmt = $pdo->query("SELECT * FROM links ORDER BY title");
$links = $stmt->fetchAll();
$stmt2 = $pdo->query("SELECT * FROM category ORDER BY id");
$categs = $stmt2->fetchAll();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Полезные ссылки</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <div class="bluredbg">
            <div class="linksvip">
                <h2 class="roboto-700" style="text-align: center;">Полезные ссылки</h2>
                <div class="container-md">
                    <div class="row">
                        <div class="col text-end">Генератор паролей</div>
                        <div class="col">
                            <a href="http://10.13.120.241:82" target="_blank" rel="noopener noreferrer">http://10.13.120.241:82</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col text-end">Сделай Бэйджик</div>
                        <div class="col">
                            <a href="http://10.13.120.241:83" target="_blank" rel="noopener noreferrer">http://10.13.120.241:83</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col text-end">Проверь скорость</div>
                        <div class="col">
                            <a href="http://10.13.120.241:85" target="_blank" rel="noopener noreferrer">http://10.13.120.241:85</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col text-end">Библиотека</div>
                        <div class="col">
                        <a href="http://10.13.120.27" target="_blank" rel="noopener noreferrer">http://10.13.120.27</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </header>
    <nav>
        <div class="container-md">
            <div class="row">
                <div class="col text-end fw-bolder text-opacity-25">
                    <a class="navlink" href="/admin" >Админ панель</a>
                </div>
            </div>
        </div>
    </nav>
    <?php 
    foreach ($categs as $categ):
        ?>
        <div class="arrow-left" style="float: left; margin-top: 10px; text-align: left;}"></div>
        <h3 class="roboto-700 linksvip" style="text-align: left; 
                                               margin-left: 10%; 
                                               background-color: #4682b424;
	                                           background-size: contain;
                                               display: inline-block;">
        <?php echo htmlspecialchars(strval($categ['id']).". ".$categ['cat_title']); ?>
        </h3>
        
        <div class="container-md clink2">
                <div class="row">
                        <div class="col-4 text-end tablhd">
                            Название
                        </div>
                        <div class="col-3 text-center tablhd">
                            Ссылка
                        </div>
                        <div class="col-5 tablhd">
                        Описание
                        </div>
                </div>
                <hr>
                <?php
                $rowIndex = 0;
                $arcn = count($links); 
                foreach ($links as $link): 
                if ($link['category'] ==$categ['id']) {?>
                    <div class="row<?php if ($rowIndex % 2 == 0):?><?php echo ' bg-light'; endif; ?>">
                        <div class="col-4 text-end d-flex align-items-center justify-content-end border-end roboto-400">
                            <?php echo htmlspecialchars($link['title']);  ?>                     
                        </div>
                        <div class="col-3 text-start d-flex align-items-center border-end roboto-400">
                            <a href="<?php echo htmlspecialchars($link['url']); ?>" target="_blank">
                            <?php echo htmlspecialchars($link['url']); ?>
                            </a>
                        </div>
                        <div class="col-5 descr d-flex align-items-center roboto-200">
                            <?php if ($link['description']): ?>
                            <?php echo htmlspecialchars($link['description']); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php 
                $rowIndex++;
                            } 
                endforeach; ?>
    </div>
    <?php endforeach;?>

    

</body>
</html>
