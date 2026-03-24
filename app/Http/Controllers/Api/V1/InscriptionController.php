<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\EtudiantResource;
use Illuminate\Http\Request;
use App\Models\Etudiant;

class InscriptionController extends Controller
{
    // POST api/v1/etudiants/{id}/cours/attach
    // Ajouter des cours à un étudiant sans toucher aux autres
    public function attach(Request $request, $id){
        // Valider que cours_ids est un tableau d'ID existants
        $request->validate([
            // cours_ids doit etre un tableau
            'cours_ids' => ['required', 'array'],
            // Chaque élément doit etre un entier qui existe dans la table cours
            'cours_ids.*' => ['integer', 'exists:cours,id'],
        ]);
        // Trouver l'étudiant -> 404 si inexistant
        $etudiant = Etudiant::findOrFail($id);

        // attach() ajputes les cours sans toucher aux cours déjà inscrits
        $etudiant->cours()->attach($request->cours_ids);

        // Recharger la relation apres modification
        $etudiant->load('cours');

        return new EtudiantResource($etudiant);
    }

    // POST POST api/v1/etudiants/{id}/cours/detach
    // Retirer des cours d'un étudiant sans toucher aux autres
    public function detach(Request $request, $id ){
        $request->validate([
            'cours_ids'     => ['required', 'array'],
            'cours_ids.*'   => ['integer', 'exists:cours,id'],
        ]);

        // Trouver l'étudiant -> 404 si inexistant
        $etudiant = Etudiant::findOrFail($id);

        // Supprime uniquement les cours spécifiés de la table pivot
        $etudiant->cours()->detach($request->cours_ids);

        $etudiant->load('cours');

        return new EtudiantResource($etudiant);
    }

    // POST POST api/v1/etudiants/{id}/cours/sync
    // Remplacer toute la liste des cours d'un étudiant sans toucher aux autres
    public function sync(Request $request, $id){
        $request->validate([
            'cours_ids'   =>   ['required', 'array'],
            'cours_ids.*'   => ['integer', 'exists:cours,id'],
        ]);

        $etudiant = Etudiant::findOrFail($id);

        // sync() Supprime tous les cours et remplace par la nouvelle liste
        $etudiant->cours()->sync($request->cours_ids);

        $etudiant->load('cours');

        return new EtudiantResource($etudiant);
    }
}
