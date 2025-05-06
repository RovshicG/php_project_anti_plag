<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>
    <link rel="stylesheet" href="login.css"> <!-- Подключение CSS файла -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
            margin: 0;
        }

        .login-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        h2 {
            text-align: center;
            margin-bottom: 24px;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 16px;
            border: 1px solid #ced4da;
            border-radius: 6px;
            box-sizing: border-box;
            padding-right: 30px; /* Отступ для иконки */
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            border: none;
            border-radius: 6px;
            color: white;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #007bff;
        }

        .toggle-password:hover {
            color: #0056b3;
        }

        .password-container {
            position: relative;
        }

    </style>
</head>
<body>

    <div class="login-container">
        <h2>Вход</h2>
        <form action="login.php" method="post">
            <label for="username">Имя пользователя</label>
            <input type="text" id="username" name="username" required>

            <div class="password-container">
                <label for="password">Пароль</label>
                <input type="password" id="password" name="password" required>
                <span class="toggle-password" onclick="togglePasswordVisibility()">👁️</span>
            </div>

            <button type="submit">Войти</button>
        </form>
    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordField = document.getElementById('password');
            const passwordIcon = document.querySelector('.toggle-password');
            
            // Toggle password visibility
            if (passwordField.type === "password") {
                passwordField.type = "text";
                passwordIcon.textContent = "🙈"; // Change icon when password is visible
            } else {
                passwordField.type = "password";
                passwordIcon.textContent = "👁️"; // Change icon when password is hidden
            }
        }
    </script>

</body>
</html>
