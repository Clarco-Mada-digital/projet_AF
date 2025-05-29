<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BackupController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/stats', function () {
    $backupService = new App\Services\BackupService();
    $backups = $backupService->listBackups();
    
    return response()->json([
        'total' => $backups->count(),
        'totalSize' => $backups->sum('size'),
        'lastBackup' => $backups->first()['created_at'] ?? null,
        'autoBackupStatus' => config('backup.auto_enabled', false)
    ]);
});
Route::post('/create', [BackupController::class, 'create']);
Route::get('/list', [BackupController::class, 'list']);
Route::delete('/{filename}', [BackupController::class, 'delete']);
// Route::middleware(['auth:sanctum', 'role:Super-Admin'])->prefix('backup')->group(function () {
    
// });
