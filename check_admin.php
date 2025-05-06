<?php
session_start();

// Проверяем, авторизован ли пользователь и является ли он администратором
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // Если нет, перенаправляем на страницу входа или выводим сообщение
    header("Location: access_denied.php");
    exit();
}
?>
