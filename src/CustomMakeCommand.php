<?php

namespace UsmanZahid\LaravelCustomMake;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class CustomMakeCommand extends Command {
    protected $signature = 'make:custom {type} {name}';
    protected $description = 'Create a custom class (Defined by the developer) using a custom stub and path.';

    protected Filesystem $files;

    public function __construct() {
        parent::__construct();
        $this->files = (new Filesystem());
    }

    public function handle(): void {
        // Get the class type and name from arguments
        $type = $this->argument('type');
        $name = $this->argument('name');

        // Fetch the configuration for the requested type
        $config = config("laravel-custom-make.$type");

        // Check if the configuration exists for the type
        if (!$config) {
            $this->error("Configuration for '{$type}' not found!");
            return;
        }

        // Ensure stub and path are defined in the config
        if (!isset($config['stub']) || !isset($config['path'])) {
            $this->error("Invalid configuration for creating '{$type}'. Ensure stub and path are defined.");
            return;
        }

        // Get the stub and path from the config
        $stubPath = $config['stub'];
        $classPath = $config['path'];

        // Check if the class already exists
        $filePath = $classPath . '/' . $name . '.php';
        if ($this->files->exists($filePath)) {
            $this->error("Class {$name} already exists!");
            return;
        }

        // Ensure the directory exists
        $this->makeDirectory($classPath);

        // Get the content from the stub file and replace placeholders
        $content = $this->buildClassContent($name, $classPath, $stubPath);

        // Write the generated content to the file
        $this->files->put($filePath, $content);

        $this->info("{$type} {$name} created successfully at {$filePath}");
    }

    protected function buildClassContent($name, $classPath, $stubPath): array|string {
        // Get the content of the stub
        $stub = $this->files->get($stubPath);

        // Replace the placeholders in the stub with the actual class name and namespace
        $namespace = $this->getNamespace($classPath);
        $className = $this->getClassName($name);

        $stub = str_replace(['{{ class }}', '{{ namespace }}'], [$className, $namespace], $stub);

        return $stub;
    }

    protected function getClassName(string $name): string {
        return class_basename($name);
    }

    protected function getNamespace(string $path): string {
        $relativePath = str_replace(base_path() . '/', '', $path);
        $namespace = str_replace(['/', '\\'], '\\', $relativePath);
        return $this->laravel->getNamespace() . trim($namespace, '\\');
    }

    protected function makeDirectory(string $path): void {
        if (!$this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0777, true);
        }
    }
}
