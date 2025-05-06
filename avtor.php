<?php if ($row['role'] == 'admin') {
        echo '<li><a href="registrate.php">Регистрация статьи</a></li>';
        echo '<li><a href="antiplag.php">Антиплагиат</a></li>';
    } elseif ($row['role'] == 'user') {
        echo '<li><a href="registrate.php">Регистрация статьи</a></li>';
        echo '<li><a href="antiplag.php">Антиплагиат</a></li>';
    } elseif ($row['role'] == 'guest') {

    }
    ?>