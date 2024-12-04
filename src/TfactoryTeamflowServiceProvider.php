<?php

namespace Techsfactory\TfactoryTeamflow;

use Illuminate\Support\Facades\Blade;
use Spatie\LaravelPackageTools\Package;
use Messagebox\Components\SendMessageBoxComponent;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Techsfactory\TfactoryTeamflow\Commands\TfactoryTeamflowCommand;

class TfactoryTeamflowServiceProvider extends PackageServiceProvider
{
    public function __construct($app)
    {
        parent::__construct($app);
    }
    public function configurePackage(Package $package): void
    {
        $package
            ->name('tfactory-teamflow')
            ->hasConfigFile()
            ->hasViews()
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

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'tfactory-teamflow');

        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        $this->publishes([
            __DIR__ . '/../public/js' => public_path('vendor/tfactory-teamflow/js'),
        ], 'tfactory-teamflow-assets');
        
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
}
