<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\EtudiantController;
use App\Http\Controllers\Api\V1\CoursController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\InscriptionController;

Route::prefix('v1')->group(function(){

    // Routes publiques qui sont protégées par throttle uniquement
    Route::middleware('throttle:api')->group(function () {
        Route::post('auth/register', [AuthController::class, 'register']);
        Route::post('auth/login',    [AuthController::class, 'login']);
    });

    Route::middleware(['auth:sanctum', 'throttle:api'])->group(function(){

        // Auth
        Route::post('/auth/logout', [AuthController::class, 'logout']);
        Route::get('/auth/me',[AuthController::class, 'me']);
        
        // CRUD
        Route::apiResource('etudiants', EtudiantController::class);
        Route::apiResource('cours', CoursController::class);

        // Many-to-Many
        Route::post('etudiants/{id}/cours/attach', [InscriptionController::class, 'attach']);
        Route::post('etudiants/{id}/cours/detach', [InscriptionController::class, 'detach']);
        Route::post('etudiants/{id}/cours/sync',   [InscriptionController::class, 'sync']);
 
    });
});
