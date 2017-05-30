# Play Or Go API

## Clone source and install
```sh
$ git clone https://bss-toanle@bitbucket.org/beesightsoft/marco.play-or-go.service-api.git <app-folder>
$ cd <app-folder>
$ composer install
```

## Setup environment variables

Clone from .env.example to .env and update
Update configuration of database in `.env` by clone from `.env.example`

## Edit swagger UI
```shell
/vendor/latrell/swagger/public/index.html
/vendor/latrell/swagger/src/views/index.blade.php
var apiKeyAuth = new SwaggerClient.ApiKeyAuthorization("Authorization", key, "header");
window.swaggerUi.api.clientAuthorizations.add("Authorization", apiKeyAuth);
```

## Publish Configuration

```shell
chmod -R 777 storage/
rm -rf resources/views/vendor/latrell/
php artisan vendor:publish
```

## Run migration and seeding

```shell
php artisan key:generate
php artisan optimize
php artisan migrate
php artisan db:seed
```

## Swagger UI
Update configuration of Swagger UI  `config/latrell-swagger.php`
```shell
'enable' => true,
'default-base-path' => '{project server url link}/public'
```
Open link  {project server url link}/public/api-docs
