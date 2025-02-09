<?php

namespace App\Console\Commands;

use App\Models\SmtpServer;
use Illuminate\Console\Command;

class ResetSmtpUsage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reset-smtp-usage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset daily and monthly usage of SMTP servers';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Reset daily usage
        SmtpServer::query()->update(['daily_usage' => 0]);

        // Reset monthly usage on the first day of each month
        if (now()->day === 1) {
            SmtpServer::query()->update(['monthly_usage' => 0]);
        }

        $this->info('SMTP usage has been reset.');
    }
}
