<?php
require_once('../db_connect.php');

// Добавляем заголовки CORS для разрешения доступа с любых источников
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Проверка, что запрос был отправлен методом POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получение данных из тела запроса
    $data = json_decode(file_get_contents('php://input'), true);

    // Проверка наличия данных
    if ($data && isset($data['ip']) && isset($data['device'])) {

        // Получение данных о посетителе из запроса
        $ip = $data['ip'];

        $ch = curl_init('http://ip-api.com/json/' . $ip . '?lang=ru');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $res = curl_exec($ch);
        curl_close($ch);

        $res = json_decode($res, true);
        $city = $res['city'];
        $device = $data['device'];

        // Подготовка SQL-запроса для сохранения данных в базу
        $sql = "INSERT INTO visits (ip, city, device) VALUES ('$ip', '$city', '$device')";

        // Выполнение запроса и проверка успешности выполнения
        if ($conn->query($sql) === TRUE) {
            echo "Данные успешно сохранены";
        } else {
            echo "Ошибка: " . $sql . "<br>" . $conn->error;
        }

        // Закрытие соединения с базой данных
        $conn->close();
    } else {
        echo "Ошибка: Некорректные данные";
    }
} else {
    echo "Ошибка: Неподдерживаемый метод запроса";
}
?>
