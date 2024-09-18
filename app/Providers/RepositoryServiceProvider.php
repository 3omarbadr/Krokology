<?php

namespace App\Providers;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Iterate through an array of model names
        foreach ($this->getModels() as $model) {
            // Bind the interface for the current model to its implementation
            $this->app->bind(
                "App\Repositories\Contracts\I{$model}Repository",
                "App\Repositories\SQL\\{$model}Repository"
            );
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    protected function getModels(): Collection
    {
        $files = File::allFiles(app_path('Models'));

        return collect($files)->map(function ($file) {
            return basename($file, '.php');
        });
    }
}
