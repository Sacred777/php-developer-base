<?php

$searchRoot = '.';
//$searchRoot = './test_search';
$searchName = 'test.txt';
$searchResult = [];

function searchFile(string $searchingDir, string $searchName, array &$searchResult): void
{
    $scannedFiles = scandir($searchingDir);
    foreach ($scannedFiles as $scannedFile) {
        if ($scannedFile === '.' || $scannedFile === '..') {
            continue;
        }

        $pathFile = $searchingDir . '/' . $scannedFile;

        if (is_dir($pathFile)) {
           searchFile($pathFile, $searchName, $searchResult);
        } else {
            if ($scannedFile === $searchName) {
                $searchResult[] = $pathFile;
            }
        }
    }
}

searchFile($searchRoot, $searchName,$searchResult);

$filteredResult = array_filter($searchResult, fn ($el) => filesize($el) !== 0 );

if (count($filteredResult) === 0) {
    echo "Поиск файла $searchName не дал результатов";
} else {
    var_dump($filteredResult);
}
