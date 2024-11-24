<?php

namespace Techsfactory\TfactoryTeamflow;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Techsfactory\TfactoryTeamflow\Commands\TfactoryTeamflowCommand;

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
            ->hasCommand(TfactoryTeamflowCommand::class);
    }
}
