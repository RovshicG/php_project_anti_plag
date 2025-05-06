<?php
session_start(); // Обязательно для начала сессии

// Проверка, что пользователь авторизован
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$username = $_SESSION['username'] ?? ''; // Получаем имя пользователя из сессии, если оно существует
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить статью</title>
    <link rel="stylesheet" href="bootstrap-4.0.0-dist/css/bootstrap.min.css">
    <style>
        .navbar {
            background-color: #343a40;
            padding: 5px 0;
        }
        .navbar-brand img {
            height: 40px;
            width: auto;
        }
        .navbar-nav .nav-link {
            color: white;
            font-size: 16px;
            margin-left: 20px;
            padding: 8px 12px;
        }
        footer.footer {
            background-color: #343a40;
            color: white;
            padding: 10px;
            text-align: center;
            position: fixed;
            width: 100%;
            bottom: 0;
            left: 0;
        }
        footer p {
            margin: 0;
            font-size: 14px;
        }
        .form-container {
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <?php include('header.inc.php'); ?>

    <div class="container form-container">
        <div class="row">
            <!-- Левая часть формы -->
            <div class="col-md-6">
                <h2>Добавить книгу или статью</h2>
                <form action="submit.php" method="post" enctype="multipart/form-data" id="form" onsubmit="return validateForm()">
                    <div class="form-group">
                        <label for="username">Имя пользователя</label>
                        <input type="text" id="username" name="username" class="form-control" value="<?php echo htmlspecialchars($username); ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="password">Пароль</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                        <input type="checkbox" id="show-password" onclick="togglePasswordVisibility()"> Показать пароль
                    </div>
                    <div class="form-group">
                        <label for="type">Тип</label>
                        <select id="type" name="type" class="form-control" required>
                            <option value="book">Несекретно</option>
                            <option value="book_d">Для служебного пользования</option>
                            <option value="article">Секретно</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="type_book">Тип документа</label>
                        <select id="type_book" name="type_book" class="form-control" required>
                            <option value="Книга">Книга</option>
                            <option value="Статья">Статья</option>
                            <option value="Доклад">Доклад</option>
                            <option value="Презентация">Презентация</option>
                            <option value="Другое">Другое</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Название</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="author">Автор</label>
                        <input type="text" id="author" name="author" class="form-control" required>
                    </div>
            </div>

            <!-- Правая часть формы -->
            <div class="col-md-6">
                    <div class="form-group">
                        <label for="link">Ссылка</label>
                        <input type="text" id="link" name="link" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="image">Загрузить фото</label>
                        <input type="file" id="image" name="image" class="form-control-file" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label for="file">Загрузить PDF, Word или Презентацию</label>
                        <input type="file" id="file" name="file" class="form-control-file" accept=".pdf, .doc, .docx, .ppt, .pptx">
                    </div>
                    <div class="form-group">
                        <label for="text_book">Текст</label>
                        <textarea id="text_book" name="text_book" rows="10" class="form-control" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Добавить</button>
                </form>
            </div>
        </div>
    </div>

    <script src="bootstrap-4.0.0-dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePasswordVisibility() {
            const passwordField = document.getElementById("password");
            const showPasswordCheckbox = document.getElementById("show-password");
            if (showPasswordCheckbox.checked) {
                passwordField.type = "text"; // Показать пароль
            } else {
                passwordField.type = "password"; // Скрыть пароль
            }
        }

        function validateForm() {
            let errorMessages = [];
            if (document.getElementById("username").value === "") {
                errorMessages.push("Имя пользователя обязательно.");
            }
            if (document.getElementById("password").value === "") {
                errorMessages.push("Пароль обязателен.");
            }
            if (document.getElementById("name").value === "") {
                errorMessages.push("Название обязательно.");
            }
            if (document.getElementById("text_book").value === "") {
                errorMessages.push("Текст обязательно.");
            }

            if (errorMessages.length > 0) {
                alert(errorMessages.join("\n"));
                return false;
            }
            return true;
        }
    </script>

    <footer class="footer">
        <?php include("footer.inc.php"); ?>
    </footer>
</body>
</html>
