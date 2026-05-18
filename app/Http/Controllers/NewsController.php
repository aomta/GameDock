<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(): View
    {
        $news = [
            [
                'title' => 'Spring Sale 2026 Now Live',
                'date' => '2026-05-01',
                'image' => 'images/spring_sale.jpg',
                'excerpt' => 'Save up to 75% on hundreds of top games. Spring Sale runs through May 15th.',
            ],
            [
                'title' => 'New RPG Collection Available',
                'date' => '2026-04-28',
                'image' => 'images/rpg_collection.jpg',
                'excerpt' => 'Discover the latest RPG titles added to our catalogue this week.',
            ],
            [
                'title' => 'Weekend Deal: Action Games Bundle',
                'date' => '2026-04-25',
                'image' => 'images/weekend_deals.jpg',
                'excerpt' => 'Grab the ultimate action bundle at a special price this weekend only.',
            ],
            [
                'title' => 'Platform Update: New Wishlist Features',
                'date' => '2026-04-20',
                'image' => 'images/wishlist_update.jpg',
                'excerpt' => 'Track your favorite games and get notified when they go on sale.',
            ],
        ];

        return view('news.index', compact('news'));
    }
}
