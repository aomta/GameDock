<?php

namespace Database\Seeders;

use App\Models\Game;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GameSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('seeders/data/games.json');
        $json = file_get_contents($path);
        $games = json_decode($json, true);

        $colors = [
            ['bg' => [30, 30, 50], 'accent' => [75, 118, 196]],
            ['bg' => [40, 20, 30], 'accent' => [200, 80, 60]],
            ['bg' => [20, 40, 30], 'accent' => [60, 180, 100]],
            ['bg' => [50, 40, 20], 'accent' => [220, 180, 60]],
            ['bg' => [25, 25, 45], 'accent' => [130, 90, 200]],
            ['bg' => [35, 25, 45], 'accent' => [200, 100, 180]],
            ['bg' => [20, 30, 50], 'accent' => [60, 150, 220]],
            ['bg' => [45, 20, 20], 'accent' => [180, 60, 60]],
            ['bg' => [20, 45, 40], 'accent' => [60, 200, 160]],
            ['bg' => [50, 30, 15], 'accent' => [230, 140, 50]],
            ['bg' => [15, 20, 35], 'accent' => [100, 130, 220]],
            ['bg' => [35, 15, 25], 'accent' => [180, 60, 120]],
        ];

        $gamesDir = storage_path('app/public/games');
        if (!is_dir($gamesDir)) {
            mkdir($gamesDir, 0755, true);
        }

        foreach ($games as $i => $data) {
            $existing = Game::where('title', $data['title'])->first();
            if ($existing) {
                $existing->update([
                    'slug' => Str::slug($data['title']),
                    'image' => Str::slug($data['title']) . '.jpg',
                    'description' => $data['description'],
                    'price' => $data['price'],
                    'genre' => $data['genre'],
                    'developer' => $data['developer'],
                    'publisher' => $data['publisher'],
                    'release_date' => $data['release_date'],
                    'active' => true,
                    'os_minimum' => $data['os_minimum'] ?? null,
                    'processor_minimum' => $data['processor_minimum'] ?? null,
                    'memory_minimum' => $data['memory_minimum'] ?? null,
                    'graphics_minimum' => $data['graphics_minimum'] ?? null,
                    'storage_minimum' => $data['storage_minimum'] ?? null,
                    'os_recommended' => $data['os_recommended'] ?? null,
                    'processor_recommended' => $data['processor_recommended'] ?? null,
                    'memory_recommended' => $data['memory_recommended'] ?? null,
                    'graphics_recommended' => $data['graphics_recommended'] ?? null,
                    'storage_recommended' => $data['storage_recommended'] ?? null,
                ]);
            } else {
                $usedIds = Game::pluck('id')->sort()->values()->toArray();
                $newId = 1;
                foreach ($usedIds as $id) {
                    if ($id > $newId) break;
                    $newId = $id + 1;
                }
                $game = new Game();
                $game->id = $newId;
                $game->title = $data['title'];
                $game->slug = Str::slug($data['title']);
                $game->image = Str::slug($data['title']) . '.jpg';
                $game->description = $data['description'];
                $game->price = $data['price'];
                $game->genre = $data['genre'];
                $game->developer = $data['developer'];
                $game->publisher = $data['publisher'];
                $game->release_date = $data['release_date'];
                $game->active = true;
                $game->os_minimum = $data['os_minimum'] ?? null;
                $game->processor_minimum = $data['processor_minimum'] ?? null;
                $game->memory_minimum = $data['memory_minimum'] ?? null;
                $game->graphics_minimum = $data['graphics_minimum'] ?? null;
                $game->storage_minimum = $data['storage_minimum'] ?? null;
                $game->os_recommended = $data['os_recommended'] ?? null;
                $game->processor_recommended = $data['processor_recommended'] ?? null;
                $game->memory_recommended = $data['memory_recommended'] ?? null;
                $game->graphics_recommended = $data['graphics_recommended'] ?? null;
                $game->storage_recommended = $data['storage_recommended'] ?? null;
                $game->save();
            }

            $slugImage = Str::slug($data['title']) . '.jpg';
            if (!file_exists($gamesDir . '/' . $slugImage)) {
                $this->generatePlaceholder($gamesDir . '/' . $slugImage, $data['title'], $colors[$i % count($colors)]);
            }
        }
    }

    private function generatePlaceholder(string $path, string $title, array $colors): void
    {
        $w = 400;
        $h = 225;
        $img = imagecreatetruecolor($w, $h);

        $bg = $colors['bg'];
        imagefill($img, 0, 0, imagecolorallocate($img, $bg[0], $bg[1], $bg[2]));

        $accent = $colors['accent'];
        $accentColor = imagecolorallocate($img, $accent[0], $accent[1], $accent[2]);

        for ($y = 0; $y < $h; $y += 4) {
            for ($x = 0; $x < $w; $x += 4) {
                $v = sin($x * 0.02) * cos($y * 0.02) * 15;
                $c = imagecolorallocate($img,
                    min(255, max(0, $bg[0] + (int)$v)),
                    min(255, max(0, $bg[1] + (int)$v)),
                    min(255, max(0, $bg[2] + (int)$v))
                );
                imagesetpixel($img, $x, $y, $c);
            }
        }

        imagerectangle($img, 2, 2, $w - 3, $h - 3, $accentColor);
        imagerectangle($img, 4, 4, $w - 5, $h - 5, $accentColor);

        $fontSize = 5;
        $text = Str::limit($title, 20);
        $tw = imagefontwidth($fontSize) * strlen($text);
        $th = imagefontheight($fontSize);
        $tx = (int)(($w - $tw) / 2);
        $ty = (int)(($h - $th) / 2);
        imagestring($img, $fontSize, $tx, $ty, $text, $accentColor);

        imagejpeg($img, $path, 80);
        imagedestroy($img);
    }
}
