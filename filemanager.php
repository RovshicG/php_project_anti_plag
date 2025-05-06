<?php
include('check_users.inc.php');
include('db_connect.php');

// Получаем соединение с базой данных
$conn = getDbConnection();

// Проверка на успешность подключения
if (!$conn) {
    die('Не удалось подключиться к базе данных');
}

// Получаем поисковой запрос и сортировку
$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';
$searchQuery = mysqli_real_escape_string($conn, $searchQuery); // Защита от SQL-инъекций
$sortBy = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'name_book'; // По умолчанию сортировка по имени
$order = isset($_GET['order']) && $_GET['order'] === 'desc' ? 'DESC' : 'ASC'; // По умолчанию сортировка по возрастанию

// Разрешенные значения для сортировки
$allowedSortBy = ['name_book', 'time_insert', 'type_book'];

// Если передано некорректное значение для сортировки, то используем значение по умолчанию
if (!in_array($sortBy, $allowedSortBy)) {
    $sortBy = 'name_book';
}

// Определяем пагинацию
$itemsPerPage = 20;  // Количество элементов на одной странице
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;  // Текущая страница (по умолчанию первая)
$offset = ($page - 1) * $itemsPerPage;  // Смещение для LIMIT

// Формируем запрос для поиска с учётом сортировки и пагинации
$sql = "
    SELECT 'books' AS type, name_book, file_name, img_book AS img_book, text_book AS content, user_id AS author, link, type_book, time_insert 
    FROM books
    WHERE name_book LIKE ? OR text_book LIKE ?
    UNION
    SELECT 'books_security' AS type, name_book, file_name, img_book AS img_book, text_book AS content, user_id AS author, link, type_book, time_insert 
    FROM books_security
    WHERE name_book LIKE ? OR text_book LIKE ?
    UNION
    SELECT 'articles' AS type, name_book, file_name, img_book AS img_book, text_book AS content, user_id AS author, link, type_book, time_insert 
    FROM articles
    WHERE name_book LIKE ? OR text_book LIKE ?
    ORDER BY $sortBy $order
    LIMIT $offset, $itemsPerPage";

// Подготавливаем запрос
$stmt = $conn->prepare($sql);

// Проверка на успешную подготовку запроса
if ($stmt === false) {
    die('Ошибка подготовки запроса: ' . $conn->error); // Выводим ошибку, если подготовка запроса не удалась
}

// Привязываем параметры
$likeQuery = "%" . $searchQuery . "%";
$stmt->bind_param("ssssss", $likeQuery, $likeQuery, $likeQuery, $likeQuery, $likeQuery, $likeQuery);
$stmt->execute();
$result = $stmt->get_result();

// Получаем общее количество записей для пагинации
$sqlCount = "
    SELECT COUNT(*) AS total 
    FROM (
        SELECT 1 FROM books WHERE name_book LIKE ? OR text_book LIKE ?
        UNION
        SELECT 1 FROM books_security WHERE name_book LIKE ? OR text_book LIKE ?
        UNION
        SELECT 1 FROM articles WHERE name_book LIKE ? OR text_book LIKE ?
    ) AS total_count";
$stmtCount = $conn->prepare($sqlCount);
$stmtCount->bind_param("ssssss", $likeQuery, $likeQuery, $likeQuery, $likeQuery, $likeQuery, $likeQuery);
$stmtCount->execute();
$countResult = $stmtCount->get_result();
$totalRows = $countResult->fetch_assoc()['total'];
$totalPages = ceil($totalRows / $itemsPerPage);  // Количество страниц
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список документов</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        footer {
            background-color: #343a40;
            color: white;
            padding: 10px;
            text-align: center;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
        
        .search-container {
            text-align: center;
            margin: 20px;
        }
        .search-container input {
            padding: 12px;
            width: 50%;
            border-radius: 25px;
            border: 1px solid #ddd;
        }
        .search-container button {
            padding: 12px 25px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 25px;
            cursor: pointer;
        }
        .document-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px;
        }
        .document-card {
            background: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .document-card img {
    width: 150px; /* Фиксированная ширина */
    height: 150px; /* Фиксированная высота */
    object-fit: cover; /* Обрезает изображение, чтобы заполнить квадрат */
    border-radius: 8px;
    display: block;
    margin: 0 auto;
}
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <?php include('header.inc.php'); ?>

    <div class="search-container">
        <form method="get" action="">
            <input type="text" name="search" placeholder="Поиск по тексту" value="<?php echo htmlspecialchars($searchQuery); ?>" />
            <button type="submit">Искать</button>
        </form>
    </div>

    <div class="sort-container">
        <form method="get" action="">
            <select name="sort_by">
                <option value="name_book" <?php if ($sortBy == 'name_book') echo 'selected'; ?>>По имени</option>
                <option value="time_insert" <?php if ($sortBy == 'time_insert') echo 'selected'; ?>>По дате</option>
                <option value="type_book" <?php if ($sortBy == 'type_book') echo 'selected'; ?>>По типу</option>
            </select>
            <select name="order">
                <option value="asc" <?php if ($order == 'ASC') echo 'selected'; ?>>По возрастанию</option>
                <option value="desc" <?php if ($order == 'DESC') echo 'selected'; ?>>По убыванию</option>
            </select>
            <button type="submit">Сортировать</button>
        </form>
    </div>

    <div class="document-container">
        <?php
        if (isset($result) && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="document-card">';
                echo '<h5>' . htmlspecialchars($row["name_book"]) . '</h5>';
                if (!empty($row["img_book"])) {
                    echo '<img src="' . htmlspecialchars($row["img_book"]) . '" class="img-fluid" alt="Image">';
                }
                echo '<p><strong>Тип:</strong> ' . htmlspecialchars($row["type_book"]) . '</p>';
                echo '<p><strong>Автор (ID):</strong> ' . htmlspecialchars($row["author"]) . '</p>';
                echo '<p><strong>Описание:</strong> ' . substr(htmlspecialchars($row["content"]), 0, 200) . '...</p>';
                if (!empty($row["file_name"])) {
                    echo '<p><a href="' . htmlspecialchars($row["file_name"]) . '" class="btn btn-primary" target="_blank">Скачать файл</a></p>';
                }
                if (!empty($row["link"])) {
                    echo '<p><a href="' . htmlspecialchars($row["link"]) . '" class="btn btn-secondary" target="_blank">Ссылка</a></p>';
                }
                echo '<p><strong>Добавлено:</strong> ' . htmlspecialchars($row["time_insert"]) . '</p>';
                echo '</div>';
            }
        } else {
            echo "<p style='text-align: center;'>Нет документов, соответствующих запросу.</p>";
        }
        ?>
    </div>

    <!-- Пагинация -->
    <div class="pagination">
        <?php
        if ($totalPages > 1) {
            echo '<nav><ul class="pagination">';
            for ($i = 1; $i <= $totalPages; $i++) {
                echo '<li class="page-item' . ($i == $page ? ' active' : '') . '">';
                echo '<a class="page-link" href="?search=' . urlencode($searchQuery) . '&sort_by=' . urlencode($sortBy) . '&order=' . urlencode($order) . '&page=' . $i . '">' . $i . '</a>';
                echo '</li>';
            }
            echo '</ul></nav>';
        }
        ?>
    </div>

    <footer>
        <?php include("footer.inc.php"); ?>
    </footer>
</body>
</html>

<?php
$conn->close();
?>
