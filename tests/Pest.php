<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

// Utilisation par défaut du TestCase Laravel + rafraîchissement de la base à chaque test
uses(TestCase::class, RefreshDatabase::class)->in('Feature', 'Unit');

/*
|--------------------------------------------------------------------------
| Expectations personnalisées
|--------------------------------------------------------------------------
|
| Ajoute ici tes extensions à `expect()`, par exemple :
| expect($value)->toBeTrue(); ou ->toBeOne();
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Fonctions globales pour les tests
|--------------------------------------------------------------------------
|
| Tu peux ajouter ici des helpers globaux à utiliser dans tes tests.
| Par exemple : une méthode pour créer un utilisateur rapidement, etc.
|
*/

function createTestUser(array $attributes = []): \App\Models\User
{
    return \App\Models\User::factory()->create($attributes);
}