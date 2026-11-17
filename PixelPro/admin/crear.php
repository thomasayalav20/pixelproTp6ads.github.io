<?php require_once __DIR__.'/verificar_admin.php';require_once __DIR__.'/../config/conexion.php';
$errores=[];$nombre='';$descripcion='';$id_categoria=0;$modo='crear';$categorias=$pdo->query('SELECT id_categoria,nombre FROM categorias_juego ORDER BY nombre')->fetchAll();
if($_SERVER['REQUEST_METHOD']==='POST'){validar_token();$nombre=trim((string)($_POST['nombre']??''));$descripcion=trim((string)($_POST['descripcion']??''));$id_categoria=(int)($_POST['id_categoria']??0);
if(mb_strlen($nombre)<2||mb_strlen($nombre)>120)$errores[]='El nombre debe tener entre 2 y 120 caracteres.';
if(!in_array($id_categoria,array_map(fn($c)=>(int)$c['id_categoria'],$categorias),true))$errores[]='Seleccioná una categoría válida.';
if(!$errores){$q=$pdo->prepare('INSERT INTO juegos(nombre,descripcion,id_categoria) VALUES(?,?,?)');$q->execute([$nombre,$descripcion,$id_categoria]);ir('index.php?status=created');}}
$titulo_pagina='Nuevo juego';require __DIR__.'/../includes/header.php';require __DIR__.'/_form.php';require __DIR__.'/../includes/footer.php';