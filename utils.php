<?php
function preprocessText($text) {
    if (detectScript($text) === 'cyrillic') {
        $text = uzTransliterate($text); // Конвертация узбекского текста из кириллицы в латиницу
    }
    $pattern = '/[^a-zA-Z0-9\s]/u';
    $cleanedText = preg_replace($pattern, '', $text);
    return mb_strtolower(trim($cleanedText));
}

function detectScript($text) {
    if (preg_match('/[\p{Cyrillic}]/u', $text)) {
        return 'cyrillic';
    }
    return 'latin';
}

function uzTransliterate($text) {
    $map = [
        'А' => 'A', 'а' => 'a', 'Б' => 'B', 'б' => 'b', 'В' => 'V', 'в' => 'v', 'Г' => 'G', 'г' => 'g',
        'Ғ' => "G'", 'ғ' => "g'", 'Д' => 'D', 'д' => 'd', 'Е' => 'E', 'е' => 'e', 'Ё' => 'Yo', 'ё' => 'yo',
        'Ж' => 'J', 'ж' => 'j', 'З' => 'Z', 'з' => 'z', 'И' => 'I', 'и' => 'i', 'Й' => 'Y', 'й' => 'y',
        'К' => 'K', 'к' => 'k', 'Қ' => 'Q', 'қ' => 'q', 'Л' => 'L', 'л' => 'l', 'М' => 'M', 'м' => 'm',
        'Н' => 'N', 'н' => 'n', 'О' => 'O', 'о' => 'o', 'П' => 'P', 'п' => 'p', 'Р' => 'R', 'р' => 'r',
        'С' => 'S', 'с' => 's', 'Т' => 'T', 'т' => 't', 'У' => 'U', 'у' => 'u', 'Ў' => "O'", 'ў' => "o'",
        'Ф' => 'F', 'ф' => 'f', 'Х' => 'X', 'х' => 'x', 'Ҳ' => 'H', 'ҳ' => 'h', 'Ц' => 'Ts', 'ц' => 'ts',
        'Ч' => 'Ch', 'ч' => 'ch', 'Ш' => 'Sh', 'ш' => 'sh', 'Щ' => 'Sh', 'щ' => 'sh', 'Ъ' => '', 'ъ' => '',
        'Ы' => 'I', 'ы' => 'i', 'Ь' => '', 'ь' => '', 'Э' => 'E', 'э' => 'e', 'Ю' => 'Yu', 'ю' => 'yu',
        'Я' => 'Ya', 'я' => 'ya'
    ];
    return strtr($text, $map);
}

function createNgrams($text, $n = 3) {
    $words = explode(' ', $text);
    $ngrams = [];
    for ($i = 0; $i <= count($words) - $n; $i++) {
        $ngrams[] = implode(' ', array_slice($words, $i, $n));
    }
    return $ngrams;
}

function cosineSimilarity($text1, $text2) {
    $ngrams1 = createNgrams($text1);
    $ngrams2 = createNgrams($text2);
    $allNgrams = array_unique(array_merge($ngrams1, $ngrams2));

    $vector1 = array_fill(0, count($allNgrams), 0);
    $vector2 = array_fill(0, count($allNgrams), 0);

    foreach ($ngrams1 as $ngram) {
        $index = array_search($ngram, $allNgrams);
        $vector1[$index]++;
    }

    foreach ($ngrams2 as $ngram) {
        $index = array_search($ngram, $allNgrams);
        $vector2[$index]++;
    }

    $dotProduct = 0;
    $magnitude1 = 0;
    $magnitude2 = 0;

    for ($i = 0; $i < count($vector1); $i++) {
        $dotProduct += $vector1[$i] * $vector2[$i];
        $magnitude1 += $vector1[$i] ** 2;
        $magnitude2 += $vector2[$i] ** 2;
    }

    $magnitude1 = sqrt($magnitude1);
    $magnitude2 = sqrt($magnitude2);

    return ($magnitude1 * $magnitude2 == 0) ? 0 : $dotProduct / ($magnitude1 * $magnitude2);
}

function highlightPlagiarism($originalText, $inputText) {
    $originalText = preprocessText($originalText);
    $inputText = preprocessText($inputText);

    $ngrams = createNgrams($inputText);
    foreach ($ngrams as $ngram) {
        $pattern = '/' . preg_quote($ngram, '/') . '/iu';
        $originalText = preg_replace($pattern, "<span class='plagiarism'>$0</span>", $originalText);
    }
    return $originalText;
}
?>
