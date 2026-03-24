<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCoursRequest extends FormRequest
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
            'libelle'        => 'sometimes|string',
            'professeur'     => 'sometimes|string',
            'volume_horaire' => 'sometimes|integer|min:1',
        ];
    }
    public function messages(): array
    {
        return [
            'libelle.string'         => 'Le libellé doit être une chaîne de caractères.',
            'professeur.string'      => 'Le nom du professeur doit être une chaîne de caractères.',
            'volume_horaire.integer' => 'Le volume horaire doit être un nombre entier.',
            'volume_horaire.min'     => 'Le volume horaire doit être supérieur à 0.',
        ];
    }

}
