<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class BackupService
{
    private $backupDisk;
    private $backupPath;
    
    public function __construct($disk = 'local', $path = 'backups')
    {
        $this->backupDisk = $disk;
        $this->backupPath = $path;
    }
    
    public function createBackup($options = [])
    {
        try {
            $filename = $this->generateFilename($options['prefix'] ?? 'backup');
            $fullPath = $this->backupPath . '/' . $filename;
            
            $database = config('database.default');
            
            switch ($database) {
                case 'mysql':
                    $this->createMySQLBackup($fullPath);
                    break;
                case 'sqlite':
                    $this->createSQLiteBackup($fullPath);
                    break;
                default:
                    throw new \Exception("Database {$database} not supported");
            }
            
            // Log de succès
            Log::info("Backup created successfully: {$fullPath}");
            
            // Nettoyer les anciennes sauvegardes
            if ($options['cleanup'] ?? true) {
                $this->cleanupOldBackups($options['keep'] ?? 10);
            }
            
            return $fullPath;
            
        } catch (\Exception $e) {
            Log::error("Backup failed: " . $e->getMessage());
            throw $e;
        }
    }
    
    private function generateFilename($prefix)
    {
        $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
        $database = config('database.default');
        return "{$prefix}_{$database}_{$timestamp}.sql";
    }
    
    private function createMySQLBackup($filepath)
    {
        $connection = config('database.connections.' . config('database.default'));
        
        $command = sprintf(
            'mysqldump --host=%s --user=%s --password=%s %s',
            escapeshellarg($connection['host']),
            escapeshellarg($connection['username']),
            escapeshellarg($connection['password']),
            escapeshellarg($connection['database'])
        );
        
        $output = shell_exec($command);
        
        if ($output === null) {
            throw new \Exception('mysqldump command failed');
        }
        
        Storage::disk($this->backupDisk)->put($filepath, $output);
    }
    
    private function createSQLiteBackup($filepath)
    {
        $dbPath = config('database.connections.sqlite.database');
        
        if (!file_exists($dbPath)) {
            throw new \Exception("SQLite database not found: {$dbPath}");
        }
        
        $content = file_get_contents($dbPath);
        Storage::disk($this->backupDisk)->put($filepath, $content);
    }
    
    private function cleanupOldBackups($keepCount)
    {
        $files = collect(Storage::disk($this->backupDisk)->files($this->backupPath))
                ->filter(function($file) {
                    return str_contains($file, 'backup_');
                })
                ->sortByDesc(function($file) {
                    return Storage::disk($this->backupDisk)->lastModified($file);
                });
        
        if ($files->count() > $keepCount) {
            $filesToDelete = $files->slice($keepCount);
            foreach ($filesToDelete as $file) {
                Storage::disk($this->backupDisk)->delete($file);
                Log::info("Old backup deleted: {$file}");
            }
        }
    }
    
    public function listBackups()
    {
        return collect(Storage::disk($this->backupDisk)->files($this->backupPath))
                ->filter(function($file) {
                    return str_contains($file, 'backup_') || str_contains($file, 'manual_');
                })
                ->map(function($file) {
                    return [
                        'filename' => basename($file),
                        'path' => $file,
                        'size' => Storage::disk($this->backupDisk)->size($file),
                        'created_at' => Carbon::createFromTimestamp(
                            Storage::disk($this->backupDisk)->lastModified($file)
                        )->format('Y-m-d H:i:s')
                    ];
                })
                ->sortByDesc('created_at')
                ->values();
    }
    
    public function restoreBackup($backupPath)
    {
        if (!Storage::disk($this->backupDisk)->exists($backupPath)) {
            throw new \Exception("Backup file not found: {$backupPath}");
        }
        
        $content = Storage::disk($this->backupDisk)->get($backupPath);
        
        // Attention: cette opération peut être destructive
        DB::unprepared($content);
        
        Log::info("Database restored from backup: {$backupPath}");
    }
}