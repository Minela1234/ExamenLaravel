<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class AuthController extends Controller
{
    public function register(Request $request){
        // Validation des données
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',

        ]);

        // Crée l'utilisateur
        // Hash::make() chiffre le mot de passe avant de le stocker
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            ]);

        // Créer un token sanctum pour cette utilisateur
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Compte crée avec succes',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
        ], 201);
    }

    // POST /api/v1/auth/login
    // Se connecter 

    public function login(Request $request){
        // Validation des données
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
             ]);

        // Cherche l'utilisateur par email
        $user = User::where('email', $request->email)->first();

        // Vérifier que l'utilisateur existe et que le token est correct
        //  Hash::check() compare le mot de passe envoyé avec celui qui est chiffré en base
        if(!$user || !Hash::check($request->password, $user->password)){
            return response()->json([
                'message' => 'Email ou mot de passe incorrect',
            ], 401);
        }

        // Supprimer les anciens token pour éviter les doublons
        $user->tokens()->delete();

        // Créer un nouveau token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Connexion reussie. ',
            'token'   => $token,
            'user'    => [
                'id'      => $user->id,
                'name'    => $user->name,
                'email'   => $user->email, 
            ],
        ]);

    }

    // POST api/v1/auth/logout
    // Se déconnecter et cette route est protégée par auth:sanctum

    public function logout(Request $request){
        // Supprimer l'actuel token de l'utilisateur
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Deconnexion reussie',
        ]);
    }

    // GET api/v1/auth/me
    // Retourner le profil de l'utilisateur connecté
    public function me(Request $request){
        return response()->json([
            'id'  => $request->user()->id,
            'name'  => $request->user()->name,
            'email'  => $request->user()->email,
        ]);      
    }
}
