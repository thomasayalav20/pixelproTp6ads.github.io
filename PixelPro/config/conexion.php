<?php
require_once __DIR__ . '/env.php';
function db(): PDO {
    static $pdo = null;
    if ($pdo instanceof PDO) return $pdo;
    $host = getenv('DB_HOST') ?: '127.0.0.1';
    $port = getenv('DB_PORT') ?: '3306';
    $name = getenv('DB_NAME') ?: 'pixelpro_db';
    $user = getenv('DB_USER') ?: 'root';
    $pass = getenv('DB_PASS') ?: '';
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$name;charset=utf8mb4",$user,$pass,[
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
    return $pdo;
}
// Compatibilidad con el TP7 anterior.
try { $pdo = db(); }
catch (PDOException $e) { http_response_code(503); die('No se pudo conectar a MySQL. Verificá XAMPP, config/.env e importá database/schema.sql.'); }
