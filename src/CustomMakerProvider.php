<?php

namespace UsmanZahid\LaravelCustomMaker;

use Illuminate\Support\ServiceProvider;

class CustomMakerProvider extends ServiceProvider {
    public function register() {
        //
    }

    public function boot(): void {
        // Publish the configuration file so the user can modify it
        $this->publishes([
            __DIR__ . '/../config/laravel_custom_maker.php' => config_path('laravel-custom-maker.php'),
        ], 'config');

        // Publish the stub files so users can customize them
        $this->publishes([
            __DIR__ . '/../stubs' => base_path('stubs'),
        ], 'stubs');

        // Register the custom command
        $this->commands([
            CustomMakerCommand::class,
        ]);
    }
}
