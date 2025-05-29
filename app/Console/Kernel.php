<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected $commands = [
        Commands\DatabaseBackup::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        // Sauvegarde quotidienne à 2h du matin
        $schedule->command('db:backup')
                 ->daily()
                 ->at('02:00')
                 ->appendOutputTo(storage_path('logs/backup.log'));
        
        // Ou sauvegarde hebdomadaire le dimanche à 3h
        // $schedule->command('db:backup')
        //          ->weekly()
        //          ->sundays()
        //          ->at('03:00');
        
        // Ou sauvegarde toutes les 6 heures
        // $schedule->command('db:backup')
        //          ->everySixHours();
        
        // Avec options personnalisées
        // $schedule->command('db:backup --path=weekly_backups')
        //          ->weekly()
        //          ->sundays()
        //          ->at('04:00');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
    
}