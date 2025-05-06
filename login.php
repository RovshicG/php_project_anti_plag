<?php
session_start(); // Начинаем сессию

include('db_connect.php'); // Подключаемся к базе данных

// Проверяем, что форма была отправлена
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Получаем данные из формы
    $user = htmlspecialchars($_POST['username']);
    $pass = $_POST['password'];

    // Подключаемся к базе данных с помощью функции getDbConnection
    $conn = getDbConnection();

    // Подготовленный SQL-запрос для проверки данных пользователя
    $sql = "SELECT id, password, role FROM users WHERE username=?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die('Ошибка в подготовке запроса: ' . $conn->error);
    }

    // Привязываем параметр и выполняем запрос
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    // Проверка наличия пользователя
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Сравниваем введенный пароль с сохраненным в базе
        if ($pass === $row['password']) {
            // Сохраняем информацию о пользователе в сессию
            $_SESSION['username'] = $user;
            $_SESSION['role'] = $row['role'];
            $_SESSION['user_id'] = $row['id']; // Сохраняем ID пользователя
            
            // Перенаправляем на главную страницу
            header("Location: menu.php");
            exit();
        } else {
            // Неверный пароль
            echo "Неверное имя пользователя или пароль.";
        }
    } else {
        // Неверное имя пользователя
        echo "Неверное имя пользователя или пароль.";
    }

    // Закрытие соединения с базой данных
    $stmt->close();
    $conn->close();
}
?>
