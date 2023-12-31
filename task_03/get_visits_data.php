<?php
include 'db_connect.php';

// Получение данных о посещениях из базы данных
$sql = "SELECT DATE_FORMAT(visited_at, '%Y-%m-%d %H:00:00') as visit_hour, COUNT(DISTINCT ip) as unique_visits FROM visits GROUP BY visit_hour";
$result = $conn->query($sql);

if (!$result) {
    die("Ошибка запроса: " . $conn->error); // Остановить скрипт и вывести ошибку
}


$visitsData = array();
while ($row = $result->fetch_assoc()) {
    $visitsData[] = array(
        'hour' => $row['visit_hour'],
        'visits' => (int)$row['unique_visits']
    );
}

// Получение данных по городам
$sqlCities = "SELECT city, COUNT(city) as city_count FROM visits GROUP BY city";
$resultCities = $conn->query($sqlCities);
$citiesData = array();
while ($rowCity = $resultCities->fetch_assoc()) {
    $citiesData[$rowCity['city']] = (int)$rowCity['city_count'];
}

// Формируем массив данных для JavaScript
$dataForJS = array(
    'visitsByHour' => $visitsData,
    'visitsByCity' => $citiesData
);

// Преобразуем данные в JSON
$jsonData = json_encode($dataForJS);

// Закрытие соединения с базой данных
$conn->close();

// Возвращаем данные в виде JSON
echo $jsonData;
?>
