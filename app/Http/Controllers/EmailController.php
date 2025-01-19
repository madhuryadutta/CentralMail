<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\YourMailable;
use Illuminate\Support\Facades\Log;
use App\Services\SmtpService;

class EmailController extends Controller
{
    public function send(Request $request)
    {


        $request->validate([
            'email' => 'required|email',
            'subject' => 'required|string',
            'body' => 'required|string',
            // 'smtp' => 'required|string|in:smtp1,smtp2', // Ensure smtp value matches your mailers
        ]);


        try {
            $smtp = $this->SmtpService->getAvailableSmtpServer();

            config(['mail.mailers.dynamic' => [
                'transport' => 'smtp',
                'host' => $smtp->host,
                'port' => $smtp->port,
                'encryption' => $smtp->encryption,
                'username' => $smtp->username,
                'password' => $smtp->password,
            ]]);

            Mail::mailer('dynamic')
                ->to($request->email)
                ->send(new YourMailable($request->subject, $request->content, $request->content_type));

            // Log and update SMTP usage
            $this->smtpService->incrementUsage($smtp);
            Log::channel('emails')->info('Email sent', ['email' => $request->email]);

            return response()->json(['message' => 'Email sent successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to send email: ' . $e->getMessage()], 500);
        }
    }
}
