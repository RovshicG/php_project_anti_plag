<?php
include('db_connect.php');

// Пробуем подключиться к базе данных
try {
    $conn = getDbConnection();
    echo "Соединение с базой данных успешно установлено!";
} catch (Exception $e) {
    echo "Ошибка подключения: " . $e->getMessage();
}
?>
