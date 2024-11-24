<?php

namespace Techsfactory\TfactoryTeamflow\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Techsfactory\TfactoryTeamflow\TfactoryTeamflow
 */
class TfactoryTeamflow extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Techsfactory\TfactoryTeamflow\TfactoryTeamflow::class;
    }
}
