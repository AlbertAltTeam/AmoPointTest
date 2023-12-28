<?php
if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = 'files/';
    // Создаем директорию, если ее не существует
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true); // Можно изменить права доступа по необходимости
    }

    $fileInfo = pathinfo($_FILES['file']['name']);
    $fileExtension = strtolower($fileInfo['extension']);

    if ($fileExtension === 'txt') {
        $uploadFile = $uploadDir . basename($_FILES['file']['name']);

        if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {
            echo '<div class="success"></div><br>';
            $content = file_get_contents($uploadFile);
            $lines = explode("\n", $content);

            foreach ($lines as $line) {
                $parts = explode(',', $line); // Измените ',' на ваш разделитель
                foreach ($parts as $part) {
                    preg_match_all("/\d/", $part, $matches);
                    echo htmlspecialchars($part) . ' = ' . count($matches[0]) . '<br>';
                }
            }
        } else {
            echo '<div class="error"></div>';
        }
    } else {
        echo '<div class="error"></div><br>';
        echo '<div>Допустим только формат .txt</div>';
    }
} else {
    echo '<div class="error"></div>';
}
?>

