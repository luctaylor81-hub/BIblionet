<?php
// Lit le fichier .env (jamais versionné) et retourne la configuration.
$env = [];
$file = __DIR__ . '/../.env';
if (is_file($file)) {
    foreach (file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || $line[0] === '#' || !str_contains($line, '=')) {
            continue;
        }
        [$k, $v] = explode('=', $line, 2);
        $env[trim($k)] = trim(trim($v), "\"'");
    }
}

return [
    'env' => $env['APP_ENV'] ?? 'development',
    'url' => $env['APP_URL'] ?? '',
    'db'  => [
        'host' => $env['DB_HOST'] ?? 'localhost',
        'name' => $env['DB_NAME'] ?? 'biblionet',
        'user' => $env['DB_USER'] ?? 'root',
        'pass' => $env['DB_PASS'] ?? '',
    ],
];
