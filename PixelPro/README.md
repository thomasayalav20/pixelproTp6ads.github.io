# PIXELPRO — Portal gamer | Proyecto Integrador TP4 a TP8

Portal editorial de videojuegos y comunidad gamer, con identidad visual propia en azul petróleo, turquesa y naranja. Se tomó como base la entrega `tp6 - copia.zip`, conservando el nombre PixelPro y las imágenes originales, y se completaron los módulos de PHP, MySQL y seguridad.

> **Proyecto académico y demostrativo:** no procesa pagos reales. Las estadísticas históricas o precios editoriales del sitio no son datos en tiempo real.

## Requisitos

- XAMPP con PHP 8.1+ y MariaDB/MySQL.
- Extensión `pdo_mysql` habilitada.
- Navegador actualizado.

## Instalación (XAMPP)

1. Extraé la carpeta `PixelPro` dentro de `C:\xampp\htdocs\`, para que exista `C:\xampp\htdocs\PixelPro\index.php`.
2. Iniciá **Apache** y **MySQL** en XAMPP.
3. En phpMyAdmin, abrí SQL e importá **`database/schema.sql`** (crea `pixelpro_db` y las tablas).
4. Copiá `config/.env.example` como `config/.env`; ajustá usuario/contraseña MySQL si son distintos. Nunca subas `.env` a GitHub.
5. Abrí `http://localhost/PixelPro/` (o `http://localhost/PixelPro/index.php`).
6. Creá una cuenta desde `registro.php` y probá `login.php` / `panel.php`.
7. Para probar el **rol de administrador en una instalación local propia**, desde phpMyAdmin ejecutá el SQL mostrado más abajo, reemplazando el correo por el de tu cuenta.

### Crear tu administrador local

```sql
USE pixelpro_db;
UPDATE usuarios
SET id_rol = (SELECT id_rol FROM roles WHERE nombre = 'admin' LIMIT 1)
WHERE email = 'tu_correo@ejemplo.com';
```

Cerrá sesión y volvé a iniciar sesión para actualizar el rol almacenado en `$_SESSION`.

## TP4 — Migración HTML a PHP y modularización

- Páginas `.php` que reutilizan `includes/header.php` y `includes/footer.php`.
- Menú único, enlaces adaptados al subdirectorio donde se instale el proyecto.
- `config/env.php`, `config/.env.example`, variables de título de página y navegación activa.
- CSS y JavaScript separados (`todo.css`, `todo.js`).

**Capturas:** portada, navegación y estructura de `includes/`.

## TP5 — GET y POST

- **GET:** `noticias.php?q=...` filtra publicaciones disponibles mediante PDO y consulta preparada.
- **POST:** `contactos.php` valida nombre, email y mensaje; guarda en la tabla `mensajes_contacto` de MySQL.
- Escapado de salida con `htmlspecialchars` y control CSRF para el envío.

**Capturas:** búsqueda GET, formulario POST y registro guardado en phpMyAdmin.

## TP6 — Normalización y base de datos

- `database/schema.sql`: usuarios, roles, géneros, juegos, categorías, publicaciones, comentarios, idiomas, solicitudes y mensajes.
- Tablas normalizadas con PK, FK, `UNIQUE` y timestamps.
- `database/consultas.sql`: consultas orientativas.
- `database/normalizacion.md`: documentación del TP6 original.

**Capturas:** esquema de tablas, estructura de `usuarios`, consultas JOIN.

## TP7 — PDO y CRUD

- Conexión mediante `config/conexion.php` y PDO con consultas preparadas.
- Panel privado `admin/index.php` con búsqueda.
- **Create:** `admin/crear.php` (selección de categoría).
- **Read:** `admin/index.php`.
- **Update:** `admin/editar.php`.
- **Delete:** `admin/eliminar.php` exige POST + CSRF y confirma la operación.
- `admin/categorias.php`: alta y listado de categorías.

**Capturas:** listado, creación, edición, comprobación de eliminación y phpMyAdmin.

## TP8 — Autenticación y autorización

- `registro.php`: registro real en MySQL y `password_hash(PASSWORD_DEFAULT)`.
- `login.php`: verificación con `password_verify()`, `session_regenerate_id(true)` y sesión PHP.
- `includes/funciones.php`: `$_SESSION`, cookie `HttpOnly`, `SameSite=Lax` y `Secure` cuando se utiliza HTTPS.
- `includes/auth_guard.php`: verifica sesión para páginas protegidas.
- `admin/verificar_admin.php`: control de acceso por rol admin.
- `logout.php`: POST + CSRF, borrado de cookie y `session_destroy()`.
- `panel.php`: página protegida del usuario.

**Capturas:** formulario de registro, hash en MySQL (ocultá datos personales), login, panel, acceso denegado a admin con usuario común y logout.

## Estructura

```text
PixelPro/
├── index.php / blog.php / noticias.php / contactos.php
├── registro.php / login.php / logout.php / panel.php
├── todo.css / todo.js / img/
├── admin/                # CRUD y roles
├── includes/             # estructura y protección
├── config/               # conexión y archivo .env.example
└── database/             # schema.sql, consultas.sql, normalizacion.md
```

## Pruebas importantes

- Usuario sin sesión intentando abrir `panel.php` → redirige al login.
- Usuario con rol `usuario` intentando abrir `/admin/index.php` → acceso restringido.
- Administrador → crear, editar y eliminar un juego.
- Formulario de contacto → registro en `mensajes_contacto`.
- Los registros de cuentas tienen hash, nunca contraseñas en texto plano.

## GitHub y entrega

Subí el código fuente, la documentación y capturas reales. No subas `config/.env`, exportaciones con datos personales o archivos de sesión. Hacé commits que describan los avances verdaderos. Para un servidor público se requiere configurar HTTPS, credenciales seguras y revisar la seguridad del despliegue.

## Nota de compatibilidad

El proyecto original tenía una página `index.php` copiada por error desde `/admin`, un registro simulado y un borrado por enlace GET. Se reemplazaron por una portada, autenticación real y eliminación por POST protegida. El SQL está preparado para una instalación nueva; si ya existe `pixelpro_db` con otros datos, respaldala antes de importar.

## Identidad visual de PixelPro

La experiencia está inspirada en estándares modernos de navegación, accesibilidad y acabado profesional, **sin replicar la identidad de LunarMC**. El sitio adopta un diseño editorial de videojuegos, con tipografía Space Grotesk/DM Sans, paleta turquesa y ámbar, portada con imagen enmarcada y tarjetas de lectura. Se preservan los módulos funcionales de TP4–TP8.
