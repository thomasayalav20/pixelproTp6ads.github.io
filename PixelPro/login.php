<?php
require_once __DIR__.'/includes/funciones.php';require_once __DIR__.'/config/conexion.php';
$error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
 validar_token();$email=trim((string)($_POST['email']??''));$password=(string)($_POST['password']??'');
 $q=$pdo->prepare('SELECT u.id_usuario,u.nombre_completo,u.email,u.password,r.nombre AS rol FROM usuarios u JOIN roles r ON r.id_rol=u.id_rol WHERE u.email=? LIMIT 1');$q->execute([$email]);$u=$q->fetch();
 if(!$u||!password_verify($password,$u['password']))$error='Credenciales incorrectas.';
 else {iniciar_sesion();session_regenerate_id(true);$_SESSION['usuario']=['id'=>(int)$u['id_usuario'],'nombre'=>$u['nombre_completo'],'email'=>$u['email'],'rol'=>$u['rol']];ir('panel.php');}
}
$titulo_pagina='Iniciar sesión';include __DIR__.'/includes/header.php';?>
<section class="auth-layout reveal"><aside class="auth-promo"><span class="eyebrow">BIENVENIDO DE NUEVO</span><h1>Volvé al <span class="gradient-text">juego.</span></h1><p>Ingresá a tu cuenta para gestionar tu perfil y acceder a las novedades.</p><img src="img/image 3.png" alt="Escena gaming" loading="lazy"></aside><div class="form-panel"><span class="eyebrow">ACCESO A PIXELPRO</span><h2>Iniciar sesión</h2><p>Usá el correo y la contraseña de tu cuenta.</p>
<?php if(isset($_GET['registro'])):?><div class="alert alert-success">Cuenta creada. Ya podés iniciar sesión.</div><?php endif; ?>
<?php if(isset($_GET['error'])):?><div class="alert alert-danger">Iniciá sesión para acceder.</div><?php endif; ?>
<?php if($error):?><div class="alert alert-danger" role="alert"><?=e($error)?></div><?php endif;?>
<form method="post" class="form-stack"><input type="hidden" name="csrf" value="<?=e(token())?>"><label>Correo electrónico<input required type="email" name="email" autocomplete="email"></label><label>Contraseña<input required type="password" name="password" autocomplete="current-password"></label><button class="btn btn-primary btn-block" type="submit">Entrar a mi cuenta ↗</button></form><p class="form-caption">¿Todavía no tenés cuenta? <a href="registro.php">Registrate</a></p></div></section><?php include __DIR__.'/includes/footer.php';?>