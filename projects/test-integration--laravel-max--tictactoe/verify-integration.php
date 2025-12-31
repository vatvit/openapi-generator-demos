<?php

/**
 * Quick verification that TictactoeApi library is properly autoloaded
 */

require __DIR__ . '/vendor/autoload.php';

echo "Verifying TictactoeApi library integration...\n\n";

// Check if generated classes can be loaded
$classes = [
    'TictactoeApi\Models\GameMode',
    'TictactoeApi\Models\Mark',
    'TictactoeApi\Models\GameStatus',
    'TictactoeApi\Models\Winner',
    'TictactoeApi\Http\Controllers\CreateGameController',
    'TictactoeApi\Http\Requests\CreateGameFormRequest',
];

$success = 0;
$failed = 0;

foreach ($classes as $class) {
    if (class_exists($class) || enum_exists($class)) {
        echo "✓ {$class}\n";
        $success++;
    } else {
        echo "✗ {$class} - NOT FOUND\n";
        $failed++;
    }
}

echo "\n";
echo "Results: {$success} found, {$failed} failed\n";

if ($failed === 0) {
    echo "\n✅ Integration successful! All classes are autoloaded correctly.\n";
    exit(0);
} else {
    echo "\n❌ Integration failed! Some classes could not be loaded.\n";
    exit(1);
}
