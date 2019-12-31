<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class StatuutType extends Enum
{
    const RTH = 0;
    const MFC = 1;
    const PVF = 2;
    const PAB = 3;

    public static function getDescription($value): string
    {
        switch ($value)
        {
            case 0 : return 'RTH';
            case 1 : return 'MFC';
            case 2 : return 'PVF';
            case 3 : return 'PAB';
        }
        
        return 'Enum::Statuut NOT FOUND';
    }          
}
