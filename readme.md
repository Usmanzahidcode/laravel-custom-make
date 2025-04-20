# Laravel Custom Maker

A simple Laravel package to generate custom classes (e.g., services, controllers, models, etc.) using user-defined stub templates and configurable paths.

---

## 📦 Installation

```bash
composer require vendor/laravel-custom-maker
```
### Publishing Configuration & Stubs
After installing, publish the configuration file and default stubs using:

```bash
php artisan vendor:publish --tag=config
php artisan vendor:publish --tag=stubs
```

This will:
- Create a config/laravel-custom-maker.php config file.
- Publish stub files to the root stubs/ directory.

### Configuration
Open config/laravel-custom-maker.php to define your custom make types. Example:

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
This will generate `app/Services/MyAwesomeService.php` using the corresponding stub.

### Use Cases

This package is ideal for:

- Adding new custom generators like Service, Action, Repository, etc.
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
Customize stubs as you need, extend the class by adding it in the stub and import it.

### License
MIT





