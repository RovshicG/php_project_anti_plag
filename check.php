<?php
session_start(); // Начинаем сессию

// Проверяем, вошел ли пользователь в систему
if (!isset($_SESSION['username'])) {
    // Если нет, перенаправляем на страницу входа
    header("Location: index.php");
    exit();
}

// Если пользователь вошел, выводим приветствие
echo "Welcome, " . $_SESSION['username'] . "!";

// В зависимости от роли можно показывать разные элементы
if ($_SESSION['role'] == 'admin') {
    echo '<a href="antiplag.php">Антиплагиат!</a><br>';
    echo '<a href="registrate.php">Регистрация новой статьи!</a><br>';
    echo 'Welcome, Admin!';
} elseif ($_SESSION['role'] == 'user') {
    echo '<a href="antiplag.php">Антиплагиат!</a><br>';
    echo '<a href="registrate.php">Регистрация новой статьи!</a><br>';
    echo 'Welcome, User!';
} elseif ($_SESSION['role'] == 'guest') {
    echo 'Welcome, Guest!<br>';
    echo '<a href="antiplag.php">Антиплагиат (Ограниченный доступ)</a><br>';
}

// Добавляем кнопку для выхода
echo '<br><a href="logout.php">Logout</a>';
?>
