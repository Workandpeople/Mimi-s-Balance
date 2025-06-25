<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Category;

class OpenAiService
{
    public function analyzeText(string $text): array
    {
        $existingCategories = Category::pluck('name')->toArray();

        $system = <<<PROMPT
    Tu es un assistant qui analyse des factures (texte brut extrait d’un PDF) et retourne un JSON strict avec ce format :
    {
    "date": "YYYY-MM-DD",
    "items": [
        {"category": "Matériel", "amount_ht": 120.0},
        {"category": "TVA", "amount_tva": 24.0}
    ]
    }

    Instructions :
    - Ne retourne que des montants **HT**, jamais TTC.
    - Si une ligne mentionne un montant de **TVA**, sépare-la avec la catégorie `"TVA"`.
    - Ne crée **aucune catégorie trop spécifique**. Utilise uniquement les catégories existantes ci-dessous, ou une **nouvelle catégorie simple et logique** si aucune ne correspond.

    Catégories connues :
    PROMPT;

        $system .= implode(', ', $existingCategories);

        $response = Http::withToken(config('services.openai.key'))
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-4',
                'messages' => [
                    ['role' => 'system', 'content' => $system],
                    ['role' => 'user', 'content' => $text],
                ],
                'temperature' => 0.1,
            ]);

        if ($response->failed()) {
            throw new \Exception('Erreur OpenAI: ' . $response->body());
        }

        $content = $response->json('choices.0.message.content');
        return json_decode($content, true); // { date, items: [...] }
    }
}