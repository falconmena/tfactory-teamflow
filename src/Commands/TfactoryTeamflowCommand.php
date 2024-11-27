<?php

namespace Techsfactory\TfactoryTeamflow\Commands;

use Illuminate\Console\Command;

class TfactoryTeamflowCommand extends Command
{
    protected $signature = 'tfactory-teamflow:install';

    protected $description = 'Install and configure tfactory-teamflow package';

    public function handle()
    {
        $this->call('vendor:publish', ['--provider' => 'Techsfactory\\TfactoryTeamflow\\TfactoryTeamflowServiceProvider']);
        
        $this->info('Running migrations...');
        $this->call('migrate', ['--force' => true]);

        $this->info('TfactoryTeamflow installation complete!');
    }
}
