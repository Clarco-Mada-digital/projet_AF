<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Services\BackupService;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

#[Layout('layouts.mainLayout')]
class Sauvegarde extends Component
{

    // public $repertoire_sauvegardes;
    // public $SaveLists = [];
    // private $db_server;
    // private $port;
    // private $db_username;
    // private $db_password;
    // private $db_name;
    // private $fileName;
    // private $db_charset;


    // function __construct() 
    // {
    //     $this->repertoire_sauvegardes = './storage/saveDB/';
    //     $this->db_server='localhost'; 
    //     $this->db_name='projet_af'; 
    //     $this->db_username='root'; 
    //     $this->db_password='';
    //     $this->db_charset = 'latin1';
    //     // $this->db_charset = 'utf-8'; 
    //     $this->fileName = 'Sauvegarde-de-AF_'.date('Y-m-d_H-i-s').'.sql';
    //     $this->port = '3306';
    // }

    // protected function filesize_formatted($path)
    // {
    //     $size = filesize($path);
    //     $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
    //     $power = $size > 0 ? floor(log($size, 1024)) : 0;
    //     return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
    // }

    // function saveDB()
    // {
    //     // Vérification et création dossier sauvegarde
    //     if (is_dir($this->repertoire_sauvegardes) === FALSE) {
    //         // 0700 repertoire non visible par les visiteurs
    //         if (mkdir($this->repertoire_sauvegardes, permissions:0700) === FALSE)
    //             exit(dd('Impossible de creer le repertoire pour la sauvegarde mysql!!!'));
    //     }

    //     //---------------------------------------------
    //     // execution de la commande mysql dump
    //     //---------------------------------------------
    //     $commande  = 'C:/wamp64/bin/mysql/mysql5.7.36/bin/mysqldump.exe';
    //     $commande .= ' --host=' . $this->db_server;
    //     $commande .= ' --port=' . $this->port;
    //     $commande .= ' --user=' . $this->db_username;
    //     $commande .= ' --password=' . $this->db_password;
    //     $commande .= ' --skip-opt';
    //     $commande .= ' --compress';
    //     $commande .= ' --add-locks';
    //     $commande .= ' --create-options';
    //     $commande .= ' --disable-keys';
    //     $commande .= ' --quote-names';
    //     $commande .= ' --quick';
    //     $commande .= ' --extended-insert';
    //     $commande .= ' --complete-insert';
    //     $commande .= ' --default-character-set='.$this->db_charset;
    //     $commande .= ' --compatible=mysql40';
    //     $commande .= ' ' . $this->db_name;
    //     $commande .= ' --result-file=' . $this->repertoire_sauvegardes . $this->fileName;
    //     // $commande .= ' > '.$this->repertoire_sauvegardes.$this->archive_GZIP;

    //     // dd($commande);
    //     system($commande);

    //     $this->dispatch("ShowSuccessMsg", ['message' => 'Sauvegarde réussite', 'type' => 'success']);
    // }

    // public function restoreDB($num)
    // {
    //     $name = $this->SaveLists[$num];
    //     // dd($this->repertoire_sauvegardes.$name);

    //     //---------------------------------------------
    //     // execution de la commande mysql dump
    //     //---------------------------------------------
    //     $commande  = 'C:/wamp64/bin/mysql/mysql5.7.36/bin/mysqldump.exe';
    //     $commande .= ' --host=' . $this->db_server;
    //     $commande .= ' --port=' . $this->port;
    //     $commande .= ' --user=' . $this->db_username;
    //     $commande .= ' --password=' . $this->db_password;
    //     $commande .= ' --default-character-set='.$this->db_charset;
    //     // $commande .= ' --compatible=mysql40';
    //     $commande .= ' ' . $this->db_name;
    //     $commande .= ' < '.$this->repertoire_sauvegardes.$name;

    //     // dd($commande);
    //     system($commande, $return_var);
    //     // dd($return_var);

    //     $this->dispatch("ShowSuccessMsg", ['message' => 'Restoration réussite', 'type' =>'success']);
    // }

    public $backups = [];
    public $isCreatingBackup = false;
    public $backupProgress = 0;
    public $selectedBackups = [];
    public $showConfirmDelete = false;
    public $backupToDelete = null;
    public $searchTerm = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $showRestoreModal = false;
    public $backupToRestore = null;
    public $autoBackupEnabled;
    public $backupFrequency;
    public $maxBackups;
    public $showSettings = false;

    protected $backupService;

    public function boot()
    {
        if (!Storage::exists('settings.json')) {
            Storage::put('settings.json', json_encode([]));
        }
    }

    public function __construct()
    {
        $this->backupService = app(BackupService::class);
        // ou
        // $this->backupService = resolve(BackupService::class);
    }

    public function mount()
    {
        // $this->backupService = new BackupService();
        $this->loadBackups();
        $this->loadSettings();

         // Chemin du fichier de settings
        $settingsPath = storage_path('app/settings.json');
        
        // Si le fichier existe, on lit son contenu, sinon on crée un tableau vide
        $settings = file_exists($settingsPath) 
            ? json_decode(file_get_contents($settingsPath), true) 
            : [];
        
        // Initialisation des propriétés    
        $this->backupFrequency = $settings['backup_frequency'] ?? config('backup.frequency', 'daily');
        $this->maxBackups = $settings['backup_max_backups'] ?? config('backup.max_backups', 10);
        $this->autoBackupEnabled = $settings['backup_auto_enabled'] ?? config('backup.auto_enabled', true);
    }

    public function loadBackups()
    {
        try {
            $this->backups = $this->backupService->listBackups()->toArray();
            // dd($this->backups);
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors du chargement des sauvegardes: ' . $e->getMessage());
        }
    }

    public function loadSettings()
    {
        // Charger les paramètres depuis la configuration ou la base de données
        $this->autoBackupEnabled = config('backup.auto_enabled', true);
        $this->backupFrequency = config('backup.frequency', 'daily');
        $this->maxBackups = config('backup.max_backups', 10);
    }

    public function createBackup()
    {
        $this->isCreatingBackup = true;
        $this->backupProgress = 0;
        
        try {
            // Simuler le progrès
            $this->dispatch('updateProgress', 20);
            $this->backupProgress = 20;
            
            $backupPath = $this->backupService->createBackup([
                'prefix' => 'manual',
                'keep' => $this->maxBackups
            ]);
            
            $this->dispatch('updateProgress', 80);
            $this->backupProgress = 80;
            
            sleep(1); // Simuler le temps de traitement
            
            $this->dispatch('updateProgress', 100);
            $this->backupProgress = 100;
            
            $this->loadBackups();
            session()->flash('success', 'Sauvegarde créée avec succès!');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de la création: ' . $e->getMessage());
        } finally {
            $this->isCreatingBackup = false;
            $this->backupProgress = 0;
        }
    }

    public function confirmDelete($backupPath)
    {
        $this->backupToDelete = $backupPath;
        $this->showConfirmDelete = true;
    }

    public function deleteBackup()
    {
        if ($this->backupToDelete) {
            try {
                Storage::delete($this->backupToDelete);
                $this->loadBackups();
                session()->flash('success', 'Sauvegarde supprimée avec succès!');
            } catch (\Exception $e) {
                session()->flash('error', 'Erreur lors de la suppression: ' . $e->getMessage());
            }
        }
        $this->showConfirmDelete = false;
        $this->backupToDelete = null;
    }

    public function deleteSelected()
    {
        try {
            foreach ($this->selectedBackups as $backupPath) {
                Storage::delete($backupPath);
            }
            $this->selectedBackups = [];
            $this->loadBackups();
            session()->flash('success', count($this->selectedBackups) . ' sauvegardes supprimées!');
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de la suppression: ' . $e->getMessage());
        }
    }

    public function confirmRestore($backupPath)
    {
        $this->backupToRestore = $backupPath;
        $this->showRestoreModal = true;
    }

    public function restoreBackup()
    {
        if ($this->backupToRestore) {
            try {
                $this->backupService->restoreBackup($this->backupToRestore);
                session()->flash('success', 'Base de données restaurée avec succès!');
            } catch (\Exception $e) {
                session()->flash('error', 'Erreur lors de la restauration: ' . $e->getMessage());
            }
        }
        $this->showRestoreModal = false;
        $this->backupToRestore = null;
    }

    public function downloadBackup($backupPath)
    {
        // dd($backupPath);
        return Storage::download($backupPath);
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function updateSettings()
    {
        try {
            // Sauvegarder les paramètres
            // config(['backup.auto_enabled' => $this->autoBackupEnabled]);
            // config(['backup.frequency' => $this->backupFrequency]);
            // config(['backup.max_backups' => $this->maxBackups]);
            $settings = [
                'backup_frequency' => $this->backupFrequency,
                'backup_max_backups' => $this->maxBackups,
                'backup_auto_enabled' => $this->autoBackupEnabled,
            ];
        
            Storage::put('settings.json', json_encode($settings));

            session()->flash('success', 'Paramètres mis à jour avec succès!');
            $this->showSettings = false;
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de la mise à jour: ' . $e->getMessage());
        }
    }

    public function getFilteredBackupsProperty()
    {
        $backups = collect($this->backups);

        // Filtrage par terme de recherche
        if ($this->searchTerm) {
            $backups = $backups->filter(function ($backup) {
                return str_contains(strtolower($backup['filename']), strtolower($this->searchTerm));
            });
        }

        // Tri
        $backups = $backups->sortBy($this->sortBy, SORT_REGULAR, $this->sortDirection === 'desc');

        return $backups->values()->toArray();
    }

    public function render()
    {
        // Carbon::setLocale('fr');        
        // $Lists = [];

        // if (is_dir($this->repertoire_sauvegardes)) {
        //     $files = opendir($this->repertoire_sauvegardes);
        //     while (($file = readdir($files)) !== false) {
        //         if ($file!= "." && $file!= "..") {
        //             array_push($this->SaveLists, $file);
        //             $size = $this->filesize_formatted($this->repertoire_sauvegardes.$file);                    
        //             $file = str_replace('.sql', '', $file);
        //             $fileSplit = Str::of($file)->explode('_');
        //             $fileTable = [$fileSplit[0], $fileSplit[1], $size];
        //             array_push($Lists, $fileTable);
        //         }
        //     }
            
        //     closedir($files);
        // }

        // $data = [
        //     'Lists' => $Lists,
        // ];

        return view('livewire.sauvegardes.index');
    }
}
