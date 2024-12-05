<?php

// config for Techsfactory/TfactoryTeamflow
return [
    'user_model' => env('TEAMFLOW_USER_MODEL', \App\Models\User::class),
    'activity_type' => [0 => "Email", 1 => 'Call', 2 => 'Meeting', 3 => 'To DO', 4 => 'Reminder', 5 => 'Upload Document', 6 => 'Exception'],

];
