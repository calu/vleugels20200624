<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactpersoonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
        'voornaam' => 'required | min:2',
        'familienaam' => ' required | min:2',
        'relatie' => 'required | min:2',
        'straat' => ' required | min:2',
        'huisnummer' => ' required',
        'postcode' => 'required',
        'gemeente' => 'required',
        'telefoon' => 'required_without:gsm',
        'gsm' => 'required_without:telefoon',
        'email' => 'email',
        'rubriek' => 'required',
        'vraag' => 'required',    
        ];
    }
}
