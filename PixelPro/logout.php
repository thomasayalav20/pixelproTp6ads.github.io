<?php
require_once __DIR__.'/includes/funciones.php';iniciar_sesion();
if($_SERVER['REQUEST_METHOD']!=='POST'){http_response_code(405);exit('Método no permitido');}
validar_token();$_SESSION=[];if(ini_get('session.use_cookies')){$p=session_get_cookie_params();setcookie(session_name(),'',time()-3600,$p['path'],$p['domain'],$p['secure'],$p['httponly']);}
session_destroy();ir('login.php?salida=ok');