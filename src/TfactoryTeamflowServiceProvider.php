<?php

namespace Techsfactory\TfactoryTeamflow;

use Livewire\Livewire;
use Illuminate\Support\Facades\Blade;
use Spatie\LaravelPackageTools\Package;
use Messagebox\Components\SendMessageBoxComponent;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Techsfactory\TfactoryTeamflow\Services\LivewireService;
use Techsfactory\TfactoryTeamflow\Commands\TfactoryTeamflowCommand;

class TfactoryTeamflowServiceProvider extends PackageServiceProvider
{
    protected LivewireService $livewireService;

    public function __construct($app)
    {
        parent::__construct($app);
        $this->livewireService = new LivewireService();
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

        // $this->registerLivewireComponents();

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
        Blade::component('tfactory-teamflow::send-message', SendMessageBoxComponent::class);
        // \Livewire\Livewire::component('TfactoryTeamflow::send-message', \Techsfactory\TfactoryTeamflow\Http\Livewire\SendMessage::class);
        // Livewire::component('log-note', \Techsfactory\TfactoryTeamflow\Http\Livewire\LogNote::class);
        // Livewire::component('attachment-list', \Techsfactory\TfactoryTeamflow\Http\Livewire\AttachmentList::class);
        // Livewire::component('chatter-tabs', \Techsfactory\TfactoryTeamflow\Http\Livewire\ChatterTabs::class);
    }
}
