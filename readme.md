# Laravel Custom Make

A Laravel package to generate custom classes using user-defined stub templates and configurable paths. 
You can define custom make types to use with the make command.

---

### Installation

```bash
composer require usmanzahid/laravel-custom-make
```
### Publishing Configuration & Stubs
After installing, publish the configuration file and default stubs using:

```bash
php artisan vendor:publish --tag=config
php artisan vendor:publish --tag=stubs
```

This will:
- Create a `config/laravel-custom-make.php` config file.
- Publish stub files to the root `stubs/` directory.

### Configuration
Open config/laravel-custom-make.php to define your custom make types. Example for services:

```php
return [
    'service' => [
        'path' => app_path('Services'),
        'stub' => base_path('stubs/service.stub'),
    ],
];
```
You can define as many types as needed. Each type must include:

- path: Where the class will be generated.
- stub: The stub template used for that type.

### Usage
Run the command:

```bash
php artisan make:custom {type} {Name}
```
Example:
```bash
php artisan make:custom service AuthService
```
This will generate `app/Services/AuthService.php` using the corresponding stub.

### Use Cases

This package is ideal for:

- Adding new custom generators like Services, DTOs, Repositories, etc.
- Generating custom class types the artisan way.
- Replacing or extending Laravel's default generators.
- Creating advanced stubs with pre-defined methods, fields, or logic.

For example, you can:

- Define a custom controller.stub with commonly used methods like index, store, etc.
- Create a model.stub with predefined $fillable fields, relationships, or traits.
- Scaffold layered structures using personalized templates.

### Stub File Format
Your stub file should include placeholders like:

```php
<?php

namespace {{ namespace }};

class {{ class }}
{
    //
}
```

### Notes
Customize stubs as you need. You may want a make type to always extend a certain class.
Just import that class in the stub and then extend that class For example having a base
class for a certain make type, in this case services:
```php
// Import the base class
use App\Http\Services\Service;

// Add it to be extended
class {{ class }} extends Service
```






