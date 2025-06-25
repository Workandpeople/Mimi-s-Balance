<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\OpenAiService;
use Illuminate\Support\Facades\Storage;
use Smalot\PdfParser\Parser;
use App\Models\Category;
use App\Models\Invoice;
use Illuminate\Support\Str;
use App\Models\Card;

class IndexController extends Controller
{

    public function index(Request $request)
    {
        $cards = Card::all();
        return view('pages.index', compact('cards'));
    }


    public function fetchFactures(Request $request)
    {
        try {
            logger()->info('Début de fetchFactures', $request->all());

            $query = Invoice::query()->with('category');

            if ($request->filled('card_id')) {
                $query->where('card_id', $request->card_id);
            }

            if ($request->filled('date_from')) {
                $query->where('invoice_date', '>=', $request->date_from);
            }

            if ($request->filled('date_to')) {
                $query->where('invoice_date', '<=', $request->date_to);
            }

            $invoices = $query->get();
            logger()->info('Factures récupérées', ['count' => $invoices->count()]);

            $grouped = $invoices->groupBy('category.name')->map(function ($items, $categoryName) {
                $color = optional($items->first()->category)->color ?? '#cccccc';
                return [
                    'category' => $categoryName ?? 'Non catégorisé',
                    'amount'   => $items->sum('amount'),
                    'color'    => $color,
                ];
            })->values();

            return response()->json(['data' => $grouped]);
        } catch (\Throwable $e) {
            logger()->error('Erreur dans fetchFactures : ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Erreur serveur'], 500);
        }
    }

    public function fetchMonthlyFactures(Request $request)
    {
        try {
            logger()->info('Début de fetchMonthlyFactures', $request->all());

            $year = $request->get('year', now()->year);
            $cardId = $request->get('card_id');

            $query = Invoice::query()
                ->with('category')
                ->whereYear('invoice_date', $year);

            if ($cardId) {
                $query->where('card_id', $cardId);
            }

            $invoices = $query->get();
            logger()->info('Factures mensuelles récupérées', ['count' => $invoices->count()]);

            $grouped = $invoices->groupBy([
                fn($i) => \Carbon\Carbon::parse($i->invoice_date)->format('m'),
                fn($i) => optional($i->category)->name ?? 'Non catégorisé',
            ]);

            $result = [];

            foreach ($grouped as $month => $categories) {
                foreach ($categories as $category => $items) {
                    $color = optional($items->first()->category)->color ?? '#cccccc';

                    if (!isset($result[$category])) {
                        $result[$category] = [
                            'label' => $category,
                            'backgroundColor' => $color,
                            'data' => array_fill(0, 12, 0),
                        ];
                    }

                    $result[$category]['data'][(int) $month - 1] = $items->sum('amount');
                }
            }

            logger()->info('Datasets construits', ['datasets' => $result]);

            return response()->json([
                'labels' => [
                    'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
                    'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'
                ],
                'datasets' => array_values($result),
            ]);
        } catch (\Throwable $e) {
            logger()->error('Erreur dans fetchMonthlyFactures : ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Erreur serveur'], 500);
        }
    }

    public function analyzeInvoice(Request $request, OpenAiService $ai)
    {
        try {
            logger()->info("Analyse de facture démarrée...");

            $request->validate(['file' => 'required|file|mimes:pdf']);
            $pdf = $request->file('file');
            $path = $pdf->store('invoices_temp');
            logger()->info("Fichier uploadé : " . $path);

            $parser = new \Smalot\PdfParser\Parser();
            $text = $parser->parseFile(Storage::path($path))->getText();

            $existingCategories = Category::pluck('name')->toArray();
            $analysis = $ai->analyzeText($text, $existingCategories);

            logger()->info("Résultat brut OpenAI : ", $analysis);

            return response()->json([
                'date' => $analysis['date'] ?? null,
                'items' => $analysis['items'] ?? [],
            ]);
        } catch (\Throwable $e) {
            logger()->error("Erreur dans analyzeInvoice : " . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Erreur lors de l’analyse de la facture.'], 500);
        }
    }

    public function storeInvoice(Request $request)
    {
        try {
            $request->validate([
                'card_id' => 'required|exists:cards,id',
                'invoice_file' => 'required|file|mimes:pdf',
                'categories' => 'required|json',
                'invoice_date' => 'nullable|date',
            ]);

            $file = $request->file('invoice_file');
            $filename = Str::uuid() . '.pdf';
            $path = $file->storeAs('invoices', $filename);

            $lines = json_decode($request->categories, true);

            foreach ($lines as $line) {
                $categoryName = $line['category'] ?? null;
                $amount = $line['amount_ht'] ?? $line['amount_tva'] ?? null;

                if (!$categoryName || !$amount) {
                    continue;
                }

                // Création ou récupération de la catégorie
                $category = Category::firstOrCreate(['name' => $categoryName], [
                    'id' => Str::uuid(),
                ]);

                // Création de la facture
                Invoice::create([
                    'id'            => Str::uuid(),
                    'filename'      => $filename,
                    'original_name' => $file->getClientOriginalName(),
                    'amount'        => $amount,
                    'invoice_date'  => $request->invoice_date ?? now(),
                    'merchant'      => null, // à remplir plus tard si besoin
                    'card_id'       => $request->card_id,
                    'category_id'   => $category->id,
                ]);
            }

            return response()->json(['success' => true]);
        } catch (\Throwable $e) {
            Log::error('Erreur dans storeInvoice : ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Erreur lors de l’enregistrement de la facture.'], 500);
        }
    }
}
