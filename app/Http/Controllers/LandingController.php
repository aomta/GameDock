<?php
namespace App\Http\Controllers;

use App\Models\Game;

class LandingController extends Controller
{
    public function index()
    {
        $marqueeGames = Game::where('active', true)->inRandomOrder()->take(5)->get();

        return view('landing', compact('marqueeGames'));
    }
}
