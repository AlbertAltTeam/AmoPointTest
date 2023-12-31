<?php
session_start();

// Удаление всех переменных сессии
$_SESSION = array();

// Уничтожение сессии
session_destroy();
?>
