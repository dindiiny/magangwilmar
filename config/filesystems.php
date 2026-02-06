<?php

$supabaseEndpoint = env('AWS_ENDPOINT');
$supabaseBucket = env('AWS_BUCKET', 'uploads');
$supabaseUrl = env('AWS_URL');

// 1. Auto-fix missing endpoint if we have the URL (common mistake)
if (empty($supabaseEndpoint) && !empty($supabaseUrl)) {
    // pattern: https://<project>.supabase.co/storage/v1/object/public/<bucket>
    // goal: https://<project>.supabase.co/storage/v1/s3
    $parsed = parse_url($supabaseUrl);
    if (isset($parsed['host']) && str_contains($parsed['host'], 'supabase.co')) {
         $scheme = $parsed['scheme'] ?? 'https';
         $host = $parsed['host'];
         $supabaseEndpoint = "{$scheme}://{$host}/storage/v1/s3";
    }
}

// 2. Auto-generate Supabase public URL if AWS_URL is missing but Endpoint is present
if (empty($supabaseUrl) && !empty($supabaseEndpoint)) {
    // From: https://[ref].supabase.co/storage/v1/s3
    // To:   https://[ref].supabase.co/storage/v1/object/public/[bucket]
    $supabaseUrl = str_replace('/s3', '/object/public/' . $supabaseBucket, $supabaseEndpoint);
}

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been set up for each driver as an example of the required values.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'throw' => false,
        ],

        'public' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION', 'us-east-1'), // Default to dummy region for Supabase
            'bucket' => env('AWS_BUCKET', 'uploads'),
            'url' => $supabaseUrl,
            'endpoint' => $supabaseEndpoint, // Use the computed endpoint
            'use_path_style_endpoint' => true,
            'visibility' => 'public',
            'throw' => true,
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
        ],

        'supabase' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET', 'uploads'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => true,
            'url' => $supabaseUrl,
            'throw' => false,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
