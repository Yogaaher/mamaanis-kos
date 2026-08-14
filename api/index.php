<?php

// Create required temporary directories in /tmp for Vercel Serverless
$tmpStorage = '/tmp/storage';
$tmpDirs = [
    $tmpStorage . '/framework/cache/data',
    $tmpStorage . '/framework/sessions',
    $tmpStorage . '/framework/views',
    $tmpStorage . '/logs',
    $tmpStorage . '/bootstrap/cache',
];

foreach ($tmpDirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

// Ensure SQLite DB file exists in /tmp
$sourceDb = __DIR__ . '/../database/database.sqlite';
$targetDb = '/tmp/database.sqlite';

if (file_exists($sourceDb) && (!file_exists($targetDb) || filesize($targetDb) === 0)) {
    @copy($sourceDb, $targetDb);
} elseif (!file_exists($targetDb)) {
    @touch($targetDb);
}

// Forward request to Laravel public/index.php
require __DIR__ . '/../public/index.php';
