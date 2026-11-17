<?php require_once __DIR__.'/verificar_admin.php';require_once __DIR__.'/../config/conexion.php';
$id=filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);if(!$id)ir('index.php');$q=$pdo->prepare('SELECT * FROM juegos WHERE id_juego=?');$q->execute([$id]);$j=$q->fetch();if(!$j){http_response_code(404);exit('Juego no encontrado.');}
$errores=[];$nombre=$j['nombre'];$descripcion=$j['descripcion']??'';$id_categoria=(int)$j['id_categoria'];$modo='editar';$categorias=$pdo->query('SELECT id_categoria,nombre FROM categorias_juego ORDER BY nombre')->fetchAll();
if($_SERVER['REQUEST_METHOD']==='POST'){validar_token();$nombre=trim((string)($_POST['nombre']??''));$descripcion=trim((string)($_POST['descripcion']??''));$id_categoria=(int)($_POST['id_categoria']??0);
if(mb_strlen($nombre)<2||mb_strlen($nombre)>120)$errores[]='El nombre debe tener entre 2 y 120 caracteres.';
if(!in_array($id_categoria,array_map(fn($c)=>(int)$c['id_categoria'],$categorias),true))$errores[]='Seleccioná una categoría válida.';
if(!$errores){$q=$pdo->prepare('UPDATE juegos SET nombre=?,descripcion=?,id_categoria=? WHERE id_juego=?');$q->execute([$nombre,$descripcion,$id_categoria,$id]);ir('index.php?status=updated');}}
$titulo_pagina='Editar juego';require __DIR__.'/../includes/header.php';require __DIR__.'/_form.php';require __DIR__.'/../includes/footer.php';