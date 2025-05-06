<?php
session_start(); // Начинаем сессию

// Уничтожаем сессию
session_unset(); // Очистка данных сессии
session_destroy(); // Завершение сессии

// Перенаправляем на страницу входа
header("Location: check.php");
exit();
?>
