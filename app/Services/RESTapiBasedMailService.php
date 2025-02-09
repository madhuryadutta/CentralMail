<?php

namespace App\Services;

use App\Models\ApiService;
use Exception;

class RESTapiBasedMailService
{
    public function getAvailableService($type)
    {
        return ApiService::where('type', $type)
            ->where('is_active', true)
            ->orderBy('daily_usage', 'asc')
            ->orderBy('monthly_usage', 'asc')
            ->first();
    }

    // public function getAvailableSmtpServer()
    // {
    //     $smtpServers = SmtpServer::where('is_active', true)
    //         ->orderBy('daily_usage', 'asc')
    //         ->orderBy('monthly_usage', 'asc')
    //         ->get();

    //     foreach ($smtpServers as $smtp) {
    //         if ($smtp->daily_usage < $smtp->daily_limit && $smtp->monthly_usage < $smtp->monthly_limit) {
    //             return $smtp;
    //         }
    //     }

    //     throw new Exception('No SMTP server available with remaining credits.');
    // }

    public function incrementUsage(ApiService $apiService)
    {
        $apiService->increment('daily_usage');
        $apiService->increment('monthly_usage');
        $apiService->save();
    }
}
