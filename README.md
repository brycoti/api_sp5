# Configuración de Laravel Passport para Clientes de Acceso Personal

Este README te guiará a través de los pasos para configurar Laravel Passport y crear un cliente de acceso personal. Los clientes de acceso personal se utilizan para permitir que aplicaciones de confianza se autentiquen e interactúen con tu API en nombre de un usuario sin requerir el consentimiento explícito del usuario para cada solicitud.

## Pasos de Configuración

### Paso 1: Instalar Passport

Si aún no has instalado Passport en tu aplicación Laravel, puedes hacerlo utilizando Composer:

```bash
composer require laravel/passport 
Paso 2: Ejecutar Migraciones
A continuación, ejecuta las migraciones de la base de datos para crear las tablas necesarias para Passport:

bash
Copy code
php artisan migrate

Paso 2.5 Verify Role Package: If you are using a role package like Spatie's Laravel Permission, ensure that it is properly installed and configured in your Laravel project. You should have run the necessary migrations to create the required tables in your database.

    If you haven't already, run the migration to create the roles and permissions tables:

    

php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --tag="migrations"
php artisan migrate

Also, make sure you've registered the Spatie\Permission\PermissionServiceProvider in your config/app.php file.




Paso 3: Crear un Cliente de Acceso Personal

bash
Copy code
php artisan key:generate

Puedes crear un cliente de acceso personal utilizando el comando Artisan passport:client. Al ejecutar este comando, especifica la opción --personal para crear un cliente de acceso personal:

bash
Copy code
php artisan passport:client --personal

Este comando te pedirá que le des un nombre al cliente (por ejemplo, "Cliente de Acceso Personal"). También puedes dejar en blanco el campo "URI de redirección" para los clientes de acceso personal.

Paso 4: Obtener las Credenciales del Cliente
Después de ejecutar el comando anterior, recibirás las credenciales del cliente, que incluyen un ID de cliente y un secreto de cliente. Asegúrate de almacenar estas credenciales de manera segura, ya que se utilizarán para autenticar tu aplicación con la API.

php artisan passport:keys

Uso del Cliente de Acceso Personal
En tu código de aplicación, puedes utilizar estas credenciales del cliente para autenticar las solicitudes a la API mediante el uso de un Bearer Token. Para obtener el token, puedes iniciar sesión una vez que hayas creado el usuario. Luego, utiliza ese token en las solicitudes a la API en Postman u otras herramientas similares.
