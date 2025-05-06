<?php
require_once('tcpdf/tcpdf.php');
session_start();

// Проверка наличия данных в сессии
if (!isset($_SESSION['last_check']) || empty($_SESSION['last_check'])) {
    echo "Ошибка: нет данных для генерации PDF. <br>";
    echo "<pre>";
    var_dump($_SESSION);
    echo "</pre>";
    exit;
}

// Данные проверки
$data = $_SESSION['last_check'];
$uniqueness = round($data['uniqueness'], 2) . '%';
$similarContent = $data['similarContent'] ?? [];

// Сортировка источников по убыванию процента плагиата
usort($similarContent, function ($a, $b) {
    return $b['similarity'] <=> $a['similarity'];
});

// Создание PDF
$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Система проверки');
$pdf->SetTitle('Отчет по проверке уникальности');
$pdf->SetMargins(10, 10, 10);
$pdf->SetAutoPageBreak(true, 10);
$pdf->AddPage();
$pdf->SetFont('dejavusans', '', 12);

// Заголовок
$pdf->Cell(0, 10, 'Отчет по проверке уникальности', 0, 1, 'C');
$pdf->Ln(5);
$pdf->Cell(0, 10, 'Уникальность: ' . $uniqueness, 0, 1);
$pdf->Ln(10);

// Список источников
$pdf->Cell(0, 10, 'Список источников:', 0, 1);
$pdf->Ln(5);

// Заголовки таблицы
$pdf->SetFont('dejavusans', '', 10);
$pdf->Cell(10, 8, '№', 1, 0, 'C');
$pdf->Cell(80, 8, 'Название источника', 1, 0, 'C');
$pdf->Cell(40, 8, 'Автор', 1, 0, 'C');
$pdf->Cell(40, 8, 'Дата проверки', 1, 0, 'C');
$pdf->Cell(20, 8, 'Плагиат', 1, 1, 'C');

// Вывод данных
foreach ($similarContent as $index => $content) {
    $pdf->Cell(10, 8, $index + 1, 1, 0, 'C');
    $pdf->Cell(80, 8, $content['name'], 1, 0, 'L');
    $pdf->Cell(40, 8, $content['author'] ?? 'Неизвестный', 1, 0, 'C');
    $pdf->Cell(40, 8, $content['date'] ?? 'Неизвестно', 1, 0, 'C');
    $pdf->Cell(20, 8, $content['similarity'] . '%', 1, 1, 'C');
}

// Сохранение PDF
$pdf->Output('otchet.pdf', 'I');
?>
