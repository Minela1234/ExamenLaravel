<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCoursRequest;
use App\Http\Resources\CoursCollection;
use App\Http\Resources\CoursResource;
use Illuminate\Http\Request;
use App\Models\Cours;
use App\Http\Requests\UpdateCoursRequest;

class CoursController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // GET api/v1/cours
    // Restourne la liste paginée des cours
    public function index(Request $request)
    {
        $query = Cours::query();

        // ?professeur=Sow -> Filtre sur le professeur
        if ($request->has('professeur')){
            $query->where(
                'professeur',
                'like',
                '%'.$request->query('professeur').'%'
            );
        }

        // ?per__page= 5 -> 10 par défaut si absent
        $perPage = $request->query('per_page', 10);

        return new CoursCollection($query->paginate($perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCoursRequest $request)
    {
        $cours = Cours::create($request->validated());
        // 201 = Resource crée avec succes
        return (new CoursResource($cours))
               ->response()
               ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
     //  GET api/v1/cours/{id}
     //  Retourne un seul cours
    public function show(Request $request, $id)
    {
        $cours = Cours::findOrfail($id);

        // ?include=etudiants -> Charger la relation étudiant
        if ($request->query('include') === 'etudiants') {
            $cours->load('etudiants');
        }

        return new CoursResource($cours);
    }

    /**
     * Update the specified resource in storage.
     */
    // PUT PATCH api/v1/cours/{id}
    // Modifie un cours
    public function update(UpdateCoursRequest $request, $id)
    {
        $cours = Cours::findOrfail($id);
        $cours->update($request->validated());

        return new CoursResource($cours);
    }

    /**
     * Remove the specified resource from storage.
     */

    //DELETE api/v1/cours/{id}
    // Supprime un cours
    public function destroy(string $id)
    {
        $cours = Cours::findOrfail($id);
        $cours->delete();

        // 204 Suppression réussie
        return response()->json(null, 204);
    }
}
