<?php

session_start();  // Стартуем сессию

// Проверяем, если сессия не пуста
if (!isset($_SESSION['user_id'])) {
    echo "<p>Сессия не установлена. Пожалуйста, войдите в систему.</p>";
    exit;  // Остановим выполнение кода, если пользователь не авторизован
}
$user_id = $_SESSION['user_id'];  // Получаем user_id из сессии

// Подключение к базе данных
include('db_connect.php');


// Получаем таблицу из GET-параметра
$table = isset($_GET['table']) ? $_GET['table'] : '';

// Получаем записи из выбранной таблицы
if ($table == 'books' || $table == 'books_security' || $table == 'articles') {
    $sql = "SELECT * FROM $table WHERE user_id = $user_id";  // Фильтруем по user_id
    $result = $conn->query($sql);

    // Если форма отправлена, обновляем запись
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_POST['id']; // Получаем ID строки для обновления
        $columns = $conn->query("SHOW COLUMNS FROM $table");
        $updateSQL = "UPDATE $table SET ";

        while ($column = $columns->fetch_assoc()) {
            $columnName = $column['Field'];
            if (isset($_POST[$columnName])) {
                $value = $conn->real_escape_string($_POST[$columnName]);
                $updateSQL .= "$columnName = '$value', ";
            }
        }

        // Убираем последнюю запятую и пробел
        $updateSQL = rtrim($updateSQL, ', ');
        $updateSQL .= " WHERE id = $id AND user_id = $user_id";  // Добавляем проверку на user_id

        if ($conn->query($updateSQL)) {
            echo "<p>Запись обновлена!</p>";
        } else {
            echo "<p>Ошибка обновления: " . $conn->error . "</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактирование базы данных</title>
    <link rel="stylesheet" href="css/styles_anti.css">
</head>
<body>
    <div class="container">
        <h1>Редактирование базы данных</h1>

        <!-- Список таблиц для редактирования -->
        <h2>Выберите таблицу для редактирования</h2>
        <ul>
            <li><a href="?table=books">Книги</a></li>
            <li><a href="?table=books_security">Книги D</a></li>
            <li><a href="?table=articles">Статьи</a></li>
        </ul>

        <?php if ($table): ?>
            <h2>Редактирование таблицы: <?php echo ucfirst($table); ?></h2>
            <table border="1">
                <thead>
                    <tr>
                        <?php
                        // Получаем список столбцов
                        $columnsResult = $conn->query("SHOW COLUMNS FROM $table");
                        while ($column = $columnsResult->fetch_assoc()) {
                            echo "<th>{$column['Field']}</th>";
                        }
                        ?>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Получаем записи из таблицы
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        foreach ($row as $key => $value) {
                            if ($key !== 'id' && $key !== 'user_id') {
                                echo "<td><input type='text' name='{$key}_{$row['id']}' value='{$value}' /></td>";
                            }
                        }
                        echo "<td><form method='POST' action=''>
                                <input type='hidden' name='id' value='{$row['id']}'>
                                <input type='submit' value='Обновить'>
                              </form></td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
// Закрытие соединения
$conn->close();
?>
