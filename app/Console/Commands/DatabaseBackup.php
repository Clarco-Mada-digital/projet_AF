<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DatabaseBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:database-backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function handle()
    {
        $this->info('Début de la sauvegarde...');
        
        $database = config('database.default');
        $connection = config("database.connections.{$database}");
        
        $filename = 'backup_' . Carbon::now()->format('Y-m-d_H-i-s') . '.sql';
        $backupPath = $this->option('path');
        
        try {
            if ($database === 'mysql') {
                $this->backupMySQL($connection, $backupPath, $filename);
            } elseif ($database === 'sqlite') {
                $this->backupSQLite($connection, $backupPath, $filename);
            } else {
                $this->error("Base de données {$database} non supportée");
                return 1;
            }
            
            $this->info("Sauvegarde créée: {$backupPath}/{$filename}");
            
            // Nettoyer les anciennes sauvegardes (garder les 10 dernières)
            $this->cleanOldBackups($backupPath);
            
        } catch (\Exception $e) {
            $this->error('Erreur lors de la sauvegarde: ' . $e->getMessage());
            return 1;
        }
        
        return 0;
    }
    
    private function backupMySQL($connection, $backupPath, $filename)
    {
        $host = $connection['host'];
        $database = $connection['database'];
        $username = $connection['username'];
        $password = $connection['password'];
        $port = $connection['port'] ?? 3306;
        
        // Créer le dossier si nécessaire
        if (!Storage::disk('local')->exists($backupPath)) {
            Storage::disk('local')->makeDirectory($backupPath);
        }
        
        $backupFile = storage_path("app/{$backupPath}/{$filename}");
        
        $command = sprintf(
            'mysqldump --host=%s --port=%s --user=%s --password=%s %s > %s',
            escapeshellarg($host),
            escapeshellarg($port),
            escapeshellarg($username),
            escapeshellarg($password),
            escapeshellarg($database),
            escapeshellarg($backupFile)
        );
        
        exec($command, $output, $returnCode);
        
        if ($returnCode !== 0) {
            throw new \Exception('Échec de mysqldump');
        }
    }
    
    private function backupSQLite($connection, $backupPath, $filename)
    {
        $dbPath = $connection['database'];
        
        if (!file_exists($dbPath)) {
            throw new \Exception("Base SQLite introuvable: {$dbPath}");
        }
        
        // Créer le dossier si nécessaire
        if (!Storage::disk('local')->exists($backupPath)) {
            Storage::disk('local')->makeDirectory($backupPath);
        }
        
        $backupFile = storage_path("app/{$backupPath}/{$filename}");
        
        // Pour SQLite, on peut simplement copier le fichier
        if (!copy($dbPath, str_replace('.sql', '.sqlite', $backupFile))) {
            throw new \Exception('Échec de la copie SQLite');
        }
    }
    
    private function cleanOldBackups($backupPath, $keepCount = 10)
    {
        $files = Storage::disk('local')->files($backupPath);
        
        // Trier par date de modification (plus récent en premier)
        usort($files, function($a, $b) {
            return Storage::disk('local')->lastModified($b) - Storage::disk('local')->lastModified($a);
        });
        
        // Supprimer les anciens fichiers
        $filesToDelete = array_slice($files, $keepCount);
        foreach ($filesToDelete as $file) {
            Storage::disk('local')->delete($file);
            $this->info("Ancien backup supprimé: {$file}");
        }
    }
}
