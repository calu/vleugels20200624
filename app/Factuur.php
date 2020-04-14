<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Factuur;

class Factuur extends Model
{
    protected $fillable = [
        'factuurvolgnummer', 'jaar', 'datum', 'serviceable_id', 'serviceable_type',
        'omschrijving', 'aantal', 'prijs', 'betaald', 'referentie'
    ];
    
    /**
     * de getHoogsteVolgnummer zoekt in alle facturen naar het hoogste nummer van het $jaar
     *
     */
    public function getHoogsteVolgnummer($jaar)
    {
        $x = Factuur::where('jaar', $jaar)->get();
        dd($x);
    }
    

}
