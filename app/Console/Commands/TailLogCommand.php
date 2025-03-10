<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TailLogCommand extends Command {
    /**
     * Nama dan signature dari command.
     *
     * @var string
     */
    protected $signature = 'log:tail';

    /**
     * Deskripsi command.
     *
     * @var string
     */
    protected $description = 'Running tail -f on Laravel log files.';

    /**
     * Eksekusi command.
     */
    public function handle() {
        $logFile = storage_path('logs/laravel.log');

        if (!file_exists($logFile)) {
            $this->error("File log tidak ditemukan: $logFile");
            return;
        }

        $this->info("Menampilkan log: $logFile");
        passthru("tail -f {$logFile}");
    }
}
