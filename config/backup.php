<?php

return [
    'auto_enabled' => env('BACKUP_AUTO_ENABLED', true),
    'frequency' => env('BACKUP_FREQUENCY', 'daily'),
    'max_backups' => env('BACKUP_MAX_BACKUPS', 10),
    'backup_path' => env('BACKUP_PATH', 'backups'),
    'disk' => env('BACKUP_DISK', 'local'),
    
    'compression' => [
        'enabled' => env('BACKUP_COMPRESSION', false),
        'method' => 'gzip', // gzip, zip
    ],
    
    'notifications' => [
        'slack' => env('BACKUP_SLACK_WEBHOOK', null),
        'email' => env('BACKUP_EMAIL_NOTIFICATIONS', null),
    ],
    
    'cleanup' => [
        'auto_cleanup' => env('BACKUP_AUTO_CLEANUP', true),
        'keep_daily' => 7,
        'keep_weekly' => 4,
        'keep_monthly' => 6,
    ]
];