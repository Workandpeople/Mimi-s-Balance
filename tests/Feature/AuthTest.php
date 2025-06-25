<?php

use App\Models\User;
use Illuminate\Support\Facades\{Hash, Mail, DB};
use Illuminate\Support\Str;
use App\Mail\VerifyEmail;
use App\Mail\ResetPasswordMail;

it('effectue un flow complet d’authentification', function () {
    Mail::fake();

    // Génération d'un email unique pour éviter les collisions
    $email = 'test_' . Str::random(8) . '@example.com';
    dump("➡️ Email généré : {$email}");

    // Étape 1 : Inscription
    dump("🟡 Étape 1 : Inscription");
    $response = $this->post('/register', [
        'role' => 'candidate',
        'email' => $email,
        'password' => 'Password@123',
        'password_confirmation' => 'Password@123',
        'lastname' => 'Doe',
        'firstname' => 'John',
    ]);
    $response->assertRedirect('/');
    dump("✅ Redirection post-register OK");

    Mail::assertSent(VerifyEmail::class);
    dump("📧 Mail de vérification envoyé");

    $user = User::where('email', $email)->first();
    expect($user)->not->toBeNull();
    dump("🧑 Utilisateur créé avec ID : {$user->id}");

    // Étape 2 : Vérification de l'e-mail
    dump("🟡 Étape 2 : Vérification d’email");
    $token = DB::table('email_verifications')->where('user_id', $user->id)->value('token');
    dump("🔐 Token de vérification : {$token}");
    expect($token)->not->toBeNull();

    $this->get("/verify-email/{$token}")
        ->assertRedirect('/')
        ->assertSessionHas('success');
    dump("✅ Email vérifié et redirection confirmée");

    $user->refresh();
    expect($user->is_verified)->toBeTrue();
    dump("🟢 Flag is_verified = true");

    // Étape 3 : Connexion initiale
    dump("🟡 Étape 3 : Connexion initiale");
    $this->post('/login', [
        'email' => $email,
        'password' => 'Password@123',
    ])->assertRedirect('/')
      ->assertSessionHas('success');
    dump("✅ Connexion avec mot de passe initial réussie");

    // Étape 4 : Demande de reset mot de passe
    dump("🟡 Étape 4 : Envoi demande de réinitialisation");
    $this->post('/password/email', [
        'email' => $email,
    ])->assertSessionHas('success');
    dump("📧 Mail de reset envoyé");

    Mail::assertSent(ResetPasswordMail::class);
    $resetToken = DB::table('password_resets')->where('email', $email)->value('token');
    expect($resetToken)->not->toBeNull();
    dump("🔐 Token de reset récupéré : {$resetToken}");

    // Étape 5 : Changement du mot de passe
    dump("🟡 Étape 5 : Réinitialisation avec nouveau mot de passe");
    $this->post('/password/reset', [
        'email' => $email,
        'token' => $resetToken,
        'password' => 'NewPassword@456',
        'password_confirmation' => 'NewPassword@456',
    ])->assertRedirect('/')
      ->assertSessionHas('success');
    dump("✅ Réinitialisation terminée");

    // Étape 6 : Connexion avec le nouveau mot de passe
    dump("🟡 Étape 6 : Connexion avec le nouveau mot de passe");
    $this->post('/login', [
        'email' => $email,
        'password' => 'NewPassword@456',
    ])->assertRedirect('/')
      ->assertSessionHas('success');
    dump("🟢 Connexion finale OK avec nouveau mot de passe");

    // Nettoyage explicite (optionnel)
    $user->delete();
    dump("🧹 Utilisateur supprimé (nettoyage)");
});