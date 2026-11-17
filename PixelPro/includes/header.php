<?php
require_once __DIR__ . '/funciones.php';
iniciar_sesion();
$titulo_pagina=$titulo_pagina ?? 'PixelPro — Comunidad gamer';
$active=basename($_SERVER['SCRIPT_NAME']??'');
$menu=[['index.php','Inicio'],['noticias.php','Noticias'],['blog.php','Blog'],['ranking.php','Ranking'],['precios.php','Precios'],['preguntas.php','Ayuda']];
?>
<!doctype html><html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="PixelPro: videojuegos, noticias y actualidad y cultura gamer.">
<title><?=e($titulo_pagina)?> | PixelPro</title>
<link rel="stylesheet" href="<?=e(url_local('todo.css'))?>?v=pixelpro2">
<script src="<?=e(url_local('todo.js'))?>?v=pixelpro2" defer></script></head>
<body>
<div class="site-stars" aria-hidden="true"></div>
<header class="site-header"><div class="nav-wrap">
<a href="<?=e(url_local('index.php'))?>" class="brand"><span class="brand-mark">P.</span><span>PIXEL<span class="brand-accent">PRO</span><small>CULTURA DIGITAL</small></span></a>
<button type="button" class="menu-toggle" aria-expanded="false" aria-controls="primary-nav">☰ <span>Menú</span></button>
<nav class="primary-nav" id="primary-nav" aria-label="Navegación principal">
<?php foreach($menu as [$route,$label]):?><a class="<?= $active===$route?'active':'' ?>" href="<?=e(url_local($route))?>"><?=e($label)?></a><?php endforeach; ?>
<div class="nav-dropdown"><button class="nav-more" type="button" aria-expanded="false">Explorar ▾</button><div class="nav-dropdown-content">
<?php foreach([['curso.php','Cursos'],['generos.php','Géneros'],['opiniones.php','Reseñas'],['contactos.php','Contacto'],['deseas unirte.php','Unite al equipo']] as [$route,$label]):?><a href="<?=e(url_local($route))?>"><?=e($label)?></a><?php endforeach;?></div></div>
</nav>
<div class="user-actions"><?php if(usuario()):?><a class="btn btn-quiet" href="<?=e(url_local('panel.php'))?>">Mi cuenta</a><?php if(usuario()['rol']==='admin'):?><a class="btn btn-outline" href="<?=e(url_local('admin/index.php'))?>">Admin</a><?php endif; ?><?php else: ?><a class="btn btn-quiet" href="<?=e(url_local('login.php'))?>">Ingresar</a><a class="btn btn-primary" href="<?=e(url_local('registro.php'))?>">Registrarme</a><?php endif;?></div>
</div></header>
<main id="main-content" class="page-shell">
