<?php

include('db_connect.php');
include('utils.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Запуск сессии только если она не была запущена
}

$text = isset($_POST['text']) ? trim($_POST['text']) : '';
$uniqueness = null;
$similarContent = [];
$previousChecks = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($text)) {
        $error = "Ошибка: Поле 'Текст' обязательно для заполнения.";
    } else {
        try {
            $cleanedText = preprocessText($text);
            $conn = getDbConnection();
            $tables = ['books', 'articles', 'books_security'];

            // Проверка по книгам и статьям
            foreach ($tables as $table) {
                $sql = "SELECT name_book, text_book FROM $table";
                $result = $conn->query($sql);
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $contentText = preprocessText($row['text_book']);
                        $similarity = cosineSimilarity($cleanedText, $contentText);
                        if ($similarity > 0) {
                            $similarContent[] = [
                                'name' => !empty($row['name_book']) ? $row['name_book'] : 'Без названия',
                                'text' => highlightPlagiarism($row['text_book'], $text),
                                'similarity' => round($similarity * 100, 2)
                            ];
                        }
                    }
                }
            }

            // Проверка по text_checks (предыдущие проверки)
            $sql = "SELECT author, text, check_time FROM text_checks";
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $checkedText = preprocessText($row['text']);
                    $similarity = cosineSimilarity($cleanedText, $checkedText);
                    if ($similarity > 0) {
                        $previousChecks[] = [
                            'author' => $row['author'],
                            'text' => highlightPlagiarism($row['text'], $text),
                            'similarity' => round($similarity * 100, 2),
                            'date' => $row['check_time']
                        ];
                    }
                }
            }

            // Определение максимального совпадения
            $allMatches = array_merge($similarContent, $previousChecks);
            $maxSimilarity = !empty($allMatches) ? max(array_column($allMatches, 'similarity')) : 0;
            $uniqueness = round((1 - ($maxSimilarity / 100)) * 100, 2);

            // Сохранение результатов в сессию
            $_SESSION['last_check'] = [
                'uniqueness' => $uniqueness,
                'similarContent' => $similarContent,
                'previousChecks' => $previousChecks
            ];

            // Запись проверки в базу данных
            $stmt = $conn->prepare("INSERT INTO text_checks (author, text, check_time, checked_by) VALUES (?, ?, NOW(), ?)");
            $checkedBy = $_SESSION["username"] ?? 'Неизвестный';
            $stmt->bind_param("sss", $_POST['author'], $text, $checkedBy);
            $stmt->execute();
            $stmt->close();
            
        } catch (Exception $e) {
            $error = "Ошибка: " . $e->getMessage();
        }
    }
}
?>


<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Проверка текста на уникальность</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .hidden-text { display: none; background: #f1f1f1; padding: 10px; border-radius: 5px; }
        .plagiarism { background: #ffcccc; font-weight: bold; }
        .uniqueness-high { color: green; font-weight: bold; }
        .uniqueness-low { color: red; font-weight: bold; }
    </style>
</head>
<body>
<?php include ('header.inc.php');?>
<div class="container mt-5">
    <h1 class="text-center">Проверка текста на уникальность</h1>
    <form method="POST" class="mt-4">
        <div class="form-group">
            <label for="author">Автор:</label>
            <input type="text" class="form-control" id="author" name="author" required>
        </div>
        <div class="form-group">
            <label for="text">Текст для проверки:</label>
            <textarea class="form-control" id="text" name="text" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Проверить</button>
    </form>

    <?php if (isset($uniqueness)): ?>
        <div class="mt-4 alert alert-info">
            <h4>Результаты:</h4>
            <p><strong>Уникальность:</strong> 
                <span class="<?= ($uniqueness > 70) ? 'uniqueness-high' : 'uniqueness-low' ?>">
                    <?= round($uniqueness, 2) ?>%
                </span>
            </p>
        </div>
        <div class="text-center mt-4">
            <a href="download_pdf.php" class="btn btn-primary">Скачать отчет в PDF</a>
        </div>

        <!-- Совпадения с книгами и статьями -->
        <?php if (!empty($similarContent)): ?>
            <div class="mt-4">
                <h4>Совпадения с книгами и статьями:</h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Название</th>
                            <th>Совпадение (%)</th>
                            <th>Действие</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($similarContent as $index => $content): ?>
                            <tr>
                                <td><?= htmlspecialchars($content['name']) ?></td>
                                <td><?= $content['similarity'] ?>%</td>
                                <td><button class="btn btn-sm btn-secondary" onclick="toggleText(<?= $index ?>)">Показать текст</button></td>
                            </tr>
                            <tr id="text-<?= $index ?>" class="hidden-text">
                                <td colspan="3"><?= nl2br($content['text']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <!-- Совпадения с предыдущими проверками -->
        <?php if (!empty($previousChecks)): ?>
            <div class="mt-4">
                <h4>Совпадения с предыдущими проверками:</h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Автор</th>
                            <th>Дата проверки</th>
                            <th>Совпадение (%)</th>
                            <th>Проверено пользователем</th>
                            <th>Действие</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($previousChecks as $index => $content): ?>
                            <tr>
                                <td><?= htmlspecialchars($content['author']) ?></td>
                                <td><?= $content['time'] ?></td>
                                <td><?= $content['similarity'] ?>%</td>
                                <td><?= htmlspecialchars($_SESSION["username"] ?? 'Неизвестный') ?></td>
                                <td><button class="btn btn-sm btn-secondary" onclick="toggleText('prev-<?= $index ?>')">Показать текст</button></td>
                            </tr>
                            <tr id="text-prev-<?= $index ?>" class="hidden-text">
                                <td colspan="5"><?= nl2br($content['text']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<script>
    function toggleText(index) {
        let el = document.getElementById('text-' + index);
        el.style.display = (el.style.display === 'none' || el.style.display === '') ? 'table-row' : 'none';
    }
</script>
<footer class="footer">
        <?php include("footer.inc.php"); ?>
    </footer>

</body>
</html>
