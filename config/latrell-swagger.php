<?php
return array(
    'enable' => env('APP_DEBUG', true),

    'prefix' => 'api-docs',

    'paths' => base_path('app'),
    'output' => storage_path('swagger/docs'),
    'exclude' => null,
    'default-base-path' => 'http://localhost/play_go/service/public',
    'default-api-version' => '1.0.0',
    'default-swagger-version' => null,
    'api-doc-template' => null,
    'suffix' => '.{format}',

    'title' => 'Swagger UI'
);