<?php

namespace Techsfactory\TfactoryTeamflow\Services;

use Illuminate\Support\Facades\App;
use Livewire\Livewire;

class LivewireService
{
    public function registerComponents(): void
    {
        if (!class_exists(Livewire::class)) {
            return;
        }

        $components = [
            'tfactory-teamflow.send-message' => \Techsfactory\TfactoryTeamflow\Http\Livewire\SendMessage::class,
        ];

        foreach ($components as $alias => $class) {
            Livewire::component($alias, $class);
        }
    }

    public function isLivewireInstalled(): bool
    {
        return class_exists(Livewire::class);
    }
}