<?php

if (basename(__FILE__) === basename($_SERVER['SCRIPT_FILENAME'])) {
    header("HTTP/1.0 403 Forbidden");
    exit('Этот файл не может быть прямо запущен.');
}

$servername = "localhost"; // Имя сервера
$username = "username"; // Имя пользователя базы данных
$password = "password"; // Пароль пользователя базы данных
$dbname = "dbname"; // Имя базы данных

// Создаем подключение
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверяем подключение
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


/* создаем базу данных и 2 таблички в ней

CREATE TABLE IF NOT EXISTS visits (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ip TEXT NOT NULL,
    city TEXT NOT NULL,
    device TEXT NOT NULL,
    visit_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)

CREATE TABLE IF NOT EXISTS users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)

*/
