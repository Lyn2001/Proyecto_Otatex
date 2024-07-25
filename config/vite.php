<?php
return [
    'manifest_path' => public_path('build/manifest.json'),
    'hot_file' => public_path('hot'),
    'dev_server' => [
        'url' => env('VITE_ASSET_URL', 'http://localhost:5173'),
        'ping_before_using_manifest' => true,
    ],
];

