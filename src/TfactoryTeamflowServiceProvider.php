<?php

namespace Techsfactory\TfactoryTeamflow;

use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Techsfactory\TfactoryTeamflow\Commands\TfactoryTeamflowCommand;
use Livewire\Livewire;

class TfactoryTeamflowServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('tfactory-teamflow')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_tfactory_teamflow_table')
            ->hasCommand(TfactoryTeamflowCommand::class)
            ->hasInstallCommand(function(InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishAssets()
                    ->publishMigrations()
                    ->callAfterInstall(function(){
                        $this->runMigrations();
                    });
            });
    }

    public function boot(): void
    {
        // Register Livewire Components
        $this->registerLivewireComponents();

        // Publish any views or assets
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/tfactory-teamflow'),
        ], 'teamflow-views');
    }

    /**
     * Register Livewire components for the package.
     */
    protected function registerLivewireComponents()
    {
        // Publish Livewire's assets if needed (optional)
        if (class_exists(\Livewire\Livewire::class)) {
            Livewire::component('send-message', \Techsfactory\TfactoryTeamflow\Http\Livewire\SendMessage::class);
        }
    }

    protected function runMigrations()
    {
        // Run migrations using the Artisan command
        \Artisan::call('migrate', ['--force' => true]);
    }
}
