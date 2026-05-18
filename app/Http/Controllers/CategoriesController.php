<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\View\View;

class CategoriesController extends Controller
{
    public function index(): View
    {
        $allGenreWords = Game::where('active', true)->pluck('genre')->filter()
            ->flatMap(fn ($g) => explode(' ', $g))
            ->unique()
            ->sort()
            ->values();

        $categories = $allGenreWords->map(function ($word) {
            return [
                'name' => $word,
                'count' => Game::where('active', true)->where('genre', 'like', '%'.$word.'%')->count(),
                'url' => route('games.index', ['genre' => [$word]]),
            ];
        });

        return view('categories.index', compact('categories'));
    }
}
