<?php
// Carga simple de variables .env sin librerías externas.
$envFile = __DIR__ . '/.env';
if (is_file($envFile)) {
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if (!$line || $line[0] === '#' || !str_contains($line, '=')) continue;
        [$key, $value] = explode('=', $line, 2);
        $key = trim($key);
        if (!preg_match('/^[A-Z_][A-Z0-9_]*$/i', $key)) continue;
        $value = trim(trim($value), " \t\n\r\0\x0B\"'");
        if (getenv($key) === false) putenv($key . '=' . $value);
    }
}
if (!defined('APP_NAME')) define('APP_NAME', 'PixelPro');
if (!defined('APP_SUPPORT_EMAIL')) define('APP_SUPPORT_EMAIL', getenv('APP_SUPPORT_EMAIL') ?: 'soporte@pixelpro.local');
