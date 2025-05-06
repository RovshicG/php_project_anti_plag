<?php
session_start();

// Принудительное использование HTTPS для защиты сессий (если это нужно)
if ($_SERVER['HTTPS'] != "on") {
    header("Location: https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    exit();
}

// Установка времени жизни сессии (в секундах)
$inactive = 900;  // 15 минут = 900 секунд

// Проверка, установлено ли время последней активности
if (isset($_SESSION['last_activity'])) {
    $session_life = time() - $_SESSION['last_activity'];

    // Если прошло больше 15 минут, уничтожаем сессию и перенаправляем
    if ($session_life > $inactive) {
        session_unset();    // Убираем все переменные сессии
        session_destroy();  // Уничтожаем сессию
        header("Location: session_expired.php"); // Перенаправляем на страницу истечения сессии
        exit();
    }
}

// Обновляем время последней активности
$_SESSION['last_activity'] = time();

// Регенерация session ID для защиты от сессионного фиксинга
if (isset($_SESSION['user_id'])) {
    session_regenerate_id(true);
}

// Проверка ролей
if (!isset($_SESSION['role'])) {
    // Если не авторизован, перенаправляем на главную страницу
    header("Location: index.php");
    exit();
}

if ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'user' && $_SESSION['role'] !== 'guest') {
    // Если это не админ или юзер, перенаправляем на другую страницу
    header("Location: index.php");
    exit();
}

// Защита от CSRF: добавление токена
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        // Невалидный CSRF токен
        die('CSRF attack detected.');
    }
}

// Генерация CSRF токена для защищенных форм
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // Создание случайного токена
}

?>

