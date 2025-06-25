<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Card;
use Illuminate\Support\Str;

class CardController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name'        => 'required|string|max:255',
                'last_digits' => 'required|string|max:4',
            ]);

            Card::create([
                'id'          => Str::uuid(),
                'name'        => $request->name,
                'last_digits' => $request->last_digits,
            ]);

            return redirect()->back()->with('success', 'Carte ajoutée.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
        }
    }

    public function destroy(Card $card)
    {
        $card->delete();
        return redirect()->back()->with('success', 'Carte supprimée.');
    }
}