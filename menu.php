<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="bootstrap-4.0.0-dist/css/bootstrap.min.css">
    <script src="bootstrap-4.0.0-dist/js/bootstrap.bundle.min.js"></script>
    <style>
        /* Шапка */
        .navbar {
            background-color: #343a40;  /* Темный фон */
            padding: 5px 0;  /* Уменьшаем отступы */
        }

        .navbar-brand img {
            height: 40px;  /* Высота логотипа */
            width: auto;  /* Автоматическая ширина для сохранения пропорций */
        }

        .navbar-nav .nav-link {
            color: white;  /* Цвет ссылок */
            font-size: 16px;
            margin-left: 20px;
            padding: 8px 12px;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: #ffdd57;  /* Желтая подсветка активных и нажатых ссылок */
            font-weight: bold;
        }

        /* Адаптация для мобильных устройств */
        @media (max-width: 768px) {
            .navbar-nav {
                text-align: center;
            }

            .navbar-nav .nav-link {
                margin-left: 0;
                margin-bottom: 10px;
            }

            .navbar-toggler {
                border-color: #ffdd57;  /* Желтая кнопка меню */
            }

            .navbar-toggler-icon {
                background-color: #ffdd57; /* Желтая иконка */
            }
        }
    </style>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }

        .main-content {
            max-width: 800px;
            margin: 30px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            font-size: 28px;
            color: #343a40;
            margin-bottom: 20px;
        }

        .text-form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-size: 16px;
            font-weight: bold;
            color: #495057;
        }

        input[type="text"], textarea {
            font-size: 16px;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            width: 100%;
            box-sizing: border-box;
        }

        input[type="text"]:focus, textarea:focus {
            border-color: #007bff;
            outline: none;
        }

        textarea {
            resize: vertical;
            min-height: 150px;
        }

        .submit-button {
            background-color: #007bff;
            color: white;
            padding: 12px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .submit-button:hover {
            background-color: #0056b3;
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

        /* Адаптивность */
        @media (max-width: 768px) {
            .main-content {
                margin: 20px;
                padding: 15px;
            }

            h1 {
                font-size: 24px;
            }

            label, input[type="text"], textarea {
                font-size: 14px;
            }

            .submit-button {
                padding: 10px 15px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <?php include ('header.inc.php');?>
    <footer class="footer">
    <?php
        include("footer.inc.php");
        ?>
        </footer>
</body>
</html>