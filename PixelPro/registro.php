<?php
require_once __DIR__.'/includes/funciones.php';require_once __DIR__.'/config/conexion.php';
$errores=[];$nombre='';$email='';
if($_SERVER['REQUEST_METHOD']==='POST'){
 validar_token();$nombre=trim((string)($_POST['nombre']??''));$email=trim((string)($_POST['email']??''));$pass=(string)($_POST['password']??'');
 if(mb_strlen($nombre)<2||mb_strlen($nombre)>150)$errores[]='Ingresá un nombre válido (2 a 150 caracteres).';
 if(!filter_var($email,FILTER_VALIDATE_EMAIL)||strlen($email)>150)$errores[]='Ingresá un correo válido.';
 if(strlen($pass)<8)$errores[]='Usá una contraseña de al menos 8 caracteres.';
 if(!isset($_POST['terminos']))$errores[]='Aceptá las condiciones para continuar.';
 if(!$errores){
  try{$role=$pdo->query("SELECT id_rol FROM roles WHERE nombre='usuario' LIMIT 1")->fetchColumn();if(!$role)throw new RuntimeException('Falta el rol usuario. Importá database/schema.sql.');
   $q=$pdo->prepare('INSERT INTO usuarios(nombre_completo,email,password,id_rol,acepto_terminos) VALUES(?,?,?,?,1)');$q->execute([$nombre,$email,password_hash($pass,PASSWORD_DEFAULT),$role]);
   ir('login.php?registro=ok');
  }catch(PDOException $x){if($x->getCode()==='23000')$errores[]='Ese correo ya está registrado.';else $errores[]='No se pudo registrar la cuenta. Verificá MySQL.';}
  catch(Throwable $x){$errores[]=$x->getMessage();}
 }
}
$titulo_pagina='Crear cuenta';include __DIR__.'/includes/header.php';?>
<section class="auth-layout reveal"><aside class="auth-promo"><span class="eyebrow">PIXELPRO ACCOUNT</span><h1>Tu aventura <span class="gradient-text">empieza acá.</span></h1><p>Una sola cuenta para tu perfil, novedades y acceso a nuestra comunidad.</p><img src="img/image 10.png" alt="PixelPro" loading="lazy"></aside><div class="form-panel"><span class="eyebrow">NUEVA CUENTA</span><h2>Crear una cuenta</h2><p>Completá los datos para registrarte en PixelPro.</p>
<?php if($errores):?><div class="alert alert-danger" role="alert"><?=e(implode(' · ',$errores))?></div><?php endif;?>
<form method="post" class="form-stack"><input type="hidden" name="csrf" value="<?=e(token())?>"><label>Nombre completo<input required maxlength="150" name="nombre" autocomplete="name" value="<?=e($nombre)?>"></label><label>Correo electrónico<input required type="email" maxlength="150" name="email" autocomplete="email" value="<?=e($email)?>"></label><label>Contraseña<input required minlength="8" type="password" name="password" autocomplete="new-password"><small>Mínimo 8 caracteres.</small></label><label class="checkbox-label"><input required type="checkbox" name="terminos" value="1"> Acepto las condiciones del sitio.</label><button class="btn btn-primary btn-block" type="submit">Crear cuenta ↗</button></form><p class="form-caption">¿Ya tenés cuenta? <a href="login.php">Iniciar sesión</a></p></div></section>
<?php include __DIR__.'/includes/footer.php';?>