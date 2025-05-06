<?php
include('check_users.inc.php');
include('db_connect.php');

// Подключение к базе данных
$conn = getDbConnection();

// Переменные для сообщений
$message = '';
$error = '';
$adminPassword = 'admin123';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit'])) {
    $id = intval($_POST['id']);
    $type = $_POST['type'];
    $newName = htmlspecialchars(trim($_POST['name']));
    $newContent = htmlspecialchars(trim($_POST['content']));
    $adminPass = $_POST['admin_password'];
    $newImg = '';

    // Проверка пароля администратора
    if ($adminPass !== $adminPassword) {
        $error = "Неверный пароль администратора!";
    } else {
        // Обработка загрузки изображения
        if (isset($_FILES['img_book']) && $_FILES['img_book']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/images/';
            $imgPath = $uploadDir . basename($_FILES['img_book']['name']);
            if (move_uploaded_file($_FILES['img_book']['tmp_name'], $imgPath)) {
                $newImg = $imgPath;
            } else {
                $error = "Ошибка загрузки изображения!";
            }
        }

        // Выбор SQL-запроса в зависимости от типа
        $sql = '';
        if ($type === 'books') {
            $sql = $newImg ? "UPDATE books SET name_book = ?, text_book = ?, img_book = ? WHERE id = ?" : "UPDATE books SET name_book = ?, text_book = ? WHERE id = ?";
        } elseif ($type === 'books_d') {
            $sql = $newImg ? "UPDATE books_d SET name_book = ?, text_book = ?, img_book = ? WHERE id = ?" : "UPDATE books_d SET name_book = ?, text_book = ? WHERE id = ?";
        } elseif ($type === 'articles') {
            $sql = $newImg ? "UPDATE articles SET title = ?, text_article = ?, img_book = ? WHERE id = ?" : "UPDATE articles SET title = ?, text_article = ? WHERE id = ?";
        } else {
            $error = "Неверный тип данных!";
        }

        // Выполнение SQL-запроса
        if (!empty($sql) && empty($error)) {
            $stmt = $conn->prepare($sql);

            // Проверка на ошибку при подготовке запроса
            if (!$stmt) {
                $error = "Ошибка подготовки запроса: " . $conn->error;
            } else {
                if ($newImg) {
                    $stmt->bind_param("sssi", $newName, $newContent, $newImg, $id);
                } else {
                    $stmt->bind_param("ssi", $newName, $newContent, $id);
                }

                if ($stmt->execute()) {
                    $message = "Данные успешно обновлены для документа ID: $id";
                } else {
                    $error = "Ошибка при обновлении данных: " . $stmt->error;
                }
                $stmt->close();
            }
        }
    }
}

// Поиск документов
$searchQuery = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';
$sql = "SELECT 'books' AS type, id, name_book, text_book AS content, img_book FROM books
        WHERE name_book LIKE ? OR text_book LIKE ?
        UNION
        SELECT 'books_d' AS type, id, name_book, text_book AS content, img_book FROM books_d
        WHERE name_book LIKE ? OR text_book LIKE ?
        UNION
        SELECT 'articles' AS type, id, title AS name_book, text_article AS content, img_book FROM articles
        WHERE title LIKE ? OR text_article LIKE ?";

$stmt = $conn->prepare($sql);

// Проверка на ошибку при подготовке запроса
if (!$stmt) {
    die("Ошибка подготовки запроса: " . $conn->error);
}

$likeQuery = "%$searchQuery%";
$stmt->bind_param("ssssss", $likeQuery, $likeQuery, $likeQuery, $likeQuery, $likeQuery, $likeQuery);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактирование документов</title>
    <link rel="stylesheet" href="bootstrap-4.0.0-dist/css/bootstrap.min.css">
    <script src="bootstrap-4.0.0-dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php include('header.inc.php'); ?>

    <div class="container my-4">
        <h1 class="text-center">Редактирование документов</h1>

        <?php if ($message): ?>
            <div class="alert alert-success" role="alert">
                <?= $message; ?>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert alert-danger" role="alert">
                <?= $error; ?>
            </div>
        <?php endif; ?>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Тип</th>
                    <th>Действие</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id']; ?></td>
                            <td><?= htmlspecialchars($row['name_book']); ?></td>
                            <td><?= $row['type']; ?></td>
                            <td>
                                <a href="?edit=<?= $row['id']; ?>&type=<?= $row['type']; ?>" class="btn btn-primary btn-sm">Редактировать</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">Документы не найдены.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <?php if (isset($_GET['edit']) && isset($_GET['type'])): 
            $id = intval($_GET['edit']);
            $type = $_GET['type'];

            // Запрос на получение данных для редактирования
            if ($type === 'books') {
                $sql = "SELECT name_book, text_book AS content, img_book FROM books WHERE id = ?";
            } elseif ($type === 'books_d') {
                $sql = "SELECT name_book, text_book AS content, img_book FROM books_d WHERE id = ?";
            } elseif ($type === 'articles') {
                $sql = "SELECT title AS name_book, text_article AS content, img_book FROM articles WHERE id = ?";
            }

            $stmt = $conn->prepare($sql);

            // Проверка на ошибку при подготовке запроса
            if (!$stmt) {
                die("Ошибка подготовки запроса: " . $conn->error);
            }

            $stmt->bind_param("i", $id);
            $stmt->execute();
            $editResult = $stmt->get_result();
            $editData = $editResult->fetch_assoc();
            $stmt->close();
        ?>
            <div class="card my-4">
                <div class="card-header">Редактировать документ</div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?= $id; ?>">
                        <input type="hidden" name="type" value="<?= $type; ?>">

                        <div class="form-group">
                            <label>Название</label>
                            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($editData['name_book']); ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Содержимое</label>
                            <textarea name="content" class="form-control" rows="6" required><?= htmlspecialchars($editData['content']); ?></textarea>
                        </div>

                        <div class="form-group">
                            <label>Изображение</label>
                            <input type="file" name="img_book" class="form-control-file">
                        </div>

                        <div class="form-group">
                            <label>Пароль администратора</label>
                            <input type="password" name="admin_password" class="form-control" required>
                        </div>

                        <button type="submit" name="edit" class="btn btn-success">Сохранить</button>
                    </form>
                </div>
            </div>
        <?php endif; ?>

    </div>
</body>
</html>
