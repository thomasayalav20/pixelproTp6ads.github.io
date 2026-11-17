<?php
require_once __DIR__ . '/../config/env.php';
function e($s): string { return htmlspecialchars((string)$s,ENT_QUOTES|ENT_SUBSTITUTE,'UTF-8'); }
function iniciar_sesion(): void {
    if (session_status() === PHP_SESSION_ACTIVE) return;
    if (headers_sent()) throw new RuntimeException('La sesión debe iniciarse antes del HTML.');
    $secure = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
    session_set_cookie_params(['lifetime'=>0,'path'=>'/','secure'=>$secure,'httponly'=>true,'samesite'=>'Lax']);
    session_start();
}
function token(): string { iniciar_sesion(); if(empty($_SESSION['csrf'])) $_SESSION['csrf']=bin2hex(random_bytes(32));return $_SESSION['csrf']; }
function validar_token(): void { iniciar_sesion(); if(!hash_equals($_SESSION['csrf']??'',(string)($_POST['csrf']??''))){http_response_code(403);exit('Solicitud inválida. Actualizá la página e intentá nuevamente.');} }
function usuario(): ?array { iniciar_sesion(); return $_SESSION['usuario'] ?? null; }
function base_url(): string { return rtrim(str_replace('\\','/',dirname($_SERVER['SCRIPT_NAME'] ?? '/pixelpro/index.php')), '/'); }
function url_local(string $path=''): string { $script = str_replace('\\','/',$_SERVER['SCRIPT_NAME']??''); $base=preg_replace('~/(?:admin/[^/]+|admin|[^/]+\.php)$~','',$script);return rtrim($base,'/').'/'.ltrim($path,'/'); }
function requiere_login(): array { $u=usuario(); if(!$u){header('Location: '.url_local('login.php?error=acceso_denegado')); exit;}return $u; }
function requiere_admin(): array {
    $u=requiere_login();
    if(($u['rol']??'')!=='admin'){http_response_code(403);exit('Acceso restringido a administradores. <a href="../panel.php">Volver</a>');}
    return $u;
}
function ir($path): void {header('Location: '.$path);exit;}
