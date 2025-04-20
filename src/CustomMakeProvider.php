<?php

namespace UsmanZahid\LaravelCustomMake;

use Illuminate\Support\ServiceProvider;

class CustomMakeProvider extends ServiceProvider {
    public function register() {
        //
    }

    public function boot(): void {
        // Publish the configuration file so the user can modify it
        $this->publishes([
            __DIR__ . '/../config/laravel-custom-make.php' => config_path('laravel-custom-make.php'),
        ], 'config');

        // Publish the stub files so users can customize them
        $this->publishes([
            __DIR__ . '/../stubs' => base_path('stubs'),
        ], 'stubs');

        // Register the custom command
        $this->commands([
            CustomMakeCommand::class,
        ]);
    }
}
