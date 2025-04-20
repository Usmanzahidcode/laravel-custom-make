<?php

namespace Usman\LaravelCustomMaker;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class CustomMakerCommand extends Command {
    protected $signature = 'make:{type} {name}';
    protected $description = 'Create a custom class (service, controller, model, etc.) using a custom stub and path.';

    protected Filesystem $files;

    public function __construct() {
        parent::__construct();
        $this->files = (new Filesystem());
    }

    /**
     * Handle the command execution.
     */
    public function handle() {
        // Get the class type and name from arguments
        $type = $this->argument('type');
        $name = $this->argument('name');

        // Fetch the configuration for the requested type
        $config = config("laravel-custom-maker.$type");

        // Check if the configuration exists for the type
        if (!$config) {
            $this->error("Configuration for '{$type}' not found!");
            return;
        }

        // Ensure stub and path are defined in the config
        if (!isset($config['stub']) || !isset($config['path'])) {
            $this->error("Invalid configuration for '{$type}'. Ensure stub and path are defined.");
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
        $content = $this->buildClassContent($name, $stubPath);

        // Write the generated content to the file
        $this->files->put($filePath, $content);

        $this->info("{$type} {$name} created successfully at {$filePath}");
    }

    /**
     * Build the content for the class.
     *
     * @param string $name
     * @param string $stubPath
     * @return string
     */
    protected function buildClassContent($name, $stubPath) {
        // Get the content of the stub
        $stub = $this->files->get($stubPath);

        // Replace the placeholders in the stub with the actual class name and namespace
        $namespace = $this->getNamespace($name);
        $className = $this->getClassName($name);

        $stub = str_replace(['{{ class }}', '{{ namespace }}'], [$className, $namespace], $stub);

        return $stub;
    }

    /**
     * Get the class name from the input.
     *
     * @param string $name
     * @return string
     */
    protected function getClassName(string $name): string {
        return class_basename($name);
    }

    /**
     * Get the namespace for the class.
     *
     * @param string $name
     * @return string
     */
    protected function getNamespace(string $name): string {
        return $this->laravel->getNamespace() . 'App\\' . Str::studly($name);
    }

    /**
     * Make the directory if it doesn't exist.
     *
     * @param string $path
     * @return void
     */
    protected function makeDirectory(string $path): void {
        if (!$this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0777, true);
        }
    }
}
