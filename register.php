<?php
session_start(); // Начинаем сессию

include('db_connect.php'); // Подключаемся к базе данных

// Проверяем, что форма была отправлена
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Получаем данные из формы и фильтруем их
    $user = htmlspecialchars($_POST['username']);
    $pass = $_POST['password'];

    // Хешируем пароль
    $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

    // Подключаемся к базе данных с помощью функции getDbConnection
    $conn = getDbConnection();

    // Проверка, существует ли уже пользователь с таким именем
    $sql_check = "SELECT id FROM users WHERE username=?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $user);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        echo "Ошибка: Пользователь с таким именем уже существует.";
    } else {
        // Подготовленный SQL-запрос для добавления нового пользователя
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $user, $hashed_password);
        $stmt->execute();

        echo "Регистрация прошла успешно. Теперь вы можете войти.";
    }

    // Закрытие соединения с базой данных
    $stmt->close();
    $stmt_check->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="bootstrap-4.0.0-dist/css/bootstrap.min.css">
</head>
<body>

    <div class="container">
        <h2>Регистрация</h2>
        <form action="register.php" method="post">
            <div class="form-group">
                <label for="username">Имя пользователя</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="password">Пароль</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
        </form>
    </div>

    <script src="bootstrap-4.0.0-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
