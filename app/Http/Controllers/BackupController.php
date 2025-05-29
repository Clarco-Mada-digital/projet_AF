<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BackupService;

class BackupController extends Controller
{
    private $backupService;
    
    public function __construct(BackupService $backupService)
    {
        $this->backupService = $backupService;
    }
    
    public function download($filename)
    {
        $path = "backups/{$filename}";
        
        if (!Storage::disk('local')->exists($path)) {
            abort(404, 'Fichier de sauvegarde introuvable');
        }
        
        return Storage::disk('local')->download($path, $filename, [
            'Content-Type' => 'application/sql',
        ]);
    }
    
    public function create(Request $request)
    {
        try {
            $backupPath = $this->backupService->createBackup([
                'prefix' => $request->get('prefix', 'api'),
                'keep' => $request->get('keep', 10)
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Sauvegarde créée avec succès',
                'path' => $backupPath
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    public function list()
    {
        try {
            $backups = $this->backupService->listBackups();
            return response()->json($backups);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    public function delete($filename)
    {
        try {
            $path = "backups/{$filename}";
            
            if (!Storage::disk('local')->exists($path)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Fichier introuvable'
                ], 404);
            }
            
            Storage::disk('local')->delete($path);
            
            return response()->json([
                'success' => true,
                'message' => 'Sauvegarde supprimée avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
