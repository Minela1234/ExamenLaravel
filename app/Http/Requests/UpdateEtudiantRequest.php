<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEtudiantRequest extends FormRequest
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
        $id = $this->route('etudiant');
        return [
            'prenom'         => 'sometimes|string',
            'nom'            => 'sometimes|string',
            'email'          => 'sometimes|email|unique:etudiants,email,'.$id,
            'date_naissance' => 'sometimes|date|before:now',
        ];
    }
     public function messages(): array
    {
        return [
            'prenom.string'         => 'Le prénom doit être une chaîne de caractères.',
            'nom.string'            => 'Le nom doit être une chaîne de caractères.',
            'email.email'           => 'L\'email doit être une adresse email valide.',
            'email.unique'          => 'Cet email est déjà utilisé.',
            'date_naissance.date'   => 'La date de naissance doit être une date valide.',
            'date_naissance.before' => 'La date de naissance doit être dans le passé.',
        ];
    }

}
