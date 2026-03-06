# Funeraria San José

Proyecto Laravel (Jetstream) con portal público, panel admin y portal cliente.

---

## Después de clonar (instalación)

Quien clone el repositorio debe hacer lo siguiente:

### 1. Dependencias y configuración
```bash
composer install
cp .env.example .env
php artisan key:generate
npm install && npm run build
```

### 2. Base de datos
```bash
php artisan migrate
php artisan db:seed
```

### 3. Enlace de storage (fotos de perfil, etc.)
```bash
php artisan storage:link
```
Esto crea el enlace `public/storage` → `storage/app/public`. Sin esto, las fotos de perfil y archivos subidos no se verán (se guardan en `storage/app/public/profile-photos` pero la web no puede servirlas). En Windows, si falla por permisos, abre CMD o PowerShell **como Administrador** y ejecuta desde la raíz del proyecto:
```cmd
rmdir public\storage
mklink /D public\storage storage\app\public
```

### 4. Vídeos (opcional)
Los vídeos **no están en el repositorio** (superan el límite de GitHub). La carpeta `public/videos/` sí existe en el proyecto.

- Si quieres usar vídeos en el sitio, **coloca los archivos** (por ejemplo `Video.mp4`, `VIDEO2.mp4`) dentro de `public/videos/`.
- Si la carpeta no existiera, créala: `public/videos/` y luego pon ahí los `.mp4`.

No hace falta ejecutar nada más para los vídeos; solo que los archivos estén en esa ruta.

### 5. Verificación en dos pasos por correo (2FA)
La autenticación de dos factores por correo envía un código al email del usuario. Para que se envíen correos reales, configura en `.env` el mailer (por ejemplo SMTP). Si usas `MAIL_MAILER=log`, el correo se escribe en `storage/logs/laravel.log` y no se envía por email.

---

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
