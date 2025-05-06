

<?php
include ('db_connect.php');

// Соединение с базой данных
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_POST['username'];
$password = $_POST['password'];
$type = $_POST['type'];
$name = $_POST['name'];
$text = $_POST['text_book'];
$link = $_POST['link'];

// Проверка пользователя
$sql = "SELECT id FROM users WHERE username='$username' AND password='$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $user_id = $row['id'];

    // Путь для загрузки файлов
    $image_dir = 'uploads/images/';
    $file_dir = 'uploads/files/';

    // Проверяем и загружаем изображение
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image_name = basename($_FILES['image']['name']);
        $image_path = $image_dir . $image_name;

        // Проверяем, является ли файл изображением
        $allowed_image_types = ['jpg', 'jpeg', 'png', 'gif'];
        $image_file_type = strtolower(pathinfo($image_path, PATHINFO_EXTENSION));

        if (in_array($image_file_type, $allowed_image_types)) {
            // Загружаем файл в директорию
            if (move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
                echo "Изображение загружено успешно.<br>";
            } else {
                echo "Ошибка загрузки изображения.<br>";
            }
        } else {
            echo "Неподдерживаемый формат изображения.<br>";
        }
    } else {
        $image_name = null; // Если изображение не загружено
    }

    // Проверяем и загружаем PDF/Word файл
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $file_name = basename($_FILES['file']['name']);
        $file_path = $file_dir . $file_name;

        // Проверяем формат файла
        $allowed_file_types = ['pdf', 'doc', 'docx'];
        $file_file_type = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));

        if (in_array($file_file_type, $allowed_file_types)) {
            // Загружаем файл в директорию
            if (move_uploaded_file($_FILES['file']['tmp_name'], $file_path)) {
                echo "Файл загружен успешно.<br>";
            } else {
                echo "Ошибка загрузки файла.<br>";
            }
        } else {
            echo "Неподдерживаемый формат файла.<br>";
        }
    } else {
        $file_name = null; // Если файл не загружен
    }

    // Вставка данных в соответствующую таблицу
    if ($type == 'book') {
        $sql = "INSERT INTO books (name, text_book, link, image_name, file_name, user_id) 
                VALUES ('$name', '$text', '$link', '$image_name', '$file_name', $user_id)";
    } elseif ($type == 'book_d') {
        $sql = "INSERT INTO books_security (name, text_book, link, image_name, file_name, user_id) 
                VALUES ('$name', '$text', '$link', '$image_name', '$file_name', $user_id)";
    } elseif ($type == 'article') {
        $sql = "INSERT INTO articles (title, text_article, image_name, file_name, user_id) 
                VALUES ('$name', '$text', '$image_name', '$file_name', $user_id)";
    } else {
        echo "Invalid type.";
        exit();
    }

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Invalid username or password";
}

$conn->close();
?>
```
