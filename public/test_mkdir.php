<?php
$dir = 'uploads/test_dir';
if (!is_dir($dir)) {
    if (mkdir($dir, 0777, true)) {
        echo "Директория '$dir' успешно создана.";
    } else {
        echo "Не удалось создать директорию '$dir'.";
    }
} else {
    echo "Директория '$dir' уже существует.";
}