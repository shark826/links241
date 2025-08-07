<?php

/**
 * Тут увеличиваем алгоритмическую стоимость BCRYPT до 12.
 * Но это никак не скажется на длине полученного результата, она останется 60 символов
 */
$options = [
    'cost' => 12,
];

echo password_hash("admin123", PASSWORD_BCRYPT, $options);
echo "\n";

?>