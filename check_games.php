<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$games = App\Models\Game::pluck('title', 'slug')->all();
foreach ($games as $slug => $title) {
    echo "$slug => $title\n";
}
echo "\nTotal: " . count($games) . "\n";
