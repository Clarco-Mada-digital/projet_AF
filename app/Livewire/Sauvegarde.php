<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Str;

#[Layout('layouts.mainLayout')]
class Sauvegarde extends Component
{

    public $repertoire_sauvegardes;
    public $SaveLists = [];
    private $db_server;
    private $port;
    private $db_username;
    private $db_password;
    private $db_name;
    private $fileName;
    private $db_charset;


    function __construct() 
    {
        $this->repertoire_sauvegardes = './storage/saveDB/';
        $this->db_server='localhost'; 
        $this->db_name='projet_af'; 
        $this->db_username='root'; 
        $this->db_password='';
        $this->db_charset = 'latin1';
        // $this->db_charset = 'utf-8'; 
        $this->fileName = 'Sauvegarde-de-AF_'.date('Y-m-d_H-i-s').'.sql';
        $this->port = '3306';
    }

    protected function filesize_formatted($path)
    {
        $size = filesize($path);
        $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
        $power = $size > 0 ? floor(log($size, 1024)) : 0;
        return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
    }

    function saveDB()
    {
        // Vérification et création dossier sauvegarde
        if (is_dir($this->repertoire_sauvegardes) === FALSE) {
            // 0700 repertoire non visible par les visiteurs
            if (mkdir($this->repertoire_sauvegardes, permissions:0700) === FALSE)
                exit(dd('Impossible de creer le repertoire pour la sauvegarde mysql!!!'));
        }

        //---------------------------------------------
        // execution de la commande mysql dump
        //---------------------------------------------
        $commande  = 'C:/wamp64/bin/mysql/mysql5.7.36/bin/mysqldump.exe';
        $commande .= ' --host=' . $this->db_server;
        $commande .= ' --port=' . $this->port;
        $commande .= ' --user=' . $this->db_username;
        $commande .= ' --password=' . $this->db_password;
        $commande .= ' --skip-opt';
        $commande .= ' --compress';
        $commande .= ' --add-locks';
        $commande .= ' --create-options';
        $commande .= ' --disable-keys';
        $commande .= ' --quote-names';
        $commande .= ' --quick';
        $commande .= ' --extended-insert';
        $commande .= ' --complete-insert';
        $commande .= ' --default-character-set='.$this->db_charset;
        $commande .= ' --compatible=mysql40';
        $commande .= ' ' . $this->db_name;
        $commande .= ' --result-file=' . $this->repertoire_sauvegardes . $this->fileName;
        // $commande .= ' > '.$this->repertoire_sauvegardes.$this->archive_GZIP;

        // dd($commande);
        system($commande);

        $this->dispatch("ShowSuccessMsg", ['message' => 'Sauvegarde réussite', 'type' => 'success']);
    }

    public function restoreDB($num)
    {
        $name = $this->SaveLists[$num];
        // dd($this->repertoire_sauvegardes.$name);

        //---------------------------------------------
        // execution de la commande mysql dump
        //---------------------------------------------
        $commande  = 'C:/wamp64/bin/mysql/mysql5.7.36/bin/mysqldump.exe';
        $commande .= ' --host=' . $this->db_server;
        $commande .= ' --port=' . $this->port;
        $commande .= ' --user=' . $this->db_username;
        $commande .= ' --password=' . $this->db_password;
        $commande .= ' --default-character-set='.$this->db_charset;
        // $commande .= ' --compatible=mysql40';
        $commande .= ' ' . $this->db_name;
        $commande .= ' < '.$this->repertoire_sauvegardes.$name;

        // dd($commande);
        system($commande, $return_var);
        // dd($return_var);

        $this->dispatch("ShowSuccessMsg", ['message' => 'Restoration réussite', 'type' =>'success']);
    }

    public function render()
    {
        Carbon::setLocale('fr');        
        $Lists = [];

        if (is_dir($this->repertoire_sauvegardes)) {
            $files = opendir($this->repertoire_sauvegardes);
            while (($file = readdir($files)) !== false) {
                if ($file!= "." && $file!= "..") {
                    array_push($this->SaveLists, $file);
                    $size = $this->filesize_formatted($this->repertoire_sauvegardes.$file);                    
                    $file = str_replace('.sql', '', $file);
                    $fileSplit = Str::of($file)->explode('_');
                    $fileTable = [$fileSplit[0], $fileSplit[1], $size];
                    array_push($Lists, $fileTable);
                }
            }
            
            closedir($files);
        }

        $data = [
            'Lists' => $Lists,
        ];

        return view('livewire.sauvegardes.index', $data);
    }
}
