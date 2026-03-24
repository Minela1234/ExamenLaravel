<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEtudiantRequest;
use App\Http\Requests\UpdateEtudiantRequest;
use App\Http\Resources\EtudiantCollection;
use Illuminate\Http\Request;
use App\Models\Etudiant;
use App\Http\Resources\EtudiantResource;

class EtudiantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    //Retourne la liste paginée d'étudiants
    //GET api/v1/etudiants
    public function index(Request $request)
    {
        //Prépare la requete etudiant sans l'executer
        $query = Etudiant::query();

        //?q=Awa -> Rechercher Awa dans prénom, nom, email
        if ($request->has('q')){
            $search = $request->query('q');
            $query->where(function($q) use ($search) {
                $q->where('prenom', 'like', "%{$search}%")
                  ->orWhere('nom', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        // ?per_page=5 ->  10 par défaut si absent
        $perPage = $request->query('per_page', 5);

        // paginate execute la requete et decoupe les pages
        // EtudiantCollection emballe avec data, links et meta
        return new EtudiantCollection($query->paginate($perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    //POST /api/v1/etudiants
    //Crée un nouvel étudiant
    public function store(StoreEtudiantRequest $request)
    {
        // validated() retourne uniquement les champs validés
        $etudiant = Etudiant::create($request->validated());

        // 201 = code HTTP "resource crée avec succes"
        return (new EtudiantResource($etudiant))
               ->response()
               ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */

    //GET api/v1/etudiantS/{id}
    // Retourne un seul étudiant
    public function show(Request $request, $id)
    {
        
        $etudiant = Etudiant::findOrfail($id);
        
        // ?include=cours -> Charget la relation cours
        if($request->query('include') === 'cours'){
            $etudiant->load('cours');
        }
        return new EtudiantResource($etudiant);
    }

    /**
     * Update the specified resource in storage.
     */

     //  PUT/PATCH api/v1/etudiants/{id}
     //  Modifie un étudiant existant
    public function update(UpdateEtudiantRequest $request, $id)
    {
        $etudiant = Etudiant::findOrfail($id);

        $etudiant->update($request->validate());

        // 200  OK par défaut
        return new EtudiantResource($etudiant);
    }

    /**
     * Remove the specified resource from storage.
     */

    // DELETE api/etudiants/{id}
    //  
    public function destroy(string $id)
    {
        $etudiant = Etudiant::findOrfail($id);
        $etudiant->delete();

        //  204 = Suppression reussie
        return response()->json(null, 204);
               
    }
}
