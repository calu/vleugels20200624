<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class ActiviteitType extends Enum
{
    const DAGO = 0;
    const VB = 1;
    const DO_VB = 2;
    const MoBe = 3;
    const AmBe = 4;
    
    public static function getDescription($value): string
    {
        if ($value === self::DAGO) {
            return 'dagopvang';
        };
        if ($value === self::VB) {
            return 'verblijf';
        };
        if ($value === self::DO_VB) {
            return 'dagopvang en verblijf';
        };
        if ($value === self::MoBe) {
            return 'Mobiele Begeleiding';
        };
         if ($value === self::AmBe) {
            return 'Ambulante Begeleiding';
        };
       
    
        return parent::getDescription($value);
    }        
}
