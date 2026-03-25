<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$apiKey = env('GEMINI_API_KEY');
echo "Checking models with API Key: " . substr($apiKey, 0, 5) . "...\n";

$response = Illuminate\Support\Facades\Http::get("https://generativelanguage.googleapis.com/v1beta/models?key={$apiKey}");

if ($response->successful()) {
    echo "Available Models:\n";
    foreach ($response->json()['models'] as $model) {
        echo "- " . $model['name'] . " (Methods: " . implode(', ', $model['supportedGenerationMethods']) . ")\n";
    }
} else {
    echo "Error: " . $response->body() . "\n";
}
