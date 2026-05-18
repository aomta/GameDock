<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminGameController extends Controller
{
    public function index()
    {
        $games = Game::orderBy('id')->get();
        return view('admin.games.index', ['games' => $games]);
    }

    public function create()
    {
        return view('admin.games.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'genre' => 'nullable|string|max:100',
            'developer' => 'nullable|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'release_date' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'active' => 'nullable|boolean',
            'os_minimum' => 'nullable|string',
            'processor_minimum' => 'nullable|string',
            'memory_minimum' => 'nullable|string',
            'graphics_minimum' => 'nullable|string',
            'storage_minimum' => 'nullable|string',
            'os_recommended' => 'nullable|string',
            'processor_recommended' => 'nullable|string',
            'memory_recommended' => 'nullable|string',
            'graphics_recommended' => 'nullable|string',
            'storage_recommended' => 'nullable|string',
        ]);

        // Find first available ID (fill gaps from deleted games)
        $usedIds = Game::pluck('id')->sort()->values()->toArray();
        $newId = 1;
        foreach ($usedIds as $id) {
            if ($id > $newId) break;
            $newId = $id + 1;
        }

        $game = new Game();
        $game->id = $newId;
        $game->title = $request->title;
        $game->slug = Str::slug($request->title);
        $game->price = $request->price;
        $game->description = $request->description;
        $game->genre = $request->genre;
        $game->developer = $request->developer;
        $game->publisher = $request->publisher;
        $game->release_date = $request->release_date;
        $game->active = $request->boolean('active', true);
        $game->os_minimum = $request->os_minimum;
        $game->processor_minimum = $request->processor_minimum;
        $game->memory_minimum = $request->memory_minimum;
        $game->graphics_minimum = $request->graphics_minimum;
        $game->storage_minimum = $request->storage_minimum;
        $game->os_recommended = $request->os_recommended;
        $game->processor_recommended = $request->processor_recommended;
        $game->memory_recommended = $request->memory_recommended;
        $game->graphics_recommended = $request->graphics_recommended;
        $game->storage_recommended = $request->storage_recommended;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/games', $filename);
            $game->image = $filename;
        }

        $game->save();

        return redirect()->route('admin.games.index')->with('status', 'Game created');
    }

    public function edit(Game $game)
    {
        return view('admin.games.edit', ['game' => $game]);
    }

    public function update(Request $request, Game $game)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'genre' => 'nullable|string|max:100',
            'developer' => 'nullable|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'release_date' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'active' => 'nullable|boolean',
            'os_minimum' => 'nullable|string',
            'processor_minimum' => 'nullable|string',
            'memory_minimum' => 'nullable|string',
            'graphics_minimum' => 'nullable|string',
            'storage_minimum' => 'nullable|string',
            'os_recommended' => 'nullable|string',
            'processor_recommended' => 'nullable|string',
            'memory_recommended' => 'nullable|string',
            'graphics_recommended' => 'nullable|string',
            'storage_recommended' => 'nullable|string',
        ]);

        $game->title = $request->title;
        if ($game->isDirty('title')) {
            $game->slug = Str::slug($request->title);
        }
        $game->price = $request->price;
        $game->description = $request->description;
        $game->genre = $request->genre;
        $game->developer = $request->developer;
        $game->publisher = $request->publisher;
        $game->release_date = $request->release_date;
        $game->active = $request->boolean('active', true);
        $game->os_minimum = $request->os_minimum;
        $game->processor_minimum = $request->processor_minimum;
        $game->memory_minimum = $request->memory_minimum;
        $game->graphics_minimum = $request->graphics_minimum;
        $game->storage_minimum = $request->storage_minimum;
        $game->os_recommended = $request->os_recommended;
        $game->processor_recommended = $request->processor_recommended;
        $game->memory_recommended = $request->memory_recommended;
        $game->graphics_recommended = $request->graphics_recommended;
        $game->storage_recommended = $request->storage_recommended;

        if ($request->hasFile('image')) {
            if ($game->image) {
                Storage::delete('public/games/' . $game->image);
            }
            $file = $request->file('image');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/games', $filename);
            $game->image = $filename;
        }

        $game->save();

        return redirect()->route('admin.games.index')->with('status', 'Game updated');
    }

    public function destroy(Game $game)
    {
        TransactionItem::where('game_id', $game->id)->delete();
        if ($game->image) {
            Storage::delete('public/games/' . $game->image);
        }
        $game->delete();
        return redirect()->route('admin.games.index')->with('status', 'Game deleted');
    }
}
