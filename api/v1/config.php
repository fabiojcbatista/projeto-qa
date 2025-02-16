<?php

// Função para carregar o .env
function loadEnv($file = '.env') {
    $filePath = __DIR__ . '/' . $file;
    if (!file_exists($filePath)) {
        throw new Exception(".env file not found at $filePath");
    }

    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        list($key, $value) = explode('=', $line, 2);
        putenv("$key=$value");
    }
}

// Carregar o arquivo .env
loadEnv();