<?php

namespace Techsfactory\TfactoryTeamflow;

use Illuminate\Support\Facades\Blade;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Techsfactory\TfactoryTeamflow\Commands\TfactoryTeamflowCommand;
use Livewire\Livewire;
use Techsfactory\TfactoryTeamflow\Services\LivewireService;

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

        if ($this->livewireService->isLivewireInstalled()) {
            $this->livewireService->registerComponents();
            $this->registerLivewireDirectives();
        }

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

    protected function registerLivewireDirectives(): void
    {
        Blade::directive('tfactoryTeamflowScripts', function () {
            return "<?php echo view('tfactory-teamflow::scripts')->render(); ?>";
        });
    }
}
