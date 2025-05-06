<?php
session_start();  // Обязательно для начала сессии

// Проверка, что пользователь авторизован
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

include('db_connect.php');

$errorMessages = [];  // Массив для хранения ошибок

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Получаем данные из формы
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $type = $_POST['type'] ?? '';  // Тип материала
    $name = trim($_POST['name'] ?? '');
    $text = trim($_POST['text_book'] ?? '');
    $link = trim($_POST['link'] ?? '');
    $author = trim($_POST['author'] ?? 'Unknown');
    $type_book = trim($_POST['type_book'] ?? ''); // Тип документа (Книга, Статья, Доклад, Другое)
    $time_insert = date('Y-m-d H:i:s'); // Текущее время

    // Проверяем, что все обязательные поля заполнены
    if (empty($username)) {
        $errorMessages[] = "Ошибка: Имя пользователя обязательно для заполнения.";
    }
    if (empty($password)) {
        $errorMessages[] = "Ошибка: Пароль обязательно для заполнения.";
    }
    if (empty($type)) {
        $errorMessages[] = "Ошибка: Тип материала обязательно для заполнения.";
    }
    if (empty($name)) {
        $errorMessages[] = "Ошибка: Название обязательно для заполнения.";
    }
    if (empty($text)) {
        $errorMessages[] = "Ошибка: Текст обязательно для заполнения.";
    }
    if (empty($type_book)) {
        $errorMessages[] = "Ошибка: Тип документа обязательно для заполнения.";
    }

    // Если есть ошибки, выводим их и прекращаем выполнение
    if (!empty($errorMessages)) {
        foreach ($errorMessages as $message) {
            echo "<p>$message</p>";
        }
        exit;  // Останавливаем выполнение скрипта
    }

    // Подключаемся к базе данных
    $conn = getDbConnection();

    // Проверяем существование пользователя и пароль
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    
    // Проверка на ошибку при подготовке запроса
    if (!$stmt) {
        die("Ошибка подготовки запроса: " . $conn->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        die("Ошибка: Пользователь не найден.");
    }

    $row = $result->fetch_assoc();
    
    // Сравниваем пароли без хеширования
    if ($password !== $row['password']) {
        die("Ошибка: Неверный пароль.");
    }

    $user_id = $row['id'];
    $stmt->close();

    // Начинаем транзакцию
    $conn->begin_transaction();

    try {
        // Обработка загрузки изображения
        $image_path = null;
        if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] == 0) {
            $image = $_FILES['image'];
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
            $image_path = 'uploads/images/' . uniqid('img_') . '.' . $ext;

            if (!in_array($image['type'], $allowed_types)) {
                throw new Exception("Ошибка: Недопустимый тип файла изображения.");
            }

            if (!move_uploaded_file($image['tmp_name'], $image_path)) {
                throw new Exception("Ошибка: Не удалось загрузить изображение.");
            }
        }

        // Обработка загрузки PDF/Word/PowerPoint файла
        $file_path = null;
        if (!empty($_FILES['file']['name']) && $_FILES['file']['error'] == 0) {
            $file = $_FILES['file'];
            $allowed_types = [
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/vnd.ms-powerpoint',
                'application/vnd.openxmlformats-officedocument.presentationml.presentation'
            ];
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $file_path = 'uploads/files/' . uniqid('file_') . '.' . $ext;

            if (!in_array($file['type'], $allowed_types)) {
                throw new Exception("Ошибка: Недопустимый тип файла.");
            }

            if (!move_uploaded_file($file['tmp_name'], $file_path)) {
                throw new Exception("Ошибка: Не удалось загрузить файл.");
            }
        }

        // Вставляем данные в соответствующую таблицу на основе типа записи
        if ($type === 'book') {
            $sql = "INSERT INTO books (name_book, text_book, file_name, img_book, user_id, author, link, type_book, time_insert) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        } elseif ($type === 'book_d') {
            $sql = "INSERT INTO books_security (name_book, text_book, file_name, img_book, user_id, author, link, type_book, time_insert) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        } elseif ($type === 'article') {
            $sql = "INSERT INTO articles (name_book, text_book, file_name, img_book, user_id, author, link, type_book, time_insert) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        } else {
            throw new Exception("Ошибка: Неверный тип записи.");
        }

        // Подготавливаем и выполняем SQL-запрос
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Ошибка подготовки запроса: " . $conn->error);
        }
        
        if ($type === 'article') {
            $stmt->bind_param("ssissss", $name, $text, $user_id, $author, $link, $type_book, $time_insert);
        } else {
            $stmt->bind_param("ssssiisss", $name, $text, $file_path, $image_path, $user_id, $author, $link, $type_book, $time_insert);
        }

        if (!$stmt->execute()) {
            throw new Exception("Ошибка выполнения запроса: " . $stmt->error);
        }

        // Фиксируем изменения
        $conn->commit();
        echo "Новая запись успешно создана.";

    } catch (Exception $e) {
        // Откатываем изменения в случае ошибки
        $conn->rollback();
        echo "Ошибка: " . $e->getMessage();
    } finally {
        // Закрываем соединение с базой данных
        $stmt->close();
        $conn->close();
    }
}
?>
