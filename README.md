# Backend Shopping Cart Example

## Tecnologies

-   Laravel 5
-   Passport RESTful API

## Installation

-   `copy .env.local file informacion , after, create .env file in the main project and paste      the information`
-   `create database : partnersControl`
-   `update database credentials, lines 13 and 14 in .env`
-   `composer install`
-   `php artisan migrate`
    `php artisan key:generate`
    `php artisan passport:install`
-   `php artisan passport:client --personal`
-   `put any name for passport credentials`
-   `php artisan db:seed`
-   `php artisan serve`
