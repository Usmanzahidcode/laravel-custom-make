<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Custom Make Types
    |--------------------------------------------------------------------------
    |
    | Define your custom class types here. Each type should include:
    | - 'path': The directory where the generated class should be placed.
    | - 'stub': The path to the stub file used as a template for generation.
    |
    | You can add as many types as needed. The `make:custom {type} {name}`
    | command will use this configuration to create the appropriate class.
    |
    */

    'service' => [
        'path' => app_path('Services'),
        'stub' => base_path('stubs/service.stub'),
    ],

];
