<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $dbName = config('database.connections.mysql.database');
        $dbUser = config('database.connections.mysql.username');
        $dbPass = config('database.connections.mysql.password');
        $backupPath = storage_path('app/backups/' . $dbName . '_' . date('Y-m-d_H-i-s') . '.sql');

        $command = "mysqldump --user={$dbUser} --password={$dbPass} {$dbName} > {$backupPath}";

        exec($command);

        $this->info('Database backed up successfully to: ' . $backupPath);
    }
}
