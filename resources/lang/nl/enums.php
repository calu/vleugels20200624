<?php

use App\Enums\StatuutType;
use App\Enums\ActiviteitType;

return [

    StatuutType::class => [
        StatuutType::RTH => 'RTH',
        StatuutType::MFC => 'MFC',
        StatuutType::PFV => 'PFV',
        StatuutType::PAB => 'PAB',
    ],

    ActiviteitType::class => [
        ActiviteitType::DAGO => 'DAGO',
        ActiviteitType::VB => 'VB',
        ActiviteitType::DO_VB => 'DO_VB',
        ActiviteitType::MoBe => 'MoBe',
        ActiviteitType::AmBe => 'AmBe',
        
    ],

];