<?php

namespace App\Services;

use App\Models\SmtpServer;
use Exception;

class SmtpService
{
    public function getAvailableSmtpServer()
    {
        $smtpServers = SmtpServer::where('is_active', true)
            ->orderBy('daily_usage', 'asc')
            ->orderBy('monthly_usage', 'asc')
            ->get();

        foreach ($smtpServers as $smtp) {
            if ($smtp->daily_usage < $smtp->daily_limit && $smtp->monthly_usage < $smtp->monthly_limit) {
                return $smtp;
            }
        }

        throw new Exception('No SMTP server available with remaining credits.');
    }

    public function incrementUsage(SmtpServer $smtp)
    {
        $smtp->increment('daily_usage');
        $smtp->increment('monthly_usage');
        $smtp->save();
    }
}
