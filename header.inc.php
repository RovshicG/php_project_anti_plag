<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <!-- Логотип -->
            <a class="navbar-brand" href="index.php">
                <img src="logo/Ozbekiston_Respublikasi_Qurolli_Kuchlar_Akademiyasi-01.png" alt="Логотип" style="height: 40px; width: auto;">
            </a>
            
            <!-- Кнопка для мобильных устройств -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <!-- Меню -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a href="editor.php" class="nav-link <?php if ($currentPage == 'editor.php') { echo 'active'; } ?>">Редактирование статей</a>
                    </li>
                    <li class="nav-item">
                        <a href="registrate.php" class="nav-link <?php if ($currentPage == 'registrate.php') { echo 'active'; } ?>">Регистрация статьи</a>
                    </li>
                    <li class="nav-item">
                        <a href="menu.php" class="nav-link <?php if ($currentPage == 'menu.php') { echo 'active'; } ?>">Меню</a>
                    </li>
                    <li class="nav-item">
                        <a href="filemanager.php" class="nav-link <?php if ($currentPage == 'filemanager.php') { echo 'active'; } ?>">Библиотека</a>
                    </li>
                    <li class="nav-item">
                        <a href="antiplag.php" class="nav-link <?php if ($currentPage == 'antiplag.php') { echo 'active'; } ?>">Антиплагиат</a>
                    </li>
                    <li class="nav-item">
                        <a href="logout.php" class="nav-link <?php if ($currentPage == 'logout.php') { echo 'active'; } ?>">Выход из аккаунта</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="bootstrap-4.0.0-dist/css/bootstrap.min.css">
<script src="bootstrap-4.0.0-dist/js/bootstrap.bundle.min.js"></script>

<style>
    /* Общее оформление шапки */
    .navbar {
        background-color: #343a40;  /* Темный фон */
        padding: 5px 0;  /* Уменьшение отступов */
    }

    .navbar-brand img {
        height: 40px;  /* Уменьшаем высоту логотипа */
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
