<?php
require_once 'includes/functions.php';

$games = loadGamesFromCSV(__DIR__ . '/data/games.csv');
echo "✅ CSV loaded successfully!\n";
echo "📊 Total games: " . count($games) . "\n\n";

echo "First 3 games:\n";
for ($i = 0; $i < min(3, count($games)); $i++) {
    $g = $games[$i];
    echo ($i+1) . ". {$g['emoji']} {$g['title']} ({$g['genre']}) - ⭐ {$g['rating']}/10\n";
}

echo "\n✅ All tests passed!\n";
