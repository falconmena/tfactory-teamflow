<?php

namespace Techsfactory\TfactoryTeamflow\Commands;

use Illuminate\Console\Command;

class TfactoryTeamflowCommand extends Command
{
    public $signature = 'tfactory-teamflow';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
