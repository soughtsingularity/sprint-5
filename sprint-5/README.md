## Descripción

En aquesta pràctica aprendràs a crear una API REST completa amb control d'accés configurat mitjançant tokens.

La idea aquí és que agafis el projecte que vas realitzar a l’Sprint 4 i el converteixis d’una arquitectura MVC a una API REST. Has de tenir en compte, però, que els endpoints els hauràs de dissenyar tu mateix/a i que serà condició indispensable obtenir-ne l’aprovació prèvia abans de desenvolupar el teu projecte.

A més, has de tenir en compte que el projecte ha de complir els següents requisits:

Com a mínim 2 recursos mantenibles.
Gestió d’usuaris amb autenticació mitjançant la llibreria Passport.
Almenys 2 rols diferenciats.
Lògica de càlcul més complexa que un simple CRUD.

✔️ Nivel 1

Recorda que, abans de picar una sola línia de codi font productiu (els experiments que facis abans per entendre les diferents eines no compten), has d’entendre què has de fer. En aquest sentit, les preguntes clau per començar podrien ser:

Quina informació vull registrar?
Què pot fer cada tipus d’usuari?
Quins són els endpoints que faré servir perquè els usuaris hi accedeixin?


Afegeix seguretat

Inclou autenticació amb Passport en tots els accessos a les URL de l’API.
Defineix un sistema de rols i restringeix l'accés a les diferents rutes segons el nivell de privilegis.


Testing

Crea els tests funcionals de l'aplicació. Et recomanem aplicar TDD per provar cadascuna de les rutes. Escriure els tests abans del codi t’ajudarà a aclarir què ha de fer la teva aplicació.


✔️ Nivel 2

Crea la documentació de la teva API per a explicar als clients/es front-end com haurien de consumir l'API.


✔️ Nivel 3

Fes un deploy de la teva API. Pots fer-ho al servidor que vulguis o fent servir Laravel Forge.


### 🔑 Requisitos 

- PHP 7.4+ 
- Laravel Framework 11.43.1
- Base de datos de preferencia
- Composer (Para gestionar dependencias de PHP instaladas en el proyecto). 
- Passport
- Spatie
- Swagger

Dependecias instaladas: 
- darkaonline/l5-swagger    9.0.1   OpenApi or Swagger integration to Laravel
- fakerphp/faker            1.24.1  Faker is a PHP library that generates fake - - data for you.
- laravel/framework         12.3.0  The Laravel Framework.
- laravel/pail              1.2.2   Easily delve into your Laravel application'slog files directly from the command line.
- laravel/passport          12.4.2  Laravel Passport provides OAuth2 server - - - support to Laravel.
- laravel/pint              1.21.2  An opinionated code formatter for PHP.
- laravel/sail              1.41.0  Docker files for running a basic Laravel - application.
- laravel/tinker            2.10.1  Powerful REPL for the Laravel framework.
- mockery/mockery           1.6.12  Mockery is a simple yet flexible PHP mock object framework
- nunomaduro/collision      8.7.0   Cli error handling for console/command-line PHP applications.
- phpunit/phpunit           11.5.13 The PHP Unit Testing framework.
- spatie/laravel-permission 6.16.0  Permission handling for Laravel 8.0 and up

☕ Instalación

Clona este repositorio en tu máquina local. git clone https://github.com/soughtsingularity/sprint-5.git

- Accede a la carpeta del proyecto. cd nombre_del_repositorio

- Instala dependencias de composer: composer install

- Crea el archivo .env a partir de example.env cp .example.env .env 

IMPORTANTE: eN ALGUNOS ENTORNOS ES NECESARIO CAMBIAR LA VARIABLE DE ENTORNO APP_MAINTENANCE_DRIVER a file

- Genera las llaves secretas php artisan key:generate
- Instala passport, spatie y swagger

```
composer require laravel/passport
php artisan migrate
php artisan passport:install

```
```
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan migrate
```
```
composer require "darkaonline/l5-swagger"
php artisan vendor:publish --provider="L5Swagger\L5SwaggerServiceProvider"
```
Una vez instalado passport debes incluir las claves de cliente y passeord que se te darán en el archivo .env

```
PASSPORT_PERSONAL_ACCESS_CLIENT_ID=1
PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET=secret

PASSPORT_PASSWORD_GRANT_CLIENT_ID=2
PASSPORT_PASSWORD_GRANT_CLIENT_SECRET=secret
```
php artisan migrate

(Debes crear una base de datos en Mysql / Mariadb llamada 'kognos' o modificar el archivo .env del proyecto para que la aplicación se comunique correctamente con tu base de datos)

Puebla la base de datos mediante los seeders implementados en la aplicación:

php artisan db:seed. DataBaseSeeder contiene

- Usuarios para poder hacer las pruebas (user y admin)
- El seed de spatie para roles y permisos en la aplicación
- La creación de dos cliente de passport

La aplicación está pensada para que, en el entorno de testing, los datos creados en el test no persistan en memoria, y al mismo tiempo, para que nuestra base de datos siempre tenga las tablas necesarias para gestionar usuarios, cursos, su relación, roles y permisos de spatie y secretos de Passport

Recuerda, en la raíz del proyecto, ejecutar el comando composer install para que los paquetes utilizados en el proyecto, y listandos en el archivo composer.json, sean instalados.

⏩ Ejecución

Ejecuta php artisan servey accede, por defecto, a 127.0.0.1:8000