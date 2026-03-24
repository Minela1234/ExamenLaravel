<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEtudiantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'prenom' => 'required|string',
            'nom' => 'required|string',
            'email' => 'required|email|unique:etudiants',
            'date_naissance' => 'required|date|before:now',
        ];
    }

    public function messages(){
        return [
            'prenom.required' => 'Le prenom est obligatoire',
            'prenom.string' => 'Le prenom doit etre une chaine de caracteres',
            'nom.required' => 'Le nom est obligatoire',
            'nom.string' => 'Le nom doit etre une chaine de caracteres',
            'email.required' => 'L\'email est obligatoire',
            'email.unique' => 'Cet email est déjà utilisé',
            'date_naissance.required' => 'La date de naissance est obligation',
            'date_naissance.date' => 'La date de naissance doit etre de type date',
            'date_naissance.before' => 'La date de naissance doit etre dans le passé',
        ];
    }
}
