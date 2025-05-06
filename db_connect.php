<?php
function getDbConnection() {
    // Параметры подключения к базе данных
    $servername = "localhost";  // или IP вашего сервера MySQL
    $username = "root";  // Ваше имя пользователя MySQL
    $password = "";  // Ваш пароль MySQL
    $dbname = "book_db"; // Имя вашей базы данных

    // Создаем подключение
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Проверяем подключение
    if ($conn->connect_error) {
        // В случае ошибки подключения, выводим ошибку и прекращаем выполнение
        die("Ошибка подключения: " . $conn->connect_error);
    }

    // Устанавливаем кодировку для подключения (для предотвращения проблем с русским текстом)
    if (!$conn->set_charset("utf8")) {
        die("Ошибка установки кодировки utf8: " . $conn->error);
    }

    // Проверяем успешность подключения
    if (!$conn->ping()) {
        die("Проблема с подключением: " . $conn->error);
    }

    // Возвращаем объект подключения
    return $conn;
}
?>
