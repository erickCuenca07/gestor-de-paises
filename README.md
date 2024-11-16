Proyecto: CRUD de Países

Descripción

Este proyecto consiste en una aplicación que permite almacenar y actualizar información de países utilizando una API externa (REST Countries). Está desarrollado con Vue.js (usando Vuetify como framework de diseño) para el frontend, y Symfony para el backend.

Tecnologías Utilizadas

-Frontend: Vue.js, Vuetify
-Backend: Symfony >= 5.4
-Base de Datos: MySQL
-Gestión de Dependencias: Composer
-Migraciones: Doctrine (Symfony)

Requisitos Previos

Antes de clonar el repositorio, asegúrate de tener instalados:

-PHP 7.1 en adelante, recomendable 8
-Composer
-Node.js y npm
-MySQL
-Symfony CLI

Instalar dependencias de PHP:

composer install

Copiar y configurar el archivo .env:

cp .env .env.local

Edita .env.local para establecer los datos de conexión a la base de datos:

DATABASE_URL="mysql://root:@127.0.0.1:3306/auren"

Crear la base de datos:

php bin/console doctrine:database:create

Ejecutar las migraciones para crear la estructura de la base de datos:

php bin/console doctrine:migrations:migrate

Instalar dependencias de Node.js:

npm install

Compilar los activos:

npm run dev

Levantar el backend:

symfony server:start

Accede a la aplicación en tu navegador en http://localhost:8000.