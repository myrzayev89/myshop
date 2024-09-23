<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['file'])) {
        $uploadDir = 'uploads/files/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $uploadFile = $uploadDir . basename($_FILES['file']['name']);
        if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {
            echo "Файл успешно загружен: " . $uploadFile;
        } else {
            echo "Ошибка при загрузке файла.";
        }
    } else {
        echo "Файл не передан.";
    }
} else {
    echo '<form enctype="multipart/form-data" method="POST">
            Выберите файл для загрузки:
            <input name="file" type="file" />
            <input type="submit" value="Загрузить" />
          </form>';
}