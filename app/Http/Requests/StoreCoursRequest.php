<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCoursRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'libelle' => 'required|string',
            'professeur' => 'required|string',
            'volume_horaire' => 'required|integer|min:1'
        ];
    }

    public function messages()
    {
        return [
            'libelle.required' => 'Le libellé est obligatoire',
            'libelle.string' => 'Le libellé doit etre une chaine de caracteres',
            'professeur.required' => 'Le professeur est obligatoire',
            'professeur.string' => 'Le professeur doit etre une chaine de caracteres',
            'volume_horaire.required' => 'Le volume horaire est obligatoire',
            'volume_horaire.integer' => 'LeLe volume horaire doit etre un entier',
            'volume_horaire.min' => 'Le volume horaire doit etre superieur à 0',
        ];
    }
}
