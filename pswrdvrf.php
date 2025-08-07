<?php

// Смотрите примеры в описании функции password_hash(), чтобы понять, откуда это взялось.
$hash = '$2y$10$2X8z7f6k5Qz3Y9W0r8X1N.k9s1z2y3x4w5v6b7n8m9p0q1r2t3u4v';

if (password_verify('admin123', $hash)) {
    echo 'Пароль правильный!';
} else {
    echo 'Пароль неправильный.';
}

?>