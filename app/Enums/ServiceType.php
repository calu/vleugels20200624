<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class ServiceType extends Enum
{
    public static function getDescription($value) : string
    {

        switch ($value){
            case 'App\Hotel':
                return "hotel";
            case 'App\Therapie':
                return "therapie";
            case 'App\Dagverblijf':
                return "dagverblijf";
        }
        
        return "[Enums-ServiceType] NOT FOUND";
    }
   
    public static function getValue($string) : string
    {
        switch ($string){
            case 'hotel':
                return "App\Hotel";
            case 'therapie':
                return "App\Therapie";
            case 'dagverblijf':
                return "App\Dagverblijf";
        }
        
        return "[Enums->ServiceType] NOT FOUND";
    }
}