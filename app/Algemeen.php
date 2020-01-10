<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Algemeen extends Model
{
    protected $fillable = [
      'iban', 'bic', 'banknaam', 'factuur_afzendernaam',
      'factuur_afzenderstraatennummer',
      'factuur_afzenderZipenGemeente',
      'factuur_afzenderTelefoon', 'factuur_afzenderEmail'
    ];

}
