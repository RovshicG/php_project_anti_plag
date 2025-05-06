<?php
session_start(); // Начинаем сессию
    
include ('db_connect.php');

// Подключение к базе данных
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Получаем данные из формы
$user = $_POST['username'];
$pass = $_POST['password'];

// SQL-запрос для проверки данных пользователя
$sql = "SELECT role FROM users WHERE username='$user' AND password='$pass'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
    // Сохраняем информацию о пользователе в сессию
    $_SESSION['username'] = $user;
    $_SESSION['role'] = $row['role'];
    
    // Перенаправляем на главную страницу
    header("Location: menu.php");
    exit();
} 
elseif {
    // Неверное имя пользователя или пароль
    header("Location: index.html");
    echo "Invalid username or password";
}

// Закрытие соединения с базой данных
$conn->close();
?>