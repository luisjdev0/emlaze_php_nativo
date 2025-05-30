# Prueba Técnica - Desarrollador Fullstack (PHP nativo / MYSQL)

## Descripción del proyecto
Este proyecto es una prueba técnica la cual consiste en crear una aplicación web que permita gestionar un listado de productos y cuenta con un sistema de autenticación de usuario.

## Tecnologías utilizadas
- HTML
- Bootstrap
- JavaScript (puro y con JQuery)
- PHP 7.4 (Nativo con composer, vlucas/phpdotenv)
- MySQL (PDO)

## Instrucciones de despliegue.

1. Clonar el repositorio:
   ```bash
   git clone https://github.com/luisjdev0/emlaze_php_nativo.git
   ```
2. Instalar las dependencias de PHP:
   ```bash
    composer install
    ```
3. Crear un archivo `.env` en la raíz del proyecto y configurar las variables de entorno necesarias basado en el archivo `.env.example`:
   ```ini
   DB_HOST=localhost
   DB_NAME=nombre_de_tu_base_de_datos
   DB_USER=tu_usuario
   DB_PASSWORD=tu_contraseña
   ```
4. Crear la base de datos y las tablas necesarias ejecutando el script SQL proporcionado en `migration.sql`.

## Credenciales de acceso
- Usuario: `admin@test.com`
- Contraseña: `emlaze_native_password`