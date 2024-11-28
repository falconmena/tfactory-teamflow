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
        $package
            ->name('tfactory-teamflow')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_tfactory_teamflow_table')
            ->hasCommand(TfactoryTeamflowCommand::class)
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishAssets()
                    ->publishMigrations();
            });
    }

    public function boot(): void
    {
        parent::boot();

        $this->registerLivewireComponents();

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'tfactory-teamflow');

        $this->publishes([
            __DIR__ . '/../database/migrations' => database_path('migrations'),
        ], 'tfactory-teamflow-migrations');

        $this->publishes([
            __DIR__ . '/../config/tfactory-teamflow.php' => config_path('tfactory-teamflow.php'),
        ], 'tfactory-teamflow-config');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/tfactory-teamflow'),
        ], 'tfactory-teamflow-views');
    }

    protected function registerLivewireComponents()
    {
        if (class_exists(\Livewire\Livewire::class)) {
            Livewire::component('send-message', \Techsfactory\TfactoryTeamflow\Http\Livewire\SendMessage::class);
            // Livewire::component('log-note', \Techsfactory\TfactoryTeamflow\Http\Livewire\LogNote::class);
            // Livewire::component('attachment-list', \Techsfactory\TfactoryTeamflow\Http\Livewire\AttachmentList::class);
            // Livewire::component('chatter-tabs', \Techsfactory\TfactoryTeamflow\Http\Livewire\ChatterTabs::class);
        }
    }
}
