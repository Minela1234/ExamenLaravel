<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Etudiant;
use App\Models\Cours;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EtudiantTest extends TestCase
{
    // Remet la base à zéro avant chaque test
    use RefreshDatabase;

    // Méthode utilitaire — créer un token
    private function getToken(): string
    {
        // Crée un utilisateur fictif
        $user = User::factory()->create();

        // Génère un token Sanctum
        return $user->createToken('test')->plainTextToken;
    }

    // ────────────────────────────────────────
    // TEST 1 : accès sans token → 401
    // ────────────────────────────────────────
    public function test_acces_sans_token_retourne_401(): void
    {
        // Appelle la route sans token
        $response = $this->getJson('/api/v1/etudiants');

        // Vérifie que la réponse est 401
        $response->assertStatus(401);
    }

    // ────────────────────────────────────────
    // TEST 2 : création étudiant → 201
    // ────────────────────────────────────────
    public function test_creation_etudiant_retourne_201(): void
    {
        $token = $this->getToken();

        $response = $this->withToken($token)->postJson('/api/v1/etudiants', [
            'prenom'         => 'Awa',
            'nom'            => 'Diallo',
            'email'          => 'awa@example.com',
            'date_naissance' => '2000-05-12',
        ]);

        // Vérifie que la réponse est 201
        $response->assertStatus(201);

        // Vérifie que l'email est bien dans la réponse
        $response->assertJsonPath('data.email', 'awa@example.com');
    }

    // ────────────────────────────────────────
    // TEST 3 : email invalide → 422
    // ────────────────────────────────────────
    public function test_creation_email_invalide_retourne_422(): void
    {
        $token = $this->getToken();

        $response = $this->withToken($token)->postJson('/api/v1/etudiants', [
            'prenom'         => 'Awa',
            'nom'            => 'Diallo',
            'email'          => 'pas-un-email',
            'date_naissance' => '2000-05-12',
        ]);

        // Vérifie que la réponse est 422
        $response->assertStatus(422);

        // Vérifie que l'erreur concerne le champ email
        $response->assertJsonValidationErrors(['email']);
    }

    // ────────────────────────────────────────
    // TEST 4 : attach → 200
    // ────────────────────────────────────────
    public function test_attach_cours_retourne_200(): void
    {
        $token    = $this->getToken();
        $etudiant = Etudiant::factory()->create();
        $cours    = Cours::factory()->create();

        $response = $this->withToken($token)->postJson(
            "/api/v1/etudiants/{$etudiant->id}/cours/attach",
            ['cours_ids' => [$cours->id]]
        );

        $response->assertStatus(200);
    }

    // ────────────────────────────────────────
    // TEST 5 : sync → 200
    // ────────────────────────────────────────
    public function test_sync_cours_retourne_200(): void
    {
        $token    = $this->getToken();
        $etudiant = Etudiant::factory()->create();
        $cours    = Cours::factory()->count(3)->create();

        $response = $this->withToken($token)->postJson(
            "/api/v1/etudiants/{$etudiant->id}/cours/sync",
            ['cours_ids' => $cours->pluck('id')->toArray()]
        );

        $response->assertStatus(200);
    }

    // ────────────────────────────────────────
    // TEST 6 : suppression → 204
    // ────────────────────────────────────────
    public function test_suppression_etudiant_retourne_204(): void
    {
        $token    = $this->getToken();
        $etudiant = Etudiant::factory()->create();

        $response = $this->withToken($token)->deleteJson(
            "/api/v1/etudiants/{$etudiant->id}"
        );

        $response->assertStatus(204);
    }
}